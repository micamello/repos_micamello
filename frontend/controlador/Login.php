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
        $usuario = Modelo_Usuario::autenticacion($data["username"], $data["password1"]);        
        if (!empty($usuario)){                      
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
        }
        else{
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
 
}  
?>
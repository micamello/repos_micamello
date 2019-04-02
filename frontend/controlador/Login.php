<?php
class Controlador_Login extends Controlador_Base {
 
  public function construirPagina(){

    $this->linkRedesSociales();
    $social_reg = array('fb'=>$this->loginURL, 'gg'=>$this->gg_URL, 'lk'=>$this->lk, 'tw'=>$this->tw);

    if( Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/perfil/');
    }
 
    if ( Utils::getParam('login_form') == 1 ){
      try{
        $campos = array('username'=>1, 'password1'=>1);        
        $data = $this->camposRequeridos($campos);                        
        $usuario = Modelo_Usuario::autenticacion($data["username"], $data["password1"]);
        if (!empty($usuario)){  
          // print_r($usuario['id_pais']."  --  ". SUCURSAL_PAISID);
          // exit();
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
            throw new Exception("El usuario no esta activo, por favor revise su cuenta de correo electr\u00F3nico para activarlo o comuniquese con el administrador para su activaci\u00F3n");            
          }
          if (!Modelo_Usuario::modificarFechaLogin($usuario["id_usuario"],$usuario["tipo_usuario"])){            
            throw new Exception("Error en el sistema, por favor intente denuevo");
          }                                 
          self::registroSesion($usuario);              
        }
        else{
          throw new Exception("Usuario o Password Incorrectos");
        }        
        Modelo_Usuario::validaPermisos($_SESSION['mfo_datos']['usuario']['tipo_usuario'],
                                       $_SESSION['mfo_datos']['usuario']['id_usuario'],
                                       (isset($_SESSION['mfo_datos']['infohv'])) ? $_SESSION['mfo_datos']['infohv'] : array(),
                                       $_SESSION['mfo_datos']['planes'],'login');   
      }
      catch( Exception $e ){
        $_SESSION['mostrar_error'] = $e->getMessage();
      }
    } 

    $tags = array('areasSubareas'=>$GLOBALS['areasSubareas']);
    $tags["template_js"][] = "DniRuc_Validador";
    $tags["template_js"][] = "multiple_select";
    $tags["template_js"][] = "micamello_registro";
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
        $_SESSION['mfo_datos']['infohv'] = $infohv; 
      }

    }  
    else{      
      $hijos = Modelo_Usuario::obtieneHerenciaEmpresa($usuario["id_usuario"]);
      if (!empty($hijos)){
        $_SESSION['mfo_datos']['subempresas'] = $hijos;
      }      
    }  
    @ini_set("session.gc_maxlifetime", 14400000000000);        
    session_write_close();  
  }
 
}  
?>
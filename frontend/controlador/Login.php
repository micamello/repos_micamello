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
            throw new Exception("El usuario no esta activo, por favor revise su cuenta de correo electrónico para activarlo o comuniquese con el administrador para su activación");            
          }
          if (!Modelo_Usuario::modificarFechaLogin($usuario["id_usuario"],$usuario["tipo_usuario"])){            
            throw new Exception("Error en el sistema, por favor intente nuevamente");
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

    $tags = array('social'=>$social_reg);
 
    $tags["arrarea"] = Modelo_Area::obtieneListado();
    $tags["intereses"] = Modelo_Interes::obtieneListado();
 
    $tags["template_js"][] = "modal-register";
    $tags["template_js"][] = "assets/js/main"; 
    $tags["template_js"][] = "ruc_jquery_validator";
    $tags["template_js"][] = "bootstrap-multiselect";
    $tags["template_js"][] = "registrar";
    $tags["template_js"][] = "mic";
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
      //$usuarioxarea = Modelo_UsuarioxArea::obtieneListado($usuario["id_usuario"]);
      //$usuarioxnivel = Modelo_UsuarioxNivel::obtieneListado($usuario["id_usuario"]);
      $infohv = Modelo_InfoHv::obtieneHv($usuario["id_usuario"]);
      
      if (!empty($usuarioxarea) && is_array($usuarioxarea)){
        $_SESSION['mfo_datos']['usuarioxarea'] = $usuarioxarea; 
      }
      if (!empty($usuarioxnivel) && is_array($usuarioxnivel)){
        $_SESSION['mfo_datos']['usuarioxnivel'] = $usuarioxnivel; 
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
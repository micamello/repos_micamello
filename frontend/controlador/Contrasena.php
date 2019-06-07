<?php
class Controlador_Contrasena extends Controlador_Base {
  
  public function construirPagina(){
    $opcion = Utils::getParam('opcion','',$this->data);  
    switch($opcion){      
      case 'recuperacion':
        if( Modelo_Usuario::estaLogueado() ){
         Utils::doRedirect(PUERTO.'://'.HOST.'/perfil/');
        }   
        $this->validarToken();
      break;   
      case 'cambioContrasena':
        if( !Modelo_Usuario::estaLogueado() ){
         Utils::doRedirect(PUERTO.'://'.HOST.'/login/');
        } 
        if (Utils::getParam('cambiarClave_obligatorio') == 1) {
            try{
                $password_ant = Utils::getParam('password_ant', '', $this->data);
                $pass_ant = Modelo_Usuario::obtenerPassAnt($_SESSION['mfo_datos']['usuario']['id_usuario_login']);
                if($pass_ant != md5($password_ant)){
                    $tags['data'] = array('password'=>$_POST["password"],'password_two'=>$_POST["password_two"],'password_ant'=>$_POST["password_ant"]);
                    throw new Exception("La contrase\u00F1a anterior no es v\u00E1lida, intente de nuevo");
                }else{
                    
                    $obj_perfil = new Controlador_Perfil();
                    $existeError = $obj_perfil->guardarClave($_SESSION['mfo_datos']['usuario']['id_usuario_login'],2);
                    if($existeError == 1){
                        $tags['data'] = array('password'=>$_POST["password"],'password_two'=>$_POST["password_two"],'password_ant'=>$_POST["password_ant"]);
                    }else{            
                      $tags["template_js"][] = "ocultarUser";          
                      Vista::render('msjcontrasena_exito', $tags);                       
                      session_destroy();
                      exit;
                    }
                }
            }catch (Exception $e) {
                $_SESSION['mostrar_error'] = $e->getMessage();
                $GLOBALS['db']->rollback();
            }
            //redirigir al perfil
        }else{
            $_SESSION['mostrar_notif'] = 'Para continuar deber\u00E1 cambiar su contrase\u00F1a';      
        }
        
        $breadcrumbs['cambioClave'] = 'Cambio de contrase&ntilde;a';
        $tags["template_js"][] = "editarPerfil";
        $tags['breadcrumbs'] = $breadcrumbs;
        Vista::render('cambio_contrasena', $tags); 
            
      break;   
      default:
        if( Modelo_Usuario::estaLogueado() ){
         Utils::doRedirect(PUERTO.'://'.HOST.'/perfil/');
        } 
        $this->mostrarDefault();
      break;
    }      
  }
  public function validarToken(){
    $tags = array();
    try{            
      $respuesta = Utils::getParam('token', '', false);
      if (empty($respuesta)){
        throw new Exception("La recuperaci\u00F3n del password es fallida, por favor intente denuevo");
      }  
      $tags["token"] = $respuesta;              
      $respuesta = Utils::desencriptar($respuesta);      
      $valores = explode("||",$respuesta);      
      $token = $valores[0];
      $id_usuario_login = $valores[1];
      $fecha = $valores[2];
      $token_valido = Utils::generarToken($id_usuario_login,"CONTRASENA");
      
      if($token_valido != $token){
        throw new Exception("El enlace para recuperaci\u00F3n es incorrecto, por favor ingrese denuevo su correo para el env\u00EDo");      
      }
      if( strtotime($fecha." +".HORAS_VALIDO_PASSWORD." hours") < time() ){
        throw new Exception("El enlace para recuperaci\u00F3n de contrase\u00F1a ya no es v\u00E1lida, por favor ingrese denuevo su correo para el env\u00EDo");        
      }  
      if ( Utils::getParam('confirm_form') == 1 ){        
        $campos = array('password1'=>1,'password2'=>1);
        $data = $this->camposRequeridos($campos);
        if ($data["password1"] != $data["password2"]){
          throw new Exception("Contrase\u00F1a y confirmaci\u00F3n de contrase\u00F1a no coinciden");
        }
        if (!Utils::valida_password($data["password1"])){
          throw new Exception("Contrase\u00F1a no v\u00E1lida, debe contener m\u00EDnimo 8 caracteres, una letra may\u00FAscula y un n\u00FAmero");
        }
        if (!Modelo_Usuario::modificarPassword($data["password1"],$id_usuario_login)){
          throw new Exception("Error al modificar la contrase\u00F1a, por favor intente denuevo"); 
        }
        $_SESSION['mostrar_exito'] = "Contrase\u00F1a modificada exitosamente"; 
        $this->redirectToController('login');
      }      
    }
    catch( Exception $e ){
      $_SESSION['mostrar_error'] = $e->getMessage();  
    } 
    $tags = array('vista'=>'contrasena');
    Vista::render('confirmar_password', $tags);     
  }
  
  public function mostrarDefault(){        
    if ( Utils::getParam('forgot_form') == 1 ){
      try{
        $campos = array('correo1'=>1);
        $data = $this->camposRequeridos($campos);  
        
        if (!Utils::es_correo_valido($data["correo1"])){
          throw new Exception("Direcci\u00F3n de correo electr\u00F3nico no v\u00E1lido");
        }
        $datousuario = Modelo_Usuario::busquedaPorCorreo($data["correo1"]);
        if (empty($datousuario)){
          throw new Exception("Direcci\u00F3n de correo electr\u00F3nico no existe");
        }                           
        $token = Utils::generarToken($datousuario["id_usuario_login"],"CONTRASENA");
        if (empty($token)){
          throw new Exception("Error en el sistema, por favor intente denuevo");
        }
        $token .= "||".$datousuario["id_usuario_login"]."||".date("Y-m-d H:i:s");        
        $token = Utils::encriptar($token);
        $nombres = ucfirst(utf8_encode($datousuario['nombres'])) . ((isset($datousuario['apellidos'])) ? "&nbsp;".ucfirst(utf8_encode($datousuario['apellidos'])) : '');
        if (!$this->envioCorreo($datousuario['correo'],$nombres,$token)){
          throw new Exception("Error en el env\u00EDo de correo, por favor intente de nuevo");
        }
        $_SESSION['mostrar_exito'] = "Se envi\u00F3 a su direcci\u00F3n de correo el enlace para el cambio de contrase\u00F1a, recuerde que tiene un m\u00E1ximo de ".HORAS_VALIDO_PASSWORD." horas para modificar su contrase\u00F1a no olvide revisar tambien su carpeta de spam";         
      }
      catch( Exception $e ){
        $_SESSION['mostrar_error'] = $e->getMessage();         
      }
    }
    $tags = array('vista'=>'contrasena');
    Vista::render('recuperar_password', $tags);  
  } 
  public function envioCorreo($correo,$nombres,$token){
    $enlace = "<a href='".PUERTO."://".HOST."/contrasena/".$token."/'>click aqui</a>"; 
    $email_body = Modelo_TemplateEmail::obtieneHTML("RECUPERACION_CONTRASENA");
    $email_body = str_replace("%NOMBRES%", $nombres, $email_body);   
    $email_body = str_replace("%ENLACE%", $enlace, $email_body);        
    if (Utils::envioCorreo($correo,"Recuperación de Contraseña",$email_body)){
      return true;
    }
    else{
      return false;
    }
  }
}  
?>
<?php
class Controlador_Contrasena extends Controlador_Base {
  
  public function construirPagina(){
    if( Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/perfil/');
    }

    $opcion = Utils::getParam('opcion','',$this->data);  
    switch($opcion){      
      case 'recuperacion':
        $this->validarToken();
      break;      
      default:
        $this->mostrarDefault();
      break;
    }        
  }

  public function validarToken(){
    $tags = array();
    try{            
      $respuesta = Utils::getParam('token', '', false);

      if (empty($respuesta)){
        throw new Exception("La recuperación del password es fallida, por favor intente denuevo");
      }  
      $tags["token"] = $respuesta;              
      $respuesta = Utils::desencriptar($respuesta);      
      $valores = explode("||",$respuesta);      
      $token = $valores[0];
      $id_usuario_login = $valores[1];
      $fecha = $valores[2];
      $token_valido = Utils::generarToken($id_usuario_login,"CONTRASENA");
      
      if($token_valido != $token){
        throw new Exception("El enlace para recuperación es incorrecto, por favor ingrese denuevo su correo para el envio");      
      }
      if( strtotime($fecha." +".HORAS_VALIDO_PASSWORD." hours") < time() ){
        throw new Exception("El enlace para recuperación de contraseña ya no es válida, por favor ingrese denuevo su correo para el envío");        
      }  
      if ( Utils::getParam('confirm_form') == 1 ){
        $campos = array('password1'=>1,'password2'=>1);
        $data = $this->camposRequeridos($campos);
        if ($data["password1"] != $data["password2"]){
          throw new Exception("Contraseña y confirmación de contraseña no coinciden");
        }
        if (!Utils::valida_password($data["password1"])){
          throw new Exception("Contraseña no válida, debe contener mínimo 8 caracteres, una letra mayúscula y un número");
        }
        if (!Modelo_Usuario::modificarPassword($data["password1"],$id_usuario_login)){
          throw new Exception("Error al modificar la contraseña, por favor intente denuevo"); 
        }
        $_SESSION['mostrar_exito'] = "Contraseña modificada exitosamente"; 
        $this->redirectToController('login');
      }      
    }
    catch( Exception $e ){
      $_SESSION['mostrar_error'] = $e->getMessage();  
    } 
    //$social_reg = array('fb'=>0, 'gg'=>$gg_URL, 'lk'=>$lk, 'tw'=>$tw);
    // $social_reg = array('fb'=>0, 'gg'=>0, 'lk'=>0);

    //$tags = array('social'=>$social_reg);
    $tags["template_js"][] = "modal-register";
    $tags["template_js"][] = "validator";
    $tags["template_js"][] = "assets/js/main";     
    $tags["template_js"][] = "ruc_jquery_validator";
    $tags["template_js"][] = "bootstrap-multiselect";
    $tags["template_js"][] = "registrar";
    $tags["template_js"][] = "mic";
    Vista::render('confirmar_password', $tags);     
  }
  
  public function mostrarDefault(){
    $this->linkRedesSociales();
    $social_reg = array('fb'=>$this->loginURL, 'gg'=>$this->gg_URL, 'lk'=>$this->lk, 'tw'=>$this->tw);

    if ( Utils::getParam('forgot_form') == 1 ){
      try{
        $campos = array('correo1'=>1);
        $data = $this->camposRequeridos($campos);  
        
        if (!Utils::es_correo_valido($data["correo1"])){
          throw new Exception("Dirección de correo electrónico no valido");
        }
        $datousuario = Modelo_Usuario::busquedaPorCorreo($data["correo1"]);
        if (empty($datousuario)){
          throw new Exception("Dirección de correo electrónico no existe");
        }                           
        $token = Utils::generarToken($datousuario["id_usuario_login"],"CONTRASENA");
        if (empty($token)){
          throw new Exception("Error en el sistema, por favor intente denuevo");
        }
        $token .= "||".$datousuario["id_usuario_login"]."||".date("Y-m-d H:i:s");
        $token = Utils::encriptar($token);
        $nombres = $datousuario['nombres'] . ((isset($datousuario['apellidos'])) ? "&nbsp;".$datousuario['apellidos'] : '');

        $datos_correo = array('tipo'=>4, 'correo'=>$datousuario['correo'], 'nombres_mostrar'=>$nombres, 'token'=>$token);
        if (!Utils::enviarEmail($datos_correo)){
          throw new Exception("Error en el envio de correo, por favor intente denuevo");
        }
        $_SESSION['mostrar_exito'] = "Se envio a su direccion de correo ingresada el enlace para el cambio de correo, recuerde que tiene un máximo de ".HORAS_VALIDO_PASSWORD." horas para modificar su contraseña y en el caso de que no encuentre su correo revisar tambien su carpeta de spam";         
      }
      catch( Exception $e ){
        $_SESSION['mostrar_error'] = $e->getMessage();         
      }
    }

    $arrarea = Modelo_Area::obtieneOfertasxArea(SUCURSAL_PAISID);
    $arrinteres = Modelo_Interes::obtieneListado();
    
    $tags = array('social'=>$social_reg);

    $tags["arrarea"] = $arrarea;
    $tags["intereses"] = $arrinteres;
    //$tags["social"] = $social_reg;
    $tags["template_js"][] = "modal-register";
    $tags["template_js"][] = "validator";
    $tags["template_js"][] = "assets/js/main";
    $tags["template_js"][] = "ruc_jquery_validator";
    $tags["template_js"][] = "bootstrap-multiselect";
    $tags["template_js"][] = "registrar";
    $tags["template_js"][] = "mic";
    Vista::render('recuperar_password', $tags);  
  } 

  // public function envioCorreo($correo,$nombres,$token){
  //   $asunto = "Recuperación de Contraseña";
  //   $body = "Estimado, ".utf8_encode($nombres)."<br>";
  //   $body .= "Por favor de click en este enlace para cambiar su contrase&ntilde;a ";
  //   $body .= "<a href='".PUERTO."://".HOST."/contrasena/".$token."/'>click aqui</a> <br>";    
  //   if (Utils::envioCorreo($correo,$asunto,$body)){
  //     return true;
  //   }
  //   else{
  //     return false;
  //   }
  // }
}  
?>
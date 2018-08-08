<?php
require_once RUTA_INCLUDES.'PasswordResetTokenGenerator.php';

class Controlador_Contrasena extends Controlador_Base {

  function __construct(){
    global $_SUBMIT;
    $this->data = $_SUBMIT;
  }
  
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
    try{
      $respuesta = Utils::getParam('token', '', false);
      if (empty($respuesta)){
        throw new Exception("La recuperacion del password es fallida, por favor intente denuevo");
      }            
      $respuesta = Utils::desencriptar($respuesta);      
      $valores = explode("||",$respuesta);      
      $token = $valores[0];
      $idusuario = $valores[1];
      $ultima_sesion = $valores[2];
      $generator = new PasswordResetTokenGenerator(SECRET_TOKEN_PASSWORD, DIAS_TOKEN_PASSWORD);
      $esvalido = $generator->checkToken($idusuario,$ultima_sesion,$token);
      if (!$esvalido){
        throw new Exception("El enlace para recuperacion de contraseña ya no es valida, por favor ingrese denuevo su correo para el envio");
      }      
    }
    catch( Exception $e ){
      $_SESSION['mostrar_error'] = $e->getMessage();  
    } 
    $menu = $this->obtenerMenu();
    $tags = array('menu'=>$menu);
    Vista::render('confirmar_password', $tags);     
  }

  public function mostrarDefault(){
    if ( Utils::getParam('forgot_form') == 1 ){
      try{
        $campos = array('correo'=>1);
        $data = $this->camposRequeridos($campos);  
        
        if (!Utils::es_correo_valido($data["correo"])){
          throw new Exception("Dirección de correo electrónico no valido");
        }

        $datousuario = Modelo_Usuario::busquedaPorCorreo($data["correo"]);
        if (empty($datousuario)){
          throw new Exception("Dirección de correo electrónico no existe");
        }   
                
        $token = $this->generarToken($datousuario["id_usuario"],$datousuario["ultima_sesion"]);
        if (empty($token)){
          throw new Exception("Error en el sistema, por favor intente denuevo");
        }

        $token .= "||".$datousuario["id_usuario"]."||".$datousuario["ultima_sesion"];
        $token = Utils::encriptar($token);
        if (!$this->envioCorreo($datousuario['correo'],$datousuario['nombres'].' '.$datousuario['apellidos'],$token)){
          throw new Exception("Error en el envio de correo, por favor intente denuevo");
        }
        $_SESSION['mostrar_exito'] = "Se envio a su direccion de correo ingresada el enlace para el cambio de correo ";         
      }
      catch( Exception $e ){
        $_SESSION['mostrar_error'] = $e->getMessage();         
      }
    } 

    $menu = $this->obtenerMenu();
    $tags = array('menu'=>$menu);
    Vista::render('recuperar_password', $tags);  
  } 

  public function generarToken($idusuario,$fechalogin){
    $generator = new PasswordResetTokenGenerator(SECRET_TOKEN_PASSWORD, DIAS_TOKEN_PASSWORD);
    return $generator->makeToken($idusuario,$fechalogin);
  }

  public function envioCorreo($correo,$nombres,$token){
    $asunto = "Recuperacion de Contraseña";
    $body = "Estimado, ".$nombres."<br>";
    $body .= "Por favor de click en este enlace para cambiar su contrase&ntilde;a ";
    $body .= "<a href='".PUERTO."://".HOST."/contrasena/".$token."/'>click aqui</a> <br>";
    if (Utils::envioCorreo($correo,$asunto,$body)){
      return true;
    }
    else{
      return false;
    }
  }

}  
?>
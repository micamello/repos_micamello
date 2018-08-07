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
                
        $token = $this->generarToken($datousuario["id_usuario"],$datousuario["fecha_creacion"]);
        if (empty($token)){
          throw new Exception("Error en el sistema, por favor intente denuevo");
        }
        if ($this->envioCorreo($datousuario['correo'])){
          throw new Exception("Error en el envio de correo, por favor intente denuevo");
        }
        $_SESSION['mostrar_exito'] = "Se envio a su direccion de correo ingresada el enlace para el cambio de correo ".$token;
         
        //Utils::doRedirect(PUERTO.'://'.HOST.'/');
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

  public function envioCorreo($correo){
    Utils::envioCorreo($correo,"Recuperacion de Contraseña","Se ha enviado un correo con el siguiente token");
  }

}  
?>
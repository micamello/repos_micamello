<?php
class Controlador_Login extends Controlador_Base {

  function __construct(){
    global $_SUBMIT;
    $this->data = $_SUBMIT;
  }
  
  public function construirPagina(){
    if( Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/perfil/');
    }
    
    if ( Utils::getParam('login_form') == 1 ){
      try{
        $campos = array('username'=>1, 'password'=>1);
        $data = $this->camposRequeridos($campos);                        
        $usuario = Modelo_Usuario::autenticacion($data["username"], $data["password"]);
        if (!empty($usuario)){
           if (!Modelo_Usuario::modificarFechaLogin($usuario["id_usuario"])){
             throw new Exception("Error en el sistema, por favor intente nuevamente");
           }
           self::registroSesion($usuario);           
        }
        else{
          throw new Exception("Usuario o Password Incorrectos");
        }
        Utils::doRedirect(PUERTO.'://'.HOST.'/perfil/');
      }
      catch( Exception $e ){
        $_SESSION['mostrar_error'] = $e->getMessage();
      }
    } 

    Vista::render('login');  
  }

  public static function registroSesion($usuario){
    unset($_SESSION['mfo_datos']['usuario']); 
    $_SESSION['mfo_datos']['usuario'] = $usuario;
    ini_set("session.gc_maxlifetime", 14400000000000);        
    session_write_close();  
  }

}  
?>
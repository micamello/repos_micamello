<?php 

class Controlador_Registro extends Controlador_Base {
	function __construct(){
    global $_SUBMIT;
    $this->data = $_SUBMIT;
  }

  public function construirPagina(){
    if( Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/perfil/');
    }
    
    if ( Utils::getParam('register_form') == 1 ){
      try{
        $campos = array('username'=>1, 'correo'=>2, 'name_user'=>3, 'apell_user'=>4, 'password'=>5, 'numero_cand'=>6, 'cedula'=>7, 'area_select'=>8, 'nivel_interes'=>9, 'term_cond'=>10, 'term_data'=>11);
        $data = $this->camposRequeridos($campos);

        $datousername = Modelo_Usuario::busquedaPorCorreo($data["username"]);
        if (empty($datousuario)){
          throw new Exception("El usuario ingresado ya existe");
        }
      }
      catch( Exception $e ){
        $_SESSION['mostrar_error'] = $e->getMessage();      
      }
    } 

    $menu = $this->obtenerMenu();
    $tags = array('menu'=>$menu);
    Vista::render('inicio', $tags);
  }
}
?>
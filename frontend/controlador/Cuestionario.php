<?php
class Controlador_Cuestionario extends Controlador_Base {
  
  function __construct(){
    global $_SUBMIT;
    $this->data = $_SUBMIT;
  }

  public function construirPagina(){
    if( !Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/login/');
    }
    //solo candidatos pueden ingresar a los test
    if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::CANDIDATO){
      Utils::doRedirect(PUERTO.'://'.HOST.'/'); 
    }
    
    $opcion = Utils::getParam('opcion','',$this->data);  
    switch($opcion){               
      default:
        $this->mostrarDefault();
      break;
    }        
  }

  public function mostrarDefault(){
    //cuestionario actual
    $test = Modelo_Cuestionario::testActualxUsuario($_SESSION['mfo_datos']['usuario']['id_usuario']);
    $menu = $this->obtenerMenu();
    $tags = array('menu'=>$menu,'nrotest'=>$test);
    Vista::render('cuestionario', $tags);
  }
}  
?>
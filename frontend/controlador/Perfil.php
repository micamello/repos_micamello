<?php
class Controlador_Perfil extends Controlador_Base {
  
  function __construct(){
    global $_SUBMIT;
    $this->data = $_SUBMIT;
  }
  
  public function construirPagina(){
    if( !Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/login/');
    }
    
    $menu = $this->obtenerMenu();
    $tags = array('menu'=>$menu);
    Vista::render('perfil', $tags);  
    
  }
}  
?>
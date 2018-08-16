<?php
class Controlador_Plan extends Controlador_Base {
  
  function __construct(){
    global $_SUBMIT;
    $this->data = $_SUBMIT;
  }
  
  public function construirPagina(){
    if( !Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/login/');
    }
    
    $planes = Modelo_Plan::listadoxTipo(Modelo_Plan::CANDIDATO);

    $tags['planes'] = $planes;

    Vista::render('planes', $tags);    
  }
}  
?>
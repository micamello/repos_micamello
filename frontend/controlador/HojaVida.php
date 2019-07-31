<?php
class Controlador_HojaVida extends Controlador_Base{
  
  public function construirPagina(){
    if(!Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/login/');
    }
    if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA){
      Utils::doRedirect(PUERTO.'://'.HOST.'/');
    }
    $this->mostrarDefault();
       
  }

  public function mostrarDefault(){
    // $tags['']
    $tags["template_js"][] = "hvFileVal";
    Vista::render('cargarHV', $tags); 
  }

}
?>
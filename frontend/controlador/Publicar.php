<?php 
class Controlador_Publicar extends Controlador_Base {
  function __construct(){
    global $_SUBMIT;
    $this->data = $_SUBMIT;
  }

  public function construirPagina(){
    if(!Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/login/');
    }

    if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA){
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
  	// Utils::log("Eder Pozo publicar vacante");

  	$tags["template_js"][] = "selectr";
    $tags["template_js"][] = "validator";
    $tags["template_js"][] = "mic";
    // $tags["template_js"][] = "https://cloud.tinymce.com/stable/tinymce.min";
  	Vista::render('publicar_vacante', $tags);
  }

}


 ?>
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
    
    $opcion = Utils::getParam('opcion','',$this->data);  
    switch($opcion){      
      case 'paso1':
        $this->mostrarPaso1();
      break;
      default:
        $this->mostrarDefault();
      break;
    }     
    
  }

  public function mostrarDefault(){   
    $tags["template_js"][] = "validator"; 
    Vista::render('perfil', $tags);
  }

  public function mostrarPaso1(){  
    $tags["template_js"][] = "validator";   
    Vista::render('perfil_paso1', $tags);
  }
}  
?>
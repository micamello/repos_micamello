<?php
class Controlador_Inicio extends Controlador_Base {
  
  public function construirPagina(){
  
    setcookie('preRegistro', null, -1, '/');    
    $arrarea = Modelo_Area::obtieneListado();    
    $arrauspiciante = Modelo_Auspiciante::obtieneListado();        
    
    $tags = array('arrarea'=>$arrarea,                  
                  'arrauspiciante'=>$arrauspiciante,
                  'vista'=>'inicio');         
    $opcion = Utils::getParam('opcion','',$this->data);
    switch($opcion){
      case 'buscaCorreo':        
        $correo = Utils::getParam('correo', '', $this->data);
        $datocorreo = Modelo_Usuario::existeCorreo($correo);
        //Utils::log($datocorreo);
        Vista::renderJSON(array("respcorreo"=>$datocorreo));
      break;
      case 'buscaDni':
        $dni = Utils::getParam('dni', '', $this->data);
        $datodni = Modelo_Usuario::existeDni($dni);        
        Vista::renderJSON(array("respdni"=>$datodni));
      break;
      case 'quienesSomos':    
        Vista::render('quienesSomos', $tags);
      break;
      case 'canea':    
        Vista::render('canea', $tags);
      break;
      default:    
        Vista::render('inicio', $tags);
      break;
    }
    
  }
}  
?>
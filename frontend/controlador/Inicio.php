<?php
class Controlador_Inicio extends Controlador_Base {
  
  public function construirPagina(){
  
    setcookie('preRegistro', null, -1, '/');    
    $arrarea = Modelo_Area::obtieneListado();  
    $divisible = round(count($arrarea)/12);
    $completar = ($divisible*12)-count($arrarea);
    $i = 1;
    foreach ($arrarea as $key => $a) {
      $arrarea[] = array('id_area'=>$a['id_area'],'nombre'=>$a['nombre'],'ico'=>$a['ico']);
      if($i == $completar){
        break;
      }
      $i++;
    }  
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
      case 'terminoscondiciones':
        $vista = 'documentos/terminos_condiciones_'.SUCURSAL_ID;
        Vista::render($vista, $tags);
      break;
      case 'politicaprivacidad':
        $vista = 'documentos/politica_privacidad_'.SUCURSAL_ID;
        Vista::render($vista, $tags);
      break;
      case 'politicacookie':
        $vista = 'documentos/politicacookie_'.SUCURSAL_ID;
        Vista::render($vista, $tags);
      break;
      case 'verificarCompra':
        Utils::log("edereder-----");
        Vista::renderJSON(array("dato"=>$_SESSION['mfo_datos']['planActivar']));
      break;
      default:            
        Vista::render('inicio', $tags);
      break;
    }
    
  }
}  
?>
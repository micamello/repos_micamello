<?php
class Controlador_Inicio extends Controlador_Base {
  
  public function construirPagina(){
  
    setcookie('preRegistro', null, -1, '/');
    $arrbanner = Modelo_Banner::obtieneListado(Modelo_Banner::PRINCIPAL);
    $arrarea = Modelo_Area::obtieneListado();
    $arrtestimonio = Modelo_Testimonio::obtieneListado(SUCURSAL_PAISID);
    $arrauspiciante = Modelo_Auspiciante::obtieneListado();
    $arrgenero = Modelo_Genero::obtenerListadoGenero();
    $arrsectorind = Modelo_SectorIndustrial::consulta();
    
    $tags = array('banners'=>$arrbanner,
                  'arrarea'=>$arrarea,
                  'arrtestimonio'=>$arrtestimonio,
                  'arrauspiciante'=>$arrauspiciante);         

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
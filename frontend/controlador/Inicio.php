<?php
class Controlador_Inicio extends Controlador_Base {
  
  public function construirPagina(){

    if(!isset($_COOKIE['modalRegistro'])){
      setcookie('modalRegistro', "0_0", time() + (86400 * 30), "/");
    }

    $this->linkRedesSociales();
    $social_reg = array('fb'=>$this->loginURL, 'gg'=>$this->gg_URL, 'lk'=>$this->lk, 'tw'=>$this->tw);

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

    $arrtestimonio = Modelo_Testimonio::obtieneListado(SUCURSAL_PAISID);
    $arrauspiciante = Modelo_Auspiciante::obtieneListado();
    $arrgenero = Modelo_Genero::obtenerListadoGenero();
    $arrsectorind = Modelo_SectorIndustrial::consulta();
    
    $tags = array('inicio'=>1,
      'arrarea'=>$arrarea,
      'arrtestimonio'=>$arrtestimonio,
      'arrauspiciante'=>$arrauspiciante);  
    Vista::render('inicio', $tags);
  }
}  
?>
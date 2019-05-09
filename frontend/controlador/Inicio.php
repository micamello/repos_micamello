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
        Vista::render('inicio', $tags);
    
  }
}  
?>
<?php
class Controlador_Inicio extends Controlador_Base {
  
  function __construct(){
    global $_SUBMIT;
    $this->data = $_SUBMIT;
  }
  
  public function construirPagina(){

    $arrbanner = Modelo_Banner::obtieneListado(Modelo_Banner::PRINCIPAL);
    $nro_oferta = Modelo_Oferta::obtieneNumero(SUCURSAL_PAISID);
    $nro_candidato = Modelo_Usuario::obtieneNroUsuarios(SUCURSAL_PAISID);
    $nro_empresa = Modelo_Usuario::obtieneNroUsuarios(SUCURSAL_PAISID,Modelo_Usuario::EMPRESA);
    $arrarea = Modelo_Area::obtieneOfertasxArea(SUCURSAL_PAISID);
    $arrinteres = Modelo_Interes::obtieneListado();
    $arrtestimonio = Modelo_Testimonio::obtieneListado(SUCURSAL_PAISID);
    $arrauspiciante = Modelo_Auspiciante::obtieneListado();

    $tags = array('banners'=>$arrbanner, 
                  'nro_oferta'=>$nro_oferta,
                  'nro_candidato'=>$nro_candidato,
                  'nro_empresa'=>$nro_empresa,
                  'arrarea'=>$arrarea,
                  'intereses'=>$arrinteres,
                  'arrtestimonio'=>$arrtestimonio,
                  'arrauspiciante'=>$arrauspiciante);

    $tags["template_js"][] = "validator";
    $tags["template_js"][] = "selectr";
    $tags["template_js"][] = "ruc_jquery_validator";
    $tags["template_js"][] = "mic";
    $tags["template_js"][] = "modal-register";

    Vista::render('inicio', $tags);
  }
}  
?>
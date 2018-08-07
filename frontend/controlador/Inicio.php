<?php
class Controlador_Inicio extends Controlador_Base {
  
  function __construct(){
    global $_SUBMIT;
    $this->data = $_SUBMIT;
  }
  
  public function construirPagina(){
    //if( Modelo_Usuario::estaLogueado() ){
    //  Utils::doRedirect(PUERTO.'://'.HOST.'/perfil/');
    //}
    $arrbanner = Modelo_Banner::obtieneListado();
    $nro_oferta = Modelo_Oferta::obtieneNumero();
    $nro_candidato = Modelo_Usuario::obtieneNroCandidato();
    $nro_empresa = Modelo_Usuario::obtieneNroEmpresa();
    $arrarea = Modelo_Area::obtieneListado();
    $arrinteres = Modelo_Interes::obtieneListado();
    $arrtestimonio = Modelo_Testimonio::obtieneListado();
    $arrauspiciante = Modelo_Auspiciante::obtieneListado();
    $arrprovincia = Modelo_Provincia::obtieneListado();
    $arrpais = Modelo_Pais::obtieneListado();
    $menu = $this->obtenerMenu();

    $tags = array('banners'=>$arrbanner, 
                  'nro_oferta'=>$nro_oferta,
                  'nro_candidato'=>$nro_candidato,
                  'nro_empresa'=>$nro_empresa,
                  'arrarea'=>$arrarea,
                  'intereses'=>$arrinteres,
                  'arrtestimonio'=>$arrtestimonio,
                  'arrauspiciante'=>$arrauspiciante,
                  'arrprovincia'=>$arrprovincia,
                  'arrpais'=>$arrpais,
                  'menu'=>$menu);

    Vista::render('inicio', $tags);  
    
  }
}  
?>
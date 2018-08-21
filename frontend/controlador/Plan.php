<?php
class Controlador_Plan extends Controlador_Base {
  
  function __construct(){
    global $_SUBMIT;
    $this->data = $_SUBMIT;
  }
  
  public function construirPagina(){
    if( !Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/login/');
    }
    
    $tipousu = $_SESSION["mfo_datos"]["usuario"]["tipo_usuario"];
    $sucursal = $_SESSION["mfo_datos"]["sucursal"]["id_sucursal"]; 
    
    $planes = Modelo_Plan::listadoxTipo($tipousu,$sucursal,Modelo_Plan::PAQUETE);    
    $avisos = Modelo_Plan::listadoxTipo($tipousu,$sucursal,Modelo_Plan::AVISO);    
    $tags['planes'] = trim(Vista::display('detalle_plan',array('arreglo'=>$planes)));    
    $tags['avisos'] = trim(Vista::display('detalle_plan',array('arreglo'=>$avisos)));

    $arrbanner = Modelo_Banner::obtieneListado(Modelo_Banner::BANNER_CANDIDATO);
    $orden = rand(1,count($arrbanner))-1;
    $_SESSION['mostrar_banner'] = PUERTO.'://'.HOST.'/imagenes/banner/'.$arrbanner[$orden]['id_banner'].'.'.$arrbanner[$orden]['extension'];
    $tags["show_banner"] = 1;
    
    $tags["template_css"][] = "planes";

    Vista::render('planes', $tags);    
  }
}  
?>
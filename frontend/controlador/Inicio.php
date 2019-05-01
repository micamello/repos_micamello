<?php
class Controlador_Inicio extends Controlador_Base {
  
  public function construirPagina(){
    if(!isset($_COOKIE['modalRegistro'])){
      setcookie('modalRegistro', "0_0", time() + (86400 * 30), "/");
    }

    $this->linkRedesSociales();
    $social_reg = array('fb'=>$this->loginURL, 'gg'=>$this->gg_URL, 'lk'=>$this->lk, 'tw'=>$this->tw);

    $arrbanner = Modelo_Banner::obtieneListado(Modelo_Banner::PRINCIPAL);
    //$nro_oferta = Modelo_Oferta::obtieneNumero(SUCURSAL_PAISID);
    //$nro_candidato = Modelo_Usuario::obtieneNroUsuarios(SUCURSAL_PAISID,Modelo_Usuario::CANDIDATO);
    //$nro_empresa = Modelo_Usuario::obtieneNroUsuarios(SUCURSAL_PAISID,Modelo_Usuario::EMPRESA);
    //$arrarea = Modelo_Area::obtieneOfertasxArea(SUCURSAL_PAISID);
    $arrarea = Modelo_Area::obtieneListado();
    $arrtestimonio = Modelo_Testimonio::obtieneListado(SUCURSAL_PAISID);
    $arrauspiciante = Modelo_Auspiciante::obtieneListado();
    $arrgenero = Modelo_Genero::obtenerListadoGenero();
    $arrsectorind = Modelo_SectorIndustrial::consulta();
    
    $tags = array('banners'=>$arrbanner, 
                  //'nro_oferta'=>$nro_oferta,
                  //'nro_candidato'=>$nro_candidato,
                  //'nro_empresa'=>$nro_empresa,
                  'arrarea'=>$arrarea,
                  'arrtestimonio'=>$arrtestimonio,
                  'arrauspiciante'=>$arrauspiciante,
                  'social'=>$social_reg,
                  'genero'=>$arrgenero,
                  'arrsectorind'=>$arrsectorind);
    $tags["template_css"][] = "DateTimePicker";
    $tags["template_js"][] = "DniRuc_Validador";
    $tags["template_js"][] = "DateTimePicker";
    $tags["template_js"][] = "micamello_registro";
    
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
      default:    
        Vista::render('inicio', $tags);
      break;
    }
    
  }
}  
?>
<?php
class Controlador_Inicio extends Controlador_Base {
  
  public function construirPagina(){
    // $navegador = Utils::detectarNavegador();
    // FACEBOOK
    // require_once "includes/fb_api/config.php";
    // $permissions = ['email'];
    // $urlLogin = PUERTO."://".HOST."/facebook.php?tipo_user=1";
    //$fb_URL = $helper->getLoginUrl(PUERTO."://".HOST."/facebook.php?tipo_user=1", $permissions);

    // GOOGLE
    require_once "includes/gg_api/config.php";
    $gg_URL = $gClient->createAuthUrl();

    // LINKEDIN
    $lk = "linkedin.php?tipo_usuario=1";

    // TWITTER
    require_once "includes/tw_api/config.php";
    $tw = $connection->url("oauth/authorize", array('oauth_token' => $request_token['oauth_token']));

    $arrbanner = Modelo_Banner::obtieneListado(Modelo_Banner::PRINCIPAL);
    $nro_oferta = Modelo_Oferta::obtieneNumero(SUCURSAL_PAISID);
    $nro_candidato = Modelo_Usuario::obtieneNroUsuarios(SUCURSAL_PAISID,Modelo_Usuario::CANDIDATO);
    $nro_empresa = Modelo_Usuario::obtieneNroUsuarios(SUCURSAL_PAISID,Modelo_Usuario::EMPRESA);
    $arrarea = Modelo_Area::obtieneOfertasxArea(SUCURSAL_PAISID);
    $arrinteres = Modelo_Interes::obtieneListado();
    $arrtestimonio = Modelo_Testimonio::obtieneListado(SUCURSAL_PAISID);
    $arrauspiciante = Modelo_Auspiciante::obtieneListado();

    // $social_reg = array('fb'=>0, 'gg'=>$gg_URL, 'lk'=>$lk, 'tw'=>$tw);
    // $social_reg = array('fb'=>0, 'gg'=>0, 'lk'=>0);
    $social_reg = array('gg'=>$gg_URL, 'lk'=>$lk, 'tw'=>$tw);

    $tags = array('banners'=>$arrbanner, 
                  'nro_oferta'=>$nro_oferta,
                  'nro_candidato'=>$nro_candidato,
                  'nro_empresa'=>$nro_empresa,
                  'arrarea'=>$arrarea,
                  'intereses'=>$arrinteres,
                  'arrtestimonio'=>$arrtestimonio,
                  'arrauspiciante'=>$arrauspiciante,
                  'social'=>$social_reg);

    $tags["template_js"][] = "modal-register";
    //$tags["template_js"][] = "validator";
    $tags["template_js"][] = "assets/js/main";
    $tags["template_js"][] = "ruc_jquery_validator";
    $tags["template_js"][] = "bootstrap-multiselect";
    $tags["template_js"][] = "registrar";
    $tags["template_js"][] = "mic";

    $opcion = Utils::getParam('opcion','',$this->data);
    switch($opcion){
      case 'buscaCorreo':        
        $correo = Utils::getParam('correo', '', $this->data);
        $datocorreo = Modelo_Usuario::existeCorreo($correo);
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
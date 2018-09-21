<?php
class Controlador_Velocimetro extends Controlador_Base {
  
  function __construct(){
    global $_SUBMIT;
    $this->data = $_SUBMIT;
  }
  
  public function construirPagina(){
    if( !Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/login/');
    }
    //solo candidatos pueden ingresar a los test
    if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::CANDIDATO){
      Utils::doRedirect(PUERTO.'://'.HOST.'/'); 
    }

    $this->mostrarDefault();     
  }

  public function mostrarDefault(){
    $cuestionario = Modelo_Cuestionario::testxUsuario($_SESSION['mfo_datos']['usuario']["id_usuario"]);
    if (empty($cuestionario)){
      $this->redirectToController('cuestionario');
    }
    
    $nrototaltest = Modelo_Cuestionario::totalTest();
    $nrotestusuario = count($cuestionario);

    $porcentajextest = round(100 / $nrototaltest);
    $valorporc = 0;
    foreach($cuestionario as $test){
      $valorporc = $valorporc + round(($test["valor"] * $porcentajextest) / Modelo_Cuestionario::PUNTAJEMAX);
    }    

    $testactual = array_pop($cuestionario);
    $imagengif = ($nrotestusuario < $nrototaltest) ? "gif-lo-quiero.gif" : "gif_felicidades.gif";
    
    switch($test["orden"]){
      case 1:
        $descrporc = "Bajas";
      break;
      case 2:
        $descrporc = "Medianas";
      break;
      case 3:
        $descrporc = "Altas";
      break;
    }

    if ((!isset($_SESSION['mfo_datos']['planes']) || !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'],'tercerFormulario')) && 
        $nrotestusuario < ($nrototaltest-1)){
      $enlaceboton = "cuestionario";
    }
    //si tengo plan y mi plan tiene permiso para el tercer formulario, debe tener el total de test
    elseif(isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'],'tercerFormulario') && 
           $nrotestusuario < $nrototaltest){
      $enlaceboton = "cuestionario";
    }  
    else{                    
      $enlaceboton = "planes"; 
    }

    $tags["testactual"] = $testactual;
    $tags["nrototaltest"] = $nrototaltest;
    $tags["nrotestusuario"] = $nrotestusuario;
    $tags["valorporc"] = $valorporc;
    $tags["descrporc"] = $descrporc;
    $tags["imagengif"] = $imagengif;
    $tags["enlaceboton"] = $enlaceboton;

    $tags["template_js"][] = "d3.v3.min";
    $tags["template_js"][] = "velocimetro";
    $tags["template_css"][] = "velocimetro";

    Vista::render('velocimetro', $tags);    
  }
}  
?>
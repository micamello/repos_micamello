<?php
class Controlador_Velocimetro extends Controlador_Base {
  
  public function construirPagina(){
    if( !Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/login/');
    }
    //solo candidatos pueden ingresar a los test
    if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::CANDIDATO){
      Utils::doRedirect(PUERTO.'://'.HOST.'/'); 
    }

    $respUsuario = Modelo_Respuesta::obtenerRespuestas($_SESSION['mfo_datos']['usuario']['id_usuario']);
    if(empty($respUsuario)){
      Utils::doRedirect(PUERTO.'://'.HOST.'/cuestionario/'); 
    }

    $this->mostrarDefault();     
  }

  public function mostrarDefault(){
    $imagengif;
    $descrporc;
    $valorporc;
    $enlaceboton;
    $imagen;
    $textoBoton;
    $faceta = Modelo_Respuesta::facetaSiguiente($_SESSION['mfo_datos']['usuario']['id_usuario']);
    $faceta -= 1;
    if($faceta == 1){
      $imagengif = "gif-lo-quiero.gif";
      $descrporc = "Bajas";
      $valorporc = "20";
      $enlaceboton = "cuestionario";
      $imagen = "caracol";
      $textoBoton = "Siguiente";
    }
    elseif ($faceta == 2) {
      $imagengif = "gif-lo-quiero.gif";
      $descrporc = "Medianas";
      $valorporc = "40";
      $enlaceboton = "cuestionario";
      $imagen = "tortuga";
      $textoBoton = "Siguiente";
    }
    else{
      $imagengif = "gif-lo-quiero.gif";
      $descrporc = "Altas";
      $valorporc = "100";
      $enlaceboton = "postulacion";
      $imagen = "camello";
      $textoBoton = "Postúlate";
    }


    // $cuestionario = Modelo_Cuestionario::testxUsuario($_SESSION['mfo_datos']['usuario']["id_usuario"]);
    // if (empty($cuestionario)){
    //   $this->redirectToController('cuestionario');
    // }
    
    // $nrototaltest = Modelo_Cuestionario::totalTest();
    // $nrotestusuario = count($cuestionario);

    // $porcentajextest = round(100 / $nrototaltest);
    // $valorporc = 0;
    // foreach($cuestionario as $test){
    //   $valorporc = $valorporc + round(($test["valor"] * $porcentajextest) / Modelo_Cuestionario::PUNTAJEMAX);
    // }    

    // $testactual = array_pop($cuestionario);
    // $imagengif = ($nrotestusuario < $nrototaltest) ? "gif-lo-quiero.gif" : "gif_felicidades.gif";
    
    /*switch($test["orden"]){
      case 1:
        $descrporc = "Bajas";
      break;
      case 2:
        $descrporc = "Medianas";
      break;
      case 3:
        $descrporc = "Altas";
      break;
    }*/

    // //si no tengo planes o no tengo permiso para el tercer cuestionario 
    // if ((!isset($_SESSION['mfo_datos']['planes']) || !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'],'tercerFormulario')) && 
    //     $nrotestusuario < ($nrototaltest-1)){
    //   $enlaceboton = "cuestionario";
    // }
    // //si tengo plan y mi plan tiene permiso para el tercer formulario, debe tener el total de test
    // elseif(isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'],'tercerFormulario') && 
    //        $nrotestusuario < $nrototaltest){
    //   $enlaceboton = "cuestionario";
    // }  
    // else{          
    //   $enlaceboton = "planes"; 
    // }

    // $tags["testactual"] = $testactual;
    // $tags["nrototaltest"] = $nrototaltest;
    // $tags["nrotestusuario"] = $nrotestusuario;
    $tags["valorporc"] = $valorporc;
    $tags["descrporc"] = $descrporc;
    $tags["imagengif"] = $imagengif;
    $tags["enlaceboton"] = $enlaceboton;
    $tags["imagen"] = $imagen;
    $tags["textoBoton"] = $textoBoton;

    $tags["template_js"][] = "d3.v3.min";
    $tags["template_js"][] = "velocimetro";
    $tags["template_css"][] = "velocimetro";

    Vista::render('velocimetro', $tags);    
  }
}  
?>
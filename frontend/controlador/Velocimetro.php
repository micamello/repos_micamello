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

    $faceta = Modelo_Respuesta::facetaActual($_SESSION['mfo_datos']['usuario']['id_usuario']);
    if (empty($faceta)){
      Utils::doRedirect(PUERTO.'://'.HOST.'/cuestionario/'); 
    }

    $this->mostrarDefault($faceta);     
  }

  public function mostrarDefault($faceta){    
    $nrototaltest = Modelo_Cuestionario::totalTest();
    $nrotestusuario = Modelo_Cuestionario::totalTestxUsuario($_SESSION['mfo_datos']['usuario']["id_usuario"]);    
    if ((!isset($_SESSION['mfo_datos']['planes']) || !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'],'tercerFormulario')) && $nrotestusuario < ($nrototaltest-3)){
      $enlaceboton = "cuestionario";
    }
    // //si tengo plan y mi plan tiene permiso para el tercer formulario, debe tener el total de test
    elseif(isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'],'tercerFormulario') && $nrotestusuario < $nrototaltest){
      $enlaceboton = "cuestionario";
    }  
    else{          
      $enlaceboton = "planes"; 
    }
    
    if($faceta == 1){
      $imagengif = "gif-lo-quiero.gif";
      $descrporc = "Bajas";
      $valorporc = "20";      
      $imagen = "caracol.gif";
      $textoBoton = "Siguiente";
    }
    elseif ($faceta == 2) {
      $imagengif = "gif-lo-quiero.gif";
      $descrporc = "Medianas";
      $valorporc = "40";
      $imagen = "tortuga.gif";
      $textoBoton = "Siguiente";
    }
    else{
      $imagengif = "gif_felicidades.gif";
      $descrporc = "Altas";
      $valorporc = "100";
      $enlaceboton = "postulacion";
      $imagen = "camello.gif";
      $textoBoton = "Postúlate";
    }

    $tags["valorporc"] = $valorporc;
    $tags["descrporc"] = $descrporc;
    $tags["imagengif"] = $imagengif;
    $tags["enlaceboton"] = $enlaceboton;
    $tags["imagen"] = $imagen;
    $tags["textoBoton"] = $textoBoton;
    $tags["faceta"] = $faceta;
    $tags["nrototaltest"] = $nrototaltest;
    $tags["nrotestusuario"] = $nrotestusuario;

    $tags["template_js"][] = "d3.v3.min";
    $tags["template_js"][] = "velocimetro";
    $tags["template_css"][] = "velocimetro";

    Vista::render('velocimetro', $tags);    
  }
}  
?>
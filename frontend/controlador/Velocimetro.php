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
      $posibilidades = 'Bajas 20%';
      $valorporc = 20;
      $img = 'vel1.png'; 
      $msj1 = '¡SIGUE AS&Iacute;!';
      $msj2 = 'Estas a punto de descubrir tus puntos fuertes y de mejora';
      $textoBoton = "Continuar";
    }
    elseif ($faceta == 2) {
      $posibilidades = 'Medio 40%'; 
      $valorporc = 40;
      $img = 'vel2.png';
      $msj1 = 'VAS MUY BIEN!';
      $msj2 = 'Obtendras resultados beneficiosos para tu carrera profesional';
      $textoBoton = "Continuar";
    }
    else{
      $posibilidades = 'Alto 100%'; 
      $valorporc = 100;
      $img = 'vel3.png';
      $msj1 = '¡FELICIDADES!';
      $msj2 = 'Ahora formas parte del presente y el futuro de las empresas, siendo el candidato ideal';
      $textoBoton = "Ver Resultados";
      $enlaceboton = "fileGEN/informeusuario/".$_SESSION['mfo_datos']['usuario']['username'];
    }

    $tags["valorporc"] = $valorporc;
    $tags["posibilidades"] = $posibilidades;
    $tags["img"] = $img;
    $tags["msj1"] = $msj1;
    $tags["msj2"] = $msj2;
    $tags["enlaceboton"] = $enlaceboton;
    $tags["textoBoton"] = $textoBoton;

    Vista::render('velocimetro', $tags);    
  }
}  
?>
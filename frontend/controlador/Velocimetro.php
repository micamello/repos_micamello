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

    $opcion = Utils::getParam('opcion','',$this->data); 
    switch($opcion){ 
      case 'guardarGrafico':
        $imagen = Utils::getParam('imagen','',$this->data);
        if (!empty($imagen)){
          if (Modelo_Usuario::actualizarGrafico($_SESSION['mfo_datos']['usuario']['id_usuario'],$imagen)){
            $_SESSION['mfo_datos']['usuario']['grafico'] = $imagen; 
          }
        }
      break;  
      default:
        $this->mostrarDefault($faceta);  
      break;
    }
       
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
      $valorporc = 20;
      $img = 'vel1.png'; 
      $msj2 = 'Sus posibilidades de estar entre las primeras opciones de selección son pocas. Incremente sus oportunidades. El <b>TEST CANEA</b> tiene mucho más que ofrecerle para que sus opciones aumenten.  ';
      $textoBoton = "CONTINUAR";
    }
    elseif ($faceta == 2) {
      $valorporc = 40;
      $img = 'vel2.png';
      $msj2 = '¡Excelente! Ahora sus posibilidades se han incrementado. Mejore sus oportunidades al  completar el <b>TEST CANEA</b>. No desespere, recuerde que obtendrá mejores resultados y beneficios para su carrera profesional.';
      $textoBoton = "CONTINUAR";
    }
    else{
      $valorporc = 100;
      $img = 'vel3.png';
      $msj2 = '¡FELICIDADES! Acaba de completar el TEST CANEA. Ahora usted forma parte del presente y del futuro de las empresas, siendo el CANDIDATO IDEAL.';
      $textoBoton = "VER INFORME COMPLETO";
      $enlaceboton = "fileGEN/informeusuario/".$_SESSION['mfo_datos']['usuario']['username'];

      if (!isset($_SESSION['mfo_datos']['usuario']['grafico']) || empty($_SESSION['mfo_datos']['usuario']['grafico'])){
        $result_faceta = Modelo_PorcentajexFaceta::consultaxUsuario($_SESSION['mfo_datos']['usuario']['id_usuario']);
        $str_grafico = '';
        $reg_ultimo = array_shift($result_faceta);
        foreach($result_faceta as $rs){
          $str_grafico .= $rs["literal"].":".$rs["valor"].",".$rs["valor"]."|";
        }
        $str_grafico .= $reg_ultimo["literal"].":".$reg_ultimo["valor"].",".$reg_ultimo["valor"];       
        $tags["val_grafico"] = $str_grafico;
      }
    }

    $tags["valorporc"] = $valorporc;
    $tags["posibilidades"] = $posibilidades;
    $tags["img"] = $img;
    $tags["msj2"] = $msj2;
    $tags["enlaceboton"] = $enlaceboton;
    $tags["textoBoton"] = $textoBoton;
    $tags["template_js"][] = "velocimetro";  

    Vista::render('velocimetro', $tags);    
  }
}  
?>
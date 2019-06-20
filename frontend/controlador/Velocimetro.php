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
      $titulo = 'HA COMPLETADO LA PRIMERA FASE DEL TEST';
      $msj2 = 'Solo ha completado 1 test de competencias, sus posibilidades de estar entre las primeras opciones de selecci&oacute;n son pocas. Incremente sus oportunidades. Nuestro test Canea tiene mucho m&aacute;s que ofrecerle para que sus opciones aumenten. ';
      $textoBoton = "CONTINUAR";
    }
    elseif ($faceta == 2) {
      $valorporc = 40;
      $img = 'vel2.png';
      $titulo = '¡SIGA ADELANTE! HA COMPLETADO LA SEGUNDA FASE DEL TEST';
      $msj2 = '¡Excelente! Ha completado el segundo test, ahora sus posibilidades se han incrementado. Mejore sus oportunidades al completar el TEST CANEA. No desespere, recuerde que obtendrá mejores resultados y beneficios para su carrera profesional';
      $textoBoton = "VER PLANES";
    }
    else{
      $valorporc = 100;
      $img = 'vel3.png';
      $titulo = '¡FELICIDADES! ACABA DE COMPLETAR EL TEST CANEA.';
      $msj2 = 'Ahora usted forma parte del presente y del futuro de las empresas, siendo el CANDIDATO IDEAL.';
      $textoBoton = "VER INFORME COMPLETO";
      $enlaceboton = "fileGEN/informeusuario/".$_SESSION['mfo_datos']['usuario']['username'];

      if (!isset($_SESSION['mfo_datos']['usuario']['grafico']) || empty($_SESSION['mfo_datos']['usuario']['grafico'])){
        $result_faceta = Modelo_PorcentajexFaceta::consultaxUsuario($_SESSION['mfo_datos']['usuario']['id_usuario']);
        $str_grafico = '';
        $reg_ultimo = array_shift($result_faceta);
        foreach($result_faceta as $rs){

            if($rs["valor"] < 15){
              $str_grafico .= $rs["literal"].",".$rs["valor"]."|";
            }else{
              $str_grafico .= $rs["literal"].":".$rs["valor"].",".$rs["valor"]."|"; 
            }
        }

        if($reg_ultimo["valor"] < 15){
          $str_grafico .= $reg_ultimo["literal"].",".$reg_ultimo["valor"];   
        }else{
          $str_grafico .= $reg_ultimo["literal"].":".$reg_ultimo["valor"].",".$reg_ultimo["valor"];
        }

        $tags["val_grafico"] = $str_grafico;
      }
    }

    $tags["valorporc"] = $valorporc;
    $tags["titulo"] = $titulo;
    $tags["img"] = $img;
    $tags["msj2"] = $msj2;
    $tags["enlaceboton"] = $enlaceboton;
    $tags["textoBoton"] = $textoBoton;
    $tags["template_js"][] = "velocimetro";  

    Vista::render('velocimetro', $tags);    
  }
}  
?>
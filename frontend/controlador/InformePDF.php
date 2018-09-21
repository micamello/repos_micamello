<?php 
require_once 'includes/mpdf/mpdf.php';

class Controlador_InformePDF extends Controlador_Base
{
	public function construirPagina(){
    if(!Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/login/');
    }

    if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA){
      Utils::doRedirect(PUERTO.'://'.HOST.'/'); 
    }

    $username = Utils::getParam('username','',$this->data);
    switch($opcion){
      default:
      $usuario = $username;
        
          $this->generarPDF($usuario);

      break;
    } 
  }
  // Salto de página
	// <div style='page-break-after:always;'></div>
  // Salto de página
	public function generarPDF($usuario){


    $resultados = array();
    // $rasgo_general = array();
    $ragen_conceptos = array();
    $array_rasgosxusuario = array();
    $array_promedioxtest = array();
    $array_caracteristicasxrasgo = array();
    $array_defxtest = array();
    $arrayformej = array();
    
    $datos_usuario = Modelo_Usuario::existeUsuario($usuario);
    $cuestionariosUsuario = Modelo_Cuestionario::listadoCuestionariosxUsuario($datos_usuario['id_usuario']);
    // if (empty($cuestionariosUsuario)) {
    //   throw new exception("El usuario o postulante aun no ha realizado");
    // }
    foreach ($cuestionariosUsuario as $cuestionarios) {
      $test = "Test".$cuestionarios['id_cuestionario'];
      $suma = 0;
      $promedio = 0;
      $rasgoxcaracte = array();
      $array_definiciones_cxr = array();
      $array_mej_for = array();
      $rasgoxtest = Modelo_InformePDF::obtieneValorxRasgoxTest($datos_usuario['id_usuario'], $cuestionarios['id_cuestionario']);
      $array_rasgosxusuario +=[$test=>$rasgoxtest];
      $resultados += ["CuestionariosUsuario"=>$cuestionariosUsuario];
      $e =1;
      //Recorrido para todos los rasgos
        foreach ($array_rasgosxusuario['Test'.$cuestionarios['id_cuestionario']] as $rasgonum) {
          //El número 6 debería ser una constante
          $k = 1;
          $suma +=$rasgonum['valor'];
          $caracteristicas = array();
          for ($i=$rasgonum['valor']; ($i <= $rasgonum['caract_max']) && $k <=Modelo_InformePDF::ITERACION; $i++) {
              $caracteristicas += ["caracte".$k=>$i];
              if (($i+1) > $rasgonum['caract_max']) {
                for ($j=($rasgonum['valor']); $k <=Modelo_InformePDF::ITERACION; $j--) { 
                  $caracteristicas += ["caracte".$k=>$j];
                  $k++;
                }
              }
            $k++;
          } 
            // Utils::log(implode(',', $caracteristicas));
            $fortalezas = Modelo_MejoraFortalezas::obtieneMejoraFortalezas(1, $rasgonum['valor'], $rasgonum['id_rasgo']);
            $mejoras = Modelo_MejoraFortalezas::obtieneMejoraFortalezas(2, $rasgonum['valor'], $rasgonum['id_rasgo']);
            $definiciones_rasgos = Modelo_Caracteristica::obtieneCaracteristicas($rasgonum['id_rasgo'], implode(',', $caracteristicas));
            $array_mej_for += ["Rasgo".$e=>array("Fortalezas"=>$fortalezas, "Mejoras"=>$mejoras)];
            $array_definiciones_cxr += ["Rasgo".$e=>$definiciones_rasgos];
            $rasgoxcaracte += ["Rasgo".$e=>$caracteristicas];
            $e++;
          }
      $arrayformej += [$test=>$array_mej_for];
      $array_defxtest += [$test=>$array_definiciones_cxr];
      $array_caracteristicasxrasgo +=[$test=>$rasgoxcaracte];
      $array_promedioxtest += [$test=>(round($suma/count($rasgoxtest)))];
      $rasgo_general = Modelo_RasgoGeneral::obtieneRasgosGeneral($cuestionarios['id_cuestionario'], $array_promedioxtest['Test'.$cuestionarios['id_cuestionario']]);
      $ragen_conceptos +=[$test=>str_replace(array("_nombreAspirante_", "_saltoLinea_"), array(ucfirst($datos_usuario['nombres']), "<br><br>"), $rasgo_general['descripcion'])];


    }
      $resultados +=["RasgosxTest"=>$array_rasgosxusuario];
      $resultados +=["Promediosxtest"=>$array_promedioxtest];
      $resultados +=["RasGenConceptos"=>$ragen_conceptos];
      $resultados +=["CaracteristicasxRasgo"=>$array_caracteristicasxrasgo];
      $resultados +=["DefinicionesCaracteristicas"=>$array_defxtest];
      $resultados +=["FortalezasMejoras"=>$arrayformej];
      Utils::log("eder: ".print_r($resultados, true));
      // Utils::log("ederederedereder:     --------------".count($resultados['DefinicionesCaracteristicas']['Test1']['Rasgo1']));

    $parametro1 = Modelo_InformePDF::obtieneParametro(1);
    $parametro2 = Modelo_InformePDF::obtieneParametro(2);
    
    
    // Utils::log("-----------------------------".$caracteristicas_esp);
    $cabecera = "imagenes/pdf/header.png";
    $piepagina = "imagenes/pdf/footer.png";
		$mpdf=new mPDF('','A4');


    $inidoc = "<link href='https://fonts.googleapis.com/css?family=Archivo' rel='stylesheet'> 
                <style>
                header{padding: -34px 0px 0px -57px;}
                main{margin: 0px 155px 55px 155px; font-size: 30px;}
                footer{padding-bottom: -34px;padding-right: -57px;text-align: right;}
                .titulo_1{text-align: center; font-family: font-family: 'Archivo', sans-serif;}
                .text_justify{text-align: justify; font-family: font-family: 'Archivo', sans-serif;}
                .text_separate{padding-top: 350px; font-size: 80px; font-weigth: 550; text-align: center; font-family: font-family: 'Archivo', sans-serif; color: #118BD8;}
                table, td {border: 2px solid #D1D2D2; text-align: center; background-color: #E8F7FA; border-radius: 5px; padding: 8px;}
                table{ width: 100%; border-collapse: collapse;}
                .ant_name{font-size: 25px; font-family: font-family: 'Archivo', sans-serif;}
                .name_caratula{font-size: 80px; font-family: font-family: 'Archivo', sans-serif; color: #118BD8;}
                .content_caratula{padding-top: 500px; text-align: right;}
                </style>
                <body>
                <main>";
      $caratula = "<div class='content_caratula'><span class='ant_name'>Resultados del informe de</span><h3 class='name_caratula'>".ucfirst($datos_usuario['nombres'])." ".ucfirst($datos_usuario['apellidos'])."</h3></div>";
      $caracteristicas_esp = str_replace("_nombreAspirante_", ucfirst($datos_usuario['nombres']), $parametro2['descripcion']);
      $introduccion = "<h3 class='titulo_1'>Introducción</h3><br><p class='text_justify'>".utf8_encode(str_replace("_saltoLinea_", "<br><br>", $parametro1['descripcion']))."</p>";
      $salto = "<div style='page-break-after:always;'></div>";
      $p1 = "<p class='text_justify'>";
      $p2 = "</p>";
      $carac_gen_start = "<br><h3 class='titulo_1'>Características generales de ".ucfirst($datos_usuario['nombres'])."</h3>";
      $carac_esp_start = "<br><h3 class='titulo_1'>Características
                        específicas de ".ucfirst($datos_usuario['nombres'])."</h3>";
      $rasgos_esp_start = "<br><h3 class='titulo_1'>Rasgos específicos de ".ucfirst($datos_usuario['nombres'])."</h3>";
      $fortalezas_start = "<br><h3 class='titulo_1'>Fortalezas de ".ucfirst($datos_usuario['nombres'])."</h3>";
      $mejoras_start = "<br><h3 class='titulo_1'>Cosas que puede mejorar ".ucfirst($datos_usuario['nombres'])."</h3>";
      // $mejoras_end = "</p>";
      $enddoc = "</main></body>";


      $mpdf->WriteHTML($inidoc);
      $mpdf->WriteHTML($caratula);

      $mpdf->setHTMLHeader('<header><img src="'.$cabecera.'" width="17%"></header>');
      $mpdf->WriteHTML($salto);
      
      $mpdf->setHTMLFooter('<footer><img src="'.$piepagina.'" width="17%"></footer>');
	    $mpdf->WriteHTML($introduccion);
      // $mpdf->WriteHTML($salto);


      for ($i=1; $i <=count($resultados['CuestionariosUsuario']) ; $i++) {
        //Inicio Características generales del postulante por test
        $mpdf->WriteHTML($salto);
        $mpdf->WriteHTML("<h3 class='text_separate'>".ucfirst(utf8_encode($resultados['CuestionariosUsuario'][$i-1]['nombre'])))."</h3>";
        $mpdf->WriteHTML($salto);
        $mpdf->WriteHTML($carac_gen_start);
        $mpdf->WriteHTML($p1.utf8_encode($resultados['RasGenConceptos']['Test'.$i]).$p2);
        $mpdf->WriteHTML($salto);
        //Fin Características generales del postulante por test

        //Tabla de características específicas del postulante
        $mpdf->WriteHTML($carac_esp_start);
        $mpdf->WriteHTML($p1.utf8_encode($caracteristicas_esp)."<br><br>".$p2);
        $mpdf->WriteHTML("<table>");
        for ($j=1; $j <= count($resultados['DefinicionesCaracteristicas']['Test'.$i]); $j++) {
          $mpdf->WriteHTML("<tr>");
          // $mpdf->WriteHTML("eder".$j. $i);
          for ($k=0; $k < count($resultados['DefinicionesCaracteristicas']['Test'.$i]['Rasgo'.$j]); $k++) {
            // $mpdf->WriteHTML("eder".$j. $i);
            $mpdf->WriteHTML("<td>");
            $mpdf->WriteHTML(utf8_encode($resultados['DefinicionesCaracteristicas']['Test'.$i]['Rasgo'.$j][($k)]['nombre']));
            $mpdf->WriteHTML("</td>");
          }
          $mpdf->WriteHTML("</tr>");
        }
        $mpdf->WriteHTML("</table>");
        $mpdf->WriteHTML($salto);
        
        $mpdf->WriteHTML($rasgos_esp_start);
          for ($j=1; $j <= count($resultados['DefinicionesCaracteristicas']['Test'.$i]); $j++) {
            for ($k=0; $k < count($resultados['DefinicionesCaracteristicas']['Test'.$i]['Rasgo'.$j]); $k++) {
              $mpdf->WriteHTML($p1.utf8_encode($resultados['DefinicionesCaracteristicas']['Test'.$i]['Rasgo'.$j][($k)]['descripcion'])."<br><br>".$p2);
            }
          }
        $mpdf->WriteHTML($salto);

        
        $mpdf->WriteHTML($fortalezas_start);
        $mpdf->WriteHTML("<table>");
          for ($j=1; $j <= count($resultados['FortalezasMejoras']['Test'.$i]); $j++) {
            for ($k=0; $k < count($resultados['FortalezasMejoras']['Test'.$i]['Rasgo'.$j]); $k++) {
              // $mpdf->WriteHTML("<tr>");
              for ($k=0; $k < count($resultados['FortalezasMejoras']['Test'.$i]['Rasgo'.$j]['Fortalezas']); $k++) {
                $mpdf->WriteHTML("<tr><td>");
                  $mpdf->WriteHTML(utf8_encode($resultados['FortalezasMejoras']['Test'.$i]['Rasgo'.$j]['Fortalezas'][($k)]['nombre'])."<br><br>");
                $mpdf->WriteHTML("</td></tr>");
              }
              // $mpdf->WriteHTML("</tr>");
            }
          }
          $mpdf->WriteHTML("</table>");

        $mpdf->WriteHTML($salto);

        $mpdf->WriteHTML($mejoras_start);
        $mpdf->WriteHTML("<table>");
          for ($j=1; $j <= count($resultados['FortalezasMejoras']['Test'.$i]); $j++) {
            for ($k=0; $k < count($resultados['FortalezasMejoras']['Test'.$i]['Rasgo'.$j]); $k++) {
              for ($k=0; $k < count($resultados['FortalezasMejoras']['Test'.$i]['Rasgo'.$j]['Mejoras']); $k++) {
                $mpdf->WriteHTML("<tr><td>");
                  $mpdf->WriteHTML(utf8_encode($resultados['FortalezasMejoras']['Test'.$i]['Rasgo'.$j]['Mejoras'][($k)]['nombre'])."<br><br>");
                $mpdf->WriteHTML("</td></tr>");
              }
            }
          }
          $mpdf->WriteHTML("</table>");
        // $mpdf->WriteHTML($mejoras_end);


      }


      $mpdf->WriteHTML($enddoc);
	    $mpdf->Output();
      // Descargar parametro del Output
      // 'filename.pdf', 'D'
	    exit;
	}
}

 ?>
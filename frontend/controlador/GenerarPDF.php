<?php 
require_once 'includes/mpdf/mpdf.php';

class Controlador_GenerarPDF extends Controlador_Base
{
	public function construirPagina(){
    if(!Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/login/');
    }

    if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA || !isset($_SESSION['mfo_datos']['planes'])){
      Utils::doRedirect(PUERTO.'://'.HOST.'/'); 
    }

    if (isset($_SESSION['mfo_datos']['planes']) && !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'descargarInformePerso')){
      Utils::doRedirect(PUERTO.'://'.HOST.'/vacantes/');  
    }

    $username = Utils::getParam('username','',$this->data);
    $opcion = Utils::getParam('opcion','',$this->data);
    $vista = Utils::getParam('vista','',$this->data);
    $id_oferta = Utils::getParam('id_oferta','',$this->data);
    switch($opcion){
      case 'informeusuario':
        $usuario = $username;
        $this->extraerDatos($usuario);
      break;
      case 'datousuario':
        $usuario = $username;
        $this->perfilAspirante($usuario, $vista, $id_oferta);
      break;
      default:
      break;
    } 
  }
  // Salto de página
	// <div style='page-break-after:always;'></div>
  // Salto de página
	public function extraerDatos($usuario){
    $firma = "";
    $total_cuestionarios = Modelo_Cuestionario::totalTest();
    $resultados = array();
    // $rasgo_general = array();
    $ragen_conceptos = array();
    $array_rasgosxusuario = array();
    $array_promedioxtest = array();
    $array_caracteristicasxrasgo = array();
    $array_defxtest = array();
    $arrayformej = array();
    
    $datos_usuario = Modelo_Usuario::existeUsuario($usuario);
    $info_usuario = Modelo_Usuario::infoUsuario($datos_usuario['id_usuario']);
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
      if (count($cuestionariosUsuario) == $total_cuestionarios) {
        $firma = "<img class='img_inf_mic' src='imagenes/informe/firma.png' alt='firma Psic.Luis Mata'/>";
      }
      $e =1;
      //Recorrido para todos los rasgos
        foreach ($array_rasgosxusuario['Test'.$cuestionarios['id_cuestionario']] as $rasgonum) {
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
      // $resultados = "";

    $parametro1 = Modelo_InformePDF::obtieneParametro(1);
    $parametro2 = Modelo_InformePDF::obtieneParametro(2);

    if (empty($resultados) || empty($datos_usuario) || empty($info_usuario)) {
      throw new Exception("Ha ocurrido un error al generar el informe");
    }
    self::informePersonalidad($parametro1, $parametro2, $resultados, $datos_usuario, $info_usuario, $firma);
    
    
	}

  public function informePersonalidad($parametro1, $parametro2, $resultados, $datos_usuario, $info_usuario, $firma){

    $cabecera = "imagenes/pdf/header.png";
    $piepagina = "imagenes/pdf/footer.png";
    $mpdf=new mPDF('','A4');


    $inidoc = "<link href='https://fonts.googleapis.com/css?family=Archivo' rel='stylesheet'>
               <link rel='stylesheet' href='css/informemic.css'>
               <link rel='icon' type='image/x-icon' href='imagenes/favicon.ico'>
               <body>
               <main>";


      $caratula = "<div class='content_caratula'><span class='ant_name'>Resultados del informe de</span><h3 class='name_caratula'>".ucfirst($datos_usuario['nombres'])." ".ucfirst($info_usuario['apellidos'])."</h3></div>";
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
        for ($j=1; $j <= count($resultados['DefinicionesCaracteristicas']['Test'.$i]); $j++) {
          for ($k=0; $k < count($resultados['DefinicionesCaracteristicas']['Test'.$i]['Rasgo'.$j]); $k++) {
            $mpdf->WriteHTML("<h6 class='items_inf'>".utf8_encode($resultados['DefinicionesCaracteristicas']['Test'.$i]['Rasgo'.$j][($k)]['nombre'])."</h6>");
          }
        }
        $mpdf->WriteHTML($salto);
        
        $mpdf->WriteHTML($rasgos_esp_start);
          for ($j=1; $j <= count($resultados['DefinicionesCaracteristicas']['Test'.$i]); $j++) {
            for ($k=0; $k < count($resultados['DefinicionesCaracteristicas']['Test'.$i]['Rasgo'.$j]); $k++) {
              $mpdf->WriteHTML($p1.utf8_encode($resultados['DefinicionesCaracteristicas']['Test'.$i]['Rasgo'.$j][($k)]['descripcion'])."<br><br>".$p2);
            }
          }
        $mpdf->WriteHTML($salto);

        
        $mpdf->WriteHTML($fortalezas_start);
          for ($j=1; $j <= count($resultados['FortalezasMejoras']['Test'.$i]); $j++) {
            for ($k=0; $k < count($resultados['FortalezasMejoras']['Test'.$i]['Rasgo'.$j]); $k++) {
              for ($k=0; $k < count($resultados['FortalezasMejoras']['Test'.$i]['Rasgo'.$j]['Fortalezas']); $k++) {
                  $mpdf->WriteHTML("<h6 class='items_inf'>".utf8_encode($resultados['FortalezasMejoras']['Test'.$i]['Rasgo'.$j]['Fortalezas'][($k)]['nombre'])."</h6>");
              }
            }
          }

        $mpdf->WriteHTML($salto);

        $mpdf->WriteHTML($mejoras_start);
          for ($j=1; $j <= count($resultados['FortalezasMejoras']['Test'.$i]); $j++) {
            for ($k=0; $k < count($resultados['FortalezasMejoras']['Test'.$i]['Rasgo'.$j]); $k++) {
              for ($k=0; $k < count($resultados['FortalezasMejoras']['Test'.$i]['Rasgo'.$j]['Mejoras']); $k++) {
                // $mpdf->WriteHTML("<tr><td>");
                  $mpdf->WriteHTML("<h6 class='items_inf'>".utf8_encode($resultados['FortalezasMejoras']['Test'.$i]['Rasgo'.$j]['Mejoras'][($k)]['nombre'])."</h6>");
              }
            }
          }

      }
      if ($firma != "") {
        $mpdf->WriteHTML("<div class='div_img_mic_inf'>".$firma."</div>");
      }

      $mpdf->WriteHTML($enddoc);
      $mpdf->Output();
      
      // Descargar parametro del Output
      // 'filename.pdf', 'D'
      exit;

  }

  public function perfilAspirante($username, $vista, $id_oferta){
    // print_r($_FILES);
    // print_r($_POST['img_val']);
    // echo "<img src='https://minutodedios.fm/wp-content/uploads/2017/05/perro-gato.jpg'>";
    // echo "<img src='".$_POST['img_val']."'>";
    // exit();
    $modelo_aspirante = new Controlador_Aspirante();
    $foto = Modelo_Usuario::obtieneFoto($username);
    // print_r($foto);
    // echo "<img src='".$foto."'>";
    $nodata = "---------";

    // var_dump($modelo_aspirante->datauser($username, $id_oferta, $vista));

    // exit();
    $datos_usuario = $modelo_aspirante->datauser($username, $id_oferta, $vista);
    Utils::log(print_r($datos_usuario, true));

    // print_r($datos_usuario['asp_sararial']['asp_salarial']);
    // exit();
    $cabecera = "imagenes/pdf/header.png";
    $piepagina = "imagenes/pdf/footer.png";


    $mpdf=new mPDF('','A4');


    $inidoc = "<link href='https://fonts.googleapis.com/css?family=Archivo' rel='stylesheet'>
              <link rel='stylesheet' href='css/mic.css'>
              <link rel='icon' type='image/x-icon' href='imagenes/favicon.ico'>
               <style>
                table{
                  width: 100%;
                }
                </style>
               <body>
               <main>";
    $enddoc = "</main></body>";
    $foto = "<img class='perfil_photo_user' src='imagenes/usuarios/profile/".$username.".jpg'>";
    $nombre_apellido = "<h3>".ucwords($datos_usuario['infoUsuario']['nombres'])." ".ucwords($datos_usuario['infoUsuario']['apellidos'])."</h3>";
    $label_asp_salarial = "<h5>ASPIRACIÓN SALARIAL</h5>";
    $asp_salarial = "<h5>".$datos_usuario['asp_sararial']['asp_salarial']."</h5>";
    // print_r("imagenes/usuarios/profile/".$username."/.jpg");exit();
    $cajainicio = "<div class='box_text'>";
    $cajafin = "</div>";


    $tableinicio = "<table><tbody>";
    $trinicio = "<tr>";
    $trfin = "</tr>";
    $tdiniciost = "<td style='text-align: center;' colspan='";
    $tdfinst = "'>";
    $tdfin = "</td>";
    $tablefin = "</tbody></table>";
    $hr = "<hr>";

    $label_datos_candidato = "<b>DATOS CANDIDATO</b>";
    $label_estudios_candidato = "<b>ESTUDIOS</b>";

    $label_estudios_extrajero = "<p>Estudios en el extrajero</p>";

    $label_datos_docimiciliarios_candidato = "<b>DATOS DOMICILIARIOS</>";

    $label_datos_nivel_idiomas = "<b>DOMINIO DE IDIOMAS</>";

    $idiomas = Modelo_NivelxIdioma::relacionIdiomaNivel($datos_usuario['infoUsuario']['idiomas']);

    $label_datos_preferencia_empleo = "<b>PREFERENCIAS DE EMPLEOS</>";

    $areas = Modelo_Area::obtieneAreas($datos_usuario['infoUsuario']['areas']);
    $nivel_interes = Modelo_Interes::obtieneIntereses($datos_usuario['infoUsuario']['nivel']);

    $label_datos_contacto = "<b>DATOS DE CONTACTO</>";
    $label_resultados_evaluacion = "<b>RESULTADOS DE EVALUACIÓN</b>";
    // var_dump($idiomas);
    // exit();

    // var_dump($nivel_interes);
    // exit();

    // Datos
// Nacionalidad
    $dato_nacionalidad = "";
    if($datos_usuario['infoUsuario']['nacionalidad'] != "" || !empty($datos_usuario['infoUsuario']['nacionalidad'])){
      $dato_nacionalidad = $datos_usuario['infoUsuario']['nacionalidad'];
    }else{
      $dato_nacionalidad = $nodata;
    }
    $nacionalidad = "<label><b>Nacionalidad:</b> ".$dato_nacionalidad."</label>";
// Estado civil
    $dato_estado_civil = "";
    if($datos_usuario['infoUsuario']['estado_civil'] != "" || !empty($datos_usuario['infoUsuario']['estado_civil'])){
      foreach (ESTADO_CIVIL as $key => $value) {
        if($datos_usuario['infoUsuario']['estado_civil'] == $key){
          $dato_estado_civil = $value;
        }
      }
    }else{
      $dato_estado_civil = $nodata;
    }
    $estado_civil = "<p><b>Estado civil</b></p>".$dato_estado_civil;

// Trabaja
    $dato_tiene_trabajo = "";
    if($datos_usuario['infoUsuario']['tiene_trabajo'] != "" || !empty($datos_usuario['infoUsuario']['tiene_trabajo'])){
      foreach (REQUISITO as $key => $value) {
        if($datos_usuario['infoUsuario']['tiene_trabajo'] == $key){
          $dato_tiene_trabajo = $value;
        }
      }
    }else{
      $dato_tiene_trabajo = $nodata;
    }
    $tiene_trabajo = "<p><b>Trabaja</b></p>".$dato_tiene_trabajo;

// Disponibilidad de viaje
    $dato_viajar = "";
    if($datos_usuario['infoUsuario']['viajar'] != "" || !empty($datos_usuario['infoUsuario']['viajar'])){
      foreach (REQUISITO as $key => $value) {
        if($datos_usuario['infoUsuario']['viajar'] == $key){
          $dato_viajar = $value;
        }
      }
    }else{
      $dato_viajar = $nodata;
    }
    $viajar = "<p><b>Disponibilidad de viajar</b></p>".$dato_viajar;

// Licencia
    $dato_licencia = "";
    if($datos_usuario['infoUsuario']['licencia'] != "" || !empty($datos_usuario['infoUsuario']['licencia'])){
      foreach (REQUISITO as $key => $value) {
        if($datos_usuario['infoUsuario']['licencia'] == $key){
          $dato_licencia = $value;
        }
      }
    }else{
      $dato_licencia = $nodata;
    }
    $licencia = "<p><b>Licencia</b></p>".$dato_licencia;

// Discapacidad
    $dato_discapacidad = "";
    if($datos_usuario['infoUsuario']['discapacidad'] != "" || !empty($datos_usuario['infoUsuario']['discapacidad'])){
      foreach (REQUISITO as $key => $value) {
        if($datos_usuario['infoUsuario']['discapacidad'] == $key){
          $dato_discapacidad = $value;
        }
      }
    }else{
      $dato_discapacidad = $nodata;
    }
    $discapacidad = "<p><b>Discapacidad</b></p>".$dato_discapacidad;

// Años experiencia
    $dato_anosexp = "";
    if($datos_usuario['infoUsuario']['anosexp'] != "" || !empty($datos_usuario['infoUsuario']['anosexp'])){
      foreach (ANOSEXP as $key => $value) {
        if($datos_usuario['infoUsuario']['anosexp'] == $key){
          $dato_anosexp = $value;
        }
      }
    }else{
      $dato_anosexp = $nodata;
    }
    $anosexp = "<p><b>Experiencia</b></p>".$dato_anosexp;

// Estado carrera
    $dato_status_carrera = "";
    if($datos_usuario['infoUsuario']['status_carrera'] != "" || !empty($datos_usuario['infoUsuario']['status_carrera'])){
      foreach (STATUS_CARRERA as $key => $value) {
        if($datos_usuario['infoUsuario']['status_carrera'] == $key){
          $dato_status_carrera = $value;
        }
      }
    }else{
      $dato_status_carrera = $nodata;
    }
    $status_carrera = "<p><b>Estado carrera</b></p>".$dato_status_carrera;

// Escolaridad
    $dato_escolaridad = "";
    if($datos_usuario['infoUsuario']['escolaridad'] != "" || !empty($datos_usuario['infoUsuario']['escolaridad'])){
      $dato_escolaridad = $datos_usuario['infoUsuario']['escolaridad'];
    }else{
      $dato_escolaridad = $nodata;
    }
    $escolaridad = "<p><b>Escolaridad</b></p>".$dato_escolaridad;

// Género
    $dato_genero = "";
    if($datos_usuario['infoUsuario']['genero'] != "" || !empty($datos_usuario['infoUsuario']['genero'])){
      foreach (GENERO as $key => $value) {
        if($datos_usuario['infoUsuario']['genero'] == $key){
          $dato_genero = $value;
        }
      }
    }else{
      $dato_genero = $nodata;
    }
    $genero = "<p><b>Género</b></p>".$dato_genero;

// Fecha nacimiento
    $dato_fecha_nacimiento = "";
    if($datos_usuario['infoUsuario']['fecha_nacimiento'] != "" || !empty($datos_usuario['infoUsuario']['fecha_nacimiento'])){
      $dato_fecha_nacimiento = $datos_usuario['infoUsuario']['fecha_nacimiento'];
    }else{
      $dato_fecha_nacimiento = $nodata;
    }
    $fecha_nacimiento = "<p><b>Fecha nacimiento</b></p>".$dato_fecha_nacimiento;

// Escolaridad
    $dato_universidad = "";
    if($datos_usuario['infoUsuario']['universidad'] != "" || !empty($datos_usuario['infoUsuario']['universidad'])){
      $dato_universidad = $datos_usuario['infoUsuario']['universidad'];
    }else{
      $dato_universidad = $nodata;
    }
    $universidad = "<p><b>Universidad</b></p>".$dato_universidad;

// País
    $dato_genero = "";
    if($datos_usuario['infoUsuario']['pais'] != "" || !empty($datos_usuario['infoUsuario']['pais'])){
      $dato_pais = $datos_usuario['infoUsuario']['pais'];
    }else{
      $dato_pais = $nodata;
    }
    $pais = "<p><b>País</b></p>".$dato_pais;

// Provincia
    $dato_provincia = "";
    if($datos_usuario['infoUsuario']['provincia'] != "" || !empty($datos_usuario['infoUsuario']['provincia'])){
      $dato_provincia = $datos_usuario['infoUsuario']['provincia'];
    }else{
      $dato_provincia = $nodata;
    }
    $provincia = "<p><b>Provincia</b></p>".$dato_provincia;

//  Ciudad
    $dato_ciudad = "";
    if($datos_usuario['infoUsuario']['ciudad'] != "" || !empty($datos_usuario['infoUsuario']['ciudad'])){
      $dato_ciudad = $datos_usuario['infoUsuario']['ciudad'];
    }else{
      $dato_ciudad = $nodata;
    }
    $ciudad = "<p><b>Ciudad</b></p>".$dato_ciudad;






    $mpdf->WriteHTML($inidoc);
    $mpdf->WriteHTML($tableinicio);

    // Nombre y apellido
      $mpdf->WriteHTML($trinicio);
        $mpdf->WriteHTML($tdiniciost."12".$tdfinst.$nombre_apellido.$tdfin);
      $mpdf->WriteHTML($trfin);

    // Nacionalidad
      $mpdf->WriteHTML($trinicio);
        $mpdf->WriteHTML($tdiniciost."12".$tdfinst.$nacionalidad.$tdfin);
      $mpdf->WriteHTML($trfin);

      // Seccion
      $mpdf->WriteHTML($hr);

      // Label datos candidato
      $mpdf->WriteHTML($trinicio);
        $mpdf->WriteHTML($tdiniciost."12".$tdfinst.$label_datos_candidato.$tdfin);
      $mpdf->WriteHTML($trfin);

      // $mpdf->WriteHTML($trinicio."<td rowspan='10' colspan='12'></td>".$trfin);

      $mpdf->WriteHTML($trinicio);
        $mpdf->WriteHTML($tdiniciost."6".$tdfinst.$estado_civil.$tdfin);
        $mpdf->WriteHTML($tdiniciost."6".$tdfinst.$tiene_trabajo.$tdfin);
      $mpdf->WriteHTML($trfin);

      $mpdf->WriteHTML($trinicio);
        $mpdf->WriteHTML($tdiniciost."6".$tdfinst.$viajar.$tdfin);
        $mpdf->WriteHTML($tdiniciost."6".$tdfinst.$licencia.$tdfin);
      $mpdf->WriteHTML($trfin);

      $mpdf->WriteHTML($trinicio);
        $mpdf->WriteHTML($tdiniciost."6".$tdfinst.$discapacidad.$tdfin);
        $mpdf->WriteHTML($tdiniciost."6".$tdfinst.$anosexp.$tdfin);
      $mpdf->WriteHTML($trfin);

      $mpdf->WriteHTML($trinicio);
        $mpdf->WriteHTML($tdiniciost."6".$tdfinst.$genero.$tdfin);
        $mpdf->WriteHTML($tdiniciost."6".$tdfinst.$fecha_nacimiento.$tdfin);
      $mpdf->WriteHTML($trfin);

      // Seccion}

      // $mpdf->WriteHTML($hr);

      // Label datos candidato
      $mpdf->WriteHTML($trinicio);
        $mpdf->WriteHTML($tdiniciost."12".$tdfinst.$label_estudios_candidato.$tdfin);
      $mpdf->WriteHTML($trfin);
      
      if(($datos_usuario['infoUsuario']['id_univ'] == NULL || $datos_usuario['infoUsuario']['id_univ'] == "") && ($datos_usuario['infoUsuario']['universidad'] != NULL || $datos_usuario['infoUsuario']['universidad']) != ""){
        $mpdf->WriteHTML($trinicio);
          $mpdf->WriteHTML($tdiniciost."12".$tdfinst.$label_estudios_extrajero.$tdfin);
        $mpdf->WriteHTML($trfin);
      }

      $mpdf->WriteHTML($trinicio);
        $mpdf->WriteHTML($tdiniciost."12".$tdfinst.$universidad.$tdfin);
      $mpdf->WriteHTML($trfin);

      $mpdf->WriteHTML($trinicio);
        $mpdf->WriteHTML($tdiniciost."6".$tdfinst.$status_carrera.$tdfin);
        $mpdf->WriteHTML($tdiniciost."6".$tdfinst.$escolaridad.$tdfin);
      $mpdf->WriteHTML($trfin);

      // Label DATOS DOMICILIARIOS
      $mpdf->WriteHTML($trinicio);
        $mpdf->WriteHTML($tdiniciost."12".$tdfinst.$label_datos_docimiciliarios_candidato.$tdfin);
      $mpdf->WriteHTML($trfin);

      // $mpdf->WriteHTML($trinicio);
      //   $mpdf->WriteHTML($tdiniciost."12".$tdfinst.$universidad.$tdfin);
      // $mpdf->WriteHTML($trfin);

      $mpdf->WriteHTML($trinicio);
        $mpdf->WriteHTML($tdiniciost."4".$tdfinst.$pais.$tdfin);
        $mpdf->WriteHTML($tdiniciost."4".$tdfinst.$provincia.$tdfin);
        $mpdf->WriteHTML($tdiniciost."4".$tdfinst.$ciudad.$tdfin);
      $mpdf->WriteHTML($trfin);

      // Label DOMINIO DE IDIOMAS
      $mpdf->WriteHTML($trinicio);
        $mpdf->WriteHTML($tdiniciost."12".$tdfinst.$label_datos_nivel_idiomas.$tdfin);
      $mpdf->WriteHTML($trfin);

      foreach ($idiomas as $key => $value) {
        $mpdf->WriteHTML($trinicio);
          $mpdf->WriteHTML($tdiniciost."12".$tdfinst.($value['descripcion'].' - '.$value['nombre']).$tdfin);
        $mpdf->WriteHTML($trinicio); 
      }

      // Label PREFERENCIAS DE EMPLEOS
      $mpdf->WriteHTML($trinicio);
        $mpdf->WriteHTML($tdiniciost."12".$tdfinst.$label_datos_preferencia_empleo.$tdfin);
      $mpdf->WriteHTML($trfin);

      $mpdf->WriteHTML($trinicio);
        $mpdf->WriteHTML($tdiniciost."12".$tdfinst."<b>Áreas</b>".$tdfin);
      $mpdf->WriteHTML($trfin);

      foreach ($areas as $key => $value) {
        $mpdf->WriteHTML($trinicio);
          $mpdf->WriteHTML($tdiniciost."12".$tdfinst.$value['nombre'].$tdfin);
        $mpdf->WriteHTML($trfin);
      }

      $mpdf->WriteHTML($trinicio);
        $mpdf->WriteHTML($tdiniciost."12".$tdfinst."<b>Nivel de interés</b>".$tdfin);
      $mpdf->WriteHTML($trfin);

      foreach ($nivel_interes as $key => $value) {
        $mpdf->WriteHTML($trinicio);
          $mpdf->WriteHTML($tdiniciost."12".$tdfinst.$value['descripcion'].$tdfin);
        $mpdf->WriteHTML($trfin);
      }

      // Label DATOS DE CONTACTO
      $mpdf->WriteHTML($trinicio);
        $mpdf->WriteHTML($tdiniciost."12".$tdfinst.$label_datos_contacto.$tdfin);
      $mpdf->WriteHTML($trfin);

        $mpdf->WriteHTML($trinicio);
          $mpdf->WriteHTML($tdiniciost."4".$tdfinst."<b>Teléfono</b><br>".$datos_usuario['Conf']['telefono'].$tdfin);
        
          $mpdf->WriteHTML($tdiniciost."4".$tdfinst."<b>Correo</b><br>".$datos_usuario['Conf']['correo'].$tdfin);
        
          $mpdf->WriteHTML($tdiniciost."4".$tdfinst."<b>DNI</b><br>".$datos_usuario['Conf']['dni'].$tdfin);
        $mpdf->WriteHTML($trfin);


      $mpdf->WriteHTML($trinicio);
        $mpdf->WriteHTML($tdiniciost."12".$tdfinst.$label_resultados_evaluacion.$tdfin);
      $mpdf->WriteHTML($trfin);

    $mpdf->WriteHTML($tablefin);

    $array_colors = ['#DFDD4B', '#C29BE6', '#E61616', '#39E75E', '#81B152', '#BEA3A3', '#5BC6FD', '#C1842D', '#9C29EC', '#FFAD85', '#88BE54'];
    // $ul_start = "<ul class='skill-list'>";
    // $ul_end = "</ul>";
    // $li_start = "<li class='skill'>";
    // $li_end = "<li>";
    // $text_bar_start = "<h3 class=''>";
    // $text_bar_end = "</h3>";
    // $progress_start_class = "<progress class='";
    // $progress_end_class_start_value = "' style='background-color: red;' max='100' value='";
    // $progress_end_value = "'>";
    // $progress_end_tag = "</progress>";

    // $mpdf->WriteHTML("<progress max='100' style='width: 100%; height: 3%; color: red;' value='25'>eder</progress>");

    
    $i = 0;
    foreach ($datos_usuario['Resultados'] as $key => $value) {
      $mpdf->WriteHTML("<p style='text-align: center;'>".$datos_usuario['Resultados'][$i]['nombre']."   (".$datos_usuario['Resultados'][$i]['valor'].")</p>");
      $mpdf->WriteHTML("<div class='progress_bar'><div class='inside_progress' style='width: ".(($datos_usuario['Resultados'][$i]['valor']*100)/25)."%; background-color: ".$array_colors[$i].";'></div></div>");
      $i++;
    }

      // $mpdf->WriteHTML("<progress value='90' max='100' style='background-color: red;'>");
        // $mpdf->WriteHTML($progress_start_class."red".$progress_end_class_start_value."80".$progress_end_value.$progress_end_tag);
    // $mpdf->showImageErrors = true;
    // $mpdf->curlAllowUnsafeSslRequests = true; 
    // $mpdf->WriteHTML("<img src='".$_POST['img_val']."'>");
    // $mpdf->WriteHTML("<img src='imagenes/banner/1.gif'>");
    // $mpdf->Image($_POST['img_val'], 0, 0, 210, 297, '', '', true, true);  
     // echo "<img src='".$foto."'>";
    // $mpdf->WriteHTML("<img src='http://localhost/repos_micamello/imagenes/usuarios/candidato1/'>");
    // $mpdf->showImageErrors(true);

    // $mpdf->WriteHTML($cajainicio."eder".$cajafin);
    // $mpdf->WriteHTML($foto);
    // $mpdf->WriteHTML($nombre_nacionalidad);

    // $mpdf->WriteHTML($cajainicio);
    // $mpdf->WriteHTML($label_asp_salarial);

    // // $mpdf->WriteHTML($cajainicio);
    // if($datos_usuario['asp_sararial']['asp_salarial'] !== null || !empty($datos_usuario['asp_sararial']['asp_salarial'])){
    //   $mpdf->WriteHTML($cajainicio.$asp_salarial.$cajafin);
    // }
    // else{
    //   $mpdf->WriteHTML($cajainicio.$nodata.$cajafin);
    // }
    // $mpdf->WriteHTML($cajafin);
    $mpdf->WriteHTML($table);
    $mpdf->WriteHTML($enddoc);
    $mpdf->Output('informe_'.$datos_usuario['infoUsuario']['username'].".pdf", 'D');
  }
}
?>
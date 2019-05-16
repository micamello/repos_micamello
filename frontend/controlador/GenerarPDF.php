<?php 
require_once 'includes/mpdf/mpdf.php';

class Controlador_GenerarPDF extends Controlador_Base
{
	public function construirPagina(){
    if(!Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/login/');
    }

    /*
    if (isset($_SESSION['mfo_datos']['planes']) && !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'descargarInformePerso')){
      Utils::doRedirect(PUERTO.'://'.HOST.'/vacantes/');  
    }*/

    $username = Utils::getParam('username','',$this->data);
    $opcion = Utils::getParam('opcion','',$this->data);
    $vista = Utils::getParam('vista','',$this->data);
    $id_oferta = Utils::getParam('id_oferta','',$this->data);
    switch($opcion){
      case 'hvUsuario':
        $username = Utils::getParam('username','',$this->data);
        $id_oferta = Utils::getParam('id_oferta','',$this->data);
        $vista = Utils::getParam('vista','',$this->data);
        self::hvUsuario($username, $id_oferta, $vista);
      break;
      case 'informeusuario':

        $usuario = Modelo_Usuario::existeUsuario($username);
        $idusuario = $usuario['id_usuario']; 
        $idPlan = Utils::getParam('idPlan','',$this->data);
        $idPlan = ((!empty($idPlan)) ? Utils::desencriptar($idPlan) : $idPlan);

        $id_oferta = Utils::getParam('idOferta','',$this->data);
        $id_oferta = ((!empty($id_oferta)) ? Utils::desencriptar($id_oferta) : $id_oferta);
        $puedeDescargar = false;
        $cantidadRestante = 1;
        $id_empresa = false;

        if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA){

          if(isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'descargarInformePerso',$idPlan) && !empty($id_oferta)){
            $puedeDescargar = true;
            $id_empresa = $_SESSION['mfo_datos']['usuario']['id_usuario'];

          }else{
            $puedeDescargar = false;
            $_SESSION['mostrar_error'] = 'Usted no tiene tiene permisos para realizar esta acci\u00F3n';
            //$ruta = PUERTO . '://' . HOST . '/vacantes/';
          }
        }

        if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){

          if(isset($_SESSION['mfo_datos']['planes']) && (Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'descargarInformePerso') || Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'descargarInformePersoParcial'))){
            $puedeDescargar = true;
          }else{ 
            $puedeDescargar = false;
            $_SESSION['mostrar_error'] = 'Usted no tiene tiene permisos para realizar esta acci\u00F3n';
            //$ruta = PUERTO . '://' . HOST . '/perfil/';
          }
        }

        if(($idusuario == $_SESSION['mfo_datos']['usuario']['id_usuario'] && $puedeDescargar == true) || ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA && $puedeDescargar == true)){

          $result = Modelo_Opcion::datosGraficos2($idusuario,1,$id_empresa); 
          $cantd_facetas = count($result);
          $tipo_informe = '';
          $cantd_f = $cont = 0;
          if(($cantd_facetas == Modelo_Usuario::PRIMER_TEST || $cantd_facetas == Modelo_Usuario::SEGUNDO_TEST) || ($cantd_facetas > Modelo_Usuario::SEGUNDO_TEST && $cantd_facetas < Modelo_Usuario::COMPLETO_TEST)){
            $tipo_informe = 'parcial';
            $cantd_f = 2;
          }else if($cantd_facetas == Modelo_Usuario::COMPLETO_TEST){
            $tipo_informe = 'completo';
            $cantd_f = 5;
          }

          $idsfacetas = "";
          foreach($result as $keyvl=>$vlresult){
            $cont++;
            if($cont<=$cantd_f){
              $idsfacetas .= $keyvl.","; 
            }else{
              break;
            }
          }

          $idsfacetas = substr($idsfacetas, 0, -1);         
          $preguntas = Modelo_Respuesta::resultadoxUsuario($idusuario,$idsfacetas);   
          $porcentajesxfaceta = Modelo_Usuario::obtenerFacetasxUsuario($idusuario,$idsfacetas);  
          $rasgos = Modelo_Rasgo::obtieneListadoAsociativo();
          //print_r($rasgos);    
          $colores = Modelo_Faceta::obtenerColoresLiterales();
          $facetasDescripcion = Modelo_Faceta::obtenerFacetas();
          $array_datos_graficos = array();
         
          $informe = $this->generaInforme(array('datos'=>$usuario,'tipo_informe'=>$tipo_informe,'preguntas'=>$preguntas,'facetas'=>$facetasDescripcion,'datosGraficos'=>$result,'colores'=>$colores,'datos_descarga'=>array('id_usuario'=>$idusuario,'id_empresa'=>$id_empresa,'id_oferta'=>$id_oferta,'puedeDescargar'=>$puedeDescargar),'porcentajesxfaceta'=>$porcentajesxfaceta,'rasgos'=>$rasgos,'facetasHabilitadas'=>explode(',',$idsfacetas)));
        }else{
          
          $enlace = $_SERVER['HTTP_REFERER'];
          Utils::doRedirect($enlace);
        }

      break;
      // case 'datousuario':
      //   $usuario = $username;
      //   $this->perfilAspirante($usuario, $vista, $id_oferta);
      // break;
      default:
      break;
    } 
  }

  public function generaInforme($datos){
    $facetas = $datos['facetas'];
    $tipo_informe = $datos['tipo_informe'];
    $preg_x_faceta = Modelo_Pregunta::totalPregXfaceta()['cantd_preguntas'];
    $datosusuario = $datos['datos'];
    $preguntas = $datos['preguntas'];
    $porcentajesxfaceta = $datos['porcentajesxfaceta'];
    $rasgos = $datos['rasgos'];
    $datos_descarga = $datos['datos_descarga'];
    $conacentos = array('Á', 'É','Í','Ó','Ú','Ñ');
    $sinacentos = array('a', 'e','i','o','u','n');
    $codigo   = array('&aacute;', '&eacute;','&iacute;','&oacute;','&uacute;','&ntilde;');
    $nombre = strtolower($datosusuario['nombres'].' '.$datosusuario['apellidos']);
    $nombre_archivo = utf8_encode(str_replace(' ', '_',str_replace($codigo,$sinacentos,$nombre))).'.pdf';
    $nombre = str_replace($codigo,$conacentos,$nombre);
    $informe = '<h3 align="center">INFORME DE TEST CANEA DE '.utf8_encode(strtoupper($nombre)).'</h3>';

    $cantd_preg = 0;
    $pos_no_disponible = 1;
    $parrafo = $faceta = $porcentaje_faceta = $etiquetas_faceta = $colors = $descrip_facetas = $descrip_titulo = '';

    $puntaxfaceta = array();

    foreach ($porcentajesxfaceta as $c => $datos_resultado) {
      $puntaxfaceta[$datos_resultado['id_faceta']] = $datos_resultado['id_puntaje'];
      $etiquetas_faceta .=  $datos_resultado['valor'].'|';
      $colors .= str_replace("#", "", $datos['colores'][$datos_resultado['id_faceta']]).'|';
      $descrip_facetas .= $facetas[$datos_resultado['id_faceta']]['faceta'].': '.$datos_resultado['valor'].'|';
      $descrip_titulo .= $facetas[$datos_resultado['id_faceta']]['literal'];
    }

    $etiquetas_faceta = substr($etiquetas_faceta, 0,-1);
    $colors = substr($colors, 0,-1);
    $descrip_facetas = substr($descrip_facetas, 0,-1);
    $porcentajes_faceta = str_replace('|', ',', $etiquetas_faceta);

    $informe .= '<table><tr>';
    foreach ($facetas as $id_faceta => $f) {
      $informe .= '<td style="background-color:'.$datos['colores'][$id_faceta].'">'.$f['literal'].'</td>';
    }
    $cantd_facetas = count($facetas);
    $informe .= '</tr>';
     
    foreach ($rasgos as $puntaje => $r) {

      $informe .= '<tr>';
      foreach ($facetas as $id_faceta => $value) {

        if(in_array($id_faceta, $datos['facetasHabilitadas'])){
          $informe .= '<td ';
          if($puntaxfaceta[$id_faceta] == $puntaje){ 
            $informe .= 'style="background-color:'.$datos['colores'][$id_faceta].';"';
          }
         $informe .= '>'.utf8_encode($r[$id_faceta]).'</td>';
        }else{

          if($pos_no_disponible <= 3){
            $informe .= '<td>NO DISPONIBLE</td>';
            $pos_no_disponible++;
          }else{
            $informe .= '<td></td>';
          }
          
        }
      }
      $informe .= '</tr>';
    }
    $informe .= '</table>';

    $informe .= '<br>';
    foreach ($porcentajesxfaceta as $k => $valores) {

      $l = $facetas[$valores['id_faceta']]['literal'];
      $d = $facetas[$valores['id_faceta']]['faceta'];
      $informe .= utf8_encode($l.'/'.$d.': '.str_replace('_NOMBRE_', utf8_encode(strtoupper($datosusuario['nombres'])),$valores['descripcion']));
      $informe .= '<br><br>';
    }

    $informe .= '<br>';

    foreach($preguntas as $key => $pregunta){
      $cantd_preg++;
      $resultado = Modelo_Baremo::obtienePuntaje($pregunta['orden1'],$pregunta['orden2'],$pregunta['orden3'],$pregunta['orden4'],$pregunta['orden5']);

      $informe .= ($key + 1).'. '.strtoupper(utf8_encode($pregunta['nombre'])).' - '.utf8_encode($pregunta['descripcion']);
      $informe .= '<br>';
      //buscar valor en segundo baremo
      $informe .= 'porcentaje: '.$resultado['porcentaje'];
      $informe .= '<br>';
      $informe .= 'limites: '.$pregunta['limite_inferior'].' - '.$pregunta['limite_medio'].' - '.$pregunta['limite_superior'];
      $informe .= '<br><br>';

      //$descriptor = Modelo_Descriptor::obtieneTextos($pregunta['id_competencia'],$resultado['id_puntaje']);       
     /* if ($pregunta['id_faceta'] != $faceta){
        $faceta = $pregunta['id_faceta'];
        $datosfaceta = Modelo_Faceta::consultaIndividual($pregunta['id_faceta']);
        $informe .= '<p align="justify"><b>'.utf8_encode($datosfaceta['introduccion'])."</b></p>";
        //$informe .= '<p align="justify"><i><u><b>'.utf8_encode($datosfaceta['descripcion']).'</b></u></i>: '.utf8_encode($competenciasXfacetas[$pregunta['id_faceta']]).'</p>';
        ;
      }
      $parrafo .= ucwords(strtolower(utf8_encode($datosusuario['nombres']))).' '.utf8_encode($descriptor['descripcion']).' ';
     */
      /*if($cantd_preg == $preg_x_faceta){
          
          $cantd_preg = 0;

          $calculo_promedio = $datos['datosGraficos'][$pregunta['id_faceta']];
          $etiquetas_faceta .=  $calculo_promedio.'|';
          $colors .= str_replace("#", "", $datos['colores'][$pregunta['id_faceta']]).'|';
          $descrip_facetas .= $facetas[$pregunta['id_faceta']]['faceta'].': '.$calculo_promedio.'|';
          $descrip_titulo .= $facetas[$pregunta['id_faceta']]['literal'];
          $informe .= '<p align="justify">'.substr($parrafo, 0,-2).'</p>';
          $parrafo = '';
      }*/
    }
    
    if(count($porcentajesxfaceta) == count($facetas)){
      $informe .= '<p align="center"><img align="center" src="https://chart.googleapis.com/chart?chs=500x300&chd=t:'.$porcentajes_faceta.'&cht=p&chl='.$etiquetas_faceta.'&chco='.$colors.'&chtt='.$descrip_titulo.'&chdl='.$descrip_facetas.'" class="img-responsive"></p>';
    }
   
    echo $informe; 
    //self::informePersonalidad($informe,$nombre_archivo,$datos_descarga);
  }

  public function informePersonalidad($html,$nombre_archivo,$datos_descarga){
    $cabecera = "imagenes/pdf/header.png";
    $piepagina = "imagenes/pdf/footer.png";
    $mpdf=new mPDF('','A4');
    $inidoc = "<!DOCTYPE html><html><link rel='stylesheet' href='css/informemic.css'>
                <body><main>";
    $enddoc = "</main></body></body></html>";
    $mpdf->setHTMLHeader('<header><img src="'.$cabecera.'" width="17%"></header>'); 
    $mpdf->WriteHTML($inidoc);
    $mpdf->WriteHTML($enddoc);   
    $mpdf->setHTMLFooter('<footer><img src="'.$piepagina.'" width="17%"></footer>');
    $mpdf->WriteHTML($html);

    //validar  si es empresa y si tiene cupo para descargar
    if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA){
      $posibilidades = Modelo_UsuarioxPlan::disponibilidadDescarga($datos_descarga['id_empresa'],$datos_descarga['id_oferta']);
      $descargas = Modelo_Descarga::descargasInforme($datos_descarga['id_empresa'],$datos_descarga['id_oferta']);

      if(!empty($posibilidades)){
        
        if(in_array($datos_descarga['id_usuario'], $descargas)){
          $mpdf->Output($nombre_archivo, 'D');
        }else{

          if(count($descargas) < $posibilidades){
            Modelo_Descarga::registrarDescargaInforme($datos_descarga['id_usuario'],$datos_descarga['id_empresa'],$datos_descarga['id_oferta']);
            $mpdf->Output($nombre_archivo, 'D');
          }else{
            $_SESSION['mostrar_error'] = 'Ya agoto su cupo de descargas de informes para esta oferta';
            $enlace = $_SERVER['HTTP_REFERER'];
            Utils::doRedirect($enlace);
          }
        }
      }else{

        if(!in_array($datos_descarga['id_usuario'], $descargas)){
          Modelo_Descarga::registrarDescargaInforme($datos_descarga['id_usuario'],$datos_descarga['id_empresa'],$datos_descarga['id_oferta']);
        }
        $mpdf->Output($nombre_archivo, 'D');
      }
    }else{
      $mpdf->Output($nombre_archivo, 'D');
    }
  }

 
  public function hvUsuario($username, $id_oferta, $vista){

        $datos = Modelo_Usuario::existeUsuario(Utils::desencriptar($username));
        if($vista == 1){
            $aspSalarial = Modelo_Usuario::aspSalarial($datos['id_usuario'], $id_oferta);
            $datos = array_merge($datos, array('aspSalarial'=>$aspSalarial['asp_salarial']));
        }
        $mfoUsuario = Modelo_Usuario::informacionPerfilUsuario($datos['id_usuario']);
        $datos = array_merge($datos, $mfoUsuario);
        $usuarioxarea = Modelo_UsuarioxArea::obtieneListado($datos['id_usuario']);
        $dataareasubarea = array();
        foreach ($usuarioxarea as $key=>$value) {
            array_push($dataareasubarea, $value[0]);
        }
        $dataareasubarea = implode(",", $dataareasubarea);
        $areasubarea = Modelo_UsuarioxAreaSubarea::obtieneAreas_Subareas($dataareasubarea);
        $array_group = array();
        foreach ($areasubarea as $key => $value) {
            $array_group[$value['id_area']][$key] = $value;
        }
        $areasubarea = $array_group;
        $usuarioxnivelidioma = Modelo_UsuarioxNivelIdioma::obtenerIdiomasUsuario($datos['id_usuario']);
        $datos = array_merge($datos, array("usuarioxarea"=>$areasubarea));
        $datos = array_merge($datos, array("usuarioxnivelidioma"=>$usuarioxnivelidioma));

        $inicioTabla = "<table style='width: 100%;'>";

        $finTabla = "</table>";
        $iniciothead = "<thead>";
        $finthead = "</thead>";
        $iniciotbody = "<tbody>";
        $fintbody = "</tbody>";
        $iniciotr = "<tr>";
        $fintr = "</tr>";
        $iniciotd = "<td colspan='";
        $tdstyle = "' style='";
        $tdinter = "'>";
        $fintd = "</td>";

        $fotoPerfil = "";
        $divinicio = "<div style='";
        $divinter = "'>";
        $divfinal = "</div>";
        $imageninicio = "<img src='";
        $imagenstyle = "' style='";
        $imagenfin = "'>";
        $ruta = PATH_PROFILE.$datos['username'].'.jpg';
        $archivoRuta = "usuarios/profile/".$datos['username'].'.jpg'; 
        $resultado = file_exists($ruta);
        if (!$resultado){
          $archivoRuta = "user.png";
        }       
        $archivo = $archivo.'.jpg';
        $foto = PUERTO.'://'.HOST.'/imagenes/'.$archivoRuta;
        $html .= $divinicio."text-align: center;".$divinter.$imageninicio.$foto.$imagenstyle."width: 120px;height: 120px;border-style: solid;border-color: white;".$imagenfin.$divfinal;
        if(isset($datos['aspSalarial'])){
          $html .= "<h5 style='text-align: center;'><b>Aspiración salarial:</b> ".SUCURSAL_MONEDA.$datos['aspSalarial']."</h5>";
        }
        $html .= $inicioTabla;
          $html .= $iniciotbody;
            $html .= $iniciotr;
              $html .= $iniciotd."12".$tdstyle."text-align: center; background-color: rgb(37, 58, 91); color: white;".$tdinter;
                $html .= "<h4>Datos de usuario</h4>";
              $html .= $fintd;
            $html .= $fintr;

            $html .= $iniciotr;
              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Nombres</b>";
              $html .= $fintd;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Apellidos</b>";
              $html .= $fintd;
            $html .= $fintr;

            $html .= $iniciotr;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= $datos['nombres'];
              $html .= $fintd;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= $datos['apellidos'];
              $html .= $fintd;

            $html .= $fintr;
    // ------------------------------------------------------
            $html .= $iniciotr;
              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Nacionalidad</b>";
              $html .= $fintd;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Edad</b>";
              $html .= $fintd;
            $html .= $fintr;

            $html .= $iniciotr;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= $datos['nacionalidad'];
              $html .= $fintd;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= $datos['edad'];
              $html .= $fintd;

            $html .= $fintr;

// ------------------------------------------------------
            $html .= $iniciotr;
              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Disponibilidad para viajar</b>";
              $html .= $fintd;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Cambio de residencia</b>";
              $html .= $fintd;
            $html .= $fintr;

            $html .= $iniciotr;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= $datos['viajar'];
              $html .= $fintd;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= $datos['residencia'];
              $html .= $fintd;

            $html .= $fintr;

// ------------------------------------------------------
            $html .= $iniciotr;
              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Discapacidad</b>";
              $html .= $fintd;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Género</b>";
              $html .= $fintd;
            $html .= $fintr;

            $html .= $iniciotr;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= $datos['discapacidad'];
              $html .= $fintd;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= $datos['genero'];
              $html .= $fintd;

            $html .= $fintr;

// ------------------------------------------------------
            $html .= $iniciotr;
              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Escolaridad</b>";
              $html .= $fintd;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Situación laboral</b>";
              $html .= $fintd;
            $html .= $fintr;

            $html .= $iniciotr;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= $datos['escolaridad'];
              $html .= $fintd;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= $datos['situacionLaboral'];
              $html .= $fintd;

            $html .= $fintr;

// ------------------------------------------------------
            $html .= $iniciotr;
              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Licencia</b>";
              $html .= $fintd;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Universidad</b>";
              $html .= $fintd;
            $html .= $fintr;

            $html .= $iniciotr;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= $datos['licencia'];
              $html .= $fintd;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= $datos['universidad'];
              $html .= $fintd;

            $html .= $fintr;

// ------------------------------------------------------
            $html .= $iniciotr;
              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Estado civil</b>";
              $html .= $fintd;
            $html .= $fintr;

            $html .= $iniciotr;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= $datos['estadocivil'];
              $html .= $fintd;

            $html .= $fintr;
// --------------***************--------------------------
            $html .= $iniciotr;
              $html .= $iniciotd."12".$tdstyle."text-align: center; background-color: rgb(37, 58, 91); color: white;".$tdinter;
                $html .= "<h4>Datos de residencia</h4>";
              $html .= $fintd;
            $html .= $fintr;

// ------------------------------------------------------
            $html .= $iniciotr;
              $html .= $iniciotd."4".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Ciudad</b>";
              $html .= $fintd;

              $html .= $iniciotd."4".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>País</b>";
              $html .= $fintd;

              $html .= $iniciotd."4".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Provincia</b>";
              $html .= $fintd;
            $html .= $fintr;

            $html .= $iniciotr;

              $html .= $iniciotd."4".$tdstyle."text-align: center;".$tdinter;
              $html .= $datos['ciudad'];
              $html .= $fintd;

              $html .= $iniciotd."4".$tdstyle."text-align: center;".$tdinter;
              $html .= $datos['pais'];
              $html .= $fintd;

              $html .= $iniciotd."4".$tdstyle."text-align: center;".$tdinter;
              $html .= $datos['provincia'];
              $html .= $fintd;

            $html .= $fintr;

// --------------***************--------------------------
            $html .= $iniciotr;
              $html .= $iniciotd."12".$tdstyle."text-align: center; background-color: rgb(37, 58, 91); color: white;".$tdinter;
                $html .= "<h4>Datos de contacto</h4>";
              $html .= $fintd;
            $html .= $fintr;

// ------------------------------------------------------
            $html .= $iniciotr;
              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Correo</b>";
              $html .= $fintd;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Teléfono</b>";
              $html .= $fintd;
            $html .= $fintr;

            $html .= $iniciotr;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= $datos['correo'];
              $html .= $fintd;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= $datos['telefono'];
              $html .= $fintd;

            $html .= $fintr;

            $html .= $iniciotr;
              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Dni</b>";
              $html .= $fintd;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Teléfono convencional</b>";
              $html .= $fintd;
            $html .= $fintr;

            $html .= $iniciotr;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= $datos['dni'];
              $html .= $fintd;

              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= $datos['telefonoConvencional'];
              $html .= $fintd;

            $html .= $fintr;

// --------------***************--------------------------
            $html .= $iniciotr;
              $html .= $iniciotd."12".$tdstyle."text-align: center; background-color: rgb(37, 58, 91); color: white;".$tdinter;
                $html .= "<h4>Idiomas</h4>";
              $html .= $fintd;
            $html .= $fintr;
// -----------------------------------------------------
            $html .= $iniciotr;
              $html .= $iniciotd."12".$tdstyle."text-align: center;".$tdinter;
              $html.= "<br>";
                foreach ($datos['usuarioxnivelidioma'] as $key=>$value) {
                  $html.= "<span><b>".$key."</b> - ".$value[2]."</span><br>";
                }
                $html.= "<br>";
                $html.= "<br>";
              $html .= $fintd;
            $html .= $fintr;
// --------------***************--------------------------
            $html .= $iniciotr;
              $html .= $iniciotd."12".$tdstyle."text-align: center; background-color: rgb(37, 58, 91); color: white;".$tdinter;
                $html .= "<h4>Áreas de interés</h4>";
              $html .= $fintd;
            $html .= $fintr;

// -----------------------------------------------------
            $html .= $iniciotr;
              $html .= $iniciotd."12".$tdstyle."text-align: center;".$tdinter;
                foreach ($datos['usuarioxarea'] as $key => $value) {
                        $actual = $value;
                        $name = "";
                        foreach ($actual as $key2 => $value2) {
                          if($name != $value2['area']){
                            $name = $value2['area'];
                            $html.= "<br><h4 style='text-align: center;'>Área: ".$value2['area']."<br></h4>";
                          }
                        }
                        $html.= "<h4 style='text-align: center;'>Subáreas: </h4>";
                        foreach ($actual as $key1 => $value1) {
                          $html.= $value1['subarea']."<br>";
                        }
              }
              $html .= $fintd;
            $html .= $fintr;


        $html .= $fintbody;
        $html .= $finTabla;

        $cabecera = "imagenes/pdf/header.png";
        $piepagina = "imagenes/pdf/footer.png";
        $mpdf=new mPDF('','A4');
        $inidoc = "<!DOCTYPE html><html><link rel='stylesheet' href='css/informemic.css'>
                    <body><main>";
        $enddoc = "</main></body></body></html>";
        $mpdf->setHTMLHeader('<header><img src="'.$cabecera.'" width="17%"></header>'); 
        $mpdf->WriteHTML($inidoc);
        $mpdf->WriteHTML($enddoc);   
        $mpdf->setHTMLFooter('<footer><img src="'.$piepagina.'" width="17%"></footer>');
        $mpdf->WriteHTML($html);
        $mpdf->Output($datos['username'].".pdf", 'D');
        // self::informePersonalidad($html, );
  }
}
?>
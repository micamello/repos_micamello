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
      case 'generarFactura':
        $idFactura = Utils::desencriptar(Utils::getParam('idFactura','',$this->data));
        if(!empty($idFactura)){
          $consultaFactura = Modelo_Factura::obtenerFactura($idFactura,Modelo_Factura::AUTORIZADO);
          
          $obj_facturacion = new Proceso_Facturacion();
          $obj_facturacion->generarRIDE(utf8_encode($consultaFactura["xml"]),$consultaFactura['fecha_estado'],true);
        }
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
        if(!empty($id_oferta)){
          $existe_en_oferta = Modelo_Postulacion::obtienePostuladoxUsuario($idusuario,$id_oferta);
        }else{
          $existe_en_oferta = array();
        }
        if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA){          
          if(isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'descargarInformePerso',$idPlan) && !empty($id_oferta) && !empty($existe_en_oferta)){
            $id_empresa = $_SESSION['mfo_datos']['usuario']['id_usuario'];
            $posibilidades = Modelo_UsuarioxPlan::disponibilidadDescarga($id_empresa,$id_oferta);
            $descargas = Modelo_Descarga::descargasInforme($id_empresa,$id_oferta);
            
            if(!empty($posibilidades)){              
              if(in_array($idusuario, $descargas)){
                $puedeDescargar = true;
              }else{
                if(count($descargas) < $posibilidades){
                  Modelo_Descarga::registrarDescargaInforme($idusuario,$id_empresa,$id_oferta);
                  $puedeDescargar = true;
                }else{
                  $_SESSION['mostrar_notif'] = 'Usted no puede visualizar este informe porque ha superado el l\u00EDmite de descargas para esta oferta';
                  $enlace = $_SERVER['HTTP_REFERER'];
                  $puedeDescargar = false;
                  Utils::doRedirect($enlace);
                }
              }
            }else{              
              if(!in_array($idusuario, $descargas)){
                Modelo_Descarga::registrarDescargaInforme($idusuario,$id_empresa,$id_oferta);              
              }
              $puedeDescargar = true;
            }            
          }else{            
            $puedeDescargar = false;
            $_SESSION['mostrar_notif'] = 'Usted no tiene permiso para realizar esta acci\u00F3n, por favor adquiera un plan.';
            //$ruta = PUERTO . '://' . HOST . '/vacantes/';
          }
        }
        
        if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){          
          /*if(isset($_SESSION['mfo_datos']['planes']) && (Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'descargarInformePerso'))){                    
            $puedeDescargar = true;
          }else if(!isset($_SESSION['mfo_datos']['planes'])){
            $puedeDescargar = true;
          }else{ 
            $puedeDescargar = false;
            $_SESSION['mostrar_notif'] = 'Para conocer los resultados de su informe, por favor suscribase al PLAN GRATUITO o a un plan de pago. Su informe parcial lo puede descargar en su perfil';
            //$ruta = PUERTO . '://' . HOST . '/perfil/';
          } */
          $puedeDescargar = true;       
        }
        
        if(($idusuario == $_SESSION['mfo_datos']['usuario']['id_usuario'] && $puedeDescargar == true) || 
           ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA && $puedeDescargar == true)){                  
          
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
          $preguntas = Modelo_Respuesta::resultadoxUsuarioxCompetencia($idusuario,$idsfacetas);   
          $porcentajesxfaceta = Modelo_Usuario::obtenerFacetasxUsuario($idusuario,$idsfacetas);  
          $rasgos = Modelo_Rasgo::obtieneListadoAsociativo();
          $competencias = Modelo_Faceta::competenciasXfaceta();
          //print_r($porcentajesxfaceta); exit;
          //$colores = Modelo_Faceta::obtenerColoresLiterales();
          $facetasDescripcion = Modelo_Faceta::obtenerFacetas();
          $array_datos_graficos = array();
         
          if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){ 
            $informe = $this->generaInformeCandidato(array('datos'=>$usuario,'tipo_informe'=>$tipo_informe,'preguntas'=>$preguntas,'facetas'=>$facetasDescripcion,'datos_descarga'=>array('id_usuario'=>$idusuario,'id_empresa'=>$id_empresa,'id_oferta'=>$id_oferta,'puedeDescargar'=>$puedeDescargar),'porcentajesxfaceta'=>$porcentajesxfaceta,'rasgos'=>$rasgos,'facetasHabilitadas'=>explode(',',$idsfacetas),'competencias'=>$competencias));
          }else{
            $informe = $this->generaInforme(array('datos'=>$usuario,'tipo_informe'=>$tipo_informe,'preguntas'=>$preguntas,'facetas'=>$facetasDescripcion,'datos_descarga'=>array('id_usuario'=>$idusuario,'id_empresa'=>$id_empresa,'id_oferta'=>$id_oferta,'puedeDescargar'=>$puedeDescargar),'porcentajesxfaceta'=>$porcentajesxfaceta,'rasgos'=>$rasgos,'facetasHabilitadas'=>explode(',',$idsfacetas),'competencias'=>$competencias));
          }
        }else{
          
          $enlace = $_SERVER['HTTP_REFERER'];
          Utils::doRedirect($enlace);
        }
      break;
      case 'informeUsuarioCandidato':
        $usuario = Modelo_Usuario::existeUsuario($username);
        $idusuario = $usuario['id_usuario']; 
        $idPlan = Utils::getParam('idPlan','',$this->data);
        $idPlan = ((!empty($idPlan)) ? Utils::desencriptar($idPlan) : $idPlan);
        $id_oferta = Utils::getParam('idOferta','',$this->data);
        $id_oferta = ((!empty($id_oferta)) ? Utils::desencriptar($id_oferta) : $id_oferta);
        $puedeDescargar = false;
        $cantidadRestante = 1;
        $id_empresa = false;
        if(!empty($id_oferta)){
          $existe_en_oferta = Modelo_Postulacion::obtienePostuladoxUsuario($idusuario,$id_oferta);
        }else{
          $existe_en_oferta = array();
        }
        /*if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA){          
          if(isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'descargarInformePerso',$idPlan) && !empty($id_oferta) && !empty($existe_en_oferta)){
            $id_empresa = $_SESSION['mfo_datos']['usuario']['id_usuario'];
            $posibilidades = Modelo_UsuarioxPlan::disponibilidadDescarga($id_empresa,$id_oferta);
            $descargas = Modelo_Descarga::descargasInforme($id_empresa,$id_oferta);
            
            if(!empty($posibilidades)){              
              if(in_array($idusuario, $descargas)){
                $puedeDescargar = true;
              }else{
                if(count($descargas) < $posibilidades){
                  Modelo_Descarga::registrarDescargaInforme($idusuario,$id_empresa,$id_oferta);
                  $puedeDescargar = true;
                }else{
                  $_SESSION['mostrar_notif'] = 'Usted no puede visualizar este informe porque ha superado el l\u00EDmite de descargas para esta oferta';
                  $enlace = $_SERVER['HTTP_REFERER'];
                  $puedeDescargar = false;
                  Utils::doRedirect($enlace);
                }
              }
            }else{              
              if(!in_array($idusuario, $descargas)){
                Modelo_Descarga::registrarDescargaInforme($idusuario,$id_empresa,$id_oferta);              
              }
              $puedeDescargar = true;
            }            
          }else{            
            $puedeDescargar = false;
            $_SESSION['mostrar_notif'] = 'Usted no tiene permiso para realizar esta acci\u00F3n, por favor adquiera un plan.';
            //$ruta = PUERTO . '://' . HOST . '/vacantes/';
          }
        }*/
        
        if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){          
          /*if(isset($_SESSION['mfo_datos']['planes']) && (Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'descargarInformePerso'))){                    
            $puedeDescargar = true;
          }else if(!isset($_SESSION['mfo_datos']['planes'])){
            $puedeDescargar = true;
          }else{ 
            $puedeDescargar = false;
            $_SESSION['mostrar_notif'] = 'Para conocer los resultados de su informe, por favor suscribase al PLAN GRATUITO o a un plan de pago. Su informe parcial lo puede descargar en su perfil';
            //$ruta = PUERTO . '://' . HOST . '/perfil/';
          }  */  
          $puedeDescargar = true;      
        }
        
        if(/*$idusuario == $_SESSION['mfo_datos']['usuario']['id_usuario'] &&*/ $puedeDescargar == true){                  
          
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
          $preguntas = Modelo_Respuesta::resultadoxUsuarioxCompetencia($idusuario,$idsfacetas);   
          $porcentajesxfaceta = Modelo_Usuario::obtenerFacetasxUsuario($idusuario,$idsfacetas);  
          $rasgos = Modelo_Rasgo::obtieneListadoAsociativo();
          $competencias = Modelo_Faceta::competenciasXfaceta();

          $facetasDescripcion = Modelo_Faceta::obtenerFacetas();
          $array_datos_graficos = array();
         
          $informe = $this->generaInformeCandidato(array('datos'=>$usuario,'tipo_informe'=>$tipo_informe,'preguntas'=>$preguntas,'facetas'=>$facetasDescripcion,'datos_descarga'=>array('id_usuario'=>$idusuario,'id_empresa'=>$id_empresa,'id_oferta'=>$id_oferta,'puedeDescargar'=>$puedeDescargar),'porcentajesxfaceta'=>$porcentajesxfaceta,'rasgos'=>$rasgos,'facetasHabilitadas'=>explode(',',$idsfacetas),'competencias'=>$competencias));
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
    $competencias = $datos['competencias'];
  
    $datos_descarga = $datos['datos_descarga'];
    $conacentos = array('&aacute;', '&eacute;','&iacute;','&oacute;','&uacute;','&ntilde;');
    $sinacentos = array('a', 'e','i','o','u','n');
    $cambiar_letra = array('&aacute;', '&eacute;','&iacute;','&oacute;','&uacute;','&ntilde;');
    $codigo   = array('&aacute;', '&eacute;','&iacute;','&oacute;','&uacute;','&ntilde;');
    $nombre = strtolower($datosusuario['nombres'].' '.$datosusuario['apellidos']);    
    $nombre_archivo = utf8_encode(str_replace(' ', '_',Utils::no_carac($nombre))).'.pdf';
    //Utils::log("FERNANDA 2 ".$nombre_archivo);
    $nombre_mayuscula = strtoupper(Utils::no_carac($nombre));
    //Utils::log("FERNANDA 3 ".$nombre_mayuscula);
    $solo_nombres = strtoupper(str_replace($codigo,$conacentos,strtolower($datosusuario['nombres'])));
    //Utils::log("FERNANDA 4 ".$solo_nombre);
    $colores_bg = array('C'=>'verde-bg','A'=>'amarillo-bg','N'=>'rojo-bg','E'=>'morado-bg','A1'=>'azul-bg');
    $colores = array('C'=>'verde','A'=>'amarillo','N'=>'rojo','E'=>'morado','A1'=>'azul');
    $cantd_preg = 0;
    $pos_no_disponible = 1;
    $parrafo = $faceta = $porcentaje_faceta = $etiquetas_faceta = $colors = $descrip_facetas = $descrip_titulo = '';
    $puntaxfaceta = $horasbd = array();

    foreach ($porcentajesxfaceta as $c => $datos_resultado) {
      $puntaxfaceta[$datos_resultado['id_faceta']] = $datos_resultado['id_puntaje'];
      $etiquetas_faceta .= $facetas[$datos_resultado['id_faceta']]['literal'].': '.$datos_resultado['valor'].'|';
      $porcentajes_faceta .= $datos_resultado['valor'].',';
      $colors .= str_replace("#", "", $datos['colores'][$datos_resultado['id_faceta']]).'|';
      $colors_l .= str_replace("#", "", $datos['colores'][$datos_resultado['id_faceta']]).'|';
      $descrip_facetas .= $facetas[$datos_resultado['id_faceta']]['faceta'].': '.$datos_resultado['valor'].'|';
      $descrip_titulo .= $facetas[$datos_resultado['id_faceta']]['literal'];
      array_push($horasbd, $datos_resultado['tiempo']);
    }
    $etiquetas_faceta = substr($etiquetas_faceta, 0,-1);
    $colors = substr($colors, 0,-1);
    $descrip_facetas = substr($descrip_facetas, 0,-1);
    $porcentajes_faceta = substr($porcentajes_faceta, 0,-1);

    $informe = '<br><br><br><br>
    <div id="pagina-1">
      <h1>Informe ';
      if($tipo_informe == 'parcial'){
        $informe .= 'Parcial ';
      }
      $informe .= 'Por Competencias</h1>
      <br><br><br><br>
      <div style="text-align:center"><br><br><br><br><br>
      <img width="600" src="'.FRONTEND_RUTA.'imagenes/pdf/diseno.png" class="canea">
      </div><br><br><br><br><br>
      <div class="pg1">
        <p><b>NOMBRES Y APELLIDOS COMPLETOS:</b><br>'.$nombre_mayuscula.'</p>
        <p><b>FECHA DE EMISION: </b><br>'.date('Y-m-d').'</p>';
        if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA){ 
          $informe .= '<p><b>TIEMPO: </b><br>'.self::sumarHoras($horasbd).'</p>';
        }
      $informe .= '</div>
    </div> 
    <div style="page-break-after:always;"></div>
    <br>
    <div id="pagina-2" style="text-align:justify">';
      $informe .= '
      <blockquote>Tu talento es nuestra oportunidad.</blockquote>';
      if($tipo_informe == 'parcial'){
        $informe .= '<p>El presente informe parcial le da la oportunidad de que conozca &uacute;nicamente una importante faceta de su personalidad y ocho importantes competencias en su lugar de trabajo. <br></p>
        <p><b>CANEA</b> tiene mucho m&aacute;s que ofrecerle acerca de sus destrezas, habilidades y comportamientos. An&iacute;mese a encontrar su talento, y que las empresas descubran su potencial. Mejores sus oportunidades laborales.
        </p>
        <blockquote>
          <b>¡Sea siempre la primera opci&oacute;n para las empresas, rindiendo el test completo!</b>
        </blockquote>';
      }
      $informe .= '<h2>&iquest;QU&Eacute; ES CANEA?</h2>
      <p>Es un Test que tiene por objetivo evaluar las competencias laborales de los candidatos y facilitar el proceso de reclutamiento de las empresas. Se dise&ntilde;&oacute; para comprender las aptitudes de una persona y llevarla a lograr un desarrollo profesional.</p>';
      //$informe .= '<table class="tabla1" style="width:100%">
        //<tr>';
        $tds = $ths = $tds_competencias = '';
        $cantd_a = 0;
        foreach ($facetas as $id_faceta => $datos_facetas) {
          if($datos_facetas['literal'] == 'A' && $cantd_a > 1){
            $color = $colores_bg[$datos_facetas['literal'].'1'];
            $color1 = $colores[$datos_facetas['literal'].'1']; 
          }else{
            $color = $colores_bg[$datos_facetas['literal']];
            $color1 = $colores[$datos_facetas['literal']];
            $cantd_a++; 
          }
          //$informe .= '<th class="'.$color1.'">'.$datos_facetas['literal'].'</th>';
          $span = '<span class="mayor">'.$datos_facetas['literal'].'</span>';
          $ths .= '<th style="width: 150px" class="'.$color1.'">'.$datos_facetas['literal'].'</th>';
          $thss .= '<td class="'.$color.'" style="text-align:center;">'.utf8_encode(Utils::str_replace_first(strtolower($facetas[$id_faceta]['literal']), $span, $facetas[$id_faceta]['faceta'],1)).'</td>';
          //$span = '<span class="mayor">'.$datos_facetas['literal'].'</span>';
          //$tds .= '<td style="text-align:center;" class="'.$color.'">'.Utils::str_replace_first($datos_facetas['literal'], $span, strtoupper($datos_facetas['faceta']),1).'</td>';
          //if($pos_no_disponible < 3){
          //  $tds_competencias .= '<td style="text-align:center;">'.utf8_encode($competencias[$id_faceta]).'</td>';
          //  $pos_no_disponible++;
          //}else{
          //  if($tipo_informe == 'parcial'){
          //    $tds_competencias .= '<td style="text-align:center;font-size:12pt;" class="rojo"><b>no disponible</b></td>';
          //  }else{
          //    $tds_competencias .= '<td style="text-align:center;">'.utf8_encode($competencias[$id_faceta]).'</td>';
          //  }
          //}
        }
        $pos_no_disponible = 1;
        //$informe .= '</tr>
        //<tr>'.$tds.'</tr>
        //<tr>'.$tds_competencias.'</tr>
      //</table>';
    
      $datosXpreguntas = array(); 
      $caracteristicas_generales = array();
      $parrafo = '';
      foreach($preguntas as $id_competencia => $pregunta){
        $cantd_preg++;
        $resultado = Modelo_Baremo::obtienePuntaje($pregunta['orden1'],$pregunta['orden2'],$pregunta['orden3'],$pregunta['orden4'],$pregunta['orden5']);
        if($resultado['porcentaje'] >= 30){
          $datosXpreguntas[$id_competencia] = $resultado['porcentaje'];
        }
        $descriptor = Modelo_Descriptor::obtieneTextos($id_competencia,$resultado['id_puntaje']);       
        $parrafo .= $solo_nombres.' '.utf8_encode($descriptor['descripcion']).' ';
       
        if($cantd_preg == $preg_x_faceta){
          $cantd_preg = 0;
          $caracteristicas_generales[$pregunta['id_faceta']] = '<p align="justify">'.substr($parrafo, 0,-1).'</p>'; 
          $parrafo = '';
        }
      }
      $informe .= '<br><h2>&iquest;QU&eacute; SON LAS COMPETENCIAS LABORALES?</h2>
      <p>Estas se definen como el conjunto de conocimientos, destrezas, habilidades y comportamientos que contribuyen al desempe&ntilde;o y desarrollo individual en un puesto de trabajo.</p>
      <br><h2>&iquest;QU&eacute; ES EL COMPORTAMIENTO?</h2>
      <p>Es la habilidad de interactuar efectivamente con la gente, esta habilidad, puede ser el &eacute;xito o fracaso en su trabajo.</p> 
      <p>Las inventigaciones han demostrado que aquellas personas que se conocen m&aacute;s as&iacute; mismas, son m&aacute;s capaces de desarrollar y comprender sus fortalezas y debilidades.</p>
      <br><h2>INTRODUCCI&Oacute;N</h2>
      <p>Este informe se desarroll&oacute; para que conozcamos y entendamos de una forma m&aacute;s clara los comportamientos que determinan nuestra personalidad integral laboral.</p>';

      if($tipo_informe == 'parcial' && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){

        $informe .= '<div class="publicidad" style="background-color:#FFC000"><b>REGISTRESE EN NUESTRA PAGINA <a style="color:red" class="azul link" href="https://micamello.com.ec/" target="_blank">WWW.MICAMELLO.COM.EC</a>, PARA ELEVAR TUS OPORTUNIDADES DE OBTENER UN EMPLEO.</b></div>';
      }
    $informe .= '</div>
    <div style="page-break-after:always;"></div>
    <br>
    <div id="pagina-3" style="text-align:justify">
      <h2>CARACTER&Iacute;STICAS GENERALES DE COMPORTAMIENTO LABORAL</h2>';
      $informe .= '<p>Este informe analiz&oacute; la forma en que <b>'.$solo_nombres.'</b> hace las actividades y tareas y c&oacute;mo reacciona ante los retos que se presentan y se viven diariamente en su sitio de trabajo. Recuerde solo medimos comportamientos. Solo le ofrecemos afirmaciones positivas, en aquellas &aacute;reas de conductas en que la persona demuestra su estilo de comportamiento.</p>
        <p>El comportamiento es un lenguaje universal de &quot;como actuamos&quot;, o de nuestro comportamiento observable. En este test no existen resultados ni buenos, ni malos. Una vez que haya le&iacute;do el reporte, omita cualquier afirmaci&oacute;n que no parezca aplicar a su comportamiento.</p>
        <p>De acuerdo a las respuestas de <b>'.$solo_nombres.',</b> le presentamos descripciones generales de su forma de actuar en su trabajo, identificando la manera en que   prefiere realizar sus funciones.</p>';
      $pos_no_disponible = 1;
      $cantd_a = 0;
      foreach ($competencias as $id_faceta => $value) {
        $comp = explode(', ',$value);
        $color1 = '';
        //print_r($facetas[$id_faceta]['literal']);
        if($facetas[$id_faceta]['literal'] == 'A' && $cantd_a > 1){
          $color1 = $colores[$facetas[$id_faceta]['literal'].'1']; 
        }else{
          
          $color1 = $colores[$facetas[$id_faceta]['literal']];
          $cantd_a++; 
        }
        $span = '<span class="mayor '.$color1.'">'.$facetas[$id_faceta]['literal'].'</span>';
        if($pos_no_disponible < 3){
          $informe .= '<ul><li><b>'.utf8_encode(Utils::str_replace_first(strtolower($facetas[$id_faceta]['literal']), $span, $facetas[$id_faceta]['faceta'],1).': </b>'.$facetas[$id_faceta]['introduccion'].' Competencias que se evaluaron: '.$value).'</li></ul>';
          $informe .= $caracteristicas_generales[$id_faceta];
          $pos_no_disponible++;
        }else{
          if($tipo_informe == 'parcial'){
            $informe .= '<ul><li><b>'.utf8_encode(Utils::str_replace_first(strtolower($facetas[$id_faceta]['literal']), $span, $facetas[$id_faceta]['faceta'],1).': </b>'.$facetas[$id_faceta]['introduccion'].' Competencias que se evaluaron: '.$value.'. <b class="rojo">no disponible</b>').'</li></ul><br>';
          }else{
            $informe .= '<ul><li><b>'.utf8_encode(Utils::str_replace_first(strtolower($facetas[$id_faceta]['literal']), $span, $facetas[$id_faceta]['faceta'],1).': </b>'.$facetas[$id_faceta]['introduccion'].' Competencias que se evaluaron: '.$value).'</li></ul>';
            $informe .= $caracteristicas_generales[$id_faceta];
          }
        }
      }

      if($tipo_informe == 'parcial' && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){

        $informe .= '<div class="publicidad" style="background-color:#FFC000"><b>¡SEA UNA DE LAS PRIMERAS OPCIONES DE SELECCIÓN DE LAS EMPRESAS TERMINANDO EL TEST CANEA EN <a style="color:red" class="azul link" href="'.PUERTO . '://' . HOST . '/planes/'.'" target="_blank">WWW.MICAMELLO.COM.EC</a></b></div>';
      }
      $informe .= '
    </div>';
    $informe .= '<div style="page-break-after:always;"></div>
    <div id="pagina-4" style="text-align:justify">
      <h2>DESCRIPTORES</h2>';
  
      $informe .= '<p>Basado en las respuestas de <b>'.$solo_nombres.',</b> predominan las palabras que m&aacute;s describen su comportamiento cuando: resuelve  problemas y enfrenta desaf&iacute;os, influye en personas, responde al ritmo del ambiente,  reglas  y  procedimientos impuestos. </p>
      <center>
        <table class="tabla2">
          <tr>
            <th style="height: 35px;"colspan="5">DESCRIPTORES</th>
          </tr>
          <tr>
            '.$ths.'
          </tr><tr>
            '.$thss.'
          </tr>';
      $pos_no_disponible = 1;
      $informe .= '<tr>';
      foreach ($facetas as $id_faceta => $value) {
      
        if(in_array($id_faceta, $datos['facetasHabilitadas'])){
          $informe .= '<td>';
          foreach ($rasgos[$id_faceta][$puntaxfaceta[$id_faceta]] as $key => $r) {
            $informe .= '<br>'.utf8_encode($r);
          }
          $informe .= '</td>';
        }else{
          if($pos_no_disponible <= 3 && $tipo_informe == 'parcial'){
            $informe .= '<td class="rojo"><b>no disponible</b></td>';
            $pos_no_disponible++;
          }else{
            $informe .= '<td></td>';
          }
        }
      }
      $informe .= '</tr></table>';

      if($tipo_informe == 'parcial' && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){

        $informe .= '<br><div class="publicidad" style="background-color:#FFC000"><b>¿DESEA OBTENER MEJORES RESULTADOS? COMPLETE EL TEST CANEA INGRESANDO A <a style="color:red" class="azul link" href="'.PUERTO . '://' . HOST . '/planes/'.'" target="_blank">WWW.MICAMELLO.COM.EC</a></b></div>';
      }
      $informe .= '</center></div><div style="page-break-after:always;"></div>
      <br>
      <div id="pagina-5" style="text-align:justify">
        <h2>ESTILO PERSONALIZADO</h2>';
      $informe .= '<p><b>'.$solo_nombres.'</b> le estamos proporcionando un resumen de s&iacute; mismo. Comprender esta secci&oacute;n le ayudar&aacute; a proyectar una imagen para controlar posibles situaciones. <b>Una vez que haya le&iacute;do el reporte, omita cualquier afirmaci&oacute;n que no parezca aplicar a su comportamiento.</b></p>
      <center>
        <table class="tabla-3">';
      $cantd_a = 0;
      foreach ($porcentajesxfaceta as $k => $valores) {
        
        $l = $facetas[$valores['id_faceta']]['literal'];
        if($l == 'A' && $cantd_a > 1){
          $color = $colores_bg[$l.'1']; 
        }else{
          $color = $colores_bg[$l];
          $cantd_a++; 
        }
        
        $d = strtoupper($facetas[$valores['id_faceta']]['faceta']);
        $informe .= '<tr>
          <td class="'.$color.'" style="text-align: center; font-size: 11pt; font-weight: bold; text-transform: uppercase;
      padding-top: 25px; padding-left: 40px; padding-bottom: 25px; padding-right: 40px;">'.utf8_encode($l.'/'.$d).'
          </td>
          <td style="background-color: #c9c9c9; width: 500px; padding: 5px 20px;">
          '.str_replace('_NOMBRE_',$solo_nombres,utf8_encode($valores['descripcion'])).'
          </td>
        </tr><tr><td></td></tr>';
      }

      if(count($porcentajesxfaceta) == 2){
        $cantd_a = 0;
        $cantd_facetas = 0;
        foreach ($facetas as $identificador => $f) {

          if($cantd_facetas >= 2){
            $l = $f['literal'];
            if($l == 'A' && $cantd_a > 1){
              $color = $colores_bg[$l.'1']; 
            }else{
              $color = $colores_bg[$l];
              $cantd_a++; 
            }
            
            $d = strtoupper($f['faceta']);

            $informe .= '<tr>
              <td class="'.$color.'" style="text-align: center; font-size: 11pt; font-weight: bold; text-transform: uppercase;
          padding-top: 25px; padding-left: 40px; padding-bottom: 25px; padding-right: 40px;">'.utf8_encode($l.'/'.$d).'
              </td>
              <td style="background-color: #c9c9c9; color:red; width: 500px; padding: 5px 20px;">
              <b>NO DISPONIBLE</b>
              </td>
            </tr><tr><td></td></tr>';
          }else{
            $cantd_facetas++;
          }
        }
      }
      
      $informe .= '</table>';
      if($tipo_informe == 'parcial' && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){
        $informe .= '<br>
        <div class="publicidad" style="background-color:#FFC000"><b>RECUERDE INGRESAR A <a style="color:red" class="azul link" href="https://micamello.com.ec/" target="_blank">WWW.MICAMELLO.COM.EC</a>, para completar su informe. ¡SE UNA DE LAS PRIMERAS OPCIONES EN LA EMPRESA!</b></div>';
      }
      $informe .= '</center>
      </div><div style="page-break-after:always;"></div>
      
      <div id="pagina-6" style="text-align:justify">
        <h2>JERARQU&iacute;A DE COMPETENCIAS</h2>';
      $informe .= '
      <p>Las gr&aacute;ficas de jerarqu&iacute;a mostrar&aacute;n por orden sus competencias de trabajo. Le ayudar&aacute; a entender en cuales de estas competencias ser&aacute; m&aacute;s productivo.</p><p>Nota: el porcentaje representado debajo del asterisco (*) representa la media poblacional de cada competencia.</p>';
      $cantd_salto = 6;
      //aqui
      arsort($datosXpreguntas);
      $key = 0;
      $cantd_preg = 0;
      $cantd_hoja_total = round(count($datosXpreguntas)/6)-1;
      $cantd_hoja = 1;
      foreach ($datosXpreguntas as $id_competencia => $resultado) {
        $pregunta = $preguntas[$id_competencia];
        $cantd_preg++;
        $informe .= '<p><b>'.($key + 1).'. '.str_replace($cambiar_letra,$conacentos,strtoupper(utf8_encode($pregunta['nombre']))).' -</b> '.utf8_encode($pregunta['descripcion']).' </p>';
       
        $key++;
        $informe .= '<table class="demo">
          <tbody>
            <tr>
              <th colspan="2">0</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th colspan="3">10</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th colspan="3">20</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th colspan="3">30</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th colspan="3">40</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th colspan="3">50</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th colspan="3">60</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th colspan="3">70</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th colspan="3">80</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th colspan="3">90</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th colspan="3" width="100">100</th>
              <th class="porcentaje" rowspan="3"><span>'.number_format($resultado, 2, '.', ',').'</span></th>
            </tr>
            <tr id="borde_barra">';
            $porcentaje = round($resultado); //43
            $limite_inferior = round($pregunta['limite_inferior']); //53
            $limite_medio = round($pregunta['limite_medio']);//62
            $limite_superior = round($pregunta['limite_superior']); //71
            if($porcentaje >= $limite_medio){
              $punto_medio = ($porcentaje - $limite_medio); //-19
              $part1 = $porcentaje - $punto_medio - 1;
              $part2 = $porcentaje - $limite_medio; 
              $part3 = 100 - $porcentaje;

              $part2 = '<td colspan="1" align="center" class="pintar-azul color_asterisco">*</td>
                <td colspan="'.$part2.'" class="pintar-azul"></td>
                <td class="fin" style="padding-left:50px;" colspan="'.$part3.'">&nbsp;</td>';
            }else{
              $part1 = $porcentaje;
              $part2 = $limite_medio - $porcentaje - 1; 
              $part3 = 100 - $limite_medio;
              $part2 = '<td colspan="'.$part2.'">&nbsp;</td>
              <td colspan="1" align="center" class="color_asterisco">*</td>
              <td class="fin" colspan="'.$part3.'">&nbsp;</td>';
            }
            $informe .= '<td colspan="'.$part1.'" class="pintar-azul"></td>
              '.$part2.'
            </tr>
            <tr style="font-size:12px;">';
            
            for ($i=1; $i <= 100; $i++) { 
              if($i >= $limite_inferior && $i <= $limite_superior){
                $informe .= '<td class="pintar-celeste">';
                if($i == $limite_medio){
                  $informe .= $pregunta['limite_medio'];
                }
                $informe .= '</td>';
              }else{
                $informe .= '<td>&nbsp;</td>';
              }
            }
            $informe .= '</tr>
          </tbody>
        </table>';
        if($cantd_salto == $cantd_preg && $cantd_hoja <= $cantd_hoja_total){
          $informe .= '<div style="page-break-after:always;"></div><br>';
          $cantd_salto++;
          $cantd_hoja++;
          $cantd_preg = 0;
        }
      }
      $informe .=  '</div>';
      if($tipo_informe == 'parcial' && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){
        $informe .= '<br><br>
        <div class="publicidad" style="background-color:#FFC000"><b>¡ELEVE SUS OPORTUNIDADES DE OBTENER UN MEJOR EMPLEO! COMPLETE EL TEST CANEA INGRESANDO A <a style="color:red" class="azul link" href="'.PUERTO . '://' . HOST . '/planes/'.'" target="_blank">WWW.MICAMELLO.COM.EC</a>. Y POTENCIE SUS FORTALEZAS.</b></div>';

      }else if($tipo_informe != 'parcial'){

        $informe .= '<div style="page-break-after:always;"></div><br><br><div>
          <h2>resumen canea</h2>
          <h1 style="text-align: left; display: block"><span class="verde">C</span><span class="amarillo">A</span><span class="rojo">N</span><span class="morado">E</span><span class="azul">A</span></h1>
        </div>';
      
        if(count($porcentajesxfaceta) == count($facetas)){
          $informe .= '<p align="center"><img width="600" heigth="600" align="center" src="'.$datosusuario['grafico'].'">';
          $porcentajes_faceta = explode(",",  $porcentajes_faceta);
          $informe .= '<table style="font-size:18px" class="tabla-canea">
              <tr>
                <td style="background-color:#5EB782; text-align:center" class="bloq-canea">C</td>
                <td class="bloq">Hacer '.$porcentajes_faceta[0].'%</td>
                <td style="background-color:#FCDC59; text-align:center" class="bloq-canea">A</td>
                <td class="bloq">Relaciones Interpersonales '.$porcentajes_faceta[1].'%</td>
                <td style="background-color:#E25050; text-align:center" class="bloq-canea">N</td>
                <td class="bloq">Inteligencia Emocional '.$porcentajes_faceta[2].'%</td>
              </tr>
              <tr>
                <td style="background-color:#8C4DCE; text-align:center" class="bloq-canea">E</td>
                <td class="bloq">Asertividad / Comunicación '.$porcentajes_faceta[3].'%</td>
                <td style="background-color:#2B8DC9; text-align:center" class="bloq-canea">A</td>
                <td class="bloq">Pensar '.$porcentajes_faceta[4].'%</td>
                <td class="bloq-canea"></td>
                <td class="bloq"></td>
              </tr>
          </table></p>';
        }
      }
    //echo $informe;    
    self::informePersonalidad($informe,$nombre_archivo,$datos_descarga);
  }

  /*public function generaInformeCandidato($datos){

    $facetas = $datos['facetas'];
    $tipo_informe = $datos['tipo_informe'];
    $preg_x_faceta = Modelo_Pregunta::totalPregXfaceta()['cantd_preguntas'];
    $datosusuario = $datos['datos'];
    $preguntas = $datos['preguntas'];
    $porcentajesxfaceta = $datos['porcentajesxfaceta'];
    $rasgos = $datos['rasgos'];
    $competencias = $datos['competencias'];

    $datos_descarga = $datos['datos_descarga'];
    $conacentos = array('&aacute;', '&eacute;','&iacute;','&oacute;','&uacute;','&ntilde;');
    $sinacentos = array('a', 'e','i','o','u','n');
    $cambiar_letra = array('&aacute;', '&eacute;','&iacute;','&oacute;','&uacute;','&ntilde;');
    $codigo   = array('&aacute;', '&eacute;','&iacute;','&oacute;','&uacute;','&ntilde;');
    $nombre = strtolower($datosusuario['nombres'].' '.$datosusuario['apellidos']);    
    $nombre_archivo = utf8_encode(str_replace(' ', '_',Utils::no_carac($nombre))).'.pdf';
    $nombre_mayuscula = strtoupper(Utils::no_carac($nombre));
    $solo_nombres = strtoupper(str_replace($codigo,$conacentos,strtolower($datosusuario['nombres'])));

    $colores_bg = array('C'=>'verde-bg','A'=>'amarillo-bg','N'=>'rojo-bg','E'=>'morado-bg','A1'=>'azul-bg');
    $colores = array('C'=>'verde','A'=>'amarillo','N'=>'rojo','E'=>'morado','A1'=>'azul');
    $cantd_preg = 0;
    $pos_no_disponible = 1;
    $parrafo = $faceta = $porcentaje_faceta = $etiquetas_faceta = $colors = $descrip_facetas = $descrip_titulo = '';
    $puntaxfaceta = array();
    foreach ($porcentajesxfaceta as $c => $datos_resultado) {
      $puntaxfaceta[$datos_resultado['id_faceta']] = $datos_resultado['id_puntaje'];
      $etiquetas_faceta .= $facetas[$datos_resultado['id_faceta']]['literal'].': '.$datos_resultado['valor'].'|';
      $porcentajes_faceta .= $datos_resultado['valor'].',';
      $colors .= str_replace("#", "", $datos['colores'][$datos_resultado['id_faceta']]).'|';
      $colors_l .= str_replace("#", "", $datos['colores'][$datos_resultado['id_faceta']]).'|';
      $descrip_facetas .= $facetas[$datos_resultado['id_faceta']]['faceta'].': '.$datos_resultado['valor'].'|';
      $descrip_titulo .= $facetas[$datos_resultado['id_faceta']]['literal'];
    }
    $etiquetas_faceta = substr($etiquetas_faceta, 0,-1);
    $colors = substr($colors, 0,-1);
    $descrip_facetas = substr($descrip_facetas, 0,-1);
    $porcentajes_faceta = substr($porcentajes_faceta, 0,-1);
    $informe = '<br><br><br><br>
    <div id="pagina-1">
      <h1>Informe ';
      if($tipo_informe == 'parcial'){
        $informe .= 'Parcial ';
      }
      $informe .= 'Por Competencias</h1>
      <br><br><br><br>
      <div style="text-align:center"><br><br><br><br><br>
      <img width="600" src="'.FRONTEND_RUTA.'imagenes/pdf/diseno.png" class="canea">
      </div><br><br><br><br><br><br><br>
      <div class="pg1">
        <p><b>NOMBRES Y APELLIDOS COMPLETOS:</b><br>'.$nombre_mayuscula.'</p>
        <p><b>FECHA DE EMISION: </b><br>'.date('Y-m-d').'</p>
      </div>
    </div> 
    <div style="page-break-after:always;"></div>
    <br>
    <div id="pagina-2" style="text-align:justify">';
      
      if($tipo_informe == 'parcial'){
        
        $informe .= '<blockquote>
          <b>¡Sea siempre la primera opci&oacute;n para las empresas, rindiendo el test completo!</b>
        </blockquote>';
      }else{
        $informe .= '<blockquote>Tu talento es nuestra oportunidad.</blockquote>';
      }
      $informe .= '<h2>&iquest;QU&Eacute; ES CANEA?</h2>
      <p>Es un Test que tiene por objetivo evaluar las competencias laborales de los candidatos y facilitar el proceso de reclutamiento de las empresas. Se dise&ntilde;&oacute; para comprender las aptitudes de una persona y llevarla a lograr un desarrollo profesional.</p>';

      $tds = $ths = $tds_competencias = '';
      $cantd_a = 0;
      foreach ($facetas as $id_faceta => $datos_facetas) {
        if($datos_facetas['literal'] == 'A' && $cantd_a > 1){
          $color = $colores_bg[$datos_facetas['literal'].'1'];
          $color1 = $colores[$datos_facetas['literal'].'1']; 
        }else{
          $color = $colores_bg[$datos_facetas['literal']];
          $color1 = $colores[$datos_facetas['literal']];
          $cantd_a++; 
        }

        $span = '<span class="mayor">'.$facetas[$id_faceta]['literal'].'</span>';
        $ths .= '<th style="width: 150px" class="'.$color1.'">'.$datos_facetas['literal'].'</th>';
        $thss .= '<td class="'.$color.'" style="text-align:center;">'.utf8_encode(Utils::str_replace_first(strtolower($facetas[$id_faceta]['literal']), $span, $facetas[$id_faceta]['faceta'],1)).'</td>';
      }
      //$pos_no_disponible = 1;
    
      $datosXpreguntas = array(); 
      $caracteristicas_generales = array();
      $parrafo = '';
      foreach($preguntas as $id_competencia => $pregunta){
        $cantd_preg++;
        $resultado = Modelo_Baremo::obtienePuntaje($pregunta['orden1'],$pregunta['orden2'],$pregunta['orden3'],$pregunta['orden4'],$pregunta['orden5']);
        if($resultado['porcentaje'] >= 30){
          $datosXpreguntas[$id_competencia] = $resultado['porcentaje'];
        }
        $descriptor = Modelo_Descriptor::obtieneTextos($id_competencia,$resultado['id_puntaje']);       
        $parrafo .= $solo_nombres.' '.utf8_encode($descriptor['descripcion']).' ';
       
        if($cantd_preg == $preg_x_faceta){
          $cantd_preg = 0;
          $caracteristicas_generales[$pregunta['id_faceta']] = '<p align="justify">'.substr($parrafo, 0,-1).'</p>'; 
          $parrafo = '';
        }
      }
      $informe .= '<br><h2>INTRODUCCI&Oacute;N</h2>
      <p>Este informe se desarroll&oacute; para que conozcamos y entendamos de una forma m&aacute;s clara los comportamientos que determinan nuestra personalidad integral laboral.</p>

      <p>El comportamiento es un lenguaje universal de &quot;como actuamos&quot;, o de nuestro comportamiento observable. <b>En este test no existen resultados ni buenos, ni malos</b>. Una vez que haya le&iacute;do el reporte, omita cualquier afirmaci&oacute;n que no parezca aplicar a su comportamiento.</p>
    ';
      if($tipo_informe == 'parcial'){
        $informe .= '<div class="publicidad">REGISTRESE EN NUESTRA PAGINA <a style="color:red" class="azul link" href="https://micamello.com.ec/" target="_blank">WWW.MICAMELLO.COM.EC</a>, PARA ELEVAR TUS OPORTUNIDADES DE OBTENER UN EMPLEO.</div>';
      }
    $informe .= '</div>
    <div style="page-break-after:always;"></div>
    <br>
    <div id="pagina-3" style="text-align:justify">
      <h2>CARACTER&Iacute;STICAS GENERALES DE COMPORTAMIENTO LABORAL</h2>';
      $informe .= '<p>Este informe analiz&oacute; la forma en que <b>'.$solo_nombres.'</b> hace las actividades y tareas y c&oacute;mo reacciona ante los retos que se presentan y se viven diariamente en su sitio de trabajo. Recuerde solo medimos comportamientos. Solo le ofrecemos afirmaciones positivas, en aquellas &aacute;reas de conductas en que la persona demuestra su estilo de comportamiento.</p>
        ';
      $pos_no_disponible = 1;
      $cantd_a = 0;
      foreach ($competencias as $id_faceta => $value) {
        $comp = explode(', ',$value);
        $color1 = '';
        //print_r($facetas[$id_faceta]['literal']);
        if($facetas[$id_faceta]['literal'] == 'A' && $cantd_a > 1){
          $color1 = $colores[$facetas[$id_faceta]['literal'].'1']; 
        }else{
          
          $color1 = $colores[$facetas[$id_faceta]['literal']];
          $cantd_a++; 
        }
        $span = '<span class="mayor '.$color1.'">'.$facetas[$id_faceta]['literal'].'</span>';
        if($pos_no_disponible < 3){
          $informe .= '<ul><li><b>'.utf8_encode(Utils::str_replace_first(strtolower($facetas[$id_faceta]['literal']), $span, $facetas[$id_faceta]['faceta'],1).': </b>'.$facetas[$id_faceta]['introduccion'].' ('.$comp[0]).')</li></ul>';
          //$informe .= $caracteristicas_generales[$id_faceta];
          $pos_no_disponible++;
        }else{
          if($tipo_informe == 'parcial'){
            $informe .= '<ul><li><b>'.utf8_encode(Utils::str_replace_first(strtolower($facetas[$id_faceta]['literal']), $span, $facetas[$id_faceta]['faceta'],1).': </b>'.$facetas[$id_faceta]['introduccion'].' ('.$comp[0].'). <b class="rojo">no disponible</b>').'</li></ul><br>';
          }else{
            $informe .= '<ul><li><b>'.utf8_encode(Utils::str_replace_first(strtolower($facetas[$id_faceta]['literal']), $span, $facetas[$id_faceta]['faceta'],1).': </b>'.$facetas[$id_faceta]['introduccion'].' ('.$comp[0]).')</li></ul>';
            //$informe .= $caracteristicas_generales[$id_faceta];
          }
        }
      }
      if($tipo_informe == 'parcial'){
        $informe .= '<div class="publicidad">VISITE NUESTRA PAGINA <a style="color:red" class="azul link" href="https://micamello.com.ec/" target="_blank">WWW.MICAMELLO.COM.EC</a>, PARA QUE LAS EMPRESAS CONOZCAN TU TALENTO</div>';
      }
      $informe .= '
    </div>';
    $informe .= '<div style="page-break-after:always;"></div>
    <div id="pagina-4" style="text-align:justify">
      <h2>DESCRIPTORES</h2>';
  
      $informe .= '<p>Basado en las respuestas de <b>'.$solo_nombres.',</b> predominan las palabras que m&aacute;s describen su comportamiento cuando: resuelve  problemas y enfrenta desaf&iacute;os, influye en personas, responde al ritmo del ambiente,  reglas  y  procedimientos impuestos. </p>
      <center>
        <table class="tabla2">
          <tr>
            <th style="height: 35px;"colspan="5">DESCRIPTORES</th>
          </tr>
          <tr>
            '.$ths.'
          </tr><tr>
            '.$thss.'
          </tr>';
      $pos_no_disponible = 1;
      $informe .= '<tr>';
      foreach ($facetas as $id_faceta => $value) {
      
        if(in_array($id_faceta, $datos['facetasHabilitadas'])){
          $informe .= '<td>';
          foreach ($rasgos[$id_faceta][$puntaxfaceta[$id_faceta]] as $key => $r) {
            $informe .= '<br>'.utf8_encode($r);
          }
          $informe .= '</td>';
        }else{
          if($pos_no_disponible <= 3 && $tipo_informe == 'parcial'){
            $informe .= '<td class="rojo"><b>no disponible</b></td>';
            $pos_no_disponible++;
          }else{
            $informe .= '<td></td>';
          }
        }
      }
      $informe .= '</tr></table>';
      if($tipo_informe == 'parcial'){
        $informe .= '<br><div class="publicidad">INGRESA EN EL LINK <a class="azul link" href="https://micamello.com.ec/" target="_blank">WWW.MICAMELLO.COM.EC</a>, PARA OBTENER MEJORES BENEFICIOS.</div>';
      }

      $informe .= '</center></div><div style="page-break-after:always;"></div>
      <br>
      <div id="pagina-5" style="text-align:justify">
        <h2>ESTILO PERSONALIZADO</h2>';
      $informe .= '<p><b>'.$solo_nombres.'</b> le estamos proporcionando un resumen de s&iacute; mismo. Comprender esta secci&oacute;n le ayudar&aacute; a proyectar una imagen para controlar posibles situaciones. <b>Una vez que haya le&iacute;do el reporte, omita cualquier afirmaci&oacute;n que no parezca aplicar a su comportamiento.</b></p>
      <center>
        <table class="tabla-3">';
      $cantd_a = 0;
      foreach ($porcentajesxfaceta as $k => $valores) {
        
        $l = $facetas[$valores['id_faceta']]['literal'];
        if($l == 'A' && $cantd_a > 1){
          $color = $colores_bg[$l.'1']; 
        }else{
          $color = $colores_bg[$l];
          $cantd_a++; 
        }
        
        $d = strtoupper($facetas[$valores['id_faceta']]['faceta']);
        $informe .= '<tr>
          <td class="'.$color.'" style="text-align: center; font-size: 11pt; font-weight: bold; text-transform: uppercase;
      padding-top: 25px; padding-left: 40px; padding-bottom: 25px; padding-right: 40px;">'.utf8_encode($l.'/'.$d).'
          </td>
          <td style="background-color: #c9c9c9; width: 500px; padding: 5px 20px;">
          '.str_replace('_NOMBRE_',$solo_nombres,utf8_encode($valores['descripcion'])).'
          </td>
        </tr><tr><td></td></tr>';
      }

      if(count($porcentajesxfaceta) == 2){
        $cantd_a = 0;
        $cantd_facetas = 0;
        foreach ($facetas as $identificador => $f) {

          if($cantd_facetas >= 2){
            $l = $f['literal'];
            if($l == 'A' && $cantd_a > 1){
              $color = $colores_bg[$l.'1']; 
            }else{
              $color = $colores_bg[$l];
              $cantd_a++; 
            }
            
            $d = strtoupper($f['faceta']);

            $informe .= '<tr>
              <td class="'.$color.'" style="text-align: center; font-size: 11pt; font-weight: bold; text-transform: uppercase;
          padding-top: 25px; padding-left: 40px; padding-bottom: 25px; padding-right: 40px;">'.utf8_encode($l.'/'.$d).'
              </td>
              <td style="background-color: #c9c9c9; color:red; width: 500px; padding: 5px 20px;">
              <b>NO DISPONIBLE</b>
              </td>
            </tr><tr><td></td></tr>';
          }else{
            $cantd_facetas++;
          }
        }
      }
      $informe .= '</table>';
      if($tipo_informe == 'parcial'){
        $informe .= '<br>
        <div class="publicidad">Recuerde ingresar a <a class="azul link" href="https://micamello.com.ec/" target="_blank">WWW.MICAMELLO.COM.EC</a>, para completar su informe. ¡SE UNA DE LAS PRIMERAS OPCIONES EN LA EMPRESA!</div>';
      }
      $informe .= '</center>
      </div><div style="page-break-after:always;"></div>';

      $informe .=  '</div>';
      if($tipo_informe == 'parcial'){
        $informe .= '<br><br>
        <div class="publicidad"><b>¡PARA CONOCER MAS DE SUS COMPETENCIAS LABORALES, FORTALEZAS, OPORTUNIDADES DE MEJORA Y ADQUIRIR UN INFORME COMPLETO INGRESE A <a class="azul link" href="https://micamello.com.ec/" target="_blank">WWW.MICAMELLO.COM.EC</a>!</b></div>';
      }else{
        $informe .= '<div style="page-break-after:always;"></div><br><br><div>
          <h2>resumen canea</h2>
          <h1 style="text-align: left; display: block"><span class="verde">C</span><span class="amarillo">A</span><span class="rojo">N</span><span class="morado">E</span><span class="azul">A</span></h1>
        </div>';
      }
      if(count($porcentajesxfaceta) == count($facetas)){
        $informe .= '<p align="center"><img width="600" heigth="600" align="center" src="'.$datosusuario['grafico'].'">';
        $porcentajes_faceta = explode(",",  $porcentajes_faceta);
        $informe .= '<table style="font-size:18px" class="tabla-canea">
            <tr>
              <td style="background-color:#5EB782; text-align:center" class="bloq-canea">C</td>
              <td class="bloq">Hacer '.$porcentajes_faceta[0].'%</td>
              <td style="background-color:#FCDC59; text-align:center" class="bloq-canea">A</td>
              <td class="bloq">Relaciones Interpersonales '.$porcentajes_faceta[1].'%</td>
              <td style="background-color:#E25050; text-align:center" class="bloq-canea">N</td>
              <td class="bloq">Estabilidad Emocional '.$porcentajes_faceta[2].'%</td>
            </tr>
            <tr>
              <td style="background-color:#8C4DCE; text-align:center" class="bloq-canea">E</td>
              <td class="bloq">Asertividad '.$porcentajes_faceta[3].'%</td>
              <td style="background-color:#2B8DC9; text-align:center" class="bloq-canea">A</td>
              <td class="bloq">Pensar '.$porcentajes_faceta[4].'%</td>
              <td class="bloq-canea"></td>
              <td class="bloq"></td>
            </tr>
        </table></p>';
      }
      //echo $informe;    
      self::informePersonalidad($informe,$nombre_archivo,$datos_descarga);
  }*/

  public function generaInformeCandidato($datos){

    $facetas = $datos['facetas'];
    $tipo_informe = $datos['tipo_informe'];
    $preg_x_faceta = Modelo_Pregunta::totalPregXfaceta()['cantd_preguntas'];
    $datosusuario = $datos['datos'];
    $preguntas = $datos['preguntas'];
    $porcentajesxfaceta = $datos['porcentajesxfaceta'];
    $rasgos = $datos['rasgos'];
    $competencias = $datos['competencias'];
  
    $datos_descarga = $datos['datos_descarga'];
    $conacentos = array('&aacute;', '&eacute;','&iacute;','&oacute;','&uacute;','&ntilde;');
    $sinacentos = array('a', 'e','i','o','u','n');
    $cambiar_letra = array('&aacute;', '&eacute;','&iacute;','&oacute;','&uacute;','&ntilde;');
    $codigo   = array('&aacute;', '&eacute;','&iacute;','&oacute;','&uacute;','&ntilde;');
    $nombre = strtolower($datosusuario['nombres'].' '.$datosusuario['apellidos']);    
    $nombre_archivo = utf8_encode(str_replace(' ', '_',Utils::no_carac($nombre))).'.pdf';
    $nombre_mayuscula = strtoupper(Utils::no_carac($nombre));
    $solo_nombres = strtoupper(str_replace($codigo,$conacentos,strtolower($datosusuario['nombres'])));
    $colores_bg = array('C'=>'verde-bg','A'=>'amarillo-bg','N'=>'rojo-bg','E'=>'morado-bg','A1'=>'azul-bg');
    $colores = array('C'=>'verde','A'=>'amarillo','N'=>'rojo','E'=>'morado','A1'=>'azul');
    $cantd_preg = 0;
    $pos_no_disponible = 1;
    $parrafo = $faceta = $porcentaje_faceta = $etiquetas_faceta = $colors = $descrip_facetas = $descrip_titulo = '';
    $puntaxfaceta = $horasbd = array();

    foreach ($porcentajesxfaceta as $c => $datos_resultado) {
      $puntaxfaceta[$datos_resultado['id_faceta']] = $datos_resultado['id_puntaje'];
      $etiquetas_faceta .= $facetas[$datos_resultado['id_faceta']]['literal'].': '.$datos_resultado['valor'].'|';
      $porcentajes_faceta .= $datos_resultado['valor'].',';
      $colors .= str_replace("#", "", $datos['colores'][$datos_resultado['id_faceta']]).'|';
      $colors_l .= str_replace("#", "", $datos['colores'][$datos_resultado['id_faceta']]).'|';
      $descrip_facetas .= $facetas[$datos_resultado['id_faceta']]['faceta'].': '.$datos_resultado['valor'].'|';
      $descrip_titulo .= $facetas[$datos_resultado['id_faceta']]['literal'];
      array_push($horasbd, $datos_resultado['tiempo']);
    }
    $etiquetas_faceta = substr($etiquetas_faceta, 0,-1);
    $colors = substr($colors, 0,-1);
    $descrip_facetas = substr($descrip_facetas, 0,-1);
    $porcentajes_faceta = substr($porcentajes_faceta, 0,-1);

    $informe = '<br><br><br><br>
    <div id="pagina-1">
      <h1>Informe ';
      if($tipo_informe == 'parcial'){
        $informe .= 'Parcial ';
      }
      $informe .= 'Por Competencias</h1>
      <br><br><br><br>
      <div style="text-align:center"><br><br><br><br><br>
      <img width="600" src="'.FRONTEND_RUTA.'imagenes/pdf/diseno.png" class="canea">
      </div><br><br><br><br><br>
      <div class="pg1">
        <p><b>NOMBRES Y APELLIDOS COMPLETOS:</b><br>'.$nombre_mayuscula.'</p>
        <p><b>FECHA DE EMISION: </b><br>'.date('Y-m-d').'</p>';
        if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA){ 
          $informe .= '<p><b>TIEMPO: </b><br>'.self::sumarHoras($horasbd).'</p>';
        }
      $informe .= '</div>
    </div> 
    <div style="page-break-after:always;"></div>
    <br>
    <div id="pagina-2" style="text-align:justify">';
      $informe .= '
      <blockquote>Tu talento es nuestra oportunidad.</blockquote>';
      if($tipo_informe == 'parcial'){
        $informe .= '<p>El presente informe parcial le da la oportunidad de que conozca &uacute;nicamente dos importantes facetas de su personalidad y ocho importantes competencias en su lugar de trabajo. <br></p>
        <p><b>CANEA</b> tiene mucho m&aacute;s que ofrecerle acerca de sus destrezas, habilidades y comportamientos. An&iacute;mese a encontrar su talento, y que las empresas descubran su potencial. Mejores sus oportunidades laborales.
        </p>
        <blockquote>
          <b>¡Sea siempre la primera opci&oacute;n para las empresas, rindiendo el test completo!</b>
        </blockquote>';
      }
      $informe .= '<h2>&iquest;QU&Eacute; ES CANEA?</h2>
      <p>Es un Test que tiene por objetivo evaluar las competencias laborales de los candidatos y facilitar el proceso de reclutamiento de las empresas. Se dise&ntilde;&oacute; para comprender las aptitudes de una persona y llevarla a lograr un desarrollo profesional.</p>';

      $tds = $ths = $tds_competencias = '';
      $cantd_a = 0;
      foreach ($facetas as $id_faceta => $datos_facetas) {
        if($datos_facetas['literal'] == 'A' && $cantd_a > 1){
          $color = $colores_bg[$datos_facetas['literal'].'1'];
          $color1 = $colores[$datos_facetas['literal'].'1']; 
        }else{
          $color = $colores_bg[$datos_facetas['literal']];
          $color1 = $colores[$datos_facetas['literal']];
          $cantd_a++; 
        }

        $span = '<span class="mayor">'.$datos_facetas['literal'].'</span>';
        $ths .= '<th style="width: 150px" class="'.$color1.'">'.$datos_facetas['literal'].'</th>';
        $thss .= '<td class="'.$color.'" style="text-align:center;">'.utf8_encode(Utils::str_replace_first(strtolower($facetas[$id_faceta]['literal']), $span, $facetas[$id_faceta]['faceta'],1)).'</td>';
      }
      $pos_no_disponible = 1;
    
      $datosXpreguntas = array(); 
      $caracteristicas_generales = array();
      $parrafo = '';
      foreach($preguntas as $id_competencia => $pregunta){
        $cantd_preg++;
        $resultado = Modelo_Baremo::obtienePuntaje($pregunta['orden1'],$pregunta['orden2'],$pregunta['orden3'],$pregunta['orden4'],$pregunta['orden5']);
        if($resultado['porcentaje'] >= 30){
          $datosXpreguntas[$id_competencia] = $resultado['porcentaje'];
        }
        $descriptor = Modelo_Descriptor::obtieneTextos($id_competencia,$resultado['id_puntaje']);       
        $parrafo .= $solo_nombres.' '.utf8_encode($descriptor['descripcion']).' ';
       
        if($cantd_preg == $preg_x_faceta){
          $cantd_preg = 0;
          $caracteristicas_generales[$pregunta['id_faceta']] = '<p align="justify">'.substr($parrafo, 0,-1).'</p>'; 
          $parrafo = '';
        }
      }
      $informe .= '<br><h2>&iquest;QU&eacute; SON LAS COMPETENCIAS LABORALES?</h2>
      <p>Estas se definen como el conjunto de conocimientos, destrezas, habilidades y comportamientos que contribuyen al desempe&ntilde;o y desarrollo individual en un puesto de trabajo.</p>
      <br><h2>&iquest;QU&eacute; ES EL COMPORTAMIENTO?</h2>
      <p>Es la habilidad de interactuar efectivamente con la gente, esta habilidad, puede ser el &eacute;xito o fracaso en su trabajo.</p> 
      <p>Las inventigaciones han demostrado que aquellas personas que se conocen m&aacute;s as&iacute; mismas, son m&aacute;s capaces de desarrollar y comprender sus fortalezas y debilidades.</p>
      <br><h2>INTRODUCCI&Oacute;N</h2>
      <p>Este informe se desarroll&oacute; para que conozcamos y entendamos de una forma m&aacute;s clara los comportamientos que determinan nuestra personalidad integral laboral.</p>';
      
    $informe .= '</div>
    <div style="page-break-after:always;"></div>
    <br>
    <div id="pagina-3" style="text-align:justify">
      <h2>CARACTER&Iacute;STICAS GENERALES DE COMPORTAMIENTO LABORAL</h2>';
      $informe .= '<p>Este informe analiz&oacute; la forma en que <b>'.$solo_nombres.'</b> hace las actividades y tareas y c&oacute;mo reacciona ante los retos que se presentan y se viven diariamente en su sitio de trabajo. Recuerde solo medimos comportamientos. Solo le ofrecemos afirmaciones positivas, en aquellas &aacute;reas de conductas en que la persona demuestra su estilo de comportamiento.</p>
        <p>El comportamiento es un lenguaje universal de &quot;como actuamos&quot;, o de nuestro comportamiento observable. En este test no existen resultados ni buenos, ni malos. Una vez que haya le&iacute;do el reporte, omita cualquier afirmaci&oacute;n que no parezca aplicar a su comportamiento.</p>
        <p>De acuerdo a las respuestas de <b>'.$solo_nombres.',</b> le presentamos descripciones generales de su forma de actuar en su trabajo, identificando la manera en que   prefiere realizar sus funciones.</p>';
      $pos_no_disponible = 1;
      $cantd_a = 0;
      foreach ($competencias as $id_faceta => $value) {
        $comp = explode(', ',$value);
        $color1 = '';

        if($facetas[$id_faceta]['literal'] == 'A' && $cantd_a > 1){
          $color1 = $colores[$facetas[$id_faceta]['literal'].'1']; 
        }else{
          
          $color1 = $colores[$facetas[$id_faceta]['literal']];
          $cantd_a++; 
        }
        $span = '<span class="mayor '.$color1.'">'.$facetas[$id_faceta]['literal'].'</span>';
        if($pos_no_disponible < 3){

          if(($pos_no_disponible < 2 || $tipo_informe == 'completo') && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){
            $informe .= '<ul><li><b>'.utf8_encode(Utils::str_replace_first(strtolower($facetas[$id_faceta]['literal']), $span, $facetas[$id_faceta]['faceta'],1).': </b>'.$facetas[$id_faceta]['introduccion'].' Competencias que se evaluaron: '.$value).'.</li></ul>';
            //if($tipo_informe == 'completo'){
              $informe .= $caracteristicas_generales[$id_faceta];
            //}else{
            //  $informe .= '<br>';
            //}
          }else{
            $informe .= '<ul><li><b>'.utf8_encode(Utils::str_replace_first(strtolower($facetas[$id_faceta]['literal']), $span, $facetas[$id_faceta]['faceta'],1).': </b><b class="rojo">no disponible</b>').'</li></ul><br>';
          }
          $pos_no_disponible++;
        }else{
          if($tipo_informe == 'parcial' && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){
            $informe .= '<ul><li><b>'.utf8_encode(Utils::str_replace_first(strtolower($facetas[$id_faceta]['literal']), $span, $facetas[$id_faceta]['faceta'],1).': </b><b class="rojo">no disponible</b>').'</li></ul><br>';
          }else{
            $informe .= '<ul><li><b>'.utf8_encode(Utils::str_replace_first(strtolower($facetas[$id_faceta]['literal']), $span, $facetas[$id_faceta]['faceta'],1).': </b>'.$facetas[$id_faceta]['introduccion'].' Competencias que se evaluaron: '.$value).'</li></ul>';
            $informe .= $caracteristicas_generales[$id_faceta];
          }
        }
      }
      if($tipo_informe == 'parcial'){
        $informe .= '<div class="publicidad" style="background-color:#FFC000"><b>¡SEA UNA DE LAS PRIMERAS OPCIONES DE SELECCIÓN DE LAS EMPRESAS TERMINANDO EL TEST CANEA EN <a style="color:red" class="azul link" href="'.PUERTO . '://' . HOST . '/planes/'.'" target="_blank">WWW.MICAMELLO.COM.EC, TE PODRAS POSICIONAR EN LOS PRIMEROS LUGARES…. NO DESPERDICIES TU POTENCIAL HASTE CONOCER…. TE ESTAN BUSCANDO</a></b></div>';
      }
      $informe .= '
    </div>';
    $informe .= '<div style="page-break-after:always;"></div>
    <div id="pagina-4" style="text-align:justify">
      <h2>DESCRIPTORES</h2>';
  
      $informe .= '<p>Basado en las respuestas de <b>'.$solo_nombres.',</b> predominan las palabras que m&aacute;s describen su comportamiento cuando: resuelve  problemas y enfrenta desaf&iacute;os, influye en personas, responde al ritmo del ambiente,  reglas  y  procedimientos impuestos. </p>
      <center>
        <table class="tabla2">
          <tr>
            <th style="height: 35px;"colspan="5">DESCRIPTORES</th>
          </tr>
          <tr>
            '.$ths.'
          </tr><tr>
            '.$thss.'
          </tr>';
      $pos_no_disponible = 1;
      $informe .= '<tr>';
      $cantd_f_candidato = 1;

      foreach ($facetas as $id_faceta => $value) {        

        if(in_array($id_faceta, $datos['facetasHabilitadas'])){
          
          if(($cantd_f_candidato < 2 && $tipo_informe == 'parcial') || ($tipo_informe == 'completo')){
            $informe .= '<td>';
            foreach ($rasgos[$id_faceta][$puntaxfaceta[$id_faceta]] as $key => $r) {
              $informe .= '<br>'.utf8_encode($r);
            }
            $informe .= '</td>';
            $cantd_f_candidato++;
          }else{
            $informe .= '<td class="rojo"><b>no disponible</b></td>';
          }

        }else{
          if($pos_no_disponible <= 3 && $tipo_informe == 'parcial'){
            $informe .= '<td class="rojo"><b>no disponible</b></td>';
            $pos_no_disponible++;
          }else{
            $informe .= '<td></td>';
          }
        }
      }
      $informe .= '</tr></table>';
      if($tipo_informe == 'parcial'){
        $informe .= '<br><div class="publicidad" style="background-color:#FFC000"><b>¿DESEA OBTENER MEJORES RESULTADOS? COMPLETE EL TEST CANEA INGRESANDO A <a style="color:red" class="azul link" href="'.PUERTO . '://' . HOST . '/planes/'.'" target="_blank">WWW.MICAMELLO.COM.EC</a></b></div>';
      }
      $informe .= '</center></div><div style="page-break-after:always;"></div>
      <br>
      <div id="pagina-5" style="text-align:justify">
        <h2>ESTILO PERSONALIZADO</h2>';
      $informe .= '<p><b>'.$solo_nombres.'</b> le estamos proporcionando un resumen de s&iacute; mismo. Comprender esta secci&oacute;n le ayudar&aacute; a proyectar una imagen para controlar posibles situaciones. <b>Una vez que haya le&iacute;do el reporte, omita cualquier afirmaci&oacute;n que no parezca aplicar a su comportamiento.</b></p>
      <center>
        <table class="tabla-3">';
      $cantd_a = 0;
      $cantd_f_candidato = 1;
      foreach ($porcentajesxfaceta as $k => $valores) {
        
        if(($cantd_a < $cantd_f_candidato && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO && $tipo_informe == 'parcial')){
        $l = $facetas[$valores['id_faceta']]['literal'];
        if($l == 'A' && $cantd_a > 1){
          $color = $colores_bg[$l.'1']; 
        }else{
          $color = $colores_bg[$l];
          $cantd_a++; 
        }
        
        $d = strtoupper($facetas[$valores['id_faceta']]['faceta']);
        $informe .= '<tr>
          <td class="'.$color.'" style="text-align: center; font-size: 11pt; font-weight: bold; text-transform: uppercase;
      padding-top: 25px; padding-left: 40px; padding-bottom: 25px; padding-right: 40px;">'.utf8_encode($l.'/'.$d).'
          </td>
          <td style="background-color: #c9c9c9; width: 500px; padding: 5px 20px;">
          '.str_replace('_NOMBRE_',$solo_nombres,utf8_encode($valores['descripcion'])).'
          </td>
        </tr><tr><td></td></tr>';}
      }

      if(count($porcentajesxfaceta) == 2){
        $cantd_a = 0;
        $cantd_facetas = 0;
        foreach ($facetas as $identificador => $f) {

          if(($cantd_facetas >= 1 && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) || ($cantd_facetas >= 2 && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA)){
            $l = $f['literal'];
            if($l == 'A' && $cantd_a > 1){
              $color = $colores_bg[$l.'1']; 
            }else{
              $color = $colores_bg[$l];
              $cantd_a++; 
            }
            
            $d = strtoupper($f['faceta']);

            $informe .= '<tr>
              <td class="'.$color.'" style="text-align: center; font-size: 11pt; font-weight: bold; text-transform: uppercase;
          padding-top: 25px; padding-left: 40px; padding-bottom: 25px; padding-right: 40px;">'.utf8_encode($l.'/'.$d).'
              </td>
              <td style="background-color: #c9c9c9; color:red; width: 500px; padding: 5px 20px;">
              <b>NO DISPONIBLE</b>
              </td>
            </tr><tr><td></td></tr>';
          }else{
            $cantd_facetas++;
          }
        }
      }
      
      $informe .= '</table>';
      if($tipo_informe == 'parcial'){
        $informe .= '<br>
        <div class="publicidad" style="background-color:#FFC000"><b>RECUERDE INGRESAR A <a style="color:red" class="azul link" href="https://micamello.com.ec/" target="_blank">WWW.MICAMELLO.COM.EC</a>, para completar su informe. ¡SE UNA DE LAS PRIMERAS OPCIONES EN LA EMPRESA!</b></div>';
      }
      $informe .= '</center>
      </div><div style="page-break-after:always;"></div>
      
      <div id="pagina-6" style="text-align:justify">
        <h2>JERARQU&iacute;A DE COMPETENCIAS</h2>';
      $informe .= '
      <p>Las gr&aacute;ficas de jerarqu&iacute;a mostrar&aacute;n por orden sus competencias de trabajo. Le ayudar&aacute; a entender en cuales de estas competencias ser&aacute; m&aacute;s productivo.</p><p>Nota: el porcentaje representado debajo del asterisco (*) representa la media poblacional de cada competencia.</p>';
      $cantd_salto = 6;
      
      arsort($datosXpreguntas);
      $key = 0;
      $cantd_preg = 0;
      $cantd_hoja_total = round(count($datosXpreguntas)/6)-1;
      $cantd_hoja = 1;

      foreach ($datosXpreguntas as $id_competencia => $resultado) {
        $pregunta = $preguntas[$id_competencia];
        $cantd_preg++;
        $informe .= '<p><b>'.($key + 1).'. '.str_replace($cambiar_letra,$conacentos,strtoupper(utf8_encode($pregunta['nombre']))).' -</b> ';
        if($tipo_informe == 'parcial'){
          $informe .= '<span class="rojo">No disponible</span>';
        }else{
          $informe .= utf8_encode($pregunta['descripcion']);
        }
        
        $informe .= '</p>';
       
        $key++;
        $informe .= '<table class="demo">
          <tbody>
            <tr>
              <th colspan="2">0</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th colspan="3">10</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th colspan="3">20</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th colspan="3">30</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th colspan="3">40</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th colspan="3">50</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th colspan="3">60</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th colspan="3">70</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th colspan="3">80</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th colspan="3">90</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th colspan="3" width="100">100</th>
              <th class="porcentaje" rowspan="3">';

              if($tipo_informe != 'parcial'){
                $informe .= '<span>'.number_format($resultado, 2, '.', ',').'</span>';
              }else{
                $informe .= '<span class="rojo"><b>no disponible</b><span>';
              }
              $informe .= '</th>
            </tr>
            <tr id="borde_barra">';
            $porcentaje = round($resultado); //43
            $limite_inferior = round($pregunta['limite_inferior']); //53
            $limite_medio = round($pregunta['limite_medio']);//62
            $limite_superior = round($pregunta['limite_superior']); //71
            if($porcentaje >= $limite_medio){
              $punto_medio = ($porcentaje - $limite_medio); //-19
              $part1 = $porcentaje - $punto_medio - 1;
              $part2 = $porcentaje - $limite_medio; 
              $part3 = 100 - $porcentaje;

              if($tipo_informe == 'parcial'){
                $part2 = '<td colspan="1" align="center" class="color_asterisco">*</td>
                <td colspan="'.$part2.'" class=""></td>
                <td class="fin" style="padding-left:50px;" colspan="'.$part3.'">&nbsp;</td>';
              }else{
                $part2 = '<td colspan="1" align="center" class="pintar-azul color_asterisco">*</td>
                <td colspan="'.$part2.'" class="pintar-azul"></td>
                <td class="fin" style="padding-left:50px;" colspan="'.$part3.'">&nbsp;</td>';
              }
              
            }else{
              $part1 = $porcentaje;
              $part2 = $limite_medio - $porcentaje - 1; 
              $part3 = 100 - $limite_medio;

              $part2 = '<td colspan="'.$part2.'">&nbsp;</td>
              <td colspan="1" align="center" class="color_asterisco">*</td>
              <td class="fin" colspan="'.$part3.'">&nbsp;</td>';

            }

            if($tipo_informe == 'parcial'){
              $informe .= '<td colspan="'.$part1.'" class=""></td>';
            }else{
              $informe .= '<td colspan="'.$part1.'" class="pintar-azul"></td>';
            }
            
            $informe .= $part2.'
            </tr>
            <tr style="font-size:12px;">';
            
            for ($i=1; $i <= 100; $i++) { 
              if($i >= $limite_inferior && $i <= $limite_superior){
                $informe .= '<td class="pintar-celeste">';
                if($i == $limite_medio){
                  $informe .= $pregunta['limite_medio'];
                }
                $informe .= '</td>';
              }else{
                $informe .= '<td>&nbsp;</td>';
              }
            }
            $informe .= '</tr>
          </tbody>
        </table>';
        if($cantd_salto == $cantd_preg && $cantd_hoja <= $cantd_hoja_total){
          $informe .= '<div style="page-break-after:always;"></div><br>';
          $cantd_salto++;
          $cantd_hoja++;
          $cantd_preg = 0;
        }
      }
      $informe .=  '</div>';
      if($tipo_informe == 'parcial'){
        $informe .= '<br><br>
        <div class="publicidad" style="background-color:#FFC000"><b>¡ELEVE SUS OPORTUNIDADES DE OBTENER UN MEJOR EMPLEO! COMPLETE EL TEST CANEA INGRESANDO A <a style="color:red" class="azul link" href="'.PUERTO . '://' . HOST . '/planes/'.'" target="_blank">WWW.MICAMELLO.COM.EC</a>. Y POTENCIE SUS FORTALEZAS. SEA LA PRIMERA OPCIÓN PARA SER CONTRATADO</b></div>';
      }else{
        $informe .= '<div style="page-break-after:always;"></div><br><br><div>
          <h2>resumen canea</h2>
          <h1 style="text-align: left; display: block"><span class="verde">C</span><span class="amarillo">A</span><span class="rojo">N</span><span class="morado">E</span><span class="azul">A</span></h1>
        </div>';
      }
      if(count($porcentajesxfaceta) == count($facetas)){
        $informe .= '<p align="center"><img width="600" heigth="600" align="center" src="'.$datosusuario['grafico'].'">';
        $porcentajes_faceta = explode(",",  $porcentajes_faceta);
        $informe .= '<table style="font-size:18px" class="tabla-canea">
            <tr>
              <td style="background-color:#5EB782; text-align:center" class="bloq-canea">C</td>
              <td class="bloq">Hacer '.$porcentajes_faceta[0].'%</td>
              <td style="background-color:#FCDC59; text-align:center" class="bloq-canea">A</td>
              <td class="bloq">Relaciones Interpersonales '.$porcentajes_faceta[1].'%</td>
              <td style="background-color:#E25050; text-align:center" class="bloq-canea">N</td>
              <td class="bloq">Inteligencia Emocional '.$porcentajes_faceta[2].'%</td>
            </tr>
            <tr>
              <td style="background-color:#8C4DCE; text-align:center" class="bloq-canea">E</td>
              <td class="bloq">Asertividad / Comunicación '.$porcentajes_faceta[3].'%</td>
              <td style="background-color:#2B8DC9; text-align:center" class="bloq-canea">A</td>
              <td class="bloq">Pensar '.$porcentajes_faceta[4].'%</td>
              <td class="bloq-canea"></td>
              <td class="bloq"></td>
            </tr>
        </table></p>';
      }
    //echo $informe;    
    self::informePersonalidad($informe,$nombre_archivo,$datos_descarga);
  }

  public function informePersonalidad($html,$nombre_archivo,$datos_descarga){    
    $cabecera = "imagenes/pdf/header1.png";
    $piepagina = "imagenes/pdf/footer1.png";
    $mpdf=new mPDF('','A4');
    $inidoc = "<!DOCTYPE html><html><link rel='stylesheet' href='css/informemic.css'>
                <body><main>";
    $enddoc = "</main></body></body></html>";
    $mpdf->setHTMLHeader('<header><img src="'.$cabecera.'" width="100%"></header>'); 
    $mpdf->setHTMLFooter('<footer style="text-align:center; color:#386b97; font-weight:bold">{PAGENO}<img src="'.$piepagina.'" width="100%"></footer>');
    $mpdf->AddPage('', '', '', '', '',
        15, // margin_left
        15, // margin right
        25, // margin top
        30, // margin bottom
        10, // margin header
        8);
    
    $mpdf->WriteHTML($inidoc);    
    $mpdf->WriteHTML($html);
    $mpdf->WriteHTML($enddoc);          
    $mpdf->Output($nombre_archivo, 'D');
  }
 
  public function hvUsuario($username, $id_oferta, $vista){
        $datos = Modelo_Usuario::existeUsuario(Utils::desencriptar($username));
        if($vista == 1){
            $aspSalarial = Modelo_Usuario::aspSalarial($datos['id_usuario'], $id_oferta);
            $datos = array_merge($datos, array('aspSalarial'=>$aspSalarial['asp_salarial']));
        }
        $mfoUsuario = Modelo_Usuario::informacionPerfilUsuario($datos['id_usuario']);
        $datos = array_merge($datos, $mfoUsuario);
        $usuarioxarea = Modelo_UsuarioxArea::listado($datos['id_usuario']);
        $dataareasubarea = array();
        foreach ($usuarioxarea as $key=>$value) {
            // array_push($dataareasubarea, $value[0]);
          array_push($dataareasubarea, $value['id_areas_subareas']);
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
        //$archivoRuta = "usuarios/profile/".$datos['username'].'.jpg';         
        $resultado = file_exists($ruta);        
        if (!$resultado){
          $ruta = FRONTEND_RUTA.'imagenes/user.png';
          //$archivoRuta = "user.png";
        }       
        //$archivo = $archivo.'.jpg';
        //$foto = PUERTO.'://'.HOST.'/imagenes/'.$archivoRuta;
        //echo $ruta; exit;
        $html .= $divinicio."text-align: center;".$divinter.$imageninicio.$ruta.$imagenstyle."width: 120px;height: 120px;border-style: solid;border-color: white;".$imagenfin.$divfinal;
        if(isset($datos['aspSalarial'])){
          $html .= "<h5 style='text-align: center;'><b>Aspiraci&oacute;n salarial:</b> ".SUCURSAL_MONEDA.$datos['aspSalarial']."</h5>";
        }
        $documento = ""; if($datos['tipo_doc'] == 1) $documento = 'Ruc';
                if($datos['tipo_doc'] == 2) $documento = 'C&eacute;dula';
                if($datos['tipo_doc'] == 3) $documento = 'Pasaporte';
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
              $html .= utf8_encode($datos['nombres']);
              $html .= $fintd;
              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= utf8_encode($datos['apellidos']);
              $html .= $fintd;
            $html .= $fintr;
    // ------------------------------------------------------
            $html .= $iniciotr;
              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Estado civil</b>";
              $html .= $fintd;
              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Edad</b>";
              $html .= $fintd;
            $html .= $fintr;
            $html .= $iniciotr;
              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= utf8_encode($datos['estadocivil']);
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
              $html .= "<b>G&eacute;nero</b>";
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
              $html .= "<b>&uacute;ltimo estudio realizado</b>";
              $html .= $fintd;
              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Situaci&oacute;n laboral</b>";
              $html .= $fintd;
            $html .= $fintr;
            $html .= $iniciotr;
              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= utf8_encode($datos['escolaridad']);
              $html .= $fintd;
              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= utf8_encode($datos['situacionLaboral']);
              $html .= $fintd;
            $html .= $fintr;
// ------------------------------------------------------
            $html .= $iniciotr;
              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Tipo de licencia</b>";
              $html .= $fintd;
              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Estudios en el extranjero</b>";
              $html .= $fintd;
            $html .= $fintr;
            $html .= $iniciotr;
              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= $datos['licencia'];
              $html .= $fintd;
              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= utf8_encode($datos['extranjero']);
              $html .= $fintd;
            $html .= $fintr;
// ------------------------------------------------------
            $html .= $iniciotr;
              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Universidad</b>";
              $html .= $fintd;
            $html .= $fintr;
            $html .= $iniciotr;
              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= utf8_encode($datos['universidad']);
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
              $html .= "<b>Ciudad de residencia</b>";
              $html .= $fintd;
              $html .= $iniciotd."4".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Nacionalidad</b>";
              $html .= $fintd;
              $html .= $iniciotd."4".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Provincia de residencia</b>";
              $html .= $fintd;
            $html .= $fintr;
            $html .= $iniciotr;
              $html .= $iniciotd."4".$tdstyle."text-align: center;".$tdinter;
              $html .= utf8_encode($datos['ciudad']);
              $html .= $fintd;
              $html .= $iniciotd."4".$tdstyle."text-align: center;".$tdinter;
              $html .= utf8_encode($datos['nacionalidad']);
              $html .= $fintd;
              $html .= $iniciotd."4".$tdstyle."text-align: center;".$tdinter;
              $html .= utf8_encode($datos['provincia']);
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
              $html .= "<b>Celular</b>";
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
              $html .= "<b>".$documento."</b>";
              $html .= $fintd;
              $html .= $iniciotd."6".$tdstyle."text-align: center;".$tdinter;
              $html .= "<b>Tel&eacute;fono</b>";
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
                $html .= "<h4>&Aacute;reas de inter&eacute;s</h4>";
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
                            $html.= "<br><h4 style='text-align: center;'>&Aacute;rea: ".utf8_encode($value2['area'])."<br></h4>";
                          }
                        }
                        $html.= "<h4 style='text-align: center;'>Sub&Aacute;reas: </h4>";
                        foreach ($actual as $key1 => $value1) {
                          $html.= utf8_encode($value1['subarea'])."<br>";
                        }
              }
              $html .= $fintd;
            $html .= $fintr;
        $html .= $fintbody;
        $html .= $finTabla;        
        $cabecera = "imagenes/pdf/header1.png";
        $piepagina = "imagenes/pdf/footer1.png";
        $mpdf=new mPDF('','A4');
        // $html = "";
        $inidoc = "<!DOCTYPE html><html><link rel='stylesheet' href='css/informemic.css'>
                    <body>
                    <style>
                      
                    </style>
                    ";
        $enddoc = "</body></html>";
        
        $mpdf->setHTMLHeader('<header><img src="'.$cabecera.'" width="100%"></header>');
        $mpdf->setHTMLFooter('<footer><img src="'.$piepagina.'" width="100%"></footer>');
        $mpdf->AddPage('',
        '', '', '', '',
        10, // margin_left
        10, // margin right
       25, // margin top
       30, // margin bottom
        10, // margin header
        8);
        $mpdf->WriteHTML($inidoc);
        $mpdf->WriteHTML($enddoc);
        $mpdf->WriteHTML($html);
        //echo $html;
        $mpdf->Output($datos['username'].".pdf", 'D');
        
  }

  public static function sumarHoras($horas) {
    $total = 0;
    foreach($horas as $h) {
        $parts = explode(":", $h);
        $total += $parts[2] + $parts[1]*60 + $parts[0]*3600;        
    }   
    return gmdate("H:i:s", $total);
  }
}
?>
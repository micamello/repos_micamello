<?php
class Controlador_Cuestionario extends Controlador_Base {
  
  public function construirPagina(){
    $mostrar_dialog = false; 
    if( !Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/login/');
    }
    if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA){
      if (isset($_SESSION['mfo_datos']['planes'])){
        $this->redirectToController('publicar');
      }else{
        $this->redirectToController('planes');
      }
    }

    if(!isset($_SESSION['mfo_datos']['usuario']['usuarioxarea']) || empty($_SESSION['mfo_datos']['usuario']['usuarioxarea']) && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){ 
      Utils::doRedirect(PUERTO.'://'.HOST.'/perfil/');
    }
    //si no ha cargado hoja de vida no puede realizar cuestionarios
    // if (empty($_SESSION['mfo_datos']['usuario']['infohv'])){
    //   $this->redirectToController('perfil');
    // }
    $opcion = Utils::getParam('opcion', '', $this->data);
    switch ($opcion) {
      case 'modalidad':
        $id_usuario = $_SESSION['mfo_datos']['usuario']['id_usuario'];
        if(!Modelo_Usuario::actualizarMetodoSeleccion($id_usuario, $_POST['seleccion'])){          
          $_SESSION['mostrar_error'] = "Ha ocurrido un error, intente nuevamente";
          Utils::doRedirect(PUERTO.'://'.HOST.'/cuestionario/');
        }
        else{
          Utils::doRedirect(PUERTO.'://'.HOST.'/preguntas/');
        }
      break;
      case 'guardarResp':
        try{ 
          $GLOBALS['db']->beginTrans();
          $id_usuario = $_SESSION['mfo_datos']['usuario']['id_usuario'];
          $arrayDatos = self::validarRespuesta($_POST['array_orden'], $_POST['array_opcion']);
          $fecha1 = new DateTime($_POST["tiempo"]);
          $fecha2 = new DateTime("now");
          $diferencia = $fecha1->diff($fecha2);
          $tiempo = $diferencia->format('%H:%i:%s');
          $facetaArr = Modelo_Respuesta::facetaSiguiente($id_usuario);
          $facetaArr = array($facetaArr);
          if($facetaArr[0] == 1){
            $data = Modelo_Opcion::obtieneOpciones($facetaArr[0]);
            foreach ($data as $opcion) {
              $siguiente = next($data);
              if(($opcion['id_faceta'] != $siguiente['id_faceta']) && count($siguiente['id_faceta']) > 0){
                array_push($facetaArr, $siguiente['id_faceta']);
              }
            }
          }
          if(!Modelo_Respuesta::guardarRespuestas($arrayDatos, $id_usuario)){
            throw new Exception("Ha ocurrido un error, intente nuevamente1.");
          }
          $id_usuario = $_SESSION['mfo_datos']['usuario']['id_usuario'];
          $faceta = Modelo_Respuesta::facetaActual($id_usuario);
          if (empty($faceta)){
            throw new Exception("Ha ocurrido un error, intente nuevamente2.");
          }
          
          $porcentajeArr = array();
          foreach ($facetaArr as $value) {
            $totalfaceta = 0;
            $porcentaje = 0;
            $vlbaremo = Modelo_Respuesta::resultadoxUsuario($id_usuario,$value);
            if (empty($vlbaremo)){
              throw new Exception("Ha ocurrido un error, intente nuevamente3."); 
            }
            foreach($vlbaremo as $valores){
              $resbaremo = Modelo_Baremo::obtienePuntaje($valores["orden1"],$valores["orden2"],$valores["orden3"],$valores["orden4"],$valores["orden5"]);
              if (empty($resbaremo)){
                throw new Exception("Ha ocurrido un error, intente nuevamente."); 
              }              
              $totalfaceta = $totalfaceta + $resbaremo["porcentaje"];
            }
            $porcentaje = round($totalfaceta/count($vlbaremo),2); 
            $acceso = Utils::getParam('acceso', '', $this->data);         
            $estado = (!empty($acceso) && $acceso == 1 && $_SESSION['mfo_datos']['usuario']['pendiente_test']) ? 0 : 1;
            array_push($porcentajeArr, $porcentaje);
          }
          if (!Modelo_PorcentajexFaceta::guardarValores($porcentajeArr,$id_usuario,$facetaArr,$estado,$tiempo)){
            throw new Exception("Ha ocurrido un error, intente nuevamente5."); 
          }
          // if ($faceta == 5){
            $hvControlador = new Controlador_HojaVida();
            $hvControlador->guardarPlanesGratis(); 
          // }
          if ($faceta == 5 && $estado == 0){

            if (!Modelo_Usuario::actualizarAceptarAcceso($_SESSION['mfo_datos']['usuario']['id_usuario'],0)){
              throw new Exception("Ha ocurrido un error, intente nuevamente6.");  
            } 
            $_SESSION['mfo_datos']['usuario']['pendiente_test'] = 0;
            $accesos = Modelo_AccesoEmpresa::consultaVariosPorCandidato($_SESSION['mfo_datos']['usuario']['id_usuario']);           
            if (!Modelo_AccesoEmpresa::actualizarFechaTermino($_SESSION['mfo_datos']['usuario']['id_usuario'])){
              throw new Exception("Ha ocurrido un error, intente nuevamente7.");  
            }            
          }
          $GLOBALS['db']->commit();
          if($faceta == 1 || $faceta == 2 || $faceta == 5){
            if ($faceta == 5 && $estado == 0){              
              if (!empty($accesos)){
                foreach($accesos as $acceso){
                  $infoempresa = Modelo_Usuario::busquedaPorId($acceso["id_empresa"],Modelo_Usuario::EMPRESA);
                  $infoempresaplan = Modelo_UsuarioxPlan::consultaIndividual($acceso["id_empresa_plan"],Modelo_Usuario::EMPRESA);
                  $infoplan = Modelo_Plan::busquedaXId($infoempresaplan["id_plan"]);
                  $email_subject = "Aceptación de Acceso"; 
                  $candidato = ucfirst(utf8_encode($_SESSION['mfo_datos']['usuario']['nombres'])).' '.ucfirst(utf8_encode($_SESSION['mfo_datos']['usuario']['apellidos']));
                  $enlace = "<a href='".PUERTO.'://'.HOST.'/planesUsuario/'."'>Mis Planes</a>";
                  $email_body = Modelo_TemplateEmail::obtieneHTML("ACEPTACION_ACCESO");
                  $email_body = str_replace("%NOMBRES%", ucfirst(utf8_encode($infoempresa["nombres"])), $email_body);   
                  $email_body = str_replace("%CANDIDATO%", $candidato, $email_body);               
                  $email_body = str_replace("%FECHA%", $acceso["fecha_envio_acceso"], $email_body);
                  $email_body = str_replace("%PLAN%", $infoplan["nombre"], $email_body);
                  $email_body = str_replace("%ENLACE%", $enlace, $email_body);
                  // Utils::envioCorreo($infoempresa["correo"],$email_subject,$email_body);
                  Utils::envioCorreo("administrador.gye@micamello.com.ec",$email_subject,$email_body);
                }
              }
              //envio de correo              
              Utils::doRedirect(PUERTO.'://'.HOST.'/oferta/');
            }
            else{
              if(($faceta == 2 || $faceta == 5) && isset($_SESSION['mfo_datos']['usuario']['infohv'])){
                Utils::doRedirect(PUERTO.'://'.HOST.'/velocimetro/');
              }
              elseif(!isset($_SESSION['mfo_datos']['usuario']['infohv'])){
                Utils::doRedirect(PUERTO.'://'.HOST.'/cargarhojavida/');
              }
            }            
          }
        }
        catch( Exception $e ){
          $GLOBALS['db']->rollback();
          $_SESSION['mostrar_error'] = $e->getMessage();  
        }
        Utils::doRedirect(PUERTO.'://'.HOST.'/preguntas/');
      break;
      case 'preguntas':
        $id_usuario = $_SESSION['mfo_datos']['usuario']['id_usuario'];
        $metodoSeleccion = Modelo_Usuario::consultarMetodoASeleccion($id_usuario);        
        $faceta = Modelo_Respuesta::facetaSiguiente($id_usuario);
        $tags = array();
        if (empty($faceta)){          
          Utils::doRedirect(PUERTO.'://'.HOST.'/velocimetro/');
        }   
        if(!$metodoSeleccion){
          Utils::doRedirect(PUERTO.'://'.HOST.'/cuestionario/'); 
        }        
        if ($faceta >= 3){
          $acceso = $this->validaTercerFormulario($faceta);
          if (!empty($acceso) && $_SESSION['mfo_datos']['usuario']['pendiente_test']){
            $tags["acceso"] = "1";
          }
        }        
        $data = Modelo_Opcion::obtieneOpciones($faceta);      
        $tags["data"] = $data;
        $tags["tiempo"] = date("Y-m-d H:i:s");
        $tags["faceta"] = $faceta;        
        $tags["template_css"][] = "toastr.min";
        $tags["template_js"][] = "jquery-ui";
        $tags["template_js"][] = "jquery.ui.touch-punch.min";
        $tags["template_js"][] ="double-tap";
        $tags["template_js"][] = "modos_respuesta";
        $tags["template_js"][] = "toastr.min";        
        $tags["nomobile"] = 1;
        $tags["pagadoEstado"] = Modelo_PorcentajexFaceta::obtienePermisoDescargar($id_usuario);
        Vista::render('modalidad'.$metodoSeleccion['metodo_resp'], $tags);
      break;
      case 'consultarCA':
        $ca = Modelo_Respuesta::facetaSiguiente($_SESSION['mfo_datos']['usuario']['id_usuario']);          
          if($ca == 1){
            $ca = '0';
          }
        Vista::renderJSON(array("dato"=>$ca));
      break;
      
      default:        
        $faceta = Modelo_Respuesta::facetaSiguiente($_SESSION['mfo_datos']['usuario']['id_usuario']);               
        if (empty($faceta)){
          $pf = Modelo_PorcentajexFaceta::obtienePermisoDescargar($_SESSION['mfo_datos']['usuario']["id_usuario"]);                
          if (empty($pf) || $pf < 5){
            $this->redirectToController('oferta'); 
          }
          else{
            Utils::doRedirect(PUERTO.'://'.HOST.'/velocimetro/');
          }
        }           
        if ($faceta >= 3){          
          $acceso = $this->validaTercerFormulario($faceta);
          if (!empty($acceso)){
            Modelo_Notificacion::eliminarNotificacionUsuario($_SESSION['mfo_datos']['usuario']['id_usuario'],Modelo_Notificacion::DESBLOQUEO_ACCESO);
          }          
        }        
        
        $metodoSeleccion = Modelo_Usuario::consultarMetodoASeleccion($_SESSION['mfo_datos']['usuario']['id_usuario']);        
        if ($faceta > 1 && !empty($metodoSeleccion) && isset($metodoSeleccion["metodo_resp"]) && !empty($metodoSeleccion["metodo_resp"])){
          Utils::doRedirect(PUERTO.'://'.HOST.'/preguntas/');
        }  
        $tags = array();
        $tags["template_js"][] = "cuestionario";
        Vista::render('modalidad', $tags);        
      break;
    }
  }
  public function validarRespuesta($arrayOrden, $arrayOpcion){
    $id_usuario = $_SESSION['mfo_datos']['usuario']['id_usuario'];
    $respuestas = Modelo_Respuesta::obtenerRespuestas($id_usuario);
    $arrayData = array();
    if(!empty($respuestas) && is_array($respuestas)){
      for ($i=0; $i < count($arrayOpcion); $i++) { 
        if(!in_array($respuestas[$i]['id_opcion'], $arrayOpcion)){
          array_push($arrayData, array('opcion'=>$arrayOpcion[$i], 'orden'=>$arrayOrden[$i]));
        }
      }
    }
    else{
      for ($i=0; $i < count($arrayOpcion); $i++) {
          array_push($arrayData, array('opcion'=>$arrayOpcion[$i], 'orden'=>$arrayOrden[$i]));
      }
    }
    return $arrayData;
  }
  public function validaTercerFormulario($faceta){
    //consultar si tiene algun acceso
    $acceso = Modelo_AccesoEmpresa::consultaPorCandidato($_SESSION['mfo_datos']['usuario']["id_usuario"]);
    if (!empty($acceso)){
      return $acceso; 
    }else{      
      if(!isset($_SESSION['mfo_datos']['planes']) || !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'],'tercerFormulario')){
        $_SESSION['mostrar_error'] = "Para una mejor experiencia adquiera Premium";  
        $this->redirectToController('planes');
      }      
      return false;
    }    
  }
}
?>
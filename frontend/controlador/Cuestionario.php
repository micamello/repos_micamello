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

    //si no ha cargado hoja de vida no puede realizar cuestionarios
    if (empty($_SESSION['mfo_datos']['usuario']['infohv'])){
      $this->redirectToController('perfil');
    }

    $opcion = Utils::getParam('opcion', '', $this->data);
    switch ($opcion) {
      case 'modalidad':
        $id_usuario = $_SESSION['mfo_datos']['usuario']['id_usuario'];
        if(!Modelo_Usuario::actualizarMetodoSeleccion($id_usuario, $_POST['seleccion'])){
          throw new Exception("Ha ocurrido un error, intente nuevamente");
          $_SESSION['mostrar_error'] = $e->getMessage();
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
          $tiempo = $_POST['tiempo'];
          if(!Modelo_Respuesta::guardarRespuestas($arrayDatos, $tiempo, $id_usuario)){
            throw new Exception("Ha ocurrido un error, intente nuevamente.");
          }
          $id_usuario = $_SESSION['mfo_datos']['usuario']['id_usuario'];
          $faceta = Modelo_Respuesta::facetaActual($id_usuario);
          if (empty($faceta)){
            throw new Exception("Ha ocurrido un error, intente nuevamente.");
          }
          $vlbaremo = Modelo_Respuesta::resultadoxUsuario($id_usuario,$faceta);
          if (empty($vlbaremo)){
            throw new Exception("Ha ocurrido un error, intente nuevamente."); 
          }
          $totalfaceta = 0;
          foreach($vlbaremo as $valores){
            $resbaremo = Modelo_Baremo::obtienePuntaje($valores["orden1"],$valores["orden2"],$valores["orden3"],$valores["orden4"],$valores["orden5"]);
            if (empty($resbaremo)){
              throw new Exception("Ha ocurrido un error, intente nuevamente."); 
            }              
            $totalfaceta = $totalfaceta + $resbaremo["porcentaje"];
          }          
          $porcentaje = round($totalfaceta/count($vlbaremo),2);          
          if (!Modelo_PorcentajexFaceta::guardarValores($porcentaje,$id_usuario,$faceta)){
            throw new Exception("Ha ocurrido un error, intente nuevamente."); 
          }
          $GLOBALS['db']->commit();
          if($faceta == 1 || $faceta == 2 || $faceta == 5){
            Utils::doRedirect(PUERTO.'://'.HOST.'/velocimetro/');
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
        if (empty($faceta)){
          Utils::doRedirect(PUERTO.'://'.HOST.'/velocimetro/');
        }
        $data = Modelo_Opcion::obtieneOpciones($faceta);        
        if(!empty($faceta) && $faceta >= 3 && (!isset($_SESSION['mfo_datos']['planes']) || !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'],'tercerFormulario'))){
          Utils::doRedirect(PUERTO.'://'.HOST.'/planes/');
        }
        elseif(!empty($faceta) && $faceta == 3 &&isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'],'tercerFormulario')){
          if(!$metodoSeleccion){
            Utils::doRedirect(PUERTO.'://'.HOST.'/cuestionario/'); 
          }
        }                
        $tags = array('data'=>$data,
                      'tiempo'=>date("Y-m-d H:i:s"),
                      'faceta'=>$faceta);
        $tags["template_css"][] = "toastr.min";
        $tags["template_js"][] = "jquery-ui";
        $tags["template_js"][] = "modos_respuesta";
        $tags["template_js"][] = "toastr.min";        
        Vista::render('modalidad'.$metodoSeleccion['metodo_resp'], $tags);
      break;
      
      default:
        $nrototaltest = Modelo_Cuestionario::totalTest();
        $nrotestusuario = Modelo_Cuestionario::totalTestxUsuario($_SESSION['mfo_datos']['usuario']["id_usuario"]);
        if($nrototaltest > $nrotestusuario){
          $ruta = "";
          $tags = array();
          $tags["template_js"][] = "cuestionario";
          $respUsuario = Modelo_Respuesta::obtenerRespuestas($_SESSION['mfo_datos']['usuario']['id_usuario']);
          if(empty($respUsuario)){
            Vista::render('modalidad', $tags);
            return false;
          }
          Utils::doRedirect(PUERTO.'://'.HOST.'/preguntas/');
        }
        else{
          $planesPagados = Modelo_UsuarioxPlan(Modelo_Usuario::CANDIDATO);
          // if($nrototaltest == $nrotestusuario){
            if(!empty($planesPagados)){
              $ruta = "postulacion";
            }else{
              $ruta = "ofertas";
            }
          // }
          Utils::doRedirect(PUERTO.'://'.HOST.'/'.$ruta.'/');
        }
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

}
?>
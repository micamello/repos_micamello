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
    if (empty($_SESSION['mfo_datos']['infohv'])){
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
        $id_usuario = $_SESSION['mfo_datos']['usuario']['id_usuario'];
        $arrayDatos = self::validarRespuesta($_POST['array_orden'], $_POST['array_opcion']);
        $tiempo = $_POST['tiempo'];
        if(!Modelo_Respuesta::guardarRespuestas($arrayDatos, $tiempo, $id_usuario)){
          throw new Exception("Ha ocurrido un error, intente nuevamente.");
        }
        $id_usuario = $_SESSION['mfo_datos']['usuario']['id_usuario'];
        $faceta = Modelo_Respuesta::facetaSiguiente($id_usuario);
        if($faceta == 1 || $faceta == 2 || $faceta == 5 || ($faceta-1) == 2){
          Utils::doRedirect(PUERTO.'://'.HOST.'/velocimetro/');
        }
        else{
          Utils::doRedirect(PUERTO.'://'.HOST.'/preguntas/');
        }
        
      break;

      case 'preguntas':
        $id_usuario = $_SESSION['mfo_datos']['usuario']['id_usuario'];
        $metodoSeleccion = Modelo_Usuario::consultarMetodoASeleccion($id_usuario);        
        $faceta = Modelo_Respuesta::facetaSiguiente($id_usuario);
        $data = Modelo_Opcion::obtieneOpciones($faceta);        

        if(!empty($faceta) && $faceta >= 3 && (!isset($_SESSION['mfo_datos']['planes']) || !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'],'tercerFormulario'))){
          Utils::doRedirect(PUERTO.'://'.HOST.'/planes/');
        }
        elseif(!empty($faceta) && $faceta == 3 &&isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'],'tercerFormulario'))
        {
          if(!$metodoSeleccion){
            Utils::doRedirect(PUERTO.'://'.HOST.'/cuestionario/'); 
          }
        }
        
        $tags = array();
        $tags = array(
                      'data'=>$data,
                      'tiempo'=>date("Y-m-d H:i:s"),
                      'faceta'=>$faceta);
        $tags["template_css"][] = "toastr.min";
        $tags["template_js"][] = "jquery-ui";
        $tags["template_js"][] = "modos_respuesta";
        $tags["template_js"][] = "toastr.min";
        
        Vista::render('modalidad'.$metodoSeleccion['metodo_resp'], $tags);
      break;
      
      default:
      $tags = array();
      $tags["template_js"][] = "cuestionario";
      $respUsuario = Modelo_Respuesta::obtenerRespuestas($_SESSION['mfo_datos']['usuario']['id_usuario']);
      if(empty($respUsuario)){
        Vista::render('modalidad', $tags);
        return false;
      }
      Utils::doRedirect(PUERTO.'://'.HOST.'/preguntas/');
      break;
    }

    // Vista::render('cuestionario', array(), 'cabecera','',true);   
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

  // public function guardarRespuestas($nro_opc,$test,$nrotest){        
  //   $campos = array('id_pregunta'=>1, 'id_opcion'=>1, 'tiempo'=>1, 'modo_pregunta'=>1, 'id_test'=>1);
  //   $data = $this->camposRequeridos($campos);    
    
  //   $fecha1 = new DateTime($data["tiempo"]);
  //   $fecha2 = new DateTime("now");
  //   $diferencia = $fecha1->diff($fecha2);
  //   $tiempo = $diferencia->format('%H:%i:%s');
      
  //   if ($data["modo_pregunta"] == Modelo_Pregunta::DIRECTA){
  //     $valor = $data["id_opcion"];    
  //   }
  //   else{
  //     $valor = $nro_opc - ($data["id_opcion"] - 1);
  //   }
          
  //   $_SESSION['cuestionario'][$data['id_pregunta']]['respuesta'] = array("valor"=>$valor,"opcion"=>$data["id_opcion"],"tiempo"=>$tiempo); 
  //   $pregunta = self::obtienePreguntaActual();     

  //   if (empty($pregunta)){
  //     $this->guardarCuestionario($test,$nrotest); 
  //     unset($_SESSION['cuestionario']);
  //     $_SESSION['mostrar_exito'] = "Formulario completado exitosamente"; 
  //     $this->redirectToController('velocimetro');
  //   }
  //   else{
  //     $this->data["pregunta"] = $pregunta;    
  //   }      
  // }

  // public function guardarCuestionario($test,$nrotest){
  //   try{ 
  //     $GLOBALS['db']->beginTrans();
  //     if (empty($_SESSION['cuestionario'])){
  //       throw new Exception("Error en el registro del cuestionario, por favor comuniquese con el administrador");
  //     }
  //     foreach($_SESSION['cuestionario'] as $pregunta){   
  //       $tiempo = $pregunta["respuesta"]["tiempo"];      
  //       $opcion = $pregunta["respuesta"]["opcion"];
  //       $valor = $pregunta["respuesta"]["valor"];
  //       $usuario = $_SESSION['mfo_datos']['usuario']['id_usuario'];
  //       if (!Modelo_Respuesta::guardarResp($valor,$opcion,$tiempo,$usuario,$test,$pregunta["id_pre"])){
  //         throw new Exception("Error al registrar la respuesta, por favor intente denuevo");
  //       }
  //     }

  //     $rasgos = Modelo_Rasgo::obtieneRasgoxTest($test);
  //     if (empty($rasgos)){
  //       throw new Exception("Error en el registro del total, por favor comuniquese con el administrador");
  //     }
  //     $total_rasgo = 0; $promedio = 0;
  //     foreach($rasgos as $rasgo){
  //       $preguntas_rasgo = Modelo_Pregunta::obtienePreguntaxRasgo($test, $rasgo["id_rasgo"]);
  //       $valor_rasgo = Modelo_Respuesta::totalxRasgo($test,$preguntas_rasgo,$_SESSION['mfo_datos']['usuario']['id_usuario']);      
  //       if (!Modelo_ResultxRasgo::guardar($valor_rasgo,$_SESSION['mfo_datos']['usuario']['id_usuario'],$rasgo["id_rasgo"])){
  //         throw new Exception("Error en el registro del total, por favor comuniquese con el administrador");
  //       }
  //       $total_rasgo = $total_rasgo + $valor_rasgo; 
  //     }
  //     $promedio = round($total_rasgo / count($rasgos));
      
  //     if (!Modelo_Cuestionario::guardarPorTest($promedio,$_SESSION['mfo_datos']['usuario']['id_usuario'],$test)){
  //       throw new Exception("Error al registrar el fin del formulario, por favor intente denuevo");
  //     }
  //     $GLOBALS['db']->commit();
  //   }
  //   catch( Exception $e ){
  //     $GLOBALS['db']->rollback();
  //     $_SESSION['mostrar_error'] = $e->getMessage();  
  //   }
  // }      
    
  // public function obtienePreguntaActual(){
  //   foreach($_SESSION['cuestionario'] as $pregunta){
  //     if (!isset($pregunta["respuesta"]) || empty($pregunta["respuesta"])){
  //        return $pregunta;
  //     }
  //   }
  //   return false;
  // }

  // public function vistaRenderCuestionario($vista){
  //   switch ($vista) {
  //     case 'metodo':
  //       # code...
  //       break;
      
  //     default:
  //       //metodo de selección

  //       break;
  //   }
  // }

}
?>
<?php
class Controlador_Cuestionariom2 extends Controlador_Base{
  
  public function construirPagina(){
    $opcion = Utils::getParam('opcion', '', $this->data);
    switch ($opcion) {
      case 'guardarresp':
          $orden = $_POST['respuestas_orden'];
          $opcion = $_POST['respuestas_opcion'];
          $tiempo = $_POST['tiempo'];
          $id_usuario = $_POST['id_usuario'];
          $pregunta = $_POST['pregunta'];
          $nropregunta = Utils::getParam('pre', 1, $this->data);
          $data = array('id_usuario'=>$id_usuario, 'opcion'=>$opcion, 'orden'=>$orden, 'tiempo'=>$tiempo, 'pregunta'=>$pregunta);
          self::guardarRespuestas($data);
          $_SESSION['id_pregunta'] = $pregunta;
          Utils::doRedirect(PUERTO.'://'.HOST.'/test');
          // self::renderscreen();
      break;
      default:
        if(isset($_SESSION['id_usuario'])){
          $pregunta = 1;
          if(isset($_SESSION['id_pregunta'])){
            $pregunta = $_SESSION['id_pregunta']+1;
          }
          self::renderscreen($pregunta);    
        }
        else{
          Utils::doRedirect(PUERTO.'://'.HOST.'/registro_test');
        }
      break;
    }         
  }

  public function guardarRespuestas($data){    
    try{ 
      $usuario = $data['id_usuario'];
      $orden = $data['orden'];
      $tiempo = $data['tiempo'];
      $opcion = $data['opcion'];
      $pregunta = $data['pregunta'];

      if (empty($usuario) || empty($orden) || empty($tiempo) || empty($opcion) || empty($pregunta)){
        throw new Exception("Error al guardar las opciones de la pregunta");
      }

      $fecha1 = new DateTime($tiempo);
      $fecha2 = new DateTime("now");
      $diferencia = $fecha1->diff($fecha2);
      $tiempo = $diferencia->format('%H:%i:%s');

      if (!Modelo_Usuario::buscaUsuario($usuario)){
        throw new Exception("Error el usuario no existe");
      }

      $opciones = Modelo_Opcion::obtieneOpciones($pregunta);
      if (empty($opciones)){
        throw new Exception("Error la pregunta no tiene opciones");
      }
      $all_selected = 0;
        for ($i=0; $i < count($opcion); $i++) { 
          if($opcion[$i] != 0){
            $all_selected++;
          }
        }

      if((count($orden) != count($opcion)) || count($opcion) != $all_selected){
        throw new Exception("Por favor, ordene todas las preguntas del lado izquierdo hacia el lado derecho de acuerdo a su prioridad.");
        
      }

      if (!Modelo_Respuesta::guardarValores($orden,$tiempo,$usuario,$opcion)){
        throw new Exception("Error al guardar las opciones de la pregunta");  
      }

    }
    catch( Exception $e ){      
      echo $e->getMessage();  
    }
  }


  public function renderscreen($pregunta){
    $nropregunta = $pregunta;
    //funcion que obtiene el total de preguntas
    $totalpreguntas = Modelo_Pregunta::totalPreguntas();
    if ($nropregunta < 1){ exit; }
    if ($nropregunta > $totalpreguntas['nro']){
      // echo "El Cuestionario fue completado exitosamente";
      $_SESSION['mostrar_exito'] = "Gracias por tu colaboración.";
      unset($_SESSION['id_usuario']);
      unset($_SESSION['id_pregunta']);
      Utils::doRedirect(PUERTO.'://'.HOST.'/registro_test');
    }
    //funcion que obtiene las opciones de una pregunta especifica    
    $opciones = Modelo_Opcion::obtieneOpciones($nropregunta);
    Vista::render('cuestionariom2',array('pregunta'=>$nropregunta, 'opciones'=>$opciones, 'tiempo'=>date("Y-m-d H:i:s"),'pre'=>$nropregunta), '', '');
  }
}
?>
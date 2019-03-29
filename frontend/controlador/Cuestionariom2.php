<?php
class Controlador_Cuestionariom2 extends Controlador_Base{
  
  public function construirPagina(){
    $opcion = Utils::getParam('opcion', '', $this->data);
    switch ($opcion) {
      case 'guardarresp':
      try{ 
        if(!isset($_POST['respuestas_orden']) && !isset($_POST['respuestas_opcion'])){
          throw new Exception("Error al guardar las opciones de la pregunta");
        }
          $orden = $_POST['respuestas_orden'];
          $opcion = $_POST['respuestas_opcion'];
          $tiempo = $_POST['tiempo'];
          $id_usuario = $_POST['id_usuario'];
          $pregunta = $_POST['pregunta'];
          $nropregunta = Utils::getParam('pre', 1, $this->data);
          $data = array('id_usuario'=>$id_usuario, 'opcion'=>$opcion, 'orden'=>$orden, 'tiempo'=>$tiempo, 'pregunta'=>$pregunta);
          self::guardarRespuestas($data);
          $_SESSION['id_pregunta'] = $pregunta;
        }
        catch( Exception $e ){      
          echo $e->getMessage();
          $_SESSION['mostrar_error'] = $e->getMessage();  
        }
        Utils::doRedirect(PUERTO.'://'.HOST.'/test');
      break;
      case 'metodo_resp':
        if(!isset($_SESSION['questions'])){
          Vista::render('metodo_seleccion', METODO_SELECCION, '', '');
        }
        else{
          Utils::doRedirect(PUERTO.'://'.HOST.'/registro_test');
        }
      break;
      case 'reg_var':
        if(!isset($_SESSION['questions'])){
          $_SESSION['questions'] = 1;
        }
        if(!isset($_SESSION['metodo_seleccionado_vista'])){
          $_SESSION['metodo_seleccionado_vista'] = "forma_".$_POST['seleccion'];
        }
        Utils::doRedirect(PUERTO.'://'.HOST.'/test');
      break;
      default:
        if(isset($_SESSION['id_usuario'])){
          $pregunta = 1;
          if(isset($_SESSION['id_pregunta'])){
            $pregunta = $_SESSION['id_pregunta']+1;
          }
          self::renderscreen($pregunta, $_SESSION['metodo_seleccionado_vista']);   
        }
        else{
          Utils::doRedirect(PUERTO.'://'.HOST.'/registroM');
        }
      break;
    }         
  }

  public function guardarRespuestas($data){
      $usuario = $data['id_usuario'];
      $orden = $data['orden'];
      $tiempo = $data['tiempo'];
      $opcion = $data['opcion'];
      $pregunta = $data['pregunta'];

      if (empty($usuario) || (empty($orden) && !is_array($orden)) || empty($tiempo) || (empty($opcion) && !is_array($opcion)) || empty($pregunta)){
        throw new Exception("Error al guardar las opciones de la pregunta");
      }

      if(!self::validarValoresRepetidos($orden)){
        throw new Exception("Por favor, verificar que no haya ingresado valores repetidos"); 
      }

      for ($i=0; $i < count($orden); $i++) { 
        if(!Utils::validarNumeros($orden[$i])){
          throw new Exception("El campo solo acepta números");
          
        }
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
          if($opcion[$i] != 0 && $opcion[$i] != null && $opcion[$i] != ""){
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


  public function renderscreen($pregunta, $vista){
    $nropregunta = $pregunta;
    //funcion que obtiene el total de preguntas
    $totalpreguntas = Modelo_Pregunta::totalPreguntas();
    if ($nropregunta < 1){ exit; }
    if ($nropregunta > $totalpreguntas['nro']){
      // echo "El Cuestionario fue completado exitosamente";
      $_SESSION['mostrar_exito'] = "Gracias por tu colaboración.";
      unset($_SESSION['id_usuario']);
      unset($_SESSION['id_pregunta']);
      Utils::doRedirect(PUERTO.'://'.HOST.'/registroM');
    }
    //funcion que obtiene las opciones de una pregunta especifica    
    $opciones = Modelo_Opcion::obtieneOpciones($nropregunta);
    Vista::render($vista,array('pregunta'=>$nropregunta, 'opciones'=>$opciones, 'tiempo'=>date("Y-m-d H:i:s"),'pre'=>$nropregunta), '', '');
  }

  public function validarValoresRepetidos($orden){
    for ($i=0; $i < count($orden); $i++) { 
      print_r($orden[$i]);
      for ($j=0; $j < count($orden); $j++) { 
        if($i != $j){
          if($orden[$i] == $orden[$j]){
             return false;
          }
        }
      }
    }
    return true;
  }
}
?>
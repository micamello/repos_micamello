<?php
class Controlador_Cuestionario extends Controlador_Base {
  
  function __construct(){
    global $_SUBMIT;
    $this->data = $_SUBMIT;
  }

  public function construirPagina(){
    if( !Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/login/');
    }
    //solo candidatos pueden ingresar a los test
    if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::CANDIDATO){
      Utils::doRedirect(PUERTO.'://'.HOST.'/'); 
    }

    $test = Modelo_Cuestionario::testActualxUsuario($_SESSION['mfo_datos']['usuario']['id_usuario']); 
    $nropreguntas = Modelo_Pregunta::obtieneNroPreguntasxTest($test);
    $preguntaact = Modelo_Pregunta::obtienePreguntaActual($_SESSION['mfo_datos']['usuario']['id_usuario'],$test);
    
    $opciones = Modelo_Opcion::listadoxPregunta($preguntaact);
    $nro_opc = count($opciones);

    if (Utils::getParam('form_pregunta') == 1){
      $this->guardarRespuestas($nro_opc,$test,$nropreguntas);
    }
        
    $pregunta = Modelo_Pregunta::obtienePreguntaxTest($preguntaact,$test);
    
    switch($test){
      case 1:
        $destest = "Primer";
      break;
      case 2:
        $destest = "Segundo";
      break;
      case 3:
        $destest = "Tercer";
      break;
    }

    $menu = $this->obtenerMenu();
    $hoy = date("Y-m-d H:i:s");
    $tags = array('menu'=>$menu,
                  'nrotest'=>$test,
                  'destest'=>$destest,
                  'nropreguntas'=>$nropreguntas,
                  'preguntaact'=>$preguntaact,
                  'pregunta'=>$pregunta,
                  'opciones'=>$opciones,
                  'tiempo'=>$hoy,
                  'menu'=>$menu);   

    if ($preguntaact == 1){
      $tags["template_js"][] = "cuestionario";
    }
    
    Vista::render('cuestionario', $tags);    
  }

  public function guardarRespuestas($nro_opc,$test,$nropreguntas){
    try{ 
      $campos = array('id_pregunta'=>1, 'id_opcion'=>1, 'tiempo'=>1, 'modo_pregunta'=>1, 'id_test'=>1);
      $data = $this->camposRequeridos($campos);    
      
      $fecha1 = new DateTime($data["tiempo"]);
      $fecha2 = new DateTime("now");
      $diferencia = $fecha1->diff($fecha2);
      $tiempo = $diferencia->format('%H:%i:%s');
        
      if ($data["modo_pregunta"] == Modelo_Pregunta::DIRECTA){
          $valor = $data["id_opcion"];
      }
      else{
          $valor = $nro_opc - ($data["id_opcion"] - 1);
      }
        
      if (!Modelo_Respuesta::guardarResp($valor,$data["id_opcion"],$tiempo,$_SESSION['mfo_datos']['usuario']['id_usuario'],$data["id_test"],$data["id_pregunta"])){
          throw new Exception("Error al registrar la respuesta, por favor intente denuevo");
      }

      $preguntaact = Modelo_Pregunta::obtienePreguntaActual($_SESSION['mfo_datos']['usuario']['id_usuario'],$test);      
      if ($preguntaact == ($nropreguntas+1)){
        $this->guardarCuestionario($test); 
        $_SESSION['mostrar_exito'] = "Formulario completado exitosamente"; 
        $this->redirectToController('velocimetro');
      }

    }
    catch( Exception $e ){
      $_SESSION['mostrar_error'] = $e->getMessage();  
    }
  }

  public function guardarCuestionario($test){
    $rasgos = Modelo_Rasgo::obtieneRasgoxTest($test);
    if (empty($rasgos)){
      throw new Exception("Error en el registro del total, por favor comuniquese con el administrador");
    }
    $total_rasgo = 0; $promedio = 0;
    foreach($rasgos as $rasgo){
      $preguntas_rasgo = Modelo_Pregunta::obtienePreguntaxRasgo($test, $rasgo["id_rasgo"]);
      $total_rasgo = $total_rasgo + Modelo_Respuesta::totalxRasgo($test,$preguntas_rasgo);      
    }
    $promedio = round($total_rasgo / count($rasgos));
    if (!Modelo_Cuestionario::guardarPorTest($promedio,$_SESSION['mfo_datos']['usuario']['id_usuario'],$test)){
      throw new Exception("Error al registrar el fin del formulario, por favor intente denuevo");
    }
  }      
    
}
?>
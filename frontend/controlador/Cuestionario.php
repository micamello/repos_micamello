<?php
class Controlador_Cuestionario extends Controlador_Base {
  
  function __construct(){
    global $_SUBMIT;
    $this->data = $_SUBMIT;
  }

  public function construirPagina(){
    
    $_SESSION['mostrar_exito'] = '';
    $_SESSION['mostrar_error'] = '';    

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

    $nrotest = Modelo_Cuestionario::totalTest();
    $test = Modelo_Cuestionario::testSiguientexUsuario($_SESSION['mfo_datos']['usuario']['id_usuario']); 
  
    if ((!isset($_SESSION['mfo_datos']['planes']) || 
        !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'],'tercerFormulario')) && 
        $test["orden"] == 3){
      $this->redirectToController('velocimetro');
    }
        
    if ($test["orden"] > $nrotest){
      $this->redirectToController('velocimetro');
    }

    $nropreguntas = Modelo_Pregunta::obtieneNroPreguntasxTest($test["id_cuestionario"]);
    $pregunta = Modelo_Pregunta::obtienePreguntaActual($_SESSION['mfo_datos']['usuario']['id_usuario'],$test["id_cuestionario"]);  
    $this->data["pregunta"] = $pregunta;
    $opciones = Modelo_Opcion::listadoxPregunta($pregunta["id_pre"]);
    $nro_opc = count($opciones);

    if (Utils::getParam('form_pregunta') == 1){
      $this->guardarRespuestas($nro_opc,$test["id_cuestionario"],$nropreguntas);
    }
        
    switch($test["orden"]){
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

    $hoy = date("Y-m-d H:i:s");
    $tags = array('nrotest'=>$test["orden"],
                  'destest'=>$destest,
                  'nropreguntas'=>$nropreguntas,
                  //'preguntaact'=>$preguntaact,
                  'pregunta'=>$this->data["pregunta"],
                  'opciones'=>$opciones,
                  'tiempo'=>$hoy);   

    if ($this->data["pregunta"]["orden"] == 1){
      $tags["template_js"][] = "cuestionario";
    }
    
    $arrbanner = Modelo_Banner::obtieneListado(Modelo_Banner::BANNER_CANDIDATO);
    $orden = rand(1,count($arrbanner))-1;
    $_SESSION['mostrar_banner'] = PUERTO.'://'.HOST.'/imagenes/banner/'.$arrbanner[$orden]['id_banner'].'.'.$arrbanner[$orden]['extension'];
    $tags["show_banner"] = 1;

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

      //si ya completo todas las preguntas del test envia al velocimetro
      if ($this->data["pregunta"]["orden"] == $nropreguntas){
        $this->guardarCuestionario($test); 
        $_SESSION['mostrar_exito'] = "Formulario completado exitosamente"; 
        $this->redirectToController('velocimetro');
      }
      else{
        $pregunta = Modelo_Pregunta::obtienePreguntaActual($_SESSION['mfo_datos']['usuario']['id_usuario'],$test);  
        $this->data["pregunta"] = $pregunta;    
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
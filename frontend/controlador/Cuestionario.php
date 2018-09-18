<?php
class Controlador_Cuestionario extends Controlador_Base {
  
  function __construct(){
    global $_SUBMIT;
    $this->data = $_SUBMIT;
  }

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
   
    $nrotest = Modelo_Cuestionario::totalTest();
    $test = Modelo_Cuestionario::testSiguientexUsuario($_SESSION['mfo_datos']['usuario']['id_usuario']);     
  
    if ((!isset($_SESSION['mfo_datos']['planes']) || 
        !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'],'tercerFormulario')) && 
        $test["orden"] == 3){
      $_SESSION['mostrar_error'] = "Debe comprar un plan para poder realizar el Tercer Formulario";  
      $this->redirectToController('planes');
    }
          
    if ($test["orden"] > $nrotest){
      $this->redirectToController('velocimetro');
    }

    if (!isset($_SESSION['cuestionario']) || empty($_SESSION['cuestionario'])){      
      $_SESSION['cuestionario'] = Modelo_Pregunta::preguntasxTest($test["id_cuestionario"]);      
      $mostrar_dialog = true;
    }    

    if (empty($_SESSION['cuestionario'])){
      $this->redirectToController('velocimetro');
    }

    $pregunta = self::obtienePreguntaActual();    

    $this->data["pregunta"] = $pregunta;
    
    $opciones = Modelo_Opcion::listadoxPregunta($pregunta["id_pre"]);
    $nro_opc = count($opciones);
    
    if (Utils::getParam('form_pregunta') == 1){
      $this->guardarRespuestas($nro_opc,$test["id_cuestionario"],$nrotest);
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
    
    $tags = array('nrotest'=>$test["orden"],
                  'destest'=>$destest,                  
                  'preguntas'=>$_SESSION['cuestionario'],
                  'preguntaact'=>$this->data["pregunta"],
                  'opciones'=>$opciones,
                  'tiempo'=>date("Y-m-d H:i:s"));   

    if ($mostrar_dialog){        
      $tags["template_js"][] = "cuestionario";
    }
    
    $arrbanner = Modelo_Banner::obtieneListado(Modelo_Banner::BANNER_CANDIDATO);
    $orden = rand(1,count($arrbanner))-1;
    $_SESSION['mostrar_banner'] = PUERTO.'://'.HOST.'/imagenes/banner/'.$arrbanner[$orden]['id_banner'].'.'.$arrbanner[$orden]['extension'];
    $tags["show_banner"] = 1;

    Vista::render('cuestionario', $tags, 'cabecera','',true);    
  }

  public function guardarRespuestas($nro_opc,$test,$nrotest){        
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
          
    $_SESSION['cuestionario'][$data['id_pregunta']]['respuesta'] = array("valor"=>$valor,"opcion"=>$data["id_opcion"],"tiempo"=>$tiempo); 
    $pregunta = self::obtienePreguntaActual();     

    if (empty($pregunta)){
      $this->guardarCuestionario($test,$nrotest); 
      unset($_SESSION['cuestionario']);
      $_SESSION['mostrar_exito'] = "Formulario completado exitosamente"; 
      $this->redirectToController('velocimetro');
    }
    else{
      $this->data["pregunta"] = $pregunta;    
    }      
  }

  public function guardarCuestionario($test,$nrotest){
    try{ 
      $GLOBALS['db']->beginTrans();
      if (empty($_SESSION['cuestionario'])){
        throw new Exception("Error en el registro del cuestionario, por favor comuniquese con el administrador");
      }
      foreach($_SESSION['cuestionario'] as $pregunta){   
        $tiempo = $pregunta["respuesta"]["tiempo"];      
        $opcion = $pregunta["respuesta"]["opcion"];
        $valor = $pregunta["respuesta"]["valor"];
        $usuario = $_SESSION['mfo_datos']['usuario']['id_usuario'];
        if (!Modelo_Respuesta::guardarResp($valor,$opcion,$tiempo,$usuario,$test,$pregunta["id_pre"])){
          throw new Exception("Error al registrar la respuesta, por favor intente denuevo");
        }
      }

      $rasgos = Modelo_Rasgo::obtieneRasgoxTest($test);
      if (empty($rasgos)){
        throw new Exception("Error en el registro del total, por favor comuniquese con el administrador");
      }
      $total_rasgo = 0; $promedio = 0;
      foreach($rasgos as $rasgo){
        $preguntas_rasgo = Modelo_Pregunta::obtienePreguntaxRasgo($test, $rasgo["id_rasgo"]);
        $valor_rasgo = Modelo_Respuesta::totalxRasgo($test,$preguntas_rasgo,$_SESSION['mfo_datos']['usuario']['id_usuario']);      
        if (!Modelo_ResultxRasgo::guardar($valor_rasgo,$_SESSION['mfo_datos']['usuario']['id_usuario'],$rasgo["id_rasgo"])){
          throw new Exception("Error en el registro del total, por favor comuniquese con el administrador");
        }
        $total_rasgo = $total_rasgo + $valor_rasgo; 
      }
      $promedio = round($total_rasgo / count($rasgos));
      
      if (!Modelo_Cuestionario::guardarPorTest($promedio,$_SESSION['mfo_datos']['usuario']['id_usuario'],$test)){
        throw new Exception("Error al registrar el fin del formulario, por favor intente denuevo");
      }
      $GLOBALS['db']->commit();
    }
    catch( Exception $e ){
      $GLOBALS['db']->rollback();
      $_SESSION['mostrar_error'] = $e->getMessage();  
    }
  }      
    
  public function obtienePreguntaActual(){
    foreach($_SESSION['cuestionario'] as $pregunta){
      if (!isset($pregunta["respuesta"]) || empty($pregunta["respuesta"])){
         return $pregunta;
      }
    }
    return false;
  }

}
?>
<?php
class Controlador_Velocimetro extends Controlador_Base {
  
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

    $opcion = Utils::getParam('opcion','',$this->data);  
    switch($opcion){      
      case 'cargarcv':
        $this->cargarCV();
      break;      
    } 
    $this->mostrarDefault();     
  }

  public function cargarCV(){
    try {          
      if(!isset($_FILES['subirCV'])){
        throw new Exception("Debe subir un archivo con formato pdf o word");         
      }            
      $validaFile = Utils::valida_upload($_FILES['subirCV'], 2);
      if (empty($validaFile)) {
          throw new Exception("El archivo debe tener formato .pdf .doc .docx y con un peso máx de 2MB");
      }
      $arch = Utils::validaExt($_FILES['subirCV'], 2);
      
      $infohv = Modelo_InfoHv::obtieneHv($_SESSION['mfo_datos']['usuario']['id_usuario']);
      if (empty($infohv)){
        if (!Modelo_InfoHv::cargarHv($_SESSION['mfo_datos']['usuario']['id_usuario'], $arch[1])) {
          throw new Exception("Ha ocurrido un error al guardar el archivo, intente nuevamente");
        } 
        else {
          Utils::upload($_FILES['subirCV'], $_SESSION['mfo_datos']['usuario']['id_usuario'], PATH_ARCHIVO, 2);
        }
        $_SESSION['mfo_datos']['infohv'] = Modelo_InfoHv::obtieneHv($_SESSION['mfo_datos']['usuario']['id_usuario']);
      }       
      $_SESSION['mostrar_exito'] = 'Hoja de vida actualizada exitosamente';          
    } 
    catch (Exception $e) {
      $_SESSION['mostrar_error'] = $e->getMessage();      
    }
  } 

  public function mostrarDefault(){
    $cuestionario = Modelo_Cuestionario::testxUsuario($_SESSION['mfo_datos']['usuario']["id_usuario"]);
    if (empty($cuestionario)){
      $this->redirectToController('cuestionario');
    }
    
    $nrototaltest = Modelo_Cuestionario::totalTest();
    $nrotestusuario = count($cuestionario);

    $porcentajextest = round(100 / $nrototaltest);
    $valorporc = 0;
    foreach($cuestionario as $test){
      $valorporc = $valorporc + round(($test["valor"] * $porcentajextest) / Modelo_Cuestionario::PUNTAJEMAX);
    }    
    $descrporc = ($valorporc > 25) ? "Medianas" : "Bajas";    
    $testactual = array_pop($cuestionario);
    $imagengif = ($nrotestusuario < $nrototaltest) ? "gif-lo-quiero.gif" : "gif_felicidades.gif";
    
    if ($testactual["orden"] < 2){
      $enlaceboton = "cuestionario";
    }
    else{
      if (isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'],'tercerFormulario')){
        $enlaceboton = "cuestionario";
      } 
      elseif(isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'],'cargarHv') && !isset($_SESSION['mfo_datos']['infohv'])){        
        $enlaceboton = "cargarHv";
      }
      else{
        $enlaceboton = "planes";
      }
    }

    $tags["testactual"] = $testactual;
    $tags["nrototaltest"] = $nrototaltest;
    $tags["nrotestusuario"] = $nrotestusuario;
    $tags["valorporc"] = $valorporc;
    $tags["descrporc"] = $descrporc;
    $tags["imagengif"] = $imagengif;
    $tags["enlaceboton"] = $enlaceboton;

    $tags["template_js"][] = "d3.v3.min";
    $tags["template_js"][] = "velocimetro";
    $tags["template_css"][] = "velocimetro";

    Vista::render('velocimetro', $tags);    
  }
}  
?>
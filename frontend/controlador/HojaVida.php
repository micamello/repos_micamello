<?php
class Controlador_HojaVida extends Controlador_Base{
  
  public function construirPagina(){
    if(!Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/login/');
    }

    $causer = Modelo_Respuesta::facetaSiguiente($_SESSION['mfo_datos']['usuario']['id_usuario']);
    $opcion = Utils::getParam('opcion','',$this->data);
    
    if($causer != (MAX_PFACETA+1) || empty($causer)){
       Utils::doRedirect(PUERTO.'://'.HOST.'/');
    }
    if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA || (isset($_SESSION['mfo_datos']['usuario']['infohv']) || !empty($_SESSION['mfo_datos']['usuario']['infohv'])) && $opcion != "hvcargado"){
      Utils::doRedirect(PUERTO.'://'.HOST.'/');
    }

    $buscar = "";
    switch($opcion){
      case 'hvusuario':
        $this->validarHv($_FILES);
      break;
      case 'hvcargado':
        $rutahvloaded = "cuestionario";
        Vista::render('hvcargado', array("rutahvloaded"=>$rutahvloaded));
      break;
      default:
        $this->mostrarDefault();
      break;
    }

    // $this->mostrarDefault();
       
  }

  public function mostrarDefault(){
    $tags["template_js"][] = "hvFileVal";
    Vista::render('cargarHV', $tags); 
  }

  public function validarHv($file){
    if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){
      $ruta = "";
      try {
          if(($file['userHV']['name'] == "") || $file['userHV']['name'] == null){
            throw new Exception("Por favor, cargue su hoja de vida.");
          }
          $extensionHV = Utils::validaExt($file['userHV'], 2);
          if(!$extensionHV[0]){
            throw new Exception("Formato de archivo no admitido.");
          }

          if($file['userHV']['size'] > PESO_ARCHIVO){
            throw new Exception("El tama\u00F1o de archivo excede lo permitido. (2 MB)");
          }
        

        if(empty($_SESSION['mfo_datos']['usuario']['infohv'])){
          if(Modelo_InfoHv::cargarHv($_SESSION['mfo_datos']['usuario']['id_usuario'], $extensionHV[1])){
            if(!Utils::upload($file['userHV'],$_SESSION['mfo_datos']['usuario']['username'],PATH_ARCHIVO, 2)){
              throw new Exception("Ha ocurrido un error al cargar el archivo. Intente nuevamente.");
            }
            else{
              $sess_usuario = Modelo_Usuario::actualizarSession($_SESSION['mfo_datos']['usuario']['id_usuario'],$_SESSION['mfo_datos']['usuario']['tipo_usuario']);
              Controlador_Login::registroSesion($sess_usuario);
              // Utils::log("data: ".print_r($sess_usuario, true));

              $ruta = '/hvcargado/';
              // exit();
            }
          }
          else{
            throw new Exception("Ha ocurrido un error al registrar su Hoja de vida. Intente nuevamente.");
          }
        }
        // Utils::upload($file['userHV'], $_SESSION['mfo_datos']['usuario']['username'], PATH_ARCHIVO, 2);

      } catch (Exception $e) {
        $ruta = '/cargarhojavida/';
        $_SESSION['mostrar_error'] = $e->getMessage();
        Utils::doRedirect(PUERTO . '://' . HOST . $ruta);
      }
      echo $ruta;
      // exit();
      Utils::doRedirect(PUERTO . '://' . HOST . $ruta);
    }
  }
}
?>
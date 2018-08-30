<?php
class Controlador_Recomendacion extends Controlador_Base {
  
  function __construct(){
    global $_SUBMIT;
    $this->data = $_SUBMIT;
  }
  
  public function construirPagina(){

    try {

      if (Utils::getParam('enviarRecomendacion') == 1) {
        $campos = array('nombres' => 1, 'correo' => 1, 'telefono' => 1, 'descripcion' => 1);
        $data = $this->camposRequeridos($campos);
        
        if(self::envioRecomendaciones(MAIL_SUGERENCIAS,$data)){
          $_SESSION['mostrar_exito'] = 'Sus recomendaciones han sido enviadas exitosamente';
        }else{
          $_SESSION['mostrar_error'] = 'El correo con sus recomendaciones falló, intente de nuevo';
        }
      }

    } catch (Exception $e) {
        $_SESSION['mostrar_error'] = $e->getMessage();
    }

    $tags["template_js"][] = "selectr";
    $tags["template_js"][] = "validator";
    $tags["template_js"][] = "mic";
    Vista::render('recomendaciones', $tags);
  }

  public function envioRecomendaciones($correo,$data){

    $asunto = "Recomendaciones o sugerencias";
    $body = "Estimado, ".MAIL_NOMBRE."<br>";
    $body .= "Sugerencia: ".$data['descripcion']."<br>Este correo fue enviado por ".$data['nombres']." y si desea comunicarse con el destinatario comuniquese al ".$data['correo']." o al tlf. ".$data['telefono'];
    if (Utils::envioCorreo($correo,$asunto,$body)){
      return true;
    }
    else{
      return false;
    }
  }
}  
?>
<?php
class Controlador_Recomendacion extends Controlador_Base {
  
  public function construirPagina(){
    $this->linkRedesSociales();
    $social_reg = array('fb'=>$this->loginURL, 'gg'=>$this->gg_URL, 'lk'=>$this->lk, 'tw'=>$this->tw);
    $tags = array('social'=>$social_reg);

    try {
      if (Utils::getParam('enviarRecomendacion') == 1) {
        $campos = array('nombres' => 1, 'correo1' => 1, 'telefono' => 1, 'descripcion' => 1);
        $data = $this->camposRequeridos($campos);
        $datos_correo = array_merge($data, array("tipo"=>7, "destinatario"=>MAIL_NOMBRE, "correo"=>MAIL_SUGERENCIAS));
        if(Utils::enviarEmail($datos_correo)){
          $_SESSION['mostrar_exito'] = 'Sus recomendaciones han sido enviadas exitosamente';
        }else{
          $_SESSION['mostrar_error'] = 'El correo con sus recomendaciones falló, intente de nuevo';
        }
      }
    } catch (Exception $e) {
        $_SESSION['mostrar_error'] = $e->getMessage();
    }
    $tags["template_js"][] = "modal-register";
    $tags["template_js"][] = "mic";
    Vista::render('recomendaciones', $tags);
  }
  // public function envioRecomendaciones($correo,$data){
  //   $asunto = "Recomendaciones o sugerencias";
  //   $body = "Estimado, ".MAIL_NOMBRE."<br>";
  //   $body .= "Sugerencia: ".$data['descripcion']."<br>Este correo fue enviado por ".$data['nombres']." y si desea comunicarse con el destinatario comuniquese al ".$data['correo1']." o al tlf. ".$data['telefono'];
  //   if (Utils::envioCorreo($correo,$asunto,$body)){
  //     return true;
  //   }
  //   else{
  //     return false;
  //   }
  // }
}  
?>
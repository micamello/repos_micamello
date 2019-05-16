<?php
class Controlador_Recomendacion extends Controlador_Base {
  
  public function construirPagina(){
    $this->linkRedesSociales();
    $social_reg = array('fb'=>$this->loginURL, 'gg'=>$this->gg_URL, 'lk'=>$this->lk, 'tw'=>$this->tw);
    $arrgenero = Modelo_Genero::obtenerListadoGenero();
    $arrsectorind = Modelo_SectorIndustrial::consulta();
    $tags = array('social'=>$social_reg,
                  'genero'=>$arrgenero,
                  'arrsectorind'=>$arrsectorind);

    /*if( Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/perfil/');
    }*/
    
    try {
      if (Utils::getParam('enviarRecomendacion') == 1) {
        $campos = array('nombres' => 1, 'correo1' => 1, 'telefono' => 1, 'descripcion' => 1);
        $data = $this->camposRequeridos($campos);
        
        if(self::envioRecomendaciones(MAIL_SUGERENCIAS,$data)){

          if(self::envioRecomendacionesUser($data)){
            $_SESSION['mostrar_exito'] = 'Sus recomendaciones han sido enviadas exitosamente';
            Utils::doRedirect(PUERTO.'://'.HOST.'/');
          }else{
            $_SESSION['mostrar_error'] = 'El correo con sus recomendaciones fall\u00F3, intente de nuevo';
            Utils::doRedirect(PUERTO.'://'.HOST.'/recomendacion/');
          }
        }else{
          $_SESSION['mostrar_error'] = 'El correo con sus recomendaciones fall\u00F3, intente de nuevo';
        }
      }
    } catch (Exception $e) {
        $_SESSION['mostrar_error'] = $e->getMessage();
    }
    $tags = array('vista'=>'recomendacion');
    Vista::render('recomendaciones', $tags);
  }

  public function envioRecomendaciones($correo,$data){
    $email_body = Modelo_TemplateEmail::obtieneHTML("SUGERENCIAS");
    $email_body = str_replace("%NOMBRES%", MAIL_NOMBRE, $email_body);   
    $email_body = str_replace("%SUGERENCIA%", $data['descripcion'], $email_body);
    $email_body = str_replace("%USUARIO%", $data['nombres'], $email_body);
    $email_body = str_replace("%CORREO%", $data['correo1'], $email_body);
    $email_body = str_replace("%TELEFONO%", $data['telefono'], $email_body);    
    if (Utils::envioCorreo($correo,"Recomendaciones o Sugerencias",$email_body)){
      return true;
    }
    else{
      return false;
    }
  }

  public function envioRecomendacionesUser($data){
    $email_body = Modelo_TemplateEmail::obtieneHTML("SUGERENCIAS_USUARIO");
    $email_body = str_replace("%NOMBRES%", $data['nombres'], $email_body);   
    $email_body = str_replace("%SUGERENCIA%", $data['descripcion'], $email_body);   
    if (Utils::envioCorreo($data['correo1'],"Recomendaciones o Sugerencias",$email_body)){
      return true;
    }
    else{
      return false;
    }
  }
}  
?>
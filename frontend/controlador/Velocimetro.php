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
    /*if ($_SESSION"'mfo_datos'""'usuario'""'tipo_usuario'" != Modelo_Usuario::CANDIDATO){
      Utils::doRedirect(PUERTO.'://'.HOST.'/'); 
    }*/


    $datos = Modelo_Ciudad::obtieneCiudadxProvincia(1);

    print_r($datos);
    Vista::renderJSON($datos);
    //Vista::render('velocimetro', $tags);    

  }
}  
?>
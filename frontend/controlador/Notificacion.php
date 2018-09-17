<?php
class Controlador_Notificacion extends Controlador_Base {
  
  function __construct(){
    global $_SUBMIT;
    $this->data = $_SUBMIT;
  }
  
  public function construirPagina(){

    if( !Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/login/');
    }

    $id_notificacion = Utils::getParam('id_notificacion','',$this->data);  
    $r = Modelo_Notificacion::desactivarNotificacion($id_notificacion);
    if($r){
      $value = true;
    }else{
      $value = false;
    }
    Vista::renderJSON(array('resultado'=>$value));
  }


}  
?>
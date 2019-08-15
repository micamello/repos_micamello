<?php
class Controlador_Logout extends Controlador_Base {
  
  public function construirPagina(){
    //Utils::log(__METHOD__ . ' Login out');
	
    if( Modelo_Usuario::estaLogueado() ){      
      session_regenerate_id(true);
      session_destroy();
    }
    Utils::doRedirect(PUERTO.'://'.HOST.'/');
  }

}
?>
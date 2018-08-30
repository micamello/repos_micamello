<?php
class Modelo_ResultxRasgo{
  
  public static function guardar($valor,$usuario,$rasgo){  	
  	if (empty($valor) || empty($usuario) || empty($rasgo)){ return false; }
  	return $GLOBALS['db']->insert('mfo_resultxrasgo',array('valor'=>$valor,'id_usuario'=>$usuario,'id_rasgo'=>$rasgo));
  }

}  
?>
<?php
class Modelo_Cuestionario{

	public static function testActualxUsuario($usuario){
		if (empty($usuario)){ return false; }
		$sql = "select id_cuestionario from mfo_porcentajextest where id_usuario = ".$usuario." order by id_cuestionario desc limit 1";
		$rs = $GLOBALS['db']->auto_array($sql,array());
		return ((empty($rs["id_cuestionario"])) ? 1 : $rs["id_cuestionario"] + 1); 
	}

	public static function guardarPorTest($valor,$usuario,$test){
		if (empty($valor) || empty($usuario) || empty($test)){ return false; }		
		return $GLOBALS['db']->insert('mfo_porcentajextest',array('valor'=>$valor,'id_usuario'=>$usuario,'id_cuestionario'=>$test));
	}
}  
?>
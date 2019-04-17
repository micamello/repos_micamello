<?php
class Modelo_SituacionLaboral{

	public static function obtenerListadoSituacionLaboral(){
    	$sql = "SELECT * FROM mfo_situacionlaboral LIMIT 1";
    	return $GLOBALS['db']->auto_array($sql,array());
	}

}  
?>
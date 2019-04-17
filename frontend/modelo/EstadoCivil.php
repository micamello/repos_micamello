<?php
class Modelo_EstadoCivil{

	public static function obtenerListadoEstadoCivil(){
    	$sql = "SELECT * FROM mfo_estadocivil LIMIT 1";
    	return $GLOBALS['db']->auto_array($sql,array());
	}

}  
?>
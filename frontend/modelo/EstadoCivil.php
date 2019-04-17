<?php
class Modelo_EstadoCivil{

	public static function obtieneListado(){
    	$sql = "SELECT * FROM mfo_estadocivil";
    	return $GLOBALS['db']->auto_array($sql,array(), true);

	}

}  
?>
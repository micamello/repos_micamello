<?php
class Modelo_SituacionLaboral{

	public static function obtieneListado(){
    	$sql = "SELECT * FROM mfo_situacionlaboral";
    	return $GLOBALS['db']->auto_array($sql,array(), true);
	}

}  
?>
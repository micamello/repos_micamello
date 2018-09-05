<?php 
class Modelo_NivelIdioma{
	public static function obtieneListado(){
		$sql = "SELECT * from mfo_nivelidioma";
    	return $GLOBALS['db']->auto_array($sql,array(),true);
	}
}
 ?>
<?php
class Modelo_Cargo{

	public static function consulta(){
		$sql = "SELECT * FROM mfo_cargo";
		return $GLOBALS['db']->auto_array($sql,array(),true);
	}
}
?>
<?php
/*Modelo que servira para la tabla de candidatos(usuario) y para la tabla de empresas*/
class Modelo_OcupacionTest{
	public static function obtenerListado(){
		$sql = "SELECT * FROM mfo_ocupacionm2";
    	return $GLOBALS['db']->auto_array($sql,array(),true);
	}
}

?>
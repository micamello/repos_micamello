<?php
/*Modelo que servira para la tabla de candidatos(usuario) y para la tabla de empresas*/
class Modelo_ProfesionTest{
	public static function obtenerListado(){
		$sql = "SELECT * FROM mfo_profesionm2";
    	return $GLOBALS['db']->auto_array($sql,array(),true);
	}
}

?>
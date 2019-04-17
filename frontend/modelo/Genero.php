<?php
class Modelo_Genero{

	public static function obtenerListadoGenero(){
    $sql = "SELECT * FROM mfo_genero";
    return $GLOBALS['db']->auto_array($sql,array(), true);
	}

}  
?>
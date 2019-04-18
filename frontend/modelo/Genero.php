<?php
class Modelo_Genero{

	public static function obtenerListadoGenero(){
    	$sql = "SELECT * FROM mfo_genero";
    	return $GLOBALS['db']->auto_array($sql,array(), true);
	}

	public static function obtieneGenero($idGenero){
    	$sql = "SELECT g.descripcion FROM mfo_genero g WHERE g.id_genero = ?";
    	return $GLOBALS['db']->auto_array($sql,array($idGenero));
	}

}  
?>
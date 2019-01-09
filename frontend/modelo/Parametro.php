<?php
class Modelo_Parametro{

	public static function obtieneValor($nombre){
    if (empty($nombre)){ return false; }
    $sql = "SELECT descripcion FROM mfo_parametro WHERE nombre = ?";
    $descripcion = $GLOBALS['db']->auto_array($sql,array($nombre));
    return $descripcion["descripcion"];
	}
}
?>	
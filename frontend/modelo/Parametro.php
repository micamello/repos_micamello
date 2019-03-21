<?php
class Modelo_Parametro{

	public static function obtieneValor($nombre){
	    if (empty($nombre)){ return false; }
	    $sql = "SELECT descripcion FROM mfo_parametro WHERE nombre = ?";
	    $descripcion = $GLOBALS['db']->auto_array($sql,array($nombre));
	    return $descripcion["descripcion"];
	}

	public static function actualizarNroFactura(){    
    return $GLOBALS['db']->execute("UPDATE mfo_parametro SET descripcion = descripcion + 1 WHERE nombre = 'numerofactura'");
	}
}
?>	
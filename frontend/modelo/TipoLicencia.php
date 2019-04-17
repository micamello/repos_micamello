<?php
class Modelo_TipoLicencia{

	public static function obtieneListado(){
    	$sql = "SELECT * FROM mfo_tipolicencia";
    	return $GLOBALS['db']->auto_array($sql,array(), true);
	}

}  
?>
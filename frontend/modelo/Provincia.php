<?php
class Modelo_Provincia{
  
  public static function obtieneListado(){

    $sql = "SELECT * FROM mfo_provincia";
    return $GLOBALS['db']->auto_array($sql,array(),true);

  }

  public static function obtieneProvincia($idCiudad){

  	$sql = "SELECT p.id_provincia FROM mfo_ciudad c, mfo_provincia p WHERE c.id_provincia = p.id_provincia
			AND c.id_ciudad = $idCiudad;";
    return $GLOBALS['db']->auto_array($sql,array());
  }
  
}  
?>
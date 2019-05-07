<?php
class Modelo_RasgoGeneral{
  
  public static function obtieneRasgosGeneral($test, $porcentaje){
  	if (empty($test) || empty($porcentaje)){ return false; }
  	$sql = "SELECT descripcion FROM mfo_rasgo_general WHERE id_cuestionario = $test AND min_rango<=$porcentaje AND max_rango>=$porcentaje;";
    return $GLOBALS['db']->auto_array($sql,array());
  }
  
}  
?>
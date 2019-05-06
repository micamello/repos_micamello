<?php
class Modelo_Rasgo{
  
  public static function obtieneRasgoxTest($test){
  	if (empty($test)){ return false; }
    $sql = "SELECT * FROM mfo_rasgo WHERE id_cuestionario = ?";
    return $GLOBALS['db']->auto_array($sql,array($test),true);
  }
  
}  
?>
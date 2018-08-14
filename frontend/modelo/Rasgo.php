<?php
class Modelo_Rasgo{
  
  public static function obtieneRasgoxTest($test){
  	if (empty($test)){ return false; }
    $sql = "select * from mfo_rasgo where id_cuestionario = ?";
    return $GLOBALS['db']->auto_array($sql,array($test),true);
  }
  
}  
?>
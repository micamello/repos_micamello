<?php
class Modelo_Area{
  
  public static function obtieneListado(){
    $sql = "SELECT * FROM mfo_area";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
  
}  
?>

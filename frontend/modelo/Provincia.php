<?php
class Modelo_Provincia{
  
  public static function obtieneListado(){
    $sql = "select * from mfo_provincia";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
  
}  
?>
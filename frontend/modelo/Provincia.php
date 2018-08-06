<?php
class Modelo_Provincia{
  
  public static function obtieneListado(){
    $sql = "select * from mfo_provincias";
    return $GLOBALS['db']->auto_array($sql,array(),MYSQL_ASSOC,true);
  }
  
}  
?>
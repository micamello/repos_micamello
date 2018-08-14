<?php
class Modelo_Provincia{
  
  public static function obtieneListado(){
    $sql = "SELECT * FROM mfo_provincia";
    return $GLOBALS['db']->auto_array($sql,array(),MYSQL_ASSOC,true);
  }
  
}  
?>
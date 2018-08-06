<?php
class Modelo_Interes{
  
  public static function obtieneListado(){
    $sql = "SELECT * from mfo_intereses";
    return $GLOBALS['db']->auto_array($sql,array(),MYSQL_ASSOC,true);
  }
  
}  
?>
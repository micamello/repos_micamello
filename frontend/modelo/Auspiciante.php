<?php
class Modelo_Auspiciante{
  
  public static function obtieneListado(){
    $sql = "SELECT imagen FROM mfo_marcas where estado = 1";
    return $GLOBALS['db']->auto_array($sql,array(),MYSQL_ASSOC,true);
  }
  
}  
?>
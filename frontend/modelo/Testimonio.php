<?php
class Modelo_Testimonio{
  
  public static function obtieneListado(){
    $sql = "SELECT nombre, profesion, imagen, descripcion FROM mfo_exitos where estado = 1";
    return $GLOBALS['db']->auto_array($sql,array(),MYSQL_ASSOC,true);
  }
  
}  
?>
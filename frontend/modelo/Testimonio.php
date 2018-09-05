<?php
class Modelo_Testimonio{
  
  public static function obtieneListado(){
    $sql = "SELECT * FROM mfo_testimonio where estado = 1 ORDER BY orden LIMIT 3";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
  
}  
?>
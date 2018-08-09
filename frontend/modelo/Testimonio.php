<?php
class Modelo_Testimonio{
  
  public static function obtieneListado(){
    $sql = "SELECT * FROM mfo_testimonio where estado = 1 ORDER BY orden";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
  
}  
?>
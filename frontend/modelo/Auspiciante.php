<?php
class Modelo_Auspiciante{
  
  public static function obtieneListado(){
    $sql = "SELECT imagen FROM mfo_auspiciante where estado = 1 ORDER BY orden";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
  
}  
?>
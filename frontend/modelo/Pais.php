<?php
class Modelo_Pais{
  
  public static function obtieneListado(){
    $sql = "SELECT * FROM mfo_pais";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
  
}  
?>

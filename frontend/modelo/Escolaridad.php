<?php
class Modelo_Escolaridad{
  
  public static function obtieneListado(){
    $sql = "SELECT * FROM mfo_escolaridad";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
  
}  
?>

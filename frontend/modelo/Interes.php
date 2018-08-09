<?php
class Modelo_Interes{
  
  public static function obtieneListado(){
    $sql = "SELECT * from mfo_nivelinteres";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
  
}  
?>
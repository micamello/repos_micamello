<?php
class Modelo_PalabrasObscenas{
  
  public static function obtienePalabras(){
    $sql = "SELECT * FROM mfo_palabrasob;";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
  
}  
?>

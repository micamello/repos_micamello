<?php
class Modelo_NivelxIdioma{
  
  public static function obtieneListado(){
    $sql = "SELECT * FROM mfo_nivelidioma_idioma";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
  
}  
?>

<?php 
class Modelo_Idioma{
  
  public static function obtieneListado(){
    $sql = "SELECT * from mfo_idioma";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }

  
  
} 
 ?>
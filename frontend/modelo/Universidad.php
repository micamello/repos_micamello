<?php
class Modelo_Universidad{
  
  public static function obtieneListado($id_pais){
    $sql = "SELECT * FROM mfo_universidades WHERE id_pais = $id_pais ORDER BY nombre;";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
}  
?>
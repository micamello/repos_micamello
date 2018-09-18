<?php
class Modelo_Universidad{
  
  public static function obtieneListado($id_pais){
    $sql = "SELECT * FROM mfo_universidades u WHERE u.id_pais = $id_pais ORDER BY u.nombre;";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
}  
?>


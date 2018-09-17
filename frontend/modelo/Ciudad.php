<?php
class Modelo_Ciudad{
  
  public static function obtieneCiudadxProvincia($id_provincia){

    $sql = "SELECT c.id_ciudad, c.nombre as ciudad
            FROM mfo_ciudad c, mfo_provincia p
            WHERE c.id_provincia = p.id_provincia AND c.id_provincia = $id_provincia ORDER BY c.nombre ASC";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
  
}  
?>

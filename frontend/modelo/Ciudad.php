<?php
class Modelo_Ciudad{
  
  public static function obtieneCiudadxProvincia($id_provincia){

    $sql = "SELECT c.id_ciudad, c.nombre as ciudad
            FROM micamello_base.mfo_ciudad c, micamello_base.mfo_provincia p
            WHERE c.id_provincia = p.id_provincia AND c.id_provincia = $id_provincia;";
    return $GLOBALS['db']->auto_array($sql,array(),MYSQL_ASSOC,true);
  }
  
}  
?>

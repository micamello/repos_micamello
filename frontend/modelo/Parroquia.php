<?php
class Modelo_Parroquia{
  
  public static function obtieneParroquiaxCanton($id_canton){
    $sql = "SELECT * FROM mfo_parroquia WHERE id_ciudad = ?";
    return $GLOBALS['db']->auto_array($sql,array($id_canton),true);

  }
}  
?>
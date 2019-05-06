<?php
class Modelo_Caracteristica{
  
  public static function obtieneCaracteristicas($id_rasgo, $caracteristicas){
    $sql = "SELECT * FROM mfo_caracteristica WHERE id_rasgo = $id_rasgo AND  num_car IN($caracteristicas);";
    return $GLOBALS['db']->auto_array($sql,array(), true);
  }

}  
?>

<?php
class Modelo_MejoraFortalezas{
  
  public static function obtieneMejoraFortalezas($tipo, $rango, $id_rasgo){

    $sql = "SELECT nombre FROM mfo_for_mej WHERE id_tipo_for_mej = $tipo AND max_rango>=$rango AND min_rango <= $rango AND id_rasgo = $id_rasgo;";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
  
}  
?>
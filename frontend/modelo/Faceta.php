<?php
class Modelo_Faceta{
  
  public static function consultaIndividual($idfaceta){
    if (empty($idfaceta)){ return false; }
    $sql = "SELECT descripcion, introduccion
            FROM mfo_facetam2
            WHERE id_faceta = ? LIMIT 1";
    return $GLOBALS['db']->auto_array($sql,array($idfaceta));
  }
  
}  
?>
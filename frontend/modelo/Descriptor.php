<?php
class Modelo_Descriptor{
  
  public static function obtieneTextos($competencia='',$puntaje=''){
  	if (empty($competencia) || empty($puntaje)){ return false; }
    $sql = "SELECT descripcion FROM mfo_descriptor 
            WHERE id_competencia = ? AND id_puntaje = ? LIMIT 1";
    return $GLOBALS['db']->auto_array($sql,array($competencia,$puntaje));
  }
  
}  
?>
<?php
class Modelo_Baremo{
  
  public static function obtienePuntaje($orden1='',$orden2='',$orden3='',$orden4='',$orden5=''){
  	if (empty($orden1) || empty($orden2) || empty($orden3) || empty($orden4) || empty($orden5)){ return false; }
    $sql = "SELECT porcentaje, id_puntaje 
            FROM mfo_baremo 
            WHERE orden1 = ? AND orden2 = ? AND orden3 = ? AND orden4 = ? AND orden5 = ?
            LIMIT 1";
    return $GLOBALS['db']->auto_array($sql,array($orden1,$orden2,$orden3,$orden4,$orden5));
  }
  
}  
?>
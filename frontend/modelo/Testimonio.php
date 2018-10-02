<?php
class Modelo_Testimonio{
  
  public static function obtieneListado($pais){
  	if (empty($pais)){ return false; }
    $sql = "SELECT * FROM mfo_testimonio where estado = 1 AND id_pais = ? ORDER BY orden LIMIT 3";
    return $GLOBALS['db']->auto_array($sql,array($pais),true);
  }
  
}  
?>
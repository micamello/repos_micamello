<?php
class Modelo_Plan{
  
  const CANDIDATO = 1;
  const EMPRESA = 2;
  const PAQUETE = 2;
  const AVISO = 1;

  public static function listadoxTipo($tipo,$sucursal,$tipoplan){
  	if (empty($tipo) || empty($sucursal) || empty($tipoplan)){ return false; }
    $sql = "SELECT * FROM mfo_plan 
            WHERE tipo_usuario = ? AND estado = 1 AND id_sucursal = ? AND tipo_plan = ? 
            ORDER BY duracion ASC";
    return $GLOBALS['db']->auto_array($sql,array($tipo,$sucursal,$tipoplan),true);
  }
  
  public static function busquedaActivoxTipo($plan,$tipo,$sucursal){
    if (empty($plan) || empty($tipo) || empty($sucursal)){ return false; }
    $sql = "SELECT * FROM mfo_plan WHERE estado = 1 AND id_plan = ? AND tipo_usuario = ? AND id_sucursal = ?";
    return $GLOBALS['db']->auto_array($sql,array($plan,$tipo,$sucursal));    
  }
}  
?>
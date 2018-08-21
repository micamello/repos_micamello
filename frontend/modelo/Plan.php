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
  
}  
?>
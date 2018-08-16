<?php
class Modelo_Plan{
  
  const CANDIDATO = 1;
  const EMPRESA = 2;

  public static function listadoxTipo($tipo){
    $sql = "select * from mfo_plan where tipo_usuario = 1 and estado = 1 order by duracion asc";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
  
}  
?>
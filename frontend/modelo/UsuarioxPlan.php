<?php
class Modelo_UsuarioxPlan{

  public static function planesActivos($usuario){
  	if (empty($usuario)){ return false; }
    $sql = "select * from mfo_usuario_plan where id_usuario = ? and estado = 1 and fecha_caducidad <= NOW()";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
  
}  
?>
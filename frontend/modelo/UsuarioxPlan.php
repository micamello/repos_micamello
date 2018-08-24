<?php
class Modelo_UsuarioxPlan{

  public static function planesActivos($usuario){
  	if (empty($usuario)){ return false; }
    $sql = "SELECT * FROM mfo_usuario_plan WHERE id_usuario = ? AND estado = 1 AND (fecha_caducidad > NOW() || fecha_caducidad IS NULL)";
    return $GLOBALS['db']->auto_array($sql,array($usuario),true);
  }
  
  public static function permisoPostular($idUsuario){

  	if (empty($idUsuario)){ return false; }

    $sql = "SELECT * FROM mfo_usuario_plan WHERE id_usuario = ? AND estado = 1 ORDEN BY id_usuario_plan";
    return $GLOBALS['db']->auto_array($sql,array($idUsuario),true);
  }
}  
?>
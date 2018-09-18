<?php
class Modelo_Notificacion{
  
  const WEB = 1;
  const CORREO = 2;
  const SMS = 3;

  public static function notificacionxUsuario($usuario,$tipo){
  	if (empty($usuario) || empty($tipo)){ return false; }
    $sql = "SELECT url,descripcion FROM mfo_notificacion WHERE estado = 1 AND id_usuario = ? AND tipo = ? LIMIT 1";
    return $GLOBALS['db']->auto_array($sql,array($usuario,$tipo));
  }
  
}  
?>

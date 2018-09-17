<?php
class Modelo_Notificacion{
  
  const WEB = 1;
  const CORREO = 2;
  const SMS = 3;

  public static function notificacionxUsuario($usuario,$tipo){
  	if (empty($usuario) || empty($tipo)){ return false; }
    $sql = "SELECT id_notificacion,url,descripcion FROM mfo_notificacion WHERE estado = 1 AND id_usuario = ? AND tipo = ? LIMIT 1";
    return $GLOBALS['db']->auto_array($sql,array($usuario,$tipo));
  }

  public static function desactivarNotificacion($id_notificacion){

  	if (empty($id_notificacion)){ return false; }
    return $GLOBALS['db']->delete('mfo_notificacion','id_notificacion = '.$id_notificacion);
  }

  public static function activarNotificaciones(){

    //Revisar si el usuario no tenga una notificacion activa para no activarle otra al mismo tiempo
    $sql = "SELECT 
            id_usuario,
            id_notificacion,
            MIN(CAST(fecha_creacion AS CHAR)) AS fecha_creacion,
            url,
            descripcion
        FROM
            mfo_notificacion
        WHERE
            tipo = 1 AND estado = 0
        GROUP BY id_usuario;";

    return $GLOBALS['db']->auto_array($sql,array($usuario,$tipo));
  }
  
}  
?>


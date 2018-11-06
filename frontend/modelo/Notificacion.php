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
    $sql = "SELECT url,descripcion FROM mfo_notificacion WHERE estado = 1 AND id_usuario = ? AND tipo = ? LIMIT 1";
    return $GLOBALS['db']->auto_array($sql,array($usuario,$tipo));
  }

  public static function insertarNotificacion($id_usuario,$mensaje,$tipo){
    if (empty($mensaje) || empty($id_usuario)){ return false; }

    $datos = array("id_usuario"=>$id_usuario,"estado"=>1,"descripcion"=>$mensaje,"tipo"=>$tipo,"fecha_creacion"=>date('Y-m-d H:i:s'));
    $result = $GLOBALS['db']->insert('mfo_notificacion',$datos);
    return $result;
  }

  public static function existeNotificacion($id_usuario,$tipo,$fecha_compra,$autopostulaciones=false){
    if(empty($id_usuario) || empty($fecha_compra) || empty($tipo)){ return false; }

    if(!is_bool($autopostulaciones) && $autopostulaciones >= 0 && $autopostulaciones <= AUTOPOSTULACION_MIN){
   
      if($autopostulaciones == 0){
        $mensaje = 'sus autopostulaciones se han agotado';
      }else{
        $mensaje = "le restan: ".$autopostulaciones." autopostulaciones";
      }
      $sql = "SELECT id_notificacion FROM mfo_notificacion n WHERE n.id_usuario = ? AND tipo = ? AND n.descripcion LIKE '%".$mensaje."%';";
      $rs = $GLOBALS['db']->auto_array($sql,array($id_usuario,$tipo));
    }else{
      $sql = "SELECT id_notificacion FROM mfo_notificacion n WHERE n.id_usuario = ? AND tipo = ? AND n.descripcion LIKE '%".$fecha_compra."%';";
      $rs = $GLOBALS['db']->auto_array($sql,array($id_usuario,$tipo));
    }
    return (!empty($rs['id_notificacion'])) ? true : false;
  }
  
}  
?>
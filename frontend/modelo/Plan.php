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

  public static function listadoPlanAccion($tipo,$sucursal,$tipoplan){
    $sql = "SELECT t.id_plan,t.nombre,t.promocional,t.duracion,t.extension,t.porc_descarga,t.num_post,t.costo, 
        GROUP_CONCAT(a.accion ORDER BY p.id_permisoPlan) as acciones, GROUP_CONCAT(a.descripcion ORDER BY p.id_permisoPlan) as descripciones
        FROM mfo_permisoplan p
        INNER JOIN mfo_accionsist a ON a.id_accionSist = p.id_accionSist 
        INNER JOIN mfo_plan t ON t.id_plan = p.id_plan 
        WHERE a.estado = 1
        AND t.tipo_plan = $tipoplan
        AND t.tipo_usuario = $tipo
        AND t.id_sucursal = $sucursal
        GROUP BY t.id_plan
        ORDER BY p.id_permisoPlan;";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }

  public static function listadoPlanesUsuario($idUsuario){
    $sql = "SELECT p.id_plan, p.nombre, p.costo, up.id_comprobante, up.fecha_compra, if(up.num_post_rest <> '',num_post_rest,'-') as num_post_rest, if(up.fecha_caducidad <> '',fecha_caducidad,'Infinito') as fecha_caducidad, up.id_usuario_plan, up.estado
        FROM mfo_usuario_plan up, mfo_plan p
        WHERE p.id_plan = up.id_plan 
        AND ((up.estado = 1)||(up.estado = 0 AND up.id_comprobante <> ''))
        AND up.id_usuario = ".$idUsuario." ORDER BY fecha_compra ASC";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
  
  public static function busquedaActivoxTipo($plan,$tipo,$sucursal){
    if (empty($plan) || empty($tipo) || empty($sucursal)){ return false; }
    $sql = "SELECT * FROM mfo_plan WHERE estado = 1 AND id_plan = ? AND tipo_usuario = ? AND id_sucursal = ?";
    return $GLOBALS['db']->auto_array($sql,array($plan,$tipo,$sucursal));    
  }

  public static function busquedaXId($id){
    if (empty($id)){ return false; }
    $sql = "SELECT * FROM mfo_plan WHERE id_plan = ?";
    return $GLOBALS['db']->auto_array($sql,array($id));
  }
}  
?>
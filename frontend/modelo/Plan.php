<?php
class Modelo_Plan{
  
  const CANDIDATO = 1;
  const EMPRESA = 2;
  const PAQUETE = 2;
  const AVISO = 1;
  
  /*costo=1 => los que tengan precio 0
    costo=2 => los que no tenga precio 0*/
  public static function busquedaPlanes($tipousuario,$sucursal,$costo=false,$tipoplan=false){
  	if (empty($tipousuario)||empty($sucursal)){ return false; }
    $sql = "SELECT p.id_plan, p.nombre, p.num_post, p.promocional, p.costo, p.duracion, 
                   p.porc_descarga, p.extension, p.codigo_paypal, GROUP_CONCAT(a.descripcion) AS permisos,
                   GROUP_CONCAT(a.accion) AS acciones
            FROM mfo_plan p
            INNER JOIN mfo_permisoplan e ON p.id_plan = e.id_plan  
            INNER JOIN mfo_accionsist a ON e.id_accionSist = a.id_accionSist
            WHERE p.tipo_usuario = ? AND p.estado = 1 AND p.id_sucursal = ? AND a.estado = 1 ";    
    if (!empty($costo)){        
      $sql .= ($costo == 1) ? " AND p.costo = 0 " : " AND p.costo <> 0 ";            
    }
    if (!empty($tipoplan)){
      $sql .= " AND p.tipo_plan = ".$tipoplan." ";
    }  
    $sql .= "GROUP BY p.id_plan ORDER BY p.costo, a.id_accionSist";
    return $GLOBALS['db']->auto_array($sql,array($tipousuario,$sucursal),true);
  }

  public static function listadoPlanesUsuario($idUsuario){
    $sql = "SELECT p.id_plan, p.nombre, p.costo, up.id_comprobante, up.fecha_compra, if(up.num_post_rest <> '',num_post_rest,'-') as num_post_rest, if(up.fecha_caducidad <> '',fecha_caducidad,'ilimitado') as fecha_caducidad, up.id_usuario_plan, up.estado
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

  public static function busquedaXId($id,$todos=false){
    if (empty($id)){ return false; }
    if (!$todos){
      $sql = "SELECT * FROM mfo_plan WHERE id_plan = ?";
    }
    else{
      $sql = "SELECT p.tipo_plan, p.id_sucursal, p.num_post, p.duracion, p.codigo_paypal, p.nombre, s.id_pais, p.tipo_usuario 
              FROM mfo_plan p
              INNER JOIN mfo_sucursal s ON s.id_sucursal = p.id_sucursal 
              WHERE p.id_plan = ? AND p.estado = 1";
    }
    return $GLOBALS['db']->auto_array($sql,array($id));
  }
}  
?>
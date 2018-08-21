<?php
class Modelo_PermisoPlan{
  
  public static function tienePermiso($planes,$permiso){
  	if (empty($planes) || !is_array($planes) || empty($permiso)){ return false; }
  	foreach($planes as $plan){
       $idaccion = self::busquedaPermisoxPlan($plan["id_plan"],$permiso);
       if (isset($idaccion["id_accionSist"]) && !empty($idaccion["id_accionSist"])){
       	  return true;
       }
  	}
    return false;
  }
  

  public static function busquedaPermisoxPlan($idplan, $permiso){
    if (empty($idplan)){ return false; }
    $sql = "select mfo_accionsist.id_accionSist from mfo_accionsist 
						inner join mfo_permisoplan on mfo_accionsist.id_accionSist = mfo_permisoplan.id_accionSist 
						where mfo_accionsist.accion = ? and mfo_accionsist.estado = 1 and mfo_permisoplan.id_plan = ?";
		return $GLOBALS['db']->auto_array($sql,array($permiso,$idplan));						
  }

  public static function listaPermisoxPlan($idplan){
    if (empty($idplan)) { return false; }
    $sql = "SELECT mfo_accionsist.accion, mfo_accionsist.descripcion 
            FROM mfo_permisoplan INNER JOIN mfo_accionsist ON mfo_accionsist.id_accionSist = mfo_permisoplan.id_accionSist 
            WHERE mfo_permisoplan.id_plan = ? and mfo_accionsist.estado = 1";
    return $GLOBALS['db']->auto_array($sql,array($idplan),true);         
  }
}  
?>
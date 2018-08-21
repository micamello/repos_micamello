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
    $sql = "SELECT mfo_accionsist.id_accionSist FROM mfo_accionsist 
						INNER JOIN mfo_permisoplan on mfo_accionsist.id_accionSist = mfo_permisoplan.id_accionSist 
						WHERE mfo_accionsist.accion = ? AND mfo_accionsist.estado = 1 AND mfo_permisoplan.id_plan = ?";
		return $rs = $GLOBALS['db']->auto_array($sql,array($permiso,$idplan));				
  }
}  
?>
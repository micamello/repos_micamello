<?php
class Modelo_PermisoPlan{
  
  public static function tienePermiso($planes,$permiso,$idplan=false){

    if (empty($planes) || !is_array($planes) || empty($permiso)){ return false; }

    if (!empty($idplan)){
      $idaccion = self::busquedaPermisoxPlan($idplan,$permiso);
      if (isset($idaccion["id_accionSist"]) && !empty($idaccion["id_accionSist"])){
        return true;
      }      
    }
    else{

      foreach($planes as $plan){
        $idaccion = self::busquedaPermisoxPlan($plan["id_plan"],$permiso);
        if (isset($idaccion["id_accionSist"]) && !empty($idaccion["id_accionSist"])){
          return true;
        }
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
  public static function listaPermisoxPlan($idplan){
    if (empty($idplan)) { return false; }
    $sql = "SELECT mfo_accionsist.accion, mfo_accionsist.descripcion 
            FROM mfo_permisoplan INNER JOIN mfo_accionsist ON mfo_accionsist.id_accionSist = mfo_permisoplan.id_accionSist 
            WHERE mfo_permisoplan.id_plan = ? and mfo_accionsist.estado = 1";
    return $GLOBALS['db']->auto_array($sql,array($idplan),true);         
  }
}  
?>
<?php
class Modelo_AccesoEmpresa{

	public static function consultaPorCandidato($idusuario){
		if (empty($idusuario)){ return false; }
    $sql = "SELECT * FROM mfo_accesos_empresas WHERE id_usuario = ? AND fecha_terminado_test IS NULL LIMIT 1";
    return $GLOBALS['db']->auto_array($sql,array($idusuario));
	}

  public static function eliminar($idacceso){
    if (empty($idacceso)){ return false; }
    return $GLOBALS['db']->delete("mfo_accesos_empresas","id_accesos_empresas=".$idacceso);
  }

  public static function actualizarFechaTermino($idusuario){
    if (empty($idusuario)){ return false; }
    return $GLOBALS['db']->update("mfo_accesos_empresas",array("fecha_terminado_test"=>date("Y-m-d H:i:s")),"id_usuario=".$idusuario." AND fecha_terminado_test IS NULL");
  }

  public static function consultaVariosPorCandidato($idusuario){
  	if (empty($idusuario)){ return false; }
    $sql = "SELECT * FROM mfo_accesos_empresas WHERE id_usuario = ? AND fecha_terminado_test IS NULL";
    return $GLOBALS['db']->auto_array($sql,array($idusuario),true);
  }
}  
?>
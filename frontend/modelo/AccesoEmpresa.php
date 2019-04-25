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

  public static function consultarEnvioPrevio($usuariosTestIncompletos,$id_empresa){
    if (empty($usuariosTestIncompletos) || empty($id_empresa)){ return false; }

    $sql = 'SELECT GROUP_CONCAT(id_usuario) AS usuarios
        FROM mfo_accesos_empresas ae
        WHERE ae.id_empresa = '.$id_empresa.' 
        AND ae.id_usuario IN('.$usuariosTestIncompletos.')'; 

    $rs = $GLOBALS['db']->auto_array($sql,array(),false);
    if (empty($rs['usuarios'])){ return false; } else{ return $rs['usuarios']; }
  }

  public static function guardarAcceso($idUsuario,$fecha,$idEmpresaPlan,$id_empresa){
    if (empty($idUsuario) || empty($fecha) || empty($idEmpresaPlan) || empty($id_empresa)){ return false; }

    $data_insert = array('id_usuario'=>$idUsuario,'id_empresa_plan'=>$idEmpresaPlan,'id_empresa'=>$id_empresa,'fecha_envio_acceso'=>$fecha);
  //print_r($data_insert); 
    return $GLOBALS['db']->insert('mfo_accesos_empresas',$data_insert);       
  }

  public static function obtenerUsuariosConAccesos($id_empresa){
    if (empty($id_empresa)){ return false; }

    $sql = 'SELECT id_usuario, fecha_terminado_test FROM mfo_accesos_empresas WHERE id_empresa = '.$id_empresa;
    $arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);

    $datos = array();
    if (!empty($arrdatos) && is_array($arrdatos)){

      foreach ($arrdatos as $key => $value) {
        $datos[$value['id_usuario']] = $value['fecha_terminado_test'];
      }
    }
    return $datos;
  }

  public static function obtenerAccesosDistintaEmp($id_empresa){

    if (empty($id_empresa)){ return false; }

    $sql = 'SELECT DISTINCT(id_usuario) FROM mfo_accesos_empresas WHERE id_empresa <> '.$id_empresa;
    $arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);

    $datos = array();
    if (!empty($arrdatos) && is_array($arrdatos)){

      foreach ($arrdatos as $key => $value) {

        array_push($datos, $value['id_usuario']);
      }
    }
    return $datos;
  }
}  
?>
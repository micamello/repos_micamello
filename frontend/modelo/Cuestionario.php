<?php
class Modelo_Cuestionario{

	const PUNTAJEMAX = 25;

	public static function testSiguientexUsuario($usuario){
		if (empty($usuario)){ return false; }
		$sql = "SELECT id_cuestionario, orden FROM mfo_cuestionario WHERE orden = (SELECT COUNT(1) AS nro FROM mfo_porcentajextest WHERE id_usuario = ?) + 1";
		return $GLOBALS['db']->auto_array($sql,array($usuario));
	}

	public static function guardarPorTest($valor,$usuario,$test){
		if (empty($valor) || empty($usuario) || empty($test)){ return false; }		
		return $GLOBALS['db']->insert('mfo_porcentajextest',array('valor'=>$valor,'id_usuario'=>$usuario,
			'id_cuestionario'=>$test,'fecha_culminacion'=>date('Y-m-d H:i:s')));
	}

	public static function existeTest($id){
    if (empty($id)){ return false; }
    $sql = "SELECT id_cuestionario FROM mfo_cuestionario WHERE id_cuestionario = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($id));
    return (!empty($rs["id_cuestionario"])) ? true : false;
	}

	public static function totalTest(){
		$sql = "SELECT COUNT(1) AS nro FROM mfo_cuestionario";
		$rs = $GLOBALS['db']->auto_array($sql,array());
		return $rs["nro"];
	}

	public static function testxUsuario($usuario){
		if (empty($usuario)){ return false; }
		$sql = "SELECT p.valor, c.imagen, c.orden 
						FROM mfo_porcentajextest p INNER JOIN mfo_cuestionario c ON p.id_cuestionario = c.id_cuestionario 
						WHERE p.id_usuario = ? ORDER BY p.id_cuestionario ASC";
		return $GLOBALS['db']->auto_array($sql,array($usuario),true);
	}

	public static function ultimoTestRealizado($usuario){
	    if (empty($usuario)){ return false; }
	    $sql = "SELECT * FROM mfo_porcentajextest WHERE id_usuario = ? ORDER BY id_cuestionario DESC LIMIT 1";
	    return $GLOBALS['db']->auto_array($sql,array($usuario));
	}

	public static function totalTestxUsuario($usuario){
		if (empty($usuario)){ return false; }
	  $sql = "SELECT COUNT(1) AS nro FROM mfo_porcentajextest WHERE id_usuario = ?";
		$rs = $GLOBALS['db']->auto_array($sql,array($usuario));
		return $rs["nro"];	
	}

	public static function listadoCuestionariosxUsuario($id_usuario){
		$sql = "SELECT distinct mr.id_cuestionario, mc.nombre FROM mfo_respuesta mr, mfo_cuestionario mc WHERE mc.id_cuestionario = mr.id_cuestionario and mr.id_usuario = '$id_usuario';";
		return $GLOBALS['db']->auto_array($sql,array(), true);
	}

	public static function totalTestxUsuario($usuario){
		if (empty($usuario)){ return false; }
	  $sql = "SELECT COUNT(1) AS nro FROM mfo_porcentajextest WHERE id_usuario = ?";
		$rs = $GLOBALS['db']->auto_array($sql,array($usuario));
		return $rs["nro"];	
	}
}  
?>
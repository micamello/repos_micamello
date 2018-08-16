<?php
class Modelo_Cuestionario{

	const PUNTAJEMAX = 25;

	public static function testSiguientexUsuario($usuario){
		if (empty($usuario)){ return false; }
		$sql = "select id_cuestionario, orden from mfo_cuestionario where orden = (select count(1) as nro from mfo_porcentajextest where id_usuario = ?) + 1";
		$rs = $GLOBALS['db']->auto_array($sql,array($usuario));
    return $rs["id_cuestionario"];		
	}

	public static function guardarPorTest($valor,$usuario,$test){
		if (empty($valor) || empty($usuario) || empty($test)){ return false; }		
		return $GLOBALS['db']->insert('mfo_porcentajextest',array('valor'=>$valor,'id_usuario'=>$usuario,'id_cuestionario'=>$test));
	}

	public static function existeTest($id){
    if (empty($id)){ return false; }
    $sql = "select id_cuestionario from mfo_cuestionario where id_cuestionario = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($id));
    return (!empty($rs["id_cuestionario"])) ? true : false;
	}

	public static function totalTest(){
		$sql = "select count(1) as nro from mfo_cuestionario";
		$rs = $GLOBALS['db']->auto_array($sql,array());
		return $rs["nro"];
	}

	public static function testxUsuario($usuario){
		if (empty($usuario)){ return false; }
		$sql = "select mfo_porcentajextest.valor, mfo_cuestionario.imagen, mfo_cuestionario.orden 
						from mfo_porcentajextest inner join mfo_cuestionario on mfo_porcentajextest.id_cuestionario = mfo_cuestionario.id_cuestionario 
						where mfo_porcentajextest.id_usuario = ? order by mfo_porcentajextest.id_cuestionario asc";
		return $GLOBALS['db']->auto_array($sql,array($usuario),true);
	}
}  
?>
<?php
class Modelo_PorcentajexFaceta{
  
  public static function obtienePermisoDescargar($idusuario){
  	if (empty($idusuario)){ return false; }
    $sql = "SELECT SUM(p.estado) as resultado FROM mfo_porcentajexfaceta p INNER JOIN mfo_faceta f ON f.id_faceta = p.id_faceta WHERE p.id_usuario = ? ORDER BY f.orden ASC";
    $r = $GLOBALS['db']->auto_array($sql,array($idusuario),false);

    if(!empty($r['resultado'])){ return $r['resultado']; }else{ return false; }
  }


	public static function usuariosxfaceta(){

		$sql = "SELECT * FROM mfo_porcentajexfaceta ORDER BY id_usuario, id_faceta";
		$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);

		$datos = array();
		if (!empty($arrdatos) && is_array($arrdatos)){

			foreach ($arrdatos as $key => $value) {

				$datos[$value['id_usuario']][$value['id_faceta']] = $value['valor'];
			}
		}
		return $datos;
	}

  public static function guardarValores($valores,$idusuario,$facetas,$estado=1, $tiempo){
    if (empty($idusuario) || empty($facetas) || !is_array($facetas) || !is_array($valores) || (count($valores) != count($facetas))){ return false; }
    $fecha_culminacion = date("Y-m-d H:i:s");
    $array_session = array();
    foreach ($facetas as $key=>$faceta) {
      array_push($array_session, array($valores[$key],$idusuario,$faceta,"'".$fecha_culminacion."'",$estado,"'".$tiempo."'"));
    }
    $result = $GLOBALS['db']->insert_multiple("mfo_porcentajexfaceta","valor,id_usuario,id_faceta,fecha_culminacion,estado,tiempo",$array_session);
    return $result;
  }

  public static function updateEstado($idusuario,$estado=1){
    if (empty($idusuario)){ return false; }
    return $GLOBALS['db']->update("mfo_porcentajexfaceta",array("estado"=>$estado),"id_usuario=".$idusuario);
  }

  public static function consultaxUsuario($idusuario){
    if (empty($idusuario)){ return false; }
    $sql = "SELECT p.id_faceta, p.valor, f.literal 
            FROM mfo_porcentajexfaceta p INNER JOIN mfo_faceta f ON f.id_faceta = p.id_faceta 
            WHERE p.id_usuario = ? ORDER BY f.id_faceta";
    return $GLOBALS['db']->auto_array($sql,array($idusuario), true);
  }
}  
?>
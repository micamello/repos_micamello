<?php
class Modelo_Postulacion{
  
	public static function obtienePostuladoxUsuario($id_usuario,$id_oferta){
		$sql = "SELECT * FROM mfo_postulacion WHERE id_usuario = $id_usuario AND id_ofertas = $id_oferta;";
		return $GLOBALS['db']->auto_array($sql,array(),true);
	}

	public static function postularse($id_usuario,$id_oferta,$asp_salarial){
		$result = $GLOBALS['db']->insert('mfo_postulacion',array("tipo"=>2,"fecha_postulado"=>date("Y-m-d H:i:s"),"resultado"=>3,"id_usuario"=>$id_usuario,"id_ofertas"=>$id_oferta,"asp_salarial"=>$asp_salarial));
		return $result;
	}

	public static function cambiarEstatus($id_usuario,$id_oferta,$resultado){
		$result = $GLOBALS['db']->update('mfo_postulacion',array("resultado"=>$resultado), "id_usuario = ".$id_usuario." and id_ofertas = ".$id_oferta);
		return $result;
	}

	public static function obtienePostulaciones($idUsuario){
	    $sql = "SELECT tipo,id_ofertas FROM mfo_postulacion  WHERE id_usuario = ".$idUsuario;
	    $arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);
	    $datos = array();
	    if (!empty($arrdatos) && is_array($arrdatos)){

	    	foreach ($arrdatos as $key => $value) {
	    		$datos[$value['id_ofertas']] = $value['tipo'];
	    	}
	    }
	    return $datos;
	} 

	public static function eliminarPostulacion($id_postulacion){
		$result = $GLOBALS['db']->delete('mfo_postulacion','id_auto = '.$id_postulacion);
		return $result;
	}
}  
?>
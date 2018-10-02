<?php
class Modelo_Postulacion{

	const MANUAL = 2;
	const AUTOMATICO = 1;
  
	public static function obtienePostuladoxUsuario($id_usuario,$id_oferta){
		$sql = "SELECT * FROM mfo_postulacion WHERE id_usuario = $id_usuario AND id_ofertas = $id_oferta;";
		return $GLOBALS['db']->auto_array($sql,array(),true);
	}

	public static function postularse($id_usuario,$id_oferta,$asp_salarial,$tipo=self::MANUAL){
		$result = $GLOBALS['db']->insert('mfo_postulacion',array("tipo"=>$tipo,"fecha_postulado"=>date("Y-m-d H:i:s"),"resultado"=>3,"id_usuario"=>$id_usuario,"id_ofertas"=>$id_oferta,"asp_salarial"=>$asp_salarial));
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

	public static function guardarPostAuto($idpostulacion,$idusuarioplan){
		if (empty($idpostulacion) || empty($idusuarioplan)){ return false; }
		return $GLOBALS['db']->insert('mfo_postulacion_automatica',array("id_postulacion"=>$idpostulacion,"id_usuarioplan"=>$idusuarioplan));
	}

	public static function eliminarPostAuto($idusuplan){
		if (empty($idusuplan)){ return false; }
		return $GLOBALS['db']->delete('mfo_postulacion_automatica','id_usuarioplan = '.$idusuplan);
	}

	public static function obtienePostAuto($idusuplan){
		if (empty($idusuplan)){ return false; }
		$sql = "SELECT id_postulacion FROM mfo_postulacion_automatica WHERE id_usuarioplan = ?";
		$rs = $GLOBALS['db']->auto_array($sql,array($idusuplan),true);
		if (empty($rs)){ return false; }
		else{
			$arreglo = array();
      foreach($rs as $key=>$value){
        $arreglo[$key] = $value["id_postulacion"];
      }
      return $arreglo;
		}
	}

	public static function eliminarPostxString($string){
    if (empty($string)){ return false; }
    return $GLOBALS['db']->delete('mfo_postulacion','id_auto IN ('.$string.')');
	}

	public static function obtienePostxOferta($idoferta){
    if (empty($idoferta)){ return false; }
    $sql = "SELECT id_auto, id_usuario, tipo FROM mfo_postulacion where id_ofertas = ?";
    return $GLOBALS['db']->auto_array($sql,array($idoferta),true);
	}

	public static function postAutoxIdPost($idpostulacion){
    if (empty($idpostulacion)){ return false; }
    $sql = "SELECT id_postauto, id_usuarioplan FROM mfo_postulacion_automatica WHERE id_postulacion = ?";
    return $GLOBALS['db']->auto_array($sql,array($idpostulacion));
	}

	public static function eliminarPostAutoxId($idpostauto){
		if (empty($idpostauto)){ return false; }
		return $GLOBALS['db']->delete('mfo_postulacion_automatica','id_postauto = '.$idpostauto);
	}
}  
?>
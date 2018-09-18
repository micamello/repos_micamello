<?php
class Modelo_Opcion{

	public static function listadoxPregunta($pregunta){
		if (empty($pregunta)){ return false; }
		$sql = "SELECT o.*,r.orden 
						FROM mfo_opcion o INNER JOIN mfo_opcion_respuesta r
						ON o.id_opcion = r.id_opcion
						WHERE r.id_pre = ? 
						ORDER BY r.orden";
		return $GLOBALS['db']->auto_array($sql,array($pregunta),true);
	}
}  
?>
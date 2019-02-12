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
	
	/*******MINISITIO******/
	public static function obtieneOpciones($pregunta){
		if (empty($pregunta)){ return false; }
		$sql = "SELECT id_opcion, descripcion, valor 
		        FROM mfo_opcionm2 WHERE id_pregunta = ? 
		        ORDER BY RAND()";
    return $GLOBALS['db']->auto_array($sql,array($pregunta),true);
	}
}  
?>
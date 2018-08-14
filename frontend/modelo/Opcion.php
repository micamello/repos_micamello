<?php
class Modelo_Opcion{

	public static function listadoxPregunta($pregunta){
		if (empty($pregunta)){ return false; }
		$sql = "select mfo_opcion.*,mfo_opcion_respuesta.orden 
						from mfo_opcion inner join mfo_opcion_respuesta 
						on mfo_opcion.id_opcion = mfo_opcion_respuesta.id_opcion
						where mfo_opcion_respuesta.id_pre = ? 
						order by mfo_opcion_respuesta.orden";
		return $GLOBALS['db']->auto_array($sql,array($pregunta),true);
	}
}  
?>
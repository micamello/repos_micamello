<?php
class Modelo_Puntaje{
  
	public static function obtenerGrados(){

		$sql = "SELECT * FROM mfo_puntajem2";
    	$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);
		$datos = array();
		if (!empty($arrdatos) && is_array($arrdatos)){

			foreach ($arrdatos as $key => $value) {
				$datos[$value['id_puntaje']] = $value['descripcion'];
			}
		}
		return $datos;
	}
}  
?>
<?php
class Modelo_SituacionLaboral{

	public static function obtieneListadoAsociativo(){
    	$sql = "SELECT * FROM mfo_situacionlaboral";
    	$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);

		$datos = array();
		if (!empty($arrdatos) && is_array($arrdatos)){

			foreach ($arrdatos as $key => $value) {
				$datos[$value['id_situacionlaboral']] = $value['descripcion'];
			}
		}
		return $datos;
	}


}  
?>
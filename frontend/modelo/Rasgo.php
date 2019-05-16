<?php
class Modelo_Rasgo{
  
  	public static function obtieneListadoAsociativo(){

		$sql = "SELECT id_faceta, id_puntaje, GROUP_CONCAT(descripcion SEPARATOR '/') as rasgo FROM mfo_rasgo GROUP BY id_faceta,id_puntaje ORDER BY id_puntaje";
    	$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);

		$datos = array();
		if (!empty($arrdatos) && is_array($arrdatos)){

			foreach ($arrdatos as $key => $value) {
				$datos[$value['id_puntaje']][$value['id_faceta']] = $value['rasgo'];
			}
		}
		return $datos;
	}
}  
?>
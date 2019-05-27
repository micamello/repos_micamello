<?php
class Modelo_Rasgo{
  
  	public static function obtieneListadoAsociativo(){

		$sql = "SELECT id_faceta, id_puntaje, descripcion as rasgo FROM mfo_rasgo ORDER BY id_puntaje";
    	$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);

		$datos = array();
		if (!empty($arrdatos) && is_array($arrdatos)){

			foreach ($arrdatos as $key => $value) {

				if(isset($datos[$value['id_faceta']][$value['id_puntaje']])){
					array_push($datos[$value['id_faceta']][$value['id_puntaje']],$value['rasgo']);
				}else{
					$datos[$value['id_faceta']][$value['id_puntaje']] = array($value['rasgo']);
				}
			}
		}
		return $datos;
	}
}  
?>
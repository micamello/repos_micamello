<?php
class Modelo_Ocupacion{
  
  	public static function obtieneListadoAsociativo(){

		$sql = "SELECT * FROM mfo_ocupacionm2";
		$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);

		$datos = array();
		if (!empty($arrdatos) && is_array($arrdatos)){

			foreach ($arrdatos as $key => $value) {
				$datos[$value['id_ocupacion']] = $value['descripcion'];
			}
		}
		return $datos;
	}

 /*********Minisitio***********/
	public static function obtieneListadoProfesion(){

		$sql = "SELECT * FROM mfo_profesionm2";
		$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);

		$datos = array();
		if (!empty($arrdatos) && is_array($arrdatos)){

			foreach ($arrdatos as $key => $value) {
				$datos[$value['id_profesion']] = $value['descripcion'];
			}
		}
		return $datos;
	}

}  
?>
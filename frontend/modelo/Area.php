<?php
class Modelo_Area{
  
  public static function obtieneListado(){
    $sql = "SELECT * FROM mfo_area";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
  
	public static function obtieneListadoAsociativo(){

		$sql = "SELECT * FROM mfo_area";
    	$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);

		$datos = array();
		if (!empty($arrdatos) && is_array($arrdatos)){

			foreach ($arrdatos as $key => $value) {
				$datos[$value['id_area']] = $value['nombre'];
			}
		}
		return $datos;
	}

	public static function obtieneOfertasxArea($pais){
		if (empty($pais)){ return false; }
		$sql = "SELECT a.id_area, a.nombre, a.ico, 0 AS ofertas
						FROM mfo_area a 												
						GROUP BY a.id_area
						ORDER BY a.nombre";
		return $GLOBALS['db']->auto_array($sql,array($pais),true);				
	}

	public static function obtieneAreas($areas){
		$sql = "SELECT * FROM mfo_area WHERE id_area IN($areas)";
		$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);
		return $arrdatos;
	}
}  
?>
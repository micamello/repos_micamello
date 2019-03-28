<?php
class Modelo_Area{
  // se usa
  public static function obtieneListado(){
    $sql = "SELECT * FROM mfo_area";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
  // se usa
  
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
		$sql = "SELECT COUNT(res.id_ofertas) AS ofertas, a.id_area, a.nombre, a.ico 
						FROM mfo_area a
						LEFT JOIN (SELECT o.id_ofertas, s.id_area
											 FROM mfo_oferta_subareas o 
											 INNER JOIN mfo_area_subareas s ON s.id_areas_subareas = o.id_areas_subareas
											 GROUP BY o.id_ofertas, s.id_area) AS res ON res.id_area = a.id_area
						GROUP BY a.id_area";		
		return $GLOBALS['db']->auto_array($sql,array($pais),true);				
	}

	public static function obtieneAreas($areas){
		$sql = "SELECT * FROM mfo_area WHERE id_area IN($areas)";
		$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);
		return $arrdatos;
	}
}  
?>
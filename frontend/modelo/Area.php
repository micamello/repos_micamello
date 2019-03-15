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
		$sql = "SELECT a.id_area, a.nombre, a.ico, COUNT(o.id_ofertas) AS ofertas
						FROM mfo_area a 
						LEFT JOIN mfo_oferta o ON o.id_area = a.id_area AND o.estado = 1
						LEFT JOIN mfo_ciudad c ON c.id_ciudad = o.id_ciudad
						LEFT JOIN mfo_provincia p ON p.id_provincia = c.id_provincia
						WHERE p.id_pais = ? OR p.id_pais IS NULL
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
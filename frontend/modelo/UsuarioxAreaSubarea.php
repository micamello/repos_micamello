<?php
class Modelo_UsuarioxAreaSubarea{
  
	public static function obtieneAreas_Subareas($areaxsubarea){
		$sql = "SELECT 
		area.id_area,
	    area.nombre as area,
	    subarea.nombre as subarea
	    
	FROM
	    mfo_area_subareas ares,
	    mfo_area area, mfo_subareas subarea
	WHERE
		ares.id_area = area.id_area AND
	    ares.id_subareas = subarea.id_subareas AND
	    ares.id_areas_subareas IN (".$areaxsubarea.")";
	    return $GLOBALS['db']->auto_array($sql,array(),true);
	}
}  
?>


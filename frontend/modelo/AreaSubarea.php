<?php 
class Modelo_AreaSubarea{
	public static function obtieneAreas_Subareas(){
		$sql = "SELECT t_a_sub.*, t_area.nombre as nombre_area, t_sub.nombre as nombre_subarea FROM mfo_area_subareas AS t_a_sub, mfo_subareas AS t_sub, mfo_area AS t_area WHERE t_a_sub.id_subareas = t_sub.id_subareas AND t_a_sub.id_area = t_area.id_area order by t_area.id_area, t_area.nombre";
		$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);
		return $arrdatos;
	}

	public static function obtieneAreasSubareas($ids_areas_subareas){
		$sql = "SELECT t_area.nombre as nombre_area, GROUP_CONCAT(t_sub.nombre order by t_sub.nombre) as nombre_subarea FROM mfo_area_subareas AS t_a_sub, mfo_subareas AS t_sub, mfo_area AS t_area WHERE t_a_sub.id_subareas = t_sub.id_subareas AND t_a_sub.id_area = t_area.id_area AND t_a_sub.id_areas_subareas IN(".$ids_areas_subareas.") GROUP BY t_a_sub.id_area ORDER BY t_area.id_area";
		$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);
		return $arrdatos;
	}

	public static function obtieneAreas_subareas_usuario($id_usuario){

		$sql = 'SELECT a.nombre as area,GROUP_CONCAT(CONCAT(" ",s.nombre) order by s.nombre) as subareas FROM mfo_usuarioxarea ua
				INNER JOIN mfo_area_subareas aa ON aa.id_areas_subareas = ua.id_areas_subareas
				INNER JOIN mfo_area a ON a.id_area = aa.id_area 
				INNER JOIN mfo_subareas s ON s.id_subareas = aa.id_subareas
				WHERE ua.id_usuario = ?
				GROUP BY aa.id_area
				ORDER BY aa.id_area';
		$arrdatos = $GLOBALS['db']->auto_array($sql,array($id_usuario),true);
		return $arrdatos;

	}

	public static function obtieneListadoAsociativo(){
		$sql = "SELECT * FROM mfo_subareas";
    	$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);
		$datos = array();
		if (!empty($arrdatos) && is_array($arrdatos)){
			foreach ($arrdatos as $key => $value) {
				$datos[$value['id_subareas']] = $value['nombre'];
			}
		}
		return $datos;
	}
}
?>
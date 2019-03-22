<?php
class Modelo_AreaSubarea{
	public static function obtieneAreas_Subareas(){
		$sql = "SELECT t_a_sub.*, t_area.nombre as nombre_area, t_sub.nombre as nombre_subarea FROM mfo_area_subareas AS t_a_sub, mfo_subareas AS t_sub, mfo_area AS t_area WHERE t_a_sub.id_subareas = t_sub.id_subareas AND t_a_sub.id_area = t_area.id_area order by t_a_sub.id_areas_subareas";
		$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);
		return $arrdatos;
	}
}  
?>
<?php
class Modelo_SectorIndustrial{

	public static function consulta(){
		$sql = "SELECT * FROM mfo_sectorindustrial";
		return $GLOBALS['db']->auto_array($sql,array(),true);
	}
}
?>
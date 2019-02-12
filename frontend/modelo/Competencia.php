<?php
class Modelo_Competencia{
  
	public static function obtenerCompetenciasGrados(){

		$sql = "SELECT * FROM mfo_competenciam2";
    	$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);

    	$grados = Modelo_Puntaje::obtenerGrados();
		$datos = array();
		if (!empty($arrdatos) && is_array($arrdatos)){

			foreach ($arrdatos as $key => $value) {
				$datos[$value['id_competencia']] = array('nombre'=>$value['descripcion'],'grados'=>$grados);
			}
		}
		return $datos;
	}
}  
?>
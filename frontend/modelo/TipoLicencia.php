<?php
class Modelo_TipoLicencia{

	public static function obtieneListadoAsociativo(){
    	$sql = "SELECT * FROM mfo_tipolicencia";
    	$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);

		$datos = array();
		if (!empty($arrdatos) && is_array($arrdatos)){

			foreach ($arrdatos as $key => $value) {
				$datos[$value['id_tipolicencia']] = $value['descripcion'];
			}
		}
		return $datos;
	}

}  
?>
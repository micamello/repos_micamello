<?php
class Modelo_TipoContrato
{

    public static function obtieneListado()
    {
        $sql = "SELECT * FROM mfo_tipocontrato";
        return $GLOBALS['db']->auto_array($sql, array(), true);
    }

    public static function obtieneListadoAsociativo(){

		$sql = "SELECT * FROM mfo_tipocontrato";
    	$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);

		$datos = array();
		if (!empty($arrdatos) && is_array($arrdatos)){

			foreach ($arrdatos as $key => $value) {
				$datos[$value['id_tipocontrato']] = $value['descripcion'];
			}
		}
		return $datos;
	}

}

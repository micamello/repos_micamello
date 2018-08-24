<?php
class Modelo_Jornada
{

    public static function obtieneListado()
    {

        $sql = "SELECT * FROM mfo_jornada";
        return $GLOBALS['db']->auto_array($sql, array(), true);

    }

    public static function obtieneListadoAsociativo(){

		$sql = "SELECT * FROM mfo_jornada";
    	$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);

		$datos = array();
		if (!empty($arrdatos) && is_array($arrdatos)){

			foreach ($arrdatos as $key => $value) {
				$datos[$value['id_jornada']] = $value['nombre'];
			}
		}
		return $datos;
	}

}

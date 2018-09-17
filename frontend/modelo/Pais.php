<?php
class Modelo_Pais{
  
  public static function obtieneListado(){
    $sql = "SELECT * FROM mfo_pais";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }

    public static function obtieneListadoAsociativo(){

		$sql = "SELECT * FROM mfo_pais ORDER BY nombre_abr ASC";
    	$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);

		$datos = array();
		if (!empty($arrdatos) && is_array($arrdatos)){

			foreach ($arrdatos as $key => $value) {
				$datos[$value['id_pais']] = $value['nombre_abr'];
			}
		}
		return $datos;
	}
  
}  
?>

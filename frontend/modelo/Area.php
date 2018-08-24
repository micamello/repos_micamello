<?php
class Modelo_Area{
  
  public static function obtieneListado(){
    $sql = "SELECT * FROM mfo_area";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
  
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
}  
?>

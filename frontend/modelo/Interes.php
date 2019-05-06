<?php
class Modelo_Interes{
  
  public static function obtieneListado(){
    $sql = "SELECT * from mfo_nivelinteres";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }

  	public static function obtieneListadoAsociativo(){

		$sql = "SELECT * FROM mfo_nivelinteres";
    	$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);

		$datos = array();
		if (!empty($arrdatos) && is_array($arrdatos)){

			foreach ($arrdatos as $key => $value) {
				$datos[$value['id_nivelInteres']] = $value['descripcion'];
			}
		}
		return $datos;
	}

  public static function obtieneIntereses($intereses){
		$sql = "SELECT * FROM mfo_nivelinteres WHERE id_nivelInteres IN($intereses)";
		$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);
		return $arrdatos;
	}
  
}  
?>
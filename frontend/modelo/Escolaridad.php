<?php
class Modelo_Escolaridad{
  
  public static function obtieneListado(){
    $sql = "SELECT * FROM mfo_escolaridad";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
  
   public static function obtieneListadoAsociativo(){

		$sql = "SELECT * FROM mfo_escolaridad ORDER BY id_escolaridad ASC";
    	$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);

		$datos = array();
		if (!empty($arrdatos) && is_array($arrdatos)){

			foreach ($arrdatos as $key => $value) {
				$datos[$value['id_escolaridad']] = $value['descripcion'];
			}
		}
		return $datos;
	}

	public static function obtieneDependencia($id_escolaridad){

		$sql = "SELECT dependencia FROM mfo_escolaridad WHERE id_escolaridad = ".$id_escolaridad;
    	return $GLOBALS['db']->auto_array($sql,array());
	}
}  
?>
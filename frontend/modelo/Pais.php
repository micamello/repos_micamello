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

	public static function obtieneListadoNacionalidad($sucursal){

		$sql = "SELECT * FROM mfo_pais ORDER BY nombre_abr ASC";
    	$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);

		$datos = array();
		if (!empty($arrdatos) && is_array($arrdatos)){

			foreach ($arrdatos as $key => $value) {

				if($sucursal == $value['id_pais']){

					$sql = "SELECT * FROM mfo_provincia ORDER BY nombre ASC";
    				$prov = $GLOBALS['db']->auto_array($sql,array(),true);

    				$array_prov = array();
    				foreach ($prov as $clave => $valor) {
    					$array_prov[$valor['id_provincia']] = $valor['nombre'];
    				}
					$datos[$value['id_pais']] = array('nombre'=>$value['nombre_abr'], 'provincias'=>$array_prov);
				}else{
					$datos[$value['id_pais']] = $value['nombre_abr'];
				}
			}
		}
		return $datos;
	}
  
}  
?>
<?php
class Modelo_Provincia{
  
  /*public static function obtieneListado($idSucursal,$id_pais){


    $sql = "SELECT id_provincia, nombre FROM mfo_provincia p 
            WHERE id_pais = '$id_pais' ORDER BY nombre ASC";
    return $GLOBALS['db']->auto_array($sql,array(),true);

  }*/

  public static function obtieneProvincia($idCiudad){

  	$sql = "SELECT p.id_provincia FROM mfo_ciudad c, mfo_provincia p WHERE c.id_provincia = p.id_provincia
			AND c.id_ciudad = $idCiudad;";
    return $GLOBALS['db']->auto_array($sql,array());
  }

  public static function obtieneProvinciasSucursal($id_pais)
  {
  	$sql = "SELECT p.id_provincia, p.nombre FROM mfo_provincia p WHERE id_pais = '$id_pais' ORDER BY nombre ASC";
  	return $GLOBALS['db']->auto_array($sql,array(), true);
  }
  
  public static function obtieneListadoAsociativo($id_pais){

		$sql = "SELECT * FROM mfo_provincia WHERE id_pais = '$id_pais' ORDER BY nombre ASC";
    	$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);

		$datos = array();
		if (!empty($arrdatos) && is_array($arrdatos)){

			foreach ($arrdatos as $key => $value) {
				$datos[$value['id_provincia']] = $value['nombre'];
			}
		}
		return $datos;
	}

  public static function obtieneProvinciaxCiudad($id_provincia){

    $sql = "SELECT c.id_ciudad, c.nombre as ciudad
            FROM mfo_ciudad c, mfo_provincia p
            WHERE c.id_provincia = p.id_provincia AND c.id_provincia = $id_provincia ORDER BY c.nombre ASC";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
}  
?>
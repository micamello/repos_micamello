<?php
class Modelo_Provincia{
  
  public static function obtieneListado(){

    $sql = "SELECT * FROM mfo_provincia";
    return $GLOBALS['db']->auto_array($sql,array(),true);

  }

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

  public static function residenciaActual($id_pais){

    $provincias = self::obtieneProvinciasSucursal($id_pais);
    $datos = array();
    foreach ($provincias as $key => $value) {
      $cantones = self::obtieneProvinciaxCiudad($value['id_provincia']);
      $datos_cantones = array();
      foreach ($cantones as $k => $val) {
        $parroquias = Modelo_Parroquia::obtieneParroquiaxCiudad($val['id_ciudad']);
        $datos_cantones[$val['id_ciudad']] = array('nombre'=>$val['ciudad'],'parroquias'=>$parroquias);
      }
      $datos[$value['id_provincia']] = array('nombre'=>$value['nombre'],'cantones'=>$datos_cantones);
    }
    return $datos;
  }
}  
?>
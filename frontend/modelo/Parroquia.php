<?php 
class Modelo_Parroquia{

  public static function obtieneParroquiaxCiudad($id_ciudad){

    $sql = "SELECT p.id_parroquia, p.descripcion as parroquia
            FROM mfo_ciudad c, mfo_parroquia p
            WHERE c.id_ciudad = p.id_ciudad AND c.id_ciudad = $id_ciudad ORDER BY c.nombre ASC";
    $arr_datos = $GLOBALS['db']->auto_array($sql,array(),true);

    $datos = array();
	if (!empty($arr_datos) && is_array($arr_datos)){

		foreach ($arr_datos as $key => $value) {
			$datos[$value['id_parroquia']] = $value['parroquia'];
		}
	}
	return $datos;

  }

  public static function obtieneParroquiaxCanton($id_canton){
    $sql = "SELECT * FROM mfo_parroquia WHERE id_ciudad = ?";
    return $GLOBALS['db']->auto_array($sql,array($id_canton),true);

  }
}  
?>
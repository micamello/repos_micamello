<?php
class Modelo_Sucursal{
  
  public static function obtieneListado(){
    $sql = "SELECT * FROM mfo_sucursal s, mfo_pais p WHERE s.id_pais = p.id_pais AND s.estado = 1;";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }

  public static function obtieneSucursalActual($dominio){
  	if($dominio == 'localhost'){
  		$dominio = 'micamello.com.ec';
  	}
  	$sql = "SELECT s.*, m.simbolo FROM mfo_sucursal s, mfo_moneda m WHERE s.id_moneda = m.id_moneda AND s.dominio = ?";
    return $GLOBALS['db']->auto_array($sql,array($dominio));
  }

  public static function obtieneCiudadDefault(){
    $id_pais = $_SESSION['mfo_datos']['sucursal']['id_pais'];
    $sql = "select ciu.id_ciudad id_ciudad from mfo_provincia pro, mfo_ciudad ciu where ciu.id_provincia = pro.id_provincia and pro.id_pais = ".$id_pais." limit 1;";
    return $GLOBALS['db']->auto_array($sql,array());
  }
  
}  
?>

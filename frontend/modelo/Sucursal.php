<?php
class Modelo_Sucursal{
  
  public static function obtieneListado(){
    $sql = "SELECT * FROM mfo_sucursal s, mfo_pais p WHERE s.id_pais = p.id_pais AND s.estado = 1;";
    return $GLOBALS['db']->auto_array($sql,array(),MYSQL_ASSOC,true);
  }

  public static function obtieneSucursalActual($dominio){

  	if($dominio == 'localhost'){
  		$dominio = 'micamello.com.ec';
  	}
  	$sql = "SELECT * FROM mfo_sucursal s WHERE s.dominio = '$dominio';";
    return $GLOBALS['db']->auto_array($sql,array());

  }
  
}  
?>

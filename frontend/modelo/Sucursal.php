<?php 
// PUERTO.'://'.HOST
// $host = 'micamello_base.com.ec1';
// $default = 2;

// public static function defaultLocation(){
//   	$sql = "select suc.id_pais, pr.nombre, ciu.nombre from mfo_sucursal suc, mfo_pais p, 
// 	mfo_provincia pr, mfo_ciudad ciu where ciu.id_provincia = pr.id_provincia and pr.id_provincia = '$default' and pr.id_pais = p.id_pais and p.id_pais 
// 	= suc.id_pais and suc.dominio = '$host'";
// 	return $GLOBALS['db']->auto_array($sql,array());
//   }
  
 ?>
<?php
class Modelo_Sucursal{
  
  public static function obtieneListado(){
    $sql = "SELECT s.icono, p.nombre_abr FROM mfo_sucursal s, mfo_pais p WHERE s.id_pais = p.id_pais AND s.estado = 1;";
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

<?php 
// PUERTO.'://'.HOST
$host = 'micamello_base.com.ec1';
$default = 2;

public static function defaultLocation(){
  	$sql = "select suc.id_pais, pr.nombre, ciu.nombre from mfo_sucursal suc, mfo_pais p, 
	mfo_provincia pr, mfo_ciudad ciu where ciu.id_provincia = pr.id_provincia and pr.id_provincia = '$default' and pr.id_pais = p.id_pais and p.id_pais 
	= suc.id_pais and suc.dominio = '$host'";
	return $GLOBALS['db']->auto_array($sql,array());
  }
  
 ?>
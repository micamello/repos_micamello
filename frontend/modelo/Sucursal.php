<?php
class Modelo_Sucursal{
  
  public static function obtieneListado(){
    $sql = "SELECT s.id_sucursal, s.extensionicono, p.nombre_abr, s.dominio FROM mfo_sucursal s, mfo_pais p WHERE s.id_pais = p.id_pais AND s.estado = 1;";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }

  public static function obtieneSucursalActual($dominio){
  	if($dominio == 'localhost'){
  		$dominio = 'micamello.com.ec';
  	}
  	$sql = "SELECT s.*, m.simbolo FROM mfo_sucursal s, mfo_moneda m WHERE s.id_moneda = m.id_moneda  AND s.estado = 1 AND s.dominio = ?;";
    return $GLOBALS['db']->auto_array($sql,array($dominio));
  }

  public static function obtieneCiudadDefault(){
    $id_pais = SUCURSAL_PAISID;
    $sql = "select ciu.id_ciudad id_ciudad from mfo_provincia pro, mfo_ciudad ciu where ciu.id_provincia = pro.id_provincia and pro.id_pais = ".$id_pais." limit 1;";
    return $GLOBALS['db']->auto_array($sql,array());
  }

  public static function consultaDominio($id){
    if (empty($id)){ return false; }
    $sql = "SELECT dominio,id_pais FROM mfo_sucursal WHERE id_sucursal = ? AND estado = 1";
    if( strstr(dirname(__FILE__), 'C:') ){  
      $rs["dominio"] = 'localhost/repos_micamello';
      $rs["id_pais"] = '14'; 
    }
    else{
      $rs = $GLOBALS['db']->auto_array($sql,array($id)); 
    }
    return $rs;
  } 

  public static function consultaxPais($pais){
    if (empty($pais)){ return false; }
    $sql = "SELECT dominio FROM mfo_sucursal where id_pais = ?";
    return $GLOBALS['db']->auto_array($sql,array($pais));   
  } 
}  
?>
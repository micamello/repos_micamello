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
    $id_pais = $_SESSION['mfo_datos']['sucursal']['id_pais'];
    $sql = "select ciu.id_ciudad id_ciudad from mfo_provincia pro, mfo_ciudad ciu where ciu.id_provincia = pro.id_provincia and pro.id_pais = ".$id_pais." limit 1;";
    return $GLOBALS['db']->auto_array($sql,array());
  }


  // public static function validar_EC($dni){
  //   $val = true;
  //   if(ValidadorEc::validarCedula($dni) == false || ValidadorEc::validarRucPersonaNatural($dni) == false || ValidadorEc::validarRucSociedadPrivada($dni) == false || ValidadorEc::validarRucSociedadPublica($dni) == false){
  //     $val = false;
  //     }
  //     return $val;
  //   }
}  
?>
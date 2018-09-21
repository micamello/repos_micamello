<?php
class Modelo_InformePDF{

  const ITERACION = 5;
  
  public static function obtieneParametro($id){
    $sql = "SELECT descripcion FROM mfo_parametro WHERE id_parametros ='$id';";
    return $GLOBALS['db']->auto_array($sql,array());
  }

  public static function obtieneValorxRasgoxTest($id_usuario, $cuestionario){
  	$sql = "select mfor.*, mra.valor from mfo_rasgo mfor, mfo_resultxrasgo mra where mfor.id_cuestionario = $cuestionario and mfor.id_rasgo = mra.id_rasgo and mra.id_usuario = '$id_usuario'";
  	return $GLOBALS['db']->auto_array($sql,array(), true);
  }

  public static function numRasgoxTest($cuestionarios){
  	$sql = "select count(id_rasgo) as numero, id_cuestionario from mfo_rasgo where id_cuestionario IN ($cuestionarios) group by id_cuestionario;";
  	return $GLOBALS['db']->auto_array($sql,array(), true);
  }

}  
?>
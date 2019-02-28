<?php
class Modelo_Factura{
  
  public static function obtenerFactura($id_factura,$estado){
  	if(empty($id_factura)){return false;}
  	 $sql = "SELECT * FROM mfo_factura f WHERE f.id_factura = ".$id_factura." AND f.estado = ".$estado;
    return $GLOBALS['db']->auto_array($sql,array());
  }
}  
?>

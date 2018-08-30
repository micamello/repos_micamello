<?php
class Modelo_Comprobante{
  
  const TIPO_PAGOS = array('1'=>'Pago verificado','2'=>'Pago incorrecto','3'=>'En proceso');
  const METODOS_PAGOS = array('1'=>'Deposito','2'=>'Paypal','3'=>'Paymentez');

  public static function obtieneComprobante($id_comprobante){
    $sql = "SELECT * FROM mfo_rcomprobantescam WHERE id_comprobante = ".$id_comprobante;
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
}  
?>
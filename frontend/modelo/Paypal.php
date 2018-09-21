<?php
class Modelo_Paypal{
  
  const NOPROCESADO = 1;
  const PROCESADO = 0;

  public static function obtieneNoProcesados(){
    $sql = "SELECT * FROM mfo_paypal WHERE estado = ? AND (payment_status = 'Completed' OR payment_status = 'Reversed') ORDER BY fecha";
    return $GLOBALS['db']->auto_array($sql,array(self::NOPROCESADO),true);
  }

  public static function guardar($valores=array()){
    if (empty($valores)){ return false; }
    return $GLOBALS['db']->insert('mfo_paypal',$valores);
  }

  public static function modificarEstado($id){
    if (empty($id)){ return false; }
    return $GLOBALS['db']->update('mfo_paypal',array('estado'=>self::PROCESADO),'id_paypal='.$id);
  }
 
}  
?>
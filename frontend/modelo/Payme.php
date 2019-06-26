<?php
class Modelo_Payme{
  
  const NOPROCESADO = 1;
  const PROCESADO = 0;
  //resultado de la compra
  const RESULT_AUTORIZADA = "00";
  const RESULT_DENEGADA = "01";
  const RESULT_RECHAZADA = "05";  

  public static function obtieneNoProcesados(){
    $sql = "SELECT * FROM mfo_payme WHERE estado = ? AND authorizationResult = ? AND errorCode = ? ORDER BY fecha";
    return $GLOBALS['db']->auto_array($sql,array(self::NOPROCESADO,self::RESULT_AUTORIZADA,self::RESULT_AUTORIZADA),true);
  }

  public static function guardar($valores=array()){
    if (empty($valores)){ return false; }
    return $GLOBALS['db']->insert('mfo_payme',$valores);
  }

  public static function modificarEstado($id){
    if (empty($id)){ return false; }
    return $GLOBALS['db']->update('mfo_payme',array('estado'=>self::PROCESADO),'id_payme='.$id);
  }
 
  public static function consultaByTransaction($IDTransaction){
    if (empty($IDTransaction)){ return false; }
    $sql = "SELECT id_payme FROM mfo_payme WHERE purchaseOperationNumber = ? AND estado = ? LIMIT 1";
    return $GLOBALS['db']->auto_array($sql,array($IDTransaction,self::PROCESADO));    
  }

  public static function consultaByOperationNumber($operationNumber,$idusuario){
    if (empty($operationNumber)){ return false; }
    $sql = "SELECT id_payme FROM mfo_payme WHERE purchaseOperationNumber = ? AND reserved16 = ? LIMIT 1";
    return $GLOBALS['db']->auto_array($sql,array($operationNumber,$idusuario));    
  }
}  
?>
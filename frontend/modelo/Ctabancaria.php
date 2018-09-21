<?php
class Modelo_Ctabancaria{
  
  const AHORROS = 1;
  const CORRIENTE = 2;

  public static function obtieneListado(){
    $sql = "SELECT * FROM mfo_cuentasbancarias";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
}  
?>
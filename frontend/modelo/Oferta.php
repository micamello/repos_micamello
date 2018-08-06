<?php
class Modelo_Oferta{
  
  public static function obtieneNumero(){
    $sql = "SELECT COUNT(id_ofertas) AS cont FROM mfo_ofertas";
    $rs = $GLOBALS['db']->auto_array($sql,array());
    return (!empty($rs['cont'])) ? $rs['cont'] : 0;
  }

  public static function obtieneNroInteres($interes){
    $sql = "SELECT COUNT(id_ofertas) AS cont FROM mfo_ofertas where intereses like '%$interes;%'";
    $rs = $GLOBALS['db']->auto_array($sql,array());
    return (!empty($rs['cont'])) ? $rs['cont'] : 0;
  }
  
}  
?>

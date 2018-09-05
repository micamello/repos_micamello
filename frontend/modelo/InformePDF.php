<?php
class Modelo_InformePDF{
  
  public static function obtieneParametro($id){
    $sql = "SELECT descripcion FROM mfo_parametro WHERE id_parametros ='$id';";
    return $GLOBALS['db']->auto_array($sql,array());
  }

}  
?>

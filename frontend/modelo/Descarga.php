<?php
class Modelo_Descarga{

  public static function registrarDescarga($id_infohv,$id_empresa){

    return $GLOBALS['db']->insert('mfo_descarga',array('id_empresa'=>$id_empresa,'id_infohv'=>$id_infohv));
  }

  public static function cantidadDescarga($id_empresa){
  	if (empty($id_empresa)){ return false; }
    $sql = "SELECT COUNT(1) as cantd_descarga FROM mfo_descarga WHERE id_empresa = ?";
    return $rs = $GLOBALS['db']->auto_array($sql,array($id_empresa));
  }

}  
?>
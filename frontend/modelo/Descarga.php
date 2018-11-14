<?php
class Modelo_Descarga{

  public static function registrarDescarga($id_infohv,$id_empresa,$id_oferta=false){
    if (empty($id_infohv) || empty($id_empresa)){ return false; }
    $val_insert = array();
    $val_insert['id_empresa'] = $id_empresa;
    $val_insert['id_infohv'] = $id_infohv;
    if (!empty($id_oferta)){
      $val_insert['id_ofertas'] = $id_oferta;
    }
    return $GLOBALS['db']->insert('mfo_descarga',$val_insert);
  }

  public static function cantidadDescarga($id_empresa){
  	if (empty($id_empresa)){ return false; }
    $sql = "SELECT COUNT(1) as cantd_descarga FROM mfo_descarga WHERE id_empresa = ?";
    return $rs = $GLOBALS['db']->auto_array($sql,array($id_empresa));
  }

  public static function obtieneDescargaCV($infoHv, $id_empresa,$id_oferta){
    if (empty($infoHv) || empty($id_empresa)){ return false; }
    $sql = "SELECT COUNT(1) as cantd_descarga FROM mfo_descarga WHERE id_infohv = ? AND id_empresa = ? AND id_ofertas = ?";
    return $rs = $GLOBALS['db']->auto_array($sql,array($infoHv,$id_empresa,$id_oferta));
  }
}  
?>
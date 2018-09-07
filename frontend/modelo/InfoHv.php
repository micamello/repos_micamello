<?php
class Modelo_InfoHv{

  public static function cargarHv($idUsuario,$ext){

    return $GLOBALS['db']->insert('mfo_infohv',array('id_usuario'=>$idUsuario,'formato'=>$ext,'fecha_creacion'=>date("Y-m-d H:i:s")));
  }

  public static function actualizarHv($idHv,$ext){

    return $GLOBALS['db']->update('mfo_infohv',array('formato'=>$ext),'id_infohv = '.$idHv);
  }
  
  public static function obtieneHv($idUsuario){

  	$sql = "SELECT * FROM mfo_infohv WHERE id_usuario = ".$idUsuario;
    return $GLOBALS['db']->auto_array($sql,array(),false);
  }

  public static function obtieneHvAspirantes($idOferta){

    $sql = "SELECT i.id_usuario FROM mfo_infohv i, mfo_oferta o WHERE o.id_ofertas = $idOferta AND o.id_usuario = i.id_usuario";
    $arraydatos = $GLOBALS['db']->auto_array($sql,array(),false);
    $datos = array();
    if (!empty($arrdatos) && is_array($arrdatos)){

      foreach ($arrdatos as $key => $value) {
        $datos[$value['id_usuario']] = 1;
      }
    }
    return $datos;
}
}  
?>
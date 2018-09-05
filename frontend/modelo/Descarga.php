<?php
class Modelo_Descarga{

  public static function registrarDescarga($id_infohv,$id_empresa){

    return $GLOBALS['db']->insert('mfo_descarga',array('id_usuario'=>$id_empresa,'id_infohv'=>$id_infohv));
  }

}  
?>
<?php
class Modelo_EmpresaBloq{
  
  public static function insertEmpresa($idusuario,$idempresa){

    $data_insert = array('id_usuario'=>$idusuario,'id_empresa'=>$idempresa);
    return $GLOBALS['db']->insert('mfo_empresa_bloq',$data_insert);   
  }
}  
?>
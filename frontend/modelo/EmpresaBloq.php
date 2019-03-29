<?php
class Modelo_EmpresaBloq{
  
  public static function consultarEmpresa($idusuario,$idempresa){

  	$sql = 'SELECT id_empresa_bloq FROM mfo_empresa_bloq WHERE id_usuario = '.$idusuario.' AND id_empresa = '.$idempresa;
    return $GLOBALS['db']->auto_array($sql,array(),false); 
  }

  public static function insertEmpresa($idusuario,$idempresa){

  	$rs = self::consultarEmpresa($idusuario,$idempresa);
  	if(empty($rs)){
    	$data_insert = array('id_usuario'=>$idusuario,'id_empresa'=>$idempresa);
    	return $GLOBALS['db']->insert('mfo_empresa_bloq',$data_insert); 
    }  
  }

  
}  
?>
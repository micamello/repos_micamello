<?php
class Modelo_RequisitoxUsuario{
  
  public static function crearRequisitoUsuario($requisitos){  	
  	if (empty($requisitos)){ return false; }
  	return $GLOBALS['db']->insert('mfo_requisitosusuario',array('id_usuario'=>$requisitos['id_usuario'],'estado_civil'=>$requisitos['estado_civil'],'anosexp'=>$requisitos['anosexp'],'status_carrera'=>$requisitos['status_carrera'],'id_escolaridad'=>$requisitos['id_escolaridad'],'genero'=>$requisitos['genero'],'apellidos'=>$requisitos['apellidos']));
  }
}  
?>
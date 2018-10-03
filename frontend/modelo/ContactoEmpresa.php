<?php
class Modelo_ContactoEmpresa{
  
  public static function crearContactoEmpresa($data, $user_id){  	
  	if (empty($data) || empty($user_id)){ return false; }
  	return $GLOBALS['db']->insert('mfo_contactoempresa',array('id_empresa'=>$user_id,'nombres'=>$data['nombre_contact'],'apellidos'=>$data['apellido_contact'],'telefono1'=>$data['tel_one_contact'],'telefono2'=>$data['tel_two_contact']));
  }
}  
?>
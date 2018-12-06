<?php
class Modelo_ContactoEmpresa{
  
  public static function crearContactoEmpresa($dato_contacto, $user_id){  	
    // Utils::log("datos de la empresa eder: ".print_r($dato_contacto, true));
    // exit();
  	if (empty($dato_contacto) || empty($user_id)){ return false; }
  	return $GLOBALS['db']->insert('mfo_contactoempresa',array('id_empresa'=>$user_id,'nombres'=>$dato_contacto['nombres'],'apellidos'=>$dato_contacto['apellidos'],'telefono1'=>$dato_contacto['telefono1'],'telefono2'=>$dato_contacto['telefono2']));
  }

  public static function editarContactoEmpresa($data,$user_id){

  	$telf2 = $data['tel_two_contact'];
  	$datos = array('nombres'=>$data['nombre_contact'],'apellidos'=>$data['apellido_contact'],'telefono1'=>$data['tel_one_contact']);
  	if($telf2 != ''){
  		$datos['telefono2'] = $telf2;
  	}else{
      $datos['telefono2'] = NULL;
    }

  	$result = $GLOBALS['db']->update('mfo_contactoempresa',$datos, 'id_empresa = '.$user_id);
	return $result;
  }
}  
?>
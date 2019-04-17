<?php
class Modelo_ContactoEmpresa{
  
  public static function crearContactoEmpresa($datoContacto, $user_id){
  	if (empty($datoContacto) || empty($user_id)){ return false; }
    print_r($datoContacto);
    // exit();
    if(!isset($datoContacto['tel2ConEmp'])){
      // if($datoContacto['tel2ConEmp'] == ''){
        $datoContacto['tel2ConEmp'] = NULL;
      // }
    }

    $result = $GLOBALS['db']->insert('mfo_contactoempresa',
                                    array(
                                          'id_empresa'=>$user_id,
                                          'nombres'=>$datoContacto['nombreConEmp'],
                                          'apellidos'=>$datoContacto['apellidoConEmp'],
                                          'telefono1'=>$datoContacto['tel1ConEmp'],
                                          'telefono2'=>$datoContacto['tel2ConEmp']));
    return $result;
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
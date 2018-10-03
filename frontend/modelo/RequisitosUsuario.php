<?php
class Modelo_RequisitosUsuario{

  public static function updateRequisitosUsuario($data,$idUsuario){

    $datos = array("apellidos"=>$data['apellidos'],"genero"=>$data['genero'],"discapacidad"=>$data['discapacidad'],"anosexp"=>$data['experiencia'],"status_carrera"=>$data['estatus'],"id_escolaridad"=>$data['escolaridad'],"licencia"=>$data['licencia'],"viajar"=>$data['viajar'],"tiene_trabajo"=>$data['tiene_trabajo'],"estado_civil"=>$data['estado_civil']);
    
    if($_POST['lugar_estudio'] == 1){
    	$datos['nombre_univ'] = $_POST['universidad2'];
    	$datos['id_univ'] = 'null';
    }else{
    	$datos['id_univ'] = $_POST['universidad'];
    	$datos['nombre_univ'] = ' ';
    }

    return $GLOBALS['db']->update("mfo_requisitosusuario",$datos,"id_usuario=".$idUsuario);
  }

  public static function crearRequisitoUsuario($requisitos){    
    if (empty($requisitos)){ return false; }
    return $GLOBALS['db']->insert('mfo_requisitosusuario',array('id_usuario'=>$requisitos['id_usuario'],'estado_civil'=>$requisitos['estado_civil'],'anosexp'=>$requisitos['anosexp'],'status_carrera'=>$requisitos['status_carrera'],'id_escolaridad'=>$requisitos['id_escolaridad'],'genero'=>$requisitos['genero'],'apellidos'=>$requisitos['apellidos']));
  }

}  
?>
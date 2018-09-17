<?php
class Modelo_RequisitosUsuario{

  public static function updateRequisitosUsuario($data,$idUsuario){

    $datos = array("apellidos"=>$data['apellidos'],"genero"=>$data['genero'],"discapacidad"=>$data['discapacidad'],"anosexp"=>$data['experiencia'],"status_carrera"=>$data['estatus'],"id_escolaridad"=>$data['escolaridad'],"id_univ"=>$data['universidad'],"licencia"=>$data['licencia'],"viajar"=>$data['viajar'],"tiene_trabajo"=>$data['tiene_trabajo'],"estado_civil"=>$data['estado_civil']);
    return $GLOBALS['db']->update("mfo_requisitosusuario",$datos,"id_usuario=".$idUsuario);
  }

}  
?>
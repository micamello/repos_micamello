<?php
class Modelo_Respuesta{
  
  public static function guardarResp($valor,$selec,$tiempo,$usuario,$test,$pregunta){  	
  	if (empty($valor) || empty($selec) || empty($tiempo) || empty($usuario) || empty($test) || empty($pregunta)){ return false; }
  	return $GLOBALS['db']->insert('mfo_respuesta',array('valor'=>$valor,'seleccion'=>$selec,'tiempo'=>$tiempo,
  																											'estado'=>1,'id_usuario'=>$usuario,'id_cuestionario'=>$test,
  																											'id_pre'=>$pregunta));
  	
  }

  public static function totalxRasgo($test,$preguntas){
  	if (empty($test) || empty($preguntas)){ return false; }
    $sql = "select sum(valor) as total from mfo_respuesta where id_cuestionario = ? and estado = 1 and id_pre in(".$preguntas.");";
    $rs = $GLOBALS['db']->auto_array($sql,array($test));
    return (empty($rs['total'])) ? 0 : $rs['total'];
  }

}  
?>
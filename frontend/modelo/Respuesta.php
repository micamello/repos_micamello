<?php
class Modelo_Respuesta{
  
  public static function guardarResp($valor,$selec,$tiempo,$usuario,$test,$pregunta){  	
  	if (empty($valor) || empty($selec) || empty($tiempo) || empty($usuario) || empty($test) || empty($pregunta)){ return false; }
  	return $GLOBALS['db']->insert('mfo_respuesta',array('valor'=>$valor,'seleccion'=>$selec,'tiempo'=>$tiempo,
  																											'estado'=>1,'id_usuario'=>$usuario,'id_cuestionario'=>$test,
  																											'id_pre'=>$pregunta));
  	
  }

  public static function totalxRasgo($test,$preguntas,$usuario){
  	if (empty($test) || empty($preguntas) || empty($usuario)){ return false; }
    $sql = "SELECT SUM(valor) AS total FROM mfo_respuesta WHERE id_cuestionario = ? AND id_usuario = ? AND estado = 1 AND id_pre IN(".$preguntas.")";
    $rs = $GLOBALS['db']->auto_array($sql,array($test,$usuario));
    return (empty($rs['total'])) ? 0 : $rs['total'];
  }

}  
?>
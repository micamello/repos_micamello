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

  /************MINISITIO****************/
  public static function guardarValores($orden,$tiempo,$idusuario,$idopcion){    
    if (empty($orden) || empty($tiempo) || empty($idusuario) || empty($idopcion)){ return false; }

    for ($i=0; $i < count($orden); $i++) { 
      $datosinsert = array('orden_seleccion' => $orden[$i],
                         'tiempo' => $tiempo,
                         'id_usuario' => $idusuario,
                         'id_opcion' => $idopcion[$i]);
      $result = $GLOBALS['db']->insert('mfo_respuestam2',$datosinsert);
    }

    
    return $result;
  }

}  
?>
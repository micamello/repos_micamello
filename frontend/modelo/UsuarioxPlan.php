<?php
class Modelo_UsuarioxPlan{

  public static function planesActivos($usuario){
    if (empty($usuario)){ return false; }
    $sql = "SELECT * FROM mfo_usuario_plan WHERE id_usuario = ? AND estado = 1 AND (fecha_caducidad > NOW() || fecha_caducidad IS NULL) ORDER BY fecha_compra ASC";
    return $GLOBALS['db']->auto_array($sql,array($usuario),true);
  }

  public static function guardarPlan($usuario,$plan,$numpost,$duracion,$idcomprobante=''){
	    if (empty($usuario) || empty($plan)){ return false; }
	    $values_insert = array();
	    $fechacreacion = date('Y-m-d H:i:s');    
	    $values_insert["fecha_compra"] = $fechacreacion;
	    $values_insert["id_usuario"] = $usuario;
	    $values_insert["id_plan"] = $plan;
	    $values_insert["estado"] = 1;
	    if (!empty($numpost)){
	      $values_insert["num_post_rest"] = $numpost;
	    }    
	    if (!empty($duracion)){
	    	$fechacaducidad = strtotime ( '+'.$duracion.' day',strtotime($fechacreacion));
	      $values_insert["fecha_caducidad"] = date('Y-m-d H:i:s',$fechacaducidad);
	    }
      if (!empty($idcomprobante)){
        $values_insert["id_comprobante"] = $idcomprobante;
      }
	    return $GLOBALS['db']->insert('mfo_usuario_plan',$values_insert);
	}

	public static function desactivarPlan($id_usuario_plan,$observacion=''){
		$result = $GLOBALS['db']->update('mfo_usuario_plan',array('estado'=>0,'observacion'=>$observacion), 'id_usuario_plan = '.$id_usuario_plan);
		return $result;
	}
	
  public static function publicacionesRestantes($usuario){
    if (empty($usuario)){ return false; }
    $sql = "SELECT sum(num_post_rest) as p_restantes FROM mfo_usuario_plan WHERE id_usuario = ? AND estado = 1 AND (fecha_caducidad > NOW() || fecha_caducidad IS NULL)";
    return $GLOBALS['db']->auto_array($sql,array($usuario));
  }

  public static function restarPublicaciones($id_plan_usuario, $num_post){
    if (empty($id_plan_usuario) || empty($num_post)) {return false;}
    $num_post = $num_post-1;
    $result = $GLOBALS['db']->update('mfo_usuario_plan', array("num_post_rest"=>$num_post), "id_usuario_plan = ".$id_plan_usuario);
    return $result;
  }

  public static function existePlan($usuario,$plan){
    if (empty($usuario) || empty($plan)){ return false; }
    $sql = "SELECT id_usuario_plan FROM mfo_usuario_plan WHERE id_usuario = ? AND id_plan = ?";
    $result = $GLOBALS['db']->auto_array($sql,array($usuario,$plan));
    return (isset($result['id_usuario_plan']) && !empty($result['id_usuario_plan'])) ? true : false;
  }

  public static function modificarPlan($usuario,$plan,$numpost,$duracion,$idcomprobante=''){
    if (empty($usuario) || empty($plan)){ return false; }
    $values_update = array();
    $fechacreacion = date('Y-m-d H:i:s');    
    $values_update["fecha_compra"] = $fechacreacion;
    $values_update["estado"] = 1;
    if (!empty($numpost)){
      $values_update["num_post_rest"] = $numpost;
    }    
    if (!empty($duracion)){
      $fechacaducidad = strtotime ( '+'.$duracion.' day',strtotime($fechacreacion));
      $values_update["fecha_caducidad"] = date('Y-m-d H:i:s',$fechacaducidad);
    }
    if (!empty($idcomprobante)){
      $values_update["id_comprobante"] = $idcomprobante;
    }
    return $GLOBALS['db']->update('mfo_usuario_plan',$values_update,'id_usuario='.$usuario.' AND id_plan='.$plan);
  }

  public static function disponibilidadDescarga($id_empresa){

    $sql = "SELECT porc_descarga FROM mfo_usuario_plan p, mfo_plan pl WHERE p.id_plan = pl.id_plan AND (pl.porc_descarga > 0 or pl.porc_descarga = -1)
            AND pl.tipo_usuario = 2 AND p.id_usuario = ?";
    $arrdatos = $GLOBALS['db']->auto_array($sql,array($id_empresa),true);

    $datos = array();
    if (!empty($arrdatos) && is_array($arrdatos)){

      foreach ($arrdatos as $key => $value) {
        array_push($datos,$value['porc_descarga']);
      }
    }
    return $datos;
  }

  public static function planesConAutopostulaciones($idusuario){
    if (empty($idusuario)){ return false; }
    $sql = "SELECT id_usuario_plan, fecha_compra, num_post_rest 
            FROM mfo_usuario_plan 
            WHERE id_usuario = ? AND estado = 1 AND 
                  fecha_caducidad > NOW() AND num_post_rest > 0 
            ORDER BY fecha_compra";
    return $GLOBALS['db']->auto_array($sql,array($idusuario),true);   
  }

  public static function consultaNroPostulaciones($idusuarioplan){
    if (empty($idusuarioplan)){ return false; }
    $sql = "SELECT num_post_rest FROM mfo_usuario_plan WHERE id_usuario_plan = ? LIMIT 1";
    $rs = $GLOBALS['db']->auto_array($sql,array($idusuarioplan));    
    return $rs["num_post_rest"];
  }

  public static function ultimoPlanActivo($usuario,$plan){
    if (empty($usuario) || empty($plan)){ return false; }
    $sql = "SELECT id_usuario_plan FROM mfo_usuario_plan WHERE id_usuario = ? AND id_plan = ? AND estado = 1 ORDER BY fecha_compra DESC LIMIT 1";
    return $GLOBALS['db']->auto_array($sql,array($usuario,$plan));   
  }

  public static function sumarPublicaciones($id_plan_usuario){
    if (empty($id_plan_usuario)) { return false; }    
    return $GLOBALS['db']->execute("UPDATE mfo_usuario_plan SET num_post_rest = num_post_rest + 1 WHERE id_usuario_plan = ".$id_plan_usuario);
  }

}  
?>
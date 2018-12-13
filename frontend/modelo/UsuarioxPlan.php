<?php
class Modelo_UsuarioxPlan{


  public static function planesActivos($usuario,$tipo){
    if (empty($usuario) || empty($tipo)){ return false; }
    if ($tipo == Modelo_Usuario::CANDIDATO){
      $sql = "SELECT * FROM mfo_usuario_plan WHERE id_usuario = ? AND estado = 1 AND (fecha_caducidad > NOW() || fecha_caducidad IS NULL) ORDER BY fecha_compra ASC";
    }
    else{
      $sql = "SELECT * FROM mfo_empresa_plan WHERE id_empresa = ? AND estado = 1 AND (fecha_caducidad > NOW() || fecha_caducidad IS NULL) ORDER BY fecha_compra ASC"; 
    }
    return $GLOBALS['db']->auto_array($sql,array($usuario),true);
  }

  public static function guardarPlan($usuario,$tipousuario,$plan,$numpost,$duracion,$porcdesc=0,$idcomprobante='',$fechacreacion=false,$fechacaducidad=false,$idEmpresaPlanParent=false){

	    if (empty($usuario) || empty($plan)){ return false; }
	    $values_insert = array();
	    $fechacreacion = (empty($fechacreacion)) ? date('Y-m-d H:i:s') : $fechacreacion;    
	    $values_insert["fecha_compra"] = $fechacreacion;
      $campo = ($tipousuario == Modelo_Usuario::CANDIDATO) ? "id_usuario" : "id_empresa";       
	    $values_insert[$campo] = $usuario;      
	    $values_insert["id_plan"] = $plan;
	    $values_insert["estado"] = 1;
	    if (!empty($numpost)){
        $campo = ($tipousuario == Modelo_Usuario::CANDIDATO) ? "num_post_rest" : "num_publicaciones_rest";               
        $values_insert[$campo] = $numpost;         
	    }    
      if (!empty($fechacaducidad)){
        $values_insert["fecha_caducidad"] = $fechacaducidad;
      }
      else{  
        if (!empty($duracion)){ 	    
  	      $fechacaducidad = strtotime ( '+'.$duracion.' day',strtotime($fechacreacion));
  	      $values_insert["fecha_caducidad"] = date('Y-m-d H:i:s',$fechacaducidad);  	    
        }

      }
      if (!empty($idcomprobante)){
        $values_insert["id_comprobante"] = $idcomprobante;
      }
    if ($tipousuario == Modelo_Usuario::EMPRESA){
      $values_insert["num_descarga_rest"] = $porcdesc;
      if ($idEmpresaPlanParent != false){
        $values_insert["id_empresa_plan_parent"] = $idEmpresaPlanParent;
      }
    }
    $tabla = ($tipousuario == Modelo_Usuario::CANDIDATO) ? "mfo_usuario_plan" : "mfo_empresa_plan";

    return $GLOBALS['db']->insert($tabla,$values_insert);
  }
 
  public static function desactivarPlan($id_usuario_plan,$tipousu){
    if (empty($id_usuario_plan) || empty($tipousu)){ return false; }
    if ($tipousu == Modelo_Usuario::CANDIDATO){
      $result = $GLOBALS['db']->update('mfo_usuario_plan',array('estado'=>0),'id_usuario_plan='.$id_usuario_plan);
    }
    else{
      $result = $GLOBALS['db']->update('mfo_empresa_plan',array('estado'=>0),'id_empresa_plan='.$id_usuario_plan);
    }		
    return $result;
  }
	
  public static function publicacionesRestantes($usuario){
    if (empty($usuario)){ return false; }
      $sql = "SELECT sum(num_post_rest) as p_restantes FROM mfo_usuario_plan WHERE id_usuario = ? AND estado = 1 AND (fecha_caducidad > NOW() || fecha_caducidad IS NULL) AND estado = 1;"; 
    return $GLOBALS['db']->auto_array($sql,array($usuario));
  }
 
  public static function restarPublicaciones($id_plan_usuario, $num_post, $tipousu){
    if (empty($id_plan_usuario) || empty($num_post) || empty($tipousu)) {return false;}
    $num_post = $num_post-1;
    if ($tipousu == Modelo_Usuario::CANDIDATO){
      $result = $GLOBALS['db']->update('mfo_usuario_plan', array("num_post_rest"=>$num_post), "id_usuario_plan = ".$id_plan_usuario);
    }
    else{
      $result = $GLOBALS['db']->update('mfo_empresa_plan', array("num_publicaciones_rest"=>$num_post), "id_empresa_plan = ".$id_plan_usuario);
    }    
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

    $sql = "SELECT num_descarga_rest 
            FROM mfo_empresa_plan  
            WHERE (num_descarga_rest > 0 or num_descarga_rest = -1) AND 
                  id_empresa = ? AND estado = 1 AND (fecha_caducidad > NOW() || fecha_caducidad IS NULL) ORDER BY fecha_compra ASC";
    $arrdatos = $GLOBALS['db']->auto_array($sql,array($id_empresa),true);
    $datos = array();
    if (!empty($arrdatos) && is_array($arrdatos)){
      foreach ($arrdatos as $key => $value) {
        array_push($datos,$value['num_descarga_rest']);
      }
    }
    return $datos;
  }
 
  public static function obtenerAspiranteSegunPlanContratado($id_usuario,$id_usuario_plan){
    $sql = "SELECT count(1) AS aspirantes
    FROM mfo_postulacion p, mfo_usuario_plan up, mfo_oferta o
    WHERE up.id_plan = o.id_plan
    AND o.id_ofertas = p.id_ofertas
    AND up.id_usuario_plan = $id_usuario_plan
    AND o.id_usuario = $id_usuario";
    return $GLOBALS['db']->auto_array($sql,'',false);
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

  public static function obtienePlanComprobante($txnid,$usuario,$plan,$tipousu){
    if (empty($txnid) || empty($usuario) || empty($plan) || empty($tipousu)){ return false; }
    if ($tipousu == Modelo_Usuario::CANDIDATO){
      $sql = "SELECT u.id_usuario_plan, c.id_comprobante FROM mfo_rcomprobantescam c
              INNER JOIN mfo_usuario_plan u ON u.id_comprobante = c.id_comprobante
              WHERE c.num_comprobante = ? AND u.estado = 1 AND u.id_usuario = ? AND 
                    c.id_user_emp = ? AND c.id_plan = ? AND u.id_plan = ? LIMIT 1";
    }
    else{
      $sql = "SELECT e.id_empresa_plan AS id_usuario_plan, c.id_comprobante FROM mfo_rcomprobantescam c 
              INNER JOIN mfo_empresa_plan e ON e.id_comprobante = c.id_comprobante
              WHERE c.num_comprobante = ? AND e.estado = 1 AND e.id_empresa = ? AND 
                    c.id_user_emp = ? AND c.id_plan = ? AND e.id_plan = ? LIMIT 1";
    }
    return $GLOBALS['db']->auto_array($sql,array($txnid,$usuario,$usuario,$plan,$plan));   
  }
 
  public static function sumarPublicaciones($id_plan_usuario){
    if (empty($id_plan_usuario)) { return false; }    
    return $GLOBALS['db']->execute("UPDATE mfo_usuario_plan SET num_post_rest = num_post_rest + 1 WHERE id_usuario_plan = ".$id_plan_usuario);
  }


  public static function planesActivosPagados($tipo,$idEmpresa=false){

    if (empty($tipo)){ return false; }
    if ($tipo == Modelo_Usuario::CANDIDATO){        
      $sql = "SELECT up.id_usuario_plan, up.id_usuario, up.fecha_caducidad, p.nombre, up.fecha_compra
              FROM mfo_usuario_plan up
              INNER JOIN mfo_plan p ON p.id_plan = up.id_plan
              WHERE up.estado = 1 AND up.fecha_caducidad IS NOT NULL
              ORDER BY up.id_usuario";  
      return $GLOBALS['db']->auto_array($sql,array(),true);  
    }        
    else{
      $sql = "SELECT ";

      if (!empty($idEmpresa)){ 
        $sql .= "GROUP_CONCAT(DISTINCT(p.id_plan)) AS planes_activos, GROUP_CONCAT(DISTINCT(em.id_empresa_plan)) AS id_empresa_plan";
      }else{ 
        $sql .= "em.id_empresa_plan AS id_usuario_plan, em.id_empresa AS id_usuario, em.fecha_caducidad, p.nombre, em.fecha_compra";
      }          
      
      $sql .= " FROM mfo_empresa_plan em
              INNER JOIN mfo_plan p ON p.id_plan = em.id_plan
              WHERE em.estado = 1 AND em.fecha_caducidad > NOW()";

      if (!empty($idEmpresa)){ 
         $sql .= " AND p.num_cuenta > 0 AND em.id_empresa = ".$idEmpresa." GROUP BY em.id_empresa LIMIT 1";
        return $GLOBALS['db']->auto_array($sql,array(),false);
      }else{
        $sql .= " AND em.fecha_caducidad IS NOT NULL ORDER BY em.id_empresa";
        return $GLOBALS['db']->auto_array($sql,array(),true);
      }
    }     
  }

  public static function obtienePlanesHijos($idplanpadre){
    if (empty($idplanpadre)){ return false; }
    $sql = "SELECT id_empresa_plan, id_empresa 
            FROM mfo_empresa_plan WHERE id_empresa_plan_parent = ? AND estado = 1";
    return $GLOBALS['db']->auto_array($sql,array($idplanpadre),true);
  }

  public static function puedeCrearCuentas($padre,$cantd_empresas){

    if (empty($padre) && empty($cantd_empresas)){ return false; }

      $sql = "SELECT ep.id_empresa_plan FROM mfo_empresa_plan ep 
          INNER JOIN mfo_empresa e ON e.id_empresa = ep.id_empresa
          INNER JOIN mfo_plan p ON p.id_plan = ep.id_plan
          WHERE ep.estado = 1 AND ep.fecha_caducidad > NOW() 
          AND e.padre = ?
          AND p.num_cuenta >= ?
          GROUP BY ep.id_empresa;";
    return $GLOBALS['db']->auto_array($sql,array($padre,$cantd_empresas));
  }

  #OBTENER LAS PUBLICACIONES Y DESCARGAS SEGUN EL PLAN SELECCIONADO
  public static function tieneRecursos($idEmpresaPlan=false,$idEmpresa=false){

    $sql = "SELECT ep.num_publicaciones_rest AS numero_postulaciones, ep.num_descarga_rest AS numero_descarga, p.num_cuenta";
    
    $sql .= " FROM mfo_empresa_plan ep
      INNER JOIN mfo_plan p ON p.id_plan = ep.id_plan
      WHERE ep.estado = 1 AND p.num_cuenta > 0 AND ep.fecha_caducidad > NOW()";

    if($idEmpresaPlan!=false){
      $sql.= " AND ep.id_empresa_plan = ".$idEmpresaPlan;
    }else{
      $sql .= " AND ep.id_empresa = ".$idEmpresa;
    }

    return $GLOBALS['db']->auto_array($sql,array(),true);
  }

  public static function consultarRecursosAretornar($idPlanEmpresa){
  
    $sql = "SELECT id_empresa_plan, id_empresa_plan_parent, num_publicaciones_rest,num_descarga_rest, fecha_compra, fecha_caducidad, id_plan, id_empresa, estado FROM mfo_empresa_plan 
      WHERE id_empresa_plan = $idPlanEmpresa";
    return $GLOBALS['db']->auto_array($sql,array());
  }

  public static function devolverRecursos($recursos){

    if($recursos['id_empresa_plan_parent'] == ''){
      $recursos['id_empresa_plan_parent'] = $recursos['id_empresa_plan'];
    }
print_r($recursos);
    echo $sql = "SELECT num_publicaciones_rest,num_descarga_rest FROM mfo_empresa_plan WHERE id_empresa_plan = ".$recursos['id_empresa_plan_parent']." LIMIT 1";
    $result = $GLOBALS['db']->auto_array($sql,array(),false);

    if($result['num_publicaciones_rest'] != -1 && $recursos['num_publicaciones_rest'] != -1){
      $cantd_post = $result['num_publicaciones_rest']+$recursos['num_publicaciones_rest'];
    }else{
      $cantd_post = -1;
    }

    if($result['num_descarga_rest'] != -1 && $recursos['num_descarga_rest'] != -1){
      $cantd_desc = $result['num_descarga_rest']+$recursos['num_descarga_rest'];
    }else{
      $cantd_desc = -1;
    }
echo $cantd_post; 
echo $cantd_desc; exit;
    return $GLOBALS['db']->update('mfo_empresa_plan',array('num_publicaciones_rest' => $cantd_post, 'num_descarga_rest' => $cantd_desc),'id_empresa_plan='.$recursos['id_empresa_plan_parent']);
  }

  public static function planesConCuentas($idEmpresa,$planes=false){

    $sql = "SELECT ep.id_empresa_plan, p.nombre, ep.id_plan
      FROM mfo_empresa_plan ep
      INNER JOIN mfo_plan p ON p.id_plan = ep.id_plan
      WHERE ep.estado = 1 AND ep.fecha_caducidad > NOW()
      AND p.num_cuenta > 0 AND ep.id_empresa = $idEmpresa 
      AND ((ep.num_descarga_rest > 0 or ep.num_descarga_rest = -1)
      OR (ep.num_publicaciones_rest > 0 or ep.num_publicaciones_rest = -1))";

    if(!empty($planes)){
      $sql .= " AND ep.id_plan NOT IN(".$planes.")";
    }

    return $GLOBALS['db']->auto_array($sql,array(),true);   
  }

  public static function actualizarPublicacionesEmpresa($id_empresa_plan, $num_post,$num_desc){
    if (empty($id_empresa_plan) || empty($num_post) || empty($num_desc)) {return false;}

    $result = $GLOBALS['db']->update('mfo_empresa_plan', array("num_publicaciones_rest"=>$num_post,"num_descarga_rest"=>$num_desc, "estado"=>1), "id_empresa_plan = ".$id_empresa_plan);
    return $result;
  }

  public static function actualizaEstadoPlan($id_empresa_plan, $estado){
    
    if (empty($id_empresa_plan)) {return false;}

    if($estado == ''){
      $estado = 0;
    }
    
    $result = $GLOBALS['db']->update('mfo_empresa_plan', array("estado"=>$estado), "id_empresa_plan = ".$id_empresa_plan);
    return $result;
  }

  public static function planCuentaPropio($idEmpresa){

    $estatus = false;
    $sql = "SELECT id_empresa_plan 
    FROM mfo_empresa_plan ep 
    INNER JOIN mfo_plan p ON p.id_plan = ep.id_plan
    WHERE ep.id_empresa = $idEmpresa AND ep.id_empresa_plan_parent IS NULL
    AND p.costo > 0 AND p.num_cuenta > 0 LIMIT 1;";

    $result = $GLOBALS['db']->auto_array($sql,array(),true);

    if(count($result)>0){
      $estatus = true;
    }

    return $estatus;
  }
}  

?>
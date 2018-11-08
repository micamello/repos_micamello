<?php 
class Modelo_Oferta{

  const ESTATUS_OFERTA = array('1'=>'CONTRATADO','2'=>'NO CONTRATADO','3'=>'EN PROCESO');

  public static function obtieneNumero($pais){
    if (empty($pais)){ return false; }
    $sql = "SELECT COUNT(1) AS cont FROM mfo_oferta o
            INNER JOIN mfo_ciudad c ON c.id_ciudad = o.id_ciudad
            INNER JOIN mfo_provincia p ON p.id_provincia = c.id_provincia
            WHERE o.estado = 1 AND p.id_pais = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($pais));
    return (!empty($rs['cont'])) ? $rs['cont'] : 0;
  }

  public static function obtieneNroArea($area){
    $sql = "SELECT COUNT(id_ofertas) AS cont FROM mfo_oferta where id_area = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($area));
    return (!empty($rs['cont'])) ? $rs['cont'] : 0;
  }

  public static function obtieneOfertas($id=false,$page=false,$vista=false,$idusuario=false,$obtCantdRegistros=false,$pais_empresa){    
    $sql = "SELECT ";

    if($obtCantdRegistros == false){
        $sql .= "o.id_ofertas, o.fecha_creado, o.titulo, o.descripcion, o.salario, o.fecha_contratacion,o.vacantes,o.anosexp,
      a.nombre AS area, n.descripcion AS nivel, j.nombre AS jornada, p.nombre AS provincia, c.nombre AS ciudad, e.descripcion AS escolaridad, r.confidencial,r.discapacidad,r.residencia, r.edad_maxima,
      r.edad_minima, r.licencia, r.viajar, u.nombres AS empresa, u.id_usuario, a.id_area";

      if (!empty($vista) && ($vista == 'postulacion')){ 
         $sql .= ", pos.tipo, pos.id_auto as id_postulacion, pos.resultado";
      }

      if(!empty($id)){
         $sql .= ", GROUP_CONCAT(ni.id_nivelIdioma_idioma) as idiomas";
      }

    }else{
      $sql .= "count(1) as cantd_ofertas";
    }


    $sql .= " FROM mfo_oferta o, mfo_usuario u, mfo_requisitooferta r, mfo_escolaridad e, mfo_area a, mfo_nivelinteres n, mfo_jornada j, mfo_ciudad c, mfo_provincia p";

    if(!empty($vista) && ($vista == 'postulacion')){

      $sql .= ", mfo_postulacion pos";
    }

    if(!empty($id)){
      $sql .= ", mfo_oferta_nivelidioma ofn, mfo_nivelidioma_idioma ni";
    }

    $sql .= " WHERE o.estado = 1 
    AND r.id_requisitoOferta = o.id_requisitoOferta
    AND e.id_escolaridad = o.id_escolaridad
    AND c.id_ciudad = o.id_ciudad
    AND p.id_provincia = c.id_provincia
    AND o.id_usuario=u.id_usuario
    AND a.id_area = o.id_area
    AND n.id_nivelInteres = o.id_nivelInteres
    AND j.id_jornada = o.id_jornada
    AND p.id_pais = ".$pais_empresa;
    
    if(!empty($vista) && ($vista == 'vacantes')){
      $sql .= " AND o.id_usuario = ".$idusuario;
    }

    if(!empty($id)){
       $sql .= " AND ni.id_nivelIdioma_idioma = ofn.id_nivelIdioma_idioma
      AND ofn.id_ofertas = o.id_ofertas AND o.id_ofertas = ".$id;
    }

    if(!empty($vista) && ($vista == 'postulacion')){
      $sql .= " AND pos.id_ofertas = o.id_ofertas AND pos.id_usuario = ".$idusuario;
    }

    if($obtCantdRegistros == false){
      $sql .= " ORDER BY o.fecha_creado DESC";
      $page = ($page - 1) * REGISTRO_PAGINA;
      $sql .= " LIMIT ".$page.",".REGISTRO_PAGINA; 
      $rs = $GLOBALS['db']->auto_array($sql,array(),true);
    }else{
      $rs = $GLOBALS['db']->auto_array($sql,array());
      $rs = $rs['cantd_ofertas'];
    }

    return $rs;
  }

  public static function filtrarOfertas(&$filtros,$page,$vista=false,$idusuario=false,$obtCantdRegistros=false,$pais_empresa){

    $sql = "SELECT ";

    if($obtCantdRegistros == false){
      $sql .= "o.id_ofertas, o.fecha_creado, o.titulo, o.descripcion, o.salario, o.fecha_contratacion,o.vacantes,o.anosexp,
      a.nombre AS area, n.descripcion AS nivel, j.nombre AS jornada, p.nombre AS provincia, c.nombre AS ciudad, e.descripcion AS escolaridad, r.confidencial,r.discapacidad,r.residencia, r.edad_maxima,r.edad_minima, r.licencia, r.viajar, u.nombres AS empresa, u.id_usuario, a.id_area";

      if (!empty($vista) && ($vista == 'postulacion')){ 
         $sql .= ", pos.tipo, pos.id_auto as id_postulacion, pos.resultado";
      }

    }else{
      $sql .= "count(1) as cantd_ofertas";
    }

    $sql .= " FROM mfo_oferta o, mfo_usuario u, mfo_requisitooferta r, mfo_escolaridad e, mfo_area a, mfo_nivelinteres n, mfo_jornada j, mfo_ciudad c, mfo_provincia p";

    if(!empty($vista) && ($vista == 'postulacion')){
      $sql .= ", mfo_postulacion pos";
    }

    $sql .= " WHERE o.estado = 1 
    AND r.id_requisitoOferta = o.id_requisitoOferta
    AND e.id_escolaridad = o.id_escolaridad
    AND c.id_ciudad = o.id_ciudad
    AND o.id_usuario=u.id_usuario
    AND n.id_nivelInteres = o.id_nivelInteres
    AND p.id_provincia = c.id_provincia
    AND a.id_area = o.id_area
    AND j.id_jornada = o.id_jornada
    AND p.id_pais = ".$pais_empresa;

    if(!empty($filtros['P']) && $filtros['P'] != 0){
       $sql .= " AND p.id_provincia = ".$filtros['P'];
    }
    
    if(!empty($filtros['A']) && $filtros['A'] != 0){
      $sql .= " AND a.id_area = ".$filtros['A'];
    }

    if(!empty($filtros['J']) && $filtros['J'] != 0){
      $sql .= " AND j.id_jornada = ".$filtros['J'];
    }

    if(!empty($filtros['Q']) && $filtros['Q'] != 0 || $filtros['Q'] != ''){

      $pos = strpos($filtros['Q'], "-");
      if ($pos != false) {

        $datos_fecha = explode("-",$filtros['Q']);
        if(count($datos_fecha) == 3 && checkdate($datos_fecha[1], $datos_fecha[2], $datos_fecha[0])){
            $pclave = $datos_fecha[0].'-'.$datos_fecha[1].'-'.$datos_fecha[2];
        }else if(count($datos_fecha) == 3 && checkdate($datos_fecha[1], $datos_fecha[0], $datos_fecha[2])){
            $pclave = $datos_fecha[2].'-'.$datos_fecha[1].'-'.$datos_fecha[0];
        }
      }else{
        $pclave = $filtros['Q'];
      }

      $sql .= " AND (u.nombres LIKE '%".$pclave."%' OR o.titulo LIKE '%".$pclave."%' OR o.descripcion LIKE '%".$pclave."%' OR o.salario LIKE '%".$pclave."%' OR o.fecha_contratacion LIKE '%".$pclave."%')";
    }

    if(!empty($vista) && ($vista == 'postulacion')){
      $sql .= " AND pos.id_ofertas = o.id_ofertas AND pos.id_usuario = ".$idusuario;
    }

    if(!empty($filtros['O']) && $filtros['O'] != 0){

      $tipo = substr($filtros['O'],0,1);
      $t = substr($filtros['O'],1,2);
      if($tipo == 1){
        if($t == 1){
          $filtros['O'] = 2;
          $sql .= " ORDER BY o.salario ASC";
        }
        if($t == 2){
          $filtros['O'] = 1;
          $sql .= " ORDER BY o.salario DESC";
        }
        
      }else{
        if($t == 1){
          $filtros['O'] = 2;
          $sql .= " ORDER BY o.fecha_creado ASC";
        }
        if($t == 2){
          $filtros['O'] = 1;
          $sql .= " ORDER BY o.fecha_creado DESC";
        }
      }
    }

    if($obtCantdRegistros == false){
      $page = ($page - 1) * REGISTRO_PAGINA;
      $sql .= " LIMIT ".$page.",".REGISTRO_PAGINA; 
      $rs = $GLOBALS['db']->auto_array($sql,array(),true);
    }else{
      $rs = $GLOBALS['db']->auto_array($sql,array());
      $rs = $rs['cantd_ofertas'];
    }

    return $rs;
  }

  public static function guardarRequisitosOferta($data){
    if (empty($data)) {return false;}
    $result = $GLOBALS['db']->insert('mfo_requisitooferta', array("licencia"=>$data['licencia'], "viajar"=>$data['viaje'], "residencia"=>$data['cambio_residencia'], "discapacidad"=>$data['discapacidad'], "confidencial"=>$data['confidencial'], "edad_minima"=>$data['edad_min'], "edad_maxima"=>$data['edad_max']));
    return $result;
  }

  public static function guardarOferta($data, $id_reqOf, $idusu, $id_plan){
    if (empty($data)) {return false;}
    $result = $GLOBALS['db']->insert('mfo_oferta', array("titulo"=>$data['titu_of'], "descripcion"=>$data['des_of'], "salario"=>$data['salario'], "fecha_contratacion"=>$data['fecha_contratacion'], "vacantes"=>$data['vacantes'], "anosexp"=>$data['experiencia'], "estado"=>1, "fecha_creado"=>date("Y-m-d H:i:s"), "id_area"=>$data['area_select'][0], "id_nivelInteres"=>$data['nivel_interes'][0], "id_jornada"=>$data['jornada_of'], "id_ciudad"=>$data['ciudad_of'], "id_requisitoOferta"=>$id_reqOf, "id_escolaridad"=>$data['escolaridad'], "id_usuario"=>$idusu, "id_usuarioplan"=>$id_plan));
    return $result;
  }

  public static function aspirantesXofertas(){

    $sql = "SELECT o.id_ofertas, COUNT(p.id_auto) AS cantd_aspirantes FROM mfo_oferta o
    LEFT JOIN mfo_postulacion p ON o.id_ofertas = p.id_ofertas
    WHERE o.estado = 1
    GROUP BY o.id_ofertas;";

    $arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);
    $datos = array();
    if (!empty($arrdatos) && is_array($arrdatos)){

      foreach ($arrdatos as $key => $value) {
        $datos[$value['id_ofertas']] = $value['cantd_aspirantes'];
      }
    }
    return $datos;
  }

  public static function obtieneAutopostulaciones($pais,$fecha,$areas,$intereses,$usuario,$provincia=0){
    if (empty($pais) || empty($fecha) || empty($areas) || empty($intereses) || empty($usuario)){ return false; }
    $sql = "SELECT o.id_ofertas, o.salario, o.titulo, o.id_empresa AS id_usuario, p.nombre AS provincia, c.nombre AS ciudad
            FROM mfo_oferta o
            INNER JOIN mfo_ciudad c ON c.id_ciudad = o.id_ciudad
            INNER JOIN mfo_provincia p ON p.id_provincia = c.id_provincia
            INNER JOIN mfo_empresa_plan e ON e.id_empresa_plan = o.id_empresa_plan
            INNER JOIN mfo_plan a ON a.id_plan = e.id_plan 
            WHERE o.estado = 1 AND p.id_pais = ? AND o.fecha_contratacion >= ? AND a.costo <> 0 AND
                  o.id_area IN(".$areas.") AND o.id_nivelInteres IN(".$intereses.") AND 
                  o.id_ofertas NOT IN (SELECT id_ofertas FROM mfo_postulacion WHERE id_usuario = ?)";
    if (!empty($provincia)){
      $sql .= " AND p.id_provincia = ".$provincia;
    }
    $sql .= " ORDER BY o.fecha_creado";
    return $GLOBALS['db']->auto_array($sql,array($pais,$fecha,$usuario),true);              
  }
  
  public static function ofertasxUsuarioPlan($usuarioplan){
    if (empty($usuarioplan)){ return false; }
    $sql = "SELECT id_ofertas FROM mfo_oferta where estado = 1 AND id_empresa_plan = ?";
    return $GLOBALS['db']->auto_array($sql,array($usuarioplan),true);
  }

  public static function desactivarOferta($idoferta){
    if (empty($idoferta)){ return false; }
    return $GLOBALS['db']->update('mfo_oferta',array('estado'=>0),'id_ofertas='.$idoferta);
  }

  public static function ofertasDiarias($pais,$areas,$intereses){
    if (empty($pais) || empty($areas) || empty($intereses)){ return false; }    
    $fechaayer = date("Y-m-d",strtotime(date("Y-m-d")."- 1 day"));
    $fechadesde = $fechaayer." 00:00:00";
    $fechahasta = $fechaayer." 23:59:59";
    $sql = "SELECT o.id_ofertas, o.titulo, e.nombres AS empresa, c.nombre AS ciudad, p.nombre AS provincia
            FROM mfo_oferta o
            INNER JOIN mfo_ciudad c ON c.id_ciudad = o.id_ciudad
            INNER JOIN mfo_provincia p ON p.id_provincia = c.id_provincia
            INNER JOIN mfo_empresa e ON e.id_empresa = o.id_empresa
            WHERE o.estado = 1 AND p.id_pais = ? AND o.id_area IN(".$areas.") AND o.id_nivelInteres IN(".$intereses.") AND o.fecha_creado BETWEEN ? AND ? 
            ORDER BY o.id_ofertas";    
    return $GLOBALS['db']->auto_array($sql,array($pais,$fechadesde,$fechahasta),true);        
  }
}  
?>
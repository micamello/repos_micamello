<?php
class Modelo_Oferta{
  
  const NOMBRE_OFERTA = array('publicacion'=>'oferta','postulacion'=>'postulacion');
  const ESTATUS_OFERTA = array('1'=>'CONTRATADO','2'=>'NO CONTRATADO','3'=>'EN PROCESO');

  public static function obtieneNumero(){
    $sql = "SELECT COUNT(id_ofertas) AS cont FROM mfo_oferta";
    $rs = $GLOBALS['db']->auto_array($sql,array());
    return (!empty($rs['cont'])) ? $rs['cont'] : 0;
  }

  public static function obtieneNroArea($area){
    $sql = "SELECT COUNT(id_ofertas) AS cont FROM mfo_oferta where id_area = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($area));
    return (!empty($rs['cont'])) ? $rs['cont'] : 0;
  }
  
  public static function obtieneOfertas($id=false,$page=false,$vista=false){
    $sql = "SELECT 
        o.id_ofertas, o.fecha_creado, o.titulo, o.descripcion, o.salario, o.fecha_contratacion,o.vacantes,o.anosexp,
    a.nombre AS area, n.descripcion AS nivel, j.nombre AS jornada, p.nombre AS provincia, e.descripcion AS escolaridad, t.descripcion AS contrato, r.confidencial,r.discapacidad,r.residencia, r.edad_maxima,
    r.edad_minima, r.licencia, r.viajar, u.nombres AS empresa, u.id_usuario";

    if (!empty($vista) && $vista == 'postulacion'){ 
       $sql .= ",pos.tipo, pos.id_auto as id_postulacion, pos.resultado";
    }

    $sql .= " FROM mfo_oferta o, mfo_usuario u, mfo_requisitooferta r, mfo_escolaridad e, mfo_area a, mfo_nivelInteres n, mfo_jornada j, mfo_ciudad c, 
    mfo_tipocontrato t, mfo_provincia p";

    if(!empty($vista) && $vista == 'postulacion'){
      $sql .= ", mfo_postulacion pos";
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
    AND t.id_tipocontrato = o.id_tipocontrato";

    if(!empty($id)){
       $sql .= " AND o.id_ofertas = ".$id;
    }

    if(!empty($vista) && $vista == 'postulacion'){
      $sql .= " AND o.id_usuario = pos.id_usuario";
    }

    $sql .= " ORDER BY o.fecha_creado DESC";

    $page = ($page - 1) * REGISTRO_PAGINA;
    $sql .= " LIMIT ".$page.",".REGISTRO_PAGINA; 

    return $rs = $GLOBALS['db']->auto_array($sql,array(),true);
  }


  public static function filtrarOfertas($id_area,$id_provincia,$id_jornada,$id_contrato,$page,$vista=false){

    $sql = "SELECT 
        o.id_ofertas, o.fecha_creado, o.titulo, o.descripcion, o.salario, o.fecha_contratacion,o.vacantes,o.anosexp,
    a.nombre AS area, n.descripcion AS nivel, j.nombre AS jornada, p.nombre AS provincia, e.descripcion AS escolaridad, t.descripcion AS contrato, r.confidencial,r.discapacidad,r.residencia, r.edad_maxima,
    r.edad_minima, r.licencia, r.viajar, u.nombres AS empresa, u.id_usuario";

    if (!empty($vista) && $vista == 'postulacion'){ 
       $sql .= ",pos.tipo,pos.id_auto as id_postulacion, pos.resultado";
    }

    $sql .= " FROM mfo_oferta o, mfo_usuario u, mfo_requisitooferta r, mfo_escolaridad e, mfo_area a, mfo_nivelInteres n, mfo_jornada j, mfo_ciudad c, 
    mfo_tipocontrato t, mfo_provincia p";

    if(!empty($vista) && $vista == 'postulacion'){
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
    AND t.id_tipocontrato = o.id_tipocontrato";

    if (!empty($id_provincia)){ 
       $sql .= " AND p.id_provincia = ".$id_provincia;
    }
    
    if (!empty($id_area)){ 
      $sql .= " AND a.id_area = ".$id_area;
    }
    if (!empty($id_jornada)){ 
      $sql .= " AND j.id_jornada = ".$id_jornada;
    }
    if (!empty($id_contrato)){ 
      $sql .= " AND t.id_tipocontrato = ".$id_contrato;
    }

    if(!empty($vista) && $vista == 'postulacion'){
      $sql .= " AND o.id_usuario = pos.id_usuario";
    }

    $sql .= " ORDER BY o.fecha_creado DESC";

    //echo $sql; exit;
    $page = ($page - 1) * REGISTRO_PAGINA;
    $sql .= " LIMIT ".$page.",".REGISTRO_PAGINA;
    return $rs = $GLOBALS['db']->auto_array($sql,array(),true);
  }

  
}  
?>

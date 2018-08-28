<?php
class Modelo_Oferta{
  
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
  
  public static function obtieneOfertas(){
    $sql = "SELECT 
        o.id_ofertas, o.titulo, o.descripcion, o.salario, o.fecha_contratacion,o.vacantes,o.anosexp,
    a.nombre AS area, n.descripcion AS nivel, j.nombre AS jornada, p.nombre AS provincia, e.descripcion AS escolaridad, t.descripcion AS contrato, r.confidencial,r.discapacidad,r.residencia, r.edad_maxima,
    r.edad_minima, r.licencia, r.viajar, u.nombres AS empresa
    FROM mfo_oferta o, mfo_usuario u, mfo_requisitooferta r, mfo_escolaridad e, mfo_area a, mfo_nivelInteres n, mfo_jornada j, mfo_ciudad c, 
    mfo_tipocontrato t, mfo_provincia p
    WHERE o.estado = 1 
    AND r.id_requisitoOferta = o.id_requisitoOferta
    AND e.id_escolaridad = o.id_escolaridad
    AND c.id_ciudad = o.id_ciudad
    AND p.id_provincia = c.id_provincia
    AND o.id_usuario=u.id_usuario
    AND a.id_area = o.id_area
    AND n.id_nivelInteres = o.id_nivelInteres
    AND j.id_jornada = o.id_jornada
    AND t.id_tipocontrato = o.id_tipocontrato";

    return $rs = $GLOBALS['db']->auto_array($sql,array(),true);
  }

  public static function obtienePostulaciones($idUsuario){

    $sql = "SELECT tipo,id_ofertas FROM mfo_postulacion  WHERE id_usuario = ".$idUsuario;
    return $rs = $GLOBALS['db']->auto_array($sql,array(),true);
  }

  public static function filtrarOfertas($id_provincia,$id_jornada,$id_contrato,$id_area){

    $sql = "SELECT 
        o.id_ofertas, o.titulo, o.descripcion, o.salario, o.fecha_contratacion,o.vacantes,o.anosexp,
    a.nombre AS area, n.descripcion AS nivel, j.nombre AS jornada, p.nombre AS provincia, e.descripcion AS escolaridad, t.descripcion AS contrato, r.confidencial,r.discapacidad,r.residencia, r.edad_maxima,
    r.edad_minima, r.licencia, r.viajar, u.nombres AS empresa
    FROM mfo_oferta o, mfo_usuario u, mfo_requisitooferta r, mfo_escolaridad e, mfo_area a, mfo_nivelInteres n, mfo_jornada j, mfo_ciudad c, 
    mfo_tipocontrato t, mfo_provincia p
    WHERE o.estado = 1 
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

    return $rs = $GLOBALS['db']->auto_array($sql,array(),true);
  }

  
}  
?>

<?php
class Modelo_Respuesta{  

  public static function resultadoxUsuario($idusuario,$faceta=null){
    if (empty($idusuario)){ return false; }
    $sql = "SELECT o.id_pregunta, p.id_competencia, c.id_faceta,        
                   SUBSTR(GROUP_CONCAT(r.orden_seleccion ORDER BY o.valor), 1, 1) AS orden1,
                   SUBSTR(GROUP_CONCAT(r.orden_seleccion order BY o.valor), 3, 1) AS orden2,
                   SUBSTR(GROUP_CONCAT(r.orden_seleccion order BY o.valor), 5, 1) AS orden3,
                   SUBSTR(GROUP_CONCAT(r.orden_seleccion order BY o.valor), 7, 1) AS orden4,
                   SUBSTR(GROUP_CONCAT(r.orden_seleccion order BY o.valor), 9, 1) AS orden5
            FROM mfo_respuesta r 
            INNER JOIN mfo_opcion o ON o.id_opcion = r.id_opcion
            INNER JOIN mfo_pregunta p ON p.id_pregunta = o.id_pregunta
            INNER JOIN mfo_competencia c ON c.id_competencia = p.id_competencia            
            WHERE r.id_usuario = ? ";
    $sql .= (!empty($faceta)) ? " AND c.id_faceta = ".$faceta : "";        
    $sql .= " GROUP BY o.id_pregunta
              ORDER BY o.id_pregunta, c.id_faceta, o.valor";          
    return $GLOBALS['db']->auto_array($sql,array($idusuario),true);  
  }

  // se estan utilizando 03-04-2019
  public static function facetaSiguiente($idusuario){
    if (empty($idusuario)){ return false; }
    $sql = "SELECT f.orden FROM mfo_opcion o 
            INNER JOIN mfo_pregunta p ON p.id_pregunta = o.id_pregunta
            INNER JOIN mfo_competencia c ON c.id_competencia = p.id_competencia
            INNER JOIN mfo_faceta f ON f.id_faceta = c.id_faceta
            WHERE o.id_opcion = (SELECT MAX(id_opcion) FROM mfo_respuesta WHERE id_usuario = ?)";
    $result = $GLOBALS['db']->auto_array($sql,array($idusuario));          
    if (empty($result)){
      return 1;
    }
    else{
      $orden = $result['orden'] + 1;
      $sql = "SELECT id_faceta FROM mfo_faceta WHERE orden = ?";
      $result2 = $GLOBALS['db']->auto_array($sql,array($orden));
      if (empty($result2)){
        return false;
      }
      else{
        return $result2['id_faceta'];
      }
    }
  }

  public static function facetaActual($idusuario){
    if (empty($idusuario)){ return false; }
    $sql = "SELECT f.orden FROM mfo_opcion o 
            INNER JOIN mfo_pregunta p ON p.id_pregunta = o.id_pregunta
            INNER JOIN mfo_competencia c ON c.id_competencia = p.id_competencia
            INNER JOIN mfo_faceta f ON f.id_faceta = c.id_faceta
            WHERE o.id_opcion = (SELECT MAX(id_opcion) FROM mfo_respuesta WHERE id_usuario = ?)";
    $result = $GLOBALS['db']->auto_array($sql,array($idusuario));  
    return $result["orden"];
  }

  public static function obtenerRespuestas($idusuario){
    if (empty($idusuario)){ return false; }
    $sql = "SELECT * FROM mfo_respuesta WHERE id_usuario = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($idusuario), true);
    return $rs;
  }

  public static function guardarRespuestas($respuestas, $tiempo, $idusuario){
    if(empty($respuestas) || empty($tiempo) || empty($idusuario)){return false;}
    $array_session = array();
    foreach ($respuestas as $key => $value) {
      array_push($array_session,array($value['orden'], "'".$tiempo."'", $value['opcion'], $idusuario));
    }
    if (!empty($array_session)){
      $result = $GLOBALS['db']->insert_multiple("mfo_respuesta","orden_seleccion,tiempo,id_opcion,id_usuario",$array_session); 
    }
    return $result;
  }

}  
?>
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
    foreach($orden as $key=>$values){
      $datosinsert = array('orden_seleccion' => $orden[$key],
                         'tiempo' => $tiempo,
                         'id_usuario' => $idusuario,
                         'id_opcion' => $idopcion[$key]);
      $return = $GLOBALS['db']->insert('mfo_respuestam2',$datosinsert);
    }    
    return $return;
  }

  public static function verResultados($edad='', $nacionalidad='', $provincia='', $genero='', $estadocivil='', $profesion='', $ocupacion='',
                                       $escolaridad='', $provinciares='', $empresa='', $competencias=array()){    
    $sql = "SELECT u.id_usuario, u.nombres, u.apellidos, u.correo, u.id_nacionalidad, u.id_provincia, u.genero,
                   TIMESTAMPDIFF(YEAR,u.fecha_nacimiento,CURDATE()) AS edad, u.estado_civil, u.id_profesion,
                   u.id_ocupacion, u.id_escolaridad, res.id_pregunta, p.id_competencia,
                   b.porcentaje, b.id_puntaje, m.id_faceta, u.id_provincia_res, res.tot_opcion,
                   SUBSTR(res.puntaje, 1, 1) AS orden1,
                   SUBSTR(res.puntaje, 3, 1) AS orden2,
                   SUBSTR(res.puntaje, 5, 1) AS orden3,
                   SUBSTR(res.puntaje, 7, 1) AS orden4,
                   SUBSTR(res.puntaje, 9, 1) AS orden5,";
    if (!empty($competencias)){
      $sql .= "IF(";
      foreach($competencias as $competencia=>$puntaje){
        $sql .= "(p.id_competencia = ".$competencia." AND b.id_puntaje = ".$puntaje.") OR ";
      }
      $sql = substr($sql,0,-3).", 'valido', 'invalido') as flag,";
    }
    else{
      $sql .= " 'valido' AS flag,"; 
    }
    $sql = substr($sql,0,-1);

    $sql .= " FROM mfo_usuariom2 u
            INNER JOIN (SELECT r.id_usuario, o.id_pregunta, GROUP_CONCAT(r.orden_seleccion ORDER BY o.valor) AS puntaje, SUM(o.id_pregunta) AS tot_opcion 
                        FROM mfo_respuestam2 r INNER JOIN mfo_opcionm2 o ON o.id_opcion = r.id_opcion 
                        GROUP BY r.id_usuario, o.id_pregunta) AS res ON res.id_usuario = u.id_usuario
            INNER JOIN mfo_baremo b ON b.orden1 = (SUBSTR(res.puntaje, 1, 1)) AND 
                                       b.orden2 = (SUBSTR(res.puntaje, 3, 1)) AND 
                                       b.orden3 = (SUBSTR(res.puntaje, 5, 1)) AND 
                                       b.orden4 = (SUBSTR(res.puntaje, 7, 1)) AND 
                                       b.orden5 = (SUBSTR(res.puntaje, 9, 1))
            INNER JOIN mfo_preguntam2 p ON p.id_pregunta = res.id_pregunta                                    
            INNER JOIN mfo_competenciam2 m ON m.id_competencia = p.id_competencia            
            WHERE ('".$edad."' = '' OR ('".$edad."' = '1' AND TIMESTAMPDIFF(YEAR,u.fecha_nacimiento,CURDATE()) <= 20) 
                                    OR ('".$edad."' = '2' AND TIMESTAMPDIFF(YEAR,u.fecha_nacimiento,CURDATE()) > 20 AND 
                                                              TIMESTAMPDIFF(YEAR,u.fecha_nacimiento,CURDATE()) <= 30)
                                    OR ('".$edad."' = '3' AND TIMESTAMPDIFF(YEAR,u.fecha_nacimiento,CURDATE()) > 30 AND 
                                                              TIMESTAMPDIFF(YEAR,u.fecha_nacimiento,CURDATE()) <= 40)
                                    OR ('".$edad."' = '4' AND TIMESTAMPDIFF(YEAR,u.fecha_nacimiento,CURDATE()) > 40 AND 
                                                              TIMESTAMPDIFF(YEAR,u.fecha_nacimiento,CURDATE()) <= 50)
                                    OR ('".$edad."' = '5' AND TIMESTAMPDIFF(YEAR,u.fecha_nacimiento,CURDATE()) > 50)) AND
                  ('".$nacionalidad."' = '' OR u.id_nacionalidad = '".$nacionalidad."') AND 
                  ('".$provincia."' = '' OR u.id_provincia = '".$provincia."') AND                        
                  ('".$genero."' = '' OR u.genero = '".$genero."') AND      
                  ('".$estadocivil."' = '' OR u.estado_civil = '".$estadocivil."') AND
                  ('".$profesion."' = '' OR u.id_profesion = '".$profesion."') AND
                  ('".$ocupacion."' = '' OR u.id_ocupacion = '".$ocupacion."') AND      
                  ('".$escolaridad."' = '' OR u.id_escolaridad = '".$escolaridad."') AND ";
    if ($empresa == 0){
      $sql .= "(u.id_empresa IS NULL) AND ";
    } 
    else{
      if ($empresa == -1){
        $empresa = '';  
      }        
      $sql .= "('".$empresa."' = '' OR u.id_empresa = '".$empresa."') AND ";
    }                                     
    $sql .= "     ('".$provinciares."' = '' OR u.id_provincia_res = '".$provinciares."') ";    
    $sql .= "ORDER BY u.id_usuario, m.id_faceta, p.orden";
    return $GLOBALS['db']->auto_array($sql,array(),true);        
  }

  public static function resultadoxUsuario($idusuario){
    if (empty($idusuario)){ return false; }
    $sql = "SELECT o.id_pregunta, p.id_competencia, c.id_faceta,        
                   SUBSTR(GROUP_CONCAT(r.orden_seleccion ORDER BY o.valor), 1, 1) AS orden1,
                   SUBSTR(GROUP_CONCAT(r.orden_seleccion order BY o.valor), 3, 1) AS orden2,
                   SUBSTR(GROUP_CONCAT(r.orden_seleccion order BY o.valor), 5, 1) AS orden3,
                   SUBSTR(GROUP_CONCAT(r.orden_seleccion order BY o.valor), 7, 1) AS orden4,
                   SUBSTR(GROUP_CONCAT(r.orden_seleccion order BY o.valor), 9, 1) AS orden5
            FROM mfo_respuestam2 r 
            INNER JOIN mfo_opcionm2 o ON o.id_opcion = r.id_opcion
            INNER JOIN mfo_preguntam2 p ON p.id_pregunta = o.id_pregunta
            INNER JOIN mfo_competenciam2 c ON c.id_competencia = p.id_competencia            
            WHERE r.id_usuario = ?
            GROUP BY o.id_pregunta
            ORDER BY o.id_pregunta, c.id_faceta, o.valor";          
    return $GLOBALS['db']->auto_array($sql,array($idusuario),true);  
  }

}  
?>
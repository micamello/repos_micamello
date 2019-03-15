<?php
class Modelo_Pregunta{

  const DIRECTA = 1;
  const INVERSA = 2;
  
  public static function obtieneNroPreguntasxTest($test){
    if (empty($test)){ return false; }
    $sql = "SELECT COUNT(1) AS nro FROM mfo_pregunta WHERE id_cuestionario = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($test));
    return ((empty($rs["nro"])) ? 0 : $rs["nro"]);
  }

  public static function obtienePreguntaxRasgo($test,$rasgo){
    if (empty($test) || empty($rasgo)){ return false; }
    $sql = "SELECT GROUP_CONCAT(id_pre separator ',') AS preguntas FROM mfo_pregunta WHERE id_cuestionario = ? AND id_rasgo = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($test,$rasgo));
    return (empty($rs['preguntas'])) ? 0 : $rs['preguntas'];
  }

  public static function obtienePreguntaActual($usuario,$test){
    if (empty($usuario) || empty($test)){ return false; }
    $sql = "SELECT * FROM mfo_pregunta 
            WHERE orden = (SELECT COUNT(1) AS nro FROM mfo_respuesta 
                           WHERE id_usuario = ? AND id_cuestionario = ? AND estado = 1) + 1 AND 
                  id_cuestionario = ?";
    return $GLOBALS['db']->auto_array($sql,array($usuario,$test,$test));
  }

  public static function preguntasxTest($test){
    if (empty($test)){ return false; }
    $sql = "SELECT id_pre,pregunta,modo FROM mfo_pregunta WHERE id_cuestionario = ? ORDER BY RAND()";
    $result = $GLOBALS['db']->auto_array($sql,array($test),true);
    $preguntas = array();
    if (!empty($result)){
      foreach($result as $pregunta){
        $preguntas[$pregunta["id_pre"]] = array("id_pre"=>$pregunta["id_pre"],"pregunta"=>$pregunta["pregunta"],"modo"=>$pregunta["modo"]);
      }
    }
    return $preguntas;
  }

  /******MINISITIO******/
  public static function totalPreguntas(){
    $sql = "SELECT COUNT(1) AS nro FROM mfo_preguntam2";
    return $GLOBALS['db']->auto_array($sql); 
  }

  public static function totalPregXfaceta(){

    $sql = "SELECT COUNT(id_pregunta) AS cantd_preguntas
            FROM mfo_preguntam2 p
            INNER JOIN mfo_competenciam2 c on c.id_competencia = p.id_competencia            
            GROUP BY c.id_faceta LIMIT 1";
    return $GLOBALS['db']->auto_array($sql,array($sql),false);
  }
}  
?>
<?php
class Modelo_Pregunta{

  const DIRECTA = 1;
  const INVERSA = 2;
  
  public static function obtieneNroPreguntasxTest($test){
  	if (empty($test)){ return false; }
    $sql = "select count(1) as nro from mfo_pregunta where id_cuestionario = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($test));
    return ((empty($rs["nro"])) ? 0 : $rs["nro"]);
  }

  public static function obtienePreguntaActual($usuario,$test){
  	if (empty($usuario) || empty($test)){ return false; }
    $sql = "select id_pre from mfo_respuesta where id_usuario = ? and id_cuestionario = ? order by id_pre desc";
    $rs = $GLOBALS['db']->auto_array($sql,array($usuario,$test));
    return ((empty($rs["id_pre"])) ? 0 : $rs["id_pre"]);
  }
  
  public static function obtienePreguntaxTest($pregunta,$test){
    if (empty($pregunta) || empty($test)){ return false; }
    $sql = "select * from mfo_pregunta where id_pre = ? and id_cuestionario = ?";
    return $GLOBALS['db']->auto_array($sql,array($pregunta,$test));
  }

  public static function obtienePreguntaxRasgo($test,$rasgo){
    if (empty($test) || empty($rasgo)){ return false; }
    $sql = "select group_concat(id_pre separator ',') as preguntas from mfo_pregunta where id_cuestionario = ? and id_rasgo = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($test,$rasgo));
    return (empty($rs['preguntas'])) ? 0 : $rs['preguntas'];
  }

  public static function primeraPreguntaxTest($test){
    if (empty($test)){ return false; }
    $sql = "select * from mfo_pregunta where id_cuestionario = ? order by id_pre asc limit 1";
    return $GLOBALS['db']->auto_array($sql,array($test));
  }
}  
?>
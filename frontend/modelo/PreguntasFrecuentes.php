<?php
class Modelo_PreguntasFrecuentes{
  
  public static function obtieneListado($tipo){
    $sql = "SELECT * FROM mfo_preguntasfrecuentes WHERE tipo_usuario = ".$tipo;
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }

}  
?>
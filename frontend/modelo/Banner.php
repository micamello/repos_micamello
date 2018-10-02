<?php
class Modelo_Banner{
  
  const PRINCIPAL = 1;
  const PUBLICIDAD = 2;
  const BANNER_PERFIL = 3;
  const BANNER_CANDIDATO = 4;

  public static function obtieneListado($tipo){
  	if (empty($tipo)){ return false; }
    $sql = "SELECT * FROM mfo_banner WHERE estado = 1 AND tipo = $tipo order by orden ASC";
    return $GLOBALS['db']->auto_array($sql,array(),true);

  }
  
  public static function obtieneAleatorio($tipo){
  	if (empty($tipo)){ return false; }
  	$sql = "SELECT id_banner, extension FROM mfo_banner WHERE estado = 1 AND tipo = ? ORDER BY RAND() LIMIT 1";
  	return $GLOBALS['db']->auto_array($sql,array($tipo));
  }

}  
?>
<?php
class Modelo_Banner{
  
  const PRINCIPAL = 1;
  const PUBLICIDAD = 2;
  const BANNER_PERFIL = 3;
  const BANNER_CANDIDATO = 4;

  public static function obtieneListado($tipo){
    $sql = "SELECT * FROM mfo_banner WHERE estado = 1 AND tipo = $tipo order by orden ASC";
    return $GLOBALS['db']->auto_array($sql,array(),true);

  }
  
}  
?>

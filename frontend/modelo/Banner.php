<?php
class Modelo_Banner{
  
  public static function obtieneListado(){
    $sql = "SELECT id,orden,nombre,imagen,estado FROM mic_banner WHERE estado=1 and tipo=0 order by orden ASC";
    return $GLOBALS['db']->auto_array($sql,array(),MYSQL_ASSOC,true);
  }
  
}  
?>

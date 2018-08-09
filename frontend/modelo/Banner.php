<?php
class Modelo_Banner{
  
  public static function obtieneListado(){
    $sql = "SELECT * FROM mfo_banner WHERE estado=1 and tipo=0 order by orden ASC";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
  
}  
?>

<?php
class Modelo_PorcentajexFaceta{
  
  public static function obtienePermisoDescargar($idusuario){
  	if (empty($idusuario)){ return false; }
    $sql = "SELECT * FROM mfo_porcentajexfaceta p INNER JOIN mfo_faceta f ON f.id_faceta = p.id_faceta WHERE id_usuario = ? ORDER BY f.orden ASC";
    $r = $GLOBALS['db']->auto_array($sql,array($idusuario),true);

    $data = array();
    foreach ($r as $key => $value) {
      $data += $value['retribucion'];
    }
    return $data;
  }
}  
?>
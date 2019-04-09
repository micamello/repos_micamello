<?php
class Modelo_PorcentajexFaceta{
  
  public static function obtienePermisoDescargar($idusuario){
  	if (empty($idusuario)){ return false; }
    $sql = "SELECT SUM(p.estado) as resultado FROM mfo_porcentajexfaceta p INNER JOIN mfo_faceta f ON f.id_faceta = p.id_faceta WHERE p.id_usuario = ? ORDER BY f.orden ASC";
    $r = $GLOBALS['db']->auto_array($sql,array($idusuario),false);

    if(!empty($r['resultado'])){ return $r['resultado']; }else{ return false; }
  }

  public static function guardarValores($valor,$idusuario,$idfaceta,$estado=1){
    if (empty($idusuario) || empty($idfaceta)){ return false; }
    $fecha_culminacion = date("Y-m-d H:i:s");    
    $vlinsert = array("valor" => $valor,
                      "id_usuario" => $idusuario,
                      "id_faceta" => $idfaceta,
                      "fecha_culminacion" => $fecha_culminacion,
                      "estado" => $estado);
    return $GLOBALS['db']->insert("mfo_porcentajexfaceta",$vlinsert);
  }
}  
?>
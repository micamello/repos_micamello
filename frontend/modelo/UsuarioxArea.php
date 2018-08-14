<?php
class Modelo_UsuarioxArea{
  
  public static function obtieneListado($id_usuario){
    $sql = "SELECT * FROM mfo_usuarioxarea WHERE id_usuario = ".$id_usuario;
    $arrdatos = $GLOBALS['db']->auto_array($sql,array(),MYSQL_ASSOC,true);
    $datos = array();
    if (!empty($arrdatos) && is_array($arrdatos)){

    	foreach ($arrdatos as $key => $value) {
    		array_push($datos,$value['id_area']);
    	}
    }
    return $datos;
  }
  
}  
?>

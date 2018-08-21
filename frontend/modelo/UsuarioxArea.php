<?php
class Modelo_UsuarioxArea{
  
  public static function obtieneListado($id_usuario){
    $sql = "SELECT * FROM mfo_usuarioxarea WHERE id_usuario = ".$id_usuario;
    $arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);
    $datos = array();
    if (!empty($arrdatos) && is_array($arrdatos)){

    	foreach ($arrdatos as $key => $value) {
    		array_push($datos,$value['id_area']);
    	}
    }
    return $datos;
  }


    public static function updateAreas($data,$idUsuario){
    if (empty($data)|| empty($idUsuario)) {return false;}
    $inserto = false;
    foreach ($data as $key => $area) {
        $inserto = $GLOBALS['db']->insert("mfo_usuarioxarea",array("id_usuario"=>$idUsuario,"id_area"=>$area));
    }
    return $inserto;  
    }  

    public static function crearUsuarioArea($area_select, $user_id){
    if (empty($area_select)|| empty($user_id)) {return false;}

    $insert = false;
    foreach ($area_select as $key => $area) {
        $insert = $GLOBALS['db']->insert("mfo_usuarioxarea", array("id_usuario"=>$user_id, "id_area"=>$area));
    }
    return $insert;

  }
}
?>

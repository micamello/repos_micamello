<?php
class Modelo_UsuarioxNivel{
  
  public static function obtieneListado($id_usuario){
    $sql = "SELECT * FROM mfo_usuarioxnivel WHERE id_usuario = ".$id_usuario;
    $arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);
    $datos = array();
    if (!empty($arrdatos) && is_array($arrdatos)){

    	foreach ($arrdatos as $key => $value) {
    		array_push($datos,$value['id_nivelInteres']);
    	}
    }
    return $datos;
  }
  
  public static function updateNiveles($data,$idUsuario){

    $inserto = false;
    foreach ($data as $key => $nivel) {
        $inserto = $GLOBALS['db']->insert("mfo_usuarioxnivel",array("id_usuario"=>$idUsuario,"id_nivelInteres"=>$nivel));
    }
    return $inserto;
  }
}  
?>

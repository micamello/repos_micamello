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

  public static function crearUsuarioNivel($nivel_interes, $user_id){
    if (empty($nivel_interes)|| empty($user_id)) {return false;}

    $insert = false;
    foreach ($nivel_interes as $key => $nivel) {
        $insert = $GLOBALS['db']->insert("mfo_usuarioxnivel", array("id_usuario"=>$user_id, "id_nivelInteres"=>$nivel));
    }
    return $insert;
  }
  
}  
?>

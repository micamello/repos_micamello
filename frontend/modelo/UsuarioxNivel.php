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
  
  public static function updateNiveles($data_session,$data_form,$idUsuario){

    $result = true;
    $array_session = array();

    if(!empty($data_session)){

      $r = array_diff($data_session, $data_form);
      if(!empty($r)){
        $result = $GLOBALS['db']->delete("mfo_usuarioxnivel", 'id_nivelInteres IN('.implode(',', $r).') AND id_usuario = '.$idUsuario.';');
      }
      $diff_insert = array_diff($data_form, $data_session);

    }else{

      $diff_insert = $data_form;
    }

    if(!empty($diff_insert)){
      foreach ($diff_insert as $key => $id) {
        array_push($array_session,array($idUsuario,$id));
      }
      $result = $GLOBALS['db']->insert_multiple("mfo_usuarioxnivel","id_usuario,id_nivelInteres",$array_session); 
    }
    return $result;
  }
}  
?>
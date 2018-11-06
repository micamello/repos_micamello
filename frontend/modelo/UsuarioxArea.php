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

  public static function crearUsuarioArea($area_select, $user_id){
    if (empty($area_select)|| empty($user_id)) {return false;}

    $insert = false;
    foreach ($area_select as $key => $area) {
        $insert = $GLOBALS['db']->insert("mfo_usuarioxarea", array("id_usuario"=>$user_id, "id_area"=>$area));
    }
    return $insert;
  }

  public static function updateAreas($data_session,$data_form,$idUsuario){

    $result = true;
    $array_session = array();

    if(!empty($data_session)){

      $r = array_diff($data_session, $data_form);
      if(!empty($r)){
        $result = $GLOBALS['db']->delete("mfo_usuarioxarea", 'id_area IN('.implode(',', $r).') AND id_usuario = '.$idUsuario.';');
      }
      $diff_insert = array_diff($data_form, $data_session);

    }else{

      $diff_insert = $data_form;
    }
    

    if(!empty($diff_insert)){
      foreach ($diff_insert as $key => $id) {
        array_push($array_session,array($idUsuario,$id));
      }
      $result = $GLOBALS['db']->insert_multiple("mfo_usuarioxarea","id_usuario,id_area",$array_session); 
    }
    return $result;
  }
}
?>
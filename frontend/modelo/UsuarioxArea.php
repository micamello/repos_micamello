<?php
class Modelo_UsuarioxArea{
  
  public static function obtieneListado($id_usuario){
    $sql = "SELECT a.id_usuario, b.id_area, b.id_subareas 
            FROM mfo_usuarioxarea a
            INNER JOIN mfo_area_subareas b ON a.id_areas_subareas = b.id_areas_subareas
            WHERE a.id_usuario = ?
            ORDER BY b.id_area";
    $arrdatos = $GLOBALS['db']->auto_array($sql,array($id_usuario),true);
    $datos = array(); $id_area ='';
    if (!empty($arrdatos) && is_array($arrdatos)){
    	foreach ($arrdatos as $key => $value) {
        if ($id_area != $value["id_area"]){
          $id_area = $value["id_area"];
        }
        $datos[$id_area][] = $value["id_subareas"];
    		//array_push($datos,$value['id_area']);
    	}
    }    
    return $datos;
  } 

  public static function crearUsuarioArea($areasSubarea, $user_id){
    
    $array_session = array();

    if (empty($areasSubarea)|| empty($user_id)) {return false;}
    foreach ($areasSubarea[0] as $key => $value) {   
      array_push($array_session,array($user_id, $value));
    } 
      $result = $GLOBALS['db']->insert_multiple("mfo_usuarioxarea","id_usuario,id_areas_subareas",$array_session);
      return $result;
  }

  public static function consultarSubareas($user_id){
    if (empty($user_id)) {return false;}

    $sql = 'SELECT GROUP_CONCAT(id_areas_subareas) AS subareas FROM mfo_usuarioxarea WHERE id_usuario ='.$user_id;
    return $GLOBALS['db']->auto_array($sql,array(),false);
  }


  public static function updateAreas($data_session,$data_form,$areas_subareas,$idUsuario){

    $result = true;
    $array_session = array();

    if(!empty($data_session)){

      $r = array_diff($data_session, $data_form);
      if(!empty($r)){
        $result = $GLOBALS['db']->delete("mfo_usuarioxarea", 'id_areas_subareas IN('.implode(',', $r).') AND id_usuario = '.$idUsuario.';');
      }
      $diff_insert = array_diff($data_form, $data_session);

    }else{

      $diff_insert = $data_form;
    }

    if(!empty($diff_insert)){

      foreach ($diff_insert as $key => $id) {
        array_push($array_session,array((integer)$idUsuario,(integer)$id));
      }
      $result = $GLOBALS['db']->insert_multiple("mfo_usuarioxarea","id_usuario,id_areas_subareas",$array_session); 
    }
    return $result;
  }
}
?>
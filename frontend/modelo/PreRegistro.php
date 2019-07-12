<?php
class Modelo_PreRegistro{

  public static function preregistradosExcepciones(){
    $sql = "SELECT id,nombres,apellidos,correo,tipo_doc,dni,telefono,fecha,tipo_usuario,fecha_nacimiento, id_genero, id_sectorindustrial, term_cond FROM mfo_preregistro where id = '4388' limit 1";
    return $GLOBALS['db']->auto_array($sql,array(),true);        
  }

  public static function borrarPreregistro($id){
    if (empty($id)){ return false; } 
    return $GLOBALS['db']->delete('mfo_preregistro','id = '.$id);
  }

}
?>
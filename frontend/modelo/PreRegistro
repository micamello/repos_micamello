<?php
class Modelo_PreRegistro{

  public static function preregistrados(){
    $sql = "SELECT id,nombres,apellidos,correo,tipo_doc,dni,telefono,fecha,tipo_usuario 
            FROM preregistro ORDER BY fecha";
    return $GLOBALS['db']->auto_array($sql,array(),true);        
  }

  public static function borrarPreregistro($id){
    if (empty($id)){ return false; } 
    return $GLOBALS['db']->delete('preregistro','id = '.$id);
  }

}
?>
<?php
class Modelo_TemplateEmail{
  
  public static function obtieneTemplate($id){
  	if (empty($id)){ return false; }
    $sql = "SELECT * FROM mfo_templateemail where id_templateEmail = ? LIMIT 1";
    return $GLOBALS['db']->auto_array($sql,array($id));
  }
  
}  
?>
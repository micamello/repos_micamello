<?php
class Modelo_Postulacion{
  
  public static function obtienePostuladoxUsuario($id_usuario,$id_oferta){
    $sql = "SELECT * FROM micamello_base.mfo_postulacion WHERE id_usuario = $id_usuario AND id_ofertas = $id_oferta;";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }

  public static function postularse($id_usuario,$id_oferta){

  	 $result = $GLOBALS['db']->insert('mfo_postulacion',array("tipo"=>2,"fecha_postulado"=>date("Y-m-d H:i:s"),"resultado"=>3,"id_usuario"=>$id_usuario,"id_ofertas"=>$id_oferta));
    return $result;
  }
  
}  
?>

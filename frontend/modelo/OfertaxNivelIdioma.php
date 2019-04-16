<?php
class Modelo_OfertaxNivelIdioma{
  
  public static function guardarOfertaNivelIdioma($id_oferta, $data_idiomas){
  	if (empty($id_oferta) || empty($data_idiomas)) {return false;}
  	$array_session = array();

    foreach ($data_idiomas as $key => $value) {   
      array_push($array_session,array($id_oferta, $value));
    }
   	$result = $GLOBALS['db']->insert_multiple("mfo_oferta_nivelidioma","id_ofertas,id_nivelIdioma_idioma",$array_session);
    return $result;
  }
}  
?>
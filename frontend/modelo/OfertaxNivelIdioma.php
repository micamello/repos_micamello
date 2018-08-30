<?php
class Modelo_OfertaxNivelIdioma{
  
  public static function guardarOfertaNivelIdioma($id_oferta, $data_idiomas){
  	if (empty($id_oferta) || empty($data_idiomas)) {return false;}
  	$result = false;
  	foreach ($data_idiomas as $key => $idiomas) {
        $result = $GLOBALS['db']->insert("mfo_oferta_nivelidioma", array("id_ofertas"=>$id_oferta, "id_nivelIdioma_idioma"=>$idiomas));
    }
    return $result;
  }
}  
?>

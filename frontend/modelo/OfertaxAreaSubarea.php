<?php 
class Modelo_OfertaxAreaSubarea{
	public static function guardarOfertaAreasSubareas($id_oferta, $subareas){
		if(empty($id_oferta) || empty($subareas) || !is_array($subareas)){return false;}
		$array_session = array();

	    foreach ($subareas as $key => $value) {   
	      array_push($array_session,array($id_oferta, $value));
	    }
	   	$result = $GLOBALS['db']->insert_multiple("mfo_oferta_subareas","id_ofertas,id_areas_subareas",$array_session);
	   	return $result;
	}
}
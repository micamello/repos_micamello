<?php
class Modelo_NivelxIdioma{
  
  public static function obtieneListado(){
    $sql = "SELECT * FROM mfo_nivelidioma_idioma";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
  
  public static function relacionIdiomaNivel($ids){

  	$sql = "SELECT i.descripcion, ni.nombre FROM mfo_idioma i, mfo_nivelidioma ni, mfo_nivelidioma_idioma nii
			WHERE nii.id_nivelIdioma_idioma in(".$ids.") 
			AND i.id_idioma = nii.id_idioma
			AND ni.id_nivelIdioma = nii.id_nivelIdioma;";
    return $GLOBALS['db']->auto_array($sql,array(),true);

  }
}  
?>
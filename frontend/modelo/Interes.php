<?php
class Modelo_Interes{
  
  public static function obtieneListado(){
    $sql = "SELECT * from mfo_nivelinteres";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }

  public static function obtieneIntereses($intereses){
		$sql = "SELECT * FROM mfo_nivelinteres WHERE id_nivelInteres IN($intereses)";
		$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);
		return $arrdatos;
	}
  
}  
?>
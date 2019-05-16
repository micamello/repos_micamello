<?php 
class Modelo_Faceta{
  
  /*public static function obtenerLiterales(){
    echo $sql = "SELECT id_faceta,SUBSTRING(descripcion, 1, 1) as faceta FROM mfo_faceta WHERE estado = 1";  
    $arrdatos = $GLOBALS['db']->auto_array($sql,array(),true); 
    $datos = array();
     $existe = 0;
    if (!empty($arrdatos) && is_array($arrdatos)){
      foreach ($arrdatos as $key => $value) {
        $datos[$value['id_faceta']] = $value['faceta'];
      }
    }
    return $datos;         
  }*/
  public static function obtenerFacetas(){
    
    $sql = "SELECT id_faceta,descripcion as faceta FROM mfo_faceta WHERE estado = 1";  
    $arrdatos = $GLOBALS['db']->auto_array($sql,array(),true); 
    $datos = array();
    $existe = 0;
    if (!empty($arrdatos) && is_array($arrdatos)){
      foreach ($arrdatos as $key => $value) {
        $datos[$value['id_faceta']] = $value['faceta'];
      }
    }
    return $datos;         
  }
  public static function obtenerColoresLiterales(){
    $sql = "SELECT id_faceta,color FROM mfo_faceta WHERE estado = 1";  
    $arrdatos = $GLOBALS['db']->auto_array($sql,array(),true); 
    $datos = array();
  if (!empty($arrdatos) && is_array($arrdatos)){
    foreach ($arrdatos as $key => $value) {
      $datos[$value['id_faceta']] = $value['color'];
    }
  }
  return $datos;         
  }
  public static function consultaIndividual($idfaceta){
    if (empty($idfaceta)){ return false; }
    $sql = "SELECT descripcion, introduccion
            FROM mfo_faceta
            WHERE id_faceta = ? LIMIT 1";
    return $GLOBALS['db']->auto_array($sql,array($idfaceta));
  }
}  
?>
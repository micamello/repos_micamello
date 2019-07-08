<?php
class Modelo_PreRegistro{

  public static function preregistrados(){
    $sql = "SELECT id,nombres,apellidos,correo,tipo_doc,dni,telefono,fecha,tipo_usuario,fecha_nacimiento, id_genero, id_sectorindustrial, term_cond 
            FROM mfo_preregistro where id in(
3
,5
,24
,369
,446
,646
,701
,1271
,1740
,1745
,1900
,2111
,2115
,2119
,2120
,2121
,2553
,2581
,2679
,2755
,3004
,3442
,3506
,3640
,3641
,3730
,3839
,4115
,4144
,4524
,4699
,4752
,4910
,4936
,5110
,5150
,5169
,6104
,6133
,7151
,7163
,7287
,7344
,7795
,7802
,8621
,8628
,9148
,9330
,9564
,9717
,9819
,10014
,10209
,10691

) ORDER BY fecha";
    return $GLOBALS['db']->auto_array($sql,array(),true);        
  }

  public static function borrarPreregistro($id){
    if (empty($id)){ return false; } 
    return $GLOBALS['db']->delete('mfo_preregistro','id = '.$id);
  }

}
?>

<!-- ,73,74,77 -->
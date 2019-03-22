<?php
require_once '../constantes.php';
require_once '../init.php';

$escolaridad = $GLOBALS['db']->auto_array("SELECT * FROM mfo_ciudad",array(),true);
foreach($escolaridad as $esco){
  echo $esco["nombre"]."<br>";
  $descripcion = ucfirst(strtolower($esco["nombre"]));
  echo $descripcion."<br>";
  $GLOBALS['db']->update('mfo_ciudad',array("nombre"=>$descripcion),'id_ciudad='.$esco["id_ciudad"]);
}
?>
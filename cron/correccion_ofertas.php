<?php
ignore_user_abort( true );
ini_set("max_execution_time", "0");
ini_set("max_input_time", "0");
ini_set('memory_limit', "768M");
set_time_limit(0);

require_once '../constantes.php';
require_once '../init.php';

$ofertas = $GLOBALS["db"]->auto_array("SELECT id_ofertas, descripcion FROM mfo_oferta",array(),true);
foreach($ofertas as $oferta){  
  $oferta["descripcion"] = str_replace("&lt;","<",$oferta["descripcion"]);
  $oferta["descripcion"] = str_replace("&gt;",">",$oferta["descripcion"]);
  $oferta["descripcion"] = str_replace("&amp;","&",$oferta["descripcion"]);
  $oferta["descripcion"] = str_replace("&quot;","'",$oferta["descripcion"]);
  $update = $GLOBALS["db"]->update("mfo_oferta",array("descripcion"=>$oferta["descripcion"]),"id_ofertas = ".$oferta["id_ofertas"]);
  if (!$update){
    echo "Error en el registro ".$oferta["id_ofertas"]."<br>";
  }
  else{  
    echo $oferta["descripcion"]."<br><br>";
  }
}
?>
<?php
ignore_user_abort( true );
ini_set("max_execution_time", "0");
ini_set("max_input_time", "0");
ini_set('memory_limit', "768M");
set_time_limit(0);

/*Script para cancelar promociones de los planes revisando la fecha de la promocion*/

require_once '../constantes.php';
require_once '../init.php';

//pregunta si ya se esta ejecutando el cron sino crea el archivo
$resultado = file_exists(CRON_RUTA.'procesando_promocion_planes.txt');
if ($resultado){
  exit;
}
else{
  Utils::crearArchivo(CRON_RUTA,'procesando_promocion_planes.txt','');
}

$promocionales = Modelo_Plan::obtienePromocionales();
if (!empty($promocionales) && is_array($promocionales)){
  $fechaActual = date('Y-m-d H:i:s');
  foreach($promocionales as $promocion){		
	$fechacaducidad = strtotime ( '+'.$promocion["prom_duracion"].' day',strtotime($promocion["fecha_inicio"]));
	$fechacaducidad = date('Y-m-d H:i:s',$fechacaducidad);
    if ($fechacaducidad < $fechaActual){    	
      if (!Modelo_Plan::modificarPromocion($promocion["id_plan"])){
    	echo "NO PROCESADO REGISTRO ".$promocion["id_plan"]."<br>";
	    Utils::envioCorreo('desarrollo@micamello.com.ec','Error Cron Promocion Planes',"NO PROCESADO REGISTRO".$promocion["id_plan"]);
      }
      echo "Plan procesado ".$promocion["id_plan"]." / ".$promocion["fecha_inicio"]." / ".$fechacaducidad." /".$fechaActual."<br>";
    }    
  }
}

//elimina archivo de procesamiento
unlink(CRON_RUTA.'procesando_promocion_planes.txt');
?>
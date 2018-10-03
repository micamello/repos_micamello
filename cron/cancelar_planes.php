<?php
ignore_user_abort( true );
ini_set("max_execution_time", "0");
ini_set("max_input_time", "0");
ini_set('memory_limit', "768M");
set_time_limit(0);

/*Script para cancelar planes de la empresa/candidato, dependiendo del plan(es) contratados y fecha actual, si el usuario es de tipo empresa inactivar las ofertas publicadas con ese plan y si el plan tiene 5 postulaciones restantes generar un registro en la tabla de alertas*/

require_once '../constantes.php';
require_once '../init.php';

//pregunta si ya se esta ejecutando el cron sino crea el archivo
$resultado = file_exists(CRON_RUTA.'procesando_cancelar_planes.txt');
if ($resultado){
  exit;
}
else{
  Utils::crearArchivo(CRON_RUTA,'procesando_cancelar_planes.txt','');
}



//elimina archivo de procesamiento
unlink(CRON_RUTA.'procesando_cancelar_planes.txt');
?>
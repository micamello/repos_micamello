<?php
ignore_user_abort( true );
ini_set("max_execution_time", "0");
ini_set("max_input_time", "0");
ini_set('memory_limit', "768M");
set_time_limit(0);

/*Script para eliminar las ofertas de los planes inactivos de las empresas*/

require_once '../constantes.php';
require_once '../init.php';

$resultado = file_exists(CRON_RUTA.'procesando_eliminar_ofertas.txt');
if ($resultado){
  exit;
}
else{
  Utils::crearArchivo(CRON_RUTA,'procesando_eliminar_ofertas.txt','');
}

$ofertas = Modelo_Oferta::ofertasxEliminar();
print_r($ofertas);

//elimina archivo de procesamiento
unlink(CRON_RUTA.'procesando_eliminar_ofertas.txt');
?>
<?php
set_time_limit(0);

/*Script que permite las autopostulaciones del candidato dependiendo del plan contratado,
ubicación del candidato, areas de interes tomando en cuenta solo 3 dias laborables anteriores a la contratacion del plan y 
generar un registro en la tabla de alertas*/

require_once '../constantes.php';
require_once '../init.php';

//pregunta si ya se esta ejecutando el cron sino crea el archivo
$resultado = file_exists(CRON_RUTA.'procesando_autopostulaciones.txt');
if ($resultado){
  exit;
}
else{
  Utils::crearArchivo(CRON_RUTA,'procesando_autopostulaciones.txt','');
}



//elimina archivo de procesamiento
unlink(CRON_RUTA.'procesando_autopostulaciones.txt');
?>
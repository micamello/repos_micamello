<?php
ignore_user_abort( true );
ini_set("max_execution_time", "0");
ini_set("max_input_time", "0");
ini_set('memory_limit', "768M");
set_time_limit(0);

/*Script que consultara diariamente las ofertas aprobadas para envio de correos a los candidatos acorde a sus subareas seleccionadas*/

require_once '../constantes.php';
require_once '../init.php';

//pregunta si ya se esta ejecutando el cron sino crea el archivo
$resultado = file_exists(CRON_RUTA.'verificacompra_payme.txt');
if ($resultado){
  exit;
}
else{
  Utils::crearArchivo(CRON_RUTA,'verificacompra_payme.txt','');
}

$directorio = opendir(FRONTEND_RUTA.'cache/compras');     
while ($archivo = readdir($directorio)) {
  if (!is_dir($archivo)){
    preg_match_all("/([0-9]+)_([0-9]+)_([0-9]+)/i",$archivo,$matches);
    if (is_array($matches)){          
      /*if ($matches[1][0] == $idusuario){          
        return true;
      }*/          
    }        
  }      
} 

//elimina archivo de procesamiento
unlink(CRON_RUTA.'verificacompra_payme.txt');
?>
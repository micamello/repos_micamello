<?php
ignore_user_abort( true );
ini_set("max_execution_time", "0");
ini_set("max_input_time", "0");
ini_set('memory_limit', "768M");
set_time_limit(0);
/*Script que permite la generacion de planes de los usuarios que cancelaron por medio de paypal*/

require_once '../constantes.php';
require_once '../init.php';

//pregunta si ya se esta ejecutando el cron sino crea el archivo
$resultado = file_exists(CRON_RUTA.'procesando_paypal.txt');
if ($resultado){
  exit;
}
else{
  Utils::crearArchivo(CRON_RUTA,'procesando_paypal.txt','');
}

$registros = Modelo_Paypal::obtieneNoProcesados();

if (!empty($registros) && is_array($registros)){
  foreach($registros as $registro){  
    if (empty($registro)){
      Utils::envioCorreo('desarrollo@micamello.com.ec','Cron planes_paypal.php','Registro no tiene valores '.print_r($registro,true));
      continue;
    }

    $cliente = obtenerDatosCliente($registro["custom"]); 
    if (empty($cliente)){ 
    	Utils::envioCorreo('desarrollo@micamello.com.ec','Cron planes_paypal.php','Campo custom no tiene valores '.print_r($registro,true));
      continue;
    }    
    if (empty($registro["txn_id"]) || empty($registro["payment_gross"]) || empty($registro["id_paypal"])){
      Utils::envioCorreo('desarrollo@micamello.com.ec','Cron planes_paypal.php','Valores nulos '.print_r($registro,true));
      continue;
    }
     
    $procesador = (object) array('id'=>$registro["id_paypal"],
                                 'tipo'=>'paypal',
                                 'trans'=>$registro["txn_id"],
                                 'monto'=>$registro["payment_gross"]);

    switch($registro["payment_status"]){
      //si realizo el pago
      case "Completed":
         $objSubscripcion = new Proceso_Subscripcion($cliente,$cliente->plan,$procesador);
         $objSubscripcion->procesar();        
      break;
      //si cancelo el pago
      case "Reversed":
         $objCancelacion = new Proceso_Cancelacion($cliente,$cliente->plan,$procesador);
         $objCancelacion->procesar();
      break;
    }    
  }
}

//elimina archivo de procesamiento
unlink(CRON_RUTA.'procesando_paypal.txt');

function obtenerDatosCliente($custom){
  if (empty($custom)){ return false; }
  $datos = explode('|',$custom);
  if (!is_array($datos)){ return false; }  
  if (count($datos)<6){ return false; }
  $usuario = array('plan'=>$datos[0],
                   'id'=>$datos[1], 
                   'nombres'=>$datos[2],  
                   'correo'=>$datos[3], 
                   'ciudad'=>$datos[4], 
                   'telefono'=>$datos[5], 
                   'dni'=>$datos[6], 
                   'direccion'=>$datos[7]);
  $obj = (object) $usuario;  
  return $obj;
}
?>
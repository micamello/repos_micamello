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
      $datos_correo = array('tipo'=>11, 'correo'=>'desarrollo@micamello.com.ec', 'mensaje'=>'Registro no tiene valores '.print_r($registro,true), 'type'=>TIPO['cron_paypal_planes']);
      Utils::enviarEmail($datos_correo);
      // Utils::envioCorreo('desarrollo@micamello.com.ec','Cron planes_paypal.php','Registro no tiene valores '.print_r($registro,true));
      continue;
    }

    $cliente = obtenerDatosCliente($registro["custom"]); 
    if (empty($cliente)){ 
      $datos_correo = array('tipo'=>11, 'correo'=>'desarrollo@micamello.com.ec', 'mensaje'=>'Campo custom no tiene valores '.print_r($registro,true), 'type'=>TIPO['cron_paypal_planes']);
      Utils::enviarEmail($datos_correo);
    	// Utils::envioCorreo('desarrollo@micamello.com.ec','Cron planes_paypal.php','Campo custom no tiene valores '.print_r($registro,true));
      continue;
    }    
    if (empty($registro["txn_id"]) || empty($registro["payment_gross"]) || empty($registro["id_paypal"])){
      $datos_correo = array('tipo'=>11, 'correo'=>'desarrollo@micamello.com.ec', 'mensaje'=>'Valores nulos '.print_r($registro,true), 'type'=>TIPO['cron_paypal_planes']);
      Utils::enviarEmail($datos_correo);
      // Utils::envioCorreo('desarrollo@micamello.com.ec','Cron planes_paypal.php','Valores nulos '.print_r($registro,true));
      continue;
    }
     
    switch($registro["payment_status"]){
      //si realizo el pago
      case "Completed":
         $procesador = (object) array('id'=>$registro["id_paypal"],
                                      'tipo'=>'paypal',
                                      'trans'=>$registro["txn_id"],
                                      'monto'=>$registro["payment_gross"]);
         $objSubscripcion = new Proceso_Subscripcion($cliente,$cliente->plan,$procesador);
         $objSubscripcion->procesar();        
      break;
      //si cancelo el pago
      case "Reversed":
         $procesador = (object) array('id'=>$registro["id_paypal"],
                                      'tipo'=>'paypal',
                                      'trans'=>$registro["parent_txn_id"],
                                      'monto'=>$registro["payment_gross"]);
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
                   'tipo'=>$datos[2],
                   'nombres'=>$datos[3],  
                   'correo'=>$datos[4], 
                   'tipodoc'=>$datos[5], 
                   'telefono'=>$datos[6], 
                   'dni'=>$datos[7], 
                   'direccion'=>$datos[8]);
  $obj = (object) $usuario;  
  return $obj;
}
?>
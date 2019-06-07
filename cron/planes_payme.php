<?php
ignore_user_abort( true );
ini_set("max_execution_time", "0");
ini_set("max_input_time", "0");
ini_set('memory_limit', "768M");
set_time_limit(0);
/*Script que permite la generacion de planes de los usuarios que cancelaron por medio de payme*/

require_once '../constantes.php';
require_once '../init.php';

//pregunta si ya se esta ejecutando el cron sino crea el archivo
$resultado = file_exists(CRON_RUTA.'procesando_payme.txt');
if ($resultado){
  exit;
}
else{
  Utils::crearArchivo(CRON_RUTA,'procesando_payme.txt','');
}

$registros = Modelo_Payme::obtieneNoProcesados();

if (!empty($registros) && is_array($registros)){  

  foreach($registros as $registro){  
    if (empty($registro)){      
      //Utils::envioCorreo('desarrollo@micamello.com.ec','Cron planes_payme','Registro no tiene valores '.print_r($registro,true));
      continue;
    }

    if (empty($registro["reserved15"]) || empty($registro["reserved16"]) ||         
        empty($registro["reserved17"]) || empty($registro["shippingFirstName"]) ||         
        empty($registro["shippingEmail"]) || empty($registro["reserved18"]) ||        
        empty($registro["shippingPhone"]) || empty($registro["reserved19"]) ||         
        empty($registro["shippingAddress"]) || empty($registro["shippingLastName"]) || 
        empty($registro["shippingCity"]) || empty($registro["shippingState"]) ||
        empty($registro["shippingZIP"])){       
    	//Utils::envioCorreo('desarrollo@micamello.com.ec','Cron planes_payme','Usuario no tiene valores '.print_r($registro,true));
      continue;
    }    
    if (empty($registro["IDTransaction"]) || empty($registro["purchaseOperationNumber"]) || empty($registro["purchaseAmount"])){
      //Utils::envioCorreo('desarrollo@micamello.com.ec','Cron planes_payme','Valores nulos '.print_r($registro,true));
      continue;
    }
        
    $id_payme = Modelo_Payme::consultaByTransaction($registro["IDTransaction"]);     
    if (!empty($id_payme)){
      if (!Modelo_Payme::modificarEstado($registro["id_payme"])){
        //Utils::envioCorreo('desarrollo@micamello.com.ec','Cron planes_payme','TransactionID duplicada sin poder actualizar el estado '.print_r($registro,true));
        continue;
      } 
    }

    //objeto de usuario     
    $cliente = (object) array('plan'=>$registro["reserved15"],
                              'id'=>$registro["reserved16"], 
                              'tipo'=>$registro["reserved17"],
                              'nombres'=>Utils::no_carac($registro["shippingFirstName"]). " " .Utils::no_carac($registro["shippingLastName"]),  
                              'correo'=>$registro["shippingEmail"], 
                              'tipodoc'=>$registro["reserved18"], 
                              'telefono'=>$registro["shippingPhone"], 
                              'dni'=>$registro["reserved19"], 
                              'direccion'=>Utils::no_carac($registro["shippingAddress"]),
                              'provincia'=>Utils::no_carac($registro["shippingState"]),
                              'ciudad'=>Utils::no_carac($registro["shippingCity"]),
                              'codpostal'=>Utils::no_carac($registro["shippingZIP"])  
                            );
                       
    //objeto procesador      
    $monto = substr($registro["purchaseAmount"],0,-2).".".substr($registro["purchaseAmount"], -2);     
    $tipopago = ($registro["reversed22"] == "DEBIT") ? Proceso_Facturacion::FORMA_PAGO["TARJETADEBITO"] : Proceso_Facturacion::FORMA_PAGO["TARJETACREDITO"];   
    $procesador = (object) array('id'=>$registro["id_payme"],
                                 'tipo'=>'payme',
                                 'trans'=>$registro["purchaseOperationNumber"],
                                 'monto'=>$monto,
                                 'tipopago'=>$tipopago);    
    $objSubscripcion = new Proceso_Subscripcion($cliente,$cliente->plan,$procesador);
    $objSubscripcion->procesar();                  
  }
}

//elimina archivo de procesamiento
unlink(CRON_RUTA.'procesando_payme.txt');
?>
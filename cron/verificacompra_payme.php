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
    preg_match_all("/([0-9]+)_([0-9]+)/i",$archivo,$matches);
    if (!empty($matches) && is_array($matches)){                  
      $rs = Modelo_Payme::consultaByOperationNumber($matches[2][0],$matches[1][0]);
      if (empty($rs)){
        $response = '';                
        $purchaseVerification = openssl_digest(PAYME_ACQUIRERID . PAYME_IDCOMMERCE . $matches[2][0] . PAYME_SECRET_KEY, 'sha512');
        
        $url = PAYME_RUTA.'VPOS2/rest/operationAcquirer/consulte';
                    
        $dataRest = '{"idAcquirer":"'.PAYME_ACQUIRERID.'","idCommerce":"'.PAYME_IDCOMMERCE.'","operationNumber":"'.$matches[2][0].'","purchaseVerification":"'.$purchaseVerification.'"}';
                
        $header = array('Content-Type: application/json');
            
        //Consumo del servicio Rest
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POSTFIELDS, $dataRest);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);            
        $arr_response = json_decode($response);         
        if (trim($arr_response->errorCode) == "00" && trim($arr_response->result) == "3"){
          $vl_insert = array();
          $vl_insert["fecha"] = date("Y-m-d H:i:s");
          $vl_insert["authorizationResult"] = "00";
          $vl_insert["authorizationCode"] = trim($arr_response->authorizationCode);
          $vl_insert["errorCode"] = trim($arr_response->errorCode);
          $vl_insert["errorMessage"] = trim($arr_response->errorMessage);
          $vl_insert["bin"] = "";
          $vl_insert["brand"] = "";
          $vl_insert["paymentReferenceCode"] = "";
          $vl_insert["purchaseVerification"] = $purchaseVerification;
          $vl_insert["reserved22"] = "";
          $vl_insert["reserved23"] = "";
          $vl_insert["shippingCountry"] = trim($arr_response->shippingCountry);
          $vl_insert["reserved2"] = trim($arr_response->reserved2);
          $vl_insert["reserved3"] = trim($arr_response->reserved3);
          $vl_insert["shippingLastName"] = trim($arr_response->shippingLastName);
          $vl_insert["txDateTime"] = "";
          $vl_insert["shippingFirstName"] = trim($arr_response->shippingFirstName);
          $vl_insert["reserved15"] = trim($arr_response->reserved15);
          $vl_insert["reserved16"] = trim($arr_response->reserved16);
          $vl_insert["reserved17"] = trim($arr_response->reserved17);
          $vl_insert["reserved18"] = trim($arr_response->reserved18);
          $vl_insert["reserved19"] = trim($arr_response->reserved19);
          $vl_insert["purchaseOperationNumber"] = $matches[2][0];
          $vl_insert["shippingPhone"] = trim($arr_response->shippingPhone);
          $vl_insert["shippingAddress"] = trim($arr_response->shippingAddress);
          $vl_insert["descriptionProducts"] = "";
          $vl_insert["shippingEmail"] = trim($arr_response->shippingEmail);
          $vl_insert["shippingZIP"] = trim($arr_response->shippingZIP);
          $vl_insert["purchaseAmount"] = trim($arr_response->purchaseAmount);
          //$vl_insert["IDTransaction"] = "";
          $vl_insert["shippingState"] = trim($arr_response->shippingState); 
          $vl_insert["shippingCity"] = trim($arr_response->shippingCity);            
          if (!Modelo_Payme::guardar($vl_insert)){
            Utils::envioCorreo('desarrollo@micamello.com.ec','Error en cron de verificacompra_payme',print_r($arr_response,true));
          }    
        }              
      }              
      unlink(FRONTEND_RUTA.'cache/compras/'.$archivo);
    }        
  }      
} 

//elimina archivo de procesamiento
unlink(CRON_RUTA.'verificacompra_payme.txt');
?>
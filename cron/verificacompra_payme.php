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
    if (!empty($matches) && is_array($matches)){             
      $rs = Modelo_Payme::consultaByOperationNumber($matches[3][0],$matches[1][0]);
      if (empty($rs)){
        $purchaseVerification = openssl_digest(PAYME_ACQUIRERID . 
                                               PAYME_IDCOMMERCE . 
                                               $matches[3][0] . 
                                               $matches[2][0] . 
                                               PAYME_CURRENCY_CODE . 
                                               PAYME_SECRET_KEY, 'sha512');
        
        $url = PAYME_RUTA.'VPOS2/rest/operationAcquirer/consulte';
                    
        $dataRest = '{"idAcquirer":"'.PAYME_ACQUIRERID.'","idCommerce":"'.PAYME_IDCOMMERCE.'","operationNumber":"'.$matches[3][0].'","purchaseVerification":"'.$purchaseVerification.'"}';
                
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
        print_r($response);
        echo "<br>";echo "<br>";
      }              

      //unlink(FRONTEND_RUTA.'cache/compras/'.$archivo);
    }        
  }      
} 

//elimina archivo de procesamiento
unlink(CRON_RUTA.'verificacompra_payme.txt');
?>
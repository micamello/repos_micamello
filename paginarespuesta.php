<?php
require_once 'constantes.php';
require_once 'init.php';

//purchaseVerication que devuelve la Pasarela de Pagos
$purchaseVericationVPOS2 = trim($_POST['purchaseVerification']);
//purchaseVerication que genera el comercio
$purchaseVericationComercio = openssl_digest(PAYME_ACQUIRERID . 
                                             PAYME_IDCOMMERCE . 
                                             trim($_POST['purchaseOperationNumber']) . 
                                             trim($_POST['purchaseAmount']) . 
                                             PAYME_CURRENCY_CODE . 
                                             trim($_POST['authorizationResult']) . 
                                             PAYME_SECRET_KEY, 'sha512');
 Utils::envioCorreo('desarrollo@micamello.com.ec','PASO_OPAYME',print_r($_POST,true));
try{
  if ($purchaseVericationVPOS2 == $purchaseVericationComercio || $purchaseVericationVPOS2 == "") {
    $vl_insert = array();
    $vl_insert["fecha"] = date("Y-m-d H:i:s");
    $vl_insert["authorizationResult"] = trim($_POST["authorizationResult"]);
    $vl_insert["authorizationCode"] = trim($_POST["authorizationCode"]);
    $vl_insert["errorCode"] = trim($_POST["errorCode"]);
    $vl_insert["errorMessage"] = trim($_POST["errorMessage"]);
    $vl_insert["bin"] = trim($_POST["bin"]);
    $vl_insert["brand"] = trim($_POST["brand"]);
    $vl_insert["paymentReferenceCode"] = trim($_POST["paymentReferenceCode"]);
    $vl_insert["purchaseVerification"] = trim($_POST["purchaseVerification"]);
    $vl_insert["reserved22"] = trim($_POST["reserved22"]);
    $vl_insert["reserved23"] = trim($_POST["reserved23"]);
    $vl_insert["shippingCountry"] = trim($_POST["shippingCountry"]);
    $vl_insert["reserved2"] = trim($_POST["reserved2"]);
    $vl_insert["reserved3"] = trim($_POST["reserved3"]);
    $vl_insert["shippingLastName"] = trim($_POST["shippingLastName"]);
    $vl_insert["txDateTime"] = trim($_POST["txDateTime"]);
    $vl_insert["shippingFirstName"] = trim($_POST["shippingFirstName"]);
    $vl_insert["reserved15"] = trim($_POST["reserved15"]);
    $vl_insert["reserved16"] = trim($_POST["reserved16"]);
    $vl_insert["reserved17"] = trim($_POST["reserved17"]);
    $vl_insert["reserved18"] = trim($_POST["reserved18"]);
    $vl_insert["reserved19"] = trim($_POST["reserved19"]);
    $vl_insert["purchaseOperationNumber"] = trim($_POST["purchaseOperationNumber"]);
    $vl_insert["shippingPhone"] = trim($_POST["shippingPhone"]);
    $vl_insert["shippingAddress"] = trim($_POST["shippingAddress"]);
    $vl_insert["descriptionProducts"] = trim($_POST["descriptionProducts"]);
    $vl_insert["shippingEmail"] = trim($_POST["shippingEmail"]);
    $vl_insert["shippingZIP"] = trim($_POST["shippingZIP"]);
    $vl_insert["purchaseAmount"] = trim($_POST["purchaseAmount"]);
    $vl_insert["IDTransaction"] = trim($_POST["IDTransaction"]);
    $vl_insert["shippingState"] = trim($_POST["shippingState"]); 
    $vl_insert["shippingCity"] = trim($_POST["shippingCity"]); 

    if (!Modelo_Payme::guardar($vl_insert)){
      throw new Exception("Error Insert IPN Payme");
    }    
    if (trim($_POST["authorizationResult"]) == "00" && trim($_POST["errorCode"]) == "00"){
      Utils::envioCorreo('desarrollo@micamello.com.ec','CRON_PAYME',print_r($_POST,true));
      Utils::doRedirect(PUERTO.'://'.HOST.'/desarrollov3/compraplan/exito/');
    }
    elseif(trim($_POST["authorizationResult"]) == "05" && trim($_POST["errorCode"]) == "2300"){
      Utils::doRedirect(PUERTO.'://'.HOST.'/desarrollov3/planes/'); 
    }
    else{
      Utils::doRedirect(PUERTO.'://'.HOST.'/desarrollov3/compraplan/error/');
    } 
  }  
}
catch(Exception $e){    
  Utils::envioCorreo('desarrollo@micamello.com.ec',$e->getMessage(),print_r($_POST,true));
  Utils::doRedirect(PUERTO.'://'.HOST.'/desarrollov3/compraplan/error/');
}
unset($_POST);
header("HTTP/1.1 200 OK");    
?>
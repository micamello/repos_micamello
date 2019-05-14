<?php
require_once 'constantes.php';
require_once 'init.php';

//purchaseVerication que devuelve la Pasarela de Pagos
$purchaseVericationVPOS2 = $_POST['purchaseVerification'];
//purchaseVerication que genera el comercio
$purchaseVericationComercio = openssl_digest(PAYME_ACQUIRERID . 
                                             PAYME_IDCOMMERCE . 
                                             $_POST['purchaseOperationNumber'] . 
                                             $_POST['purchaseAmount'] . 
                                             PAYME_CURRENCY_CODE . 
                                             $_POST['authorizationResult'] . 
                                             PAYME_SECRET_KEY, 'sha512');

try{
  if ($purchaseVericationVPOS2 == $purchaseVericationComercio || $purchaseVericationVPOS2 == "") {
    $vl_insert = array();
    $vl_insert["fecha"] = date("Y-m-d H:i:s");
    $vl_insert["authorizationResult"] = $_POST["authorizationResult"];
    $vl_insert["authorizationCode"] = $_POST["authorizationCode"];
    $vl_insert["errorCode"] = $_POST["errorCode"];
    $vl_insert["errorMessage"] = $_POST["errorMessage"];
    $vl_insert["bin"] = $_POST["bin"];
    $vl_insert["brand"] = $_POST["brand"];
    $vl_insert["paymentReferenceCode"] = $_POST["paymentReferenceCode"];
    $vl_insert["purchaseVerification"] = $_POST["purchaseVerification"];
    $vl_insert["reserved22"] = $_POST["reserved22"];
    $vl_insert["reserved23"] = $_POST["reserved23"];
    $vl_insert["shippingCountry"] = $_POST["shippingCountry"];
    $vl_insert["reserved2"] = $_POST["reserved2"];
    $vl_insert["reserved3"] = $_POST["reserved3"];
    $vl_insert["shippingLastName"] = $_POST["shippingLastName"];
    $vl_insert["txDateTime"] = $_POST["txDateTime"];
    $vl_insert["shippingFirstName"] = $_POST["shippingFirstName"];
    $vl_insert["reserved15"] = $_POST["reserved15"];
    $vl_insert["reserved16"] = $_POST["reserved16"];
    $vl_insert["reserved17"] = $_POST["reserved17"];
    $vl_insert["reserved18"] = $_POST["reserved18"];
    $vl_insert["reserved19"] = $_POST["reserved19"];
    $vl_insert["purchaseOperationNumber"] = $_POST["purchaseOperationNumber"];
    $vl_insert["shippingPhone"] = $_POST["shippingPhone"];
    $vl_insert["shippingAddress"] = $_POST["shippingAddress"];
    $vl_insert["descriptionProducts"] = $_POST["descriptionProducts"];
    $vl_insert["shippingEmail"] = $_POST["shippingEmail"];
    $vl_insert["shippingZIP"] = $_POST["shippingZIP"];
    $vl_insert["purchaseAmount"] = $_POST["purchaseAmount"];
    $vl_insert["IDTransaction"] = $_POST["IDTransaction"];    
    if (!Modelo_Payme::guardar($vl_insert)){
      throw new Exception("Error Insert IPN Payme");
    }
    if ($_POST["authorizationResult"] = "00"){
      Utils::envioCorreo('desarrollo@micamello.com.ec','CRON_PAYME',print_r($_POST,true));
      Utils::doRedirect(PUERTO.'://'.HOST.'/desarrollov3/compraplan/exito/');
    } 
  }
  Utils::doRedirect(PUERTO.'://'.HOST.'/desarrollov3/compraplan/error/');
}
catch(Exception $e){    
  Utils::envioCorreo('desarrollo@micamello.com.ec',$e->getMessage(),print_r($_POST,true));
  Utils::doRedirect(PUERTO.'://'.HOST.'/desarrollov3/compraplan/error/');
}
header("HTTP/1.1 200 OK");    
?>
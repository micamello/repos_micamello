<?php
require_once 'constantes.php';
require_once 'init.php';

//Misma clave que se usa para el envio a VPOS2
//$claveSecreta = 'mjNkPqNvrjUxZAH.97676492';

//purchaseVerication que devuelve la Pasarela de Pagos
$purchaseVericationVPOS2 = $_POST['purchaseVerification'];
//echo $purchaseVericationVPOS2 . "\n";
//purchaseVerication que genera el comercio
$purchaseVericationComercio = openssl_digest(PAYME_ACQUIRERID . 
                                             PAYME_IDCOMMERCE . 
                                             $_POST['purchaseOperationNumber'] . 
                                             $_POST['purchaseAmount'] . 
                                             PAYME_CURRENCY_CODE . 
                                             $_POST['authorizationResult'] . 
                                             PAYME_SECRET_KEY, 'sha512');
//echo $purchaseVericationComercio;
try{
  if ($purchaseVericationVPOS2 == $purchaseVericationComercio || $purchaseVericationVPOS2 == "") {
    $vl_insert = array();
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
    Utils::envioCorreo("desarrollo@micamello.com.ec","CRON PAYME",print_r($_POST,true));    
    //if (!Modelo_Paypal::guardar($vl_insert)){
    //  throw new Exception("Error Insert IPN Paypal");
    //} 
  }
}
catch(Exception $e){    
  Utils::envioCorreo('desarrollo@micamello.com.ec',$e->getMessage(),print_r($_POST,true));
}
header("HTTP/1.1 200 OK");    

print_r($_POST);

//Si ambos datos son iguales
if ($purchaseVericationVPOS2 == $purchaseVericationComercio || $purchaseVericationVPOS2 == "") {
?>    	
  <table>
    <tr><td>AuthorizationResult</td><td><?php echo $_POST['authorizationResult'];?></td></tr>
    <tr><td>AuthorizationCode</td><td><?php echo $_POST['authorizationCode'];?></td></tr>
    <tr><td>ErrorCode</td><td><?php echo $_POST['errorCode'];?></td></tr>
    <tr><td>ErroMessage</td><td><?php echo $_POST['errorMessage'];?></td></tr>
    <tr><td>Bin</td><td><?php echo $_POST['bin'];?></td></tr>
    <tr><td>Brand</td><td><?php echo $_POST['brand'];?></td></tr>
    <tr><td>PaymentReferenceCode</td><td><?php echo $_POST['paymentReferenceCode'];?></td></tr>
    <!--Ejemplo recepción de campos reservados en parametro reserved1-->
    <tr><td>Reserved1</td><td><?php echo $_POST['reserved1'];?></td></tr>
    <tr><td>Reserved22</td><td><?php echo $_POST['reserved22'];?></td></tr>
    <tr><td>Reserved23</td><td><?php echo $_POST['reserved23'];?></td></tr>
    <tr><td>Número de Operacion</td><td><?php echo $_POST['purchaseOperationNumber'];?></td></tr>
    <tr><td>Monto</td><td><?php echo "S/. " . $_POST['purchaseAmount'];?></td></tr>
</table>
    
<?php
    //Si ambos datos son diferentes
} else {
    echo "<h1>Transacción Invalida. Los datos fueron alterados en el proceso de respuesta.</h1>";
}   
?> 
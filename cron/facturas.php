<?php

require_once '../constantes.php';
require_once '../init.php';
/*
$obj_facturacion = new Proceso_Facturacion();
$obj_facturacion->razonSocialComprador = 'Fernanda Fueltala';
$obj_facturacion->identificacionComprador = '0919580985';
$obj_facturacion->direccionComprador = 'Duran Cdla Abel Gilbert Mz B48 V1';
$obj_facturacion->tipoIdentifComprador = TIPO_DOCUMENTO[2];
$obj_facturacion->importeTotal = 23;
$obj_facturacion->codigoPrincipal = '2';
$obj_facturacion->descripdetalle = 'Camellito Simple';
*/
//$xml = $obj_facturacion->generarFactura();
//echo FRONTEND_RUTA."cron/widman_ivan_hidrovo_benalcazar.p12";
//$obj_facturacion->sign(FRONTEND_RUTA."cron/widman_ivan_hidrovo_benalcazar.p12", null, "Amor2018"); 
//$xml_final = $obj_facturacion->injectSignature($xml);
//print_r($xml_final);
/*$wsdl = 'https://celcer.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl'; 
//Basados en la estructura del servicio armamos un array
//$xml_final = file_get_contents('1101201901099306446700110010010000000021234567810.xml');
$params = Array('xml' => '');
$options = Array(
    "uri"=> $wsdl,
    "encoding" => "UTF-8",
);

$soap = new SoapClient($wsdl, $options);
$result = $soap->validarComprobante($params); 
print_r($result);

$wsdl = 'https://celcer.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl'; 
$options = Array(
    "uri"=> $wsdl,
    "encoding" => "UTF-8",
);
$soap = new SoapClient($wsdl, $options);
$params = Array("claveAccesoComprobante" => '1401201901099306446700110010010000000241234567817');
$result = $soap->autorizacionComprobante($params); 
print_r($result);

*/
?>
<!doctype html>
<head>
</head>
<!--<script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>
  <script src="./moment.js"></script> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/x2js/1.2.0/xml2json.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/node-forge@0.7.0/dist/forge.min.js"></script>
<script src="./xades_fact_sri.js"></script>  -->
<body>

  <?php 
  //openssl_pkcs12_read(file_get_contents("widman_ivan_hidrovo_benalcazar.p12"), $certs, "Amor2018");
 print_r(openssl_x509_read("widman_ivan_hidrovo_benalcazar.p12"));
 exit;
 // openssl_pkey_export($certs, $privkey, "PassPhrase number 1" );
 print_r($privkey);
// Get public key
$pubkey=openssl_pkey_get_details($certs);
$pubkey=$pubkey["key"];
//var_dump($privkey);
//var_dump($pubkey);

// Create the keypair
$res2=openssl_pkey_new();

// Get private key
openssl_pkey_export($res2, $privkey2, "This is a passPhrase *µà" );

// Get public key
$pubkey2=openssl_pkey_get_details($res2);
$pubkey2=$pubkey2["key"];
var_dump($privkey2);
var_dump($pubkey2);

$data = "Only I know the purple fox. Trala la !";

openssl_seal($data, $sealed, $ekeys, array($pubkey, $pubkey2));

var_dump("sealed");
var_dump(base64_encode($sealed));
var_dump(base64_encode($ekeys[0]));
var_dump(base64_encode($ekeys[1]));

// decrypt the data and store it in $open
if (openssl_open($sealed, $open, $ekeys[1], openssl_pkey_get_private  ($privkey2  ,"This is a passPhrase *µà" ) ) ) {
    echo "here is the opened data: ", $open;
} else {
    echo "failed to open data";
}

?>

  <?php
/*
  $certificado_p12 = file_get_contents("widman_ivan_hidrovo_benalcazar.p12");
if (openssl_pkcs12_read($certificado_p12, $pkcs12, "Amor2018")) {
$certificado = $pkcs12["extracerts"][0];
$certificado = str_replace('-----BEGIN CERTIFICATE-----', '', $certificado);
$certificado = str_replace('-----END CERTIFICATE-----', '', $certificado);
$certificado = str_replace('\n', '', $certificado);
$certificado = str_split($certificado, 76);
$certificado = implode('\n', $certificado);
$certificado_b64 = str_replace('\n', '', $certificado);
$hash_certificado_der = base64_encode(hash('sha1', base64_decode($certificado_b64), true));
//echo $hash_certificado_der;

}
*/
if (!$almacen_cert = file_get_contents("widman_ivan_hidrovo_benalcazar.p12")) {
    echo "Error: No se puede leer el fichero del certificado\n";
    exit;
}
$publicKey = '';
$privateKey = ''; 
if (openssl_pkcs12_read(file_get_contents("widman_ivan_hidrovo_benalcazar.p12"), $certs, "Amor2018")) {
  $publicKey = openssl_x509_read($certs["cert"]);
  $privateKey = openssl_pkey_get_private($certs['pkey']);
}

//print_r($publicKey);
//print_r($privateKey);

$certData = openssl_x509_parse($publicKey);
//print_r($certs);

$privateData = openssl_pkey_get_details($privateKey);
//echo '<br>';
//print_r($privateData);
$modulus = chunk_split(base64_encode($privateData['rsa']['n']), 76);
$modulus = str_replace("\r", "", $modulus);
$exponent = base64_encode($privateData['rsa']['e']);
//echo '<br>';
//print_r($modulus);
/*if (openssl_pkcs12_read($almacen_cert, $info_cert, "Amor2018")) {
    echo "Información del certificado\n";
    
 

   

    $modulus = chunk_split(base64_encode($privateData['rsa']['n']), 76);
    $modulus = str_replace("\r", "", $modulus);
    $exponent = base64_encode($privateData['rsa']['e']);
    print_r($modulus);

} else {
    echo "Error: No se puede leer el almacén de certificados.\n";
    exit;
}*/




  //echo "<br><textarea id='xml' cols=100 rows=30>".$xml_final."</textarea>"; 
   //echo "<br><textarea cols=100 rows=30>".$xml_prueba."</textarea>"; 
   //echo "<br><textarea cols=100 rows=30>".$byte_array."</textarea>"; 
  ?>


</body>
</html>
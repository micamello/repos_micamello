<?php 
$pkcs12 = file_get_contents('C:/wamp64/www/repos_micamello/includes/facturae/widman_ivan_hidrovo_benalcazar.p12');

if (openssl_pkcs12_read($pkcs12, $certs, 'Amor2018')) {

    print_r($certs);
    //echo $certs['pkey'];

    $privateKey = $certs['pkey']; 
    $publicKey = $certs['cert'];
    $signedMsg = "";

    $strData = '<infoTributaria>
    <ambiente>1</ambiente>
    <tipoEmision>1</tipoEmision>
    <razonSocial>MICAMELLO S.A.</razonSocial>
    <nombreComercial>MICAMELLO S.A.</nombreComercial>
    <ruc>0993064467001</ruc>
    <claveAcceso>1101201901099306446700110010010000000020000000217</claveAcceso>
    <codDoc>01</codDoc>
    <estab>001</estab>
    <ptoEmi>001</ptoEmi>
    <secuencial>000000002</secuencial>
    <dirMatriz>Km 12 Av. Febres Cordero Cdla. Villa Club Etapa Krypton Mz.14 Solar 3</dirMatriz>
  </infoTributaria>'; 

    if (openssl_sign($strData, $signedMsg, $privateKey)) {       
       $signedMsg=base64_encode($signedMsg); //can use base64_encode also
       //echo $signedMsg;
    } else {
        return '';
    }
} else {
    return '0';
}
?>
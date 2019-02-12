<?php
require_once '../constantes.php';
//require_once '../init.php';
require_once '../frontend/Proceso/Facturacion.php';

$obj_facturacion = new Proceso_Facturacion();
$obj_facturacion->razonSocialComprador = 'Fernanda Fueltala Narvaez';
$obj_facturacion->identificacionComprador = '0919580985';
$obj_facturacion->direccionComprador = 'Duran cdla abel gilbert mz b48 v1';
$obj_facturacion->emailComprador = 'fermaggy@hotmail.com';
$obj_facturacion->telefComprador = '0997969113';
$obj_facturacion->tipoIdentifComprador = TIPO_DOCUMENTO[2];
$obj_facturacion->importeTotal = 23;
$obj_facturacion->codigoPrincipal = '2';
$obj_facturacion->descripdetalle = 'Camellito Efectivo';

$xml = $obj_facturacion->generarFactura();
//$obj_facturacion->sign(RUTA_INCLUDES."facturae/widman_ivan_hidrovo_benalcazar.p12", null, "Amor2018";
//$xml_final = $obj_facturacion->injectSignature($xml);

/*$doc = new DOMDocument();
$doc->formatOutput = true;
$return = $doc->loadXML($xml_final);

$doc->save('local.xml',LIBXML_NOEMPTYTAG);*/

$fp = fopen("local.xml", "r");
$contenido = '';
while (!feof($fp)){
    $linea = fgets($fp);
    $contenido .= $linea;
}
fclose($fp);

//echo "<textarea cols=150 rows=50>".$xml."</textarea>";

/*$wsdl = 'https://celcer.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl'; 
$params = Array("xml" => $contenido);
$options = Array(
    "uri"=> $wsdl,
    "trace" => true,
    "encoding" => "UTF-8",
);
$soap = new SoapClient($wsdl, $options);
$result = $soap->validarComprobante($params); 
echo "<br>";
print_r($result);*/

/*$wsdl = 'https://celcer.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl'; 
$options = Array(
    "uri"=> $wsdl,
    "trace" => true,
    "encoding" => "UTF-8",
);
$soap = new SoapClient($wsdl, $options);
$params = Array("claveAccesoComprobante" => '2501201901099306446700110010010000000261234567813');
$result = $soap->autorizacionComprobante($params); 
echo "<br>";
print_r($result);*/
?>
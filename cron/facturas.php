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

//$xml = $obj_facturacion->generarFactura();
//$obj_facturacion->sign(RUTA_INCLUDES."facturae/widman_ivan_hidrovo_benalcazar.p12", null, "Amor2018"); 
//$xml_final = $obj_facturacion->injectSignature($xml);

$xml_final = '<?xml version="1.0" encoding="UTF-8"?>
<factura id="comprobante" version="1.0.0">
    <infoTributaria>
        <ambiente>1</ambiente>
        <tipoEmision>1</tipoEmision>
        <razonSocial>MICAMELLO S.A.</razonSocial>
        <nombreComercial>MICAMELLO S.A.</nombreComercial>
        <ruc>0993064467001</ruc>
        <claveAcceso>1601201901099306446700110010010000000391234567815</claveAcceso>
        <codDoc>01</codDoc>
        <estab>001</estab>
        <ptoEmi>001</ptoEmi>
        <secuencial>000000039</secuencial>
        <dirMatriz>Km 12 Av. Febres Cordero Cdla. Villa Club Etapa Krypton Mz.14 Solar 3</dirMatriz>
    </infoTributaria>
    <infoFactura>
        <fechaEmision>16/01/2019</fechaEmision>
        <dirEstablecimiento>Km 12 Av. Febres Cordero Cdla. Villa Club Etapa Krypton Mz.14 Solar 3</dirEstablecimiento>
        <obligadoContabilidad>SI</obligadoContabilidad>
        <tipoIdentificacionComprador>05</tipoIdentificacionComprador>
        <razonSocialComprador>FERNANDA MAGALY FUELTALA NARVAEZ</razonSocialComprador>
        <identificacionComprador>0919580985</identificacionComprador>
        <direccionComprador>Duran cdla abel gilbert mz b48 v1</direccionComprador>
        <totalSinImpuestos>23.00</totalSinImpuestos>
        <totalDescuento>0.00</totalDescuento>
        <totalConImpuestos>
            <totalImpuesto>
                <codigo>2</codigo>
                <codigoPorcentaje>2</codigoPorcentaje>
                <baseImponible>23.00</baseImponible>
                <tarifa>12</tarifa>
                <valor>2.76</valor>
            </totalImpuesto>
        </totalConImpuestos>
        <propina>0.00</propina>
        <importeTotal>25.76</importeTotal>
        <moneda>DOLAR</moneda>
        <pagos>
            <pago>
                <formaPago>01</formaPago>
                <total>25.00</total>
                <plazo>1</plazo>
                <unidadTiempo>Días</unidadTiempo>
            </pago>
        </pagos>
    </infoFactura>
    <detalles>
        <detalle>
            <codigoPrincipal>1</codigoPrincipal>
            <descripcion>CAMELLITO SIMPLE</descripcion>
            <cantidad>1</cantidad>
            <precioUnitario>23</precioUnitario>
            <descuento>0</descuento>
            <precioTotalSinImpuesto>23.00</precioTotalSinImpuesto>
            <impuestos>
                <impuesto>
                    <codigo>2</codigo>
                    <codigoPorcentaje>2</codigoPorcentaje>
                    <tarifa>12</tarifa>
                    <baseImponible>23.00</baseImponible>
                    <valor>2.76</valor>
                </impuesto>
            </impuestos>
        </detalle>
    </detalles>
    <infoAdicional>
        <campoAdicional nombre="Dirección">Duran cdla abel gilbert mz b48 v1</campoAdicional>
        <campoAdicional nombre="Teléfono">042551329</campoAdicional>
        <campoAdicional nombre="Email">fermaggy@hotmail.com</campoAdicional>
    </infoAdicional>
<ds:Signature xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:etsi="http://uri.etsi.org/01903/v1.3.2#" Id="Signature500400">
<ds:SignedInfo Id="Signature-SignedInfo195194">
<ds:CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"></ds:CanonicalizationMethod>
<ds:SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"></ds:SignatureMethod>
<ds:Reference Id="SignedPropertiesID61353" Type="http://uri.etsi.org/01903#SignedProperties" URI="#Signature500400-SignedProperties864283">
<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod>
<ds:DigestValue>FylvuVBe3Gx2ODW4LzmJhooyO6I=</ds:DigestValue>
</ds:Reference>
<ds:Reference URI="#Certificate1277949">
<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod>
<ds:DigestValue>McuUEIy8PSxai4YS08h4nYyQcIg=</ds:DigestValue>
</ds:Reference>
<ds:Reference Id="Reference-ID-450480" URI="#comprobante">
<ds:Transforms>
<ds:Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"></ds:Transform>
</ds:Transforms>
<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod>
<ds:DigestValue>CEA8jGkebre6ceqjAWC2J8iHEwk=</ds:DigestValue>
</ds:Reference>
</ds:SignedInfo>
<ds:SignatureValue Id="SignatureValue129109">
XAXyFMKF8nKFqgyDpe2ECjB961PT+Zn7qXb2KKI3Ckg7hleZ02jl6Dc0eE9cyWU2TvnZsVhzkyIs
Jer17eyicsIc/3KBX2sb1qOSMf9oYlUg7sUVhy5UUATZ14o5vLloh+W77I4wrz32QL4GQi79zZSJ
DwvirO6YQBCWMEm4Qn3snQ2Ohqyn7vSSORd2fIfQ4DgYCqPacBoxNY1AfrO8tuA2cHKCmacSdSdP
65eEtgb+pTcMwqI8hdvFLP7ojfzcr5Il5qAV2rZgP8WiPbyhDGsjhb+2BqdKY+DRFC9h1Jaq55rd
j/l2L9a0sQ/lZKjgrkvkfv4JMBcLsrO8qqb12Q==
</ds:SignatureValue>
<ds:KeyInfo Id="Certificate1277949">
<ds:X509Data>
<ds:X509Certificate>
MIIJ8TCCB9mgAwIBAgIEWH+3ojANBgkqhkiG9w0BAQsFADCBoTELMAkGA1UEBhMCRUMxIjAgBgNV
BAoTGUJBTkNPIENFTlRSQUwgREVMIEVDVUFET1IxNzA1BgNVBAsTLkVOVElEQUQgREUgQ0VSVElG
SUNBQ0lPTiBERSBJTkZPUk1BQ0lPTi1FQ0lCQ0UxDjAMBgNVBAcTBVFVSVRPMSUwIwYDVQQDExxB
QyBCQU5DTyBDRU5UUkFMIERFTCBFQ1VBRE9SMB4XDTE4MDExMDIwNDIzMloXDTIwMDExMDIxMTIz
MlowgbYxCzAJBgNVBAYTAkVDMSIwIAYDVQQKExlCQU5DTyBDRU5UUkFMIERFTCBFQ1VBRE9SMTcw
NQYDVQQLEy5FTlRJREFEIERFIENFUlRJRklDQUNJT04gREUgSU5GT1JNQUNJT04tRUNJQkNFMQ4w
DAYDVQQHEwVRVUlUTzE6MBEGA1UEBRMKMDAwMDI1MDY1ODAlBgNVBAMTHldJRE1BTiBJVkFOIEhJ
RFJPVk8gQkVOQUxDQVpBUjCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBAL88Rc9I575c
+S1D/wOVPr0fGeadYJ9Fs0qOxSJEVFoV1M7EOnZlOlVKE8JSo37jpNU9vsZpQBO0yDFFThHhpJkH
eeP9g/HkzmA+JZU+zX2VTwfYaQtC7chZYazUqeqDAO3FOz0gOD/14HyJZRzRy9Zl5kACMhgxQFf4
U45kMjKigIHh0OAOjXiBdEL5fRQObHdpDgDfqgEHnv0sKJ3tLkw+PRmL8SmTCCv6edxLH1Lvl1J+
C5DKKrgckTKdSGVmjYyphYb0deHWKDa2jSoO95qiShyk6YTZvnFWHWSBCDFljZk+H2WyCaOjluJJ
65XmLBzt375oO4/E8taPJcqNkusCAwEAAaOCBRgwggUUMAsGA1UdDwQEAwIHgDBnBgNVHSAEYDBe
MFwGCysGAQQBgqg7AgIBME0wSwYIKwYBBQUHAgEWP2h0dHA6Ly93d3cuZWNpLmJjZS5lYy9wb2xp
dGljYS1jZXJ0aWZpY2Fkby9wZXJzb25hLWp1cmlkaWNhLnBkZjCBkQYIKwYBBQUHAQEEgYQwgYEw
PgYIKwYBBQUHMAGGMmh0dHA6Ly9vY3NwLmVjaS5iY2UuZWMvZWpiY2EvcHVibGljd2ViL3N0YXR1
cy9vY3NwMD8GCCsGAQUFBzABhjNodHRwOi8vb2NzcDEuZWNpLmJjZS5lYy9lamJjYS9wdWJsaWN3
ZWIvc3RhdHVzL29jc3AwHAYKKwYBBAGCqDsDCgQOEwxNSUNBTUVMTE8gU0EwHQYKKwYBBAGCqDsD
CwQPEw0wOTkzMDY0NDY3MDAxMBoGCisGAQQBgqg7AwEEDBMKMTcxMjQ2NTczOTAbBgorBgEEAYKo
OwMCBA0TC1dJRE1BTiBJVkFOMBcGCisGAQQBgqg7AwMECRMHSElEUk9WTzAaBgorBgEEAYKoOwME
BAwTCkJFTkFMQ0FaQVIwHwYKKwYBBAGCqDsDBQQREw9HRVJFTlRFIEdFTkVSQUwwMQYKKwYBBAGC
qDsDBwQjEyFWSUxMQSBDTFVCIEVUQVBBIEtSWVBUT04gTVogMTQgVjMwGQYKKwYBBAGCqDsDCAQL
EwkwNDI3NTMxMDYwGQYKKwYBBAGCqDsDCQQLEwlHdWF5YXF1aWwwFwYKKwYBBAGCqDsDDAQJEwdF
Q1VBRE9SMCAGCisGAQQBgqg7AzMEEhMQU09GVFdBUkUtQVJDSElWTzAiBgNVHREEGzAZgRd3aWRt
YW5oaWRyb3ZvQGdtYWlsLmNvbTCCAd8GA1UdHwSCAdYwggHSMIIBzqCCAcqgggHGhoHVbGRhcDov
L2JjZXFsZGFwc3VicDEuYmNlLmVjL2NuPUNSTDQ5OSxjbj1BQyUyMEJBTkNPJTIwQ0VOVFJBTCUy
MERFTCUyMEVDVUFET1IsbD1RVUlUTyxvdT1FTlRJREFEJTIwREUlMjBDRVJUSUZJQ0FDSU9OJTIw
REUlMjBJTkZPUk1BQ0lPTi1FQ0lCQ0Usbz1CQU5DTyUyMENFTlRSQUwlMjBERUwlMjBFQ1VBRE9S
LGM9RUM/Y2VydGlmaWNhdGVSZXZvY2F0aW9uTGlzdD9iYXNlhjRodHRwOi8vd3d3LmVjaS5iY2Uu
ZWMvQ1JML2VjaV9iY2VfZWNfY3JsZmlsZWNvbWIuY3JspIG1MIGyMQswCQYDVQQGEwJFQzEiMCAG
A1UEChMZQkFOQ08gQ0VOVFJBTCBERUwgRUNVQURPUjE3MDUGA1UECxMuRU5USURBRCBERSBDRVJU
SUZJQ0FDSU9OIERFIElORk9STUFDSU9OLUVDSUJDRTEOMAwGA1UEBxMFUVVJVE8xJTAjBgNVBAMT
HEFDIEJBTkNPIENFTlRSQUwgREVMIEVDVUFET1IxDzANBgNVBAMTBkNSTDQ5OTArBgNVHRAEJDAi
gA8yMDE4MDExMDIwNDIzMlqBDzIwMjAwMTEwMjExMjMyWjAfBgNVHSMEGDAWgBQY+fD75jIcmWY5
KsqLsml9SSe/zjAdBgNVHQ4EFgQUQwUxoPxbl6RHSWq2WjKwYGIfJDwwCQYDVR0TBAIwADAZBgkq
hkiG9n0HQQAEDDAKGwRWOC4xAwIEsDANBgkqhkiG9w0BAQsFAAOCAgEAbHZgzZV7FQEugDfARPJo
eadgaIJMFib3ZNzMl3Wj88Ld/zgBM10cvBkjRj4Q1BO1jEFQ2nRv4vkhYmrnfN5wX9GhmQB0T/vP
kdiuv0yuu70qNzT9IDdXRIbVAi3ehiCwtpIr6l28kUmHaAIxJK+54ByTlrM/SUIp6TFGJ2rWV/q5
zk/jGVppHLaNnvBWopiAaH7BR+6yak2I0LnsYszFpLWOdjnnZ9TzlV97AJeIi4HHpOFLokl52FDK
5zab86VUBPkJHRgGrUDPiiX5H0n3EDc5co5sFS+K394N22XxVnbQid4GWnQWfIrzIigH9qT8taXI
IP+Z4aTnPNGKAP6JxfaO2sW2xxxSWrCUIPJ8tig19y/8l8ADgexW3cuX7yoMusuFKaw0MPPtx2hk
pFV2/2sOwHx/rWSPXtuzWHGUcHHmhQBYZFpzxgQtszuDT7lRRu1xU81wsOAxMTbunw+Qy9/1gmQ3
9Zax84Cba1iqEpy41/yLIfz8tEPIWrsg3MC0kOstTaEY3SqDMRgFONMCDkiGbxmTEOUnRrb3M2Hq
KMYfdD9ZoeY74n3PkVpuBuysCk112ATgAaaUd2gpyfaM4DKBxi+uwbCDIs7mXqJ9mVgIQ02qc6Cw
VVEVLVHoGHy5u58iyN8nc+Vl6Js4jSn5cm0sE3AyT1j0bI9zXWkx7pY=
</ds:X509Certificate>
</ds:X509Data>
<ds:KeyValue>
<ds:RSAKeyValue>
<ds:Modulus>
vzxFz0jnvlz5LUP/A5U+vR8Z5p1gn0WzSo7FIkRUWhXUzsQ6dmU6VUoTwlKjfuOk1T2+xmlAE7TI
MUVOEeGkmQd54/2D8eTOYD4llT7NfZVPB9hpC0LtyFlhrNSp6oMA7cU7PSA4P/XgfIllHNHL1mXm
QAIyGDFAV/hTjmQyMqKAgeHQ4A6NeIF0Qvl9FA5sd2kOAN+qAQee/Swone0uTD49GYvxKZMIK/p5
3EsfUu+XUn4LkMoquByRMp1IZWaNjKmFhvR14dYoNraNKg73mqJKHKTphNm+cVYdZIEIMWWNmT4f
ZbIJo6OW4knrleYsHO3fvmg7j8Ty1o8lyo2S6w==
</ds:Modulus>
<ds:Exponent>AQAB</ds:Exponent>
</ds:RSAKeyValue>
</ds:KeyValue>
</ds:KeyInfo>
<ds:Object Id="Signature500400-Object74730"><etsi:QualifyingProperties Target="#Signature500400"><etsi:SignedProperties Id="Signature500400-SignedProperties864283"><etsi:SignedSignatureProperties><etsi:SigningTime>2019-01-16T16:02:26-05:00</etsi:SigningTime><etsi:SigningCertificate><etsi:Cert><etsi:CertDigest><ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod><ds:DigestValue>KiO4lk5C4adHzXVIrQb9W5acGps=</ds:DigestValue></etsi:CertDigest><etsi:IssuerSerial><ds:X509IssuerName>CN=AC BANCO CENTRAL DEL ECUADOR,L=QUITO,OU=ENTIDAD DE CERTIFICACION DE INFORMACION-ECIBCE,O=BANCO CENTRAL DEL ECUADOR,C=EC</ds:X509IssuerName><ds:X509SerialNumber>1484765090</ds:X509SerialNumber></etsi:IssuerSerial></etsi:Cert></etsi:SigningCertificate></etsi:SignedSignatureProperties><etsi:SignedDataObjectProperties><etsi:DataObjectFormat ObjectReference="#Reference-ID-450480"><etsi:Description>contenido comprobante</etsi:Description><etsi:MimeType>text/xml</etsi:MimeType></etsi:DataObjectFormat></etsi:SignedDataObjectProperties></etsi:SignedProperties></etsi:QualifyingProperties></ds:Object></ds:Signature></factura>';

$doc = new DOMDocument();
$doc->formatOutput = true;
$return = $doc->loadXML($xml_final);

$doc->save('local.xml',LIBXML_NOEMPTYTAG);
//echo $xml_final->save('local.xml');

/*function string2ByteArray($string) {
  return unpack('C*', $string);
}
function byteArray2String($byteArray) {
  $chars = array_map("chr", $byteArray);
  return join($chars);
}
function byteArray2Hex($byteArray) {
  $chars = array_map("chr", $byteArray);
  $bin = join($chars);
  return bin2hex($bin);
}
function hex2ByteArray($hexString) {
  $string = hex2bin($hexString);
  return unpack('C*', $string);
}
function string2Hex($string) {
  return bin2hex($string);
}
function hex2String($hexString) {
  return hex2bin($hexString);
}
function create_byte_array($string){
    $array = array();
    foreach(str_split($string) as $char){
        array_push($array, sprintf("%02X", ord($char)));
    }
    return implode(' ', $array);
}*/

$fp = fopen("local.xml", "r");
$contenido = '';
while (!feof($fp)){
    $linea = fgets($fp);
    $contenido .= $linea;
}
fclose($fp);

echo $contenido;

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

$wsdl = 'https://celcer.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl'; 
$options = Array(
    "uri"=> $wsdl,
    "trace" => true,
    "encoding" => "UTF-8",
);
$soap = new SoapClient($wsdl, $options);
$params = Array("claveAccesoComprobante" => '1601201901099306446700110010010000000391234567815');
$result = $soap->autorizacionComprobante($params); 
echo "<br>";
print_r($result);
?>
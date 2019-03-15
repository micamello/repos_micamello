<?php
require_once '../constantes.php';
require_once '../init.php';
require_once '../frontend/Proceso/Facturacion.php';

$obj_facturacion = new Proceso_Facturacion();
$obj_facturacion->razonSocialComprador = 'Fernanda Magalyñ Fueltala Narváéíóúz';
$obj_facturacion->identificacionComprador = '0919580985';
$obj_facturacion->direccionComprador = 'Duráéíóún cdlañ abel gilbert mz b#48 v1.';
$obj_facturacion->emailComprador = 'fermaggy@hotmail.com';
$obj_facturacion->telefComprador = '0997969113';
$obj_facturacion->tipoIdentifComprador = TIPO_DOCUMENTO[2];
$obj_facturacion->importeTotal = 23;
$obj_facturacion->codigoPrincipal = '2';
$obj_facturacion->descripdetalle = 'Camellito Efectivo';

//$xml = $obj_facturacion->generarFactura();

//echo "<textarea cols=150 rows=50>".$xml."</textarea>";

$xml = '<?xml version="1.0" encoding="UTF-8"?>
<factura id="comprobante" version="1.0.0">
  <infoTributaria>
    <ambiente>1</ambiente>
    <tipoEmision>1</tipoEmision>
    <razonSocial>MICAMELLO S.A.</razonSocial>
    <nombreComercial>MICAMELLO S.A.</nombreComercial>
    <ruc>0993064467001</ruc>
    <claveAcceso>15032019010993064467001100100100000005312345678110</claveAcceso>
    <codDoc>01</codDoc>
    <estab>001</estab>
    <ptoEmi>001</ptoEmi>
    <secuencial>000000053</secuencial>
    <dirMatriz>Km 12 Av. Febres Cordero Cdla. Villa Club Etapa Krypton Mz.14 Solar 3</dirMatriz>
  </infoTributaria>
  <infoFactura>
    <fechaEmision>15/03/2019</fechaEmision>
    <dirEstablecimiento>Km 12 Av. Febres Cordero Cdla. Villa Club Etapa Krypton Mz.14 Solar 3</dirEstablecimiento>
    <obligadoContabilidad>SI</obligadoContabilidad>
    <tipoIdentificacionComprador>05</tipoIdentificacionComprador>
    <razonSocialComprador>Fernanda </razonSocialComprador>
    <identificacionComprador>0919580985</identificacionComprador>
    <direccionComprador>Quito</direccionComprador>
    <totalSinImpuestos>20.24</totalSinImpuestos>
    <totalDescuento>0</totalDescuento>
    <totalConImpuestos>
      <totalImpuesto>
        <codigo>2</codigo>
        <codigoPorcentaje>2</codigoPorcentaje>
        <baseImponible>20.24</baseImponible>
        <tarifa>12</tarifa>
        <valor>2.76</valor>
      </totalImpuesto>
    </totalConImpuestos>
    <propina>0.00</propina>
    <importeTotal>23.00</importeTotal>
    <moneda>DOLAR</moneda>
    <pagos>
      <pago>
        <formaPago>01</formaPago>
        <total>23.00</total>
        <plazo>1</plazo>
        <unidadTiempo>Días</unidadTiempo>
      </pago>
    </pagos>
  </infoFactura>
  <detalles>
    <detalle>
      <codigoPrincipal>2</codigoPrincipal>
      <descripcion>Camellito Simple</descripcion>
      <cantidad>1</cantidad>
      <precioUnitario>20.24</precioUnitario>
      <descuento>0</descuento>
      <precioTotalSinImpuesto>20.24</precioTotalSinImpuesto>
      <impuestos>
        <impuesto>
          <codigo>2</codigo>
          <codigoPorcentaje>2</codigoPorcentaje>
          <tarifa>12</tarifa>
          <baseImponible>20.24</baseImponible>
          <valor>2.76</valor>
        </impuesto>
      </impuestos>
    </detalle>
  </detalles>
  <infoAdicional>
    <campoAdicional nombre="Dirección">Quito</campoAdicional>
    <campoAdicional nombre="Teléfono">0997969113</campoAdicional>
    <campoAdicional nombre="Email">fermaggy@hotmail.com</campoAdicional>
  </infoAdicional>
<ds:Signature xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:etsi="http://uri.etsi.org/01903/v1.3.2#" Id="Signature76865">
<ds:SignedInfo Id="Signature-SignedInfo20995">
<ds:CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"></ds:CanonicalizationMethod>
<ds:SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"></ds:SignatureMethod>
<ds:Reference Id="SignedPropertiesID55353" Type="http://uri.etsi.org/01903#SignedProperties" URI="#Signature76865-SignedProperties18072">
<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod>
<ds:DigestValue>u1NR0Ngpnn2WUdTOy3doE+uoS3E=</ds:DigestValue>
</ds:Reference>
<ds:Reference URI="#Certificate95705">
<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod>
<ds:DigestValue>ld+R3ZS+fYTCAFRRNLLn57hF6rY=</ds:DigestValue>
</ds:Reference>
<ds:Reference Id="Reference-ID-6934" URI="#comprobante">
<ds:Transforms>
<ds:Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"></ds:Transform>
</ds:Transforms>
<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod>
<ds:DigestValue>tFtS5yNgLcSgULlc6j28EkkmJ2k=</ds:DigestValue>
</ds:Reference>
</ds:SignedInfo>
<ds:SignatureValue Id="SignatureValue21904">
BcEv9zOl2ArWHc+8LFdIfLh1EiSGbOS3EB7l/FFoEKsUk5W5ASnqEe9nP205KBBpDdPHqOY3WFa8
We4M2niK4/4Cy2wtBOzFmwEMAx8wZhhqZa7gDXSGjJUdQfQSl62B+ZJem96okNCn93rSVn9+lLBD
c7keeqFNSygY5616xPnodEaD6rkFUvOF2/PYg1/kKdvlXnMQ4fVjtaJZ+ZXp+3XA+OB4B3Ud+ssF
Qg/E4/F6puRkb26jYgd4V6P82JKcSJUH+nLB9dmkXeoGyLYqUbeBpLJc6TMOj77oS5O2/r6QL7jV
OSXV8ZOpZf/k64BJeMZk1RVl5lmQ+wU1bCROIQ==
</ds:SignatureValue>
<ds:KeyInfo Id="Certificate95705">
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
<ds:Object Id="Signature76865-Object8327"><etsi:QualifyingProperties Target="#Signature76865"><etsi:SignedProperties Id="Signature76865-SignedProperties18072"><etsi:SignedSignatureProperties><etsi:SigningTime>2019-03-15T16:08:31-05:00</etsi:SigningTime><etsi:SigningCertificate><etsi:Cert><etsi:CertDigest><ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod><ds:DigestValue>KiO4lk5C4adHzXVIrQb9W5acGps=</ds:DigestValue></etsi:CertDigest><etsi:IssuerSerial><ds:X509IssuerName>C=EC,O=BANCO CENTRAL DEL ECUADOR,OU=ENTIDAD DE CERTIFICACION DE INFORMACION-ECIBCE,L=QUITO,CN=AC BANCO CENTRAL DEL ECUADOR</ds:X509IssuerName><ds:X509SerialNumber>1484765090</ds:X509SerialNumber></etsi:IssuerSerial></etsi:Cert></etsi:SigningCertificate></etsi:SignedSignatureProperties><etsi:SignedDataObjectProperties><etsi:DataObjectFormat ObjectReference="#Reference-ID-6934"><etsi:Description>contenido comprobante</etsi:Description><etsi:MimeType>text/xml</etsi:MimeType></etsi:DataObjectFormat></etsi:SignedDataObjectProperties></etsi:SignedProperties></etsi:QualifyingProperties></ds:Object></ds:Signature></factura>';

//$obj_facturacion->generarRIDE($xml);

$wsdl = 'https://celcer.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl'; 
$params = Array("xml" => $xml);
$options = Array(
    "uri"=> $wsdl,
    "trace" => true,
    "encoding" => "UTF-8",
);
$soap = new SoapClient($wsdl, $options);
$result = $soap->validarComprobante($params); 
echo "<br>";
print_r($result);

/*$wsdl = 'https://celcer.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl'; 
$options = Array(
    "uri"=> $wsdl,
    "trace" => true,
    "encoding" => "UTF-8",
);
$soap = new SoapClient($wsdl, $options);
$params = Array("claveAccesoComprobante" => '1303201901099306446700110010010000000471234567818');
$result = $soap->autorizacionComprobante($params); 
echo "<br>";
print_r($result);*/
?>
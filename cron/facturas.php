<?php
require_once '../constantes.php';
require_once '../init.php';
require_once RUTA_INCLUDES.'nusoap/lib/nusoap.php';

$obj_facturacion = new Proceso_Facturacion();
$obj_facturacion->razonSocialComprador = 'Fernanda Fueltala';
$obj_facturacion->identificacionComprador = '0919580985';
$obj_facturacion->direccionComprador = 'Duran Cdla Abel Gilbert Mz B48 V1';
$obj_facturacion->tipoIdentifComprador = TIPO_DOCUMENTO[2];
$obj_facturacion->importeTotal = 23;
$obj_facturacion->codigoPrincipal = '2';
$obj_facturacion->descripdetalle = 'Camellito Simple';

$xml = $obj_facturacion->generarFactura();
$obj_facturacion->sign(RUTA_INCLUDES."facturae/widman_ivan_hidrovo_benalcazar.p12", null, "Amor2018"); 
$xml_final = $obj_facturacion->injectSignature($xml);
$byte_array = unpack('C*', '<?xml version="1.0" encoding="UTF-8"?>
<factura id="comprobante" version="1.1.0">
    <infoTributaria>
        <ambiente>1</ambiente>
        <tipoEmision>1</tipoEmision>
        <razonSocial>JIMENEZ AGUILAR LUIS ADRIAN</razonSocial>
        <nombreComercial>IMPORTADORA JIMENEZ</nombreComercial>
        <ruc>0703360487001</ruc>
        <claveAcceso>1506201801070336048700110010010000000010000000115</claveAcceso>
        <codDoc>01</codDoc>
        <estab>001</estab>
        <ptoEmi>001</ptoEmi>
        <secuencial>000000001</secuencial>
        <dirMatriz>CDLA. GUAYACANES MZ. 216 SOLAR 20</dirMatriz>
    </infoTributaria>
    <infoFactura>
        <fechaEmision>15/06/2018</fechaEmision>
        <dirEstablecimiento>CDLA. GUAYACANES MZ. 216 SOLAR 20</dirEstablecimiento>
        <contribuyenteEspecial>0000</contribuyenteEspecial>
        <obligadoContabilidad>SI</obligadoContabilidad>
        <tipoIdentificacionComprador>04</tipoIdentificacionComprador>
        <razonSocialComprador>IVAN GAVILANEZ</razonSocialComprador>
        <identificacionComprador>0920011772001</identificacionComprador>
        <totalSinImpuestos>243.20</totalSinImpuestos>
        <totalDescuento>0.00</totalDescuento>
        <totalConImpuestos>
            <totalImpuesto>
                <codigo>2</codigo>
                <codigoPorcentaje>2</codigoPorcentaje>
                <baseImponible>243.20</baseImponible>
                <valor>29.18</valor>
            </totalImpuesto>
        </totalConImpuestos>
        <propina>0.00</propina>
        <importeTotal>272.38</importeTotal>
        <moneda>DOLAR</moneda>
        <pagos>
            <pago>
                <formaPago>01</formaPago>
                <total>272.38</total>
                <plazo>0</plazo>
                <unidadTiempo>dias</unidadTiempo>
            </pago>
        </pagos>
    </infoFactura>
    <detalles>
        <detalle>
            <codigoPrincipal>0001</codigoPrincipal>
            <codigoAuxiliar>0001</codigoAuxiliar>
            <descripcion>TINTA ROJA 032 DONG YANG INK 1 KILO</descripcion>
            <cantidad>2.00</cantidad>
            <precioUnitario>14.2900</precioUnitario>
            <descuento>0.00</descuento>
            <precioTotalSinImpuesto>28.58</precioTotalSinImpuesto>
            <impuestos>
                <impuesto>
                    <codigo>2</codigo>
                    <codigoPorcentaje>2</codigoPorcentaje>
                    <tarifa>12.00</tarifa>
                    <baseImponible>28.58</baseImponible>
                    <valor>3.42</valor>
                </impuesto>
            </impuestos>
        </detalle>
        <detalle>
            <codigoPrincipal>0012</codigoPrincipal>
            <codigoAuxiliar>0012</codigoAuxiliar>
            <descripcion>RODILLO DISTRIBUIDOR COLOMBIANO CHIEF 15</descripcion>
            <cantidad>2.00</cantidad>
            <precioUnitario>53.5700</precioUnitario>
            <descuento>0.00</descuento>
            <precioTotalSinImpuesto>107.14</precioTotalSinImpuesto>
            <impuestos>
                <impuesto>
                    <codigo>2</codigo>
                    <codigoPorcentaje>2</codigoPorcentaje>
                    <tarifa>12.00</tarifa>
                    <baseImponible>107.14</baseImponible>
                    <valor>12.86</valor>
                </impuesto>
            </impuestos>
        </detalle>
        <detalle>
            <codigoPrincipal>0032</codigoPrincipal>
            <codigoAuxiliar>0032</codigoAuxiliar>
            <descripcion>RODILLO PASE PAPEL CAUCHO RENCAUCHE CHIEF 15/17</descripcion>
            <cantidad>3.00</cantidad>
            <precioUnitario>22.3200</precioUnitario>
            <descuento>0.00</descuento>
            <precioTotalSinImpuesto>66.96</precioTotalSinImpuesto>
            <impuestos>
                <impuesto>
                    <codigo>2</codigo>
                    <codigoPorcentaje>2</codigoPorcentaje>
                    <tarifa>12.00</tarifa>
                    <baseImponible>66.96</baseImponible>
                    <valor>8.04</valor>
                </impuesto>
            </impuestos>
        </detalle>
        <detalle>
            <codigoPrincipal>0043</codigoPrincipal>
            <codigoAuxiliar>0043</codigoAuxiliar>
            <descripcion>MOLETON TELA PATO CAFE KORD TM#2 (51-79MM)</descripcion>
            <cantidad>0.81</cantidad>
            <precioUnitario>17.8600</precioUnitario>
            <descuento>0.00</descuento>
            <precioTotalSinImpuesto>14.47</precioTotalSinImpuesto>
            <impuestos>
                <impuesto>
                    <codigo>2</codigo>
                    <codigoPorcentaje>2</codigoPorcentaje>
                    <tarifa>12.00</tarifa>
                    <baseImponible>14.47</baseImponible>
                    <valor>1.73</valor>
                </impuesto>
            </impuestos>
        </detalle>
    </detalles>
<ds:Signature xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:etsi="http://uri.etsi.org/01903/v1.3.2#" Id="Signature470145">
<ds:SignedInfo Id="Signature-SignedInfo143579">
<ds:CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"></ds:CanonicalizationMethod>
<ds:SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"></ds:SignatureMethod>
<ds:Reference Id="SignedPropertiesID574754" Type="http://uri.etsi.org/01903#SignedProperties" URI="#Signature470145-SignedProperties682704">
<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod>
<ds:DigestValue>tj9Nvw6VupgrM/zXSynoWTwqll8=</ds:DigestValue>
</ds:Reference>
<ds:Reference URI="#Certificate1451469">
<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod>
<ds:DigestValue>FmjobzOA94T7rK6wmgCprFkusKA=</ds:DigestValue>
</ds:Reference>
<ds:Reference Id="Reference-ID-552521" URI="#comprobante">
<ds:Transforms>
<ds:Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"></ds:Transform>
</ds:Transforms>
<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod>
<ds:DigestValue>ELCLUARj32+epnFQypeIvnbHLag=</ds:DigestValue>
</ds:Reference>
</ds:SignedInfo>
<ds:SignatureValue Id="SignatureValue404944">
v1hJZ+N/80SbUXqzRo4LjTVbNypP1x5VDWDcZXFIXbQB67AOfJ+zbMW1DDrT4ytwo6o6rQxdkQZ/
PhbJGDnmpWsMeMv276Umzzlm/s8UhVw3cOj+qEE8Ykoqn6cX6TQK0hQClc3PxFv//ZkQHK5Fmhbj
9pH2wizLTe10Aurnnec+TFPfx4Lm7bQJStPyOe3HZwhlWb6SHRYFEhTy8Ud6Oq2HEEQsfo0e/Uvy
d7Urs4DbMq8a7epjap7Os6do2DbYelJE7LEOanOTkHuFtJejr7Xjz5l9HOJywNr4nWap/1DsjvLG
Cmdq3iw+AV94sZjDKJYh4IvPItlP0Py1WXqsyQ==
</ds:SignatureValue>
<ds:KeyInfo Id="Certificate1451469">
<ds:X509Data>
<ds:X509Certificate>
MIIJozCCCIugAwIBAgIEVNFsqjANBgkqhkiG9w0BAQsFADCBkzELMAkGA1UEBhMCRUMxGzAZBgNV
BAoTElNFQ1VSSVRZIERBVEEgUy5BLjEwMC4GA1UECxMnRU5USURBRCBERSBDRVJUSUZJQ0FDSU9O
IERFIElORk9STUFDSU9OMTUwMwYDVQQDEyxBVVRPUklEQUQgREUgQ0VSVElGSUNBQ0lPTiBTVUIg
U0VDVVJJVFkgREFUQTAeFw0xODA2MTMxNTE4MDhaFw0yNDA2MTMxNTQ4MDhaMIGXMQswCQYDVQQG
EwJFQzEbMBkGA1UEChMSU0VDVVJJVFkgREFUQSBTLkEuMTAwLgYDVQQLEydFTlRJREFEIERFIENF
UlRJRklDQUNJT04gREUgSU5GT1JNQUNJT04xOTATBgNVBAUTDDEzMDYxODEwNDYwMzAiBgNVBAMT
G0xVSVMgQURSSUFOIEpJTUVORVogQUdVSUxBUjCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoC
ggEBAPjos4Fx3n/kUHfcfg+HHSHW3VLoW2KnOdZE5eL8ZhrodKJNFkKACN1v/GAoKGUz5XZl23JH
b8PFIjg/q8GiUMdOdhGAFXrNyZieqbqGJK9dCM8SLt1m+K6RCNckBPUP86z09DTa+l60Bb6geidr
HLsxAGLy7PMHbrvgmM9JUeU1sFZZi3txzFne4AJ5Tp1APBMMENC9Fqd0zOqvYzDDTnfrDAaYy0yq
3U2UjHWodaokW3m34G9kdaj8Yc8/XSOK2ET/WzH0qaXRqDDX/1b5vKIsfzuPFFSw2m7XXtgknGvi
w8CrWbT6yYjVmPxAoDA6Z4GEpch26ZZ03qPaEOzXZE8CAwEAAaOCBfcwggXzMAsGA1UdDwQEAwIF
4DBZBggrBgEFBQcBAQRNMEswSQYIKwYBBQUHMAGGPWh0dHA6Ly9vY3NwZ3cuc2VjdXJpdHlkYXRh
Lm5ldC5lYy9lamJjYS9wdWJsaWN3ZWIvc3RhdHVzL29jc3AwgcQGA1UdIASBvDCBuTA8BgorBgEE
AYKmcgIHMC4wLAYIKwYBBQUHAgIwIBoeQ2VydGlmaWNhZG8gZGUgUGVyc29uYSBOYXR1cmFsMHkG
CisGAQQBgqZyAgEwazBpBggrBgEFBQcCARZdaHR0cHM6Ly93d3cuc2VjdXJpdHlkYXRhLm5ldC5l
Yy9sZXllc19ub3JtYXRpdmFzL1BvbGl0aWNhcyBkZSBDZXJ0aWZpY2FkbyBQZXJzb25hIE5hdHVy
YWwucGRmMBoGCisGAQQBgqZyAwEEDBMKMDcwMzM2MDQ4NzAbBgorBgEEAYKmcgMCBA0TC0xVSVMg
QURSSUFOMBcGCisGAQQBgqZyAwMECRMHSklNRU5FWjAXBgorBgEEAYKmcgMEBAkTB0FHVUlMQVIw
ewYKKwYBBAGCpnIDBwRtE2tDSVVEQURFTEE6IEdVQVlBQ0FORVMgTlVNRVJPOiBTT0xBUiAyMCBS
RUZFUkVOQ0lBOiBBIFRSRVMgQ1VBRFJBUyBERSBMQVMgT0ZJQ0lOQVMgREVQQUNJRklDVEVMIE1B
TlpBTkE6IDIxNjAbBgorBgEEAYKmcgMIBA0TCzU5MzQyODIyODUyMBkGCisGAQQBgqZyAwkECxMJ
R1VBWUFRVUlMMBcGCisGAQQBgqZyAwwECRMHRUNVQURPUjAdBgorBgEEAYKmcgMLBA8TDTA3MDMz
NjA0ODcwMDEwHwYKKwYBBAGCpnIDIAQREw8wMDEwMDIwMDAwMTcyMzgwEwYKKwYBBAGCpnIDIQQF
EwNQRlgwIgYDVR0RBBswGYEXbHVpc2ppbWVuZXpyaUB5YWhvby5jb20wggJ7BgNVHR8EggJyMIIC
bjCCAmqgggJmoIICYoY9aHR0cDovL29jc3Bndy5zZWN1cml0eWRhdGEubmV0LmVjL2VqYmNhL3B1
YmxpY3dlYi9zdGF0dXMvb2NzcIaB1WxkYXA6Ly9kaXJlY3Quc2VjdXJpdHlkYXRhLm5ldC5lYy9j
bj1DUkwyMTMsY249QVVUT1JJREFEJTIwREUlMjBDRVJUSUZJQ0FDSU9OJTIwU1VCJTIwU0VDVVJJ
VFklMjBEQVRBLG91PUVOVElEQUQlMjBERSUyMENFUlRJRklDQUNJT04lMjBERSUyMElORk9STUFD
SU9OLG89U0VDVVJJVFklMjBEQVRBJTIwUy5BLixjPUVDP2NlcnRpZmljYXRlUmV2b2NhdGlvbkxp
c3Q/YmFzZYaBnmh0dHBzOi8vZGlyZWN0LnNlY3VyaXR5ZGF0YS5uZXQuZWMvfmNybC9hdXRvcmlk
YWRfZGVfY2VydGlmaWNhY2lvbl9zdWJfc2VjdXJpdHlfZGF0YV9lbnRpZGFkX2RlX2NlcnRpZmlj
YWNpb25fZGVfaW5mb3JtYWNpb25fY3VyaXR5X2RhdGFfcy5hLl9jX2VjX2NybGZpbGUuY3JspIGn
MIGkMQswCQYDVQQGEwJFQzEbMBkGA1UEChMSU0VDVVJJVFkgREFUQSBTLkEuMTAwLgYDVQQLEydF
TlRJREFEIERFIENFUlRJRklDQUNJT04gREUgSU5GT1JNQUNJT04xNTAzBgNVBAMTLEFVVE9SSURB
RCBERSBDRVJUSUZJQ0FDSU9OIFNVQiBTRUNVUklUWSBEQVRBMQ8wDQYDVQQDEwZDUkwyMTMwKwYD
VR0QBCQwIoAPMjAxODA2MTMxNTE4MDhagQ8yMDI0MDYxMzE1NDgwOFowHwYDVR0jBBgwFoAU9y9M
4HXnYqN4llsGti5xO8xsP5AwHQYDVR0OBBYEFO1iOX1OZz7GPVyWACTg/Vw9w/QTMAkGA1UdEwQC
MAAwGQYJKoZIhvZ9B0EABAwwChsEVjguMQMCA6gwDQYJKoZIhvcNAQELBQADggEBADgDTpmkFnY9
ahKZhmJ3pXTnqncRS17TAMHGeKr/Pz5gO/TZqlg21Qph9VSS6Imu2WPsqV0yPMQPU//pjySOyzTi
rBG8S6GFGMrtliH11QMs7rxudCZlPooDUFNUYCQG9svcwRTS3iyw5XXtMXUcDzxKmIosfr0uor6+
Bp9BVCItdtoyz3lGAQOwbD2tzOCbDBZ+AegieKKn7VKB/u5OTV82wP0Qi1itpj6ZlsOMi8jisdI4
LWqspZL1nAjVIrAYBU7ZXyFC9IuVeeq5ZOA7lwJeD39JlNxQfSeGZHQ6n7N4VQV4+R2Knrq5C3Pb
4w+QbHAcKP6Rl5lIvjk9R6oMMBs=
</ds:X509Certificate>
</ds:X509Data>
<ds:KeyValue>
<ds:RSAKeyValue>
<ds:Modulus>
+OizgXHef+RQd9x+D4cdIdbdUuhbYqc51kTl4vxmGuh0ok0WQoAI3W/8YCgoZTPldmXbckdvw8Ui
OD+rwaJQx052EYAVes3JmJ6puoYkr10IzxIu3Wb4rpEI1yQE9Q/zrPT0NNr6XrQFvqB6J2scuzEA
YvLs8wduu+CYz0lR5TWwVlmLe3HMWd7gAnlOnUA8EwwQ0L0Wp3TM6q9jMMNOd+sMBpjLTKrdTZSM
dah1qiRbebfgb2R1qPxhzz9dI4rYRP9bMfSppdGoMNf/Vvm8oix/O48UVLDabtde2CSca+LDwKtZ
tPrJiNWY/ECgMDpngYSlyHbplnTeo9oQ7NdkTw==
</ds:Modulus>
<ds:Exponent>AQAB</ds:Exponent>
</ds:RSAKeyValue>
</ds:KeyValue>
</ds:KeyInfo>
<ds:Object Id="Signature470145-Object806398"><etsi:QualifyingProperties Target="#Signature470145"><etsi:SignedProperties Id="Signature470145-SignedProperties682704"><etsi:SignedSignatureProperties><etsi:SigningTime>2018-06-15T23:37:07-05:00</etsi:SigningTime><etsi:SigningCertificate><etsi:Cert><etsi:CertDigest><ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod><ds:DigestValue>yyid7+kYpeXkEFvm0JAQoBNa+hI=</ds:DigestValue></etsi:CertDigest><etsi:IssuerSerial><ds:X509IssuerName>CN=AUTORIDAD DE CERTIFICACION SUB SECURITY DATA,OU=ENTIDAD DE CERTIFICACION DE INFORMACION,O=SECURITY DATA S.A.,C=EC</ds:X509IssuerName><ds:X509SerialNumber>1423010986</ds:X509SerialNumber></etsi:IssuerSerial></etsi:Cert></etsi:SigningCertificate></etsi:SignedSignatureProperties><etsi:SignedDataObjectProperties><etsi:DataObjectFormat ObjectReference="#Reference-ID-552521"><etsi:Description>contenido comprobante</etsi:Description><etsi:MimeType>text/xml</etsi:MimeType></etsi:DataObjectFormat></etsi:SignedDataObjectProperties></etsi:SignedProperties></etsi:QualifyingProperties></ds:Object></ds:Signature></factura>');

$client = new nusoap_client('https://celcer.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl', 'wsdl');
$param = array('name' => array('xml'=>'<?xml version="1.0" encoding="UTF-8"?>
<factura id="comprobante" version="1.1.0">
    <infoTributaria>
        <ambiente>1</ambiente>
        <tipoEmision>1</tipoEmision>
        <razonSocial>JIMENEZ AGUILAR LUIS ADRIAN</razonSocial>
        <nombreComercial>IMPORTADORA JIMENEZ</nombreComercial>
        <ruc>0703360487001</ruc>
        <claveAcceso>1506201801070336048700110010010000000010000000115</claveAcceso>
        <codDoc>01</codDoc>
        <estab>001</estab>
        <ptoEmi>001</ptoEmi>
        <secuencial>000000001</secuencial>
        <dirMatriz>CDLA. GUAYACANES MZ. 216 SOLAR 20</dirMatriz>
    </infoTributaria>
    <infoFactura>
        <fechaEmision>15/06/2018</fechaEmision>
        <dirEstablecimiento>CDLA. GUAYACANES MZ. 216 SOLAR 20</dirEstablecimiento>
        <contribuyenteEspecial>0000</contribuyenteEspecial>
        <obligadoContabilidad>SI</obligadoContabilidad>
        <tipoIdentificacionComprador>04</tipoIdentificacionComprador>
        <razonSocialComprador>IVAN GAVILANEZ</razonSocialComprador>
        <identificacionComprador>0920011772001</identificacionComprador>
        <totalSinImpuestos>243.20</totalSinImpuestos>
        <totalDescuento>0.00</totalDescuento>
        <totalConImpuestos>
            <totalImpuesto>
                <codigo>2</codigo>
                <codigoPorcentaje>2</codigoPorcentaje>
                <baseImponible>243.20</baseImponible>
                <valor>29.18</valor>
            </totalImpuesto>
        </totalConImpuestos>
        <propina>0.00</propina>
        <importeTotal>272.38</importeTotal>
        <moneda>DOLAR</moneda>
        <pagos>
            <pago>
                <formaPago>01</formaPago>
                <total>272.38</total>
                <plazo>0</plazo>
                <unidadTiempo>dias</unidadTiempo>
            </pago>
        </pagos>
    </infoFactura>
    <detalles>
        <detalle>
            <codigoPrincipal>0001</codigoPrincipal>
            <codigoAuxiliar>0001</codigoAuxiliar>
            <descripcion>TINTA ROJA 032 DONG YANG INK 1 KILO</descripcion>
            <cantidad>2.00</cantidad>
            <precioUnitario>14.2900</precioUnitario>
            <descuento>0.00</descuento>
            <precioTotalSinImpuesto>28.58</precioTotalSinImpuesto>
            <impuestos>
                <impuesto>
                    <codigo>2</codigo>
                    <codigoPorcentaje>2</codigoPorcentaje>
                    <tarifa>12.00</tarifa>
                    <baseImponible>28.58</baseImponible>
                    <valor>3.42</valor>
                </impuesto>
            </impuestos>
        </detalle>
        <detalle>
            <codigoPrincipal>0012</codigoPrincipal>
            <codigoAuxiliar>0012</codigoAuxiliar>
            <descripcion>RODILLO DISTRIBUIDOR COLOMBIANO CHIEF 15</descripcion>
            <cantidad>2.00</cantidad>
            <precioUnitario>53.5700</precioUnitario>
            <descuento>0.00</descuento>
            <precioTotalSinImpuesto>107.14</precioTotalSinImpuesto>
            <impuestos>
                <impuesto>
                    <codigo>2</codigo>
                    <codigoPorcentaje>2</codigoPorcentaje>
                    <tarifa>12.00</tarifa>
                    <baseImponible>107.14</baseImponible>
                    <valor>12.86</valor>
                </impuesto>
            </impuestos>
        </detalle>
        <detalle>
            <codigoPrincipal>0032</codigoPrincipal>
            <codigoAuxiliar>0032</codigoAuxiliar>
            <descripcion>RODILLO PASE PAPEL CAUCHO RENCAUCHE CHIEF 15/17</descripcion>
            <cantidad>3.00</cantidad>
            <precioUnitario>22.3200</precioUnitario>
            <descuento>0.00</descuento>
            <precioTotalSinImpuesto>66.96</precioTotalSinImpuesto>
            <impuestos>
                <impuesto>
                    <codigo>2</codigo>
                    <codigoPorcentaje>2</codigoPorcentaje>
                    <tarifa>12.00</tarifa>
                    <baseImponible>66.96</baseImponible>
                    <valor>8.04</valor>
                </impuesto>
            </impuestos>
        </detalle>
        <detalle>
            <codigoPrincipal>0043</codigoPrincipal>
            <codigoAuxiliar>0043</codigoAuxiliar>
            <descripcion>MOLETON TELA PATO CAFE KORD TM#2 (51-79MM)</descripcion>
            <cantidad>0.81</cantidad>
            <precioUnitario>17.8600</precioUnitario>
            <descuento>0.00</descuento>
            <precioTotalSinImpuesto>14.47</precioTotalSinImpuesto>
            <impuestos>
                <impuesto>
                    <codigo>2</codigo>
                    <codigoPorcentaje>2</codigoPorcentaje>
                    <tarifa>12.00</tarifa>
                    <baseImponible>14.47</baseImponible>
                    <valor>1.73</valor>
                </impuesto>
            </impuestos>
        </detalle>
    </detalles>
<ds:Signature xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:etsi="http://uri.etsi.org/01903/v1.3.2#" Id="Signature470145">
<ds:SignedInfo Id="Signature-SignedInfo143579">
<ds:CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"></ds:CanonicalizationMethod>
<ds:SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"></ds:SignatureMethod>
<ds:Reference Id="SignedPropertiesID574754" Type="http://uri.etsi.org/01903#SignedProperties" URI="#Signature470145-SignedProperties682704">
<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod>
<ds:DigestValue>tj9Nvw6VupgrM/zXSynoWTwqll8=</ds:DigestValue>
</ds:Reference>
<ds:Reference URI="#Certificate1451469">
<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod>
<ds:DigestValue>FmjobzOA94T7rK6wmgCprFkusKA=</ds:DigestValue>
</ds:Reference>
<ds:Reference Id="Reference-ID-552521" URI="#comprobante">
<ds:Transforms>
<ds:Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"></ds:Transform>
</ds:Transforms>
<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod>
<ds:DigestValue>ELCLUARj32+epnFQypeIvnbHLag=</ds:DigestValue>
</ds:Reference>
</ds:SignedInfo>
<ds:SignatureValue Id="SignatureValue404944">
v1hJZ+N/80SbUXqzRo4LjTVbNypP1x5VDWDcZXFIXbQB67AOfJ+zbMW1DDrT4ytwo6o6rQxdkQZ/
PhbJGDnmpWsMeMv276Umzzlm/s8UhVw3cOj+qEE8Ykoqn6cX6TQK0hQClc3PxFv//ZkQHK5Fmhbj
9pH2wizLTe10Aurnnec+TFPfx4Lm7bQJStPyOe3HZwhlWb6SHRYFEhTy8Ud6Oq2HEEQsfo0e/Uvy
d7Urs4DbMq8a7epjap7Os6do2DbYelJE7LEOanOTkHuFtJejr7Xjz5l9HOJywNr4nWap/1DsjvLG
Cmdq3iw+AV94sZjDKJYh4IvPItlP0Py1WXqsyQ==
</ds:SignatureValue>
<ds:KeyInfo Id="Certificate1451469">
<ds:X509Data>
<ds:X509Certificate>
MIIJozCCCIugAwIBAgIEVNFsqjANBgkqhkiG9w0BAQsFADCBkzELMAkGA1UEBhMCRUMxGzAZBgNV
BAoTElNFQ1VSSVRZIERBVEEgUy5BLjEwMC4GA1UECxMnRU5USURBRCBERSBDRVJUSUZJQ0FDSU9O
IERFIElORk9STUFDSU9OMTUwMwYDVQQDEyxBVVRPUklEQUQgREUgQ0VSVElGSUNBQ0lPTiBTVUIg
U0VDVVJJVFkgREFUQTAeFw0xODA2MTMxNTE4MDhaFw0yNDA2MTMxNTQ4MDhaMIGXMQswCQYDVQQG
EwJFQzEbMBkGA1UEChMSU0VDVVJJVFkgREFUQSBTLkEuMTAwLgYDVQQLEydFTlRJREFEIERFIENF
UlRJRklDQUNJT04gREUgSU5GT1JNQUNJT04xOTATBgNVBAUTDDEzMDYxODEwNDYwMzAiBgNVBAMT
G0xVSVMgQURSSUFOIEpJTUVORVogQUdVSUxBUjCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoC
ggEBAPjos4Fx3n/kUHfcfg+HHSHW3VLoW2KnOdZE5eL8ZhrodKJNFkKACN1v/GAoKGUz5XZl23JH
b8PFIjg/q8GiUMdOdhGAFXrNyZieqbqGJK9dCM8SLt1m+K6RCNckBPUP86z09DTa+l60Bb6geidr
HLsxAGLy7PMHbrvgmM9JUeU1sFZZi3txzFne4AJ5Tp1APBMMENC9Fqd0zOqvYzDDTnfrDAaYy0yq
3U2UjHWodaokW3m34G9kdaj8Yc8/XSOK2ET/WzH0qaXRqDDX/1b5vKIsfzuPFFSw2m7XXtgknGvi
w8CrWbT6yYjVmPxAoDA6Z4GEpch26ZZ03qPaEOzXZE8CAwEAAaOCBfcwggXzMAsGA1UdDwQEAwIF
4DBZBggrBgEFBQcBAQRNMEswSQYIKwYBBQUHMAGGPWh0dHA6Ly9vY3NwZ3cuc2VjdXJpdHlkYXRh
Lm5ldC5lYy9lamJjYS9wdWJsaWN3ZWIvc3RhdHVzL29jc3AwgcQGA1UdIASBvDCBuTA8BgorBgEE
AYKmcgIHMC4wLAYIKwYBBQUHAgIwIBoeQ2VydGlmaWNhZG8gZGUgUGVyc29uYSBOYXR1cmFsMHkG
CisGAQQBgqZyAgEwazBpBggrBgEFBQcCARZdaHR0cHM6Ly93d3cuc2VjdXJpdHlkYXRhLm5ldC5l
Yy9sZXllc19ub3JtYXRpdmFzL1BvbGl0aWNhcyBkZSBDZXJ0aWZpY2FkbyBQZXJzb25hIE5hdHVy
YWwucGRmMBoGCisGAQQBgqZyAwEEDBMKMDcwMzM2MDQ4NzAbBgorBgEEAYKmcgMCBA0TC0xVSVMg
QURSSUFOMBcGCisGAQQBgqZyAwMECRMHSklNRU5FWjAXBgorBgEEAYKmcgMEBAkTB0FHVUlMQVIw
ewYKKwYBBAGCpnIDBwRtE2tDSVVEQURFTEE6IEdVQVlBQ0FORVMgTlVNRVJPOiBTT0xBUiAyMCBS
RUZFUkVOQ0lBOiBBIFRSRVMgQ1VBRFJBUyBERSBMQVMgT0ZJQ0lOQVMgREVQQUNJRklDVEVMIE1B
TlpBTkE6IDIxNjAbBgorBgEEAYKmcgMIBA0TCzU5MzQyODIyODUyMBkGCisGAQQBgqZyAwkECxMJ
R1VBWUFRVUlMMBcGCisGAQQBgqZyAwwECRMHRUNVQURPUjAdBgorBgEEAYKmcgMLBA8TDTA3MDMz
NjA0ODcwMDEwHwYKKwYBBAGCpnIDIAQREw8wMDEwMDIwMDAwMTcyMzgwEwYKKwYBBAGCpnIDIQQF
EwNQRlgwIgYDVR0RBBswGYEXbHVpc2ppbWVuZXpyaUB5YWhvby5jb20wggJ7BgNVHR8EggJyMIIC
bjCCAmqgggJmoIICYoY9aHR0cDovL29jc3Bndy5zZWN1cml0eWRhdGEubmV0LmVjL2VqYmNhL3B1
YmxpY3dlYi9zdGF0dXMvb2NzcIaB1WxkYXA6Ly9kaXJlY3Quc2VjdXJpdHlkYXRhLm5ldC5lYy9j
bj1DUkwyMTMsY249QVVUT1JJREFEJTIwREUlMjBDRVJUSUZJQ0FDSU9OJTIwU1VCJTIwU0VDVVJJ
VFklMjBEQVRBLG91PUVOVElEQUQlMjBERSUyMENFUlRJRklDQUNJT04lMjBERSUyMElORk9STUFD
SU9OLG89U0VDVVJJVFklMjBEQVRBJTIwUy5BLixjPUVDP2NlcnRpZmljYXRlUmV2b2NhdGlvbkxp
c3Q/YmFzZYaBnmh0dHBzOi8vZGlyZWN0LnNlY3VyaXR5ZGF0YS5uZXQuZWMvfmNybC9hdXRvcmlk
YWRfZGVfY2VydGlmaWNhY2lvbl9zdWJfc2VjdXJpdHlfZGF0YV9lbnRpZGFkX2RlX2NlcnRpZmlj
YWNpb25fZGVfaW5mb3JtYWNpb25fY3VyaXR5X2RhdGFfcy5hLl9jX2VjX2NybGZpbGUuY3JspIGn
MIGkMQswCQYDVQQGEwJFQzEbMBkGA1UEChMSU0VDVVJJVFkgREFUQSBTLkEuMTAwLgYDVQQLEydF
TlRJREFEIERFIENFUlRJRklDQUNJT04gREUgSU5GT1JNQUNJT04xNTAzBgNVBAMTLEFVVE9SSURB
RCBERSBDRVJUSUZJQ0FDSU9OIFNVQiBTRUNVUklUWSBEQVRBMQ8wDQYDVQQDEwZDUkwyMTMwKwYD
VR0QBCQwIoAPMjAxODA2MTMxNTE4MDhagQ8yMDI0MDYxMzE1NDgwOFowHwYDVR0jBBgwFoAU9y9M
4HXnYqN4llsGti5xO8xsP5AwHQYDVR0OBBYEFO1iOX1OZz7GPVyWACTg/Vw9w/QTMAkGA1UdEwQC
MAAwGQYJKoZIhvZ9B0EABAwwChsEVjguMQMCA6gwDQYJKoZIhvcNAQELBQADggEBADgDTpmkFnY9
ahKZhmJ3pXTnqncRS17TAMHGeKr/Pz5gO/TZqlg21Qph9VSS6Imu2WPsqV0yPMQPU//pjySOyzTi
rBG8S6GFGMrtliH11QMs7rxudCZlPooDUFNUYCQG9svcwRTS3iyw5XXtMXUcDzxKmIosfr0uor6+
Bp9BVCItdtoyz3lGAQOwbD2tzOCbDBZ+AegieKKn7VKB/u5OTV82wP0Qi1itpj6ZlsOMi8jisdI4
LWqspZL1nAjVIrAYBU7ZXyFC9IuVeeq5ZOA7lwJeD39JlNxQfSeGZHQ6n7N4VQV4+R2Knrq5C3Pb
4w+QbHAcKP6Rl5lIvjk9R6oMMBs=
</ds:X509Certificate>
</ds:X509Data>
<ds:KeyValue>
<ds:RSAKeyValue>
<ds:Modulus>
+OizgXHef+RQd9x+D4cdIdbdUuhbYqc51kTl4vxmGuh0ok0WQoAI3W/8YCgoZTPldmXbckdvw8Ui
OD+rwaJQx052EYAVes3JmJ6puoYkr10IzxIu3Wb4rpEI1yQE9Q/zrPT0NNr6XrQFvqB6J2scuzEA
YvLs8wduu+CYz0lR5TWwVlmLe3HMWd7gAnlOnUA8EwwQ0L0Wp3TM6q9jMMNOd+sMBpjLTKrdTZSM
dah1qiRbebfgb2R1qPxhzz9dI4rYRP9bMfSppdGoMNf/Vvm8oix/O48UVLDabtde2CSca+LDwKtZ
tPrJiNWY/ECgMDpngYSlyHbplnTeo9oQ7NdkTw==
</ds:Modulus>
<ds:Exponent>AQAB</ds:Exponent>
</ds:RSAKeyValue>
</ds:KeyValue>
</ds:KeyInfo>
<ds:Object Id="Signature470145-Object806398"><etsi:QualifyingProperties Target="#Signature470145"><etsi:SignedProperties Id="Signature470145-SignedProperties682704"><etsi:SignedSignatureProperties><etsi:SigningTime>2018-06-15T23:37:07-05:00</etsi:SigningTime><etsi:SigningCertificate><etsi:Cert><etsi:CertDigest><ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod><ds:DigestValue>yyid7+kYpeXkEFvm0JAQoBNa+hI=</ds:DigestValue></etsi:CertDigest><etsi:IssuerSerial><ds:X509IssuerName>CN=AUTORIDAD DE CERTIFICACION SUB SECURITY DATA,OU=ENTIDAD DE CERTIFICACION DE INFORMACION,O=SECURITY DATA S.A.,C=EC</ds:X509IssuerName><ds:X509SerialNumber>1423010986</ds:X509SerialNumber></etsi:IssuerSerial></etsi:Cert></etsi:SigningCertificate></etsi:SignedSignatureProperties><etsi:SignedDataObjectProperties><etsi:DataObjectFormat ObjectReference="#Reference-ID-552521"><etsi:Description>contenido comprobante</etsi:Description><etsi:MimeType>text/xml</etsi:MimeType></etsi:DataObjectFormat></etsi:SignedDataObjectProperties></etsi:SignedProperties></etsi:QualifyingProperties></ds:Object></ds:Signature></factura>'));
$result = $client->call('validarComprobante',$param);
$err = $client->getError();                                                 

print_r($result);       
?>

<html>
<head>
	
</head>
<body>
  <?php
   echo "<br><textarea cols=100 rows=30>".$xml_final."</textarea>"; 
   //echo "<br><textarea cols=100 rows=30>".$byte_array."</textarea>"; 
   //print_r($byte_array);
  ?>
</body>
</html>
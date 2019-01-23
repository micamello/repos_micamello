<?php
require_once RUTA_INCLUDES.'facturae/KeyPairReader.php';
require_once RUTA_INCLUDES.'facturae/XmlTools.php';

class Proceso_Facturacion{
     
  protected $claveAcceso;      
  protected $secuencial;  
  protected $totalSinImpuestos;
  protected $totalDescuento = '0';       
  protected $cantidad = 1;
  protected $importeImpuesto;
  //firma electronica
  protected $signatureID;
  protected $signedInfoID;
  protected $signedPropertiesID;
  protected $signatureValueID;
  protected $certificateID;
  protected $referenceID;
  protected $signatureSignedPropertiesID;
  protected $signatureObjectID;
  protected $publicKey;
  protected $privateKey;
  //protected $signPolicy;
  protected $signTime;

  public $razonSocialComprador;
  public $identificacionComprador;
  public $direccionComprador; 
  public $tipoIdentifComprador;
  public $emailComprador;
  public $telefComprador;
  public $importeTotal;
  public $codigoPrincipal;
  public $descripdetalle;

  const RUC = '0993064467001';
  const TIPO_EMISION = 1;
  const VERSION = '1.0.0';
  const RAZON_SOCIAL = 'MICAMELLO S.A.';
  const NOMBRE_COMERCIAL = 'MICAMELLO S.A.';
  const DIR_MATRIZ = 'Km 12 Av. Febres Cordero Cdla. Villa Club Etapa Krypton Mz.14 Solar 3';
  const OBLIGADO_CONTABILIDAD = 'SI';  
  const ESTAB = '001';
  const PTOEMI = '001';
  const CONTRIBUYENTE_ESPECIAL = '0000';
  const PROPINA = '0.00';
  const PLAZO = 1;
  const UNIDAD_TIEMPO = 'Días';
  const AMBIENTE = array("PRUEBAS"=>1, "PRODUCCION"=>2);
  const TIPO_DOCUMENTO = array("FACTURA"=>"01");  
  const TIPO_IDENTIF_COMPRADOR = array("RUC"=>"04","CÉDULA"=>"05","PASAPORTE"=>"06");
  const CODIGO_IMPUESTO = array("IVA"=>2,"ICE"=>3,"IRBPNR"=>5);  
  const TARIFA_IVA = array("12"=>2,"14"=>3);
  const MONEDA = array(1=>'DOLAR');
  const FORMA_PAGO = array("SINFINANCIERO"=>"01","TARJETADEBITO"=>"16","TARJETACREDITO"=>"19"); 
  const TIPO_IMPUESTO = array("detalle"=>1,"total"=>2);  
  
  const SCHEMA_3_2 = "3.2";
  const SCHEMA_3_2_1 = "3.2.1";
  const SCHEMA_3_2_2 = "3.2.2";

  protected static $SCHEMA_NS = array(
    self::SCHEMA_3_2   => "http://www.facturae.es/Facturae/2009/v3.2/Facturae",
    self::SCHEMA_3_2_1 => "http://www.facturae.es/Facturae/2014/v3.2.1/Facturae",
    self::SCHEMA_3_2_2 => "http://www.facturae.gob.es/formato/Versiones/Facturaev3_2_2.xml"
  );

  function generarFactura(){    
    $this->totalSinImpuestos = number_format(round($this->importeTotal / ((array_search(2, self::TARIFA_IVA)/100)+1),2),2);
    $this->importeImpuesto = number_format(round($this->totalSinImpuestos * (array_search(2, self::TARIFA_IVA)/100),2),2);
    $this->importeTotal = number_format($this->importeTotal,2);
    $this->generarClaveAcceso();
    return $this->creaXml();    
  }

  function generarClaveAcceso(){
    //$seriefactura = Modelo_Parametro::obtieneValor('seriefactura');
    //$numerofactura = Modelo_Parametro::obtieneValor('numerofactura')+1;
    $seriefactura = '001001';
    $numerofactura = 35;
    $this->secuencial = str_pad($numerofactura,9,"0",STR_PAD_LEFT);        
    $numerico = "12345678";   
    $clave = date('dmY').self::TIPO_DOCUMENTO["FACTURA"].
             self::RUC.
             self::AMBIENTE["PRUEBAS"].
             $seriefactura.
             $this->secuencial.
             $numerico.
             self::TIPO_EMISION;   
            
    $arrclave = str_split($clave);
    $j=7; $acum=0;
    for($i=0;$i<48;$i++){
      $acum = $acum + ($arrclave[$i] * $j);   
      $j = $j - 1;
      $j = ($j == 1) ? 7 : $j;
    }         
    $resultado = $acum%11;
    $codVerificador = 11 - $resultado;

    if($codVerificador >= 1 && $codVerificador <= 9){
      $codVerificador = $codVerificador;
    }else if($codVerificador == 10){
      $codVerificador = 1;
    }else if($codVerificador == 11){
      $codVerificador = 0;
    }
    $this->claveAcceso = $clave.$codVerificador;
  }

  function creaXml(){
    $xml = new DomDocument('1.0', 'UTF-8'); 
    $xml->preserveWhiteSpace = false;
    $xml->formatOutput = true;
    $root = $xml->createElement('factura');
    $root = $xml->appendChild($root);
    $attribute = $xml->createAttribute('id');    
    $attribute->value = 'comprobante';    
    $root->appendChild($attribute);
    $attribute = $xml->createAttribute('version');    
    $attribute->value = self::VERSION;    
    $root->appendChild($attribute);
    $nodo = $xml->createElement('infoTributaria');
    $infoTributaria = $this->valoresInfoTributaria();
    foreach($infoTributaria as $atributo=>$valor){
      $subnodo = $xml->createElement($atributo,$valor);                
      $subnodo = $nodo->appendChild($subnodo);     
      $nodo = $root->appendChild($nodo);  
    }  
    $nodo = $xml->createElement('infoFactura');
    $infoFactura = $this->valoresinfoFactura();    
    foreach($infoFactura as $atributo=>$valor){
      if ($atributo == "totalImpuesto"){
        $totalConImpuesto = $xml->createElement('totalConImpuestos');                
        $totalConImpuesto = $nodo->appendChild($totalConImpuesto);                            
        foreach($valor as $vlimpuesto){
          $totalImpuesto = $xml->createElement('totalImpuesto');                
          $totalImpuesto = $totalConImpuesto->appendChild($totalImpuesto); 
          foreach($vlimpuesto as $keyimp=>$impuesto){            
            $subnimp = $xml->createElement($keyimp,$impuesto);    
            $subnimp = $totalImpuesto->appendChild($subnimp);     
          }                       
        }        
      }
      elseif($atributo == "pagos"){
        $pagos = $xml->createElement('pagos');                
        $pagos = $nodo->appendChild($pagos);                            
        $pago = $xml->createElement('pago');
        $pago = $pagos->appendChild($pago);         
        foreach($valor as $keypago=>$vlpago){                                                        
          $subnpago = $xml->createElement($keypago,$vlpago);    
          $subnpago = $pago->appendChild($subnpago);                                      
        }        
      }
      else{        
        $subnodo = $xml->createElement($atributo,$valor);                
        $subnodo = $nodo->appendChild($subnodo);        
      }                  
    }
    $nodo = $root->appendChild($nodo);

    $detalles = $xml->createElement('detalles');
    $detalles = $root->appendChild($detalles);
    $detalle = $xml->createElement('detalle');
    $detalle = $detalles->appendChild($detalle);
    $infodetalle = $this->valoresDetalle();
    foreach($infodetalle as $keydet=>$vldetalle){
      if ($keydet == "impuestos"){
        $impuestos = $xml->createElement('impuestos');                
        $impuestos = $detalle->appendChild($impuestos);                            
        foreach($vldetalle as $vlimpuesto){
          $impuesto = $xml->createElement('impuesto');                
          $impuesto = $impuestos->appendChild($impuesto);           
          foreach($vlimpuesto as $keyimp=>$valorimpuesto){            
            $subnimp = $xml->createElement($keyimp,$valorimpuesto);    
            $subnimp = $impuesto->appendChild($subnimp);     
          }                       
        } 
      }
      else{
        $subnodo = $xml->createElement($keydet,$vldetalle);                
        $subnodo = $detalle->appendChild($subnodo);       
      }      
    }

    $infoadicional = $xml->createElement('infoAdicional'); 
    $infoadicional = $root->appendChild($infoadicional);
    $campoadicional = $xml->createElement('campoAdicional',$this->direccionComprador);
    $attribute = $xml->createAttribute('nombre');    
    $attribute->value = 'Direccion';    
    $campoadicional->appendChild($attribute);
    $campoadicional = $infoadicional->appendChild($campoadicional);
    $campoadicional = $xml->createElement('campoAdicional',$this->telefComprador);
    $attribute = $xml->createAttribute('nombre');    
    $attribute->value = 'Telefono';    
    $campoadicional->appendChild($attribute);
    $campoadicional = $infoadicional->appendChild($campoadicional);    
    $campoadicional = $xml->createElement('campoAdicional',$this->emailComprador);
    $attribute = $xml->createAttribute('nombre');    
    $attribute->value = 'Email';    
    $campoadicional->appendChild($attribute);
    $campoadicional = $infoadicional->appendChild($campoadicional);

    $xmltest = $xml->saveXML();
    $xml->save($this->claveAcceso.'.xml');
    return $xmltest;
  }

  function valoresInfoTributaria(){
    $infoTributaria = array("ambiente" => self::AMBIENTE["PRUEBAS"], 
                            "tipoEmision" => self::TIPO_EMISION,
                            "razonSocial" => self::RAZON_SOCIAL,                             
                            "nombreComercial" => self::NOMBRE_COMERCIAL,
                            "ruc" => self::RUC, 
                            "claveAcceso" => $this->claveAcceso, 
                            "codDoc" => self::TIPO_DOCUMENTO["FACTURA"], 
                            "estab" => self::ESTAB,
                            "ptoEmi" => self::PTOEMI,
                            "secuencial" => $this->secuencial,
                            "dirMatriz" => self::DIR_MATRIZ);
    return $infoTributaria;
  }

  function valoresinfoFactura(){
    $infoFactura = array("fechaEmision" => date("d/m/Y"),
                         "dirEstablecimiento" => self::DIR_MATRIZ,    
                         //"contribuyenteEspecial" => self::CONTRIBUYENTE_ESPECIAL,            
                         "obligadoContabilidad" => self::OBLIGADO_CONTABILIDAD,                                  
                         "tipoIdentificacionComprador" => self::TIPO_IDENTIF_COMPRADOR[$this->tipoIdentifComprador],                         
                         "razonSocialComprador" => strtoupper($this->razonSocialComprador),
                         "identificacionComprador" => $this->identificacionComprador,
                         "direccionComprador" => $this->direccionComprador,                        
                         "totalSinImpuestos" => $this->totalSinImpuestos,
                         "totalDescuento" => $this->totalDescuento,
                         "totalImpuesto" => array($this->valoresImpuestos(self::CODIGO_IMPUESTO["IVA"],self::TARIFA_IVA["12"],$this->importeImpuesto,self::TIPO_IMPUESTO['detalle'])),
                         "propina" => self::PROPINA,
                         "importeTotal" => $this->importeTotal,
                         "moneda" => self::MONEDA[1],
                         "pagos" => array("formaPago" => self::FORMA_PAGO["SINFINANCIERO"],
                                          "total" => $this->importeTotal,
                                          "plazo" => self::PLAZO,
                                          "unidadTiempo" => self::UNIDAD_TIEMPO
                                        )//,
                         //"valorRetIva" => '0.00',
                         //"valorRetRenta" => '0.00'
                        );    
    return $infoFactura;
  }

  function valoresDetalle(){
    $infoDetalle = array("codigoPrincipal" => $this->codigoPrincipal,
                         //"codigoAuxiliar" => $this->codigoPrincipal,
                         "descripcion" => strtoupper($this->descripdetalle),
                         "cantidad" => $this->cantidad,
                         "precioUnitario" => $this->totalSinImpuestos,
                         "descuento" => $this->totalDescuento,
                         "precioTotalSinImpuesto" => $this->totalSinImpuestos,
                         "impuestos" => array($this->valoresImpuestos(self::CODIGO_IMPUESTO["IVA"],self::TARIFA_IVA["12"],$this->importeImpuesto,self::TIPO_IMPUESTO['total'])));
    return $infoDetalle;
  }

  function valoresImpuestos($codigo,$tarifa,$valor,$tipoImp){
    $totalConImpuestos = array("codigo" => $codigo,
                               "codigoPorcentaje" => $tarifa);    
    if($tipoImp == 1){
      $totalConImpuestos["baseImponible"] = $this->totalSinImpuestos;
      $totalConImpuestos["tarifa"] = array_search(2, self::TARIFA_IVA);    
    }else{
      $totalConImpuestos["tarifa"] = array_search(2, self::TARIFA_IVA);
      $totalConImpuestos["baseImponible"] = $this->totalSinImpuestos;
    }    
    $totalConImpuestos["valor"] = $valor;
    return $totalConImpuestos;
  }

  function sign($publicPath, $privatePath=null, $passphrase=""/*,$policy=self::SIGN_POLICY_3_1*/) {
    // Generate random IDs
    $tools = new XmlTools();
    $this->signatureID = '470145';//$tools->randomId();
    $this->signedInfoID = '143579';//$tools->randomId();
    $this->signedPropertiesID = '574754';//$tools->randomId();
    $this->signatureValueID = '404944';//$tools->randomId();
    $this->certificateID = '1451469';//$tools->randomId();
    $this->referenceID = '552521';//$tools->randomId();
    $this->signatureSignedPropertiesID = '682704';//$tools->randomId();
    $this->signatureObjectID = '806398';//$tools->randomId();

    // Load public and private keys
    $reader = new KeyPairReader($publicPath, $privatePath, $passphrase);
    $this->publicKey = $reader->getPublicKey();
    $this->privateKey = $reader->getPrivateKey();
    //$this->signPolicy = $policy;
    unset($reader);   
    // Return success
    return (!empty($this->publicKey) && !empty($this->privateKey));
  }

  function injectSignature($xml) {
    // Make sure we have all we need to sign the document
    /*if (empty($this->publicKey) || empty($this->privateKey)) return $xml;
    $tools = new XmlTools();

    // Normalize document
    $xml = str_replace("\r", "", $xml);

    // Prepare signed properties
    $signTime = is_null($this->signTime) ? time() : $this->signTime;
    $certData = openssl_x509_parse($this->publicKey);
    $certIssuer = array();
    foreach ($certData['issuer'] as $item=>$value) {
      $certIssuer[] = $item . '=' . $value;
    }
    $certIssuer = implode(',', $certIssuer);

    // Generate signed properties
    $prop = '<etsi:SignedProperties Id="Signature' . $this->signatureID .
            '-SignedProperties' . $this->signatureSignedPropertiesID . '">' .
              '<etsi:SignedSignatureProperties>' .
                '<etsi:SigningTime>' . date('c', $signTime) . '</etsi:SigningTime>' .
                '<etsi:SigningCertificate>' .
                  '<etsi:Cert>' .
                    '<etsi:CertDigest>' .
                      '<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod>' .
                      '<ds:DigestValue>' . $tools->getCertDigest($this->publicKey) . '</ds:DigestValue>' .
                    '</etsi:CertDigest>' .
                    '<etsi:IssuerSerial>' .
                      '<ds:X509IssuerName>' . $certIssuer . '</ds:X509IssuerName>' .
                      '<ds:X509SerialNumber>' . $certData['serialNumber'] . '</ds:X509SerialNumber>' .
                    '</etsi:IssuerSerial>' .
                  '</etsi:Cert>' .
                '</etsi:SigningCertificate>' .
              '</etsi:SignedSignatureProperties>' .
              '<etsi:SignedDataObjectProperties>' .
                '<etsi:DataObjectFormat ObjectReference="#Reference-ID-' . $this->referenceID . '">' .
                  '<etsi:Description>Factura electrónica</etsi:Description>' .
                  '<etsi:MimeType>text/xml</etsi:MimeType>' .
                '</etsi:DataObjectFormat>' .
              '</etsi:SignedDataObjectProperties>' .
            '</etsi:SignedProperties>';

    // Extract public exponent (e) and modulus (n)
    $privateData = openssl_pkey_get_details($this->privateKey);
    $modulus = chunk_split(base64_encode($privateData['rsa']['n']), 76);
    $modulus = str_replace("\r", "", $modulus);
    $exponent = base64_encode($privateData['rsa']['e']);

    // Generate KeyInfo
    $kInfo = '<ds:KeyInfo Id="Certificate' . $this->certificateID . '">' . "\n" .
               '<ds:X509Data>' . "\n" .
                 '<ds:X509Certificate>' . "\n" . $tools->getCert($this->publicKey) . '</ds:X509Certificate>' . "\n" .
               '</ds:X509Data>' . "\n" .
               '<ds:KeyValue>' . "\n" .
                 '<ds:RSAKeyValue>' . "\n" .
                   '<ds:Modulus>' . "\n" . $modulus . '</ds:Modulus>' . "\n" .
                   '<ds:Exponent>' . $exponent . '</ds:Exponent>' . "\n" .
                 '</ds:RSAKeyValue>' . "\n" .
               '</ds:KeyValue>' . "\n" .
             '</ds:KeyInfo>';

    // Calculate digests
    $xmlns = $this->getNamespaces();
    $propDigest = $tools->getDigest($tools->injectNamespaces($prop, $xmlns));
    $kInfoDigest = $tools->getDigest($tools->injectNamespaces($kInfo, $xmlns));
    $documentDigest = $tools->getDigest($xml);

    // Generate SignedInfo
    $sInfo = '<ds:SignedInfo Id="Signature-SignedInfo' . $this->signedInfoID . '">' . "\n" .
               '<ds:CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315">' .
               '</ds:CanonicalizationMethod>' . "\n" .
               '<ds:SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1">' .
               '</ds:SignatureMethod>' . "\n" .
               '<ds:Reference Id="SignedPropertiesID' . $this->signedPropertiesID . '" ' .
               'Type="http://uri.etsi.org/01903#SignedProperties" ' .
               'URI="#Signature' . $this->signatureID . '-SignedProperties' .
               $this->signatureSignedPropertiesID . '">' . "\n" .
                 '<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1">' .
                 '</ds:DigestMethod>' . "\n" .
                 '<ds:DigestValue>' . $propDigest . '</ds:DigestValue>' . "\n" .
               '</ds:Reference>' . "\n" .
               '<ds:Reference URI="#Certificate' . $this->certificateID . '">' . "\n" .
                 '<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1">' .
                 '</ds:DigestMethod>' . "\n" .
                 '<ds:DigestValue>' . $kInfoDigest . '</ds:DigestValue>' . "\n" .
               '</ds:Reference>' . "\n" .
               '<ds:Reference Id="Reference-ID-' . $this->referenceID . '" URI="#comprobante">' . "\n" .
                 '<ds:Transforms>' . "\n" .
                   '<ds:Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature">' .
                   '</ds:Transform>' . "\n" .
                 '</ds:Transforms>' . "\n" .
                 '<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1">' .
                 '</ds:DigestMethod>' . "\n" .
                 '<ds:DigestValue>' . $documentDigest . '</ds:DigestValue>' . "\n" .
               '</ds:Reference>' . "\n" .
             '</ds:SignedInfo>';

    // Calculate signature
    $signaturePayload = $tools->injectNamespaces($sInfo, $xmlns);
    $signatureResult = $tools->getSignature($signaturePayload, $this->privateKey);

    // Make signature
    $sig = '<ds:Signature xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:etsi="http://uri.etsi.org/01903/v1.3.2#" Id="Signature' . $this->signatureID . '">' . "\n" .
             $sInfo . "\n" .
             '<ds:SignatureValue Id="SignatureValue' . $this->signatureValueID . '">' . "\n" .
               $signatureResult .
             '</ds:SignatureValue>' . "\n" .
             $kInfo . "\n" .
             '<ds:Object Id="Signature' . $this->signatureID . '-Object' . $this->signatureObjectID . '">' .
               '<etsi:QualifyingProperties Target="#Signature' . $this->signatureID . '">' .
                 $prop .
               '</etsi:QualifyingProperties>' .
             '</ds:Object>' .
           '</ds:Signature>';*/

    $sign = '<ds:Signature xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:etsi="http://uri.etsi.org/01903/v1.3.2#" Id="Signature713585">
<ds:SignedInfo Id="Signature-SignedInfo86168">
<ds:CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"></ds:CanonicalizationMethod>
<ds:SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"></ds:SignatureMethod>
<ds:Reference Id="SignedPropertiesID861246" Type="http://uri.etsi.org/01903#SignedProperties" URI="#Signature713585-SignedProperties124821">
<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod>
<ds:DigestValue>6eO2G2UGDZe/R8dIYJRcSdQEOZU=</ds:DigestValue>
</ds:Reference>
<ds:Reference URI="#Certificate1940706">
<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod>
<ds:DigestValue>N3p39c7hv/iAtAG17f5Zb3YbCnY=</ds:DigestValue>
</ds:Reference>
<ds:Reference Id="Reference-ID-160180" URI="#comprobante">
<ds:Transforms>
<ds:Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"></ds:Transform>
</ds:Transforms>
<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod>
<ds:DigestValue>9Z99xKugZUOD3SQtuNjIoi5LIKE=</ds:DigestValue>
</ds:Reference>
</ds:SignedInfo>
<ds:SignatureValue Id="SignatureValue976167">
mQDKE0uZIWpZCyZRmHYh2waf9IbyHUP7110DnfWnVDFbu477uKdWPMFRVnWxJS8dg0SU9PD4mbLt
kUu9BGD0G2s1TzRBOdWdBdNDsm0OFwNJT+BozDZeVxAEK3auUIbdTpG1rvchxvvZ+o31bLU718zl
as5n9B4/PYUvV3n9TeK25yyu/Kt+S9JxfJTJlGVTYQueHPEdeOHSOvrNcuBHqCKX8pJQ5TVvW8Gc
JTnFR732MM74T6ijvp2eCQiNpFPeCc4SciCQtkHh5LyV5OcsMBFyOkSXdiyKvBh9G/EmDQ5p8DQs
fzXWZgpk0zMefWVif3OIjcPxPILS+WvhTrYkTA==
</ds:SignatureValue>
<ds:KeyInfo Id="Certificate1940706">
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
<ds:Object Id="Signature713585-Object454535"><etsi:QualifyingProperties Target="#Signature713585"><etsi:SignedProperties Id="Signature713585-SignedProperties124821"><etsi:SignedSignatureProperties><etsi:SigningTime>2019-01-16T14:53:46-05:00</etsi:SigningTime><etsi:SigningCertificate><etsi:Cert><etsi:CertDigest><ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod><ds:DigestValue>KiO4lk5C4adHzXVIrQb9W5acGps=</ds:DigestValue></etsi:CertDigest><etsi:IssuerSerial><ds:X509IssuerName>CN=AC BANCO CENTRAL DEL ECUADOR,L=QUITO,OU=ENTIDAD DE CERTIFICACION DE INFORMACION-ECIBCE,O=BANCO CENTRAL DEL ECUADOR,C=EC</ds:X509IssuerName><ds:X509SerialNumber>1484765090</ds:X509SerialNumber></etsi:IssuerSerial></etsi:Cert></etsi:SigningCertificate></etsi:SignedSignatureProperties><etsi:SignedDataObjectProperties><etsi:DataObjectFormat ObjectReference="#Reference-ID-160180"><etsi:Description>contenido comprobante</etsi:Description><etsi:MimeType>text/xml</etsi:MimeType></etsi:DataObjectFormat></etsi:SignedDataObjectProperties></etsi:SignedProperties></etsi:QualifyingProperties></ds:Object></ds:Signature>';
   
    $xml = trim(str_replace('</factura>', $sign . '</factura>', $xml));  
      
    return $xml;    
  }

  function getNamespaces() {
    $xmlns = array();
    $xmlns[] = 'xmlns:ds="http://www.w3.org/2000/09/xmldsig#"';
    //$xmlns[] = 'xmlns:fe="' . self::$SCHEMA_NS[self::SCHEMA_3_2_1] . '"';
    $xmlns[] = 'xmlns:etsi="http://uri.etsi.org/01903/v1.3.2#"';
    return $xmlns;
  }
  /*public function export($filePath=null) {

    // Add signature
    $xml = $this->injectSignature($xml);
    foreach ($this->extensions as $ext) $xml = $ext->__onAfterSign($xml);

    // Prepend content type
    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . $xml;

    // Save document
    if (!is_null($filePath)) return file_put_contents($filePath, $xml);
    return $xml;
  }*/

}
?>
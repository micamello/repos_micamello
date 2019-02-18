<?php
require_once RUTA_INCLUDES.'facturae/KeyPairReader.php';
require_once RUTA_INCLUDES.'facturae/XmlTools.php';

class Proceso_Facturacion{
     
  protected $claveAcceso;      
  protected $secuencial;  
  protected $totalSinImpuestos;
  protected $totalDescuento = '0.00';       
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
  protected $signPolicy;
  protected $signTime;

  public $razonSocialComprador;
  public $identificacionComprador;
  public $direccionComprador; 
  public $tipoIdentifComprador;
  public $importeTotal;
  public $codigoPrincipal;
  public $descripdetalle;

  const RUC = '0993064467001';
  const TIPO_EMISION = 1;
  const VERSION = '2.1.0';
  const RAZON_SOCIAL = 'MICAMELLO S.A.';
  const NOMBRE_COMERCIAL = 'MICAMELLO S.A.';
  const DIR_MATRIZ = 'Km 12 Av. Febres Cordero Cdla. Villa Club Etapa Krypton Mz.14 Solar 3';
  const OBLIGADO_CONTABILIDAD = 'SI';  
  const ESTAB = '001';
  const PTOEMI = '001';
  const CONTRIBUYENTE_ESPECIAL = '0000';
  const PROPINA = '0.00';
  const PLAZO = 0;
  const UNIDAD_TIEMPO = 'dias';
  const AMBIENTE = array("PRUEBAS"=>1, "PRODUCCION"=>2);
  const TIPO_DOCUMENTO = array("FACTURA"=>"01");  
  const TIPO_IDENTIF_COMPRADOR = array("RUC"=>"04","CÉDULA"=>"05","PASAPORTE"=>"06");
  const CODIGO_IMPUESTO = array("IVA"=>2,"ICE"=>3,"IRBPNR"=>5);  
  const TARIFA_IVA = array("12"=>2,"14"=>3);
  const MONEDA = array(1=>'DOLAR');
  const FORMA_PAGO = array("SINFINANCIERO"=>"01","TARJETADEBITO"=>"16","TARJETACREDITO"=>"19");   

  const SIGN_POLICY_3_1 = array(
    "name" => "Política de Firma FacturaE v3.1",
    "url" => "http://www.facturae.es/politica_de_firma_formato_facturae/politica_de_firma_formato_facturae_v3_1.pdf",
    "digest" => "Ohixl6upD6av8N7pEvDABhEL6hM="
  ); 
  
  const SCHEMA_3_2 = "3.2";
  const SCHEMA_3_2_1 = "3.2.1";
  const SCHEMA_3_2_2 = "3.2.2";

  protected static $SCHEMA_NS = array(
    self::SCHEMA_3_2   => "http://www.facturae.es/Facturae/2009/v3.2/Facturae",
    self::SCHEMA_3_2_1 => "http://www.facturae.es/Facturae/2014/v3.2.1/Facturae",
    self::SCHEMA_3_2_2 => "http://www.facturae.gob.es/formato/Versiones/Facturaev3_2_2.xml"
  );

  function generarFactura(){    
    $this->importeImpuesto = number_format(round($this->importeTotal * (array_search(2, self::TARIFA_IVA)/100),2),2);
    $this->totalSinImpuestos = number_format(round($this->importeTotal - $this->importeImpuesto,2),2);
    $this->importeTotal = number_format($this->importeTotal,2);
    $this->generarClaveAcceso();
    return $this->creaXml();    
  }

  function generarClaveAcceso(){
    $seriefactura = Modelo_Parametro::obtieneValor('seriefactura');
    $numerofactura = Modelo_Parametro::obtieneValor('numerofactura')+1;
    $this->secuencial = str_pad($numerofactura,9,"0",STR_PAD_LEFT);        
    $numerico = str_pad($numerofactura,8,"0",STR_PAD_LEFT);   
    $clave = date('dmY').
             self::TIPO_DOCUMENTO["FACTURA"].
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
    $resultado = $acum / 11;
    $entero = intval($resultado);        
    $this->claveAcceso = $clave.(11 - abs((($entero - $resultado) * 11)));
  }

  function creaXml(){
    $xml = new DomDocument('1.0', 'UTF-8'); 
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
      $nodo = $root->appendChild($nodo);                   
    }
    $detalles = $xml->createElement('detalles');
    $detalles = $nodo->appendChild($detalles);
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
    
    $nodo = $root->appendChild($nodo);
    return $xml->saveXML();
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
                         "contribuyenteEspecial" => self::CONTRIBUYENTE_ESPECIAL,            
                         "obligadoContabilidad" => self::OBLIGADO_CONTABILIDAD,                                  
                         "tipoIdentificacionComprador" => self::TIPO_IDENTIF_COMPRADOR[$this->tipoIdentifComprador],                         
                         "razonSocialComprador" => $this->razonSocialComprador,
                         "identificacionComprador" => $this->identificacionComprador,
                         "direccionComprador" => $this->direccionComprador,                        
                         "totalSinImpuestos" => $this->totalSinImpuestos,
                         "totalDescuento" => $this->totalDescuento,
                         "totalImpuesto" => array($this->valoresImpuestos(self::CODIGO_IMPUESTO["IVA"],self::TARIFA_IVA["12"],$this->importeImpuesto)),
                         "propina" => self::PROPINA,
                         "importeTotal" => $this->importeTotal,
                         "moneda" => self::MONEDA[1],
                         "pagos" => array("formaPago" => self::FORMA_PAGO["SINFINANCIERO"],
                                          "total" => $this->importeTotal,
                                          "plazo" => self::PLAZO,
                                          "unidadTiempo" => self::UNIDAD_TIEMPO)
                        );    
    return $infoFactura;
  }

  function valoresDetalle(){
    $infoDetalle = array("codigoPrincipal" => $this->codigoPrincipal,
                         "codigoAuxiliar" => $this->codigoPrincipal,
                         "descripcion" => $this->descripdetalle,
                         "cantidad" => $this->cantidad,
                         "precioUnitario" => $this->totalSinImpuestos,
                         "descuento" => $this->totalDescuento,
                         "precioTotalSinImpuesto" => $this->totalSinImpuestos,
                         "impuestos" => array($this->valoresImpuestos(self::CODIGO_IMPUESTO["IVA"],self::TARIFA_IVA["12"],$this->importeImpuesto)));
    return $infoDetalle;
  }

  function valoresImpuestos($codigo,$tarifa,$valor){
    $totalConImpuestos = array("codigo" => $codigo,
                               "codigoPorcentaje" => $tarifa,
                               "baseImponible" => $this->totalSinImpuestos,
                               "valor" => $valor);
    return $totalConImpuestos;
  }

  function sign($publicPath, $privatePath=null, $passphrase="",$policy=self::SIGN_POLICY_3_1) {
    // Generate random IDs
    $tools = new XmlTools();
    $this->signatureID = $tools->randomId();
    $this->signedInfoID = $tools->randomId();
    $this->signedPropertiesID = $tools->randomId();
    $this->signatureValueID = $tools->randomId();
    $this->certificateID = $tools->randomId();
    $this->referenceID = $tools->randomId();
    $this->signatureSignedPropertiesID = $tools->randomId();
    $this->signatureObjectID = $tools->randomId();

    // Load public and private keys
    $reader = new KeyPairReader($publicPath, $privatePath, $passphrase);
    $this->publicKey = $reader->getPublicKey();
    $this->privateKey = $reader->getPrivateKey();
    $this->signPolicy = $policy;
    unset($reader);   
    // Return success
    return (!empty($this->publicKey) && !empty($this->privateKey));

  }

  function injectTimestamp($signedXml) {
    $tools = new XmlTools();

    // Prepare data to timestamp
    $payload = explode('<ds:SignatureValue', $signedXml, 2)[1];
    $payload = explode('</ds:SignatureValue>', $payload, 2)[0];
    $payload = '<ds:SignatureValue' . $payload . '</ds:SignatureValue>';
    $payload = $tools->injectNamespaces($payload, $this->getNamespaces());

    // Create TimeStampQuery in ASN1 using SHA-1
    $tsq = "302c0201013021300906052b0e03021a05000414";
    $tsq .= hash('sha1', $payload);
    $tsq .= "0201000101ff";
    $tsq = hex2bin($tsq);

    // Await TimeStampRequest
    $chOpts = array(
      CURLOPT_URL => $this->timestampServer,
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_BINARYTRANSFER => 1,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_FOLLOWLOCATION => 1,
      CURLOPT_CONNECTTIMEOUT => 0,
      CURLOPT_TIMEOUT => 10, // 10 seconds timeout
      CURLOPT_POST => 1,
      CURLOPT_POSTFIELDS => $tsq,
      CURLOPT_HTTPHEADER => array("Content-Type: application/timestamp-query"),
      CURLOPT_USERAGENT => self::USER_AGENT
    );
    if (!empty($this->timestampUser) && !empty($this->timestampPass)) {
      $chOpts[CURLOPT_USERPWD] = $this->timestampUser . ":" . $this->timestampPass;
    }
    $ch = curl_init();
    curl_setopt_array($ch, $chOpts);
    $tsr = curl_exec($ch);
    if ($tsr === false) throw new \Exception('cURL error: ' . curl_error($ch));
    curl_close($ch);

    // Validate TimeStampRequest
    $responseCode = substr($tsr, 6, 3);
    if ($responseCode !== "\02\01\00") { // Bytes for INTEGER 0 in ASN1
      throw new \Exception('Invalid TSR response code');
    }

    // Extract TimeStamp from TimeStampRequest and inject into XML document
    $tools = new XmlTools();
    $timeStamp = substr($tsr, 9);
    $timeStamp = $tools->toBase64($timeStamp, true);
    $tsXml = '<xades:UnsignedProperties Id="Signature' . $this->signatureID . '-UnsignedProperties' . $tools->randomId() . '">' .
               '<xades:UnsignedSignatureProperties>' .
                 '<xades:SignatureTimeStamp Id="Timestamp-' . $tools->randomId() . '">' .
                   '<ds:CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315">' .
                   '</ds:CanonicalizationMethod>' .
                   '<xades:EncapsulatedTimeStamp>' . "\n" . $timeStamp . '</xades:EncapsulatedTimeStamp>' .
                 '</xades:SignatureTimeStamp>' .
               '</xades:UnsignedSignatureProperties>' .
             '</xades:UnsignedProperties>';
    $signedXml = str_replace('</xades:QualifyingProperties>', $tsXml . '</xades:QualifyingProperties>', $signedXml);
    return $signedXml;
  }

  function injectSignature($xml) {
    // Make sure we have all we need to sign the document
    if (empty($this->publicKey) || empty($this->privateKey)) return $xml;
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
    $prop = '<xades:SignedProperties Id="Signature' . $this->signatureID .
            '-SignedProperties' . $this->signatureSignedPropertiesID . '">' .
              '<xades:SignedSignatureProperties>' .
                '<xades:SigningTime>' . date('c', $signTime) . '</xades:SigningTime>' .
                '<xades:SigningCertificate>' .
                  '<xades:Cert>' .
                    '<xades:CertDigest>' .
                      '<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod>' .
                      '<ds:DigestValue>' . $tools->getCertDigest($this->publicKey) . '</ds:DigestValue>' .
                    '</xades:CertDigest>' .
                    '<xades:IssuerSerial>' .
                      '<ds:X509IssuerName>' . $certIssuer . '</ds:X509IssuerName>' .
                      '<ds:X509SerialNumber>' . $certData['serialNumber'] . '</ds:X509SerialNumber>' .
                    '</xades:IssuerSerial>' .
                  '</xades:Cert>' .
                '</xades:SigningCertificate>' .
                '<xades:SignaturePolicyIdentifier>' .
                  '<xades:SignaturePolicyId>' .
                    '<xades:SigPolicyId>' .
                      '<xades:Identifier>' . $this->signPolicy['url'] . '</xades:Identifier>' .
                      '<xades:Description>' . $this->signPolicy['name'] . '</xades:Description>' .
                    '</xades:SigPolicyId>' .
                    '<xades:SigPolicyHash>' .
                      '<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod>' .
                      '<ds:DigestValue>' . $this->signPolicy['digest'] . '</ds:DigestValue>' .
                    '</xades:SigPolicyHash>' .
                  '</xades:SignaturePolicyId>' .
                '</xades:SignaturePolicyIdentifier>' .
                '<xades:SignerRole>' .
                  '<xades:ClaimedRoles>' .
                    '<xades:ClaimedRole>emisor</xades:ClaimedRole>' .
                  '</xades:ClaimedRoles>' .
                '</xades:SignerRole>' .
              '</xades:SignedSignatureProperties>' .
              '<xades:SignedDataObjectProperties>' .
                '<xades:DataObjectFormat ObjectReference="#Reference-ID-' . $this->referenceID . '">' .
                  '<xades:Description>Factura electrónica</xades:Description>' .
                  '<xades:MimeType>text/xml</xades:MimeType>' .
                '</xades:DataObjectFormat>' .
              '</xades:SignedDataObjectProperties>' .
            '</xades:SignedProperties>';

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
               '<ds:Reference Id="Reference-ID-' . $this->referenceID . '" URI="">' . "\n" .
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
    $sig = '<ds:Signature xmlns:xades="http://uri.etsi.org/01903/v1.3.2#" Id="Signature' . $this->signatureID . '">' . "\n" .
             $sInfo . "\n" .
             '<ds:SignatureValue Id="SignatureValue' . $this->signatureValueID . '">' . "\n" .
               $signatureResult .
             '</ds:SignatureValue>' . "\n" .
             $kInfo . "\n" .
             '<ds:Object Id="Signature' . $this->signatureID . '-Object' . $this->signatureObjectID . '">' .
               '<xades:QualifyingProperties Target="#Signature' . $this->signatureID . '">' .
                 $prop .
               '</xades:QualifyingProperties>' .
             '</ds:Object>' .
           '</ds:Signature>';

    // Inject signature
    //$xml = str_replace('</fe:Facturae>', $sig . '</fe:Facturae>', $xml);
    $xml = str_replace('</factura>', $sig . '</factura>', $xml);    

    // Inject timestamp
    if (!empty($this->timestampServer)) $xml = $this->injectTimestamp($xml);

    return $xml;
  }

  function getNamespaces() {
    $xmlns = array();
    $xmlns[] = 'xmlns:ds="http://www.w3.org/2000/09/xmldsig#"';
    $xmlns[] = 'xmlns:fe="' . self::$SCHEMA_NS[self::SCHEMA_3_2_1] . '"';
    $xmlns[] = 'xmlns:xades="http://uri.etsi.org/01903/v1.3.2#"';
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
<?php
require_once RUTA_INCLUDES.'factura/FacturaeExportable.php';

class Proceso_Facturacion{
     
  protected $claveAcceso;      
  protected $secuencial;  
  protected $totalSinImpuestos;
  protected $totalDescuento = '0';       
  protected $cantidad = 1;
  protected $importeImpuesto;
  protected $strxml = '';

  public $razonSocialComprador;
  public $identificacionComprador;
  public $direccionComprador; 
  public $telefComprador;
  public $emailComprador;
  public $tipoIdentifComprador;
  public $importeTotal;
  public $codigoPrincipal;
  public $descripdetalle;

  const KEY_PUBLIC = RUTA_INCLUDES."factura/firmadigital/public.pem";
  const KEY_PRIVATE = RUTA_INCLUDES."factura/firmadigital/private.pem";
  const KEY_PASSWORD = "Amor2018";
  const RUC = '0993064467001';
  const TIPO_EMISION = 1;
  const VERSION = '1.0.0';
  const RAZON_SOCIAL = 'MICAMELLO S.A.';
  const NOMBRE_COMERCIAL = 'MICAMELLO S.A.';
  const DIR_MATRIZ = 'Km 12 Av. Febres Cordero Cdla. Villa Club Etapa Krypton Mz.14 Solar 3';
  const OBLIGADO_CONTABILIDAD = 'SI';  
  const ESTAB = '001';
  const PTOEMI = '001';  
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

  function generarFactura(){    
    $this->importeImpuesto = number_format(round($this->importeTotal * (array_search(2, self::TARIFA_IVA)/100),2),2);
    $this->totalSinImpuestos = number_format(round($this->importeTotal - $this->importeImpuesto,2),2);
    $this->importeTotal = number_format($this->importeTotal,2);
    $this->generarClaveAcceso();
    $this->creaXml();   
    return $this->sign(); 
  }

  function generarClaveAcceso(){
    $seriefactura = Modelo_Parametro::obtieneValor('seriefactura');
    $numerofactura = Modelo_Parametro::obtieneValor('numerofactura')+1;
    $this->secuencial = str_pad($numerofactura,9,"0",STR_PAD_LEFT);        
    $numerico = "12345678";   
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
    $this->strxml = '<factura id="comprobante" version="'.self::VERSION.'">' . "\n" .
                    '  <infoTributaria>'. "\n";
    $infoTributaria = $this->valoresInfoTributaria();
    foreach($infoTributaria as $atributo=>$valor){
      $this->strxml .= '    <'.$atributo.'>'.$valor.'</'.$atributo.'>'. "\n";
    }
    $this->strxml .= '  </infoTributaria>'. "\n" .
                     '  <infoFactura>'. "\n";
    $infoFactura = $this->valoresinfoFactura(); 
    foreach($infoFactura as $atributo=>$valor){
      if ($atributo == "totalImpuesto"){
        $this->strxml .= '    <totalConImpuestos>'. "\n";
        foreach($valor as $vlimpuesto){
          $this->strxml .= '      <totalImpuesto>'. "\n";
          foreach($vlimpuesto as $keyimp=>$impuesto){      
            $this->strxml .= '        <'.$keyimp.'>'.$impuesto.'</'.$keyimp.'>'. "\n";
          }
          $this->strxml .= '      </totalImpuesto>'. "\n";
        }
        $this->strxml .= '    </totalConImpuestos>'. "\n";
      }
      elseif($atributo == "pagos"){
        $this->strxml .= '    <pagos>'. "\n" .
                         '      <pago>'. "\n";
        foreach($valor as $keypago=>$vlpago){
          $this->strxml .= '        <'.$keypago.'>'.$vlpago.'</'.$keypago.'>'. "\n";
        }
        $this->strxml .= '      </pago>'. "\n" .
                         '    </pagos>'. "\n";
      }
      else{     
        $this->strxml .= '    <'.$atributo.'>'.$valor.'</'.$atributo.'>'. "\n";
      }
    } 
    $this->strxml .= '  </infoFactura>'. "\n" .
                     '  <detalles>'. "\n" .
                     '    <detalle>'. "\n";
    $infodetalle = $this->valoresDetalle();
    foreach($infodetalle as $keydet=>$vldetalle){
      if ($keydet == "impuestos"){
        $this->strxml .= '      <impuestos>'. "\n";
        foreach($vldetalle as $vlimpuesto){
          $this->strxml .= '        <impuesto>'. "\n";
          foreach($vlimpuesto as $keyimp=>$valorimpuesto){
            $this->strxml .= '          <'.$keyimp.'>'.$valorimpuesto.'</'.$keyimp.'>'. "\n";                        
          }
          $this->strxml .= '        </impuesto>'. "\n";                       
        }
        $this->strxml .= '      </impuestos>'. "\n";
      }
      else{        
        $this->strxml .= '      <'.$keydet.'>'.$vldetalle.'</'.$keydet.'>'. "\n";
      }      
    }
    $this->strxml .= '    </detalle>'. "\n" .
                     '  </detalles>'. "\n" .
                     '  <infoAdicional>' ."\n";
    $infoAdicional = $this->valoresinfoAdicional();
    foreach($infoAdicional as $keyadc=>$vladicional){
      $this->strxml .= '    <campoAdicional nombre="'.$keyadc.'">'.$vladicional.'</campoAdicional>'. "\n";     
    }
    $this->strxml .= '  </infoAdicional>'. "\n" .
                     '</factura>';    
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
                         "obligadoContabilidad" => self::OBLIGADO_CONTABILIDAD,                                  
                         "tipoIdentificacionComprador" => self::TIPO_IDENTIF_COMPRADOR[$this->tipoIdentifComprador],                         
                         "razonSocialComprador" => $this->razonSocialComprador,
                         "identificacionComprador" => $this->identificacionComprador,
                         "direccionComprador" => $this->direccionComprador,                        
                         "totalSinImpuestos" => $this->totalSinImpuestos,
                         "totalDescuento" => $this->totalDescuento,
                         "totalImpuesto" => array($this->valoresImpuestos(self::CODIGO_IMPUESTO["IVA"],self::TARIFA_IVA["12"],$this->importeImpuesto,1)),
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
                         "descripcion" => $this->descripdetalle,
                         "cantidad" => $this->cantidad,
                         "precioUnitario" => $this->totalSinImpuestos,
                         "descuento" => $this->totalDescuento,
                         "precioTotalSinImpuesto" => $this->totalSinImpuestos,
                         "impuestos" => array($this->valoresImpuestos(self::CODIGO_IMPUESTO["IVA"],self::TARIFA_IVA["12"],$this->importeImpuesto,2)));
    return $infoDetalle;
  }

  function valoresImpuestos($codigo,$tarifa,$valor,$tipoImp){
    $totalConImpuestos = array("codigo" => $codigo,
                               "codigoPorcentaje" => $tarifa);
    if($tipoImp == 2){
      $totalConImpuestos["tarifa"] = array_search(2, self::TARIFA_IVA);
      $totalConImpuestos["baseImponible"] = $this->totalSinImpuestos; 
    }
    else{
      $totalConImpuestos["baseImponible"] = $this->totalSinImpuestos; 
      $totalConImpuestos["tarifa"] = array_search(2, self::TARIFA_IVA);      
    }
    $totalConImpuestos["valor"] = $valor;                                                                                         
    return $totalConImpuestos;
  }

  function valoresinfoAdicional(){
    $infoAdicional = array("Dirección" => $this->direccionComprador,
                           "Teléfono" => $this->telefComprador,
                           "Email" => $this->emailComprador);
    return $infoAdicional;
  }

  function sign(){    
    $fac = new FacturaeExportable();
    $fac->sign(self::KEY_PUBLIC,self::KEY_PRIVATE,self::KEY_PASSWORD);
    $xmlfirmado = $fac->export($this->strxml);
    return $xmlfirmado;
  }

}
?>
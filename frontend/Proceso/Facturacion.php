<?php
require_once RUTA_INCLUDES.'factura/FacturaeExportable.php';

class Proceso_Facturacion{
     
  protected $claveAcceso;      
  protected $secuencial;  
  protected $totalSinImpuestos;
  protected $totalDescuento = '0';       
  protected $cantidad = 1;
  protected $importeImpuesto;
  protected $numerico = '12345678';
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
  public $numerofactura;

  const KEY_PUBLIC = RUTA_INCLUDES."factura/firmadigital/public.pem";
  const KEY_PRIVATE = RUTA_INCLUDES."factura/firmadigital/private.pem";
  const RUTA_FACTURA = FRONTEND_RUTA."/imagenes/usuarios/facturas/";
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
  const DES_FORMA_PAGO = array("01"=>"SIN UTILIZACION DEL SISTEMA FINANCIERO",
                               "15"=>"COMPENSACIÓN DE DEUDAS", 
                               "16"=>"TARJETA DE DÉBITO", 
                               "17"=>"DINERO ELECTRÓNICO", 
                               "18"=>"TARJETA PREPAGO", 
                               "19"=>"TARJETA DE CRÉDITO", 
                               "20"=>"OTROS CON UTILIZACION DEL SISTEMA FINANCIERO", 
                               "21"=>"ENDOSO DE TÍTULOS"); 

  function generarFactura(){    
    $this->importeImpuesto = number_format(round($this->importeTotal * (array_search(2, self::TARIFA_IVA)/100),2),2);
    $this->totalSinImpuestos = number_format(round($this->importeTotal - $this->importeImpuesto,2),2);
    $this->importeTotal = number_format($this->importeTotal,2);
    $this->generarClaveAcceso();
    $this->creaXml();   
    $this->sign(); 
    return array("claveacceso"=>$this->claveAcceso,"xml"=>$this->strxml);
  }

  function generarClaveAcceso(){
    $seriefactura = Modelo_Parametro::obtieneValor('seriefactura');
    if (empty($this->numerofactura)){
      $this->numerofactura = Modelo_Parametro::obtieneValor('numerofactura')+1;
    }    
    $this->secuencial = str_pad($this->numerofactura,9,"0",STR_PAD_LEFT);        
    //$numerico = "12345678";   
    $clave = date('dmY').
             self::TIPO_DOCUMENTO["FACTURA"].
             self::RUC.
             self::AMBIENTE["PRUEBAS"].
             $seriefactura.
             $this->secuencial.
             $this->numerico.
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
    $this->strxml = $fac->export($this->strxml);    
  }

  function sendRecepcion($xml,$claveAcceso){    
    $params = array("xml" => $xml);
    $options = array("uri"=> WS_SRI_RECEPCION,"trace" => true,"encoding" => "UTF-8");
    $soap = new SoapClient(WS_SRI_RECEPCION, $options);
    $result = $soap->validarComprobante($params);     
    $msgerror = print_r($result,true);    
    $valoresact = array();
    $valoresact["fecha_estado"] = date('Y-m-d H:i:s');
    if (is_object($result) && $result->RespuestaRecepcionComprobante->estado == "RECIBIDA"){
      $valoresact["estado"] = Modelo_Factura::RECIBIDO;            
      $return = true;
    }
    else{
      $valoresact["estado"] = Modelo_Factura::DEVUELTO;
      $valoresact["msg_error"] = $msgerror;            
      $return = false;
    }    
    Modelo_Factura::actualizar($claveAcceso,$valoresact);
    return $return;
  }

  function sendAutorizacion($claveAcceso){    
    $options = array("uri"=> WS_SRI_AUTORIZACION,"trace" => true,"encoding" => "UTF-8");
    $soap = new SoapClient(WS_SRI_AUTORIZACION, $options);
    $params = array("claveAccesoComprobante" => $claveAcceso);
    $result = $soap->autorizacionComprobante($params);     
    $msgerror = print_r($result,true);    
    $valoresact = array();    
    if (is_object($result) && $result->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->estado == "AUTORIZADO"){
      $valoresact["estado"] = Modelo_Factura::AUTORIZADO;
      $fechaautorizacion = str_replace('T', ' ', substr($result->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->fechaAutorizacion,0,18));
      $valoresact["fecha_estado"] = $fechaautorizacion;      
      $return = $fechaautorizacion;
    }
    else{
      $valoresact["estado"] = Modelo_Factura::NOAUTORIZADO;
      $valoresact["fecha_estado"] = date('Y-m-d H:i:s');      
      $return = false;
    }   
    Modelo_Factura::actualizar($claveAcceso,$valoresact);
    return $return;   
  }

  function generarRIDE($xml,$fecha_auto){
    if (empty($xml)){ return false; }     
    $tipo_emision = array(1=>"NORMAL");   
    $factura = simplexml_load_string($xml);    
    $infoTributaria = $factura->infoTributaria;
    $infoFactura = $factura->infoFactura;
    $detalles = $factura->detalles;
    $infoAdicional = $factura->infoAdicional;

    $obj_generar = new GenerarBarcode((string)$infoTributaria->claveAcceso,FRONTEND_RUTA.'/imagenes/imagenesCod/');
    $obj_generar->imprimirbarcode();
    //header('Content-Type: text/html');
    //ob_flush();

    $mpdf=new mPDF('','A4','','',3,3,3,3,6,3); 

    $logo = "<img src='".FRONTEND_RUTA."/imagenes/logo.png' alt='Mi Camello Logo' height='150'>";
    $eslogan = "Eficiencia, innovación y transparencia";

    $style1 = ' style="padding: 5px 5px 5px 5px;" ';
    $abrir_interlineado = '<tr><td colspan="2" style="height:';
    $cerrar_interlineado = 'px;"></td></tr>';

    $contenido .= "<table width='1000' style='font-size: 18px; border-spacing: 5px;'>";
    $contenido .= "<tr>";
    $contenido .= "<td width='500' style='text-align:center;'>";
    $contenido .= "<br>".$logo."<br><span atyle='text-align:center;color: #0d0d13;font-size: 10px;'>".$eslogan."<span>";
    $contenido .= "</td>";
    $contenido .= "<td rowspan='2' width='600' style=''>";
    $contenido .= '<table width="600" style="border: 1px solid #000;text-align:left;padding-top: 20px;padding-left: 15px;padding-right: 15px;">
                    <tr>
                      <td colspan="2"><h1><b>R.U.C.:</b> '.$infoTributaria->ruc.'</h1></td>
                    </tr>'
                    .$abrir_interlineado.'10'.$cerrar_interlineado.
                    '<tr>
                      <td colspan="2"><b><h1>'.$tipo_documento[(string)$infoTributaria->codDoc].'</h1></b></td>
                    </tr>
                    <tr>
                      <td colspan="2" style="color:red;"><h2><b>No. '.$infoTributaria->estab.'-'.$infoTributaria->ptoEmi.'-'.$infoTributaria->secuencial.'</b></h2></td>
                    </tr>'
                    .$abrir_interlineado.'10'.$cerrar_interlineado.
                    '<tr>
                      <td colspan="2"><b>NÚMERO DE AUTORIZACIÓN</b></td>
                    </tr>
                    <tr>
                      <td colspan="2">'.$infoTributaria->claveAcceso.'</td>
                    </tr>'
                    .$abrir_interlineado.'30'.$cerrar_interlineado.
                    '<tr>
                      <td width="200"><b>FECHA Y HORA DE AUTORIZACIÓN:</b></td>
                      <td>'.$fecha_auto.'</td>
                    </tr>'
                    .$abrir_interlineado.'10'.$cerrar_interlineado.
                    '<tr>
                      <td width="200"><b>AMBIENTE:</b></td>
                      <td>'.str_replace("?", "Ó", array_search($infoTributaria->ambiente, self::AMBIENTE)).'</td>
                    </tr>'
                    .$abrir_interlineado.'10'.$cerrar_interlineado.
                    '<tr>
                      <td width="200"><b>EMISIÓN:</b></td>
                      <td>'.$tipo_emision[(string)$infoTributaria->tipoEmision].'</td>
                    </tr>'
                    .$abrir_interlineado.'10'.$cerrar_interlineado.
                    '<tr>
                      <td><b>CLAVE DE ACCESO:</b></td>
                    </tr>
                    <tr>
                     <td colspan="2"><img style="width: 560px; height: 90px;" alt="codigo de barra" src="'.FRONTEND_RUTA.'/imagenes/imagenesCod/'.(string)$infoTributaria->claveAcceso.'.png'.'" /></td>
                    </tr>
                    <tr>
                      <td colspan="2" style="text-align:center;">'.(string)$infoTributaria->claveAcceso.'</td>
                    </tr>'
                    .$abrir_interlineado.'10'.$cerrar_interlineado.
                    '</table>';
    $contenido .= "</td>";
    $contenido .= "</tr>";
    $contenido .= "<tr>";
    $contenido .= "<td width='400'>";
    $contenido .= '<table style="border: 1px solid #000; text-align:left; padding: 15px 20px 15px 15px;">
                      <tr><td style="padding-left: 15px; padding-right: 5px;" colspan="2"><h2><b>'.$infoTributaria->razonSocial.'</b></h2></td>
                      </tr>'
                      .$abrir_interlineado.'15'.$cerrar_interlineado.
                      '<tr><td style="padding-right: 5px;"><b>Dirección Matriz:</b></td><td width="500" style="padding-right: 15px;">'.$infoTributaria->dirMatriz.'</td>
                      </tr>'
                      .$abrir_interlineado.'15'.$cerrar_interlineado.
                      '<tr><td colspan="2" style=""><b>OBLIGADO A LLEVAR CONTABILIDAD:</b>&nbsp;&nbsp;&nbsp;&nbsp;'.$infoFactura->obligadoContabilidad.'</td>
                      </tr>
                    </table>
                    ';
    $contenido .= "</td>";
    $contenido .= "</tr>"; 
    $contenido .= "<tr>";
    $contenido .= "<td colspan='2'>";
    $contenido .= '<table width="1000" style="border: 1px solid #000;padding: 10px 10px 10px 10px;" >
                    <tr>
                      <td '.$style1.'><b>Razón Social / Nombres y Apellidos: </b></td>
                      <td '.$style1.'>'.strtoupper($infoFactura->razonSocialComprador).'</td>
                      <td '.$style1.'><b>RUC / CI: </b></td>
                      <td '.$style1.'>'.$infoFactura->identificacionComprador.'</td>
                    </tr>
                    <tr>
                      <td '.$style1.'><b>Fecha de Emisión: </b></td>
                      <td '.$style1.'>'.$infoFactura->fechaEmision.'</td>
                      <td '.$style1.'><b>Guía de Remisión: </b></td>
                      <td '.$style1.'></td>
                    </tr>
                </table>';
    $contenido .= "</td>";
    $contenido .= "</tr>"; 
    $contenido .= "<tr>";
    $contenido .= "<td colspan='2'>";
    $contenido .= '<table width="1000" border="1" style="text-align:center; border-collapse: collapse;" >
                      <tr>
                        <td width="10"><b>Cod. Principal</b></td>
                        <td width="10"><b>Cant.</b></td>
                        <td width="950"><b>Descripción</b></td>
                        <td width="10"><b>Precio Unitario</b></td>
                        <td width="10"><b>Descuento</b></td>
                        <td width="10"><b>Precio ToTal</b></td>
                      </tr>';
    foreach ($detalles->detalle as $detalle) {

      $contenido .= '<tr>
        <td '.$style1.' align="right">'.$detalle->codigoPrincipal.'</td>
        <td '.$style1.' align="right">'.$detalle->cantidad.'</td>
        <td '.$style1.' >'.$detalle->descripcion.'</td>
        <td '.$style1.' align="right">'.number_format((float)$detalle->precioUnitario, 2, '.', ',').'</td>
        <td '.$style1.' align="right">'.number_format((float)$detalle->descuento, 2, '.', ',').'</td>
        <td '.$style1.' align="right">'.number_format((float)$detalle->precioTotalSinImpuesto, 2, '.', ',').'</td>
      </tr>';
    }
    $contenido .= '</table>';
    $contenido .= "</td>";
    $contenido .= "</tr>"; 
    $contenido .= "<tr>";
    $contenido .= "<td>";
    $contenido .= '<table width="500" style="border: 1px solid #000; padding-top: 20px;padding-left: 15px;padding-bottom: 15px;padding-right: 15px;">
                      <tr><td align="center" style="padding-left: 15px; padding-right: 5px;" colspan="2"><b>Información Adicional</b></td></tr>';

    foreach ($infoAdicional->campoAdicional as $nodo) 
    {
      $atributos = $nodo->attributes();
      $contenido .= '<tr><td colspan="2" style="height: 15px;"></td></tr>
                    <tr><td style="padding-right: 5px;"><b>'.$atributos->nombre.'</b></td><td width="500" style="padding-right: 15px;">'.$nodo[0].'</td>
                    </tr>';
    }
    $contenido .= '</table>
                  <br>
                  <table width="500" border="1" style="text-align:center; border-collapse: collapse;">
                      <tr>
                        <td '.$style1.' align="center"><b>Forma de Pago</b></td>
                        <td '.$style1.' align="center"><b>Valor</b></td>
                      </tr>
                      <tr>
                        <td '.$style1.' align="center">'.self::DES_FORMA_PAGO[(string)$infoFactura->pagos->pago->formaPago].'</td>
                        <td '.$style1.' align="center">'.$infoFactura->pagos->pago->total.'</td>
                      </tr>
                  </table>
                  ';
    $contenido .= "</td>";
    $contenido .= "<td valign='top' align='right'>";

    $contenido .= '<table width="500" border="1" style="text-align:center; border-collapse: collapse;">
                          <tr>
                            <td '.$style1.' colspan="2" align="left"><b>SUBTOTAL 12%</b></td>
                            <td '.$style1.' align="right">'.$infoFactura->totalConImpuestos->totalImpuesto->baseImponible.'</td>
                          </tr>
                          <tr>
                            <td '.$style1.' colspan="2" align="left"><b>SUBTOTAL 0%</b></td>
                            <td '.$style1.' align="right">0.00</td>
                          </tr>
                          <tr>
                            <td '.$style1.' colspan="2" align="left"><b>SUBTOTAL no objeto de IVA</b></td>
                            <td '.$style1.' align="right">0.00</td>
                          </tr>
                          <tr>
                            <td '.$style1.' colspan="2" align="left"><b>SUBTOTAL exento de IVA</b></td>
                            <td '.$style1.' align="right">0.00</td>
                          </tr>
                          <tr>
                            <td '.$style1.' colspan="2" align="left"><b>SUBTOTAL SIN IMPUESTOS</b></td>
                            <td '.$style1.' align="right">'.$infoFactura->totalSinImpuestos.'</td>
                          </tr>
                          <tr>
                            <td '.$style1.' colspan="2" align="left"><b>TOTAL DESCUENTO</b></td>
                            <td '.$style1.' align="right">'.$infoFactura->totalDescuento.'</td>
                          </tr>
                          <tr>
                            <td '.$style1.' colspan="2" align="left"><b>ICE</b></td>
                            <td '.$style1.' align="right">0.00</td>
                          </tr>
                          <tr>
                            <td '.$style1.' colspan="2" align="left"><b>IVA '.$infoFactura->totalConImpuestos->totalImpuesto->tarifa.'%</b></td>
                            <td '.$style1.' align="right">'.$infoFactura->totalConImpuestos->totalImpuesto->valor.'</td>
                          </tr>
                          <tr>
                            <td '.$style1.' colspan="2" align="left"><b>IRBPNR</b></td>
                            <td '.$style1.' align="right">0.00</td>
                          </tr>
                          <tr>
                            <td '.$style1.' colspan="2" align="left"><b>PROPINA</b></td>
                            <td '.$style1.' align="right">'.$infoFactura->propina.'</td>
                          </tr>
                          <tr>
                            <td '.$style1.' colspan="2" align="left"><b>VALOR TOTAL</b></td>
                            <td '.$style1.' align="right">'.$infoFactura->importeTotal.'</td>
                          </tr>
                      </table>';
    $contenido .= "</td>";
    $contenido .= "</tr>";                            
    $contenido .= "</table>";

    $mpdf->setHTMLFooter('<footer align="center" style="font-size:10px; color:#5d5858;">Provincia: Guayas Cantón: DAULE Parroquia LA AURORA (SATÉLITE) <br>km. 12 Av. Febres Cordero Cdla. Villa Club etapa Krypton Mz. 14 Solar 3 (a cuatro cuadras de la garita). <br>Teléfono: 2753106 Celular: 099234268. E-mail: infor@micamello.com.ec</footer>');

    $mpdf->WriteHTML($contenido);

    unlink(FRONTEND_RUTA.'/imagenes/imagenesCod/'.$infoTributaria->claveAcceso.'.png');
    //echo $contenido;
    $mpdf->Output(self::RUTA_FACTURA.$infoTributaria->claveAcceso.".pdf", 'F');
  }

  function generarXML($xml,$claveacceso){
    Utils::crearArchivo(self::RUTA_FACTURA,$claveacceso.".xml",$xml);
  }
}
?>
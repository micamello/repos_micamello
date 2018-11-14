<?php
class Proceso_Facturacion{

	protected $dia;
  protected $mes;
  protected $anio;
  protected $tipoComprobante;
  protected $ruc;
  protected $ambiente;
  protected $serie;
  protected $nroFactura;
  protected $secuencial;
  protected $tipoEmision;
  protected $digitoVerificador;

  const FACTURA = '01';
  const NOTACREDITO = '04';
  const NOTADEBITO = '05';
  const GUIAREMISION = '06';
  const COMPRETENCION = '07';
  const RUC = '0993064467001';
  const AMB_PRUEBAS = 1;
  const AMB_PRODUCCION = 2;

  function __construct(){        
    $this->dia = date('dd');
    $this->mes = date('mm');    
    $this->anio = date('YY');
    $this->tipoComprobante = self::FACTURA; 
    $this->ruc = self::RUC;
    $this->ambiente = self::AMB_PRUEBAS;
  }

}
?>
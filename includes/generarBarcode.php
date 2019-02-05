<?php
require_once('barcode/BCGFontFile.php');
require_once('barcode/BCGColor.php');
require_once('barcode/BCGDrawing.php');
require_once('barcode/BCGcode128.barcode.php');

class GenerarBarcode{

   var $clave = '';
   var $url = '';

   function __construct($clave,$url){
     $this->clave = $clave;
     $this->url = $url;
    }

   function imprimirbarcode(){

   	header('Content-Type: image/png');
	$claveAcceso = $this->clave;
	$claveUrl = $this->url;

	$colorFront = new BCGColor(0, 0, 0);
	$colorBack = new BCGColor(255, 255, 255);

	$code = new BCGcode128();
	$code->setScale(4);
	$code->setThickness(30);
	$code->setForegroundColor($colorFront);
	$code->setBackgroundColor($colorBack);
	$code->parse($claveAcceso);

	$drawing = new BCGDrawing($claveUrl.'/'.$claveAcceso.'.png', $colorBack);
	$drawing->setBarcode($code);

	$drawing->draw();
	$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
  }
}
?>
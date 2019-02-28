<?php 
require_once('barcode/BCGFontFile.php');
require_once('barcode/BCGColor.php');
require_once('barcode/BCGDrawing.php');
require_once('barcode/BCGcode128.barcode.php');
header('Content-Type: image/png');

$colorFront = new BCGColor(0, 0, 0);
$colorBack = new BCGColor(255, 255, 255);

$code = new BCGcode128();
$code->setScale(4);
$code->setThickness(30);
$code->setForegroundColor($colorFront);
$code->setBackgroundColor($colorBack);
$code->parse('2101201901099306446700110010010000000401234567811');

$drawing = new BCGDrawing('../includes/imagenes/imagenesCod/2101201901099306446700110010010000000401234567811.png', $colorBack);
$drawing->setBarcode($code);

$drawing->draw();
$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);

?>
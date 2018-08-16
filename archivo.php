<?php
require_once 'constantes.php';
require_once 'init.php';

$carpeta = Utils::getParam('carpeta','',$_GET);
$archivo = Utils::getParam('archivo','',$_GET);
$mostrar = false;

switch ($carpeta){
	case 'profile':
	  $extension = 'image/jpeg';
	  $directorio = 
	  $mostrar = true;
	break;
}

if ($mostrar){
  header("Pragma: no-cache"); 
	header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0"); 
	header("Expires: 0"); 
	header("Content-type: ".$extension); 
	header("Content-Disposition: inline; filename=".$archivo); 
	//header("Content-Length: $size"); 
	readfile(USER_DIR.CURRENT_DIR . '/' .$archivo); 
}   
exit;
?>
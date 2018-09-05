<?php
require_once 'constantes.php';
require_once 'init.php';

$carpeta = Utils::getParam('carpeta','',$_GET);
$archivo = Utils::getParam('archivo','',$_GET);

if (empty($carpeta) || empty($archivo)){
 exit; 
}

if(!Modelo_Usuario::estaLogueado()){
  exit;
}

$idusuario = strstr($archivo, '.', true);
$ext = strstr($archivo, '.');
if (empty($idusuario)){
	exit;
}

if ($_SESSION['mfo_datos']['usuario']['tipo_usuario']==Modelo_Usuario::CANDIDATO && 
	  Utils::getArrayParam('id_usuario',$_SESSION['mfo_datos']['usuario']) != $idusuario){
  exit;
}

$mostrar = false;

switch ($carpeta){
	case 'profile':
	  $extension = 'image/jpeg';
	  $ruta = PATH_PROFILE.$archivo;
	  $resultado = file_get_contents(PUERTO.'://'.HOST.'/imagenes/usuarios/profile/'.$archivo);	  
	  if (!$resultado){
	  	$ruta = PUERTO.'://'.HOST.'/imagenes/user.png';
	  }	  
	  $mostrar = true;
	break;
	case 'hv':
		if($ext == '.pdf'){
		  $extension = 'application/pdf';
		}else{
			$extension = 'application/msword';
		}
		$ruta = PATH_ARCHIVO.$archivo;
		$resultado = file_get_contents(PUERTO.'://'.HOST.'/imagenes/usuarios/profile/'.$archivo);	  
		$mostrar = (!$resultado) ? false : true;		
	break;
}

if ($mostrar){
  header("Pragma: no-cache"); 
	header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0"); 
	header("Expires: 0"); 
	header("Content-type: ".$extension); 
	header("Content-Disposition: inline; filename=".$archivo); 
	readfile($ruta); 
}   
exit;
?>
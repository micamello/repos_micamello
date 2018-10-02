<?php
require_once 'constantes.php';
require_once 'init.php';
$carpeta = Utils::getParam('carpeta','',$_GET);
$archivo = Utils::getParam('archivo','',$_GET);
$param1 = Utils::getParam('param1','',$_GET);
$param2 = Utils::getParam('param2','',$_GET);
if (empty($carpeta) && (empty($archivo) || empty($param2) || empty($param1))){
   exit; 
}
if(!Modelo_Usuario::estaLogueado()){
  exit;
}
if(!empty($archivo)){
	$idusuario = strstr($archivo, '.', true);
	$ext = strstr($archivo, '.');
	if (empty($idusuario)){
		exit;
	}
}
if(!empty($param1) && !empty($param2)){
	$archivo = Modelo_Usuario::existeUsuario($param1);
	if(!empty($archivo)){
		$idusuario = $archivo["id_usuario"]; 
		$ext = '.'.$param2;
		$archivo = $idusuario.$ext;
	}
}

if ($_SESSION['mfo_datos']['usuario']['tipo_usuario']==Modelo_Usuario::CANDIDATO && 
	  Utils::getArrayParam('id_usuario',$_SESSION['mfo_datos']['usuario']) != $idusuario){
	$infoUsuario = Modelo_Usuario::busquedaPorId($idusuario);  
  if (empty($infoUsuario) || !isset($infoUsuario["id_usuario"]) || $infoUsuario["tipo_usuario"] == Modelo_Usuario::CANDIDATO){
  	exit;
  }
}
$mostrar = false;
switch ($carpeta){
	case 'profile':
	  $extension = 'image/jpeg';
	  $ruta = PATH_PROFILE.$archivo;
	  $resultado = file_exists($ruta);	  
	  if (!$resultado){
	  	$ruta = FRONTEND_RUTA.'/imagenes/user.png';
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
		$resultado = file_exists($ruta);	  
		$mostrar = (!$resultado) ? false : true;		
	break;
}

if(!empty($param1) && !empty($param2) && $mostrar && $_SESSION['mfo_datos']['usuario']['tipo_usuario']==Modelo_Usuario::EMPRESA){

	$posibilidades = Modelo_UsuarioxPlan::disponibilidadDescarga($_SESSION['mfo_datos']['usuario']['id_usuario']);
	$descargas = Modelo_Descarga::cantidadDescarga($_SESSION['mfo_datos']['usuario']['id_usuario']);

	$infoHv = Modelo_InfoHv::obtieneHv($idusuario);	

	if(in_array('-1',$posibilidades) ){
		Modelo_Descarga::registrarDescarga($infoHv[0]['id_infohv'],$idusuario);
	}else{
		$cantidadRestante = array_sum($posibilidades) - $descargas['cantd_descarga'];
		if($cantidadRestante > 0){
			Modelo_Descarga::registrarDescarga($infoHv[0]['id_infohv'],$idusuario);
		}else{
			$mostrar = false;
		}
	}
}

if ($mostrar){	
  header("Pragma: no-cache"); 
  header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0"); 
  header("Expires: 0"); 
  header("Content-type: ".$extension); 
  header("Content-Disposition: inline; filename=".$archivo); 
  readfile($ruta); 	
}   
else{

	if(isset($cantidadRestante) && $cantidadRestante == 0){
		$_SESSION['mostrar_error'] = 'Ya agoto su cupón de descargas';
	}else{
		$_SESSION['mostrar_error'] = 'Archivo no encontrado';
	}
	$enlace = PUERTO.'://'.HOST.'/verAspirantes/2/0/1/';
	header('Location: '.$enlace);
}
exit;
?>
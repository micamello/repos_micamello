<?php
require_once 'constantes.php';
require_once 'init.php';
include 'multisitios.php';

$carpeta = Utils::getParam('carpeta','',$_GET);
$param1 = Utils::getParam('param1','',$_GET); //username
$param2 = Utils::desencriptar(Utils::getParam('param2','',$_GET)); //idoferta


if (empty($carpeta) || empty($param1)){
   exit; 
}

if(!Modelo_Usuario::estaLogueado()){
  exit;
}

if(!empty($param1) && !empty($carpeta)){
	$usuario = Modelo_Usuario::existeUsuario($param1);
	if (empty($usuario)){
		exit;
	}
	else{
		$archivo = $usuario["username"];
	}
}

//si es candidato no puede ver imagenes/hojas de vida de otros candidatos
if ($_SESSION['mfo_datos']['usuario']['tipo_usuario']==Modelo_Usuario::CANDIDATO && 
	  $_SESSION['mfo_datos']['usuario']['username'] != $usuario["username"] && $usuario["tipo_usuario"]==Modelo_Usuario::CANDIDATO){	
  exit;
}

$mostrar = false;
switch ($carpeta){
	case 'imgperfil':
	  $extension = 'image/jpeg';
	  $disposition = 'inline';
	  $ruta = PATH_PROFILE.$archivo.'.jpg';	  
	  $resultado = file_exists($ruta);	  	  
	  if (!$resultado){
	  	$ruta = FRONTEND_RUTA.'imagenes/icono-perfil-06.png';
	  	//$archivo = 'user.png';
	  }	  	
	  //echo $ruta." / ".$archivo; exit;  
	  $archivo = $archivo.'.jpg';
	  $mostrar = true;
	break;
	case 'profile':
	  $extension = 'image/jpeg';
	  $disposition = 'inline';
	  $ruta = PATH_PROFILE.$archivo.'.jpg';	  
	  $resultado = file_exists($ruta);	  	  
	  if (!$resultado){
	  	$ruta = FRONTEND_RUTA.'imagenes/user.png';
	  }	  	  
	  $archivo = $archivo.'.jpg';
	  $mostrar = true;
	break;
	case 'hv':	  
	  $infoHv = Modelo_InfoHv::obtieneHv($usuario["id_usuario"]);	
		if($infoHv['formato'] == 'pdf'){
		  $extension = 'application/pdf';
		}else{
			$extension = 'application/msword';
		}
		$disposition = 'attachment';
		$ruta = PATH_ARCHIVO.$archivo.'.'.$infoHv['formato'];		
		$resultado = file_exists($ruta);	  
		$archivo = $archivo.'.'.$infoHv['formato'];
		$mostrar = (!$resultado) ? false : true;		
	break;
}

if($carpeta=='hv' && $mostrar && $_SESSION['mfo_datos']['usuario']['tipo_usuario']==Modelo_Usuario::EMPRESA){

	$id_oferta = (!empty($param2)) ? $param2 : false;
	$id_empresa = $_SESSION['mfo_datos']['usuario']['id_usuario'];
	$posibilidades = Modelo_UsuarioxPlan::disponibilidadDescarga($id_empresa,$id_oferta);
	$descargas = Modelo_Descarga::descargas($id_empresa,$id_oferta);
	if(in_array($infoHv['id_infohv'], $descargas)){
		$mostrar = true;
	}else{
		if(count($descargas) <= $posibilidades){
			Modelo_Descarga::registrarDescarga($infoHv['id_infohv'],$id_empresa,$id_oferta);
			$mostrar = true;
		}else{
			$cantidadRestante = 0;
			$mostrar = false;
		}
	}
	/*if(in_array('-1',$posibilidades) ){	
		$idoferta = (!empty($param2)) ? $param2 : false;
		Modelo_Descarga::registrarDescarga($infoHv['id_infohv'],$_SESSION['mfo_datos']['usuario']['id_usuario'],$idoferta);
	}else{
		$cantidadRestante = array_sum($posibilidades) - $descargas['cantd_descarga'];
		if($cantidadRestante > 0){
			$idoferta = (!empty($param2)) ? $param2 : false;
			Modelo_Descarga::registrarDescarga($infoHv['id_infohv'],$_SESSION['mfo_datos']['usuario']['id_usuario'],$idoferta);
		}else{
			$mostrar = false;
		}
	}*/
}

if ($mostrar){
  header("Pragma: no-cache"); 
  header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0"); 
  header("Expires: 0"); 
  header("Content-type: ".$extension); 
  header("Content-Disposition: ".$disposition."; filename=".$archivo); 
  readfile($ruta); 	
}   
else{
	if(isset($cantidadRestante) && $cantidadRestante == 0){
		$_SESSION['mostrar_error'] = 'Ya agoto su cupo de descargas';
	}else{
		$_SESSION['mostrar_error'] = 'Archivo no encontrado';
	}
	$enlace = $_SERVER['HTTP_REFERER'];
	header('Location: '.$enlace);
}

exit;
?>
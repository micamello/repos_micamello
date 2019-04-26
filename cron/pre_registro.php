<?php
ignore_user_abort( true );
ini_set("max_execution_time", "0");
ini_set("max_input_time", "0");
ini_set('memory_limit', "768M");
set_time_limit(0);

/*Script para migrar datos de usuarios de pre-registro a produccion con envío de correos de bienvenida y el enlace de ingreso */

require_once '../constantes.php';
require_once '../init.php';
require_once '../multisitios.php';

define('SUCURSAL_PAISID',39);
define('DOMINIO','micamello.com.ec');

//pregunta si ya se esta ejecutando el cron sino crea el archivo
// $resultado = file_exists(CRON_RUTA.'procesando_preregistro.txt');
// if ($resultado){
//   exit;
// }
// else{
//   Utils::crearArchivo(CRON_RUTA,'procesando_preregistro.txt','');
// }
$usuarios = Modelo_PreRegistro::preregistrados();
$tipodoc = "";
if (!empty($usuarios) && is_array($usuarios)){	
	$datosPreregistro = array();
	$conterror = 0;
	$escolaridad = Modelo_Escolaridad::obtieneListado()[0]['id_escolaridad'];
	$default_city = Modelo_Sucursal::obtieneCiudadDefault()['id_ciudad'];
	$datosPreregistro = array_merge($datosPreregistro,
									array("id_escolaridad"=>$escolaridad, 
											"id_ciudad"=>$default_city));
	foreach($usuarios as $usuario){  
	  	try{
	  		$datosPreregistro = array_merge($datosPreregistro, $usuario);
		  	$longitudDoc = strlen($datosPreregistro['dni']);
		  	if($longitudDoc == 10){
		  		if (method_exists(new Utils, 'validar_'.SUCURSAL_ISO)){
			        $function = 'validar_'.SUCURSAL_ISO;
			        if(!Utils::$function($datosPreregistro['dni'])){
			        	$conterror++;
	    				throw new Exception("CEDULA INVALIDA ".$datosPreregistro["dni"]);
			        }
			    }
			    $tipodoc = 2;
		  	}
		  	elseif($longitudDoc == 13){
		  		if (method_exists(new Utils, 'validar_'.SUCURSAL_ISO)){
			        $function = 'validar_'.SUCURSAL_ISO;
			        if(!Utils::$function($datosPreregistro['dni'])){
			        	$conterror++;
	    				throw new Exception("RUC INVALIDO ".$datosPreregistro["dni"]);
			        }
			    }
			    $tipodoc = 1;
		  	}
		  	elseif($longitudDoc <= 6){
		  		$conterror++;
		  		throw new Exception("PASAPORTE INVALIDO ".$datosPreregistro["dni"]);
		  	}
		  	else{
		  		$tipodoc = 3;
		  	}
// Comprobar si es válido el correo

			if(!Utils::es_correo_valido($datosPreregistro['correo'])){
				$conterror++;
				throw new Exception("EL CORREO NO ES VÁLIDO ".$datosPreregistro["correo"]);
			}
			
			if (Modelo_Usuario::existeDni($datosPreregistro["dni"]) != false){
	    		$conterror++;
	    		throw new Exception("DNI YA EXISTE ".$datosPreregistro["dni"]);	      	    		    		
		    }

		    if (Modelo_Usuario::existeCorreo($datosPreregistro["correo"]) != false){
		    	$conterror++;
		      	throw new Exception("CORREO YA EXISTE ".$datosPreregistro["correo"]);
		    } 
		    print_r($datosPreregistro);
		    exit();


		   	$nombre = Utils::no_carac(explode(" ", trim($datosPreregistro['nombres']))); 
		    $nombre[0] = strtolower($nombre[0]);	    	    	    	    
		    if ($datosPreregistro['tipo_usuario'] == 1){ 
		      $apellido = Utils::no_carac(explode(" ", trim($datosPreregistro['apellidos'])));
		      $apellido[0] = strtolower($apellido[0]);
		      $username = Utils::generarUsername($nombre[0].$apellido[0]);
		    }
		    else{
		      $username = Utils::generarUsername($nombre[0]);
		    }








		  		print_r("correcto");
		  	exit();
    	}
	    catch(Exception $e){
	  	  $GLOBALS['db']->rollback();
	  	  echo "Error en usuario ".$usuario['id']." ".$e->getMessage()."<br>";  	  
			  Utils::envioCorreo('administrador.gye@micamello.com.ec','Error Cron PreRegistro',$e->getMessage());      
	    }         
	}
	echo "TOTAL REGISTROS INVALIDOS ".$conterror;
}

//elimina archivo de procesamiento
unlink(CRON_RUTA.'procesando_preregistro.txt');
?>
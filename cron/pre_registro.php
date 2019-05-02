<?php
ignore_user_abort( true );
ini_set("max_execution_time", "0");
ini_set("max_input_time", "0");
ini_set('memory_limit', "768M");
set_time_limit(0);

/*Script para migrar datos de usuarios de pre-registro a produccion con envío de correos de bienvenida y el enlace de ingreso */

require_once '../constantes.php';
require_once '../init.php';
//require_once '../multisitios.php';

define('SUCURSAL_PAISID',39);
define('SUCURSAL_ISO','EC');
//define('DOMINIO','micamello.com.ec');

// pregunta si ya se esta ejecutando el cron sino crea el archivo
$resultado = file_exists(CRON_RUTA.'procesando_preregistro.txt');
if ($resultado){
  exit;
}
else{
  Utils::crearArchivo(CRON_RUTA,'procesando_preregistro.txt','');
}
$usuarios = Modelo_PreRegistro::preregistrados();
$tipodoc = "";
if (!empty($usuarios) && is_array($usuarios)){	
	$datosPreregistro = array();
	$conterror = 0;
	$default_city = Modelo_Sucursal::obtieneCiudadDefault()['id_ciudad'];
	$datosPreregistro = array_merge($datosPreregistro,
									array("id_ciudad"=>$default_city));
	foreach($usuarios as $usuario){  
		$idInsercion = 0;
	  	try{
	  		$GLOBALS['db']->beginTrans(); 
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
		    
		   	$nombre = Utils::no_carac(explode(" ", trim(utf8_decode($datosPreregistro['nombres'])))); 
		    $nombre[0] = strtolower($nombre[0]);	    	    	    	    
		    if ($datosPreregistro['tipo_usuario'] == 1){ 
		      $apellido = Utils::no_carac(explode(" ", trim(utf8_decode($datosPreregistro['apellidos']))));
		      $apellido[0] = strtolower($apellido[0]);
		      $username = Utils::generarUsername($nombre[0].$apellido[0]);
		    }
		    else{
		      $username = Utils::generarUsername($nombre[0]);
		    }

		    // generar password
		    $password = Utils::generarPassword();

		    $datosPreregistro = array_merge($datosPreregistro, 
		    							array("username"=>$username, 
		    									"tipo_doc"=>$tipodoc, 
		    									"password"=>$password, 
		    									"tipo_registro"=>1));

		    $usuarioLogin = array("tipo_usuario"=>$datosPreregistro['tipo_usuario'], 
		    						"username"=>$datosPreregistro['username'], 
		    						"password"=>$datosPreregistro['password'], 
		    						"correo"=>$datosPreregistro['correo'], 
		    						"dni"=>$datosPreregistro['dni'], 
		    						"tipo_registro"=>$datosPreregistro['tipo_registro']);
		    // se ingresa en la tabla mfo_usuario_login el registro
		    if(!Modelo_UsuarioLogin::crearUsuarioLogin($usuarioLogin)){
		    	throw new Exception("Error al crear el usuario_login");
		    }
		    $fechaActual = date("Y-m-d H:i:s");
		    $idUsuarioLogin = $GLOBALS['db']->insert_id();
		    if($datosPreregistro['tipo_usuario'] == 1){
		    	$id_escolaridad = Modelo_Escolaridad::obtieneListado()[0]['id_escolaridad'];
		    	$idEstadoCivil = Modelo_EstadoCivil::obtieneListado()[0]['id_estadocivil'];
		    	$idSituacionLaboral = Modelo_SituacionLaboral::obtieneListadoAsociativo();
		    	if(!empty($idSituacionLaboral)){
		    		foreach ($idSituacionLaboral as $key => $value) {
			    		$idSituacionLaboral = $key;
			    		break;
			    	}
		    	}
		    	$mfoUsuario = array("nombres"=>$datosPreregistro['nombres'],
			    						"apellidos"=>$datosPreregistro['apellidos'],
			    						"telefono"=>$datosPreregistro['telefono'],
			    						"fecha_nacimiento"=>$datosPreregistro['fecha_nacimiento'],
			    						"fecha_creacion"=>$datosPreregistro['fecha'],
			    						"estado"=>0,
			    						"term_cond"=>1,
			    						"id_ciudad"=>$datosPreregistro['id_ciudad'],
			    						"ultima_sesion"=>$fechaActual,
			    						"id_nacionalidad"=>SUCURSAL_PAISID,
			    						"tipo_doc"=>$datosPreregistro['tipo_doc'],
				    					"viajar"=>0,
				    					"residencia"=>0,
				    					"discapacidad"=>0,
				    					"id_escolaridad"=> $id_escolaridad,
				    					"id_usuario_login"=>$idUsuarioLogin,
				    					"genero"=>$datosPreregistro['id_genero'],
				    					"id_estadocivil"=>$idEstadoCivil,
				    					"id_situacionlaboral"=>$idSituacionLaboral,
				    					"tipo_usuario"=>$datosPreregistro['tipo_usuario']);
		    	if(!Modelo_Usuario::crearUsuario($mfoUsuario)){
			   		throw new Exception("Error al ingresar el usuario o empresa");
			   	}
			   	$idInsercion = $GLOBALS['db']->insert_id();
		    }
		    else{
		    	$mfoEmpresa = array("telefono"=>$datosPreregistro['telefono'],
		    						"nombres"=>$datosPreregistro['nombres'],
		    						"fecha_nacimiento"=>$fechaActual,
		    						"fecha_creacion"=>$datosPreregistro['fecha'],
		    						"estado"=>0,
		    						"term_cond"=>1,
		    						"id_ciudad"=>$datosPreregistro['id_ciudad'],
		    						"id_nacionalidad"=>SUCURSAL_PAISID,
		    						"id_usuario_login"=>$idUsuarioLogin,
		    						"id_sectorindustrial"=>$datosPreregistro['id_sectorindustrial'],
		    						"tipo_usuario"=>$datosPreregistro['tipo_usuario']);

		    	if(!Modelo_Usuario::crearUsuario($mfoEmpresa)){
			   		throw new Exception("Error al ingresar el usuario o empresa");
			   	}

			   	$idInsercion = $GLOBALS['db']->insert_id();
			   	$contactoEmpresa = array("nombreConEmp"=>$datosPreregistro['nombres'],
			   								"apellidoConEmp"=>$datosPreregistro['nombres'],
			   								"tel1ConEmp"=>$datosPreregistro['telefono'],
			   								"tel2ConEmp"=>'');

			  	if(!Modelo_ContactoEmpresa::crearContactoEmpresa($contactoEmpresa, $idInsercion)){
		          throw new Exception("Error al ingresar el contacto de la empresa");
		        }
		    }
		    if (!Modelo_PreRegistro::borrarPreregistro($datosPreregistro['id'])){
		   		throw new Exception("Error al borrar el preregistro");
		    }
		    $GLOBALS['db']->commit();


		    $token = Utils::generarToken($idInsercion,"ACTIVACION");
		      if (empty($token)){
		        throw new Exception("Error en el sistema, por favor intente de nuevo");
		      }
		    $token .= "||".$idInsercion."||".$datosPreregistro['tipo_usuario']."||".date("Y-m-d H:i:s");
		    $token = Utils::encriptar($token);
			$enlace = "<a href='".PUERTO."://".HOST."/registro/".$token."/'>click aqui</a>";


		   	$nombre_mostrar = utf8_encode($datosPreregistro["nombres"]).(!empty($datosPreregistro['apellidos']) ? " ".utf8_encode($datosPreregistro['apellidos']) : "");
		    // $enlace = "<a href='".PUERTO."://".DOMINIO."/desarrollov3/login/'>click aqu&iacute;</a>";
		  
		   	$email_body = Modelo_TemplateEmail::obtieneHTML("ACTIVACION_USUARIO");
		   	$email_body = str_replace("%NOMBRES%", $nombre_mostrar, $email_body);   
		   	$email_body = str_replace("%USERNAME%", $username, $email_body);   
		   	$email_body = str_replace("%CORREO%", $datosPreregistro["correo"], $email_body);   
		   	$email_body = str_replace("%PASSWORD%", $password, $email_body);   
		   	$email_body = str_replace("%ENLACE%", $enlace, $email_body);   
		   	Utils::envioCorreo($datosPreregistro["correo"],"Activación de Usuario",$email_body);          
		   	echo utf8_encode($datosPreregistro['nombres'])." ".utf8_encode($datosPreregistro['apellidos'])."/".$username."<br>";
    	}
	    catch(Exception $e){
	  	  $GLOBALS['db']->rollback();
	  	  echo "Error en usuario ".$datosPreregistro['id']." ".$e->getMessage()."<br>";  	  
			  Utils::envioCorreo('administrador.gye@micamello.com.ec','Error Cron PreRegistro',$e->getMessage());      
	    }         
	}
	echo "TOTAL REGISTROS INVALIDOS ".$conterror;
}
//elimina archivo de procesamiento
unlink(CRON_RUTA.'procesando_preregistro.txt');
?>
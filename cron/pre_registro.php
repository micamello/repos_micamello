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
// Por favor  validar su cuenta con un correo empresarial y enviandonos copia del ruc y del nombramiento 
$validarCorreo = array(
"0990004196001",
"0992216816001",
"0993190861001",
"0992422823001",
"0992428678001",
"1790011119001",
"0992665041001",
"0992165480001",
"1792695333001",
"1792587077001",
"1792597188001"
);
// pregunta si ya se esta ejecutando el cron sino crea el archivo
$resultado = file_exists(CRON_RUTA.'procesando_preregistro.txt');
if ($resultado){
  exit;
}
else{
  Utils::crearArchivo(CRON_RUTA,'procesando_preregistro.txt','');
}
$usuarios = Modelo_PreRegistro::preregistrados();
// print_r($usuarios);
// exit();
$tipodoc = "";
if (!empty($usuarios) && is_array($usuarios)){
print_r("FECHA DE INICIO: ". date('Y-m-d h:i:s')."<br><br>");	
	$datosPreregistro = array();
	$conterror = 0;
	$default_city = Modelo_Sucursal::obtieneCiudadDefault()['id_ciudad'];
	$datosPreregistro = array_merge($datosPreregistro,
									array("id_ciudad"=>$default_city));
	$i = 1;
	foreach($usuarios as $usuario){  
		$idInsercion = 0;
	  	try{
	  		$GLOBALS['db']->beginTrans(); 
	  		$datosPreregistro = array_merge($datosPreregistro, $usuario);
	  		print_r("<br>-----USUARIO (".$i."): ".$datosPreregistro['nombres']."-----<br>");
		  	$longitudDoc = strlen($datosPreregistro['dni']);
		  	// echo $datosPreregistro['dni'];

		  	if($longitudDoc == 10 && $datosPreregistro['tipo_usuario'] == 1){
		  		$tipodoc = 2;
		  		if($datosPreregistro['tipo_doc'] != "" || $datosPreregistro['tipo_doc'] != null){
	  				$tipodoc = $datosPreregistro['tipo_doc'];
	  			}

		  		if (method_exists(new Utils, 'validar_'.SUCURSAL_ISO)){
			        $function = 'validar_'.SUCURSAL_ISO;
			        if(!Utils::$function($datosPreregistro['dni'], 1, $tipodoc)){
			        	$conterror++;
	    				throw new Exception("CEDULA INVALIDA ".$datosPreregistro["dni"]);
			        }
			    }
		  	}
		  	elseif($longitudDoc == 13 && $datosPreregistro['tipo_usuario'] == 2){
		  		if(!empty($validarCorreo)){
		  			if(in_array($datosPreregistro["dni"], $validarCorreo)){
		  				// validar correo

		  				$email_body = Modelo_TemplateEmail::obtieneHTML("VALIDAR_CORREO");
		  				$email_body = str_replace("%NOMBRES%", $datosPreregistro['nombres'], $email_body);
		  				Utils::envioCorreo($datosPreregistro["correo"],"Validar correo",$email_body);
		  				throw new Exception("NO SE REGISTRO validar correo: ".$datosPreregistro["dni"]);
		  			}
		  		}
		  		// if(!empty($excepcionesEmpresas)){
		  			// if(!in_array($datosPreregistro['dni'], $excepcionesEmpresas)){
		  				if (method_exists(new Utils, 'validar_'.SUCURSAL_ISO)){
				  			$tipodoc = 1;
				  			if($datosPreregistro['tipo_doc'] != "" || $datosPreregistro['tipo_doc'] != null){
				  				$tipodoc = $datosPreregistro['tipo_doc'];
				  			}
				  			$function = 'validar_'.SUCURSAL_ISO;
					        if(!Utils::$function($datosPreregistro['dni'] , 1, $tipodoc)){
					        	$conterror++;
					        	// Utils::envioCorreo("administrador.gye@micamello.com.ec","Ruc no admintido","No persona natural".$datosPreregistro['dni']);
					        	$email_body = Modelo_TemplateEmail::obtieneHTML("RUC_NO_VALIDO");
					        	$email_body = str_replace("%NOMBRES%", $datosPreregistro['nombres'], $email_body);
							    $email_body = str_replace("%ENLACE%", "<a style='background-color: #22b573; color: white; padding: 8px 20px; text-decoration: none; border-radius: 5px;' href='https://www.micamello.com.ec/'>Click aqu&iacute;</a>", $email_body);   
							    $email_body = str_replace("%ENLACE2%", "info@micamello.com.ec", $email_body);
							    // aqui va el correo de que envie el ruc y nombramiento
					        	Utils::envioCorreo($datosPreregistro["correo"],"Ruc rechazado",$email_body);
			    				throw new Exception("RUC INVALIDO ".$datosPreregistro["dni"]);
					        }
					    }
		  			// }
		  		// }
		  		
		  		
			    
		  	}

		  	// elseif($datosPreregistro['tipo_usuario'] == 1){
		  	// 		$tipodoc = 3;
		  	// 		if($datosPreregistro['tipo_doc'] != "" || $datosPreregistro['tipo_doc'] != null){
		  	// 			$tipodoc = $datosPreregistro['tipo_doc'];
		  	// 		}
		  	// }
		  	elseif(($longitudDoc >= 6 && $longitudDoc != 10 && $longitudDoc != 13) && $datosPreregistro['tipo_usuario'] == 1){
		  		$tipodoc = 3;
		  			if($datosPreregistro['tipo_doc'] != "" || $datosPreregistro['tipo_doc'] != null){
		  				$tipodoc = $datosPreregistro['tipo_doc'];
		  			}
		  	}
		  	else{
		  		$conterror++;
		  		throw new Exception("<br>Documento ingresado no válido: -".$datosPreregistro["dni"]."-".$datosPreregistro["correo"]."- ".$datosPreregistro["nombres"]);
		  		
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
		    	$mfoUsuario = array("nombres"=>utf8_encode($datosPreregistro['nombres']),
			    						"apellidos"=>utf8_encode($datosPreregistro['apellidos']),
			    						"telefono"=>$datosPreregistro['telefono'],
			    						"fecha_nacimiento"=>$datosPreregistro['fecha_nacimiento'],
			    						// "fecha_creacion"=>$datosPreregistro['fecha'],
			    						"fecha_creacion"=>$fechaActual,
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
		    		var_dump($mfoUsuario);
		    		echo "<br><br><br>";
			   		throw new Exception("Error al ingresar el usuario o empresa".
			   							"<br>".$datosPreregistro['nombres'].
			   							"<br>".$datosPreregistro['apellidos']."<br>");
			   	}
			   	$idInsercion = $GLOBALS['db']->insert_id();
		    }
		    else{
		    	if($datosPreregistro['id_sectorindustrial'] ==  "" || $datosPreregistro['id_sectorindustrial'] == null){
		    		$datosPreregistro['id_sectorindustrial'] = 69;
		    	}
		    	$mfoEmpresa = array("telefono"=>$datosPreregistro['telefono'],
		    						"nombres"=>utf8_encode($datosPreregistro['nombres']),
		    						"fecha_creacion"=>$fechaActual,
		    						"nro_trabajadores"=>1,
		    						// "fecha_creacion"=>$datosPreregistro['fecha'],
		    						"estado"=>0,
		    						"term_cond"=>1,
		    						"id_ciudad"=>$datosPreregistro['id_ciudad'],
		    						"id_nacionalidad"=>SUCURSAL_PAISID,
		    						"id_usuario_login"=>$idUsuarioLogin,
		    						"id_sectorindustrial"=>$datosPreregistro['id_sectorindustrial'],
		    						"tipo_usuario"=>$datosPreregistro['tipo_usuario']);

		    	if(!Modelo_Usuario::crearUsuario($mfoEmpresa)){
		    		var_dump($mfoEmpresa);
		    		echo "<br><br><br>";
			   		throw new Exception("Error al ingresar el usuario o empresa".
			   							"<br>".$datosPreregistro['nombres']."<br>");
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
		    echo $datosPreregistro['dni']." - si válido: ".$datosPreregistro['nombres'];
		    $GLOBALS['db']->commit();


		    $token = Utils::generarToken($idInsercion,"ACTIVACION");
		      if (empty($token)){
		        throw new Exception("Error en el sistema, por favor intente de nuevo");
		      }
		    $token .= "||".$idInsercion."||".$datosPreregistro['tipo_usuario']."||".date("Y-m-d H:i:s");
		    $token = Utils::encriptar($token);
			$enlace = "<a href='".PUERTO."://".HOST."/registro/".$token."/'>click aqui</a>";


		   	$nombre_mostrar = ucfirst(utf8_encode($datosPreregistro["nombres"])).(!empty($datosPreregistro['apellidos']) ? " ".ucfirst(utf8_encode($datosPreregistro['apellidos'])) : "");
		    // $enlace = "<a href='".PUERTO."://".DOMINIO."/administrador.gyev3/login/'>click aqu&iacute;</a>";
		  
		   	$email_body = Modelo_TemplateEmail::obtieneHTML("ACTIVACION_USUARIO");
		   	$email_body = str_replace("%NOMBRES%", $nombre_mostrar, $email_body);   
		   	$email_body = str_replace("%USUARIO%", $username, $email_body);   
		   	$email_body = str_replace("%CORREO%", $datosPreregistro["correo"], $email_body);   
		   	$email_body = str_replace("%PASSWORD%", $password, $email_body);   
		   	$email_body = str_replace("%ENLACE%", $enlace, $email_body);   

		   	Utils::envioCorreo($datosPreregistro["correo"],"Activación de Usuario",$email_body);         
		   	

		   	echo utf8_encode($datosPreregistro['nombres'])." ".utf8_encode($datosPreregistro['apellidos'])."/".$username."<br>";
    	}
	    catch(Exception $e){
	  	  $GLOBALS['db']->rollback();

	  	  echo $datosPreregistro['id']."Error en usuario ".$datosPreregistro['nombres']." ".$datosPreregistro['nombres']." - ".$e->getMessage()."<br>";  	  

			  Utils::envioCorreo('administrador.gye@micamello.com.ec','Error Cron PreRegistro',$e->getMessage());      
	    }
	    $i++;         

	}
	print_r("FECHA DE FIN: ". date('Y-m-d h:i:s'));
	echo "TOTAL REGISTROS INVALIDOS ".$conterror;
}
//elimina archivo de procesamiento
unlink(CRON_RUTA.'procesando_preregistro.txt');
?>
<?php
ignore_user_abort( true );
ini_set("max_execution_time", "0");
ini_set("max_input_time", "0");
ini_set('memory_limit', "768M");
set_time_limit(0);

/*Script para migrar datos de usuarios de pre-registro a produccion con envío de correos de bienvenida y el enlace de ingreso */

require_once '../constantes.php';
require_once '../init.php';

define('SUCURSAL_PAISID',39);
define('DOMINIO','micamello.com.ec');

//pregunta si ya se esta ejecutando el cron sino crea el archivo
$resultado = file_exists(CRON_RUTA.'procesando_preregistro.txt');
if ($resultado){
  exit;
}
else{
  Utils::crearArchivo(CRON_RUTA,'procesando_preregistro.txt','');
}

$usuarios = Modelo_PreRegistro::preregistrados();
if (!empty($usuarios) && is_array($usuarios)){	
	$conterror = 0;
	$escolaridad = Modelo_Escolaridad::obtieneListado();
	$default_city = Modelo_Sucursal::obtieneCiudadDefault();
	foreach($usuarios as $usuario){   
	  try{
	  	$GLOBALS['db']->beginTrans(); 
			$long_dni = strlen($usuario["dni"]);
			if ($long_dni == 13){   
				$valido1 = ValidadorEc::validarRucPersonaNatural($usuario["dni"]);
				$valido2 = ValidadorEc::validarRucSociedadPrivada($usuario["dni"]);
				$valido3 = ValidadorEc::validarRucSociedadPublica($usuario["dni"]);
				if (!$valido1 && !$valido2 && !$valido3){
					$conterror++;
					throw new Exception("RUC INVALIDO ".$usuario["dni"]);    			    			    		
	    	}
	    	$tipodoc = 1;
			}    
	    elseif($long_dni == 10){
	    	$valido = ValidadorEc::validarCedula($usuario["dni"]);
	    	if (!$valido){
	    		$conterror++;
	    		throw new Exception("CEDULA INVALIDA ".$usuario["dni"]);
	    	}
	    	$tipodoc = 2;
	    }
	    elseif ($long_dni <= 6){
	    	$conterror++;
	    	throw new Exception("PASAPORTE INVALIDO ".$usuario["dni"]);
	    }
	    else{
	    	$tipodoc = 3;
	    }

	    $validocorreo = Utils::es_correo_valido($usuario["correo"]);
	    if (!$validocorreo){
	    	$conterror++;
	    	throw new Exception("CORREO INVALIDO ".$usuario["correo"]);
	    }

	    if ($usuario["tipo_usuario"] == 2 && $long_dni != 13){
	    	$conterror++;
	    	throw new Exception("RUC INVALIDO ".$usuario["dni"]);	      	    
	    }

	    if (!Modelo_Usuario::existeDni($usuario["dni"])){
	    	$conterror++;
	    	throw new Exception("DNI YA EXISTE ".$usuario["dni"]);	      	    		    		
	    }

	    if (!Modelo_Usuario::existeCorreo($usuario["correo"])){
	    	$conterror++;
	      throw new Exception("CORREO YA EXISTE ".$usuario["correo"]);
	    }    	       	
    	
	    $nombre = Utils::no_carac(explode(" ", trim($usuario['nombres']))); 
	    $nombre[0] = strtolower($nombre[0]);	    	    	    	    
	    if ($usuario['tipo_usuario'] == 1){   
	      $apellido = Utils::no_carac(explode(" ", trim($usuario['apellidos'])));
	      $apellido[0] = strtolower($apellido[0]);
	      $username = Utils::generarUsername($nombre[0].$apellido[0]);
	    }
	    else{
	      $username = Utils::generarUsername($nombre[0]);
	    }
      
 			$password = Utils::generarPassword();
      $usuario_login = array("tipo_usuario"=>$usuario["tipo_usuario"], "username"=>$username, 
      	                     "password"=>$password, "correo"=>$usuario['correo'], "dni"=>$usuario["dni"]);
      if(!Modelo_UsuarioLogin::crearUsuarioLogin($usuario_login)){
        throw new Exception("Error al crear el usuario_login");
      }
      $id_usuario_login = $GLOBALS['db']->insert_id();
      $mayor_edad = date("Y-m-d H:i:s",strtotime($usuario["fecha"]."- 18 year"));
      if ($usuario["tipo_usuario"] == 1) {      	
        $data = array('telefono'=>$usuario['telefono'], 'nombres'=>$usuario['nombres'], 'apellidos'=>$usuario['apellidos'], 
        	            'fecha_nacimiento'=>$mayor_edad, 'fecha_creacion'=>date('Y-m-d H:i:s'), 'estado'=>1, 'term_cond'=>1,
        	            'id_ciudad'=>$default_city['id_ciudad'], 'ultima_sesion'=>date('Y-m-d H:i:s'), 'id_nacionalidad'=>SUCURSAL_PAISID, 
        	            'tipo_doc'=>$tipodoc, 'id_escolaridad'=>$escolaridad[0]['id_escolaridad'], 'genero'=>'M', 
        	            'id_usuario_login'=>$id_usuario_login, 'tipo_usuario'=>$usuario["tipo_usuario"]);       
      }
      else{
        $data = array('telefono'=>$usuario['telefono'], 'nombres'=>$usuario['nombres'], 'fecha_nacimiento'=>$mayor_edad,
        	            'fecha_creacion'=>date('Y-m-d H:i:s'), 'estado'=>1, 'term_cond'=>1, 'id_ciudad'=>$default_city['id_ciudad'],
        	            'ultima_sesion'=>date('Y-m-d H:i:s'), 'id_nacionalidad'=>SUCURSAL_PAISID, 'id_usuario_login'=>$id_usuario_login, 'tipo_usuario'=>$usuario['tipo_usuario']); 
      }
      if(!Modelo_Usuario::crearUsuario($data)){
        throw new Exception("Error al ingresar el usuario o empresa");
      }

      $user_id = $GLOBALS['db']->insert_id();
      if ($usuario["tipo_usuario"] == 2){      	
      	$contacto = array('nombre_contact'=>$usuario['nombres'], 'apellido_contact'=>$usuario['nombres'], 'tel_one_contact'=>$usuario['telefono'], 'tel_two_contact'=>'');
        if(!Modelo_ContactoEmpresa::crearContactoEmpresa($contacto, $user_id)){
          throw new Exception("Error al ingresar el contacto de la empresa");
        }
      }

      if (!Modelo_PreRegistro::borrarPreregistro($usuario['id'])){
      	throw new Exception("Error al borrar el preregistro");
      }

      $GLOBALS['db']->commit();
    
	    $nombre_mostrar = utf8_encode($usuario["nombres"]).(!empty($usuario['apellidos']) ? " ".utf8_encode($usuario['apellidos']) : "");
	    $enlace = "<a href='".PUERTO."://".DOMINIO."/desarrollov3/login/'>click aqu&iacute;</a>";
	  
      $email_body = Modelo_TemplateEmail::obtieneHTML("ACTIVACION_USUARIO");
      $email_body = str_replace("%NOMBRES%", $nombre_mostrar, $email_body);   
      $email_body = str_replace("%USERNAME%", $username, $email_body);   
      $email_body = str_replace("%CORREO%", $usuario["correo"], $email_body);   
      $email_body = str_replace("%PASSWORD%", $password, $email_body);   
      $email_body = str_replace("%ENLACE%", $enlace, $email_body);   
      Utils::envioCorreo($usuario["correo"],"Activación de Usuario",$email_body);          

      echo utf8_encode($usuario['nombres'])." ".utf8_encode($usuario['apellidos'])."/".$username."<br>";    
    }
    catch(Exception $e){
  	  $GLOBALS['db']->rollback();
  	  echo "Error en usuario ".$usuario['id']." ".$e->getMessage()."<br>";  	  
		  Utils::envioCorreo('desarrollo@micamello.com.ec','Error Cron PreRegistro',$e->getMessage());      
    }         
	}
	echo "TOTAL REGISTROS INVALIDOS ".$conterror;
}

//elimina archivo de procesamiento
unlink(CRON_RUTA.'procesando_preregistro.txt');
?>
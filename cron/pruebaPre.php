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
	  		// $GLOBALS['db']->beginTrans(); 
	  		$datosPreregistro = array_merge($datosPreregistro, $usuario);
	  		
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

		   	Utils::envioCorreo("administrador.gye@micamello.com.ec","Activación de Usuario",$email_body);         

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
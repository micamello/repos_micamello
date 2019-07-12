<?php
ignore_user_abort( true );
ini_set("max_execution_time", "0");
ini_set("max_input_time", "0");
ini_set('memory_limit', "768M");
set_time_limit(0);

/*Script para migrar datos de usuarios de pre-registro a produccion con envío de correos de bienvenida y el enlace de ingreso */

require_once '../constantes.php';
require_once '../init.php';

$usuarios = Modelo_PreRegistro::consultaCorreccion();

foreach($usuarios as $usuario){
  $token = Utils::generarToken($usuario["id_empresa"],"ACTIVACION");
  if (empty($token)){
    throw new Exception("Error en el sistema, por favor intente de nuevo");
  }
  $token .= "||".$usuario["id_empresa"]."||2||".date("Y-m-d H:i:s");
  $token = Utils::encriptar($token);
  $enlace = "<a href='https://www.micamello.com.ec/registro/".$token."/'>click aqui</a>"; 
  $nombre_mostrar = ucfirst(utf8_encode($usuario['nombres']));		    		  
	$email_body = Modelo_TemplateEmail::obtieneHTML("ACTIVACION_USUARIO");
	$email_body = str_replace("%NOMBRES%", $nombre_mostrar, $email_body);   
	$email_body = str_replace("%USUARIO%", $usuario['username'], $email_body);   
	$email_body = str_replace("%CORREO%", $usuario['correo'], $email_body);   
	$email_body = str_replace("%PASSWORD%", 'User12345', $email_body);   
	$email_body = str_replace("%ENLACE%", $enlace, $email_body);   

	Utils::envioCorreo($usuario["correo"],"Activación de Empresa",$email_body); 	
	//Utils::envioCorreo("desarrollo@micamello.com.ec","Activación de Empresa",$email_body); 	
}
?>
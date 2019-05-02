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
//define('DOMINIO','micamello.com.ec');

// pregunta si ya se esta ejecutando el cron sino crea el archivo
$resultado = file_exists(CRON_RUTA.'alerta_preregistro.txt');
if ($resultado){
  exit;
}
else{
  Utils::crearArchivo(CRON_RUTA,'alerta_preregistro.txt','');
}
$usuariosNoSesion = Modelo_Usuario::obtenerUsuariosPreregistrados();
	if(!empty($usuariosNoSesion) && is_array($usuariosNoSesion)){
		foreach ($usuariosNoSesion as $usuarios) {
			try {
				$token = Utils::generarToken($usuarios['id_reg'],"ACTIVACION");
			      if (empty($token)){
			        throw new Exception("Error en el sistema, por favor intente de nuevo");
			      }
			    $token .= "||".$usuarios['id_reg']."||".$usuarios['tipo_usuario']."||".date("Y-m-d H:i:s");
			    $token = Utils::encriptar($token);
				$enlace = "<a href='".PUERTO."://".HOST."/registro/".$token."/'>click aqui</a>";
				$password = Utils::generarPassword();
				if(!Modelo_Usuario::modificarPassword($password, $usuarios['id_usuario_login'])){
					throw new Exception("Ha ocurrido un error al actualizar la contraseña");
				}

			   	$nombre_mostrar = utf8_encode($usuarios["nombres"]).(!empty($usuarios['apellidos']) ? " ".utf8_encode($usuarios['apellidos']) : "");
			  
			   	$email_body = Modelo_TemplateEmail::obtieneHTML("ACTIVACION_USUARIO");
			   	$email_body = str_replace("%NOMBRES%", $nombre_mostrar, $email_body);   
			   	$email_body = str_replace("%USERNAME%", $usuarios['username'], $email_body);   
			   	$email_body = str_replace("%CORREO%", $usuarios["correo"], $email_body);   
			   	$email_body = str_replace("%PASSWORD%", $password, $email_body);   
			   	$email_body = str_replace("%ENLACE%", $enlace, $email_body);   
			   	Utils::envioCorreo($usuarios["correo"],"Activación de Usuario",$email_body);          
			   	echo utf8_encode($usuarios['nombres'])." ".utf8_encode($usuarios['apellidos'])."/".$usuarios['username']."<br>";
			} catch (Exception $e) {
				echo "Error en usuario ".$usuarios['id_reg']." ".$e->getMessage()."<br>No se pudo enviar el correo al usuario ".$usuarios['nombres'];    
			  	Utils::envioCorreo('administrador.gye@micamello.com.ec','Error Cron PreRegistro',$e->getMessage());
			}
		}
	}
//elimina archivo de procesamiento
unlink(CRON_RUTA.'alerta_preregistro.txt');
?>

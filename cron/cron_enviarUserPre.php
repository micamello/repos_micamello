<?php 
require_once '../constantes.php';
require_once '../init.php';

$dominio = 'http://localhost/repos_micamello';

$file = fopen("correos.txt", "r");
$contador = 0;
$array_correos2 = $array_correos = array();
while(!feof($file)) {

	if($contador < 40){
    	array_push($array_correos, fgets($file));
    	$contador++;
    }else{
    	array_push($array_correos2, fgets($file));
    }
}
fclose($file);

$correos = "'".implode("','", $array_correos)."'";

if(!empty($correos)){

	$consultar_usuarios = Modelo_Usuario::busquedaPorCorreoMasivo($correos);
	foreach ($consultar_usuarios as $key => $usuario) {
		
	    $enlace = "<a href='https://www.micamello.com.ec/login/'>click aquí</a><br>"; 
	    $nombre_mostrar = ucfirst(utf8_encode($usuario['nombres'].' '.$usuario['apellidos']));                    
	    $email_body = Modelo_TemplateEmail::obtieneHTML("ACTIVACION_USER");
	    $email_body = str_replace("%NOMBRES%", $nombre_mostrar, $email_body);   
	    $email_body = str_replace("%USUARIO%", $usuario['username'], $email_body);   
	    $email_body = str_replace("%CORREO%", $usuario['correo'], $email_body);   
	    $email_body = str_replace("%PASSWORD%", 'User12345', $email_body);   
	    $email_body = str_replace("%ENLACE%", $enlace, $email_body);   
	    //Utils::envioCorreo($usuario["correo"],"Activación de Usuario",$email_body);     
	}

	$file = fopen("correos.txt", "w");
	foreach($array_correos2 as $c){
		fwrite($file, $c);
	}
	fclose($file);
}
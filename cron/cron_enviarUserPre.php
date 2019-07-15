<?php 
require_once '../constantes.php';
require_once '../init.php';

$dominio = 'http://localhost/repos_micamello';

$correos = "'mariana280790@gmail.com','fermaggy@hotmail.com'";
$consultar_usuarios = Modelo_Usuario::busquedaPorCorreoMasivo($correos);

foreach ($consultar_usuarios as $key => $usuario) {

    $enlace = "<a href='https://www.micamello.com.ec/login/'>click aquí</a>"; 
    $nombre_mostrar = ucfirst(utf8_encode($usuario['nombres'].' '.$usuario['apellidos']));                    
    $email_body = Modelo_TemplateEmail::obtieneHTML("ACTIVACION_USER");
    $email_body = str_replace("%NOMBRES%", $nombre_mostrar, $email_body);   
    $email_body = str_replace("%USUARIO%", $usuario['username'], $email_body);   
    $email_body = str_replace("%CORREO%", $usuario['correo'], $email_body);   
    $email_body = str_replace("%PASSWORD%", 'User12345', $email_body);   
    $email_body = str_replace("%ENLACE%", $enlace, $email_body);   
    Utils::envioCorreo($usuario["correo"],"Activación de Usuario",$email_body);     
    break;
}

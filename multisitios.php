<?php
require_once 'constantes.php';
require_once 'init.php';

//obtiene el dominio en el que estamos navegando actualmente
$resultado = Utils::obtieneDominio();
//si el dominio no existe
if (empty($resultado)){
	Utils::doRedirect(PUERTO.'://error/paginanoencontrada.html');
}

//validacion para sitio local
if ($_SERVER["HTTP_HOST"] == "localhost"){
	Utils::doRedirect(PUERTO.'://localhost/repos_micamello/');
}
//else se redirecciona al dominio real
else{
  Utils::doRedirect(PUERTO.'://'.$resultado["dominio"]);
}
?>
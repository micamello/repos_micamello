<?php
require_once RUTA_INCLUDES.'Database.php';
require_once RUTA_INCLUDES.'Utils.php';
require_once RUTA_INCLUDES.'/phpMailer/PHPMailerAutoload.php';
require_once RUTA_INCLUDES.'Aes.php';

function cargarClases($nombreClase) {
  $nombre_archivo = RUTA_FRONTEND . '/'. str_replace('_', '/', $nombreClase) . '.php';
  if (file_exists($nombre_archivo)) {
    include_once( $nombre_archivo );
  }
}

spl_autoload_register(null, false);
spl_autoload_register('cargarClases', false);

$GLOBALS['db'] = new Database( DBSERVIDOR, DBUSUARIO, DBCLAVE, DBNOMBRE);
$GLOBALS['db']->connect();

$_SUBMIT = array_merge($_POST, $_GET);

Utils::createSession(); 
?>
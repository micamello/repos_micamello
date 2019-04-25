<?php
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
    require_once 'constantes.php';
	require_once "GoogleAPI/vendor/autoload.php";
	// include 'multisitios.php';
	$gClient = new Google_Client();
	$gClient->setClientId(G_ID_CLIENTE);
	$gClient->setClientSecret(G_SECRET);
	$gClient->setApplicationName("MiCamello");
	// $gClient->setRedirectUri("https://www.micamello.com.ec/desarrollov3/google.php"); comentado
	$gClient->setRedirectUri(PUERTO.'://'.HOST.'/google.php');
	// $gClient->setRedirectUri("http://localhost/repos_micamello/includes/gg_api/google.php?tipo_user=1");
	
	$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");
?>
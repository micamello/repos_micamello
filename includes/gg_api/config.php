<?php
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

	require_once "GoogleAPI/vendor/autoload.php";
	$gClient = new Google_Client();
	$gClient->setClientId("87037959378-d851bc5825slmmu4qq2dr9ajspd0nhqo.apps.googleusercontent.com");
	$gClient->setClientSecret("U0XSH6-3nHpMZLNp6Cszy7Br");
	$gClient->setApplicationName("MiCamello");
	$gClient->setRedirectUri("http://localhost/repos_micamello/google.php?tipo_user=1");
	// $gClient->setRedirectUri("http://localhost/repos_micamello/includes/gg_api/google.php?tipo_user=1");
	
	$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");
?>

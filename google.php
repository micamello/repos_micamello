<?php
	require_once 'constantes.php';
	require_once 'init.php';
	include 'multisitios.php';

	require_once "includes/gg_api/config.php";


	$tipo_usuario = $_GET['tipo_user'];

	// print_r($tipo_usuario);
	// exit();

	if (isset($_SESSION['access_token']))
		$gClient->setAccessToken($_SESSION['access_token']);
	else if (isset($_GET['code'])) {
		$token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
		$_SESSION['access_token'] = $token;
	} 
	// else {
	// 	header('Location: login.php');
	// 	exit();
	// }

	$oAuth = new Google_Service_Oauth2($gClient);
	$userData = $oAuth->userinfo_v2_me->get();
	// print_r($userData);
	// exit();
	$obj_registro = new Controlador_Registro();
	$obj_registro->google($userData, $tipo_usuario);
?>
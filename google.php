<?php
	require_once 'constantes.php';
	require_once 'init.php';
	include 'multisitios.php';

	require_once "includes/gg_api/config.php";

try {
	unset($_SESSION['access_token']);
	if (isset($_GET['code'])) {
		$token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
		$_SESSION['access_token'] = $token;
	}else{
		throw new Exception("Ha cancelado el registro");
	}
} catch (Exception $e) {
	$obj_registro = new Utils();
	$_SESSION['mostrar_error'] = $e->getMessage();
	$obj_registro->doRedirect(PUERTO.'://'.HOST.'/registro/');
}
	$oAuth = new Google_Service_Oauth2($gClient);
	$userData = $oAuth->userinfo_v2_me->get();
	$obj_registro = new Controlador_Registro();
	$obj_registro->google($userData);
?>
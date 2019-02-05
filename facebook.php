<?php
	require_once 'constantes.php';
	require_once 'init.php';
	require_once 'multisitios.php';
	require_once "includes/fb_api/config.php";
	$tipo_usuario = $_GET['tipo_user'];
	$_SESSION['FBRLH_state']=$_GET['state'];
	try {
		$accessToken = $helper->getAccessToken();
	} catch (\Facebook\Exceptions\FacebookResponseException $e) {
		echo "Response Exception: " . $e->getMessage();
		exit();
	} catch (\Facebook\Exceptions\FacebookSDKException $e) {
		echo "SDK Exception: " . $e->getMessage();
		exit();
	}
	if (!$accessToken) {
		header('Location: index.php');
		exit();
	}
	$oAuth2Client = $FB->getOAuth2Client();
	if (!$accessToken->isLongLived())
		$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
	$response = $FB->get("/me?fields=id, first_name, last_name, email, picture.type(large)", $accessToken);
	$userData = $response->getGraphNode()->asArray();
	$_SESSION['access_token'] = (string) $accessToken;
	// print_r($userData);
	// exit();
	$obj_registro = new Controlador_Registro();
	$obj_registro->facebook($userData, $tipo_usuario);
?>
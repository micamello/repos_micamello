<?php
	require_once "includes/fb_api/config.php";

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
		header('Location: login.php');
		exit();
	}

	$oAuth2Client = $FB->getOAuth2Client();
	if (!$accessToken->isLongLived())
		$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);

	$response = $FB->get("/me?fields=id, first_name, last_name, email, picture.type(large)", $accessToken);
	$userData = $response->getGraphNode()->asArray();
	$_SESSION['userData'] = $userData;
	print_r($_SESSION['userData']);
	exit();
	$_SESSION['access_token'] = (string) $accessToken;
	header('Location: index.php');
	exit();
?>
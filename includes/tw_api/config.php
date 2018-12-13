<?php 
require_once 'constantes.php';
require_once 'init.php';
// include 'multisitios.php';

require "includes/tw_api/twitter/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
	$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
	setcookie("oauth_token", $request_token['oauth_token'], time() + (86400 * 30), "/");
	setcookie("oauth_token_secret", $request_token['oauth_token_secret'], time() + (86400 * 30), "/");

 ?>
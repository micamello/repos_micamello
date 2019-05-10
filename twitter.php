<?php
require_once 'constantes.php';
require_once 'init.php';
include 'multisitios.php';
require "includes/tw_api/Twitter/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;
if (isset($_REQUEST['oauth_verifier'], $_REQUEST['oauth_token']) && $_REQUEST['oauth_token'] == $_COOKIE['oauth_token']) {			   
//In project use this session to change login header after successful login 

	$request_token = [];
	$request_token['oauth_token'] = $_COOKIE['oauth_token'];

	$request_token['oauth_token_secret'] = $_COOKIE['oauth_token_secret'];
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);
	$access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));

	$_SESSION['access_token'] = $access_token;
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	$user = $connection->get("account/verify_credentials", ['include_email' => 'true']);

	$userData = (array) $user;
	$obj_registro = new Controlador_Registro();
	$obj_registro->twitter($userData);
}
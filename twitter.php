<?php
require_once 'constantes.php';
require_once 'init.php';
include 'multisitios.php';
require "includes/tw_api/twitter/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;
if (isset($_REQUEST['oauth_verifier'], $_REQUEST['oauth_token']) && $_REQUEST['oauth_token'] == $_COOKIE['oauth_token']) {			   
//In project use this session to change login header after successful login 

	$request_token = [];
	$request_token['oauth_token'] = $_COOKIE['oauth_token'];

	$request_token['oauth_token_secret'] = $_COOKIE['oauth_token_secret'];
	$consumerKey = "08HrTpu25IsM20tskQWUrYlJz";
	$consumerSecret = "CYblyiO8sPJO6tVbGAmRnxgSTnaYLazYFDz6FA0Tez5Kj80oY2";
	$connection = new TwitterOAuth($consumerKey, $consumerSecret, $request_token['oauth_token'], $request_token['oauth_token_secret']);
	$access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));
	// print_r($access_token);
	$_SESSION['access_token'] = $access_token;
	$connection = new TwitterOAuth($consumerKey, $consumerSecret, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	$user = $connection->get("account/verify_credentials", ['include_email' => 'true']);
	// echo "<pre>";
    	// $_SESSION['user'] = $user;
	$userData = (array) $user;
	$tipo_usuario = $_GET['tipo_usuario'];
   	// print_r($user_data['screen_name']."-----".$user_data['email']);
   	// print_r($user);


    // echo "<pre>";
    // exit();
	$obj_registro = new Controlador_Registro();
	$obj_registro->twitter($userData, $tipo_usuario);
}
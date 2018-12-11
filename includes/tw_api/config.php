<?php 
// print_r("eder");
// session_start();
// require_once 'init.php';
require_once 'constantes.php';
require_once 'init.php';
include 'multisitios.php';

require "includes/tw_api/twitter/autoload.php";
// print_r("eder");
use Abraham\TwitterOAuth\TwitterOAuth;
// print_r("eder");
	
// $consumerKey = "9iUeqBjdjPQqDa9dkfgx661VJ";
// $consumerSecret = "AmPNb3URABiG11spadOiZ6O4D9B47DAaNarjiYH7CvBNyre9On";
// $accessToken = "1055523335109533696-f2bxT3JQIyQKS33sSdGCUm1WSrIph7";
// $accessTokenSecret = "YOLaQOTgpJtbi5GHAobjtcDxemsYUizplX4csYTkO84wk";
// print_r("eder");
// exit();
define('OAUTH_CALLBACK', 'https://www.micamello.com.ec/desarrollov2/twitter.php?tipo_usuario=1');

	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
	// print_r($connection);
	$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
	// print_r($request_token);
	// unset($_SESSION['oauth_token']);
	// unset($_SESSION['oauth_token_secret']);
	// $name = "oauth_token";
	// $valor = $request_token['oauth_token'];
	// $_SESSION['oauth_token'] = $request_token['oauth_token'];
	// $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
	// print_r("eder");
// exit();
	setcookie("oauth_token", $request_token['oauth_token'], time() + (86400 * 30), "/");
	setcookie("oauth_token_secret", $request_token['oauth_token_secret'], time() + (86400 * 30), "/");
	// print_r($_SESSION);
	// print_r($_SESSION['oauth_token']);
	// sleep(5);
	// exit();
	// exit();
 ?>
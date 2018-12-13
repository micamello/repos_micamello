<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    require_once "constantes.php";
	require_once "Facebook/autoload.php";

	$FB = new \Facebook\Facebook([
		'app_id' => FB_ID_CLIENTE,
		'app_secret' => FB_CLIENTE_SECRET,
		'default_graph_version' => 'v2.10'
	]);

	$helper = $FB->getRedirectLoginHelper();
?>
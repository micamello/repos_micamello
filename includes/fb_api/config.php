<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

	require_once "Facebook/autoload.php";

	$FB = new \Facebook\Facebook([
		'app_id' => '706585049706744',
		'app_secret' => '247391a884159a515d149502b0f56aba',
		'default_graph_version' => 'v2.10'
	]);

	$helper = $FB->getRedirectLoginHelper();
?>
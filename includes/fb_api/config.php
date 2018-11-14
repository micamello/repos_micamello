<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

	require_once "Facebook/autoload.php";

	$FB = new \Facebook\Facebook([
		'app_id' => '182819669263964',
		'app_secret' => 'f5ce73ed2f5bd3dff264b2589cdb43ca',
		'default_graph_version' => 'v2.10'
	]);

	$helper = $FB->getRedirectLoginHelper();
?>
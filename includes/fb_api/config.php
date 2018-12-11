<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

	require_once "Facebook/autoload.php";

	$FB = new \Facebook\Facebook([
		'app_id' => '388679925219540',
		'app_secret' => '59bc4e9abca15fa0ef6583a735c688fc',
		'default_graph_version' => 'v2.10'
	]);

	$helper = $FB->getRedirectLoginHelper();
?>
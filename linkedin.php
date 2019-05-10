<?php
    require_once 'constantes.php';
    require_once 'init.php';
    require_once 'multisitios.php';

if (! session_id()) {
    session_start();
}
    require ('includes/lk_api/oauth/http.php');
    require ('includes/lk_api/oauth/oauth_client.php');
    
    
    $client = new oauth_client_class();
    
    $client->debug = false;
    $client->debug_http = true;
    $client->redirect_uri = PUERTO.'://'.HOST.'/linkedin.php';
    $client->server = "LinkedIn";
    $client->client_id = LK_ID_CLIENTE;
    $client->client_secret = LK_SECRET;
    $client->scope = LK_SCOPE;
    
    if (($success = $client->Initialize())) {
        if (($success = $client->Process())) {
            if (strlen($client->authorization_error)) {
                $client->error = $client->authorization_error;
                $success = false;
            } elseif (strlen($client->access_token)) {
                $success = $client->CallAPI('http://api.linkedin.com/v1/people/~:(id,email-address,first-name,last-name,picture-url,public-profile-url,formatted-name)', 'GET', array(
                    'format' => 'json'
                ), array(
                    'FailOnAccessError' => true
                ), $user);
                
            }
        }
    }
    if ($client->exit) {
        exit();
    }
    if ($success) {
        // Do your code with the Linkedin Data
        $success = $client->Finalize($success);
        $data_user =  (array) $user;
        $obj_registro = new Controlador_Registro();
        $obj_registro->linkedin($data_user);
    } else {
        $error = $client->error;
    }

?>
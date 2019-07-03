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
    
    $client->debug = 1;
    $client->debug_http = 1;
    $client->redirect_uri = PUERTO.'://'.HOST.'/linkedin.php';
    $client->client_id = LK_ID_CLIENTE;
    $client->client_secret = LK_SECRET;
    $client->scope = LK_SCOPE;
    // $client->client_id = LIN_CLIENT_ID;
    // $client->client_secret = LIN_CLIENT_SECRET;
    // $client->redirect_uri = LIN_REDIRECT_URL;
    // $client->scope = LIN_SCOPE;
    // $client->debug = 1;
    // $client->debug_http = 1;
    $application_line = __LINE__;
    
    if($success = $client->Initialize()){
        if(($success = $client->Process())){
            if(strlen($client->authorization_error)){
                $client->error = $client->authorization_error;
                $success = false;
            }elseif(strlen($client->access_token)){
                $success = $client->CallAPI(
                    'https://api.linkedin.com/v2/me?projection=(id,firstName,lastName,profilePicture(displayImage~:playableStreams))', 
                    'GET', array(
                        'format'=>'json'
                    ), array('FailOnAccessError'=>true), $userInfo);
                $emailRes = $client->CallAPI(
                    'https://api.linkedin.com/v2/emailAddress?q=members&projection=(elements*(handle~))', 
                    'GET', array(
                        'format'=>'json'
                    ), array('FailOnAccessError'=>true), $userEmail);
            }
        }
    }
    if ($client->exit) {
        exit();
    }
    if ($success) {
        $dataUser  = array(
                     "firstName"=>$userInfo->firstName->localized->es_ES,
                     "lastName"=>$userInfo->lastName->localized->es_ES, 
                     "emailAddress"=>$userEmail->elements[0]->{'handle~'}->emailAddress);
        // Do your code with the Linkedin Data
        $success = $client->Finalize($success);
        $data_user = $dataUser;
        $obj_registro = new Controlador_Registro();
        $obj_registro->linkedin($data_user);
    } else {
        $error = $client->error;
    }

?>
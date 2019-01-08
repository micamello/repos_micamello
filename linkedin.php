<?php
    require_once 'constantes.php';
    require_once 'init.php';
    require_once 'multisitios.php';

if (! session_id()) {
    session_start();
}
$tipo_usuario = $_GET['tipo_usuario'];
if (empty($_GET["action"])) {
    // require_once 'includes/lk_api/config.php';
    require ('includes/lk_api/oauth/http.php');
    require ('includes/lk_api/oauth/oauth_client.php');
    
    // if ($_GET["oauth_problem"] != "") {
    //     $error1 = $_GET["oauth_problem"];
    // }
    
    $client = new oauth_client_class();
    
    $client->debug = false;
    $client->debug_http = true;
    $client->redirect_uri = LK_REDIRECT_URI;
    $client->server = "LinkedIn";
    $client->client_id = LK_ID_CLIENTE;
    $client->client_secret = LK_SECRET;
    $client->scope = LK_SCOPE;
    print_r("eder");exit();
    
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
        // print_r($success);

        $success = $client->Finalize($success);
        $data_user =  (array) $user;
        // print_r($user->emailAddress);
        // exit();
        $obj_registro = new Controlador_Registro();
        $obj_registro->linkedin($data_user, $tipo_usuario);
        // unset($_SESSION['OAUTH_ACCESS_TOKEN']);
    }
    if ($client->exit) {
        exit();
    }
    if ($success) {
        // Do your code with the Linkedin Data
    } else {
        $error = $client->error;
    }
} else {
    $_SESSION = array();
    unset($_SESSION);
    session_destroy();
}
?>
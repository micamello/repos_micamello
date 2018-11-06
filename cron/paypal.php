<?php
require_once '../constantes.php';
require_once '../init.php';

try{
  $ipn = new PaypalIPN();
  $ipn->useSandbox();
  $verified = $ipn->verifyIPN();
  if ($verified) {
    $vl_insert = array();
    $vl_insert["fecha"] = date('Y-m-d H:i:s');
    $vl_insert["mc_gross"] = $_POST["mc_gross"];
    $vl_insert["protection_eligibility"] = $_POST["protection_eligibility"];
    $vl_insert["address_status"] = $_POST["address_status"];
    $vl_insert["payer_id"] = $_POST["payer_id"];
    $vl_insert["address_street"] = $_POST["address_street"];
    $vl_insert["payment_date"] = $_POST["payment_date"];
    $vl_insert["payment_status"] = $_POST["payment_status"];
    $vl_insert["charset"] = $_POST["charset"];
    $vl_insert["address_zip"] = $_POST["address_zip"];
    $vl_insert["first_name"] = $_POST["first_name"];
    $vl_insert["mc_fee"] = $_POST["mc_fee"];
    $vl_insert["address_country_code"] = $_POST["address_country_code"];
    $vl_insert["address_name"] = $_POST["address_name"];
    $vl_insert["notify_version"] = $_POST["notify_version"];
    $vl_insert["custom"] = $_POST["custom"];
    $vl_insert["payer_status"] = $_POST["payer_status"];
    $vl_insert["business"] = $_POST["business"];
    $vl_insert["address_country"] = $_POST["address_country"];
    $vl_insert["address_city"] = $_POST["address_city"];
    $vl_insert["quantity"] = $_POST["quantity"];
    $vl_insert["verify_sign"] = $_POST["verify_sign"];
    $vl_insert["payer_email"] = $_POST["payer_email"];
    $vl_insert["txn_id"] = $_POST["txn_id"];
    $vl_insert["payment_type"] = $_POST["payment_type"];
    $vl_insert["last_name"] = $_POST["last_name"];
    $vl_insert["address_state"] = $_POST["address_state"];
    $vl_insert["receiver_email"] = $_POST["receiver_email"];
    $vl_insert["payment_fee"] = $_POST["payment_fee"];
    $vl_insert["receiver_id"] = $_POST["receiver_id"];
    $vl_insert["txn_type"] = $_POST["txn_type"];
    $vl_insert["item_name"] = $_POST["item_name"];
    $vl_insert["mc_currency"] = $_POST["mc_currency"];
    $vl_insert["item_number"] = $_POST["item_number"];
    $vl_insert["residence_country"] = $_POST["residence_country"];
    $vl_insert["test_ipn"] = $_POST["test_ipn"];
    $vl_insert["transaction_subject"] = $_POST["transaction_subject"];
    $vl_insert["payment_gross"] = $_POST["payment_gross"];
    $vl_insert["ipn_track_id"] = $_POST["ipn_track_id"];
    Utils::envioCorreo("desarrollo@micamello.com.ec","CRON PAYPAL",print_r($_POST,true));
    if (!Modelo_Paypal::guardar($vl_insert)){
      throw new Exception("Error Insert IPN Paypal");
    } 
  }
}
catch(Exception $e){
  Utils::envioCorreo('desarrollo@micamello.com.ec',$e->getMessage(),print_r($_POST,true));
}
header("HTTP/1.1 200 OK");
?>
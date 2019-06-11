<?php
function getCurlData($url){
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_TIMEOUT, 120);
$curlData = curl_exec($curl);
curl_close($curl);
return $curlData;
}
?>
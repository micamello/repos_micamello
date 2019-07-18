<?php
require('C:/wamp64/www/repos_micamello/includes/mailin-smtp-api/Mailin.php');

$mailin = new Mailin('https://api.sendinblue.com/v2.0', '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', 5000);    //Optional parameter: Timeout in MS
$mailin->
addTo('ffueltala@gmail.com', 'Fernanda Fueltala')->
setFrom('ffueltala@gmail.com', 'Fernanda Fueltala')->
setReplyTo('ffueltala@gmail.com','Fernanda Fueltala')->
setSubject('Escriba el asunto aquí')->
setText('Hola')->
setHtml('<strong>Hola</strong>')->setAttachments(array('ejemplo.txt'));
$res = $mailin->send();


print_r($res);
?>
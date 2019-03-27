<?php
ignore_user_abort( true );
ini_set("max_execution_time", "0");
ini_set("max_input_time", "0");
ini_set('memory_limit', "768M");
set_time_limit(0);

/*Script que consultara diariamente las ofertas aprobadas para envio de correos a los candidatos acorde a sus subareas seleccionadas*/

require_once '../constantes.php';
require_once '../init.php';

//pregunta si ya se esta ejecutando el cron sino crea el archivo
$resultado = file_exists(CRON_RUTA.'alerta_ofertas.txt');
if ($resultado){
  exit;
}
else{
  Utils::crearArchivo(CRON_RUTA,'alerta_ofertas.txt','');
}

$result_set = Modelo_Usuario::obtieneTodosCandidatos();
while( $rows = mysqli_fetch_array( $result_set, Database::ASSOC) ){
	$mail_ofertas = ""; 
	$arr_areas = Modelo_UsuarioxArea::consultarSubareas($rows["id_usuario"]);
  $str_areas = implode($arr_areas,',');
  if (empty($arr_areas)){
  	continue;
  }
  echo "<br>usuario: ".$rows["id_usuario"]." / ".$rows["nombres"]." / ".$rows["apellidos"]."<br>";
  echo "areas: ".$str_areas."<br>";  
	$ofertas = Modelo_Oferta::ofertasDiarias($rows["id_pais"],$str_areas);
  if (empty($ofertas)){
  	continue;
  }

  $sucursal = Modelo_Sucursal::consultaxPais($rows["id_pais"]);

  foreach($ofertas as $oferta){    
    $mail_ofertas .= utf8_encode($oferta["titulo"])."<br>";
    $mail_ofertas .= utf8_encode($oferta["empresa"])." - ".utf8_encode($oferta["provincia"])." / ".utf8_encode($oferta["ciudad"])."<br>";
    $mail_ofertas .= "<a href='".PUERTO."://".$sucursal["dominio"]."/desarrollov3/detalleOferta/oferta/".Utils::encriptar($oferta["id_ofertas"])."/'>Ver Oferta</a><br><br>";
    echo $mail_ofertas."<br>";
  }
  //envio de correo al candidato
  if (!empty($mail_ofertas)){
    $email_body = Modelo_TemplateEmail::obtieneHTML("OFERTAS_LABORALES");
    $email_body = str_replace("%NOMBRES%", $nombre_mostrar, $email_body);   
    $email_body = str_replace("%OFERTAS%", $mail_ofertas, $email_body);   
    Utils::envioCorreo($rows["correo"],"Ofertas Laborales",$email_body);     
  }
}

//elimina archivo de procesamiento
unlink(CRON_RUTA.'alerta_ofertas.txt');
?>
<?php
ignore_user_abort( true );
ini_set("max_execution_time", "0");
ini_set("max_input_time", "0");
ini_set('memory_limit', "768M");
set_time_limit(0);

/*Script que consultara diariamente las ofertas aprobadas para envio de correos a los candidatos acorde a sus areas y nivel seleccionado*/

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
while( $rows = mysqli_fetch_array( $result_set, Database::ASSOC ) ){
	$mail_ofertas = ""; 
	$arr_areas = Modelo_UsuarioxArea::obtieneListado($rows["id_usuario"]);
  $str_areas = implode($arr_areas,',');
  $arr_niveles = Modelo_UsuarioxNivel::obtieneListado($rows["id_usuario"]);
  $str_niveles = implode($arr_niveles,',');
  if (empty($arr_areas) || empty($arr_niveles)){
  	continue;
  }
  echo "<br>usuario: ".$rows["id_usuario"]." / ".$rows["nombres"]." / ".$rows["apellidos"]."<br>";
  echo "areas: ".$str_areas."<br>";
  echo "interes: ".$str_niveles."<br>";
	$ofertas = Modelo_Oferta::ofertasDiarias($rows["id_pais"],$str_areas,$str_niveles);
  if (empty($ofertas)){
  	continue;
  }

  $sucursal = Modelo_Sucursal::consultaxPais($rows["id_pais"]);

  foreach($ofertas as $oferta){    
    $mail_ofertas .= utf8_encode($oferta["titulo"])."<br>";
    $mail_ofertas .= utf8_encode($oferta["empresa"])." - ".utf8_encode($oferta["provincia"])." / ".utf8_encode($oferta["ciudad"])."<br>";
    $mail_ofertas .= "<a href='".PUERTO."://".$sucursal["dominio"]."/desarrollov2/detalleOferta/oferta/".$oferta["id_ofertas"]."/'>Ver Oferta</a><br><br>";
    echo $mail_ofertas."<br>";
  }
  //envio de correo al candidato
  if (!empty($mail_ofertas)){
    // $email_body = "Estimado ".utf8_encode($rows["nombres"])." ".utf8_encode($rows["apellidos"]).", le informamos las siguientes ofertas que se ajustan a su perfil:<br><br>";    
    // $email_body .= $mail_ofertas;
    // Utils::envioCorreo($rows["correo"],"Ofertas Laborales",$email_body); 

    $nombre_mostrar = utf8_encode($rows["nombres"])." ".utf8_encode($rows["apellidos"]);
    $datos_correo = array("tipo"=>9, "correo"=>$rows["correo"], "mensaje"=>$mail_ofertas, "nombre"=>$nombre_mostrar, "type"=>TIPO['alerta_oferta']);
    Utils::enviarEmail($datos_correo);   
  }
}

//elimina archivo de procesamiento
unlink(CRON_RUTA.'alerta_ofertas.txt');
?>
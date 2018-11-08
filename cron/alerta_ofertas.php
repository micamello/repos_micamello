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
  foreach($ofertas as $oferta){
    echo "oferta: ".$oferta["titulo"]."<br>";
    $mail_ofertas .= utf8_encode($oferta["titulo"])."<br>";
    $mail_ofertas .= utf8_encode($empresa["nombres"])." - ".utf8_encode($oferta["provincia"])."/".utf8_encode($oferta["ciudad"])."<br><br>";
  }
}

//elimina archivo de procesamiento
unlink(CRON_RUTA.'alerta_ofertas.txt');
?>
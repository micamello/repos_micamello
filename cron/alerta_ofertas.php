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

if(!file_exists(CRON_RUTA.'fecha_'.date('Y-m-d').'.txt')){
  exit();
}

$resultado = file_exists(CRON_RUTA.'alerta_ofertas.txt');
if ($resultado){
  exit;
}
else{
  Utils::crearArchivo(CRON_RUTA,'alerta_ofertas.txt','');
}

$result_set = Modelo_Usuario::obtieneTodosCandidatos();
$fechaInicial = new DateTime("now");

$correosEnviados = 0;
$id_ultimoUsuario = 0;

$i = 0;
while( $rows = mysqli_fetch_array( $result_set, Database::ASSOC) ){
  // echo "(puede viajar: ".$rows['viajar']. " puede cambiar residencia: ".$rows['residencia'].")<br>";
  // var_dump($rows);
  $i++;
  if($result_set->num_rows == $i){
    Utils::crearArchivo(CRON_RUTA, 'fecha_'.date('Y-m-d', strtotime("+1 day")).'.txt', '');
    unlink(CRON_RUTA.'fecha_'.date('Y-m-d').'.txt');
  }
  echo "correos enviados: ".$correosEnviados."<br>Id_usuario:".$rows['id_usuario']." <br>";
  $fechaFin = new DateTime("now");
  $diferencia = $fechaInicial->diff($fechaFin)->format("%H:%i:%s");
  $diferencia = explode(':', $diferencia);
  $minutosDiff = ($diferencia[0]*60) + $diferencia[1] + ($diferencia[2]/60);

	if($correosEnviados >= 5 || $minutosDiff >= 60){
    if($ultimousuariofile = file_exists(CRON_RUTA.'ultimousuario.txt')){
      unlink(CRON_RUTA.'ultimousuario.txt');
    }
    Utils::crearArchivo(CRON_RUTA, 'ultimousuario.txt', $rows["id_usuario"]);
    break;
  }else{
    $id_ultimoUsuario = $rows["id_usuario"];
    if($ultimousuariofile = file_exists(CRON_RUTA.'ultimousuario.txt')){
      $file = fopen("ultimousuario.txt", "r");
      $contenido = fgets($file);
      echo "ultimo usuario row: ".$id_ultimoUsuario." ----- ".$contenido."<br>";
      if((int)$id_ultimoUsuario != (int)$contenido){
        continue;
      }
      fclose($file);
      unlink(CRON_RUTA.'ultimousuario.txt');
    }

    $mail_ofertas = ""; 
    $arr_areas = Modelo_UsuarioxArea::consultarSubareas($rows["id_usuario"]);
    $str_areas = implode($arr_areas,',');
    if (empty($arr_areas)){
      continue;
    }
    echo "<br>usuario: ".$rows["id_usuario"]." / ".$rows["nombres"]." / ".$rows["apellidos"]."<br>";
    echo "areas: ".$str_areas."<br>";  
    $ofertas = Modelo_Oferta::ofertasDiarias($rows["id_pais"],$str_areas, $rows);
    if (empty($ofertas)){
      continue;
    }

    $sucursal = Modelo_Sucursal::consultaxPais($rows["id_pais"]);

    foreach($ofertas as $oferta){    
      $mail_ofertas .= utf8_encode($oferta["titulo"])."<br>";
      $nombre_empresa = ($oferta["confidencial"]) ? "Nombre de la Empresa - Confidencial" : utf8_encode($oferta["empresa"]);
      $mail_ofertas .= $nombre_empresa." - ".utf8_encode($oferta["provincia"])." / ".utf8_encode($oferta["ciudad"])."<br>";
      $mail_ofertas .= "<a href='".PUERTO."://".$sucursal["dominio"]."/detalleOferta/oferta/".Utils::encriptar($oferta["id_ofertas"])."/'>Ver Oferta</a><br><br>";
      echo $mail_ofertas."<br>";
    }
    //envio de correo al candidato
    if (!empty($mail_ofertas)){
      $nombre_mostrar = ucfirst(utf8_encode($rows["nombres"]))." ".ucfirst(utf8_encode($rows["apellidos"]));
      $email_body = Modelo_TemplateEmail::obtieneHTML("OFERTAS_LABORALES");
      $email_body = str_replace("%NOMBRES%", $nombre_mostrar, $email_body);   
      $email_body = str_replace("%OFERTAS%", $mail_ofertas, $email_body);
      Utils::envioCorreo("edervpozo@gmail.com","Ofertas Laborales",$email_body); 
      
      $correosEnviados++;
      echo "<br><br><br>";  
    }
  }
}
//elimina archivo de procesamiento
// unlink(CRON_RUTA."ultimousuario.txt");
unlink(CRON_RUTA.'alerta_ofertas.txt');
?>
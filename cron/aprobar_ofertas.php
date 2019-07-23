<style type="text/css">
  .boton_personalizado{
    text-decoration: none;
    padding: 5px;
    font-weight: 600;
    font-size: 20px;
    color: #ffffff;
    background-color: #1883ba;
    border-radius: 6px;
    border: 1px solid #0016b0;
  }
</style>

<?php 
require_once '../constantes.php';
require_once '../init.php';

$dominio = 'https://www.micamello.com.ec';

if(isset($_GET['id_oferta']) && !isset($_GET['estado'])){

	$id_oferta = $_GET['id_oferta'];
	$consultar_oferta = Modelo_Oferta::consultarInfoOfertaEmpresa($id_oferta);

	echo '<b>Empresa:</b> '.$consultar_oferta["empresa"].'<br>';
	echo '<b>Título:</b> '.$consultar_oferta["titulo"].'<br>';
	echo '<b>Estado:</b> '.(($consultar_oferta["estado"]==1)?'Activa<br>':'Rechazada o Inactiva<br>');
	echo '<b>Descripción:</b> '.$consultar_oferta["descripcion"].'<br><br>';

	echo '<a class="boton_personalizado" href="'.$dominio.'/cron/aprobar_ofertas.php?id_oferta='.$id_oferta.'&estado=0">Rechazar</a>';
	echo '<a class="boton_personalizado" href="'.$dominio.'/cron/aprobar_ofertas.php?id_oferta='.$id_oferta.'&estado=1">Aprobar</a>';

}else if(isset($_GET['id_oferta']) && isset($_GET['estado'])){

	$id_oferta = $_GET['id_oferta'];
	$consultar_oferta = Modelo_Oferta::consultarInfoOfertaEmpresa($id_oferta);

	//1 activar - 0 rechazar
	$estado = $_GET['estado'];

	if($estado == 1){
		$email_subject = "Activación de oferta"; 
		$email_body = Modelo_TemplateEmail::obtieneHTML("OFERTA_APROBADA");   
		Modelo_Oferta::desactivarOferta($id_oferta,Modelo_Oferta::ACTIVA);                
	}else{
		$email_subject = "Rechazo de oferta"; 
		$email_body = Modelo_TemplateEmail::obtieneHTML("OFERTA_RECHAZADA"); 
		Modelo_Oferta::desactivarOferta($id_oferta);   
	}

	$email_body = str_replace("%NOMBRES%", utf8_encode($consultar_oferta["empresa"]), $email_body);   
	$email_body = str_replace("%NOMBRE_OFERTA%", utf8_encode($consultar_oferta["titulo"]), $email_body);  

	Utils::envioCorreo($consultar_oferta["correo"],$email_subject,$email_body);
	echo 'YA ENVIO EL CORREO A '.$consultar_oferta["correo"];

}else{
	echo "ENVIAR POR PARAMETRO EL ID_OFERTA";
}
?>

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
    cursor:pointer;
  }
</style>

<?php
require_once '../constantes.php';
require_once '../init.php';

$dominio = "https://www.micamello.com.ec";

if(isset($_GET['id_empresa']) && !isset($_GET['estado'])){
	
	$id_empresa = $_GET['id_empresa'];
	$datos_empresa = Modelo_Usuario::consultarInfoEmpresa($id_empresa);

	echo '<b>Username:</b> '.$datos_empresa["username"].'<br>';
	echo '<b>Nombres:</b> '.$datos_empresa["nombres"].'<br>';
	echo '<b>Estado:</b> '.(($datos_empresa["estado"]==1)?'Activa<br>':'Rechazada o Inactiva<br>');
	echo '<b>RUC:</b> '.$datos_empresa["dni"].'<br>';
	echo '<b>Teléfono:</b> '.$datos_empresa["telefono"].'<br>';
	echo '<b>Correo:</b> '.$datos_empresa["correo"].'<br><br>';
	echo '<b>Razones:</b> <br><form role="form" name="aprobacionEmpresa" id="aprobacionEmpresa" method="post" action="'.$dominio.'/cron/empresa_aprobada.php?id_empresa='.$id_empresa.'&estado=0"><textarea id="razones" name="razones" style="margin: 0px; width: 666px; height: 164px;"></textarea><br><br>';
	echo '<button style="font-size: 20px;" class="boton_personalizado" type="submit">Rechazar</button></form>';
	echo '<a class="boton_personalizado" href="'.$dominio.'/cron/empresa_aprobada.php?id_empresa='.$id_empresa.'&estado=1">Aprobar</a>';

}else if(isset($_GET['id_empresa']) && isset($_GET['estado'])){
	
	$id_empresa = $_GET['id_empresa'];
	$datos_empresa = Modelo_Usuario::consultarInfoEmpresa($id_empresa);

	//1 activar - 0 rechazar
	$estado = $_GET['estado'];

	if($estado == 1){
		$email_subject = "Activación de Empresa"; 
		$template_nombre = "ACTIVACION_EMPRESA";       
		$email_body = Modelo_TemplateEmail::obtieneHTML($template_nombre); 
	}else{
		$email_subject = "Aprobación de Empresa denegada"; 
		$template_nombre = "APROBACION_DENEGADA";   
		$razones = $_POST['razones'];    
		$email_body = Modelo_TemplateEmail::obtieneHTML($template_nombre);
		$email_body = str_replace("%RAZONES%", $razones, $email_body);
	}

	Modelo_Usuario::actualizarEmpresa($id_empresa,$estado); 
	$email_body = str_replace("%USUARIO%", $datos_empresa["username"], $email_body);
	$email_body = str_replace("%NOMBRES%", $datos_empresa["nombres"], $email_body);
	$email_body = str_replace("%CORREO%", $datos_empresa["correo"], $email_body);
	
	$enlace = "<a href='".$dominio."/login/'>click aqu&iacute;</a><br>";      
	$email_body = str_replace("%ENLACE%", $enlace, $email_body);     
	Utils::envioCorreo($datos_empresa["correo"],$email_subject,$email_body); 
	echo 'YA ENVIO EL CORREO A '.$datos_empresa["correo"];

}else{
	echo "ENVIAR POR PARAMETRO EL ID_EMPRESA";
}

 
?>
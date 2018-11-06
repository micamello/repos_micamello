<?php
ignore_user_abort( true );
ini_set("max_execution_time", "0");
ini_set("max_input_time", "0");
ini_set('memory_limit', "768M");
set_time_limit(0);

/*Script para cancelar planes de la empresa/candidato, dependiendo del plan(es) contratados y fecha actual, si el usuario es de tipo empresa inactivar las ofertas publicadas con ese plan y si es candidato y el plan tiene 5 postulaciones restantes generar un registro en la tabla de alertas*/

require_once '../constantes.php';
require_once '../init.php';

//pregunta si ya se esta ejecutando el cron sino crea el archivo
$resultado = file_exists(CRON_RUTA.'procesando_cancelar_planes.txt');
if ($resultado){
 // exit;
}
else{
  Utils::crearArchivo(CRON_RUTA,'procesando_cancelar_planes.txt','');
}

$arrplanes = Modelo_UsuarioxPlan::planesActivosPagados();
if (!empty($arrplanes)){

	$fechaactual = date("Y-m-d H:i:s");
  	echo "Fecha Actual: ".$fechaactual."<br>";

	foreach($arrplanes as $usuarioplan){

		if ($usuarioplan["fecha_caducidad"] <= $fechaactual){

			echo "<br>Fecha de Caducidad: ".$usuarioplan["fecha_caducidad"]."<br>";
			echo "Usuario de tipo: ";
			if($usuarioplan["tipo_usuario"] == Modelo_Usuario::CANDIDATO){
				echo "Candidato<br>";
			}else{
				echo "Empresa<br>";
			}

			//Desactivar el plan caducado del usuario 
			if (!Modelo_UsuarioxPlan::desactivarUsuarioxPlan($usuarioplan["id_usuario_plan"])){
				throw new Exception("Error al desactivar el plan caducado"); 
			}else{

				$tipo = 2; // Tipo de alerta (1.- web, 2.- correo y 3.- sms)
				if(!Modelo_Notificacion::existeNotificacion($usuarioplan["id_usuario"],$tipo,$usuarioplan["fecha_compra"])){

					echo '<br>Notificación vía correo empresa<br>';
					echo "El plan: ".utf8_encode($usuarioplan["nombre"])." del usuario ".$usuarioplan["nombres"]." fue desactivado<br>";
					echo $mensaje = "Estimado, ".utf8_encode($usuarioplan["nombres"])."<br> Su plan (".utf8_encode($usuarioplan["nombre"]).") contratado el ".$usuarioplan["fecha_compra"]." ha caducado.<br> De querer seguir haciendo uso de nuestro servicio debe activar un nuevo plan.<br>";
					Modelo_Notificacion::insertarNotificacion($usuarioplan["id_usuario"],$mensaje,$tipo);
				}
			}

			if($usuarioplan["tipo_usuario"] == Modelo_Usuario::EMPRESA){

				//Obtener las ofertas creadas o asignadas al plan si es empresa
				if (!Modelo_Oferta::desactivarOferta($usuarioplan["id_usuario_plan"])){
                	throw new Exception("Error al desactivar la oferta"); 
                }else{
                	echo "Fueron desactivadas todas las ofertas registradas con el plan: ".utf8_encode($usuarioplan["nombre"])." contratado el ".$usuarioplan["fecha_compra"]."<br>";
                }  
			}

		}else if($usuarioplan["tipo_usuario"] == Modelo_Usuario::CANDIDATO){

			$resultado = Modelo_UsuarioxPlan::publicacionesRestantes($usuarioplan["id_usuario"]);

			$tipo = 2; // Tipo de alerta (1.- web, 2.- correo y 3.- sms) 
			if($resultado['p_restantes'] == 0){

				if(!Modelo_Notificacion::existeNotificacion($usuarioplan["id_usuario"],$tipo,$usuarioplan["fecha_compra"],$resultado['p_restantes'])){
					echo '<br>Notificación vía correo candidato<br>';
					echo $mensaje = "Estimado ".utf8_encode($usuarioplan["nombres"])." sus autopostulaciones se han agotado, debe activar un nuevo plan.<br>";
					Modelo_Notificacion::insertarNotificacion($usuarioplan["id_usuario"],$mensaje,$tipo);
				}

			}else if($resultado['p_restantes'] <= AUTOPOSTULACION_MIN){
				
				if(!Modelo_Notificacion::existeNotificacion($usuarioplan["id_usuario"],$tipo,$usuarioplan["fecha_compra"],$resultado['p_restantes'])){
					echo '<br>Notificación vía correo candidato<br>';
					echo $mensaje = "Estimado ".utf8_encode($usuarioplan["nombres"])." le restan: ".$resultado['p_restantes']." autopostulaciones, pronto deberá activar un nuevo plan.<br>";
					Modelo_Notificacion::insertarNotificacion($usuarioplan["id_usuario"],$mensaje,$tipo);
				}
			}
		}    
	}
} 

//elimina archivo de procesamiento
unlink(CRON_RUTA.'procesando_cancelar_planes.txt');
?>
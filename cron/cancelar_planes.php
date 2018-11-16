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
  exit;
}
else{
  Utils::crearArchivo(CRON_RUTA,'procesando_cancelar_planes.txt','');
}

$arrcandidato = Modelo_UsuarioxPlan::planesActivosPagados(Modelo_Usuario::CANDIDATO);
if (!empty($arrcandidato)){
	$fechaactual = date("Y-m-d H:i:s");
	foreach($arrcandidato as $usuarioplan){
		try{
			$infousuario = Modelo_Usuario::busquedaPorId($usuarioplan["id_usuario"],Modelo_Usuario::CANDIDATO);
		  if ($usuarioplan["fecha_caducidad"] <= $fechaactual){			
				$GLOBALS['db']->beginTrans();      
				//Desactivar el plan caducado del usuario 
				if (!Modelo_UsuarioxPlan::desactivarPlan($usuarioplan["id_usuario_plan"],Modelo_Usuario::CANDIDATO)){
					throw new Exception("Error al desactivar el plan caducado"); 
				}
										
				$mensaje = "Estimado, ".utf8_encode($infousuario["nombres"]." ".$infousuario["apellidos"]).",<br>Su plan (".utf8_encode($usuarioplan["nombre"]).") contratado el ".$usuarioplan["fecha_compra"]." ha caducado.<br> De querer seguir haciendo uso de nuestro servicio debe activar un nuevo plan.";
				
        $GLOBALS['db']->commit();
        echo "Plan de Candidato Desactivado ".$usuarioplan["id_usuario_plan"]."<br>";				
				Utils::envioCorreo($infousuario["correo"],"Cancelación de Plan",$mensaje);												
			}
			else{				
			  $resultado = Modelo_UsuarioxPlan::publicacionesRestantes($usuarioplan["id_usuario"]);
				if($resultado['p_restantes'] == 0){
	        $mensaje = "Estimado ".utf8_encode($infousuario["nombres"]." ".$infousuario["apellidos"]).",<br>De su plan contratado el ".$usuarioplan["fecha_compra"]." se han agotado las autopostulaciones.<br>De querer seguir haciendo uso de este servicio debe activar un nuevo plan.";	        
	        $result = enviarNotificaciones($usuarioplan["id_usuario"],$usuarioplan["fecha_compra"],$mensaje);					
	        if (!$result){
	        	throw new Exception("Error al enviar la notificacion"); 
	        }
	        echo "Notificacion de que acabo autopostulaciones a Candidato Enviado ".$usuarioplan["id_usuario"]."<br>";
				}
				else if($resultado['p_restantes'] <= AUTOPOSTULACION_MIN){				
          $mensaje = "Estimado ".utf8_encode($infousuario["nombres"]." ".$infousuario["apellidos"]).",<br>De su plan contratado el ".$usuarioplan["fecha_compra"]." le restan: ".$resultado['p_restantes']." autopostulaciones, pronto deber&aacute; activar un nuevo plan.";
				  $result = enviarNotificaciones($usuarioplan["id_usuario"],$usuarioplan["fecha_compra"],$mensaje);					
				  if (!$result){
	        	throw new Exception("Error al enviar la notificacion"); 
	        }
	        echo "Notificacion de que 5 o menos autopostulaciones a Candidato Enviado ".$usuarioplan["id_usuario"]."<br>";
				}
		  }
		}
    catch(Exception $e){
  	  $GLOBALS['db']->rollback();
  	  echo "Error en registro ".$usuarioplan['id_usuario_plan']."<br>";
      Utils::envioCorreo('desarrollo@micamello.com.ec','Error Cron Cancelar Planes',$e->getMessage());      
    }    
	}
} 

$arrempresa = Modelo_UsuarioxPlan::planesActivosPagados(Modelo_Usuario::EMPRESA);
if (!empty($arrempresa)){
	$fechaactual = date("Y-m-d H:i:s");
	foreach($arrempresa as $usuarioplan){
		try{
			$infousuario = Modelo_Usuario::busquedaPorId($usuarioplan["id_usuario"],Modelo_Usuario::EMPRESA);
		  if ($usuarioplan["fecha_caducidad"] <= $fechaactual){			
				$GLOBALS['db']->beginTrans();      
				//Desactivar el plan caducado del usuario 
				if (!Modelo_UsuarioxPlan::desactivarPlan($usuarioplan["id_usuario_plan"],Modelo_Usuario::EMPRESA)){
					throw new Exception("Error al desactivar el plan caducado"); 
				}
								
				$mensaje = "Estimado, ".utf8_encode($infousuario["nombres"]).",<br>Su plan (".utf8_encode($usuarioplan["nombre"]).") contratado el ".$usuarioplan["fecha_compra"]." ha caducado.<br>De querer seguir haciendo uso de nuestro servicio debe activar un nuevo plan.";
				        								
				//desactivar todas las ofertas del plan
				$ofertas = Modelo_Oferta::ofertasxUsuarioPlan($usuarioplan["id_usuario_plan"]);
				if (!empty($ofertas) && is_array($ofertas)){
					foreach($ofertas as $oferta){
						if (!Modelo_Oferta::desactivarOferta($oferta["id_ofertas"])){
		          throw new Exception("Error al desactivar la oferta"); 
		        }         
	        }
        }
				
				$GLOBALS['db']->commit();
				Utils::envioCorreo($infousuario["correo"],"Cancelación de Plan",$mensaje);				
				echo "Plan de Empresa Desactivado ".$usuarioplan["id_usuario"]."<br>";
			}			
		}
    catch(Exception $e){
  	  $GLOBALS['db']->rollback();
  	  echo "Error en registro ".$usuarioplan["id_usuario_plan"]."<br>";
      Utils::envioCorreo('desarrollo@micamello.com.ec','Error Cron Cancelar Planes',$e->getMessage());      
    }    
	}
} 

function enviarNotificaciones($idusu,$fchcompra,$mensaje){
	if(!Modelo_Notificacion::existeNotificacion($idusu,Modelo_Notificacion::WEB,$fchcompra)){		
		if (!Modelo_Notificacion::insertarNotificacion($idusu,$mensaje,Modelo_Notificacion::WEB)){
			return false;
		}
	}  
	return true;
}

//elimina archivo de procesamiento
unlink(CRON_RUTA.'procesando_cancelar_planes.txt');
?>
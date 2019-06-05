<?php
ignore_user_abort( true );
ini_set("max_execution_time", "0");
ini_set("max_input_time", "0");
ini_set('memory_limit', "768M");
set_time_limit(0);

$dominio = "www.micamello.com.ec/desarrollov3/";

/*Script para cancelar planes de la empresa/candidato, dependiendo del plan(es) contratados y fecha actual, si el usuario es de tipo empresa inactivar las ofertas publicadas con ese plan*/

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
	$fechaactual = date("Y-m-d");
	foreach($arrcandidato as $usuarioplan){
		try{
			$infousuario = Modelo_Usuario::busquedaPorId($usuarioplan["id_usuario"],Modelo_Usuario::CANDIDATO);
		  if (substr($usuarioplan["fecha_caducidad"],0,-9) < $fechaactual){			
				$GLOBALS['db']->beginTrans();      
				//Desactivar el plan caducado del usuario 
				if (!Modelo_UsuarioxPlan::desactivarPlan($usuarioplan["id_usuario_plan"],Modelo_Usuario::CANDIDATO)){
					throw new Exception("Error al desactivar el plan caducado"); 
				}													
				
        $GLOBALS['db']->commit();       
        envioCorreo($infousuario["nombres"]." ".$infousuario["apellidos"],$infousuario["correo"],$usuarioplan["nombre"],$usuarioplan["fecha_compra"]);				
        echo "Plan de Candidato Desactivado ".$usuarioplan["id_usuario_plan"]."<br>";				
			}
			/*else{				
			  $resultado = Modelo_UsuarioxPlan::publicacionesRestantes($usuarioplan["id_usuario"]);
				if($resultado['p_restantes'] == 0){
	        $mensaje = "Estimado ".utf8_encode($infousuario["nombres"]." ".$infousuario["apellidos"]).",<br>De su plan contratado el ".$usuarioplan["fecha_compra"]." se han agotado las autopostulaciones.<br>De querer seguir haciendo uso de este servicio debe activar un nuevo plan.";	        
	        //$result = enviarNotificaciones($usuarioplan["id_usuario"],$usuarioplan["fecha_compra"],$mensaje,Modelo_Usuario::CANDIDATO);					
	        if (!$result){
	        	throw new Exception("Error al enviar la notificacion"); 
	        }
	        echo "Notificacion de que acabo autopostulaciones a Candidato Enviado ".$usuarioplan["id_usuario"]."<br>";
				}
				else if($resultado['p_restantes'] <= AUTOPOSTULACION_MIN){				
          $mensaje = "Estimado ".utf8_encode($infousuario["nombres"]." ".$infousuario["apellidos"]).",<br>De su plan contratado el ".$usuarioplan["fecha_compra"]." le restan: ".$resultado['p_restantes']." autopostulaciones, pronto deber&aacute; activar un nuevo plan.";
				  //$result = enviarNotificaciones($usuarioplan["id_usuario"],$usuarioplan["fecha_compra"],$mensaje,Modelo_Usuario::CANDIDATO);					
				  if (!$result){
	        	throw new Exception("Error al enviar la notificacion"); 
	        }
	        echo "Notificacion de que 5 o menos autopostulaciones a Candidato Enviado ".$usuarioplan["id_usuario"]."<br>";
				}
		  }*/
		}
    catch(Exception $e){
  	  $GLOBALS['db']->rollback();
  	  echo "Error en registro candidato ".$usuarioplan['id_usuario_plan']."<br>";
      Utils::envioCorreo('desarrollo@micamello.com.ec','Error Cron Cancelar Planes',$e->getMessage());
    }    
	}
}

$arrempresa = Modelo_UsuarioxPlan::planesActivosEmpresas();
if (!empty($arrempresa)){
	$fechaactual = date("Y-m-d");
	foreach($arrempresa as $usuarioplan){
		try{
			$infousuario = Modelo_Usuario::busquedaPorId($usuarioplan["id_usuario"],Modelo_Usuario::EMPRESA);
      
		  if (substr($usuarioplan["fecha_caducidad"],0,-9) < $fechaactual){			
		  	
				$GLOBALS['db']->beginTrans();      
				//Desactivar el plan caducado del usuario 
				if (!Modelo_UsuarioxPlan::desactivarPlanEmpresa($usuarioplan["id_usuario_plan"],Modelo_Usuario::EMPRESA)){
					throw new Exception("Error al desactivar el plan caducado"); 
				}
												        							
				//desactivar todas las ofertas del plan
				$ofertas = Modelo_Oferta::ofertasxUsuarioPlan($usuarioplan["id_usuario_plan"]);
				if (!empty($ofertas) && is_array($ofertas)){
					foreach($ofertas as $oferta){
						if (!Modelo_Oferta::desactivarOferta($oferta["id_ofertas"],Modelo_Oferta::PORELIMINAR)){
		          throw new Exception("Error al desactivar la oferta"); 
		        }         
	        }
        }
				
				$GLOBALS['db']->commit();
        envioCorreo($infousuario["nombres"],$infousuario["correo"],$usuarioplan["nombre"],$usuarioplan["fecha_compra"]);
				echo "Plan de Empresa Desactivado ".$usuarioplan["id_usuario"]."<br>";
			}		
		}
    catch(Exception $e){
  	  $GLOBALS['db']->rollback();
  	  echo "Error en registro empresa ".$usuarioplan["id_usuario_plan"]."<br>";
      Utils::envioCorreo('desarrollo@micamello.com.ec','Error Cron Cancelar Planes',$e->getMessage()); 		
    }    
	}
} 

/*function enviarNotificaciones($idusu,$fchcompra,$mensaje,$tipousu){
	if(!Modelo_Notificacion::existeNotificacion($idusu,Modelo_Notificacion::WEB,$fchcompra)){				
		if (!Modelo_Notificacion::insertarNotificacion($idusu,$mensaje,$tipousu,'',Modelo_Notificacion::WEB)){
			return false;
		}
	}  
	return true;
}*/

function envioCorreo($nombres,$correo,$plan,$fecha){
	$enlace = "<a href='".PUERTO."://".$dominio."/planes/'>click aqu&iacute;</a>";
  $email_body = Modelo_TemplateEmail::obtieneHTML("CANCELACION_SUBSCRIPCION");
  $email_body = str_replace("%NOMBRES%", utf8_encode($nombres), $email_body);   
  $email_body = str_replace("%PLAN%", utf8_encode($plan), $email_body); 
  $email_body = str_replace("%FECHA%", $fecha, $email_body);   
  $email_body = str_replace("%ENLACE%", $enlace, $email_body);   
  Utils::envioCorreo($correo,"Cancelación de Subscripción",$email_body);		
}

//elimina archivo de procesamiento
unlink(CRON_RUTA.'procesando_cancelar_planes.txt');
?>
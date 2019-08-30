<?php
require_once '../constantes.php';
require_once '../init.php';

/***DEPOSITOS MANUALES***/
$id_comprobante = 1;  
$datos_comprobante = Modelo_Comprobante::obtieneComprobante($id_comprobante);    
$infoplan = Modelo_Plan::busquedaXId($datos_comprobante["id_plan"],true);
$infousuario = Modelo_Usuario::busquedaPorId($datos_comprobante["id_user_emp"],$datos_comprobante["tipo_usuario"]);
try{ 
	$GLOBALS['db']->beginTrans(); 
	if (!Modelo_UsuarioxPlan::guardarPlan($datos_comprobante["id_user_emp"],$datos_comprobante["tipo_usuario"],
		                                    $datos_comprobante["id_plan"],$infoplan["num_post"],
	                                      $infoplan["duracion"],$infoplan["porc_descarga"],$id_comprobante,false,false,false,
	                                      $infoplan["num_accesos"])){
	  throw new Exception("Error en crear el plan");  
	}       
	//si es candidato y ya tenia los ultimos 3 cuestionarios hechos se los activa      
	if ($tipo_usuario == Modelo_Usuario::CANDIDATO){
	  if (!Modelo_PorcentajexFaceta::updateEstado($datos_comprobante["id_user_emp"])){
	    throw new Exception("Error en crear el plan");  
	  }
	}

	//modelo comprobante
	if (!Modelo_Comprobante::modificaEstado($id_comprobante,Modelo_Comprobante::PAGO_VERIFICADO)){
	  throw new Exception("Error al actualizar el registro en comprobantes"); 
	} 
      
  $nombresusuario = Utils::no_carac($infousuario["nombres"]);
  if (isset($infousuario["apellidos"]) && !empty($infousuario["apellidos"])){
  	$nombresusuario .= " " .Utils::no_carac($infousuario["apellidos"]);
  }          
	//facturacion electronica
	// $obj_facturacion = new Proceso_Facturacion();
	// $obj_facturacion->razonSocialComprador = $datos_comprobante["nombre"];
	// $obj_facturacion->identificacionComprador = $datos_comprobante["dni"];
	// $obj_facturacion->direccionComprador = $datos_comprobante["direccion"];
	// $obj_facturacion->emailComprador = $datos_comprobante["correo"];
	// $obj_facturacion->telefComprador = $datos_comprobante["telefono"];            
	// $obj_facturacion->tipoIdentifComprador = $datos_comprobante["tipo_doc"];            
	// $obj_facturacion->importeTotal = $datos_comprobante["valor"];
	// $obj_facturacion->codigoPrincipal = $datos_comprobante["id_plan"];
	// $obj_facturacion->descripdetalle = utf8_encode($infoplan["nombre"]); 
	// $obj_facturacion->formadepago = Proceso_Facturacion::FORMA_PAGO["SINFINANCIERO"];     
	// $obj_facturacion->provinciaComprador = $datos_comprobante["provincia"];     
	// $obj_facturacion->ciudadComprador = $datos_comprobante["ciudad"];     
	// $obj_facturacion->codpostalComprador = $datos_comprobante["codigopostal"];     
	// $rsfact = $obj_facturacion->generarFactura(); 
	// if (is_array($rsfact) && isset($rsfact["claveacceso"]) && isset($rsfact["xml"]) && !empty($rsfact["claveacceso"]) && !empty($rsfact["xml"])){
	//   if (!Modelo_Factura::guardar($rsfact["claveacceso"],$rsfact["xml"],$datos_comprobante["id_user_emp"],
	//   	                           $infousuario["tipo_usuario"],$infoplan["id_sucursal"],$id_comprobante)){
	//     throw new Exception("Error al generar la factura");  
	//   }
	//   if (!Modelo_Parametro::actualizarNroFactura()){
	//     throw new Exception("Error al generar el siguiente numero de factura");  
	//   } 
	// }         
	$GLOBALS['db']->commit();

	$nombres = ucfirst(utf8_encode($infousuario["nombres"]))." ".ucfirst((isset($infousuario["apellidos"])) ? ucfirst(utf8_encode($infousuario["apellidos"])) : "");
 
	$email_subject = "Activación de Suscripción"; 
	if ($datos_comprobante["tipo_usuario"] == Modelo_Usuario::CANDIDATO){
		$template_nombre = "ACTIVACION_SUBSCRIPCION_CANDIDATO";      
	}
	else{
		$template_nombre = "ACTIVACION_SUBSCRIPCION_EMPRESA";       
	}
	$email_body = Modelo_TemplateEmail::obtieneHTML($template_nombre);
	$email_body = str_replace("%NOMBRES%", $nombres, $email_body);
	$precioTemplate = "Parcial";
	if($infoplan["costo"] > 0 && $datos_comprobante["tipo_usuario"] == Modelo_Usuario::CANDIDATO){
		$precioTemplate = "Completo ";
		$email_body = str_replace("%PRECIO%", $precioTemplate, $email_body);
	}
	$email_body = str_replace("%PRECIO%", $precioTemplate, $email_body);
	$email_body = str_replace("%PLAN%", $infoplan["nombre"], $email_body);   
	
	if ($datos_comprobante["tipo_usuario"] == Modelo_Usuario::CANDIDATO){      
		$enlace = "<a href='".PUERTO."://".$dominio."/oferta/'>click aqu&iacute;</a><br>";      
	}else{      
		$enlace = "<a href='".PUERTO."://".$dominio."/publicar/'>click aqu&iacute;</a><br>";  
	} 
	$email_body = str_replace("%ENLACE%", $enlace, $email_body);     
	Utils::envioCorreo($infousuario["correo"],$email_subject,$email_body);  
	echo "DEPOSITO REALIZADO";
}
catch(Exception $e){
  $GLOBALS['db']->rollback();            
  Utils::envioCorreo('desarrollo@micamello.com.ec','Error deposito',$e->getMessage());      
}
?>
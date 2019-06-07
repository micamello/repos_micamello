<?php
ignore_user_abort( true );
ini_set("max_execution_time", "0");
ini_set("max_input_time", "0");
ini_set('memory_limit', "768M");
set_time_limit(0);

/*Script para generar nuevas facturas que no fueron recibidas o autorizadas*/

require_once '../constantes.php';
require_once '../init.php';

$resultado = file_exists(CRON_RUTA.'procesando_facturas.txt');
if ($resultado){
  exit;
}
else{
  Utils::crearArchivo(CRON_RUTA,'procesando_facturas.txt','');
}

$facturas = Modelo_Factura::factNoRecibidasAutorizadas();
if (count($facturas) > 0){
  $obj_facturacion = new Proceso_Facturacion();
  foreach($facturas as $factura){
    try{  
      $GLOBALS['db']->beginTrans();
      $datos_comprobante = Modelo_Comprobante::obtieneComprobante($factura["id_comprobante"]);
      if (empty($datos_comprobante)){
        throw new Exception("Error no se encontro datos en el comprobante");  
      }  
      $infousuario = Modelo_Usuario::busquedaPorId($datos_comprobante["id_user_emp"],$datos_comprobante["tipo_usuario"]);
      if (empty($infousuario)){
        throw new Exception("Error no se encontro datos del usuario");  
      }    
      $infoplan = Modelo_Plan::busquedaXId($datos_comprobante["id_plan"],true);      
      if (empty($infoplan)){
        throw new Exception("Error no se encontro datos en el plan");  
      }
      $obj_facturacion->razonSocialComprador = $datos_comprobante["nombre"];
      $obj_facturacion->identificacionComprador = $datos_comprobante["dni"];
      $obj_facturacion->direccionComprador = $datos_comprobante["direccion"];
      $obj_facturacion->emailComprador = $datos_comprobante["correo"];
      $obj_facturacion->telefComprador = $datos_comprobante["telefono"];            
      $obj_facturacion->tipoIdentifComprador = $datos_comprobante["tipo_doc"];            
      $obj_facturacion->importeTotal = $datos_comprobante["valor"];
      $obj_facturacion->codigoPrincipal = $datos_comprobante["id_plan"];
      $obj_facturacion->descripdetalle = utf8_encode($infoplan["nombre"]);
      $obj_facturacion->formadepago = $datos_comprobante["formapago"];    
      $obj_facturacion->provinciaComprador = $datos_comprobante["provincia"];     
      $obj_facturacion->ciudadComprador = $datos_comprobante["ciudad"];     
      $obj_facturacion->codpostalComprador = $datos_comprobante["codigopostal"];       
      
      $obj_facturacion->numerofactura = (int)substr($factura["clave_acceso"],30,9);      
      $rsfact = $obj_facturacion->generarFactura();  

      if (empty($rsfact) || !isset($rsfact["claveacceso"]) || !isset($rsfact["xml"]) || empty($rsfact["claveacceso"]) || empty($rsfact["xml"])){
        throw new Exception("Error no se pudo generar la factura");   
      }
      
      $datosact = array("clave_acceso" => $rsfact["claveacceso"], 
                        "xml" => $rsfact["xml"], "estado" => Modelo_Factura::NOENVIADO, 
                        "msg_error" => "", "fecha_estado" => "null");
      
      if (!Modelo_Factura::actualizar($factura["clave_acceso"],$datosact)){
        throw new Exception("Error al actualizar la factura");  
      }       
      
      $attachments = array();      
      if (!$obj_facturacion->sendRecepcion($rsfact["xml"],$rsfact["claveacceso"])){
        throw new Exception("1 WS del SRI");  
      }  
      sleep(5);
      $fecha_auto = $obj_facturacion->sendAutorizacion($rsfact["claveacceso"]);
      if (empty($fecha_auto)){
        throw new Exception("2 WS del SRI");  
      }

      //adjuntar factura
      $obj_facturacion->generarRIDE($rsfact["xml"],$fecha_auto);
      $obj_facturacion->generarXML($rsfact["xml"],$rsfact["claveacceso"]);
        
      $attachments[] = array("ruta"=>Proceso_Facturacion::RUTA_FACTURA.$rsfact["claveacceso"].".pdf",
                             "archivo"=>$rsfact["claveacceso"].".pdf");
      $attachments[] = array("ruta"=>Proceso_Facturacion::RUTA_FACTURA.$rsfact["claveacceso"].".xml",
                             "archivo"=>$rsfact["claveacceso"].".xml");          

      $nombres = ucfirst(utf8_encode($infousuario["nombres"]))." ".(isset($infousuario["apellidos"]) ? ucfirst(utf8_encode($infousuario["apellidos"])) : "");
      $email_subject = "Factura Electrónica"; 
      $mensaje = "N&uacute;mero de Autorizaci&oacute;n: ".$rsfact["claveacceso"]."<br>";
      $mensaje .= "Fecha de Emisi&oacute;n: ".$fecha_auto."<br>";
      $mensaje .= "Tipo de Comprobante: Factura<br>";
      $mensaje .= "Valor Total: ".$datos_comprobante["valor"]."<br>";

      $email_body = Modelo_TemplateEmail::obtieneHTML("FACTURACION");
      $email_body = str_replace("%NOMBRES%", $nombres, $email_body);   
      $email_body = str_replace("%MENSAJE%", $mensaje, $email_body);         
            
      unlink(Proceso_Facturacion::RUTA_FACTURA.$rsfact["claveacceso"].".pdf");
      unlink(Proceso_Facturacion::RUTA_FACTURA.$rsfact["claveacceso"].".xml");

      $GLOBALS['db']->commit();

      Utils::envioCorreo($infousuario["correo"],$email_subject,$email_body,$attachments);
      
      if (!empty($attachments)){
        //eliminar archivos temporales
        unlink(Proceso_Facturacion::RUTA_FACTURA.$rsfact["claveacceso"].".pdf");
        unlink(Proceso_Facturacion::RUTA_FACTURA.$rsfact["claveacceso"].".xml");
      }
    }
    catch(Exception $e){
      $GLOBALS['db']->rollback();
      echo "NO PROCESADO REGISTRO ".$factura["id_factura"]."<br>";     
      $msgerror = $e->getMessage()." factura:".$factura["id_factura"];
      Utils::envioCorreo('desarrollo@micamello.com.ec','Error Cron facturas',$msgerror);     
    }
  }
} 
 
//elimina archivo de procesamiento
unlink(CRON_RUTA.'procesando_facturas.txt');
?>
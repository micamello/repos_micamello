<?php
class Proceso_Subscripcion{

  protected $objUsuario;
  protected $idplan;    
  protected $procesador;

	function __construct($objUsuario,$idplan,$procesador){        
    $this->objUsuario = $objUsuario;
    $this->idplan = $idplan;    
    $this->procesador = $procesador;
  }

  public function procesar(){
    try{	
      $GLOBALS['db']->beginTrans();

	    $infousuario = Modelo_Usuario::busquedaPorId($this->objUsuario->id,$this->objUsuario->tipo);
	    $infoplan = Modelo_Plan::busquedaXId($this->idplan,true);
      $infosucursal = Modelo_Sucursal::consultaDominio($infoplan["id_sucursal"]); 

	    if (empty($infousuario) || empty($infoplan) || empty($infosucursal)){
	      throw new Exception("Usuario, Plan o Sucursal no existe");	
	    }
	    if ($infousuario["tipo_usuario"] != $infoplan["tipo_usuario"]){
	    	throw new Exception("Usuario no corresponde al plan");	
	    }
      if ($infousuario["id_pais"] <> $infoplan["id_pais"]){
        throw new Exception("Plan no corresponde al pais del usuario"); 
      }
      if ($this->procesador->tipo == 'paypal'){
        if (empty($infoplan["codigo_paypal"])){
          throw new Exception("Plan asociado con paypal"); 
        }
      }
	  	
      $id_comprobante = $this->guardarComprobante();      
      if (!Modelo_UsuarioxPlan::guardarPlan($this->objUsuario->id,$this->objUsuario->tipo,$this->idplan,$infoplan["num_post"],
                                            $infoplan["duracion"],$infoplan["porc_descarga"],$id_comprobante,false,false,false,
                                            $infoplan["num_accesos"])){
        throw new Exception("Error en crear el plan");	
      }	      
	    
	    if ($this->procesador->tipo == 'paypal'){
	      if (!Modelo_Paypal::modificarEstado($this->procesador->id)){
	        throw new Exception("Error al actualizar el registro en tabla de paypal");	
	      }	
	    }
	    
      //facturacion electronica
      /*$obj_facturacion = new Proceso_Facturacion();
      $obj_facturacion->razonSocialComprador = $this->objUsuario->nombres;
      $obj_facturacion->identificacionComprador = $this->objUsuario->dni;
      $obj_facturacion->direccionComprador = $this->objUsuario->direccion;
      $obj_facturacion->emailComprador = $this->objUsuario->correo;
      $obj_facturacion->telefComprador = $this->objUsuario->telefono;            
      $obj_facturacion->tipoIdentifComprador = TIPO_DOCUMENTO[$this->objUsuario->tipodoc];            
      $obj_facturacion->importeTotal = $this->procesador->monto;
      $obj_facturacion->codigoPrincipal = $this->idplan;
      $obj_facturacion->descripdetalle = $infoplan["nombre"];
      $rsfact = $obj_facturacion->generarFactura(); 
      if (is_array($rsfact) && isset($rsfact["claveacceso"]) && isset($rsfact["xml"]) && !empty($rsfact["claveacceso"]) && !empty($rsfact["xml"])){
        if (!Modelo_Factura::guardar($rsfact["claveacceso"],$rsfact["xml"],$this->objUsuario->id,$infousuario["tipo_usuario"],$infoplan["id_sucursal"],$id_comprobante)){
          throw new Exception("Error al generar la factura");  
        }
        if (!Modelo_Parametro::actualizarNroFactura()){
          throw new Exception("Error al generar el siguiente numero de factura");  
        } 
      }*/   
      
      $GLOBALS['db']->commit();

      $attachments = array();
      //envio a los WS al SRI
      /*if ($obj_facturacion->sendRecepcion($rsfact["xml"],$rsfact["claveacceso"])){
        sleep(5);
        $fecha_auto = $obj_facturacion->sendAutorizacion($rsfact["claveacceso"]);
        if (!empty($fecha_auto)){
          //adjuntar factura
          $obj_facturacion->generarRIDE($rsfact["xml"],$fecha_auto);
          $obj_facturacion->generarXML($rsfact["xml"],$rsfact["claveacceso"]);
            
          $attachments[] = array("ruta"=>Proceso_Facturacion::RUTA_FACTURA.$rsfact["claveacceso"].".pdf",
                                 "archivo"=>$rsfact["claveacceso"].".pdf");
          $attachments[] = array("ruta"=>Proceso_Facturacion::RUTA_FACTURA.$rsfact["claveacceso"].".xml",
                                 "archivo"=>$rsfact["claveacceso"].".xml");
        }
      }*/

      $nombres = utf8_encode($infousuario["nombres"])." ".(isset($infousuario["apellidos"]) ? utf8_encode($infousuario["apellidos"]) : "");

	    $this->crearNotificaciones($infousuario["correo"],$infousuario["id_usuario"],$nombres,
                                 $infoplan["nombre"],$infousuario["tipo_usuario"],$infosucursal["dominio"],$attachments);
      
      if (!empty($attachments)){
        //eliminar archivos temporales
        unlink(Proceso_Facturacion::RUTA_FACTURA.$rsfact["claveacceso"].".pdf");
        unlink(Proceso_Facturacion::RUTA_FACTURA.$rsfact["claveacceso"].".xml");
      }

  	}
  	catch(Exception $e){
  	  $GLOBALS['db']->rollback();
	  	echo "NO PROCESADO REGISTRO ".$this->procesador->id."<br>";
      $msgerror = $e->getMessage()." transaccion:".$this->procesador->trans." usuario:".$this->objUsuario->id." plan:".$this->idplan;
	    Utils::envioCorreo('desarrollo@micamello.com.ec','Error Cron planes_paypal',$msgerror);	    
  	}

  }

  public function guardarComprobante(){
    if (!Modelo_Comprobante::guardarComprobante($this->procesador->trans,$this->objUsuario->nombres,$this->objUsuario->correo,
        	                                      $this->objUsuario->telefono,$this->objUsuario->dni,$this->objUsuario->tipodoc,
        	                                      Modelo_Comprobante::METODO_PAYPAL,'',$this->procesador->monto,
        	                                      $this->objUsuario->id,$this->idplan,$this->objUsuario->direccion,$this->objUsuario->tipo,
                                                Modelo_Comprobante::PAGO_VERIFICADO)){
      throw new Exception("Error al ingresar el comprobante transaccion:".$this->procesador->trans." usuario:".$this->objUsuario->id." plan:".$this->idplan);
    }  
	  return $GLOBALS['db']->insert_id();	  
  }

  public function crearNotificaciones($correo,$idusuario,$nombres,$plan,$tipousuario,$dominio,$attachments){  
  	$email_subject = "Activación de Subscripción"; 
    $email_body = Modelo_TemplateEmail::obtieneHTML("ACTIVACION_SUBSCRIPCION");
    $email_body = str_replace("%NOMBRES%", $nombres, $email_body);   
    $email_body = str_replace("%PLAN%", $plan, $email_body);   
    $notif_body = "Su plan ".$plan." ha sido activado exitosamente";    
    if ($tipousuario == Modelo_Usuario::CANDIDATO){
      $mensaje = "Por favor de click en este enlace para realizar el tercer formulario";       
      $mensaje .= "<a href='".PUERTO."://".$dominio."/desarrollov3/oferta/'>click aqu&iacute;</a><br>";      
    }else{
      $mensaje = "Por favor de click en este enlace para publicar una oferta "; 
      $mensaje .= "<a href='".PUERTO."://".$dominio."/desarrollov3/publicar/'>click aqu&iacute;</a><br>";  
    } 
    $email_body = str_replace("%MENSAJE%", $mensaje, $email_body);   
    Modelo_Notificacion::insertarNotificacion($idusuario,$notif_body,$tipousuario,Modelo_Notificacion::ACTIVACION_SUBSCRIPCION);
    Utils::envioCorreo($correo,$email_subject,$email_body,$attachments);
  }

}
?>
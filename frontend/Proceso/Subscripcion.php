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
                                            $infoplan["duracion"],$infoplan["porc_descarga"],$id_comprobante)){
        throw new Exception("Error en crear el plan");	
      }	      
	    
	    if ($this->procesador->tipo == 'paypal'){
	      if (!Modelo_Paypal::modificarEstado($this->procesador->id)){
	        throw new Exception("Error al actualizar el registro en tabla de paypal");	
	      }	
	    }
	    
	    $GLOBALS['db']->commit();
    	echo "PROCESADO REGISTRO ".$this->procesador->id."<br>";	
      $nombres = $infousuario["nombres"]." ".(isset($infousuario["apellidos"]) ? $infousuario["apellidos"] : "");
	    $this->crearNotificaciones($infousuario["correo"],$infousuario["id_usuario"],$nombres,$infoplan["nombre"],$infousuario["tipo_usuario"],$infosucursal["dominio"]);
  	}
  	catch(Exception $e){
  	  $GLOBALS['db']->rollback();
	  	echo "NO PROCESADO REGISTRO ".$this->procesador->id."<br>";
      $msgerror = $e->getMessage()." <b>Transaccion:</b>".$this->procesador->trans."<br> <b>Usuario:</b>".$this->objUsuario->id." <br><b>Plan:</b>".$this->idplan;
      $datos_correo = array('tipo'=>8, 'mensaje'=>$msgerror, 'correo'=>'desarrollo@micamello.com.ec', 'type'=>TIPO['error_cron_paypal'], 'asunto'=>'Error Cron planes_paypal');
      Utils::enviarEmail($datos_correo);
	    // Utils::envioCorreo('desarrollo@micamello.com.ec','Error Cron planes_paypal',$msgerror);
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

  public function crearNotificaciones($correo,$idusuario,$nombres,$plan,$tipousuario,$dominio){  	
  	// $email_subject = "Activación de Subscripción";    
  	$email_body = "Estimado, ".utf8_encode($nombres)."<br>";
    $email_body .= "Su plan (".utf8_encode($plan).") ha sido activado exitosamente <br>";
    $notif_body = $email_body;
    if ($tipousuario == Modelo_Usuario::CANDIDATO){
      $email_body .= "Por favor de click en este enlace para realizar el tercer formulario "; 
      $email_body .= "<a href='".PUERTO."://".$dominio."/desarrollov2/cuestionario/'>click aqu&iacute;</a> <br>";      
    }else{
      $email_body .= "Por favor de click en este enlace para publicar una oferta "; 
      $email_body .= "<a href='".PUERTO."://".$dominio."/desarrollov2/publicar/'>click aqu&iacute;</a> <br>";      
    }  
    Modelo_Notificacion::insertarNotificacion($idusuario,$notif_body,$tipousuario);
    $datos_correo = array('tipo'=>11, 'mensaje'=>$email_body, 'correo'=>$correo, 'type'=>TIPO['notificaciones'], 'asunto'=>'Activación de Subscripción');
    Utils::enviarEmail($datos_correo);
    // Utils::envioCorreo($correo,$email_subject,$email_body);
  }

}
?>
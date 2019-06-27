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
      Utils::log("PASO TRES ".date('Y-m-d H:i:s'));
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
      
      $id_comprobante = $this->guardarComprobante();      
      if (!Modelo_UsuarioxPlan::guardarPlan($this->objUsuario->id,$this->objUsuario->tipo,$this->idplan,$infoplan["num_post"],
                                            $infoplan["duracion"],$infoplan["porc_descarga"],$id_comprobante,false,false,false,
                                            $infoplan["num_accesos"])){
        throw new Exception("Error en crear el plan");  
      } 
      Utils::log("PASO CUATRO ".date('Y-m-d H:i:s'));
      //si es candidato y ya tenia los ultimos 3 cuestionarios hechos se los activa      
      if ($this->objUsuario->tipo == Modelo_Usuario::CANDIDATO){
        if (!Modelo_PorcentajexFaceta::updateEstado($this->objUsuario->id)){
          throw new Exception("Error en crear el plan");  
        }
      }
      if ($this->procesador->tipo == 'payme'){
        if (!Modelo_Payme::modificarEstado($this->procesador->id)){
          throw new Exception("Error al actualizar el registro en tabla de payme"); 
        } 
      }
      Utils::log("PASO CINCO ".date('Y-m-d H:i:s')); 
      //facturacion electronica
      $obj_facturacion = new Proceso_Facturacion();
      $obj_facturacion->razonSocialComprador = $this->objUsuario->nombres;
      $obj_facturacion->identificacionComprador = $this->objUsuario->dni;
      $obj_facturacion->direccionComprador = $this->objUsuario->direccion;
      $obj_facturacion->emailComprador = $this->objUsuario->correo;
      $obj_facturacion->telefComprador = $this->objUsuario->telefono;            
      $obj_facturacion->tipoIdentifComprador = $this->objUsuario->tipodoc;            
      $obj_facturacion->importeTotal = $this->procesador->monto;
      $obj_facturacion->codigoPrincipal = $this->idplan;
      $obj_facturacion->descripdetalle = utf8_encode($infoplan["nombre"]); 
      $obj_facturacion->formadepago = $this->procesador->tipopago;     
      $obj_facturacion->provinciaComprador = $this->objUsuario->provincia;     
      $obj_facturacion->ciudadComprador = $this->objUsuario->ciudad;     
      $obj_facturacion->codpostalComprador = $this->objUsuario->codpostal;     
      $rsfact = $obj_facturacion->generarFactura(); 
      if (is_array($rsfact) && isset($rsfact["claveacceso"]) && isset($rsfact["xml"]) && !empty($rsfact["claveacceso"]) && !empty($rsfact["xml"])){
        if (!Modelo_Factura::guardar($rsfact["claveacceso"],$rsfact["xml"],$this->objUsuario->id,$infousuario["tipo_usuario"],$infoplan["id_sucursal"],$id_comprobante)){
          throw new Exception("Error al generar la factura");  
        }
        if (!Modelo_Parametro::actualizarNroFactura()){
          throw new Exception("Error al generar el siguiente numero de factura");  
        } 
      }   
      Utils::log("PASO SEIS ".date('Y-m-d H:i:s'));
      $GLOBALS['db']->commit();

      /*$attachments = array();
      //envio a los WS al SRI
      if ($obj_facturacion->sendRecepcion($rsfact["xml"],$rsfact["claveacceso"])){
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

      $nombres = ucfirst(utf8_encode($infousuario["nombres"]))." ".ucfirst((isset($infousuario["apellidos"])) ? ucfirst(utf8_encode($infousuario["apellidos"])) : "");
       
      $this->crearNotificaciones($infousuario["correo"],$infousuario["id_usuario"],$nombres,
                                 $infoplan["nombre"],$infousuario["tipo_usuario"],$infosucursal["dominio"],$this->idplan);
      
      Utils::log("PASO SIETE ".date('Y-m-d H:i:s'));
      /*if (!empty($attachments)){
        //eliminar archivos temporales
        unlink(Proceso_Facturacion::RUTA_FACTURA.$rsfact["claveacceso"].".pdf");
        unlink(Proceso_Facturacion::RUTA_FACTURA.$rsfact["claveacceso"].".xml");
      }*/

    }
    catch(Exception $e){
      $GLOBALS['db']->rollback();
      echo "NO PROCESADO REGISTRO ".$this->procesador->id."<br>";
      $msgerror = $e->getMessage()." transaccion:".$this->procesador->trans." usuario:".$this->objUsuario->id." plan:".$this->idplan;
      //Utils::envioCorreo('desarrollo@micamello.com.ec','Error Cron planes_payme',$msgerror);      
    }

  }

  public function guardarComprobante(){
    if ($this->procesador->tipo == 'payme'){
      $tipoproc = Modelo_Comprobante::METODO_PAYME;
    }
    else{
      $tipoproc = Modelo_Comprobante::METODO_DEPOSITO;
    }
    if (!Modelo_Comprobante::guardarComprobante($this->procesador->trans,$this->objUsuario->nombres,$this->objUsuario->correo,
                                                $this->objUsuario->telefono,$this->objUsuario->dni,$this->objUsuario->tipodoc,
                                                $tipoproc,'',$this->procesador->monto,$this->objUsuario->id,
                                                $this->idplan,$this->objUsuario->direccion,$this->objUsuario->tipo,
                                                Modelo_Comprobante::PAGO_VERIFICADO,$this->objUsuario->provincia,
                                                $this->objUsuario->ciudad,$this->objUsuario->codpostal,
                                                $this->procesador->tipopago)){
      throw new Exception("Error al ingresar el comprobante transaccion:".$this->procesador->trans." usuario:".$this->objUsuario->id." plan:".$this->idplan);
    }  
    return $GLOBALS['db']->insert_id();   
  }

  public function crearNotificaciones($correo,$idusuario,$nombres,$plan,$tipousuario,$dominio,$costo){  
    $costo = Modelo_Plan::busquedaXId($costo);
    $email_subject = "Activación de Subscripción"; 
    if ($tipousuario == Modelo_Usuario::CANDIDATO){
      $template_nombre = "ACTIVACION_SUBSCRIPCION_CANDIDATO";      
    }
    else{
      $template_nombre = "ACTIVACION_SUBSCRIPCION_EMPRESA";       
    }
    $email_body = Modelo_TemplateEmail::obtieneHTML($template_nombre);
    $email_body = str_replace("%NOMBRES%", $nombres, $email_body);
    $precioTemplate = "Parcial";
    if($costo['costo'] > 0 && $tipousuario == Modelo_Usuario::CANDIDATO){
      $precioTemplate = "completo ";
      $email_body = str_replace("%PRECIO%", $precioTemplate, $email_body);
    }
    $email_body = str_replace("%PRECIO%", $precioTemplate, $email_body);
    $email_body = str_replace("%PLAN%", $plan, $email_body);   
    //$notif_body = "Su plan ".$plan." ha sido activado exitosamente";    
    if ($tipousuario == Modelo_Usuario::CANDIDATO){      
      $enlace = "<a href='".PUERTO."://".$dominio."/desarrollov3/oferta/'>click aqu&iacute;</a><br>";      
    }else{      
      $enlace = "<a href='".PUERTO."://".$dominio."/desarrollov3/publicar/'>click aqu&iacute;</a><br>";  
    } 
    $email_body = str_replace("%ENLACE%", $enlace, $email_body);     
    Utils::envioCorreo($correo,$email_subject,$email_body/*,$attachments*/);
    //Modelo_Notificacion::insertarNotificacion($idusuario,$notif_body,$tipousuario,Modelo_Notificacion::ACTIVACION_SUBSCRIPCION);
  }

}
?>
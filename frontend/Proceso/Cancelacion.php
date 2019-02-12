<?php
class Proceso_Cancelacion{

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

	    //obtiene el ultimo plan comprado
	    $plan = Modelo_UsuarioxPlan::obtienePlanComprobante($this->procesador->trans,$this->objUsuario->id,$this->idplan,$this->objUsuario->tipo);
	    if (empty($plan)){
	    	throw new Exception("Plan no asociado al usuario");
	    }
	  	
	  	//si es de tipo candidato
	  	if ($infousuario["tipo_usuario"] == Modelo_Usuario::CANDIDATO){
	  		$this->reversoCandidato($plan["id_comprobante"],$plan["id_usuario_plan"]); 		 			  		
	  	}	  		 
	  	//si es de tipo empresa
	  	else{
        //si el plan tiene asociado cuentas hijas
        $planes_hijos = Modelo_UsuarioxPlan::obtienePlanesHijos($plan["id_usuario_plan"]);
        if (!empty($planes_hijos) && count($planes_hijos) > 0){
          foreach($planes_hijos as $planhijo){
            //reverso de ofertas y postulaciones de candidatos
            $this->reversoOfertas($plan["id_comprobante"],$planhijo["id_empresa_plan"]);
            //consulta si el usuario tiene mas planes activos y pagados
            $planpago = Modelo_UsuarioxPlan::existePlanPagado($planhijo["id_empresa"],$planhijo["id_empresa_plan"],$this->objUsuario->tipo);
            //inactivar el usuario
            if (empty($planpago)){
              if(!Modelo_Usuario::desactivarCuenta($planhijo["id_empresa"],$this->objUsuario->tipo)){
                throw new Exception("Error al desactivar la empresa hija");
              }     
            }
          }          
        }            
        $this->reversoOfertas($plan["id_comprobante"],$plan["id_usuario_plan"]);        	  	
	  	} 		                
	    
	    if ($this->procesador->tipo == 'paypal'){
		    if (!Modelo_Paypal::modificarEstado($this->procesador->id)){
		      throw new Exception("Error al actualizar el registro en tabla de paypal");	
		    }
	    }

	    $GLOBALS['db']->commit();
    	echo "PROCESADO REGISTRO ".$this->procesador->id."<br>";	
      $nombres = $infousuario["nombres"]." ".(isset($infousuario["apellidos"]) ? $infousuario["apellidos"] : "");    
	    $this->crearNotificaciones($infousuario["correo"],$infousuario["id_usuario"],$nombres,$infoplan["nombre"],$infousuario["tipo_usuario"]);

    }
    catch(Exception $e){
  	  $GLOBALS['db']->rollback();
	  	echo "NO PROCESADO REGISTRO ".$this->procesador->id."<br>";
	  	$msgerror = $e->getMessage()." 
                          <br><b>Transaccion:</b>".$this->procesador->trans." 
                          <br><b>Usuario:</b>".$this->objUsuario->id." 
                          <br><b>Plan:</b>".$this->idplan;
	    // Utils::envioCorreo('desarrollo@micamello.com.ec','Error Cron planes_paypal',$msgerror);
      $datos_correo = array(
                          'tipo'=>11, 
                          'mensaje'=>$msgerror, 'correo'=>'desarrollo@micamello.com.ec', 
                          'asunto'=>'Error Cron planes_paypal', 
                          'type'=>TIPO['error_cron_paypal']);
      Utils::enviarEmail($datos_correo);
  	}
  }

  public function reversoCandidato($id_comprobante,$id_usuario_plan){
    $post_auto = Modelo_Postulacion::obtienePostAuto($id_usuario_plan);
    if (!empty($post_auto)){
      $str_post = implode(",",$post_auto);   
      //eliminar todas las autopostulaciones de ese plan
      if (!Modelo_Postulacion::eliminarPostAuto($id_usuario_plan)){
        throw new Exception("Error al eliminar postulaciones automaticas");
      }
      if (!Modelo_Postulacion::eliminarPostxString($str_post)){
        throw new Exception("Error al eliminar postulaciones"); 
      }
    }  
    $this->reversoComprobantePlan($id_comprobante,$id_usuario_plan);
  }
  
  public function reversoOfertas($id_comprobante=false,$id_usuario_plan){
    $ofertas = Modelo_Oferta::ofertasxUsuarioPlan($id_usuario_plan);
    if (!empty($ofertas)){
      foreach($ofertas as $oferta){
        //buscar postulaciones para esa oferta
        $postulaciones = Modelo_Postulacion::obtienePostxOferta($oferta["id_ofertas"]);
        if (!empty($postulaciones)){
          foreach($postulaciones as $postulacion){
            if ($postulacion["tipo"] == Modelo_Postulacion::AUTOMATICO){
              $postauto = Modelo_Postulacion::postAutoxIdPost($postulacion["id_auto"]);
              if (empty($postauto)){
                throw new Exception("Error usuario no tiene registros en postulacion_automatica"); 
              }                  
              //eliminar postulaciones automaticas
              if (!Modelo_Postulacion::eliminarPostAutoxId($postauto["id_postauto"])){
                throw new Exception("Error al eliminar postulaciones automaticas"); 
              }
              //devolver numero de postulaciones
              if (!Modelo_UsuarioxPlan::sumarPublicaciones($postauto["id_usuarioplan"])){
                throw new Exception("Error al devolver numero de postulaciiones");
              }
            }
            //eliminar postulacion
            if(!Modelo_Postulacion::eliminarPostulacion($postulacion["id_auto"])){
              throw new Exception("Error al eliminar postulaciones"); 
            }                
          }
        }
        //buscar postulaciones automaticas
        //cancelar las ofertas  
        if (!Modelo_Oferta::desactivarOferta($oferta["id_ofertas"])){
          throw new Exception("Error al desactivar la oferta"); 
        }     
      }   
    }
    if (!empty($id_comprobante)){
      $this->reversoComprobantePlan($id_comprobante,$id_usuario_plan);    
    }
  }

  public function reversoComprobantePlan($id_comprobante,$id_usuario_plan){
    if (!Modelo_Comprobante::modificaEstado($id_comprobante)){
      throw new Exception("Error al modificar el estado del comprobante");
    }
    if (!Modelo_UsuarioxPlan::desactivarPlan($id_usuario_plan,$this->objUsuario->tipo)){
      throw new Exception("Error al modificar el estado en usuarioxplan");
    }
  } 

  public function crearNotificaciones($correo,$idusuario,$nombres,$plan,$tipousuario){  	
  	$email_subject = "Cancelación de Subscripción";
  	$email_body = "Estimado, ".utf8_encode($nombres)."<br>";
    $email_body .= "Su plan (".utf8_encode($plan).") ha sido cancelado <br>";
    $notif_body = $email_body;
    if ($tipousuario == Modelo_Usuario::CANDIDATO){
      $email_body .= "En el caso de tener autopostulaciones estas ser&aacute;n eliminadas"; 
      
    }else{
      $email_body .= "En el caso de tener ofertas publicadas estas ser&aacute;n eliminadas";
    }  
    Modelo_Notificacion::insertarNotificacion($idusuario,$notif_body,$tipousuario);
    $datos_correo = array('tipo'=>11, 'mensaje'=>$email_body, 'correo'=>$correo, 'type'=>TIPO['notificaciones'], 'asunto'=>'Cancelación de Subscripción');
    Utils::enviarEmail($datos_correo);
    // Utils::envioCorreo($correo,$email_subject,$email_body);
  }
  
}
?>
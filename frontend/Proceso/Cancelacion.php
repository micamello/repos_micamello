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

      $infousuario = Modelo_Usuario::busquedaPorId($this->objUsuario->id,true);
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
	    $ultimoplan = Modelo_UsuarioxPlan::ultimoPlanActivo($this->objUsuario->id,$this->idplan);
	    if (empty($ultimoplan)){
	    	throw new Exception("Plan no asociado al usuario");
	    }
	  	
	  	//si es de tipo candidato
	  	if ($infousuario["tipo_usuario"] == Modelo_Usuario::CANDIDATO){
	  		$post_auto = Modelo_Postulacion::obtienePostAuto($ultimoplan["id_usuario_plan"]);
	  		if (!empty($post_auto)){
	  			$str_post = implode(",",$post_auto);	 
	  			//eliminar todas las autopostulaciones de ese plan
		  		if (!Modelo_Postulacion::eliminarPostAuto($ultimoplan["id_usuario_plan"])){
	          throw new Exception("Error al eliminar postulaciones automaticas");
		  		}
		  		if (!Modelo_Postulacion::eliminarPostxString($str_post)){
            throw new Exception("Error al eliminar postulaciones"); 
		  		}
	  		}	  		 			  		
	  	}	  		 
	  	//si es de tipo empresa
	  	else{
	  		$ofertas = Modelo_Oferta::ofertasxUsuarioPlan($ultimoplan["id_usuario_plan"]);
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
	  	} 		
      
      if (!Modelo_Comprobante::modificaEstado($ultimoplan["id_usuario_plan"])){
        throw new Exception("Error al modificar el estado del comprobante");
      }

      if (!Modelo_UsuarioxPlan::desactivarPlan($ultimoplan["id_usuario_plan"],"Reverso de Paypal")){
      	throw new Exception("Error al modificar el estado en usuarioxplan");
      }      
	    
	    if ($this->procesador->tipo == 'paypal'){
		    if (!Modelo_Paypal::modificarEstado($this->procesador->id)){
		      throw new Exception("Error al actualizar el registro en tabla de paypal");	
		    }
	    }

	    $GLOBALS['db']->commit();
    	echo "PROCESADO REGISTRO ".$this->procesador->id."<br>";	
      $nombres = $infousuario["nombres"]." ".$infousuario["apellidos"];    
	    $this->buildNotificacion(/*$infousuario["correo"]*/$infousuario["id_usuario"],$nombres,$infoplan["nombre"],$infousuario["tipo_usuario"],2);

    }
    catch(Exception $e){
  	  $GLOBALS['db']->rollback();
	  	echo "NO PROCESADO REGISTRO ".$this->procesador->id."<br>";
	  	$msgerror = $e->getMessage()." transaccion:".$this->procesador->trans." usuario:".$this->objUsuario->id." plan:".$this->idplan;
	    Utils::envioCorreo('desarrollo@micamello.com.ec','Error Cron planes_paypal',$msgerror);	    
  	}
  }

  public function buildNotificacion($id_usuario,$nombres,$plan,$tipousuario,$tipo){  	
  	//$email_subject = "Cancelación de Subscripción";
  	$email_body = "Cancelación de Subscripción<br>Estimado, ".utf8_encode($nombres)."<br>";
    $email_body .= "Su plan (".utf8_encode($plan).") ha sido cancelado desde Paypal<br>";
    if ($tipousuario == Modelo_Usuario::CANDIDATO){
      $email_body .= "En el caso de tener autopostulaciones estas ser&aacute;n eliminadas"; 
      
    }else{
      $email_body .= "En el caso de tener ofertas publicadas estas ser&aacute;n eliminadas";
    }  
    //Utils::envioCorreo($correo,$email_subject,$email_body);
    Modelo_Notificacion::insertarNotificacion($id_usuario,$email_body,$tipo);
  }
  
}
?>
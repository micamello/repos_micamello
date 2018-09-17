<?php
set_time_limit(0);

/*Script que permite la generacion de planes de los usuarios que cancelaron por medio de paypal*/

require_once '../constantes.php';
require_once '../init.php';

$registros = Modelo_Paypal::obtieneNoProcesados();
if (empty($registros) || !is_array($registros)){
	exit;
}

foreach($registros as $registro){
  try{	
  	$GLOBALS['db']->beginTrans();
    
    $cliente = obtenerDatosCliente($registro["custom"]); 
    if (empty($cliente)){ 
    	throw new Exception("No tiene datos campos custom ".print_r($registro,true));
    }
    $infousuario = Modelo_Usuario::busquedaPorId($cliente["usuario"]);
    $infoplan = Modelo_Plan::busquedaXId($cliente["plan"]); 
    if (empty($infousuario) || empty($infoplan)){
      throw new Exception("Usuairo o Plan no existe ".print_r($registro,true));	
    }
    if ($infousuario["tipo_usuario"] != $infoplan["tipo_usuario"]){
    	throw new Exception("Usuario no corresponde al plan ".print_r($registro,true));	
    }
    $email_to = $infousuario["correo"];
    $email_subject = "";
    $email_body = "";      
    if (Modelo_UsuarioxPlan::existePlan($cliente["usuario"],$cliente["plan"])){
      if ($registro["payment_status"] == "Reversed"){
        if (!Modelo_UsuarioxPlan::cancelarPlan($cliente["usuario"],$cliente["plan"],"Reverso de Paypal")){
      		throw new Exception("Error en cancelar el plan actual ".print_r($registro,true));
      	}
      	$email_subject = "Cancelación de Subscripción";
      	$email_body = "Estimado, ".$infousuario["nombres"]." ".$infousuario["apellidos"]."<br>";
        $email_body .= "Su plan ".$infoplan["nombre"]." ha sido cancelado desde Paypal";
    	}
    	else{
        if (!Modelo_Comprobante::guardarComprobante($registro["txn_id"],$cliente["nombres"],$cliente["correo"],
        	                                          $cliente["telefono"],$cliente["dni"],$cliente["ciudad"],
        	                                          Modelo_Comprobante::METODO_PAYPAL,'',$registro["payment_gross"],
        	                                          $infousuario['id_usuario'],$infoplan["id_plan"],
                                                    Modelo_Comprobante::PAGO_VERIFICADO)){
          throw new Exception("Error al ingresar el comprobante ".print_r($registro,true));
        }  

        $id_comprobante = $GLOBALS['db']->insert_id();

        if (!Modelo_UsuarioxPlan::modificarPlan($cliente["usuario"],$cliente["plan"],$infoplan["num_post"],$infoplan["duracion"],$id_comprobante)){
          throw new Exception("Error en actualizar el plan ".print_r($registro,true));	
        }
        $email_subject = "Activación de Subscripción";
      	$email_body = "Estimado, ".$infousuario["nombres"]." ".$infousuario["apellidos"]."<br>";
        $email_body .= "Su plan (".$infoplan["nombre"].") ha sido activado exitosamente";
    	}
    }
    else{
      if (!Modelo_Comprobante::guardarComprobante($registro["txn_id"],$cliente["nombres"],$cliente["correo"],
        	                                        $cliente["telefono"],$cliente["dni"],$cliente["ciudad"],
        	                                        Modelo_Comprobante::METODO_PAYPAL,'',$registro["payment_gross"],
        	                                        $infousuario['id_usuario'],$infoplan["id_plan"],
                                                  Modelo_Comprobante::PAGO_VERIFICADO)){
        throw new Exception("Error al ingresar el comprobante ".print_r($registro,true));
      }  
      
      $id_comprobante = $GLOBALS['db']->insert_id();
      Utils::log("ID COMPROBANTE".$id_comprobante);

      if (!Modelo_UsuarioxPlan::guardarPlan($cliente["usuario"],$cliente["plan"],$infoplan["num_post"],$infoplan["duracion"],$id_comprobante)){
        throw new Exception("Error en crear el plan ".print_r($registro,true));	
      }
      $email_subject = "Activación de Subscripción";
      $email_body = "Estimado, ".$infousuario["nombres"]." ".$infousuario["apellidos"]."<br>";
      $email_body .= "Su plan (".$infoplan["nombre"].") ha sido activado exitosamente";
    }
    
    if (!Modelo_Paypal::modificarEstado($registro["id_paypal"])){
      throw new Exception("Error al actualizar el registro en tabla de paypal ".print_r($registro,true));	
    }
    
    $GLOBALS['db']->commit();
    echo "PROCESADO REGISTRO ".$registro['id_paypal']."<br>";

    if (!empty($email_subject) && !empty($email_body)){
    	Utils::envioCorreo($email_to,$email_subject,$email_body);
    }
       
  }
  catch(Exception $e){
  	$GLOBALS['db']->rollback();
  	echo "NO PROCESADO REGISTRO ".$registro['id_paypal']."<br>";
    Utils::envioCorreo('micamelloecuador@gmail.com','Error Cron planes_paypal',$e->getMessage());
    continue;
  }
}


function obtenerDatosCliente($custom){
  if (empty($custom)){ return false; }
  $datos = explode('|',$custom);
  if (!is_array($datos)){ return false; }
  $return = array();
  $return["plan"] = $datos[0];
  $return["usuario"] = $datos[1];
  $return["nombres"] = $datos[2];
  $return["correo"] = $datos[3];
  $return["ciudad"] = $datos[4];
  $return["telefono"] = $datos[5];
  $return["dni"] = $datos[6];
  return $return;
}
?>
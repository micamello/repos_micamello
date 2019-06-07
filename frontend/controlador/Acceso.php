<?php
class Controlador_Acceso extends Controlador_Base{
  
  public function construirPagina(){
    if(!Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/login/');
    }

    $opcion = Utils::getParam('opcion','',$this->data);        
    switch($opcion){      
      case 'devolucion':
        $this->devolucionCandidato();
      break;   
      case 'aceptar':
        $this->aceptarCandidato();
      break;   
      default:
        $this->mostrarDefault();
      break;
    }        
  }

  public function devolucionCandidato(){
    $id = Utils::getParam('id','',$this->data);
  	try{
      $GLOBALS['db']->beginTrans();
      if (empty($id)){
        throw new Exception("Error en la cancelaci\u00F3n del acceso, por favor intente denuevo");
      }
      $notificacion = Modelo_Notificacion::consultaIndividual($id);
      if (empty($notificacion) || $notificacion["id_usuario"] != $_SESSION['mfo_datos']['usuario']['id_usuario']){
        throw new Exception("Error en la cancelaci\u00F3n del acceso, por favor intente denuevo");
      }      
      $acceso = Modelo_AccesoEmpresa::consultaPorCandidato($notificacion["id_usuario"]);
      if (empty($acceso) || !empty($acceso["fecha_terminado_test"])){
        throw new Exception("Error en la cancelaci\u00F3n del acceso, por favor intente denuevo");
      }
      if (!Modelo_UsuarioxPlan::sumarNumeroAccesos($acceso["id_empresa_plan"])){
        throw new Exception("Error en la cancelaci\u00F3n del acceso, por favor intente denuevo");
      }
      if (!Modelo_AccesoEmpresa::eliminar($acceso["id_accesos_empresas"])){
        throw new Exception("Error en la cancelaci\u00F3n del acceso, por favor intente denuevo");
      }
      if (!Modelo_Notificacion::desactivarNotificacion($id)){
        throw new Exception("Error en la cancelaci\u00F3n del acceso, por favor intente denuevo");
      }
      //envio de correo a la empresa para indicarle que se le devolvio el acceso
      $infoempresa = Modelo_Usuario::busquedaPorId($acceso["id_empresa"],Modelo_Usuario::EMPRESA);
      $email_subject = "Devolución de Acceso"; 
      $candidato = ucfirst(utf8_encode($_SESSION['mfo_datos']['usuario']['nombres'])).' '.ucfirst(utf8_encode($_SESSION['mfo_datos']['usuario']['apellidos']));
      $enlace = "<a href='".PUERTO.'://'.HOST.'/planesUsuario/'."'>Mis Planes</a>";
      $infoempresaplan = Modelo_UsuarioxPlan::consultaIndividual($acceso["id_empresa_plan"]);
      $infoplan = Modelo_Plan::busquedaXId($infoempresaplan["id_plan"]);
      $email_body = Modelo_TemplateEmail::obtieneHTML("DEVOLUCION_ACCESO");
      $email_body = str_replace("%NOMBRES%", utf8_encode($infoempresa["nombres"]), $email_body);   
      $email_body = str_replace("%CANDIDATO%", utf8_encode($candidato), $email_body);              
      $email_body = str_replace("%FECHA%", $acceso["fecha_envio_acceso"], $email_body);  
      $email_body = str_replace("%PLAN%", $infoplan["nombre"], $email_body);
      $email_body = str_replace("%ENLACE%", $enlace, $email_body);       
      Utils::envioCorreo($infoempresa["correo"],$email_subject,$email_body);

      $GLOBALS['db']->commit();
      $respuesta = "OK";
      $mensaje = "Acceso Cancelado";
    }
    catch( Exception $e ){
      $GLOBALS['db']->rollback();
      //$_SESSION['mostrar_error'] = $e->getMessage();  
      $respuesta = "ERROR";
      $mensaje = $e->getMessage();
    } 

    Vista::renderJSON(array("respuesta"=>$respuesta,"mensaje"=>$mensaje));  
  }

  public function aceptarCandidato(){
    $id = Utils::getParam('id','',$this->data);
    try{
      $GLOBALS['db']->beginTrans();
      if (empty($id)){
        throw new Exception("Error en la cancelaci\u00F3n del acceso, por favor intente denuevo");
      }
      $notificacion = Modelo_Notificacion::consultaIndividual($id);
      if (empty($notificacion) || $notificacion["id_usuario"] != $_SESSION['mfo_datos']['usuario']['id_usuario']){
        throw new Exception("Error en la aceptaci\u00F3n del acceso, por favor intente denuevo");
      }      
      $acceso = Modelo_AccesoEmpresa::consultaPorCandidato($notificacion["id_usuario"]);
      if (empty($acceso) || !empty($acceso["fecha_terminado_test"])){
        throw new Exception("Error en la aceptaci\u00F3n del acceso, por favor intente denuevo");
      }
      if (!Modelo_Usuario::actualizarAceptarAcceso($notificacion["id_usuario"])){
        throw new Exception("Error en la aceptaci\u00F3n del acceso, por favor intente denuevo"); 
      }
      if (!Modelo_Notificacion::desactivarNotificacion($id)){
        throw new Exception("Error en la aceptaci\u00F3n del acceso, por favor intente denuevo");
      }
      $_SESSION['mfo_datos']['usuario']['pendiente_test'] = 1;
      $GLOBALS['db']->commit();
      $respuesta = "OK";
      $mensaje = "Acceso Aceptado";
    }
    catch( Exception $e ){
      $GLOBALS['db']->rollback();
      //$_SESSION['mostrar_error'] = $e->getMessage();  
      $respuesta = "ERROR";
      $mensaje = $e->getMessage();
    }  
    Vista::renderJSON(array("respuesta"=>$respuesta,"mensaje"=>$mensaje));   
  }

}
?>
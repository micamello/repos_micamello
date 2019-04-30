<?php
ignore_user_abort( true );
ini_set("max_execution_time", "0");
ini_set("max_input_time", "0");
ini_set('memory_limit', "768M");
set_time_limit(0);

/*Script para migrar datos de usuarios de pre-registro a produccion con envío de correos de bienvenida y el enlace de ingreso */

require_once '../constantes.php';
require_once '../init.php';
require_once '../multisitios.php';

define('DOMINIO','micamello.com.ec');

// pregunta si ya se esta ejecutando el cron sino crea el archivo
$resultado = file_exists(CRON_RUTA.'devolucion_accesos.txt');
if ($resultado){
  exit;
}
else{
  Utils::crearArchivo(CRON_RUTA,'devolucion_accesos.txt','');
}
$email_body = Modelo_TemplateEmail::obtieneHTML("ACEPTACION_ACCESO");
$parametro = Modelo_Parametro::obtieneValor("tiempo_retornoAcceso");
$facetas = count(Modelo_Faceta::obtenerFacetas());
$listadoAcceso = Modelo_AccesoEmpresa::obtenerListado();
  if(!empty($listadoAcceso) && is_array($listadoAcceso)){
    foreach ($listadoAcceso as $accesoemp) {
      $facetaxusuario = Modelo_Usuario::obtenerFacetasxUsuario($accesoemp['id_usuario']);
      try {

        $fechacaducidad = strtotime ( '+'.$parametro.' hours',strtotime($accesoemp['fecha_envio_acceso']));
        $fechacaducidad = date('Y-m-d H:i:s',$fechacaducidad);

          if(count($facetaxusuario) == $facetas){
            if(!Modelo_AccesoEmpresa::actualizarFechaxidAcceso($accesoemp['id_accesos_empresas'], $fechacaducidad)){
              throw new Exception("Ha ocurrido un error al actualizar la fecha de caducidad");
            }
            
              if(count(Modelo_AccesoEmpresa::consultaPorCandidato($accesoemp['id_usuario'])) == 0){
                if (!Modelo_Notificacion::eliminarNotificacionUsuario($accesoemp['id_usuario'], Modelo_Notificacion::DESBLOQUEO_ACCESO)){
                  throw new Exception("Error en la cancelaci\u00F3n del acceso, por favor intente denuevo");
                }
              }
            
              $nombre_mostrar = utf8_encode($accesoemp["nombre_usuario"]).(!empty($accesoemp['apellido_usuario']) ? " ".utf8_encode($accesoemp['apellido_usuario']) : "");
              $email_body = Modelo_TemplateEmail::obtieneHTML("ACEPTACION_ACCESO");
              $email_body = str_replace("%NOMBRES%", $accesoemp['nombre_empresa'], $email_body);
              $email_body = str_replace("%CANDIDATO%", $nombre_mostrar, $email_body);    
              $email_body = str_replace("%FECHA%", $accesoemp['fecha_envio_acceso'], $email_body);  
              Utils::envioCorreo($accesoemp["correo"],"Aceptación de acceso",$email_body); 
          }
          else{
                if($fechacaducidad <= date('Y:m:d H:i:s')){
                  proceso($accesoemp);
                  $nombre_mostrar = utf8_encode($accesoemp["nombre_usuario"]).(!empty($accesoemp['apellido_usuario']) ? " ".utf8_encode($accesoemp['apellido_usuario']) : "");
                  $email_body = Modelo_TemplateEmail::obtieneHTML("DEVOLUCION_ACCESO");
                  $email_body = str_replace("%NOMBRES%", $accesoemp['nombre_empresa'], $email_body);
                  $email_body = str_replace("%CANDIDATO%", $nombre_mostrar, $email_body);    
                  $email_body = str_replace("%FECHA%", $accesoemp['fecha_envio_acceso'], $email_body);  
                  Utils::envioCorreo($accesoemp["correo"],"Devolución de acceso",$email_body);
                }      
              
            }
          }
          catch (Exception $e) {
            $GLOBALS['db']->rollback();
            echo "Error en usuario ".$accesoemp['id_usuario']." ".$e->getMessage()."<br>No se pudo enviar el correo al usuario ".$accesoemp['nombres'];
            Utils::envioCorreo('administrador.gye@micamello.com.ec','Error Cron Devolucion de accesos',$e->getMessage());
      }
    }
  }


  function proceso($accesoemp){
    $GLOBALS['db']->beginTrans();
      if (!Modelo_UsuarioxPlan::sumarNumeroAccesos($accesoemp["id_empresa_plan"])){
        throw new Exception("Error en la cancelaci\u00F3n del acceso, por favor intente denuevo");
      }
      if (!Modelo_AccesoEmpresa::eliminar($accesoemp["id_accesos_empresas"])){
        throw new Exception("Error en la cancelaci\u00F3n del acceso, por favor intente denuevo");
      }
      if(count(Modelo_AccesoEmpresa::consultaPorCandidato($accesoemp['id_usuario'])) == 0){
        if (!Modelo_Notificacion::eliminarNotificacionUsuario($accesoemp['id_usuario'], Modelo_Notificacion::DESBLOQUEO_ACCESO)){
          throw new Exception("Error en la cancelaci\u00F3n del acceso, por favor intente denuevo");
        }
      }
    $GLOBALS['db']->commit();
  }
//elimina archivo de procesamiento
unlink(CRON_RUTA.'devolucion_accesos.txt');
?>

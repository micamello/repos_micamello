<?php
ignore_user_abort( true );
ini_set("max_execution_time", "0");
ini_set("max_input_time", "0");
ini_set('memory_limit', "768M");
set_time_limit(0);

/*Script que permite las autopostulaciones del candidato dependiendo del plan contratado,
ubicación del candidato, areas de interes tomando en cuenta solo 3 dias laborables anteriores a la contratacion del plan y 
envio de correo con el numero de autopostulaciones*/

require_once '../constantes.php';
require_once '../init.php';

//pregunta si ya se esta ejecutando el cron sino crea el archivo
$resultado = file_exists(CRON_RUTA.'procesando_autopostulaciones.txt');
if ($resultado){
  exit;
}
else{
  Utils::crearArchivo(CRON_RUTA,'procesando_autopostulaciones.txt','');
}

//1.-consulta de todos los usuarios activos de tipo candidatos
$result_set = Modelo_Usuario::obtieneTodosCandidatos();
while( $rows = mysqli_fetch_array( $result_set, Database::ASSOC ) ){
  $mail_ofertas = ""; 
	//2.-consulta todos los planes activos del candidato que esten activos no hayan caducado y tenga aun postulaciones libres	
	$arr_planes = Modelo_UsuarioxPlan::planesConAutopostulaciones($rows["id_usuario"]);   
  if (empty($arr_planes)){
  	continue;
  }
  
  //consulta las areas niveles del candidato
  $arr_areas = Modelo_UsuarioxArea::obtieneListado($rows["id_usuario"]);
  $str_areas = implode($arr_areas,',');
  $arr_niveles = Modelo_UsuarioxNivel::obtieneListado($rows["id_usuario"]);
  $str_niveles = implode($arr_niveles,',');

  echo "<br>usuario: ".$rows["id_usuario"]." / ".$rows["nombres"]." / ".$rows["viajar"]." / ".$rows["id_provincia"]."<br>";
  echo "areas: ".$str_areas."<br>";
  echo "interes: ".$str_niveles."<br>";

  foreach($arr_planes as $plan){
    echo "plan: ".$plan["id_usuario_plan"]." / ".$plan["fecha_compra"]." / ".$plan["num_post_rest"]."<br>";
    //restar 3 dias laborables a la fecha de contratacion del plan
    $fechacalculada = Utils::restarDiasLaborables($plan["fecha_compra"],DIAS_AUTOPOSTULACION);           
    echo "3 dias antes ".$fechacalculada."<br>";
    //3.- obtiene todas las ofertas del pais del candidato, con los niveles y areas, si tiene disponibilidad para viajar o no y que no se haya postulado antes
    $arr_ofertas = Modelo_Oferta::obtieneAutopostulaciones($rows["id_pais"],$fechacalculada,$str_areas,$str_niveles,$rows["id_usuario"],(($rows["viajar"]) ? 0 :$rows["id_provincia"]));
    
    if (empty($arr_ofertas)){
    	echo "No hay ofertas para este plan<br>";
    	continue;
    }       

    $cont_publicacion = $plan["num_post_rest"];

    //4.-guardar la postulacion a esa oferta
    foreach($arr_ofertas as $oferta){
	    try{	
	  	  $GLOBALS['db']->beginTrans();

        if (!Modelo_Postulacion::postularse($rows["id_usuario"],$oferta["id_ofertas"],$oferta["salario"],Modelo_Postulacion::AUTOMATICO)){        	
          throw new Exception("Error al grabar la postulacion ".print_r($oferta,true));
        } 
        $idpostulacion = $GLOBALS['db']->insert_id();      
        if (!Modelo_Postulacion::guardarPostAuto($idpostulacion,$plan["id_usuario_plan"])){
        	throw new Exception("Error al grabar la postulacion automatica ".print_r($oferta,true));
        }        
        if (!Modelo_UsuarioxPlan::restarPublicaciones($plan["id_usuario_plan"],$cont_publicacion)){
          throw new Exception("Error al restar las autopostulaciones ".print_r($oferta,true)); 
        }
	  	  $GLOBALS['db']->commit();
         
        $cont_publicacion = $cont_publicacion - 1; 

        $empresa = Modelo_Usuario::busquedaPorId($oferta["id_usuario"]);    
        $mail_ofertas .= utf8_encode($oferta["titulo"])."<br>";
        $mail_ofertas .= utf8_encode($empresa["nombres"])." - ".utf8_encode($oferta["provincia"])."/".utf8_encode($oferta["ciudad"])."<br><br>";

        //si al plan ya se le acabo las autopostulaciones busca otro
        $numpostact = Modelo_UsuarioxPlan::consultaNroPostulaciones($plan["id_usuario_plan"]);
        if (empty($numpostact)){
        	break;
        }
        
        echo "PROCESADO REGISTRO ".$oferta['id_ofertas']."<br>";
	  	}
	    catch(Exception $e){
	  	  $GLOBALS['db']->rollback();
	  	  echo "NO PROCESADO REGISTRO ".$oferta['id_ofertas']."<br>";
	      Utils::envioCorreo('micamelloecuador@gmail.com','Error Cron autopostulaciones',$e->getMessage());      
	    }
    }
        
  }  
  
  //5.-envio de correo al candidato
  if (!empty($mail_ofertas)){
  	$email_body = "Estimado, ".utf8_encode($rows["nombres"])." ".utf8_encode($rows["apellidos"]).", le confirmamos su autopostulaci&oacute;n a las siguientes ofertas:<br><br>";
    $email_body .= $mail_ofertas;
  	Utils::envioCorreo($rows["correo"],"Autopostulaciones Automáticas",$email_body);
  }

}

//elimina archivo de procesamiento
unlink(CRON_RUTA.'procesando_autopostulaciones.txt');
?>
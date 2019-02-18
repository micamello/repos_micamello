<?php
ignore_user_abort( true );
ini_set("max_execution_time", "0");
ini_set("max_input_time", "0");
ini_set('memory_limit', "768M");
set_time_limit(0);

/*Script para eliminar las ofertas de los planes inactivos de las empresas*/

require_once '../constantes.php';
require_once '../init.php';

$resultado = file_exists(CRON_RUTA.'procesando_eliminar_ofertas.txt');
if ($resultado){
  exit;
}
else{
  Utils::crearArchivo(CRON_RUTA,'procesando_eliminar_ofertas.txt','');
}

$ofertas = Modelo_Oferta::ofertasxEliminar();
if (count($ofertas) > 0){
	$fechaactual = date("Y-m-d H:i:s");
	foreach($ofertas as $oferta){
		if ($oferta["fecha_actual"] > $oferta["fecha_tope"]){
			try{
				if (!Modelo_Oferta::desactivarOferta($oferta["id_ofertas"],Modelo_Oferta::INACTIVA)){
		      throw new Exception("Error al desactivar la oferta"); 
		    } 			  
			}
      catch(Exception $e){  	    
  	    echo "Error al inactivar oferta ".$oferta["id_ofertas"]."<br>";
        // Utils::envioCorreo('desarrollo@micamello.com.ec','Error Cron Eliminar Ofertas',$e->getMessage());   
		$datos_correo_error = array('tipo'=>8, 'correo'=>'desarrollo@micamello.com.ec', 'mensaje'=>$e->getMessage(), "type"=>TIPO['eliminar_oferta']);
   		Utils::enviarEmail($datos_correo_error);   
      } 
		}    
	}
}

//elimina archivo de procesamiento
unlink(CRON_RUTA.'procesando_eliminar_ofertas.txt');
?>
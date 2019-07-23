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

$ofertas = Modelo_Oferta::obtenerOfertas();

if (count($ofertas) > 0){

	echo '<br>fecha_actual: '.$fechaactual = date("Y-m-d H:i:s");
	echo '<br>dias_totales: '.$dias_totales = (int)OFERTA_ACTIVA_DESCARGA + (int)OFERTA_ACTIVA_VER;
	echo '<br>';
	foreach($ofertas as $oferta){

		echo '<br>id_ofertas: '.$oferta["id_ofertas"];
		echo '<br>fecha_creado: '.$oferta["fecha_creado"];
		$fecha_con_permisos = strtotime ( '+'.(OFERTA_ACTIVA_DESCARGA-1).' day' , strtotime ( $oferta["fecha_creado"] ) ) ;
		echo '<br>fecha_con_permisos: '.$fecha_con_permisos = date ( 'Y-m-d H:m:s' , $fecha_con_permisos );

		$fecha_limite = strtotime ( '+'.($dias_totales-1).' day' , strtotime ( $oferta["fecha_creado"] ) ) ;
		echo '<br>fecha_limite: '.$fecha_limite = date ( 'Y-m-d H:m:s' , $fecha_limite );

		try{
	    	if ($fechaactual >= $fecha_con_permisos && $fechaactual <= $fecha_limite){
	    		echo '<br>estado: 3';
	    		if (!Modelo_Oferta::desactivarOferta($oferta["id_ofertas"],Modelo_Oferta::DENTRODELTIEMPO)){
	    			throw new Exception("Error al cambiar estado de la oferta"); 
	    		}	    	
	    	}else if($fechaactual > $fecha_limite){
	    		echo '<br>estado: 0';
	    		if (!Modelo_Oferta::desactivarOferta($oferta["id_ofertas"],Modelo_Oferta::INACTIVA)){
		      		throw new Exception("Error al desactivar la oferta"); 
		    	} 
	    	}			  
		}
  		catch(Exception $e){  	    
	  	    echo "Error al inactivar oferta ".$oferta["id_ofertas"]."<br>";
	        Utils::envioCorreo('desarrollo@micamello.com.ec','Error Cron Eliminar Ofertas',$e->getMessage());
  		} 
		  echo '<br>'; 
	}
}

//elimina archivo de procesamiento
unlink(CRON_RUTA.'procesando_eliminar_ofertas.txt');
?>
<?php 

	ignore_user_abort(0);
	ini_set("max_execution_time", "0");
	ini_set("max_input_time", "0");
	ini_set('memory_limit', "768M");
	set_time_limit(0);

	require_once '../constantes.php';
	require_once '../init.php';


	$resultado = file_exists(CRON_RUTA.'plangratuitoempresa.txt');
	if ($resultado){
	  exit;
	}
	else{
	  Utils::crearArchivo(CRON_RUTA,'plangratuitoempresa.txt','');
	}

	$planesempresalistado = Modelo_Plan::busquedaEmpresaPlanTipo();

	if(!empty($planesempresalistado)){
		// si la fecha de caducidad del plan de la empresa es menor y estado inactivo entonces se procede a registrar el nuevo plan
		$fecha_actual = date('Y-m-d h:i:s');
		foreach ($planesempresalistado as $listado) {
			if($listado['maxdate'] < $fecha_actual && $listado['estado'] == 0){
				print_r($listado);
				$gratuitos = Modelo_Plan::busquedaActivoxTipo($listado['plan'], Modelo_Usuario::EMPRESA, $listado['id_sucursal']);
				if(!Modelo_UsuarioxPlan::guardarPlan($listado['id_empresa'], Modelo_Usuario::EMPRESA , 
													$gratuitos["id_plan"],$gratuitos["num_post"],
                                                	$gratuitos["duracion"],$gratuitos["porc_descarga"],'',false,
                                                	false,false,$gratuitos["num_accesos"] , $gratuitos["limite_perfiles"])){
					throw new Exception("Error al guardar el plan gratuitos a empresa: ".$listado['id_empresa']." plan:".$gratuitos["id_plan"]);

				}

			}
		}
	}
//elimina archivo de procesamiento
unlink(CRON_RUTA.'plangratuitoempresa.txt');

?>
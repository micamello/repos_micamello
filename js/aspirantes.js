function enviarPclave(ruta,page){

	var pclave = $('#inputGroup').val();

	if(pclave != ''){
		var nueva_ruta = ruta+"Q"+pclave.toLowerCase()+"/"+page+"/";
	}else{
		var nueva_ruta = ruta+page+"/";
	}
	window.location = nueva_ruta;

}

function obtenerFiltro(ruta,page){

	var pclave = $('#inputGroup1').val();
	var escolaridad = $('#escolaridad').val();
	var provincia = $('#provincia').val();
	var salario = $('#salario').val();
	var busco = false;

	if(pclave != ''){
		ruta += "Q"+pclave.toLowerCase()+"/";
		busco = true;
	}

	if(escolaridad != 0){
		ruta += "E"+escolaridad+"/";
		busco = true;
	}

	if(provincia != 0){
		ruta += "U"+provincia+"/";
		busco = true;
	}
	
	if(salario != 0){
		ruta += "S"+salario+"/";
		busco = true;
	}

	if(busco){
		var nueva_ruta = ruta+page+"/";
		window.location = nueva_ruta;
	}else{
		abrirModal('Debe Seleccionar al menos un filtro','alert_descarga','','Ok');
	}
}

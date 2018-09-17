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

	if(pclave != ''){
		ruta += "Q"+pclave.toLowerCase()+"/";
	}
	if(escolaridad != 0){
		ruta += "E"+escolaridad+"/";
	}
	if(provincia != 0){
		ruta += "U"+provincia+"/";
	}
	if(salario != 0){
		ruta += "S"+salario+"/";
	}

	var nueva_ruta = ruta+page+"/";
	window.location = nueva_ruta;
}

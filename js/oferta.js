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
	var categoria = $('#categoria').val();
	var provincia = $('#provincia').val();
	var jornada = $('#jornada').val();

	if(pclave != ''){
		ruta += "Q"+pclave.toLowerCase()+"/";
	}
	if(categoria != 0){
		ruta += "A"+categoria+"/";
	}
	if(provincia != 0){
		ruta += "P"+provincia+"/";
	}
	if(jornada != 0){
		ruta += "J"+jornada+"/";
	}

	var nueva_ruta = ruta+page+"/";
	window.location = nueva_ruta;
}

if(document.getElementById('form_postulacion')){
	$("#form_postulacion").validator();
}
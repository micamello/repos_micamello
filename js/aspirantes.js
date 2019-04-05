$(document).ready(function () {

    $("#range_00").ionRangeSlider({
        min: 0,
        max: 100,
        postfix:'%',
        onFinish: function(){
			verFacetasTodas();
        },
    });

    $("#range_01").ionRangeSlider({
        min: 0,
        max: 100,
        postfix:'%',
        onFinish: function(){
			verFacetasTodas();
        },
    });

    $("#range_02").ionRangeSlider({
        min: 0,
        max: 100,
        postfix:'%',
        onFinish: function(){
			verFacetasTodas();
        },
    });

    $("#range_03").ionRangeSlider({
        min: 0,
        max: 100,
        postfix:'%',
        onFinish: function(){
			verFacetasTodas();
        },
    });

    $("#range_04").ionRangeSlider({
        min: 0,
        max: 100,
        postfix:'%',
        onFinish: function(){
			verFacetasTodas();
        },
    });
});


function enviarPclave(ruta,page){

	var pclave = $('#inputGroup').val();

	if(pclave != ''){
		var nueva_ruta = ruta+"Q"+pclave.toLowerCase()+"/"+page+"/";
	}else{
		var nueva_ruta = ruta+page+"/";
	}
	window.location = nueva_ruta;

}

function verFacetas(facetas,pos){

	var ruta = document.getElementById('ruta').value;
	var page = document.getElementById('page').value;
	var hijos = document.querySelectorAll('#facetas > div > div > div > span > span > span');
	var j = 0;
	var valor = hijos[pos].innerText.replace('%','');

	if(valor > 0){
		porcentajes = 'R'+facetas+hijos[pos].innerText.replace('%','');
		var nueva_ruta = ruta+porcentajes+'/'+page+"/";
		window.location = nueva_ruta;
	}else{
		swal('Advertencia!', 'Debe seleccionar un porcentaje', 'error');
	}
}



function verFacetasTodas(){

	var facetas = document.getElementById('f').value;
	var page = document.getElementById('page').value;
	var ruta = document.getElementById('ruta').value;
	var hijos = document.querySelectorAll('#facetas > div > div > div > span > span > span');
	var porcentajes = 'R';
	var fac = facetas.split('-');
	var diff_cero = 0;
	var j = 0;
	for (var i = 5; i < hijos.length; i=i+6) {

		var valor = hijos[i].innerText.replace('%','');
		if(valor != 0){
			diff_cero++;
			if(fac[j] == 'A' && j>1){
				fac[j] = 'P';
			}
			porcentajes += fac[j]+valor;
		}
		j++;
	}

	if(diff_cero >= 3){
		var nueva_ruta = ruta+porcentajes+'/'+page+"/";
		for (var i = 0; i < j; i++) {
			document.getElementById('btn_'+i).style.display = 'none';
			document.getElementById('fac_'+i).style.width = '288px';
		}
		document.getElementById('btn_consultar').href = nueva_ruta;
		document.getElementById('btn_consultar').style.display = 'block';
	}else{

		for (var i = 0; i < fac.length-1; i++) {

			document.getElementById('btn_'+i).style.display = 'block';
			document.getElementById('fac_'+i).style.width = '261px';
		}
		document.getElementById('btn_consultar').href = '#';
		document.getElementById('btn_consultar').style.display = 'none';
	}
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
		//abrirModal('Debe Seleccionar al menos un filtro','alert_descarga','','Ok');
		swal('Advertencia!', 'Debe Seleccionar al menos un filtro', 'error');
	}
}

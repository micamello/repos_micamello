$(document).ready(function () {

  	$('[data-toggle="tooltip"]').tooltip();   

	if($('#accesos').val() == 1 && $('#vista').val() == 2){
		$('#planes').show();
    }/*else{
    	$('#planes').hide();
    }*/

	$("#range_05").ionRangeSlider({
        min: 0,
        max: 100,
        from:$('#C').val(),
        postfix:'%',
        onFinish: function(){
			verFacetasTodas();
        },
    });

    $("#range_06").ionRangeSlider({
        min: 0,
        max: 100,
        from:$('#A').val(),
        postfix:'%',
        onFinish: function(){
			verFacetasTodas();
        },
    });

    $("#range_07").ionRangeSlider({
        min: 0,
        max: 100,
        from:$('#N').val(),
        postfix:'%',
        onFinish: function(){
			verFacetasTodas();
        },
    });

    $("#range_08").ionRangeSlider({
        min: 0,
        max: 100,
        from:$('#E').val(),
        postfix:'%',
        onFinish: function(){
			verFacetasTodas();
        },
    });

    $("#range_09").ionRangeSlider({
        min: 0,
        max: 100,
        from:$('#P').val(),
        postfix:'%',
        onFinish: function(){
			verFacetasTodas();
        },
    });

    $("#range_00").ionRangeSlider({
        min: 0,
        max: 100,
        from:$('#C').val(),
        postfix:'%',
        onFinish: function(){
			verFacetasTodas();
        },
    });

    $("#range_01").ionRangeSlider({
        min: 0,
        max: 100,
        from:$('#A').val(),
        postfix:'%',
        onFinish: function(){
			verFacetasTodas();
        },
    });

    $("#range_02").ionRangeSlider({
        min: 0,
        max: 100,
        from:$('#N').val(),
        postfix:'%',
        onFinish: function(){
			verFacetasTodas();
        },
    });

    $("#range_03").ionRangeSlider({
        min: 0,
        max: 100,
        from:$('#E').val(),
        postfix:'%',
        onFinish: function(){
			verFacetasTodas();
        },
    });

    $("#range_04").ionRangeSlider({
        min: 0,
        max: 100,
        from:$('#P').val(),
        postfix:'%',
        onFinish: function(){
			verFacetasTodas();
        },
    });

    verFacetasTodas(); 
    cargaAutomaticaModal();
});

$('#button_convertir_oferta').on('click', function(){
	document.form_convertir.submit();
});

$('#btn_convertir').on('click', function(){

	var puerto_host = $('#puerto_host').val();
	var idOferta = document.getElementById('idOferta').value;
	if($('#cantd_planes').val() > 0){
		
		$.ajax({
	        type: "GET",
	        url: puerto_host+"/index.php?mostrar=oferta&opcion=buscaTitulo&idOferta="+idOferta+"&tipo=1",
	        dataType:'json',
	        async: false,
	        success:function(data){

	            $('#titulo_oferta').html('<b>Oferta: </b>'+data.titulo);
	            //$('#id_oferta').val(idOferta);
	            $('#convertir').modal();
	        },
	        error: function (request, status, error) {
	            error = 1;
	        }                  
	    })
	}else{

		$.ajax({
	        type: "GET",
	        url: puerto_host+"/index.php?mostrar=oferta&opcion=convertir&idOferta="+idOferta+"&tipo=1",
	        dataType:'json',
	        async: false,                 
	    })

	    window.location = puerto_host+'/planes/';
	}
});


$('#cancelar_conversion').on('click', function(){

	var puerto_host = $('#puerto_host').val();
	$.ajax({
        type: "GET",
        url: puerto_host+"/index.php?mostrar=oferta&opcion=convertir&tipo=2",
        dataType:'json',
        async: false,                 
    })

    if(document.getElementById('ofertaConvertir') && document.getElementById('ofertaConvertir').value != ''){
    	window.location = puerto_host+'/verAspirantes/1/'+document.getElementById('ofertaConvertir').value+'/1/';
	}
});


$('#btn_accesos_confirmar').on('click', function(){
	document.form_enviarAccesos.submit();
});

$('#activar-accesos').on('click', function(){
	
	$('#aviso_accesos').modal();
	activar();
});

$('#btn_accesos_cancelar').on('click', function(){
	desactivar();
});

$('#cerrar_accesos').on('click', function(){
	desactivar();
});

function cargaAutomaticaModal(){

	var puerto_host = $('#puerto_host').val();
	if(document.getElementById('ofertaConvertir') && document.getElementById('ofertaConvertir').value != ''){

    	var idOferta = document.getElementById('ofertaConvertir').value;	
		$.ajax({
	        type: "GET",
	        url: puerto_host+"/index.php?mostrar=oferta&opcion=buscaTitulo&idOferta="+idOferta+"&tipo=2",
	        dataType:'json',
	        async: false,
	        success:function(data){

	            $('#titulo_oferta').html('<b>Oferta: </b>'+data.titulo);
	            //$('#convertir').modal();
	        },
	        error: function (request, status, error) {
	            error = 1;
	        }                  
	    })
    }
}

/*$('#marcarTo').on('change',function(){

	if(!$("#marcarTo").is(':checked')) { 
		desmarcarCheckboxes();
	}else{
		marcarTodo();
	}
});*/

$('#listadoPlanes').on('change',function(){

	var puerto_host = $('#puerto_host').val();
	var plan = $('#listadoPlanes').val();

	$('.check_usuarios').removeAttr('disabled');
	$('.check_usuarios').removeAttr('title');
	//document.getElementById('marcarTo').setAttribute('title', 'Marcar Todo');
	//$('#marcarTo').removeAttr('disabled');
	$.ajax({
        type: "GET",
        url: puerto_host+"/index.php?mostrar=aspirante&opcion=guardarPlanSeleccionado&idPlan="+plan,
        dataType:'json',         
    })
});

function marcarTodo(){

	var puerto_host = $('#puerto_host').val();
	var plan = $('#listadoPlanes').val();
	var usuarios = '';

	if(plan == undefined){
		plan = $('#planOf').val();
	}

	$.ajax({
        type: "GET",
        url: puerto_host+"/index.php?mostrar=aspirante&opcion=buscarCantdAccesos&idPlan="+plan,
        dataType:'json',
        success:function(data){

        	var checkboxes = document.getElementsByName('usuarios_check');
			for(var i=0;i<checkboxes.length;i++) {

				if(i <= (data.cantd-1)){
					if(checkboxes[i].checked == true){
						checkboxes[i].checked = false;
					}else{
						checkboxes[i].checked = true;
					}
					
					if(usuarios != ''){
						usuarios += ','+checkboxes[i].id;
					}else{
						usuarios = checkboxes[i].id;
					}
				}else{
					break;
				}
			}
			$.ajax({
		        type: "GET",
		        url: puerto_host+"/index.php?mostrar=aspirante&opcion=guardarUsuariosSeleccionados&marcar=1&usuario="+usuarios,
		        dataType:'json',         
		    })
        },
        error: function (request, status, error) {
            error = 1;
        }           
    })
	/*}else{
		var checkboxes = document.getElementsByName('usuarios_check');
		for(var i=0;i<checkboxes.length;i++) {

			if(checkboxes[i].checked == true){
				checkboxes[i].checked = false;
			}else{
				checkboxes[i].checked = true;

				if(usuarios != ''){
					usuarios += ','+checkboxes[i].id;
				}else{
					usuarios = checkboxes[i].id;
				}
			}
		}

		$.ajax({
	        type: "GET",
	        url: puerto_host+"/index.php?mostrar=aspirante&opcion=guardarUsuariosSeleccionados&marcar=1&usuario="+usuarios,
	        dataType:'json',         
	    })
	}*/
}

function desmarcarCheckboxes(){

	var puerto_host = $('#puerto_host').val();
	//document.getElementById('marcarTo').removeAttribute('checked');
	//document.getElementById('marcarTo').setAttribute('title', 'Debe seleccionar un plan');

	var usuarios = '';
	var checkboxes = document.getElementsByName('usuarios_check');
	for(var i=0;i<checkboxes.length;i++) {

		checkboxes[i].setAttribute('title','Debe seleccionar un plan');
		checkboxes[i].checked = false;
		if(usuarios != ''){
			usuarios += ','+checkboxes[i].id;
		}else{
			usuarios = checkboxes[i].id;
		}
	}

	$.ajax({
        type: "GET",
        url: puerto_host+"/index.php?mostrar=aspirante&opcion=guardarUsuariosSeleccionados&marcar=0&usuario="+usuarios,
        dataType:'json',         
    })
}

function marcarSeleccionado(usuario){

	var puerto_host = $('#puerto_host').val();
	var marcar = 1;
	if(!$("#"+usuario).is(':checked')) { 
		marcar = 0;
	}

	$.ajax({
        type: "GET",
        url: puerto_host+"/index.php?mostrar=aspirante&opcion=guardarUsuariosSeleccionados&marcar="+marcar+"&usuario="+usuario,
        dataType:'json', 
        success:function(data){
        	/*if(data.marcarTo == 1){
        		document.getElementById('marcarTo').setAttribute('checked','checked');
        	}else{
        		document.getElementById('marcarTo').removeAttribute('checked');
        	}*/
        },
        error: function (request, status, error) {
            error = 1;
        }        
    })
}

function activar(){

	var puerto_host = $('#puerto_host').val();
	var vista = $('#vista').val();
	if(vista == 2){ 
		$('#planes').show();
		$('.check_usuarios').attr('disabled','disabled');
		//$('#marcarTo').attr('disabled','disabled');
		//document.getElementById('marcarTo').removeAttribute('checked');
		//document.getElementById('marcarTo').setAttribute('title', 'Debe seleccionar un plan');
	}else{
		$('#planes').hide();
	}

	$.ajax({
        type: "GET",
        url: puerto_host+"/index.php?mostrar=aspirante&opcion=activarAccesos&accesos=1",
        dataType:'json',           
    })
	
	$('#accesos').val(0);
	$('#activarAccesos').hide();
	$('#desactivarAccesos').show();
	$('#marcar').show();
	$('.checkboxes').show();
}

function desactivar(){

	var puerto_host = $('#puerto_host').val();

	$.ajax({
        type: "GET",
        url: puerto_host+"/index.php?mostrar=aspirante&opcion=activarAccesos&accesos=0",
        dataType:'json',     
    })

	desmarcarCheckboxes();
	$('#listadoPlanes option[value="0"]').prop('selected',true);
	$('#accesos').val(1);
	$('#planes').hide();
	$('#desactivarAccesos').hide();
	$('#activarAccesos').show();
	$('#marcar').hide();
	$('.checkboxes').hide();
}

function enviarPclave(ruta,tipo,page){

	var pclave = $('#inputGroup').val();

	if(pclave != '' && pclave.length >= 2){
		var nueva_ruta = ruta+"Q"+pclave.toLowerCase()+"/"+page+"/";
		window.location = nueva_ruta;
	}else{
		
		if(tipo == 1){
            swal('Notificación!', 'La longitud mínima de la palabra clave es de 2 caracteres', 'error');
        }else{
            var nueva_ruta = ruta+page+"/";
            window.location = nueva_ruta;
        }
	}
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

	if(diff_cero >= 2){
		var nueva_ruta = ruta+porcentajes+'/'+page+"/";
		for (var i = 0; i < j; i++) {
			document.getElementById('btn_'+i).style.display = 'none';
			document.getElementById('fac_'+i).style.width = '100%';
		}
		document.getElementById('btn_consultar').href = nueva_ruta;
		document.getElementById('btn_consultar').style.display = 'block';
	}else{

		for (var i = 0; i < fac.length-1; i++) {

			document.getElementById('btn_'+i).style.display = 'block';
			document.getElementById('fac_'+i).style.width = '90%';
		}
		document.getElementById('btn_consultar').href = '#';
		document.getElementById('btn_consultar').style.display = 'none';
	}
}

function verFacetasTodasMovil(){

	var facetas = document.getElementById('f').value;
	//var page = document.getElementById('page').value;
	//var ruta = document.getElementById('ruta').value;
	var hijos = document.querySelectorAll('#facetas_movil > div > div > div > span > span > span');
	var porcentajes = '';
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
	return porcentajes;
	/*if(diff_cero >= 3){
		var nueva_ruta = ruta+porcentajes+'/'+page+"/";
		for (var i = 0; i < j; i++) {
			document.getElementById('btn_'+i).style.display = 'none';
			document.getElementById('fac_'+i).style.width = '100%';
		}
		document.getElementById('btn_consultar').href = nueva_ruta;
		document.getElementById('btn_consultar').style.display = 'block';
	}else{

		for (var i = 0; i < fac.length-1; i++) {

			document.getElementById('btn_'+i).style.display = 'block';
			document.getElementById('fac_'+i).style.width = '90%';
		}
		document.getElementById('btn_consultar').href = '#';
		document.getElementById('btn_consultar').style.display = 'none';
	}*/
}

function obtenerFiltro(ruta,page){

	var pclave = $('#inputGroup1').val();
	var escolaridad = $('#escolaridad').val();
	var provincia = $('#provincia').val();
	var salario = $('#salario').val();
	var informe = $('#informe').val();
	var areas = $('#areas').val();
	var nacionalidad = $('#nacionalidad').val();
	var postulado = $('#postulado').val();
	var genero = $('#genero').val();
	var viajar = $('#viajar').val();
	var trabajo = $('#trabajo').val();
	var licencia = $('#licencia').val();
	var discapacidad = $('#discapacidad').val();
	var facetas = verFacetasTodasMovil();
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

	if(areas != 0){
		ruta += "A"+areas+"/";
		busco = true;
	}

	if(nacionalidad != 0){
		ruta += "N"+nacionalidad+"/";
		busco = true;
	}

	if(postulado != 0){
		ruta += "F"+postulado+"/";
		busco = true;
	}

	if(genero != 0){
		ruta += "G"+genero+"/";
		busco = true;
	}

	if(viajar != 0){
		ruta += "V"+viajar+"/";
		busco = true;
	}

	if(trabajo != 0){
		ruta += "T"+trabajo+"/";
		busco = true;
	}

	if(licencia != -1){
		ruta += "L"+licencia+"/";
		busco = true;
	}

	if(discapacidad != 0){
		ruta += "D"+discapacidad+"/";
		busco = true;
	}

	if(informe != 0){
		ruta += "P"+informe+"/";
		busco = true;
	}

	if(facetas != ''){
		ruta += "R"+facetas+"/";
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

// DEPENDENCIAS
var puerto_host = $('#puerto_host').val();

$('#pais').on('change', function(){
	var id_pais = $(this).val(); 
	if (id_pais != "" && id_pais == 14) {
	        $.ajax({
	            type: "GET",
	            url: puerto_host+"?mostrar=regtest&opcion=buscaProvincia&id_pais="+id_pais,
	            dataType:'json',
	            success:function(data){
	                $('#provincia').html('<option value="">Selecciona una provincia</option>');
	                // console.log(data);
	                $.each(data, function(index, value) {
	                    $('#provincia').append("<option value='"+index+"'>"+value+"</option>");

	                });
	            },
	            error: function (request, status, error) {
	                alert(request.responseText);
	            }
	        });
		$('#provincia_content').css('display', '');
		$('#cantonnac').attr('disabled', '');
		$('#cantonnac_content').css('display', '');
	}
	else{
		$('#provincia').html('<option value="">Selecciona una provincia</option>');
		$('#cantonnac').html('<option value="">Selecciona un cantón</option>');
		$('#provincia_content').css('display', 'none');
		$('#cantonnac_content').css('display', 'none');
		eliminarMensajeError($('#provincia'), '');
		eliminarMensajeError($('#cantonnac'), '');
	}
});

$('#provincia').on('change', function(){
	var id_provincia = $(this).val();
	if(id_provincia != ""){
		$.ajax({
	            type: "GET",
	            url: puerto_host+"?mostrar=regtest&opcion=buscaCiudad&id_provincia="+id_provincia,
	            dataType:'json',
	            success:function(data){
	                $('#cantonnac').html('<option value="">Selecciona un cantón</option>');
	                // console.log(data);
	                $.each(data, function(index, value) {
	                    $('#cantonnac').append("<option value='"+value.id_ciudad+"'>"+value.ciudad+"</option>");
	                });
	            },
	            error: function (request, status, error) {
	                alert(request.responseText);
	            }
	        });
		$('#cantonnac').removeAttr('disabled');
	}
});

$('#provincia_res').on('change', function(){
	var id_provincia = $(this).val();
	if(id_provincia != ""){
		$.ajax({
	            type: "GET",
	            url: puerto_host+"?mostrar=regtest&opcion=buscaCiudad&id_provincia="+id_provincia,
	            dataType:'json',
	            success:function(data){
	                $('#canton_res').html('<option value="">Selecciona un cantón</option>');
	                console.log(data);
	                $.each(data, function(index, value) {
	                    $('#canton_res').append("<option value='"+value.id_ciudad+"'>"+value.ciudad+"</option>");
	                });
	            },
	            error: function (request, status, error) {
	                alert(request.responseText);
	            }
	        });
		$('#canton_res').removeAttr('disabled');
	}
});

$('#canton_res').on('change', function(){
	var id_canton = $(this).val();
	if(id_canton != ""){
		$.ajax({
	            type: "GET",
	            url: puerto_host+"?mostrar=regtest&opcion=buscaParroquia&id_canton="+id_canton,
	            dataType:'json',
	            success:function(data){
	                $('#parroquia_res').html('<option value="">Selecciona una parroquia</option>');
	                console.log(data);
	                $.each(data, function(index, value) {
	                    $('#parroquia_res').append("<option value='"+value.id_parroquia+"'>"+value.descripcion+"</option>");
	                });
	            },
	            error: function (request, status, error) {
	                alert(request.responseText);
	            }
	        });
		$('#parroquia_res').removeAttr('disabled');
	}
});
// DEPENDENCIAS
//Validaciones
var mensaje_error = "";
$('#nombres').on('blur', function(){
	emptyField(this);
	validarCaracteresPermitidos('nombre_apellido', $(this));
});

$('#apellidos').on('blur', function(){
	emptyField(this);
	validarCaracteresPermitidos('nombre_apellido', $(this));
});

$('#fecha_nacimiento').on('blur', function(){
	emptyField(this);
	validarCaracteresPermitidos('fecha', $(this));
});

$('#genero').on('change', function(){
	emptyField(this);
	// validarCaracteresPermitidos('nombre_apellido', $(this));
});

$('#pais').on('change', function(){
	emptyField(this);
	// validarCaracteresPermitidos('nombre_apellido', $(this));
});

$('#provincia').on('change', function(){
	emptyField(this);
	// validarCaracteresPermitidos('nombre_apellido', $(this));
});

$('#cantonnac').on('change', function(){
	emptyField(this);
	// validarCaracteresPermitidos('nombre_apellido', $(this));
});

$('#estado_civil').on('change', function(){
	emptyField(this);
	// validarCaracteresPermitidos('nombre_apellido', $(this));
});

$('#nivel_instruccion').on('change', function(){
	emptyField(this);
	// validarCaracteresPermitidos('nombre_apellido', $(this));
});

$('#profesion').on('change', function(){
	emptyField(this);
	// validarCaracteresPermitidos('nombre_apellido', $(this));
});

$('#ocupacion').on('change', function(){
	emptyField(this);
	// validarCaracteresPermitidos('nombre_apellido', $(this));
});

$('#provincia_res').on('change', function(){
	emptyField(this);
	// validarCaracteresPermitidos('nombre_apellido', $(this));
});

$('#canton_res').on('change', function(){
	emptyField(this);
	// validarCaracteresPermitidos('nombre_apellido', $(this));
});

$('#parroquia_res').on('change', function(){
	emptyField(this);
	// validarCaracteresPermitidos('nombre_apellido', $(this));
});

$('#correo').on('blur', function(){
	emptyField(this);
	validarCaracteresPermitidos('correo', $(this));
});

$('#aspiracion_salarial').on('blur', function(){
	emptyField(this);
	validarCaracteresPermitidos('dinero', $(this));
});

$('#terminos_condiciones').on('change', function(){
	emptyField(this);
	// validarCaracteresPermitidos('nombre_apellido', $(this));
});

// inicializar campos del formulario
function camposFormulario(){
	var camposForm = [];
	if($('#nombres').length){
		var nombres_field = $('#nombres');
		camposForm.push(nombres_field);
	}
	if($('#apellidos').length){
		var apellidos_field = $('#apellidos');
		camposForm.push(apellidos_field);
	}
	if($('#fecha_nacimiento').length){
		var fecha_nacimiento_field = $('#fecha_nacimiento');
		camposForm.push(fecha_nacimiento_field);
	}
	if($('#genero').length){
		var genero_field = $('#genero');
		camposForm.push(genero_field);
	}
	if($('#pais').length){
		var pais_field = $('#pais');
		camposForm.push(pais_field);
	}
	// dependencias start
	if($('#provincia_content:visible').length == 1){
		if($('#provincia').length){
			var provincia_field = $('#provincia');
			camposForm.push(provincia_field);
		}
	}
	if($('#cantonnac_content:visible').length == 1){
		if($('#cantonnac').length){
			var cantonnac_field = $('#cantonnac');
			camposForm.push(cantonnac_field);
		}
	}
	// dependencias end
	if($('#estado_civil').length){
		var estado_civil_field = $('#estado_civil');
		camposForm.push(estado_civil_field);
	}
	if($('#nivel_instruccion').length){
		var nivel_instruccion_field = $('#nivel_instruccion');
		camposForm.push(nivel_instruccion_field);
	}
	if($('#profesion').length){
		var profesion_field = $('#profesion');
		camposForm.push(profesion_field);
	}
	if($('#ocupacion').length){
		var ocupacion_field = $('#ocupacion');
		camposForm.push(ocupacion_field);
	}
	if($('#provincia_res').length){
		var provincia_res_field = $('#provincia_res');
		camposForm.push(provincia_res_field);
	}
	if($('#canton_res').length){
		var canton_res_field = $('#canton_res');
		camposForm.push(canton_res_field);
	}
	if($('#parroquia_res').length){
		var parroquia_res_field = $('#parroquia_res');
		camposForm.push(parroquia_res_field);
	}
	if($('#correo').length){
		var correo_field = $('#correo');
		camposForm.push(correo_field);
	}
	if($('#aspiracion_salarial').length){
		var aspiracion_salarial_field = $('#aspiracion_salarial');
		camposForm.push(aspiracion_salarial_field);
	}
	if($('#terminos_condiciones').length){
		var terminos_condiciones_field = $('#terminos_condiciones');
		camposForm.push(terminos_condiciones_field);
	}
	return camposForm;
}

function ValidarCamposVacios(campos){
	for (var i = 0; i < campos.length; i++) {
		emptyField(campos[i]);
	}
}

function errorCountMessage(){
	var number = $('.error_field').length;
	// console.log(number);
	return number;
}
 // || $(obj)[0].checked != 1
function emptyField(obj){
	if($(obj).prop('type') != 'checkbox'){
		if($(obj).val() == "" || $(obj).val() == null){
			if($(obj).prop('tagName') == 'SELECT'){
				mensaje_error = "Seleccione una opción";
			}
			else{
				mensaje_error = "Rellene este campo";
			}
			crearMensajeError(obj, mensaje_error);
		}
		else{
			mensaje_error = "";
			eliminarMensajeError(obj, mensaje_error);
		}
	}
	else{
		if($(obj).prop('type') == 'checkbox'){
			if(!$(obj).is(':checked')){
				mensaje_error = "Debe aceptar términos y condiciones";
				crearMensajeError(obj, mensaje_error);
			}
			else{
				mensaje_error = "";
					eliminarMensajeError(obj, mensaje_error);
			}
		}
	}
}

function crearMensajeError(obj, mensaje){
	$(obj).siblings('div').html(mensaje);
	$(obj).siblings('div').addClass('error_field');
}

function eliminarMensajeError(obj, mensaje){
	$(obj).siblings('div').html(mensaje);
	$(obj).siblings('div').removeClass('error_field');
}
//Validaciones
$('#form_registrotest').on('submit', function(event){
	ValidarCamposVacios(camposFormulario());
	permitidos();
	if(errorCountMessage() > 0){
		event.preventDefault();
	}
	// errorCountMessage();
	
	// event.preventDefault();
});

function validarCaracteresPermitidos(tipo, contenido){
	var tipo_validacion = [];
	tipo_validacion.push(["nombre_apellido", ['El ' +contenido.siblings('label').text()+ ' ingresado no es válido', validarNombreApellido(contenido[0].value)]]);
	tipo_validacion.push(["correo", ['El ' +contenido.siblings('label').text()+ ' ingresado no es válido', validarCorreo(contenido[0].value)]]);
	tipo_validacion.push(["fecha", ['El ' +contenido.siblings('label').text()+ ' ingresado no es válido', validarFecha(contenido[0].value)]]);
	tipo_validacion.push(["dinero", ['El formato ingresado no es válido', validarFormatoDinero(contenido[0].value)]]);
	tipo_validacion.push(["numero", ['Solo numeros entre 1 y 5', validarNumero(contenido[0].value)]]);
	// console.log(tipo_validacion);
	if (tipo == tipo_validacion[0][0] && (contenido[0].value != null && contenido[0].value != "")) {
		if(!(tipo_validacion[0][1][1])){
			crearMensajeError(contenido, tipo_validacion[0][1][0]);
		}
		else{
			eliminarMensajeError(contenido);
		}
	}
	if (tipo == tipo_validacion[1][0] && (contenido[0].value != null && contenido[0].value != "")) {
		if(!(tipo_validacion[1][1][1])){
			crearMensajeError(contenido, tipo_validacion[1][1][0]);
		}
		else{
			eliminarMensajeError(contenido);
		}
	}
	if (tipo == tipo_validacion[2][0] && (contenido[0].value != null && contenido[0].value != "")) {
		if(!(tipo_validacion[2][1][1])){
			crearMensajeError(contenido, tipo_validacion[2][1][0]);
		}
		else{
			eliminarMensajeError(contenido);
		}
	}
	if (tipo == tipo_validacion[3][0] && (contenido[0].value != null && contenido[0].value != "")) {
		if(!(tipo_validacion[3][1][1])){
			crearMensajeError(contenido, tipo_validacion[3][1][0]);
		}
		else{
			eliminarMensajeError(contenido);
		}
	}
	if (tipo == tipo_validacion[4][0] && (contenido[0].value != null && contenido[0].value != "")) {
		if(!(tipo_validacion[4][1][1])){
			crearMensajeError(contenido, tipo_validacion[4][1][0]);
		}
		else{
			eliminarMensajeError(contenido);
		}
	}
};

function permitidos(){
	validarCaracteresPermitidos('nombre_apellido', $('#nombres'));
	validarCaracteresPermitidos('nombre_apellido', $('#apellidos'));
	validarCaracteresPermitidos('fecha', $('#fecha_nacimiento'));
	validarCaracteresPermitidos('correo', $('#correo'));
	validarCaracteresPermitidos('dinero', $('#aspiracion_salarial'));
}

function validarCorreo(correo) { 
  return /^\w+([\.\+\-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(correo);
}

function validarNombreApellido(nombre){
	return /^[A-Za-zÁÉÍÓÚñáéíóúÑ ]+?$/.test(nombre);
}

function validarFecha(fecha){
	// console.log(fecha);
	return /^(19[5-9][0-9]|20[0-4][0-9]|2050)[-/](0?[1-9]|1[0-2])[-/](0?[1-9]|[12][0-9]|3[01])$/.test(fecha);
}

function validarNumero(numero){
	return /^[1-5]{1,1}$/.test(numero);
}

$("#ocupaciones").on("keyup", function() {
	var value = $(this).val().toLowerCase();
	$("#listaOcupaciones li").filter(function() {
	  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	});
});

$("#profesiones").on("keyup", function() {
	var value = $(this).val().toLowerCase();
	$("#listaProfesiones li").filter(function() {
	  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	});
});

$("#nacionalidades").on("keyup", function() {
	var value = $(this).val().toLowerCase();
	$("#menu1 li").filter(function() {
	  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	});
});

$("#residencia").on("keyup", function() {
	var value = $(this).val().toLowerCase();
	$("#menu2 li").filter(function() {
	  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	});
});

$("#competencias").on("keyup", function() {
	var value = $(this).val().toLowerCase();
	$("#menu3 li").filter(function() {
	  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	});
});

function enviarPclave(ruta){

	window.location = ruta;
}

function validarFormatoDinero(salario){
	return /^[0-9]*\.[0-9][0-9]$/.test(salario);
}

// *******************************RESPUESTAS************************************
if($('.list-group1').length){
	$('.list-group1').draggable({
	    revert: 'invalid',
	    stop: function(){
	        $(this).draggable('option','revert','invalid');
	    }
	  });
}

if($('.caja_origen').length){
	$('.caja_origen').droppable(
    {
      drop: function(event, ui){
        var draggable = ui.draggable;
        var droppable = $(this);
          if(droppable.find('ul').length > 0){
            draggable.css({top: '0px', left: '0px'});
          }
          else{
            droppable.removeAttr('class');
            droppable.attr('class', 'caja_origen');
            draggable.appendTo(droppable);
            draggable.css({top: '0px', left: '0px'});
          }
      },
      out: function(event, ui){
        var draggable = ui.draggable;
        var droppable = $(this);
        droppable.removeAttr('class');
        droppable.attr('class', 'caja_origen');
      }
    }
  );
}

if($('.caja_destino').length){
	$('.caja_destino').droppable(
    {
      drop: function(event, ui){
        var draggable = ui.draggable;
        var droppable = $(this);
          if(droppable.find('ul').length > 0){
            draggable.css({top: '0px', left: '0px'});
          }
          else{
            droppable.find('P').html('');
            droppable.removeAttr('class');
            droppable.attr('class', 'caja_destino');
            draggable.appendTo(droppable);
            draggable.css({top: '0px', left: '0px'});
            crearinputRespuestas();
          }
      },
      out: function(event, ui){
        var draggable = ui.draggable;
        var droppable = $(this);
        // console.log('eder'+$(this).find('ul').length);
        if(droppable.find('ul').length <= 0){
          droppable.find('P').html('Arrastre aqui');
          droppable.attr('class', 'caja_destino');
        }
      },
    }
  );
}  
  
// DRAG AND DROP
  function crearinputRespuestas(){
    var contenedor_resp = $('#contenedor_resp');
    var opcion_value = 0;
    var order = 0;
    contenedor_resp.html("");
    var find_destiny = $('.caja_destino');
    for (var i = 0; i < find_destiny.length; i++) {
      order = 0;
      order = $(find_destiny[i]).find('input[name="orden"]');
      if($(find_destiny[i]).find('input[name="opcion"]').length){
        opcion_value = $(find_destiny[i]).find('input[name="opcion"]').val();
      }
      else{
        opcion_value = 0;
      }
        // console.log("orden: "+order.val());
        // console.log("opcion: "+opcion_value);
        var input_opcion = $('<input></input>');
        var input_orden = $('<input></input>');
        input_orden.attr('name', 'respuestas_orden[]');
        input_orden.attr('value', order.val());
        input_orden.css('background-color', 'red');
        input_opcion.attr('name', 'respuestas_opcion[]');
        input_opcion.attr('value', opcion_value)
        contenedor_resp.append(input_orden);
        contenedor_resp.append(input_opcion);
    }
  };

 $('#respuestas_form').on('submit', function(event){
 	if(validarRespuestas() == false){
 		mostrarerror();
 		event.preventDefault();
 	}
 });


function validarRespuestas(){
	var respuestas_insertadas = $('.caja_destino');
	var contador_respuestas = 0;
	for (var i = respuestas_insertadas.length - 1; i >= 0; i--) {
		var respuestas = $(respuestas_insertadas[i]).find('ul');
		if(respuestas.length){
			contador_respuestas++;
		}
	}
	console.log(contador_respuestas+"-----"+respuestas_insertadas.length);
	$return = false;
	if(contador_respuestas == respuestas_insertadas.length){
		$return  = true;
	}
	return $return;
};

function mostrarerror(mensaje_text = 'Por favor arrastre todas las opciones del lado izquierdo en los cuadros que se muestran en el lado derecho de acuerdo a su prioridad.'){
	var mensaje = ('<div class="alert alert-danger text-center" role="alert"><h5><b>'+mensaje_text+'</b></h5></div>');
	$('#error_msg').html(mensaje);
}

// $(document).ready(function(){
//   var n = 0;
//   var l = document.getElementById("tiempo");
//   window.setInterval(function(){
//     l.setAttribute('value', n);
//     n++;
//   },1000);
// });
if($('#pre').length){
	if($('#pre').val() <= 1){
		$('#texto_modal').html('Por favor ordene  de 1 a 5  las siguientes oraciones en cada pregunta. <br>(uno es la oración con la que mas se identifica  y 5 es con la que menos se identifica)');
		$('#exampleModal').modal('show');
	}
};

// seleccion de método
// CASILLAS
	$('input[type=radio][name="seleccion"]').change(function() {
		var seleccion_value = this.value;
		var radios = $('input[type=radio][name="seleccion"]');
		for (var i = radios.length - 1; i >= 0; i--) {
			$('#gif_'+(i+1)).removeAttr('class');
		}
		$('#gif_'+seleccion_value).attr('class', 'bounce');
	});

	$('#form_seleccion').on('submit', function(event){
		if(validar_seleccion_form() <= 0){
			mostrarerror('Por favor, seleccione una de las opciones.');
			event.preventDefault();
		}
		else{
			$('#error_msg').html('');
		}
	});

	function validar_seleccion_form(){
		var count = $('[name="seleccion"]:checked').length;
		return count;
	}

	function crearInputRespuestasSeleccion(){
		var contenedor_resp = $('#contenedor_resp');
		contenedor_resp.html("");
		var opcion;
		var orden;
		var respuestas = $('.respuesta');
		for (var i = 0; i < respuestas.length ; i++) {
			if($(respuestas[i]).find('input[name="opcion[]"]').length){
				opcion = $(respuestas[i]).find('input[name="opcion[]"]').val();
			}

			if($(respuestas[i]).find('input[name="orden[]"]').length){
				orden = $(respuestas[i]).find('input[name="orden[]"]').val();
			}

			var input_opcion = $('<input></input>');
	        var input_orden = $('<input></input>');
	        input_orden.attr('name', 'respuestas_orden[]');
	        input_orden.attr('value', orden);
	        input_orden.css('background-color', 'red');
	        input_opcion.attr('name', 'respuestas_opcion[]');
	        input_opcion.attr('value', opcion);
	        contenedor_resp.append(input_orden);
	        contenedor_resp.append(input_opcion);
		}
	}

	$('input[name="orden[]"]').on('change', function(){
		// validarUnicoChange(this);
		emptyField(this);
		validarCaracteresPermitidos('numero', $(this));
		crearInputRespuestasSeleccion();
	});

	function validarUnicoChange(obj){
		// console.log($(obj).val());
		var valor_change = $(obj).val();
		var inputs = $('input[name="orden[]"]');
		var found = 0;
		for (var i = inputs.length - 1; i >= 0; i--) {
			if(inputs[i] != obj){
				if($(inputs[i]).val() == $(obj).val()){
					found = inputs[i];
					crearMensajeError($(obj), "Valor repetido, por favor revise y vuelva a ingresar un número");
					// console.log($(obj).val());
					break;
					// for (var j = inputs.length - 1; j >= 0; j--) {
					// 	if(inputs[j] != obj){
					// 		if($(inputs[j]).val() == $(obj).val()){
					// 			crearMensajeError(obj, "Valor repetido, por favor revise y vuelva a ingresar un número");
					// 		}
					// 	}
					// }
				}
				else{
					console.log("eder"+found);
					eliminarMensajeError(obj, "");
					eliminarMensajeError(found, "");
				}
			}
		}
	}

	function validarUnico(){
		var inputs = $('input[name="orden[]"]');
		var count = 0;
		for (var i = inputs.length - 1; i >= 0; i--) {
			for (var j = inputs.length - 1; j >= 0; j--) {
				if(inputs[j] != inputs[i] && inputs[j] != ""){
					if($(inputs[j]).val() == $(inputs[i]).val()){
						mostrarerror("Por favor, verifique que no existan valores repetidos.");
						count++;
						break;
					}
				}
			}
		}
		return count;
	}

	if($('#forma_2').length){
		$('#forma_2').on('submit', function(event){
			var input_opcion = $('input[name="orden[]"]');
			ValidarCamposVacios(input_opcion);
			for (var i = input_opcion.length - 1; i >= 0; i--) {
				validarCaracteresPermitidos('numero', $(input_opcion[i]));
			}
			if(errorCountMessage() > 0 || validarUnico() >= 1){
				event.preventDefault();
			}
			// event.preventDefault();
		});
	}

	// $('.label_double_opcion').dblclick(function(){
	// 	alert();
	// });

	$('.text_origen').on('dblclick', function(){
		var destino = $('.text_destino');
		var input = $(this).find('input[name="opcion_double[]"]');
		for (var i = 0; i < destino.length; i++) {
			var ubicar = $(destino[i]).find('label[class="label_double_opcion"]');
				if(ubicar.length <= 0){
					var div = $('<div></div>');
					div.attr('class', 'div_destino');	
					$(destino[i])[0].innerHTML = 
						"<i class='fa fa-times delete_icon' onclick='eliminar_nodo(this)'></i>"+$(this).html();
					break;
				}		
		}
		$(this)[0].innerHTML = "";
		crearInputRespuestasDobleClick();
	});


	function eliminar_nodo(obj){
		var padre = $(obj).parent();
		var label_test = padre.find('label').text();
		var input_value = padre.find('input[name="opcion_double[]"]').val();
		var origen = $('.text_origen');
		var destino = $('.text_destino');
		for (var i = 0; i < origen.length; i++) {
			var ubicar = $(origen[i]).find('label[class="label_double_opcion"]');
				if(ubicar.length <= 0){
					$(origen[i]).html("<label class='label_double_opcion'>"+label_test+"</label><input type='hidden' name='opcion_double[]' value='"+input_value+"'>");
					break;
				}
		}
		for (var i = 0; i < destino.length; i++) {
			console.log("eder");
			console.log($(obj).parent()[0]);
			// if($(obj).parent()[0].length){
				$(obj).parent()[0].innerHTML = "";
			// }
			crearInputRespuestasDobleClick();
		}
	}


	function crearInputRespuestasDobleClick(){
		var contenedor_resp = $('#contenedor_resp');
		contenedor_resp.html("");
		var opcion;
		var orden;
		var respuestas = $('.respuesta');
		for (var i = 0; i < respuestas.length ; i++) {
			opcion = 0;
			orden = 0;
			if($(respuestas[i]).find('input[name="opcion_double[]"]').length){
				opcion = $(respuestas[i]).find('input[name="opcion_double[]"]').val();
				console.log(opcion);
			}

			if($(respuestas[i]).find('input[name="orden_double[]"]').length){
				orden = $(respuestas[i]).find('input[name="orden_double[]"]').val();
			}

			var input_opcion = $('<input></input>');
	        var input_orden = $('<input></input>');
	        input_orden.attr('name', 'respuestas_orden[]');
	        input_orden.attr('value', orden);
	        input_orden.css('background-color', 'red');
	        input_opcion.attr('name', 'respuestas_opcion[]');
	        input_opcion.attr('value', opcion);
	        contenedor_resp.append(input_orden);
	        contenedor_resp.append(input_opcion);
	        contenedor_resp.append("<br>");
		}
	}

	if($('#forma_1').length){
		$('#forma_1').on('submit', function(event){
			if(!validarllenado()){
				event.preventDefault();
				mostrarerror();
			}
		})
	};

	function validarllenado(){
		var respuestas = $('.respuesta').find(('input[name="opcion_double[]"]'));
		if(respuestas.length >= 5){
			for (var i =  0; i < respuestas.length; i++) {
				if($(respuestas[i]).val() != 0){
					return true;
				}
			}
			return false;
		}
	}

// CASILLAS
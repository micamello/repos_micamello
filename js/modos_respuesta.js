$(window).on('load',function(){
	if ($('#faceta').val() <= 3){
    $('#msg_inforcuestionario').modal('show');
  }
});

// DOBLE CLICK
// if($('.contenedor_p').length){
// 	var isTouched = false;
// 	$('.contenedor_p').find('.text_origen').dblclick( function(){
// 		var destino = $(this).parents('.contenedor_p').find('.text_destino');
// 		var contenido_val = $(this).text();
// 		if(contenido_val != ""){
// 			for (var i = 0; i < destino.length; i++) {
// 				if(!$(destino[i]).find('input[name="opcion[]"]').length){
// 					var contenido_origen = $(this).html();
// 					$(destino[i]).append(contenido_origen);
// 					var icon = $('<i></i>');
// 					icon.attr('class', 'fa fa-times delete_icon');
// 					icon.attr('onclick', 'eliminarOpcion(this)');
// 					$(destino[i]).append(icon);
// 					$(this).html('');
// 					if((i+2) == destino.length){
// 						var ultimo_elemento = $(this).parents('.contenedor_p').find('.text_origen');
// 						for (var j = 0; j < ultimo_elemento.length; j++) {
// 							if($(ultimo_elemento[j]).find('input').length){
// 								var contenido = $(ultimo_elemento[j]).html();
// 								$(destino[i+1]).append(contenido);
// 								var icon = $('<i></i>');
// 								icon.attr('class', 'fa fa-times delete_icon');
// 								icon.attr('onclick', 'eliminarOpcion(this)');
// 								$(destino[i+1]).append(icon);
// 								$(ultimo_elemento[j]).html('');
// 							}
// 						}
// 					}
// 					break;
// 				}
// 			}
// 		}
// 		crearArrayInputs();
// 	});

	// $('.contenedor_p').find('.text_origen').on('doubletap', function(event){
	// 	event.preventDefault();
	// 	event.stopPropagation(); 
	// 	var destino = $(this).parents('.contenedor_p').find('.text_destino');
	// 	var contenido_val = $(this).text();
	// 	if(contenido_val != ""){
	// 		for (var i = 0; i < destino.length; i++) {
	// 			if(!$(destino[i]).find('input[name="opcion[]"]').length){
	// 				var contenido_origen = $(this).html();
	// 				$(destino[i]).append(contenido_origen);
	// 				var icon = $('<i></i>');
	// 				icon.attr('class', 'fa fa-times delete_icon');
	// 				icon.attr('onclick', 'eliminarOpcion(this)');
	// 				$(destino[i]).append(icon);
	// 				$(this).html('');
	// 				if((i+2) == destino.length){
	// 					var ultimo_elemento = $(this).parents('.contenedor_p').find('.text_origen');
	// 					for (var j = 0; j < ultimo_elemento.length; j++) {
	// 						if($(ultimo_elemento[j]).find('input').length){
	// 							var contenido = $(ultimo_elemento[j]).html();
	// 							$(destino[i+1]).append(contenido);
	// 							var icon = $('<i></i>');
	// 							icon.attr('class', 'fa fa-times delete_icon');
	// 							icon.attr('onclick', 'eliminarOpcion(this)');
	// 							$(destino[i+1]).append(icon);
	// 							$(ultimo_elemento[j]).html('');
	// 						}
	// 					}
	// 				}
	// 				break;
	// 			}
	// 		}
	// 	}
	// 	crearArrayInputs();
	// });

// }

// DOBLE CLICK

// if($('.contenedor_p').length){
// 	var isTouched = false;
// 	$('.contenedor_p').find('.text_origen').dblclick( function(){
		
// 		var destino = $(this).parents('.contenedor_p').find('.text_destino');
// 		var contenido_val = $(this).text();
// 		if(contenido_val != ""){
// 			for (var i = 0; i < destino.length; i++) {
// 				if(!$(destino[i]).find('input[name="opcion[]"]').length){
// 					var contenido_origen = $(this).html();
// 					$(destino[i]).append(contenido_origen);
// 					var icon = $('<i></i>');
// 					icon.attr('class', 'fa fa-times delete_icon');
// 					icon.attr('onclick', 'eliminarOpcion(this)');
// 					$(destino[i]).append(icon);
// 					$(this).html('');
// 					if((i+2) == destino.length){
// 						var ultimo_elemento = $(this).parents('.contenedor_p').find('.text_origen');
// 						for (var j = 0; j < ultimo_elemento.length; j++) {
// 							if($(ultimo_elemento[j]).find('input').length){
// 								var contenido = $(ultimo_elemento[j]).html();
// 								$(destino[i+1]).append(contenido);
// 								var icon = $('<i></i>');
// 								icon.attr('class', 'fa fa-times delete_icon');
// 								icon.attr('onclick', 'eliminarOpcion(this)');
// 								$(destino[i+1]).append(icon);
// 								$(ultimo_elemento[j]).html('');
// 							}
// 						}
// 					}
// 					break;
// 				}
// 			}
// 		}
// 		crearArrayInputs();
// 	});

	// $('.contenedor_p').find('.text_origen').on('doubletap', function(event){
	// 	event.preventDefault();
	// 	event.stopPropagation(); 
	// 	var destino = $(this).parents('.contenedor_p').find('.text_destino');
	// 	var contenido_val = $(this).text();
	// 	if(contenido_val != ""){
	// 		for (var i = 0; i < destino.length; i++) {
	// 			if(!$(destino[i]).find('input[name="opcion[]"]').length){
	// 				var contenido_origen = $(this).html();
	// 				$(destino[i]).append(contenido_origen);
	// 				var icon = $('<i></i>');
	// 				icon.attr('class', 'fa fa-times delete_icon');
	// 				icon.attr('onclick', 'eliminarOpcion(this)');
	// 				$(destino[i]).append(icon);
	// 				$(this).html('');
	// 				if((i+2) == destino.length){
	// 					var ultimo_elemento = $(this).parents('.contenedor_p').find('.text_origen');
	// 					for (var j = 0; j < ultimo_elemento.length; j++) {
	// 						if($(ultimo_elemento[j]).find('input').length){
	// 							var contenido = $(ultimo_elemento[j]).html();
	// 							$(destino[i+1]).append(contenido);
	// 							var icon = $('<i></i>');
	// 							icon.attr('class', 'fa fa-times delete_icon');
	// 							icon.attr('onclick', 'eliminarOpcion(this)');
	// 							$(destino[i+1]).append(icon);
	// 							$(ultimo_elemento[j]).html('');
	// 						}
	// 					}
	// 				}
	// 				break;
	// 			}
	// 		}
	// 	}
	// 	crearArrayInputs();
	// });

// }

// DOBLE CLICK
if($('.contenedor_p').length){

	$('.contenedor_p').find('.text_origen').on('dblclick', function(){
		var destino = $(this).parents('.contenedor_p').find('.text_destino');
		var contenido_val = $(this).text();
		if(contenido_val != ""){
			for (var i = 0; i < destino.length; i++) {
				if(!$(destino[i]).find('input[name="opcion[]"]').length){
					var contenido_origen = $(this).html();
					$(destino[i]).append(contenido_origen);
					var icon = $('<i></i>');
					icon.attr('class', 'fa fa-times delete_icon');
					icon.attr('onclick', 'eliminarOpcion(this)');
					$(destino[i]).append(icon);
					$(this).html('');
					if((i+2) == destino.length){
						var ultimo_elemento = $(this).parents('.contenedor_p').find('.text_origen');
						for (var j = 0; j < ultimo_elemento.length; j++) {
							if($(ultimo_elemento[j]).find('input').length){
								var contenido = $(ultimo_elemento[j]).html();
								$(destino[i+1]).append(contenido);
								var icon = $('<i></i>');
								icon.attr('class', 'fa fa-times delete_icon');
								icon.attr('onclick', 'eliminarOpcion(this)');
								$(destino[i+1]).append(icon);
								$(ultimo_elemento[j]).html('');
							}
						}
					}
					break;
				}
			}
		}
		crearArrayInputs();
	});

	$('.contenedor_p').find('.text_origen').on('doubletap', function(event){
		// $("body").nodoubletapzoom();
		event.preventDefault();
		event.stopPropagation(); 
		var destino = $(this).parents('.contenedor_p').find('.text_destino');
		var contenido_val = $(this).text();
		if(contenido_val != ""){
			for (var i = 0; i < destino.length; i++) {
				if(!$(destino[i]).find('input[name="opcion[]"]').length){
					var contenido_origen = $(this).html();
					$(destino[i]).append(contenido_origen);
					var icon = $('<i></i>');
					icon.attr('class', 'fa fa-times delete_icon');
					icon.attr('onclick', 'eliminarOpcion(this)');
					$(destino[i]).append(icon);
					$(this).html('');
					if((i+2) == destino.length){
						var ultimo_elemento = $(this).parents('.contenedor_p').find('.text_origen');
						for (var j = 0; j < ultimo_elemento.length; j++) {
							if($(ultimo_elemento[j]).find('input').length){
								var contenido = $(ultimo_elemento[j]).html();
								$(destino[i+1]).append(contenido);
								var icon = $('<i></i>');
								icon.attr('class', 'fa fa-times delete_icon');
								icon.attr('onclick', 'eliminarOpcion(this)');
								$(destino[i+1]).append(icon);
								$(ultimo_elemento[j]).html('');
							}
						}
					}
					break;
				}
			}
		}
		crearArrayInputs();
	});

}

function preventZoom(e) {
  var t2 = e.timeStamp;
  var t1 = e.currentTarget.dataset.lastTouch || t2;
  var dt = t2 - t1;
  var fingers = e.touches.length;
  e.currentTarget.dataset.lastTouch = t2;

  if (!dt || dt > 500 || fingers > 1) return; // not double-tap

  e.preventDefault();
  e.target.click();
}

function eliminarOpcion(obj){
	var elementos_des = $(obj).parent('.text_destino');
	var elementos_ori = $(obj).parents('.contenedor_p').find('.text_origen');
		for (var j =  0; j < elementos_ori.length; j++) {
			if(!$(elementos_ori[j]).find('input[name="opcion[]"]').length){
				var label = $(elementos_des).find('label');
				var input_opcion = $(elementos_des).find('input[name="opcion[]"]');
				if($(elementos_ori[j])[0].id == ('nido_'+$(input_opcion).val())){
					$(elementos_ori[j]).append(label);
					$(elementos_ori[j]).append(input_opcion);
					break;
				}
			}
		}
	$(obj)[0].outerHTML = "";
	crearArrayInputs();
}

function crearArrayInputs(){
	var orden_array = [];
	var opcion_array = [];
	var contenedor_respuestas = $('#respuestas');
	contenedor_respuestas.html('');
	orden_array = [];
		opcion_array = [];
	var contenedor = $('.contenedor_p');
	for (var i =  0; i < contenedor.length; i++) {
		
		var contenedor_inputs = $(contenedor[i]).find('.text_destino');
		for (var j = 0; j < contenedor_inputs.length; j++) {
			if($(contenedor_inputs[j]).find('input[name="orden[]"]').length && $(contenedor_inputs[j]).find('input[name="opcion[]"]').length){
				var orden = $(contenedor_inputs[j]).find('input[name="orden[]"]');
				for (var k = 0; k < orden.length; k++) {
					var value_orden = $(orden[k]).val();
					orden_array.push(value_orden);
				}
			}

			if($(contenedor_inputs[j]).find('input[name="opcion[]"]').length && $(contenedor_inputs[j]).find('input[name="orden[]"]').length){
				var opciones = $(contenedor_inputs[j]).find('input[name="opcion[]"]');
				for (var k = 0; k < opciones.length; k++) {
					var value_opcion = $(opciones[k]).val();
					opcion_array.push(value_opcion);
				}
			}
		}
	}

	for (var i = 0; i < opcion_array.length; i++) {
		var input_orden = $('<input></input>');
		var input_opcion = $('<input></input>');
		input_orden.attr('name', 'array_orden[]');
		input_opcion.attr('name', 'array_opcion[]');
		input_orden.attr('value', orden_array[i]);
		input_opcion.attr('value', opcion_array[i]);
		$(contenedor_respuestas).append(input_orden);
		$(contenedor_respuestas).append(input_opcion);
		$(contenedor_respuestas).append("<br>");
	}
}

if($('#forma_1').length){
	$('#forma_1').on('submit', function(event){
		var preguntasError = "";
		var contenedores = $('.contenedor_p');
		var contador_errores = 0;
		// var preguntasError = $('<div></div>');
		for (var i = 0; i < contenedores.length; i++) {
			var orden = $(contenedores[i]).find('.text_destino').find('input[name="orden[]"]');
			var opciones = $(contenedores[i]).find('.text_destino').find('input[name="opcion[]"]');
			var div_error = $(contenedores[i]).parent().prev().prev();
			var panel = $(contenedores[i]).parents('.panel');
				if(orden.length != opciones.length){
					// console.log(div_error);
					// mostrarerror(div_error, "Por favor seleccione el orden correcto para cada opción");
					
					panel.removeClass('panel-default');
					panel.addClass('panel-danger');

					preguntasError += "- Ordene las opciones en la "+panel.find('.panel-heading').text()+"\n";
					contador_errores++;
					event.preventDefault();
				}
				else{
					panel.removeClass('panel-danger');
					panel.addClass('panel-default');
					ocultarError(div_error);
				}
		}
		if(contador_errores > 0){
			// Sobreescribiendo el mensaje del sweetalert
			preguntasError = "Ordene las preguntas de todos los apartados.";
			//console.log(contador_errores);
			preguntasError = "Ordene los enunciados de todos los apartados.";
			alertErrores(preguntasError);
		}
	})
}

function alertErrores(texto){
	Swal.fire({    
    html: texto,
    imageUrl: $('#puerto_host').val()+'/imagenes/wrong-04.png',
    imageWidth: 75,
    confirmButtonText: 'ACEPTAR',
    animation: true
  });	
}

// DOBLE CLICK



// ESCRIBIR ORDEN
if($('#forma_2').length){
	$('#forma_2').submit(function(event){
		validarArrayContenedor();
		validarValor();
		validarRepetidos();
		if(checkErrors() === false){
			event.preventDefault();
		}
	})
}


function validarArrayContenedor(){
	var condicion = true;
	var contenedores_p2 = $('.contenedor_p_2');
	// console.log(contenedores_p2.length);
	for (var i =  0; i < contenedores_p2.length; i++) {
		var flag = 0;
		var orden = $(contenedores_p2[i]).find('.orden_div');
		var opcion = $(contenedores_p2[i]).find('.opcion_div');
		var div_error = $(contenedores_p2[i]).parent().prev().find('.error_msg');
			if(orden.length == opcion.length){
				for (var j =  0; j < orden.length; j++) {
					var orden_input = $(orden[j]).find('input');
					if($(orden[j]).find('input').val() == "" || $(orden[j]).find('input').val() == null){
						flag = 1;
						condicion = false;
						break;
					}
				}
			}
		if(flag == 1){
			mostrarerror(div_error, "Por favor seleccione el orden correcto para cada opción");
		}
		else{
			ocultarError(div_error);
		}
	}
	return condicion;
}

$('.orden_div').find('input').change(function(event){
	var long_opciones = $(this).parents('.contenedor_p_2').find('.opcion_div').length;
	if($(this).val() != ""){
		if($.isNumeric($(this).val()) != false){
			if($(this).val() < 1 || $(this).val() > long_opciones){
				crearMensajeError($(this), "Dígitos de 1 a 5");
			}
			else{
				eliminarMensajeError($(this), "");
			}
		}
		else{
			crearMensajeError($(this), "Solo números");
		}
	}
	else{
		crearMensajeError($(this), "Rellene este campo");
	}
});

function validarValor(){
	var all_orden = $('.orden_div');
	for (var i = 0; i < all_orden.length; i++) {
		var input = $(all_orden[i]).find('input');
		var long_opciones = $(input).parents('.contenedor_p_2').find('.opcion_div').length;
		// console.log(long_opciones);
		if($(input).val() != ""){

			if($.isNumeric($(input).val()) != false){


				if($(input).val() < 1 || $(input).val() > long_opciones){
					// event.preventDefault();
					crearMensajeError($(input), "Dígitos de 1 a 5");
				}
				else{
					eliminarMensajeError($(input), "");
				}

			}
			else{
				crearMensajeError($(input), "Solo números");
			}
		}
		else{
			crearMensajeError($(input), "Rellene este campo");
		}

	}
}

function validarRepetidos(){
	
	var contenedor = $('.contenedor_p_2');
	for (var i = 0; i < contenedor.length; i++) {
		var error = 0;
		var div_error = $(contenedor[i]).parent().prev().find('.error_msg');
		var orden = $(contenedor[i]).find('.orden_div');
		for (var j = 0; j < orden.length; j++) {
			for(var k = 0; k < orden.length; k++){
				if($(orden[j]).find('input').val() != "")
				{
					if($(orden[j]).find('input')[0].id != $(orden[k]).find('input')[0].id){
						if($(orden[j]).find('input').val() == $(orden[k]).find('input').val()){
							mostrarerror(div_error, "eder");
							error = 1;
						}
						else{
							ocultarError(div_error, "");
						}
					}
				}
			}
			if(error == 1){
				mostrarerror(div_error, "Verifique que no hayan valores repetidos");
				break;
			}
		}
	}

}

// ESCRIBIR ORDEN
function checkErrors(){
	var alertas = $('.alert-danger').length;
	var div = $('.error_field').length;
	if(alertas == 0 && div == 0){
		return true;
	}
	else{
		return false;
	}
}

function mostrarerror(obj, mensaje_text){
	if (mensaje_text == ''){
		mensaje_text = 'Por favor arrastre todas las opciones del lado izquierdo en los cuadros que se muestran en el lado derecho de acuerdo a su prioridad.';
	}
	var mensaje = ('<div class="alert alert-danger text-center" role="alert"><h6><b>'+mensaje_text+'</b></h6></div>');
	$(obj).html(mensaje);
}

function ocultarError(obj){
	$(obj).html('');
}

function crearMensajeError(obj, mensaje){	
	if (obj.id == 'profesion'){
    $('#err_profesion').html(mensaje);
    $('#err_profesion').addClass('error_field');
	}
	else if (obj.id == 'ocupacion'){
    $('#err_ocupacion').html(mensaje);
    $('#err_ocupacion').addClass('error_field');
	}
	else{
		$(obj).siblings('div').html(mensaje);
	  $(obj).siblings('div').addClass('error_field');
	}	
}

function eliminarMensajeError(obj, mensaje){
  if (obj.id == 'profesion'){
    $('#err_profesion').html(mensaje);
    $('#err_profesion').removeClass('error_field');
	}
	else if (obj.id == 'ocupacion'){
    $('#err_ocupacion').html(mensaje);
    $('#err_ocupacion').removeClass('error_field');
	}
	else{
	  $(obj).siblings('div').html(mensaje);
	  $(obj).siblings('div').removeClass('error_field');
	}
}

if($('.drag_origen').length){
	$('.drag_origen').draggable({
		opacity: 0.60,
    	zIndex: 100,
    	revert: 'invalid',
	    stop: function(){
	        $(this).draggable('option','revert','invalid');
	    }
	});
}

if($('.contenedor_drag').length){
	$('.contenedor_drag').droppable({
            drop: function(event, ui) {
            	var droppable = $(this);
            	var draggable = ui.draggable;
            	makeDrop(droppable, draggable);
            }
        });

}

if($('.drop_destino').length){
	$('.drop_destino').droppable({
            drop: function(event, ui) {
            	var droppable = $(this);
            	var draggable = ui.draggable;
            	makeDrop(droppable, draggable);
            }
       });
}

function makeDrop(drop, drag){
	var padre_drop = $(drop).parents(':eq(2)').attr('class');
	var padre_drag = $(drag).parents(':eq(3)').attr('class');
	var padre_directo_drag = $(drag).parent();
	// console.log($(drag).parent()[0]);
	var content = $(drop).find('label');
	if(content.length == 0){
		if(padre_drop == padre_drag){
			drag.css({top: '0px', left: '0px'});
			drag.appendTo(drop);
			// padre_directo_drag.addClass('espacio');
			crearInputsArastre();
			// toastr.remove();
		}
		else{
			// toastr.remove();
			// toastr.options.positionClass = "toast-top-center";
			// toastr.warning('Ubique la opción en la pregunta correspondiente');
			drag.css({top: '0px', left: '0px'});
			Swal.fire({	      
	      html: 'Ubique la opción en la pregunta correspondiente',
	      imageUrl: $('#puerto_host').val()+'/imagenes/wrong-04.png',
	      imageWidth: 75,
	      confirmButtonText: 'ACEPTAR',
	      animation: true
	    });			
		}
	}
	else{
		drag.css({top: '0px', left: '0px'});
	}
}

// validar metodo arrastre
if($('#forma_2').length){
	$('#forma_2').on('submit', function(event){
		opinRightSide();
		if(validarErrores() > 0){
			event.preventDefault();
		}	
	})
}

function opinRightSide(){
	var card = $('.panel-body');
	// console.log(card.length);
	var destino_input;
	var destino;
	var contador_errores = 0;
	var textoError = "";
	var panel;
	for (var i = 0; i < card.length; i++) {
		panel = $(card[i]).parent();
		// panel = $(card[i]).parents().find('.panel');
		// var error = 0;
		// error = $(card[i]).prev().prev();
		destino = $(card[i]).find('.drop_destino');
		destino_input = $(card[i]).find('.drop_destino').find('input[name="opcion[]"]');
		if(destino.length != destino_input.length){
			// error.html('<div class="alert alert-danger" role="alert">Una o mas opciones de esta pregunta no estan ordenadas. (Ordenadas '+destino_input.length+' de '+destino.length+')</div>');
			contador_errores++;
			panel.removeClass('panel-default');
			panel.addClass('panel-danger');
			textoError += "- Ordene opciones de la "+$(card[i]).prev().text()+" (ordenadas "+destino_input.length+' de '+destino.length+")\n";
		}
		else{
			// error.html('');
			panel.removeClass('panel-danger');
			panel.addClass('panel-default');
		}
	}

	if(contador_errores > 0){
		alertErrores(textoError);	
	}
}

function crearInputsArastre(){
	var card = $('.panel-body');
	var orden = [];
	var opcion = [];
	var contenedor_respuestas = $('#respuestas');
	contenedor_respuestas.html('');
	var input_orden;
	for (var i = 0; i < card.length; i++) {
		var drop_destino = $(card[i]).find('.drop_destino');
		var input_opcion = drop_destino.find('input[name="opcion[]"]');
		if($(input_opcion).length > 0){
			for (var j = 0; j < input_opcion.length; j++) {
				if($(input_opcion[j]).length){
						input_orden = $(input_opcion[j]).parent().prev();
						opcion.push($(input_opcion[j]).val());
						orden.push($(input_orden).val());
				}
			}
		}
	}
	for (var i = 0; i < opcion.length; i++) {
		var input_orden = $('<input></input>');
		var input_opcion = $('<input></input>');
		input_orden.attr('name', 'array_orden[]');
		input_opcion.attr('name', 'array_opcion[]');
		input_orden.attr('value', orden[i]);
		input_opcion.attr('value', opcion[i]);
		$(contenedor_respuestas).append(input_orden);
		$(contenedor_respuestas).append(input_opcion);
		$(contenedor_respuestas).append("<br>");
	}
}

function validarErrores(){
	if($('.panel-danger').length){
		var alerts = $('.panel-danger');
		return alerts.length;
	}
}
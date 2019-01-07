// MENSAJES DE ERROR
var campo_vacio = "Rellene este campo";
var lista_vacia = "Seleccione un elemento de la lista";
var invalido_dni = "Cédula no válida";
var term_cond_mensaje = "Debe aceptar términos y condiciones";

if(document.getElementById('button_register')){
	var button_register = document.getElementById('button_register').id;
}

$(document).ready(function(){
	$("#button_register").addClass('disabled');
})

if(document.getElementById("#form_register")){
	document.querySelector("#form_register")
	.addEventListener( "invalid", function( event ) {
	    event.preventDefault();
	}, true );
}

if(document.getElementById('name_user')){
	var reg = "";
	var mensaje = "";
	
	if(document.getElementById('nombre_error')){
		var nombre_error = document.getElementById('nombre_error').id;
	}

	if(document.getElementById('group_nombre')){
		var group_nombre = document.getElementById('group_nombre').id;
	}

	$('#name_user').on('blur', function(){
		var nombres = document.getElementById('name_user');
		var tipo_usuario = document.getElementById("tipo_usuario").value;
		if(tipo_usuario == 1){
			reg = /^[a-z ÁÉÍÓÚáéíóúñÑ]+$/i;
		}else{
			reg = /^[a-z ÁÉÍÓÚáéíóúñÑ. 0-9 &]+$/i;
		}

		var contenido = nombres.value;
		if(contenido != ""){
			if(reg.test(contenido) != false){

				if(contenido.length <= 60){
					quitarError(nombre_error, group_nombre);
					enableBTN(1);
				}
				else{
					mensaje = "Longitud máxima del campo 60 caracteres";
					colocaError(nombre_error, group_nombre, mensaje, button_register);
				}
			}
			else{
				mensaje = "Ajustese al formato solicitado";
				colocaError(nombre_error, group_nombre, mensaje, button_register);
			}


				// if(reg.test(contenido) == false && contenido != ""){
				// 	// alert("eder");
				// 	mensaje = "Ajustese al formato solicitado";
				// 	colocaError(nombre_error, group_nombre, mensaje, button_register);
				// }
				// else{
					
				// }	
		}
		else{
			mensaje = "Rellene este campo";
			colocaError(nombre_error, group_nombre, mensaje, button_register);
		}
	});

	$('#name_user').on('keydown', function(event){
		tipo_usuario = document.getElementById("tipo_usuario").value;

		if(tipo_usuario == 1){
			validar_keycode(this, "nombre_apellido", nombre_error, group_nombre, event, button_register, 60);
		}
		else{
			validar_keycode(this, "nombre_empresa", nombre_error, group_nombre, event, button_register, 60);
		}
	});
}

if(document.getElementById('apell_user')){
	var mensaje = "";
	
	if(document.getElementById('apell_error')){
		var apell_error = document.getElementById('apell_error').id;
	}

	if(document.getElementById('apellido_group')){
		var apellido_group = document.getElementById('apellido_group').id;
	}

	$('#apell_user').on('blur', function(){
		reg = /^[a-z ÁÉÍÓÚáéíóúñÑ]+$/i;
		var apellidos = document.getElementById('apell_user');
		var contenido = apellidos.value;
		if(contenido != ""){
				if(reg.test(contenido) != false){
					if(contenido.length <= 60){
						quitarError(apell_error, apellido_group);
						enableBTN(1);
					}
					else{
						mensaje = "Longitud máxima del campo 60 caracteres";
						colocaError(apell_error, apellido_group, mensaje, button_register);
					}
				}
				else{
					mensaje = "Ajustese al formato solicitado";
					colocaError(apell_error, apellido_group, mensaje, button_register);
				}	
		}
		else{
			mensaje = "Rellene este campo";
			colocaError(apell_error, apellido_group, mensaje, button_register);
		}
	});

	$('#apell_user').on('keydown', function(event){
		tipo_usuario = document.getElementById("tipo_usuario").value;
		if(tipo_usuario == 1){
			validar_keycode(this, "nombre_apellido", apell_error, apellido_group, event, button_register, 60);
		}
	});
}

if(document.getElementById('correo')){
	if(document.getElementById('correo_error')){
			var correo_error = document.getElementById('correo_error').id;
		}

	if(document.getElementById('correo_group')){
		var correo_group = document.getElementById('correo_group').id;
	}

	$('#correo').on('blur', function(){
		var correo = document.getElementById('correo');
		var contenido = correo.value;
		if(contenido != ""){
			if(validateEmail(contenido) == false && contenido != ""){
				// ------------------------------------------------------------------------------------------
				mensaje = "Ingrese una dirección de correo válida";
				colocaError(correo_error, correo_group, mensaje, button_register);
			}
			else{
				if(existeCorreo(contenido) != 1){
					mensaje = "El correo ingresado ya existe";
					colocaError(correo_error, correo_group, mensaje, button_register);
				}
				else{
					quitarError(correo_error, correo_group);
					enableBTN(1);
				}
			}
		}
		else{
			mensaje = "Rellene este campo";
			colocaError(correo_error, correo_group, mensaje, button_register);
		}
	})
}

if(document.getElementById('numero_cand')){
	if(document.getElementById('numero_error')){
		var numero_error = document.getElementById('numero_error').id;
	}

	if(document.getElementById('numero_group')){
		var numero_group = document.getElementById('numero_group').id;
	}

	$('#numero_cand').on('blur', function(){
		validar_numero(this, 1, numero_error, numero_group);
	});

	$('#numero_cand').on('keydown', function(event){
		validar_keycode(this, "telefono", numero_error, numero_group, event, button_register, 15);
	})
}

if(document.getElementById('seleccione_group')){
	var seleccione_group = document.getElementById('seleccione_group').id;
}

if(document.getElementById('seleccione_error')){
	var seleccione_error = document.getElementById('seleccione_error').id;
}
if(document.getElementById('dni_group')){
	var dni_group = document.getElementById('dni_group').id;
}

if(document.getElementById('dni_error')){
	var dni_error = document.getElementById('dni_error').id;
}

if(document.getElementById('documentacion')){
	$("#documentacion").on("change", function(){
		quitarError(seleccione_error, seleccione_group);
		quitarError(dni_error, dni_group);
		enableBTN(1);
		var dni = document.getElementById('dni');
		dni.removeAttribute('disabled');
		dni.value = "";
	})
}

if(document.getElementById('dni')){
	var mensaje = "";
	$('#dni').on('blur', function(){
	var tipo_usuario = document.getElementById("tipo_usuario").value;
	var documentacion = $('#documentacion').val();
	var host = document.getElementById('iso').value;
	if($(this).val() != ""){
		if(tipo_usuario == 1){
			if(documentacion == 2){
				if (typeof window['validar_'+host] === 'function') {
				    if(window['validar_'+host](this, 2, dni_error, dni_group, button_register) != 1){
					    if(host == "EC"){
					    	if(((this.value.length))>10){
					    		mensaje = "DNI máximo 10 números";
								colocaError(dni_error, dni_group, mensaje, button_register);
					    	}
					    	else{
					    		if(existeDni(this.value) != 1){
									mensaje = "El numero de cédula o pasaporte o ruc ya existe";
									colocaError(dni_error, dni_group, mensaje, button_register);
								}
								else{
										quitarError(dni_error, dni_group);
										enableBTN(1);
									}
					    	}
					    }
					}
					// else{
					// 	quitarError(dni_error, dni_group);
					// 	enableBTN(1);
					// }
				}
			}
			else{
				if(existeDni(this.value) != 1){
					mensaje = "El numero de cédula o pasaporte o ruc ya existe";
					colocaError(dni_error, dni_group, mensaje, button_register);
				}
				else
				{
					quitarError(dni_error, dni_group);
					enableBTN(1);
				}
			}
		}
		else{
			if (typeof window['validar_'+host] === 'function') {
			    window['validar_'+host](this, 1, dni_error, dni_group, button_register);
			    if(host == "EC"){
			    	if(((this.value.length)) == 13){
			    		if(existeDni(this.value) == 1){
							quitarError(dni_error, dni_group);
							enableBTN(1);
						}
						else
						{
							mensaje = "El numero de cédula o pasaporte o ruc ya existe";
							colocaError(dni_error, dni_group, mensaje, button_register);
						}
			    	}
			    	else{
			    		mensaje = "Para ingresar el RUC son 13 números";
						colocaError(dni_error, dni_group, mensaje, button_register);
			    	}
			    }
			}
		}
	}		
	else{
		mensaje = "Rellene este campo";
		colocaError(dni_error, dni_group, mensaje, button_register);
	}
});

	$('#dni').on('keydown', function(event){
		var tipo_usuario = document.getElementById("tipo_usuario").value;
		var documentacion = $('#documentacion').val();
		var host = document.getElementById('iso').value;
		if(tipo_usuario == 1){
			if(documentacion == 2){
				if(host == "EC"){
					if(((this.value.length)+1)<=10){
						validar_keycode(this, "telefono", dni_error, dni_group, event, button_register, 10);
					}
					else{
						if (event.keyCode >= 65 && event.keyCode <= 90) {
							event.preventDefault();
							mensaje = "DNI no debe contener letras";
							colocaError(dni_error, dni_group, mensaje, button_register);
						}
						// else{
						// 	mensaje = "DNI máximo 10 números";
						// 	colocaError(dni_error, dni_group, mensaje, button_register);
						// }
					}
				}
			}
			else{
				validar_keycode(this, "pasaporte", dni_error, dni_group, event, button_register, 15);
			}
		}
		else{
			validar_keycode(this, "telefono", dni_error, dni_group, event, button_register, 15);
		}
	})
}

// function is_function(func) {
//     return typeof window[func] !== 'undefined' && $.isFunction(window[func]);
// }

if(document.getElementById('password_error_two')){
	var password_error_two = document.getElementById('password_error_two').id;
}

if(document.getElementById('password_group_two')){
	var password_group_two = document.getElementById('password_group_two').id;
}

if(document.getElementById('password_error')){
	var password_error = document.getElementById('password_error').id;
}

if(document.getElementById('password_group')){
	var password_group = document.getElementById('password_group').id;
}


if(document.getElementById('password')){
	var  pattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
	$('#password').on('blur', function(){
		var password = document.getElementById('password');
		var contenido = password.value;
		var password_two = document.getElementById('password_two');
		var contenido_pass = password_two.value;
		if(contenido != ""){
			if(pattern.test(contenido) == false && contenido != ""){
				mensaje = "Letras, números y 8 caracteres mínimo.";
				colocaError(password_error, password_group, mensaje, button_register);
			}
			else
			if(contenido_pass != "" && (passCoincide(contenido_pass, contenido)) == false){
				mensaje = "La contraseñas no coinciden";
				colocaError(password_error, password_group, mensaje, button_register);
				colocaError(password_error_two, password_group_two, mensaje, button_register);
			}
			else{
				quitarError(password_error, password_group);
				quitarError(password_error_two, password_group_two);
				enableBTN(1);
			}
		}
		else{
			mensaje = "Rellene este campo";
			colocaError(password_error, password_group, mensaje, button_register);
		}
	})
}

if(document.getElementById('password_two')){
	var  pattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
	$('#password_two').on('blur', function(){
		var password_two = document.getElementById('password_two');
		var contenido = password_two.value;
		var password_one = document.getElementById('password');
		var contenido_pass = password_one.value;
		if(contenido != ""){
			if(pattern.test(contenido) == false && contenido != ""){
				mensaje = "Letras, números y 8 caracteres mínimo.";
				colocaError(password_error_two, password_group_two, mensaje, button_register);
				
			}
			else
			if(contenido_pass != "" && (passCoincide(contenido_pass, contenido)) == false){
				mensaje = "La contraseñas no coinciden";
				colocaError(password_error_two, password_group_two, mensaje, button_register);
				colocaError(password_error, password_group, mensaje, button_register);
			}
			else{
				quitarError(password_error_two, password_group_two);
				quitarError(password_error, password_group);
				enableBTN(1);
			}
		}
		else{
			mensaje = "Rellene este campo";
			colocaError(password_error_two, password_group_two, mensaje, button_register);
		}
	})
}

if(document.getElementById('term_cond_error')){
	var term_cond_error = document.getElementById('term_cond_error').id;
}

if(document.getElementById('term_cond_group')){
	var term_cond_group = document.getElementById('term_cond_group').id;
}

if(document.getElementById('term_cond')){
	var term_cond = document.getElementById('term_cond');
	$('#term_cond').on('change', function(){
		var checked = 0;
		if(this.checked == false){
			var mensaje = "Debe aceptar términos y condiciones";
			colocaError(term_cond_error, term_cond_group, mensaje, button_register);
		}
		else{
			quitarError(term_cond_error, term_cond_group);
			enableBTN(1);
		}
	})
}

if(document.getElementById('area_group')){
	var area_group = document.getElementById('area_group').id;
}

if(document.getElementById('area_error')){
	var area_error = document.getElementById('area_error').id;
}

if(document.getElementById('nivel_group')){
	var nivel_group = document.getElementById('nivel_group').id;
}

if(document.getElementById('nivel_error')){
	var nivel_error = document.getElementById('nivel_error').id;
}



if(document.getElementById('area_select')){
	$('#area_select').on('change', function(){
		if(this.value == ""){
			mensaje = "Seleccione un elemento de la lista";
			colocaError(area_error, area_group, mensaje, button_register);
		}
		else{
			quitarError(area_error, area_group);
			enableBTN(1);
		}
	})
}

if(document.getElementById('nivel_interes')){
	$('#nivel_interes').on('change', function(){
		if(this.value == ""){
			mensaje = "Seleccione un elemento de la lista";
			colocaError(nivel_error, nivel_group, mensaje, button_register);
		}
		else{
			quitarError(nivel_error, nivel_group);
			enableBTN(1);
		}
	})
}


// Datos del contacto modal empresa

if(document.getElementById('nombre_contact_group')){
	var nombre_contact_group = document.getElementById('nombre_contact_group').id;
}

if(document.getElementById('nombre_contact_error')){
	var nombre_contact_error = document.getElementById('nombre_contact_error').id;
}

if(document.getElementById('apellido_contact_group')){
	var apellido_contact_group = document.getElementById('apellido_contact_group').id;
}

if(document.getElementById('apellido_contact_error')){
	var apellido_contact_error = document.getElementById('apellido_contact_error').id;
}

if(document.getElementById('tel_one_contact_group')){
	var tel_one_contact_group = document.getElementById('tel_one_contact_group').id;
}

if(document.getElementById('tel_one_contact_error')){
	var tel_one_contact_error = document.getElementById('tel_one_contact_error').id;
}


$('#form_register').on('submit', function(event){
	if(enableBTN(2) === false){
		event.preventDefault();
	}
});

// Validación campo contacto empresa
if(document.getElementById('nombre_contact')){
	var reg = "";
	var mensaje = "";

	$('#nombre_contact').on('blur', function(){
		var nombres = document.getElementById('nombre_contact');
		
		reg = /^[a-z ÁÉÍÓÚáéíóú]+$/i;

		var contenido = nombres.value;
		if(contenido != ""){
				if(reg.test(contenido) == false && contenido != ""){
					// alert("eder");
					mensaje = "Ajustese al formato solicitado";
					colocaError(nombre_contact_error, nombre_contact_group, mensaje, button_register);
				}
				else{
					quitarError(nombre_contact_error, nombre_contact_group);
					enableBTN(1);
				}	
		}
		else{
			mensaje = "Rellene este campo";
			colocaError(nombre_contact_error, nombre_contact_group, mensaje, button_register);
		}
	});

	$('#nombre_contact').on('keydown', function(event){	
		validar_keycode(this, "nombre_apellido", nombre_contact_error, nombre_contact_group, event, button_register, 60);
	});
}

if(document.getElementById('apellido_contact')){
	var reg = "";
	var mensaje = "";

	$('#apellido_contact').on('blur', function(){
		var apellidos = document.getElementById('apellido_contact');
		
		reg = /^[a-z ÁÉÍÓÚáéíóú]+$/i;

		var contenido = apellidos.value;
		if(contenido != ""){
				if(reg.test(contenido) == false && contenido != ""){
					// alert("eder");
					mensaje = "Ajustese al formato solicitado";
					colocaError(apellido_contact_error, apellido_contact_group, mensaje, button_register);
				}
				else{
					quitarError(apellido_contact_error, apellido_contact_group);
					enableBTN(1);
				}	
		}
		else{
			mensaje = "Rellene este campo";
			colocaError(apellido_contact_error, apellido_contact_group, mensaje, button_register);
		}
	});

	$('#apellido_contact').on('keydown', function(event){	
	  	validar_keycode(this, "nombre_apellido", apellido_contact_error, apellido_contact_group, event, button_register, 60);
	});
}

if(document.getElementById('tel_one_contact')){
	// Requerido == 1 y no == 0
	$('#tel_one_contact').on('blur', function(){
		var error_mensaje = document.getElementById('tel_one_contact_error').id;
		var error_group = document.getElementById('tel_one_contact_group').id;
		validar_numero(this, 1, error_mensaje, error_group);
	});

	$('#tel_one_contact').on('keydown', function(event){
		var error_mensaje = document.getElementById('tel_one_contact_error').id;
		var error_group = document.getElementById('tel_one_contact_group').id;

		validar_keycode(this, "telefono", error_mensaje, error_group, event, button_register, 15);
	});
}


if(document.getElementById('tel_two_contact')){
	// Requerido == 1 y no == 0
	$('#tel_two_contact').on('blur', function(){
		var error_mensaje = document.getElementById('tel_two_contact_error').id;
		var error_group = document.getElementById('tel_two_contact_group').id;
		validar_numero(this, 0, error_mensaje, error_group);
	});

	$('#tel_two_contact').on('keydown', function(event){
		var error_mensaje = document.getElementById('tel_two_contact_error').id;
		var error_group = document.getElementById('tel_two_contact_group').id;
		// *telefono
		// *nombre_apellido
		// *nombre_empresa_pasaporte
		validar_keycode(this, "telefono", error_mensaje, error_group, event, button_register, 15);
	});
}

// --------------------------------------------------------------------------------------------------------------------

// if (document.getElementById("area_select"))
// {
//   $("#area_select").selectr({
//       placeholder: 'Buscar...'
//   });
// }

// if (document.getElementById("nivel_interes"))
// {
//   $("#nivel_interes").selectr({
//       placeholder: 'Buscar...'
//   });
// }

        $(document).ready(function() {
          $('#area_select').multiselect({
            buttonContainer: '<div id="example-checkbox-list-container"></div>',
            buttonClass: '',
            templates: {
                button: '',
                ul: '<ul class="multiselect-container checkbox-list scroll"></ul>',
            },
            maxHeight: 84,
            	enableFiltering: true,
            	enableCaseInsensitiveFiltering: true,
            	buttonWidth: '50%',
            	buttonText: function(options, select) {
                if (options.length === 0) { 
                	//$('#seleccionados').html('Seleccione una area ...');
                	$('#seleccionados1').html('');
                  return 'Seleccione una area ...';
                }
                else if (options.length > 3) {                	
                    return 'Solo se permiten 3 areas';
                }
                else {
                  var labels = [];  
                  $('#seleccionados1').html('');                
                  options.each(function() {
                    if ($(this).attr('label') !== undefined) {
                      labels.push($(this).attr('label'));                             
                      $('#seleccionados1').html($('#seleccionados1').html()+' '+'<a href="javascript:void(0);" onclick="deseleccionar('+$(this).val()+', area_select);"><i class="fa fa-times-circle fa fa-2x"></i></a>');
                      // $('#'+this.parentNode.id).parents(':eq(1)').find('.panel-head-select').children().children().html(options.length);
                      // console.log(this);
                    }
                    else {
                      labels.push($(this).html());                             
                      $('#seleccionados1').html($('#seleccionados1').html()+'<p class="selectedItems">'+$(this).html()+' '+'<a href="javascript:void(0);" onclick="deseleccionar('+$(this).val()+', area_select);"><i class="fa fa-times-circle fa fa-2x"></i></a></p>');
                        // $(this).parents(':eq(1)').find('.panel-head-select').children().children().html(options.length);
                        // console.log($(this).parents(':eq(1)').find('.panel-head-select'));
                        $('#'+this.parentNode.id).parents(':eq(1)').find('.panel-head-select').children().children().html(options.length);
                    }
                  });                          
                  return labels.join(', ') + '';
                }
              },
              onChange: function(option, checked) {
                var selectedOptions = $('#area_select option:selected');
                // console.log(selectedOptions);
 
                if (selectedOptions.length >= 3) {
                    var nonSelectedOptions = $('#area_select option').filter(function() {
                        return !$(this).is(':selected');
                    }); 
                    nonSelectedOptions.each(function() {
                        var input = $('input[id="area_select-' + $(this).val() + '"]');
                        // console.log(input[0].nextSibling.data);
                        // console.log($('input[id="area_select-' + $(this).val() + '"]')[0]);
                        input.prop('disabled', true);
                        input.parent('li').addClass('disabled');
                        // $('#'+this.parentNode.id).parents(':eq(1)').find('.panel-head-select').children().children().html(selectedOptions.length);
                    });
                }
                else {
                    $('#area_select option').each(function() {
                        // console.log(this);
                        console.log(selectedOptions.length);
                        var input = $('input[id="area_select-' + $(this).val() + '"]');
                        input.prop('disabled', false);
                        input.parent('li').addClass('disabled');
                        $('#'+this.parentNode.id).parents(':eq(1)').find('.panel-head-select').children().children().html(selectedOptions.length);
                    });
                }
              }        
            });
            $('#seleccionados1').parent().append(filtro[0]);

            
        $('#nivel_interes').multiselect({
            buttonContainer: '<div id="example-checkbox-list-container"></div>',
            buttonClass: '',
            templates: {
                button: '',
                ul: '<ul class="multiselect-container checkbox-list scroll"></ul>',
            },
            maxHeight: 84,
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                buttonWidth: '50%',
                buttonText: function(options, select) {
                if (options.length === 0) { 
                    //$('#seleccionados').html('Seleccione una area ...');
                    $('#seleccionados2').html('');
                  return 'Seleccione una area ...';
                }
                else if (options.length > 2) {                  
                    return 'Solo se permiten 1 areas';
                }
                else {
                  var labels = [];  
                  $('#seleccionados2').html('');                
                  options.each(function() {
                    if ($(this).attr('label') !== undefined) {
                      labels.push($(this).attr('label'));                             
                      $('#seleccionados2').html($('#seleccionados2').html()+' '+'<a href="javascript:void(0);" onclick="deseleccionar('+$(this).val()+', nivel_interes);"><i class="fa fa-times-circle fa-2x"></i></a>');
                      $('#'+this.parentNode.id).parents(':eq(1)').find('.panel-head-select').children().children().html(options.length);
                    }
                    else {
                      labels.push($(this).html());                             
                      $('#seleccionados2').html($('#seleccionados2').html()+'<p class="selectedItems">'+$(this).html()+' '+'<a href="javascript:void(0);" onclick="deseleccionar('+$(this).val()+', nivel_interes);"><i class="fa fa-times-circle fa-2x"></i></a></p>');
                    // console.log(this.parentNode.id);
                    $('#'+this.parentNode.id).parents(':eq(1)').find('.panel-head-select').children().children().html(options.length);
                    // console.log($('#'+this.parentNode.id).parents(':eq(1)').find('.panel-head-select').children().children());
                    }
                  });                                    
                  return labels.join(', ') + '';
                }
              },
              onChange: function(option, checked) {
                var selectedOptions = $('#nivel_interes option:selected');
 
                if (selectedOptions.length >= 2) {
                    var nonSelectedOptions = $('#nivel_interes option').filter(function() {
                        return !$(this).is(':selected');
                    }); 
                    nonSelectedOptions.each(function() {
                        var input = $('input[id="nivel_interes-' + $(this).val() + '"]');
                        // console.log(input[0].nextSibling.data);
                        // console.log($('input[id="nivel_interes-' + $(this).val() + '"]')[0]);
                        input.prop('disabled', true);
                        input.parent('li').addClass('disabled');
                        // console.log(input.parent('li'));
                    });
                }
                else {
                    $('#nivel_interes option').each(function() {
                        // console.log(this);
                        var input = $('input[id="nivel_interes-' + $(this).val() + '"]');
                        input.prop('disabled', false);
                        input.parent('li').addClass('disabled');
                        // console.log(input.parent('li'));
                        // console.log("eder:  "+selectedOptions.length);
                        // console.log($(this).parents(':eq(1)').find('.panel-head-select'));
                        $('#'+this.parentNode.id).parents(':eq(1)').find('.panel-head-select').children().children().html(selectedOptions.length);
                    });
                }
              }        
            });
            $('#seleccionados2').parent().append(filtro[1]);
        });


// ----------------------------------------------------------------------------------------------------------------------------------------

function validar_numero(obj, requerido, error_mensaje, error_group){
	// Pattern de validación
	var pattern = /^[0-9]{9,15}$/;
	var input = obj;
	var contenido = input.value;
	if(contenido != ""){
		if(pattern.test(contenido) == false && contenido != ""){
			mensaje = "Mín 9 dígitos, max 15 dígitos.";
			colocaError(error_mensaje, error_group, mensaje, button_register);
		}
		else{
			quitarError(error_mensaje, error_group);
			enableBTN(1);
		}
	}
	else{
		if(requerido == 1){
			mensaje = "Rellene este campo";
			colocaError(error_mensaje, error_group, mensaje, button_register);
		}
		else{
			quitarError(error_mensaje, error_group);
			enableBTN(1);
		}
	}
}

function enableBTN(tipo){
	if(validateForm(tipo) == 0 && verifyErrors() == 0){
		var btn = document.getElementById('button_register');
		btn.classList.remove("disabled");
		return true;
	}
	return false;
}


function validateEmail(correo) {
  // var pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  var pattern = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/;
  return pattern.test(correo);
}

function passCoincide(pass_one, pass_two){
	if(pass_one == pass_two){
		return true;
	}
	else{
		return false;
	}
}

function validateForm(tipo){
	// console.log(tipo);
	var tipo_usuario = document.getElementById('tipo_usuario').value;
	var errors = 0;
	if(document.getElementById('name_user').value == ""){
		if(tipo==2){colocaError(nombre_error, group_nombre, campo_vacio, button_register);}
		errors++;
	}

	if(document.getElementById('correo').value == ""){
		if(tipo==2){colocaError(correo_error, correo_group, campo_vacio, button_register);}
		errors++;
	}

	if(document.getElementById('numero_cand').value == ""){
		if(tipo==2){colocaError(numero_error, numero_group, campo_vacio, button_register);}
		errors++;
	}

	if(document.getElementById('password').value == ""){
		if(tipo==2){colocaError(password_error, password_group, campo_vacio, button_register);}
		errors++;
	}

	if(document.getElementById('password_two').value == ""){
		if(tipo==2){colocaError(password_error_two, password_group_two, campo_vacio, button_register);}
		errors++;
	}

	if(document.getElementById('dni').value == ""){
		if(tipo==2){colocaError(dni_error, dni_group, campo_vacio, button_register);}
		errors++;
	}

	if(document.getElementById('term_cond').checked){
	}
	else{
		if(tipo==2){colocaError(term_cond_error, term_cond_group, term_cond_mensaje, button_register);}
		errors++;
	}
// ----------------------------------------------Tipo de usuario 1 (candidato) exclusivo--------------------------------------
	if(tipo_usuario == 1){
		if(document.getElementById('apell_user').value == ""){
			if(tipo==2){colocaError(apell_error, apellido_group, campo_vacio, button_register);}
			errors++;
		}

		if(document.getElementById('documentacion').value == ""){
			if(tipo==2){colocaError(seleccione_error, seleccione_group, lista_vacia, button_register);}
			errors++;
		}
		if(document.getElementById('area_select').value == ""){
			if(tipo==2){colocaError(area_error, area_group, lista_vacia, button_register);}
			errors++;
		}

		if(document.getElementById('nivel_interes').value == ""){
			if(tipo==2){colocaError(nivel_error, nivel_group, lista_vacia, button_register);}
			errors++;
		}
	}
// ----------------------------------------------Tipo de usuario 1 (candidato) exclusivo--------------------------------------

// ----------------------------------------------Tipo de usuario 2 (candidato) exclusivo--------------------------------------
	if(tipo_usuario == 2){
		mensaje = "Rellene este campo";
		if(document.getElementById('nombre_contact').value == ""){
			if(tipo==2){colocaError(nombre_contact_error, nombre_contact_group, mensaje, button_register);}
			errors++;
		}

		if(document.getElementById('apellido_contact').value == ""){
			if(tipo==2){colocaError(apellido_contact_error, apellido_contact_group, mensaje, button_register);}
			errors++;
		}

		if(document.getElementById('tel_one_contact').value == ""){
			if(tipo==2){colocaError(tel_one_contact_error, tel_one_contact_group, mensaje, button_register);}
			errors++;
		}
	}
	// console.log(errors);
// ----------------------------------------------Tipo de usuario 2 (candidato) exclusivo--------------------------------------
	return errors;
}


function validar_EC(dni_obj,tipo,campoErr,campoSeccion,btn){
	var validacion = validarDocumento(dni_obj.value, tipo,campoErr,campoSeccion,btn);
	return validacion;
}

function existeCorreo(correo){
	var value = "";
	var puerto_host = $('#puerto_host').val();
	if (correo != "") {
		$.ajax({
            type: "GET",
            url: puerto_host+"?opcion=buscaCorreo&correo="+correo,
    		dataType: 'json',
    		async: false,
            success:function(data){
				value = data.respcorreo;
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }                  
        })
	}
	return value;
}

function existeDni(dni){
	var value = "";
	var puerto_host = $('#puerto_host').val();
	if (dni != "") {
		$.ajax({
            type: "GET",
            url: puerto_host+"?opcion=buscaDni&dni="+dni,
    		dataType: 'json',
    		async: false,
            success:function(data){
            	value = data.respdni;
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }                  
        })
	}
	return value;
}

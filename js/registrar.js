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

document.querySelector( "form" )
.addEventListener( "invalid", function( event ) {
    event.preventDefault();
}, true );



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
			reg = /^[a-zÁÉÍÓÚáéíóúñÑ. 0-9]+$/i;
		}

		var contenido = nombres.value;
		if(contenido != ""){
			if(reg.test(contenido) != false){
				if(contenido.length <= 60){
					quitarError(nombre_error, group_nombre);
					enableBTN();
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
			validar_keycode(this, "nombre_apellido", nombre_error, group_nombre, event);
		}
		else{
			validar_keycode(this, "nombre_empresa", nombre_error, group_nombre, event);
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
						enableBTN();
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
			validar_keycode(this, "nombre_apellido", apell_error, apellido_group, event);
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
					enableBTN();
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
		validar_keycode(this, "telefono", numero_error, numero_group, event);
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
		enableBTN();
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
				    if(window['validar_'+host](this) != false){
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
										enableBTN();
									}
					    	}
					    }
					}
					// else{
					// 	quitarError(dni_error, dni_group);
					// 	enableBTN();
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
					enableBTN();
				}
			}
		}
		else{
			if (typeof window['validar_'+host] === 'function') {
			    window['validar_'+host](this);
			    if(host == "EC"){
			    	if(((this.value.length)) < 13){
			    		mensaje = "Para ingresar el RUC son 13 números";
						colocaError(dni_error, dni_group, mensaje, button_register);
			    	}
			    	else{
			    		enableBTN();
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
						validar_keycode(this, "telefono", dni_error, dni_group, event);
					}
					else{
						if (event.keyCode >= 65 && event.keyCode <= 90) {
							event.preventDefault();
							mensaje = "DNI no debe contener letras";
							colocaError(dni_error, dni_group, mensaje, button_register);
						}
						else{
							mensaje = "DNI máximo 10 números";
							colocaError(dni_error, dni_group, mensaje, button_register);
						}
					}
				}
			}
			else{
				validar_keycode(this, "pasaporte", dni_error, dni_group, event);
			}
		}
		else{
			validar_keycode(this, "telefono", dni_error, dni_group, event);
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
				enableBTN();
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
				enableBTN();
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
			enableBTN();
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
			enableBTN();
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
			enableBTN();
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
	if(enableBTN() === false){
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
					enableBTN();
				}	
		}
		else{
			mensaje = "Rellene este campo";
			colocaError(nombre_contact_error, nombre_contact_group, mensaje, button_register);
		}
	});

	$('#nombre_contact').on('keydown', function(event){	
		validar_keycode(this, "nombre_apellido", nombre_contact_error, nombre_contact_group, event);
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
					enableBTN();
				}	
		}
		else{
			mensaje = "Rellene este campo";
			colocaError(apellido_contact_error, apellido_contact_group, mensaje, button_register);
		}
	});

	$('#apellido_contact').on('keydown', function(event){	
	  	validar_keycode(this, "nombre_apellido", apellido_contact_error, apellido_contact_group, event);
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

		validar_keycode(this, "telefono", error_mensaje, error_group, event);
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
		validar_keycode(this, "telefono", error_mensaje, error_group, event);
	});
}

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
			enableBTN();
		}
	}
	else{
		if(requerido == 1){
			mensaje = "Rellene este campo";
			colocaError(error_mensaje, error_group, mensaje, button_register);
		}
		else{
			quitarError(error_mensaje, error_group);
			enableBTN();
		}
	}
}

function enableBTN(){
	if(validateForm() == 0 && verifyErrors() == 0){
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

function validateForm(){
	var tipo_usuario = document.getElementById('tipo_usuario').value;
	var errors = 0;
	if(document.getElementById('name_user').value == ""){
		colocaError(nombre_error, group_nombre, campo_vacio, button_register);
		errors++;
	}

	if(document.getElementById('correo').value == ""){
		colocaError(correo_error, correo_group, campo_vacio, button_register);
		errors++;
	}

	if(document.getElementById('numero_cand').value == ""){
		colocaError(numero_error, numero_group, campo_vacio, button_register);
		errors++;
	}

	if(document.getElementById('password').value == ""){
		colocaError(password_error, password_group, campo_vacio, button_register);
		errors++;
	}

	if(document.getElementById('password_two').value == ""){
		colocaError(password_error_two, password_group_two, campo_vacio, button_register);
		errors++;
	}

	if(document.getElementById('dni').value == ""){
		colocaError(dni_error, dni_group, campo_vacio, button_register);
		errors++;
	}

	if(document.getElementById('term_cond').checked){
	}
	else{
		colocaError(term_cond_error, term_cond_group, term_cond_mensaje, button_register);
		errors++;
	}
// ----------------------------------------------Tipo de usuario 1 (candidato) exclusivo--------------------------------------
	if(tipo_usuario == 1){
		if(document.getElementById('apell_user').value == ""){
			colocaError(apell_error, apellido_group, campo_vacio, button_register);
			errors++;
		}

		if(document.getElementById('documentacion').value == ""){
			colocaError(seleccione_error, seleccione_group, lista_vacia, button_register);
			errors++;
		}
		if(document.getElementById('area_select').value == ""){
			colocaError(area_error, area_group, lista_vacia, button_register);
			errors++;
		}

		if(document.getElementById('nivel_interes').value == ""){
			colocaError(nivel_error, nivel_group, lista_vacia, button_register);
			errors++;
		}
	}
// ----------------------------------------------Tipo de usuario 1 (candidato) exclusivo--------------------------------------

// ----------------------------------------------Tipo de usuario 2 (candidato) exclusivo--------------------------------------
	if(tipo_usuario == 2){
		mensaje = "Rellene este campo";
		if(document.getElementById('nombre_contact').value == ""){
			colocaError(nombre_contact_error, nombre_contact_group, mensaje, button_register);
			errors++;
		}

		if(document.getElementById('apellido_contact').value == ""){
			colocaError(apellido_contact_error, apellido_contact_group, mensaje, button_register);
			errors++;
		}

		if(document.getElementById('tel_one_contact').value == ""){
			colocaError(tel_one_contact_error, tel_one_contact_group, mensaje, button_register);
			errors++;
		}
	}
// ----------------------------------------------Tipo de usuario 2 (candidato) exclusivo--------------------------------------
	return errors;
}

function validar_EC(dni_obj){
	var validacion = validarDocumento(dni_obj);
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

function verifyErrors(){
	var listerrors = document.getElementsByClassName('msg_error');
	return listerrors.length;
}
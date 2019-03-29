$('#areaCand').multiple_select({
    items: 3,
    dependence: {
      id_dependencia: "subareasCand",
      items: 1
    }
  });

var modal;
var campos = [];

// campos candidato
var nombresCandEmp;
var apellidosCand;
var correoCandEmp;
var celularCandEmp;
var tipoDoc;
var documentoCandEmp;
var areaCand;
var subareasCand;
var password_1;
var password_2;
var nombreConEmp;
var apellidoConEmp;
var tel1ConEmp;
var tel2ConEmp;
var terminosCond;

function camposDelForm(){
	nombresCandEmp = "";
	apellidosCand = "";
	correoCandEmp = "";
	celularCandEmp = "";
	tipoDoc = "";
	documentoCandEmp = "";
	areaCand = "";
	subareasCand = "";
	password_1 = "";
	password_2 = "";
	nombreConEmp = "";
	apellidoConEmp = "";
	tel1ConEmp = "";
	tel2ConEmp = "";
	// habilitar campos del formulario
	campos = [];
	if($('#nombresCandEmp').length){
		nombresCandEmp = $('#nombresCandEmp');
		campos.push(nombresCandEmp);
	}
	// No empresa----------
	if($('#apellidosCand').length){
		apellidosCand = $('#apellidosCand');
		campos.push(apellidosCand);
	}
	// No empresa----------

	if($('#correoCandEmp').length){
		correoCandEmp = $('#correoCandEmp');
		campos.push(correoCandEmp);
	}

	if($('#celularCandEmp').length){
		celularCandEmp = $('#celularCandEmp');
		campos.push(celularCandEmp);
	}

	if($('#tipoDoc').length){
		tipoDoc = $('#tipoDoc');
		campos.push(tipoDoc);
	}

	if($('#documentoCandEmp').length){
		documentoCandEmp = $('#documentoCandEmp');
		campos.push(documentoCandEmp);
	}
	// No empresa----------
	if($('#areaCand').length){
		areaCand = $('#areaCand');
		campos.push(areaCand);
	}

	if($('#subareasCand').length){
		subareasCand = $('#subareasCand');
		campos.push(subareasCand);
	}
	// No empresa----------
	if($('#password_1').length){
		password_1 = $('#password_1');
		campos.push(password_1);
	}

	if($('#password_2').length){
		password_2 = $('#password_2');
		campos.push(password_2);
	}

	// Solo empresa--------------
	if($('#nombreConEmp').length){
		nombreConEmp = $('#nombreConEmp');
		campos.push(nombreConEmp);
	}

	if($('#apellidoConEmp').length){
		apellidoConEmp = $('#apellidoConEmp');
		campos.push(apellidoConEmp);
	}

	if($('#tel1ConEmp').length){
		tel1ConEmp = $('#tel1ConEmp');
		campos.push(tel1ConEmp);
	}

	if($('#tel2ConEmp').length){
		tel2ConEmp = $('#tel2ConEmp');
		campos.push(tel2ConEmp);
	}

	if($('#terminosCond').length){
		terminosCond = $('#terminosCond');
		campos.push(terminosCond);
	}
	// terminosCond

	return campos;
}


$('#regCandMic').on('click', function(){
	$('#tipo_usuario').val(1);
	var tags = camposDelForm();
	// funcion mostrar dependiente del tipo de usuario
	showTags(tags, 1);
	riseModal();
});

$('#regEmpMic').on('click', function(){
	$('#tipo_usuario').val(2);
	$('#tipo_documentacion').val(1);
	var tags = camposDelForm();
	// funcion mostrar dependiente del tipo de usuario
	showTags(tags, 2);
	riseModal();
});

function showTags(tags, tipo){
	for (var i = 0; i < tags.length; i++) {
		if(tipo == 1){
			if(tags[i].attr('id') == 'documentoCandEmp'){
				tags[i].attr('disabled','disabled');
				tags[i].prev().html('Documento <i class="obligatorio">*</i>');
			}
			if(tags[i].attr('id') == 'nombreConEmp' ||
				tags[i].attr('id') == 'apellidoConEmp' ||
				tags[i].attr('id') == 'tel1ConEmp' ||
				tags[i].attr('id') == 'tel2ConEmp'){
				tags[i].parents(':eq(1)').css('display', 'none');
			}
			else{
				if(tags[i].attr('id') == 'nombresCandEmp'){
					tags[i].prev().html('Nombres <i class="obligatorio">*</i>');
				}
				else{
					tags[i].parents(':eq(1)').css('display', '');
				}
			}

			if($('#datosContEmp')){
				$('#datosContEmp').css('display', 'none');
			}

			if($('#socialReg').length){
				$('#socialReg').css('display', '');
			}
		}
		if(tipo == 2){
			if(tags[i].attr('id') == 'documentoCandEmp'){
				tags[i].removeAttr('disabled');
				tags[i].prev().html('RUC <i class="obligatorio">*</i>');
			}
			if(tags[i].attr('id') == 'apellidosCand' ||
				tags[i].attr('id') == 'tipoDoc' ||
				tags[i].attr('id') == 'areaCand' ||
				tags[i].attr('id') == 'subareasCand'){
				tags[i].parents(':eq(1)').css('display', 'none');
			}
			else{
				if(tags[i].attr('id') == 'nombresCandEmp'){
					tags[i].prev().html('Nombre Empresa <i class="obligatorio">*</i>');
				}
				else{
					tags[i].parents(':eq(1)').css('display', '');
				}
			}
			if($('#datosContEmp')){
				$('#datosContEmp').css('display', '');
			}

			if($('#socialReg').length){
				$('#socialReg').css('display', 'none');
			}
		}
	}
}

// ver u ocultar contraseña
$('.reveal_content').on('click', function(){
	var input = $(this).next();
	var tipo = input.attr('type');
	if(tipo == 'password'){
		input.attr('type', 'text');
		$(this).removeClass('fa fa-eye');
		$(this).addClass('fa fa-eye-slash');
	}
	else{
		input.attr('type', 'password');
		$(this).removeClass('fa fa-eye-slash');
		$(this).addClass('fa fa-eye');
	}

})


function riseModal(){
	if($('#modal_registro').length){
		var modal = $('#modal_registro');
		modal.modal('show');
	}
}

// Validaciones del formulario de registro

function validarOnSubmit(){
	var camposavalidar = camposDelForm();
	var tipo_usuario = $('#tipo_usuario').val();
// Campo nombreConEmp-------------------------------------
	if(camposavalidar[0].val() != ""){
		if(tipo_usuario == 1){
			if(!validarNombreApellido(camposavalidar[0].val())){
				crearMensajeError(camposavalidar[0], "Nombre ingresado no válido");
			}
			else{
				eliminarMensajeError(camposavalidar[0], "");
			}
		}
		else{
			if(!validarNombreEmpresa(camposavalidar[0].val())){
				crearMensajeError(camposavalidar[0], "Nombre ingresado no válido");
			}
			else{
				eliminarMensajeError(camposavalidar[0], "");
			}
		}
			
	}else{
		crearMensajeError(camposavalidar[0], "Rellene este campo");
	}

// Campo apellidosCand-------------------------------------
	if(tipo_usuario == 1){
		if(camposavalidar[1].val() != ""){
			if(!validarNombreApellido(camposavalidar[1].val())){
				crearMensajeError(camposavalidar[1], "Apellido ingresado no válido");
			}
			else{
				eliminarMensajeError(camposavalidar[1], "");
			}
		}else{
			crearMensajeError(camposavalidar[1], "Rellene este campo");
		}
	}

// Campo correoCandEmp-------------------------------------
	if(camposavalidar[2].val() != ""){
		if(validarCorreo(camposavalidar[2].val())){
			if(!verificarExiste(camposavalidar[2])){
				crearMensajeError(camposavalidar[2], "El correo ingresado ya existe");
			}
			else{
				eliminarMensajeError(camposavalidar[2], "");
			}
		}
		else{
			crearMensajeError(camposavalidar[2], "Correo ingresado no válido");
			// eliminarMensajeError(camposavalidar[2], "");
		}
	}else{
		crearMensajeError(camposavalidar[2], "Rellene este campo");
	}

// Campo celularCandEmp-------------------------------------
	if(camposavalidar[3].val() != ""){
		if(!validarTelefono(camposavalidar[3].val())){
			crearMensajeError(camposavalidar[3], "Ingrese un número válido");
		}
		else{
			eliminarMensajeError(camposavalidar[3], "");
		}
	}else{
		crearMensajeError(camposavalidar[3], "Rellene este campo");
	}

// Campo tipoDoc-------------------------------------
	if(tipo_usuario == 1){
		if(camposavalidar[4].val() != ""){
			eliminarMensajeError(camposavalidar[4], "");
		}else{
			crearMensajeError(camposavalidar[4], "Seleccione una opción");
		}
	}

// Campo documentoCandEmp-------------------------------------
	if(camposavalidar[5].val() != ""){
		if(!DniRuc_Validador(camposavalidar[5], $('#tipo_documentacion').val())){
			if(!verificarExiste(camposavalidar[5])){
				crearMensajeError(camposavalidar[5], "El documento ingresado ya existe");
			}
			else{
				eliminarMensajeError(camposavalidar[5], "");
			}
		}
		else{
			crearMensajeError(camposavalidar[5], "Ingrese un documento válido");
		}
	}else{
		crearMensajeError(camposavalidar[5], "Rellene este campo");
	}

	if(tipo_usuario == 1){
	// Campo areaCand-------------------------------------
		if(camposavalidar[6].val() != ""){
			eliminarMensajeError(camposavalidar[6], "");
		}else{
			crearMensajeError(camposavalidar[6], "Seleccione una opción");
		}

	// Campo subareasCand-------------------------------------
		if(camposavalidar[7].val() != ""){
			eliminarMensajeError(camposavalidar[7], "");
		}else{
			crearMensajeError(camposavalidar[7], "Seleccione una opción");
		}
	}

// Campo password_1-------------------------------------
	if(camposavalidar[8].val() != ""){
		if(validarPassword(camposavalidar[8].val())){
			if(!passwordCoinciden(camposavalidar[8], camposavalidar[9]) && camposavalidar[9].val() != ""){
				crearMensajeError(camposavalidar[8], "Las contraseñas no coinciden");
				crearMensajeError(camposavalidar[9], "Las contraseñas no coinciden");
			}
			else{
				// crearMensajeError(camposavalidar[8], "Ingrese una contraseña válida");
				eliminarMensajeError(camposavalidar[8], "");
				eliminarMensajeError(camposavalidar[9], "");
			}
		}
		else{
			crearMensajeError(camposavalidar[8], "Ingrese una contraseña válida");
		}
	}else{
		crearMensajeError(camposavalidar[8], "Rellene este campo");
	}

// Campo password_2-------------------------------------
	if(camposavalidar[9].val() != ""){
		if(validarPassword(camposavalidar[9].val())){
			if(!passwordCoinciden(camposavalidar[8], camposavalidar[9]) && camposavalidar[8].val() != ""){
				crearMensajeError(camposavalidar[8], "Las contraseñas no coinciden");
				crearMensajeError(camposavalidar[9], "Las contraseñas no coinciden");
			}
			else{
				// crearMensajeError(camposavalidar[8], "Ingrese una contraseña válida");
				eliminarMensajeError(camposavalidar[8], "");
				eliminarMensajeError(camposavalidar[9], "");
			}
		}
		else{
			// eliminarMensajeError(camposavalidar[8], "");
			crearMensajeError(camposavalidar[9], "Ingrese una contraseña válida");
		}
	}else{
		crearMensajeError(camposavalidar[9], "Rellene este campo");
	}

	if(!camposavalidar[14].is(':checked')){
		crearMensajeError(camposavalidar[14], "Debe aceptar términos y condiciones");
	}
	else{
		eliminarMensajeError(camposavalidar[14], "");
	}
	// console.log(camposavalidar[14]);

	
	if(tipo_usuario == 2){
//nombreConEmp
		if(camposavalidar[10].val() != ""){
			if(!validarNombreApellido(camposavalidar[10].val())){
				crearMensajeError(camposavalidar[10], "Ingrese un nombre válido");
			}
			else{
				eliminarMensajeError(camposavalidar[10], "");
			}
		}
		else{
			crearMensajeError(camposavalidar[10], "Rellene este campo");
		}

//apellidoConEmp
		if(camposavalidar[11].val() != ""){
			if(!validarNombreApellido(camposavalidar[11].val())){
				crearMensajeError(camposavalidar[11], "Ingrese un apellido válido");
			}
			else{
				eliminarMensajeError(camposavalidar[11], "");
			}
		}
		else{
			crearMensajeError(camposavalidar[11], "Rellene este campo");
		}

//tel1ConEmp
		if(camposavalidar[12].val() != ""){
			if(!validarTelefono(camposavalidar[12].val())){
				crearMensajeError(camposavalidar[12], "Ingrese un número válido");
			}
			else{
				eliminarMensajeError(camposavalidar[12], "");
			}
		}
		else{
			crearMensajeError(camposavalidar[12], "Rellene este campo");
		}

//tel2ConEmp
		if(camposavalidar[13].val() != ""){
			if(!validarTelefono(camposavalidar[13].val())){
				crearMensajeError(camposavalidar[13], "Ingrese un número válido");
			}
			else{
				eliminarMensajeError(camposavalidar[13], "");
			}
		}
		else{
			eliminarMensajeError(camposavalidar[13], "");
		}
	}
}

$('#form_register').on('submit', function(event){
	validarOnSubmit();
	console.log(checkErrors());
	if(!checkErrors()){
		event.preventDefault();
	}
});

$('#modal_registro').on('show.bs.modal', function(){
	// console.log("eder");
	var error_class = $('.error_class');
	var error_class_1 = $('.error_class_1');
	var error_class_2 = $('.error_class_2');
	var error_input = $('.error_input');
	var ahashakeheartache = $('#ahashakeheartache');

	for (var i = 0; i < error_class.length; i++) {
	 	$(error_class[i]).removeClass('error_class');
	 	$(error_class[i]).text("");
	}

	for (var i = 0; i < error_class_1.length; i++) {
	 	$(error_class_1[i]).removeClass('error_class_1');
	 	$(error_class_1[i]).text("");
	}

	for (var i = 0; i < error_class_2.length; i++) {
	 	$(error_class_2[i]).removeClass('error_class_2');
	 	$(error_class_2[i]).text("");
	}

	for (var i = 0; i < error_input.length; i++) {
	 	$(error_input[i]).removeClass('error_input');
	 	// $(error_input[i]).text("");
	}

	for (var i = 0; i < ahashakeheartache.length; i++) {
	 	$(ahashakeheartache[i]).removeClass('ahashakeheartache');
	 	$(ahashakeheartache[i]).text("");
	}

	var camposdelformReset = camposDelForm();
	for (var i = 0; i < camposdelformReset.length; i++) {
		if($(camposdelformReset[i]).attr('id') != 'tipoDoc'){
			$(camposdelformReset[i]).val("");
		}
	}

	$('#terminosCond').prop('checked', false);
});

// validaciones de cada componente--------------------------------------------------------------------------
	if($('#nombresCandEmp').length){
		$('#nombresCandEmp').on('blur', function(){
			if($(this).val() != ""){
				var tipo_user = $('#tipo_usuario').val();
				if(tipo_user == 1){
					if(!validarNombreApellido($(this).val())){
						crearMensajeError($(this), "Ingrese un nombre válido");
					}
					else{
						eliminarMensajeError($(this), "");
					}
				}
				else{
					if(!validarNombreEmpresa($(this).val())){
						crearMensajeError($(this), "Ingrese un nombre válido");
					}
					else{
						eliminarMensajeError($(this), "");
					}
				}	
			}
			else{
				crearMensajeError($(this), 'Rellene este campo');
			}
		});
	}



	if($('#apellidosCand').length){
		$('#apellidosCand').on('blur', function(){
			if($(this).val() != ""){
				if (!validarNombreApellido($(this).val())){
					crearMensajeError($(this), "Ingrese un apellido válido");
				}
				else{
					eliminarMensajeError($(this), "");
				}
			}
			else{
				crearMensajeError($(this), 'Rellene este campo');
			}
		})
	}


	if($('#correoCandEmp').length){
		$('#correoCandEmp').on('blur', function(){
			if($(this).val() != ""){
				if(validarCorreo($(this).val())){
					if(!verificarExiste($(this))){
						crearMensajeError($(this), 'El correo ingresado ya existe');
					}
					else{
						eliminarMensajeError($(this), "");
					}
				}
				else{
					crearMensajeError($(this), "Ingrese un correo válido")
				}
			}
			else{
				crearMensajeError($(this), 'Rellene este campo');
			}
		})
	}

	if($('#celularCandEmp').length){
		$('#celularCandEmp').on('blur', function(){
			if($(this).val() != ""){
				if(!validarTelefono($(this).val())){
					crearMensajeError($(this), "Ingrese un número válido");
				}
				else{
					eliminarMensajeError($(this), "");
				}
			}
			else{
				crearMensajeError($(this), 'Rellene este campo');
			}
		})
	}

	if($('#tipoDoc').length){
		$('#tipoDoc').on('change', function(){
			$('#tipo_documentacion').val($(this).val());
			$('#documentoCandEmp').removeAttr('disabled');
			$('#documentoCandEmp').prev().html($(this).find('option:selected').text()+" <i class='obligatorio'>*</i>");
			eliminarMensajeError($(this), "");
			if($('#documentoCandEmp').val() != ""){
				if(!DniRuc_Validador($('#documentoCandEmp'), $(this).val())){
					if(!verificarExiste($('#documentoCandEmp'))){
						crearMensajeError($('#documentoCandEmp'), "El documento ingresado ya existe");
					}
					else{
						eliminarMensajeError($('#documentoCandEmp'), "");
					}
				}
				else{
					crearMensajeError($('#documentoCandEmp'), "El documento ingresado no es válido");
				}
			}
		});
	}

	if($('#documentoCandEmp').length){
		$('#documentoCandEmp').on('blur', function(){
			if($(this).val() != ""){
				if(!DniRuc_Validador($(this), $('#tipo_documentacion').val())){
					if(!verificarExiste($(this))){
						crearMensajeError($(this), "El documento ingresado ya existe");
					}
					else{
						eliminarMensajeError($(this), "");
					}
				}
				else{
					crearMensajeError($(this), "El documento ingresado no es válido");
				}
			}
			else{
				crearMensajeError($(this), 'Rellene este campo');
			}
		})
	}

	if($('#subareasCand').length){
		$('#subareasCand').on('change', function(){
			// console.log("eder");
			if($(this).val() == ""){
				crearMensajeError($(this), "Seleccione una opción");
			}
			else{
				eliminarMensajeError($(this), "");
				eliminarMensajeError($('#areaCand'), "");
			}
		});
	}

	if($('#password_1').length){
		$('#password_1').on('blur', function(){
			if($(this).val() != ""){
				if(validarPassword($(this).val())){
					if($('#password_2').val() != ""){
						if(!passwordCoinciden($(this), $('#password_2'))){
							crearMensajeError($(this), "Las contraseñas no coinciden");
							crearMensajeError($('#password_2'), "Las contraseñas no coinciden");
						}
						else{
							eliminarMensajeError($(this), "");
							eliminarMensajeError($('#password_2'), "");
						}
					}
					else{
						eliminarMensajeError($(this), "");
					}
				}
				else{
					crearMensajeError($(this), "Al menos una letra y numero. Mínimo 8 caracteres");
				}
			}
			else{
				crearMensajeError($(this), "Rellene este campo");
			}
		})
	}

	if($('#password_2').length){
		$('#password_2').on('blur', function(){
			if($(this).val() != ""){
				if(validarPassword($(this).val())){
					if($('#password_2').val() != ""){
						if(!passwordCoinciden($(this), $('#password_1'))){
							crearMensajeError($(this), "Las contraseñas no coinciden");
							crearMensajeError($('#password_1'), "Las contraseñas no coinciden");
						}
						else{
							eliminarMensajeError($(this), "");
							eliminarMensajeError($('#password_1'), "");
						}
					}
					else{
						eliminarMensajeError($(this), "");
					}
				}
				else{
					crearMensajeError($(this), "Al menos una letra y numero. Mínimo 8 caracteres");
				}
			}
			else{
				crearMensajeError($(this), "Rellene este campo");
			}
		})
	}

	if($('#nombreConEmp').length){
		$('#nombreConEmp').on('blur', function(){
			if($(this).val() != ""){
				if(!validarNombreApellido($(this).val())){
					crearMensajeError($(this), "El nombre ingresado no es válido");
				}
				else{
					eliminarMensajeError($(this), "");
				}
			}
			else{
				crearMensajeError($(this), "Rellene este campo");
			}
		})
	}

	if($('#apellidoConEmp').length){
		$('#apellidoConEmp').on('blur', function(){
			if($(this).val() != ""){
				if(!validarNombreApellido($(this).val())){
					crearMensajeError($(this), "El apellido ingresado no es válido");
				}
				else{
					eliminarMensajeError($(this), "");
				}
			}
			else{
				crearMensajeError($(this), "Rellene este campo");
			}
		})
	}

	if($('#tel1ConEmp').length){
		$('#tel1ConEmp').on('blur', function(){
			if($(this).val() != ""){
				if(!validarTelefono($(this).val())){
					crearMensajeError($(this), "Ingrese un número válido");
				}
				else{
					eliminarMensajeError($(this), "");
				}
			}
			else{
				crearMensajeError($(this), "Rellene este campo");
			}
		})
	}

	if($('#tel2ConEmp').length){
		$('#tel2ConEmp').on('blur', function(){
			if($(this).val() != ""){
				if(!validarTelefono($(this).val())){
					crearMensajeError($(this), "Ingrese un número válido");
				}
				else{
					eliminarMensajeError($(this), "");
				}
			}
			else{
				eliminarMensajeError($(this), "");
			}
		})
	}

	if($('#terminosCond').length){
		$('#terminosCond').on('change', function(){
			if(!$(this).is(':checked')){
				crearMensajeError($(this), "Deebe aceptar términos y condiciones");
			}
			else{
				eliminarMensajeError($(this), "");
			}
		})
	}

// validaciones de cada componente--------------------------------------------------------------------------

function crearMensajeError(obj, mensaje){
	if(obj.attr('class') == "terminosCond"){
		$(obj).parent().next().attr('class', 'error_class_2 ahashakeheartache');
		$(obj).parent().next().text(mensaje);
		return false;
	}
	// console.log(obj.prop('tagName'));
	if(obj.attr('multiple')){
		// console.log("eder");
		$(obj).next().attr('class', 'error_class_1 ahashakeheartache');
		$(obj).addClass('error_input');
		$(obj).next().text(mensaje);
		return false;
	}
	if($(obj).length){
		$(obj).addClass('error_input');
		$(obj).next().attr('class', 'error_class ahashakeheartache');
		$(obj).next().text(mensaje);
	}
}

function eliminarMensajeError(obj, mensaje){
	if(obj.attr('class') == "terminosCond"){
		$(obj).parent().next().removeAttr('class', 'error_class_2 ahashakeheartache');
		$(obj).parent().next().text("");
		return false;
	}

	if($(obj).length){
		$(obj).removeClass('error_input');
		$(obj).next().removeAttr('class');
		$(obj).next().text("");
	}
}

function verificarExiste(obj){
	var buscar = obj.val();
	var url = "";
	var puerto_host = $('#puerto_host').val();
	var retorno = "";
	// console.log(puerto_host);
	// console.log(buscar);
	if(obj[0].id == 'correoCandEmp'){
		url = puerto_host+"?mostrar=registro&opcion=buscarCorreo&correo="+buscar;
	}
	if(obj[0].id == 'documentoCandEmp'){
		url = puerto_host+"?mostrar=registro&opcion=buscarDocumento&documento="+buscar;
	}
	console.log(url);
	$.ajax({
	    type: "GET",
	    url: url,
	    dataType:'json',
	    async: false,
	    success:function(data){
	    	console.log(data.dato);
	        if(data.dato != ""){
	        	retorno = false;
	        }
	        else{
	        	retorno = true;
	        }
	    },
	    error: function (request, status, error) {
	        console.log(request.responseText);
	    }
	});
	return retorno;
}

// funciones de Validaciones
function validarCorreo(correo) { 
  return /^\w+([\.\+\-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(correo);
}

function validarNombreApellido(nombre){
	if((/^[A-Za-zÁÉÍÓÚñáéíóúÑ ]{4,}$/.test(nombre)) && (/(.*[a-zA-ZÁÉÍÓÚñáéíóúÑ]){1}/.test(nombre))){
		return true;
	}
	else{
		return false;
	}
}

function validarNombreEmpresa(nombre){
	if((/^[a-zA-ZÁÉÍÓÚñáéíóúÑ0-9&.,' ]{4,}$/.test(nombre)) && (/(.*[a-zA-ZÁÉÍÓÚñáéíóúÑ]){3}/.test(nombre))){
		return true;
	}
	else{
		return false;
	}
}

function validarTelefono(telefono){
	return /^[0-9]{10,15}$/.test(telefono);
}

function validarNumero(numero){
	return /^[1-5]{1,1}$/.test(numero);
}

function validarPassword(password){
	return /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(password);
}

function passwordCoinciden(obj1, obj2){
	// if(obj1.val() != "" && obj2.val() != ""){
		if(obj1.val() == obj2.val()){
			return true;
		}else{
			return false;
		}
	// }
		
}

function checkErrors(){
	var error_1 = $('.error_input');
	var error_2 = $('.error_class');
	var error_3 = $('.error_class_1');
	var error_4 = $('.error_class_2');
	// var error_5 = $('.error');
	if(error_1.length == 0 && error_2.length == 0 && error_3.length == 0 && error_4.length == 0){
		return true;
	}
	else{
		return false;
	}
}
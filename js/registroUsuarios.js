$(document).ready(function(){
	if(leerCookie('preRegistro') != null){
		controlButtonForm(leerCookie('preRegistro'));
	}
	else{
		controlButtonForm(1);
	}
});

if($('#fechaNac')){
	$('#fechaShow').DateTimePicker({
      dateFormat: "yyyy-MM-dd",
      shortDayNames: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
      shortMonthNames: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
      fullMonthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Deciembre"],
      titleContentDate: "Configurar fecha",
      titleContentTime: "Configurar tiempo",
      titleContentDateTime: "Configurar Fecha & Tiempo",
      setButtonContent: "Listo",
      clearButtonContent: "Limpiar"
    });
}

$('.controlTipo').find('button').on('click', function(){
	var idBoton = $(this).attr('id');
	if(idBoton == "btnEmp"){
		controlButtonForm(2);
	}
	else{
		controlButtonForm(1);
	}
})

function controlButtonForm(id){
	// alert(id);
	buttonApariencia(id);
	habilitarCampos(id);
}

function buttonApariencia(id){
	var candForm = $('#btnCand');
	var empForm = $('#btnEmp');
	if(id == 1){
		empForm.removeClass('btn-primary');
		empForm.addClass('btn-default');
		candForm.removeClass('btn-default');
		candForm.addClass('btn-primary');
	}
	else{
		empForm.addClass('btn-primary');
		empForm.removeClass('btn-default');
		candForm.addClass('btn-default');
		candForm.removeClass('btn-primary');
	}
}

if($('#nombresCandEmp').length){
	$('#nombresCandEmp').on('blur', function(){
		var tipousuario = $('#tipo_usuario').val();
		if($(this).val() != ""){
			if(tipousuario == 2){
				if(!validarNombreEmpresa($(this).val())){
					crearMensajeError($(this), "Ingrese un nombre válido");
				}
				else{
					eliminarMensajeError($(this));
				}
			}
			else{
				if(!validarNombreApellido($(this).val())){
					crearMensajeError($(this), "Ingrese un nombre válido");
				}
				else{
					eliminarMensajeError($(this));
				}
			}
		}
		else{
			crearMensajeError($(this), "Rellene este campo");
		}
	});
}

if($('#apellidosCand').length){
	$('#apellidosCand').on('blur', function(){
		if($(this).val() != ""){
			if(!validarNombreApellido($(this).val())){
				crearMensajeError($(this), "Ingrese un apellido válido");
			}
			else{
				eliminarMensajeError($(this));
			}
		}
		else{
			crearMensajeError($(this), "Rellene este campo");
		}
	});
}

// if($('#correoCandEmp').length){
// 	$('#correoCandEmp').on('blur', function(){
// 		if($(this).val() != ""){
// 			if(!validarCorreo($(this).val())){
// 				crearMensajeError($(this), "Ingrese un correo válido");
// 			}
// 			else{
// 				eliminarMensajeError($(this));
// 			}
// 		}
// 		else{
// 			crearMensajeError($(this), "Rellene este campo");
// 		}
// 	});
// }

	if($('#correoCandEmp').length){
		$('#correoCandEmp').on('blur', function(){
			if($(this).val() != ""){
				if(validarCorreo($(this).val())){
					if(!searchAjax($(this))){
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
		var tipousuario = $('#tipo_usuario').val();
		if($(this).val() != ""){
			if(tipousuario == 2){
				if(!ValidarCelularConvencional($(this).val())){
					crearMensajeError($(this), "Mínimo 9 dígitos, máx. 15");
				}
				else{
					eliminarMensajeError($(this));
				}
			}
			else{
				if(!validarCelCand($(this).val())){
					crearMensajeError($(this), "Debe contener entre 10 y 15 dígitos");
				}
				else{
					eliminarMensajeError($(this));
				}
			}
		}
		else{
			crearMensajeError($(this), "Rellene este campo");
		}
	});
}

if($('#tipoDoc').length){
	$('#tipoDoc').on('change blur', function(){
		var textoSelect = $(this).children('option:selected').text();
		var docCampo = $('#documentoCandEmp');
		if($(this).val() != ""){
			docCampo.attr('placeholder', "Número de "+textoSelect+" *");
			docCampo.removeAttr('disabled');
			$('#tipo_documentacion').val($(this).val());
				if(docCampo.val() != ""){ 
					if(DniRuc_Validador(docCampo,$(this).val()) == true){
						if(searchAjax(docCampo)){
							eliminarMensajeError(docCampo);
						}
						else{
							crearMensajeError(docCampo, "Documento ingresado ya existe");
						}
					}
					else{
						crearMensajeError(docCampo, "Documento ingresado no es válido");
					}
				}
				eliminarMensajeError($(this));
		}
		else{
			crearMensajeError($(this), "Seleccione una opción");
		}
	});
}

if($('#documentoCandEmp').length){
	$('#documentoCandEmp').on('blur', function(){
		if($(this).val() != ""){
			var tipoDocCampo = $('#tipo_documentacion').val();
			if(DniRuc_Validador($(this), tipoDocCampo) == true){
				if(searchAjax($(this))){
					eliminarMensajeError($(this));
				}
				else{
					crearMensajeError($(this), "Documento ingresado ya existe");
				}
			}
			else{
				crearMensajeError($(this), "Documento ingresado no es válido");
			}
		}
		else{
			crearMensajeError($(this), "Rellene este campo");
		}
	});
}

if($('#fechaNac').length){
	$('#fechaNac').on('blur', function(){
		if($(this).val() != ""){
			if(validarFormatoFecha($(this).val())){
				if(!calcularEdad($(this).val())){
					crearMensajeError($(this), "Debe ser mayor de edad");
				}
				else{
					eliminarMensajeError($(this));
				}
			}
			else{
				crearMensajeError($(this), "Ingrese una fecha válida");
			}
		}
		else{
			crearMensajeError($(this), "Rellene este campo");
		}
	})
}

if($('#generoUsuario').length){
	$('#generoUsuario').on('blur change', function(){
		if($(this).val() != null){
			eliminarMensajeError($(this));
		}
		else{
			crearMensajeError($(this), "Seleccione una opción");
		}
	})
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
					crearMensajeError($(this), "Mín. 8 caracteres, 1 letra, 1 número");
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
					crearMensajeError($(this), "Mín. 8 caracteres, 1 letra, 1 número");
				}
			}
			else{
				crearMensajeError($(this), "Rellene este campo");
			}
		})
	}

	if($('#terminosCond').length){
		$('#terminosCond').on('change', function(){
			if($(this).prop('checked') == false){
				crearMensajeError($(this), 'Debe aceptar términos y condiciones');
			}
			else{
				eliminarMensajeError($(this));
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
				if(!validarCelCand($(this).val())){
					crearMensajeError($(this), "10 dígitos");
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
				if(!ValidarCelularConvencional($(this).val())){
					crearMensajeError($(this), "Longitud entre 9 y 15 dígitos");
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

	if($('#sectorind').length){
		$('#sectorind').on('change blur', function(){
			if($(this).val() == "" || $(this).val() == null){
				crearMensajeError($(this), "Seleccione una opción");
			}
			else{
				eliminarMensajeError($(this), "");
			}
		});
	}

function viewErrors(){
	var errorClass = $('.errorClass');
	if(errorClass.length == 0){
		return true;
	}
	else{
		return false;
	}
}

function validarOnSubmit(){
	var tipousuario = $('#tipo_usuario').val();
	if($('#nombresCandEmp').length){
			tipousuario = $('#tipo_usuario').val();
			if($('#nombresCandEmp').val() != ""){
				if(tipousuario == 2){
					if(!validarNombreEmpresa($('#nombresCandEmp').val())){
						crearMensajeError($('#nombresCandEmp'), "Ingrese un nombre válido");
					}
					else{
						eliminarMensajeError($('#nombresCandEmp'));
					}
				}
				else{
					if(!validarNombreApellido($('#nombresCandEmp').val())){
						crearMensajeError($('#nombresCandEmp'), "Ingrese un nombre válido");
					}
					else{
						eliminarMensajeError($('#nombresCandEmp'));
					}
				}
			}
			else{
				crearMensajeError($('#nombresCandEmp'), "Rellene este campo");
			}
	}

if(tipousuario == 1){
	if($('#apellidosCand').length){
		if($('#apellidosCand').val() != ""){
			if(!validarNombreApellido($('#apellidosCand').val())){
				crearMensajeError($('#apellidosCand'), "Ingrese un apellido válido");
			}
			else{
				eliminarMensajeError($('#apellidosCand'));
			}
		}
		else{
			crearMensajeError($('#apellidosCand'), "Rellene este campo");
		}
	}

	if($('#tipoDoc').length){
		var textoSelect = $('#tipoDoc').children('option:selected').text();
		var docCampo = $('#documentoCandEmp');
		if($('#tipoDoc').val() != ""){
			docCampo.attr('placeholder', "Número de "+textoSelect+" *");
			docCampo.removeAttr('disabled');
			$('#tipo_documentacion').val($('#tipoDoc').val());
				if(docCampo.val() != ""){ 
					if(DniRuc_Validador(docCampo,$('#tipoDoc').val()) == true){
						if(!searchAjax(docCampo) != true){
							eliminarMensajeError(docCampo);
						}
						else{
							crearMensajeError(docCampo, "Documento ingresado ya existe");
						}
					}
					else{
						crearMensajeError(docCampo, "Documento ingresado no es válido");
					}
				}
				eliminarMensajeError($('#tipoDoc'));
		}
		else{
			crearMensajeError($('#tipoDoc'), "Seleccione una opción");
		}
	}

	if($('#generoUsuario').length){
		if($('#generoUsuario').val() != null){
			eliminarMensajeError($('#generoUsuario'));
		}
		else{
			crearMensajeError($('#generoUsuario'), "Seleccione una opción");
		}
	}

	if($('#fechaNac').length){
		if($('#fechaNac').val() != ""){
			if(validarFormatoFecha($('#fechaNac').val())){
				if(!calcularEdad($('#fechaNac').val())){
					crearMensajeError($('#fechaNac'), "Debe ser mayor de edad");
				}
				else{
					eliminarMensajeError($('#fechaNac'));
				}
			}
			else{
				crearMensajeError($('#fechaNac'), "Ingrese una fecha válida");
			}
		}
		else{
			crearMensajeError($('#fechaNac'), "Rellene este campo");
		}
	}
}

	// if($('#correoCandEmp').length){
	// 	if($('#correoCandEmp').val() != ""){
	// 		if(!validarCorreo($('#correoCandEmp').val())){
	// 			crearMensajeError($('#correoCandEmp'), "Ingrese un correo válido");
	// 		}
	// 		else{
	// 			eliminarMensajeError($('#correoCandEmp'));
	// 		}
	// 	}
	// 	else{
	// 		crearMensajeError($('#correoCandEmp'), "Rellene este campo");
	// 	}
	// }

	if($('#correoCandEmp').length){
			if($('#correoCandEmp').val() != ""){
				if(validarCorreo($('#correoCandEmp').val())){
					if(!searchAjax($('#correoCandEmp'))){
						crearMensajeError($('#correoCandEmp'), 'El correo ingresado ya existe');
					}
					else{
						eliminarMensajeError($('#correoCandEmp'), "");
					}
				}
				else{
					crearMensajeError($('#correoCandEmp'), "Ingrese un correo válido");
				}
			}
			else{
				crearMensajeError($('#correoCandEmp'), 'Rellene este campo');
			}
	}


	if($('#celularCandEmp').length){
		var tipousuario = $('#tipo_usuario').val();
		if($('#celularCandEmp').val() != ""){
			if(tipousuario == 2){
				if(!ValidarCelularConvencional($('#celularCandEmp').val())){
					crearMensajeError($('#celularCandEmp'), "Mínimo 9 dígitos, máx. 15");
				}
				else{
					eliminarMensajeError($('#celularCandEmp'));
				}
			}
			else{
				if(!validarCelCand($('#celularCandEmp').val())){
					crearMensajeError($('#celularCandEmp'), "Debe contener entre 10 y 15 dígitos");
				}
				else{
					eliminarMensajeError($('#celularCandEmp'));
				}
			}
		}
		else{
			crearMensajeError($('#celularCandEmp'), "Rellene este campo");
		}
	}

	if($('#documentoCandEmp').length){
		if($('#documentoCandEmp').val() != ""){
			var tipoDocCampo = $('#tipo_documentacion').val();
			if(DniRuc_Validador($('#documentoCandEmp'), tipoDocCampo) == true){
				if(searchAjax($('#documentoCandEmp'))){
					eliminarMensajeError($('#documentoCandEmp'));
				}
				else{
					crearMensajeError($('#documentoCandEmp'), "Documento ingresado ya existe");
				}
			}
			else{
				crearMensajeError($('#documentoCandEmp'), "Documento ingresado no es válido");
			}
		}
		else{
			crearMensajeError($('#documentoCandEmp'), "Rellene este campo");
		}
	}



	if($('#password_1').length){
		if($('#password_1').val() != ""){
			if(validarPassword($('#password_1').val())){
				if($('#password_2').val() != ""){
					if(!passwordCoinciden($('#password_1'), $('#password_2'))){
						crearMensajeError($('#password_1'), "Las contraseñas no coinciden");
						crearMensajeError($('#password_2'), "Las contraseñas no coinciden");
					}
					else{
						eliminarMensajeError($('#password_1'), "");
						eliminarMensajeError($('#password_2'), "");
					}
				}
				else{
					eliminarMensajeError($('#password_1'), "");
				}
			}
			else{
				crearMensajeError($('#password_1'), "Mín. 8 caracteres, 1 letra, 1 número");
			}
		}
		else{
			crearMensajeError($('#password_1'), "Rellene este campo");
		}
	}

	if($('#password_2').length){
		if($('#password_2').val() != ""){
			if(validarPassword($('#password_2').val())){
				if($('#password_2').val() != ""){
					if(!passwordCoinciden($('#password_2'), $('#password_1'))){
						crearMensajeError($('#password_2'), "Las contraseñas no coinciden");
						crearMensajeError($('#password_1'), "Las contraseñas no coinciden");
					}
					else{
						eliminarMensajeError($('#password_2'), "");
						eliminarMensajeError($('#password_1'), "");
					}
				}
				else{
					eliminarMensajeError($('#password_2'), "");
				}
			}
			else{
				crearMensajeError($('#password_2'), "Mín. 8 caracteres, 1 letra, 1 número");
			}
		}
		else{
			crearMensajeError($('#password_2'), "Rellene este campo");
		}
	}

	if($('#terminosCond').length){
		if($('#terminosCond').prop('checked') == false){
			crearMensajeError($('#terminosCond'), 'Debe aceptar términos y condiciones');
		}
		else{
			eliminarMensajeError($('#terminosCond'));
		}
	}


	

	if(tipousuario == 2){
		if($('#nombreConEmp').length){
			if($('#nombreConEmp').val() != ""){
				if(!validarNombreApellido($('#nombreConEmp').val())){
					crearMensajeError($('#nombreConEmp'), "El nombre ingresado no es válido");
				}
				else{
					eliminarMensajeError($('#nombreConEmp'), "");
				}
			}
			else{
				crearMensajeError($('#nombreConEmp'), "Rellene este campo");
			}
		}

		if($('#apellidoConEmp').length){
			if($('#apellidoConEmp').val() != ""){
				if(!validarNombreApellido($('#apellidoConEmp').val())){
					crearMensajeError($('#apellidoConEmp'), "El apellido ingresado no es válido");
				}
				else{
					eliminarMensajeError($('#apellidoConEmp'), "");
				}
			}
			else{
				crearMensajeError($('#apellidoConEmp'), "Rellene este campo");
			}
		}

		if($('#tel1ConEmp').length){
			if($('#tel1ConEmp').val() != ""){
				if(!ValidarCelularConvencional($('#tel1ConEmp').val())){
					crearMensajeError($('#tel1ConEmp'), "Longitud entre 9 y 15 dígitos");
				}
				else{
					eliminarMensajeError($('#tel1ConEmp'), "");
				}
			}
			else{
				crearMensajeError($('#tel1ConEmp'), "Rellene este campo");
			}
		}

		if($('#tel2ConEmp').length){
			if($('#tel2ConEmp').val() != ""){
				if(!ValidarCelularConvencional($('#tel2ConEmp').val())){
					crearMensajeError($('#tel2ConEmp'), "Longitud entre 9 y 15 dígitos");
				}
				else{
					eliminarMensajeError($('#tel2ConEmp'), "");
				}
			}
			else{
				eliminarMensajeError($('#tel2ConEmp'), "");
			}
		}

		if($('#sectorind').length){
			if($('#sectorind').val() == "" || $('#sectorind').val() == null){
				crearMensajeError($('#sectorind'), "Seleccione una opción");
			}
			else{
				eliminarMensajeError($('#sectorind'), "");
			}
		}
	}
}

function searchAjax(obj){
	var val_retorno1 = "";	
	var puerto_host = $('#puerto_host').val();
	var contenido = $(obj).val();
	var url;
	var tipo_dni = $('#tipo_usuario').val();
		if(contenido != "" && tipo_dni != ""){
			if(obj[0].id == "documentoCandEmp"){
				url = puerto_host+"/index.php?mostrar=registro&opcion=buscarDni&dni="+contenido;
			}
			if(obj[0].id == "correoCandEmp"){
				url = puerto_host+"/index.php?mostrar=registro&opcion=buscarCorreo&correo="+contenido;
			}
			$.ajax({
        type: "GET",
        url: url,
        dataType:'json',
        async: false,
        success:function(data){
            if(data.dato != ""){
            	val_retorno1 = false;
            }
            else{
            	val_retorno1 = true;
            }
        },
        error: function (request, status, error) {
            console.log(request.responseText);
        }
		  });
		}
	return val_retorno1;
}

function crearMensajeError(obj, mensaje){
	var diverror = $(obj).prev();
	if(obj.attr('id') == "password_1" || obj.attr('id') == "password_2"){
		diverror = obj.parent().prev();
	}
	if(obj.attr('id') == "terminosCond"){
		diverror = obj.prev();
	}
	eliminarMensajeError(obj);
	diverror.addClass('errorClass');
	diverror.text(mensaje);
}

function eliminarMensajeError(obj){
	var diverror = $(obj).prev();
	if(obj.attr('id') == "password_1" || obj.attr('id') == "password_2"){
		diverror = obj.parent().prev();
	}
	if(obj.attr('id') == "terminosCond"){
		// diverror = obj.parents(':eq(1)').prev();
		diverror = obj.prev();
	}
	diverror.removeClass('errorClass');
	diverror.text('');
}

function habilitarCampos(id){
	resetForm();
	// variables
		var nombresCandEmp;
		var apellidosCand;
		var correoCandEmp;
		var celularCandEmp;
		var tipoDoc;
		var documentoCandEmp;
		var fechaNac;
		var generoUsuario;
		var password_1;
		var password_2;
		var nombreConEmp;
		var apellidoConEmp;
		var tel1ConEmp;
		var tel2ConEmp;
		var terminosCond;
		var sectorind;
		// var camposEmp = [];
		// var camposCand = [];
	// variables
	if($('#nombresCandEmp').length){
		nombresCandEmp = $('#nombresCandEmp');
	}
	if($('#apellidosCand').length){
		apellidosCand = $('#apellidosCand');
	}
	if($('#correoCandEmp').length){
		correoCandEmp = $('#correoCandEmp');
	}
	if($('#celularCandEmp').length){
		celularCandEmp = $('#celularCandEmp');
	}
	if($('#tipoDoc').length){
		tipoDoc = $('#tipoDoc');
	}
	if($('#documentoCandEmp').length){
		documentoCandEmp = $('#documentoCandEmp');
	}
	if($('#fechaNac').length){
		fechaNac = $('#fechaNac');
	}
	if($('#generoUsuario').length){
		generoUsuario = $('#generoUsuario');
	}
	if($('#password_1').length){
		password_1 = $('#password_1');
	}
	if($('#password_2').length){
		password_2 = $('#password_2');
	}
	if($('#nombreConEmp').length){
		nombreConEmp = $('#nombreConEmp');
	}
	if($('#apellidoConEmp').length){
		apellidoConEmp = $('#apellidoConEmp');
	}
	if($('#tel1ConEmp').length){
		tel1ConEmp = $('#tel1ConEmp');
	}
	if($('#tel2ConEmp').length){
		tel2ConEmp = $('#tel2ConEmp');
	}
	if($('#terminosCond').length){
		terminosCond = $('#terminosCond');
	}
	if($('#sectorind').length){
		sectorind = $('#sectorind');
	}
	$('#tipo_usuario').val(id);
	if(id == 1){
		$('.registro-titulo').text('Registrarse como Candidato');
		$('#tipo_documentacion').val('');
		apellidosCand.parent().css('display', '');
		tipoDoc.parent().css('display', '');
		generoUsuario.parent().css('display', '');
		sectorind.parent().css('display', 'none');
		fechaNac.parent().css('display', '');
		correoCandEmp.parent().removeClass('col-md-12').addClass('col-md-6');
		$('#datosContactoLabel').css('display', 'none');
		nombreConEmp.parent().css('display', 'none');
		apellidoConEmp.parent().css('display', 'none');
		tel1ConEmp.parent().css('display', 'none');
		tel2ConEmp.parent().css('display', 'none');
		$('#socialRegistro').css('display', '');
		documentoCandEmp.attr('placeholder', 'Documento *');
		celularCandEmp.attr('placeholder', 'Celular *');
		if($('#tipoDoc').val() != ""){
			$('#documentoCandEmp').prop('disabled', false);
		}
		else{
			$('#documentoCandEmp').prop('disabled', true);
		}

	}else{
		$('#documentoCandEmp').prop('disabled', false);
		$('.registro-titulo').text('Registrarse como Empresa');
		$('#tipo_documentacion').val(1);
		apellidosCand.parent().css('display', 'none');
		tipoDoc.parent().css('display', 'none');
		generoUsuario.parent().css('display', 'none');
		sectorind.parent().css('display', '');
		fechaNac.parent().css('display', 'none');
		correoCandEmp.parent().removeClass('col-md-6').addClass('col-md-12');
		$('#datosContactoLabel').css('display', '');
		nombreConEmp.parent().css('display', '');
		apellidoConEmp.parent().css('display', '');
		tel1ConEmp.parent().css('display', '');
		tel2ConEmp.parent().css('display', '');
		$('#socialRegistro').css('display', 'none');
		documentoCandEmp.attr('placeholder', 'Ruc *');
		celularCandEmp.attr('placeholder', 'Teléfono *');
	}
}

$('#registroFormulario').on('submit', function(event){
	validarOnSubmit();
	if(viewErrors() == false){
		event.preventDefault();
	}
});

function resetForm(){
	var camposdelform = $('#registroFormulario').find('input:not([type="hidden"], [type="submit"]), select');
	$.each(camposdelform, function(indice, elemento){
		if($(elemento).prop('tagName') == "INPUT"){
			$(elemento).val("");
		}
		if($(elemento).prop('tagName') == "SELECT"){
			$(elemento).children('option:first-child').prop('selected', true);
		}
		if($(elemento).attr('type') == "checkbox"){
			$(elemento).prop('checked', false);
		}
	});
	var errorClass = $('.errorClass');
	$.each(errorClass, function(indice, elemento){
		$(elemento).removeClass('errorClass');
		$(elemento).text('');
	});

	var eyeFontIcon = $('.fa-eye-slash');
	$.each(eyeFontIcon, function(indice, elemento){
		$(elemento).removeClass('fa-eye-slash');
		$(elemento).addClass('fa-eye');
		$(elemento).parent().next().attr('type', 'password');
	});
}


if($('.fa-eye,.fa-eye-slash').length){
	$('.fa-eye,.fa-eye-slash').parent().on('click', function(){
		var childrenEye = $(this).children('i');
		if(childrenEye.hasClass('fa-eye-slash')){
			childrenEye.removeClass('fa-eye-slash').addClass('fa-eye');
			$(this).next('input').attr('type', 'password');
		}
		else{
			childrenEye.removeClass('fa-eye').addClass('fa-eye-slash');
			$(this).next('input').attr('type', 'text');
		}
	})
}

function leerCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function safari(){
	if(navigator.userAgent.indexOf("Safari") > -1){
		var safariGrid = $('.form-group');
		$.each(safariGrid, function(indice, elemento){
			$(elemento).removeClass('col-md-6');
			$(elemento).removeClass('col-xs-12');
			$(elemento).addClass('col-md-12');
		});
	}
}

function validarCorreo(correo) { 
  return /^\w+([\.\+\-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(correo);
}

function ValidarTelefonoConvencional(valor){
	if(/^[0-9]{9}$/.test(valor)){return true;}else{return false;}
}


function ValidarCelularConvencional(valor){
	if(/^[0-9]{9,15}$/.test(valor)){return true;}else{return false;}
}

function validarCelCand(valor){
	if(/^[0-9]{10,15}$/.test(valor)){return true;}else{return false;}
}

function calcularEdad(contenido){
    // Si la fecha es correcta, calculamos la edad
    var values=contenido.split("-");
    var dia = values[2];
    var mes = values[1];
    var ano = values[0];
    // cogemos los valores actuales
    var fecha_hoy = new Date();
    var ahora_ano = fecha_hoy.getYear();
    var ahora_mes = fecha_hoy.getMonth()+1;
    var ahora_dia = fecha_hoy.getDate();
    // realizamos el calculo
    var edad = (ahora_ano + 1900) - ano;

    if ( ahora_mes < mes )
    {
        edad--;
    }
    if ((mes == ahora_mes) && (ahora_dia < dia))
    {
        edad--;
    }
    if (edad > 1900)
    {
        edad -= 1900;
    }

    if(edad >= 18){
        
        return true;

    }else{
        return false;
    }
}
function validarFormatoFecha(campo) {
  var RegExPattern = /^\d{1,2}-\d{1,2}-\d{4}$/;
  var values = campo.split("-");
  var dia = parseInt(values[2]);
  var mes = parseInt(values[1]);
  var ano = parseInt(values[0]);

  if((dia <= 0 || dia > 31) || (mes <= 0 || mes > 12) || (ano <= 1500 || ano > 2099)){
    return false;
  }else if ((RegExPattern.test(dia+"-"+mes+"-"+ano)) && (campo!='')) {
    return true;
  } else {
    return false;
  }
}
function validarNombreApellido(nombre){
	if((/^[A-Za-zÁÉÍÓÚñáéíóúÑ ]{1,}$/.test(nombre)) && (/(.*[a-zA-ZÁÉÍÓÚñáéíóúÑ]){1,}/.test(nombre))){
		return true;
	}
	else{
		return false;
	}
}

function validarNombreEmpresa(nombre){
	if((/^([a-zA-ZÁÉÍÓÚñáéíóúÑ]+[0-9&.,' ]*)*$/.test(nombre))){
		return true;
	}
	else{
		return false;
	}
}

function validarPassword(password){
	return /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(password);
}

function passwordCoinciden(obj1, obj2){
	if(obj1.val() == obj2.val()){
		return true;
	}else{
		return false;
	}
}

// $('.form-control').on('click', function(){
// 	console.log($(this).attr('placeholder').split(' ')[0]);
// })
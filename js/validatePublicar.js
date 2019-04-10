// document.querySelector( "form" )
// .addEventListener( "invalid", function( event ) {
//     event.preventDefault();
// }, true );

// $(document).ready(function() {
//   $('#area_select').multiple_select({
//     items: 1,
//     dependence: {
//       id_dependencia: "subareasCand",
//       items: 1
//     }
//   });
//  });


  // $('#fecha').DateTimePicker({
  //   dateFormat: "yyyy-MM-dd",
  //   shortDayNames: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
  //   shortMonthNames: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
  //   fullMonthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Deciembre"],
  //   titleContentDate: "Configurar fecha",
  //   titleContentTime: "Configurar tiempo",
  //   titleContentDateTime: "Configurar Fecha & Tiempo",
  //   setButtonContent: "Listo",
  //   clearButtonContent: "Limpiar"
  // });

// $('#provincia_of').change(function(){
//   var id_provincia = $('select[id=provincia_of]').val();
//   var puerto_host = $('#puerto_host').val();
//   if(id_provincia != ""){
//     $.ajax({
//       type: "GET",
//       url: puerto_host+"?mostrar=publicar&opcion=buscaCiudad&id_provincia="+id_provincia,
//       dataType:'json',
//       success:function(data){
//         $('#ciudad_of').html('<option value="">Selecciona una ciudad</option>');
//         $.each(data, function(index, value) {
//           $('#ciudad_of').append("<option value='"+value.id_ciudad+"'>"+value.ciudad+"</option>");
//         });
//       },
//       error: function (request, status, error) {
//         alert(request.responseText);
//       }                  
//     })
//   }
// });

// if(document.getElementById('descripcionOferta')){
  tinymce.init({ 
    selector:'textarea#descripcionOferta',
    style_formats: [
        {title: 'Headers', items: [
            {title: 'Header 1', format: 'h1'},
            {title: 'Header 2', format: 'h2'},
            {title: 'Header 3', format: 'h3'},
            {title: 'Header 4', format: 'h4'},
            {title: 'Header 5', format: 'h5'},
            {title: 'Header 6', format: 'h6'}
        ]},
        {title: 'Inline', items: [
            {title: 'Bold', icon: 'bold', format: 'bold'},
            {title: 'Italic', icon: 'italic', format: 'italic'},
            {title: 'Underline', icon: 'underline', format: 'underline'},
            {title: 'Strikethrough', icon: 'strikethrough', format: 'strikethrough'},
            {title: 'Superscript', icon: 'superscript', format: 'superscript'},
            {title: 'Subscript', icon: 'subscript', format: 'subscript'}
        ]},
        {title: 'Blocks', items: [
            {title: 'Paragraph', format: 'p'},
            {title: 'Blockquote', format: 'blockquote'}
        ]},
        {title: 'Alignment', items: [
            {title: 'Left', icon: 'alignleft', format: 'alignleft'},
            {title: 'Center', icon: 'aligncenter', format: 'aligncenter'},
            {title: 'Right', icon: 'alignright', format: 'alignright'},
            {title: 'Justify', icon: 'alignjustify', format: 'alignjustify'}
        ]}
    ],
    removed_menuitems: 'undo, redo',
    height : "128",
    resize: false,
    branding: false,
    elementpath: false,
    menubar:false,
    statusbar: false,
    language: 'es',
    setup: function (editor) {
        editor.on('blur', function () {
            // console.log(editor.getContent().replace(/<p>/g, "").replace(/<\/p>/g, "").replace(/&nbsp;/g, ""));
            contenido = editor.getContent().replace(/<p>/g, "").replace(/<\/p>/g, "").replace(/&nbsp;/g, "");
        	if(editor.getContent() == "" || !contenido.match(/\w/)){

        		colocaError(descripcion_error, descripcion_group, mensaje, button_register);
        	}
        	else{
        		quitarError(descripcion_error, descripcion_group);
        		enableBTN(1);
        	}
        });
    },
})



if($('#fechaCont').length){
    $('#fecha').DateTimePicker({
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

if($('#ciudadOf').length){
    $('#ciudadOf').attr('disabled', true);
}

if($('#provinciaOf').length){
    $('#provinciaOf').change(function(){
      var id_provincia = $('select[id=provinciaOf]').val();
      var puerto_host = $('#puerto_host').val();
      if(id_provincia != ""){
        $.ajax({
          type: "GET",
          url: puerto_host+"?mostrar=publicar&opcion=buscaCiudad&id_provincia="+id_provincia,
          dataType:'json',
          success:function(data){
            $('#ciudadOf').html('<option value="">Seleccione una ciudad</option>');
            $.each(data, function(index, value) {
              $('#ciudadOf').append("<option value='"+value.id_ciudad+"'>"+value.ciudad+"</option>");
            });
            $('#ciudadOf').attr('disabled', false);

          },
          error: function (request, status, error) {
            alert(request.responseText);
          }                  
        })
      }
    });
}

if($('#area_select').length){
  $('#area_select').multiple_select({
    items: 1,
    dependence: {
      id_dependencia: "subareasCand",
      items: 1
    }
  });
}
// }

// var mensaje = "";
// if(document.getElementById('boton')){
// 	var button_register = document.getElementById('boton').id;
// }

// // titulo
// if(document.getElementById('titu_of_error')){
// 	var titu_of_error = document.getElementById('titu_of_error').id;
// }

// if(document.getElementById('titu_of_group')){
// 	var titu_of_group = document.getElementById('titu_of_group').id;
// }
// // ----------------------------------------------------
// if(document.getElementById('descripcion_group')){
// 	var descripcion_group = document.getElementById('descripcion_group').id;
// }

// if(document.getElementById('descripcion_error')){
// 	var descripcion_error = document.getElementById('descripcion_error').id;
// }
// // ----------------------------------------------------
// if(document.getElementById('salario_group')){
// 	var salario_group = document.getElementById('salario_group').id;
// }

// if(document.getElementById('salario_error')){
// 	var salario_error = document.getElementById('salario_error').id;
// }
// // ----------------------------------------------------
// if(document.getElementById('vacante_group')){
// 	var vacante_group = document.getElementById('vacante_group').id;
// }

// if(document.getElementById('vacante_error')){
// 	var vacante_error = document.getElementById('vacante_error').id;
// }
// // ----------------------------------------------------
// if(document.getElementById('area_group')){
// 	var area_group = document.getElementById('area_group').id;
// }

// if(document.getElementById('area_error')){
// 	var area_error = document.getElementById('area_error').id;
// }
// // ----------------------------------------------------
// //if(document.getElementById('nivel_group')){
// //	var nivel_group = document.getElementById('nivel_group').id;
// //}

// //if(document.getElementById('nivel_error')){
// //	var nivel_error = document.getElementById('nivel_error').id;
// //}
// // ----------------------------------------------------
// if(document.getElementById('fecha_group')){
// 	var fecha_group = document.getElementById('fecha_group').id;
// }

// if(document.getElementById('fecha_error')){
// 	var fecha_error = document.getElementById('fecha_error').id;
// }
// // ----------------------------------------------------
// if(document.getElementById('listado_group')){
// 	var listado_group = document.getElementById('listado_group').id;
// }

// if(document.getElementById('listado_error')){
// 	var listado_error = document.getElementById('listado_error').id;
// }
// // ----------------------------------------------------
// if(document.getElementById('edad_min_group')){
// 	var edad_min_group = document.getElementById('edad_min_group').id;
// }

// if(document.getElementById('edad_min_error')){
// 	var edad_min_error = document.getElementById('edad_min_error').id;
// }
// // ----------------------------------------------------
// if(document.getElementById('edad_max_group')){
// 	var edad_max_group = document.getElementById('edad_max_group').id;
// }

// if(document.getElementById('edad_max_error')){
// 	var edad_max_error = document.getElementById('edad_max_error').id;
// }
// // ----------------------------------------------------

// if(document.getElementById('titu_of')){
// 	$('#titu_of').on('blur', function(){
// 		if(emptyContent(this) != false && this.value.match(/\w/)){
// 			if(this.value.length <= 100){
// 				quitarError(titu_of_error, titu_of_group);
// 			}
// 			else{
// 				mensaje = "Longitud máxima del campo 100 caracteres";
// 				colocaError(titu_of_error, titu_of_group, mensaje, button_register);
// 			}
// 		}
// 		else{
// 			mensaje = "Rellene este campo";
// 			colocaError(titu_of_error, titu_of_group, mensaje, button_register);
// 		}
//         console.log(this.value);
// 	});

// 	$('#titu_of').on('keydown', function(event){
// 		validar_keycode(this, "nombre_empresa", titu_of_error, titu_of_group, event, button_register, 100);
// 	})
// }

// if(document.getElementById('salario')){
// 	$('#salario').on('blur', function(){
// 		if(emptyContent(this) != false){
// 			if(validarFloat(this) != false){
// 				if(this.value > 0){
// 					quitarError(salario_error, salario_group);
// 					enableBTN(1);
// 				}
// 				else{
// 					mensaje = "Solo valores mayores a 1";
// 					colocaError(salario_error, salario_group, mensaje, button_register);
// 				}
// 			}
// 			else{
// 				mensaje = "Ajustese al formato solicitado";
// 				colocaError(salario_error, salario_group, mensaje, button_register);
// 			}
// 		}
// 		else{
// 			mensaje = "Rellene este campo";
// 			colocaError(salario_error, salario_group, mensaje, button_register);
// 		}
// 	});

// 	$('#salario').on('keydown', function(event){
// 		validar_keycode(this, "float", salario_error, salario_group, event, button_register, 10);
// 	})
// }

// if(document.getElementById('vacante')){
// 	var reg = //;
// 	$('#vacante').on('change', function(){
// 		if(emptyContent(this) != false){
// 			if(validarNumero(this) != false){
// 				if(this.value > 0){
// 					if(this.value.length > 0 && this.value.length < 4){
// 						quitarError(vacante_error, vacante_group);
// 						enableBTN(1);
// 					}
// 					else{
// 						mensaje = "Máximo 3 dígitos";
// 						colocaError(vacante_error, vacante_group, mensaje, button_register);
// 					}
// 				}
// 				else{
// 					mensaje = "Mínimo 1 vacante";
// 					colocaError(vacante_error, vacante_group, mensaje, button_register);
// 				}
// 			}
// 		}
// 		else{
// 			mensaje = "Rellene este campo";
// 			colocaError(vacante_error, vacante_group, mensaje, button_register);
// 		}
// 	});

// 	$('#vacante').on('keydown', function(event){
// 		// lockLength(vacante_error, vacante_group, this, 3, event, button_register);
// 		validar_keycode(this, "float", vacante_error, vacante_group, event, button_register, 3);
// 	});
// }

/*if(document.getElementById('fecha_contratacion')){
	var date = new Date();
    document.getElementById("fecha_contratacion").valueAsDate = date;
    var fecha_actual = fechaActual();

    $('#fecha_contratacion').on('change', function(){
    	if(fecha_actual > this.value){
    		mensaje = "La fecha debe ser mayor a la actual";
    		colocaError(fecha_error, fecha_group, mensaje, button_register);
    	}
    	else{
    		quitarError(fecha_error, fecha_group);
    		enableBTN(1);
    	}
    })
}*/

/*if(document.getElementById('nivel_interes')){
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
}*/

/*if(document.getElementById('area_select')){
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
}*/

// if(document.getElementById('edad_min')){
// 	$('#edad_min').on('blur', function(){
// 		var edad2 =  document.getElementById('edad_max');
// 		if(emptyContent(this) != false){
// 			if(this.value >= 18 && this.value <=100){
// 					if(this.value <= edad2.value && edad2.value != ""){
// 						quitarError(edad_min_error, edad_min_group);
// 					}
// 			}else{
// 				mensaje = "Mayor a 17 y menor 101";
// 				colocaError(edad_min_error, edad_min_group, mensaje, button_register);
// 			}
// 		}
// 		else{
// 			mensaje = "Rellene este campo";
// 			colocaError(edad_min_error, edad_min_group, mensaje, button_register);
// 		}
// 	});

// 	$('#edad_min').on('keydown', function(event){
// 		// lockLength(edad_min_error, edad_min_group, this, 3, event, button_register);
// 		validar_keycode(this, "telefono", edad_min_error, edad_min_group, event, button_register, 3);
		
// 	})
// }

// if(document.getElementById('edad_max')){
// 	$('#edad_max').on('blur', function(){
// 		var edad1 =  document.getElementById('edad_min');
// 		if(emptyContent(this) != false){
// 			if(this.value >= 18 && this.value <=100){
// 				if(this.value >= edad1.value && edad1.value != ""){
// 					quitarError(edad_min_error, edad_min_group);
// 				}
// 				else{
// 					mensaje = "Debe ser mayor a edad mínima";
// 					colocaError(edad_max_error, edad_max_group, mensaje, button_register);
// 				}
// 			}else{
// 				mensaje = mensaje = "Mayor a 17 y menor 101";
// 				colocaError(edad_max_error, edad_max_group, mensaje, button_register);
// 			}
// 		}
// 		else{
// 			mensaje = "Rellene este campo";
// 			colocaError(edad_max_error, edad_max_group, mensaje, button_register);
// 		}
// 	});

// 	$('#edad_max').on('keydown', function(event){
// 		// lockLength(edad_max_error, edad_max_group, this, 3, event, button_register);
// 		validar_keycode(this, "telefono", edad_max_error, edad_max_group, event, button_register, 3);
// 	})
// }

// Inicializando tinyMCE


// var select_one = 0;
// var select_two = 0;
// $('#idioma_of').on('change', function(){
// 	select_one = 1;
// 	if(select_one == 1 && select_two == 1){
// 		document.getElementById('effect_bounce').classList.add('bounce');
// 		document.getElementById('btn_transfer').classList.add('active_button');
// 	}
// });

// $('#nivel_idi_of').on('change', function(){
// 	select_two = 1;
// 	if(select_one == 1 && select_two == 1){
// 		document.getElementById('effect_bounce').classList.add('bounce');
// 		document.getElementById('btn_transfer').classList.add('active_button');
// 	}
// });

// function validarRangoEdad(obj1, obj2){
// 	if(obj1.value != "" && obj2.value != ""){
// 		if(obj1.value >=18 && obj2.value >= 18){
// 			if(obj1.value >= obj2.value){
// 				return true;
// 			}
// 			else{
// 				return false;
// 			}
// 		}
// 		else{
// 			return false;
// 		}
// 	}
// }

// function validarFloat(obj){
// 	var reg = /^[+-]?\d+(\.\d+)?$/i;
// 	if(reg.test(obj.value)){
// 		return true;
// 	}
// 	else{
// 		return false;
// 	}
// }

// function validarNumero(obj){
// 	var reg = /^[0-9]{1,100}$/;
// 	if(reg.test(obj.value)){
// 		return true;
// 	}
// 	else{
// 		return false;
// 	}
// }

// function emptyContent(obj){
// 	if(obj.value == ""){
// 		return false;
// 	}
// 	else{
// 		return true;
// 	}
// }
// 112 - 123
// function lockLength(error_mensaje, error_group, obj, longitud, event, button_register){
// 	var permitidas = [8, 9, 18, 27, 37, 38, 39, 40];
// 	var numeros = [48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105];
// 	for (var i = 112; i < 124; i++) {
// 	    permitidas.push(i);
// 	}
	
// 	if($.inArray(event.keyCode, numeros) !== -1 || $.inArray(event.keyCode, permitidas) !== -1){
// 		// event.preventDefault();
// 		if(obj.value.length < longitud){
// 			quitarError(error_mensaje, error_group);
// 			enableBTN();
// 		}
// 		else{
// 			if($.inArray(event.keyCode, permitidas) == -1){
// 				event.preventDefault();
// 				mensaje = longitud + " dígitos max.";
// 				colocaError(error_mensaje, error_group, mensaje, button_register);
// 			}
// 			else{
// 				quitarError(error_mensaje, error_group);
// 				enableBTN();
// 			}
// 		}
// 	}
// 	else{
// 		event.preventDefault();
// 		mensaje = "Solo dígitos";
// 		colocaError(error_mensaje, error_group, mensaje, button_register);
// 	}
// }

	$('#form_publicar').on('submit', function(event){        
		// if(enableBTN(2) == false){
			// cancelSubmit(event);
		// }
	})

// function campos(tipo){
// 	var errors = 0
// 	mensaje = "Rellene este  campo";
// 	if(document.getElementById('titu_of').value === ""){
// 		if(tipo ==2){colocaError(titu_of_error, titu_of_group, mensaje, button_register);}
// 		errors++;
// 	}

// 	var editorContent = tinyMCE.get('des_of').getContent();
// 	if (editorContent == '')
// 	{
// 	    if(tipo ==2){colocaError(descripcion_error, descripcion_group, mensaje, button_register);}
// 	 	errors++;
// 	}

// 	if(document.getElementById('salario').value == ""){
// 		if(tipo ==2){colocaError(salario_error, salario_group, mensaje, button_register);}
// 		errors++;
// 	}

// 	if(document.getElementById('vacante').value == ""){
// 		if(tipo ==2){colocaError(vacante_error, vacante_group, mensaje, button_register);}
// 		errors++;
// 	}

// 	mensaje = "Seleccione una opción";
// 	/*if(document.getElementById('area_select').value == ""){
// 		if(tipo ==2){colocaError(area_error, area_group, mensaje, button_register);}
// 		errors++;
// 	}*/

// 	if(document.getElementsByClassName('badge_item').length == 0){
// 		if(tipo ==2){colocaError(listado_error, listado_group, mensaje, button_register);}
// 		errors++;
// 	}

// 	/*if(document.getElementById('nivel_interes').value == ""){
// 		if(tipo ==2){colocaError(nivel_error, nivel_group, mensaje, button_register);}
// 		errors++;
// 	}*/

// 	mensaje = "Rellene este  campo";
// 	if(document.getElementById('fecha_contratacion').value == ""){
// 		if(tipo ==2){colocaError(fecha_error, fecha_group, mensaje, button_register);}
// 		errors++;
// 	}

// 	if(document.getElementById('edad_min').value == ""){
// 		if(tipo ==2){colocaError(edad_min_error, edad_min_group, mensaje, button_register);}
// 		errors++;
// 	}

// 	if(document.getElementById('edad_max').value == ""){
// 		if(tipo ==2){colocaError(edad_max_error, edad_max_group, mensaje, button_register);}
// 		errors++;
// 	}
// 	return errors; 
// }

// function enableBTN(tipo){
//     console.log(tipo);
// 	var flag = false;
// 	if(campos(tipo) == 0 && errorsVerify() != false){

// 		var btn = document.getElementById('boton');
// 		btn.classList.remove("disabled");
// 		btn.removeAttribute("disabled");
// 		flag = true;
// 	}
// 	return flag;
// }

// function errorsVerify(){
// 	var flag = false;
// 	var errors = document.getElementsByClassName("has-error");
// 	if(errors.length == 0){
// 		flag = true;
// 	}

// 	return flag;
// }

// function cancelSubmit(event){
// 	event.preventDefault();
// }

// $('#btn_transfer').on('click', function()
// {
//     var select_array_idioma = document.getElementById('select_array_idioma');
//     var options = "";
//     var tag_idioma = document.getElementById('idioma_of');
//     var tag_nivel_idioma = document.getElementById('nivel_idi_of');
//     var idioma_selected_select = tag_idioma.options[tag_idioma.selectedIndex];
//     var idiomanivel_selected_select = tag_nivel_idioma.options[tag_nivel_idioma.selectedIndex];

//     if(idioma_selected_select.text != 'Seleccione una opción' && idiomanivel_selected_select.text != 'Seleccione una opción'){
        
//         var selected_items = document.getElementsByClassName('listado');

//         var all_selected = $('#idioma_of option:disabled');
//         var error_show = document.getElementById('id_span_error');
//         var op = '';

//         if(tag_idioma.options[0].value == 0){
//             op = tag_idioma.length-1;
//         }else{
//             op = tag_idioma.length;           	
//         }

//         if (all_selected.length == op) {
// 	        mensaje = "Ha seleccionado todas las opciones disponibles";
// 	        colocaError(listado_error, listado_group, mensaje, button_register);
//         }
//         else{
//         	enableBTN();
//         	quitarError(listado_error, listado_group);
        	
        	
//         	document.getElementById('text_nothing').style.display = "none";
//         }
        
//         if (idioma_selected_select.disabled == false)
//         {
//             var id_idioma = tag_idioma.value;
//             var id_nivel_idioma = tag_nivel_idioma.value;
//             var div_idioma = document.getElementById('list_idioma');
//             var text_idioma = idioma_selected_select.text;
//             var text_idioma_nivel = idiomanivel_selected_select.text;
//             var p_node = document.createElement('P');
//             div_idioma.appendChild(p_node);
//             p_node.setAttribute("id", "idioma"+id_idioma);
//             p_node.innerHTML = text_idioma+" ("+text_idioma_nivel+") <i class='fa fa-window-close fa-2x icon' id='"+id_idioma+"' onclick='delete_item_selected(this);'></i>";
//             p_node.setAttribute("disabled", "disabled");
//             p_node.setAttribute("class", "col-md-5 badge_item listado");
//             idioma_selected_select.setAttribute("disabled", "disabled");
//             var nodo_option = document.createElement('option');
//             nodo_option.setAttribute("value", id_idioma+"_"+id_nivel_idioma);
//             nodo_option.setAttribute("id", "array_idioma"+id_idioma);
//             nodo_option.selected = "selected";
//             select_array_idioma.appendChild(nodo_option);
//             document.getElementById('effect_bounce').classList.remove('bounce');
//             document.getElementById('btn_transfer').classList.remove('active_button');
//             select_one = 0;
//             select_two = 1;
//         }

//         var all_selected = $('#idioma_of option:disabled');
//         if (all_selected.length == op) {
//             tag_nivel_idioma.setAttribute("disabled", true);
//             tag_idioma.setAttribute("disabled", true);
//         }
//         quitarError(listado_error, listado_group);
//     	enableBTN();
//     }
//     else{
//     	mensaje = "Seleccione una opción";
// 	   	colocaError(listado_error, listado_group, mensaje, button_register);
//     }
// })

// function delete_item_selected(selected_item){
//     var tag_idioma = document.getElementById('idioma_of');
//     var tag_nivel_idioma = document.getElementById('nivel_idi_of');
//     var tag_idioma_seleccionado = document.getElementById("idioma"+selected_item.id);
//     tag_idioma_seleccionado.outerHTML = "";
//     $("#idioma_of option[value="+selected_item.id+"]").attr("disabled",false);
//     var idioma_selected_select = document.getElementById('idioma_of');
//     var array_idioma_select = document.getElementById('select_array_idioma').length;
//     if (array_idioma_select >= 1) {
//             $("#select_array_idioma option[id='array_idioma"+selected_item.id+"']").remove();
//             tag_nivel_idioma.removeAttribute("disabled");
//             tag_idioma.removeAttribute("disabled");
//             if(selected_item.id == tag_idioma.options[tag_idioma.selectedIndex].value){
//             	document.getElementById('effect_bounce').classList.add('bounce');
//            		document.getElementById('btn_transfer').classList.add('active_button');
//             	select_one = 0;
//             }
//     }
// 	if (document.getElementById('select_array_idioma').length <= 0)
// 	{
// 		mensaje = "Seleccione una opcion";
// 	    colocaError(listado_error, listado_group, mensaje, button_register);
// 	    document.getElementById('text_nothing').style.display = "";
// 	}
// 	else{
// 		quitarError(listado_error, listado_group);
// 		enableBTN();
// 	} 
// }

// $('#urgente').on('change', function(){
// 	this.value = this.checked ? 1 : 0;
// 	var text = "No";
// 	var text_urg = document.getElementById('text_urg');
// 	if(this.checked === true){
// 		text = "Sí";
// 	}
// 	text_urg.innerHTML = text;
// })

/*function colocaError(campo, id, mensaje,btn){
    nodo = document.getElementById(campo);
    nodo.innerHTML = '';
    var elem1 = document.createElement('P');
    var t = document.createTextNode(mensaje); 
    elem1.appendChild(t);

    var elem2 = document.createElement("P");             
    elem2.classList.add('list-unstyled');
    elem2.classList.add('msg_error');
    elem2.appendChild(elem1); 

    elem2.appendChild(elem1); 
    nodo.appendChild(elem2); 

    $("#"+id).addClass('has-error');
    $("#"+btn).addClass('disabled');

    if(document.getElementById('form_paypal')){
      document.getElementById('form_paypal').action = '#';
    }
}

function quitarError(campo,id){
    document.getElementById(campo).innerHTML = '';
    $("#"+id).removeClass('has-error');
}*/
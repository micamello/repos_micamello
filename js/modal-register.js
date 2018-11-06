$('#form_register').on("submit", function(e){
	console.log(document.getElementsByClassName("list-unstyled msg_error").length);
	if(document.getElementsByClassName("list-unstyled msg_error").length > 0){
		document.getElementById("button_register").setAttribute("class","btn btn-info disabled");
		e.preventDefault();
	}
	else{
		document.getElementById("button_register").setAttribute("class", "btn btn-info");
	}
})

// $("#correo").on("blur", function(){
// 	if ($('#correo_error')) {
// 		var correo = document.getElementById("correo_error");
// 	}
// 	var puerto_host = $('#puerto_host').val();
// 	var correo_form = this.value;
// 	if (correo_form != "") {
// 		$.ajax({
//             type: "GET",
//             url: puerto_host+"?opcion=buscaCorreo&correo="+correo_form,
//     		dataType: 'json',
//             success:function(data){
//             	console.log("valor ajax 1:"+data.respcorreo);
// 				if(data.respcorreo != 1){
// 					console.log("valor ajax 2:"+data.respcorreo);
// 						crearMensajeError("correo_div_error", "El correo ingresado ya existe");
// 						correo.setAttribute("class", "form-group has-error has-danger");
// 				}
// 				else{
// 					// console.log(document.getElementById("correo_div_error").firstChild.innerHTML);
// 					// if(document.getElementById("correo_div_error").firstChild.innerHTML == "El correo ingresado ya existe"){
// 						eliminarMensajeError("correo_div_error");
// 						correo.setAttribute("class", "form-group");
// 					// }
// 				}
//             },
//             error: function (request, status, error) {
//                 alert(request.responseText);
//             }                  
//         })
// 	}
// })

// $("#dni").on("blur", function(){
// 	if ($('#dni_error')) {
// 		var dni = document.getElementById("dni_error");
// 	}
// 	var puerto_host = $('#puerto_host').val();
// 	var dni_form = this.value;
// 	if (dni_form != "") {
// 		$.ajax({
//             type: "GET",
//             url: puerto_host+"?opcion=buscaDni&dni="+dni_form,
//     		dataType: 'json',
//             success:function(data){
// 				if(data.respdni != 1){
// 					if(document.getElementById("error_custom_dni").innerHTML == ""){
// 						crearMensajeError("error_custom_dni", "El dni ingresado ya existe");
// 						dni.setAttribute("class", "form-group has-error has-danger");
// 					}
// 				}
// 				else{
// 					if(document.getElementById("error_custom_dni").firstChild.innerHTML == "El dni ingresado ya existe"){
// 						eliminarMensajeError("error_custom_dni");
// 						dni.setAttribute("class", "form-group");
// 					}
// 				}
//             },
//             error: function (request, status, error) {
//                 alert(request.responseText);
//             }                  
//         })
// 	}
// })




$("#documentacion").on("change", function(){
	var dni = document.getElementById("dni");
	var dni_text = document.getElementById("error_custom_dni");
	dni_text.innerHTML = "";
	dni.value = "";
	if(this.value != null || this.value != ""){
		dni.removeAttribute("disabled");
		if (this.value == 3) {
			dni.removeAttribute("onblur");
		}
		else{
			dni.setAttribute("onblur", "validarDocumento(this);");
		}
	}
})

function modal_set(id)
{
	if($('#documentacion')){
		var select_tipo_doc = document.getElementById("documentacion");
	}


	if($('#group_select_tipo_doc')){
		var tipo_doc = document.getElementById("group_select_tipo_doc");
	}

	if ($('#apellido_group')) {
		var apellido_group = document.getElementById("apellido_group");
		var area_select = document.getElementById("apell_user");
	}

	if ($('#dni_text')) {
		var dni_text = document.getElementById("dni_text");
	}

	if ($('#dni')) {
		var dni = document.getElementById("dni");
	}

	if ($('#area_group')) {
		var area_group = document.getElementById("area_group");
		var area_select = document.getElementById("area_select");
	}

	if ($('#nivel_group')) {
		var nivel_group = document.getElementById("nivel_group");
		var nivel_interes = document.getElementById("nivel_interes");
	}

	if ($('#nivel_group')) {
		var tipo_usuario = document.getElementById("tipo_usuario");
	}

	if ($('#group_nombre_contact')) {
		var group_nombre_contact = document.getElementById("group_nombre_contact");
		if ($('#nombre_contact')) {
			var nombre_contact = document.getElementById("nombre_contact");
		}
	}

	if ($('#group_apell_contact')) {
		var group_apell_contact = document.getElementById("group_apell_contact");
		if ($('#apellido_contact')) {
			var apellido_contact = document.getElementById("apellido_contact");
		}
	}

	if ($('#group_num1_contact')) {
		var group_num1_contact = document.getElementById("group_num1_contact");
		if ($('#tel_one_contact')) {
			var tel_one_contact = document.getElementById("tel_one_contact");
		}
	}

	if ($('#group_num2_contact')) {
		var group_num2_contact = document.getElementById("group_num2_contact");
		if ($('#tel_two_contact')) {
			var tel_two_contact = document.getElementById("tel_two_contact");
		}
	}

	if($('#contact_company_section')){
		var contact_company_section = document.getElementById("contact_company_section");
	}

	// if (('#correo_group')) {
	// 	var correo_group = document.getElementById("correo_group");
	// }

	if($('#name_user')){
		var name_user = document.getElementById("name_user");
	}

	if (id == null)
	{
		alert("Por favor recarge la página");
	}

	if (id == 1){
		apellido_group.style.display = "";
		apell_user.required = true;
		dni_text.innerHTML = "Cédula / Pasaporte&nbsp;<i class='requerido'>*</i>";
		area_group.style.display = "";
		area_select.required = true;
		nivel_group.style.display = "";
		nivel_interes.required = true;

		group_nombre_contact.style.display = "none";
		nombre_contact.required = false;

		group_apell_contact.style.display = "none";
		apellido_contact.required = false;

		group_num1_contact.style.display = "none";
		tel_one_contact.required = false;

		group_num2_contact.style.display = "none";

		contact_company_section.style.display = "none";

		dni.setAttribute("disabled", "true");	

		tipo_doc.style.display = "";

		select_tipo_doc.setAttribute("required", "true");



		// correo_group.className ="col-md-12";

		tipo_usuario.value = id;

		name_user.setAttribute("pattern", "[a-z A-ZñÑáéíóúÁÉÍÓÚ]+");

		dni.setAttribute("minlength", "");
		dni.setAttribute("maxlength", "");

		$("#myModal").modal("show");
	}

	if(id == 2){
		apellido_group.style.display = "none";
		apell_user.required = false;
		dni_text.innerHTML = "RUC&nbsp;<i class='requerido'>*</i>";
		area_group.style.display = "none";
		area_select.required = false;
		nivel_group.style.display = "none";
		nivel_interes.required = false;

		group_nombre_contact.style.display = "";
		nombre_contact.required = true;

		group_apell_contact.style.display = "";
		apellido_contact.required = true;

		group_num1_contact.style.display = "";
		tel_one_contact.required = true;

		group_num2_contact.style.display = "";

		contact_company_section.style.display = "";

		correo_group.className ="col-md-6";

		name_user.setAttribute("pattern", "[A-Za-z 0-9]+");

		dni.setAttribute("minlength", "13");
		dni.setAttribute("maxlength", "13");

		dni.removeAttribute("disabled");

		dni.setAttribute("onblur", "validarDocumento(this);");

		tipo_doc.style.display = "none";

		select_tipo_doc.removeAttribute("required");

		tipo_usuario.value = id;
		$("#myModal").modal("show");
	}

	var var_menu = document.getElementById('bs-example-navbar-collapse-1');
	var_menu.classList.remove('in');
}


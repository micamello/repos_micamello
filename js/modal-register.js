// $('#form_register').on("submit", function(e){
// 	// console.log(document.getElementsByClassName("list-unstyled msg_error").length);
// 	var correo_e = document.getElementById("correo_e");
// 	var dni_e = document.getElementById("dni_e");
// 	if(document.getElementsByClassName("list-unstyled msg_error").length > 0 || (correo_e.innerHTML != "" && dni_e.innerHTML != "")){
// 		document.getElementById("button_register").setAttribute("class","btn btn-info disabled");
// 		e.preventDefault();
// 	}
// });

function modal_set(id)
{

	if($('#social_reg')){
		var social_reg = document.getElementById("social_reg");
	}

	if($('#modal.size')){
		var modal_size = document.getElementById("modal-size");
	}

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

	if(document.getElementById('label_nombres')){
		var label_nombres = document.getElementById('label_nombres');
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
		modal_size.setAttribute("class", "modal-dialog modal-lg");

		social_reg.style.display = "";

		apellido_group.style.display = "";
		// apell_user.required = true;
		dni_text.innerHTML = "C&eacute;dula / Pasaporte&nbsp;<i class='requerido'>*</i>";
		area_group.style.display = "";
		// area_select.required = true;
		nivel_group.style.display = "";
		// nivel_interes.required = true;

		group_nombre_contact.style.display = "none";
		// nombre_contact.required = false;

		group_apell_contact.style.display = "none";
		// apellido_contact.required = false;

		group_num1_contact.style.display = "none";
		// tel_one_contact.required = false;

		group_num2_contact.style.display = "none";

		contact_company_section.style.display = "none";

		dni.setAttribute("disabled", "true");	

		tipo_doc.style.display = "";

		// select_tipo_doc.setAttribute("required", "true");

		label_nombres.innerHTML = "Nombres&nbsp;<i class='requerido'>*</i>";

		// correo_group.className ="col-md-12";

		tipo_usuario.value = id;

		name_user.setAttribute("pattern", "[a-z A-ZñÑáéíóúÁÉÍÓÚ]+");

		dni.setAttribute("minlength", "");
		dni.setAttribute("maxlength", "");

		$("#myModal").modal("show");
	}

	if(id == 2){

		modal_size.setAttribute("class", "modal-dialog");

		social_reg.style.display = "none";

		apellido_group.style.display = "none";
		// apell_user.required = false;
		dni_text.innerHTML = "RUC&nbsp;<i class='requerido'>*</i>";
		area_group.style.display = "none";
		// area_select.required = false;
		nivel_group.style.display = "none";
		// nivel_interes.required = false;

		group_nombre_contact.style.display = "";
		// nombre_contact.required = true;

		group_apell_contact.style.display = "";
		// apellido_contact.required = true;

		group_num1_contact.style.display = "";
		// tel_one_contact.required = true;

		group_num2_contact.style.display = "";

		contact_company_section.style.display = "";

		correo_group.className ="col-md-6";

		name_user.setAttribute("pattern", "[A-Za-z 0-9]+");

		dni.setAttribute("minlength", "13");
		dni.setAttribute("maxlength", "13");
		dni.setAttribute("pattern", "[0-9]{13,13}");

		dni.removeAttribute("disabled");

		// dni.setAttribute("onblur", "validarDocumento(this);");

		label_nombres.innerHTML = "Nombre Empresa&nbsp;<i class='requerido'>*</i>";

		tipo_doc.style.display = "none";

		// select_tipo_doc.removeAttribute("required");

		tipo_usuario.value = id;
		$("#myModal").modal("show");
	}

	var var_menu = document.getElementById('bs-example-navbar-collapse-1');
	var_menu.classList.remove('in');
}


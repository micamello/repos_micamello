function modal_set(id)
{
	if ($('#apellido_group')) {
		var apellido_group = document.getElementById("apellido_group");
		var area_select = document.getElementById("apell_user");
	}

	if ($('#dni_text')) {
		var dni_text = document.getElementById("dni_text");
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
		dni_text.innerHTML = "Cédula / Pasaporte:";
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

		correo_group.className ="col-md-12";

		tipo_usuario.value = id;

		name_user.setAttribute("pattern", "[a-z A-ZñÑáéíóúÁÉÍÓÚ]+");

		$("#myModal").modal("show");
	}

	if(id == 2){
		apellido_group.style.display = "none";
		apell_user.required = false;
		dni_text.innerHTML = "RUC";
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

		tipo_usuario.value = id;
		$("#myModal").modal("show");
	}

	var var_menu = document.getElementById('bs-example-navbar-collapse-1');
	var_menu.classList.remove('in');
}


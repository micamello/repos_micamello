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
		tipo_usuario.value = id;
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
		tipo_usuario.value = id;
		$("#myModal").modal("show");
	}

	var var_menu = document.getElementById('bs-example-navbar-collapse-1');
	var_menu.classList.remove('in');
}


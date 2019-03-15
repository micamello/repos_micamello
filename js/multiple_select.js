$.fn.multiple_select = function(){
	var objeto = $(this);
	avr listado_opciones = ""
	// console.log(objeto);
	objeto.css('display', 'none');
	var padre_objeto = objeto.prev();
	// console.log(padre_objeto[0]);
	var opciones = objeto[0].options;
	console.log(opciones);
	if(opciones.length != ""){
		listado_opciones = "eder";
	}
	else{
		listado_opciones = "No hay ninguna opción";
	}
	console.log(objeto);
	var panel = "<div class='panel panel-default'><div class='panel-heading'><input class='form-control'></div><div class='panel-body'>"+opciones.length+"</div></div>";
	padre_objeto.after(panel);	
}
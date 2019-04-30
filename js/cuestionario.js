// $(window).on('load',function(){
//   $('#msg_inforcuestionario').modal('show');
// });
// MÉTODO DE SELECCIÓN
if($('#metodoSeleccion').length){
	$('#metodoSeleccion').on('submit', function(event){
		// var modo_seleccion = $('[name="seleccion"]:checked').length;
		console.log($('[name="seleccion"]:checked').length);
		if($('[name="seleccion"]:checked').length > 0){
			
		}
		else{
			crearMensajeErrorBig(this, "Por favor, seleccione una opción para poder continuar con los test");
			event.preventDefault();
		}
	})
}

function crearMensajeErrorBig(obj, mensaje){
	var mensajeError = $(obj).parents().find('.error');
	mensajeError.html('<div class="alert alert-danger">'+mensaje+'</div>');
	// console.log(mensajeError);
}
function eliminarMensajeErrorBig(obj){
	var mensajeError = $(obj).parents().find('.error');
	mensajeError.html('');
}
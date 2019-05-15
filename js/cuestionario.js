$(document).ready(function(){
	// alert("eder");
	$('#msg_canea').modal('show');
})
// MÉTODO DE SELECCIÓN
if($('#metodoSeleccion').length){
	$('#metodoSeleccion').on('submit', function(event){

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
	// var mensajeError = $(obj).parents().find('.error');
	// mensajeError.html('<div class="alert alert-danger">'+mensaje+'</div>');
	// console.log(mensajeError);
	swal('Advertencia!', 'Seleccione un método', 'error');
}
// function eliminarMensajeErrorBig(obj){
// 	var mensajeError = $(obj).parents().find('.error');
// 	mensajeError.html('');
// }
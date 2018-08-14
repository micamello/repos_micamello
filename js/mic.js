// Ocultar menú si aparecen los modales
function hidden_menuuser_small()
{
	var var_menu = document.getElementById('bs-example-navbar-collapse-1');
	var_menu.classList.remove('in');
}

// Validación de formulario

//$("#form_candidato").validator();

// Validación de formulario

// Validación de cédula campo DNI formulario

//$("#dni").validarCedulaEC();

// Validación de cédula campo DNI formulario



//---------------------- Validación de nputs solo texto-------------------------//
// $(document).ready(function(){
 //    function isNumberKey(){
	//     var textInput = document.getElementById("telefono_cand").value;
	//     textInput = textInput.replace(/[^0-9]/g, "");
	//     document.getElementById("telefono_cand").value = textInput;
	// }
// });

// $(document).on('keypress', '#id', function (event) {
//     var regex = new RegExp("^[a-zA-Z ]+$");
//     var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
//     if (!regex.test(key)) {
//         event.preventDefault();
//         return false;
//     }
// });

// document.getElementById('inputid').onkeypress=function(e){
//     if(("abcdefghijklmnopqrstuvwxyz ").indexOf(String.fromCharCode(e.keyCode))===-1){
//         e.preventDefault();
//         return false;
//     }
// }



// name_user
// apell_user

//---------------------- Validación de nputs solo texto-------------------------//


//---------------------- Validación de inputs solo números-------------------------//
$('#select_area').selectr({
  placeholder:'Buscar'
});


$('#select_nivel').selectr({
  placeholder:'Buscar'
});

/*var x = document.getElementById('telefono_cand');

x.addEventListener('keydown',function(e) {

  var code = e.which || e.keyCode,
  allowedKeys = [8, 9, 13, 27, 35,36,37,38,39,46,110, 190];
  
  if(allowedKeys.indexOf(code) > -1) {
    return;
  }
  
  if((e.shiftKey || (code < 48 || code > 57)) && (code < 96 || code > 105)) {
    e.preventDefault();
  }

});*/

//---------------------- Validación de inputs solo números-------------------------//

// Validación de nombres de usuarios

  // function valitidy_username(val)
  // {
    
  // }

// Validación de nombres de usuarios



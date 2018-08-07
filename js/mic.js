// Ocultar menú si aparecen los modales
function hidden_menuuser_small()
{
	var var_menu = document.getElementById('bs-example-navbar-collapse-1');
	var_menu.classList.remove('in');
}

$("#form_candidato").validator();

//---------------------- Validación de nputs solo texto-------------------------//
// $(document).ready(function(){
 //    function isNumberKey(){
	//     var textInput = document.getElementById("telefono_cand").value;
	//     textInput = textInput.replace(/[^0-9]/g, "");
	//     document.getElementById("telefono_cand").value = textInput;
	// }
// });

$(document).on('keypress', '#username', function (event) {
    var regex = new RegExp("^[a-zA-Z ]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
});


//---------------------- Validación de nputs solo texto-------------------------//


//---------------------- Validación de nputs solo números-------------------------//

var x = document.getElementById('telefono_cand');

x.addEventListener('keydown',function(e) {

  var code = e.which || e.keyCode,
  allowedKeys = [8, 9, 13, 27, 35,36,37,38,39,46,110, 190];
  
  if(allowedKeys.indexOf(code) > -1) {
    return;
  }
  
  if((e.shiftKey || (code < 48 || code > 57)) && (code < 96 || code > 105)) {
    e.preventDefault();
  }

});

//---------------------- Validación de nputs solo números-------------------------//
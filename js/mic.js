// Ocultar menú si aparecen los modales
function hidden_menuuser_small()
{
	var var_menu = document.getElementById('bs-example-navbar-collapse-1');
	var_menu.classList.remove('in');
}
// Ocultar menú si aparecen los modales





// Validación de formulario - Inicialización

// -------------CANDIDATO--------------
$("#form_candidato").validator();
// ------------EMPRESA-------------------
$("#form_empresa").validator();

// Validación de formulario








// Validación de cédula campo DNI formulario

$("#dni").validarCedulaEC();

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

function numero_validate(id)
{
  var input_number = id;
  var nodo_padre = document.getElementById(input_number.id).parentNode;
  var nodo_div = nodo_padre.querySelectorAll('div');
  // alert(input_number.id);
  
  // alert(text_show.id);
  
  input_number.addEventListener('keydown',function(e) {
    
    var code = e.which || e.keyCode,
    allowedKeys = [8, 9, 13, 27, 35,36,37,38,39,46,110, 190];
    
    if(allowedKeys.indexOf(code) > -1) {
      return;
    }
    
    if((e.shiftKey || (code < 48 || code > 57)) && (code < 96 || code > 105)) {
      e.preventDefault();
      nodo_div[0].innerHTML = "El campo solo acepta números";
      nodo_div[0].style.color = "red";
      input_number.style.borderColor = "red";
    }
    else
    {
      nodo_div[0].innerHTML = "";
      input_number.style.borderColor = "";
    }
    // Hidden modal
      $('.modal').on('hidden.bs.modal', function(){
          nodo_div[0].innerHTML = "";
          input_number.style.borderColor = "";

      });
    // Hidden modal

  })
}

//---------------------- Validación de inputs solo números-------------------------//


// ---------------------------------Validación de contraseña-------------------------------//

// ---------------------------------Validación de contraseña-------------------------------//

// Validación de nombres de usuarios

  // function valitidy_username(val)
  // {
    
  // }

// Validación de nombres de usuarios

// Reset de estilos erroneos del modal cuando se ocultan
$('.modal').on('hidden.bs.modal', function(){
    var $form = $(this);
    // $form.find('.with-errors').css('border-color', 'blue').removeClass('error');
    // $('.with-errors').removeClass('help-block');
    // $('.with-errors').removeClass('help-block');
    $(this).find('form')[0].reset();
});
// Reset de estilos erroneos del modal cuando se oculta


// Testing multiselect

// var expanded = false;

// function showCheckboxes(id) {
//   var checkboxes = document.getElementById("checkboxes"+id);
//   // alert("checkboxes"+id);
//   if (!expanded) {
//     checkboxes.style.display = "block";
//     expanded = true;
//   } else {
//     checkboxes.style.display = "none";
//     expanded = false;
//   }
// }



$('#area_select').change(function() {
            console.log($(this).val());
        }).multipleSelect({
            width: '100%'
        });

$('#nivel_interes').change(function() {
            console.log($(this).val());
        }).multipleSelect({
            width: '100%'
        });
    
// Testing multiselect


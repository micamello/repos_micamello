$("#form_empresa").validator();

if(document.getElementById('form_register')){
  $("#form_register").validator();
}

if(document.getElementById('form_editarPerfil')){
  $("#form_editarPerfil").validator();
}

// function numero_validate(id)
// {
//   var cel_error = document.getElementById("error_custom_cel");
//   // alert("Eder");
//   var input_number = id;
//   var nodo_padre = document.getElementById(input_number.id).parentNode;
//   // alert(input_number.id);
//   var nodo_div = nodo_padre.querySelectorAll('div');
//   // alert(input_number.id);
  
//   // alert(text_show.id);
  
//   input_number.addEventListener('keydown',function(e) {
//     // alert("Eder");
//     var code = e.which || e.keyCode,
//     allowedKeys = [8, 9, 13, 27, 35,36,37,38,39,46,110, 190];
    
//     if(allowedKeys.indexOf(code) > -1) {
//       return;
//     }
    
//     if((e.shiftKey || (code < 48 || code > 57)) && (code < 96 || code > 105)) {
//       e.preventDefault();

//         while (cel_error.hasChildNodes()) {
//           cel_error.removeChild(cel_error.lastChild);
//         }
//         var p1 = document.createElement("P");
//         p1.setAttribute("class", "list-unstyled msg_error");
//         p1.setAttribute("id", "p_text_cel");
//         var text_node = document.createTextNode("El campos solo acepta números");
//         p1.appendChild(text_node);
//         cel_error.appendChild(p1);
//     }
//     else
//     {
//         while (cel_error.hasChildNodes()) {
//           cel_error.removeChild(cel_error.firstChild);
//         }
//     }
//       $('.modal').on('hidden.bs.modal', function(){
//           nodo_div[0].innerHTML = "";
//           input_number.style.borderColor = "";

//       });

//   })
// }

function isNumber(evt) {
  var cel_error = document.getElementById("error_custom_cel");
        evt = (evt) ? evt : window.event;
        // evt.preventDefault();
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if ( (charCode > 31 && charCode < 48) || charCode > 57) {evt.preventDefault();

        while (cel_error.hasChildNodes()) {
          cel_error.removeChild(cel_error.lastChild);
        }
        var p1 = document.createElement("P");
        p1.setAttribute("class", "list-unstyled msg_error");
        p1.setAttribute("id", "p_text_cel");
        var text_node = document.createTextNode("El campos solo acepta números");
        p1.appendChild(text_node);
        cel_error.appendChild(p1);
            return false;
        }
        while (cel_error.hasChildNodes()) {
          cel_error.removeChild(cel_error.firstChild);
        }
        $('.modal').on('hidden.bs.modal', function(){
          // nodo_div[0].innerHTML = "";
          // input_number.style.borderColor = "";

      });

        return true;
    }

$('.modal').on('hidden.bs.modal', function(){
    var $form = $(this);
    var dni_error = document.getElementById("error_custom_dni");
        while (dni_error.hasChildNodes()) {
          dni_error.removeChild(dni_error.firstChild);
        }

    $(this).find('form')[0].reset();
});

if (document.getElementById("area_select"))
{
  $("#area_select").selectr({
                placeholder: 'Buscar...'
            });
}

if (document.getElementById("nivel_interes"))
{
  $("#nivel_interes").selectr({
                placeholder: 'Buscar...'
            });
}
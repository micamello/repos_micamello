// Ocultar menú si aparecen los modales
function hidden_menuuser_small()
{
	var var_menu = document.getElementById('bs-example-navbar-collapse-1');
	var_menu.classList.remove('in');
}


$("#form_candidato").validator();
$("#form_empresa").validator();


$("#dni").validarCedulaEC();

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

$('.modal').on('hidden.bs.modal', function(){
    var $form = $(this);
    // $form.find('.with-errors').css('border-color', 'blue').removeClass('error');
    // $('.with-errors').removeClass('help-block');
    // $('.with-errors').removeClass('help-block');
    $(this).find('form')[0].reset();
});

$("#area_select").selectr({
                placeholder: 'Buscar...'
            });
$("#nivel_interes").selectr({
                placeholder: 'Buscar...'
            });

$('#select_area').selectr({
  placeholder:'Buscar'
});

$('#select_nivel').selectr({
  placeholder:'Buscar'
});





if(document.getElementById('form_register')){
  $("#form_register").validator();
}

function numero_validate(id)
{
  var input_number = id;
  var nodo_padre = document.getElementById(input_number.id).parentNode;
  var nodo_div = nodo_padre.querySelectorAll('div');
  
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
      nodo_div[0].style.position = "absolute";
      input_number.style.borderColor = "red";
      input_number.style.borderColor = ""
    }
    else
    {
      nodo_div[0].innerHTML = "";
      input_number.style.borderColor = "";
    }
      $('.modal').on('hidden.bs.modal', function(){
          nodo_div[0].innerHTML = "";
          input_number.style.borderColor = "";

      });

  })
}

if(document.getElementById('form_editarPerfil')){
  $("#form_editarPerfil").validator();
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

if(document.getElementById('form_login')){
  $("#form_login").validator();
}

if(document.getElementById('form_contrasena')){
  $("#form_contrasena").validator();
}

if(document.getElementById('form_deposito')){
  $("#form_deposito").validator();
}

if(document.getElementById('form_recomendaciones')){
  $("#form_recomendaciones").validator();
}


$('.carousel[data-type="multi"] .item').each(function(){

  var next = $(this).next();
  if (!next.length) {
    next = $(this).siblings(':first');
  }
  next.children(':first-child').clone().appendTo($(this));
  
  for (var i=0;i<4;i++) {

    next=next.next();
    if (!next.length) {
        next = $(this).siblings(':first');
    }
    
    next.children(':first-child').clone().appendTo($(this));
  }
});


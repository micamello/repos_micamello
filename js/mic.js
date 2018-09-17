if(document.getElementById('form_register')){
  $("#form_register").validator();
}

if(document.getElementById('form_login')){
  $("#form_login").validator();
}

if(document.getElementById('form_publicar')){
  $("#form_publicar").validator();
}

function valida_numeros(evt){
    if(window.event){
      keynum = evt.keyCode; 
     }
     else{
      keynum = evt.which; 
     } 
     if((keynum > 47 && keynum < 58) || keynum == 8 
    || keynum == 9 || keynum == 13 || keynum == 116 
    || (keynum > 36 && keynum < 41) 
    || (keynum > 95 && keynum < 106)){
      return true;
     }
     else{
      return false;
     }
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


if(document.getElementById('form_paypal')){
  $("#form_paypal").validator();
}

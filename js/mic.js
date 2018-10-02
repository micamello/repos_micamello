if(document.getElementById('form_register')){
  $("#form_register").validator();
}

if(document.getElementById('form_login')){
  $("#form_login").validator();
}

if(document.getElementById('form_publicar')){
  $("#form_publicar").validator();
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

function pass_reveal(obj){
  var input_reveal = obj.nextElementSibling;
  input_reveal.setAttribute("type", "text");
  obj.firstChild.setAttribute("class", "fa fa-eye-slash");
  obj.setAttribute("onclick", "pass_hidden(this)");
}

function pass_hidden(obj){
  var input_reveal = obj.nextElementSibling;
  input_reveal.setAttribute("type", "password");
  obj.firstChild.setAttribute("class", "fa fa-eye");
  obj.setAttribute("onclick", "pass_reveal(this)");
}


if(document.getElementById("term_cond")){
  $("#term_cond").on("change", function(){
    if (document.getElementById("term_cond").checked) {
      document.getElementById("conf_datos").checked = true;
    }
    else{
      document.getElementById("conf_datos").checked = false;
    }
  })
}

if(document.getElementById("conf_datos")){
  $("#conf_datos").on("change", function(){
    if (document.getElementById("conf_datos").checked) {
      document.getElementById("term_cond").checked = true;
    }
    else{
      document.getElementById("term_cond").checked = false;
    }
  })
}

function crearMensajeError($id_div_error, $mensaje_error){
    var nodo_div = document.getElementById($id_div_error);
    var p_node = document.createElement("P");
    p_node.setAttribute("class", "list-unstyled msg_error");
     p_node.setAttribute("id", "p_node_error");
    var p_text = document.createTextNode($mensaje_error);
    p_node.appendChild(p_text);
    nodo_div.appendChild(p_node);
}

function eliminarMensajeError($id_div_error){
    var nodo_div = document.getElementById($id_div_error);
    nodo_div.innerHTML = "";
}

if (document.getElementById("dni")) {
  var host = window.location.hostname;
  $("#dni").on("blur", function(){
    //if (host == 'localhost') {
      validarDocumento(this);
    //}
  })
}

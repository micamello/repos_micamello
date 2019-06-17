var puerto_host = $('#puerto_host').val();
$('body').css('overflow', 'hidden');
function navegador(){
  var agente = window.navigator.userAgent;
  var navegadores = ["Chrome", "Firefox", "Safari", "Opera", "MSIE", "Trident", "Edge"];
  for(var i in navegadores){
      if(agente.indexOf( navegadores[i]) != -1 ){
          return navegadores[i];
      }
  }
}

// $(window).on('resize', function(){
//   console.log($(window).width());
// });
// $('form').on("submit", function (e) {
//   $('.loaderMic').css('display', 'block');
// });

// $(document).ajaxStart(function(){
//   $('.spin').open({ 
//       image: puerto_host+'/imagenes/loader.gif',
//       // color: 'red',
//     });
// });

// $(document).ajaxStop(function(){
//   $('.spin').close();
// });



function redireccionar(ruta){
  console.log(ruta);
  abrirModal('Debe contratar un plan que permita buscar candidatos','alert_descarga',ruta,'Ok','');
}

function colocaError(campo, id, mensaje,btn){

  nodo = document.getElementById(campo);
  nodo.innerHTML = '';
  var elem1 = document.createElement('P');
  var t = document.createTextNode(mensaje); 
  elem1.appendChild(t);

  var elem2 = document.createElement("P");             
  elem2.classList.add('list-unstyled');
  elem2.classList.add('msg_error');
  //elem2.classList.add('ahashakeheartache');
  
  elem2.appendChild(elem1); 
  nodo.appendChild(elem2); 

  $("#"+id).addClass('has-error');

  if(document.getElementById('form_paypal')){
    document.getElementById('form_paypal').action = '#';
  }
}

function quitarError(campo,id){
    document.getElementById(campo).innerHTML = '';
    $("#"+id).removeClass('has-error');
}



"use strict";
jQuery(document).ready(function ($) {

  if($('#blockRightClick').length){
    $("body").on("contextmenu",function(e){
     return false;
   });
  }
  // console.log();
  if(window.location.pathname.split("/")[3] != "exito"){
    $('body').css('overflow', 'auto');
    $('.loaderMic').delay('500').fadeOut( "fast");
  }
  eventos();
    // bannerTel();
//for Preloader

    //$(window).load(function () {
    //    $("#loading").fadeOut(500);
    //});


    /*---------------------------------------------*
     * Mobile menu
     ---------------------------------------------*/
    $('#navbar-menu').find('a[href*=#]:not([href=#])').click(function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: (target.offset().top - 80)
                }, 1000);
                if ($('.navbar-toggle').css('display') != 'none') {
                    $(this).parents('.container').find(".navbar-toggle").trigger("click");
                }
                return false;
            }
        }
    });


    $('.scrollup').click(function () {
        $("html, body").animate({scrollTop: 0}, 1000);
        return false;
    });

    //End

});

function eventos(){
  if($('.noautofill').length){
    var variables = $('.noautofill');
    $.each(variables, function(indice, obj){
      $(obj).attr('readonly', 'readonly');
      $(obj).css('background-color', '#FFFFFF');
    });
    variables.on('focus blur', function(event){
      if(event.type == "focus"){
        $(this).removeAttr('readonly');
      }
      if(event.type == "blur"){
        $(this).attr('readonly', 'readonly');
      }
    });
  }
}

function abrirModal(mensaje,id,enlace,btn,titulo){

    $('#mensaje').html(mensaje);

    if(btn != 'Ok' && btn != ''){

      $('#'+btn).html('Aceptar');
      document.getElementById('btn_cancelar').style.display = 'inline-block';      
      document.getElementById(btn).setAttribute('href', enlace);
    }else{ 

      if(btn == ''){
        document.getElementById('btn_cancelar').style.display = 'none';
      }
      $('#btn_modal').html('Aceptar');

      if($('#titulo_noti')){
        $('#titulo_noti').html('<b>'+titulo+'</b>');
      }
      document.getElementById('btn_modal').setAttribute('href', enlace);
    }

    $('#'+id).modal();
}

function validaDecimales(evt,input){
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;    
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filter(tempValue)=== false){
            return false;
        }else{       
            return true;
        }
    }else{
          if(key == 8 || key == 13 || key == 0) {     
              return true;              
          }else if(key == 46){
                if(filter(tempValue)=== false){
                    return false;
                }else{       
                    return true;
                }
          }else{
              return false;
          }
    }
}

function filter(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
    if(preg.test(__val__) === true){
        return true;
    }else{
       return false;
    }
    
}

function validaNumeros(evt){
     var keynum = window.Event ? evt.which : evt.keycode;    
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


function validar_keycode(obj, tipo_keydown, error_mensaje, error_group, event, button_register, longitud){
        var mensaje = "";
        var permitidas = [8, 9, 18, 20, 27, 37, 38, 39, 40];
        for (var i = 112; i < 124; i++) {
            permitidas.push(i);
        }

        var numeros = [48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105,];
        if(tipo_keydown == "telefono"){
            var keycode = numeros;
            mensaje = "El campo solo acepta números";
        }

        if(tipo_keydown == "nombre_apellido"){
            var keycode = [32, 192];
            for (var i = 65; i < 91; i++) {
                keycode.push(i);
            }
            mensaje = "El campo solo acepta letras";
        }

        if(tipo_keydown == "pasaporte"){
            var keycode = numeros;
            for (var i = 65; i < 91; i++) {
                keycode.push(i);
            }
            mensaje = "El campo solo acepta valores alfanuméricos";
        }

        if(tipo_keydown == "nombre_empresa"){
            var keycode = numeros;
            for (var i = 65; i < 91; i++) {
                keycode.push(i);
            }
            keycode.push(32);
            keycode.push(192);
            keycode.push(110);
            keycode.push(190);
            mensaje = "Solo acepta valores alfanuméricos y espacios";
        }

        if(tipo_keydown == "float"){
            keycode = numeros;
            keycode.push(190, 110);
            mensaje = "Ajustese al formato indicado";
        }

        if($.inArray(event.keyCode, keycode) !== -1 || $.inArray(event.keyCode, permitidas) !== -1){
            // console.log(keycode);
          if(longitud != -1){
            if(obj.value.length < longitud){
              quitarError(error_mensaje, error_group);
              enableBTN(1);
            }
            else{
              if($.inArray(event.keyCode, permitidas) == -1){
                event.preventDefault();
                mensaje = longitud + " caracteres max.";
                colocaError(error_mensaje, error_group, mensaje, button_register);
              }
              else{
                quitarError(error_mensaje, error_group);
                enableBTN(1);
              }
            }
          }
        }
        else{
            event.preventDefault();
            colocaError(error_mensaje, error_group, mensaje, button_register);
        }

    }

function fechaActual() {
    var d = new Date(),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}

function getBrowserSize(){
       var w, h;

         if(typeof window.innerWidth != 'undefined')
         {
          w = window.innerWidth; //other browsers
          h = window.innerHeight;
         } 
         else if(typeof document.documentElement != 'undefined' && typeof      document.documentElement.clientWidth != 'undefined' && document.documentElement.clientWidth != 0) 
         {
          w =  document.documentElement.clientWidth; //IE
          h = document.documentElement.clientHeight;
         }
         else{
          w = document.body.clientWidth; //IE
          h = document.body.clientHeight;
         }
       return {'width':w, 'height': h};
}

function imprimir(nombreDiv) {
    document.getElementById('boton_imprimir').style.display = 'none';
    var printContents = document.getElementById(nombreDiv).innerHTML;
    var document_html = window.open();
    document_html.document.write( "<html><head><title></title>" );
    document_html.document.write( "<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" type=\"text/css\"/>" );
    document_html.document.write( "<link rel=\"stylesheet\" href=\"https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css\" type=\"text/css\"/>" );
    document_html.document.write( "<link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css\" type=\"text/css\"/>" );
    document_html.document.write( "<style>.perfil_photo_user {display: block;margin: -10px 0px 5px 0px;margin-left: auto;margin-right: auto; height: 250px;width: 250px;border-radius: 50%;border: 5px solid white;background: #22242a;box-shadow: 0 1.5px 4px rgba(0, 0, 0, 0.24), 0 1.5px 6px rgba(0, 0, 0, 0.12);}.profilebox {position: relative;background-color: #CEECFD;min-height: 230px;width: 100%;border-radius: 8px;padding: 50px 20px 20px 15px;box-shadow: 0 6px 12px rgba(0, 0, 0, 0.23), 0 10px 40px rgba(0, 0, 0, 0.19);display: flex;flex-direction: column;margin-bottom: 20px;}.box_text{background-color: #F4F4F4;border-radius: 30px;margin: 5px 1px 5px 1px;overflow: hidden; }</style>" );
    document_html.document.write( "</head><body>" );
    document_html.document.write( printContents );
    document_html.document.write( "</body></html>" );
    setTimeout(function () {
      document_html.print();
      document.getElementById('boton_imprimir').style.display = '';
    }, 100)
  }

function validarUsuario(username){

  if(username == null || username.length == 0 || /^\s+$/.test(username)){
    colocaError("err_username","seccion_username","El campo no puede ser vac\u00EDo","btn_sesion");
  }else if(username.length > '50'){
    colocaError("err_username","seccion_username","Usuario no debe exceder a 50 caracteres","btn_sesion");
  }else if(username.length < '4'){
    colocaError("err_username","seccion_username","Minimo de caracteres es de 4","btn_sesion");
  }else{
    quitarError("err_username","seccion_username");
  }
}

function validarClave(){

  var password = document.getElementById('password1').value;

  if(password == null || password.length == 0 || /^\s+$/.test(password)){
    colocaError("err_password","seccion_password","El campo no puede ser vac\u00EDo","btn_sesion");
  }else if(password.length > '15'){
    colocaError("err_password","seccion_password","Clave no debe exceder a 15 caracteres","btn_sesion");
  }else if(password.length < '8'){
    colocaError("err_password","seccion_password","M\u00EDnimo de caracteres es 8","btn_sesion");
  }else{
    quitarError("err_password","seccion_password");
  }
}

function validarClavesRecuperar(){

    var expreg = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    var err_campo = "El campo no puede ser vac\u00EDo";
    var err_formato = "Letras y n\u00FAmeros, m\u00EDnimo 8 caracteres";
    var password = document.getElementById('password1').value;
    var password_two = document.getElementById('password2').value;

    if(password == null || password.length == 0 || /^\s+$/.test(password)){
      colocaError("err_clave", "seccion_clave",err_campo,"recuperar");
    }else if(!expreg.test(password)){
      colocaError("err_clave", "seccion_clave",err_formato,"recuperar");   
    }else{
      quitarError("err_clave", "seccion_clave");
    }
    if(password_two == null || password_two.length == 0 || /^\s+$/.test(password_two)){
      colocaError("err_clave1", "seccion_clave1",err_campo,"recuperar");
    }else if(!expreg.test(password_two)){
      colocaError("err_clave1", "seccion_clave1",err_formato,"recuperar");  
    }else{
      if(password != password_two){
        colocaError("err_clave1", "seccion_clave1","Ingrese la misma contrase\u00F1a","recuperar"); 
      }else{
        quitarError("err_clave1", "seccion_clave1");
      }
    }
}

function validarCorreo(correo,err_correo,seccion_correo,btn){

  var error = 0;
  var expreg_correo = /^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/;
  if(correo == null || correo.length == 0 || /^\s+$/.test(correo)){
    colocaError(err_correo, seccion_correo,"El campo no puede ser vac\u00EDo",btn);
    error = 1;
  }else if(!expreg_correo.test(correo)){
    colocaError(err_correo,seccion_correo,"Formato incorrecto, no es un correo v\u00E1lido",btn); 
    error = 1;
  }else{
    quitarError(err_correo,seccion_correo);
  }
  return error;
}

$('#btn_sesion').click(function () {
  if (!$('#btn_sesion').hasClass("disabled")){
    $('.loaderMic').css('display', 'block');
    document.form_login.submit();
  }      
});

$("#password1").keypress(function(e) {
  if(e.which == 13) {
    if (!$('#btn_sesion').hasClass("disabled")){
      $('.loaderMic').css('display', 'block');
      document.form_login.submit();
    }   
  }
});

$('#recomendaciones').click(function () {
  if (!$('#recomendaciones').hasClass("disabled")){
    $('.loaderMic').css('display', 'block');
    $('#form_recomendaciones').submit();    
  }      
});

$('#recuperar').click(function () {
  if (!$('#recuperar').hasClass("disabled")){
    $('.loaderMic').css('display', 'block');
    $('#form_contrasena').submit();    
  }      
});

function validaForm(tipo,btn){

  //tipo de formulario a evaluar 1 es login y 2 recuperar contraseña
  if(tipo == 1){
    var username = document.getElementById('username').value;
    validarUsuario(username);
    validarClave();
    validaCampos(1,btn);    
  }

  if(tipo == 2){
    if(document.getElementById('password1')){
      validarClavesRecuperar();
    }else{
      var correo = document.getElementById('correo1').value;
      validarCorreo(correo,"err_correo","seccion_correo",btn);
    }
    validaCampos(2,btn);
  }

  if(tipo == 3){
    var nombres = document.getElementById('nombres').value;
    var correo = document.getElementById('correo1').value;
    var descripcion = document.getElementById('descripcion').value;
    var telefono = document.getElementById('telefono').value;    
    validarInput(nombres,"err_nombres","seccion_nombres",btn);
    validarCorreo(correo,"err_correo","seccion_correo",btn);
    validarDir(descripcion,"err_descripcion", "seccion_descripcion",btn);
    validarNumTelf(telefono,"err_telefono","seccion_telefono",btn);
    validaCampos(3,btn);
  }
}

function validarDineroFormPlanes(num,err_val,seccion_val,btn){
  var expreg_telf = /^[0-9]{2,5}$/;
  var error = 0;
    if(num == null || num.length == 0 || /^\s+$/.test(num)){
      colocaError(err_val,seccion_val,"El campo no puede ser vac\u00EDo",btn);
      error = 1;
    }else if(!expreg_telf.test(num)){
        colocaError(err_val,seccion_val,"Formato incorrecto, solo numeros",btn);
        error = 1;
    }else{
        quitarError(err_val,seccion_val);
    }
    return error;
}

function validarNumTelf(num,err_telf,seccion_telf,btn){

  var expreg_telf = /^[0-9]{9,15}$/;
  var error = 0;

  if(num == null || num.length == 0 || /^\s+$/.test(num)){

      colocaError(err_telf,seccion_telf,"El campo no puede ser vac\u00EDo",btn);
      error = 1;

  }else if(!expreg_telf.test(num)){
      colocaError(err_telf,seccion_telf,"Solo numeros (min 9, máx 15)",btn);
      error = 1;

  }else{
      quitarError(err_telf,seccion_telf);
  }
  return error;
}

function validarDir(direccion,err_dir, seccion_dir,btn){

  var error = 0;
  var expreg1 = /^[a-z A-Z0-9ñÑÁÉÍÓÚáéíóú /\n/]+$/;

  if(direccion == null || direccion.length == 0 || /^\s+$/.test(direccion)){

    colocaError(err_dir, seccion_dir,"El campo no puede ser vac\u00EDo",btn);
    error = 1; 

  }else if(expreg1.test(direccion) == false){

    colocaError(err_dir, seccion_dir,"Solo letras y n\u00FAmeros, sin comas ni puntos",btn); 
    error = 1;

  }else{
      quitarError(err_dir,seccion_dir);
  }
  return error;
}

function validarInput(campo,err,err_campo,btn){

  var error = 0;
  var expreg = /^[a-z ÁÉÍÓÚáéíóúñÑ]+$/i;  
  if(campo == null || campo.length == 0 || /^\s+$/.test(campo)){
    colocaError(err,err_campo,"El campo no puede ser vac\u00EDo",btn);
    error = 1; 
  }else if(expreg.test(campo) == false){
    //console.log(campo + "/" + expreg);
    colocaError(err,err_campo,"Formato incorrecto, solo letras",btn);
    error = 1;
  }else{
    quitarError(err,err_campo);
  }
  return error;
}

function validaCampos(form,btn){

  if(form == 1){
    elem = $('#form_login').find('input[type!="hidden"]');
  }else if(form == 2){
    elem = $('#form_contrasena').find('input[type!="hidden"]');
  }else if(form == 3){
    elem = $('#form_recomendaciones').find('input[type!="hidden"]');
  }

  var errors = 0; 

  for(i=0; i < elem.length; i++){

    if(elem[i].value=="" || elem[i].value==" "){
      errors++;
      break;
    }
  }
  
  if(errors > 0 || verifyErrors() > 0){    
    $("#"+btn).addClass('disabled');
  }else{    
    $("#"+btn).removeClass('disabled'); 
    $('#'+btn).removeAttr('disabled');  
    //if ()     
  }
}

function verifyErrors(){
  var listerrors = document.getElementsByClassName('msg_error');
  //console.log(listerrors.length);
  return listerrors.length;
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

function reemplazar(texto){
  return texto.replace(/ñ/g, 'n').
          replace(/Ñ/g, 'N').
          replace(/á/g, 'a').
          replace(/é/g, 'e').
          replace(/í/g, 'i').
          replace(/ó/g, 'o').
          replace(/ú/g, 'u').
          replace(/Á/g, 'A').
          replace(/É/g, 'E').
          replace(/Í/g, 'I').
          replace(/Ó/g, 'O').
          replace(/Ú/g, 'U');
}

function searchAjax(obj,tipo_dni){

  var val_retorno1 = "";  
  var puerto_host = $('#puerto_host').val();
  var contenido = $(obj).val();
  var url;
  if(contenido != "" && tipo_dni != ""){
    $.ajax({
      type: "GET",
      url: url = puerto_host+"/index.php?mostrar=perfil&opcion=buscarDni&dni="+contenido,
      dataType:'json',
      async: false,
      success:function(data){

          if(data.resultado == ""){
            val_retorno1 = false;
          }
          else{
            val_retorno1 = true;
          }
      },
      error: function (request, status, error) {
          console.log(request.responseText);
      },
      beforeSend : function(){
        ajaxLoader(obj, 'aparecer');
      },
      complete : function(){
        ajaxLoader(obj, 'desaparecer');
      }
    });
  }
  //console.log(val_retorno1);
  return val_retorno1;
}

$('.modal').css('overflow-y', 'auto');

function bannerTel(){
  if($('.navbar-fixed-top').prev().length){
    var navbar = $('.navbar-fixed-top');
    var heightelement = $('.navbar-fixed-top').prev().height();
    navbar.css('top', heightelement+'px');
    //console.log($('.navbar-fixed-top').height()+heightelement+30);
    $('body').css('padding-top', ($('.navbar-fixed-top').height()+heightelement+35)+'px');
  }
  else{
    $('body').css('padding-top', ($('.navbar-fixed-top').height()+35)+'px');
  }
}

$(window).resize(function(){
  // bannerTel();
});


function ajaxLoader(obj, action, tipo){
  tipo = typeof tipo !== 'undefined' ?  tipo : "";
  var res = "-41px";
  if(tipo == 2){res = "-31px";}
  if(obj[0].tagName != 'SELECT'){
    if(action == 'aparecer'){
      if(obj.siblings('div.contE').length){
        obj.siblings('div.contE').remove();
      }
      obj.after(' <div style="position: relative;" class="contE"><i class="fa fa-spinner fa-spin fa-2x" style="position: absolute; right: 5px; top: '+res+';"></i></div>');
    }
    else if(action == 'desaparecer'){
      if(obj.siblings('div.contE').length){
        obj.siblings('div.contE').delay('500').fadeOut( "fast", function(){
          obj.siblings('div.contE').remove();
        });
      }
    }
  }
  else{
    if(action == 'aparecer'){
      obj.attr('disabled', true);
        if(obj.siblings('div.contE').length){
          obj.siblings('div.contE').remove();
        }
        obj.after(' <div style="position: relative;" class="contE"><i class="fa fa-spinner fa-spin fa-2x" style="position: absolute; right: 25px; top: -31px;"></i></div>');
    }
    else if(action == 'desaparecer'){
      if(obj.siblings('div.contE').length){
        obj.siblings('div.contE').delay('500').fadeOut( "fast", function(){
          obj.siblings('div.contE').remove();
          obj.attr('disabled', false);
        });
      }
    }

  }
}
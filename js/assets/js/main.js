function colocaError(campo, id, mensaje,btn){
    nodo = document.getElementById(campo);
    nodo.innerHTML = '';
    var elem1 = document.createElement('P');
    var t = document.createTextNode(mensaje); 
    elem1.appendChild(t);

    var elem2 = document.createElement("P");             
    elem2.classList.add('list-unstyled');
    elem2.classList.add('msg_error');
    elem2.appendChild(elem1); 

    elem2.appendChild(elem1); 
    nodo.appendChild(elem2); 

    $("#"+id).addClass('has-error');

    // $("#"+btn).attr({
    //     'disabled': 'disabled',
    // });
 
    $("#"+btn).addClass('disabled');
    // $("#"+btn).attr('disabled', 'disabled');

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


function abrirModal(mensaje,id){
    $('#mensaje').html(mensaje);
    $('#'+id).modal();
}

// function colocaError(campo, id, mensaje,btn){

//     nodo = document.getElementById(campo);
//     nodo.innerHTML = '';
//     var elem1 = document.createElement('P');
//     var t = document.createTextNode(mensaje); 
//     elem1.appendChild(t);

//     var elem2 = document.createElement("P");             
//     elem2.classList.add('list-unstyled');
//     elem2.classList.add('msg_error');
//     elem2.appendChild(elem1); 

//     elem2.appendChild(elem1); 
//     nodo.appendChild(elem2); 

//     $("#"+id).addClass('has-error');

//     $("#"+btn).attr({
//         'disabled': 'disabled',
//     });
 
//     $("#"+btn).addClass('disabled');
//     $("#"+btn).attr('disabled', 'disabled');

//     if(document.getElementById('form_paypal')){
//       document.getElementById('form_paypal').action = '#';
//     }
// }

// function quitarError(campo,id){

//     document.getElementById(campo).innerHTML = '';
//     $("#"+id).removeClass('has-error');
// }


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


function validar_keycode(obj, tipo_keydown, error_mensaje, error_group, event){
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
            quitarError(error_mensaje, error_group)
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
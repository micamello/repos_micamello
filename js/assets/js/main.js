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

    /*---------------------------------------------*
     * WOW
     ---------------------------------------------*/

    //var wow = new WOW({
    //    mobile: false // trigger animations on mobile devices (default is true)
    //});
    //wow.init();

// magnificPopup

    //$('.popup-img').magnificPopup({
    //    type: 'image',
    //    gallery: {
    //        enabled: true
    //    }
    //});

    //$('.video-link').magnificPopup({
    //    type: 'iframe'
    //});

// slick slider active Home Page Tow
    // $(".hello_slid").slick({
    //     dots: true,
    //     infinite: false,
    //     slidesToShow: 1,
    //     slidesToScroll: 1,
    //     arrows: true,
    //     prevArrow: "<i class='icon icon-chevron-left nextprevleft'></i>",
    //     nextArrow: "<i class='icon icon-chevron-right nextprevright'></i>",
    //     autoplay: true,
    //     autoplaySpeed: 2000
    // });
    
    
    
    // $(".business_items").slick({
    //     dots: true,
    //     infinite: false,
    //     slidesToShow: 1,
    //     slidesToScroll: 1,
    //     arrows: true,
    //     prevArrow: "<i class='icon icon-chevron-left nextprevleft'></i>",
    //     nextArrow: "<i class='icon icon-chevron-right nextprevright'></i>",
    //     autoplay: true,
    //     autoplaySpeed: 2000
    // });

//---------------------------------------------
// Scroll Up 
//---------------------------------------------

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

    $("#"+btn).attr({
        'disabled': 'disabled',
    });
 
    $("#"+btn).addClass('disabled');
    $("#"+btn).attr('disabled', 'disabled');

    if(document.getElementById('form_paypal')){
      document.getElementById('form_paypal').action = '#';
    }
}

function quitarError(campo,id){

    document.getElementById(campo).innerHTML = '';
    $("#"+id).removeClass('has-error');
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
     var keynum = window.Event ? evt.which : evt.keyCode;    
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
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
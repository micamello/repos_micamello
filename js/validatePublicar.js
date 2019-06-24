$('#confidencialOf').parents(':eq(1)').css('display', 'none');

$('#confidencialObligatory').css('display', 'none');



$(document).ready(function(){
    $('#nivelIdiomaOf').attr('disabled', true);
    idiomasPost();



    var id_plan = $('#planesSelect').val();

      var puerto_host = $('#puerto_host').val();

      if(id_plan != ""){

        $.ajax({

            type: "GET",

            url: puerto_host+"/index.php?mostrar=publicar&opcion=buscaPlan&id_plan="+id_plan,

            dataType:'json',

            success:function(data){

                mostrarDatosPlan(data);

            },

            error: function (request, status, error) {
                crearMensajeError($('#planesSelect'), "Verifique su conexión de red. Intente de nuevo.");
                Swal.fire({

                  html: request.responseText,

                  imageUrl: $('#puerto_host').val()+'/imagenes/wrong-04.png',

                  imageWidth: 75,

                  confirmButtonText: 'ACEPTAR',

                  animation: true

                });                        

            },

            beforeSend : function(){

                ajaxLoader($('#planesSelect'), 'aparecer');

            },

            complete : function(){

                ajaxLoader($('#planesSelect'), 'desaparecer');

            }           

        })

      };



      if($(this).val() == 0){

            $('#confidencialOf').next().text("Su información se mostrará a los candidatos");

        }

        else{

            $('#confidencialOf').next().text("Su información no se mostrará a los candidatos");

        }

})



var contenido = "";

var puerto_host = $('#puerto_host').val();

var editor;

tinymce.init({ 

    selector:'textarea#descripcionOferta',

    external_plugins: {"nanospell": puerto_host+"/includes/nanospell/plugin.js"},

        nanospell_dictionary: "es",

        // forced_root_block: false ,

    style_formats: [

        {title: 'Headers', items: [

            {title: 'Header 1', format: 'h1'},

            {title: 'Header 2', format: 'h2'},

            {title: 'Header 3', format: 'h3'},

            {title: 'Header 4', format: 'h4'},

            {title: 'Header 5', format: 'h5'},

            {title: 'Header 6', format: 'h6'}

        ]},

        {title: 'Inline', items: [

            {title: 'Bold', icon: 'bold', format: 'bold'},

            {title: 'Italic', icon: 'italic', format: 'italic'},

            {title: 'Underline', icon: 'underline', format: 'underline'},

            {title: 'Strikethrough', icon: 'strikethrough', format: 'strikethrough'},

            {title: 'Superscript', icon: 'superscript', format: 'superscript'},

            {title: 'Subscript', icon: 'subscript', format: 'subscript'}

        ]},

        {title: 'Blocks', items: [

            {title: 'Paragraph', format: 'p'},

            {title: 'Blockquote', format: 'blockquote'}

        ]},

        {title: 'Alignment', items: [

            {title: 'Left', icon: 'alignleft', format: 'alignleft'},

            {title: 'Center', icon: 'aligncenter', format: 'aligncenter'},

            {title: 'Right', icon: 'alignright', format: 'alignright'},

            {title: 'Justify', icon: 'alignjustify', format: 'alignjustify'}

        ]}

    ],

    removed_menuitems: 'undo, redo',

    height : "128",

    resize: false,

    branding: false,

    elementpath: false,

    menubar:false,

    statusbar: false,

    language: 'es',

    setup: function (editor) {

        editor.on('blur', function () {

            contenido = editor.getContent().replace(/<p>/g, "").replace(/<\/p>/g, "").replace(/&nbsp;/g, "");

            $('#descripcionOferta').val(contenido);

            $('#descripcionOferta').trigger('blur');

        });

    },

});



if($('#fechaCont').length){

    $('#fecha').DateTimePicker({

    dateFormat: "yyyy-MM-dd",

    shortDayNames: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],

    shortMonthNames: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],

    fullMonthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Deciembre"],

    titleContentDate: "Configurar fecha",

    titleContentTime: "Configurar tiempo",

    titleContentDateTime: "Configurar Fecha & Tiempo",

    setButtonContent: "Listo",

    clearButtonContent: "Limpiar"

  });

}



// if($('#ciudadOf').length){

//     $('#ciudadOf').attr('disabled', true);

// }



if($('#provinciaOf').length){

    $('#provinciaOf').change(function(){

      var id_provincia = $('select[id=provinciaOf]').val();

      var puerto_host = $('#puerto_host').val();

      if(id_provincia != ""){

        $.ajax({

            type: "GET",

            url: puerto_host+"/index.php?mostrar=publicar&opcion=buscaCiudad&id_provincia="+id_provincia,

            dataType:'json',

            success:function(data){

            $('#ciudadOf').html('<option selected disabled value="0">Seleccione una ciudad</option>');

            $.each(data, function(index, value) {

              $('#ciudadOf').append("<option value='"+value.id_ciudad+"'>"+value.ciudad+"</option>");

            });

            $('#ciudadOf').attr('disabled', false);



            },

            error: function (request, status, error) {
                crearMensajeError($('#provinciaOf'), "Verifique su conexión de red. Intente de nuevo.");
                // crearMensajeError($('#ciudadOf'), "Verifique su conexión de red. Intente de nuevo.");
                $('#ciudadOf').html('<option selected disabled value="0">Seleccione una ciudad</option>');

            },

            beforeSend : function(){

                ajaxLoader($('#provinciaOf'), 'aparecer');

                ajaxLoader($('#ciudadOf'), 'aparecer');

            },

            complete : function(){

                ajaxLoader($('#provinciaOf'), 'desaparecer');

                ajaxLoader($('#ciudadOf'), 'desaparecer');

            }                

        })

      }

    });

}



if($('#area_select').length){

  $('#area_select').multiple_select({

    items: 1,

    dependence: {

      id_dependencia: "subareasCand",

      items: 1

    }

  });

}



if($('#idiomaOf').length){

    $('#idiomaOf').on('change', function(){
        $('#nivelIdiomaOf').attr('disabled', false);
        // $('#addButton').parent().removeClass('bounce');

        $('#addButton').parent().addClass('bounce');

        // $('#addButton').removeClass('addButton');

        // $('#addButton').addClass('active_button');

    })

}

if($('#nivelIdiomaOf').length){
    $('#nivelIdiomaOf').on('change', function(){
        addIdioma();
    })
}



// if($('#addButton').length){

        // $('#addButton').on('click', function(){
function addIdioma(){
            var contenedorIdiomas = $('#listadoIdiomas');

            var selectIdioma = $('#idiomaOf');

            var selectNivelIdioma = $('#nivelIdiomaOf');
            // console.log($('#nivelIdiomaOf option:first').val());

            if(selectIdioma.val() != "" 

                && selectNivelIdioma.val() != "" 

                && existeIdioma(selectIdioma.val()) == true

                && !selectIdioma.children('option:selected').attr('disabled')){

                var li = "<li class='liCss' id='lista_"+selectIdioma.val()+"'><b>Idioma:</b> "+selectIdioma.children(':selected').text()+" - <b>Nivel:</b> "+selectNivelIdioma.children(':selected').text()+" <i class='fa fa-times' onclick='eliminarIdioma($(this))'></i></li>";

                

                if(contenedorIdiomas.find('label').length){

                    contenedorIdiomas[0].innerHTML = '';

                }

                if(!contenedorIdiomas.find('ul').length){

                    var ul = "<ul class='ulCss'></ul>";

                    contenedorIdiomas.append(ul);

                }

                contenedorIdiomas.find('ul').append(li);

                crearArrayIdiomas(selectIdioma.val(), selectNivelIdioma.val());

                $('#addButton').parent().removeClass('bounce');

                // $('#addButton').removeClass('active_button');

                // $('#addButton').addClass('addButton');



                selectIdioma.children(':selected').attr('disabled', true);
                // console.log($(selectIdioma).first());
                
                // console.log($(selectNivelIdioma).first()[0]);
                
                // selectNivelIdioma
            }
            // console.log(selectNivelIdioma.first().val());
            selectIdioma.val($(selectIdioma).first().val());
            $('#nivelIdiomaOf').val($('#nivelIdiomaOf option:first').val());
            $('#nivelIdiomaOf').attr('disabled', true); 
            $('#select_array_idioma').trigger('change'); 
        }

        // })

// }



function idiomasPost(){

    if($('#select_array_idioma').children().length != 0){

        var contenedorIdiomas = $('#listadoIdiomas');

        var idioma = $('#idiomaOf');

        var nivelidioma = $('#nivelIdiomaOf');

        var listadodeidiomas = $('#select_array_idioma').children();

        $.each(listadodeidiomas, function(indice, obj){

            var indiceIdioma = "";

            var indiceNivel = "";

            indiceIdioma = $(obj).attr('value').split('_')[0];

            indiceNivel = $(obj).attr('value').split('_')[1];

            var idiomatexto = idioma.find('option[value="'+ indiceIdioma +'"]').text();

            idioma.find('option[value="'+ indiceIdioma +'"]').attr('disabled', true);

            var niveltexto = nivelidioma.find('option[value="'+ indiceNivel +'"]').text();

                if(contenedorIdiomas.find('label').length){

                    contenedorIdiomas[0].innerHTML = '';

                }

                if(!contenedorIdiomas.find('ul').length){

                    var ul = "<ul class='ulCss'></ul>";

                    contenedorIdiomas.append(ul);

                }

            var li = "<li class='liCss' id='lista_"+indiceIdioma+"'><b>Idioma:</b> "+idiomatexto+" - <b>Nivel:</b> "+niveltexto+" <i class='fa fa-times' onclick='eliminarIdioma($(this))'></i></li>";

            contenedorIdiomas.find('ul').append(li);

        })

    }

}



function existeIdioma(idIdioma){

    var listadoIdiomasSeleccionados = $('#select_array_idioma').children('option[value^="'+idIdioma+'_"]:selected');

    var listadoLi = $('#listadoIdiomas').find('li#'+idIdioma+'');

    if(listadoIdiomasSeleccionados.length > 0 && listadoLi.length > 0){

        return false;

    }

    else{

        return true;

    }

}







function crearArrayIdiomas(idioma, nivelIdioma){

    if($('#listadoIdiomasSeleccionados').length){

        var listadoIdiomas = $('#listadoIdiomasSeleccionados');

        if(!$('#select_array_idioma').length){

            var array = "<select id='select_array_idioma' name='nivel_idioma[]' onchange='funcion()'></select>";

            $('#listadoIdiomasSeleccionados').append(array);

        }

        if($('#select_array_idioma').length){

            var option = "<option value='"+idioma+"_"+nivelIdioma+"' id='array_idioma"+idioma+"' selected='selected'></option>";

            $('#select_array_idioma').append(option);

        }

    }

}



function eliminarIdioma(obj){

    var idEliminar = obj.parent().attr('id').split('_')[1];

    $('#select_array_idioma').children('option[value^="'+idEliminar+'_"]').remove();

    $('#select_array_idioma').trigger('change');

    $('#idiomaOf').children('option[value="'+idEliminar+'"]').removeAttr('disabled');

    obj.parent()[0].outerHTML = "";

    if($('#listadoIdiomas').find('li').length == 0){

        $('#listadoIdiomas').html('<label>Seleccione un idioma</label>');

    }

}



if($('#formPublicar').length){

    $('#formPublicar').on('submit', function(event){

        validarFormPublicar();

        validarFormError();

        if(validarFormError() > 0){

            event.preventDefault();

        }

        else{

            $('.loaderMic').css('display', 'block');

        }

    })

}





// **********************validacion de formularios*********************************



// -------validar on submit-------

function validarFormPublicar(){

var nombreOferta;

var descripcionOferta;

var salarioOf;

var salarioConv;

var fechaCont;

var cantVac;

var provinciaOf;

var ciudadOf;

var area_select;

var subareasCand;

var jornadaOf;

var escolaridadOf;

var edadMinOf;

var edadMaxOf;

var select_array_idioma;

var anosexp;

var dispOf;

var licenciaOf;

var residenciaOf;

var discapacidadOf;

var confidencialOf;

var ofertaUrgenteOf

var primerEmpleoOf

    if($('#nombreOferta').length){

        nombreOferta = $('#nombreOferta');

    }

    if($('#descripcionOferta').length){

        descripcionOferta = $('#descripcionOferta');

    }

    if($('#salarioOf').length){

        salarioOf = $('#salarioOf');

    }

    if($('#salarioConv').length){

        salarioConv = $('#salarioConv');

    }

    if($('#fechaCont').length){

        fechaCont = $('#fechaCont');

    }

    if($('#cantVac').length){

        cantVac = $('#cantVac');

    }

    if($('#provinciaOf').length){

        provinciaOf = $('#provinciaOf');

    }

    if($('#ciudadOf').length){

        ciudadOf = $('#ciudadOf');

    }

    if($('#area_select').length){

        area_select = $('#area_select');

    }

    if($('#subareasCand').length){

        subareasCand = $('#subareasCand');

    }

    if($('#jornadaOf').length){

        jornadaOf = $('#jornadaOf');

    }

    if($('#escolaridadOf').length){

        escolaridadOf = $('#escolaridadOf');

    }

    if($('#edadMinOf').length){

        edadMinOf = $('#edadMinOf');

    }

    if($('#edadMaxOf').length){

        edadMaxOf = $('#edadMaxOf');

    }

    if($('#select_array_idioma').length){

        select_array_idioma = $('#select_array_idioma');

    }

    if($('#anosexp').length){

        anosexp = $('#anosexp');

    }

    if($('#dispOf').length){

        dispOf = $('#dispOf');

    }

    if($('#licenciaOf').length){

        licenciaOf = $('#licenciaOf');

    }

    if($('#residenciaOf').length){

        residenciaOf = $('#residenciaOf');

    }

    if($('#discapacidadOf').length){

        discapacidadOf = $('#discapacidadOf');

    }

    if($('#confidencialOf').length){

        if($('#confidencialOf').val() == 0){

            $('#confidencialOf').next().text("Su información se mostrará a los candidatos");

        }

        else{

            $('#confidencialOf').next().text("Su información no se mostrará a los candidatos");

        }

        confidencialOf = $('#confidencialOf');

    }

    if($('#ofertaUrgenteOf').length){

        ofertaUrgenteOf = $('#ofertaUrgenteOf');

    }

    if($('#primerEmpleoOf').length){

        primerEmpleoOf = $('#primerEmpleoOf');

    }



    // nombreOferta.on('blur', function(){

    //     console.log("eder");

    // })

// ------------------------------------------------------------------

    var mensajes = "";

    if(nombreOferta.val() != ""){

        if(nombreOferta.val().length <= 250){

            if(!validarTituloEmpresa(nombreOferta.val())){

                crearMensajeError(nombreOferta, "Escriba un título válido");

                mensajes += "- Campo titulo: Escriba un título válido";

            }

            else{

                eliminarMensajeError(nombreOferta);

            }

        }

        else{

            crearMensajeError(nombreOferta, "Longitud máxima de caracteres 250.");

            mensajes += "- Campo titulo: Longitud máxima de caracteres 250";

        }

    }

    else{

        crearMensajeError(nombreOferta, "Rellene este campo.");

        mensajes += "- Campo título no puede ser vacío";

    }

// ------------------------------------------------------------------

    if($('#descripcionOferta').val() == ""){

        crearMensajeError(descripcionOferta, "Rellene este campo");

        mensajes += "\n- El campo descripción no puede ser vacío";

    }

    else{

        eliminarMensajeError(descripcionOferta);

    }





// ------------------------------------------------------------------

    if(salarioOf.val() != ""){

        var permitidosFloat = /^[0-9.]+$/;

        if(!validarFloat(salarioOf.val())){

            crearMensajeError(salarioOf, "Ingrese un valor correcto, 00.00");

            mensajes += "\n-Campo salario: Ingrese un valor válido, 00.00";

        }

        else{

            eliminarMensajeError(salarioOf);

        }

    }

    else{

        crearMensajeError(salarioOf, "Rellene este campo");

        mensajes += "\n-El campo salario no puede ser vacío";

    }



// ------------------------------------------------------------------

    if(salarioConv.val() == ""){

        crearMensajeError(salarioConv, "Seleccione una opción");

        mensajes += "\n-Campo salario a convenir: seleccione una opción";

    }

    else{

        eliminarMensajeError(salarioConv);

    }

// ------------------------------------------------------------------

    if(fechaCont.val() != ""){

        if(validarFecha(fechaCont.val())){

            if(!fechaMayor(fechaCont.val())){

                crearMensajeError(fechaCont, 'Ingrese una fecha válida (mayor a actual)');

                mensajes += "\n- Campo fecha contratación: Ingrese una fecha mayor a la actual";

            }

            else{

                eliminarMensajeError(fechaCont);

            }

        }

        else{

            crearMensajeError(fechaCont, "Ingrese una fecha válida");

            mensajes += "\n- Ingrese una fecha válida"

        }

    }

    else{

        crearMensajeError(fechaCont, "Rellene este campo");

        mensajes += "\n- El campo fecha contratación no puede estar vacío";

    }



// ------------------------------------------------------------------

if(cantVac.val() != ""){

    if(!validarVacante(cantVac.val())){

        crearMensajeError(cantVac, "Superó número máximo de vacantes");

        mensajes += "\n- Campo Cantidad vacante: Superó número máximo de vacantes";

    }

    else{

        eliminarMensajeError(cantVac);

    }

}

else{

    crearMensajeError(cantVac, "Rellene este campo");

    mensajes += "\n- El campo cantidad de vacantes no puede ser vacío";

}



// ------------------------------------------------------------------

if(provinciaOf.val() == "" || provinciaOf.val() == null){

    crearMensajeError(provinciaOf, "Seleccione una opción");

    mensajes += "\n- Campo provincia: Seleccione una opción";

}

else{

    eliminarMensajeError(provinciaOf);

}



// ------------------------------------------------------------------

if(ciudadOf.val() == "" || ciudadOf.val() == null){

    crearMensajeError(ciudadOf, "Seleccione una opción");

    mensajes += "\n- Campo ciudad: Seleccione una opción";

}

else{

    eliminarMensajeError(ciudadOf);

}

// ------------------------------------------------------------------

if(subareasCand.val() == "" || subareasCand.val() == null){

    crearMensajeError(subareasCand, "Seleccione una opción");

    mensajes += "\n- Campo subarea: Seleccione una opción";

}

else{

    eliminarMensajeError(subareasCand);

}



// ------------------------------------------------------------------

if(jornadaOf.val() == "" || jornadaOf.val() == null){

    crearMensajeError(jornadaOf, "Seleccione una opción");

    mensajes += "\n- Campo jornada: Seleccione una opción";

}

else{

    eliminarMensajeError(jornadaOf);

}



// ------------------------------------------------------------------

if(escolaridadOf.val() == "" || escolaridadOf.val() == null){

    crearMensajeError(escolaridadOf, "Seleccione una opción");

    mensajes += "\n- Campo escolaridad: Seleccione una opción";

}

else{

    eliminarMensajeError(escolaridadOf);

}



// ------------------------------------------------------------------

if(edadMinOf.val() != ""){

    var edadmayor = parseInt($('#edadMaxOf').val());

    var edadmenor = parseInt($('#edadMinOf').val());

    if(edadmenor != ""){

        if(edadmenor >= 18 && edadmenor < 101){

            if($(edadmenor != "")){

                if(edadmenor > edadmayor){

                    crearMensajeError($('#edadMaxOf'), "Verifique la edad");

                    mensajes+= "\n- Verifique el campo Edad mínima";

                }

                else{

                    eliminarMensajeError($(edadMinOf));

                }

            }

        }

        else{

            crearMensajeError($(this), "Mín: 18 años , Máx: 100 años");

            mensajes+= "\n- Verifique el campo Edad mínima";

        }

    }

    else{

        crearMensajeError($(this), "Rellene este campo");

        mensajes+= "\n- Verifique el campo Edad mínima";

    }

}

else{

    crearMensajeError(edadMinOf, "Rellene este campo");

    mensajes+= "\n- Verifique el campo Edad mínima";

}

// // ------------------------------------------------------------------

if(edadMaxOf.val() != ""){

    var edadmayor = parseInt($('#edadMaxOf').val());

    var edadmenor = parseInt($('#edadMinOf').val());

    if(edadmayor != ""){

        if(edadmayor >= 18 && edadmayor < 101){

            if($(edadmayor != "")){

                if(edadmenor > edadmayor){

                    crearMensajeError($('#edadMaxOf'), "Verifique la edad");

                    mensajes+= "\n- Verifique el campo Edad mayor";

                }

                else{

                    eliminarMensajeError($(edadMaxOf));

                }

            }

        }

        else{

            crearMensajeError($(this), "Mín: 18 años , Máx: 100 años");

            mensajes+= "\n- Verifique el campo Edad mayor";

        }

    }

    else{

        crearMensajeError($(this), "Rellene este campo");

        mensajes+= "\n- Verifique el campo Edad mayor";

    }

}

else{

    crearMensajeError(edadMaxOf, "Rellene este campo");

    mensajes += "\n- Verifique el campo edad máxima";

}





if(select_array_idioma.val() == "" || select_array_idioma.val() == null){

    crearMensajeError($('#listadoIdiomas'), "Seleccione un idioma");

    mensajes += "\n- Campo idioma: Seleccione al menos un idioma";

}

else{

    eliminarMensajeError($('#listadoIdiomas'));

}

//

// descripcionOferta.on('blur', function(){

//     console.log(contenido);

// })

// ------------------------------------------------------------------

if(anosexp.val() == "" || anosexp.val() == null){

    crearMensajeError(anosexp, "Seleccione una opción");

    mensajes += "\n- Campo años experiencia: Seleccione una opción";

}

else{

    eliminarMensajeError(anosexp);

}

// ------------------------------------------------------------------

if(dispOf.val() == "" || dispOf.val() == null){

    crearMensajeError(dispOf, "Seleccione una opción");

    mensajes += "\n- Campo disponibilidad para viajar: Seleccione una opción";

}

else{

    eliminarMensajeError(dispOf);

}

// ------------------------------------------------------------------

if(licenciaOf.val() == "" || licenciaOf.val() == null){

    crearMensajeError(licenciaOf, "Seleccione una opción");

    mensajes += "\n- Campo licencia: Seleccione una opción";

}

else{

    eliminarMensajeError(licenciaOf);

}

// ------------------------------------------------------------------

if(residenciaOf.val() == "" || residenciaOf.val() == null){

    crearMensajeError(residenciaOf, "Seleccione una opción");

    mensajes += "\n- Campo cambio de residencia: Seleccione una opción";

}

else{

    eliminarMensajeError(residenciaOf);

}

// ------------------------------------------------------------------

if(discapacidadOf.val() == "" || discapacidadOf.val() == null){

    crearMensajeError(discapacidadOf, "Seleccione una opción");

    mensajes += "\n- Campo discapacidad: Seleccione una opción";

}

else{

    eliminarMensajeError(discapacidadOf);

}

// ------------------------------------------------------------------

if(confidencialOf.val() == "" || confidencialOf.val() == null){

    crearMensajeError(confidencialOf, "Seleccione una opción");

    mensajes += "\n- Campo confidencial: Seleccione una opción";

}

else{

    eliminarMensajeError(confidencialOf);

}

// ------------------------------------------------------------------

if(ofertaUrgenteOf.val() == "" || ofertaUrgenteOf.val() == null){

    crearMensajeError(ofertaUrgenteOf, "Seleccione una opción");

    mensajes += "\n- Campo oferta urgente: Seleccione una opción";

}

else{

    eliminarMensajeError(ofertaUrgenteOf);

}

// ------------------------------------------------------------------

if(primerEmpleoOf.val() == "" || primerEmpleoOf.val() == null){

    crearMensajeError(primerEmpleoOf, "Seleccione una opción");

    mensajes += "\n- Campo primer empleo: Seleccione una opción";

}

else{

    eliminarMensajeError(primerEmpleoOf);

}

if(mensajes != ""){

    mensajeErrorAlert(mensajes);

}



}



$('#nombreOferta').on('blur', function(){

    if($(this).val() != ""){

        if($(this).val().length <= 250){

            if(!validarTituloEmpresa($(this).val())){

                crearMensajeError($(this), "Ingrese un título válido");

            }

            else{

                eliminarMensajeError($(this));

            }

        }

        else{

            crearMensajeError($(this), "Longitud máxima de caracteres 250.");

        }

    }

    else{

        crearMensajeError($(this), "Rellene este campo.")

    }

});



$('#descripcionOferta').on('blur', function(){

    if(contenido == ""){

        crearMensajeError($(this), "Rellene este campo");

    }

    else{

        eliminarMensajeError($(this));

    }

});



if($('#salarioOf').length){

    $('#salarioOf').on('blur', function(event){

        if($(this).val() != ""){

            if(!validarFloat($(this).val())){

                crearMensajeError($(this), "Formato incorrecto, 00.00");

            }

            else{

                eliminarMensajeError($(this));

            }

        }

        else{

            crearMensajeError($(this), "Rellene este campo");

        }

    });



    $('#salarioOf').on('keypress', function(event){

        var permitidos = /^[0-9.]+$/;

        if(permitidos.test(event.key)){

            eliminarMensajeError($(this));

        }

        else{

            event.preventDefault();

            crearMensajeError($(this), "Caracter no permitido");

        }



    });

}





$('#salarioConv').on('blur', function(){

    if($(this).val() == "" || $(this).val() == null){

        crearMensajeError($(this), "Seleccione una opción");

    }

    else{

        eliminarMensajeError($(this));

    }

});



$('#fechaCont').on('change', function(){

    if($(this).val() != ""){

        if(validarFecha($(this).val())){

            if(!fechaMayor($(this).val())){

                crearMensajeError($(this), 'Ingrese una fecha válida (mayor o igual a actual)');

            }

            else{

                eliminarMensajeError($(this));

            }

        }

        else{

            crearMensajeError($(this), "Ingrese una fecha válida");

        }

    }

    else{

        crearMensajeError($(this), "Rellene este campo");

    }

});



$('#cantVac').on('blur', function(event){

        if($(this).val() != ""){

            if($(this).val() >= 1){

                if(!validarVacante($(this).val())){

                    crearMensajeError($(this), "Superó número máximo de vacantes");

                }

                else{

                    eliminarMensajeError($(this));

                }

            }

            else{

                crearMensajeError($(this), "Mínimo una vacante");

            }

        }

        else{

            crearMensajeError($(this), "Rellene este campo");

        }

    });



    $('#cantVac').on('keypress', function(event){

        var permitidos = /^[0-9]+$/;

        if(permitidos.test(event.key)){

            eliminarMensajeError($(this));

        }

        else{

            event.preventDefault();

            crearMensajeError($(this), "Caracter no permitido");

        }



    });



$('#provinciaOf').on('blur change', function(){

    if($(this).val() == "" || $(this).val() == null){

        crearMensajeError($(this), "Seleccione una opción");

    }

    else{

        eliminarMensajeError($(this));

    }

});



$('#ciudadOf').on('blur change', function(){

    if($(this).val() == "" || $(this).val() == null){

        crearMensajeError($(this), "Seleccione una opción");

    }

    else{

        eliminarMensajeError($(this));

    }

});



$('#subareasCand').on('change', function(){
    console.log("llego a subareas - valor : "+$(this).val());
    if($(this).val() == "" || $(this).val() == null){

        crearMensajeError($(this), "Seleccione una opción");

    }

    else{

        eliminarMensajeError($(this)); 

    }

});





$('#jornadaOf').on('blur change', function(){

    if($(this).val() == "" || $(this).val() == null){

        crearMensajeError($(this), "Seleccione una opción");

    }

    else{

        eliminarMensajeError($(this));

    }

});



$('#escolaridadOf').on('blur change', function(){

    if($(this).val() == "" || $(this).val() == null){

        crearMensajeError($(this), "Seleccione una opción");

    }

    else{

        eliminarMensajeError($(this));

    }

});



// $('#edadMinOf').on('blur', function(){

//     if($(this).val() != ""){

//         if($(this).val() >= 18 && $(this).val() <= 100){

//             if($('#edadMaxOf').val() != "" && $('#edadMaxOf').val() < $(this).val()){

//                 crearMensajeError($('#edadMaxOf'), "Verifique la edad");

//             }

//             else{

//                 eliminarMensajeError($('#edadMaxOf'));

//             }

//         }

//         else{

//             crearMensajeError($(this), "Mín: 18 años , Máx: 100 años");

//         }

//     }

//     else{

//         crearMensajeError($(this), "Rellene este campo");

//     }

// });

$('#edadMinOf').on('blur', function(){

    var edadmayor = parseInt($('#edadMaxOf').val());

    var edadmenor = parseInt($('#edadMinOf').val());

    if(edadmenor != ""){

        if(edadmenor >= 18 && edadmenor < 101){

            if(edadmayor != ""){

                if(edadmenor > edadmayor){

                    crearMensajeError($('#edadMaxOf'), "Verifique la edad");

                }

                else{

                    eliminarMensajeError($(this));

                }

            }

        }

        else{

            crearMensajeError($(this), "Mín: 18 años , Máx: 100 años");

        }

    }

    else{

        crearMensajeError($(this), "Rellene este campo");

    }

});



$('#edadMinOf').on('keypress', function(event){

    var permitidosEdad = /^[0-9]+$/;

    if(!permitidosEdad.test(event.key)){

        event.preventDefault();

        crearMensajeError($(this), "Caracter no permitido");

    }

    else{

        eliminarMensajeError($(this));

    }

})



$('#edadMaxOf').on('blur', function(){

    var edadmayor = parseInt($('#edadMaxOf').val());

    var edadmenor = parseInt($('#edadMinOf').val());

    if(edadmayor != ""){

        if(edadmayor >= 18 && edadmayor < 101){

            if($(edadmayor != "")){

                if(edadmenor > edadmayor){

                    crearMensajeError($('#edadMaxOf'), "Verifique la edad");

                }

                else{

                    eliminarMensajeError($(this));

                }

            }

        }

        else{

            crearMensajeError($(this), "Mín: 18 años , Máx: 100 años");

        }

    }

    else{

        crearMensajeError($(this), "Rellene este campo");

    }

});



$('#edadMaxOf').on('keypress', function(event){

    var permitidosEdad = /^[0-9]+$/;

    if(!permitidosEdad.test(event.key)){

        event.preventDefault();

        crearMensajeError($(this), "Caracter no permitido");

    }

    else{

        eliminarMensajeError($(this));

    }

})



$('#select_array_idioma').on('change', function(){

    if($(this).val() == "" || $(this).val() == null){

        crearMensajeError($('#listadoIdiomas'), "Seleccione un idioma");

    }

    else{

        eliminarMensajeError($('#listadoIdiomas'));

    }

});



$('#addButton').on('click', function(){

    if($('#select_array_idioma').val() != "" || $('#select_array_idioma').val() != null){

        eliminarMensajeError($('#listadoIdiomas'));

    }

});



$('#anosexp').on('blur change', function(){

    if($(this).val() == "" || $(this).val() == null){

        crearMensajeError($(this), "Seleccione una opción");

    }

    else{

        eliminarMensajeError($(this));

    }

});



$('#dispOf').on('blur change', function(){

    if($(this).val() == "" || $(this).val() == null){

        crearMensajeError($(this), "Seleccione una opción");

    }

    else{

        eliminarMensajeError($(this));

    }

});



$('#licenciaOf').on('blur change', function(){

    if($(this).val() == "" || $(this).val() == null){

        crearMensajeError($(this), "Seleccione una opción");

    }

    else{

        eliminarMensajeError($(this));

    }

});



$('#residenciaOf').on('blur change', function(){

    if($(this).val() == "" || $(this).val() == null){

        crearMensajeError($(this), "Seleccione una opción");

    }

    else{

        eliminarMensajeError($(this));

    }

}); 



$('#discapacidadOf').on('blur change', function(){

    if($(this).val() == "" || $(this).val() == null){

        crearMensajeError($(this), "Seleccione una opción");

    }

    else{

        eliminarMensajeError($(this));

    }

});



$('#confidencialOf').on('blur change', function(){

    if($(this).val() == 0){

        // $(this).next().text("eder 1");

        $(this).next().text("Su información se mostrará a los candidatos");

    }

    else{

        // $(this).next().text("eder 2");

        $(this).next().text("Su información no se mostrará a los candidatos");

    }

    if($(this).val() == "" || $(this).val() == null){

        crearMensajeError($(this), "Seleccione una opción");

    }

    else{

        eliminarMensajeError($(this));

    }

});



$('#ofertaUrgenteOf').on('blur change', function(){

    if($(this).val() == "" || $(this).val() == null){

        crearMensajeError($(this), "Seleccione una opción");

    }

    else{

        eliminarMensajeError($(this));

    }

});



$('#primerEmpleoOf').on('blur change', function(){

    if($(this).val() == "" || $(this).val() == null){

        crearMensajeError($(this), "Seleccione una opción");

    }

    else{

        eliminarMensajeError($(this));

    }

});



// ******************funciones***********************

function fechaMayor(fecha){

    var ahora = new Date().toISOString().slice(0,10);

    if(ahora>fecha){

        return false;

    }

    else{

        return true;

    }

}



function validarTituloEmpresa(texto){

    return /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\/"'&(),. ]{3,}$/.test(texto);

}



function crearMensajeError(obj, mensaje){

    var objdiverror = "";

    var texterror = "";

    eliminarMensajeError(obj);

    objdiverror = obj.prev();

    var claseError = "";

    claseError = "errorClass";

    if(obj.attr('id') == "descripcionOferta"){

        objdiverror = obj.prev().prev();

    }

    if(obj.attr('id') == "subareasCand"){

        objdiverror = obj.parent().find('label').next();

    }

    if(obj.attr('id') == "listadoIdiomas"){

        objdiverror = obj.parent().prev();

        claseError = "errorClass";

    }

    texterror = "<p class='"+claseError+"'>"+mensaje+"</p>";

    objdiverror.append(texterror);

}



function eliminarMensajeError(obj){

    var objdiverror = "";

    objdiverror = obj.prev();

    if(obj.attr('id') == "descripcionOferta"){

        objdiverror = obj.prev().prev();

    }

    if(obj.attr('id') == "subareasCand"){

        objdiverror = obj.parent().find('label').next();

    }

    if(obj.attr('id') == "listadoIdiomas"){

        objdiverror = obj.parent().prev();

    }

    objdiverror[0].innerHTML = "";

}



function validarFloat(valor){

    return /^([0-9]{1,5})[.][0-9]{2}?$/.test(valor);

}



function validarFecha(fecha){

    return /^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/.test(fecha);

}



function validarVacante(numero){

    if((/^[0-9]{1,4}$/.test(numero))){

        return true;

    }    

    else{

        return false;

    }

}



function validarMinMaxEdad(min, max, tipo){

    var retorno = [false, false];

    if(tipo == 1){

        if(max.val() != "" && validarNumeroEdad(max.val()) && max.val() <= 100){

            if(min.val() > max.val()){

                retorno = [];

                retorno.push(max, false);

            }

            else{

                retorno = [];

                retorno.push(max, true);

            }

        }

    }

    else{

        if(min.val() != "" && validarNumeroEdad(min.val()) && min.val() <= 100){

            if(max.val() < min.val()){

                retorno = [];

                retorno.push(max, false);

            }

            else{

                retorno = [];

                retorno.push(max, true);

            }

        }

    }

    return retorno;

}



function validarNumeroEdad(edad){

    return /^[0-9]+$/.test(edad);

}



function validarFormError(){

    var errors = $('.errorClass').length;

    return errors;

}



// eventos planesSelect



$('#planesSelect').on('change', function(){

    var id_plan = $(this).val();

      var puerto_host = $('#puerto_host').val();

      if(id_plan != ""){

        $.ajax({

          type: "GET",

          url: puerto_host+"/index.php?mostrar=publicar&opcion=buscaPlan&id_plan="+id_plan,

          dataType:'json',

          success:function(data){

            mostrarDatosPlan(data);



          },

          error: function (request, status, error) {
            crearMensajeError($('#planesSelect'), "Verifique su conexión de red. Intente de nuevo.");
            ajaxLoader($('#planesSelect'), 'aparecer');

          },

          beforeSend : function(){

            ajaxLoader($('#planesSelect'), 'aparecer');

            },

            complete : function(){

                ajaxLoader($('#planesSelect'), 'desaparecer');

            }                 

        })

      }   

});



function mostrarDatosPlan(data){

    var fecha_caducidad = "Ilimitado";

    var ofertaRest = data.num_publicaciones_rest;

    if(data.fecha_caducidad != ""){

        fecha_caducidad = formatearFecha(data.fecha_caducidad);

    }



    // var html = "<div class='col-md-6'><span><b>Fecha de caducidad:</b></span><div class='bubbleData'>"+fecha_caducidad+"</div></div><div class='col-md-6'><span><b>Publicaciones restantes:</b></span><div class='bubbleData'><b>"+ofertaRest+"</b> Publicaciones</div></div>";

    var html = "<p><b>Fecha de caducidad:</b> "+fecha_caducidad+"<br><b>Publicaciones restantes:</b> "+ofertaRest+" publicaciones</p>";

    // $('#detallePlan').removeClass('col-md-6');

    // $('#detallePlan').removeClass('col-md-offset-3');

    // $('#detallePlan').removeClass('cajaDetalle');

    $('#detallePlan')[0].innerHTML = "";

    $('#detallePlan').html(html);

    if(data.confidencial == 1){

        $('#confidencialOf').parents(':eq(1)').css('display', 'block');

        $('#confidencialObligatory').css('display', 'none');

    }

    else{

        $('#confidencialOf').parents(':eq(1)').css('display', 'none');

        $('#confidencialObligatory').css('display', 'block');

    }

}



function formatearFecha(contenido){

  var meses = [

      "Enero", "Febrero", "Marzo",

      "Abril", "Mayo", "Junio", "Julio",

      "Agosto", "Septiembre", "Octubre",

      "Noviembre", "Diciembre"

    ] 

    var date = new Date(contenido);

    var dia = date.getDate();

    var mes = date.getMonth();

    var yyy = date.getFullYear();

    var fecha_formateada = dia + ' de ' + meses[mes] + ' de ' + yyy;

    return fecha_formateada;

}



function mensajeErrorAlert(mensaje){

  Swal.fire({    

    //html: mensaje,

    html: 'Por favor complete los campos con (*)<br>',

    imageUrl: $('#puerto_host').val()+'/imagenes/wrong-04.png',

    imageWidth: 75,

    confirmButtonText: 'ACEPTAR',

    animation: true

  });      

}
if(document.getElementById('form_editarPerfil')){

    validarFormulario();
    ocultarCampos();
    mostrarUni();
}

if (document.getElementById("area_select"))
{
  var selectedOptions = $('#area_select option:selected');

  $('#area_select').multiselect({
    buttonContainer: '<div id="example-checkbox-list-container"></div>',
    buttonClass: '',
    templates: {
        button: '',
        ul: '<ul class="multiselect-container checkbox-list scroll"></ul>',
    },
    maxHeight: 84,
    enableFiltering: true,
    enableCaseInsensitiveFiltering: true,
    buttonWidth: '50%',
    buttonText: function(options, select) {

      var labels = [];  
      $('#seleccionados1').html('');                
      options.each(function() {

        if ($(this).attr('label') !== undefined) {
          labels.push($(this).attr('label'));                             
          $('#seleccionados1').html($('#seleccionados1').html()+' '+'<a href="javascript:void(0);" onclick="deseleccionar('+$(this).val()+', area_select);"><i class="fa fa-times-circle fa fa-2x"></i></a>');          
          $('#'+this.parentNode.id).parents(':eq(1)').find('.panel-head-select').children().children().html(options.length);
        }
        else {
          labels.push($(this).html());
          $('#seleccionados1').html($('#seleccionados1').html()+'<p class="selectedItems">'+$(this).html()+' '+'<a href="javascript:void(0);" onclick="deseleccionar('+$(this).val()+', area_select);"><i class="fa fa-times-circle fa fa-2x"></i></a></p>');
            $('#'+this.parentNode.id).parents(':eq(1)').find('.panel-head-select').children().children().html(options.length);
        }
      });                        
      return labels.join(', ') + '';
    },
    onChange: function(option, checked) {
      var selectedOptions = $('#area_select option:selected');

      if (selectedOptions.length >= 3) {
        var nonSelectedOptions = $('#area_select option').filter(function() {
            return !$(this).is(':selected');
        }); 
        nonSelectedOptions.each(function() {
            var input = $('input[id="area_select-' + $(this).val() + '"]');
            input.prop('disabled', true);
            input.parent('li').addClass('disabled');
        });
      }
      else {
        $('#area_select option').each(function() {               
            var input = $('input[id="area_select-' + $(this).val() + '"]');
            //console.log(input);
            input.prop('disabled', false);
            input.parent('li').addClass('disabled');
            $('#'+this.parentNode.id).parents(':eq(1)').find('.panel-head-select').children().children().html(selectedOptions.length);
        });
      }
    }        
  });

  if (selectedOptions.length >= 3) {
      var nonSelectedOptions = $('#area_select option').filter(function() {
          return !$(this).is(':selected');
      }); 
      nonSelectedOptions.each(function() {
          var input = $('input[id="area_select-' + $(this).val() + '"]');
          input.prop('disabled', true);
          input.parent('li').addClass('disabled');
      });
  }
  else {
      $('#area_select option').each(function() {               
          var input = $('input[id="area_select-' + $(this).val() + '"]');
          //console.log(input);
          input.prop('disabled', false);
          input.parent('li').addClass('disabled');
          $('#'+this.parentNode.id).parents(':eq(1)').find('.panel-head-select').children().children().html(selectedOptions.length);
      });
  }

  $('#seleccionados1').parent().append(filtro[0]);

  if (selectedOptions.length >= 3) {
    var nonSelectedOptions = $('#area_select option').filter(function() {
        return !$(this).is(':selected');
    }); 
    nonSelectedOptions.each(function() {
        var input = $('input[id="area_select-' + $(this).val() + '"]');
        input.prop('disabled', true);
        input.parent('li').addClass('disabled');
    });
  }
  else {
    $('#area_select option').each(function() {
        var input = $('input[id="area_select-' + $(this).val() + '"]');
        input.prop('disabled', false);
        input.parent('li').addClass('disabled');
        $('#'+this.parentNode.id).parents(':eq(1)').find('.panel-head-select').children().children().html(selectedOptions.length);
    });
  }

  if(selectedOptions.length === 0){
    colocaError("err_area","seccion_area","Debe seleccionar una opcion de la lista","boton");
  }
}

if (document.getElementById("nivel_interes"))
{
  $('#nivel_interes').multiselect({
    buttonContainer: '<div id="example-checkbox-list-container"></div>',
    buttonClass: '',
    templates: {
        button: '',
        ul: '<ul class="multiselect-container checkbox-list scroll"></ul>',
    },
    maxHeight: 84,
    enableFiltering: true,
    enableCaseInsensitiveFiltering: true,
    buttonWidth: '50%',
    buttonText: function(options, select) {
      var labels = [];  
      $('#seleccionados2').html('');                
      options.each(function() {

        if ($(this).attr('label') !== undefined) {
          labels.push($(this).attr('label'));                             
          $('#seleccionados2').html($('#seleccionados2').html()+' '+'<a href="javascript:void(0);" onclick="deseleccionar('+$(this).val()+', nivel_interes);"><i class="fa fa-times-circle fa fa-2x"></i></a>');
          $('#'+this.parentNode.id).parents(':eq(1)').find('.panel-head-select').children().children().html(options.length);
        }
        else {
          labels.push($(this).html());

          $('#seleccionados2').html($('#seleccionados2').html()+'<p class="selectedItems">'+$(this).html()+' '+'<a href="javascript:void(0);" onclick="deseleccionar('+$(this).val()+', nivel_interes);"><i class="fa fa-times-circle fa fa-2x"></i></a></p>');
            $('#'+this.parentNode.id).parents(':eq(1)').find('.panel-head-select').children().children().html(options.length);
        }
      });                        
      return labels.join(', ') + '';
    },
    onChange: function(option, checked) {
      var selectedOptions = $('#nivel_interes option:selected');

      if (selectedOptions.length >= 2) {
          var nonSelectedOptions = $('#nivel_interes option').filter(function() {
              return !$(this).is(':selected');
          }); 
          nonSelectedOptions.each(function() {
              var input = $('input[id="nivel_interes-' + $(this).val() + '"]');
              input.prop('disabled', true);
              input.parent('li').addClass('disabled');
          });
      }
      else {
          $('#nivel_interes option').each(function() {
              // console.log(this);
              var input = $('input[id="nivel_interes-' + $(this).val() + '"]');
              input.prop('disabled', false);
              input.parent('li').addClass('disabled');
              $('#'+this.parentNode.id).parents(':eq(1)').find('.panel-head-select').children().children().html(selectedOptions.length);
          });
      }
    }        
  });

  $('#seleccionados2').parent().append(filtro[1]);

  var selectedOptions = $('#nivel_interes option:selected');

  if (selectedOptions.length >= 2) {
    var nonSelectedOptions = $('#nivel_interes option').filter(function() {
        return !$(this).is(':selected');
    }); 
    nonSelectedOptions.each(function() {
        var input = $('input[id="nivel_interes-' + $(this).val() + '"]');
        input.prop('disabled', true);
        input.parent('li').addClass('disabled');
    });
  }
  else {
    $('#nivel_interes option').each(function() {
        var input = $('input[id="nivel_interes-' + $(this).val() + '"]');
        input.prop('disabled', false);
        input.parent('li').addClass('disabled');
        $('#'+this.parentNode.id).parents(':eq(1)').find('.panel-head-select').children().children().html(selectedOptions.length);
    });
  }

  if(selectedOptions.length == 0){
    colocaError("err_int","seccion_int","Debe seleccionar una opcion de la lista","boton");
  }
}

if(document.getElementById('seccion_listado')){
    var listado_group = document.getElementById('seccion_listado').id;
}

if(document.getElementById('boton')){
    var button_register = document.getElementById('boton').id;
}

if(document.getElementById('listado_idiomas')){
    var listado_error = document.getElementById('listado_idiomas').id;
}

/* Carga select dependiente (ciudad) */
$('#provincia').change(function()
{
    var id_provincia = $('select[id=provincia]').val();
    var puerto_host = $('#puerto_host').val();

    if(id_provincia != ""){
        $.ajax({
            type: "GET",
            url: puerto_host+"?mostrar=perfil&opcion=buscaCiudad&id_provincia="+id_provincia,
            dataType:'json',
            success:function(data){
                $('#ciudad').html('<option value="0">Selecciona una ciudad</option>');
                $.each(data, function(index, value) {
                    $('#ciudad').append("<option value='"+value.id_ciudad+"'>"+value.ciudad+"</option>");
                });

                if(document.getElementById('ciudad').value == 0){
                    colocaError("err_ciu", "seccion_ciudad","Debe seleccionar una opcion de la lista","boton");
                }else{
                    quitarError("err_ciu","seccion_ciudad");
                }
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }                  
        })
    }
});

function eliminar_item_selected(selected_item,tipo,op){

    var seleccionado = document.getElementById(selected_item);
    seleccionado.outerHTML = "";

    $('#li'+selected_item).removeClass('selected');
    $("#"+tipo+" option[value='"+op+"']:selected").removeAttr("selected");
    
}

/* Carga select dependiente (ciudad) */

/* Carga de imagen dinamico */

$('#file-input').change(function(e) {
    addImage(e); 
    validarImg(document.getElementById('file-input'),'err_img','seccion_img',"btndeposito");
});

function addImage(e){
    var file = e.target.files[0],
    imageType = /image.*/;

if (!file.type.match(imageType))
    return;

    var reader = new FileReader();
    reader.onload = fileOnload;
    reader.readAsDataURL(file);
}

function fileOnload(e) {
    var result=e.target.result;
    $('#imagen_perfil').attr("src",result);
}


function validarImg(archivo,err_img,seccion_img,btn){

  var file = fileValidation(archivo);
  var error = 0;
  if(file == 1){
    error = 1;
  }else{
    $('#err_img').html('<p class="parpadea" style="font-size:11px;color:green">Imagen cargada</p>');
  }
  return error;
}

function fileValidation(fileInput){

  var filePath = fileInput.value;
  var allowedExtensions = /[.jpg |.jpeg |.png]$/i;
  
  if(filePath != ''){
   
    var tamano = fileInput.files[0].size/1024/1024;
    if(tamano > 1){
      //colocaError("err_img", "seccion_img","El peso permitido es de máximo es de 1MB","btndeposito");
      document.getElementById('err_img').innerHTML = '<p class="parpadea" style="font-size:11px;color:red">El peso permitido es de máximo 1MB</p>';
      return 1;
    }else{
      return 0;
    }
    
  }else if(!allowedExtensions.test(filePath)){
    //colocaError("err_img", "seccion_img","El formato permitido es .jpeg/.jpg/.png","btndeposito");
    fileInput.value = '';
    document.getElementById('err_img').innerHTML = '<p class="parpadea" style="font-size:11px;color:red">El formato permitido es .jpeg/.jpg/.png</p>';
    return 1;
  }else{
    return 0;
  }
}

/*function validaCampos(tipo){

  var elem = $('#form_editarPerfil').find('input[type!="hidden"]');
  var btn = 'btn_submitpaypal'; 

  var errors = 0; 

  if(select != 0){
    for(i=0; i < elem.length; i++){
      if(elem[i].type != 'image'){
        if(elem[i].value=="" || elem[i].value==" "){
          errors++;
          break;
        }
      }
    }
  }else{
    errors++;
  }

  if(errors > 0 || verifyErrors() > 0){
    $("#"+btn).addClass('disabled');
  }else{
    $("#"+btn).removeClass('disabled');
  }
}*/


/* Carga de imagen dinamico */

/* Carga de hoja de vida */

$('#subirCV').change(function(e) {

    $('#imagenBtn').attr("src",$('#puerto_host').val()+'/imagenes/actualizar.png');
    $('#texto_status').html('Hoja de vida Cargada');
    $('#texto_status').addClass('arch_cargado');
    if(document.getElementById("mensaje_error_hv")){
        document.getElementById("mensaje_error_hv").style.display = "none";
    }

    var estado = validarFormulario();

    if(estado == 1){
        $('#boton').removeAttr('disabled');
    }else{
        $('#boton').attr('disabled');
    }
});

/* Carga de hoja de vida */
$('#idioma_of').on('change', function(){

    if(document.getElementById('idioma_of').value != 0 && document.getElementById('nivel_idi_of').value != 0){
        document.getElementById('effect_bounce').classList.add('bounce');
        document.getElementById('btn_transfer').classList.add('active_button');
    }else{
        document.getElementById('effect_bounce').classList.remove('bounce');
        document.getElementById('btn_transfer').classList.remove('active_button');
    }
});

$('#nivel_idi_of').on('change', function(){

    if(document.getElementById('idioma_of').value != 0 && document.getElementById('nivel_idi_of').value != 0){
        document.getElementById('effect_bounce').classList.add('bounce');
        document.getElementById('btn_transfer').classList.add('active_button');
    }else{
        document.getElementById('effect_bounce').classList.remove('bounce');
        document.getElementById('btn_transfer').classList.remove('active_button');
    }
});

function enableBTN(event){
    
    var flag = false;
    if(validarFormulario() == 1 && errorsVerify() != false){
        var btn = document.getElementById('boton');
        btn.classList.remove("disabled");
        btn.removeAttribute("disabled");
        flag = true;
    }
    return flag;
}

function errorsVerify(){

    var flag = false;
    var errors = document.getElementsByClassName("has-error");
    if(errors.length == 0){
        flag = true;
    }

    return flag;
}


function limpiarSelect(idSelect) {
  
    var elements = document.getElementById(idSelect).options;
    for(var i = 0; i < elements.length; i++){
      elements[i].selected = false;
    }
}

$('#btn_transfer').on('click', function()
{
    var select_array_idioma = document.getElementById('select_array_idioma');
    var options = "";
    var tag_idioma = document.getElementById('idioma_of');
    var tag_nivel_idioma = document.getElementById('nivel_idi_of');
    var idioma_selected_select = tag_idioma.options[tag_idioma.selectedIndex];
    var idiomanivel_selected_select = tag_nivel_idioma.options[tag_nivel_idioma.selectedIndex];
//console.log(idioma_selected_select.text);
//console.log(idiomanivel_selected_select.text);
    if(idioma_selected_select.text != 'Seleccione una opción' && idiomanivel_selected_select.text != 'Seleccione una opción'){
        
        var selected_items = document.getElementsByClassName('listado');

        var all_selected = $('#idioma_of option:disabled');
        var error_show = document.getElementById('id_span_error');
        var op = '';

        if(tag_idioma.options[0].value == 0){
            op = tag_idioma.length-1;
        }else{
            op = tag_idioma.length;             
        }

        if (all_selected.length == op) {
            mensaje = "Ha seleccionado todas las opciones disponibles";
            colocaError(listado_error, listado_group, mensaje, button_register);
        }
        else{
            enableBTN();
            quitarError(listado_error, listado_group);
            document.getElementById('text_nothing').style.display = "none";
        }
        
        if (idioma_selected_select.disabled == false)
        {
            var id_idioma = tag_idioma.value;
            var id_nivel_idioma = tag_nivel_idioma.value;
            var div_idioma = document.getElementById('list_idioma');
            var text_idioma = idioma_selected_select.text;
            var text_idioma_nivel = idiomanivel_selected_select.text;
            var p_node = document.createElement('P');
            div_idioma.appendChild(p_node);
            p_node.setAttribute("id", "idioma"+id_idioma);
            p_node.innerHTML = text_idioma+" ("+text_idioma_nivel+") <i class='fa fa-window-close fa-2x icon' id='"+id_idioma+"' onclick='delete_item_selected(this);'></i>";
            p_node.setAttribute("disabled", "disabled");
            p_node.setAttribute("class", "col-md-5 badge_item listado");
            idioma_selected_select.setAttribute("disabled", "disabled");
            var nodo_option = document.createElement('option');
            nodo_option.setAttribute("value", id_idioma+"_"+id_nivel_idioma);
            nodo_option.setAttribute("id", "array_idioma"+id_idioma);
            nodo_option.selected = "selected";
            select_array_idioma.appendChild(nodo_option);
            document.getElementById('effect_bounce').classList.remove('bounce');
            document.getElementById('btn_transfer').classList.remove('active_button');
            
            limpiarSelect("idioma_of");
            limpiarSelect("nivel_idi_of");
        }

        var all_selected = $('#idioma_of option:disabled');
        if (all_selected.length == op) {
            tag_nivel_idioma.setAttribute("disabled", true);
            tag_idioma.setAttribute("disabled", true);
        }
        quitarError(listado_error, listado_group);
        enableBTN();
    }
    /*else{

        console.log($('#idioma_of option:disabled'));
        mensaje = "Debe seleccionar un idiomas";
        colocaError(listado_error, listado_group, mensaje, button_register);
    }*/
})

function delete_item_selected(selected_item){

    var tag_idioma = document.getElementById('idioma_of');
    var tag_nivel_idioma = document.getElementById('nivel_idi_of');
    var tag_idioma_seleccionado = document.getElementById("idioma"+selected_item.id);
    tag_idioma_seleccionado.outerHTML = "";
    $("#idioma_of option[value="+selected_item.id+"]").attr("disabled",false);
    var idioma_selected_select = document.getElementById('idioma_of');
    var array_idioma_select = document.getElementById('select_array_idioma').length;
    
    if (array_idioma_select >= 1) {

        $("#"+'array_idioma'+selected_item.id).remove();
        tag_nivel_idioma.removeAttribute("disabled");
        tag_idioma.removeAttribute("disabled");

        if(selected_item.id == tag_idioma.options[tag_idioma.selectedIndex].value){
            document.getElementById('effect_bounce').classList.add('bounce');
            document.getElementById('btn_transfer').classList.add('active_button');
        }
    }

    if (document.getElementById('select_array_idioma').length <= 0)
    {
        mensaje = "Seleccione una opcion";
        colocaError(listado_error, listado_group, mensaje, button_register);
        document.getElementById('text_nothing').style.display = "";
    }
    else{
        quitarError(listado_error, listado_group);
        enableBTN();
    } 
}

/* valida si el candidato es mayor de edad */
function validarFormatoFecha(campo) {
  var RegExPattern = /^\d{1,2}-\d{1,2}-\d{4}$/;
  var values = campo.split("-");
  var dia = parseInt(values[2]);
  var mes = parseInt(values[1]);
  var ano = parseInt(values[0]);

  if((dia <= 0 || dia > 31) || (mes <= 0 || mes > 12) || (ano <= 1500 || ano > 2099)){
    return true;
  }else if ((campo.match(RegExPattern)) && (campo!='')) {
    return true;
  } else {
    return false;
  }
}

function calcularEdad(){

    var fecha=document.getElementById("fecha_nacimiento").value;

    // Si la fecha es correcta, calculamos la edad
    var values=fecha.split("-");
    var dia = values[2];
    var mes = values[1];
    var ano = values[0];

    // cogemos los valores actuales
    var fecha_hoy = new Date();
    var ahora_ano = fecha_hoy.getYear();
    var ahora_mes = fecha_hoy.getMonth()+1;
    var ahora_dia = fecha_hoy.getDate();

    // realizamos el calculo
    var edad = (ahora_ano + 1900) - ano;
    if ( ahora_mes < mes )
    {
        edad--;
    }
    if ((mes == ahora_mes) && (ahora_dia < dia))
    {
        edad--;
    }
    if (edad > 1900)
    {
        edad -= 1900;
    }

    if(edad >= 18){
        
        return 1;

    }else{
        return 0;
    }
}

/* valida si el candidato es mayor de edad */

function mostrarUni(){

    var lugar_estudio = document.getElementById("lugar_estudio");

    if(lugar_estudio){

        if(lugar_estudio.value != -1){

            if(lugar_estudio.value == 0){
                document.getElementById("universidad2").style.display = "none";
                document.getElementById("universidad").style.display = "block";
                document.getElementById("universidad").setAttribute("required",true);
                $("#universidad2").removeAttr("required");
            }else{
                document.getElementById("universidad").style.display = "none";
                document.getElementById("universidad2").style.display = "block";
                document.getElementById("universidad2").setAttribute("required",true);
                $("#universidad").removeAttr("required");
            }
        }else{
            $("#universidad").removeAttr("required");
            $("#universidad2").removeAttr("required");
        } 
    }
}

function ocultarCampos(){

    var ultimoTitulo = document.getElementById("escolaridad");

    if(ultimoTitulo){

        var id_escolaridad = ultimoTitulo.options[ultimoTitulo.selectedIndex].value;
        var puerto_host = $('#puerto_host').val();

        if(id_escolaridad != 0){
            $.ajax({
                type: "GET",
                url: puerto_host+"?mostrar=perfil&opcion=buscaDependencia&id_escolaridad="+id_escolaridad,
                dataType:'json',
                success:function(data){

                    var elements = document.getElementsByClassName("depende");
                    for(var i = 0, length = elements.length; i < length; i++) {
                        if(data.dependencia == 1){
                            document.getElementById("lugar_estudio").setAttribute("required",true);
                            elements[i].style.display = 'block';
                            validarFormulario();
                            
                        }else{
                            $("#lugar_estudio").removeAttr("required");
                            elements[i].style.display = 'none';
                            var lugar_estudio = document.getElementById("lugar_estudio");
                            lugar_estudio.selectedIndex = 0;
                            mostrarUni();
                        }
                    }

                    mostrarUni();
                },
                error: function (request, status, error) {
                    //alert(request.responseText);
                }                  
            });
        }
    }
}

function enviarFormulario(){

    var estado = validarFormulario();
    if(estado == 1){
        document.form_editarPerfil.submit();
    }
}

function validarFormulario(){

    var tipo_usuario = document.getElementById('tipo_usuario').value;
    if(tipo_usuario == 1){
      expreg = /^[a-z ÁÉÍÓÚáéíóúñÑ]+$/i;
    }else{
      expreg = /^[a-z ÁÉÍÓÚáéíóúñÑ. 0-9 &]+$/i;
    }
    //var expreg = /^[a-z A-ZñÑáéíóúÁÉÍÓÚ]+$/i;
    var expreg_telf = /^[0-9]+$/i;
    var error = 0;
    var err_list = "Debe seleccionar una opcion de la lista";
    var err_campo = "El campo no puede ser vacío";
    var err_formato_letra = "Formato incorrecto, solo letras";
    var err_formato_numeros = "Formato incorrecto, solo numeros";
    var err_univ = "Debe introducir una universidad";

    var nombres = document.getElementById('nombres').value;
    if(document.getElementById('apellidos')){
        var apellidos = document.getElementById('apellidos').value;
    }
    var nacionalidad = document.getElementById('id_nacionalidad').value;
    var fecha_nacimiento = document.getElementById('fecha_nacimiento').value;
    var telefono = document.getElementById('telefono').value;
    var provincia = document.getElementById('provincia').value;
    var ciudad = document.getElementById('ciudad').value;

    if(tipo_usuario == 1){

        var discapacidad = document.getElementById('discapacidad').selectedIndex;
        var experiencia = document.getElementById('experiencia').selectedIndex;
        var estado_civil = document.getElementById('estado_civil').selectedIndex;
        var genero = document.getElementById('genero').selectedIndex;
        var tiene_trabajo = document.getElementById('tiene_trabajo').selectedIndex;
        var residencia = document.getElementById('residencia').selectedIndex;
        var viajar = document.getElementById('viajar').selectedIndex;
        var licencia = document.getElementById('licencia').selectedIndex;
        var escolaridad = document.getElementById('escolaridad').selectedIndex;
        var estatus = document.getElementById('estatus').selectedIndex;
        var area_select = document.getElementById('area_select');
        var nivel_interes = document.getElementById('nivel_interes');
        var select_array_idioma = document.getElementById('select_array_idioma');
        var lugar_estudio = document.getElementById('lugar_estudio');
        var universidad = document.getElementById('universidad').selectedIndex;
        var universidad2 = document.getElementById('universidad2').value;
        
        var tipo_doc = document.getElementById('documentacion').value;
        var dni = document.getElementById('dni').value;
                
        if ($("#dni").is(":disabled") == false){
          if(tipo_doc != 0){          
            quitarError("seleccione_error","seleccione_group");          
            var validar = validarDocumento(dni,tipo_doc,"err_dni","seccion_dni","boton");
            if(validar == 1){            
              error = 1;
            }else{
              quitarError("err_dni","seccion_dni");
            }
          }else{
            colocaError("seleccione_error","seleccione_group",err_list,"boton");
            validarDocumento(dni,tipo_doc,"err_dni","seccion_dni","boton");
            error = 1;
          }       
        }

        if(document.getElementById('subirCV') && document.getElementById('subirCV').value != ''){
            $("#mensaje_error_hv").remove();

        }else if(document.getElementById('btnDescarga').value == 0 && document.getElementById('subirCV').value == ''){
            error = 1;
        }

        if(discapacidad == null || discapacidad == 0){
            colocaError("err_dis", "seccion_dis",err_list,"boton");
            error = 1;
        }else{
            quitarError("err_exp", "seccion_exp");
        }

        if(experiencia == null || experiencia == 0){

            colocaError("err_exp", "seccion_exp",err_list,"boton");
            error = 1;
        }else{
            quitarError("err_exp", "seccion_exp");
        }

        if(estado_civil == null || estado_civil == 0){

            colocaError("err_civil", "seccion_civil",err_list,"boton");
            error = 1;
        }else{
            quitarError("err_civil", "seccion_civil");
        }

        if(genero == null || genero == 0){

            colocaError("err_gen", "seccion_gen",err_list,"boton");
            error = 1;
        }else{
            quitarError("err_gen", "seccion_gen");
        }

        if(tiene_trabajo == null || tiene_trabajo == 0){

            colocaError("err_trab", "seccion_trab",err_list,"boton");
            error = 1;
        }else{
            quitarError("err_trab", "seccion_trab");
        }

        if(residencia == null || residencia == 0){

            colocaError("err_res", "seccion_res",err_list,"boton");
            error = 1;
        }else{
            quitarError("err_res", "seccion_res");
        }


        if(viajar == null || viajar == 0){

            colocaError("err_via", "seccion_via",err_list,"boton");
            error = 1;
        }else{
            quitarError("err_via", "seccion_via");
        }

        if(licencia == null || licencia == 0){

            colocaError("err_lic", "seccion_lic",err_list,"boton");
            error = 1;
        }else{
            quitarError("err_lic", "seccion_lic");
        }

        if(escolaridad == null || escolaridad == 0){

            colocaError("err_esc", "seccion_esc",err_list,"boton");
            error = 1;
        }else{
            quitarError("err_esc", "seccion_esc");
        }

        if(estatus == null || estatus == 0){

            colocaError("err_est", "seccion_est",err_list,"boton");
            error = 1;
        }else{
            quitarError("err_est", "seccion_est");
        }

        if($(".depende").is(":visible")){

            if(lugar_estudio.selectedIndex == null || lugar_estudio.selectedIndex == 0){

                colocaError("err_estudio", "seccion_estudio",err_list,"boton");
                if($(".depende").is(":visible") && lugar_estudio.value == -1){

                    if(universidad2 == null || universidad2 == ''){

                        colocaError("err_univ", "seccion_univ",err_univ,"boton");
                        error = 1;
                    }else{
                        quitarError("err_univ", "seccion_univ");
                    }
                } 
                error = 1;

            }else{
                quitarError("err_estudio", "seccion_estudio");
            }
        }

        if(($(".depende").is(":visible") && lugar_estudio.value == 0)){

            if(universidad == null || universidad == 0){

                colocaError("err_univ", "seccion_univ",err_list,"boton");
                error = 1;
            }else{
                quitarError("err_univ", "seccion_univ");
            }

        }else if($(".depende").is(":visible") && lugar_estudio.value == 1){

            if(universidad2 == null || universidad2 == ''){

                colocaError("err_univ", "seccion_univ",err_univ,"boton");
                error = 1;
            }else{
                quitarError("err_univ", "seccion_univ");
            }
        } 


        if(area_select.value == null || area_select.value == 0){

            colocaError("err_area", "seccion_area",err_list,"boton");
            error = 1;
        }else{

            var cantd_selec = $('#seleccionados1').find('help-block').length;
            if(cantd_selec != 0)
            {
                colocaError("err_area", "seccion_area",err_list,"boton");
                error = 1;
            }else{
                quitarError("err_area", "seccion_area");
            }
        }

        if(nivel_interes.value == null || nivel_interes.value == 0){

            colocaError("err_int", "seccion_int",err_list,"boton");
            error = 1;
        }else{
            
            var cantd_selec = $('#seleccionados2').find('help-block').length;
            if(cantd_selec != 0)
            {
                colocaError("err_int", "seccion_int",err_list,"boton");
                error = 1;
            }else{
                quitarError("err_int", "seccion_int");
            }
        }


        if((select_array_idioma.length) == 0 || (select_array_idioma.length) == -1){

            colocaError("listado_idiomas", "seccion_listado",err_list,"boton");
            error = 1;
        }else{
            quitarError("listado_idiomas", "seccion_listado");
        }

        if(apellidos.length <= '100'){

          if(document.getElementById('apellidos')){

            if(apellidos == null || apellidos.length == 0 || /^\s+$/.test(apellidos)){
                colocaError("err_ape", "seccion_apellido",err_campo,"boton");
                error = 1; 
            }else if(!expreg.test(apellidos)){
                colocaError("err_ape", "seccion_apellido",err_formato_letra,"boton");
                error = 1;
            }else{
                quitarError("err_ape","seccion_apellido");
            }
          }
        }else{
          colocaError("err_ape","seccion_apellido","El apellido no debe exceder de 100 caracteres","boton");
          error = 1; 
        }

    }else if(tipo_usuario == 2){

        var nombre_contact = document.getElementById('nombre_contact').value;
        var apellido_contact = document.getElementById('apellido_contact').value;
        var tel_one_contact = document.getElementById('tel_one_contact').value;

        if(nombre_contact.length <= '100'){
            if(nombre_contact == null || nombre_contact.length == 0 || /^\s+$/.test(nombre_contact)){

                colocaError("err_nomCon", "seccion_nombreContacto",err_campo,"boton");
                error = 1; 

            }else if(!expreg.test(nombre_contact)){

                colocaError("err_nomCon", "seccion_nombreContacto",err_formato_letra,"boton"); 
                error = 1;  
            }else{
                quitarError("err_nomCon","seccion_nombreContacto");
            }
        }else{

            colocaError("err_nomCon", "seccion_nombreContacto","El nombre no debe exceder de 100 caracteres","boton");
            error = 1; 
        }

        if(apellido_contact.length <= '100'){

            if(apellido_contact == null || apellido_contact.length == 0 || /^\s+$/.test(apellido_contact)){

                colocaError("err_apeCon", "seccion_apellidoContacto",err_campo,"boton");
                error = 1; 

            }else if(!expreg.test(apellido_contact)){

                colocaError("err_apeCon", "seccion_apellidoContacto",err_formato_letra,"boton");
                error = 1;  

            }else{
                quitarError("err_apeCon","seccion_apellidoContacto");
            }
        }else{

            colocaError("err_apeCon","seccion_apellidoContacto","El apellido no debe exceder de 100 caracteres","boton");
            error = 1; 
        }

        if(tel_one_contact.length <= '25'){

            if(tel_one_contact == null || tel_one_contact.length == 0 || /^\s+$/.test(tel_one_contact)){

                colocaError("err_tlfCon", "seccion_tlfCon",err_campo,"boton");
                error = 1;

            }else if(!expreg_telf.test(tel_one_contact)){

                colocaError("err_tlfCon", "seccion_tlfCon",err_formato_numeros,"boton");
                error = 1; 

            }else{
                quitarError("err_tlfCon","seccion_tlfCon");
            }
        }else{

            colocaError("err_tlfCon","seccion_tlfCon","El telefono no debe exceder de 25 caracteres","boton");
            error = 1; 
        }
    }

    if(nombres.length <= '100'){

        if(nombres == null || nombres.length == 0 || /^\s+$/.test(nombres)){

            colocaError("err_nom", "seccion_nombre",err_campo,"boton");
            error = 1; 

        }else if(!expreg.test(nombres)){
     
            colocaError("err_nom", "seccion_nombre",err_formato_letra,"boton");
            error = 1;

        }else{
            quitarError("err_nom","seccion_nombre");
        }

    }else{

        colocaError("err_nom","seccion_nombre","El nombre no debe exceder de 100 caracteres","boton");
        error = 1; 
    }

    if(telefono.length <= '25'){

        if(telefono == null || telefono.length == 0 || /^\s+$/.test(telefono)){

            colocaError("err_tlf", "seccion_tlf",err_campo,"boton");
            error = 1;

        }else if(!expreg_telf.test(telefono)){

            colocaError("err_tlf", "seccion_tlf",err_formato_numeros,"boton");
            error = 1; 

        }else{
            quitarError("err_tlf","seccion_tlf");
        }
    }else{

        colocaError("err_tlf","seccion_tlf","El telefono no debe exceder de 25 caracteres","boton");
        error = 1; 
    }

    if(!isNaN(fecha_nacimiento)){

        colocaError("error", "mayoria","Debe elegir una fecha válida","boton");
        error = 1;
    }else if(validarFormatoFecha(fecha_nacimiento)){

      colocaError("error", "mayoria","El formato de fecha es incorrecto","boton");
      error = 1;

    }else if(calcularEdad() == 0 && tipo_usuario == 1){

        colocaError("error", "mayoria","Debe ser mayor de edad","boton");
        error = 1;

    }else{
        quitarError("error","mayoria");
    }

    if(provincia == null || provincia == 0){

        colocaError("err_prov", "seccion_provincia",err_list,"boton");
        error = 1;
    }else{
        quitarError("err_prov","seccion_provincia");
    }

    if(ciudad == null || ciudad == 0){

        colocaError("err_ciu", "seccion_ciudad",err_list,"boton");
        error = 1;

    }else{
        quitarError("err_ciu","seccion_ciudad");
    }

    if(nacionalidad == null || nacionalidad == 0){

        colocaError("err_nac", "seccion_nac",err_list,"boton");
        error = 1;
    }else{
        quitarError("err_nac", "seccion_nac");
    }
    
    if(error == 1){
        return 0;
    }else{
        $("#boton").removeAttr('disabled');
        $("#boton").removeClass('disabled');
        return 1;
    }
}
 
function enviarCambioClave(){

    var estado = validarClave();
    if(estado == 1){
        document.form_cambiar.submit();
    }
}

function validarClave(){

    var expreg = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    var error = 0;
    var err_campo = "El campo no puede ser vacío";
    var err_formato = "Formato incorrecto, Letras y números, mínimo 8 caracteres";

    var password = document.getElementById('password').value;
    var password_two = document.getElementById('password_two').value;

    if(password == null || password.length == 0 || /^\s+$/.test(password)){

        colocaError("err_clave", "seccion_clave",err_campo,"button_cambiar");
        error = 1; 

    }else if(!expreg.test(password)){

        colocaError("err_clave", "seccion_clave",err_formato,"button_cambiar"); 
        error = 1;  
    }else{
        quitarError("err_clave", "seccion_clave");
    }

    if(password_two == null || password_two.length == 0 || /^\s+$/.test(password_two)){

        colocaError("err_clave1", "seccion_clave1",err_campo,"button_cambiar");
        error = 1; 

    }else if(!expreg.test(password_two)){

        colocaError("err_clave1", "seccion_clave1",err_formato,"button_cambiar"); 
        error = 1;  

    }else{

         if(password != password_two){
            colocaError("err_clave1", "seccion_clave1","Ingrese la misma contraseña","button_cambiar"); 
            error = 1; 
        }else{
            quitarError("err_clave1", "seccion_clave1");
        }
    }

    if(error == 1){
        return 0;
    }else{

        $("#button_cambiar").removeAttr('disabled');
        $("#button_cambiar").removeClass('disabled');
        return 1;
    }
}
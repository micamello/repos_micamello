//HACER ESTO AL MOMENTO DE TERMINAR EL TERCER CUESTIONARIO
$(document).ready(function(){
  $('#nivel_idi_of').attr('disabled', true);
  if(errorsVerify() == false){
    $('.btnPerfil').addClass('disabled');
    $('.btnPerfil').attr('disabled', 'disabled');
  }

  var datos = $('#datosGrafico').val();

  if(datos != ''){
    datos = datos.split('|');        
    var arreglo = [['Task', 'Hours per Day']];
    for (var i = 0; i < datos.length; i++) {
      var porcion = datos[i].split(',');
      porcion[1] = parseFloat(porcion[1]);
      arreglo.push(porcion);
    }
    var puerto_host = $('#puerto_host').val();
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable(arreglo);
      var options = {
        pieSliceText: 'label',
        is3D: true,
        width:3500,
        height:2000,
        pieSliceTextStyle: {color: 'black', fontName: 'dsfd', fontSize: 60},
        fontSize:80,
        legend: 'none',
        slices: {
          0: { color: '#FCDC59' },
          1: { color: '#E25050' },
          2: { color: '#8C4DCE' },
          3: { color: '#2B8DC9' },
          4: { color: '#5EB782' }
        }
      };

      document.getElementById('Chart_details').style.display='block';
      var chart_1 = new google.visualization.PieChart(document.getElementById('g_chart_1'));
      chart_1.draw(data, options);
      var chart_div = document.getElementById('chart_div');

      google.visualization.events.addListener(chart_1, 'ready', function () {

        var uri = chart_1.getImageURI();
        document.getElementById('Chart_details').style.display='none';
               //chart_div.innerHTML = '<img width="600" heigth="600" align="center" src="'+uri+'">';

        $.ajax({
          type: "POST",
          url: puerto_host+"/index.php?mostrar=velocimetro&opcion=guardarGrafico",
          data: {imagen:uri},
          dataType:'json',
        });
      });
    }
  }
});

if(document.getElementById('form_editarPerfil')){

    validarFormulario(false);
    ocultarCampos();
    mostrarUni();

    if(navegador() != 'MSIE'){

        if(document.getElementById('tipo_usuario').value == 1){
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
    }
}

$('#hoja_de_vida').on('click', function(){
    $('#modal_actualizar').modal();
});

$('#button_cambiar').on('click', function(){
    enviarCambioClave();
});

$('#boton').on('click', function(){
  enviarFormulario();
});

$('#documentacion').change(function()
{

  if($('#documentacion').val()==3){
    $('#nombre_documento').html('Pasaporte');
  }else if($('#documentacion').val()==2){
    $('#nombre_documento').html('C&eacute;dula');
  }
});


if (document.getElementById("area"))
{
  $('#area').multiple_select({
    items: 3,
    dependence: {
      id_dependencia: "subareas",
      items: false
    }
  });
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
            url: puerto_host+"/index.php?mostrar=perfil&opcion=buscaCiudad&id_provincia="+id_provincia,
            dataType:'json',
            success:function(data){
                $('#ciudad').html('<option disabled selected value="0">Selecciona una ciudad</option>');
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
              colocaError("err_ciu", "seccion_ciudad","No se ha podido completar la solicitud","boton");
            	$('#ciudad').html('<option disabled selected value="0">Selecciona una ciudad</option>');
              /*Swal.fire({                
                html: 'Ocurrio un error al consultar las ciudades',
                imageUrl: $('#puerto_host').val()+'/imagenes/wrong-04.png',
                imageWidth: 75,
                confirmButtonText: 'ACEPTAR',
                animation: true
              });   */               
            },
            beforeSend : function(){
              ajaxLoader($('#ciudad'), 'aparecer');
              ajaxLoader($('#provincia'), 'aparecer');
            },
            complete : function(){
              ajaxLoader($('#ciudad'), 'desaparecer');
              ajaxLoader($('#provincia'), 'desaparecer');
            }                
        })
    }
});

/*Permite deseleccionar las subareas seleccionadas*/
function eliminar_item_selected(selected_item,tipo,op){

    var seleccionado = document.getElementById(selected_item);
    seleccionado.outerHTML = "";

    $('#li'+selected_item).removeClass('selected');
    $("#"+tipo+" option[value='"+op+"']:selected").removeAttr("selected");
    
}

/*Muestra dinamicamente si la imagen / foto fue cargada*/
$('#file-input').change(function(e) {
   console.log(document.getElementById('file-input').files[0]);
    var error = validarImg(document.getElementById('file-input'));

    if(error == 0){
        addImage(e); 
    }
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


/*Valida si la imagen / foto fue cargada*/
function validarImg(archivo){

  var file = fileValidation(archivo,1);
  var error = 0;
  if(file == 1){
    error = 1;
  }else{
    $('#btnDescargarHV').val('cargada');
    Swal.fire({      
      html: 'Imagen cargada',
      imageUrl: $('#puerto_host').val()+'/imagenes/logo-04.png',
      imageWidth: 210,
      confirmButtonText: 'ACEPTAR',
      animation: true
    });     
  }
  return error;
}

/*Valida el peso del archivo*/
function fileValidation(fileInput,tipo){

  var filePath = fileInput.value;
  var error = 0;

    if(tipo == 1){
        var allowedExtensions = /(.jpg|.jpeg)$/i;
        if(filePath != ''){
       
            var tamano = fileInput.files[0].size/1024/1024;
            if(tamano > 1){
              Swal.fire({                
                html: 'El peso permitido es de máx. 1MB',
                imageUrl: $('#puerto_host').val()+'/imagenes/wrong-04.png',
                imageWidth: 75,
                confirmButtonText: 'ACEPTAR',
                animation: true
              });                
              error = 1;
            }else if(!allowedExtensions.exec(filePath)){
                fileInput.value = '';
                Swal.fire({                  
                  html: 'El formato permitido es .jpeg/.jpg/',
                  imageUrl: $('#puerto_host').val()+'/imagenes/wrong-04.png',
                  imageWidth: 75,
                  confirmButtonText: 'ACEPTAR',
                  animation: true
                });                
                error =1;
            }else{
              error = 0;
            }
        }
    }else{
        var allowedExtensions = /(.pdf|.doc|.docx)$/i;
        if(filePath != ''){
       
            var tamano = fileInput.files[0].size/1024/1024;
            if(tamano > 2){
              Swal.fire({                
                html: 'El peso permitido de la hoja de vida es máx. 2MB',
                imageUrl: $('#puerto_host').val()+'/imagenes/wrong-04.png',
                imageWidth: 75,
                confirmButtonText: 'ACEPTAR',
                animation: true
              });                  
              error = 1;
            }else if(!allowedExtensions.exec(filePath)){
                fileInput.value = '';
                Swal.fire({                  
                  html: 'El formato permitido de la hoja de vida es .pdf/.doc/.docx/',
                  imageUrl: $('#puerto_host').val()+'/imagenes/wrong-04.png',
                  imageWidth: 75,
                  confirmButtonText: 'ACEPTAR',
                  animation: true
                });                
                error =1;
            }else{
              error = 0;
            }
        }else{
           Swal.fire({              
              html: 'Cargar la hoja de vida es obligatorio',
              imageUrl: $('#puerto_host').val()+'/imagenes/wrong-04.png',
              imageWidth: 75,
              confirmButtonText: 'ACEPTAR',
              animation: true
           });               
        }
    }

  return error;
}

/* Carga de hoja de vida */
$('#subirCV').change(function(e) {

    var file = fileValidation(document.getElementById('subirCV'),2);
    var error = 0;
    if(file == 1){
        error = 1;
    }else{
      $('#btnDescargarHV').val('cargada');
      Swal.fire({        
        html: 'Hoja de vida cargada',
        imageUrl: $('#puerto_host').val()+'/imagenes/logo-04.png',
        imageWidth: 210,
        confirmButtonText: 'ACEPTAR',
        animation: true
      });      
      $('#modal_actualizar').modal('hide');
    }
});

/*Eventos del campo de idiomas*/
$('#idioma_of').on('change', function(){
  $('#nivel_idi_of').attr('disabled', false);
});

$('#nivel_idi_of').on('change', function(){
    addIdioma();
    $('#nivel_idi_of').attr('disabled', true);
});

/*Valrifica si no existe algún error en los inputs*/
function enableBTN(event){
    
    var flag = false;
    if(errorsVerify() != false){
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

/*Permite transferir los idiomas de la lista de select al div de seleccionados*/
// $('#btn_transfer').on('click', function()
function addIdioma(){
    var select_array_idioma = document.getElementById('select_array_idioma');
    var options = "";
    var tag_idioma = document.getElementById('idioma_of');
    var tag_nivel_idioma = document.getElementById('nivel_idi_of');
    var idioma_selected_select = tag_idioma.options[tag_idioma.selectedIndex];
    var idiomanivel_selected_select = tag_nivel_idioma.options[tag_nivel_idioma.selectedIndex];

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
            // document.getElementById('effect_bounce').classList.remove('bounce');
            
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

}
// )

/*Permite deseleccionar los idiomas seleccionados*/
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
            // document.getElementById('effect_bounce').classList.add('bounce');
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

/*Valida el formato de la fecha*/
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
/* valida si el candidato es mayor de edad */
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
          ajaxLoader($('#universidad'), 'aparecer');
          document.getElementById("universidad2").style.display = "none";
          document.getElementById("universidad").style.display = "block";
          document.getElementById("universidad").setAttribute("required",true);
          $("#universidad2").removeAttr("required");
          ajaxLoader($('#universidad'), 'desaparecer');
        }else{
          ajaxLoader($('#universidad2'), 'aparecer');
          document.getElementById("universidad").style.display = "none";
          document.getElementById("universidad2").style.display = "block";
          document.getElementById("universidad2").setAttribute("required",true);
          $("#universidad").removeAttr("required");
          ajaxLoader($('#universidad2'), 'desaparecer');
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
                url: puerto_host+"/index.php?mostrar=perfil&opcion=buscaDependencia&id_escolaridad="+id_escolaridad,
                dataType:'json',
                success:function(data){

                    var elements = document.getElementsByClassName("depende");
                    for(var i = 0, length = elements.length; i < length; i++) {
                        if(data.dependencia == 1){
                            document.getElementById("lugar_estudio").setAttribute("required",true);
                            elements[i].style.display = 'block';
                            validarFormulario(false);
                            
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
                    colocaError("err_esc", "seccion_esc","No se ha podido completar la solicitud","boton");
                },
                beforeSend : function(){
                  ajaxLoader($('#escolaridad'), 'aparecer');
                  ajaxLoader($('#lugar_estudio'), 'aparecer');
                  
                },
                complete : function(){
                  ajaxLoader($('#escolaridad'), 'desaparecer');
                  ajaxLoader($('#lugar_estudio'), 'desaparecer');
                }                   
            });
        }
    }
}

function enviarFormulario(){
    var estado = validarFormulario(true);    

    if($('#tipo_usuario').val() == 2){
      
      if(estado == ''){
        $('.loaderMic').css('display', 'block');
        document.form_editarPerfil.submit();

        console.log('ir abajo');
        var destino = $('#boton');
        $('html, body').animate({ scrollTop: destino.offset().top }, 700); 
      }
      else if(estado != ''){
        //mostrarERRORES
        Swal.fire({
          // title: '¡Advertencia!',        
          html: 'Por favor complete los campos con (*)<br>',
          imageUrl: $('#puerto_host').val()+'/imagenes/wrong-04.png',
          imageWidth: 75,
          confirmButtonText: 'ACEPTAR',
          animation: true
        });      
      }
      
    }else if($('#tipo_usuario').val() == 1){

      var file = document.getElementById('btnDescargarHV').value;
      if(estado == '' && file != ''){
          $('.loaderMic').css('display', 'block');
          document.form_editarPerfil.submit();
      }
      else if(estado != '' && file != ''){
        //mostrarERRORES
        Swal.fire({
          // title: '¡Advertencia!',        
          html: 'Por favor complete los campos con (*)<br>',
          imageUrl: $('#puerto_host').val()+'/imagenes/wrong-04.png',
          imageWidth: 75,
          confirmButtonText: 'ACEPTAR',
          animation: true
        });      
      }else if(estado == '' && file == ''){
          //solo falta hoja de vida
        Swal.fire({
          // title: '¡Advertencia!',        
          html: 'Por favor cargue su hoja de vida. <br>',
          imageUrl: $('#puerto_host').val()+'/imagenes/wrong-04.png',
          imageWidth: 75,
          confirmButtonText: 'ACEPTAR',
          animation: true
        });
      }
      else if(estado != '' && file == ''){
        // error de ambos lados
          Swal.fire({
              // title: '¡Advertencia!',        
              html: 'Por favor cargue su hoja de vida y complete los campos con (*)<br>',
              imageUrl: $('#puerto_host').val()+'/imagenes/wrong-04.png',
              imageWidth: 75,
              confirmButtonText: 'ACEPTAR',
              animation: true
            });
      }
    }
}


function validarDni(){

}

function validarNombreApellido(nombre){
    if((/^[A-Za-zÁÉÍÓÚñáéíóúÑ ]{1,}$/.test(nombre)) && (/(.*[a-zA-ZÁÉÍÓÚñáéíóúÑ]){1}/.test(nombre))){
        return true;
    }
    else{
        return false;
    }
}

function validarNombreEmpresa(nombre){
    if((/^([a-zA-ZÁÉÍÓÚñáéíóúÑ]+[0-9&.,' ]*)*$/.test(nombre))){
        return true;
    }
    else{
        return false;
    }
}

function ValidURL(str) {
  var regex = /^(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})/;
  if(!regex .test(str)) {
    return false;
  } else {
    return true;
  }
}

function validarFormulario(tipovalidacion){

    var mensaje = '';
    var tipo_usuario = document.getElementById('tipo_usuario').value;

    var expreg_telf = /^[0-9]+$/i;
    var error = 0;
    var err_list = "Debe seleccionar una opción";
    var err_campo = "No puede ser vacío";
    var err_formato_letra = "Solo letras, mín. 1 caracter";
    var err_formato_letra2 = "Solo letras, mín. 3 caracter";
    var err_formato_numeros = "Solo números";
    var err_univ = "Debe introducir una universidad";

    var nombres = document.getElementById('nombres').value;
    if(document.getElementById('apellidos')){
        var apellidos = document.getElementById('apellidos').value;
    }
    var nacionalidad = document.getElementById('id_nacionalidad').value;
    var telefono = document.getElementById('telefono').value;
    var provincia = document.getElementById('provincia').value;
    var ciudad = document.getElementById('ciudad').value;

    if(tipo_usuario == 1){
        
        var fecha_nacimiento = document.getElementById('fecha_nacimiento').value;
        var discapacidad = document.getElementById('discapacidad').selectedIndex;
        var estado_civil = document.getElementById('estado_civil').selectedIndex;
        var genero = document.getElementById('genero').selectedIndex;
        var tiene_trabajo = document.getElementById('tiene_trabajo').selectedIndex;
        var residencia = document.getElementById('residencia').selectedIndex;
        var viajar = document.getElementById('viajar').selectedIndex;
        var escolaridad = document.getElementById('escolaridad').selectedIndex;
        var area_select = document.getElementById('area');
        var select_array_idioma = document.getElementById('select_array_idioma');
        var lugar_estudio = document.getElementById('lugar_estudio');
        var universidad = document.getElementById('universidad').selectedIndex;
        var universidad2 = document.getElementById('universidad2').value;
        var convencional = document.getElementById('convencional').value;
        
        var tipo_doc = document.getElementById('documentacion').value;
        var dni = document.getElementById('dni').value;
                
        if ($("#dni").is(":disabled") == false ){
          if(tipo_doc != 0){          
            quitarError("seleccione_error","seleccione_group");          
          }else{
            colocaError("seleccione_error","seleccione_group",err_list,"boton");
            mensaje += '- Tipo de documento, '+err_list+'<br>';
            error = 1;
          }          
          
          if($('#dni').val() != ""){
            if (tipovalidacion == true){
              if(document.getElementById('dni').value.length >= 10){
                if(searchAjax($('#dni'),tipo_doc) == false){
                  if(DniRuc_Validador($('#dni'),tipo_doc) == true){
                    quitarError("err_dni","seccion_dni");
                  }else{
                    colocaError("err_dni", "seccion_dni","Documento no válido","boton");
                    mensaje += "- Documento ingresado no es válido"+'<br>';
                    error = 1;      
                  }
                }else{
                  colocaError("err_dni", "seccion_dni","Documento ya existe","boton");
                  mensaje += "- Documento ingresado ya existe"+'<br>'; 
                  error = 1; 
                } 
              }else if(tipo_doc == 2 && document.getElementById('dni').value.length < 10){
                colocaError("err_dni", "seccion_dni","Documento mínimo de 10 dígitos","boton");
                error = 1;
                mensaje += "- El número de cédula debe tener mínimo 10 dígitos"+'<br>';
              }else if(tipo_doc == 3 && document.getElementById('dni').value.length < 6){
                console.log(document.getElementById('dni').value.length);
                colocaError("err_dni", "seccion_dni","Documento mínimo de 6 dígitos","boton");
                error = 1;
                mensaje += "- El pasaporte debe tener mínimo 6 dígitos"+'<br>';
              }
              else if(tipo_doc == 1 && document.getElementById('dni').value.length < 13){
                colocaError("err_dni", "seccion_dni","Documento mínimo de 13 dígitos","boton");
                error = 1;
                mensaje += "- El RUC debe tener mínimo 13 dígitos"+'<br>';
              }else{
                quitarError("err_dni","seccion_dni");
              }
            }    
          }else{
            colocaError("err_dni", "seccion_dni",err_campo,"boton");
            mensaje += "- Documento no puede ser vacío"+'<br>';
            error = 1;
          }
        }

        if(discapacidad == null || discapacidad == 0){
            colocaError("err_dis", "seccion_dis",err_list,"boton");
            mensaje += '- Discapacidad, '+err_list+'<br>';
            error = 1;
        }else{
            quitarError("err_dis", "seccion_dis");
        }

        if(estado_civil == null || estado_civil == 0){

            colocaError("err_civil", "seccion_civil",err_list,"boton");
            error = 1;
        }else{
            quitarError("err_civil", "seccion_civil");
        }

        if(genero == null || genero == 0){

            colocaError("err_gen", "seccion_gen",err_list,"boton");
            mensaje += '- Genero, '+err_list+'<br>';
            error = 1;
        }else{
            quitarError("err_gen", "seccion_gen");
        }

        if(tiene_trabajo == null || tiene_trabajo == 0){

            colocaError("err_trab", "seccion_trab",err_list,"boton");
            mensaje += '- Situaci\u00F3n laboral, '+err_list+'<br>';
            error = 1;
        }else{
            quitarError("err_trab", "seccion_trab");
        }

        if(residencia == null || residencia == 0){

            colocaError("err_res", "seccion_res",err_list,"boton");
            mensaje += '- Cambio de residencia?, '+err_list+'<br>';
            error = 1;
        }else{
            quitarError("err_res", "seccion_res");
        }


        if(viajar == null || viajar == 0){

            colocaError("err_via", "seccion_via",err_list,"boton");
            mensaje += '- Puede viajar?, '+err_list+'<br>';
            error = 1;
        }else{
            quitarError("err_via", "seccion_via");
        }

        if(escolaridad == null || escolaridad == 0){

            colocaError("err_esc", "seccion_esc",err_list,"boton");
            mensaje += '- Escolaridad, '+err_list+'<br>';
            error = 1;
        }else{
            quitarError("err_esc", "seccion_esc");
        }

        if($(".depende").is(":visible")){

            if(lugar_estudio.selectedIndex == null || lugar_estudio.selectedIndex == 0){

                colocaError("err_estudio", "seccion_estudio",err_list,"boton");
                if($(".depende").is(":visible") && lugar_estudio.value == -1){

                    if(universidad2 == null || universidad2 == ''){

                        colocaError("err_univ", "seccion_univ",err_univ,"boton");
                        mensaje += '- Universidad, '+err_list+'<br>';
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
                mensaje += '- Universidad, '+err_list+'<br>';
                error = 1;
            }else{
                quitarError("err_univ", "seccion_univ");
            }

        }else if($(".depende").is(":visible") && lugar_estudio.value == 1){

            if(universidad2 == null || universidad2 == ''){

                colocaError("err_univ", "seccion_univ",err_univ,"boton");
                mensaje += '- Universidad, '+err_list+'<br>';
                error = 1;
            }else{
                quitarError("err_univ", "seccion_univ");
            }
        } 
        
        if(area_select.value == null || area_select.value == 0){

            colocaError("err_area", "seccion_area",err_list,"boton");
            mensaje += '- \u00C1reas, '+err_list+'<br>';
            error = 1;
        }else{

            quitarError("err_area", "seccion_area");
        }

        if((select_array_idioma.length) == 0 || (select_array_idioma.length) == -1){

            colocaError("listado_idiomas", "seccion_listado",err_list,"boton");
            mensaje += '- Listado de idiomas, '+err_list+'<br>';
            error = 1;
        }else{
            quitarError("listado_idiomas", "seccion_listado");
        }

        if(document.getElementById('apellidos')){

            if(apellidos.length <= '100'){

                if(apellidos == null || apellidos.length == 0 || /^\s+$/.test(apellidos)){
                    colocaError("err_ape", "seccion_apellido",err_campo,"boton");
                    mensaje += '- Apellidos, '+err_campo+'<br>';
                    error = 1; 
                }else if(!validarNombreApellido(apellidos)){
                    colocaError("err_ape", "seccion_apellido",err_formato_letra,"boton");
                    mensaje += '- Apellidos, '+err_formato_letra+'<br>';
                    error = 1;
                }else{
                    quitarError("err_ape","seccion_apellido");
                }
             
            }else{
              colocaError("err_ape","seccion_apellido","Longitud máx. 100 caracteres","boton");
              mensaje += '- Apellidos, El apellido no debe exceder de 100 caracteres<br>';
              error = 1; 
            }
        }

        if(convencional.length != ''){

            if(convencional.length < '9'){
                colocaError("err_tlfCon","seccion_tlfCon","Longitud mín. 9 caracteres","boton");
                mensaje += '- Tel\u00E9fono convencional, longitud m\u00EDn. 9 caracteres<br>'; 
                error = 1; 
            }else if(convencional.length > '9'){

                colocaError("err_tlfCon","seccion_tlfCon","Longitud máx. 9 caracteres","boton");
                mensaje += '- Tel\u00E9fono convencional, longitud m\u00E1x. 9 caracteres<br>'; 
                error = 1; 
            }else{
               quitarError("err_tlfCon","seccion_tlfCon"); 
            }
        }

        if(nombres.length <= '100'){

            if(nombres == null || nombres.length == 0 || /^\s+$/.test(nombres)){

                colocaError("err_nom", "seccion_nombre",err_campo,"boton");
                mensaje += '- Nombres, '+err_campo+'<br>';
                error = 1; 

            }else if(!validarNombreApellido(nombres)){
         
                colocaError("err_nom", "seccion_nombre",err_formato_letra,"boton");
                mensaje += '- Nombres, '+err_formato_letra+'<br>';
                error = 1;

            }else{
                quitarError("err_nom","seccion_nombre");
            }

        }else{

            colocaError("err_nom","seccion_nombre","Longitud máx. 100 caracteres","boton");
            mensaje += '- Nombres, no debe exceder de 100 caracteres<br>';
            error = 1; 
        }

        if(!isNaN(fecha_nacimiento)){

            colocaError("error", "mayoria","Elegir una fecha válida","boton");
            mensaje += '- Fecha de nacimiento, debe elegir una fecha válida<br>';
            error = 1;
        }else if(validarFormatoFecha(fecha_nacimiento)){

          colocaError("error", "mayoria","Formato incorrecto","boton");
          mensaje += '- Fecha de nacimiento, El formato de fecha es incorrecto<br>';
          error = 1;

        }else if(calcularEdad() == 0 && tipo_usuario == 1){

            colocaError("error", "mayoria","Debe ser mayor de edad","boton");
            mensaje += '- Fecha de nacimiento, debe ser mayor de edad<br>';
            error = 1;

        }else{
            quitarError("error","mayoria");
        }

        if(telefono == null || telefono.length == 0 || /^\s+$/.test(telefono)){

            colocaError("err_tlf", "seccion_tlf",err_campo,"boton");
            mensaje += '- Celular, '+err_campo+'<br>';
            error = 1;
            
        }else if(telefono.length >= '10' && telefono.length <= '15'){ 

            if(!expreg_telf.test(telefono)){

                colocaError("err_tlf", "seccion_tlf",err_formato_numeros,"boton");
                mensaje += '- Celular, '+err_formato_numeros+'<br>';
                error = 1; 

            }else{
                quitarError("err_tlf","seccion_tlf");
            }
        }else if(telefono.length < '10'){
            colocaError("err_tlf","seccion_tlf","Longitud mín. 10 caracteres","boton");
            mensaje += '- Celular, longitud m\u00EDn. 10 caracteres<br>'; 
            error = 1; 
        }else if(telefono.length > '15'){

            colocaError("err_tlf","seccion_tlf","Longitud máx. 15 caracteres","boton");
            mensaje += '- Celular, longitud m\u00E1x. 15 caracteres<br>'; 
            error = 1; 
        }else{
            quitarError("err_tlf","seccion_tlf");
        }

    }else if(tipo_usuario == 2){

        var nombre_contact = document.getElementById('nombre_contact').value;
        var apellido_contact = document.getElementById('apellido_contact').value;
        var tel_one_contact = document.getElementById('tel_one_contact').value;
        var tel_two_contact = document.getElementById('tel_two_contact').value;
        var pagina_web = document.getElementById('pagina_web').value;
        var sectorind = document.getElementById('sectorind').value;
        var nro_trabajadores = document.getElementById('nro_trabajadores').value;
        var cargo = document.getElementById('cargo').value;

        if(nombres.length <= '100'){

            if(nombres == null || nombres.length == 0 || /^\s+$/.test(nombres)){

                colocaError("err_nom", "seccion_nombre",err_campo,"boton");
                mensaje += '- Nombre de la empresa, '+err_campo+'<br>';
                error = 1; 

            }else if(!validarNombreEmpresa(nombres)){
         
                colocaError("err_nom", "seccion_nombre","Formato incorrecto","boton");
                mensaje += '- Nombre de la empresa, Formato incorrecto<br>';
                error = 1;

            }else{
                quitarError("err_nom","seccion_nombre");
            }

        }else{

            colocaError("err_nom","seccion_nombre","Longitud máx. 100 caracteres","boton");
            mensaje += '- Nombre de la empresa, no debe exceder de 100 caracteres<br>';
            error = 1; 
        }

        if(nombre_contact.length <= '100'){
            if(nombre_contact == null || nombre_contact.length == 0 || /^\s+$/.test(nombre_contact)){

                colocaError("err_nomCon", "seccion_nombreContacto",err_campo,"boton");
                mensaje += '- Nombre de contacto, '+err_campo+'<br>';
                error = 1; 

            }else if(!validarNombreEmpresa(nombre_contact)){

                colocaError("err_nomCon", "seccion_nombreContacto","Formato incorrecto","boton");
                mensaje += '- Nombre de contacto, '+"Formato incorrecto"+'<br>'; 
                error = 1;  
            }else{
                quitarError("err_nomCon","seccion_nombreContacto");
            }
        }else{

            colocaError("err_nomCon", "seccion_nombreContacto","Longitud máx. 100 caracteres","boton");
            mensaje += '- Nombre de contacto, no debe exceder de 100 caracteres<br>'; 
            error = 1; 
        }

        if(apellido_contact.length <= '100'){

            if(apellido_contact == null || apellido_contact.length == 0 || /^\s+$/.test(apellido_contact)){

                colocaError("err_apeCon", "seccion_apellidoContacto",err_campo,"boton");
                mensaje += '- Apellido de contacto, '+err_campo+'<br>';
                error = 1; 

            }else if(!validarNombreEmpresa(apellido_contact)){

                colocaError("err_apeCon", "seccion_apellidoContacto",err_formato_letra,"boton");
                mensaje += '- Apellido de contacto, '+err_formato_letra+'<br>';
                error = 1;  

            }else{
                quitarError("err_apeCon","seccion_apellidoContacto");
            }
        }else{

            colocaError("err_apeCon","seccion_apellidoContacto","Longitud máx. 100 caracteres","boton");
            mensaje += '- Apellido de contacto, no debe exceder de 100 caracteres<br>'; 
            error = 1; 
        }

        if(tel_one_contact == null || tel_one_contact.length == 0 || /^\s+$/.test(tel_one_contact)){

            colocaError("err_tlfCel", "seccion_tlfCel",err_campo,"boton");
            mensaje += '- Celular de contacto, '+err_campo+'<br>';
            error = 1;

        }else if(tel_one_contact.length >= '10' && tel_one_contact.length <= '15'){

            if(!expreg_telf.test(tel_one_contact)){

                colocaError("err_tlfCel", "seccion_tlfCel",err_formato_numeros,"boton");
                mensaje += '- Celular de contacto, '+err_formato_numeros+'<br>';
                error = 1; 

            }else{
                quitarError("err_tlfCel","seccion_tlfCel");
            }

        }else if(tel_one_contact.length < '10'){
            colocaError("err_tlfCel","seccion_tlfCel","Longitud mín. 10 caracteres","boton");
            mensaje += '- Celular de contacto, longitud m\u00EDn. 10 caracteres<br>'; 
            error = 1; 
        }else if(tel_one_contact.length > '15'){

            colocaError("err_tlfCel","seccion_tlfCel","Longitud máx. 15 caracteres","boton");
            mensaje += '- Celular de contacto, longitud m\u00E1x. 15 caracteres<br>'; 
            error = 1; 
        }else{
           quitarError("err_tlfCel","seccion_tlfCel"); 
        }

        if(tel_two_contact.length != ''){

            if(tel_two_contact.length < '9'){
                colocaError("err_tlfCon2","seccion_tlfCon2","Longitud mín. 9 caracteres","boton");
                mensaje += '- Tel\u00E9fono convencional, longitud m\u00EDn. 9 caracteres<br>'; 
                error = 1; 
            }else if(tel_two_contact.length > '9'){

                colocaError("err_tlfCon2","seccion_tlfCon2","Longitud máx. 9 caracteres","boton");
                mensaje += '- Tel\u00E9fono convencional, longitud m\u00E1x. 9 caracteres<br>'; 
                error = 1; 
            }else{
                quitarError("err_tlfCon2","seccion_tlfCon2");
            }
        }

        if(telefono == null || telefono.length == 0 || /^\s+$/.test(telefono)){

            colocaError("err_tlf", "seccion_tlf",err_campo,"boton");
            mensaje += '- Tel\u00E9fono, '+err_campo+'<br>';
            error = 1;
            
        }else if(telefono.length >= '9' && telefono.length <= '15'){ 

            if(!expreg_telf.test(telefono)){

                colocaError("err_tlf", "seccion_tlf",err_formato_numeros,"boton");
                mensaje += '- Tel\u00E9fono, '+err_formato_numeros+'<br>';
                error = 1; 

            }else{
                quitarError("err_tlf","seccion_tlf");
            }
        }else if(telefono.length < '9'){
            colocaError("err_tlf","seccion_tlf","Longitud mín. 9 caracteres","boton");
            mensaje += '- Tel\u00E9fono, longitud m\u00EDn. 9 caracteres<br>'; 
            error = 1; 
        }else if(telefono.length > '15'){

            colocaError("err_tlf","seccion_tlf","Longitud máx. 15 caracteres","boton");
            mensaje += '- Tel\u00E9fono, longitud m\u00E1x. 15 caracteres<br>'; 
            error = 1; 
        }else{
            quitarError("err_tlf","seccion_tlf");
        }

        if(pagina_web.length != 0){

            if(!ValidURL(pagina_web)){
                colocaError("err_pag", "seccion_pag","Formato incorrecto","boton");
                mensaje += '- La p\u00E1gina tiene un formato incorrecto, '+err_campo+'<br>';
                error = 1;
            }else{
                quitarError("err_pag","seccion_pag");
            }
        }else{
            quitarError("err_pag","seccion_pag");
        }

        if(sectorind == null || sectorind == 0){

            colocaError("err_sector", "seccion_sector",err_list,"boton");
            mensaje += '- Sector industrial, '+err_list+'<br>';
            error = 1;
        }else{
            quitarError("err_sector","seccion_sector");
        }

        if(nro_trabajadores == null || nro_trabajadores == 0){

            colocaError("err_nro", "seccion_nro",err_list,"boton");
            mensaje += '- N\u00FAmero de trabajadores, '+err_list+'<br>';
            error = 1;
        }else{
            quitarError("err_nro","seccion_nro");
        }

        if(cargo == null || cargo == 0){

            colocaError("err_cargo", "seccion_cargo",err_list,"boton");
            mensaje += '- Cargo, '+err_list+'<br>';
            error = 1;
        }else{
            quitarError("err_cargo","seccion_cargo");
        }

    }

    if(provincia == null || provincia == 0){

        colocaError("err_prov", "seccion_provincia",err_list,"boton");
        mensaje += '- Provincia, '+err_list+'<br>';
        error = 1;
    }else{
        quitarError("err_prov","seccion_provincia");
    }

    if(ciudad == null || ciudad == 0){

        colocaError("err_ciu", "seccion_ciudad",err_list,"boton");
        mensaje += '- Ciudad, '+err_list+'<br>';
        error = 1;

    }else{
        quitarError("err_ciu","seccion_ciudad");
    }

    if(nacionalidad == null || nacionalidad == 0){

        colocaError("err_nac", "seccion_nac",err_list,"boton");
        mensaje += '- Nacionalidad, '+err_list+'<br>';
        error = 1;
    }else{
        quitarError("err_nac", "seccion_nac");
    }

    if(error == 1){
        return mensaje;
    }else{
        return '';
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
    var expreg_ant = /^[A-Za-z\d]{8,}$/;
    var error = 0;
    var err_campo = "El campo no puede ser vacío";
    var err_formato = "Letras y números, mín. 8 dígitos";

    var password = document.getElementById('password').value;
    var password_two = document.getElementById('password_two').value;

    if(document.getElementById('password_ant')){

        var password_ant = document.getElementById('password_ant').value;

        if(password_ant == null || password_ant.length == 0 || /^\s+$/.test(password_ant)){

            colocaError("err_clave_ant", "seccion_clave_ant",err_campo,"button_cambiar");
            error = 1; 

        }else if(!expreg_ant.test(password_ant)){

            colocaError("err_clave_ant", "seccion_clave_ant",err_formato,"button_cambiar"); 
            error = 1;  
        }else{
            quitarError("err_clave_ant", "seccion_clave_ant");
        }
    }

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
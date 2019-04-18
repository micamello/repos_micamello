$(window).on('load',function(){  
  $("#panel_1").hide();
  $("#panel_2").show();
  $("#panel_3").hide();

  $("#tipo_doc").change(function(){    
    if ($(this).val() == 1){
      $("#dni").attr("minlength","13");
      $("#dni").attr("maxlength","13");
    }
    else if($(this).val() == 2){
      $("#dni").attr("minlength","10");
      $("#dni").attr("maxlength","10");
    }
    else{
      $("#dni").attr("minlength","7");
      $("#dni").attr("maxlength","15");
    }
  });

});

function cambia(radioSeleccionado){  
  document.getElementById('tipoSeleccionado').value = radioSeleccionado;
}

$("input[name=select_form]").click( function() {
  if ($('input[name=select_form]:checked').val() == '2'){
    $("#panel_2").show();
    $("#panel_1").hide();
    $("#panel_3").hide();
  }
  else if($('input[name=select_form]:checked').val() == '3'){
    $("#panel_2").hide();
    $("#panel_1").hide();
    $("#panel_3").show();
  }
  else{
    $("#panel_1").show();
    $("#panel_2").hide();
    $("#panel_3").hide();
  }
});


$('#provincia').change(function(){
  var id_provincia = $('select[id=provincia]').val();
  var puerto_host = $('#puerto_host').val();

  if(id_provincia != ""){
    $.ajax({
      type: "GET",
      url: puerto_host+"index.php?mostrar=perfil&opcion=buscaCiudad&id_provincia="+id_provincia,
      dataType:'json',
      success:function(data){
        $('#ciudad').html('<option value="">Selecciona una ciudad</option>');
        $.each(data, function(index, value) {
            $('#ciudad').append("<option value='"+value.id_ciudad+"'>"+value.ciudad+"</option>");
        });
      },
      error: function (request, status, error) {
        alert(request.responseText);
      }                  
    })
  }
});

$('#provinciaP').change(function(){
  var id_provincia = $('select[id=provinciaP]').val();
  var puerto_host = $('#puerto_host').val();

  if(id_provincia != ""){
    $.ajax({
      type: "GET",
      url: puerto_host+"index.php?mostrar=perfil&opcion=buscaCiudad&id_provincia="+id_provincia,
      dataType:'json',
      success:function(data){
        $('#ciudadP').html('<option value="">Selecciona una ciudad</option>');
        $.each(data, function(index, value) {
            $('#ciudadP').append("<option value='"+value.id_ciudad+"'>"+value.ciudad+"</option>");
        });
      },
      error: function (request, status, error) {
        alert(request.responseText);
      }                  
    })
  }
});


$('#btn_submitpaypal').click(function(){  
  var valor = $('#idplanP').val()+'|'+$('#usuarioP').val()+'|'+$('#tipousuP').val()+'|'+reemplazar($('#nombreP').val())+'|'+$('#correoP').val()+'|'+$('#tipo_docP').val()+'|'+$('#telefonoP').val()+'|'+$('#dniP').val()+'|'+reemplazar($('#direccionP').val());
  $('#custom').attr('value',valor);
  console.log('v2: '+valor);
});

$('#imagen').change(function(e) {
    addImage(e); 
    validarImg(document.getElementById('imagen'),'err_img','seccion_img',"btndeposito");
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
    $('#divimagen').html('<img width="130" height="130" src="'+result+'">');
    validaCampos(2);
}

function validaCampos(tipo){

  if(tipo == 1){
    var elem = $('#form_paypal').find('input[type!="hidden"]');
    var btn = 'btn_submitpaypal';
    var select = document.getElementById('tipo_docP').value;
  }else{
    var elem = $('#form_deposito').find('input[type!="hidden"]');
    var btn = 'btndeposito';
    var select = document.getElementById('tipo_doc').value;
  }

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
    if(tipo == 1){    
      var valor = $('#idplanP').val()+'|'+$('#usuarioP').val()+'|'+$('#tipousuP').val()+'|'+reemplazar($('#nombreP').val())+'|'+$('#correoP').val()+'|'+$('#tipo_docP').val()+'|'+$('#telefonoP').val()+'|'+$('#dniP').val()+'|'+reemplazar($('#direccionP').val());
      $('#custom').attr('value',valor);
      console.log('v1: '+valor);
      document.getElementById('form_paypal').action = document.getElementById('rutaPAYPAL').value;      
    }
  }
}
/*
function validarCorreo(correo,err_correo,seccion_correo,btn){

  var error = 0;
  var expreg_correo = /^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/i;

  if(correo == null || correo.length == 0 || /^\s+$/.test(correo)){

    colocaError(err_correo, seccion_correo,"El campo no puede ser vacío",btn);
    error = 1; 

  }else if(!expreg_correo.test(correo)){

    colocaError(err_correo,seccion_correo,"Formato incorrecto, no es un correo válido",btn); 
    error = 1;  

  }else{
    quitarError(err_correo,seccion_correo);
  }
  return error;
}

function validarInput(campo,err,err_campo,btn){

  var error = 0;
  var expreg = /^[a-z A-ZñÑáéíóúÁÉÍÓÚ]+$/i;

  if(campo == null || campo.length == 0 || /^\s+$/.test(campo)){
    colocaError(err,err_campo,"El campo no puede ser vacío",btn);
    error = 1; 
  }else if(!expreg.test(campo)){
    colocaError(err,err_campo,"Formato incorrecto, solo letras",btn);
    error = 1;
  }else{
    quitarError(err,err_campo);
  }
  return error;
}

function validarDir(direccion,err_dir, seccion_dir,btn){

  var error = 0;
  var expreg1 = /^[a-z A-Z 0-9 ÁÉÍÓÚáéíóúñÑ]+$/i;

  if(direccion == null || direccion.length == 0 || /^\s+$/.test(direccion)){

    colocaError(err_dir, seccion_dir,"El campo no puede ser vacío",btn);
    error = 1; 

  }else if(!expreg1.test(direccion)){

    colocaError(err_dir, seccion_dir,"Formato incorrecto, solo letras y números",btn); 
    error = 1;

  }else{
      quitarError(err_dir,seccion_dir);
  }
  return error;
}
*/

function validarSelect(id,err_select,err_group_select,btn){

  var error = 0;
  if(id != 0){
    quitarError(err_select,err_group_select);
  }else{
    colocaError(err_select,err_group_select,"Debe seleccionar una opcion de la lista",btn);
    error = 1;
  }

  return error;
}

/*function validarNumTelf(num,err_telf,seccion_telf,btn){

  var expreg_telf = /^[0-9]+$/i;
  var error = 0;

  if(num == null || num.length == 0 || /^\s+$/.test(num)){

      colocaError(err_telf,seccion_telf,"El campo no puede ser vacío",btn);
      error = 1;

  }else if(!expreg_telf.test(num)){

      colocaError(err_telf,seccion_telf,"Formato incorrecto, solo numeros",btn);
      error = 1; 

  }else{
      quitarError(err_telf,seccion_telf);
  }
  return error;
}*/

function validarImg(archivo,err_img,seccion_img,btn){

  var file = fileValidation(archivo);
  var error = 0;
  if(file == 1){
    error = 1;
  }else{
    quitarError(err_img, seccion_img,btn);
  }
  return error;
}

$('#correoP').on('blur', function(){

  var correoP = document.getElementById('correoP').value;
  validarCorreo(correoP,'err_correoP','seccion_correoP','btn_submitpaypal');
  validaCampos(1);
});

$('#tipo_docP').on('change', function(){

    var tipo_doc = document.getElementById('tipo_docP').value;

    if(tipo_doc != 0){
      if(document.getElementById('dniP').value != ""){
        if(document.getElementById('dniP').value.length >= 10){

          if(DniRuc_Validador($('#dniP'),tipo_doc) == true){
            quitarError("err_dniP","seccion_dniP");
          }else{
            colocaError("err_dniP", "seccion_dniP","Documento ingresado no es válido","btn_submitpaypal");
            error = 1;      
          }
        }else if(tipo_doc == 2 && document.getElementById('dniP').value.length < 10){

          colocaError("err_dniP", "seccion_dniP","El número de cédula debe tener mínimo 10 dígitos","btn_submitpaypal");

        }else if(tipo_doc == 3 && document.getElementById('dniP').value.length < 6){

          colocaError("err_dniP", "seccion_dniP","El pasaporte debe tener mínimo 6 dígitos","btn_submitpaypal");
        }
        else if(tipo_doc == 1 && document.getElementById('dniP').value.length < 13){

          colocaError("err_dniP", "seccion_dniP","El RUC debe tener mínimo 13 dígitos","btn_submitpaypal");
        }
      }else{
        colocaError("err_dniP", "seccion_dniP","Documento no puede ser vacío","btn_submitpaypal");
        error = 1;
      }
      quitarError("err_tipoP","seccion_tipoP");
    }else{
      error = validarSelect(tipo_doc,'err_tipoP','seccion_tipoP','btn_submitpaypal');
    }
    validaCampos(1);
});

$('#nombreP').on('blur', function(){

  var nombres = document.getElementById('nombreP').value;
  if(nombres.length <= '100'){
    validarInput(nombres,"err_nomP","seccion_nombreP","btn_submitpaypal")
    validaCampos(1);
  }else{
    colocaError("err_nomP","seccion_nombreP","El nombre no debe exceder de 100 caracteres","btn_submitpaypal");
  }
});

$('#telefonoP').on('blur', function(){

  var tel = document.getElementById('telefonoP').value;
  if(tel.length >= '10' && tel.length <= '25'){
    validarNumTelf(tel,"err_tlfP","seccion_tlfP","btn_submitpaypal");
    validaCampos(1);
  }else if(tel.length <= '10'){
    colocaError("err_tlfP","seccion_tlfP","El número minimo de caracteres es de 10","btn_submitpaypal");
  }else{
    colocaError("err_tlfP","seccion_tlfP","El teléfono no debe exceder de 25 caracteres","btn_submitpaypal");
  }
});

$('#direccionP').on('blur', function(){

  var dir = document.getElementById('direccionP').value;

  if(dir.length >= '10' && dir.length <= '100'){
    validarDir(dir,"err_dirP","seccion_dirP","btn_submitpaypal");
    validaCampos(1);
  }else{
    colocaError("err_dirP","seccion_dirP","Dirección longitud entre 10 y 100 caracteres","btn_submitpaypal");
  }
});

$('#correo').on('blur', function(){

  var correoP = document.getElementById('correo').value;
  validarCorreo(correoP,'err_correo','seccion_correo','btndeposito');
  validaCampos(2);
});

$('#tipo_doc').on('change', function(){

    var tipo_doc = document.getElementById('tipo_doc').value;
    if(tipo_doc != 0){
      
      if(document.getElementById('dni').value != ""){
        if(document.getElementById('dni').value.length >= 10){
          if(DniRuc_Validador($('#dni'),tipo_doc) == true){
            quitarError("err_dni","seccion_dni");
          }else{
            colocaError("err_dni", "seccion_dni","Documento ingresado no es válido","btndeposito");
            error = 1;      
          } 
        }else if(tipo_doc == 2 && document.getElementById('dni').value.length < 10){

          colocaError("err_dni", "seccion_dni","El número de cédula debe tener mínimo 10 dígitos","btndeposito");

        }else if(tipo_doc == 3 && document.getElementById('dni').value.length < 6){

          colocaError("err_dni", "seccion_dni","El pasaporte debe tener mínimo 6 dígitos","btndeposito");
        }
        else if(tipo_doc == 1 && document.getElementById('dni').value.length < 13){

          colocaError("err_dni", "seccion_dni","El RUC debe tener mínimo 13 dígitos","btndeposito");
        }
      }else{
        colocaError("err_dni", "seccion_dni","Documento no puede ser vacío","btndeposito");
        error = 1;
      }
      quitarError("err_tipo","seccion_tipo");
      
    }else{
      error = validarSelect(tipo_doc,'err_tipo','seccion_tipo','btndeposito');
    }
    validaCampos(2);
});

$('#nombre').on('blur', function(){

  var nombres = document.getElementById('nombre').value;
  if(nombres.length <= '100'){
    validarInput(nombres,"err_nom","seccion_nombre","btndeposito");
    validaCampos(2);
  }else{
    colocaError("err_nom","seccion_nombre","El nombre no debe exceder de 100 caracteres","btndeposito");
  }
});


$('#num_comprobante').on('blur', function(){

  var num_comprobante = document.getElementById('num_comprobante').value;
  if(num_comprobante.length <= '50'){
    validarNumTelf(num_comprobante,"err_comp","seccion_comp","btndeposito");
    validaCampos(2);
  }else{
    colocaError("err_comp","seccion_comp","El comprobante no debe exceder de 50 caracteres","btndeposito");
  }
});

$('#valor').on('blur', function(){

  var val = document.getElementById('valor').value;
  validarNumTelf(val,"err_val","seccion_val","btndeposito");
  validaCampos(2);
});

$('#telefono').on('blur', function(){

  var tel = document.getElementById('telefono').value;
  if(tel.length >= '10' && tel.length <= '25'){
    validarNumTelf(tel,"err_tlf","seccion_tlf","btndeposito");
    validaCampos(2);
  }else if(tel.length <= '10'){
    colocaError("err_tlf","seccion_tlf","El número minimo de caracteres es de 10","btndeposito");
  }else{
    colocaError("err_tlf","seccion_tlf","El teléfono no debe exceder de 25 caracteres","btndeposito");
  }
});

$('#direccion').on('blur', function(){

  var dir = document.getElementById('direccion').value;
  if(dir.length <= '10' && dir.length <= '100'){
    validarDir(dir,"err_dir","seccion_dir","btndeposito");
    validaCampos(2);
  }else{
    colocaError("err_dir","seccion_dir","La dirección debe tener una longitud entre 10 y 100 caracteres","btndeposito");
  }
});

$('#imagen').on('click', function(){

  var archivo = document.getElementById('imagen');
  validarImg(archivo,'err_img','seccion_img',"btndeposito");
  validaCampos(2);
});

$('#dni').on('blur', function(){

  var tipo_doc = document.getElementById('tipo_doc').value;
  if(tipo_doc != 0){
    if(document.getElementById('dni').value != ""){

      if(document.getElementById('dni').value.length >= 10){
        if(DniRuc_Validador($('#dni'),tipo_doc) == true){
          quitarError("err_dni","seccion_dni");
        }else{
          colocaError("err_dni", "seccion_dni","Documento ingresado no es válido","btndeposito");
          error = 1;      
        } 
      }else if(tipo_doc == 2 && document.getElementById('dni').value.length < 10){

        colocaError("err_dni", "seccion_dni","El número de cédula debe tener mínimo 10 dígitos","btndeposito");

      }else if(tipo_doc == 3 && document.getElementById('dni').value.length < 6){

        colocaError("err_dni", "seccion_dni","El pasaporte debe tener mínimo 6 dígitos","btndeposito");
      }
      else if(tipo_doc == 1 && document.getElementById('dni').value.length < 13){

        colocaError("err_dni", "seccion_dni","El RUC debe tener mínimo 13 dígitos","btndeposito");
      }
    }else{
      colocaError("err_dni", "seccion_dni","Documento no puede ser vacío","btndeposito");
      error = 1;
    }
  }else{
    colocaError("err_dni", "seccion_dni","Debe ingresar un tipo de documento","btndeposito");
    error = validarSelect(tipo_doc,'err_tipo','seccion_tipo','btndeposito');
  }
  validaCampos(2);
});

$('#dniP').on('blur', function(){

  var tipo_doc = document.getElementById('tipo_docP').value;
  if(tipo_doc != 0){
    if(document.getElementById('dniP').value != ""){

      if(document.getElementById('dniP').value.length >= 10){

        if(DniRuc_Validador($('#dniP'),tipo_doc) == true){
          quitarError("err_dniP","seccion_dniP");
        }else{
          colocaError("err_dniP", "seccion_dniP","Documento ingresado no es válido","btn_submitpaypal");
          error = 1;      
        }
      }else if(tipo_doc == 2 && document.getElementById('dni').value.length < 10){

        colocaError("err_dniP", "seccion_dniP","El número de cédula debe tener mínimo 10 dígitos","btn_submitpaypal");

      }else if(tipo_doc == 3 && document.getElementById('dni').value.length < 6){

        colocaError("err_dniP", "seccion_dniP","El pasaporte debe tener mínimo 6 dígitos","btn_submitpaypal");
      }
      else if(tipo_doc == 1 && document.getElementById('dni').value.length < 13){

        colocaError("err_dniP", "seccion_dniP","El RUC debe tener mínimo 13 dígitos","btn_submitpaypal");
      }
    }else{
      colocaError("err_dniP", "seccion_dniP","Documento no puede ser vacío","btn_submitpaypal");
      error = 1;
    }
  }else{
    colocaError("err_dniP", "seccion_dniP","Debe ingresar un tipo de documento","btn_submitpaypal");
    error = validarSelect(tipo_doc,'err_tipoP','seccion_tipoP','btn_submitpaypal');
  }
  validaCampos(1);
});

function enviarFormulario(form){

  var estado = validarFormulario();
  
  if(estado == 1 && form == 'form_deposito'){
    document.form_deposito.submit();
  }else if(form == 'form_paypal'){    
    if(estado != 1){
      $("#btn_submitpaypal").on('click', function(evt){
        evt.preventDefault();  
      });
    }else{      
      var valor = $('#idplanP').val()+'|'+$('#usuarioP').val()+'|'+$('#tipousuP').val()+'|'+$('#nombreP').val()+'|'+$('#correoP').val()+'|'+$('#tipo_docP').val()+'|'+$('#telefonoP').val()+'|'+$('#dniP').val()+'|'+$('#direccionP').val();
      $('#custom').attr('value',valor);
      document.getElementById('form_paypal').action = document.getElementById('rutaPAYPAL').value;      
      $('#form_paypal').submit();
    }
  }
}

function validarFormulario(){

  var expreg = /^[a-z A-Z ÁÉÍÓÚáéíóúñÑ]+$/i;
  var expreg1 = /^[a-z A-Z 0-9 ÁÉÍÓÚáéíóúñÑ]+$/i;
  var expreg_telf = /^[0-9]+$/i;
  var expreg_correo = /^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/i;
  var error = 0;

  var form = document.getElementById("tipoSeleccionado").value;

  if(form == 1){

    var archivo = document.getElementById('imagen');
    var num_comprobante = document.getElementById('num_comprobante').value;
    var correo = document.getElementById('correo').value;
    var valor = document.getElementById('valor').value;
    var nombre = document.getElementById('nombre').value;
    var direccion = document.getElementById('direccion').value;
    var telefono = document.getElementById('telefono').value;
    var dni = document.getElementById('dni');
    var tipo = document.getElementById('tipo_doc').value;

    var err_nom = "err_nom"; var seccion_nombre = "seccion_nombre";
    var err_dir = "err_dir"; var seccion_dir = "seccion_dir"; 
    var err_tlf = "err_tlf"; var seccion_tlf = "seccion_tlf";
    var err_dni = "err_dni"; var seccion_dni = "seccion_dni";
    var err_tipo = "err_tipo"; var seccion_tipo = "seccion_tipo";
     var err_correo = "err_correo"; var seccion_correo= "seccion_correo";
    var btn = "btndeposito";
    
    if(num_comprobante.length <= '50'){
      if(validarNumTelf(num_comprobante,"err_comp","seccion_comp",btn)){
        error = 1;
      }else{
        quitarError("err_comp","seccion_comp");
      }
    }else{
      colocaError("err_comp","seccion_comp","El comprobante no debe exceder de 50 caracteres",btn);
      error = 1;
    }

    if(validarNumTelf(valor,"err_val","seccion_val",btn)){
      error = 1;
    }else{
      quitarError("err_val","seccion_val");
    }

    if(validarImg(archivo,'err_img','seccion_img',btn)){
      error = 1;
    }else{
      quitarError('err_img','seccion_img');
    }

  }else{

    var nombre = document.getElementById('nombreP').value;
    var direccion = document.getElementById('direccionP').value;
    var telefono = document.getElementById('telefonoP').value;
    var correo = document.getElementById('correoP').value;
    var dni = document.getElementById('dniP');
    var tipo = document.getElementById('tipo_docP').value;

    var err_nom = "err_nomP"; var seccion_nombre = "seccion_nombreP";
    var err_dir = "err_dirP"; var seccion_dir = "seccion_dirP"; 
    var err_tlf = "err_tlfP"; var seccion_tlf = "seccion_tlfP";
    var err_dni = "err_dniP"; var seccion_dni = "seccion_dniP";
    var err_tipo = "err_tipoP"; var seccion_tipo = "seccion_tipoP";
    var err_correo = "err_correoP"; var seccion_correo= "seccion_correoP";
    var btn = "btn_submitpaypal";
  }
  
  if(nombre.length <= '100'){
    if(validarInput(nombre,err_nom,seccion_nombre,btn)){
      error = 1;
    }else{
      quitarError(err_nom,seccion_nombre);
    }
  }else{
    colocaError(err_nom,seccion_nombre,"El nombre no debe exceder de 100 caracteres",btn);
    error = 1;    
  }

  if(validarCorreo(correo,err_correo,seccion_correo,btn)){
    error = 1;
  }else{
    quitarError(err_correo,seccion_correo);
  }

  if(direccion.length >= '10' && direccion.length <= '100'){
    if(validarDir(direccion,err_dir,seccion_dir,btn)){
      error = 1;
    }else{
      quitarError(err_dir,seccion_dir);
    }
  }else{
    colocaError(err_dir,seccion_dir,"La dirección debe tener una longitud entre 10 y 100 caracteres",btn);
    error = 1;
  }

  if(telefono.length >= '10' && telefono.length <= '25'){
    if(validarNumTelf(telefono,err_tlf, seccion_tlf,btn)){
      error = 1;
    }else{
      quitarError(err_tlf, seccion_tlf);
    }
  }else if(telefono.length <= '10'){
    colocaError(err_tlf,seccion_tlf,"El número minimo de caracteres es de 10",btn);
    error = 1;    
  }else{
    colocaError(err_tlf,seccion_tlf,"El teléfono no debe exceder de 25 caracteres",btn);
    error = 1;
  }
  
  if(validarSelect(tipo,err_tipo,seccion_tipo,btn)){
    error = 1;
  }else{
    quitarError(err_tipo,seccion_tipo);
  }

  if(dni.value != ""){

    if(dni.value.length >= 10){      
      if(DniRuc_Validador(dni,tipo) == true){
        quitarError(err_dni,seccion_dni);
      }else{
        colocaError(err_dni, seccion_dni,"Documento ingresado no es válido",btn);
        error = 1;      
      } 
    }else if(tipo == 2 && dni.value.length < 10){

      colocaError(err_dni, seccion_dni,"El número de cédula debe tener mínimo 10 dígitos",btn);
      error = 1;

    }else if(tipo == 3 && dni.value.length < 6){

      colocaError(err_dni, seccion_dni,"El pasaporte debe tener mínimo 6 dígitos",btn);
      error = 1;
    }
    else if(tipo == 1 && dni.value.length < 13){

      colocaError(err_dni, seccion_dni,"El RUC debe tener mínimo 13 dígitos",btn);
      error = 1;
    }
  }else{
    colocaError(err_dni, seccion_dni,"Documento no puede ser vacío",btn);
    error = 1;
  }

  if(error == 0){
    $("#"+btn).removeClass('disabled');
    document.getElementById('form_paypal').action = document.getElementById('rutaPAYPAL').value;
    return 1;
  }
}

function fileValidation(fileInput){

  var filePath = fileInput.value;
  var allowedExtensions = /[.jpg |.jpeg |.png]$/i;
  
  if(filePath != ''){
   
    var tamano = fileInput.files[0].size/1024/1024;
    if(tamano > 1){
      colocaError("err_img", "seccion_img","El peso permitido es de máximo es de 1MB","btndeposito");
      document.getElementById('divimagen').innerHTML = '';
      return 1;
    }else{
      return 0;
    }
    
  }else if(!allowedExtensions.test(filePath)){

    colocaError("err_img", "seccion_img","El formato permitido es .jpeg/.jpg/.png","btndeposito");
    fileInput.value = '';
    document.getElementById('divimagen').innerHTML = '';
    return 1;
  }else{
    return 0;
  }
}
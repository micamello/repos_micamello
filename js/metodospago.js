$(window).on('load',function(){  
  $("#panel_1").hide();
  $("#panel_2").hide();
  $("#panel_3").show();
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

$('#provinciaPM').change(function(){
  var id_provincia = $('select[id=provinciaPM]').val();
  var puerto_host = $('#puerto_host').val();
  if(id_provincia != ""){
    $.ajax({
      type: "GET",
      url: puerto_host+"/index.php?mostrar=perfil&opcion=buscaCiudad&id_provincia="+id_provincia,
      dataType:'json',
      success:function(data){
        $('#ciudadPM').html('<option disabled selected value="0">Seleccione una ciudad</option>');
        $.each(data, function(index, value) {
            $('#ciudadPM').append("<option value='"+value.id_ciudad+"'>"+value.ciudad+"</option>");
        });
      },
      error: function (request, status, error) {
        colocaError("err_provPM", "seccion_provPM","Verifique su conexión de red. Intente de nuevo.","btnpayme");
        $('#ciudadPM').html('<option value="">Seleccione una ciudad</option>');
        /*Swal.fire({          
          html: 'Error por favor intente denuevo',
          imageUrl: $('#puerto_host').val()+'/imagenes/wrong-04.png',
          imageWidth: 75,
          confirmButtonText: 'ACEPTAR',
          animation: true
        });*/        
      },   
      beforeSend : function(){
        ajaxLoader($('#ciudadPM'), 'aparecer');
        ajaxLoader($('#provinciaPM'), 'aparecer');
      },
      complete : function(){
        ajaxLoader($('#ciudadPM'), 'desaparecer');
        ajaxLoader($('#provinciaPM'), 'desaparecer');
      }                 
    });
    quitarError("err_provPM","seccion_provPM");
  }
  else{    
    colocaError("err_provPM", "seccion_provPM","Seleccione una opción","btnpayme");
    error = 1;
  }
});

$('#select_provincia').change(function(){
  var id_provincia = $('select[id=select_provincia]').val();
  var puerto_host = $('#puerto_host').val();
  if(id_provincia != ""){
    $.ajax({
      type: "GET",
      url: puerto_host+"/index.php?mostrar=perfil&opcion=buscaCiudad&id_provincia="+id_provincia,
      dataType:'json',
      success:function(data){
        $('#select_ciudad').html('<option disabled selected value="0">Seleccione una ciudad</option>');
        $.each(data, function(index, value) {
            $('#select_ciudad').append("<option value='"+value.id_ciudad+"'>"+value.ciudad+"</option>");
        });
      },
      error: function (request, status, error) {
        colocaError("err_prov", "seccion_prov","Verifique su conexión de red. Intente de nuevo.","btndeposito");
        $('#select_ciudad').html('<option value="">Seleccione una ciudad</option>');
        /*Swal.fire({          
          html: 'Error por favor intente denuevo',
          imageUrl: $('#puerto_host').val()+'/imagenes/wrong-04.png',
          imageWidth: 75,
          confirmButtonText: 'ACEPTAR',
          animation: true
        });    */    
      },
      beforeSend : function(){
        ajaxLoader($('#select_ciudad'), 'aparecer');
        ajaxLoader($('#select_provincia'), 'aparecer');
      },
      complete : function(){
        ajaxLoader($('#select_ciudad'), 'desaparecer');
        ajaxLoader($('#select_provincia'), 'desaparecer');
      }                   
    });
    quitarError("err_prov","seccion_prov");
  }
  else{    
    colocaError("err_prov", "seccion_prov","Seleccione una opción","btndeposito");
    error = 1;
  }
});

$('#ciudadPM').change(function(){
  var id_ciudad = $('select[id=ciudadPM]').val();  
  if(id_ciudad != ""){    
    quitarError("err_ciuPM","seccion_ciuPM");
  }
  else{    
    colocaError("err_ciuPM", "seccion_ciuPM","Seleccione una opción","btnpayme");
    error = 1;
  }
});

$('#select_ciudad').change(function(){
  var id_ciudad = $('select[id=select_ciudad]').val();  
  if(id_ciudad != ""){    
    quitarError("err_ciu","seccion_ciu");
  }
  else{    
    colocaError("err_ciu", "seccion_ciu","Seleccione una opción","btndeposito");
    error = 1;
  }
});

/*$('#btn_submitpaypal').click(function(){  
  var valor = $('#idplanP').val()+'|'+$('#usuarioP').val()+'|'+$('#tipousuP').val()+'|'+reemplazar($('#nombreP').val())+'|'+$('#correoP').val()+'|'+$('#tipo_docP').val()+'|'+$('#telefonoP').val()+'|'+$('#dniP').val()+'|'+reemplazar($('#direccionP').val());
  $('#custom').attr('value',valor);  
});*/

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
  /*if(tipo == 1){
    var elem = $('#form_paypal').find('input[type!="hidden"]');
    var btn = 'btn_submitpaypal';
    var select = document.getElementById('tipo_docP').value;
  }else */if (tipo == 2){
    var elem = $('#form_deposito').find('input[type!="hidden"]');
    var btn = 'btndeposito';
    var select = document.getElementById('tipo_doc').value;
  }else{
    var elem = $('#form_payme').find('input[type!="hidden"]');
    var btn = 'btnpayme';
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
    //$("#"+btn).addClass('disabled');
  }else{    
    //$("#"+btn).removeClass('disabled');     
    /*if(tipo == 1){    
      var valor = $('#idplanP').val()+'|'+$('#usuarioP').val()+'|'+$('#tipousuP').val()+'|'+reemplazar($('#nombreP').val())+'|'+$('#correoP').val()+'|'+$('#tipo_docP').val()+'|'+$('#telefonoP').val()+'|'+$('#dniP').val()+'|'+reemplazar($('#direccionP').val());
      $('#custom').attr('value',valor);      
      document.getElementById('form_paypal').action = document.getElementById('rutaPAYPAL').value;      
    }*/
  }
}

function validarSelect(id,err_select,err_group_select,btn){
  var error = 0;
  if(id != 0){
    quitarError(err_select,err_group_select);
  }else{
    colocaError(err_select,err_group_select,"Seleccione una opción",btn);
    error = 1;
  }
  return error;
}

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

/*$('#tipo_docP').on('change', function(){
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
        else{
          quitarError("err_dniP","seccion_dniP");
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
});*/

$('#nombre').on('blur', function(){
  var nombres = document.getElementById('nombre').value;
  if(nombres.length <= '30'){
    validarInput(nombres,"err_nom","seccion_nombre","btndeposito");
    validaCampos(2);
  }else{
    colocaError("err_nom","seccion_nombre","Mínimo 30 caracteres","btndeposito");
  }
});

/*$('#nombreP').on('blur', function(){
  var nombres = document.getElementById('nombreP').value;
  if(nombres.length <= '100'){
    validarInput(nombres,"err_nomP","seccion_nombreP","btn_submitpaypal")
    validaCampos(1);
  }else{
    colocaError("err_nomP","seccion_nombreP","El nombre no debe exceder de 100 caracteres","btn_submitpaypal");
  }
});*/

$('#shippingFirstName').on('blur', function(){
  var nombres = document.getElementById('shippingFirstName').value;
  if(nombres.length <= '30'){
    validarInput(nombres,"err_nomPM","seccion_nombrePM","btnpayme");
    validaCampos(2);
  }else{
    colocaError("err_nomPM","seccion_nombrePM","Mínimo 30 caracteres","btnpayme");
  }
});

$('#apellido').on('blur', function(){
  var apellidos = document.getElementById('apellido').value;
  if(apellidos.length <= '50'){
    validarInput(apellidos,"err_apell","seccion_apellido","btndeposito");
    validaCampos(2);
  }else{
    colocaError("err_apell","seccion_apellido","Mínimo 50 caracteres","btndeposito");
  }
});

$('#shippingLastName').on('blur', function(){
  var nombres = document.getElementById('shippingLastName').value;
  if(nombres.length <= '50'){
    validarInput(nombres,"err_apellidoPM","seccion_apellidoPM","btnpayme");
    validaCampos(2);
  }else{
    colocaError("err_apellidoPM","seccion_apellidoPM","Mínimo 50 caracteres","btnpayme");
  }
});

$('#telefono').on('blur', function(){
  $(this).val($(this).val().trim());
  var tel = document.getElementById('telefono').value;
  if(tel.length >= '9' && tel.length <= '15'){
    validarNumTelf(tel,"err_tlf","seccion_tlf","btndeposito");
    validaCampos(2);
  }else if(tel.length <= '9'){
    colocaError("err_tlf","seccion_tlf","Mínimo 9 caracteres","btndeposito");
  }else{
    colocaError("err_tlf","seccion_tlf","Máximo 15 caracteres","btndeposito");
  }
});

/*$('#telefonoP').on('blur', function(){
  var tel = document.getElementById('telefonoP').value;
  if(tel.length >= '10' && tel.length <= '25'){
    validarNumTelf(tel,"err_tlfP","seccion_tlfP","btn_submitpaypal");
    validaCampos(1);
  }else if(tel.length <= '10'){
    colocaError("err_tlfP","seccion_tlfP","El número minimo de caracteres es de 10","btn_submitpaypal");
  }else{
    colocaError("err_tlfP","seccion_tlfP","El teléfono no debe exceder de 25 caracteres","btn_submitpaypal");
  }
});*/

$('#shippingPhone').on('blur', function(){
  $(this).val($(this).val().trim());
  var tel = document.getElementById('shippingPhone').value;
  if(tel.length >= '9' && tel.length <= '15'){
    validarNumTelf(tel,"err_tlfPM","seccion_tlfPM","btnpayme");
    validaCampos(1);
  }else if(tel.length <= '9'){
    colocaError("err_tlfPM","seccion_tlfPM","Mínimo 9 caracteres","btnpayme");
  }else{
    colocaError("err_tlfPM","seccion_tlfPM","Máximo 15 caracteres","btnpayme");
  }
});

$('#direccion').on('blur', function(){
  var dir = document.getElementById('direccion').value;
  if(dir.length >= 10 && dir.length <= 50){
    validarDir(dir,"err_dir","seccion_dir","btndeposito");
    validaCampos(2);
  }else{
    colocaError("err_dir","seccion_dir","Mínimo 10 y máximo 50 caracteres","btndeposito");
  }
});

/*$('#direccionP').on('blur', function(){
  var dir = document.getElementById('direccionP').value;
  if(dir.length >= '10' && dir.length <= '100'){
    validarDir(dir,"err_dirP","seccion_dirP","btn_submitpaypal");
    validaCampos(1);
  }else{
    colocaError("err_dirP","seccion_dirP","Dirección longitud entre 10 y 100 caracteres","btn_submitpaypal");
  }
});*/

$('#shippingAddress').on('blur', function(){
  var dir = document.getElementById('shippingAddress').value;
  if(dir.length >= '10' && dir.length <= '50'){
    validarDir(dir,"err_dirPM","seccion_dirPM","btnpayme");
    validaCampos(1);
  }else{
    colocaError("err_dirPM","seccion_dirPM","Mínimo 10 y máximo 50 caracteres","btnpayme");
  }
});

$('#correo').on('blur', function(){
  $(this).val($(this).val().trim().toLowerCase());
  var correoP = document.getElementById('correo').value;
  validarCorreo(correoP,'err_correo','seccion_correo','btndeposito');
  validaCampos(2);
});

$('#correo').on('keyup', function(){
  $(this).val($(this).val().toLowerCase());
})

/*$('#correoP').on('blur', function(){
  var correoP = document.getElementById('correoP').value;
  validarCorreo(correoP,'err_correoP','seccion_correoP','btn_submitpaypal');
  validaCampos(1);
});*/

$('#shippingEmail').on('blur', function(){
  $(this).val($(this).val().trim().toLowerCase());
  var correoP = document.getElementById('shippingEmail').value;
  validarCorreo(correoP,'err_correoPM','seccion_correoPM','btnpayme');
  validaCampos(2);
});

$('#shippingEmail').on('keyup', function(){
  $(this).val($(this).val().toLowerCase());
});

$('#shippingZIP').on('blur', function(){
  var dir = document.getElementById('shippingZIP').value;
  if(dir.length >= '1' && dir.length <= '10'){
    validarDir(dir,"err_zipPM","seccion_zipPM","btnpayme");
    validaCampos(1);
  }else{
    colocaError("err_zipPM","seccion_zipPM","Mínimo 1 y máximo 10 caracteres","btnpayme");
  }
});

$('#shipping').on('blur', function(){
  var dir = document.getElementById('shipping').value;
  if(dir.length >= '1' && dir.length <= '10'){
    validarDir(dir,"err_zip","seccion_zip","btndeposito");
    validaCampos(1);
  }else{
    colocaError("err_zip","seccion_zip","Mínimo 1 y máximo 10 caracteres","btndeposito");
  }
});

$('#tipo_doc').on('change', function(){
    var tipo_doc = document.getElementById('tipo_doc').value;
    if(tipo_doc != 0){      
      if(document.getElementById('dni').value != ""){
        if(document.getElementById('dni').value.length >= 10){
          if(DniRuc_Validador($('#dni'),tipo_doc) == true){
            quitarError("err_dni","seccion_dni");
          }else{
            colocaError("err_dni", "seccion_dni","Documento inválido","btndeposito");
            error = 1;      
          } 
        }else if(tipo_doc == 2 && document.getElementById('dni').value.length < 10){
          colocaError("err_dni", "seccion_dni","Mínimo 10 dígitos","btndeposito");
        }else if(tipo_doc == 3 && document.getElementById('dni').value.length < 6){
          colocaError("err_dni", "seccion_dni","Mínimo 6 dígitos","btndeposito");
        }
        else if(tipo_doc == 1 && document.getElementById('dni').value.length < 13){
          colocaError("err_dni", "seccion_dni","Mínimo 13 dígitos","btndeposito");
        }
        else{
          quitarError("err_dni","seccion_dni");
        }
      }else{
        colocaError("err_dni", "seccion_dni","Documento obligatorio","btndeposito");
        error = 1;
      }
      quitarError("err_tipo","seccion_tipo");      
    }else{
      error = validarSelect(tipo_doc,'err_tipo','seccion_tipo','btndeposito');
    }
    validaCampos(2);
});

$('#tipo_docPM').on('change', function(){

    var tipo_doc = document.getElementById('tipo_docPM').value;    
    if(tipo_doc != 0){      
      if(document.getElementById('dniPM').value != ""){
        if(document.getElementById('dniPM').value.length >= 10){
          if(DniRuc_Validador($('#dniPM'),tipo_doc) == true){
            quitarError("err_dniPM","seccion_dniPM");
          }else{
            colocaError("err_dniPM", "seccion_dniPM","Documento inválido","btnpayme");
            error = 1;      
          } 
        }else if(tipo_doc == 2 && document.getElementById('dniPM').value.length < 10){
          colocaError("err_dniPM", "seccion_dniPM","Mínimo 10 dígitos","btnpayme");
        }else if(tipo_doc == 3 && document.getElementById('dniPM').value.length < 6){
          colocaError("err_dniPM", "seccion_dniPM","Mínimo 6 dígitos","btnpayme");
        }
        else if(tipo_doc == 1 && document.getElementById('dniPM').value.length < 13){
          colocaError("err_dniPM", "seccion_dniPM","Mínimo 13 dígitos","btnpayme");
        }
        else{
          quitarError("err_dniPM","seccion_dniPM");
        }
      }else{
        colocaError("err_dniPM", "seccion_dniPM","Documento obligatorio","btnpayme");
        error = 1;
      }
      quitarError("err_tipoPM","seccion_tipoPM");      
    }else{
      error = validarSelect(tipo_doc,'err_tipoPM','seccion_tipoPM','btnpayme');
    }
    validaCampos(2);
});

$('#num_comprobante').on('blur', function(){
  var num_comprobante = document.getElementById('num_comprobante').value;
  if(num_comprobante.length <= '50'){
    validarNumTelf(num_comprobante,"err_comp","seccion_comp","btndeposito");
    validaCampos(2);
  }else{
    colocaError("err_comp","seccion_comp","Máximo 50 caracteres","btndeposito");
  }
});

$('#valor').on('blur', function(){
  var val = document.getElementById('valor').value;
  validarDineroFormPlanes(val,"err_val","seccion_val","btndeposito");
  validaCampos(2);
});

$('#imagen').on('click', function(){
  var archivo = document.getElementById('imagen');
  validarImg(archivo,'err_img','seccion_img',"btndeposito");
  validaCampos(2);
});

$('#dni').on('blur', function(){
  $(this).val($(this).val().trim());
  var tipo_doc = document.getElementById('tipo_doc').value;
  if(tipo_doc != 0){
    if(document.getElementById('dni').value != ""){
      if(document.getElementById('dni').value.length >= 10){
        if(DniRuc_Validador($('#dni'),tipo_doc) == true){
          quitarError("err_dni","seccion_dni");
        }else{
          colocaError("err_dni", "seccion_dni","Documento inválido","btndeposito");
          error = 1;      
        } 
      }else if(tipo_doc == 2 && document.getElementById('dni').value.length < 10){
        colocaError("err_dni", "seccion_dni","Mínimo 10 dígitos","btndeposito");
      }else if(tipo_doc == 3 && document.getElementById('dni').value.length < 6){
        colocaError("err_dni", "seccion_dni","Mínimo 6 dígitos","btndeposito");
      }
      else if(tipo_doc == 1 && document.getElementById('dni').value.length < 13){
        colocaError("err_dni", "seccion_dni","Mínimo 13 dígitos","btndeposito");
      }
      else{
        quitarError("err_dni","seccion_dni");
      }
    }else{
      colocaError("err_dni", "seccion_dni","Documento no puede ser vacío","btndeposito");
      error = 1;
    }
  }else{
    colocaError("err_dni", "seccion_dni","Seleccione tipo de documento","btndeposito");
    error = validarSelect(tipo_doc,'err_tipo','seccion_tipo','btndeposito');
  }
  validaCampos(2);
});

/*$('#dniP').on('blur', function(){
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
  }else{
    colocaError("err_dniP", "seccion_dniP","Debe ingresar un tipo de documento","btn_submitpaypal");
    error = validarSelect(tipo_doc,'err_tipoP','seccion_tipoP','btn_submitpaypal');
  }
  validaCampos(1);
});*/
$('#dniPM').on('keypress', function(event){
  if(event.keyCode == 0 || event.keyCode == 32){
    event.preventDefault();
  }
});

$('#shippingPhone').on('keypress', function(event){
  if(event.keyCode == 0 || event.keyCode == 32){
    event.preventDefault();
  }
});

$('#shippingEmail').on('keypress', function(event){
  if(event.keyCode == 0 || event.keyCode == 32){
    event.preventDefault();
  }
});

$('#dni').on('keypress', function(event){
  if(event.keyCode == 0 || event.keyCode == 32){
    event.preventDefault();
  }
});

$('#telefono').on('keypress', function(event){
  if(event.keyCode == 0 || event.keyCode == 32){
    event.preventDefault();
  }
});

$('#correo').on('keypress', function(event){
  if(event.keyCode == 0 || event.keyCode == 32){
    event.preventDefault();
  }
});


$('#dniPM').on('blur', function(){
  $(this).val($(this).val().trim());
  var tipo_doc = document.getElementById('tipo_docPM').value;
  if(tipo_doc != 0){
    if(document.getElementById('dniPM').value != ""){
      if(document.getElementById('dniPM').value.length >= 10){
        if(DniRuc_Validador($('#dniPM'),tipo_doc) == true){
          quitarError("err_dniPM","seccion_dniPM");
        }else{
          colocaError("err_dniPM", "seccion_dniPM","Documento inválido","btnpayme");
          error = 1;      
        } 
      }else if(tipo_doc == 2 && document.getElementById('dniPM').value.length < 10){
        colocaError("err_dniPM", "seccion_dniPM","Mínimo 10 dígitos","btnpayme");
      }else if(tipo_doc == 3 && document.getElementById('dniPM').value.length < 6){
        colocaError("err_dniPM", "seccion_dniPM","Mínimo 6 dígitos","btnpayme");
      }
      else if(tipo_doc == 1 && document.getElementById('dniPM').value.length < 13){
        colocaError("err_dniPM", "seccion_dniPM","Mínimo 13 dígitos","btnpayme");
      }
      else{
        quitarError("err_dniPM","seccion_dniPM");
      }
    }else{
      colocaError("err_dniPM", "seccion_dniPM","Documento no puede ser vacío","btnpayme");
      error = 1;
    }
  }else{
    colocaError("err_dniPM", "seccion_dniPM","Seleccione tipo de documento","btnpayme");
    error = validarSelect(tipo_doc,'err_tipoPM','seccion_tipoPM','btnpayme');
  }
  validaCampos(2);
});

function enviarFormulario(form){
  var estado = validarFormulario();  
  if(estado == 1 && form == 'form_deposito'){
    $('#provincia').attr('value',$("#select_provincia").children('option:selected').text());
    $('#ciudad').attr('value',$("#select_ciudad").children('option:selected').text());     
    document.form_deposito.submit();
  }/*else if(form == 'form_paypal'){    
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
  }*/else if(estado == 1 && form == 'form_payme'){    
    $('#shippingState').attr('value',$("#provinciaPM").children('option:selected').text());
    $('#shippingCity').attr('value',$("#ciudadPM").children('option:selected').text());    
    $('#reserved18').val($("#tipo_docPM").val());    
    $('#reserved19').val($("#dniPM").val());
    var enlace = $('#puerto_host').val()+"/index.php?mostrar=plan&opcion=file&id="+$('#reserved16').val()+'&idoperation='+$('#purchaseOperationNumber').val()+'&idplan='+$('#reserved15').val();
    $.ajax({
      type: "GET",
      url: enlace,
      dataType:'json',
      success:function(data){  
      console.log(data); 
        if (data.resultado == 1){
          AlignetVPOS2.openModal($('#rutaPayMe').val());            
        }  
        else if(data.resultado == 2){
          Swal.fire({            
            text: data.mensaje,
            imageUrl: $('#puerto_host').val()+'/imagenes/logo-04.png',
            imageWidth: 210,
            confirmButtonText: 'ACEPTAR',
            animation: true
          });
        } 
        else{
          Swal.fire({        
            html: data.mensaje,
            imageUrl: $('#puerto_host').val()+'/imagenes/wrong-04.png',
            imageWidth: 75,
            confirmButtonText: 'ACEPTAR',
            animation: true
          });
        }
      },
      error: function (request, status, error) {
        Swal.fire({        
          html: 'Error por favor intente denuevo',
          imageUrl: $('#puerto_host').val()+'/imagenes/wrong-04.png',
          imageWidth: 75,
          confirmButtonText: 'ACEPTAR',
          animation: true
        });            
      }                  
    });    
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
    var apellido = document.getElementById('apellido').value;
    var direccion = document.getElementById('direccion').value;
    var telefono = document.getElementById('telefono').value;
    var dni = document.getElementById('dni');
    var tipo = document.getElementById('tipo_doc').value;
    var zip = document.getElementById('shipping').value;
    var provincia = document.getElementById('select_provincia');
    var ciudad = document.getElementById('select_ciudad');
    var err_nom = "err_nom"; var seccion_nombre = "seccion_nombre";
    var err_apell = "err_apell"; var seccion_apellido = "seccion_apellido";
    var err_dir = "err_dir"; var seccion_dir = "seccion_dir"; 
    var err_tlf = "err_tlf"; var seccion_tlf = "seccion_tlf";
    var err_dni = "err_dni"; var seccion_dni = "seccion_dni";
    var err_tipo = "err_tipo"; var seccion_tipo = "seccion_tipo";
    var err_correo = "err_correo"; var seccion_correo= "seccion_correo";
    var err_zip = "err_zip"; var seccion_zip= "seccion_zip";
    var err_prov = "err_prov"; var seccion_prov= "seccion_prov";
    var err_ciu = "err_ciu"; var seccion_ciu= "seccion_ciu";
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
    if(validarDineroFormPlanes(valor,"err_val","seccion_val",btn)){      
      error = 1;
    }else{
      quitarError("err_val","seccion_val");
    }
    if(validarImg(archivo,'err_img','seccion_img',btn)){
      error = 1;      
    }else{
      quitarError('err_img','seccion_img');
    }
    if(apellido.length <= '50'){
      if(validarInput(apellido,err_apell,seccion_apellido,btn)){
        error = 1;        
      }else{
        quitarError(err_apell,seccion_apellido);
      }
    }else{
      colocaError(err_apell,seccion_apellido,"Máximo 50 caracteres",btn);      
      error = 1;    
    }
    if(zip.length <= '10'){
      if(validarDir(zip,err_zip,seccion_zip,btn)){
        error = 1;        
      }else{
        quitarError(err_zip,seccion_zip);
      }
    }else{
      colocaError(err_zip,seccion_zip,"Máximo 10 caracteres",btn);
      error = 1;          
    }
    if (provincia.value == 0){
      colocaError(err_prov,seccion_prov,"Seleccione una opción",btn);
      error = 1;           
    }
    else{
      quitarError(err_prov,seccion_prov);
    }
    if (ciudad.value == 0){
      colocaError(err_ciu,seccion_ciu,"Seleccione una opción",btn);
      error = 1;           
    }
    else{
      quitarError(err_ciu,seccion_ciu);
    }
  }/*else if (form == 2){
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
  }*/
  else{    
    var correo = document.getElementById('shippingEmail').value;    
    var nombre = document.getElementById('shippingFirstName').value;
    var apellido = document.getElementById('shippingLastName').value;
    var direccion = document.getElementById('shippingAddress').value;
    var telefono = document.getElementById('shippingPhone').value;
    var zip = document.getElementById('shippingZIP').value;
    var dni = document.getElementById('dniPM');
    var tipo = document.getElementById('tipo_docPM').value;
    var provincia = document.getElementById('provinciaPM');
    var ciudad = document.getElementById('ciudadPM');
    var err_nom = "err_nomPM"; var seccion_nombre = "seccion_nombrePM";
    var err_apell = "err_apellidoPM"; var seccion_apellido = "seccion_apellidoPM";
    var err_dir = "err_dirPM"; var seccion_dir = "seccion_dirPM"; 
    var err_tlf = "err_tlfPM"; var seccion_tlf = "seccion_tlfPM";
    var err_dni = "err_dniPM"; var seccion_dni = "seccion_dniPM";
    var err_tipo = "err_tipoPM"; var seccion_tipo = "seccion_tipoPM";
    var err_correo = "err_correoPM"; var seccion_correo= "seccion_correoPM";
    var err_zip = "err_zipPM"; var seccion_zip= "seccion_zipPM";
    var err_prov = "err_provPM"; var seccion_prov= "seccion_provPM";
    var err_ciu = "err_ciuPM"; var seccion_ciu= "seccion_ciuPM";
    var btn = "btnpayme";    
          
    if(apellido.length <= '50'){
      if(validarInput(apellido,err_apell,seccion_apellido,btn)){
        error = 1;
      }else{
        quitarError(err_apell,seccion_apellido);
      }
    }else{
      colocaError(err_apell,seccion_apellido,"Máximo 50 caracteres",btn);
      error = 1;    
    }
    if(zip.length <= '10'){
      if(validarDir(zip,err_zip,seccion_zip,btn)){
        error = 1;
      }else{
        quitarError(err_zip,seccion_zip);
      }
    }else{
      colocaError(err_zip,seccion_zip,"Máximo 10 caracteres",btn);
      error = 1;    
    }
    if (provincia.value == 0){
      colocaError(err_prov,seccion_prov,"Seleccione una opción",btn);
      error = 1;     
    }
    else{
      quitarError(err_prov,seccion_prov);
    }
    if (ciudad.value == 0){
      colocaError(err_ciu,seccion_ciu,"Seleccione una opción",btn);
      error = 1;     
    }
    else{
      quitarError(err_ciu,seccion_ciu);
    }
  }
  
  if(nombre.length <= '30'){
    if(validarInput(nombre,err_nom,seccion_nombre,btn)){
      error = 1;      
    }else{
      quitarError(err_nom,seccion_nombre);
    }
  }else{
    colocaError(err_nom,seccion_nombre,"Máximo 30 caracteres",btn);
    error = 1;        
  }
  if(validarCorreo(correo,err_correo,seccion_correo,btn)){
    error = 1;
  }else{
    quitarError(err_correo,seccion_correo);
  }
  if(direccion.length >= 10 && direccion.length <= 50){
    if(validarDir(direccion,err_dir,seccion_dir,btn)){
      error = 1;      
    }else{
      quitarError(err_dir,seccion_dir);
    }
  }else{
    colocaError(err_dir,seccion_dir,"Mínimo 10 y máximo 50 caracteres",btn);
    error = 1;    
  }
  if(telefono.length >= '9' && telefono.length <= '15'){
    if(validarNumTelf(telefono,err_tlf, seccion_tlf,btn)){
      error = 1;      
    }else{
      quitarError(err_tlf, seccion_tlf);
    }
  }else if(telefono.length <= '10'){
    colocaError(err_tlf,seccion_tlf,"Mínimo 9 caracteres",btn);
    error = 1;     
  }else{
    colocaError(err_tlf,seccion_tlf,"Máximo 15 caracteres",btn);
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
        colocaError(err_dni, seccion_dni,"Documento inválido",btn);
        error = 1;          
      } 
    }else if(tipo == 2 && dni.value.length < 10){
      colocaError(err_dni, seccion_dni,"Mínimo 10 dígitos",btn);
      error = 1;      
    }else if(tipo == 3 && dni.value.length < 6){
      colocaError(err_dni, seccion_dni,"Mínimo 6 dígitos",btn);
      error = 1;      
    }
    else if(tipo == 1 && dni.value.length < 13){
      colocaError(err_dni, seccion_dni,"Mínimo 13 dígitos",btn);
      error = 1;
    }
  }else{
    colocaError(err_dni, seccion_dni,"Documento no puede ser vacío",btn);
    error = 1;    
  }
  if(error == 0){
    //$("#"+btn).removeClass('disabled');
    //document.getElementById('form_paypal').action = document.getElementById('rutaPAYPAL').value;
    return 1;
  }
}

function fileValidation(fileInput){
  var filePath = fileInput.value;
  var allowedExtensions = /[.jpg |.jpeg |.png]$/i;
  if(filePath != ''){
    var tamano = fileInput.files[0].size/1024/1024;
    if(tamano > 1){
      colocaError("err_img", "seccion_img","Peso máximo 1MB","btndeposito");
      document.getElementById('divimagen').innerHTML = '';
      return 1;
    }else{
      return 0;
    }
  }else if(!allowedExtensions.test(filePath)){
    colocaError("err_img", "seccion_img","Formato permitido .jpeg/.jpg/.png","btndeposito");
    fileInput.value = '';
    document.getElementById('divimagen').innerHTML = '';
    return 1;
  }else{
    return 0;
  }
}
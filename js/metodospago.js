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
      url: puerto_host+"?mostrar=perfil&opcion=buscaCiudad&id_provincia="+id_provincia,
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
      url: puerto_host+"?mostrar=perfil&opcion=buscaCiudad&id_provincia="+id_provincia,
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
	var valor = $('#idplanP').val()+'|'+$('#usuarioP').val()+'|'+$('#nombreP').val()+'|'+$('#correoP').val()+'|'+$('#ciudadP').val()+'|'+$('#telefonoP').val()+'|'+$('#dniP').val()+'|'+$('#direccionP').val();
	$('#custom').attr('value',valor);

});

$('#imagen').change(function(e) {
    addImage(e); 
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
}

function enviarFormulario(form){

  var estado = validarFormulario();
  if(estado == 1 && form == 'form_deposito'){
      document.form_deposito.submit();
  }
}

function validarFormulario(){

  var expreg = /^[a-z A-Z]+$/i;
  var expreg1 = /^[a-z A-Z 0-9]+$/i;
  var expreg_telf = /^[0-9]+$/i;
  var expreg_correo = /^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/i;
  var expreg_float = /^[0-9]{2,}\.?[0-9]{2}$/i;
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
    var tipo = document.getElementById('tipo_doc').selectedIndex;

    var err_nom = "err_nom"; var seccion_nombre = "seccion_nombre";
    var err_dir = "err_dir"; var seccion_dir = "seccion_dir"; 
    var err_tlf = "err_tlf"; var seccion_tlf = "seccion_tlf";
    var err_dni = "err_dni"; var seccion_dni = "seccion_dni";
    var err_tipo = "err_tipo"; var seccion_tipo = "seccion_tipo";
     var err_correo = "err_correo"; var seccion_correo= "seccion_correo";
    var btn = "btndeposito";
    
    if(num_comprobante == null || num_comprobante.length == 0 || /^\s+$/.test(num_comprobante)){

        colocaError("err_comp", "seccion_comp","El campo no puede ser vacío",btn);
        error = 1;

    }else if(!expreg_telf.test(num_comprobante)){

        colocaError("err_comp", "seccion_comp","Formato incorrecto, solo numeros",btn);
        error = 1; 

    }else{
        quitarError("err_comp","seccion_comp",btn);
    }

    if(valor == null || valor.length == 0 || /^\s+$/.test(valor)){

        colocaError("err_val", "seccion_val","El campo no puede ser vacío",btn);
        error = 1;

    }else if(!expreg_float.test(valor)){

        colocaError("err_val", "seccion_val","Formato incorrecto, xx.xx",btn);
        error = 1; 

    }else{
        quitarError("err_val", "seccion_val",btn);
    }

    var file = fileValidation(archivo);
    if(file == 1){
      error = 1;
    }else{
      quitarError("err_img", "seccion_img",btn);
    }

  }else{

    var nombre = document.getElementById('nombreP').value;
    var direccion = document.getElementById('direccionP').value;
    var telefono = document.getElementById('telefonoP').value;
    var correo = document.getElementById('correoP').value;
    var dni = document.getElementById('dniP');
    var tipo = document.getElementById('tipo_docP').selectedIndex;

    var err_nom = "err_nomP"; var seccion_nombre = "seccion_nombreP";
    var err_dir = "err_dirP"; var seccion_dir = "seccion_dirP"; 
    var err_tlf = "err_tlfP"; var seccion_tlf = "seccion_tlfP";
    var err_dni = "err_dniP"; var seccion_dni = "seccion_dniP";
    var err_tipo = "err_tipoP"; var seccion_tipo = "seccion_tipoP";
    var err_correo = "err_correoP"; var seccion_correo= "seccion_correoP";
    var btn = "btn_submitpaypal";
  }
  
  if(nombre == null || nombre.length == 0 || /^\s+$/.test(nombre)){

    colocaError(err_nom, seccion_nombre,"El campo no puede ser vacío",btn);
    error = 1; 

  }else if(!expreg.test(nombre)){

    colocaError(err_nom, seccion_nombre,"Formato incorrecto, solo letras",btn); 
    error = 1;  

  }else{
    quitarError(err_nom,seccion_nombre);
  }

  if(correo == null || correo.length == 0 || /^\s+$/.test(correo)){

    colocaError(err_correo, seccion_correo,"El campo no puede ser vacío",btn);
    error = 1; 

  }else if(!expreg_correo.test(correo)){

    colocaError(err_correo, seccion_correo,"Formato incorrecto, no es un correo válido",btn); 
    error = 1;  

  }else{
      quitarError(err_correo,seccion_correo);
  }

  if(direccion == null || direccion.length == 0 || /^\s+$/.test(direccion)){

    colocaError(err_dir, seccion_dir,"El campo no puede ser vacío",btn);
    error = 1; 

  }else if(!expreg1.test(direccion)){

    colocaError(err_dir, seccion_dir,"Formato incorrecto, solo letras y números",btn); 
    error = 1;

  }else{
      quitarError(err_dir,seccion_dir);
  }
  
  if(telefono == null || telefono.length == 0 || /^\s+$/.test(telefono)){

    colocaError(err_tlf, seccion_tlf,"El campo no puede ser vacío",btn);
    error = 1;

  }else if(!expreg_telf.test(telefono)){

    colocaError(err_tlf, seccion_tlf,"Formato incorrecto, solo numeros",btn);
    error = 1; 

  }else{
    quitarError(err_tlf,seccion_tlf);
  }
  
  if(tipo == 0 || tipo == -1){
    colocaError(err_tipo,seccion_tipo,"Debe seleccionar un elemento de la lista",btn);
    error = 1; 
  }else{

      var validar = validarDocumento(dni.value,tipo,err_dni,seccion_dni,btn);
      if(validar == 1){
        error = 1;
      }else{
        quitarError(err_dni, seccion_dni);
      }
      quitarError(err_tipo,seccion_tipo);
  }

  var validar = validarDocumento(dni.value,tipo,err_dni,seccion_dni,btn);
  if(validar == 1){
    error = 1;
  }else{
    quitarError(err_dni,seccion_dni);
  }

  if(error == 0){
    $("#"+btn).removeClass('disabled');
    $("#"+btn).removeAttr('disabled');
    if(form == 2){
      document.getElementById('form_paypal').action = document.getElementById('rutaPAYPAL').value;
    }
    return 1;
  }
}


function validarDocumento(numero,tipo,campoErr,campoSeccion,btn){  
  
  var suma = 0;      
  var residuo = 0;      
  var pri = false;      
  var pub = false;            
  var nat = false;      
  var numeroProvincias = 22;                  
  var modulo = 11;
  var error = 0;
 
  if (numero.length == 0){
    colocaError(campoErr, campoSeccion,"El campo no puede ser vacío",btn);
    return error = 1;
  } 

  
  var expregLN = /[a-zA-Z0-9]{7,}$/i;
  if ((!expregLN.test(numero) && tipo == 3) ){

    colocaError(campoErr, campoSeccion,"Pasaporte inválido",btn);                 
    return error = 1;
  }
  else if (numero.length < 10 && tipo == 2){ 
    colocaError(campoErr, campoSeccion,"DNI inválida",btn);                 
    return error = 1;

  }else if (numero.length < 13 && tipo == 1){ 
    colocaError(campoErr, campoSeccion,"RUC inválido",btn);                 
    return error = 1;
  }

  /* Verifico que el campo no contenga letras */                    
  if (tipo == 1 || tipo == 2){
    var expreg = /^[0-9]+$/i;
    provincia = numero.substr(0,2); 
    if(!expreg.test(numero) || (provincia < 1 || provincia > numeroProvincias)){
      colocaError(campoErr, campoSeccion,"Formato inválido",btn);    
      return error = 1;
    }
  }

  if(tipo != 3)
  {
    /* Aqui almacenamos los digitos de la cedula en variables. */
    d1  = numero.substr(0,1);         
    d2  = numero.substr(1,1);         
    d3  = numero.substr(2,1);         
    d4  = numero.substr(3,1);         
    d5  = numero.substr(4,1);         
    d6  = numero.substr(5,1);         
    d7  = numero.substr(6,1);         
    d8  = numero.substr(7,1);         
    d9  = numero.substr(8,1);         
    d10 = numero.substr(9,1);                
           
    /* El tercer digito es: */                           
    /* 9 para sociedades privadas y extranjeros   */         
    /* 6 para sociedades publicas */         
    /* menor que 6 (0,1,2,3,4,5) para personas naturales */ 
    if (d3==7 || d3==8){    
      colocaError(campoErr, campoSeccion,"Formato inválido",btn);           
      return error = 1;
    }       
           
    /* Solo para personas naturales (modulo 10) */         
    if (d3 < 6){           
      nat = true;            
      p1 = d1 * 2;  if (p1 >= 10) p1 -= 9;
      p2 = d2 * 1;  if (p2 >= 10) p2 -= 9;
      p3 = d3 * 2;  if (p3 >= 10) p3 -= 9;
      p4 = d4 * 1;  if (p4 >= 10) p4 -= 9;
      p5 = d5 * 2;  if (p5 >= 10) p5 -= 9;
      p6 = d6 * 1;  if (p6 >= 10) p6 -= 9; 
      p7 = d7 * 2;  if (p7 >= 10) p7 -= 9;
      p8 = d8 * 1;  if (p8 >= 10) p8 -= 9;
      p9 = d9 * 2;  if (p9 >= 10) p9 -= 9;             
      modulo = 10;
    }         
    /* Solo para sociedades publicas (modulo 11) */                  
    /* Aqui el digito verficador esta en la posicion 9, en las otras 2 en la pos. 10 */
    else if(d3 == 6){           
      pub = true;             
      p1 = d1 * 3;
      p2 = d2 * 2;
      p3 = d3 * 7;
      p4 = d4 * 6;
      p5 = d5 * 5;
      p6 = d6 * 4;
      p7 = d7 * 3;
      p8 = d8 * 2;            
      p9 = 0;            
    }         
           
    /* Solo para entidades privadas (modulo 11) */         
    else if(d3 == 9) {           
      pri = true;                                   
      p1 = d1 * 4;
      p2 = d2 * 3;
      p3 = d3 * 2;
      p4 = d4 * 7;
      p5 = d5 * 6;
      p6 = d6 * 5;
      p7 = d7 * 4;
      p8 = d8 * 3;
      p9 = d9 * 2;            
    }
                  
    suma = p1 + p2 + p3 + p4 + p5 + p6 + p7 + p8 + p9;                
    residuo = suma % modulo;                                         
    /* Si residuo=0, dig.ver.=0, caso contrario 10 - residuo*/
    digitoVerificador = residuo==0 ? 0: modulo - residuo;                
    /* ahora comparamos el elemento de la posicion 10 con el dig. ver.*/                         
    if (pub==true){           
      if (digitoVerificador != d9){
        colocaError(campoErr, campoSeccion,"Formato inválido",btn);                                
        return error = 1;
      }                  
      /* El ruc de las empresas del sector publico terminan con 0001*/         
      if ( numero.substr(9,4) != '0001' ){
        colocaError(campoErr, campoSeccion,"Formato inválido",btn);                          
        return error = 1;
      }
    }        
    else if(pri == true){         
      if (digitoVerificador != d10){ 
        colocaError(campoErr, campoSeccion,"Formato inválido",btn);                                
        return error = 1;
      }         
      if (numero.substr(10,3) != '001' ){ 
        colocaError(campoErr, campoSeccion,"Formato inválido",btn);                          
        return error = 1;
      }
    }      
    else if(nat == true){         
      if (digitoVerificador != d10){ 
        colocaError(campoErr, campoSeccion,"Formato inválido",btn);                                 
        return error = 1;
      }         
      if (numero.length >10 && numero.substr(10,3) != '001' ){
        colocaError(campoErr, campoSeccion,"Formato inválido",btn);                           
        return error = 1;
      }
    }
  }
  return error;
}  

function fileValidation(fileInput){

  var filePath = fileInput.value;
  var allowedExtensions = /[.jpg |.jpeg |.png]$/i;
  if(!allowedExtensions.exec(filePath)){
    colocaError("err_img", "seccion_img","El formato permitido es .jpeg/.jpg/.png","btndeposito");
    fileInput.value = '';
    document.getElementById('divimagen').innerHTML = '';
    return 1;
  }else{
    return 0;
  }
}
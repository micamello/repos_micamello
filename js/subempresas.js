if(document.getElementById('form_editarCuenta')){
  validaRecursos();
}

function cambiarEstados(){

  if(document.getElementById('estado')){

    var estado = document.getElementById('estado').value;
    console.log(estado);
    if(estado == 0){
      document.getElementById('nom_estado').innerHTML = '<h6><b>Activo</b></h6>';
      document.getElementById('estado').value = 1;
    }else{
      document.getElementById('nom_estado').innerHTML = '<h6><b>Inactivo</b></h6>';
      document.getElementById('estado').value = 0;
    }
  }
}

function calRec(){

  var idplan = $('#plan').val();
  return calcularRecursos(idplan);
}

function calcularRecursos(idplan){

  var error = 0;
  var nuevo_valor = 0;
  var puerto_host = $('#puerto_host').val();

  if(idplan == ''){
    var idplan = $('#plan').val();
  }

  if(document.getElementById('name_user') && document.getElementById('name_user').value == ''){
    
    if(document.getElementById('num_post') && $('#num_post').val() == -1){
      document.getElementById('num_post').value = 1;
    }

    if(document.getElementById('num_desc') && $('#num_desc').val() == -1){
      document.getElementById('num_desc').value = 1;
    }
  }

  $.ajax({
      type: "GET",
      url: puerto_host+"?mostrar=subempresa&opcion=buscaRecursos&idPlanEmpresa="+idplan,
      dataType:'json',
      async: false,
      success:function(data){

        var post_asignar = parseInt(data.num_publicaciones_rest);
        var desc_asignar = parseInt(data.num_descarga_rest);

        var num_post = $('#num_post').val();
        var num_desc = $('#num_desc').val();

        if(num_post == ''){
          num_post = 0;
        }else{
          num_post = parseInt(num_post);
        }

        if(num_desc == ''){
          num_desc = 0;
        }else{
          num_desc = parseInt(num_desc);
        }

        if(document.getElementById('postNum')){
          document.getElementById('postNum').value = '';
          document.getElementById('descNum').value = '';
        }

        if(document.getElementById('post') && document.getElementById('desc')){

          var post = parseInt(document.getElementById('post').value);
          var desc = parseInt(document.getElementById('desc').value);

          var cantd_1 = Math.abs(post-num_post);
          var cantd_2 = Math.abs(desc-num_desc);
          
          if(!isNaN(cantd_1)){

            var sumAsignar = post_asignar+post;
            if(num_post <= sumAsignar && num_post != 0){

              if(sumAsignar-num_post == 0){
                nuevo_valor = 0;
              }else{
                nuevo_valor = sumAsignar-num_post;
              }
              document.getElementById('post_asignar').innerHTML = nuevo_valor;
              quitarError("rec1","recursos1");
            }else{
              colocaError("rec1","recursos1","La cantidad no es válida","button_crear");
              document.getElementById('post_asignar').innerHTML = post_asignar+post;
              error = 1;
            }
          }else{
            error = 1;
          }
          
          if(!isNaN(cantd_2)){ 

            var sumAsignar2 = desc_asignar+desc;
            if(num_desc <= sumAsignar2 && num_desc != 0){
              
              if(sumAsignar2-num_desc == 0){
                nuevo_valor = 0;
              }else{
                nuevo_valor = sumAsignar2-num_desc;
              }

              document.getElementById('desc_asignar').innerHTML = nuevo_valor;
              quitarError("rec2","recursos2");
            }else{
              colocaError("rec2","recursos2","La cantidad no es válida","button_crear");
              document.getElementById('desc_asignar').innerHTML = desc_asignar+desc;
              error = 1;
            }
          }else{
            error = 1;
          }
    
        }else{

          if(post_asignar >= 1){

            var cantd_1 = num_post;

            if(cantd_1 != -1){

              if(cantd_1 <= post_asignar && cantd_1 != 0){
                nuevo_valor = post_asignar-cantd_1;
                document.getElementById('post_asignar').innerHTML = nuevo_valor;
                quitarError("rec1","recursos1");
              }else{
                colocaError("rec1","recursos1","La cantidad no es válida","button_crear");
                document.getElementById('post_asignar').innerHTML = post_asignar;
                error = 1;
              }

              $('#seccion_postulacion').show();
            }else{
              colocaError("rec1","recursos1","El número debe ser positivo","button_crear");
              document.getElementById('post_asignar').innerHTML = post_asignar;
              $('#seccion_postulacion').hide();
              error = 1;
            }
            document.getElementById('pI').innerHTML = '';
          }else{
            if(post_asignar == -1){ 
              document.getElementById('pI').innerHTML = '<label style="color:red" class="parpadea">Número de Publicaciones Ilimitadas</label>';
              document.getElementById('num_post').value = '-1';
              $('#seccion_postulacion').hide();
            }else{
              document.getElementById('pI').innerHTML = '';
              $('#seccion_postulacion').hide();
            }
          }
          
          if(desc_asignar >= 1){

              var cantd_2 = num_desc;
              if(cantd_2 != -1){

                  if(cantd_2 <= desc_asignar && cantd_2 != 0){
                      nuevo_valor = desc_asignar-cantd_2;
                      document.getElementById('desc_asignar').innerHTML = nuevo_valor;
                      quitarError("rec2","recursos2");
                  }else{
                      colocaError("rec2","recursos2","La cantidad no es válida","button_crear");
                      document.getElementById('desc_asignar').innerHTML = desc_asignar;
                      error = 1;
                  }
                  $('#seccion_descarga').show();
                  //$('#seccion_recursos').show();
              }else{
                 colocaError("rec2","recursos2","El número debe ser positivo","button_crear");
                 document.getElementById('desc_asignar').innerHTML = desc_asignar;
                 $('#seccion_descarga').hide();
                 //$('#seccion_recursos').hide();
                 error = 1;
              }
              document.getElementById('dI').innerHTML = '';
          }else{
            if(desc_asignar == -1){
              document.getElementById('dI').innerHTML = '<label style="color:red" class="parpadea">Número de Descargas Ilimitadas</label>';
              document.getElementById('num_desc').value = '-1';
              $('#seccion_descarga').hide();
            }else{
              document.getElementById('dI').innerHTML = '';
              $('#seccion_descarga').hide();
            }
          }

          if((post_asignar >= 0 || post_asignar == -1) || (desc_asignar >= 0 || desc_asignar == -1)){
            $('#seccion_recursos').show();
          }
        }

        if(document.getElementById('form_editarCuenta')){
          validaRecursos();
        }else{
          validaCampos();
        }
      },
      error: function (request, status, error) {
          error = 1;
      }                  
  })
  
  return error;
}

$('#correo').on('blur', function(){

  validarCorreo();
  validaCampos();
});

$('#plan').on('change', function(){

    var plan = document.getElementById('plan').value;

    if(calcularRecursos(plan) == 1 || plan != 0){
      quitarError("err_plan","seccion_plan");
    }else{
      $('#seccion_recursos').hide();
      colocaError("err_plan","seccion_plan","Debe seleccionar una opcion de la lista","button_crear");
    }
    validaCampos();
});

$('#plan1').on('change', function(){

    var plan = document.getElementById('plan1').value;

    if(calcularRecursos(plan) == 1 || plan != 0){
      quitarError("err_plan","seccion_plan");
    }else{
      $('#seccion_recursos').hide();
      colocaError("err_plan","seccion_plan","Debe seleccionar una opcion de la lista","button_editar");
    }
    validaRecursos();
});

$('#name_user').on('blur', function(){

  var nombres = document.getElementById('name_user').value;
  if(nombres.length <= '100'){
    validarInput(nombres,"err_nom","seccion_nombre");
    validaCampos();
  }else{
    colocaError("err_nom","seccion_nombre","El nombre no debe exceder de 100 caracteres","button_crear");
  }
});

$('#nombre_contact').on('blur', function(){

  var nombres = document.getElementById('nombre_contact').value;
  if(nombres.length <= '100'){
    validarInput(nombres,"nom_cont","group_nombre_contact");
    validaCampos();
  }else{
    colocaError("nom_cont","group_nombre_contact","El nombre no debe exceder de 100 caracteres","button_crear");
  }
});

$('#apellido_contact').on('blur', function(){

  var apellidos = document.getElementById('apellido_contact').value;
  if(apellidos.length <= '100'){
    validarInput(apellidos,"err_apell","group_apell_contact");
    validaCampos();
  }else{
    colocaError("err_apell","group_apell_contact","El apellido no debe exceder de 100 caracteres","button_crear");
  }
});

$('#tel_one_contact').on('blur', function(){

  var tel_one_contact = document.getElementById('tel_one_contact').value;
  if(tel_one_contact.length <= '25'){
    validarNumTelf(tel_one_contact,"tel_err","group_num1_contact");
    validaCampos();
  }else{
    colocaError("tel_err","group_num1_contact","El telefono no debe exceder de 25 caracteres","button_crear");
  }
});

$('#numero_cand').on('blur', function(){

  var tel_one_contact = document.getElementById('numero_cand').value;
  if(tel_one_contact.length <= '25'){
    validarNumTelf(tel_one_contact,"err_num","seccion_num");
    validaCampos();
  }else{
    colocaError("err_num","seccion_num","El telefono no debe exceder de 25 caracteres","button_crear");
  }
});

function validar_EC(dni_obj,tipo,error,group,btn){

  if(searchAjax($('#dni'),tipo) == false){
    if(DniRuc_Validador($('#dni'),tipo) == false){
      quitarError(error,group);
    }else{
      colocaError(error,group,"Documento ingresado no es válido",btn);
      error = 1;      
    }
  }else{
    colocaError(error,group,"Documento ingresado ya existe",btn);
    error = 1; 
  } 
}

function chequeaRUC(dni){

  var host = document.getElementById('iso').value;
  var btn = "button_crear"; 
  var error = 0;

  if(dni != ""){
      
      if (typeof window['validar_'+host] === 'function') {
          window['validar_'+host](dni,1,"dni_error", "dni_group", btn);
          if(host == "EC"){

            if(((dni.length)) < 13){
                colocaError("dni_error", "dni_group", "Para ingresar el RUC son 13 números",btn);
                error = 1;
            }
          }
      }
  }       
  else{
      colocaError("dni_error", "dni_group", "El campo no puede ser vacío", btn);
      error = 1;
  }
  return error;
}

$('#dni').on('blur', function(){
  var dni = document.getElementById('dni').value;
  chequeaRUC(dni);
  validaCampos();
});

$('#button_crear').on('click', function(){
  enviarFormulario();
});

$('#button_editar').on('click', function(){
  enviarRecursos();
});


function existeCorreo(correo){

  var value = "";
  var puerto_host = $('#puerto_host').val();
  if (correo != "") {
      $.ajax({
          type: "GET",
          url: puerto_host+"?opcion=buscaCorreo&correo="+correo,
          dataType: 'json',
          async: false,
          success:function(data){
              value = data.respcorreo;
          },
          error: function (request, status, error) {
              alert(request.responseText);
          }                  
      })
  }
  return value;
}

/*function existeDni(dni){

  var value = "";
  var puerto_host = $('#puerto_host').val();
  if (dni != "") {
      $.ajax({
          type: "GET",
          url: puerto_host+"?opcion=buscaDni&dni="+dni,
          dataType: 'json',
          async: false,
          success:function(data){
              value = data.respdni;
          },
          error: function (request, status, error) {
              alert(request.responseText);
          }                  
      })
  }
  return value;
}*/

function validarNumTelf(num,err_telf,seccion_telf){

  var btn = "button_crear";
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
}

function validarCorreo(){

  var error = 0;
  var correo = document.getElementById('correo').value;
  var expreg_correo = /^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/i;
  var btn = "button_crear";
  var err_correo = "correo_div_error"; var seccion_correo= "correo_group";

  if(correo == null || correo.length == 0 || /^\s+$/.test(correo)){

    colocaError(err_correo, seccion_correo,"El campo no puede ser vacío",btn);
    error = 1; 

  }else if(!expreg_correo.test(correo)){

    colocaError(err_correo,seccion_correo,"Formato incorrecto, no es un correo válido",btn); 
    error = 1;  

  }else{

    if(existeCorreo(correo) != 1){
        colocaError(err_correo,seccion_correo, "El correo ingresado ya existe", btn);
    }
    else{
        quitarError(err_correo,seccion_correo);
    }
  }
  return error;
}

function enviarFormulario(){

  var estado = validarFormulario();

  if(estado == 1){
      document.form_crearCuenta.submit();
  }
}

function validaCampos(){

  var elem = $('#form_crearCuenta').find('input[type!="hidden"]');
  var select = document.getElementById('plan').value;
  var errors = 0; 

  if(select != 0){
    for(i=0; i < elem.length; i++){

      if(elem[i].id != 'tel_two_contact'){

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
    $("#button_crear").addClass('disabled');
  }else{
    $("#button_crear").removeClass('disabled');
  }
} 

function enviarRecursos(){

  var estado = validaRecursos();
  if(estado == 0 && verifyErrors() == 0){
    document.form_editarCuenta.submit();
  }
}

function validaRecursos(){

  if(document.getElementById('num_post')){
    var num_post = document.getElementById('num_post').value;
  }else{
    var num_post = -1;
  }

  if(document.getElementById('num_desc')){
    var num_desc = document.getElementById('num_desc').value;
  }else{
    var num_desc = -1;
  }

  var errors = 0; 

  if(document.getElementById('plan1') && document.getElementById('plan1').value == 0){
    colocaError("err_plan","seccion_plan","Debe seleccionar una opcion de la lista","button_crear");
    errors = 1;
  }

  if(num_post == '' || num_post == 0){
    errors = 1;
    colocaError("rec1","recursos1","La cantidad no es válida","button_editar");
  }

  if(num_desc == '' || num_desc == 0){
    errors = 2;
    colocaError("rec2","recursos2","La cantidad no es válida","button_editar");
  }
    //console.log(errors);
  if(errors > 0 || verifyErrors() > 0){
    $("#button_editar").addClass('disabled');
  }else{
    $("#button_editar").removeClass('disabled');
  }
  return errors;
} 

function validarFormulario(){

    var error = 0;

    if(validarCorreo() == 1){
      error = 1;
    }

    var nombres = document.getElementById('name_user').value;
    if(validarInput(nombres,"err_nom","seccion_nombre") == 1){
      error = 1;
    }

    var nombres = document.getElementById('nombre_contact').value;
    if(validarInput(nombres,"nom_cont","group_nombre_contact") == 1){
      error = 1;
    }

    var apellidos = document.getElementById('apellido_contact').value;
    if(validarInput(apellidos,"err_apell","group_apell_contact") == 1){
      error = 1;
    }

    var tel_one_contact = document.getElementById('tel_one_contact').value;
    if(validarNumTelf(tel_one_contact,"tel_err","group_num1_contact") == 1){
      error = 1;
    }

    var tel_one_contact = document.getElementById('numero_cand').value;
    if(validarNumTelf(tel_one_contact,"err_num","seccion_num") == 1){
      error = 1;
    }

    if(validarSelect("err_plan","seccion_plan") == 1){
      error = 1;
    }

    var dni = document.getElementById('dni').value;
    if(chequeaRUC(dni) == 1){
      error = 1;
    }

    if(error >= 1){
      return 0;
    }else{
      validaCampos();
      return 1;
    }
}

function validarInput(campo,err,err_campo){

  var error = 0;
  var btn = "button_crear";
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

function validarSelect(err_select,err_group_select){

  var btn = "button_crear";
  var error = 0;
  var idEmpresaPlan = $('#plan').val();

  if(idEmpresaPlan != 0){
    if(calcularRecursos(idEmpresaPlan) == 1){
      error = 1;
    }else{
      quitarError(err_select,err_group_select);
    }
  }else{
    colocaError(err_select,err_group_select,"Debe seleccionar una opcion de la lista",btn);
    error = 1;
  }

  return error;
}


/*$(document).ready(function () {
  var idplan = $('#plan').val();
  if(idplan != ''){
    return calcularRecursos(idplan,0);
  }
});*/

if(document.getElementById('form_editarCuenta')){
  calRec();
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
  if(idplan != ''){
    return calcularRecursos(idplan,0);
  }
}

function calcularRecursos(idplan,tipo){
  //console.log(tipo);
  var mensaje = '';
  var nuevo_valor = 0;
  var puerto_host = $('#puerto_host').val();

  if(idplan == ''){
    var idplan = $('#plan').val();
  }

  if(document.getElementById('name_user') && document.getElementById('name_user').value == ''){
    
    if(document.getElementById('num_post') && $('#num_post').val() == -1){
      document.getElementById('num_post').value = 1;
    }

    if(document.getElementById('num_accesos') && $('#num_accesos').val() == -1){
      document.getElementById('num_accesos').value = 1;
    }
  }

  var ya_entro = 0;

  $.ajax({
      type: "GET",
      url: puerto_host+"/index.php?mostrar=subempresa&opcion=buscaRecursos&idPlanEmpresa="+idplan,
      dataType:'json',
      async: false,
      success:function(data){

        var post_asignar = parseInt(data.num_publicaciones_rest);
        var accesos_asignar = parseInt(data.num_accesos_rest);

        var num_post = $('#num_post').val();
        var num_accesos = $('#num_accesos').val();

        if(num_post != 0){
          num_post = parseInt(num_post);
        }

        if(num_accesos != 0){
          num_accesos = parseInt(num_accesos);
        }

        if(document.getElementById('postNum')){
          document.getElementById('postNum').value = '';
          document.getElementById('accesNum').value = '';
        }

        if(document.getElementById('post') && document.getElementById('acces')){

          var post = parseInt(document.getElementById('post').value);
          var acces = parseInt(document.getElementById('acces').value);

          var cantd_1 = Math.abs(post-num_post);
          var cantd_3 = Math.abs(acces-num_accesos);

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

              document.getElementById('post_asignar').innerHTML = post_asignar+post;
              if(num_post == '' && tipo == 0){
                //console.log('aqui entro4');
                colocaError("rec1","recursos1","No pueden ser vac\u00EDo.","button_editar");
              }else if(num_post == 0 && num_accesos == 0 && num_accesos != '' && tipo == 0){
                //console.log('aqui entro');
                colocaError("rec1","recursos1","No pueden ser cero ambos recursos.","button_editar");
                colocaError("rec3","recursos3","No pueden ser cero ambos recursos.","button_editar");
              }else{
                quitarError("rec1","recursos1");
              }
            }
          }else{
            mensaje += '- Cantd. ofertas, no es un formato v\u00E1lido. \n';
          }


          if(!isNaN(cantd_3)){ 

            var sumAsignar3 = accesos_asignar+acces;
            if(num_accesos <= sumAsignar3 && num_accesos != 0){
              
              if(sumAsignar3-num_accesos == 0){
                nuevo_valor = 0;
              }else{
                nuevo_valor = sumAsignar3-num_accesos;
              }

              document.getElementById('accesos_asignar').innerHTML = nuevo_valor;
              quitarError("rec3","recursos3");
            }else{
              document.getElementById('accesos_asignar').innerHTML = accesos_asignar+acces;
              if(num_accesos == '' && tipo == 0){
                console.log('aqui entro3');
                colocaError("rec3","recursos3","No pueden ser vac\u00EDo.","button_editar");
              }else if(num_post == 0 && num_accesos == 0 && num_post != '' && tipo == 0){
                //console.log('aqui entro2');
                colocaError("rec1","recursos1","No pueden ser cero ambos recursos.","button_editar");
                colocaError("rec3","recursos3","No pueden ser cero ambos recursos.","button_editar");
              }else{
                quitarError("rec3","recursos3");
              }
            }
          }else{
            //error = 1;
            mensaje += '- Cantd. accesos, no es un formato v\u00E1lido. \n';
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
                document.getElementById('post_asignar').innerHTML = post_asignar;
                console.log('cantd_1: '+cantd_1);
                if(cantd_1 == '' && tipo == 0){
                  console.log('entro if');
                  colocaError("rec1","recursos1","No pueden ser vac\u00EDo.","button_crear");
                }else if(cantd_1 == 0 && cantd_2 == 0 && tipo == 0){
                  colocaError("rec1","recursos1","No pueden ser cero ambos recursos.","button_crear");
                  colocaError("rec3","recursos3","No pueden ser cero ambos recursos.","button_crear");
                }else{
                  quitarError("rec1","recursos1");
                }
              }

              $('#seccion_postulacion').show();
            }else{
              colocaError("rec1","recursos1","No puede ser vac\u00EDo","button_crear");
              mensaje += '- Cantd. ofertas, No puede ser vac\u00EDo. \n';
              document.getElementById('post_asignar').innerHTML = post_asignar;
              $('#seccion_postulacion').hide();
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

          if(accesos_asignar >= 1){

              var cantd_2 = num_accesos;
              
              if(cantd_2 != -1){
                
                if(cantd_2 <= accesos_asignar && cantd_2 != 0){
                    nuevo_valor = accesos_asignar-cantd_2;
                    document.getElementById('accesos_asignar').innerHTML = nuevo_valor;
                    quitarError("rec3","recursos3");
                }else{
                  document.getElementById('accesos_asignar').innerHTML = accesos_asignar;
                  console.log('cantd_2: '+cantd_2);
                  if(cantd_2 == '' && tipo == 0){
                    console.log('entro if2');
                    colocaError("rec3","recursos3","No pueden ser vac\u00EDo.","button_crear");
                  }else if(cantd_1 == 0 && cantd_2 == 0 && tipo == 0){
                    colocaError("rec1","recursos1","No pueden ser cero ambos recursos.","button_crear");
                    colocaError("rec3","recursos3","No pueden ser cero ambos recursos.","button_crear");
                  }else{
                    quitarError("rec3","recursos3");
                  }
                }
                $('#seccion_acceso').show();
              }else{
                 colocaError("rec3","recursos3","No puede ser vac\u00EDo","button_crear");
                 mensaje += '- Cantd. accesos, No puede ser vac\u00EDo. \n';
                 document.getElementById('accesos_asignar').innerHTML = accesos_asignar;
                 $('#seccion_acceso').hide();
              }
              document.getElementById('aI').innerHTML = '';
          }else{
            if(accesos_asignar == -1){
              document.getElementById('aI').innerHTML = '<label style="color:red" class="parpadea">Número de Accesos Ilimitados</label>';
              document.getElementById('num_accesos').value = '-1';
              $('#seccion_acceso').hide();
            }else{
              document.getElementById('aI').innerHTML = '';
              $('#seccion_acceso').hide();
            }
          }

          if((post_asignar >= 0 || post_asignar == -1) /*|| (desc_asignar >= 0 || desc_asignar == -1) */|| (accesos_asignar >= 0 || accesos_asignar == -1)){
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
          //error = 1;
          mensaje += 'Hubo un error de conexi\u00F3n al servidor. \n';
      }                  
  })
  
  return mensaje;
}

$('#correo').on('blur', function(){

  validarCorreo();
  validaCampos();
});

$('#plan').on('change', function(){

    var plan = document.getElementById('plan').value;

    if(calcularRecursos(plan,1) == 1 || plan != 0){
      quitarError("err_plan","seccion_plan");
    }else{
      $('#seccion_recursos').hide();
      colocaError("err_plan","seccion_plan","Debe seleccionar una opcion de la lista","button_crear");
    }
    validaCampos();
});

/*$('#plan1').on('change', function(){

    var plan = document.getElementById('plan1').value;

    if(calcularRecursos(plan,0) == 1 || plan != 0){
      quitarError("err_plan","seccion_plan");
    }else{
      $('#seccion_recursos').hide();
      colocaError("err_plan","seccion_plan","Debe seleccionar una opcion de la lista","button_editar");
    }
    validaRecursos();
});*/

$('#name_user').on('blur', function(){

  var nombres = document.getElementById('name_user').value;
  if(nombres.length <= '100'){
    validarInput(nombres,"err_nom","seccion_nombre","Nombres");
    validaCampos();
  }else{
    colocaError("err_nom","seccion_nombre","El nombre no debe exceder de 100 caracteres","button_crear");
  }
});

$('#sectorind').on('change', function(){

  var sector_industrial = document.getElementById('sectorind').value;
  if(sector_industrial != 0){
    quitarError("err_sector","sector");
  }else{
    //mensaje += '- Sector Industrial, Debe seleccionar una opci\u00F3n\n';
    colocaError("err_sector","sector","Debe seleccionar una opción de la lista",'button_crear');
  }
});



$('#nombre_contact').on('blur', function(){

  var nombres = document.getElementById('nombre_contact').value;
  if(nombres.length <= '100'){
    validarInput(nombres,"nom_cont","group_nombre_contact","Nombres contacto");
    validaCampos();
  }else{
    colocaError("nom_cont","group_nombre_contact","El nombre no debe exceder de 100 caracteres","button_crear");
  }
});

$('#apellido_contact').on('blur', function(){

  var apellidos = document.getElementById('apellido_contact').value;
  if(apellidos.length <= '100'){
    validarInput(apellidos,"err_apell","group_apell_contact","Apellidos");
    validaCampos();
  }else{
    colocaError("err_apell","group_apell_contact","El apellido no debe exceder de 100 caracteres","button_crear");
  }
});

$('#tel_one_contact').on('blur', function(){

  var tel_one_contact = document.getElementById('tel_one_contact').value;
  if(tel_one_contact.length >= '10' && tel_one_contact.length <= '15'){
    validarNumTelf(tel_one_contact,"tel_err","group_num1_contact","Celular");
    validaCampos();
  }else if(tel_one_contact.length < '10'){
      colocaError("tel_err","group_num1_contact","Longitud mín. 10 caracteres","button_crear");
      //mensaje += '- Celular, longitud m\u00EDn. 10 caracteres\n'; 
      error = 1; 
  }else if(tel_one_contact.length > '15'){

      colocaError("tel_err","group_num1_contact","Longitud máx. 15 caracteres","button_crear");
      //mensaje += '- Celular, longitud m\u00E1x. 15 caracteres\n'; 
      error = 1; 
  }else{
      quitarError("tel_err","group_num1_contact");
  }

});

$('#numero_cand').on('blur', function(){

  var tel_one_contact = document.getElementById('numero_cand').value;
  if(tel_one_contact.length >= '9' && tel_one_contact.length <= '15'){
    validarNumTelf(tel_one_contact,"err_num","seccion_num","Teléfono");
    validaCampos();
  }else if(tel_one_contact.length < '9'){
      colocaError("err_num","seccion_num","Longitud mín. 9 caracteres","button_crear");
      //mensaje += '- Celular, longitud m\u00EDn. 9 caracteres\n'; 
      error = 1; 
  }else if(tel_one_contact.length > '15'){

      colocaError("err_num","seccion_num","Longitud máx. 15 caracteres","button_crear");
      //mensaje += '- Celular, longitud m\u00E1x. 15 caracteres\n'; 
      error = 1; 
  }else{
      quitarError("err_num","seccion_num");
  }
});


$('#tel_two_contact').on('blur', function(){

  var expreg_telf = /^[0-9]+$/i;
  var tel_two_contact = document.getElementById('tel_two_contact').value;
  if(tel_two_contact.length > 0){
    if(!expreg_telf.test(tel_two_contact)){
      colocaError("tel_err2","group_num2_contact","Formato incorrecto, solo numeros",'button_crear');
      //mensaje += '- Tel\u00E9fono convencional, Formato incorrecto\n';
      error = 1; 
    }else if(tel_two_contact.length < '9'){
        colocaError("tel_err2","group_num2_contact","Longitud mín. 9 caracteres","button_crear");
        //mensaje += '- Tel\u00E9fono convencional, longitud m\u00EDn. 9 caracteres\n'; 
        error = 1; 
    }else if(tel_two_contact.length > '9'){

        colocaError("tel_err2","group_num2_contact","Longitud máx. 9 caracteres","button_crear");
        //mensaje += '- Tel\u00E9fono convencional, longitud m\u00E1x. 9 caracteres\n'; 
        error = 1; 
    }else{
        quitarError("tel_err2","group_num2_contact");
    }
  }
});



function validar_EC(dni_obj,tipo,error,group,btn){

  if(DniRuc_Validador($('#dni'),tipo) == true){

      if(searchAjax($('#dni'),tipo) == false){
        quitarError(error,group);
      }else{
        colocaError(error,group,"Documento ingresado ya existe",btn);
        error = 1; 
      } 
  }else{
    colocaError(error,group,"Documento ingresado no es válido",btn);
    error = 1;      
  } 
}

function chequeaRUC(dni){

  var host = document.getElementById('iso').value;
  var btn = "button_crear"; 
  var mensaje = '';

  if(dni != ""){
      
      if (typeof window['validar_'+host] === 'function') {
          window['validar_'+host](dni,1,"dni_error", "dni_group", btn);
          if(host == "EC"){

            if(((dni.length)) < 13){
                colocaError("dni_error", "dni_group", "Para ingresar el RUC son 13 números",btn);
                mensaje += '- RUC, son 13 números \n';
            }
          }
      }
  }       
  else{
      colocaError("dni_error", "dni_group", "El campo no puede ser vacío", btn);
      mensaje += '- RUC, no puede ser vacío \n';
  }
  return mensaje;
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
          url: puerto_host+"/index.php?mostrar=inicio&opcion=buscaCorreo&correo="+correo,
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

function validarNumTelf(num,err_telf,seccion_telf,campo){

  var btn = "button_crear";
  var expreg_telf = /^[0-9]+$/i;
  var mensaje = '';

  if(num == null || num.length == 0 || /^\s+$/.test(num)){

      colocaError(err_telf,seccion_telf,"El campo no puede ser vacío",btn);
      mensaje += '- '+campo+', no puede ser vacío \n';

  }else if(!expreg_telf.test(num)){

    colocaError(err_telf,seccion_telf,"Formato incorrecto, solo numeros",btn);
    mensaje += '- '+campo+', Formato incorrecto, solo numeros \n';

  }else{
      quitarError(err_telf,seccion_telf);
  }

  return mensaje;
}

function validarCorreo(){

  var mensaje = '';
  var correo = document.getElementById('correo').value;
  var expreg_correo = /^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/i;
  var btn = "button_crear";
  var err_correo = "correo_div_error"; var seccion_correo= "correo_group";

  if(correo == null || correo.length == 0 || /^\s+$/.test(correo)){

    colocaError(err_correo, seccion_correo,"El campo no puede ser vacío",btn);
    mensaje += '- Correo, no puede ser vacío\n';
    //error = 1; 

  }else if(!expreg_correo.test(correo)){

    colocaError(err_correo,seccion_correo,"Formato incorrecto",btn); 
    mensaje += '- Correo, Formato incorrecto, no es un correo válido\n';
    //error = 1;  

  }else{

    if(existeCorreo(correo) != false){
        colocaError(err_correo,seccion_correo, "El correo ingresado ya existe", btn);
        mensaje += '- Correo, ingresado ya existe\n';
    }
    else{
        quitarError(err_correo,seccion_correo);
    }
  }
  return mensaje;
}

function enviarFormulario(){

  var estado = validarFormulario();

  if(estado == 1){
      document.form_crearCuenta.submit();
  }else{
    //mostrarERRORES
    Swal.fire({
      //title: '¡Advertencia!',        
      html: 'Faltan algunos datos:<br>'+estado,
      imageUrl: $('#puerto_host').val()+'/imagenes/wrong-04.png',
      imageWidth: 210,
      confirmButtonText: 'ACEPTAR',
      animation: true
    });      
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
  if(estado == '' && verifyErrors() == 0){
    document.form_editarCuenta.submit();
  }else{
    Swal.fire({
      //title: '¡Advertencia!',        
      html: 'Faltan algunos datos:<br>'+estado,
      imageUrl: $('#puerto_host').val()+'/imagenes/wrong-04.png',
      imageWidth: 210,
      confirmButtonText: 'ACEPTAR',
      animation: true
    });
  }
}

function validaRecursos(){

  if(document.getElementById('num_post')){
    var num_post = document.getElementById('num_post').value;
  }else{
    var num_post = -1;
  }

  if(document.getElementById('num_accesos')){
    var num_accesos = document.getElementById('num_accesos').value;
  }else{
    var num_accesos = -1;
  }

  var mensaje = ''; 

  var num_post = document.getElementById('num_post').value;
  var num_accesos = document.getElementById('num_accesos').value;
  if(num_post == '' && num_accesos == ''){
    colocaError("rec1","recursos1","No puede ser vac\u00EDo","button_editar");
    colocaError("rec3","recursos3","No puede ser vac\u00EDo","button_editar");
    mensaje += '- Cantd. ofertas, no puede ser vac\u00EDo. \n';
    mensaje += '- Cantd. accesos, no puede ser vac\u00EDo. \n';
  }else if(num_post == '' && num_accesos >= 0){
    colocaError("rec1","recursos1","No puede ser vac\u00EDo","button_editar");
    mensaje += '- Cantd. ofertas, no puede ser vac\u00EDo. \n';
  }else if(num_accesos == '' && num_post >= 0){
    colocaError("rec3","recursos3","No puede ser vac\u00EDo","button_editar");
    mensaje += '- Cantd. accesos, no puede ser vac\u00EDo. \n';
  }

//console.log(mensaje);
  if(mensaje != '' || verifyErrors() > 0){
    $("#button_editar").addClass('disabled');
  }else{
    $("#button_editar").removeClass('disabled');
  }
  return mensaje;
} 

function validarFormulario(){

    var mensaje = '';

    var mjs = validarCorreo();
    if(mjs != ''){
      mensaje += mjs;
      //error = 1;
    }

    var nombres = document.getElementById('name_user').value;
    var mjs = validarInput(nombres,"err_nom","seccion_nombre","Nombres");
    if(mjs != ''){
      mensaje += mjs;
      //error = 1;
    }

    var nombres = document.getElementById('nombre_contact').value;
    var mjs = validarInput(nombres,"nom_cont","group_nombre_contact","Nombres contacto");
    if(mjs != ''){
      mensaje += mjs;
    }

    var apellidos = document.getElementById('apellido_contact').value;
    var mjs = validarInput(apellidos,"err_apell","group_apell_contact","Apellidos");
    if(mjs != ''){
      mensaje += mjs;
    }

    var tel_one_contact = document.getElementById('tel_one_contact').value;
    var mjs = validarNumTelf(tel_one_contact,"tel_err","group_num1_contact","Celular");
    if(mjs != ''){
      mensaje += mjs;
    }

    var numero_cand = document.getElementById('numero_cand').value;
    var mjs = validarNumTelf(numero_cand,"err_num","seccion_num","Teléfono");
    if(mjs != ''){
      mensaje += mjs;
    }

    var mjs = validarSelect("err_plan","seccion_plan", "Plan");
    if(mjs != ''){
      mensaje += mjs;
    }

    var sector_industrial = document.getElementById('sectorind').value;
    if(sector_industrial != 0){
      quitarError("err_sector","sector");
    }else{
      mensaje += '- Sector Industrial, Debe seleccionar una opci\u00F3n\n';
      colocaError("err_sector","sector","Debe seleccionar una opción de la lista",'button_crear');
      //error = 1;
    }

    var dni = document.getElementById('dni').value;
    var mjs = chequeaRUC(dni);
    if(mjs != ''){
      mensaje += mjs;
    }

    var num_post = document.getElementById('num_post').value;
    var num_accesos = document.getElementById('num_accesos').value;
    if(num_post == '' && num_accesos == ''){
      colocaError("rec1","recursos1","No puede ser vac\u00EDo","button_editar");
      colocaError("rec3","recursos3","No puede ser vac\u00EDo","button_editar");
      mensaje += '- Cantd. accesos, no puede ser vac\u00EDo. \n';
      mensaje += '- Cantd. ofertas, no puede ser vac\u00EDo. \n';
    }else if(num_post == '' && num_accesos >= 0){
      colocaError("rec1","recursos1","No puede ser vac\u00EDo","button_editar");
      mensaje += '- Cantd. ofertas, no puede ser vac\u00EDo. \n';
    }else if(num_accesos == '' && num_post >= 0){
      colocaError("rec3","recursos3","No puede ser vac\u00EDo","button_editar");
      mensaje += '- Cantd. accesos, no puede ser vac\u00EDo. \n';
    }

    if(mensaje != ''){
      return mensaje;
    }else{
      validaCampos();
      return 1;
    }
}

function validarInput(campo,err,err_campo,nom_campo){

  var mensaje = '';
  var btn = "button_crear";
  var expreg = /^[a-z A-ZñÑáéíóúÁÉÍÓÚ]+$/i;

  if(campo == null || campo.length == 0 || /^\s+$/.test(campo)){
    colocaError(err,err_campo,"El campo no puede ser vacío",btn);
    mensaje += '- '+nom_campo+', no puede ser vacío \n';
    //error = 1; 
  }else if(!expreg.test(campo)){
    colocaError(err,err_campo,"Formato incorrecto, solo letras",btn);
    mensaje += '- '+nom_campo+', Formato incorrecto, solo letras \n';
    //error = 1;
  }else{
    quitarError(err,err_campo);
  }
  return mensaje;
}

function validarSelect(err_select,err_group_select,campo){

  var btn = "button_crear";
  var mensaje = '';
  var idEmpresaPlan = $('#plan').val();

  if(idEmpresaPlan != 0){
    var mjs = calcularRecursos(idEmpresaPlan,0);
    //console.log(mjs);
    if(mjs != ''){
      mensaje += mjs;
      //error = 1;
    }else{
      quitarError(err_select,err_group_select);
    }
  }else{
    colocaError(err_select,err_group_select,"Debe seleccionar una opción",btn);
    mensaje += '- '+campo+', debe seleccionar una opci\u00F3n \n';
    //error = 1;
  }

  return mensaje;
}


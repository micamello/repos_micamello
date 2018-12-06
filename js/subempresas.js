function colocaError(campo, id, mensaje, btn){

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
  $("#"+btn).addClass('disabled');
}

function quitarError(campo,id){

  document.getElementById(campo).innerHTML = '';
  $("#"+id).removeClass('has-error');
}

function calcularRecursos(){

  var error = 0;
  var nuevo_valor = 0;
  var puerto_host = $('#puerto_host').val();
  var idEmpresaPlan = $('#plan').val();

  $.ajax({
      type: "GET",
      url: puerto_host+"?mostrar=subempresa&opcion=buscaRecursos&idPlanEmpresa="+idEmpresaPlan,
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
            //console.log(cantd_1+' - '+num_post+' - '+post_asignar+' - '+post+' - '+sumAsignar);
            if(num_post <= sumAsignar && num_post != 0){

              if(sumAsignar-num_post == 0){
                nuevo_valor = 0;
              }else{
                nuevo_valor = sumAsignar-num_post;
              }
              document.getElementById('post_asignar').innerHTML = nuevo_valor;
              quitarError("rec1","recursos1");
              document.getElementById('num').value = '-1';
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
              //nuevo_valor = desc_asignar+num_desc;
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
              $('#seccion_recursos').show();
            }else{
              colocaError("rec1","recursos1","El número debe ser positivo","button_crear");
              document.getElementById('post_asignar').innerHTML = post_asignar;
              $('#seccion_postulacion').hide();
              $('#seccion_recursos').hide();
              error = 1;
            }
            document.getElementById('pI').innerHTML = '';
          }else{
            if(post_asignar == -1){ 
              $('#seccion_recursos').show();
              document.getElementById('pI').innerHTML = '<label style="color:red" class="parpadea">Número de Publicaciones Ilimitadas</label>';
              document.getElementById('num_post').value = '-1';
              $('#seccion_postulacion').hide();
            }else{
              document.getElementById('pI').innerHTML = '';
              $('#seccion_recursos').hide();
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
                  $('#seccion_recursos').show();
              }else{
                 colocaError("rec2","recursos2","El número debe ser positivo","button_crear");
                 document.getElementById('desc_asignar').innerHTML = desc_asignar;
                 $('#seccion_descarga').hide();
                 $('#seccion_recursos').hide();
                 error = 1;
              }
              document.getElementById('dI').innerHTML = '';
          }else{
            if(desc_asignar == -1){
              $('#seccion_recursos').show();
              document.getElementById('dI').innerHTML = '<label style="color:red" class="parpadea">Número de Descargas Ilimitadas</label>';
              document.getElementById('num_desc').value = '-1';
              $('#seccion_descarga').hide();
            }else{
              document.getElementById('dI').innerHTML = '';
              $('#seccion_recursos').hide();
              $('#seccion_descarga').hide();
            }
          }
        }
        validaCampos();
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

    var plan = document.getElementById('plan').selectedIndex;

    if(calcularRecursos() == 1 || plan != 0){
      quitarError("err_plan","seccion_plan");
    }else{
      $('#seccion_recursos').hide();
      colocaError("err_plan","seccion_plan","Debe seleccionar una opcion de la lista","button_crear");
    }
    validaCampos();
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

// function validarDocumento(obj){
     
//   var mensaje = "DNI no válido";
//   numero = obj;

//   var suma = 0;      
//   var residuo = 0;      
//   var pri = false;      
//   var pub = false;            
//   var nat = false;      
//   var numeroProvincias = 22;                  
//   var modulo = 11;
//   var button_register = 'button_crear';

//   /* Verifico que el campo no contenga letras */                  
//   var ok=1;
//   for (i=0; i < numero.length && ok==1 ; i++){
//      var n = parseInt(numero.charAt(i));
//      if (isNaN(n)) ok=0;
//   }

//   if (ok==0){
//      colocaError("dni_error", "dni_group", mensaje, button_register);
//      // alert("No puede ingresar caracteres en el número");         
//      return 1;
//   }
//   else
//   {
//      quitarError("dni_error", "dni_group");
//   }
 
//   if (numero.length < 10 ){ 

//      colocaError("dni_error", "dni_group", mensaje, button_register);             
//      // alert('El número ingresado no es válido');                  
//      return 1;
//   }
//   else
//   {
//      quitarError("dni_error", "dni_group");
//   }
 
//   /* Los primeros dos digitos corresponden al codigo de la provincia */
//   provincia = numero.substr(0,2);      
//   if (provincia < 1 || provincia > numeroProvincias){     
//   colocaError("dni_error", "dni_group", mensaje, button_register);    
//      // alert('El código de la provincia (dos primeros dígitos) es inválido');
//  return 1;       
//   }
//   else
//   {
//      quitarError("dni_error", "dni_group");
//   }
//   /* Aqui almacenamos los digitos de la cedula en variables. */
//   d1  = numero.substr(0,1);         
//   d2  = numero.substr(1,1);         
//   d3  = numero.substr(2,1);         
//   d4  = numero.substr(3,1);         
//   d5  = numero.substr(4,1);         
//   d6  = numero.substr(5,1);         
//   d7  = numero.substr(6,1);         
//   d8  = numero.substr(7,1);         
//   d9  = numero.substr(8,1);         
//   d10 = numero.substr(9,1);                
     
//   /* El tercer digito es: */                           
//   /* 9 para sociedades privadas y extranjeros   */         
//   /* 6 para sociedades publicas */         
//   /* menor que 6 (0,1,2,3,4,5) para personas naturales */ 
//   if (d3==7 || d3==8){    
//     colocaError("dni_error", "dni_group", mensaje, button_register);       
//      // alert('El tercer dígito ingresado es inválido');                     
//      return 1;
//   }
//   else
//   {
//      quitarError("dni_error", "dni_group");
//   }         
     
//   /* Solo para personas naturales (modulo 10) */         
//   if (d3 < 6){           
//      nat = true;            
//      p1 = d1 * 2;  if (p1 >= 10) p1 -= 9;
//      p2 = d2 * 1;  if (p2 >= 10) p2 -= 9;
//      p3 = d3 * 2;  if (p3 >= 10) p3 -= 9;
//      p4 = d4 * 1;  if (p4 >= 10) p4 -= 9;
//      p5 = d5 * 2;  if (p5 >= 10) p5 -= 9;
//      p6 = d6 * 1;  if (p6 >= 10) p6 -= 9; 
//      p7 = d7 * 2;  if (p7 >= 10) p7 -= 9;
//      p8 = d8 * 1;  if (p8 >= 10) p8 -= 9;
//      p9 = d9 * 2;  if (p9 >= 10) p9 -= 9;             
//      modulo = 10;
//   }         
//   /* Solo para sociedades publicas (modulo 11) */                  
//   /* Aqui el digito verficador esta en la posicion 9, en las otras 2 en la pos. 10 */
//   else if(d3 == 6){           
//      pub = true;             
//      p1 = d1 * 3;
//      p2 = d2 * 2;
//      p3 = d3 * 7;
//      p4 = d4 * 6;
//      p5 = d5 * 5;
//      p6 = d6 * 4;
//      p7 = d7 * 3;
//      p8 = d8 * 2;            
//      p9 = 0;            
//   }         
     
//   /* Solo para entidades privadas (modulo 11) */         
//   else if(d3 == 9) {           
//      pri = true;                                   
//      p1 = d1 * 4;
//      p2 = d2 * 3;
//      p3 = d3 * 2;
//      p4 = d4 * 7;
//      p5 = d5 * 6;
//      p6 = d6 * 5;
//      p7 = d7 * 4;
//      p8 = d8 * 3;
//      p9 = d9 * 2;            
//   }
            
//   suma = p1 + p2 + p3 + p4 + p5 + p6 + p7 + p8 + p9;                
//   residuo = suma % modulo;                                         
//   /* Si residuo=0, dig.ver.=0, caso contrario 10 - residuo*/
//   digitoVerificador = residuo==0 ? 0: modulo - residuo;                
//   /* ahora comparamos el elemento de la posicion 10 con el dig. ver.*/                         
//   if (pub==true){           
//      if (digitoVerificador != d9){
//      colocaError("dni_error", "dni_group", mensaje, button_register);                          
//         // alert('El ruc de la empresa del sector público es incorrecto.');            
//         return 1;
//      }                  
//      /* El ruc de las empresas del sector publico terminan con 0001*/         
//      if ( numero.substr(9,4) != '0001' ){
//      colocaError("dni_error", "dni_group", mensaje, button_register);                    
//         // alert('El ruc de la empresa del sector público debe terminar con 0001');
//         return 1;
//      }
//   }        
//   else if(pri == true){         
//      if (digitoVerificador != d10){ 
//      colocaError("dni_error", "dni_group", mensaje, button_register);                         
//         // alert('El ruc de la empresa del sector privado es incorrecto.');
//         return 1;
//      }         
//      if ( numero.substr(10,3) != '001' ){ 
//      colocaError("dni_error", "dni_group", mensaje, button_register);                   
//         // alert('El ruc de la empresa del sector privado debe terminar con 001');
//         return 1;
//      }
//   }      
//   else if(nat == true){         
//      if (digitoVerificador != d10){ 
//      colocaError("dni_error", "dni_group", mensaje, button_register);                         
//         // alert('El número de cédula de la persona natural es incorrecto.');
//         return 1;
//      }         
//      if (numero.length >10 && numero.substr(10,3) != '001' ){
//      colocaError("dni_error", "dni_group", mensaje, button_register);                    
//         // alert('El ruc de la persona natural debe terminar con 001');
//         return 1;
//      }
//   }
//   else
//   {
//      quitarError("dni_error", "dni_group");
//   }      
//   return 0;
// }  

function validar_EC(dni_obj,tipo,error,group,btn){

  var validacion = validarDocumento(dni_obj,tipo,error,group,btn);
  return validacion;
}

function chequeaRUC(dni){

  var host = document.getElementById('iso').value;
  var btn = "button_crear"; 
  var error = 0;

  if(dni != ""){
      
      if (typeof window['validar_'+host] === 'function') {
          window['validar_'+host](dnid,1,"dni_error", "dni_group", btn);
          if(host == "EC"){

              if(((dni.length)) < 13){
                  colocaError("dni_error", "dni_group", "Para ingresar el RUC son 13 números",btn);
                  error = 1;
              }
              else{
                  if(existeDni(dni) != 1){
                      colocaError("dni_error", "dni_group","El numero de RUC ya existe", btn);
                      error = 1;
                  }
                  else
                  {
                      quitarError("dni_error", "dni_group");
                  }
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

function existeDni(dni){

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
}

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

  var num_post = document.getElementById('num_post').value;
  var num_desc = document.getElementById('num_desc').value;
  var errors = 0; 

  if(document.getElementById('plan') && document.getElementById('plan').value == 0){
    colocaError("err_plan","seccion_plan","Debe seleccionar una opcion de la lista","button_crear");
    errors = 1;
  }

  if(num_post == '' || num_post == 0){
    errors = 1;
  }

  if(num_desc == '' || num_desc == 0){
    errors = 1;
  }

  if(errors > 0){
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
    if(calcularRecursos() == 1){
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

function verifyErrors(){
  var listerrors = document.getElementsByClassName('msg_error');
  return listerrors.length;
}

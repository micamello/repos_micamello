/*$(document).ready(function () {
  var idplan = $('#plan').val();
  if(idplan != ''){
    return calcularRecursos(idplan,0);
  }
});*/
if(document.getElementById('form_editarCuenta')){
  calRec();
}

if(document.getElementById('form_crearCuenta')){
  var idplan = document.getElementById('plan').value;
  if(idplan != 0){
    calcularRecursos(idplan);
  }
}

function cambiarEstados(){

  if(document.getElementById('estado')){

    var estado = document.getElementById('estado').value;
    //console.log(estado);
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

  var idplan = document.getElementById('plan').value;
  if(idplan == 0){
    colocaError("err_plan","seccion_plan","Seleccione una opción","button_editar");
    return 1;
  }else{
    return calcularRecursos(idplan);
  }
}

function calcularRecursos(idplan){
  //console.log(tipo);
  var mensaje = '';
  var nuevo_valor = 0;
  var puerto_host = $('#puerto_host').val();

  if(idplan == ''){
    var idplan = document.getElementById('plan').value;
  }

  if(document.getElementById('name_user') && document.getElementById('name_user').value == ''){
    
    if(document.getElementById('num_post') && $('#num_post').val() == -1){
      document.getElementById('num_post').value = 1;
    }

    if(document.getElementById('num_accesos') && $('#num_accesos').val() == -1){
      document.getElementById('num_accesos').value = 1;
    }
  }

  //var ya_entro = 0;

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

        if(document.getElementById('form_editarCuenta')){
          var btn = "button_editar";
        }else{
          var btn = "button_crear";
        }

        if(document.getElementById('post') && document.getElementById('acces')){
          //console.log('if1');
          var post = parseInt(document.getElementById('post').value);
          var acces = parseInt(document.getElementById('acces').value);

          if(post_asignar > post){
            var cantd_rest1 = parseInt(post_asignar-post);
          }else{
            var cantd_rest1 = parseInt(post-post_asignar);
          }

          if(accesos_asignar > acces){
            var cantd_rest3 = parseInt(accesos_asignar-acces);
          }else{
            var cantd_rest3 = parseInt(acces-accesos_asignar);
          }
          //console.log(cantd_rest3);
          var tipo = 1;
        }else{
          //console.log('if2');
          var cantd_rest1 = parseInt(post_asignar);
          var cantd_rest3 = parseInt(accesos_asignar);

          var post = parseInt(num_post);
          var acces = parseInt(num_accesos);
          var tipo = 2;
        }
        
        //if(cantd_rest1 == cantd_rest3 && cantd_rest1 != 0){
          if(!isNaN(cantd_rest1) && cantd_rest1 >= 0){

            if(tipo == 1){
              var sumAsignar = post_asignar+post;
            }else{
              var sumAsignar = post_asignar;
            }
            //console.log('sumAsignar: '+sumAsignar);
              //console.log('sumAsignar3: '+sumAsignar3);
              //console.log('post: '+post);
              //console.log('acces: '+acces);
            if(num_post <= sumAsignar && num_post != 0 && sumAsignar != 0){

              if(parseInt(sumAsignar-num_post) == 0){
                nuevo_valor = 0;
              }else{
                nuevo_valor = sumAsignar-num_post;
              }
              //console.log('nuevo_valor:'+nuevo_valor);
              document.getElementById('post_asignar').innerHTML = nuevo_valor;
              quitarError("rec1","recursos1");
            }else if(num_post == 0 && num_accesos == 0 && num_post != ''){
                //console.log('aqui entro ifnuevo');
                colocaError("rec1","recursos1","No pueden ser cero ambos recursos.",btn);
                colocaError("rec3","recursos3","No pueden ser cero ambos recursos.",btn);
                mensaje += 'Cantd. ofertas, no pueden ser vac\u00EDo. <br>';
                mensaje += 'Cantd. accesos, no pueden ser vac\u00EDo. <br>';
                document.getElementById('post_asignar').innerHTML = post_asignar;
                document.getElementById('accesos_asignar').innerHTML = accesos_asignar;
            }else{
              
              if(post_asignar > 0){

                if(tipo == 1){
                  document.getElementById('post_asignar').innerHTML = post_asignar+post;
                }else{
                  document.getElementById('post_asignar').innerHTML = post_asignar;
                }
                if(num_post == ''){
                  //console.log('aqui entro4');
                  colocaError("rec1","recursos1","No pueden ser vac\u00EDo.",btn);
                  mensaje += 'Cantd. ofertas, no pueden ser vac\u00EDo. <br>';
                }else if(num_post == 0 && num_accesos == 0 && num_accesos != ''){
                  //console.log('aqui entro');
                  colocaError("rec1","recursos1","No pueden ser cero ambos recursos.",btn);
                  colocaError("rec3","recursos3","No pueden ser cero ambos recursos.",btn);
                  mensaje += 'Cantd. ofertas, no pueden ser vac\u00EDo. <br>';
                  mensaje += 'Cantd. accesos, no pueden ser vac\u00EDo. <br>';
                }else if(num_post > post_asignar){
                  colocaError("rec1","recursos1","Cantidad no v\u00E1lida.",btn);
                  mensaje += 'Cantd. ofertas, cantidad no v\u00E1lida. <br>';
                }else{
                  quitarError("rec1","recursos1");
                }
              }else if(num_post == 0 && num_accesos == 0 && num_accesos != ''){
                //console.log('aqui entro');
                colocaError("rec1","recursos1","No pueden ser cero ambos recursos.",btn);
                colocaError("rec3","recursos3","No pueden ser cero ambos recursos.",btn);
                mensaje += 'Cantd. ofertas, no pueden ser vac\u00EDo. <br>';
                mensaje += 'Cantd. accesos, no pueden ser vac\u00EDo. <br>';
              }else{
                document.getElementById('pI').innerHTML = '';
                //document.getElementById('post_asignar').innerHTML = post_asignar;

                if(num_post == 0 && tipo == 2){
                  //console.log('num_post: '+num_post);
                  document.getElementById('num_post').disabled = true;
                  document.getElementById('num_post').value = 0;
                  document.getElementById('post_asignar').innerHTML = post_asignar;
                  quitarError("rec1","recursos1");
                }else if(num_post == 0 && tipo == 1){
                  //console.log('acces: '+acces);
                  if(acces == 0 && accesos_asignar < 0){
                    document.getElementById('num_post').value = 1;
                    document.getElementById('post_asignar').innerHTML = post_asignar+post-1;
                  }else{
                    document.getElementById('num_post').value = 0;
                    document.getElementById('post_asignar').innerHTML = post_asignar+post;
                    //document.getElementById('num_post').disabled = true;
                  }
                  quitarError("rec1","recursos1");
                }else{
                  document.getElementById('post_asignar').innerHTML = post_asignar+post;
                  /*if(num_post == 0 && num_accesos == 0 && num_accesos != ''){
                    //console.log('aqui entro');
                    colocaError("rec1","recursos1","No pueden ser cero ambos recursos.",btn);
                    colocaError("rec3","recursos3","No pueden ser cero ambos recursos.",btn);
                    mensaje += 'Cantd. ofertas, no pueden ser vac\u00EDo. <br>';
                    mensaje += 'Cantd. accesos, no pueden ser vac\u00EDo. <br>';
                  }else */if(num_post > post_asignar){
                    colocaError("rec1","recursos1","Cantidad no v\u00E1lida.",btn);
                    mensaje += 'Cantd. ofertas, cantidad no v\u00E1lida. <br>';
                  }else{
                    quitarError("rec1","recursos1");
                  }
                }
              }
            }
            $('#seccion_postulacion').show();
            $('#seccion_acceso').show();
          }else{
            colocaError("rec1","recursos1","Cantidad no v\u00E1lida.",btn);
            mensaje += 'Cantd. ofertas, cantidad no v\u00E1lida. <br>';
            document.getElementById('post_asignar').innerHTML = 0;
          }

          if(!isNaN(cantd_rest3) && cantd_rest3 >= 0){ 
            
            if(tipo == 1){
              var sumAsignar3 = accesos_asignar+acces;
            }else{
              var sumAsignar3 = accesos_asignar;
            }
            //console.log(sumAsignar3);
            if(num_accesos <= sumAsignar3 && num_accesos != 0 && sumAsignar3 != 0){
              
              if(sumAsignar3-num_accesos == 0){
                nuevo_valor = 0;
              }else{
                nuevo_valor = sumAsignar3-num_accesos;
              }
              
              document.getElementById('accesos_asignar').innerHTML = nuevo_valor;
              quitarError("rec3","recursos3");
            }else if(num_post == 0 && num_accesos == 0 && num_accesos != ''){
              //console.log('aqui entro2');
              colocaError("rec1","recursos1","No pueden ser cero ambos recursos.",btn);
              colocaError("rec3","recursos3","No pueden ser cero ambos recursos.",btn);
              mensaje += 'Cantd. ofertas, no pueden ser vac\u00EDo. <br>';
              mensaje += 'Cantd. accesos, no pueden ser vac\u00EDo. <br>';
              document.getElementById('post_asignar').innerHTML = post_asignar;
              document.getElementById('accesos_asignar').innerHTML = accesos_asignar;
            }else{
              //console.log(accesos_asignar);
              if(accesos_asignar > 0){
                if(tipo == 1){
                  document.getElementById('accesos_asignar').innerHTML = accesos_asignar+acces;
                }else{
                  document.getElementById('accesos_asignar').innerHTML = accesos_asignar;
                }
                if(num_accesos == ''){
                  //console.log('aqui entro3');
                  colocaError("rec3","recursos3","No pueden ser vac\u00EDo.",btn);
                  mensaje += 'Cantd. accesos, no pueden ser vac\u00EDo. <br>';
                }else if(num_post == 0 && num_accesos == 0 && num_post != ''){
                  //console.log('aqui entro2');
                  colocaError("rec1","recursos1","No pueden ser cero ambos recursos.",btn);
                  colocaError("rec3","recursos3","No pueden ser cero ambos recursos.",btn);
                  mensaje += 'Cantd. ofertas, no pueden ser vac\u00EDo. <br>';
                  mensaje += 'Cantd. accesos, no pueden ser vac\u00EDo. <br>';
                }else if(num_accesos > accesos_asignar){
                  colocaError("rec3","recursos3","Cantidad no v\u00E1lida.",btn);
                  mensaje += 'Cantd. accesos, cantidad no v\u00E1lida. <br>';
                }else{
                  quitarError("rec3","recursos3");
                }
              }/*else if(post == cantd_rest1 && acces == cantd_rest3){
                console.log('aqui entro ifnuevo');
                colocaError("rec1","recursos1","No pueden ser cero ambos recursos.",btn);
                colocaError("rec3","recursos3","No pueden ser cero ambos recursos.",btn);
                mensaje += 'Cantd. ofertas, no pueden ser vac\u00EDo. <br>';
                mensaje += 'Cantd. accesos, no pueden ser vac\u00EDo. <br>';
              }*/else{
                
                document.getElementById('aI').innerHTML = '';
                //document.getElementById('accesos_asignar').innerHTML = accesos_asignar;

                if(num_accesos == 0 && tipo == 2){
                  //console.log('num_accesos: '+num_accesos);
                  document.getElementById('num_accesos').disabled = true;
                  document.getElementById('num_accesos').value = 0;
                  document.getElementById('accesos_asignar').innerHTML = accesos_asignar;
                  quitarError("rec3","recursos3");
                }else if(num_accesos == 0 && tipo == 1 /*&& accesos_asignar == num_accesos*/){
                 //console.log('post: '+post);
                  if(post == 0 && post_asignar < 0){ console.log('entro'+post_asignar);
                    document.getElementById('num_accesos').value = 1;
                    document.getElementById('accesos_asignar').innerHTML = accesos_asignar+acces-1;
                  }else{
                    document.getElementById('num_accesos').value = 0;
                    //document.getElementById('num_accesos').disabled = true;
                    document.getElementById('accesos_asignar').innerHTML = accesos_asignar+acces;
                  }
                  quitarError("rec3","recursos3");
                }else{
                  document.getElementById('accesos_asignar').innerHTML = accesos_asignar+acces;
                  /*if(num_post == 0 && num_accesos == 0 && num_post != ''){
                    //console.log('aqui entro2');
                    colocaError("rec1","recursos1","No pueden ser cero ambos recursos.",btn);
                    colocaError("rec3","recursos3","No pueden ser cero ambos recursos.",btn);
                    mensaje += 'Cantd. ofertas, no pueden ser vac\u00EDo. <br>';
                    mensaje += 'Cantd. accesos, no pueden ser vac\u00EDo. <br>';
                  }else*/ if(num_accesos > accesos_asignar){
                    colocaError("rec3","recursos3","Cantidad no v\u00E1lida.",btn);
                    mensaje += 'Cantd. accesos, cantidad no v\u00E1lida. <br>';
                  }else{
                    quitarError("rec3","recursos3");
                  }
                }
              }
            }
            $('#seccion_postulacion').show();
            $('#seccion_acceso').show();
          }else{
            //console.log('aaaaa');
            colocaError("rec3","recursos3","Cantidad no v\u00E1lida.",btn);
            mensaje += 'Cantd. accesos, cantidad no v\u00E1lida. <br>';
            document.getElementById('accesos_asignar').innerHTML = 0;
          }
        /*}else{
          alert('no permitir llegar a cero');
        }*/
        /*}else{
          console.log('if2');
         
          if(post_asignar > 0){

            if(num_post != -1){
              
              if(num_post <= post_asignar && num_post != 0 && post_asignar != 0){
                nuevo_valor = post_asignar-num_post;
                document.getElementById('post_asignar').innerHTML = nuevo_valor;
                quitarError("rec1","recursos1");
              }else{
                console.log('num_post: '+num_post);
                document.getElementById('post_asignar').innerHTML = post_asignar;
                if(num_post == ''){
                  colocaError("rec1","recursos1","No pueden ser vac\u00EDo.",btn);
                  mensaje += 'Cantd. ofertas, no pueden ser vac\u00EDo. <br>';
                }else if(num_post == 0 ){
                  colocaError("rec1","recursos1","No pueden ser cero ambos recursos.",btn);
                  //colocaError("rec3","recursos3","No pueden ser cero ambos recursos.",btn);
                  mensaje += 'Cantd. ofertas, no pueden ser cero ambos recursos. <br>';
                  //mensaje += 'Cantd. accesos, no pueden ser cero ambos recursos. <br>';
                }else if(num_post > post_asignar){
                  colocaError("rec1","recursos1","Cantidad no v\u00E1lida.",btn);
                  mensaje += 'Cantd. ofertas, cantidad no v\u00E1lida. <br>';
                }else{
                  quitarError("rec1","recursos1");
                }
              }
              $('#seccion_postulacion').show();
              $('#seccion_acceso').show();
            }else{
              colocaError("rec1","recursos1","No puede ser vac\u00EDo",btn);
              mensaje += '- Cantd. ofertas, no puede ser vac\u00EDo. <br>';
            }
            document.getElementById('pI').innerHTML = '';
          }else{
            /*if(post_asignar == -1){ 
              document.getElementById('pI').innerHTML = '<label style="color:red" class="parpadea">Número de Publicaciones Ilimitadas</label>';
              document.getElementById('num_post').value = '-1';
              $('#seccion_postulacion').hide();
            }else{
              document.getElementById('pI').innerHTML = '';

              if(post_asignar == 0){
                document.getElementById('num_post').disabled = true;
                document.getElementById('num_post').value = 0;
                document.getElementById('post_asignar').innerHTML = 0;
              }else{
                document.getElementById('post_asignar').innerHTML = post_asignar;
              }

              if(num_accesos == 0){
                colocaError("rec3","recursos3","No pueden ser cero ambos recursos.",btn);
                mensaje += 'Cantd. accesos, no pueden ser cero ambos recursos. <br>';
              }

              quitarError("rec1","recursos1");
            }
              colocaError("rec1","recursos1","Cantidad no v\u00E1lida.",btn);
              mensaje += 'Cantd. ofertas, cantidad no v\u00E1lida. <br>';
               //document.getElementById('num_post').value = 0;
               // document.getElementById('post_asignar').innerHTML = 0;
            
          }

          if(accesos_asignar > 0){

              if(num_accesos != -1){
                
                if(num_accesos <= accesos_asignar && num_accesos != 0 && accesos_asignar != 0){
                    nuevo_valor = accesos_asignar-num_accesos;
                    document.getElementById('accesos_asignar').innerHTML = nuevo_valor;
                    quitarError("rec3","recursos3");
                }else{
                  document.getElementById('accesos_asignar').innerHTML = accesos_asignar;
                  console.log('num_accesos: '+num_accesos);
                  if(num_accesos == ''){
                    colocaError("rec3","recursos3","No pueden ser vac\u00EDo.",btn);
                    mensaje += 'Cantd. accesos, no pueden ser vac\u00EDo. <br>';
                  }else if( num_accesos == 0){
                    //colocaError("rec1","recursos1","No pueden ser cero ambos recursos.",btn);
                    colocaError("rec3","recursos3","No pueden ser cero ambos recursos.",btn);
                    //mensaje += 'Cantd. ofertas, no pueden ser cero ambos recursos. <br>';
                    mensaje += 'Cantd. accesos, no pueden ser cero ambos recursos. <br>';
                  }else if(num_accesos > accesos_asignar){
                    colocaError("rec3","recursos3","Cantidad no v\u00E1lida.",btn);
                    mensaje += 'Cantd. accesos, cantidad no v\u00E1lida. <br>';
                  }else{
                    quitarError("rec3","recursos3");
                  }
                }
                $('#seccion_postulacion').show();
                $('#seccion_acceso').show();
              }else{
                 colocaError("rec3","recursos3","No puede ser vac\u00EDo",btn);
                 mensaje += '- Cantd. accesos, no puede ser vac\u00EDo. <br>';
              }
              document.getElementById('aI').innerHTML = '';
          }else{
            /*if(accesos_asignar == -1){
              document.getElementById('aI').innerHTML = '<label style="color:red" class="parpadea">Número de Accesos Ilimitados</label>';
              document.getElementById('num_accesos').value = '-1';
              $('#seccion_acceso').hide();
            }else{
              document.getElementById('aI').innerHTML = '';
            
              if(accesos_asignar == 0){
                document.getElementById('num_accesos').disabled = true;
                document.getElementById('num_accesos').value = 0;
                document.getElementById('accesos_asignar').innerHTML = 0;
              }else{
                document.getElementById('accesos_asignar').innerHTML = accesos_asignar;
              }

              if(num_post == 0 ){
                colocaError("rec1","recursos1","No pueden ser cero ambos recursos.",btn);
                mensaje += 'Cantd. ofertas, no pueden ser cero ambos recursos. <br>';
              }
              quitarError("rec3","recursos3"); 
            }
              colocaError("rec3","recursos3","Cantidad no v\u00E1lida.",btn);
              mensaje += 'Cantd. accesos, cantidad no v\u00E1lida. <br>';
              //document.getElementById('num_accesos').value = 0;
                //document.getElementById('accesos_asignar').innerHTML = 0;
           
          }*/

          if((post_asignar >= 0 || post_asignar == -1) || (accesos_asignar >= 0 || accesos_asignar == -1)){
            $('#seccion_recursos').show();
          }
        //}

        if(document.getElementById('form_editarCuenta')){
          if(mensaje != '' || verifyErrors() > 0){
            $("#button_editar").addClass('disabled');
          }else{
            $("#button_editar").removeClass('disabled');
          }
        }else{
          validaCampos();
        }
      },
      error: function (request, status, error) {
        colocaError("rec1","recursos1","Verifique su conexión de red. Intente de nuevo.","button_crear");
        colocaError("rec3","recursos3","Verifique su conexión de red. Intente de nuevo.","button_crear");
          //error = 1;
          // console.log();
          // mensaje += 'Hubo un error de conexi\u00F3n al servidor. <br>';
          mensaje += 2;
      },
       beforeSend : function(){
        ajaxLoader($('#num_post'), 'aparecer', 2);
        ajaxLoader($('#num_accesos'), 'aparecer', 2);
      },
      complete : function(){
        ajaxLoader($('#num_post'), 'desaparecer');
        ajaxLoader($('#num_accesos'), 'desaparecer');
      }               
  })
  
  return mensaje;
}

$('#correo').on('blur', function(){
  $(this).val($(this).val().trim().toLowerCase());
  validarCorreo();
  validaCampos();
});

$('#plan').on('change', function(){

    var plan = document.getElementById('plan').value;
    var calcularRecursosVar = calcularRecursos(plan);
    // console.log(calcularRecursosVar);
    if((calcularRecursosVar == 1 || plan != 0) && calcularRecursosVar != 2){
      quitarError("err_plan","seccion_plan");
    }
    else if(calcularRecursosVar == 2){
      colocaError("err_plan","seccion_plan","Verifique su conexión de red. Intente de nuevo.","button_crear");
    }else{
      $('#seccion_recursos').hide();
      colocaError("err_plan","seccion_plan","Seleccione una opción","button_crear");
    }
    validaCampos();
});

/*$('#plan1').on('change', function(){

    var plan = document.getElementById('plan1').value;

    if(calcularRecursos(plan,0) == 1 || plan != 0){
      quitarError("err_plan","seccion_plan");
    }else{
      $('#seccion_recursos').hide();
      colocaError("err_plan","seccion_plan","Seleccione una opción","button_editar");
    }
    validaRecursos();
});*/

function validarNombreEmpresa(nombre){
  if((/^([a-zA-ZÁÉÍÓÚñáéíóúÑ]+[0-9&.,' ]*)*$/.test(nombre))){
      return true;
  }
  else{
      return false;
  }
}

$('#name_user').on('blur', function(){

  var nombres = document.getElementById('name_user').value;
  if(nombres.length <= '100'){
    if(nombres == null || nombres.length == 0 || /^\s+$/.test(nombres)){
      colocaError("err_nom", "seccion_nombre","El campo no puede ser vacío","button_crear");
      mensaje += '- Nombre de la empresa, no puede ser vacío <br>';
    }else if(!validarNombreEmpresa(nombres)){
      colocaError("err_nom", "seccion_nombre","Formato incorrecto","button_crear");
      mensaje += '- Nombre de la empresa, Formato incorrecto<br>';
    }else{
      quitarError("err_nom","seccion_nombre");
    }
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
    //mensaje += '- Sector Industrial, Debe seleccionar una opci\u00F3n<br>';
    colocaError("err_sector","sector","Selecciona una opción.",'button_crear');
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
  $(this).val($(this).val().replace("+", "").replace(/[{()}]/g, '').replace(/\s/g, ""));
  var tel_one_contact = document.getElementById('tel_one_contact').value;
  if(tel_one_contact.length >= '10' && tel_one_contact.length <= '15'){
    validarNumTelf(tel_one_contact,"tel_err","group_num1_contact","Celular");
    validaCampos();
  }else if(tel_one_contact.length < '10'){
      colocaError("tel_err","group_num1_contact","Longitud mín. 10 caracteres","button_crear");
      //mensaje += '- Celular, longitud m\u00EDn. 10 caracteres<br>'; 
      error = 1; 
  }else if(tel_one_contact.length > '15'){

      colocaError("tel_err","group_num1_contact","Longitud máx. 15 caracteres","button_crear");
      //mensaje += '- Celular, longitud m\u00E1x. 15 caracteres<br>'; 
      error = 1; 
  }else{
      quitarError("tel_err","group_num1_contact");
  }

});

$('#numero_cand').on('blur', function(){
  $(this).val($(this).val().replace("+", "").replace(/[{()}]/g, '').replace(/\s/g, ""));
  var tel_one_contact = document.getElementById('numero_cand').value;
  if(tel_one_contact.length >= '9' && tel_one_contact.length <= '15'){
    validarNumTelf(tel_one_contact,"err_num","seccion_num","Teléfono");
    validaCampos();
  }else if(tel_one_contact.length < '9'){
      colocaError("err_num","seccion_num","Longitud mín. 9 caracteres","button_crear");
      //mensaje += '- Celular, longitud m\u00EDn. 9 caracteres<br>'; 
      error = 1; 
  }else if(tel_one_contact.length > '15'){

      colocaError("err_num","seccion_num","Longitud máx. 15 caracteres","button_crear");
      //mensaje += '- Celular, longitud m\u00E1x. 15 caracteres<br>'; 
      error = 1; 
  }else{
      quitarError("err_num","seccion_num");
  }
});


$('#tel_two_contact').on('blur', function(){
  $(this).val($(this).val().replace("+", "").replace(/[{()}]/g, '').replace(/\s/g, ""));
  var expreg_telf = /^[0-9]+$/i;
  var tel_two_contact = document.getElementById('tel_two_contact').value;
  if(tel_two_contact.length > 0){
    if(!expreg_telf.test(tel_two_contact)){
      colocaError("tel_err2","group_num2_contact","Formato incorrecto, solo numeros",'button_crear');
      //mensaje += '- Tel\u00E9fono convencional, Formato incorrecto<br>';
      error = 1; 
    }else if(tel_two_contact.length < '9'){
        colocaError("tel_err2","group_num2_contact","Longitud mín. 9 caracteres","button_crear");
        //mensaje += '- Tel\u00E9fono convencional, longitud m\u00EDn. 9 caracteres<br>'; 
        error = 1; 
    }else if(tel_two_contact.length > '9'){

        colocaError("tel_err2","group_num2_contact","Longitud máx. 9 caracteres","button_crear");
        //mensaje += '- Tel\u00E9fono convencional, longitud m\u00E1x. 9 caracteres<br>'; 
        error = 1; 
    }else{
        quitarError("tel_err2","group_num2_contact");
    }
  }
});



function validar_EC(dni_obj,tipo,error,group,btn){

  if(DniRuc_Validador($('#dni'),tipo, 1) == true){

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
                mensaje += '- RUC, son 13 números <br>';
            }
          }
      }
  }       
  else{
      colocaError("dni_error", "dni_group", "El campo no puede ser vacío", btn);
      mensaje += '- RUC, no puede ser vacío <br>';
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
  var mensaje = enviarRecursos();
  if(mensaje != '' || verifyErrors() > 0){
    $("#button_editar").addClass('disabled');
  }else{
    $("#button_editar").removeClass('disabled');
  }
});

function existeCorreo(correo){

  var value = "";
  var puerto_host = $('#puerto_host').val();
  if(correo != ""){
      $.ajax({
          type: "GET",
          url: puerto_host+"/index.php?mostrar=inicio&opcion=buscaCorreo&correo="+correo,
          dataType: 'json',
          async: false,
          success:function(data){
              value = data.respcorreo;
          },
          error: function (request, status, error) {
              // colocaError("correo_div_error","correo_group", "No se pudo completar la solicitud.", "button_crear");
              value = 2;
              // alert(request.responseText);
          },
          beforeSend : function(){
            ajaxLoader($('#correo'), 'aparecer', 2);
          },
          complete : function(){
            ajaxLoader($('#correo'), 'desaparecer');
          }                 
      })

  }
  return value;
}

function validarNumTelf(num,err_telf,seccion_telf,campo){

  var btn = "button_crear";
  var expreg_telf = /^[0-9]+$/i;
  var mensaje = '';

  if(num == null || num.length == 0 || /^\s+$/.test(num)){

      colocaError(err_telf,seccion_telf,"El campo no puede ser vacío",btn);
      mensaje += '- '+campo+', no puede ser vacío <br>';

  }else if(!expreg_telf.test(num)){

    colocaError(err_telf,seccion_telf,"Formato incorrecto, solo numeros",btn);
    mensaje += '- '+campo+', Formato incorrecto, solo numeros <br>';

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
    mensaje += '- Correo, no puede ser vacío<br>';
    //error = 1; 

  }else if(!expreg_correo.test(correo)){

    colocaError(err_correo,seccion_correo,"Formato incorrecto",btn); 
    mensaje += '- Correo, Formato incorrecto, no es un correo válido<br>';
    //error = 1;  

  }else{

    if(existeCorreo(correo) != false && existeCorreo(correo) != 2){
        colocaError(err_correo,seccion_correo, "El correo ingresado ya existe", btn);
        mensaje += '- Correo, ingresado ya existe<br>';
    }
    else if(existeCorreo(correo) == 2){
      colocaError("correo_div_error","correo_group", "Verifique su conexión de red. Intente de nuevo.", "button_crear");
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
      html: 'Faltan algunos datos por completar:<br>Los campos con (*) son obligatorios',
      imageUrl: $('#puerto_host').val()+'/imagenes/wrong-04.png',
      imageWidth: 75,
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

  var estado = calRec();
  if(estado == '' && verifyErrors() == 0){
    document.form_editarCuenta.submit();
  }else{
    Swal.fire({            
      html: 'Faltan algunos datos por completar:<br>Los campos con (*) son obligatorios',
      imageUrl: $('#puerto_host').val()+'/imagenes/wrong-04.png',
      imageWidth: 75,
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

  
    var plan = document.getElementById('plan').value;

    if(plan == 0){
      colocaError("err_plan","seccion_plan","Selecciona una opción.","button_editar");
      mensaje += '- Plan, debe seleccionar una opci\u00F3n. <br>';
    }else{
      if(document.getElementById('err_plan')){
        quitarError("err_plan","seccion_plan");
      }
    }

  var num_post = document.getElementById('num_post').value;
  var num_accesos = document.getElementById('num_accesos').value;
  if(num_post == '' && num_accesos == ''){
    //console.log(num_post);
    colocaError("rec1","recursos1","No puede ser vac\u00EDo","button_editar");
    colocaError("rec3","recursos3","No puede ser vac\u00EDo","button_editar");
    mensaje += '- Cantd. ofertas, no puede ser vac\u00EDo. <br>';
    mensaje += '- Cantd. accesos, no puede ser vac\u00EDo. <br>';
  }else if(num_post == '' && num_accesos >= 0){
    colocaError("rec1","recursos1","No puede ser vac\u00EDo","button_editar");
    mensaje += '- Cantd. ofertas, no puede ser vac\u00EDo. <br>';
  }else if(num_accesos == '' && num_post >= 0){
    colocaError("rec3","recursos3","No puede ser vac\u00EDo","button_editar");
    mensaje += '- Cantd. accesos, no puede ser vac\u00EDo. <br>';
  }

  //onsole.log(mensaje);
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
    if(nombres.length <= '100'){
      if(nombres == null || nombres.length == 0 || /^\s+$/.test(nombres)){
        colocaError("err_nom", "seccion_nombre","El campo no puede ser vacío","button_crear");
        mjs += '- Nombre de la empresa, no puede ser vacío <br>';
      }else if(!validarNombreEmpresa(nombres)){
        colocaError("err_nom", "seccion_nombre","Formato incorrecto","button_crear");
        mjs += '- Nombre de la empresa, Formato incorrecto<br>';
      }else{
        quitarError("err_nom","seccion_nombre");
      }
      validaCampos();
    }else{
      colocaError("err_nom","seccion_nombre","El nombre no debe exceder de 100 caracteres","button_crear");
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
      mensaje += '- Sector Industrial, Debe seleccionar una opci\u00F3n<br>';
      colocaError("err_sector","sector","Selecciona una opción.",'button_crear');
      //error = 1;
    }

    var dni = document.getElementById('dni').value;
    var mjs = chequeaRUC(dni);
    if(mjs != ''){
      mensaje += mjs;
    }

    /*var num_post = document.getElementById('num_post').value;
    var num_accesos = document.getElementById('num_accesos').value;
    if(num_post == '' && num_accesos == ''){
      colocaError("rec1","recursos1","No puede ser vac\u00EDo","button_editar");
      colocaError("rec3","recursos3","No puede ser vac\u00EDo","button_editar");
      mensaje += '- Cantd. accesos, no puede ser vac\u00EDo. <br>';
      mensaje += '- Cantd. ofertas, no puede ser vac\u00EDo. <br>';
    }else if(num_post == '' && num_accesos >= 0){
      colocaError("rec1","recursos1","No puede ser vac\u00EDo","button_editar");
      mensaje += '- Cantd. ofertas, no puede ser vac\u00EDo. <br>';
    }else if(num_accesos == '' && num_post >= 0){
      colocaError("rec3","recursos3","No puede ser vac\u00EDo","button_editar");
      mensaje += '- Cantd. accesos, no puede ser vac\u00EDo. <br>';
    }*/

    var idplan = document.getElementById('plan').value;

    if(idplan == 0){
      colocaError("err_plan","seccion_plan","Seleccione una opción","button_crear");
      mensaje += '- Seleccione una opción<br>';
    }else{

      var mjs = calcularRecursos(idplan);
      if(mjs != ''){
        mensaje += mjs;
      }
      quitarError("err_plan","seccion_plan");
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
    mensaje += '- '+nom_campo+', no puede ser vacío <br>';
    //error = 1; 
  }else if(!expreg.test(campo)){
    colocaError(err,err_campo,"Formato incorrecto, solo letras",btn);
    mensaje += '- '+nom_campo+', Formato incorrecto, solo letras <br>';
    //error = 1;
  }else{
    quitarError(err,err_campo);
  }
  return mensaje;
}

function validarSelect(err_select,err_group_select,campo){

  var btn = "button_crear";
  var mensaje = '';
  var idEmpresaPlan = document.getElementById('plan').value;

  if(idEmpresaPlan != 0){
    var mjs = calcularRecursos(idEmpresaPlan);
    //console.log(mjs);
    if(mjs != ''){
      mensaje += mjs;
      //error = 1;
    }else{
      quitarError(err_select,err_group_select);
    }
  }else{
    colocaError(err_select,err_group_select,"Debe seleccionar una opción",btn);
    mensaje += '- '+campo+', debe seleccionar una opci\u00F3n <br>';
    //error = 1;
  }

  return mensaje;
}


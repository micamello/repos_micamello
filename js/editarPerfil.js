if(document.getElementById('form_editarPerfil')){

    //validarFormulario();
    //validarClave();

    ocultarCampos();
    mostrarUni();
    //$("#form_editarPerfil").validator();
}

if(document.getElementById('form_cambiar')){
  //$("#form_cambiar").validator();
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

/* Carga de imagen dinamico */

/* Carga de hoja de vida */

$('#subirCV').change(function(e) {
    $('#imagenBtn').attr("src",$('#puerto_host').val()+'/imagenes/actualizar.png');
    $('#texto_status').html('Hoja de vida Cargada');
    $('#texto_status').addClass('arch_cargado');
    document.getElementById("mensaje_error_hv").style.display = "none";
});

/* Carga de hoja de vida */


/* valida si el candidato es mayor de edad */

function calcularEdad()
{
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
        
        /*$("#mayoria").attr({
            class: 'form-group',
        });
        nodo = document.getElementById("error");
        nodo.innerHTML = '';
        $("#boton").removeAttr('disabled');*/
        return 1;

    }else{
        return 0;
        //colocaError("error", "mayoria","Debe ser mayor de edad");
    }
}


/*function colocaError(campo, id, mensaje){

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

    $("#boton").attr({
        'disabled': 'disabled',
    });
}

function quitarError(campo,id){

    document.getElementById(campo).innerHTML = '';
    $("#"+id).removeClass('has-error');
}*/
/* valida si el candidato es mayor de edad */

function mostrarUni(){

    var lugar_estudio = document.getElementById("lugar_estudio");

    if(lugar_estudio){

        if(lugar_estudio.selectedIndex != -1){

            var r = lugar_estudio.options[lugar_estudio.selectedIndex].value;
       
            if(r == 0){
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
                            
                        }else{
                            $("#lugar_estudio").removeAttr("required");
                            elements[i].style.display = 'none';
                            var lugar_estudio = document.getElementById("lugar_estudio");
                            lugar_estudio.selectedIndex = -1;
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
    var expreg = /^[a-z A-ZñÑáéíóúÁÉÍÓÚ]+$/i;
    var expreg_telf = /^[0-9]+$/i;
    var error = 0;

    var nombres = document.getElementById('nombres').value;
    if(document.getElementById('apellidos')){
        var apellidos = document.getElementById('apellidos').value;
    }
    var nacionalidad = document.getElementById('id_nacionalidad').value;
    var fecha_nacimiento = document.getElementById('fecha_nacimiento').value;
    var telefono = document.getElementById('telefono').value;
    var provincia = document.getElementById('provincia').selectedIndex;
    var ciudad = document.getElementById('ciudad').selectedIndex;

    if(tipo_usuario == 1){

        var discapacidad = document.getElementById('discapacidad').selectedIndex;
        var experiencia = document.getElementById('experiencia').selectedIndex;
        var estado_civil = document.getElementById('estado_civil').selectedIndex;
        var genero = document.getElementById('genero').selectedIndex;
        var tiene_trabajo = document.getElementById('tiene_trabajo').selectedIndex;
        var viajar = document.getElementById('viajar').selectedIndex;
        var licencia = document.getElementById('licencia').selectedIndex;
        var escolaridad = document.getElementById('escolaridad').selectedIndex;
        var estatus = document.getElementById('estatus').selectedIndex;
        var area_select = document.getElementById('area_select');
        var nivel_interes = document.getElementById('nivel_interes').selectedIndex;
        var select_array_idioma = document.getElementById('select_array_idioma');
        var lugar_estudio = document.getElementById('lugar_estudio');
        var universidad = document.getElementById('universidad').selectedIndex;
        var universidad2 = document.getElementById('universidad2').value;

        if(discapacidad == null || discapacidad == 0){

            colocaError("err_dis", "seccion_dis","Debe seleccionar una opcion de la lista","boton");
            error = 1;

        }else{
            quitarError("err_exp", "seccion_exp");
        }

        if(experiencia == null || experiencia == 0){

            colocaError("err_exp", "seccion_exp","Debe seleccionar una opcion de la lista","boton");
            error = 1;

        }else{
            quitarError("err_exp", "seccion_exp");
        }

        if(estado_civil == null || estado_civil == 0){

            colocaError("err_civil", "seccion_civil","Debe seleccionar una opcion de la lista","boton");
            error = 1;

        }else{
            quitarError("err_civil", "seccion_civil");
        }

        if(genero == null || genero == 0){

            colocaError("err_gen", "seccion_gen","Debe seleccionar una opcion de la lista","boton");
            error = 1;

        }else{
            quitarError("err_gen", "seccion_gen");
        }

        if(tiene_trabajo == null || tiene_trabajo == 0){

            colocaError("err_trab", "seccion_trab","Debe seleccionar una opcion de la lista","boton");
            error = 1;

        }else{
            quitarError("err_trab", "seccion_trab");
        }

        if(viajar == null || viajar == 0){

            colocaError("err_via", "seccion_via","Debe seleccionar una opcion de la lista","boton");
            error = 1;

        }else{
            quitarError("err_via", "seccion_via");
        }

        if(licencia == null || licencia == 0){

            colocaError("err_lic", "seccion_lic","Debe seleccionar una opcion de la lista","boton");
            error = 1;

        }else{
            quitarError("err_lic", "seccion_lic");
        }

        if(escolaridad == null || escolaridad == 0){

            colocaError("err_esc", "seccion_esc","Debe seleccionar una opcion de la lista","boton");
            error = 1;

        }else{
            quitarError("err_esc", "seccion_esc");
        }

        if(estatus == null || estatus == 0){

            colocaError("err_est", "seccion_est","Debe seleccionar una opcion de la lista","boton");
            error = 1;

        }else{
            quitarError("err_est", "seccion_est");
        }

        if(lugar_estudio.selectedIndex == null || lugar_estudio.selectedIndex == 0){

            colocaError("err_estudio", "seccion_estudio","Debe seleccionar una opcion de la lista","boton");
            error = 1;

        }else{
            quitarError("err_estudio", "seccion_estudio");
        }

        if(lugar_estudio.value == 0){

            if(universidad == null || universidad == 0){

                colocaError("err_univ", "seccion_univ","Debe seleccionar una opcion de la lista","boton");
                error = 1;

            }else{
                quitarError("err_univ", "seccion_univ");
            }

        }else if(lugar_estudio.value == 1){

            if(universidad2 == null || universidad2 == ''){

                colocaError("err_univ", "seccion_univ","Debe introducir una universidad","boton");
                error = 1;

            }else{
                quitarError("err_univ", "seccion_univ");
            }
        }     

        if(area_select.selectedIndex == null || area_select.selectedIndex == -1){

            colocaError("err_area", "seccion_area","Debe seleccionar una opcion de la lista","boton");
            error = 1;

        }else{
            
            var cantd_selec = $('#seleccionados').find('p').length-1;
            if(cantd_selec == 0)
            {
                colocaError("err_area", "seccion_area","Debe seleccionar una opcion de la lista","boton");
                error = 1;
            }else{
                quitarError("err_area", "seccion_area");
            }
        }

        if(nivel_interes == null || nivel_interes == -1){

            colocaError("err_int", "seccion_int","Debe seleccionar una opcion de la lista","boton");
            error = 1;

        }else{
            quitarError("err_int", "seccion_int");
        }

        if((select_array_idioma.length) == 0 || (select_array_idioma.length) == -1){

            colocaError("listado_idiomas", "seccion_listado","Debe seleccionar una opcion de la lista","boton");
            error = 1;

        }else{
            quitarError("listado_idiomas", "seccion_listado");
        }


    }else if(tipo_usuario == 2){

        var nombre_contact = document.getElementById('nombre_contact').value;
        var apellido_contact = document.getElementById('apellido_contact').value;
        var tel_one_contact = document.getElementById('tel_one_contact').value;

        if(nombre_contact == null || nombre_contact.length == 0 || /^\s+$/.test(nombre_contact)){

            colocaError("err_nomCon", "seccion_nombreContacto","El campo no puede ser vacío","boton");
            error = 1; 

        }else if(!expreg.test(nombre_contact)){

            colocaError("err_nomCon", "seccion_nombreContacto","Formato incorrecto, solo letras","boton"); 
            error = 1;  
        }else{
            quitarError("err_nomCon","seccion_nombreContacto");
        }


        if(apellido_contact == null || apellido_contact.length == 0 || /^\s+$/.test(apellido_contact)){

            colocaError("err_apeCon", "seccion_apellidoContacto","El campo no puede ser vacío","boton");
            error = 1; 

        }else if(!expreg.test(apellido_contact)){

            colocaError("err_apeCon", "seccion_apellidoContacto","Formato incorrecto, solo letras","boton");
            error = 1;  

        }else{
            quitarError("err_apeCon","seccion_apellidoContacto");
        }

        if(tel_one_contact == null || tel_one_contact.length == 0 || /^\s+$/.test(tel_one_contact)){

            colocaError("err_tlfCon", "seccion_tlfCon","El campo no puede ser vacío","boton");
            error = 1;

        }else if(!expreg_telf.test(tel_one_contact)){

            colocaError("err_tlfCon", "seccion_tlfCon","Formato incorrecto, solo numeros","boton");
            error = 1; 

        }else{
            quitarError("err_tlfCon","seccion_tlfCon");
        }
    }


    if(nombres == null || nombres.length == 0 || /^\s+$/.test(nombres)){

        colocaError("err_nom", "seccion_nombre","El campo no puede ser vacío","boton");
        error = 1; 

    }else if(!expreg.test(nombres)){
 
        colocaError("err_nom", "seccion_nombre","Formato incorrecto, solo letras","boton");
        error = 1;

    }else{
        quitarError("err_nom","seccion_nombre");
    }

    if(document.getElementById('apellidos')){

        if(apellidos == null || apellidos.length == 0 || /^\s+$/.test(apellidos)){

            colocaError("err_ape", "seccion_apellido","El campo no puede ser vacío","boton");
            error = 1; 

        }else if(!expreg.test(apellidos)){

            colocaError("err_ape", "seccion_apellido","Formato incorrecto, solo letras","boton");
            error = 1;

        }else{
            quitarError("err_ape","seccion_apellido");
        }
    }

    if(telefono == null || telefono.length == 0 || /^\s+$/.test(telefono)){

        colocaError("err_tlf", "seccion_tlf","El campo no puede ser vacío","boton");
        error = 1;

    }else if(!expreg_telf.test(telefono)){

        colocaError("err_tlf", "seccion_tlf","Formato incorrecto, solo numeros","boton");
        error = 1; 

    }else{
        quitarError("err_tlf","seccion_tlf");
    }

    if(!isNaN(fecha_nacimiento)){

        colocaError("error", "mayoria","Debe elegir una fecha válida","boton");
        error = 1;
    }else if(calcularEdad() == 0 && tipo_usuario == 1){

        colocaError("error", "mayoria","Debe ser mayor de edad");
        error = 1;

    }else{
        quitarError("error","mayoria");
    }

    if(provincia == null || provincia == 0){

        colocaError("err_prov", "seccion_provincia","Debe seleccionar una opcion de la lista","boton");
        colocaError("err_ciu", "seccion_ciudad","Debe seleccionar una opcion de la lista","boton");
        error = 1;
    }else{

        if(ciudad == null || ciudad == 0){

            colocaError("err_ciu", "seccion_ciudad","Debe seleccionar una opcion de la lista","boton");
            error = 1;

        }else{
            quitarError("err_ciu","seccion_ciudad");
        }

        quitarError("err_prov","seccion_provincia");
    }

    if(nacionalidad == null || nacionalidad == 0){

        colocaError("err_nac", "seccion_nac","Debe seleccionar una opcion de la lista","boton");
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

    var expreg = /^(?=(?:.*\d))(?=(?:.*[a-zA-Z]))\S{8,}$/i;
    var error = 0;

    var password = document.getElementById('password').value;
    var password_two = document.getElementById('password_two').value;

    if(password == null || password.length == 0 || /^\s+$/.test(password)){

        colocaError("err_clave", "seccion_clave","El campo no puede ser vacío","button_cambiar");
        error = 1; 

    }else if(!expreg.test(password)){

        colocaError("err_clave", "seccion_clave","Formato incorrecto, Letras y números, mínimo 8 caracteres","button_cambiar"); 
        error = 1;  
    }else{
        quitarError("err_clave", "seccion_clave");
    }

    if(password_two == null || password_two.length == 0 || /^\s+$/.test(password_two)){

        colocaError("err_clave1", "seccion_clave1","El campo no puede ser vacío","button_cambiar");
        error = 1; 

    }else if(!expreg.test(password_two)){

        colocaError("err_clave1", "seccion_clave1","Formato incorrecto, Letras y números, mínimo 8 caracteres","button_cambiar"); 
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
        return 1;
    }
}

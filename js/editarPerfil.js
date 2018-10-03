if(document.getElementById('form_editarPerfil')){
    mostrarUni();
    ocultarCampos();
    $("#form_editarPerfil").validator();
}

if(document.getElementById('form_cambiar')){
  $("#form_cambiar").validator();
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
    $('#texto_status').addClass('arch_cargado')
     
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
        
        $("#mayoria").attr({
            class: 'form-group',
        });
        nodo = document.getElementById("error");
        nodo.innerHTML = '';
        $("#boton").removeAttr('disabled');

    }else{

        nodo = document.getElementById("error");
        nodo.innerHTML = '';
        var elem1 = document.createElement('P');
        var t = document.createTextNode("Debe ser mayor de edad"); 
        elem1.appendChild(t);

        var elem2 = document.createElement("P");             
        elem2.classList.add('list-unstyled');
        elem2.classList.add('msg_error');
        elem2.appendChild(elem1); 

        elem2.appendChild(elem1); 
        nodo.appendChild(elem2); 

        $("#mayoria").attr({
            'class': 'has-error',
        });

        $("#boton").attr({
            'disabled': 'disabled',
        });
    }
}
/* valida si el candidato es mayor de edad */

function mostrarUni(){

    var lugar_estudio = document.getElementById("lugar_estudio");

    if(lugar_estudio){

        var r = lugar_estudio.options[lugar_estudio.selectedIndex].value;
        
        if(lugar_estudio.selectedIndex != ''){
            if(r == 0){
                document.getElementById("universidad2").style.display = "none";
                document.getElementById("universidad").style.display = "block";
                document.getElementById("universidad").setAttribute("required",true);
                $("#universidad2").removeAttr("required");;
            }else{
                document.getElementById("universidad").style.display = "none";
                document.getElementById("universidad2").style.display = "block";
                document.getElementById("universidad2").setAttribute("required",true);
                $("#universidad").removeAttr("required");
            }
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
                        }
                    }
                },
                error: function (request, status, error) {
                    alert(request.responseText);
                }                  
            });
        }
    }
}
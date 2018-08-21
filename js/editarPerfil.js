
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

/* Carga dehoja de vida */

$('#subirCV').change(function(e) {
    $('#imagenBtn').attr("src",'http://localhost/repos_micamello/imagenes/actualizar.png');
    $('#texto_status').html('Hoja de vida Cargada');
    $('#texto_status').addClass('arch_cargado')
     
});

/* Carga dehoja de vida */



$('#provincia').change(function()
{
    var id_provincia = $('select[id=provincia]').val();
    var puerto_host = $('#puerto_host').val();
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
})
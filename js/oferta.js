
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

var interes = "";
var provincia = "";
var jornada = "";
var contrato = "";

function result_filter(element,tipo)
{ 
    var busquedas = nodo = '';
    busquedas = document.getElementById("busquedas");

    if (element.className == 'interes' || element.className == 'interes_class filtros')
    {
        if(tipo == 1){
            interes = element.id;
            nodo = document.getElementById("interes_class");
            nodo.setAttribute('onclick','result_filter(this,2);');
            nodo.setAttribute('id',interes);
            $("#interes_class").html('sfvgfdsgv');
            //nodo.append(element.innerHTML+"<i class='fa fa-times click'></i>")
            //select = "<span id='interes_class' onclick='result_filter(this,2);' class='interes_class filtros' id='"+interes+"'>"+element.innerHTML+"<i class='fa fa-times click'></i></span>";
            //$('.interes_class').html(select);
        }else{
            interes = '';
            nodo = document.getElementById("interes_class");
            busquedas.removeChild(nodo);
            var elem = document.createElement('span');
            elem.id = "interes_class";
            elem.classList.add('interes_class');
            busquedas.appendChild(elem);
        }
    }

    if (element.className == 'provincia' || element.className == 'provincia_class filtros')
    {
      if(tipo == 1){
        provincia = element.id;
        select = "<span id='provincia_class' onclick='result_filter(this,2);' class='provincia_class filtros' id='"+provincia+"'>"+element.innerHTML+"<i class='fa fa-times click'></i></span>";
        $('.provincia_class').html(select);
      }else{
        provincia = '';
        nodo = document.getElementById("provincia_class");
        resultado = busquedas.removeChild(nodo);
      }
    }

    if (element.className == 'jornada' || element.className == 'jornada_class filtros')
    {
        if(tipo == 1){
            jornada = element.id;
            select = "<span id='jornada_class' onclick='result_filter(this,2);' class='jornada_class filtros' id='"+jornada+"'>"+element.innerHTML+"<i class='fa fa-times click'></i></span>";
            $('.jornada_class').html(select);
        }else{
            jornada = '';
            nodo = document.getElementById("jornada_class");
            resultado = busquedas.removeChild(nodo);
        }
    }
    
    if (element.className == 'contrato' || element.className == 'contrato_class filtros')
    {
        if(tipo == 1){
            contrato = element.id;
            select = "<span id='contrato_class' onclick='result_filter(this,2);' class='contrato_class filtros' id='"+contrato+"'>"+element.innerHTML+"<i class='fa fa-times click'></i></span>";
            $('.contrato_class').html(select);
        }else{
            contrato = '';
            nodo = document.getElementById("contrato_class");
            resultado = busquedas.removeChild(nodo);
        }
    }

    var html = "";
    var puerto_host = $('#puerto_host').val();
    $.ajax({
        type: "GET",
        url: puerto_host+"?mostrar=oferta&opcion=filtrar&id_area="+interes+"&id_provincia="+provincia+"&id_jornada="+jornada+"&id_contrato="+contrato,
        dataType:'json',
        success:function(data){
            if (data.length != 0) {
                html = "<a href='"+puerto_host+"/verOferta/><div class='panel panel-default shadow-panel'><div class='panel-body'><div class='col-md-2' align='center'><img class='img-circle img-responsive' style='border: 3px solid #ccf2ff; margin: 0 auto;padding: 19px 0px 19px 0px;' src='"+puerto_host+"/imagenes/iconOferta.png' alt='icono oferta'></div><div class='col-md-10'></div></div></div></a>";
            }
            else{
                html = "<br><br><div class='panel panel-default'><div class='panel-body' align='center'><span>No se encontraron ofertas</span></div></div>";
            }
            $('#result').html(html);
        },
        error: function (request, status, error) {
          alert(request.responseText);
        }                  
    })
}


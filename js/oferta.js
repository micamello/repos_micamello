
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


/* filtrado por categorias */
var interes = "";
var provincia = "";
var jornada = "";
var contrato = "";
var filtros_total = 0;
var filtros_add = new Array(0,0,0,0);
var filtros_delete = 0;

function result_filter(element,tipo)
{ 
    var busquedas = nodo = '';
    busquedas = document.getElementById("busquedas");
console.log(element.className+' - '+tipo);
    if (element.className == 'interes' || element.className == 'interes_class filtros')
    {
        if(tipo == 1){
            interes = element.id;
            //filtros_add[0] = 1;
            //select = "<span id='interes_class' onclick='result_filter(this,2);' class='interes_class filtros' id='"+interes+"'>"+element.innerHTML+"<i class='fa fa-times click'></i></span>";
            //$('.interes_class').html(select);
            $('.interes_class').attr({
                'onclick': 'alert(this,2);',
                //'class':'filtros',
                'id':interes
            });

            $('.interes_class').html(element.innerHTML+" <i class='fa fa-times click'></i>");
            $('.interes_class').addClass('filtros');
        }else{
            interes = '';
            //filtros_delete++;
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
            //filtros_add[1] = 1;
            //select = "<span id='provincia_class' onclick='result_filter(this,2);' class='provincia_class filtros' id='"+provincia+"'>"+element.innerHTML+"<i class='fa fa-times click'></i></span>";
            //$('.provincia_class').html(select);
            $('.provincia_class').attr({
                'onclick': 'result_filter(this,2);',
                //'class':'filtros',
                'id':provincia
            });

            $('.provincia_class').html(element.innerHTML+" <i class='fa fa-times click'></i>");
            $('.provincia_class').addClass('filtros');
        }else{
            provincia = '';
            //filtros_delete++;
            nodo = document.getElementById("provincia_class");
            busquedas.removeChild(nodo);
            var elem = document.createElement('span');
            elem.id = "provincia_class";
            elem.classList.add('provincia_class');
            busquedas.appendChild(elem);
        }
    }

    if (element.className == 'jornada' || element.className == 'jornada_class filtros')
    {
        if(tipo == 1){
            jornada = element.id;
            //filtros_add[2] = 1;
            //select = "<span id='jornada_class' onclick='result_filter(this,2);' class='jornada_class filtros' id='"+jornada+"'>"+element.innerHTML+"<i class='fa fa-times click'></i></span>";
            //$('.jornada_class').html(select);
            $('.jornada_class').attr({
                'onclick': 'result_filter(this,2);',
                //'class':'filtros',
                'id':jornada
            });

            $('.jornada_class').html(element.innerHTML+" <i class='fa fa-times click'></i>");
            $('.jornada_class').addClass('filtros');
        }else{
            jornada = '';
            //filtros_delete++;
            nodo = document.getElementById("jornada_class");
            busquedas.removeChild(nodo);
            var elem = document.createElement('span');
            elem.id = "jornada_class";
            elem.classList.add('jornada_class');
            busquedas.appendChild(elem);
        }
    }
    
    if (element.className == 'contrato' || element.className == 'contrato_class filtros')
    {
        if(tipo == 1){
            contrato = element.id;
            //filtros_add[3] = 1;
            //select = "<span id='contrato_class' onclick='result_filter(this,2);' class='contrato_class filtros' id='"+contrato+"'>"+element.innerHTML+"<i class='fa fa-times click'></i></span>";
            //$('.contrato_class').html(select);
            $('.contrato_class').attr({
                'onclick': 'result_filter(this,2);',
                //'class':'filtros',
                'id':contrato
            });

            $('.contrato_class').html(element.innerHTML+"<i class='fa fa-times click'></i>");
            $('.contrato_class').addClass('filtros');
        }else{
            contrato = '';
           // filtros_delete++;
            nodo = document.getElementById("contrato_class");
            busquedas.removeChild(nodo);
            var elem = document.createElement('span');
            elem.id = "contrato_class";
            elem.classList.add('contrato_class');
            busquedas.appendChild(elem);
        }
    }

    /*filtros_total = filtros_add[0]+filtros_add[1]+filtros_add[2]+filtros_add[3];
    if(tipo == 1){
        $("#busquedas").css('margin-bottom', '25px');
    }else if(filtros_total == filtros_delete){
        $("#busquedas").css('margin-bottom', '0px');
    }*/
    /*var html = "";
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
    })*/
}


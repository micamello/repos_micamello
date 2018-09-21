$(window).on('load',function(){  
  $("#panel_1").show();
  $("#panel_2").hide();
  $("#panel_3").hide();
});

$("input[name=select_form]").click( function() {
	if ($("input:checked").val() == '2'){
		$("#panel_2").show();
		$("#panel_1").hide();
    $("#panel_3").hide();
	}
  else if($("input:checked").val() == '3'){
    $("#panel_2").hide();
    $("#panel_1").hide();
    $("#panel_3").show();
  }
	else{
    $("#panel_1").show();
		$("#panel_2").hide();
    $("#panel_3").hide();
	}
});

$('#provincia').change(function(){
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

$('#provinciaP').change(function(){
  var id_provincia = $('select[id=provinciaP]').val();
  var puerto_host = $('#puerto_host').val();

  if(id_provincia != ""){
    $.ajax({
      type: "GET",
      url: puerto_host+"?mostrar=perfil&opcion=buscaCiudad&id_provincia="+id_provincia,
      dataType:'json',
      success:function(data){
        $('#ciudadP').html('<option value="">Selecciona una ciudad</option>');
        $.each(data, function(index, value) {
            $('#ciudadP').append("<option value='"+value.id_ciudad+"'>"+value.ciudad+"</option>");
        });
      },
      error: function (request, status, error) {
        alert(request.responseText);
      }                  
    })
  }
});

$('#btn_submitpaypal').click(function(){	
	var valor = $('#idplanP').val()+'|'+$('#usuarioP').val()+'|'+$('#nombreP').val()+'|'+$('#correoP').val()+'|'+$('#ciudadP').val()+'|'+$('#telefonoP').val()+'|'+$('#dniP').val();
	$('#custom').attr('value',valor);
});
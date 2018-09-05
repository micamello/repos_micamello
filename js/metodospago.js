$(window).on('load',function(){
  $("#panel_P *").attr("disabled",true);
  $("#panel_D *").attr("disabled",false);
});

$("input[name=select_form]").click( function() {
	if ($("input:checked").val() == 'P'){
		$("#panel_P *").attr("disabled",false);
		$("#panel_D *").attr("disabled",true);
	}
	else{
    $("#panel_D *").attr("disabled",false);
		$("#panel_P *").attr("disabled",true);
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
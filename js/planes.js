function buttongrat(){		
	var desc = ($('#gratnombre').length) ? $('#gratnombre').attr('value') : $('#gratcmb option:selected').text();  
	$('#desplan').html(desc);
  $('#btncomprar').attr('href',$('#puerto_host').val()+'/compraplan/'+$('#gratcmb').val()+'/');
	//$('#msg_confirmplan').modal();
  window.location.href = $('#puerto_host').val()+'/compraplan/'+$('#gratcmb').val()+'/';
}

function buttonplan(){
  var desc = ($('#plannombre').length) ? $('#plannombre').attr('value') : $('#plancmb option:selected').text();  
  $('#btncomprar').attr('href',$('#puerto_host').val()+'/compraplan/'+$('#plancmb').val()+'/');
	$('#desplan').html(desc);
	$('#msg_confirmplan').modal();
}

function buttonaviso(){	
	var desc = ($('#avisonombre').length) ? $('#avisonombre').attr('value') : $('#avisocmb option:selected').text();  
  $('#btncomprar').attr('href',$('#puerto_host').val()+'/compraplan/'+$('#avisocmb').val()+'/');
	$('#desplan').html(desc);
	$('#msg_confirmplan').modal();
}

function msg_compra(id,desc){		  
	$('#desplan').html(desc);
  $('#btncomprar').attr('href',$('#puerto_host').val()+'/compraplan/'+id+'/');
	$('#msg_confirmplan').modal();
}

function loadgratuito(idplan){	
  var estilotitulo = ($('#gratprom_'+idplan).attr('value') == 1) ? 'headingrojo' : 'headingazul';
  var estiloul = ($('#gratprom_'+idplan).attr('value') == 1) ? 'border:2px solid #a21414;' : 'border:1px solid #262D5D;';
  var duracion = ($('#gratprom_'+idplan).attr('value') == 1) ? 'Promoci&oacute;n<br>' : '';
  duracion = duracion + (($('#gratdura_'+idplan).attr('value') != 0) ? 'Duraci&oacute;n del plan<br>' + $('#gratdura_'+idplan).attr('value') + ' d&iacute;as' : 'ilimitado');  
  var srcimagen = $('#puerto_host').val()+'/imagenes/planes/'+$('#gratid_'+idplan).attr('value')+'.'+$('#gratext_'+idplan).attr('value');
  var costo = $('#simbolo').val()+$('#gratcosto_'+idplan).attr('value');
  var permisos = $('#gratpermiso_'+idplan).attr('value').split('||');
  var strperm = '';
  if (permisos.length > 1){
	  for (var i = 0; i < permisos.length; i++) {
	  	if (permisos[i] != ''){
	      strperm = strperm + '<li class="text-justify">• '+permisos[i]+'</li> ';
	    }
	  }
  }
  $('#grattitulo').html($('#grattitulo_'+idplan).attr('value'));
  $('#grattitulo').attr('class','title '+estilotitulo);
  $('#gratul').attr('style',estiloul);
  $('#gratimg').attr('src',srcimagen);
  $('#gratdura').html(duracion);
  $('#gratcosto').html(costo);
  $('#gratpermisos').html(strperm);
}

function loadplanes(idplan){	
  var estilotitulo = ($('#planprom_'+idplan).attr('value') == 1) ? 'headingrojo' : 'headingazul';
  var estiloul = ($('#planprom_'+idplan).attr('value') == 1) ? 'border:2px solid #a21414;' : 'border:1px solid #262D5D;';
  var duracion = ($('#planprom_'+idplan).attr('value') == 1) ? 'Promoci&oacute;n<br>' : '';
  duracion = duracion + (($('#plandura_'+idplan).attr('value') != 0) ? 'Duraci&oacute;n del plan<br>' + $('#plandura_'+idplan).attr('value') + ' d&iacute;as' : 'ilimitado');  
  var srcimagen = $('#puerto_host').val()+'/imagenes/planes/'+$('#planid_'+idplan).attr('value')+'.'+$('#planext_'+idplan).attr('value');
  var costo = $('#simbolo').val()+$('#plancosto_'+idplan).attr('value');
  var permisos = $('#planpermiso_'+idplan).attr('value').split('||');
  var strperm = '';
  if (permisos.length > 1){
	  for (var i = 0; i < permisos.length; i++) {
	  	if (permisos[i] != ''){
	      strperm = strperm + '<li class="text-justify">• '+permisos[i]+'</li> ';
	    }
	  }
  }
  $('#plantitulo').html($('#plantitulo_'+idplan).attr('value'));
  $('#plantitulo').attr('class','title '+estilotitulo);
  $('#planul').attr('style',estiloul);
  $('#planimg').attr('src',srcimagen);
  $('#plandura').html(duracion);
  $('#plancosto').html(costo);
  $('#planpermisos').html(strperm);
}

function loadavisos(idplan){	
  var estilotitulo = ($('#avisoprom_'+idplan).attr('value') == 1) ? 'headingrojo' : 'headingazul';
  var estiloul = ($('#avisoprom_'+idplan).attr('value') == 1) ? 'border:2px solid #a21414;' : 'border:1px solid #262D5D;';
  var duracion = ($('#avisoprom_'+idplan).attr('value') == 1) ? 'Promoci&oacute;n<br>' : '';
  duracion = duracion + (($('#avisodura_'+idplan).attr('value') != 0) ? 'Duraci&oacute;n del plan<br>' + $('#avisodura_'+idplan).attr('value') + ' d&iacute;as' : 'ilimitado');  
  var srcimagen = $('#puerto_host').val()+'/imagenes/planes/'+$('#avisoid_'+idplan).attr('value')+'.'+$('#avisoext_'+idplan).attr('value');
  var costo = $('#simbolo').val()+$('#avisocosto_'+idplan).attr('value');
  var permisos = $('#avisopermiso_'+idplan).attr('value').split('||');
  var strperm = '';
  if (permisos.length > 1){
	  for (var i = 0; i < permisos.length; i++) {
	  	if (permisos[i] != ''){
	      strperm = strperm + '<li class="text-justify">• '+permisos[i]+'</li> ';
	    }
	  }
  }
  $('#avisotitulo').html($('#avisotitulo_'+idplan).attr('value'));
  $('#avisotitulo').attr('class','title '+estilotitulo);
  $('#avisoul').attr('style',estiloul);
  $('#avisoimg').attr('src',srcimagen);
  $('#avisodura').html(duracion);
  $('#avisocosto').html(costo);
  $('#avisopermisos').html(strperm);
}

$(function() {  	
	if ($('#gratcmb').length){
    loadgratuito($('#gratcmb').val());		
  }
  if ($('#plancmb').length){
    loadplanes($('#plancmb').val());
  }
  if ($('#avisocmb').length){
    loadavisos($('#avisocmb').val());
  }

  $('#gratcmb').change(function(){  	
    loadgratuito($(this).val());  	  	
  });
  $('#plancmb').change(function(){  	
    loadplanes($(this).val());  	  	
  });
  $('#avisocmb').change(function(){  	
    loadavisos($(this).val());  	  	
  });

});
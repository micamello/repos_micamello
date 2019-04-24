if($('.reveal').length){
	var revelar = $('.reveal');
	var hostPie = $('#puerto_host').val();
	revelar.on('mouseenter', function(){
		var bottonRevelar = "<a href='"+hostPie+"/planes/' target='_blank' class='botonRevelar'>Mostrar datos</a>";
		$(this).prepend(bottonRevelar);
	});

	revelar.on('mouseleave', function(){
		$(this).find('a').remove();
	});
}


var defaults;
var objeto;
var settings
$.fn.multiple_select = function(options){
	// console.log(options);
	defaults = {
        items : false,
        dependence: {
        	id_dependencia: false,
        	items: false
        }
    }
    settings = $.extend({}, defaults, options);
	objeto = $(this);
	var objeto_id = objeto[0].id;
	var listado_opciones = "";
	var selected_item = "";
	var input_id = "input_" + objeto_id; 

	objeto.css('display', 'none');
	var padre_objeto = objeto.prev();
	var opciones = objeto[0].options;

	var opcion_texto;
	var opcion_value;
	var id_panel = "panel" + objeto_id;
	var area_selected = "";
	var count1 = 0;
	var count2 = 0;
	if(opciones.length != 0){
		for (var i = 0; i < opciones.length; i++) {
			area_selected = "";
			listado = "";
			opcion_texto = "";
			opcion_value = "";
			opcion_texto = $(opciones[i]).text();
			opcion_value = $(opciones[i]).val();
			if($(opciones[i]).attr('selected')){
				area_selected = "area_with_subarea";
			}

			
			listado_opciones += "<li class='select_list "+area_selected+"' id='area_"+$(opciones[i]).val()+"'>"+opcion_texto+" (<label>0</label>/<label class='all_area'>0</label>)</li>";
			// <input style='float: right;' type='checkbox'>
		}
	}
	else{
		listado_opciones = "";
		listado_opciones = "No hay ninguna opción";
	}

	var panel = "<div id='"+id_panel+"' class='panel panel-default panel_mic'><div class='panel-heading'><div class='inner-addon right-addon'><input class='form-control' placeholder='Buscar...' id='"+input_id+"'></div></div><div class='panel-body panelb_mic'><ul class='list_content_mic'>"+listado_opciones+"</ul></div></div>";
	padre_objeto.after(panel);

	// inicializar si tiene dependencia
	if(settings.dependence.id_dependencia != false){
		inicializarDependencia(settings.dependence.id_dependencia);
		buscarDependencia(settings.dependence.id_dependencia);
		contadorAreasSubareas(1);
		ifallselectedStart();
		desmarcarTodascheckarea();
		startDefaultLoad();
	}

	function ifallselectedStart(){
		var listado = $('#'+id_panel).find('li');
		for (var i = 0; i < listado.length; i++) {
			var labels = $(listado[i]).find('label');
			if($(labels[0]).text() == $(labels[1]).text()){
				$('#all_select_'+settings.dependence.id_dependencia+"_"+$(listado[i]).attr('id').split('_')[1]).addClass('subarea_selected');
				$('#all_select_'+settings.dependence.id_dependencia+"_"+$(listado[i]).attr('id').split('_')[1]).find('input[type="checkbox"]').prop('checked', true);
			}

		}
		// $('#panel'+settings.dependence.id_dependencia).find('li');
	}

	function startDefaultLoad(){
		var find_load = $('#'+id_panel).find('li.area_with_subarea');
		var find_load_sub = "";
		// console.log(find_load.length);	
		if(find_load.length > 0){
			// console.log(find_load[0]);
			console.log('panel'+settings.dependence.id_dependencia);
			find_load_sub = $('#panel'+settings.dependence.id_dependencia).find('li[id^="'+find_load.attr('id').split('_')[1]+'_"].subarea_disabled:not(.seleccion_e)');
			find_load_sub.each(function(){
				$(this).removeClass('subarea_disabled');
			})
			$('#all_select_'+settings.dependence.id_dependencia+"_"+find_load.attr('id').split('_')[1]).removeClass('subarea_disabled');
		}
	}



	

// evento click en listados de opciones

$('#'+id_panel).find('li').on('click', function(){
	var li = $(this);
	if(!li.hasClass('active_li')){
		if(minMaxSelect(li,settings.dependence.id_dependencia) == false){
			return minMaxSelect(li, settings.dependence.id_dependencia);
		}
		if(selected_item != ""){
			if(selected_item.hasClass('active_li')){
				selected_item.removeClass('active_li');
			}
		}
		li.addClass('active_li');
		selected_item = li;
		mostrarSubareas(selected_item, settings.dependence.id_dependencia);
	}
	else{
		selected_item = "";
		li.removeClass('active_li');
		mostrarSubareas(selected_item, settings.dependence.id_dependencia);
	}
	controlCheck(settings.dependence.id_dependencia);
});

$('#'+input_id).on('keyup', function(){
	var thisobject = this;
	if(!$(thisobject).prev().length){
		if($(thisobject).val() != ""){
			$(thisobject).before("<i class='fa fa-times erase_content' onclick='botonfafaTimes("+input_id+");'></i>");
		}	
	}
	if($(this).prev().length){
		if($(this).val() == ""){
			$(this).prev().remove();
		}
	}	
	busquedaListado(this);
});

}

function busquedaListado(obj){
	var listado = $(obj).parents(':eq(1)').next().find('li');
	var texto = $(obj).val().toLowerCase();
	for (var i = 0; i < listado.length; i++) {
		if(!$(listado[i]).hasClass('subarea_disabled')){
			if($(listado[i]).text().toLowerCase().indexOf(texto) > -1){
				$(listado[i])[0].style.display = "";
			}
			else{
				$(listado[i])[0].style.display = "none";
			}
		}
	}
}

function botonfafaTimes(obj){
	if($(obj).val() != ""){
		$(obj).val('');
		$(obj).prev()[0].outerHTML = "";
	}
	busquedaListado($(obj));
}

function inicializarDependencia(obj){
	// console.log(obj);
	if($('#'+obj).length){
		var objeto = $('#'+obj);
		var objeto_id = objeto[0].id;
		var listado_opciones = "";
		var selected_item = "";
		var input_id = "input_" + objeto_id; 

		objeto.css('display', 'none');
		var padre_objeto = objeto.prev();
		var opciones = objeto[0].options;

		var opcion_texto;
		var opcion_value;
		var id_panel = "panel" + objeto_id;
		var opciones = objeto[0].options;
		var e = 0;
		var selected_class = "";
		var check_check = "";

		if(opciones.length != 0){
			for (var i = 0; i < opciones.length; i++) {
				listado = "";
				opcion_texto = "";
				opcion_value = "";
				opcion_texto = $(opciones[i]).text();
				opcion_value = $(opciones[i]).val();
				var area_val = $(opciones[i]).val().split("_")[0];
				selected_class = "";
				check_check = "";
				if($(opciones[i]).attr('selected')){
					selected_class = "subarea_selected"; check_check = "checked";
				}
				if(e != area_val){
					listado_opciones += "<li class='select_list_subarea subarea_disabled seleccion_e' id='all_select_"+obj+"_"+area_val+"'>Marcar o desmarcar todos<input type='checkbox'></li>";
					e = area_val;
				}
				listado_opciones += "<li class='select_list_subarea subarea_disabled "+selected_class+"' id='"+$(opciones[i]).val()+"'>"+opcion_texto+"<input type='checkbox' "+check_check+"></li>";
			}
		}
		var panel = "<a href='#' class='button_selected'onclick='rise_modal_selected("+obj+");'><i class='fa fa-plus'></i></a><div id='"+id_panel+"' class='panel panel-default panel_mic'><div class='panel-heading'><div class='inner-addon right-addon'><input class='form-control' placeholder='Buscar...' id='"+input_id+"'></div></div><div class='panel-body panelb_mic'><ul class='list_content_mic'>"+listado_opciones+"</ul></div></div>";
		padre_objeto.after(panel);


	}
}

function mostrarSubareas(selected_item, subarea){
	var li_subareas = $('#panel'+subarea).find('li');
	if(selected_item != ""){
		var area = $(selected_item)[0].id.split("_")[1];
		var id_subarea;
		for (var i = 0; i < li_subareas.length; i++) {
			id_area_subarea = $(li_subareas[i])[0].id.split("_")[0];
			if(id_area_subarea == area){
				$(li_subareas[i]).removeClass("subarea_disabled");
			}
			else{
				$(li_subareas[i]).addClass("subarea_disabled");
			}
		}
		$('#all_select_'+subarea+"_"+area).removeClass("subarea_disabled");
	}
	else{
		for (var i = 0; i < li_subareas.length; i++){
			$(li_subareas[i]).addClass("subarea_disabled");
			$('#all_select_'+subarea+"_"+area).addClass("subarea_disabled");
		}
	}
}


function buscarDependencia(obj){
	$('#input_'+obj).on('keyup', function(){
		var thisobject = this;
		if(!$(thisobject).prev().length){
			if($(thisobject).val() != ""){
				$(thisobject).before("<i class='fa fa-times erase_content' onclick='botonfafaTimes(input_"+obj+");'></i>");
			}	
		}
		if($(this).prev().length){
			if($(this).val() == ""){
				$(this).prev().remove();
			}
		}
		$('#all_select_'+obj).removeClass("subarea_disabled");
		busquedaListado(this);
	})
}

function controlCheck(obj){
	oncheckChange(obj);
}

function oncheckChange(obj){
	var subarea_tag = $('#'+obj);
	// para checkbox
	var id_list;
	var area;
	var opcion_area;
	var listado_check = $('.select_list_subarea:not(.subarea_disabled)').find('input[type=checkbox]');
	listado_check.unbind('change').change();
	if(listado_check.length){
		listado_check.on('change', function(){
			
			// console.log(eder);
			// event.preventDefault();
			// return false;
			// event.preventDefault();
			if($(this).parent().attr('id').split("_")[0] == "all"){
				if($(this).is(':checked')){
					// var count = 0;
					for (var i = 0; i < listado_check.length; i++) {
						if(!$(listado_check[i]).parent().hasClass('subarea_selected')){
							if(!$(listado_check[i]).parent().hasClass('seleccion_e')){
								// count++;
								opcion_area = "";
								id_list = "";
								id_list = $(listado_check[i]).parent().attr('id');
								opcion_area = objeto.find('option[value="'+id_list.split("_")[0]+'"]');
								subarea_tag.find('option[value="'+id_list+'"]').attr('selected', 'selected');
								if(!opcion_area.attr('selected')){ 
									// verificar esto------------------------------------------
									opcion_area.attr('selected', 'selected');
									$('#panel'+objeto.attr('id')).find('li#area_'+opcion_area.attr('value')).addClass('area_with_subarea');
									// $('#panel'+objeto.attr('id')).find('li#area_'+opcion_area.attr('value')).children('i').remove();
									// $('#panel'+objeto.attr('id')).find('li#area_'+opcion_area.attr('value')).append("<i style='float: right;'>"+count+"</i>");
								}
							}
							$(listado_check[i]).parent().addClass('subarea_selected');
							$(listado_check[i]).prop('checked', true);
						}
					}
					if(!$(this).hasClass('subarea_selected')){
						$(this).addClass('subarea_selected');
					}
				}
				else{
					for (var i = 0; i < listado_check.length; i++) {
						// if($(listado_check[i]).parent().hasClass('subarea_selected')){
							if(!$(listado_check[i]).parent().hasClass('seleccion_e')){
								opcion_area = "";
								id_list = "";
								id_list = $(listado_check[i]).parent().attr('id');
								opcion_area = objeto.find('option[value="'+id_list.split("_")[0]+'"]');
								subarea_tag.find('option[value="'+id_list+'"]').removeAttr('selected');
								
								if(opcion_area.attr('selected')){
									opcion_area.removeAttr('selected');
									$('#panel'+objeto.attr('id')).find('li#area_'+opcion_area.attr('value')).removeClass('area_with_subarea');
									// $('#panel'+objeto.attr('id')).find('li#area_'+opcion_area.attr('value')).children('i').remove();
									// console.log($('#panel'+objeto.attr('id')).find('li:not(.subarea_disabled)').attr('id', 'area_'+opcion_area.attr('value'));
								}
							}
							$(listado_check[i]).parent().removeClass('subarea_selected');
							$(listado_check[i]).prop('checked', false);
						// }
					}
				}
			}
			else{
				area = $(this).parent().attr('id').split("_")[0];
				if($(this).is(':checked')){
					var id_opcion = 0;
					if(!$(this).parent().hasClass('subarea_selected')){
						id_opcion = $(this).parent().attr('id');
						var subarea_count = 0;
						$('#'+obj).find('option[value="'+id_opcion+'"]').attr('selected', 'selected');
						$(this).parent().addClass('subarea_selected');
						subarea_count = $('.select_list_subarea.subarea_selected:not(.subarea_disabled, .seleccion_e)');
						if(subarea_count.length >=1){
							$('#panel'+objeto.attr('id')).find('li#area_'+area).addClass('area_with_subarea');
							objeto.find('option[value="'+area+'"]').attr('selected', 'selected');
						}
						else{
							$('#panel'+objeto.attr('id')).find('li#area_'+area).removeClass('area_with_subarea');
							objeto.find('option[value="'+area+'"]').removeAttr('selected');
						}
					}
				}
				else{
					if($(this).parent().hasClass('subarea_selected')){
						id_opcion = $(this).parent().attr('id');
						var subarea_count = 0;
						$('#'+obj).find('option[value="'+id_opcion+'"]').removeAttr('selected');
						$(this).parent().removeClass('subarea_selected');
						subarea_count = $('.select_list_subarea.subarea_selected:not(.subarea_disabled, .seleccion_e)');
						if(subarea_count.length >=1){
							$('#panel'+objeto.attr('id')).find('li#area_'+area).addClass('area_with_subarea');
							objeto.find('option[value="'+area+'"]').attr('selected', 'selected');
						}
						else{
							$('#panel'+objeto.attr('id')).find('li#area_'+area).removeClass('area_with_subarea');
							objeto.find('option[value="'+area+'"]').removeAttr('selected');
						}
					}
				}
				if($('.select_list_subarea:not(.subarea_disabled, li:first)').find('input[type=checkbox]:checked').length== $('.select_list_subarea:not(.subarea_disabled, li:first)').length){
					// console.log($('#all_select_'+obj+"_"+area));
					$('#all_select_'+obj+"_"+area).addClass('subarea_selected');
					$('#all_select_'+obj+"_"+area).find('input[type=checkbox]').prop('checked', true);
				}
				else{
					$('#all_select_'+obj+"_"+area).removeClass('subarea_selected');
					$('#all_select_'+obj+"_"+area).find('input[type=checkbox]').prop('checked', false);
				}
			}
			contadorAreasSubareas(2);
			desmarcarTodascheckarea();
		})
	}


	var listado_li = $('.select_list_subarea:not(.subarea_disabled)');
	listado_li.unbind('click').click();
	if(listado_li.length){
		listado_li.on('click', function(){
			
			// console.log(eder);
			// event.preventDefault();
			// return false;
			// event.preventDefault();
			var subarea_count = 0;
			if($(this).attr('id').split("_")[0] == "all"){
				if(!$(this).hasClass('subarea_selected')){
					if(!$(this).find('input[type="checkbox"]').is(':checked')){
						for (var i = 0; i < listado_li.length; i++) {
							if(!$(listado_li[i]).hasClass('subarea_selected')){

								if(!$(listado_li[i]).hasClass('seleccion_e')){
									// count++;
									opcion_area = "";
									id_list = "";
									id_list = $(listado_li[i]).attr('id');
									opcion_area = objeto.find('option[value="'+id_list.split("_")[0]+'"]');
									subarea_tag.find('option[value="'+id_list+'"]').attr('selected', 'selected');
									if(!opcion_area.attr('selected')){ 
										// verificar esto------------------------------------------
										opcion_area.attr('selected', 'selected');
										$('#panel'+objeto.attr('id')).find('li#area_'+opcion_area.attr('value')).addClass('area_with_subarea');
										// $('#panel'+objeto.attr('id')).find('li#area_'+opcion_area.attr('value')).children('i').remove();
										// $('#panel'+objeto.attr('id')).find('li#area_'+opcion_area.attr('value')).append("<i style='float: right;'>"+count+"</i>");
									}
								}

								$(listado_li[i]).addClass('subarea_selected');
								$(listado_li[i]).find('input[type="checkbox"]').prop('checked', true);



							}
						}
					}
				}
				else{
					for (var i = 0; i < listado_li.length; i++) {
						// if($(listado_li[i]).hasClass('subarea_selected')){
							if(!$(listado_li[i]).hasClass('seleccion_e')){
								opcion_area = "";
								id_list = "";
								id_list = $(listado_li[i]).attr('id');
								opcion_area = objeto.find('option[value="'+id_list.split("_")[0]+'"]');
								subarea_tag.find('option[value="'+id_list+'"]').removeAttr('selected');
								
								if(opcion_area.attr('selected')){
									opcion_area.removeAttr('selected');
									$('#panel'+objeto.attr('id')).find('li#area_'+opcion_area.attr('value')).removeClass('area_with_subarea');
									// $('#panel'+objeto.attr('id')).find('li#area_'+opcion_area.attr('value')).children('i').remove();
									// console.log($('#panel'+objeto.attr('id')).find('li:not(.subarea_disabled)').attr('id', 'area_'+opcion_area.attr('value'));
								}
							}

							$(listado_li[i]).removeClass('subarea_selected');
							$(listado_li[i]).find('input[type="checkbox"]').prop('checked', false);
						// }
					}
				}
			}
			else{
				area = $(this).attr('id').split("_")[0];
				// console.log(listado_li.length);
				var id_opcion = 0;
				if(!$(this).hasClass('subarea_selected')){
					// if(!$(this).hasClass('subarea_selected')){

						// if(!$(this).parent().hasClass('subarea_selected')){
							id_opcion = $(this).attr('id');
							
							$('#'+obj).find('option[value="'+id_opcion+'"]').attr('selected', 'selected');
							$(this).addClass('subarea_selected');
							subarea_count = $('.select_list_subarea.subarea_selected:not(.subarea_disabled,.seleccion_e)');
							if(subarea_count.length >=1){
								$('#panel'+objeto.attr('id')).find('li#area_'+area).addClass('area_with_subarea');
								objeto.find('option[value="'+area+'"]').attr('selected', 'selected');
							}
							else{
								$('#panel'+objeto.attr('id')).find('li#area_'+area).removeClass('area_with_subarea');
								objeto.find('option[value="'+area+'"]').removeAttr('selected');
							}
						// }
						$(this).addClass('subarea_selected');
						$(this).find('input[type="checkbox"]').prop('checked', true);
					// }
				}
				else{
					// if($(this).hasClass('subarea_selected')){
						id_opcion = $(this).attr('id');
						
						$('#'+obj).find('option[value="'+id_opcion+'"]').removeAttr('selected');
						$(this).removeClass('subarea_selected');
						subarea_count = $('.select_list_subarea.subarea_selected:not(.subarea_disabled,.seleccion_e)');
						if(subarea_count.length >=1){
							$('#panel'+objeto.attr('id')).find('li#area_'+area).addClass('area_with_subarea');
							objeto.find('option[value="'+area+'"]').attr('selected', 'selected');
						}
						else{
							$('#panel'+objeto.attr('id')).find('li#area_'+area).removeClass('area_with_subarea');
							objeto.find('option[value="'+area+'"]').removeAttr('selected');
						}
						$(this).removeClass('subarea_selected');
						$(this).find('input[type="checkbox"]').prop('checked', false);
					// }
				}
				
				if($('.select_list_subarea:not(.subarea_disabled, li:first)').find('input[type=checkbox]:checked').length == $('.select_list_subarea:not(.subarea_disabled, li:first)').length){
					// console.log($('#all_select_'+obj+"_"+area));
					$('#all_select_'+obj+"_"+area).addClass('subarea_selected');
					$('#all_select_'+obj+"_"+area).find('input[type=checkbox]').prop('checked', true);
				}
				else{
					$('#all_select_'+obj+"_"+area).removeClass('subarea_selected');
					$('#all_select_'+obj+"_"+area).find('input[type=checkbox]').prop('checked', false);
				}
			}
			contadorAreasSubareas(2);
			desmarcarTodascheckarea();
		})
	}
}

function rise_modal_selected(obj){
	var obj_id = $(obj).attr('id');
	// console.log("eder");
	var modal = $('#modal_select');
	modal.modal('show');
	var panel_subarea = $('#panel'+obj_id);
	var panel_area = objeto.attr('id');
	var opciones_seleccionadas = panel_subarea.find('li.subarea_selected:not(".seleccion_e")');
	var panel_body = modal.find('.modal-body');
	panel_body[0].innerHTML = "";
	var seleccionados_listado  = "";
	var texto = "";
	var id = "";
	var id_area = 0;
	var texto_area = "-----";
	var primer_elemento = ($(opciones_seleccionadas).first());
	for (var i = 0; i < opciones_seleccionadas.length; i++) {
		id = "";
		texto = "";
		id = $(opciones_seleccionadas[i]).attr('id');
		texto = $(opciones_seleccionadas[i]).text();
		if(id.split("_")[0] != id_area){
			if($(opciones_seleccionadas[i]).attr('id') != primer_elemento.attr('id')){	
			}
			id_area = id.split("_")[0];
			texto_area = $('#area_'+id_area).text();
			seleccionados_listado += '<div><label>'+texto_area+'</label><br>';
		}
		seleccionados_listado += "<p class='modal_selected_list'>"+texto+"<i class='fa fa-times' id='selected_"+id+"' onclick='delete_list(this);'></i></p>";
	}
	panel_body.append(seleccionados_listado);
}

function delete_list(obj){
	var label = "";
	var all_prev = $(obj).parent().siblings('p');
	var label = $(obj).parent().siblings('label');
	$(obj).parent()[0].outerHTML = "";
	if(all_prev.length == 0){
		label[0].outerHTML = "";
	}
	var subareas = $('#panel'+settings.dependence.id_dependencia).find('li.subarea_selected:not(".seleccion_e")');
	var id_li = $(obj).attr('id').split("_");
	for (var i = 0; i < subareas.length; i++) {
		console.log($(subareas[i]).attr('id'));
		if($(subareas[i]).attr('id') == id_li[1]+"_"+id_li[2]+"_"+id_li[3]){
			$(subareas[i]).removeClass('subarea_selected');
			$(subareas[i]).find('input[type="checkbox"]').prop('checked', false);
		}
	}
}

function minMaxSelect(obj, dependencia){
	var contador = objeto.find('option[selected]').length;
	var listados_panel;
	var array_li = [];
	listados_panel = $('#panel'+settings.dependence.id_dependencia).find('li');
	var listado_areas_seleccionadas = $('#panel'+objeto.attr('id')).find('li.area_with_subarea');
	var id_area_seleccionada;
	var id_subarea_seleccionada;
	// console.log(contador + "____" + settings.items);
	if(contador >= settings.items){
		for (var i = 0; i < listado_areas_seleccionadas.length; i++) {
			id_area_seleccionada = $(listado_areas_seleccionadas[i]).attr('id').split("_")[1];
			// console.log(id_area_seleccionada);
			for (var j = 0; j < listados_panel.length; j++) {
				$(listados_panel).addClass('subarea_disabled_1');
				id_subarea_seleccionada =	$(listados_panel[j]).attr('id').split("_")[0];
				if(id_area_seleccionada == id_subarea_seleccionada || ($(listados_panel[j]).attr('id') == "all_select_"+dependencia+"_"+id_area_seleccionada)){
					
					array_li.push($(listados_panel[j])[0]);	
				}
			}
		}
	}
	else{
		for (var j = 0; j < listados_panel.length; j++) {
			$(listados_panel).removeClass('subarea_disabled_1');
		}
	}
	for (var i = 0; i < array_li.length; i++) {
		$(array_li[i]).removeClass('subarea_disabled_1');
	}
}

function contadorAreasSubareas(tipo){
	var count_1 = 0;
	var count_2 = 0;
	var area = 0;
	var li_panel_area = $('#panel'+$(objeto).attr('id')).find('li');
	if(tipo == 1){
		var listado_sub_selec = $('#panel'+settings.dependence.id_dependencia).find('li.subarea_selected:not(.seleccion_e)');
		for (var i = 0; i < li_panel_area.length; i++) {
			area = $(li_panel_area[i]).attr('id').split("_")[1];
			count_1 = $('#panel'+settings.dependence.id_dependencia).find('li[id^="'+area+'_"]:not(.seleccion_e)').length;
			count_2 = $('#panel'+settings.dependence.id_dependencia).find('li[id^="'+area+'_"].subarea_selected:not(.seleccion_e)').length;
			$(li_panel_area[i]).find('label.all_area').text(count_1);
			$(li_panel_area[i]).find('label:not(.all_area)').text(count_2);
			$(li_panel_area[i]).attr('title', count_2+' subareas seleccionadas de '+count_1);
			// if(count_2>= 1){
			// 	$(li_panel_area[i]).append('<input checked style="float: right;"" type="checkbox">');
			// }else{
			// 	$(li_panel_area[i]).find('input').remove();
			// }
		}
	}
	if(tipo == 2){
		var listado_sub_selec = $('#panel'+settings.dependence.id_dependencia).find('li.subarea_selected:not(.seleccion_e)');
		for (var i = 0; i < li_panel_area.length; i++) {
			area = $(li_panel_area[i]).attr('id').split("_")[1];
			count_1 = $('#panel'+settings.dependence.id_dependencia).find('li[id^="'+area+'_"]:not(.seleccion_e)').length;
			count_2 = $('#panel'+settings.dependence.id_dependencia).find('li[id^="'+area+'_"].subarea_selected:not(.seleccion_e)').length;
			$(li_panel_area[i]).find('label:not(.all_area)').text(count_2);
			$(li_panel_area[i]).attr('title', count_2+' subareas seleccionadas de '+count_1);
			// if(count_2 >= 1){
			// 	$(li_panel_area[i]).find('input').remove();
			// 	$(li_panel_area[i]).append('<input checked style="float: right;"" type="checkbox">');
			// }else{
			// 	$(li_panel_area[i]).find('input').remove();
			// }
		}
	}
}


function desmarcarTodascheckarea(){
		var des_all = $('#panel'+$(objeto).attr('id')).find('li').find('input[type="checkbox"]');
		var area_des = 0;
		var list_sub = "";
		var all_select_sub = "";
		var list_options = [];
		$(des_all).on('change', function(){

			area = $(this).parent().attr('id').split('_')[1];
			list_sub = $('#panel'+settings.dependence.id_dependencia).find('li[id^="'+area+'_"].subarea_selected:not(.seleccion_e)');
			// console.log(list_sub);
			list_options = $('#'+settings.dependence.id_dependencia).prop('options');
			// console.log(list_options);
			for (var i = 0; i < list_options.length; i++) {
				// console.log($(list_options[i]));
				if($(list_options[i]).attr('value').split('_')[0] == area){
					// console.log($(list_options[i]));
					$(list_options[i]).removeAttr('selected');
				}
			}
			if(!$(this).is(':checked')){
				// console.log('eder 1');
				for (var i = 0; i < list_sub.length; i++) {
					// console.log($(list_sub[i]).attr('id'));

					$(list_sub[i]).removeClass('subarea_selected');
					$(list_sub[i]).find('input[type="checkbox"]').prop('checked', false);
				}
				all_select_sub = $('#panel'+settings.dependence.id_dependencia).find('li#all_select_'+settings.dependence.id_dependencia+"_"+area);
				all_select_sub.removeClass('subarea_selected');
				all_select_sub.find('input[type="checkbox"]').prop('checked', false);
				$(this).parent().removeClass('area_with_subarea');
				$('#'+objeto.attr('id')).children(':selected').attr('value', area).removeAttr('selected');
				
				$(this)[0].outerHTML = "";
				
				// console.log($(this)[0]);
				// console.log(this);
			}
			if(minMaxSelect($(this).parent(),settings.dependence.id_dependencia) == false){
				return minMaxSelect($(this).parent(), settings.dependence.id_dependencia);
			}
		})
	}
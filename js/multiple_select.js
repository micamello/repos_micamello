var defaults;
var objeto;
var settings
$.fn.multiple_select = function(options){

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
            
        }
    }
    else{
        listado_opciones = "";
        listado_opciones = "No hay ninguna opción";
    }
    
    var panel = "<div id='"+id_panel+"' class='panel panel-default panel_mic'><div class='panel-heading'><div class='inner-addon right-addon' style='position:inherit'><input class='form-control' placeholder='Buscar...' id='"+input_id+"'></div></div><div class='panel-body panelb_mic'><ul class='list_content_mic'>"+listado_opciones+"</ul></div></div>";
    
    padre_objeto.after(panel);
    // var numero = $('#'+id_panel).siblings('label')[0];
    // numero.textContent+= " (máx: "+settings.items+")";
    // console.log(this.siblings('label').text());
    if(this.siblings('label').text().indexOf('numero') >= 0){
        this.siblings('label').text(this.siblings('label').text().replace('numero', settings.items));
    }

    // inicializar si tiene dependencia
    if(settings.dependence.id_dependencia != false){
        inicializarDependencia(settings.dependence.id_dependencia);
        buscarDependencia(settings.dependence.id_dependencia);
        contadorAreasSubareas(1);
        ifallselectedStart();
        desmarcarTodascheckarea();
        startDefaultLoad();
        loadButtonSelected(settings.dependence.id_dependencia);
        controlCheck(settings.dependence.id_dependencia);
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
    }

    function startDefaultLoad(){
        var find_load = $('#'+id_panel).find('li.area_with_subarea');
        var find_load_sub = "";
        if(find_load.length > 0){
            find_load_sub = $('#panel'+settings.dependence.id_dependencia).find('li[id^="'+find_load.attr('id').split('_')[1]+'_"].subarea_disabled:not(.seleccion_e)');
            find_load_sub.each(function(){
                $(this).removeClass('subarea_disabled');
            })
            $('#all_select_'+settings.dependence.id_dependencia+"_"+find_load.attr('id').split('_')[1]).removeClass('subarea_disabled');
        }
        else{
            $('#panel'+settings.dependence.id_dependencia).find('.panel-body').append("<label>Seleccione un área</label>");
        }
    }



    

// evento click en listados de opciones

$('#'+id_panel).find('li').on('click', function(){
    if($('#panel'+settings.dependence.id_dependencia).find('label').length){
        $('#panel'+settings.dependence.id_dependencia).find('label')[0].outerHTML = "";
    }
    var li = $(this);
    // if(!li.hasClass('active_li')){
        // if(minMaxSelect(li,settings.dependence.id_dependencia) == false){
        //     return minMaxSelect(li, settings.dependence.id_dependencia);
        // }
        if(selected_item != ""){
            if(selected_item.hasClass('active_li')){
                selected_item.removeClass('active_li');
            }
        }
        li.addClass('active_li');
        selected_item = li;
        mostrarSubareas(selected_item, settings.dependence.id_dependencia);
    // }
    controlCheck(settings.dependence.id_dependencia);
    maximoSubareas($(this).attr('id').split('_')[1]);
    minMaxSelect(li, settings.dependence.id_dependencia);
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

function loadButtonSelected(obj){
    var panel_dep = $('#panel'+settings.dependence.id_dependencia);
    var panel_depLi = panel_dep.find('li.subarea_selected');
    var botonSeleccionados = $("<a href='#' id='boton_"+settings.dependence.id_dependencia+"' class='button_selected'onclick='rise_modal_selected("+obj+");'></a>");
    if(panel_depLi.length > 0){
        if(panel_dep.prev('.button_selected').length){
            $(panel_dep).prev('.button_selected').remove();
        }
        panel_dep.before(botonSeleccionados);
        ondeleteCount();
    }
    else{
        if(panel_dep.prev('.button_selected').length){
            $(panel_dep).prev('.button_selected').remove();
        }
    }
}

function clickOnDeleteModalOption(){

}

function inicializarDependencia(obj){
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
                    if(settings.dependence.items == false){
                    listado_opciones += "<li class='select_list_subarea subarea_disabled seleccion_e' id='all_select_"+obj+"_"+area_val+"'>Marcar o desmarcar todos<input type='checkbox'></li>";  
                    }
                    
                    e = area_val;
                }
                listado_opciones += "<li class='select_list_subarea subarea_disabled "+selected_class+"' id='"+$(opciones[i]).val()+"'>"+opcion_texto+"<input type='checkbox' "+check_check+"></li>";
            }
        }
        // subpanelNumber = "";
        // if(settings.dependence.items != false){
            // var subpanelNumber = ' (máx: '+settings.dependence.items+')';
        // }
        var panel = "<div id='"+id_panel+"' class='panel panel-default panel_mic'><div class='panel-heading'><div class='inner-addon right-addon' style='position:inherit'><input class='form-control' placeholder='Buscar...' id='"+input_id+"'></div></div><div class='panel-body panelb_mic'><ul class='list_content_mic'>"+listado_opciones+"</ul></div></div>";
        padre_objeto.after(panel);
        // var numero = $('#'+id_panel).siblings('label')[0];
        // numero.textContent+= subpanelNumber;
        loadButtonSelected(obj);
        ondeleteCount();
        var modalSelectedSpace = $('#'+id_panel).parent(':eq(0)').parent().next();
        var modalCode = '<div class="modal fade" id="modal_select" role="dialog"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header">Áreas seleccionadas<button type="button" class="close" data-dismiss="modal">&times;</button></div><div class="modal-body" style="overflow: scroll"></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div> </div></div></div>';
        modalSelectedSpace.append(modalCode);

        if($('#'+id_panel).siblings('label').text().indexOf('numero') >= 0){
            $('#'+id_panel).siblings('label').text($('#'+id_panel).siblings('label').text().replace('numero', settings.dependence.items));
        }
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
        if(settings.dependence.items == false){
            $('#all_select_'+subarea+"_"+area).removeClass("subarea_disabled");
        }
        
    }
    else{
        for (var i = 0; i < li_subareas.length; i++){
            $(li_subareas[i]).addClass("subarea_disabled");
            if(settings.dependence.items == false){
                $('#all_select_'+subarea+"_"+area).addClass("subarea_disabled");
            }
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

            if($(this).parent().attr('id').split("_")[0] == "all"){
                if($(this).is(':checked')){
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
                            if(!$(listado_check[i]).parent().hasClass('seleccion_e')){
                                opcion_area = "";
                                id_list = "";
                                id_list = $(listado_check[i]).parent().attr('id');
                                opcion_area = objeto.find('option[value="'+id_list.split("_")[0]+'"]');
                                subarea_tag.find('option[value="'+id_list+'"]').removeAttr('selected');
                                
                                if(opcion_area.attr('selected')){
                                    opcion_area.removeAttr('selected');
                                    $('#panel'+objeto.attr('id')).find('li#area_'+opcion_area.attr('value')).removeClass('area_with_subarea');
                                }
                            }
                            $(listado_check[i]).parent().removeClass('subarea_selected');
                            $(listado_check[i]).prop('checked', false);
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
                    $('#all_select_'+obj+"_"+area).addClass('subarea_selected');
                    $('#all_select_'+obj+"_"+area).find('input[type=checkbox]').prop('checked', true);
                }
                else{
                    $('#all_select_'+obj+"_"+area).removeClass('subarea_selected');
                    $('#all_select_'+obj+"_"+area).find('input[type=checkbox]').prop('checked', false);
                }
            }
            $('#'+settings.dependence.id_dependencia).trigger('change');
            contadorAreasSubareas(2);
            desmarcarTodascheckarea();
            loadButtonSelected(obj);
            ondeleteCount();
        })
    }


    var listado_li = $('.select_list_subarea:not(.subarea_disabled)');
    listado_li.unbind('click').click();
    if(listado_li.length){
        listado_li.on('click', function(){
            // maximoSubareas(this);
            // console.log();
            
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
                            if(!$(listado_li[i]).hasClass('seleccion_e')){
                                opcion_area = "";
                                id_list = "";
                                id_list = $(listado_li[i]).attr('id');
                                opcion_area = objeto.find('option[value="'+id_list.split("_")[0]+'"]');
                                subarea_tag.find('option[value="'+id_list+'"]').removeAttr('selected');
                                
                                if(opcion_area.attr('selected')){
                                    opcion_area.removeAttr('selected');
                                    $('#panel'+objeto.attr('id')).find('li#area_'+opcion_area.attr('value')).removeClass('area_with_subarea');
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
            $('#'+settings.dependence.id_dependencia).trigger('change');
            contadorAreasSubareas(2);
            desmarcarTodascheckarea();
            loadButtonSelected(obj);
            maximoSubareas($(this).attr('id').split('_')[0]);
            ondeleteCount();
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
            texto_area = $('#area_'+id_area).text().match(/(.*)[(]/)[1];
            seleccionados_listado += '<div class="clearfix"></div><div><label>'+texto_area+'</label><br>';
        }
        seleccionados_listado += "<p class='modal_selected_list col-md-4 col-md-offset-1'><span>"+texto+"</span><i class='fa fa-times' id='selected_"+id+"' onclick='delete_list(this);'></i></p>";
    }
    panel_body.append(seleccionados_listado);
}

function delete_list(obj){
    var label = $(obj).parent().siblings('label');
    var all_selected_list;
    $(obj).parent()[0].outerHTML = "";
    var array_seleccionados = [];
    var id_dep = settings.dependence.id_dependencia;
    var contador_sel = 0;
    var id_array = $(obj).attr('id').split("_");
    var id_selected = id_array[1]+"_"+id_array[2]+"_"+id_array[3];
    var area_item = id_array[1];
    var list_select = $('#panel'+id_dep).find('li[id="'+id_selected+'"]');
    var des_all = $('#panel'+id_dep).find('li#all_select_'+id_dep+"_"+area_item);
    var select_area;
    $('#'+id_dep).find('option[value="'+id_selected+'"]').removeAttr('selected');
    list_select.removeClass('subarea_selected');
    list_select.find('input[type="checkbox"]').prop('checked', false);

    $('#'+id_dep).find('option[value="'+area_item+'"]').removeAttr('selected');
    if(des_all.hasClass('subarea_selected')){
        des_all.removeClass('subarea_selected');
        des_all.find('input[type="checkbox"]').prop('checked', false);
    }
    contador_sel = $('#panel'+id_dep).find('li[id^="'+area_item+'_"].subarea_selected:not(.seleccion_e)');
    // console.log(contador_sel.length);
    if(contador_sel.length == 0){
        select_area = $('#panel'+$(objeto).attr('id')).find('li#area_'+area_item);
        select_area.removeClass('area_with_subarea');
        select_area.find('input[type="checkbox"]').prop('checked', false);
        objeto.find('option[value="'+area_item+'"]').removeAttr('selected');
        label[0].outerHTML = "";
    }
    all_selected_list = $('#panel'+id_dep).find('li.subarea_selected');
    if(all_selected_list.length == 0){
        $('#modal_select').modal('hide');
        loadButtonSelected(id_dep);
    }
    contadorAreasSubareas(2);
    habilitandoOnclickModalDelete(obj);
    maximoSubareas(id_array[1]);
    ondeleteCount();
}

function habilitandoOnclickModalDelete(obj){
    // var listados_delete = $('#panel'+objeto.attr('id')).find('li.active_li');
    // console.log(listados_delete.length);
    // if(listados_delete.length != 0){
    //     console.log(obj);
    // }
    // console.log($(obj).attr('id').split("_")[1]);
    var area_delete = $(obj).attr('id').split("_")[1];
    var areaSeleccionadas = $('#panel'+objeto.attr('id')).find('li.area_with_subarea');
    var areaActiveList = "";
    var selectorRestantes = $('#modal_select').find('i[id^="selected_'+area_delete+'"]');
    
    // $('#modal_select').find('i[id^="selected_"'+area_delete+']');
    console.log("area seleccionadas: "+ areaSeleccionadas.length);
    console.log("Restantes: "+selectorRestantes.length);
    if(areaSeleccionadas.length >= 1){
        console.log('eder1');
        if(selectorRestantes.length == 0){
            console.log('eder');
            console.log(areaSeleccionadas[0]);
            areaActiveList = $('#panel'+objeto.attr('id')).find('li.active_li');
            if(areaActiveList.length != 0){
                for (var i = 0; i < areaActiveList.length; i++) {
                    if(i == 0){
                        $(areaActiveList[i]).addClass('active_li');
                    }
                    else{
                        $(areaActiveList[i]).removeClass('active_li');
                    }
                }
                $(areaActiveList[0]).removeClass('active_li');
                $(areaSeleccionadas[0]).addClass('active_li');
                // console.log($(areaSeleccionadas[0]).attr('id'));
                mostrarSubareas($(areaSeleccionadas[0]), settings.dependence.id_dependencia);
            }
        }
    }
    else{
        areaActiveList = $('#panel'+objeto.attr('id')).find('li.active_li');
        for (var i = 0; i < areaActiveList.length; i++) {
            $(areaActiveList[i]).removeClass('active_li');
        }
        var subareas_li = $('#panel'+settings.dependence.id_dependencia).find('li');
        subareas_li.each(function(){
            $(this).addClass('subarea_disabled');
        })
        $('#panel'+settings.dependence.id_dependencia).find('.panel-body').append("<label>Seleccione un área</label>");
    }
}

function minMaxSelect(obj, dependencia){
    // if(settings.dependence.items != false){
        
            var numberArea = objeto.find('option[selected]').length;
            var areaSel;
            var panelDep = $('#panel'+dependencia);
            var listadoDep;
            if(!$(obj).hasClass('area_with_subarea')){
                areaSel = $(obj).attr('id').split('_')[1];
                listadoDep = panelDep.find('li[id^="'+areaSel+'_"].select_list_subarea:not(.subarea_selected)');
                if(numberArea >= settings.items){
                    console.log(obj);
                    for (var i = 0; i < listadoDep.length; i++) {
                        $(listadoDep[i]).addClass('subarea_disabled_1');
                    }
                    $('#panel'+dependencia).find('li#all_select_'+dependencia+'_'+areaSel).addClass('subarea_disabled_1');
                }
                else{
                    for (var i = 0; i < listadoDep.length; i++) {
                        $(listadoDep[i]).removeClass('subarea_disabled_1');
                    }
                    $('#panel'+dependencia).find('li#all_select_'+dependencia+'_'+areaSel).removeClass('subarea_disabled_1');
                }
            }
    // }
}

function contadorAreasSubareas(tipo){
    // console.log(tipo);
    var count_1 = 0;
    var count_2 = 0;
    var area = 0;
    var li_panel_area = $('#panel'+$(objeto).attr('id')).find('li');
    var listado_sub_selec = "";
    if(tipo == 1){
        listado_sub_selec = $('#panel'+settings.dependence.id_dependencia).find('li.subarea_selected:not(.seleccion_e)');
        for (var i = 0; i < li_panel_area.length; i++) {
            area = $(li_panel_area[i]).attr('id').split("_")[1];
            count_1 = $('#panel'+settings.dependence.id_dependencia).find('li[id^="'+area+'_"]:not(.seleccion_e)').length;
            count_2 = $('#panel'+settings.dependence.id_dependencia).find('li[id^="'+area+'_"].subarea_selected:not(.seleccion_e)').length;
            $(li_panel_area[i]).find('label.all_area').text(count_1);
            $(li_panel_area[i]).find('label:not(.all_area)').text(count_2);
            $(li_panel_area[i]).attr('title', count_2+' subareas seleccionadas de '+count_1);
            if(count_2>= 1){
                $(li_panel_area[i]).find('input').remove();
                $(li_panel_area[i]).append('<input checked style="float: right;"" type="checkbox">');
            }else{
                $(li_panel_area[i]).find('input').remove();
            }
        }
    }
    if(tipo == 2){
        listado_sub_selec = $('#panel'+settings.dependence.id_dependencia).find('li.subarea_selected:not(.seleccion_e)');
        for (var i = 0; i < li_panel_area.length; i++) {
            area = $(li_panel_area[i]).attr('id').split("_")[1];
            count_1 = $('#panel'+settings.dependence.id_dependencia).find('li[id^="'+area+'_"]:not(.seleccion_e)').length;
            count_2 = $('#panel'+settings.dependence.id_dependencia).find('li[id^="'+area+'_"].subarea_selected:not(.seleccion_e)').length;
            $(li_panel_area[i]).find('label:not(.all_area)').text(count_2);
            $(li_panel_area[i]).attr('title', count_2+' subareas seleccionadas de '+count_1);
            if(count_2 >= 1){
                $(li_panel_area[i]).find('input').remove();
                $(li_panel_area[i]).append('<input checked style="float: right;" type="checkbox">');
            }else{
                $(li_panel_area[i]).find('input').remove();
            }
        }
    }
}

function maximoSubareas(id){
    if(settings.dependence.items != false){
        var subareasLim = settings.dependence.items;
        var panelSub = $('#panel'+settings.dependence.id_dependencia);
        var count = panelSub.find('li[id^="'+id+'_"].subarea_selected').length;
        var count1 = panelSub.find('li[id^="'+id+'_"]:not(.subarea_selected)');
        if(count >= subareasLim){
            count1.each(function(){
                $(this).addClass('subarea_disabled_1');
            })
        $('#panel'+settings.dependence.id_dependencia).find('li#all_select_'+settings.dependence.id_dependencia+"_"+id).addClass('subarea_disabled_1');
        }
        else{
            count1.each(function(){
                $(this).removeClass('subarea_disabled_1');
            })
            $('#panel'+settings.dependence.id_dependencia).find('li#all_select_'+settings.dependence.id_dependencia+"_"+id).removeClass('subarea_disabled_1');
        }
    }
}   


function desmarcarTodascheckarea(){
    var obj_id = $(objeto).attr('id');
    var checkbox_all = $('#panel'+obj_id).find('input[type="checkbox"]');
    var area;
    var id_subarea = $('#'+settings.dependence.id_dependencia);
    var listado_seleccionados;
    var this_id;
    var value_title = [];
    checkbox_all.on('change', function(){
        area = $(this).parent().attr('id').split("_")[1];
        listado_seleccionados = $('#panel'+settings.dependence.id_dependencia).find('li[id^="'+area+'_"].subarea_selected:not(.seleccion_e)');
        if(!$(this).is(':checked')){
            for (var i = 0; i < listado_seleccionados.length; i++) {
                $(listado_seleccionados[i]).removeClass('subarea_selected');
                $(listado_seleccionados[i]).find('input[type="checkbox"]').prop('checked', false);
                objeto.find('option[value="'+area+'"]').removeAttr('selected');
                // console.log();
                this_id = $(listado_seleccionados[i]).attr('id');
                id_subarea.find('option[value="'+this_id+'"]').removeAttr('selected');
            }
        $(this).parent().removeClass('area_with_subarea');
        value_title[0] = 0;
        value_title[1] = $(this).parent().find('label.all_area').text();
        $(this).parent().find('label:not(.all_area)').text(value_title[0]);
        $(this).parent().attr('title', value_title[0]+' subareas seleccionadas de '+value_title[1]);
        objeto.find('option[value="'+area+'"]').removeAttr('selected');
        $('#panel'+id_subarea.attr('id')).find('li#all_select_'+id_subarea.attr('id')+'_'+area).removeClass('subarea_selected');
        $('#panel'+id_subarea.attr('id')).find('li#all_select_'+id_subarea.attr('id')+'_'+area).find('input[type="checkbox"]').prop('checked', false);
        }
        $(this)[0].outerHTML = "";
        loadButtonSelected(settings.dependence.id_dependencia);
        var listadoDisabled = $('#panel'+settings.dependence.id_dependencia).find('li[id^="'+area+'_"].subarea_disabled_1');
        for (var i = 0; i < listadoDisabled.length; i++) {
            $(listadoDisabled[i]).removeClass('subarea_disabled_1');
        }
    })

}

function ondeleteCount(){
    // bounceCss
    var objetoBoton = $('#boton_'+settings.dependence.id_dependencia);
    var countListado = $('#panel'+settings.dependence.id_dependencia).find('li.subarea_selected:not(.seleccion_e)');
    objetoBoton.removeClass('bounceCss');
    objetoBoton.addClass('bounceCss');
    objetoBoton.html("<i class='fa fa-plus'></i><span class='countList'>"+countListado.length+"</span>");
}

$('#modal_select').on('hidden.bs.modal', function(){
    desmarcarTodascheckarea();
})
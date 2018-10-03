if(document.getElementById("fecha_contratacion")){
    var date = new Date();
    console.log(date.setDate(date.getDate()+30));
    document.getElementById("fecha_contratacion").valueAsDate = date;
}

if (document.getElementById("fecha_contratacion")) {    
    $fecha_actual = fechaActual();
    $("#fecha_contratacion").on("change", function(){
        var valor = document.getElementById("fecha_contratacion");
        if ((!!this.value)) {
            if ($fecha_actual>this.value) {
                if (document.getElementById("p_node_error")) {
                    document.getElementById("p_node_error").outerHTML = "";
                }
                    var p_node = document.createElement("P");
                    var p_text = document.createTextNode("La fecha debe ser igual o mayor a la actual");
                    p_node.appendChild(p_text);
                    p_node.setAttribute("class", "list-unstyled msg_error");
                    p_node.setAttribute("id", "p_node_error");
                    var fecha_error = document.getElementById("fecha_error");
                    fecha_error.appendChild(p_node);
            }
            else{
                if (document.getElementById("p_node_error")) {
                    document.getElementById("p_node_error").outerHTML = "";
                }
            }
        }
        else{
            if (document.getElementById("p_node_error")) {
                document.getElementById("p_node_error").outerHTML = "";
            }
        }
    })
}

function fechaActual() {
    var d = new Date(),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}

$('#provincia_of').change(function()
{
    var id_provincia = $('select[id=provincia_of]').val();
    var puerto_host = $('#puerto_host').val();

    if(id_provincia != ""){
        $.ajax({
            type: "GET",
            url: puerto_host+"?mostrar=publicar&opcion=buscaCiudad&id_provincia="+id_provincia,
            dataType:'json',
            success:function(data){
                $('#ciudad_of').html('<option value="">Selecciona una ciudad</option>');
                $.each(data, function(index, value) {
                    $('#ciudad_of').append("<option value='"+value.id_ciudad+"'>"+value.ciudad+"</option>");

                });
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }                  
        })
    }
});

if(document.getElementById('des_of')){
  tinymce.init({ 
    selector:'textarea#des_of',
    style_formats: [
        {title: 'Headers', items: [
            {title: 'Header 1', format: 'h1'},
            {title: 'Header 2', format: 'h2'},
            {title: 'Header 3', format: 'h3'},
            {title: 'Header 4', format: 'h4'},
            {title: 'Header 5', format: 'h5'},
            {title: 'Header 6', format: 'h6'}
        ]},
        {title: 'Inline', items: [
            {title: 'Bold', icon: 'bold', format: 'bold'},
            {title: 'Italic', icon: 'italic', format: 'italic'},
            {title: 'Underline', icon: 'underline', format: 'underline'},
            {title: 'Strikethrough', icon: 'strikethrough', format: 'strikethrough'},
            {title: 'Superscript', icon: 'superscript', format: 'superscript'},
            {title: 'Subscript', icon: 'subscript', format: 'subscript'}
        ]},
        {title: 'Blocks', items: [
            {title: 'Paragraph', format: 'p'},
            {title: 'Blockquote', format: 'blockquote'}
        ]},
        {title: 'Alignment', items: [
            {title: 'Left', icon: 'alignleft', format: 'alignleft'},
            {title: 'Center', icon: 'aligncenter', format: 'aligncenter'},
            {title: 'Right', icon: 'alignright', format: 'alignright'},
            {title: 'Justify', icon: 'alignjustify', format: 'alignjustify'}
        ]}
    ],
    removed_menuitems: 'undo, redo',
    height : "128",
    resize: false,
    branding: false,
    elementpath: false,
    menubar:false,
    statusbar: false,
    language: 'es',
    setup: function (editor) {
        var publicar_btn = document.getElementById("publicar_btn");
        var errors = document.getElementsByClassName("form-group has-error has-danger");
        editor.on('keyup', function () {
            tinymce.triggerSave();
            if (tinyMCE.get('des_of').getContent() != "") {
                eliminarMensajeError("descripcion_error");
                document.getElementById("des_of_error").setAttribute("class", "form-group");
                if (errors.length <= 1 && ($(':input').filter('[required]:visible').val() != "") && ($('select').filter('[required]:visible').val() != "")) {
                  publicar_btn.setAttribute("class", "btn btn-success");
                }
                else{
                    console.log("Deshabilita el boton");
                    publicar_btn.setAttribute("class", "btn btn-success disabled");
                }
            }
            else{
                publicar_btn.setAttribute("class", "btn btn-success disabled");
            }
        });
    }
})
}

$('#btn_transfer').on('click', function()
{
    var select_array_idioma = document.getElementById('select_array_idioma');
    var options = "";
    var tag_idioma = document.getElementById('idioma_of');
    var tag_nivel_idioma = document.getElementById('nivel_idi_of');
    var idioma_selected_select = tag_idioma.options[tag_idioma.selectedIndex];
    var idiomanivel_selected_select = tag_nivel_idioma.options[tag_nivel_idioma.selectedIndex];

    if(idioma_selected_select.text != 'Seleccione una opción' && idiomanivel_selected_select.text != 'Seleccione una opción'){
        
        var selected_items = document.getElementsByClassName('listado');

        var all_selected = $('#idioma_of option:disabled');
        var error_show = document.getElementById('id_span_error');
        var op = '';

        if(tag_idioma.options[0].value == 0){
            op = tag_idioma.length-1;
        }else{
            op = tag_idioma.length;
        }

        if (all_selected.length == op) {
            if (error_show) {
                error_show.outerHTML = "";
            }
                var error_all_selected = document.getElementById('error_msg');
                var error_span = document.createElement('SPAN');
                error_span.setAttribute("id", "id_span_error");
                error_span.setAttribute("class", "error_text");
                var error_msg_text = document.createTextNode('Ha seleccionado todas las opciones disponibles');
                error_span.appendChild(error_msg_text);
                error_all_selected.appendChild(error_span);
        }
        
        if (idioma_selected_select.disabled == false)
        {
            if (document.getElementById("text_nothing")) {
                document.getElementById("text_nothing").innerHTML = "";
                document.getElementById("text_nothing").style.display = "none";
            }
            var id_idioma = tag_idioma.value;
            var id_nivel_idioma = tag_nivel_idioma.value;
            var div_idioma = document.getElementById('list_idioma');
            var text_idioma = idioma_selected_select.text;
            var text_idioma_nivel = idiomanivel_selected_select.text;
            var p_node = document.createElement('P');
            div_idioma.appendChild(p_node);
            p_node.setAttribute("id", "idioma"+id_idioma);
            p_node.innerHTML = text_idioma+" ("+text_idioma_nivel+") <i class='fa fa-window-close fa-2x icon' id='"+id_idioma+"' onclick='delete_item_selected(this);'></i>";
            p_node.setAttribute("disabled", "disabled");
            p_node.setAttribute("class", "col-md-5 badge_item listado");
            idioma_selected_select.setAttribute("disabled", "disabled");
            var nodo_option = document.createElement('option');
            nodo_option.setAttribute("value", id_idioma+"_"+id_nivel_idioma);
            nodo_option.setAttribute("id", "array_idioma"+id_idioma);
            nodo_option.selected = "selected";
            select_array_idioma.appendChild(nodo_option);

            tag_idioma.removeAttribute("required");
            tag_nivel_idioma.removeAttribute("required"); 

            var listado = document.getElementById("listado_idiomas");
            listado.innerHTML = "";
            var publicar_btn = document.getElementById("boton");
            var errors = document.getElementsByClassName("form-group has-error has-danger");

            if (errors.length <= 1 && ($(':input').filter('[required]:visible').val() != "") && ($('select').filter('[required]:visible').val() != "")) {
                publicar_btn.setAttribute("class", "btn btn-success");
            }  
        }

        var all_selected = $('#idioma_of option:disabled');
        if (all_selected.length == op) {
            tag_nivel_idioma.setAttribute("disabled", true);
            tag_idioma.setAttribute("disabled", true);
        }
    }
})

function delete_item_selected(selected_item){
    var error_show = document.getElementById('id_span_error');
        if (error_show) {
            error_show.outerHTML = "";
        }

    var tag_idioma = document.getElementById('idioma_of');
    var tag_nivel_idioma = document.getElementById('nivel_idi_of');
    var tag_idioma_seleccionado = document.getElementById("idioma"+selected_item.id);
    tag_idioma_seleccionado.outerHTML = "";
    $("#idioma_of option[value="+selected_item.id+"]").attr("disabled",false);
    var idioma_selected_select = document.getElementById('idioma_of');
    var array_idioma_select = document.getElementById('select_array_idioma').length;
    if (array_idioma_select >= 1) {
            $("#select_array_idioma option[id='array_idioma"+selected_item.id+"']").remove();
            tag_nivel_idioma.removeAttribute("disabled");
            tag_idioma.removeAttribute("disabled");
    }
    var publicar_btn = document.getElementById("publicar_btn");
        var errors = document.getElementsByClassName("form-group has-error has-danger");
    if (document.getElementById('select_array_idioma').length <= 0)
    {
        tag_idioma.setAttribute("required", true);
        tag_nivel_idioma.setAttribute("required", true);
        document.getElementById("text_nothing").innerHTML = "Ningun idioma seleccionado.....";
        document.getElementById("text_nothing").style.display = "";
        // document.getElementById("listado_idiomas").innerHTML = "<p id='error_tag' class='list-unstyled msg_error'></p>";
        // document.getElementById("error_tag").innerHTML = "<p>Seleccione un elemento de la lista.</p>";
        if (document.getElementById("id_idi_error")){
          document.getElementById("id_idi_error").setAttribute("class", "form-group has-error has-danger");
        }
        if (document.getElementById("publicar_btn")){
          publicar_btn.setAttribute("class", "btn btn-success disabled");
        }
    }
    else{
        if (document.getElementById("id_idi_error")){
        // document.getElementById("listado_idiomas").innerHTML = "";
          document.getElementById("id_idi_error").setAttribute("class", "form-group");
        }
    }	
}

function valida_numeros(evt){
    if(window.event){
      keynum = evt.keyCode; 
     }
     else{
      keynum = evt.which; 
     } 
     if((keynum > 47 && keynum < 58) || keynum == 8 
    || keynum == 9 || keynum == 13 || keynum == 116 
    || (keynum > 36 && keynum < 41) 
    || (keynum > 95 && keynum < 106)){
      return true;
     }
     else{
      return false;
     }
}
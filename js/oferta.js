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
            var publicar_btn = document.getElementById("boton");
            var errors = document.getElementsByClassName("form-group has-error has-danger");
            editor.on('keyup', function () {
                tinymce.triggerSave();
                if (tinyMCE.get('des_of').getContent() != "") {
                    //eliminarMensajeError("descripcion_error");
                    quitarError('descripcion_error','des_of_error');
                    document.getElementById("des_of_error").setAttribute("class", "form-group");
                    if (errors.length <= 0 && ($(':input').filter('[required]:visible').val() != "")) {                    
                        publicar_btn.setAttribute("class", "btn btn-success");
                    }
                    else{
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

function abrirModalEditar(id,contenido,idOferta){
    
    document.getElementById('idOferta').value = idOferta;    
    tinymce.get('des_of').setContent(decodeURIComponent((contenido+'').replace(/\+/g, '%20')));
    $('#'+id).modal();
}

function enviarEdicion(){

    var estado = validarDescripcion();
    console.log(estado);
    if(estado == 1){
        var action = document.getElementById('form_editar_Of').action;
        action += document.getElementById('idOferta').value+'/1/';
        document.getElementById('form_editar_Of').action = action;
        document.form_editar_Of.submit();
    }
}

function colocaError(campo, id, mensaje,btn){

    nodo = document.getElementById(campo);
    nodo.innerHTML = '';
    var elem1 = document.createElement('P');
    var t = document.createTextNode(mensaje); 
    elem1.appendChild(t);

    var elem2 = document.createElement("P");             
    elem2.classList.add('list-unstyled');
    elem2.classList.add('msg_error');
    elem2.appendChild(elem1); 

    elem2.appendChild(elem1); 
    nodo.appendChild(elem2); 

    $("#"+id).addClass('has-error');

    $("#"+btn).attr({
        'disabled': 'disabled',
    });
 
    $("#"+btn).addClass('disabled');
    $("#"+btn).attr('disabled', 'disabled');

    if(document.getElementById('form_paypal')){
      document.getElementById('form_paypal').action = '#';
    }

}

function validarDescripcion(){

    var error = 0;

    /*var des_of = document.getElementById('des_of').value;
    console.log(des_of);*/

    if(tinyMCE.get('des_of').getContent() == ""){

        colocaError("descripcion_error", "des_of_error","El campo no puede ser vacío","boton");
        error = 1; 

    }else{
        quitarError("descripcion_error", "des_of_error");
    }

    if(error == 1){
        return 0;
    }else{
        $("#boton").removeAttr('disabled');
        return 1;
    }
}

function enviarPclave(ruta,page){

	var pclave = $('#inputGroup').val();

	if(pclave != ''){
		var nueva_ruta = ruta+"Q"+pclave.toLowerCase()+"/"+page+"/";
	}else{
		var nueva_ruta = ruta+page+"/";
	}
	window.location = nueva_ruta;
}

function obtenerFiltro(ruta,page){

	var pclave = $('#inputGroup1').val();
	var categoria = $('#categoria').val();
	var provincia = $('#provincia').val();
	var jornada = $('#jornada').val();

	if(pclave != ''){
		ruta += "Q"+pclave.toLowerCase()+"/";
	}
	if(categoria != 0){
		ruta += "A"+categoria+"/";
	}
	if(provincia != 0){
		ruta += "P"+provincia+"/";
	}
	if(jornada != 0){
		ruta += "J"+jornada+"/";
	}

	var nueva_ruta = ruta+page+"/";
	window.location = nueva_ruta;
}

if(document.getElementById('form_postulacion')){
	$("#form_postulacion").validator();
}

function verAspirantes($idOfertas){

	var nueva_ruta = $('#puerto_host').val()+'/verAspirantes/'+$idOfertas;
	alert(nueva_ruta);
	//window.location = nueva_ruta;
}
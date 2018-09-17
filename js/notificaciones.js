if($("#msg_notificacion").length > 0){
    if(document.getElementById('msg_notificacion').value == 1){
        $('#notificaciones').modal('show');
    }
}


function crea_notificacion(titulo,opciones,url) {

    if (Notification) {
        if (Notification.permission !== "granted") {
            Notification.requestPermission();
        }
        
        var noti = new Notification( titulo, opciones);
        noti.onclick = function(event) {

            event.preventDefault(); 
            window.open(url, '_blank');
        }
        noti.onclose = {
        // Al cerrar
        }
        setTimeout( function() { noti.close() }, 10000);
    }
}

function permiso(titulo,opciones,url) {

    if(Notification) {
        if (Notification.permission == "granted") {
            crea_notificacion(titulo,opciones,url);
        }

        else if(Notification.permission == "default") {
            alert("Primero tiene que dar los permisos de notificación");
            Notification.requestPermission();
        }
        else {
            alert("Bloqueaste los permisos de notificación, elimina este sitio de la seccion de bloqueos en las notificaciones y seguridad de tu navegador y podrás recibir nuestro contenido.");
        }
    }
}

var image = '/imagenes/notificaciones.png';
if(navegador() == 'Firefox'){
    image = '/imagenes/notificaciones2.png';
}
            
var titulo = "Mi camello";
var opciones = {
    icon: $('#puerto_host').val()+image,
    body: "Notificación de prueba",
};
var url = 'http://www.google.com';

/*permiso(titulo,opciones,url);*/

function navegador(){
    var agente = window.navigator.userAgent;
    var navegadores = ["Chrome", "Firefox", "Safari", "Opera", "Trident", "MSIE", "Edge"];
    for(var i in navegadores){
        if(agente.indexOf( navegadores[i]) != -1 ){
            return navegadores[i];
        }
    }
}

function desactivarNotificacion(id,url){

    var enlace = $('#puerto_host').val()+"?mostrar=notificacion&id_notificacion="+id;

    $.ajax({
        type: "GET",
        url: enlace,
        dataType:'json',
        success:function(data){
            window.location=$('#puerto_host').val()+'/'+url+'/';
        },
        error: function (request, status, error) {
            alert('Error intente de nuevo');
        }                  
    });
}

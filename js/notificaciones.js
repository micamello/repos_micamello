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

/*function permiso(titulo,opciones,url) {
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
}*/

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

function desactivarNotificacion(id){
  var enlace = $('#puerto_host').val()+"/index.php?mostrar=notificacion&id_notificacion="+id;
  $.ajax({
    type: "GET",
    url: enlace,
    dataType:'json',
    success:function(data){      
      $("#notificaciones").modal('hide');        
    },
    error: function (request, status, error) {
      swal('Advertencia!', 'Error  por favor intente denuevo', 'error');
      //alert('Error intente de nuevo');
    }                  
  });
}

function cancelarAcceso(id){
  $("#notificaciones").modal('hide');
  var enlace = $('#puerto_host').val()+"/index.php?mostrar=acceso&opcion=devolucion&id="+id;  
  $.ajax({
    type: "GET",
    url: enlace,
    dataType:'json',
    success:function(data){             
      if (data.respuesta == "OK"){        
        swal('Exitoso!', data.mensaje, 'success');
      }     
      else{
        swal('Advertencia!', data.mensaje, 'error');
        //alert('Error, por favor intente de nuevo');
      }
    },
    error: function (request, status, error) {
      swal('Advertencia!', 'Error en la cancelación del acceso, por favor intente denuevo', 'error');
      //alert('Error intente de nuevo');      
    }                  
  });
}

function aceptarAcceso(id){
  $("#notificaciones").modal('hide'); 
  var enlace = $('#puerto_host').val()+"/index.php?mostrar=acceso&opcion=aceptar&id="+id;
  $.ajax({
    type: "GET",
    url: enlace,
    dataType:'json',
    success:function(data){   
      $(location).attr('href',$('#puerto_host').val()+'/preguntas/');      
    },
    error: function (request, status, error) {
      swal('Advertencia!', 'Error  por favor intente denuevo', 'error');
      //alert('Error intente de nuevo');
    }                  
  });
}
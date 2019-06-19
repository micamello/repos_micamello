function verificarCompraPlan(){
  var puerto_host = $('#puerto_host').val();
  $.ajax({
      type: "GET",
      url: puerto_host+"/index.php?opcion=verificarCompra",
      dataType:'json',
        async: false,
      success:function(data){
        if(data.dato == 1){
          $('.spin').find('h4').text('Su compra fue procesada con éxito');
          $('.spin').find('img').attr('src', puerto_host+'/imagenes/success.png');
          $('.spin').delay('2000').fadeOut( "slow", function(){
            window.location.href = puerto_host+"/"+$('#redireccionar').val()+"/";
          });
        }
      },
      error: function (request, status, error) {
          console.log(request.responseText);
      }
    });
}

$(document).ready(function(){
    setInterval(verificarCompraPlan, 1000);
});
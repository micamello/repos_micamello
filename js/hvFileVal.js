if($('#cargarHV').length){
  $('#cargarHV').on('click', function(){
    $('#userHV').click();
  });
}

if($('#userHV').length){
  $('#userHV').on('change', function(){
    var cargaHV = $(this).val();
    var imagen = "";
    var texto = "";
    var filehVExt = cargaHV.split('.').pop();
    console.log(filehVExt);
    if(cargaHV != null && cargaHV != ""){
      if(filehVExt != 'pdf' && filehVExt != 'docx'){
        imagen = "wrong-04.png";
        texto = "El campo solo permite archivos con formato .docx, .pdf";
      }
      else{
        console.log($(this)[0].files[0].size);
        if($(this)[0].files[0].size > 2000000){
          imagen = "wrong-04.png";
          texto = "El archivo cargado excede el tamaño permitido.";  
        }
        else{
          $('#cargarHV').text($(this)[0].files[0].name);
          imagen = "logo-04.png";
          texto = "Hoja de vida cargada. De click en guardar para continuar.";
        }
      }
    }
    else{
      imagen = "wrong-04.png";
      texto = "Ha ocurrido un error. Intente nuevamente.";
    }

    Swal.fire({            
      text: texto,
      imageUrl: $('#puerto_host').val()+'/imagenes/'+imagen,
      imageWidth: 210,
      confirmButtonText: 'ACEPTAR',
      animation: true
    });          
  });
}


if($('#cargarHVForm').length){
  $('#cargarHVForm').on('submit', function(){
    var cargaHV = $('#userHV').val();
    var imagen = "";
    var texto = "";
    var filehVExt = cargaHV.split('.').pop();
    console.log(filehVExt);
    if(cargaHV != null && cargaHV != ""){
      if(filehVExt != 'pdf' && filehVExt != 'docx' && filehVExt != 'doc'){
        imagen = "wrong-04.png";
        texto = "El campo solo permite archivos con formato .docx, .pdf";
      }
      else{
        imagen = "logo-04.png";
        texto = "Hoja de vida cargada. De click en guardar para continuar.";
      }
    }
    else{
      imagen = "wrong-04.png";
      texto = "Ha ocurrido un error. Intente nuevamente.";
    }

    Swal.fire({            
      text: texto,
      imageUrl: $('#puerto_host').val()+'/imagenes/'+imagen,
      imageWidth: 210,
      confirmButtonText: 'ACEPTAR',
      animation: true
    });
  })
}



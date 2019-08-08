var errorCount = 0;
if($('.recuadro-perfil').length){
  $('.recuadro-perfil').on('click', function(){
    $('#userHV').click();
  });
}

if($('#userHV').length){
  $('#userHV').on('change', function(){
    var cargaHV = $(this).val();
    var imagen = "";
    var texto = "";
    var filehVExt = cargaHV.split('.').pop();
    // console.log(filehVExt);
    if(cargaHV != null && cargaHV != ""){
      $('#cargarHV').text($(this)[0].files[0].name);
      if(filehVExt != 'pdf' && filehVExt != 'docx' && filehVExt != 'doc'){
        imagen = "wrong-04.png";
        texto = "El campo solo permite archivos con formato .docx, .pdf";
        errorCount = 1;
      }
      else{
        // console.log($(this)[0].files[0].size);
        if($(this)[0].files[0].size > 2000000){
          imagen = "wrong-04.png";
          texto = "El archivo cargado excede el tamaño permitido (2MB).";  
          errorCount = 1;
        }
        else{
          imagen = "logo-04.png";
          texto = "Hoja de vida cargada. De click en guardar para continuar.";
          errorCount = 0;
        }
      }
    }
    else{
      imagen = "wrong-04.png";
      texto = "Ha ocurrido un error. Intente nuevamente.";
      errorCount = 1;
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
  $('#cargarHVForm').on('submit', function(event){
    var cargaHV = $('#userHV').val();
    var imagen = "";
    var texto = "";
    var filehVExt = cargaHV.split('.').pop();
    // console.log(filehVExt);
    if(cargaHV != null && cargaHV != ""){
      $('#cargarHV').text($('#userHV')[0].files[0].name);
      if(filehVExt != 'pdf' && filehVExt != 'docx' && filehVExt != 'doc'){
        imagen = "wrong-04.png";
        texto = "El campo solo permite archivos con formato .docx, .pdf";
        errorCount = 1;
      }
      else{
        // console.log($('#userHV')[0].files[0].size);
        if($('#userHV')[0].files[0].size > 2000000){
          imagen = "wrong-04.png";
          texto = "El archivo cargado excede el tamaño permitido (2MB).";  
          errorCount = 1;
        }
        else{
          imagen = "logo-04.png";
          texto = "Hoja de vida cargada. De click en guardar para continuar.";
          errorCount = 0;
        }
      }
    }
    else{
      imagen = "wrong-04.png";
      texto = "Por favor, cargue su Hoja de vida para continuar.";
      errorCount = 1;
    }


    validarSubmit($(this), event);

    if(errorCount != 0){
      Swal.fire({            
        text: texto,
        imageUrl: $('#puerto_host').val()+'/imagenes/'+imagen,
        imageWidth: 210,
        confirmButtonText: 'ACEPTAR',
        animation: true
      });
    }
  })
}

function validarSubmit(obj, e){
  if(errorCount == 1){
    // e.preventDefault();
  }
}




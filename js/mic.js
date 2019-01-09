function validarUsuario(username){

  if(username == null || username.length == 0 || /^\s+$/.test(username)){
    colocaError("err_username","seccion_username","El campo no puede ser vac\u00EDo","btn_sesion");
  }else if(username.length > '50'){
    colocaError("err_username","seccion_username","El usuario no debe exceder de 50 caracteres","btn_sesion");
  }else if(username.length < '4'){
    colocaError("err_username","seccion_username","El n\u00FAmero minimo de caracteres es de 4","btn_sesion");
  }else{
    quitarError("err_username","seccion_username");
  }
}

function validarClave(){

  var password = document.getElementById('password1').value;

  if(password == null || password.length == 0 || /^\s+$/.test(password)){
    colocaError("err_password","seccion_password","El campo no puede ser vac\u00EDo","btn_sesion");
  }else if(password.length > '15'){
    colocaError("err_password","seccion_password","La clave no debe exceder de 15 caracteres","btn_sesion");
  }else if(password.length < '8'){
    colocaError("err_password","seccion_password","El n\u00FAmero minimo de caracteres es de 8","btn_sesion");
  }else{
    quitarError("err_password","seccion_password");
  }
}

function validarClavesRecuperar(){

    var expreg = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    var err_campo = "El campo no puede ser vac\u00EDo";
    var err_formato = "Formato incorrecto, Letras y n\u00FAmeros, m\u00EDnimo 8 caracteres";
    var password = document.getElementById('password1').value;
    var password_two = document.getElementById('password2').value;

    if(password == null || password.length == 0 || /^\s+$/.test(password)){
      colocaError("err_clave", "seccion_clave",err_campo,"recuperar");
    }else if(!expreg.test(password)){
      colocaError("err_clave", "seccion_clave",err_formato,"recuperar");   
    }else{
      quitarError("err_clave", "seccion_clave");
    }
    if(password_two == null || password_two.length == 0 || /^\s+$/.test(password_two)){
      colocaError("err_clave1", "seccion_clave1",err_campo,"recuperar");
    }else if(!expreg.test(password_two)){
      colocaError("err_clave1", "seccion_clave1",err_formato,"recuperar");  
    }else{
      if(password != password_two){
        colocaError("err_clave1", "seccion_clave1","Ingrese la misma contrase\u00F1a","recuperar"); 
      }else{
        quitarError("err_clave1", "seccion_clave1");
      }
    }
}

function validarCorreo(correo,err_correo,seccion_correo,btn){

  var expreg_correo = /^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/;
  if(correo == null || correo.length == 0 || /^\s+$/.test(correo)){
    colocaError(err_correo, seccion_correo,"El campo no puede ser vac\u00EDo",btn);
  }else if(!expreg_correo.test(correo)){
    colocaError(err_correo,seccion_correo,"Formato incorrecto, no es un correo v\u00E1lido",btn); 
  }else{
    quitarError(err_correo,seccion_correo);
  }
}

function validaForm(tipo,btn){

  //tipo de formulario a evaluar 1 es login y 2 recuperar contraseña
  if(tipo == 1){
    var username = document.getElementById('username').value;
    validarUsuario(username);
    validarClave();
    validaCampos(1,btn);
  }

  if(tipo == 2){
    if(document.getElementById('password1')){
      validarClavesRecuperar();
    }else{
      var correo = document.getElementById('correo1').value;
      validarCorreo(correo,"err_correo","seccion_correo",btn);
    }
    validaCampos(2,btn);
  }

  if(tipo == 3){
    var nombres = document.getElementById('nombres').value;
    var correo = document.getElementById('correo1').value;
    var descripcion = document.getElementById('descripcion').value;
    var telefono = document.getElementById('telefono').value;    
    validarInput(nombres,"err_nombres","seccion_nombres",btn);
    validarCorreo(correo,"err_correo","seccion_correo",btn);
    validarDir(descripcion,"err_descripcion", "seccion_descripcion",btn);
    validarNumTelf(telefono,"err_telefono","seccion_telefono",btn);
    validaCampos(3,btn);
  }
}

function validarNumTelf(num,err_telf,seccion_telf,btn){

  var expreg_telf = /^[0-9]+$/;
  var error = 0;

  if(num == null || num.length == 0 || /^\s+$/.test(num)){

      colocaError(err_telf,seccion_telf,"El campo no puede ser vac\u00EDo",btn);
      error = 1;

  }else if(!expreg_telf.test(num)){

      colocaError(err_telf,seccion_telf,"Formato incorrecto, solo numeros",btn);
      error = 1; 

  }else{
      quitarError(err_telf,seccion_telf);
  }
  return error;
}

function validarDir(direccion,err_dir, seccion_dir,btn){

  var error = 0;
  var expreg1 = /^[a-z A-Z0-9ñÑÁÉÍÓÚáéíóú]+$/;

  //console.log(expreg1.test(direccion));
  if(direccion == null || direccion.length == 0 || /^\s+$/.test(direccion)){

    colocaError(err_dir, seccion_dir,"El campo no puede ser vac\u00EDo",btn);
    error = 1; 

  }else if(!expreg1.test(direccion)){

    colocaError(err_dir, seccion_dir,"Formato incorrecto, solo letras y n\u00FAmeros",btn); 
    error = 1;

  }else{
      quitarError(err_dir,seccion_dir);
  }
  return error;
}

function validarInput(campo,err,err_campo,btn){

  var error = 0;
  var expreg = /^[a-z ÁÉÍÓÚáéíóúñÑ]+$/i;  
  if(campo == null || campo.length == 0 || /^\s+$/.test(campo)){
    colocaError(err,err_campo,"El campo no puede ser vac\u00EDo",btn);
    error = 1; 
  }else if(expreg.test(campo) == false){
    console.log(campo + "/" + expreg);
    colocaError(err,err_campo,"Formato incorrecto, solo letras",btn);
    error = 1;
  }else{
    quitarError(err,err_campo);
  }
  return error;
}

function validaCampos(form,btn){

  if(form == 1){
    elem = $('#form_login').find('input[type!="hidden"]');
  }else if(form == 2){
    elem = $('#form_contrasena').find('input[type!="hidden"]');
  }else if(form == 3){
    elem = $('#form_recomendaciones').find('input[type!="hidden"]');
  }

  var errors = 0; 

  for(i=0; i < elem.length; i++){

    if(elem[i].value=="" || elem[i].value==" "){
      errors++;
      break;
    }
  }
  //console.log(errors);
  if(errors > 0 || verifyErrors() > 0){    
    $("#"+btn).addClass('disabled');
    document.getElementById(btn).setAttribute('disabled','disabled');
  }else{    
    $("#"+btn).removeClass('disabled'); 
    $('#'+btn).removeAttr('disabled');   
  }
}

$('.modal').on('hidden.bs.modal', function(){
    var $form = $(this);

    $(this).find('#form_register')[0].reset();
    var error_msg = document.getElementsByClassName('with-errors');
    var error_input = document.getElementsByClassName('has-error');

    for (var i = error_msg.length - 1; i >= 0; i--) {
      error_msg[i].innerHTML = '';
    }

    for (var i = error_input.length - 1; i >= 0; i--) {
      error_input[i].classList.remove("has-error")
    }
});

function verifyErrors(){
  var listerrors = document.getElementsByClassName('msg_error');
  return listerrors.length;
}

$('.carousel[data-type="multi"] .item').each(function(){

  var next = $(this).next();
  if (!next.length) {
    next = $(this).siblings(':first');
  }
  next.children(':first-child').clone().appendTo($(this));
  
  for (var i=0;i<4;i++) {

    next=next.next();
    if (!next.length) {
        next = $(this).siblings(':first');
    }
    
    next.children(':first-child').clone().appendTo($(this));
  }
});

function pass_reveal(obj){
  var input_reveal = obj.nextElementSibling;
  input_reveal.setAttribute("type", "text");
  obj.firstChild.setAttribute("class", "fa fa-eye-slash");
  obj.setAttribute("onclick", "pass_hidden(this)");
}

function pass_hidden(obj){
  var input_reveal = obj.nextElementSibling;
  input_reveal.setAttribute("type", "password");
  obj.firstChild.setAttribute("class", "fa fa-eye");
  obj.setAttribute("onclick", "pass_reveal(this)");
}

$(document).ready(function(){
  if (document.getElementsByName("nombres_res") && document.getElementsByName("valor_res")){
    var nombres_res = document.getElementsByName("nombres_res");
    var valor_res = document.getElementsByName("valor_res");
      mostrarGrafico(nombres_res, valor_res);
  }
  expreg = /^[a-z ÁÉÍÓÚáéíóúñÑ]+$/i;  
  console.log(expreg);
});

function mostrarGrafico(label, valor){
  var labels = [];
  var valores = [];
  for (var i = label.length - 1; i >= 0; i--) {
    labels[i] = label[i].value;
    // 
  }
  for (var i = valor.length - 1; i >= 0; i--) {
    valores[i] = valor[i].value;
    // 
  }
    let myChart = document.getElementById('myChart').getContext('2d');
      // Global Options
      Chart.defaults.global.defaultFontFamily = 'Lato';
      Chart.defaults.global.defaultFontSize = 15;
      Chart.defaults.global.defaultFontColor = 'black';
      // Chart.defaults.scale.gridLines.display = false;

      let massPopChart = new Chart(myChart, {
        type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
        data:{
          labels:labels,
          datasets:[{
            label:'Population',
            data:valores,
            //backgroundColor:'green',
            backgroundColor:[
              '#001f3f',
              '#0074D9',
              '#7FDBFF',
              '#39CCCC',
              '#3D9970',
              '#FFDC00',
              '#FF851B ',
              '#FF4136',
              '#85144b',
              '#AAAAAA',
              '#B10DC9'
            ],
            borderWidth:1,
            borderColor:'#777',
            hoverBorderWidth:3,
            hoverBorderColor:'#000'
          }]
        },
        options:{
          responsive: true,
          title:{
            display:false,
            text:'Resultados evaluación',
            fontSize:25
          },
          legend:{
            display:false,
            position:'top',
            labels:{
              fontColor:'#000'
            }
          },
          layout:{
            padding:{
              left:50,
              right:0,
              bottom:0,
              top:0
            }
          },
          tooltips:{
            enabled:true
          },
          scales: {
            yAxes: [{
                ticks: {
                  min: 0
                },
                gridLines: {
                    display:false
                }
            }],
            xAxes: [{
                barPercentage: 0.4,
                 ticks: {
                    autoSkip: false,
                    maxRotation: 50,
                    minRotation: 50
                  },
                gridLines: {
                    display:false
                }
            }]
          }
        }
      });
  }  

// $(document).ready(function(){
//   html2canvas(document.getElementById("myChart"), {
//     dpi: 300, // Set to 300 DPI
//     scale: 69, // Adjusts your resolution
//     onrendered: function(canvas) {
//       var img = canvas.toDataURL("image/png", 1);
//       console.log(img);
//       // document.getElementById('img_2').appendChild(canvas);
//       $('#img_val').val(canvas.toDataURL("image/png"));
//       console.log($('#img_val').val());
//     }
//   });
// });

  // this.style.display = "none";
  // var w = document.getElementById("myChart").offsetWidth;
  // var h = document.getElementById("myChart").offsetHeight;
  // html2canvas(document.getElementById("myChart"), {
  //   dpi: 300, // Set to 300 DPI
  //   scale: 3, // Adjusts your resolution
  //   onrendered: function(canvas) {
  //     var img = canvas.toDataURL("image/png", 1);
  //     var doc = new jsPDF('L', 'px', [w, h]);
  //     doc.addImage(img, 'JPEG',   0,  0, w, h);
  //     doc.save('sample-file.pdf');
  //   }
  // });
  // this.style.display = "";

// html2canvas(document.querySelector("#myChart")).then(canvas => {
//     document.body.appendChild(canvas)
// });


if(document.getElementById('form_register')){
  $("#form_register").validator();
}

if(document.getElementById('form_login')){
  $("#form_login").validator();
}

if(document.getElementById('form_publicar')){
  $("#form_publicar").validator();
}

$('.modal').on('hidden.bs.modal', function(){
    var $form = $(this);
    if (document.getElementById("error_custom_dni")){
      var dni_error = document.getElementById("error_custom_dni");
      while (dni_error.hasChildNodes()) {
        dni_error.removeChild(dni_error.firstChild);
      }
    }
    $(this).find('form')[0].reset();
});

if (document.getElementById("area_select"))
{
  $("#area_select").selectr({
      placeholder: 'Buscar...'
  });
}

if (document.getElementById("nivel_interes"))
{
  $("#nivel_interes").selectr({
      placeholder: 'Buscar...'
  });
}

if(document.getElementById('form_login')){
  $("#form_login").validator();
}

if(document.getElementById('form_contrasena')){
  $("#form_contrasena").validator();
}


if(document.getElementById('form_recomendaciones')){
  $("#form_recomendaciones").validator();
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


// if(document.getElementById("term_cond")){
//   $("#term_cond").on("change", function(){
//     if (document.getElementById("term_cond").checked) {
//       document.getElementById("conf_datos").checked = true;
//     }
//     else{
//       document.getElementById("conf_datos").checked = false;
//     }
//   })
// }

// if(document.getElementById("conf_datos")){
//   $("#conf_datos").on("change", function(){
//     if (document.getElementById("conf_datos").checked) {
//       document.getElementById("term_cond").checked = true;
//     }
//     else{
//       document.getElementById("term_cond").checked = false;
//     }
//   })
// }

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

function quitarError(campo,id){

    document.getElementById(campo).innerHTML = '';
    $("#"+id).removeClass('has-error');
}

$(document).ready(function(){
  if (document.getElementsByName("nombres_res") && document.getElementsByName("valor_res")){
    var nombres_res = document.getElementsByName("nombres_res");
    var valor_res = document.getElementsByName("valor_res");
      mostrarGrafico(nombres_res, valor_res);
  }
});

function mostrarGrafico(label, valor){
  var labels = [];
  var valores = [];
  for (var i = label.length - 1; i >= 0; i--) {
    // console.log(label[i].value+" - "+valor[i].value);
    labels[i] = label[i].value;
    // 
  }
  for (var i = valor.length - 1; i >= 0; i--) {
    // console.log(label[i].value+" - "+valor[i].value);
    valores[i] = valor[i].value;
    // 
  }
  // console.log(labels);
  // console.log(valores);

    let myChart = document.getElementById('myChart').getContext('2d');


      // Global Options
      Chart.defaults.global.defaultFontFamily = 'Lato';
      Chart.defaults.global.defaultFontSize = 15;
      Chart.defaults.global.defaultFontColor = '#777';

      let massPopChart = new Chart(myChart, {
        type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
        data:{
          labels:labels,
          datasets:[{
            label:'Population',
            data:valores,
            //backgroundColor:'green',
            backgroundColor:[
              'rgba(75, 192, 192, 0.6)',
              'rgba(255, 99, 132, 0.6)',
              'rgba(54, 162, 235, 0.6)',
              'rgba(51, 136, 45, 0.3)',
              'rgba(153, 102, 255, 0.6)',
              'rgba(246, 136, 196, 0.3)',
              'rgba(255, 159, 64, 0.6)',
              'rgba(246, 61, 196, 0.3)',
              'rgba(246, 136, 45, 0.3)',
              'rgba(164, 142, 99, 0.3)',
              'rgba(33, 91, 138, 0.3)'
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
                  min: 5
                }
            }],
            xAxes: [{
                barPercentage: 0.4,
                 ticks: {
                    autoSkip: false,
                    maxRotation: 50,
                    minRotation: 50
                  }
            }]
          }
        }
      });
  }  


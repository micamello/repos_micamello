// if(document.getElementById('form_register')){
//   $("#form_register").validator();
// }

if(document.getElementById('form_login')){
  $("#form_login").validator();
}

// if(document.getElementById('form_publicar')){
//   $("#form_publicar").validator();
// }

$('.modal').on('hidden.bs.modal', function(){
    var $form = $(this);

    $(this).find('#form_register')[0].reset();
    var error_msg = document.getElementsByClassName('with-errors');
    var error_input = document.getElementsByClassName('has-error');

    // console.log(error_msg.length);
    // console.log(error_input.length);

    for (var i = error_msg.length - 1; i >= 0; i--) {
      error_msg[i].innerHTML = '';
    }

    for (var i = error_input.length - 1; i >= 0; i--) {
      error_input[i].classList.remove("has-error")
    }
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
                  min: 5
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


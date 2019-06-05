/*$('#btn-verde').on('click',function(){

    if(document.getElementById('btn-enlace')){
        document.getElementById('btn-enlace').style.display = 'block';
        document.getElementById('btn-verde').style.display = 'none';
    }
});*/

$(document).ready(function(){

    var datos = $('#datosGrafico').val();

    if(datos != ''){

        datos = datos.split('|');
        
        var arreglo = [['Task', 'Hours per Day']];
        for (var i = 0; i < datos.length; i++) {

            var porcion = datos[i].split(',');
            porcion[1] = parseFloat(porcion[1]);
            arreglo.push(porcion);
        }
        var puerto_host = $('#puerto_host').val();
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable(arreglo);

            var options = {
              pieSliceText: 'label',
              is3D: true,
              width:3500,
              height:2000,
              pieSliceTextStyle: {color: 'black', fontName: 'dsfd', fontSize: 80},
              fontSize:80,
              legend: 'none',
              slices: {
                0: { color: '#FCDC59' },
                1: { color: '#E25050' },
                2: { color: '#8C4DCE' },
                3: { color: '#2B8DC9' },
                4: { color: '#5EB782' }
              }
            };

            document.getElementById('Chart_details').style.display='block';
            var chart_1 = new google.visualization.PieChart(document.getElementById('g_chart_1'));
            chart_1.draw(data, options);
            var chart_div = document.getElementById('chart_div');

            google.visualization.events.addListener(chart_1, 'ready', function () {

               var uri = chart_1.getImageURI();
               document.getElementById('Chart_details').style.display='none';
               //chart_div.innerHTML = '<img width="600" heigth="600" align="center" src="'+uri+'">';

               $.ajax({
                    type: "POST",
                    url: puerto_host+"/index.php?mostrar=velocimetro&opcion=guardarGrafico",
                    data: {imagen:uri},
                    dataType:'json',
               });
            });
        }
    }
});
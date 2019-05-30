$(document).ready(function(){
    
    /*var datos = $('#datosGrafico').val();
    datos = datos.split('/');
    
    var arreglo = [['Task', 'Hours per Day']];
    for (var i = 0; i < datos.length; i++) {
        arreglo.push(datos[i].split(','));
    }
    var puerto_host = $('#puerto_host').val();
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable(arreglo);

        var options = {
          pieSliceText: 'label',
          is3D: true,
          width:4000,
          height:2600,
          pieSliceTextStyle: {color: 'black', fontName: 'dsfd', fontSize: 80},
          fontSize:80,
          legend: 'none',
          slices: {
            0: { color: '#ffd966' },
            1: { color: '#ff7575' },
            2: { color: '#a86ed4' },
            3: { color: '#4b98dd' },
            4: { color: '#a8d08d' }
          }
        };

        var chart_1 = new google.visualization.PieChart(document.getElementById('g_chart_1'));
        chart_1.draw(data, options);

        var chart_div = document.getElementById('chart_div');
        
        google.visualization.events.addListener(chart_1, 'ready', function () {

            $.ajax({
                type: "POST",
                url: puerto_host+"/index.php?mostrar=velocimetro&opcion=guardarGrafico",
                data: {imagen:chart_1.getImageURI()},
                success(data){
                    document.getElementById('Chart_details').style.display='none';
                },
                error(){
                    document.getElementById('Chart_details').style.display='none';
                }
            });
        });

        chart_1.draw(data, options);
    }*/
});
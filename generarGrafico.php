 <script src="http://localhost/repos_micamello/js/assets/js/vendor/jquery-3.0.0.js"></script>
 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
  <link rel="stylesheet" href="http://localhost/repos_micamello/css/assets/css/bootstrap.css">
 <script type="text/javascript">

   google.charts.load('current', {'packages':['corechart']});
   google.charts.setOnLoadCallback(drawChart);

   function drawChart(){
    
      var data = google.visualization.arrayToDataTable([
      ['Gender', 'Number'],
      
      ]);

      var options = {
        title : 'Percentage of Male and Female Employee',
        pieHole : 0.4,
        chartArea:{left:100,top:70,width:'100%',height:'80%'}
      };
      document.getElementById('grafico').html = '';
      var chart_area = document.getElementById('grafico');
      var chart = new google.visualization.PieChart(chart_area);

      chart.draw(data, options);
      document.write(chart.getImageURI());
     /* var input = document.createElement("input");
      input.setAttribute("type", "hidden");
      input.setAttribute("name", "hidden_html");
      input.setAttribute("id", "hidden_html");
      input.setAttribute("value", chart.getImageURI());
      document.getElementById("area_inputs").appendChild(input);*/
      //var divnombre = 'grafico1';
      //$('#'+divnombre).html(chart.getImageURI());
    
      
    //$('#envio_graficos').submit();
   }

</script>  
 
<div id="grafico" style="width: 100%; max-width:900px; height: 500px; visibility: hidden;"></div>

<div id="area_inputs"><div id='grafico1'><script>drawChart();</script></div></div>
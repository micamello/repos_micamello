 <script type="text/javascript">

   google.charts.load('current', {'packages':['corechart']});

   google.charts.setOnLoadCallback(drawChart);

   function drawChart()
   {
    var data = google.visualization.arrayToDataTable([
     ['Gender', 'Number'],
     <?php
     foreach($result as $row)
     {
      echo "['".$row["gender"]."', ".$row["number"]."],";
     }
     ?>
    ]);

    var options = {
     title : 'Percentage of Male and Female Employee',
     pieHole : 0.4,
     chartArea:{left:100,top:70,width:'100%',height:'80%'}
    };
    var chart_area = document.getElementById('grafico');
    var chart = new google.visualization.PieChart(chart_area);

    chart.draw(data, options);
    $('#hidden_html').val(chart.getImageURI());
    $('#make_pdf').submit();
   }
</script>  
 
<div id="grafico" style="width: 100%; max-width:900px; height: 500px; visibility: hidden;"></div>
<form method="POST" id="make_pdf" action="<?php echo PUERTO."://".HOST;?>/generaPDF/1/">
  <input type="hidden" name="hidden_html" id="hidden_html" />
</form>

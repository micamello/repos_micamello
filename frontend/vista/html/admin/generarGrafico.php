 <script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/jquery-3.0.0.js"></script>
 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/assets/css/bootstrap.css">
 <script type="text/javascript">

   google.charts.load('current', {'packages':['corechart']});
   google.charts.setOnLoadCallback(drawChart);

   function drawChart()
   {
    <?php foreach($datos as $key => $result){ ?>

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
      document.getElementById('grafico').html = '';
      var chart_area = document.getElementById('grafico');
      var chart = new google.visualization.PieChart(chart_area);

      chart.draw(data, options);

      var input = document.createElement("input");
      input.setAttribute("type", "hidden");
      input.setAttribute("name", "hidden_html<?php echo $key+1; ?>");
      input.setAttribute("id", "hidden_html<?php echo $key+1; ?>");
      input.setAttribute("value", chart.getImageURI());
      document.getElementById("area_inputs").appendChild(input);
    <?php } ?>

    $('#envio_graficos').submit();
   }
</script>  
 
<div id="grafico" style="width: 100%; max-width:900px; height: 500px; visibility: hidden;"></div>
<form method="POST" id="envio_graficos" action="<?php echo PUERTO."://".HOST;?>/generaInforme/1/">
<div id="area_inputs"></div>
</form>

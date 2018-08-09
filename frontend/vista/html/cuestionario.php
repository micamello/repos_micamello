<style type="text/css">
  .home {
    background: linear-gradient( rgba(35, 30, 30, 0.35), rgba(0, 0, 0, 0.35) ),url(<?php echo PUERTO.'://'.HOST;?>/imagenes/banner/cabecera-candidato.jpg) no-repeat scroll center center;    background-size: cover;
    position: relative;
    padding-top: 185px;
    padding-bottom: 79px;
    width: 100%;
}
body {
    background-color: #eceff1;
}
</style>
<section id="home" class="home bg-black fix">
  <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="main_home text-center">
          <div class="col-md-12">
            <div class="hello_slid">
              <div class="slid_item">
                <div class="home_text ">
                  <h2 class="text-white">Bienvenid@ <strong><?php echo $_SESSION['mfo_datos']['usuario']['nombres'].' '.$_SESSION['mfo_datos']['usuario']['apellidos']; ?></strong></h2>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><!--End off row-->
  </div><!--End off container -->
</section> <!--End off Home Sections-->

<section id="product" class="product">
  <div class="container"><br><br>

    <div class="breadcrumb" style="background-color: #0267cf;">
      <p class="text-center" style="color: white; font-size: 17px;">Primer formulario</p>
    </div>
 
    <div class="container">
      <ul class="nav nav-tabs">               
        <li class="active"><a href="#<?php echo $total; ?>" data-toggle="tab">No.<?php echo $total; ?></a></li>
        <!--<li><a href="#<?php echo $i; ?>" data-toggle="">No.<?php echo $i; ?></a></li>-->             
      </ul>
    </div>

    <div class="" style="background-color: white;">
      <div class="tab-content ">
        <form role="form" name="form1" id="form1" method="post">
          <textarea name="tiempo" id="count-up" style="display: none">0:00</textarea>        
          <br>
          <div class='tab-pane active' id='1' align='center'>
            <h4><?php echo $row['pregunta']; ?></h4>
            <div align="left" style="margin-left: 400px">
              <label><input type="radio" name="n1" value="1" checked> Completamente falso</label><br>
              <label><input type="radio" name="n1" value="2"> Bastante falso</label><br>
              <label><input type="radio" name="n1" value="3"> Ni verdadero ni falso</label><br>
              <label><input type="radio" name="n1" value="4"> Bastante verdadero</label><br>
              <label><input type="radio" name="n1" value="5"> Completamente verdadero</label>
            </div>
          </div>
          <br>
          <div align="center">
            <input class="btn btn-success" type="submit" name="" value="CONTINUAR">
          </div>
          <br>        
        </form>
      </div>
  </div>
</section>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="margin-top: 100px">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" align="center">Instrucciones</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12" style="font-size: 16px; color: #333">
            Para una mayor efectividad en tu búsqueda, a continuación, te presentamos tres <b>Formularios de Personalidad</b> avalados por profesionales, sigue las siguientes instrucciones:<br><br>

            - Debes responder en el menor tiempo posible<br>
            - Apagar celulares o aparatos que pudieran ser distractores<br>
            - Contesta en forma honesta y precisa. <b>Solo accederás una vez</b><br>
            - Al enviar no podrás realizar ningún tipo de corrección <br><br>

            ¿Estás listo? Coloca tu mente en blanco y haz clic <br><br>

            <center>
              <button type="button" class="btn btn-success" data-dismiss="modal">Formularios </button>
            </center> 
          </div>
        </div>
      </div>      
    </div>
  </div>
</div>

<!--<script type='text/javascript'>
  $(window).on('load',function(){
        $('#myModal').modal('show');
  });
</script>-->
<div class="container">
  <div class="breadcrumb" style="background-color: #0267cf;">
    <p class="text-center" style="color: white; font-size: 17px;"><?php echo $destest;?> formulario</p>
  </div>

  <div class="container">
    <ul class="nav nav-tabs">         
      <?php for($key=0;$key<$nropreguntas;$key++){ ?>      
        <li <?php echo ($pregunta["orden"] == ($key+1)) ? 'class="active"' : '';?>><a href="javascript:void(0);" data-toggle="tab">No.<?php echo ($key+1);?></a></li>
      <?php } ?>
    </ul>
  </div>

  <div class="" style="background-color: white;">
    <div class="tab-content ">
      <form role="form" name="form1" id="form1" method="post" action="<?php echo PUERTO."://".HOST."/cuestionario/";?>">        
        <br>
        <div class='tab-pane active' id='1' align='center'>
          <h4><?php echo utf8_encode($pregunta["pregunta"]);?>
            <input type='hidden' id='id_test' name='id_test' value='<?php echo $nrotest;?>'>
            <input type='hidden' id='id_pregunta' name='id_pregunta' value='<?php echo $pregunta["id_pre"];?>'>
            <input type='hidden' id='form_pregunta' name='form_pregunta' value='1'>
            <input type='hidden' id='tiempo' name='tiempo' value='<?php echo $tiempo;?>'>
            <input type='hidden' id='modo_pregunta' name='modo_pregunta' value='<?php echo $pregunta["modo"];?>'>
          </h4>
          <div class="form-group">
            <div class="row">
              <div class="col-xs-3 col-md-5"></div>
              <div class="col-xs-9 col-md-7">
              <?php foreach($opciones as $opcion){ ?>
                <p align="justify"><input type="radio" name="id_opcion" value="<?php echo $opcion["orden"];?>" <?php echo ($opcion["orden"] == 1) ? "checked" : "";?>>&nbsp;<?php echo $opcion["descripcion"];?></p>
              <?php } ?>
              </div>         
            </div>               
          </div>
        </div>
        <div class="row">        
          <div class="col-md-12" align="center">
            <input class="btn btn-success" type="submit" name="" value="CONTINUAR">
          </div>
        </div>
        <br>        
      </form>
    </div>
</div>

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



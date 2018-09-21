<div class="container">
  <div class="breadcrumb" style="background-color: #0267cf;">
    <p class="text-center" style="color: white; font-size: 17px;"><?php echo $destest;?> formulario</p>
  </div>

  <div class="container">
    <ul class="nav nav-tabs">
      <?php $i = 0;?>         
      <?php foreach($preguntas as $key=>$pregunta){ ?>
        <?php $i++;?>      
        <li <?php echo ($pregunta["id_pre"] == $preguntaact["id_pre"]) ? 'class="active"' : '';?>><a href="javascript:void(0);" data-toggle="tab">No.<?php echo $i;?></a></li>
      <?php } ?>
    </ul>
  </div>

  <div class="" style="background-color: white;">
    <div class="tab-content ">
      <form role="form" name="form1" id="form1" method="post" action="<?php echo PUERTO."://".HOST."/cuestionario/";?>">        
        <br>
        <div class='tab-pane active' id='1' align='center'>
          <h4><?php echo utf8_encode($preguntaact["pregunta"]);?>
            <input type='hidden' id='id_test' name='id_test' value='<?php echo $nrotest;?>'>
            <input type='hidden' id='id_pregunta' name='id_pregunta' value='<?php echo $preguntaact["id_pre"];?>'>
            <input type='hidden' id='form_pregunta' name='form_pregunta' value='1'>
            <input type='hidden' id='tiempo' name='tiempo' value='<?php echo $tiempo;?>'>
            <input type='hidden' id='modo_pregunta' name='modo_pregunta' value='<?php echo $preguntaact["modo"];?>'>
          </h4>
          <div class="form-group">
            <div class="row">
              <div class="col-xs-3 col-md-5"></div>
              <div class="col-xs-9 col-md-7">
              <?php foreach($opciones as $opcion){ ?>
                <p align="justify"><input type="radio" name="id_opcion" value="<?php echo $opcion["id_opcion"];?>" <?php echo ($opcion["orden"] == 1) ? "checked" : "";?>>&nbsp;<?php echo $opcion["descripcion"];?></p>
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
<br><br>

<!-- Modal -->
<div class="modal fade" id="msg_inforcuestionario" tabindex="-1" role="dialog" aria-labelledby="msg_inforcuestionario" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" align="center">Instrucciones</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <h5 class="text-justify">Para una mayor efectividad en tu búsqueda, a continuación, te presentamos tres <b>Formularios de Personalidad</b>, sigue las siguientes instrucciones:</h5>
            <h5 class="text-justify">- Debes responder en el menor tiempo posible<br>
               - Apagar celulares o aparatos que pudieran ser distractores<br>
               - Contesta en forma honesta y precisa. <b>Solo accederás una vez</b><br>
               - Al enviar no podrás realizar ningún tipo de corrección</h5>
            <h5>¿Estás listo? Coloca tu mente en blanco y haz clic</h5>
            <center>
              <button type="button" class="btn btn-success" data-dismiss="modal">Formularios </button>
            </center> 
          </div>
        </div>
      </div>      
    </div>
  </div>
</div>

<!--pie de pagina-->
</section>
<input type="text" hidden id="puerto_host" value="<?php echo PUERTO."://".HOST ;?>">
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/jquery-3.0.0.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/bootstrap.min.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/main.js"></script>
<!--<script src="<?php //echo PUERTO."://".HOST;?>/js/notificaciones.js" type="text/javascript"></script>-->
<script src="<?php echo PUERTO."://".HOST;?>/js/cookies.js" type="text/javascript"></script>

<?php
if (isset($template_js) && is_array($template_js)){
  foreach($template_js as $file_js){
    echo '<script type="text/javascript" src="'.PUERTO.'://'.HOST.'/js/'.$file_js.'.js"></script>';
  }  
}
?>
</body>
</html>
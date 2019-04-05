<div class="container">



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
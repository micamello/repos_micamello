<input type="text" hidden id="puerto_host" value="<?php echo PUERTO."://".HOST ;?>">
<input type="hidden" id="iso" value="<?php echo SUCURSAL_ISO; ?>">

<footer id="contact" class="footer p-top-30">
  <div class="container-fluid">
    <div class="foot_mic">
      <div class="pie-pag col-md-4" style=" padding-left: 30px;
      ">
        <h3>Nosotros</h3>
        <p><a class="" href="<?php echo PUERTO.'://'.HOST.'/quienesSomos/'?>">¿Quiénes somos?</a></p>
        <p><a class="legal_info_content" href="http://blog.micamello.com.ec/" target="blanked">Blog</a></p>
        <h3>Políticas de Privacidad</h3>
        <p><a class="legal_info_content" href="<?php echo PUERTO."://".HOST."/docs/terminos_y_condiciones".SUCURSAL_ID.".pdf";?>" target="_blank">Términos y Condiciones</a></p>
        <p><a class="legal_info_content" href="<?php echo PUERTO."://".HOST."/docs/politicas_de_privacidad".SUCURSAL_ID.".pdf";?>" target="_blank">Políticas de Privacidad</a></p>
        <p><a class="legal_info_content" href="<?php echo PUERTO."://".HOST."/docs/politicas_de_cookies".".pdf";?>" target="_blank">Políticas de Cookies</a></p>
        <p><a class="legal_info_content" href="<?php echo PUERTO."://".HOST;?>/recomendacion/">Recomendaciones</a></p>
      </div>
      <div class="pie-pag col-md-4" style=" padding-left: 30px;">
        <h3>Disponible también en otros países</h3>
        <?php foreach(Modelo_Sucursal::obtieneListado() as $sucursal){ ?>  
          <a>
            <img src="<?php echo PUERTO."://".HOST;?>/imagenes/sucursal/iconos/<?php echo $sucursal["id_sucursal"];?>.<?php echo $sucursal["extensionicono"];?>" class="country_mic" title="<?php echo utf8_encode($sucursal["nombre_abr"]);?>"> 
          </a>
        <?php }?>   
      </div>
      <div class="pie-pag col-md-4" style="padding-left: 30px;
      ">
        <h3>Contacto</h3>
        <p>info@micamello.com.ec</p>
        <p>Ecuador</p>
        <a href="<?php echo FACEBOOK; ?>" target="_blank">
          <img src="<?php echo PUERTO."://".HOST;?>/imagenes/redes/face.png" class="social_mic">
        </a>
        <a href="<?php echo TWITTER; ?>" target="_blank">
          <img src="<?php echo PUERTO."://".HOST;?>/imagenes/redes/tw.png" class="social_mic">
        </a>
        <a href="<?php echo INSTAGRAM; ?>" target="_blank">
          <img src="<?php echo PUERTO."://".HOST;?>/imagenes/redes/ins.png" class="social_mic">
        </a>
      </div>
      <div class="col-md-12">
        <p>©<?php echo date('Y'); ?> <b>MiCamello.</b> Todos los derechos reservados.</p>
      </div>
    </div>
  </div>
</footer>
<!-- modal_seleccionados -->
<div class="modal fade" id="alert_descarga" tabindex="-1" role="dialog" aria-labelledby="alert_descarga" aria-hidden="true">
  <div class="modal-dialog" role="document">    
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><b>Notificaci&oacute;n</b></h5>   
      </div>
      <div class="modal-body">
        <h5 id="mensaje"></h5>
      </div>
      <div class="modal-footer" style="margin-top: 0px;">
        <button type="button" id="btn_cancelar" class="btn btn-md btn-default" data-dismiss="modal">Cancelar</button>
        <a href="#" id="btn_modal" class="btn btn-md btn-success">Ok</a>
      </div>
    </div>    
  </div>
</div>

<input type="text" hidden id="puerto_host" value="<?php echo PUERTO."://".HOST ;?>">
<input type="hidden" id="iso" value="<?php echo SUCURSAL_ISO; ?>">

<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/jquery-3.0.0.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/bootstrap.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/main.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/notificaciones.js" type="text/javascript"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/cookies.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo PUERTO."://".HOST;?>/js/loader.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/sweetalert.min.js"></script>
<?php
if (isset($template_js) && is_array($template_js)){
  foreach($template_js as $file_js){
    echo '<script type="text/javascript" src="'.PUERTO.'://'.HOST.'/js/'.$file_js.'.js"></script>';
  }  
}
?>
<!--mensajes de error y exito-->
<?php if (isset($sess_err_msg) && !empty($sess_err_msg)){
  echo "<script type='text/javascript'>
        $(document).ready(function(){
          swal('Advertencia!', '".$sess_err_msg."', 'error');
        });
      </script>";
}?>
<?php if (isset($sess_suc_msg) && !empty($sess_suc_msg)){
  echo "<script type='text/javascript'>
        $(document).ready(function(){
          swal('Exitoso!', '".$sess_suc_msg."', 'success');
        });
      </script>";
}?>  
</body>
</html>
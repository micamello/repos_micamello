<footer id="contact" class="footer p-top-30">
  <div class="container-fluid">
    <div class="foot_mic">
      <div class="pie-pag col-md-4" style=" padding-left: 30px;
      ">
        <h3>Nosotros</h3>
        <p><a class="" target="_blank" href="<?php echo PUERTO.'://'.HOST.'/quienesSomos/'?>">¿Quiénes somos?</a></p>
        <p><a class="legal_info_content" href="<?php echo PUERTO; ?>://blog.micamello.com.ec/" target="blanked">Blog</a></p>
        <p><a class="legal_info_content" href="<?php echo PUERTO."://".HOST."/canea/"?>" target="blanked">¿Qué es CANEA?</a></p>
        <h3>Políticas de Privacidad</h3>
        <p><a class="legal_info_content" href="<?php echo PUERTO."://".HOST."/terminoscondiciones/";?>" target="_blank">Términos y Condiciones</a></p>
        <p><a class="legal_info_content" href="<?php echo PUERTO."://".HOST."/politicaprivacidad/";?>" target="_blank">Políticas de Privacidad</a></p>
        <p><a class="legal_info_content" href="<?php echo PUERTO."://".HOST."/politicacookie/";?>" target="_blank">Políticas de Cookies</a></p>
        <p><a target="_blank" class="legal_info_content" href="<?php echo PUERTO."://".HOST;?>/recomendacion/">Recomendaciones</a></p>
      </div>
      <div class="pie-pag col-md-4" style=" padding-left: 30px;">
        <h3>Disponible también en otros países</h3>
        <?php foreach(Modelo_Sucursal::obtieneListado() as $sucursal){ ?>  
          <a href="<?php echo PUERTO."://".$sucursal['dominio']; ?>" target="_blank">
            <img src="<?php echo PUERTO."://".HOST;?>/imagenes/sucursal/iconos/<?php echo $sucursal["id_sucursal"];?>.<?php echo $sucursal["extensionicono"];?>" class="redes-mic" title="<?php echo utf8_encode($sucursal["nombre_abr"]);?>"> 
          </a>
        <?php } ?>   
      </div>
      <div class="pie-pag col-md-4" style="padding-left: 30px;
      ">
        <h3>Contacto</h3>
        <p><i class="fa fa-envelope" id="social-pie" aria-hidden="true"></i><a target="_blank" class="legal_info_content" href="<?php echo PUERTO."://".HOST;?>/recomendacion/">info@micamello.com.ec</a></p>
        <p><i class="fa fa-map-marker" id="social-pie" aria-hidden="true"></i>&nbsp;&nbsp;Ecuador</p>
        <a href="<?php echo FACEBOOK; ?>" target="_blank">
          <img src="<?php echo PUERTO."://".HOST;?>/imagenes/redes/face.png" class="redes-mic">
        </a>
        <a href="<?php echo TWITTER; ?>" target="_blank">
          <img src="<?php echo PUERTO."://".HOST;?>/imagenes/redes/tw.png" class="redes-mic">
        </a>
        <a href="<?php echo INSTAGRAM; ?>" target="_blank">
          <img src="<?php echo PUERTO."://".HOST;?>/imagenes/redes/ins.png" class="redes-mic">
        </a>
        <a href="<?php echo LINKEDIN; ?>" target="_blank">
          <img src="<?php echo PUERTO."://".HOST;?>/imagenes/redes/linkedin.png" class="redes-mic">
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
        <h5 class="titulo-modal-hoja modal-title" id="exampleModalLongTitle"><b>Notificaci&oacute;n</b></h5>   
      </div>
      <div class="modal-body">
        <h5 id="mensaje"></h5>
      </div>
      <div class="modal-footer" style="margin-top: 0px;">
        <button type="button" style="line-height: normal;" id="btn_cancelar" class="btn-red" data-dismiss="modal">Cancelar</button>
        <a href="#" id="btn_modal" class="btn-blue">Aceptar</a>
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
<script src="<?php echo PUERTO."://".HOST;?>/js/loader.js" type="text/javascript"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/sweetalert.v2.js"></script>

<?php
if (isset($template_js) && is_array($template_js)){
  foreach($template_js as $file_js){
    if ($file_js == "alignet"){
      //echo '<script type="text/javascript" src="https://integracion.alignetsac.com/VPOS2/js/modalcomercio.js"></script>';
      echo '<script type="text/javascript" src="'.PAYME_RUTA.'VPOS2/js/modalcomercio.js"></script>';
      
    }
    else{
      echo '<script type="text/javascript" src="'.PUERTO.'://'.HOST.'/js/'.$file_js.'.js"></script>';
    }
  }  
}
?>

<!--mensajes de error y exito-->
<?php if (isset($sess_err_msg) && !empty($sess_err_msg)){
  echo "<script type='text/javascript'>
        $(document).ready(function(){          
          Swal.fire({            
            text: '".$sess_err_msg."',
            imageUrl: '".PUERTO."://".HOST."/imagenes/wrong-04.png',
            imageWidth: 75,
            confirmButtonText: 'ACEPTAR',
            animation: true
          });     
        });
      </script>";
}?>

<?php if (isset($sess_suc_msg) && !empty($sess_suc_msg)){
  echo "<script type='text/javascript'>
        $(document).ready(function(){
          Swal.fire({            
            text: '".$sess_suc_msg."',
            imageUrl: '".PUERTO."://".HOST."/imagenes/logo-04.png',
            imageWidth: 210,
            confirmButtonText: 'ACEPTAR',
            animation: true
          });          
        });
        if($('#form_cambiar').length){
          $('html, body').animate({
            scrollTop: ($('.btnPerfil').offset().top-300)
        },1000);
        }
      </script>";
}?> 
 
<?php if (isset($sess_not_msg) && !empty($sess_not_msg)){
  echo "<script type='text/javascript'>
        $(document).ready(function(){
          Swal.fire({            
            text: '".$sess_not_msg."',
            imageUrl: '".PUERTO."://".HOST."/imagenes/logo-04.png',
            imageWidth: 210,
            confirmButtonText: 'ACEPTAR',
            animation: true
          });          
        });
      </script>";
}?>  
<!--<div class="container" id="Chart_details">
    <div id='chart_div' ></div><div id='g_chart_1' style="width: auto; height: auto;"></div>
</div>-->
<script type="text/javascript">
  if($("#form_payme").length || $("#form_deposito").length){
    function disableF5(e) { console.log(e.keyCode); if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 117) e.preventDefault(); };

    $(document).ready(function(){
         $(document).on("keydown", disableF5);
         $(document).on("contextmenu", function(e){
          e.preventDefault();
         });


    });

    // $(document).on('mobileinit', function () {
    //     $.mobile.ignoreContentEnabled = true;
    // });
  }
</script>
</body>
</html>
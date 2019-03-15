  </section>

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

<?php if( !Modelo_Usuario::estaLogueado() ){ ?>

<div id="modal_registro" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <!-- <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div> -->
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>


        <div class="">
          <diw class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Nombre <i class="obligatorio">*</i></label>
                <input type="text" name="nombres_c_e" class="form-control" id="nombres_c_e">
                <div></div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Apellidos <i class="obligatorio">*</i></label>
                <input type="text" name="apellidos" class="form-control" id="apellidos">
                <div></div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Correo <i class="obligatorio">*</i></label>
                <input type="text" name="correo_c_e" class="form-control" id="correo_c_e">
                <div></div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Celular <i class="obligatorio">*</i></label>
                <input type="text" name="celular_c_e" class="form-control" id="celular_c_e">
                <div></div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Tipo documentación <i class="obligatorio">*</i></label>
                <select class="form-control" id="tipo_doc" name="tipo_doc">
                  <option value="">Seleccione una opción</option>
                  <?php 
                    foreach (TIPO_DOCUMENTO as $key => $value) {
                      if($value != 'RUC'){
                        echo "<option value='".$key."'>".$value."</option>";
                      }
                    }
                   ?>
                </select>
                <div></div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Documento <i class="obligatorio">*</i></label>
                <input type="text" name="documento_c_e" class="form-control" id="documento_c_e">
                <div></div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Seleccione área</label>
                <select class="form-control" id="area" name="area" multiple="multiple">
                  <!-- <option value="">Seleccione una opción</option> -->
                  <?php 
                    if(!empty($areas) && is_array($areas)){
                      foreach ($areas as $area) {
                        echo "<option value='".$area['id_area']."'>".$area['nombre']."</option>";
                      }
                    }
                   ?>
                </select>
              </div>
            </div>
          </diw>  
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<?php } ?>
<input type="text" hidden id="puerto_host" value="<?php echo PUERTO."://".HOST ;?>">
<div id="grafico" style="width: 100%; max-width:900px; height: 500px; visibility: hidden;"></div>
<input type="hidden" id="iso" value="<?php echo SUCURSAL_ISO; ?>">
<section id="action" class="banner_info_email">
                <div class="container">
                    <div class="row">
                        <div class="maine_action">
                            <div class="col-md-4">
                                <div class="action_item text-center">
                                    
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-12 col-xs-12">
                               <div class="content_email">
                                   <div>
                                        <span class="pre_text_email">NECESITA AYUDA? ESCRÍBANOS:</span>
                                        <i class="fa fa-envelope"></i>
                                        <a class="info_email_mic">info@micamello.com.ec</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <!--<a href="form-sug.php" style="color: white; text-decoration: underline;"><b>Recomendaciones o sugerencias <i class="fa fa-focus"></i></b></a>-->
                                    </div>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <footer id="contact" class="footer p-top-30">
                <!--<div class="action-lage"></div>-->
                <div class="container-fluid" align="center">

                    <div class="foot_mic">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="foot_div_section">
                                    <a class="legal_info_content" href="<?php echo PUERTO."://".HOST."/docs/terminos_y_condiciones".SUCURSAL_ID.".pdf";?>" target="_blank">T&eacute;rminos y Condiciones</a>| 
                                    <a class="legal_info_content" href="<?php echo PUERTO."://".HOST."/docs/politicas_de_privacidad".SUCURSAL_ID.".pdf";?>" target="_blank">Pol&iacute;ticas de Privacidad</a>|
                                    <a class="legal_info_content" href="<?php echo PUERTO."://".HOST."/docs/politicas_de_cookies".".pdf";?>" target="_blank">Pol&iacute;ticas de Cookies</a>|                                    
            <a class="legal_info_content" href="http://blog.micamello.com.ec" target="blanked">Blog</a>|

                                    <a class="legal_info_content" href="<?php echo PUERTO."://".HOST;?>/recomendacion/">Recomendaciones</a>
                                    
                                   
                                </div><!-- End off widget item -->
                            </div><!-- End off col-md-3 -->
                            <div class="col-md-6">
                            <div class="foot_div_section">
                              <div class="widget_item widget_latest sm-m-top-50" align="center">
                                <div class="row">
                                  <div class="form-inline">
                                    <?php foreach(Modelo_Sucursal::obtieneListado() as $sucursal){ ?>  
                                      <img src="<?php echo PUERTO."://".HOST;?>/imagenes/sucursal/iconos/<?php echo $sucursal["id_sucursal"];?>.<?php echo $sucursal["extensionicono"];?>" class="country_mic"> 
                                      <span class="text_icons_footer"><?php echo utf8_encode($sucursal["nombre_abr"]);?></span>
                                    <?php }?>                                                                                
                                    <span class="separate_social_country">|</span>
                                    
                                    <span class="text_icons_footer">Siguenos en:</span>
                                    <a href="https://es-la.facebook.com/MiCamello.com.ec/" target="_blank">
                                      <img src="<?php echo PUERTO."://".HOST;?>/imagenes/redes/face.png" class="social_mic">
                                    </a>                                                                       
                                    <a href="https://twitter.com/MiCamelloec" target="_blank">
                                      <img src="<?php echo PUERTO."://".HOST;?>/imagenes/redes/tw.png" class="social_mic">
                                    </a>
                                    <a href="https://www.instagram.com/micamelloec/" target="_blank">
                                      <img src="<?php echo PUERTO."://".HOST;?>/imagenes/redes/ins.png" class="social_mic">
                                    </a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
     
</footer> 


<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/jquery-3.0.0.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/bootstrap.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/main.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/notificaciones.js" type="text/javascript"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/cookies.js" type="text/javascript"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript" src="<?php echo PUERTO."://".HOST;?>/js/loader.js"></script> 
<script src="<?php echo PUERTO."://".HOST;?>/js/sweetalert.min.js"></script>
<?php
if (isset($template_js) && is_array($template_js)){
  foreach($template_js as $file_js){
    echo '<script type="text/javascript" src="'.PUERTO.'://'.HOST.'/js/'.$file_js.'.js"></script>';
  }  
}
?>
<script type="text/javascript">
  $('#area').multiple_select();
</script>
</body>
</html>
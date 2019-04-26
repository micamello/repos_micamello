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
        <button type="button" class="close" id="closeModalRegistro" data-dismiss="modal">&times;</button>

        <form action="<?php echo PUERTO."://".HOST;?>/registro/" method="post" id="form_register">
          <input type="hidden" name="tipo_usuario" id="tipo_usuario">
          <input type="hidden" name="tipo_documentacion" id="tipo_documentacion">
          <input type="hidden" name="formularioRegistro" id="formularioRegistro" value="1">
          <!-- <input type="hidden" name="puerto_host" id="puerto_host" value="<?php echo PUERTO."://".HOST ;?>"> -->
          <div class="">
            <diw class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Nombre <i class="obligatorio">*</i></label>
                  <input type="text" name="nombresCandEmp" class="form-control" id="nombresCandEmp">
                  <div></div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Apellidos <i class="obligatorio">*</i></label>
                  <input type="text" name="apellidosCand" class="form-control" id="apellidosCand">
                  <div></div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Sector industrial <i class="obligatorio">*</i></label>
                  <select id="sectorind" name="sectorind" class="form-control">
                    <option value="" selected="selected" disabled="disabled">Seleccione una opción</option>
                    <?php 
                      if(!empty($arrsectorind)){
                        foreach($arrsectorind as $sectorind){
                          echo "<option value='".$sectorind['id_sectorindustrial']."'>".$sectorind['descripcion']."</option>";
                        }
                      }
                    ?>
                  </select>
                  <div></div>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>Correo <i class="obligatorio">*</i></label>
                  <input type="text" name="correoCandEmp" class="form-control" id="correoCandEmp">
                  <div></div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Celular <i class="obligatorio">*</i></label>
                  <input type="text" name="celularCandEmp" class="form-control" id="celularCandEmp">
                  <div></div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Tipo documentación <i class="obligatorio">*</i></label>
                  <select class="form-control" id="tipoDoc" name="tipoDoc">
                    <option value="">Seleccione una opción</option>
                    <?php 
                      foreach (TIPO_DOCUMENTO as $key => $value) {
                        if($key != 1){
                          echo "<option value='".$key."'>".utf8_encode($value)."</option>";
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
                  <input type="text" name="documentoCandEmp" class="form-control" id="documentoCandEmp">
                  <div></div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Fecha de nacimiento: </label>
                  <input type="text" data-field="date" class="form-control" name="fechaNac" id="fechaNac">
                  <div id="fechaShow"></div>
                  <div id="errorFechaUsuario"></div>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="form-group">
                  <label>Género: </label>
                  <select class="form-control" name="generoUsuario" id="generoUsuario">
                    <option value="" selected="selected" disabled="disabled">Seleccione una opción</option>
                    <?php 
                      if(!empty($genero)){
                        foreach ($genero as $gen) {
                          echo "<option value='".$gen['id_genero']."'>".$gen['descripcion']."</option>";
                        }
                      }
                    ?>
                  </select>
                  <div></div>
                </div>
              </div>

              <!-- contraseña -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Contraseña <i class="obligatorio">*</i></label>
                  <div class="inner-addon right-addon">
                    <i class="fa fa-eye reveal_content" title="Mostrar contraseña"></i>
                    <input type="password" class="form-control" name="password_1" id="password_1">
                    <div></div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Repita contraseña <i class="obligatorio">*</i></label>
                  <div class="inner-addon right-addon">
                    <i class="fa fa-eye reveal_content"></i>
                    <input type="password" class="form-control" name="password_2" id="password_2">
                    <div></div>
                  </div>
                </div>
              </div>

            <div class="col-md-12" id="datosContEmp">
              <hr>
              <label>Datos de contacto</label>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Nombres <i class="obligatorio">*</i></label>
                <input type="text" class="form-control" name="nombreConEmp" id="nombreConEmp">
                <div></div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Apellidos <i class="obligatorio">*</i></label>
                <input type="text" class="form-control" name="apellidoConEmp" id="apellidoConEmp">
                <div></div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Celular <i class="obligatorio">*</i></label>
                <input type="text" class="form-control" name="tel1ConEmp" id="tel1ConEmp">
                <div></div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Convencional (opcional)</label>
                <input type="text" class="form-control" name="tel2ConEmp" id="tel2ConEmp">
                <div></div>
              </div>
            </div>

            <div class="form-group check_box">
                <div class="col-md-12 text-center">
                  <div class="checkbox">
                    <label><input type="checkbox" class="terminosCond" name="terminosCond" id="terminosCond"> He le&iacute;do y acepto las <a href="<?php echo PUERTO."://".HOST."/docs/politicas_de_privacidad1.pdf";?>" target="_blank">pol&iacute;ticas de privacidad</a> y <a href="<?php echo PUERTO."://".HOST."/docs/terminos_y_condiciones1.pdf";?>" target="_blank">t&eacute;rminos y condiciones</a></label>
                    <div></div>
                  </div>
                </div>
              </div>

              <div class="col-md-12">
                <input type="submit" name="registro_form_mic" class="btn btn-success" value="Registrarse">
              </div>

            </diw>  
          </div>
        </form>

        <div class="row" id="socialReg">
          <div class="col-md-12">
            <hr>
            <span class="textoInHr">O accede con: </span>
          </div>
          <div class="col-md-4 col-sm-4 col-xs-12 col-sm-offset-4 col-md-offset-4">
            <div class="col-md-3 col-sm-3 col-xs-3">
              <div class="">
                <a onclick="window.location = '<?php echo $social['fb']; ?>'" style="cursor:pointer;"> 
                  <i class="fa fa-facebook-official fa-2x fbClass"></i></div>
                </a>
            </div>

            <div class="col-md-3 col-sm-3 col-xs-3">
              <div class="">
                <a onclick="window.location = '<?php echo $social['tw']; ?>'" style="cursor:pointer;">
                  <i class="fa fa-twitter fa-2x twClass"></i></a>
              </div>
            </div>
            
            <div class="col-md-3 col-sm-3 col-xs-3">
              <div class="">
                <a onclick="window.location = '<?php echo $social['lk']; ?>'" style="cursor:pointer;">
                  <i class="fa fa-linkedin fa-2x lkClass"></i></a>
              </div>
            </div>

            <div class="col-md-3 col-sm-3 col-xs-3">
              <div class="">
                <a onclick="window.location = '<?php echo $social['gg']; ?>'" style="cursor:pointer;">
                  <i class="fa fa-google fa-2x ggClass"></i>
                </a>
              </div>  
            </div>

          </div>
        </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div> -->
    </div>

  </div>
</div>

<div class="modal fade" id="modal_select" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">Áreas seleccionadas<button type="button" class="close" data-dismiss="modal">&times;</button></div>
      <div class="modal-body" style="overflow: scroll">
        <!-- <div class="col-md-12" id="modalmodal"> -->
          
        <!-- </div> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div> 
    </div>
  </div>
</div>

<?php } ?>
<input type="text" hidden id="puerto_host" value="<?php echo PUERTO."://".HOST ;?>">
<!--<div id="grafico" style="width: 100%; max-width:900px; height: 500px; visibility: hidden;"></div>-->
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
<!-- modal_seleccionados -->
<div class="modal fade" id="modal_select" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">Áreas seleccionadas<button type="button" class="close" data-dismiss="modal">&times;</button></div>
        <div class="modal-body" style="overflow: scroll;">
          <!-- <div class="col-md-12" id="modalmodal"> -->
            
          <!-- </div> -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

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
} ?>
    
</body>
</html>
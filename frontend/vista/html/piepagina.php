  </section>

<div class="modal fade" id="alert_descarga" tabindex="-1" role="dialog" aria-labelledby="alert_descarga" aria-hidden="true">
  <div class="modal-dialog" role="document">    
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo_noti"><b>Notificaci&oacute;n</b></h5>   
      </div>
      <div class="modal-body">
        <h5 id="mensaje"></h5>
      </div>
      <div class="modal-footer" style="margin-top: 0px;">
        <button type="button" id="btn_cancelar" class="btn btn-md btn-danger" data-dismiss="modal">Cancelar</button>
        <a href="#" id="btn_modal" class="btn btn-md btn-success">Ok</a>
      </div>
    </div>    
  </div>
</div>

<?php if( !Modelo_Usuario::estaLogueado() ){ ?>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" data-backdrop="static" style="z-index:9999">
  <div id="modal-size" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <div class="modal-body">

        <!--Formulario de registro usuario - candidato-->
        <div class="col-md-12" align="center">
          <!-- <span class="text-center">Accede con: </span>
          <br><br> -->
          
        </div>

        


        <!-- <br><br> -->
        <form action = "<?php echo PUERTO."://".HOST;?>/registro/" method = "post" id="form_register">

         <div class="row">  
          <input type="hidden" name="register_form" id="register_form" value="1">
          <div class="col-md-6">
              <div class="form-group" id="group_nombre">
                <p class="text-center text_form" id="label_nombres">Nombres&nbsp;<i class="requerido">*</i></p><div id="nombre_error" class="help-block with-errors"></div>
                <input type="text" name="name_user" id="name_user" placeholder="Ejemplo: Carlos Pedro" class="form-control">
              </div>
          </div>
          <div class="col-md-6" id="apellido_group">
              <div class="form-group" id="apellido_group">
                <p class="text-center text_form">Apellidos&nbsp;<i class="requerido">*</i></p><div id="apell_error" class="help-block with-errors"></div>
                <input type="text" name="apell_user" id="apell_user" placeholder="Ejemplo: Ortiz Zambrano" class="form-control">
              </div>
          </div>

          <div class="col-md-6" id="correo_group">
            <p id="correo_e" class="twin_reg"></p>
            <div class="form-group" id="correo_group">
              <p class="text-center text_form">Correo&nbsp;<i class="requerido">*</i></p><div id="correo_error" class="help-block with-errors"></div>
              <input id="correo" type="email" name="correo" placeholder="Ejemplo: camello@gmail.com" class="form-control" aria-describedby="correoHelp">
            </div>
          </div>    

           <div class="col-md-6">
             <div class="form-group" id="numero_group">
               <p for="numero_cand" class="text-center text_form">Celular&nbsp;<i class="requerido">*</i></p><div class="help-block with-errors" id="numero_error"></div>
               <input type="text" class="form-control" name="numero_cand" id="numero_cand">
             </div>
           </div>

          <div class="col-md-6" id="group_select_tipo_doc">
            <div class="form-group" id="seleccione_group">
              <p class="text-center text_form">Seleccione tipo documentación</p><div id="seleccione_error" class="help-block with-errors"></div>
              <select class="form-control" id="documentacion" name="tipo_doc">
                <option selected="" value="" disabled>Seleccione tipo identificación</option>
                <?php 
                  foreach(DOCUMENTACION as $key => $doc)
                    echo "<option value='".$key."'>".utf8_encode($doc)."</option>";
                 ?>
              </select>
            </div>
          </div> 

           <div class="col-md-6">
            <p id="dni_e" class="twin_reg"></p>
                  <!-- <div class="group"> -->
                    <div class="form-group" id="dni_group">
                      <p class="text-center text_form" id="dni_text"></p><div class="help-block with-errors" id="dni_error"></div>
                      <input id="dni" type="text" name="cedula" class="form-control">
                    </div>
                  <!-- </div> -->
              </div>

              <input type="hidden" name="ruc" value="1">

              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6" id="area_group">
                    <div class="form-group">
                      <div class="">
                        
                          <div class="panel panel-default">
                            <div class="panel-head-select">Seleccione áreas (Máx: 3)
                                  <label class="num_sel" style="float: right; color: black; padding: 0px 5px 0px 5px;">
                                      <label id="numero1">0</label> de 3
                                  </label>
                              </div>
                              <div class="panel-body">
                                <div class="row" id="seleccionados1">
                                </div>
                              </div>
                              <div id="area_error" class="help-block with-errors"></div>
                              <select class="form-control" name="area_select[]" id="area_select" multiple>
                                <!-- <option value="" selected disabled>Seleccione un área</option> -->
                                <?php 
                                  if (!empty($arrarea)){
                                      foreach($arrarea as $area){ ?>
                                          <option value="<?php echo $area['id_area'] ?>"><?php echo utf8_encode($area['nombre']); ?></option>
                                      <?php }
                                  } ?>
                              </select>
                            </div>
                        </div>
                    </div>
                  </div>


                  <div class="col-md-6" id="nivel_group">
                    
                    <div class="form-group">
                      <div class="">
                          
                          <div class="panel panel-default">
                            <div class="panel-head-select">Seleccione nivel de interés (Máx: 2)
                                  <label class="num_sel" style="float: right; color: black; padding: 0px 5px 0px 5px;">
                                      <label id="numero2">0</label> de 2
                                  </label>
                              </div>
                              <div class="panel-body">
                                <div class="row" id="seleccionados2">
                                </div>
                              </div>
                            <div id="nivel_error" class="help-block with-errors"></div>
                            <select class="form-control" name="nivel_interes[]" id="nivel_interes" multiple>
                              <!-- <option value="" selected disabled>Seleccione un área</option> -->
                              <?php 
                                if (!empty($intereses)){
                                    foreach($intereses as $interes){ ?>
                                        <option value="<?php echo $interes['id_nivelInteres'] ?>"><?php echo utf8_encode($interes['descripcion']); ?></option>
                                    <?php }
                                } ?>
                            </select>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group" id="password_group">
                  <p class="text-center text_form">Contraseña&nbsp;<i class="requerido">*</i></p><div id="password_error" class="help-block with-errors"></div>
                  <div class="input-group">
                    <span class="input-group-addon show_hidden" onclick="pass_reveal(this);"><i class="fa fa-eye"></i></span>
                    <input title="Letras y números, mínimo 8 caracteres" id="password" name="password" type="password" class="form-control">
                  </div>
                </div>
            </div>
            <div class="col-md-6">
              <div class="form-group" id="password_group_two">
                  <p class="text-center text_form">Confirmar Contraseña&nbsp;<i class="requerido">*</i></p><div id="password_error_two" class="help-block with-errors"></div>
                  <div class="input-group">
                    <span class="input-group-addon show_hidden" onclick="pass_reveal(this);"><i class="fa fa-eye"></i></span>
                    <input id="password_two" name="password_two" type="password" placeholder="Verificar contraseña" class="form-control">
                </div>
              </div>
            </div>

            <div class="col-md-12" id="contact_company_section">
              <hr>
              <h6 class="text-center">Datos de contacto</h6>
            </div>

            <!-- Empresas contacto -->
            <div class="col-md-6" id="group_nombre_contact">
              <div class="form-group" id="nombre_contact_group">
                <p class="text-center text_form">Nombres&nbsp;<i class="requerido">*</i></p><div id="nombre_contact_error" class="help-block with-errors"></div>
                <input type="text" name="nombre_contact" id="nombre_contact" placeholder="Ejemplo: Juan David" class="form-control">
              </div>
            </div>  

            <div class="col-md-6" id="group_apell_contact">
              <div class="form-group" id="apellido_contact_group">
                <p class="text-center text_form">Apellidos&nbsp;<i class="requerido">*</i></p><div id="apellido_contact_error" class="help-block with-errors"></div>
                <input type="text" name="apellido_contact" id="apellido_contact" placeholder="Ejemplo: Ortíz Zambrano" class="form-control">
              </div>
            </div> 

            <div class="col-md-6" id="group_num1_contact">
              <div class="form-group" id="tel_one_contact_group">
                <p class="text-center text_form">Teléfono 1&nbsp;<i class="requerido">*</i></p><div id="tel_one_contact_error" class="help-block with-errors"></div>
                <input type="text" name="tel_one_contact" id="tel_one_contact" class="form-control">
              </div>
            </div> 

            <div class="col-md-6" id="group_num2_contact">
              <div class="form-group" id="tel_two_contact_group">
                <p class="text-center text_form">Teléfono 2 (opcional):</p><div id="tel_two_contact_error" class="help-block with-errors"></div>
                <input type="text" name="tel_two_contact" id="tel_two_contact" class="form-control">
              </div>
            </div> 



              <div class="row">
                
              </div>
              <div class="conditions_components">
                <div class="col-md-12" align="left">
                  <div class="form-group" id="term_cond_group"> 
                    <label class="form-text">
                    <input type="checkbox" class="flipswitch_check" name="term_cond" id="term_cond" value="1"><label for="term_cond" class="label_term_cond">He leido y acepto los <a href="<?php echo PUERTO."://".HOST."/docs/terminos_y_condiciones".SUCURSAL_ID.".pdf";?>" target="blank"> términos y condiciones </a> y la <a href="<?php echo PUERTO."://".HOST."/docs/politicas_de_privacidad".SUCURSAL_ID.".pdf";?>" target="blank">Política de Privacidad</a></label><div id="term_cond_error" class="help-block with-errors"></div></label>
                  </div>
                </div>
                <input type="hidden" name="conf_datos" id="conf_datos" value="1">
              </div>

              <input type="hidden" id="tipo_usuario" name="tipo_usuario" value="">

              <div class="row">
                <div class="text-center">
                  <input id="button_register" type="submit" name="btnusu" class="btn btn-primary" value="Crear Cuenta">  
                </div> 
              </div>
            </div>

        </form>
        <!--Formulario de registro usuario - candidato-->

        <!-- <hr> -->
        
        <div class="row" id="social_reg">
          <br>
          <div class="col-md-12" align="center">
            <p class="center-text-line" style="font-size: 17px;">ó registrate con: </p>
            <!-- <div align="center" class="col-md-12"> -->
              <div class="col-xs-8 col-xs-offset-2 col-md-1 col-md-offset-4 col-sm-1 col-sm-offset-4" align="">
              <a class="socialbutton fb" onclick="window.location = '<?php echo $social['fb']; ?>'"><i class="fa fa-facebook-square"></i><span class="social_text"> Facebook</span></a>
              </div>

              <div class="col-md-1 col-sm-offset-0 col-sm-1 col-xs-8 col-xs-offset-2" align="">
              <!-- <div class="col-xs-8 col-xs-offset-2 col-md-2 col-md-offset-3 col-sm-1 col-sm-offset-4" align=""> -->
                <a class="socialbutton tw" onclick="window.location = '<?php echo $social['tw'] ?>'"><i class="fa fa-twitter-square"></i><span class="social_text"> Twitter</span></a>
              </div>

              <div class="col-md-1 col-sm-offset-0 col-sm-1 col-xs-8 col-xs-offset-2" align="">
                <a class="socialbutton google" onclick="window.location = '<?php echo $social['gg'] ?>'"><i class="fa fa-google-plus-square"></i><span class="social_text"> Google</span></a>
              </div>

              <div class="col-md-1 col-sm-offset-0 col-sm-1 col-xs-8 col-xs-offset-2" align="">
                <a class="socialbutton lkin" onclick="window.location = '<?php echo $social['lk'] ?>'"><i class="fa fa-linkedin-square"></i><span class="social_text"> LinkeIn</span></a>
              </div>
            <!-- </div> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<input type="text" hidden id="puerto_host" value="<?php echo PUERTO."://".HOST ;?>">
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

<script type="text/javascript" src="<?php echo PUERTO."://".HOST;?>/js/loader.js"></script> 
<script src="<?php echo PUERTO."://".HOST;?>/js/sweetalert.min.js"></script>
<?php
if (isset($template_js) && is_array($template_js)){
  foreach($template_js as $file_js){
    echo '<script type="text/javascript" src="'.PUERTO.'://'.HOST.'/js/'.$file_js.'.js"></script>';
  }  
}
?>
</body>
</html>
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
        <button type="button" class="btn btn-md btn-primary" data-dismiss="modal">OK</button>
      </div>
    </div>    
  </div>
</div>

<?php if( !Modelo_Usuario::estaLogueado() ){ ?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" style="z-index:9999">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!--<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">REGISTRE SU CUENTA 
        <i class="fa fa-user" style="color: #00a885;padding: 8px;font-size: 25px;"></i></h4>
      </div>-->
      
      <div class="modal-body">

        <!--Formulario de registro usuario - candidato-->
        <div class="col-md-12" align="center">
          <!-- <span class="text-center">Accede con: </span>
          <br><br> -->
          
        </div>

        <!-- <hr> -->
        
        <!-- <div class="col-md-12" align="center">
          <p class="center-text-line" style="font-size: 17px;">ó</p>
          <span class="text-center" style="color: grey; font-size: 15px;">o registrate con tus datos: </span><br><br>
        </div> -->


        <!-- <br><br> -->
        <form action = "<?php echo PUERTO."://".HOST;?>/registro/" method = "post" id="form_register">

         <div class="row">

          <div class="col-md-6" id="correo_group">
            <div class="form-group">
              <label class="text-center">Correo</label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
              <input id="correo" type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Ingrese un correo electrónico válido' : '')" name="correo" placeholder="Ejemplo: camello@gmail.com" class="form-control" aria-describedby="correoHelp" required>
            </div>
          </div>   
          <input type="hidden" name="register_form" id="register_form" value="1">
          <div class="col-md-6">
              <div class="form-group">
                <label class="text-center">Nombres</label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
                <input type="text" name="name_user" id="name_user" pattern="[a-z A-ZñÑáéíóúÁÉÍÓÚ]+" placeholder="Ejemplo: Carlos Pedro" class="form-control" required>
              </div>
          </div>
          <div class="col-md-6" id="apellido_group">
              <div class="form-group">
                <label class="text-center">Apellidos</label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
                <input type="text" name="apell_user" id="apell_user" pattern='[a-z A-ZñÑáéíóúÁÉÍÓÚ]+' placeholder="Ejemplo: Ortiz Zambrano" class="form-control">
              </div>
          </div>        

           <div class="col-md-6">
             <div class="form-group">

               <label for="numero_cand">Celular:</label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors" id="error_custom_cel"></div>
               <input type="text" class="form-control" name="numero_cand" id="numero_cand" required onkeydown="return validaNumeros(event);">
             </div>
           </div> 

           <div class="col-md-6">
                  <div class="group">
                    <div class="form-group">
                      <label class="text-center" id="dni_text"></label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors" id="error_custom_dni"></div>
                      <input id="dni" type="text" name="cedula" class="form-control" required>
                    </div>
                  </div>
              </div>

              <div class="col-md-12" id="area_group">
                <div class="form-group">
                  <div class="opcionesSeleccionados">
                    <div class="row" id="seleccionados">
                      <p style="font-size: 11px; margin-bottom: 0px;">Opciones seleccionadas</p>
                      <!-- <?php echo $optiones; ?> -->
                    </div>
                      <div class="help-block with-errors"></div>
                      <label class="form-text">Seleccione área:</label><span class="text-help">(max. 3)&nbsp;<i class="requerido">*</i></span>
                      <select class="form-control" name="area_select[]" id="area_select" data-selectr-opts='{"maxSelection": 3 }' multiple>
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

              <div class="col-md-12" id="nivel_group">
                <div class="form-group">
                  <div class="opcionesSeleccionados">
                    <div class="row" id="seleccionados1">
                      <p style="font-size: 11px; margin-bottom: 0px;">Opciones seleccionadas</p>
                      <!-- <?php echo $optiones; ?> -->
                    </div>
                      <div class="help-block with-errors"></div>
                      <label class="form-text">Seleccione nivel de interés:</label><span>(max. 2)&nbsp;<i class="requerido">*</i></span>
                      <select class="form-control" name="nivel_interes[]" id="nivel_interes" data-selectr-opts='{"maxSelection": 2 }' multiple>
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

              <div class="col-md-6">
                <div class="form-group">
                  <label class="text-center">Contraseña</label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
                  <div class="input-group">
                    <span class="input-group-addon show_hidden" onclick="pass_reveal(this);"><i class="fa fa-eye"></i></span>
                    <input title="Letras y números, mínimo 8 caracteres" id="password" name="password" type="password" pattern="^(?=(?:.*\d))(?=(?:.*[a-zA-Z]))\S{8,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); if(this.checkValidity()) form.password_two.pattern = this.value;" class="form-control" required>
                  </div>
                </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  <label class="text-center">Confirmar Contraseña</label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
                  <div class="input-group">
                    <span class="input-group-addon show_hidden" onclick="pass_reveal(this);"><i class="fa fa-eye"></i></span>
                    <input id="password_two" name="password_two" type="password" pattern="^(?=(?:.*\d))(?=(?:.*[a-zA-Z]))\S{8,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Ingrese la misma contraseña' : '');" placeholder="Verificar contraseña" class="form-control" required>
                </div>
              </div>
            </div>

            <div class="col-md-12" id="contact_company_section">
              <hr>
              <h6 class="text-center">Datos de contacto</h6>
            </div>

            <!-- Empresas contacto -->
            <div class="col-md-6" id="group_nombre_contact">
              <div class="form-group">
                <label class="text-center">Nombres</label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
                <input type="text" name="nombre_contact" id="nombre_contact" pattern='[a-z A-ZñÑáéíóúÁÉÍÓÚ]+' placeholder="Ejemplo: Juan David" class="form-control">
              </div>
            </div>  

            <div class="col-md-6" id="group_apell_contact">
              <div class="form-group">
                <label class="text-center">Apellidos</label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
                <input type="text" name="apellido_contact" id="apellido_contact" pattern='[a-z A-ZñÑáéíóúÁÉÍÓÚ]+' placeholder="Ejemplo: Ortíz Zambrano" class="form-control">
              </div>
            </div> 

            <div class="col-md-6" id="group_num1_contact">
              <div class="form-group">
                <label class="text-center">Teléfono 1</label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
                <input type="text" name="tel_one_contact" id="tel_one_contact" class="form-control" onkeydown="return validaNumeros(event);">
              </div>
            </div> 

            <div class="col-md-6" id="group_num2_contact">
              <div class="form-group">
                <label class="text-center">Teléfono 2 (opcional):</label><div class="help-block with-errors"></div>
                <input type="text" name="tel_two_contact" id="tel_two_contact" class="form-control" onkeydown="return validaNumeros(event);">
              </div>
            </div> 



              <div class="row">
                
              </div>
              <div class="conditions_components">
                <div class="" align="left">
                  <label class="form-text"><div class="help-block with-errors"></div>
                    <input id="box-1" type="checkbox" name="term_cond" id="term_cond" value="1" required><label for="box-1">He leido y acepto los <a href="<?php echo PUERTO."://".HOST."/docs/terminos_y_condiciones".SUCURSAL_ID.".pdf";?>" target="blank"> términos y condiciones </a> y la <a href="<?php echo PUERTO."://".HOST."/docs/politicas_de_privacidad".SUCURSAL_ID.".pdf";?>" target="blank">Política de Privacidad</a></label></label>
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
      </div>
    </div>
  </div>
</div>
<?php } ?>
<input type="text" hidden id="puerto_host" value="<?php echo PUERTO."://".HOST ;?>">
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
                                      <a href="<?php echo PUERTO."://".$sucursal["dominio"];?>/"><img src="<?php echo PUERTO."://".HOST;?>/imagenes/sucursal/iconos/<?php echo $sucursal["id_sucursal"];?>.<?php echo $sucursal["extensionicono"];?>" class="country_mic"> 
                                      <span class="text_icons_footer"><?php echo utf8_encode($sucursal["nombre_abr"]);?></span></a>
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
<!--<script src="<?php echo PUERTO."://".HOST;?>/js/notificaciones.js" type="text/javascript"></script>-->
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
<!--mensajes de error y exito-->

<?php if (isset($sess_err_msg) && !empty($sess_err_msg)){?>
  <div align="center" id="alerta" style="display:" class="alert alert-danger alert-dismissible">
    <?php echo $sess_err_msg;?>
  </div>  
<?php }?>

<?php if (isset($sess_suc_msg) && !empty($sess_suc_msg)){?>
  <div align="center" id="alerta" style="display:" class="alert alert-success alert-dismissible">
    <?php echo $sess_suc_msg;?>
  </div>  
<?php } ?>


<?php if( !Modelo_Usuario::estaLogueado() ){ ?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" style="z-index:9999">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 97px;">
      <!--<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">REGISTRE SU CUENTA 
        <i class="fa fa-user" style="color: #00a885;padding: 8px;font-size: 25px;"></i></h4>
      </div>-->
      
      <div class="modal-body">

        <!--Formulario de registro usuario - candidato-->
        <div class="col-md-12" align="center">
          <span class="text-center">Accede con: </span>
          <br><br>
          
          <!--<a id="facebook_login" href="<?php //echo $loginUrl ?>">
            <i class="fab fa-facebook" style="font-size: 40px"></i>
          </a>

           <a id="google_login" onclick="window.location = '<?php //echo $gloginURL ?>';">
            <i class="fab fa-google-plus-square" style="font-size: 40px; color:#a94442"></i>
          </a>

          <a id="instagram_login" onclick="javascript: window.location = '<?php //echo $Instagram->getLoginURL() ?>';">
            <i class="fab fa-instagram" style="font-size: 40px; color:#31708f"></i>
          </a>-->
        </div>

        <hr>
        
        <div class="col-md-12" align="center">
          <p class="center-text-line" style="font-size: 17px;">ó</p>
          <span class="text-center" style="color: grey; font-size: 15px;">o registrate con tus datos: </span><br><br>
        </div>


        <br><br>
        <form action = "<?php echo PUERTO."://".HOST;?>/registro/" method = "post" id="form_candidato">

         <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="text-center">Usuario:</label><div class="help-block with-errors"></div>
              <input id="username" type="text" name="username" placeholder="Ejemplo: camello205487" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$" class="form-control" aria-describedby="usernameHelp" required>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label class="text-center">Correo:</label><div class="help-block with-errors"></div>
              <input id="correo" type="email" name="correo" placeholder="Ejemplo: camello@gmail.com" class="form-control" aria-describedby="correoHelp" required>
            </div>
          </div>   
          <input type="hidden" name="register_form" id="register_form" value="1">
          <div class="col-md-6">
              <div class="form-group">
                <label class="text-center">Nombres:</label><div class="help-block with-errors"></div>
                <input type="text" name="name_user" id="name_user" pattern="[a-z A-ZñÑáéíóúÁÉÍÓÚ]+" placeholder="Ejemplo: Carlos Pedro" class="form-control" required>
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                <label class="text-center">Apellidos:</label><div class="help-block with-errors"></div>
                <input type="text" name="apell_user" id="apell_user" pattern='[a-z A-ZñÑáéíóúÁÉÍÓÚ]+' placeholder="Ejemplo: Ortiz Zambrano" class="form-control" required>
              </div>
          </div>       

          <div class="col-md-6">
              <div class="form-group">
                <label class="text-center">Contraseña:</label><div class="help-block with-errors"></div>
                <input id="password" name="password" type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Debe contener letra, una mayúscula mínimo y numeros' : ''); if(this.checkValidity()) form.password_two.pattern = this.value;" placeholder="Ejemplo: me198454EjgE" class="form-control" required data-toggle="password">
              </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="text-center">Confirmar Contraseña:</label><div class="help-block with-errors"></div>
              <input id="password_two" name="password_two" type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Por favor, ingrese la misma contraseña' : '');" placeholder="Verificar contraseña" class="form-control" required data-toggle="password">
            </div>
          </div>    

           <div class="col-md-6">
             <div class="form-group">
               <label for="numero_cand">Celular: </label><div class="help-block with-errors"></div>
               <input type="text" class="form-control" name="numero_cand" id="numero_cand" onclick="numero_validate(this);" required>
             </div>
           </div> 

           <div class="col-md-6">
                  <div class="group">
                    <div class="form-group">
                      <label class="text-center">Cédula / Pasaporte:</label><div class="help-block with-errors"></div>
                      <input id="dni" type="text" name="cedula" minlength="10" maxlength="15" onkeypress="" class="form-control" aria-describedby="dniHelp" required>
                    </div>
                  </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-text">Seleccione área: </label><span class="text-help">(max. 3)</span><div class="help-block with-errors"></div>
                  <select class="form-control" name="area_select[]" id="area_select" data-selectr-opts='{"maxSelection": 3 }' multiple required>
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

              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-text">Seleccione nivel de interés: </label><span>(max. 2)</span><div class="help-block with-errors"></div>
                  <select class="form-control" name="nivel_interes[]" id="nivel_interes"data-selectr-opts='{"maxSelection": 2 }' multiple required>
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


              <div class="conditions_components">
                <div class="" align="left">
                  <label class="form-text"><input type="checkbox" name="term_cond" id="term_cond" value="1" required><a href="<?php echo PUERTO."://".HOST;?>/docs/terminos_y_condiciones.pdf" target="blank">Aceptar términos y condiciones </a></label>
                </div>
                <div class="" align="left">
                  <label class="form-text"><input type="checkbox" name="term_data" id="term_data" value="1" required><a href="<?php echo PUERTO."://".HOST;?>/docs/terminos_y_condiciones.pdf" target="blank">Aceptar términos de confidencialidad de datos </a></label>
                </div>
              </div>

              <div class="row">
                <div class="text-center">
                  <input id="button-save" type="submit" name="btnusu" class="btn btn-primary" value="Crear Cuenta">  
                </div> 
              </div>
            </div>

        </form>
        <!--Formulario de registro usuario - candidato-->


        <div class="row">
          <div class="col-md-12"><br>
            <p class="text-center"><strong>¿Ya tienes cuenta? </strong><a href="<?php echo PUERTO."://".HOST;?>/login/">Iniciar sesión</a></p> 
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- modal empresa -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" style="z-index:9999">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 97px;">
              <form role="form" id="form_empresa" name="formulario2" method="post">

      <!--<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">REGISTRE SU EMPRESA 
        <i class="fa fa-user" style="color: #00a885;padding: 8px;font-size: 25px;"></i></h4>
      </div>-->
      <div class="modal-body">
        <div class="col-md-6">
            <div class="form-group">
              <label class="form-text">Usuario:</label><div class="help-block with-errors"></div>
              <input type="text" id="emp_username" name="emp_username" placeholder="Ejemplo: camello205487" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$" class="form-control" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
              <label class="form-text">Correo:</label><div class="help-block with-errors"></div>
              <input type="email" id="emp_correo" name="emp_correo" placeholder="carlosp@gmail.com" class="form-control" required>
            </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
              <label class="text-center">seleccione provincia:</label><div class="help-block with-errors"></div>
              <select id="provincia_emp" class="form-control" name="provincia_emp" required>
                <option value="" selected disabled>Seleccione provincia</option>
          <!--SQL EXTRACT ALL PROVINCES-->
          <?php foreach($arrprovincia as $provincia) { ?>
              <option value="<?php echo $provincia['nombre'] ?>" id="<?php echo $provincia['id_pro'] ?>"><?php echo $provincia['nombre']; ?></option>
          <?php } ?>
          <!--SQL EXTRACT ALL PROVINCES-->
            </select>
           </div>
         </div>

         <div class="col-md-6">
          <div class="form-group">
              <label class="text-center">seleccione ciudad:</label><div class="help-block with-errors"></div>
              <select id="ciudad_emp" class="form-control" name="ciudad_emp" required>
                <option value="">Selecciona ciudad primero</option>
          <!--SQL EXTRACT ALL PROVINCES-->
          <!--SQL EXTRACT ALL PROVINCES-->
            </select>
           </div>
         </div>  


        <div class="col-md-6">
            <div class="form-group">
              <label class="form-text">Contraseña:</label><div class="help-block with-errors"></div>
              <input id="password" name="emp_password" type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Debe contener letra, una mayúscula mínimo y numeros' : ''); if(this.checkValidity()) form.password_two.pattern = this.value;" placeholder="Formato: me198454EjgE" class="form-control" required data-toggle="password">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
              <label class="form-text">Confirmar Contraseña:</label><div class="help-block with-errors"></div>
              <input id="password_two" name="password_two" type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Por favor, ingrese la misma contraseña' : '');" placeholder="Verificar contraseña" class="form-control" required data-toggle="password">
            </div>
        </div>   
       <div class="col-md-6">
            <div class="form-group">
              <label class="form-text">RUC:</label><div class="help-block with-errors"></div>
              <input id="dni" type="text" name="emp_cedula" minlength="10" maxlength="15" onkeypress="" class="form-control" aria-describedby="dniHelp" required>
            </div>
        </div>
       <div class="col-md-6">
            <div class="form-group">
              <label class="form-text">Nombre de Empresa:</label><div class="help-block with-errors"></div>
              <input type="text" id="emp_nempresa" name="emp_nempresa"  class="form-control" required>
            </div>
        </div>        

       <div class="col-md-6">
            <div class="form-group">
              <label class="form-text">Teléfono:</label><div class="help-block with-errors"></div>
              <input type="text" name="emp_telefono" id="emp_telefono" minlength="10" maxlength="15" onclick="numero_validate(this);"  class="form-control" required>
            </div>
        </div>        
        
        <div class="ecol-md-6" align="center">
        ¿Ya tienes una cuenta? <a href="<?php echo PUERTO."://".HOST;?>/login/">Iniciar sesión</a>
        </div>
        <br><br><br>
        <div align="left">
          <label class="form-text"><input type="checkbox" name="term_emp" id="terminos_emp" value="1"><a href="<?php echo PUERTO."://".HOST;?>/docs/terminos_y_condiciones.pdf" target="blank">Aceptar términos y condiciones</a></label>
        </div>
        <br>
        <div align="center">
          <input type="submit" id="button-save-emp" disabled name="btnemp" class="btn btn-primary" value="Crear Cuenta Empresarial"> 
        </div>    
      </div>
     

</form>
    </div>
  </div>
</div>
<?php } ?>

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
                                        <i class="far fa-envelope"></i>
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
                <div class="fluid-container" align="center">

                    <div class="foot_mic">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="foot_div_section">
                                    <a class="legal_info_content" href="<?php echo PUERTO."://".HOST;?>/docs/terminos_y_condiciones.pdf" target="blanked">Términos y Condiciones</a>| 
                                    <a class="legal_info_content" href="<?php echo PUERTO."://".HOST;?>/docs/politicas_de_privacidad.pdf" target="blanked">Políticas de Privacidad</a>|
                                    <a class="legal_info_content" href="https://www.blog.micamello.com.ec" target="blanked">Blog</a>|
                                    <a class="legal_info_content" href="form-
                                    g.php">Recomendaciones</a>
                                    
                                   
                                </div><!-- End off widget item -->
                            </div><!-- End off col-md-3 -->

                            <div class="col-md-6">
                                <div class="foot_div_section">
                                    <div class="widget_item widget_latest sm-m-top-50" align="center">
                                        <div class="row">
                                        <div class="form-inline">
                                        <?php foreach(Modelo_Sucursal::obtieneListado() as $sucursal){ ?>  
                                          <img src="<?php echo PUERTO."://".HOST;?>/imagenes/paises/<?php echo $sucursal["icono"];?>" class="country_mic"> 
                                          <span class="text_icons_footer"><?php echo $sucursal["nombre_abr"];?></span>
                                        <?php }?>                                                                                
                                        <span class="separate_social_country">|</span>
                                        <!-- </div>                                        
                                        
                                        <div class=""> -->
                                            <span class="text_icons_footer">Siguenos en:</span>
                                        <a href="https://es-la.facebook.com/MiCamello.com.ec/" target="blacked"><img src="<?php echo PUERTO."://".HOST;?>/imagenes/redes/face.png" class="social_mic">
                                        <!-- <span style="color: #000;font-size: 16px;" class="text_icons_footer"></span></a> -->
                                        
                                        <a href="https://twitter.com/MiCamelloec" target="blacked"><img src="<?php echo PUERTO."://".HOST;?>/imagenes/redes/tw.png" class="social_mic">
                                        <!-- <span style="color: #000;font-size: 16px;" class="text_icons_footer"></span></a> -->
                                        
                                        <a href="https://www.instagram.com/micamelloec/" target="blacked"><img src="<?php echo PUERTO."://".HOST;?>/imagenes/redes/ins.png" class="social_mic">
                                        <!-- <span style="color: #000;font-size: 16px;" class="text_icons_footer"></span></a> -->
                                        </div>
                                        </div>
                                    </div><!-- End off widget item -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


               
            </footer> 


<!-- <script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/jquery-1.11.2.min.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/bootstrap.min.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/main.js"></script>
<script type="text/javascript" src="<?php echo PUERTO."://".HOST;?>/js/validator.js"></script>
<script type="text/javascript" src="<?php echo PUERTO."://".HOST;?>/js/ruc_jquery_validator.js"></script>
<script type="text/javascript" src="<?php echo PUERTO."://".HOST;?>/js/selectr.js"></script>
<script type="text/javascript" src="<?php echo PUERTO."://".HOST;?>/js/mic.js"></script> -->

<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/jquery-3.0.0.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/bootstrap.min.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/main.js"></script>
<?php
if (isset($template_js) && is_array($template_js)){
  foreach($template_js as $file_js){
    echo '<script type="text/javascript" src="'.PUERTO.'://'.HOST.'/js/'.$file_js.'.js"></script>';
  }  
}
?>

</body>
</html>
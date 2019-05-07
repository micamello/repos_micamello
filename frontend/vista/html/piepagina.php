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
                          echo "<option value='".$sectorind['id_sectorindustrial']."'>".utf8_encode($sectorind['descripcion'])."</option>";
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
                  <label>Tipo documentaci&oacute;n <i class="obligatorio">*</i></label>
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
                    <input type="password" class="form-control" name="password_1" id="password_1" spellcheck="false">
                    <div></div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Repita contraseña <i class="obligatorio">*</i></label>
                  <div class="inner-addon right-addon">
                    <i class="fa fa-eye reveal_content"></i>
                    <input type="password" class="form-control" name="password_2" id="password_2" spellcheck="false">
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

<input type="hidden" id="iso" value="<?php echo SUCURSAL_ISO; ?>">

<footer id="contact" class="footer p-top-30">
  <div class="container-fluid">
    <div class="foot_mic">
      <div class="pie-pag col-md-4" style=" padding-left: 30px;
      ">
        <h3>Nosotros</h3>
        <p><a class="" href="">¿Quiénes somos?</a></p>
        <p><a class="legal_info_content" href="http://blog.micamello.com.ec/" target="blanked">Blog</a></p>
        <h3>Políticas de Privacidad</h3>
        <p><a class="legal_info_content" href="<?php echo PUERTO."://".HOST."/docs/terminos_y_condiciones".SUCURSAL_ID.".pdf";?>" target="_blank">Términos y Condiciones</a></p>
        <p><a class="legal_info_content" href="<?php echo PUERTO."://".HOST."/docs/politicas_de_privacidad".SUCURSAL_ID.".pdf";?>" target="_blank">Políticas de Privacidad</a></p>
        <p><a class="legal_info_content" href="<?php echo PUERTO."://".HOST."/docs/politicas_de_cookies".".pdf";?>" target="_blank">Políticas de Cookies</a></p>
        <p><a class="legal_info_content" href="<?php echo PUERTO."://".HOST;?>/recomendacion/">Recomendaciones</a></p>
      </div>
      <div class="pie-pag col-md-4" style=" padding-left: 30px;
      ">
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
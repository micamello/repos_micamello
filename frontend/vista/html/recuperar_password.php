<div class="container">
  <div class="row">
    <div class="main_business"><br><br>
      <div class="col-md-6">
        <h3 align="center"> RECUPERACI&Oacute;N DE CONTRASE&Ntilde;A</h3>
        <form action = "<?php echo PUERTO."://".HOST;?>/contrasena/" method = "post" id="form_contrasena">          
          <div class="col-md-12">
            <div class="form-group">
              <label>Correo Electr&oacute;nico:</label><div class="help-block with-errors"></div>
              <input type="email" name="correo" id="correo" class="form-control" placeholder="Ej: camello@gmail.com" aria-describedby="correoHelp" required maxlength="100" minlength="10">
              <input type="hidden" name="forgot_form" id="forgot_form" value="1">
            </div>  
          </div>                            
          <div class="row">          
            <div class="col-xs-12">
              <button type="submit" class="btn btn-success btn-block btn-flat">Enviar</button>
            </div>          
          </div>
        </form>
      </div>
      <div class="col-md-6" align="center"><br><br>
        <img src="<?php echo PUERTO."://".HOST;?>/imagenes/logo.png" style="width: 50%">
        <h3>BIENVENID@ A MICAMELLO, LA PLATAFORMA MAS EXITOSA DE EMPLEOS DEL ECUADOR  </h3>
      </div>                                      
    </div>
  </div>
</div>
<br><br><br><br><br>
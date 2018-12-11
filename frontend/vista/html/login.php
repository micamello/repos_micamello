<div class="container">
  <div class="row">
    <div class="main_business"><br><br>      
      <div class="col-md-6"> 
      <h3 align="center"> INICIAR SESI&Oacute;N</h3>       
        <form action = "<?php echo PUERTO."://".HOST;?>/login/" method = "post" id="form_login">
          <div class="col-md-12">
            <div class="form-group ">
              <label>Usuario/Correo:</label><div class="help-block with-errors"></div>
              <input type="text" name="username" id="username" class="form-control" placeholder="Ej: palvarez/pedroalvarez@gmail.com" required maxlength="50" minlength="5">
              <input type="hidden" name="login_form" id="login_form" value="1">            
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Contrase&ntilde;a:</label><div class="help-block with-errors"></div>
              <div class="input-group">
                <span class="input-group-addon show_hidden" onclick="pass_reveal(this);"><i class="fa fa-eye"></i></span>
                <input title="Letras y números, mínimo 8 caracteres" type="password" name="password" id="password" class="form-control" required maxlength="15" minlength="8">
              </div>
            </div>
          </div>
          <p class="text-center"><strong>Olvidaste tu contrase&ntilde;a</strong> <a href="<?php echo PUERTO."://".HOST;?>/contrasena/">Haz click aqu&iacute;</a></p><br>
          <div class="row">          
            <div class="col-xs-12">
              <button type="submit" class="btn btn-success btn-block btn-flat">Iniciar Sesi&oacute;n</button>
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
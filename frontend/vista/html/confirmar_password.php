<div class="container">
  <div class="row">
    <div class="main_business"><br><br>
      <div class="col-md-6">
        <h3 align="center"> CAMBIO DE CONTRASE&Ntilde;A</h3> 
        <form action = "<?php echo PUERTO."://".HOST;?>/contrasena/<?php echo $token;?>/" method = "post" id="form_contrasena">
          <div class="col-md-12">
            <div class="form-group">
              <label>Nueva contrase&ntilde;a:</label><div class="help-block with-errors"></div>
              <div class="input-group">
                <span class="input-group-addon show_hidden" onclick="pass_reveal(this);"><i class="fa fa-eye"></i></span>
                <input type="password" name="password" id="password" class="form-control" title="Letras y números, mínimo 8 caracteres" pattern="^(?=(?:.*\d))(?=(?:.*[a-zA-Z]))\S{8,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); if(this.checkValidity()) form.password_two.pattern = this.value;" required maxlength="8" minlength="8">
              </div>
              <input type="hidden" name="confirm_form" id="confirm_form" value="1">
              <input type="hidden" name="token" id="token" value="<?php echo $token;?>">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Confirme contrase&ntilde;a:</label><div class="help-block with-errors"></div>
              <div class="input-group">
                <span class="input-group-addon show_hidden" onclick="pass_reveal(this);"><i class="fa fa-eye"></i></span>
                <input type="password" name="password2" id="password2" class="form-control" title="Letras y números, mínimo 8 caracteres" pattern="^(?=(?:.*\d))(?=(?:.*[a-zA-Z]))\S{8,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); if(this.checkValidity()) form.password_two.pattern = this.value;" required maxlength="8" minlength="8"> 
              </div>
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
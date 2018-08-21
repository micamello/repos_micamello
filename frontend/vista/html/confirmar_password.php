<div class="container">
  <div class="row">
    <div class="main_business"><br><br>
      <div class="col-md-6">
        <form action = "<?php echo PUERTO."://".HOST;?>/contrasena/<?php echo $token;?>/" method = "post">
          <h3 align="center"> INGRESE SU NUEVA CONTRASE&Ntilde;A</h3>
          <div class="form-group has-feedback">
            <input type="password" name="password" id="password" class="form-control" placeholder="Nueva Contrase&ntilde;a" required>
            <input type="hidden" name="confirm_form" id="confirm_form" value="1">
            <input type="hidden" name="token" id="token" value="<?php echo $token;?>">
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password2" id="password2" class="form-control" placeholder="Confirme Contrase&ntilde;a" required> 
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
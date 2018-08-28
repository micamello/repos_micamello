<div class="container">
  <div class="row">
    <div class="main_business"><br><br>
      <div class="col-md-6">
        <form id="form_login" action = "<?php echo PUERTO."://".HOST;?>/login/" method = "post">
          <h3 align="center"> INICIAR SESIÓN</h3>
          <div class="col-md-12">
            <div class="form-group">
            <label>eder: </label><div class="help-block with-errors"></div>
            <input type="text" name="username" id="username" class="form-control" placeholder="Usuario" required>
            <input type="hidden" name="login_form" id="login_form" value="1">
          </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
            <label>eder: </label><div class="help-block with-errors"></div>
            <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required>
          </div>
          </div>
          <p class="text-center"><strong>Olvidaste tu contraseña</strong> <a href="<?php echo PUERTO."://".HOST;?>/contrasena/">Haz click aquí</a></p><br>
          <div class="row">          
            <div class="col-xs-12">
              <button type="submit" class="btn btn-success btn-block btn-flat">Iniciar Sesión</button>
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
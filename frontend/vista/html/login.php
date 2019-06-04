<!--<section id="product" class="product">-->
  <div class="container">
    <div class="text-center">
      <h2 class="titulo">Iniciar Sesi&oacute;n</h2>
    </div>
  </div>
  <section id="product" class="inicio">
    <div class="container">
      <div class="row" id="registro-algo-centro">  
        <div class="col-md-6 col-md-offset-3">
          <div class="" id="inicio-cuadro"> 
            <form action = "<?php echo PUERTO."://".HOST;?>/login/" method = "post" id="form_login" name="form_login" autocomplete="off">
              <div class="col-md-12">
                <div class="form-group" id="seccion_username">
                  <label>Usuario/Correo <span title="Este campo es obligatorio">*</span></label><div id="err_username" class="help-block with-errors"></div>
                  <input type="text" name="username" id="username" class="form-control" placeholder="Ej: palvarez/pedroalvarez@gmail.com" maxlength="50" minlength="4"  onkeyup="validaForm(1,'btn_sesion')">
                  <input type="hidden" name="login_form" id="login_form" value="1">            
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group" id="seccion_password">
                  <label>Contrase&ntilde;a <span title="Este campo es obligatorio">*</span></label><div id="err_password" class="help-block with-errors"></div>
                  <div class="input-group">
                    <span class="input-group-addon show_hidden" onclick="pass_reveal(this);"><i class="fa fa-eye"></i></span>
                    <input title="Letras y números, mínimo 8 caracteres" type="password" name="password1" id="password1" class="form-control noautofill" maxlength="15" minlength="8" onkeyup="validaForm(1,'btn_sesion')" readonly>
                  </div>
                </div>
              </div>
              <div class="row">          
                <div class="col-xs-12">
                  <div class="text-center" style="margin-top: 20px;">
                    <label><a href="<?php echo PUERTO."://".HOST;?>/contrasena/">¿Olvidaste tu contraseña?&nbsp;Haz click aqu&iacute;</a></label><br>
                    <button id="btn_sesion" type="button" class="btn-blue" onclick="validaForm(1,'btn_sesion')">Ingresar</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  ﻿</section>
<!--</section>-->
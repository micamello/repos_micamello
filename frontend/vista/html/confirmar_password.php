<!--<section id="product" class="product">-->
  <div class="container">
    <div class="text-center">
      <h2 class="titulo">Cambio de Contrase&ntilde;a</h2>
    </div>
  </div>
  <section id="product" class="inicio">
    <div class="container">
      <div class="row" id="registro-algo-centro">  
        <div class="col-md-6 col-md-offset-3">
          <div class="" id="inicio-cuadro"> 
            <form action = "<?php echo PUERTO."://".HOST;?>/contrasena/<?php echo $token;?>/" method = "post" id="form_contrasena" name="form_contrasena">
              <div class="col-md-12">
                <div class="form-group" id="seccion_clave">
                  <label>Nueva Contrase&ntilde;a <span title="Este campo es obligatorio">*</span></label><div id="err_clave" class="help-block with-errors"></div>
                  <div class="input-group">
                    <span class="input-group-addon show_hidden" onclick="pass_reveal(this);"><i class="fa fa-eye"></i></span>
                    <input type="password" name="password1" id="password1" class="form-control <?php echo $noautofill; ?>" title="Letras y números, mínimo 8 caracteres" onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); if(this.checkValidity()) form.password2.pattern = this.value;" maxlength="15" minlength="8" onkeyup="validaForm(2,'recuperar')" <?php echo $readonly; ?>>
                  </div> 
                  <input type="hidden" name="confirm_form" id="confirm_form" value="1">
                  <input type="hidden" name="token" id="token" value="<?php echo $token;?>">        
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group" id="seccion_clave1">
                  <label>Confirme Contrase&ntilde;a <span title="Este campo es obligatorio">*</span></label><div id="err_clave1" class="help-block with-errors"></div>
                  <div class="input-group">
                    <span class="input-group-addon show_hidden" onclick="pass_reveal(this);"><i class="fa fa-eye"></i></span>
                    <input type="password" name="password2" id="password2" class="form-control <?php echo $noautofill; ?>" title="Letras y números, mínimo 8 caracteres" onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); if(this.checkValidity()) form.password2.pattern = this.value;" maxlength="15" minlength="8" onkeyup="validaForm(2,'recuperar')" <?php echo $readonly; ?>>
                  </div>
                </div>
              </div>
              <div class="row">          
                <div class="col-xs-12">
                  <div class="text-center" style="margin-top: 20px;">
                    <button type="button" class="btn-blue" onclick="validaForm(2,'recuperar')" id="recuperar">Enviar</button>
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
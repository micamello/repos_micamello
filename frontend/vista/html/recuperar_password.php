<!--<section id="product" class="product">-->
  <div class="container">
    <div class="text-center">
      <h2 class="titulo">Recuperaci&oacute;n de Contrase&ntilde;a</h2>
    </div>
  </div>

  <section id="product" class="inicio">
    <div class="container">
      <div class="row" id="registro-algo-centro">  
        <div class="col-md-6 col-md-offset-3">
          <div class="" id="inicio-cuadro"> 
            <form action = "<?php echo PUERTO."://".HOST;?>/contrasena/" method = "post" id="form_contrasena" name="form_contrasena">
              <div class="col-md-12">
                <div class="form-group" id="seccion_correo">
                  <label>Correo Electr&oacute;nico <span title="Este campo es obligatorio">*</span></label><div id="err_correo" class="help-block with-errors"></div>
                  <input type="email" name="correo1" id="correo1" class="form-control" placeholder="Ej: camello@gmail.com" aria-describedby="correoHelp" maxlength="100" minlength="10" onkeyup="validaForm(2,'recuperar')" >
                  <input type="hidden" name="forgot_form" id="forgot_form" value="1">            
                </div>
              </div>
              <div class="row">          
                <div class="col-xs-12">
                  <div class="text-center" style="margin-top: 20px;">
                    <button id="recuperar" type="button" class="btn-blue" onclick="validaForm(2,'recuperar')">Enviar</button>
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
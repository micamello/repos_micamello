<section>
  
  <div class="text-center">
    <h2 class="titulo">Env&iacute;anos tus dudas y sugerencias</h2>
  </div>
  
  <div class="container bloque-gris" style="padding: 0px;">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="" id="inicio-cuadro"> 
            <form action = "<?php echo PUERTO."://".HOST;?>/recomendacion/" method = "post" id="form_recomendaciones" name="form_recomendaciones">
              <div class="col-md-12">
                <div class="form-group" id="seccion_nombres">
                  <label for="nombres">Nombres <span class="requerido">*</span></label><div id="err_nombres" class="help-block with-errors"></div>
                  <input class="form-control" type="text" name="nombres" id="nombres" onkeyup="validaForm(3,'recomendaciones')"/>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group" id="seccion_correo">
                  <label for="correo">Correo <span class="requerido">*</span></label>
                  <div id="err_correo" class="help-block with-errors"></div>
                  <input type="email" id="correo1" name="correo1" class="form-control" onkeyup="validaForm(3,'recomendaciones')">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group" id="seccion_telefono">
                  <label for="telefono">Tel&eacute;fono <span class="requerido">*</span></label><div id="err_telefono" class="help-block with-errors"></div>
                  <input type="text" id="telefono" name="telefono" class="form-control" minlength="10" maxlength="15" pattern='[0-9]+' onkeydown="return validaNumeros(event)" onkeyup="validaForm(3,'recomendaciones')">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group" id="seccion_descripcion">
                  <label for="descripcion">Descripci&oacute;n <span class="requerido">*</span></label><div id="err_descripcion" class="help-block with-errors"></div>
                  <textarea id="descripcion" rows="7" class="form-control" onkeyup="validaForm(3,'recomendaciones')" name="descripcion" style="resize: none;"></textarea>
                </div>
              </div>
              
              <input type="hidden" name="enviarRecomendacion" id="enviarRecomendacion" value="1">
              <div class="row">          
                <div class="col-xs-12">
                  <div class="text-center" style="margin-top: 20px;">
                    <input type="button" class="btn-blue"  id="recomendaciones" value="Enviar" onclick="validaForm(3,'recomendaciones')"/>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
  </div>
</section>
<!--</section>-->
<br><br>
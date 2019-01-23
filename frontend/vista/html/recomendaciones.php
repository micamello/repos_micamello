<br><br>
<div class="container">
    <div class="breadcrumb">
      <p class="text-center" style="font-size: 20px;">Env&iacute;anos tus sugerencias o comentarios</p>
    </div>
</div>

<div class="container" style="text-align: left;">
    <div class="panel panel-default col-md-6">
        <div class="panel-body">
            <form role="form" id="form_recomendaciones" method="post" action="<?php echo PUERTO."://".HOST;?>/recomendacion/">
                <div class="col-md-12">
                    <div class="form-group" id="seccion_nombres">
                        <label for="nombres">Nombres <span class="requerido">*</span></label><div id="err_nombres" class="help-block with-errors"></div>
                        <input class="form-control" type="text" name="nombres" id="nombres" onkeyup="validaForm(3,'recomendaciones')"/>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group" id="seccion_correo">
                        <label for="correo">Correo <span class="requerido">*</span></label><div id="err_correo" class="help-block with-errors"></div>
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
                <br>
                <input type="hidden" name="enviarRecomendacion" id="enviarRecomendacion" value="1">
                <div class="text-center">
                    <input type="button" class="btn btn-success" value="Enviar" id="recomendaciones" onclick="validaForm(3,'recomendaciones')">
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <div class="" align="center" style="margin: auto 0; margin-top: 80px;">
            <img src="<?php echo PUERTO."://".HOST."/imagenes/logo.png";?>" class="img-responsive" style="max-width:100%;">
        </div>
    </div>
</div>
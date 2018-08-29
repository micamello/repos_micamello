<br><br>
<div class="container">
    <div class="breadcrumb">
      <p class="text-center" style="font-size: 20px;">Env&iacute;anos tus sugerencias o comentarios</p>
    </div>
</div>

<div class="container" style="text-align: left;">
    <div class="panel panel-default col-md-6">
        <div class="panel-body">
            <form role="form" name="form1" id="form_recomendaciones" method="post" action="<?php echo PUERTO."://".HOST;?>/recomendacion/">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="nombres">Nombres</label><div class="help-block with-errors"></div>
                        <input class="form-control" type="text" id="nombres" name="nombres" pattern="[a-z A-ZñÑáéíóúÁÉÍÓÚ]+" required/>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="correo">Correo</label><div class="help-block with-errors"></div>
                        <input type="email" id="correo" name="correo" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="telefono">Tel&eacute;fono</label><div class="help-block with-errors"></div>
                        <input type="text" id="telefono" name="telefono" class="form-control" minlength="10" maxlength="15" pattern='[0-9]+' required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="descripcion">Descripci&oacute;n</label><div class="help-block with-errors"></div>
                        <textarea id="descripcion" rows="7" class="form-control" required name="descripcion" style="resize: none;"></textarea>
                    </div>
                </div>
                <br>
                <input type="hidden" name="enviarRecomendacion" id="enviarRecomendacion" value="1">
                <div class="text-center">
                    <input type="submit" class="btn btn-success" value="Enviar">
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <div class="" align="center" style="margin: auto 0; margin-top: 80px;">
            <img src="<?php echo PUERTO."://".HOST."/imagenes/logo.png";?>" class="img-responsive">
        </div>
    </div>
</div>

        

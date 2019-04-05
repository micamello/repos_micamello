<br><br>
<div class="container vertical-center">
  <div class="error"></div>
	<div class="panel panel-default">
		<form id="metodoSeleccion" action="<?php echo PUERTO."://".HOST;?>/modalidad/" method="POST">
      <div class="panel-body">
        <input type="hidden" name="metodoSeleccion" value="1">
        <div class="text-center">
          <div>
            <span style="font-size: 14px; font-weight: bold;">
              En esta página se presentan dos opciones de respuestas, para responder el cuestionario. Seleccione la opción con la que más se sienta cómodo.
            </span>
            <span style="font-size: 14px; font-weight: bold;">
              En la parte inferior podrá visualizar dos ejemplos didácticos. 
            </span>
          </div>
          <br><br>
          <div class="row">
            <?php 
              foreach (METODO_SELECCION as $key => $value) {
                ?>
                  <div class="col-md-6 text-center">
                    <div class="form-group">
                      <label class="form-check-label">
                        <input type="radio" name="seleccion" class="form-check-input" value="<?php echo $key; ?>">
                        <span style="font-size: 12px;"><?php echo utf8_encode($value[0]); ?></span>
                      </label>
                    </div><br>
                    <div class="text-center">
                      <img src="<?php echo PUERTO."://".HOST."/imagenes/metodoSel/".$key.".gif";?>" style="width: 100%;" id="<?php echo "gif_".$key; ?>">
                    </div>
                  </div>
                <?php
              }
             ?>
          </div>

        </div>
      </div>
      <div class="panel-footer">
        <input type="submit" name="" value="Seleccionar" class="btn btn-success">
      </div>
    </form>
	</div>
</div>
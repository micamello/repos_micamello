<div class="row">
  <div class="main_business">
    <div class="container">
      <div class="row" align="justify">
        <?php foreach ($oferta as $key => $o) { ?>
          <div class="col-md-8">
              <div class="panel panel-primary shadow-panel1">
                <div class="panel-heading">
                    <?php echo $o['titulo']; ?>
                </div>
                <div class="panel-body">
                  <div style="margin: 0;">
                    <?php if ($o['confidencial'] == 0) {?>
                      <div style="margin-bottom: 10px; color: #1e82c4; font-size: 20px;font-weight: bold; border-bottom: solid #ccc thin">
                        <?php echo $o['empresa']; ?>
                      </div>
                      <?php } else {?>
                      <div style="margin-bottom: 10px; color: #1e82c4; font-size: 20px;font-weight: bold; border-bottom: solid #ccc thin">
                          Nombre - confidencial
                      </div>
                    <?php }?>
                    <div>
                        <h5><b>Descripción</b></h5>
                    </div>

                    <div style="color: #333; font-size: 16px;">
                        <?php echo $o['descripcion']; ?>
                    </div>
                    <br><br><h5><b>Requerimientos</b></h5>
                    <div>
                        <h5>
                            <span style="color: #0267cf;">Fecha de Contrato</span><br>
                             <?php echo substr($o['fecha_contratacion'], 0, 10); ?>
                        </h5>
                    </div>

                    <div>
                        <h5>
                            <span style="color: #0267cf;">Años de Experiencia</span><br>
                             <?php echo ANOSEXP[$o['anosexp']]; ?>
                        </h5>
                    </div>

                    <div>
                        <h5>
                            <span style="color: #0267cf;">Nivel de Estudios</span><br>
                             <?php echo $o['escolaridad']; ?>
                        </h5>
                    </div>
                    <div>
                        <h5>
                            <span style="color: #0267cf;">Disponibilidad de Viajar</span><br>
                            <?php if ($o['viajar'] == 0) { echo 'NO'; }else{ echo 'SI'; } ?>
                        </h5>
                    </div>
                    <div>
                        <h5>
                            <span style="color: #0267cf;">Disponibilidad de Cambio de Residencia</span>
                            <br>
                            <?php if ($o['residencia'] == 0) { echo 'NO'; }else{ echo 'SI'; } ?>
                        </h5>
                    </div>
                  </div>
                </div>
                <br><br>
              </div>
          </div>
          <div class="col-md-4">
            <div class="panel panel-default shadow-panel1">
              <div class="panel-body">
                <img style="margin-top: 0px; padding-bottom: 10px;" src="<?php echo $_SESSION['publicidad']; ?>">
                <div>
                  <h5><b>Resumen de Empleo</b></h5>
                </div>
                <hr>
                <div>
                  <h5>
                      <span style="color: #0267cf;">Localización</span><br>
                      - <?php echo $o['provincia']; ?>
                  </h5>
                </div>
                <div>
                  <h5>
                      <span style="color: #0267cf;">Jornada</span><br>
                      - <?php echo $o['jornada']; ?>
                  </h5>
                </div>
                <div>
                    <h5>
                        <span style="color: #0267cf;">Tipo de Contrato</span><br>
                        - <?php echo $o['tipo_contrato']; ?>
                    </h5>
                </div>
                <div>
                    <h5>
                        <span style="color: #0267cf;">Salario</span><br>
                        - <?php echo $o['salario']; ?>
                    </h5>
                </div>
                <div>
                    <h5>
                        <span style="color: #0267cf;">Discapacidad</span><br>
                        - <?php echo DISCAPACIDAD[$o['discapacidad']]; ?>
                    </h5>
                </div>
                <form role="form" name="form1" id="form_postulacion" method="post" action="<?php echo PUERTO."://".HOST;?>/detalleOferta/<?php echo $o['id_ofertas']; ?>/" enctype="multipart/form-data">
                  <input type="hidden" name="postulado" id="postulado" value="1">
                  <?php if(!empty($postulado)){ ?>
                    <div align="center">
                      <h5>
                       <span class="btn btn-danger">Ya aplico para la oferta</span>
                      </h5>
                    </div>
                  <?php }else{ ?>
                    <div align="center">
                      <h5>
                        <button type="submit" class="btn btn-success">POSTULARSE</button>
                      </h5>
                    </div>
                  <?php } ?>
                </form>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

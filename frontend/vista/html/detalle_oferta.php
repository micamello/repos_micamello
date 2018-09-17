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
                      <div class="confidencial">
                        <?php echo $o['empresa']; ?>
                      </div>
                      <?php } else {?>
                      <div class="confidencial">
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
                            <span class="titulos">Fecha de Contrato</span><br>
                             <?php echo substr($o['fecha_contratacion'], 0, 10); ?>
                        </h5>
                    </div>

                    <div>
                        <h5>
                            <span class="titulos">Años de Experiencia</span><br>
                             <?php echo ANOSEXP[$o['anosexp']]; ?>
                        </h5>
                    </div>

                    <div>
                        <h5>
                            <span class="titulos">Nivel de Estudios</span><br>
                             <?php echo $o['escolaridad']; ?>
                        </h5>
                    </div>

                    <div>
                        <h5>
                            <span class="titulos">Nivel de Idiomas</span><br>
                             <?php $idiomas = Modelo_NivelxIdioma::relacionIdiomaNivel($o['idiomas']); 
                             foreach ($idiomas as $key => $value) {
                                echo utf8_encode($value['descripcion'].' - '.$value['nombre']).'<br>';
                             }

                             ?>
                        </h5>
                    </div>

                    <div>
                        <h5>
                            <span class="titulos">Disponibilidad de Viajar</span><br>
                            <?php if ($o['viajar'] == 0) { echo 'NO'; }else{ echo 'SI'; } ?>
                        </h5>
                    </div>
                    <div>
                        <h5>
                            <span class="titulos">Disponibilidad de Cambio de Residencia</span>
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
                      <span class="titulos">Localización</span><br>
                      - <?php echo $o['provincia']; ?>
                  </h5>
                </div>
                <div>
                  <h5>
                      <span class="titulos">Jornada</span><br>
                      - <?php echo $o['jornada']; ?>
                  </h5>
                </div>
                <div>
                    <h5>
                        <span class="titulos">Salario</span><br>
                        - <?php echo $_SESSION["mfo_datos"]["sucursal"]["simbolo"].number_format($o['salario'],2);?>
                    </h5>
                </div>
                <div>
                    <h5>
                        <span class="titulos">Discapacidad</span><br>
                        - <?php echo REQUISITO[$o['discapacidad']]; ?>
                    </h5>
                </div>
                <form role="form" name="form1" id="form_postulacion" method="post" action="<?php echo PUERTO."://".HOST;?>/detalleOferta/<?php echo $vista.'/'.$o['id_ofertas']; ?>/">
                  <input type="hidden" name="postulado" id="postulado" value="1">
                  <?php if(!empty($vista) && $vista != 'postulacion'){ 

                     ?>
                    <?php if(!empty($postulado)){ ?>
                      <div align="center">
                        <h5>
                         <span class="btn btn-danger">Ya aplico para la oferta</span>
                        </h5>
                      </div>
                    <?php }else{ ?>
                      <div align="center">
                        <div class="col-md-12">
                          <div class="form-group">
                              <label for="aspiracion">Aspiraci&oacute;n salarial</label><div class="help-block with-errors"></div>
                              <input class="form-control" type="text" name="aspiracion" id="aspiracion" placeholder="Ej: <?php echo $_SESSION["mfo_datos"]["sucursal"]["simbolo"].number_format(450,2); ?>" required/>
                          </div>
                        </div>
                        <h5>
                          <button type="submit" class="btn btn-success">POSTULARSE</button>
                        </h5>
                      </div>
                    <?php } ?>
                  <?php }else{ ?>
                      <div align="center">
                        <label for="status">Estatus del candidato en la oferta</label>
                        <select class="form-control" name="status" id="status">
                          <option value="">Seleccione un estatus</option>
                          <?php 
                            foreach(ESTATUS_OFERTA as $key => $v){ 

                                echo "<option value='".$key."'";
                                if($key == strtoupper($postulado['0']['resultado'])){
                                  echo " selected='selected'";
                                }
                                echo ">".utf8_encode($v)."</option>";
                            } 
                          ?>
                        </select>
                        <br>
                        <h5>
                          <button type="submit" class="btn btn-success">GUARDAR</button>
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

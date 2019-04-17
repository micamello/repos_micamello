<div class="row">
  <div class="main_business">
    <div class="container">
      <div class="row" align="justify">
        <?php 

        foreach ($oferta as $key => $o) { ?>
          <div class="col-md-8">
              <div class="panel panel-primary shadow-panel1">
                <div class="panel-heading">
                    <?php echo utf8_encode($o['titulo']); ?>
                </div>
                <div class="panel-body">
                  <div style="margin: 0;">
                    <?php 
                    if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA){
                      if ($o['confidencial'] == 0) { ?>
                        <div class="confidencial">
                          <?php echo utf8_encode($o['empresa']); ?>
                        </div>
                      <?php } else {?>
                        <div class="confidencial">
                            Nombre de empresa - confidencial
                        </div>
                    <?php }
                    } ?>
                    <div>
                        <h5><b>Descripción</b></h5>
                    </div>

                    <div style="color: #333; font-size: 16px;">
                        <?php echo html_entity_decode($o['descripcion']); ?>
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
                             <?php echo utf8_encode($o['escolaridad']); ?>
                        </h5>
                    </div>

                    <div>
                        <h5>
                            <span class="titulos">Nivel de Idiomas</span><br>
                             <?php $idiomas = Modelo_NivelxIdioma::relacionIdiomaNivel($o['idiomas']);
                              if(!empty($idiomas)){ 
                               foreach ($idiomas as $key => $value) {
                                  echo utf8_encode($value['descripcion'].' - '.$value['nombre']).'<br>';
                               }
                              }else{
                                echo 'No exige idiomas en especifico';
                              }
                             ?>
                        </h5>
                    </div>
                   <div> 
                    <h5> 
                      <span class="titulos">&Aacute;rea (sub&aacute;reas)</span><br> <?php echo utf8_encode($o['area']); ?>  
                      <?php 
                        $areas_subareas = Modelo_AreaSubarea::obtieneAreasSubareas($o['subareas']);
                        $areas = '';
                        foreach ($areas_subareas as $key => $datos) {
                          $areas .= utf8_encode($datos['nombre_area'].' ('.$datos['nombre_subarea']).')<br>';
                        } 
                        echo $areas;
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
		                <div>
                        <h5>
                            <span class="titulos">Tipo de licencia para conducir</span>
                            <br>
                            <?php if ($o['licencia'] == 0) { echo 'NO'; }else{ echo 'SI'; } ?>
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
                <img class="publicidad" src="<?php echo $_SESSION['publicidad']; ?>">
                <div>
                  <h5><b>Resumen de Empleo</b></h5>
                </div>
                <hr>
                <div>
                  <h5>
                      <span class="titulos">Localización</span><br>
                      - <?php echo utf8_encode($o['provincia'].'/'.$o['ciudad']); ?>
                  </h5>
                </div>
                <div>
                  <h5>
                      <span class="titulos">Jornada</span><br>
                      - <?php echo utf8_encode($o['jornada']); ?>
                  </h5>
                </div>
                <div>
                    <h5>
                        <span class="titulos">Salario <?php if(!empty($o['a_convenir'])){ echo '(a convenir)'; } ?></span><br>
                        - <?php echo SUCURSAL_MONEDA.number_format($o['salario'],2);?>
                    </h5>
                </div>
                <div>
                    <h5>
                        <span class="titulos">Discapacidad</span><br>
                        - <?php echo REQUISITO[$o['discapacidad']]; ?>
                    </h5>
                </div>
                <div>
                    <h5>
                        <span class="titulos">Cantidad de vacantes</span><br>
                        - <?php echo $o['vacantes']; ?>
                    </h5>
                </div>
                <div>
                    <h5>
                        <span class="titulos">Rango de edad</span><br>
                        - <?php echo $o['edad_minima'].' a '.$o['edad_maxima']; ?> a&ntilde;os
                    </h5>
                </div>

                <div>
                    <h5>
                        <span class="titulos">Primer Empleo</span><br>
                        - <?php if($o['primer_empleo']){ echo 'S&iacute;'; }else{ echo 'No'; } ?>
                    </h5>
                </div>

		          <?php if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){ ?>
                <form role="form" name="form_postulacion" id="form_postulacion" method="post" action="<?php echo PUERTO."://".HOST;?>/detalleOferta/<?php echo $vista.'/'.Utils::encriptar($o['id_ofertas']); ?>/">
                  <input type="hidden" name="postulado" id="postulado" value="1">
                  <input type="hidden" name="opcion" id="opcion" value="">
                  <?php if(!empty($vista) && $vista != 'postulacion'){ ?>
                    <?php if(!empty($postulado)){ ?>
                      <div align="center">
                        <h5>
                         <span class="btn btn-danger">Ya aplic&oacute; para la oferta</span>
                        </h5>
                      </div>
                    <?php }else{ ?>
                      <div align="center">
                        <div class="col-md-12">
                          <div id="seccion_asp" class="form-group">
                              <label for="aspiracion">Aspiraci&oacute;n salarial</label><div id="err_asp" class="help-block with-errors"></div>
                              <input class="form-control" type="text" min="1" onkeydown="return validaNumeros(event)" name="aspiracion" id="aspiracion" pattern='[0-9]+' placeholder="Ej: <?php echo SUCURSAL_MONEDA.number_format(450,2); ?>" required/>
                          </div>
                          <h5>
                            <button type="button" class="btn btn-success" onclick="validarAspiracion();">POSTULARSE</button>
                          </h5>
                        </div>
                      </div>
                    <?php } ?>
                  <?php }else{ ?>
                      <div align="center">
			                 <br>
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
		          <?php } ?>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
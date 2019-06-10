<div class="container">
  <div class="text-center">
    <h2 class="titulo">Detalles de la <?php if(!empty($vista) && $vista != 'postulacion'){ echo 'Oferta de empleo'; }else{ echo 'Postulaci&oacute;n'; } ?></h2>
  </div>
</div>

<?php if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA){ ?>
<br>
<div class=" banner-publicidad">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="banner-light col-md-9 click ">est&aacute; a un solo click de encontrar el <b>candidato ideal</b></div>
        <button class="btn-minimalista heartBeat animated infinite col-md-2"><a href="<?php echo PUERTO."://".HOST;?>/publicar/">Publicar Oferta</a></button>
      </div>
    </div>
  </div>
</div>
<?php } ?>

<br>
<div class="main_business">
  <div class="container">
    <div class="row" align="justify">
      <?php foreach ($oferta as $key => $o) { ?>
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h3 class="titulo-detalle" style="margin-top: 10px; margin-bottom: 0px;"><?php echo utf8_encode($o['titulo']); ?></h3>
        <p class="detalles-subt">
          <span class="empresa-detalle"><?php
            if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA){
              if ($o['confidencial'] == 0) { 
                echo utf8_encode($o['empresa']).' | ';
              }else {
                echo 'empresa confidencial | ';
              }
            } ?></span>
          <span><b>Fecha de contrato: </b><?php echo substr($o['fecha_contratacion'], 0, 10); ?> </span>
        </p>
        <div class="col-md-3">
          <div id="altura-detalle" class="resumen">
            <h5 class="tit-detalle-1" style="margin-top: 0px;"><b>Resumen de Empleo</b></h5>
            <div class="visible-lg"><br></div>
          <div>
            <h5>
              <b><i class="fa fa-map-marker" aria-hidden="true"></i></b><?php echo utf8_encode($o['provincia'].'/'.$o['ciudad']); ?></h5>
            </div>
            <div>
              <h5>
                <b><i class="fa fa-clock-o" aria-hidden="true"></i></b><?php echo utf8_encode($o['jornada']); ?></h5>
            </div>
            <div>
              <h5>
                <b><i class="fa fa-usd" aria-hidden="true"></i></b><?php if(!empty($o['a_convenir'])){ echo '(a convenir)'; } ?></b> 
                <?php echo SUCURSAL_MONEDA.number_format($o['salario'],2);?></h5>
            </div>
            <div>
              <h5>
                <b><i class="fa fa-wheelchair" aria-hidden="true"></i></b><?php echo REQUISITO[$o['discapacidad']]; ?></h5>
            </div>
            <div>
              <h5>
                <b><i class="fa fa-users" aria-hidden="true"></i></b>Vacantes: <?php echo $o['vacantes']; ?></h5>
            </div>
            <div>
              <h5>
                <b><i class="fa fa-calendar" aria-hidden="true"></i></b>Edad: <?php echo $o['edad_minima'].' a '.$o['edad_maxima']; ?> a&ntilde;os</h5>
            </div>
            <div>
              <h5>
                <b><i class="fa fa-suitcase" aria-hidden="true"></i></b>Primer Empleo: <?php if($o['primer_empleo']){ echo 'S&iacute;'; }else{ echo 'No'; } ?></h5>
            </div>
          </div>
        </div>
        <div class="col-md-9">
          <div id="altura-detalle" class="resumen col-md-12">
          <div class="col-md-6">
            <h5 class="tit-detalle-1" style="margin-top: 0px;"><b>Requerimientos</b></h5>
            <div class="visible-lg"><br></div>
            <div>
              <h5>
                <b>Años de Experiencia: </b>
                <?php echo ANOSEXP[$o['anosexp']]; ?>                   
              </h5>
            </div>
            <div>
              <h5>
                <b>Nivel de Estudios: </b>
                <?php echo utf8_encode($o['escolaridad']); ?>             
              </h5>
            </div>
            <div>
              <h5>
                <b>Nivel de Idiomas: </b>
                <?php 
                  $idiomas = Modelo_NivelxIdioma::relacionIdiomaNivel($o['idiomas']);
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
                <b>Área (subáreas):</b>
                <?php echo utf8_encode($o['area']);  
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
                <b>Disponibilidad de Viajar: </b>
                <?php if ($o['viajar'] == 0) { echo 'NO'; }else{ echo 'SI'; } ?>                      
              </h5>
            </div>
            <div>
              <h5>
                <b>Disponibilidad de Cambio de Residencia: </b>
                <?php if ($o['residencia'] == 0) { echo 'NO'; }else{ echo 'SI'; } ?>                       
              </h5>
            </div>
            <div>
              <h5>
                <b>Tipo de licencia para conducir: </b>
                <?php if($o['licencia'] == 0){
                  echo 'Sin licencia';
                }else{ 
                  echo $licencias[$o['licencia']]; 
                } ?>                        
              </h5>
            </div>
          </div>
          <div class="col-md-6">
            <div align="center">
              <div class="cambiar">
                <div class="col-md-12">
                  <img class="publicidad img-responsive" src="<?php echo PUERTO."://".HOST;?>/imagenes/anuncio.gif">
                  <br>
                  <?php if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){ ?>
                    <form role="form" name="form_postulacion" id="form_postulacion" method="post" action="<?php echo PUERTO."://".HOST;?>/detalleOferta/<?php echo $vista.'/'.Utils::encriptar($o['id_ofertas']); ?>/">
                      <input type="hidden" name="postulado" id="postulado" value="1">
                      <input type="hidden" name="opcion" id="opcion" value="">
                      <?php if(!empty($vista) && $vista != 'postulacion'){ ?>
                        <?php if(!empty($postulado)){ ?>
                          <div align="center">
                            <div class="cambiar">
                              <h5 class="centro">
                                <br>
                               <button type="button" class="btn-red" style="cursor:pointer">Ya aplic&oacute; para la oferta</button>
                              </h5>
                            </div>
                          </div>
                        <?php }else{ ?>
                          <div align="center">
                            <div class="cambiar">
                              <div class="col-md-12">
                                <div id="seccion_asp" class="form-group">
                                    <label for="aspiracion">Aspiraci&oacute;n salarial</label><div id="err_asp" class="help-block with-errors"></div>
                                    <input class="form-control" type="text" min="1" onkeydown="return validaNumeros(event)" name="aspiracion" id="aspiracion" pattern='[0-9]+' maxlength="5" placeholder="Ej: <?php echo SUCURSAL_MONEDA.number_format(450,0); ?>" required/>
                                </div>
                                <h5>
                                  <button type="button" class="btn btn-success" id="btn-verde" onclick="validarAspiracion();">POSTULARSE</button>
                                </h5>
                              </div>
                            </div>
                          </div>
                        <?php } ?>
                      <?php }else{ ?>
                        <div align="center">
                          <div align="cambiar">
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
                              <button type="submit" class="btn btn-success" id="btn-verde">GUARDAR</button>
                            </h5>
                          </div>
                        </div>
                      <?php } ?>
                    </form>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>          
        </div>
      </div>

      <div class="col-md-12">
        <section style="padding: 25px 0px; margin-bottom: 10px; background-color: grey;color: white; text-align:center">
          <div class="container">
            <div class="col-md-12">
              <label>PUBLICIDAD</label>
            </div>
          </div>
        </section>

        <div class="resumen">
          <h5 class="tit-detalle-1" style="text-align: left; margin-top: 0px;"><b>Descripci&oacute;n:</b></h5>
            
          <p><?php echo html_entity_decode($o['descripcion']); ?></p>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</div>

<?php if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA){ ?>
<div class=" banner-publicidad">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="banner-light col-md-9 click ">est&aacute; a un solo click de encontrar el <b>candidato ideal</b></div>
        <button class="btn-minimalista heartBeat animated infinite col-md-2"><a href="<?php echo PUERTO."://".HOST;?>/publicar/">Publicar Oferta</a></button>
      </div>
    </div>
  </div>
</div>
<?php } ?>
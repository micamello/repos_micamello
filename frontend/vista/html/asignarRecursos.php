<div class="container"><br>
  <div class="row">
    <div class="main_business">
      <section>
        <div class="col-md-12">
          <div class="text-center">
            <h2 class="titulo">Asignar Ofertas - <?php echo $nombreEmp; ?></h2><br><br>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>

<div id="registro-algo-centro">
  <div class="container">
    <div class="row">
      <div id="inicio-cuadro">
        <div class="panel-body">
          <div id="no-more-tables">
                <div class="form-group col-md-12">
                    <form action = "<?php echo PUERTO."://".HOST;?>/asignarPlanEmpresa/<?php echo Utils::encriptar($idSubEmpresa); ?>/" method = "post" id="form_editarCuenta" name="form_editarCuenta">
                        <div class="row">  
                          <input type="hidden" name="asignarRecursos" id="asignarRecursos" value="1">
                          <div class="col-md-offset-3 col-md-6">
                            <div class="form-group" style="text-align: center" id="seccion_plan">
                              <label for="plan" style="font-size:18px" class="campo">Seleccione un Plan <span title="Este campo es obligatorio">*</span></label><div id="err_plan" class="help-block with-errors"></div>
                              <select class="form-control" name="plan" id="plan">
                                <option selected disabled value="0">Seleccione un plan</option>
                                <?php 
                                if (!empty($planesActivos)){
                                  foreach($planesActivos as $key => $v){ 
                                    echo "<option value='".Utils::encriptar($v['id_empresa_plan'])."'";
                                    if(isset($data['plan']) && Utils::desencriptar($data['plan']) == $v['id_empresa_plan']){
                                      echo "selected='selected'";
                                    }
                                    echo ">".utf8_encode($v['nombre']).' - Fecha de compra: '.$v['fecha_compra']."</option>";
                                  }
                                } ?>
                              </select>
                            </div>
                          </div>
                          <div class="clearfix"></div>

                          <div class="col-md-12" id="seccion_recursos" style="display:none">
                            <br>
                            <div id="seccion_postulacion">
                              <div class="col-md-6">
                                <div class="caja-cuenta-2" id="recursos1">
                                  <h4 class="caja-cuenta-2-subt"><b>Asignar Ofertas</b></h4>
                                  <label style="margin-bottom: 0px;" for="numPost">N&uacute;mero de Ofertas&nbsp;</label><span class="requerido" title="Este campo es obligatorio">*</span><div id="rec1" class="help-block with-errors" style="margin: 0px; height: 15px;"></div>
                                  <input type="number" min="0" pattern="^[0-9]+" name="num_post" id="num_post" onkeyup="calRec()" onclick="calRec()" onchange="calRec()" onkeydown="return validaNumeros(event);" class="form-control" value="<?php if(isset($planHijo['num_publicaciones_rest']) && !empty($planHijo['num_publicaciones_rest'])){ echo $planHijo['num_publicaciones_rest']; }else{ echo '0'; } ?>" placeholder="0">
                                  <label style="font-size: 12px;">Publicación por asignar: </label>
                                  <div style="display: inline;" id="post_asignar"></div>
                                </div>
                              </div>
                            </div>
                            <div id="pI" class="text-center"></div>
                            <div id="seccion_acceso">
                              <div class="col-md-6">
                                <div class="caja-cuenta-2" id="recursos3">
                                  <h4 class="caja-cuenta-2-subt"><b>Asignar Accesos</b></h4>
                                  <label style="margin-bottom: 0px;" for="numAcces">N&uacute;mero de Accesos&nbsp;</label><span class="requerido" title="Este campo es obligatorio">*</span><div id="rec3" class="help-block with-errors" style="margin: 0px; height: 15px;"></div>
                                      <input type="number" min="0" pattern="^[0-9]+" name="num_accesos" id="num_accesos" onkeyup="calRec()" onclick="calRec()" onchange="calRec()" onkeydown="return validaNumeros(event);" class="form-control" value="<?php if(isset($planHijo['num_accesos_rest']) && !empty($planHijo['num_accesos_rest'])){ echo $planHijo['num_accesos_rest']; }else{ echo '0'; } ?>" placeholder="0">
                                  <label style="font-size: 12px;">Accesos por asignar: </label>
                                  <div style="display: inline;" id="accesos_asignar"></div>
                                </div>
                              </div>
                            </div>
                            <div  id="aI" class="text-center"></div>
                          </div>
                        </div>
                        <br><br>
                        <div class="text-center">
                          <input id="button_editar" type="button" style="margin-bottom:0px" name="button_editar" class="btn-blue disabled" value="Crear Plan">
                        </div>
                    </form>
                </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
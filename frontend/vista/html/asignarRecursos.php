<div class="container"><br>
    <div class="row">
        <div class="main_business">
            <section>
                <div class="container">
                    <div class="col-md-12">
                        <div>
                            <p class="text-center" style="font-size: 20px;margin-bottom: 20px;">Asignar Recursos a - <?php echo $nombreEmp; ?></p>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div id="no-more-tables">
                                    <div class="form-group col-md-12">
                                        <form action = "<?php echo PUERTO."://".HOST;?>/asignarPlanEmpresa/<?php echo $idSubEmpresa; ?>/" method = "post" id="form_editarCuenta" name="form_editarCuenta">
                                            <div class="row">  
                                              <input type="hidden" name="asignarRecursos" id="asignarRecursos" value="1">
                                              <div class="col-md-offset-3 col-md-6">
                                                <div class="form-group" id="seccion_plan">
                                                  <label for="plan">Seleccione un Plan <span class="requerido" title="Este campo es obligatorio">*</span></label><div id="err_plan" class="help-block with-errors"></div>
                                                  <select class="form-control" name="plan" id="plan"   required>
                                                    <option value="0">Seleccione un plan</option>
                                                    <?php 
                                                    if (!empty($planesActivos)){
                                                      foreach($planesActivos as $key => $v){ 
                                                        echo "<option value='".$v['id_empresa_plan']."'>".utf8_encode($v['nombre'])."</option>";
                                                      }
                                                    } ?>
                                                  </select>
                                                </div>
                                              </div>

                                              <div class="clearfix"></div>

                                              <div class="col-md-12" id="seccion_recursos" style="display: none;">
                                                  <hr>
                                                  <h6 class="text-center">Asignar Recursos</h6>
                                                
                                                  <div id="seccion_postulacion" style="display: none;" >
                                                    <div class="col-md-offset-3 col-md-4">
                                                      <div id="recursos1" class="form-group">
                                                        <label for="numPost">N&uacute;mero de Publicaciones</label><span class="requerido" title="Este campo es obligatorio">*</span></label><div id="rec1" class="help-block with-errors"></div>
                                                        <input type="number" min="1" pattern="^[0-9]+" name="num_post" id="num_post" onkeyup="calcularRecursos(); validaRecursos();" onclick="calcularRecursos(); validaRecursos();" onkeydown="return validaNumeros(event);" class="form-control" value="1">
                                                      </div>
                                                    </div> 

                                                    <div class="col-md-2">
                                                      <div class="form-group">
                                                        <label style="font-size: 12px;">Publicaci&oacute;n por asignar: </label>
                                                        <div style="padding-top: 15px;" id="post_asignar"></div>
                                                      </div>
                                                    </div>

                                                    <div class="clearfix"></div>
                                                  </div>
                                                  <div id="pI"></div>
                                                  <div id="seccion_descarga" style="display: none;">
                                                    <div class="col-md-offset-3 col-md-4">
                                                      <div class="form-group" id="recursos2">
                                                        <label for="numDesc">N&uacute;mero de Descargas</label><span class="requerido" title="Este campo es obligatorio">*</span></label><div id="rec2" class="help-block with-errors"></div>
                                                        <input type="number" min="1" pattern="^[0-9]+" name="num_desc" id="num_desc" onkeyup="calcularRecursos(); validaRecursos();" onclick="calcularRecursos(); validaRecursos();" onkeydown="return validaNumeros(event);" class="form-control" value="1">
                                                      </div>
                                                    </div> 

                                                    <div class="col-md-2">
                                                      <div class="form-group">
                                                        <label style="font-size: 12px;">Descargas por asignar: </label>
                                                        <div style="padding-top: 15px;" id="desc_asignar"></div>
                                                      </div>
                                                    </div>

                                                    <div class="clearfix"></div>
                                                  </div>
                                                  <div  id="dI"></div>
                                              </div>
                                            </div>
                                            <br><br>
                                            <div class="row">
                                              <div class="form-group">
                                                <input id="button_crear" type="button" name="btnusu" class="btn btn-success disabled" value="Crear Plan" onclick="enviarRecursos();">  
                                              </div> 
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
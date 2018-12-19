<div class="container"><br>
    <div class="row">
        <div class="main_business">
            <section>
                <div class="container">
                    <div class="col-md-12">
                        <div>
                            <h1 class="text-center" style="font-size: 20px;margin-bottom: 20px;">Editar Plan</h1>
                            <h5 style="color:#989494;"><strong><?php echo $planHijo['nombre']; ?></strong> - 
                            <strong><?php echo $planHijo['nombres']; ?></strong></h5>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div id="no-more-tables">
                                    <div class="form-group col-md-12">
                                        <form action = "<?php echo PUERTO."://".HOST;?>/editarPlanEmpresa/<?php echo $idPlanEmpresa; ?>/" method = "post" id="form_editarCuenta" name="form_editarCuenta">
                                            <div class="row">  
                                              <input type="hidden" name="editarPlan" id="editarPlan" value="1">

                                              <input type="hidden" name="idSubEmpresa" id="idSubEmpresa" value="<?php if(isset($planHijo['id_empresa'])) { echo $planHijo['id_empresa']; } ?>">

                                              <input type="hidden" name="plan" id="plan" value="<?php if(isset($planHijo['id_empresa_plan_parent'])) { echo $planHijo['id_empresa_plan_parent']; } ?>">

                                              <input type="hidden" name="post" id="post" value="<?php if(isset($planHijo['num_publicaciones_rest'])) { echo $planHijo['num_publicaciones_rest']; } ?>">

                                              <input type="hidden" name="desc" id="desc" value="<?php if(isset($planHijo['num_descarga_rest'])) { echo $planHijo['num_descarga_rest']; } ?>">

                                              <div class="col-md-12" id="seccion_recursos">
                                                  <br>     
                                                  <?php if(isset($planPadre['num_publicaciones_rest']) && $planPadre['num_publicaciones_rest'] == -1 && $planPadre['num_descarga_rest'] == -1) { ?>
                                                  <div id="nom_estado">
                                                    <?php if($planHijo['estado'] == 1){ ?>
                                                      <h6><b>Activo</b></h6>
                                                    <?php }else{ ?>
                                                      <h6><b>Inactivo</b></h6>
                                                    <?php } ?>
                                                  </div>
                                                  <div>
                                                    <input name="estado" id="estado" type="checkbox" value="<?php echo $planHijo['estado']; ?>" class="flipswitch_check" onclick="cambiarEstados();" <?php if($planHijo['estado'] == 1){ echo 'checked'; } ?> />
                                                  </div>
                                                  <br> 
                                                <?php } ?>
                                                  <?php if(isset($planPadre['num_publicaciones_rest']) && $planPadre['num_publicaciones_rest'] != -1) { ?>
                                                    <div id="seccion_postulacion">
                                                      <div class="col-md-offset-3 col-md-4">
                                                        <div id="recursos1" class="form-group">
                                                          <label for="numPost">N&uacute;mero de Ofertas</label><span class="requerido" title="Este campo es obligatorio">*</span></label><div id="rec1" class="help-block with-errors"></div>
                                                          <input type="number" min="1" pattern="^[0-9]+" name="num_post" id="num_post" onkeydown="return validaNumeros(event);" onkeyup="calcularRecursos(); validaRecursos();" onclick="calcularRecursos(); validaRecursos();" class="form-control" value="<?php if(isset($planHijo['num_publicaciones_rest'])){ echo $planHijo['num_publicaciones_rest']; }else{ echo '1'; } ?>">
                                                        </div>
                                                      </div> 

                                                      <div class="col-md-2">
                                                        <div class="form-group">
                                                          <label style="font-size: 12px;">Ofertas por asignar: </label>
                                                          <div style="padding-top: 15px;" id="post_asignar"><?php if(isset($planPadre['num_publicaciones_rest'])){ echo $planPadre['num_publicaciones_rest']; } ?></div>
                                                        </div>
                                                      </div>
                                                      <div id="pI" style="display:none">
                                                      <label style="color:red" class="parpadea">Número de Ofertas Ilimitadas</label>
                                                    </div>
                                                      <div class="clearfix"></div>
                                                    </div>
                                                  <?php }else{ ?>
                                                    <div id="pI">
                                                      <label style="color:red" class="parpadea">Número de Ofertas Ilimitadas</label>
                                                    </div>
                                                  <?php } ?>

                                                  <?php if(isset($planPadre['num_descarga_rest']) && $planPadre['num_descarga_rest'] != -1) { ?>
                                                    <div id="seccion_descarga">
                                                      <div class="col-md-offset-3 col-md-4">
                                                        <div class="form-group" id="recursos2">
                                                          <label for="numDesc">N&uacute;mero de Descargas</label><span class="requerido" title="Este campo es obligatorio">*</span></label><div id="rec2" class="help-block with-errors"></div>
                                                          <input type="number" min="1" pattern="^[0-9]+" name="num_desc" id="num_desc" onkeydown="return validaNumeros(event);" onkeyup="calcularRecursos(); validaRecursos();" onclick="calcularRecursos(); validaRecursos();" class="form-control" value="<?php if(isset($planHijo['num_descarga_rest'])){ echo $planHijo['num_descarga_rest']; }else{ echo '1'; } ?>">
                                                        </div>
                                                      </div> 

                                                      <div class="col-md-2">
                                                        <div class="form-group">
                                                          <label style="font-size: 12px;">Descargas por asignar: </label>
                                                          <div style="padding-top: 15px;" id="desc_asignar"><?php if(isset($planPadre['num_descarga_rest'])){ echo $planPadre['num_descarga_rest']; } ?></div>
                                                        </div>
                                                        <div  id="dI" style="display:none">
                                                      <label style="color:red" class="parpadea">Número de Descargas Ilimitadas
                                                      </label>
                                                    </div>
                                                      </div>
                                                      <div class="clearfix"></div>
                                                    </div>
                                                  <?php }else{ ?>
                                                    <div  id="dI">
                                                      <label style="color:red" class="parpadea">Número de Descargas Ilimitadas
                                                      </label>
                                                    </div>
                                                  <?php } ?>
                                                </div>
                                              </div>
                                            </div>
                                            <br><br>
                                            <div class="row">
                                              <div class="form-group">
                                                <input id="button_editar" type="button" name="btnusu" class="btn btn-success" value="Guardar" onclick="enviarRecursos();">  
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
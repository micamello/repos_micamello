<div class="container"><br>
  <div class="row">
    <div class="main_business">
      <section>
        <div class="col-md-12">
          <div class="text-center">
            <h2 class="titulo">Editar Plan <?php echo $planHijo['nombre'].' - '.$planHijo['nombres']; ?></h2><br><br>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>

<?php print_r($planHijo);
#print_r($planPadre); ?>

<div id="registro-algo-centro">
  <div class="container">
    <div class="row">
      <div id="inicio-cuadro">
        <div class="panel-body">
          <div id="no-more-tables">
            <div class="form-group col-md-12">
              <form action = "<?php echo PUERTO."://".HOST;?>/editarPlanEmpresa/<?php echo Utils::encriptar($idPlanEmpresa); ?>/" method = "post" id="form_editarCuenta" name="form_editarCuenta">
                <div class="row">  
                  <input type="hidden" name="editarPlan" id="editarPlan" value="1">
                  <input type="hidden" name="idSubEmpresa" id="idSubEmpresa" value="<?php if(isset($planHijo['id_empresa'])) { echo Utils::encriptar($planHijo['id_empresa']); } ?>">
                  <input type="hidden" name="plan" id="plan" value="<?php if(isset($planHijo['id_empresa_plan_parent'])) { echo Utils::encriptar($planHijo['id_empresa_plan_parent']); } ?>">
                  <input type="hidden" name="post" id="post" value="<?php if(isset($planHijo['num_publicaciones_rest'])) { echo $planHijo['num_publicaciones_rest']; }else{ echo '0'; } ?>">
                  <!--<input type="hidden" name="desc" id="desc" value="<?php #if(isset($planHijo['num_descarga_rest'])) { echo $planHijo['num_descarga_rest']; } ?>">-->
                  <input type="hidden" name="acces" id="acces" value="<?php if(isset($planHijo['num_accesos_rest'])) { echo $planHijo['num_accesos_rest']; }else{ echo '0'; } ?>">

                  <div class="col-md-12" id="seccion_recursos">
                    <br>
                    <div id="seccion_postulacion">
                      <div class="col-md-6">
                        <div class="caja-cuenta-2" id="recursos1">
                          <h4 class="caja-cuenta-2-subt"><b>Asignar Ofertas</b></h4>
                          <label style="margin-bottom: 0px;" for="numPost">N&uacute;mero de Ofertas&nbsp;</label><span title="Este campo es obligatorio">*</span><div id="rec1" class="help-block with-errors" style="margin: 0px; height: 15px;"></div>
                          <input type="number" min="1" pattern="^[0-9]+" name="num_post" id="num_post" onkeyup="calRec()" onclick="calRec()" onkeydown="return validaNumeros(event);" class="form-control" value="<?php if(isset($planHijo['num_publicaciones_rest']) && !empty($planHijo['num_publicaciones_rest'])){ echo $planHijo['num_publicaciones_rest']; }else{ echo '0'; } ?>">
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
                          <label style="margin-bottom: 0px;" for="numAcces">N&uacute;mero de Accesos&nbsp;</label><span title="Este campo es obligatorio">*</span><div id="rec3" class="help-block with-errors" style="margin: 0px; height: 15px;"></div>
                              <input type="number" min="1" pattern="^[0-9]+" name="num_accesos" id="num_accesos" onkeyup="calRec()" onclick="calRec()" onkeydown="return validaNumeros(event);" class="form-control" value="<?php if(isset($planHijo['num_accesos_rest']) && !empty($planHijo['num_accesos_rest'])){ echo $planHijo['num_accesos_rest']; }else{ echo '0'; } ?>">
                          <label style="font-size: 12px;">Accesos por asignar: </label>
                          <div style="display: inline;" id="accesos_asignar"></div>
                        </div>
                      </div>
                    </div>
                    <div  id="aI" class="text-center"></div>

                    <!--<div id="seccion_descarga">
                      <div class="col-md-12">
                        <div class="caja-cuenta-2" id="recursos2">
                          <h4 class="caja-cuenta-2-subt"><b>Asignar Descargas</b></h4>
                          <label style="margin-bottom: 0px;" for="numDesc">N&uacute;mero de Descargas</label><span title="Este campo es obligatorio">*</span><div id="rec3" class="help-block with-errors" style="margin: 0px; height: 15px;"></div>
                              <input type="number" min="1" pattern="^[0-9]+" name="num_desc" id="num_desc" onkeyup="calRec()" onclick="calRec()" onkeydown="return validaNumeros(event);" class="form-control" value="<?php #if(isset($planHijo['num_descarga_rest']) && !empty($planHijo['num_descarga_rest'])){ echo $planHijo['num_descarga_rest']; }else{ echo '1'; } ?>">
                          <label style="font-size: 12px;">Descargas por asignar: </label>
                          <div style="display: inline;" id="desc_asignar"></div>
                        </div>
                      </div>
                    </div>
                    <div  id="dI" class="col-md-12 text-center"></div>-->
                  </div>
                  <input type="hidden" name="postNum" id="postNum" value="">
                  <!--<input type="hidden" name="descNum" id="descNum" value="">-->
                  <input type="hidden" name="accesNum" id="accesNum" value="">
                </div>
              </form>
            </div>
            <br><br>
            <div class="text-center">
              <input id="button_editar" type="button" style="margin-bottom:0px" name="button_editar" class="btn-blue" value="Guardar">  
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
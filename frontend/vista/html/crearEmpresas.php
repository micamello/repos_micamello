<div class="container"><br>
  <div class="row">
    <div class="main_business">
      <section>
        <div class="col-md-12">
          <div class="text-center">
            <h2 class="titulo">Crear cuenta</h2><br><br>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
<?php #print_r($data); ?>
<div id="registro-algo-centro">
  <div class="container">
    <div class="row">
      <div id="inicio-cuadro">
        <div class="panel-body">
            <div id="no-more-tables">
                <div class="form-group col-md-12">
                    <form action = "<?php echo PUERTO."://".HOST;?>/crearEmpresas/" method = "post" id="form_crearCuenta" name="form_crearCuenta">
                      <div class="row">  
                        <input type="hidden" name="form_crear_input" id="form_crear_input" value="1">
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

                        <div class="col-md-12">
                          <hr>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="seccion_nombre">
                              <p class="campo">Nombres de la empresa&nbsp;<i>*</i></p><div id="err_nom" class="help-block with-errors"></div>
                              <input type="text" name="name_user" id="name_user" placeholder="Ejemplo: micamellosa" maxlength="100" class="form-control" value="<?php if(isset($data['name_user']) && !empty($data['name_user'])){ echo $data['name_user']; } ?>">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" id="sector">
                              <p class="campo">Sector Industrial&nbsp;<i>*</i></p><div id="err_sector" class="help-block with-errors"></div>
                              <select id="sectorind" name="sectorind" class="espacio form-control">
                                <option value="0" selected="selected" disabled="disabled">Seleccione una opción</option>
                                <?php 
                                  if(!empty($arrsectorind)){
                                    foreach($arrsectorind as $sectorind){
                                      echo "<option value='".$sectorind['id_sectorindustrial']."'";
                                      if(isset($data['sectorind']) && $data['sectorind'] == $sectorind['id_sectorindustrial']){
                                        echo "selected='selected'";
                                      }
                                      echo ">".utf8_encode($sectorind['descripcion'])."</option>";
                                    }
                                  }
                                ?>
                            </select>
                            </div>
                        </div>

                        <div class="col-md-12 form-group" id="correo_group">
                          
                            <p class="campo">Correo&nbsp;<i>*</i></p><div id="correo_div_error" class="help-block with-errors"></div>
                            <input id="correo" type="email" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Ingrese un correo electrónico válido' : '')" name="correo" placeholder="Ejemplo: camello@gmail.com" maxlength="100" class="form-control" aria-describedby="correoHelp" value="<?php if(isset($data['correo']) && !empty($data['correo'])){ echo $data['correo']; } ?>">
                      
                        </div>      

                        <div class="col-md-6">
                           <div class="form-group" id="seccion_num">
                             <p for="numero_cand" class="campo">Tel&eacute;fono&nbsp;<i>*</i></p><div id="err_num" class="help-block with-errors"></div>
                             <input type="text" class="form-control" name="numero_cand" id="numero_cand" minlength="10" maxlength="25" onkeydown="return validaNumeros(event);" value="<?php if(isset($data['numero_cand']) && !empty($data['numero_cand'])){ echo $data['numero_cand']; } ?>">
                           </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" id="dni_group">
                              <p class="campo">RUC&nbsp;<i>*</i></p><div id="dni_error" class="help-block with-errors"></div>
                              <input type="text" name="dni" id="dni" onkeydown="return validaNumeros(event)" minlength="13" maxlength="13" class="form-control" value="<?php if(isset($data['dni']) && !empty($data['dni'])){ echo $data['dni']; } ?>">
                            </div>
                        </div>

                        <div class="col-md-12" id="contact_company_section">
                          <hr>
                          <h4 class="text-center" style="color: #4b5052;">Datos de contacto</h4>
                        
                          <!-- Empresas contacto -->
                          <div class="col-md-6 form-group" id="group_nombre_contact">
                              <p class="campo">Nombres&nbsp;<i>*</i></p><div id="nom_cont" class="help-block with-errors"></div>
                              <input type="text" name="nombre_contact" id="nombre_contact" placeholder="Ejemplo: Juan David" maxlength="100" class="form-control" value="<?php if(isset($data['nombre_contact']) && !empty($data['nombre_contact'])){ echo $data['nombre_contact']; } ?>">
                          </div>  

                          <div class="col-md-6 form-group" id="group_apell_contact">
                            <p class="campo">Apellidos&nbsp;<i>*</i></p><div id="err_apell" class="help-block with-errors"></div>
                            <input type="text" name="apellido_contact" id="apellido_contact" placeholder="Ejemplo: Ortíz Zambrano" maxlength="100" class="form-control" value="<?php if(isset($data['apellido_contact']) && !empty($data['apellido_contact'])){ echo $data['apellido_contact']; } ?>">
                          </div> 

                          <div class="col-md-6 form-group" id="group_num1_contact">
                            <p class="campo">Celular&nbsp;<i>*</i></p><div id="tel_err" class="help-block with-errors"></div>
                            <input type="text" name="tel_one_contact" id="tel_one_contact" minlength="10" maxlength="25" class="form-control" onkeydown="return validaNumeros(event);" value="<?php if(isset($data['tel_one_contact']) && !empty($data['tel_one_contact'])){ echo $data['tel_one_contact']; } ?>">
                          </div> 

                          <div class="col-md-6 form-group" id="group_num2_contact">
                            <p class="campo">Convencional (opcional)</p><div id="tel_err2" class="help-block with-errors"></div>
                            <input type="text" name="tel_two_contact" id="tel_two_contact" minlength="9" maxlength="9" class="form-control" onkeydown="return validaNumeros(event);" value="<?php if(isset($data['tel_two_contact']) && !empty($data['tel_two_contact'])){ echo $data['tel_two_contact']; } ?>">
                          </div> 
                        </div>

                        <div class="col-md-12" id="seccion_recursos" style="display: none;">
                          <hr>
                          <div id="seccion_postulacion" style="display: none;" >
                            <div class="col-md-6">
                              <div class="caja-cuenta-2" id="recursos1">
                                <h4 class="caja-cuenta-2-subt"><b>Asignar Ofertas</b></h4>
                                <label style="margin-bottom: 0px;" for="numPost">N&uacute;mero de Ofertas&nbsp;</label><span title="Este campo es obligatorio">*</span><div id="rec1" class="help-block with-errors" style="margin: 0px; height: 15px;"></div>
                                <input type="number" min="0" pattern="^[0-9]+" name="num_post" id="num_post" onkeyup="calRec()" onclick="calRec()" onkeydown="return validaNumeros(event);" class="form-control" value="<?php if(isset($data['num_post']) && !empty($data['num_post'])){ echo $data['num_post']; }else{ echo '0'; } ?>" placeholder="0">
                                <label style="font-size: 12px;">Publicación por asignar: </label>
                                <div style="display: inline;" id="post_asignar"></div>
                              </div>
                            </div>
                          </div>
                          <div id="pI" class="text-center"></div>

                          <div id="seccion_acceso" style="display: none;">
                            <div class="col-md-6">
                              <div class="caja-cuenta-2" id="recursos3">
                                <h4 class="caja-cuenta-2-subt"><b>Asignar Accesos</b></h4>
                                <label style="margin-bottom: 0px;" for="numAcces">N&uacute;mero de Accesos&nbsp;</label><span title="Este campo es obligatorio">*</span><div id="rec3" class="help-block with-errors" style="margin: 0px; height: 15px;"></div>
                                    <input type="number" min="0" pattern="^[0-9]+" name="num_accesos" id="num_accesos" onkeyup="calRec()" onclick="calRec()" onkeydown="return validaNumeros(event);" class="form-control" value="<?php if(isset($data['num_accesos']) && !empty($data['num_accesos'])){ echo $data['num_accesos']; }else{ echo '0'; } ?>" placeholder="0">
                                <label style="font-size: 12px;">Accesos por asignar: </label>
                                <div style="display: inline;" id="accesos_asignar"></div>
                              </div>
                            </div>
                          </div>
                          <div  id="aI" class="text-center"></div>

                          <!--<div id="seccion_descarga" style="display: none;">
                            <div class="col-md-12">
                              <div class="caja-cuenta-2" id="recursos2">
                                <h4 class="caja-cuenta-2-subt"><b>Asignar Descargas</b></h4>
                                <label style="margin-bottom: 0px;" for="numDesc">N&uacute;mero de Descargas</label><span title="Este campo es obligatorio">*</span><div id="rec3" class="help-block with-errors" style="margin: 0px; height: 15px;"></div>
                                    <input type="number" min="1" pattern="^[0-9]+" name="num_desc" id="num_desc" onkeyup="calRec()" onclick="calRec()" onkeydown="return validaNumeros(event);" class="form-control" value="<?php #if(isset($data['num_desc']) && !empty($data['num_desc'])){ echo $data['num_desc']; }else{ echo '1'; } ?>">
                                <label style="font-size: 12px;">Descargas por asignar: </label>
                                <div style="display: inline;" id="desc_asignar"></div>
                              </div>
                            </div>
                          </div>
                          <div  id="dI" class="col-md-12 text-center"></div>-->
                        </div>
                      </div>
                      <br><br>

                     
                        <input type="hidden" name="postNum" id="postNum" value="">
                        <!--<input type="hidden" name="descNum" id="descNum" value="">-->
                        <input type="hidden" name="accesNum" id="accesNum" value="">
                     
                     <!-- <div class="row">
                        <div class="form-group">
                          <input id="button_crear" type="button" name="btnusu" class="btn btn-success disabled" value="Crear Cuenta">  
                        </div> 
                      </div>-->
                      <div class="text-center">
                        <input id="button_crear" type="button" style="margin-bottom:0px"name="btnusu" class="btn-blue disabled" value="Crear Cuenta">  
                      </div>
                    </form>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
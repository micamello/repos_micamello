<div class="container"><br>
    <div class="row">
        <div class="main_business">
            <section>
                <div class="container">
                    <div class="col-md-12">
                        <div>
                            <p class="text-center" style="font-size: 20px;margin-bottom: 20px;">Crear Cuenta</p>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div id="no-more-tables">
                                    <div class="form-group col-md-12">
                                        <form action = "<?php echo PUERTO."://".HOST;?>/crearEmpresas/" method = "post" id="form_crearCuenta" name="form_crearCuenta">
                                            <div class="row">  
                                              <input type="hidden" name="form_crear_input" id="form_crear_input" value="1">
                                              <div class="col-md-offset-3 col-md-6">
                                                <div class="form-group" id="seccion_plan">
                                                  <label for="plan">Seleccione un Plan <span class="requerido" title="Este campo es obligatorio">*</span></label><div id="err_plan" class="help-block with-errors"></div>
                                                  <select class="form-control" name="plan" id="plan">
                                                    <option value="0">Seleccione un plan</option>
                                                    <?php 
                                                    if (!empty($planesActivos)){
                                                      foreach($planesActivos as $key => $v){ 
                                                        echo "<option value='".Utils::encriptar($v['id_empresa_plan'])."'>".utf8_encode($v['nombre']).' - Fecha de compra: '.$v['fecha_compra']."</option>";
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
                                                    <p class="text-center text_form">Nombres de la empresa&nbsp;<i class="requerido">*</i></p><div id="err_nom" class="help-block with-errors"></div>
                                                    <input type="text" name="name_user" id="name_user" placeholder="Ejemplo: micamellosa" maxlength="100" class="form-control">
                                                  </div>
                                              </div>

                                              <div class="col-md-6 form-group" id="correo_group">
                                                
                                                  <p class="text-center text_form">Correo&nbsp;<i class="requerido">*</i></p><div id="correo_div_error" class="help-block with-errors"></div>
                                                  <input id="correo" type="email" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Ingrese un correo electrónico válido' : '')" name="correo" placeholder="Ejemplo: camello@gmail.com" maxlength="100" class="form-control" aria-describedby="correoHelp">
                                            
                                              </div>      

                                              <div class="col-md-6">
                                                 <div class="form-group" id="seccion_num">
                                                   <p for="numero_cand" class="text-center text_form">Celular&nbsp;<i class="requerido">*</i></p><div id="err_num" class="help-block with-errors" id="error_custom_cel"></div>
                                                   <input type="text" class="form-control" name="numero_cand" id="numero_cand" maxlength="25" onkeydown="return validaNumeros(event);">
                                                 </div>
                                              </div>

                                              <div class="col-md-6">
                                                  <div class="form-group" id="dni_group">
                                                    <p class="text-center text_form">RUC&nbsp;<i class="requerido">*</i></p><div id="dni_error" class="help-block with-errors"></div>
                                                    <input type="text" name="dni" id="dni" maxlength="25" class="form-control">
                                                  </div>
                                              </div>

                                              <div class="col-md-12" id="contact_company_section">
                                                <hr>
                                                <h6 class="text-center">Datos de contacto</h6>
                                              
                                                <!-- Empresas contacto -->
                                                <div class="col-md-6 form-group" id="group_nombre_contact">
                                                    <p class="text-center text_form">Nombres&nbsp;<i class="requerido">*</i></p><div id="nom_cont" class="help-block with-errors"></div>
                                                    <input type="text" name="nombre_contact" id="nombre_contact" placeholder="Ejemplo: Juan David" maxlength="100" class="form-control">
                                                </div>  

                                                <div class="col-md-6 form-group" id="group_apell_contact">
                                                  <p class="text-center text_form">Apellidos&nbsp;<i class="requerido">*</i></p><div id="err_apell" class="help-block with-errors"></div>
                                                  <input type="text" name="apellido_contact" id="apellido_contact" placeholder="Ejemplo: Ortíz Zambrano" maxlength="100" class="form-control">
                                                </div> 

                                                <div class="col-md-6 form-group" id="group_num1_contact">
                                                  <p class="text-center text_form">Teléfono 1&nbsp;<i class="requerido">*</i></p><div id="tel_err" class="help-block with-errors"></div>
                                                  <input type="text" name="tel_one_contact" id="tel_one_contact" maxlength="25" class="form-control" onkeydown="return validaNumeros(event);">
                                                </div> 

                                                <div class="col-md-6 form-group" id="group_num2_contact">
                                                  <p class="text-center text_form">Teléfono 2 (opcional):</p><div id="tel_err2" class="help-block with-errors"></div>
                                                  <input type="text" name="tel_two_contact" id="tel_two_contact" maxlength="25" class="form-control" onkeydown="return validaNumeros(event);">
                                                </div> 
                                              </div>
                                              <div class="col-md-12" id="seccion_recursos" style="display: none;">
                                                  <hr>
                                                  <h6 class="text-center">Asignar Ofertas</h6>
                                                
                                                  <div id="seccion_postulacion" style="display: none;" >
                                                    <div class="col-md-offset-3 col-md-4">
                                                      <div id="recursos1" class="form-group">
                                                        <label for="numPost">N&uacute;mero de Ofertas</label><span class="requerido" title="Este campo es obligatorio">*</span></label><div id="rec1" class="help-block with-errors"></div>
                                                        <input type="number" min="1" pattern="^[0-9]+" name="num_post" id="num_post" onkeyup="calcularRecursos()" onclick="calcularRecursos()" onkeydown="return validaNumeros(event);" class="form-control" value="1">
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
                                                        <input type="number" min="1" pattern="^[0-9]+" name="num_desc" id="num_desc" onkeyup="calcularRecursos()" onclick="calcularRecursos()" onkeydown="return validaNumeros(event);" class="form-control" value="1">
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
                                            <input type="hidden" name="postNum" id="postNum" value="">
                                            <input type="hidden" name="descNum" id="descNum" value="">
                                            <div class="row">
                                              <div class="form-group">
                                                <input id="button_crear" type="button" name="btnusu" class="btn btn-success disabled" value="Crear Cuenta">  
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
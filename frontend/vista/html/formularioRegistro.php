<!--<section id="product" class="inicio">-->
    <div id="candidato">
        <div class="container" >
            <div class="row" id="registro-algo-centro">
                <div class="col-md-10 col-md-offset-1" id="inicio-cuadro">
                     <div class="text-right">
                         <div class="btn-group controlTipo">
                          <button type="button" id="btnCand" class="btn btn-lg btn-primary">Candidato</button>
                          <button type="button" id="btnEmp" class="btn btn-lg btn-default">Empresa</button>
                        </div>
                     </div>
                    <h3 class="registro-titulo">Registrarse como Candidato</h3>
                        <form action="<?php echo PUERTO.'://'.HOST.'/registroUsuario/' ?>" method="POST" id="registroFormulario">

                            <input type="hidden" name="tipo_usuario" id="tipo_usuario">
                            <input type="hidden" name="tipo_documentacion" id="tipo_documentacion">
                            <input type="hidden" name="formularioRegistro" id="formularioRegistro" value="1">

                            <div class="col-md-6 form-group">
                                <div></div>
                                <input type="text" name="nombresCandEmp" class="espacio form-control" id="nombresCandEmp" placeholder="Nombres *">
                            </div>
                            <div class="col-md-6 form-group">
                                <div></div>
                                <input type="text" class="espacio  form-control" placeholder="Apellidos *" name="apellidosCand" id="apellidosCand"/>
                            </div>
                            <div class="col-md-6 form-group">
                                <div></div>
                                <select id="sectorind" name="sectorind" class="espacio form-control">
                                    <option value="" selected="selected" disabled="disabled">Sector industrial *</option>
                                    <?php 
                                      if(!empty($arrsectorind)){
                                        foreach($arrsectorind as $sectorind){
                                          echo "<option value='".$sectorind['id_sectorindustrial']."'>".utf8_encode($sectorind['descripcion'])."</option>";
                                        }
                                      }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <div></div>
                                <input type="text" class="espacio form-control" placeholder="Correo *" id="correoCandEmp" name="correoCandEmp" />
                            </div>

                            <div class="col-md-6 form-group">
                                <div></div>
                                <input type="text" class="espacio form-control" placeholder="Célular *" id="celularCandEmp" name="celularCandEmp"/>
                            </div>

                            <div class="col-md-6 form-group">
                                <div></div>
                                <select class=" espacio form-control" id="tipoDoc" name="tipoDoc">
                                    <option value="">Tipo documentación *</option>
                                        <?php 
                                            foreach (TIPO_DOCUMENTO as $key => $value) {
                                                if($key != 1){
                                                echo "<option value='".$key."'>".utf8_encode($value)."</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <div></div>
                                <input type="text" class="espacio form-control" placeholder="Documento *" id="documentoCandEmp" name="documentoCandEmp"/>
                            </div>

                            <div class="col-md-6 form-group">
                                <div></div>
                                <input placeholder="Fecha de Nacimiento *" type="text" data-field="date" class="espacio form-control" name="fechaNac" id="fechaNac">
                                <div id="fechaShow"></div>
                                <div id="errorFechaUsuario"></div>
                            </div>

                            <div class="col-md-6 form-group" id="altura-44">
                                <div></div>
                                <select class="espacio form-control" name="generoUsuario" id="generoUsuario">
                                    <option value="" selected="selected" disabled="disabled">Género *   </option>
                                    <?php 
                                      if(!empty($arrgenero)){
                                        foreach ($arrgenero as $gen) {
                                          echo "<option value='".$gen['id_genero']."'>".$gen['descripcion']."</option>";
                                        }
                                      }
                                    ?>
                                  </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <div></div>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-eye"></i></div>
                                    <input type="password" class="espacio form-control" placeholder="Contraseña *" value="" id="password_1" name="password_1"/>
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <div></div>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-eye"></i></div>
                                    <input type="password" class="espacio form-control"  placeholder="Repita Contraseña *" id="password_2" name="password_2"/>
                                </div>
                            </div>

                            <div id="datosContactoLabel" style="text-align: center;" class="col-md-12 form-group">
                                <label>Datos de contacto</label>
                            </div>

                            <div class="col-md-6 form-group">
                                <div></div>
                                <input type="text" class="espacio form-control" placeholder="Nombres *" id="nombreConEmp" name="nombreConEmp"/>
                            </div>

                            <div class="col-md-6 form-group">
                                <div></div>
                                <input type="text" class="espacio form-control" placeholder="Apellidos *" id="apellidoConEmp" name="apellidoConEmp"/>
                            </div>

                            <div class="col-md-6 form-group">
                                <div></div>
                                <input type="text" class="espacio form-control" placeholder="Célular *" id="tel1ConEmp" name="tel1ConEmp"/>
                            </div>

                            <div class="col-md-6 form-group">
                                <div></div>
                                <input type="text" class="espacio form-control" placeholder="Convencional (opcional) *" id="tel2ConEmp" name="tel2ConEmp"/>
                            </div>


                            <div class="col-md-12 text-center">
                                <div class="form-group check_box">
                                    <div class="checkbox subt-registro">

                                        <label>
                                            <div></div>
                                            <input type="checkbox" class="terminosCond" name="terminosCond" id="terminosCond"> He le&iacute;do y acepto las <a class="link" href="<?php echo PUERTO.'://'.HOST; ?>/docs/politicas_de_privacidad1.pdf" target="_blank">pol&iacute;ticas de privacidad</a> y <a class="link" href="<?php echo PUERTO.'://'.HOST; ?>/docs/terminos_y_condiciones1.pdf" target="_blank">t&eacute;rminos y condiciones</a>
                                        </label>
                                        <label>Nota: Después de registrarte le llegará un E-mail para validar tu cuenta</label>
                                    </div>
                                </div>
                                <input type="submit" class="btn-blue"  value="Registrarse"/>
                                <div class="subt-registro" style="padding-bottom: 20px">
                                    <label>¿Ya tienes una cuenta? <a class="link" href="<?php echo PUERTO.'://'.HOST.'/login/' ?>">Inicia sesión</a></label><br>
                                    <div id="socialRegistro">
                                        <label>O puedes acceder con:</label>
                                        <br><br>
                                        <a id="regEmpMic" onclick="window.location = '<?php echo $social['fb']; ?>'"><i class="acceso-social fa fa-facebook"></i></a>

                                        <a id="regEmpMic" onclick="window.location = '<?php echo $social['tw'] ?>'"><i class="acceso-social fa fa-twitter"></i></a>

                                        <a id="regEmpMic" onclick="window.location = '<?php echo $social['gg'] ?>'"><i class="acceso-social fa fa-google"></i></a>

                                        <a id="regEmpMic" onclick="window.location = '<?php echo $social['lk'] ?>'"><i class="acceso-social fa fa-linkedin"></i></a>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<!--/section>-->
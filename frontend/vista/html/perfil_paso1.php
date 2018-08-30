<?php if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?>
<div class="container">
	<div class="checkout-wrap">
	  <ul class="checkout-bar">
	    <li class="visited">Registro</li>    
	    <li class="active">Completar Perfil</li>
	    <?php for($i=1;$i<=$nrototaltest;$i++){ ?>
	      <li class="">Formulario <?php echo $i;?></li>                
	    <?php } ?>
	  </ul>
	</div>
</div>
<br>
<?php } ?>


<!--<section id="product" class="product">-->
    <div class="container"><br><br>
        <form role="form" name="form1" id="form_editarPerfil" method="post" action="<?php echo PUERTO."://".HOST;?>/<?php if($btnSig == 0){ echo 'editarperfil'; }else{ echo 'cuestionario'; } ?>/" enctype="multipart/form-data">
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="panel panel-default shadow" style="border-radius: 20px;">
                    	<img id="imagen_perfil" width="100%" alt="fotoPerfil" src="<?php echo Modelo_Usuario::obtieneFoto($_SESSION['mfo_datos']['usuario']['id_usuario']); ?>" style="border-radius: 20px 20px 0px 0px;">
                        <label for="file-input" class="custom_file"><img class="button-center" src="<?php echo PUERTO."://".HOST."/imagenes/upload-icon.png";?>" width="50px"></label>
						<input id="file-input" type="file" name="file-input" <?php if($btnSig == 1){ echo 'disabled'; } ?> class="upload-photo">
                        <div align="center">
                            <p class="text-center">Actualizar foto de perfil</p>
                            <br>
                        </div>
                    </div>
                    <?php if($cargarHv){ ?>
	                    <div class="panel panel-default shadow" style="border-radius: 20px;">
	                    	
	                    	<img id="archivo" width="100%" alt="hoja_de_vida" src="<?php echo PUERTO."://".HOST."/imagenes/Hv.jpg";?>" style="border-radius: 20px 20px 0px 0px;">
	                       
	                       <?php if($btnDescarga == 1){ ?>
		                       	<div <?php if($btnSig == 0){ echo 'class="pull-left" style="position: relative; margin-left: 15px;"'; } ?>>
			                        <label for="descargarCV" class="custom_file">
			                        	<a href="<?php echo $ruta_arch; ?>" target="_blank">
			                        		<img id="imagenBtn1" class="button-center" src="<?php echo PUERTO."://".HOST."/imagenes/$imgArch1";?>" width="50px">
			                        	</a>
			                        </label>
									<input id="descargarCV" type="file" name="descargarCV" <?php if($btnSig == 1){ echo 'disabled'; } ?> class="upload-photo">
									<div align="center">
			                            <p class="text-center arch_cargado" id="texto_status1"><?php echo $msj1; ?></p>
			                        </div>
			                    </div>
			                    <br>
							<?php } ?>
							<?php if($btnSubir == 1){ ?>
								<div <?php if($btnDescarga == 1){ echo 'class="pull-right" style="position: relative; margin-right: 15px;"'; } ?>>
			                        <label for="subirCV" class="custom_file">
			                        	<img id="imagenBtn" class="button-center" src="<?php echo PUERTO."://".HOST."/imagenes/$imgArch2";?>" width="50px">
			                        </label>
			                   		<input id="subirCV" type="file" name="subirCV" class="upload-photo">
			                   		<div align="center">
		                            	<p class="text-center arch_cargado" id="texto_status"><?php echo $msj2; ?></p>
		                        	</div>
								</div>
								<br>
	                        <?php }

	                        if($btnDescarga == 1 && $btnSubir == 1 && $btnSig == 0){ echo '<br><br><br>'; } ?>
	                    </div>
                	<?php } ?>
                </div>
	            <div class="col-md-8">
	                <div class="panel panel-default shadow" style="border-radius: 20px;">
	                    <div class="panel-body">
				            <div class="row">
				            	<div class="main_business">
	                                <div class="col-md-12">
	                                	<div class="col-md-12">
		                                    <div class="form-group">
		                                        <label for="username">Usuario:
		                                        	<h4 class="usuario">
		                                        	   <u><?php echo $_SESSION['mfo_datos']['usuario']['username']; ?></u>
		                                        	</h4><?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::CANDIDATO) { ?>
		                                        	<h6>RUC: <?php echo $_SESSION['mfo_datos']['usuario']['dni']; ?></h6><?php } ?>
		                                        </label>		                                        
		                                    </div>
	                                    </div>
	                                    <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?>
	                                    <div class="col-md-6">
		                                    <div class="form-group">

		                                        <label for="dni">C&eacute;dula</label><div class="help-block with-errors"></div>

		                                        <input class="form-control" type="text" id="dni" readonly value="<?php echo $_SESSION['mfo_datos']['usuario']['dni']; ?>" />
		                                    </div>
	                                    </div>
	                                	<?php } ?>
	                                    <div class="col-md-6">
		                                    <div class="form-group">

		                                        <label for="correo">Correo </label><div class="help-block with-errors"></div>

		                                        <input class="form-control" id="correo" type="email" readonly value="<?php echo $_SESSION['mfo_datos']['usuario']['correo']; ?>"/>
		                                    </div>
	                                    </div>
	                                    <div class="col-md-6">
	                                        <div class="form-group">

	                                            <label for="nombres"><?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?> Nombres <?php }else{ ?> Nombre de la empresa<?php } ?></label><div class="help-block with-errors"></div>
	                                			<input class="form-control" type="text" id="nombres" name="nombres" value="<?php echo $_SESSION['mfo_datos']['usuario']['nombres']; ?>" pattern="[a-z A-ZñÑáéíóúÁÉÍÓÚ]+" <?php if($btnSig == 1){ echo 'readonly'; } ?> required/>
	                                        </div>
	                                    </div>
	                                    <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?>
	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="apellidos">Apellidos</label><div class="help-block with-errors"></div>
	                                			<input class="form-control" type="text" id="apellidos" name="apellidos" value="<?php echo $_SESSION['mfo_datos']['usuario']['apellidos']; ?>" pattern='[a-z A-ZñÑáéíóúÁÉÍÓÚ]+' <?php if($btnSig == 1){ echo 'readonly'; } ?> required/>
	                                        </div>
	                                    </div>
	                                    <?php } ?>

	                                    		
	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="provincia">Provincia</label><div class="help-block with-errors"></div>
	                                            <select class="form-control" name="provincia" id="provincia" <?php if($btnSig == 1){ echo 'readonly'; } ?> required>
	                                            	<option value="">Seleccione una provincia</option>
													<?php 
													if (!empty($arrprovincia)){
				                                    	foreach($arrprovincia as $key => $pr){ 
															echo "<option value='".$pr['id_provincia']."'";

															if ($provincia == $pr['id_provincia'])

															{ 
																echo " selected='selected'";
															}
															echo ">".utf8_encode($pr['nombre'])."</option>";
														}
													} ?>
												</select>
	                                        </div>
	                                    </div>

	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="ciudad">Ciudad</label><div class="help-block with-errors"></div>
	                                            <select id="ciudad" name="ciudad" class="form-control" <?php if($btnSig == 1){ echo 'readonly'; } ?> required>
	                                            <?php 
	                                            if(!empty($arrciudad)){
			                                    	foreach($arrciudad as $key => $ciudad){ 
														echo "<option value='".$ciudad['id_ciudad'];
														if ($_SESSION['mfo_datos']['usuario']['id_ciudad'] == $key)
														{  
															echo " selected='selected'";
														}
														echo "'>".utf8_encode($ciudad['ciudad'])."</option>";
													} 
	                                            }else{ ?>
													<option value="">Selecciona una ciudad</option>
	                                            <?php } ?>
	                                            </select>
	                                        </div>
	                                    </div>					
	                                    <div class="col-md-6">
		                                    <div id="mayoria"  class="form-group">
		                                        <label for="mayor_edad"><?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?> Fecha de Nacimiento <?php }else{ ?> Fecha de Apertura <?php } ?></label><div id="error" class="help-block with-errors"></div>
		                                        <input class="form-control" type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="<?php echo date('Y-m-d',strtotime($_SESSION['mfo_datos']['usuario']['fecha_nacimiento'])); ?>" <?php if($btnSig == 1){ echo 'readonly'; } ?> <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?> onchange="calcularEdad()" <?php } ?> placeholder="dd/mm/aaaa" required/>
		                                    </div>
	                                    </div>

	                                    <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?>
	                                    <div class="col-md-6">
	                                    	<div class="form-group">
		                                    	<label for="discapacidad">Discapacidad</label><div class="help-block with-errors"></div>
			                                    <select id="discapacidad" name="discapacidad" class="form-control" <?php if($btnSig == 1){ echo 'readonly'; } ?> required>
			                                    	<option value="">Tiene alguna discapacidad&#63;</option>
			                                    	<?php 
			                                    	foreach(DISCAPACIDAD as $key => $dis){ 
														echo "<option value='$key'";
														if ($_SESSION['mfo_datos']['usuario']['discapacidad'] == $key)
														{ 
															echo " selected='selected'";
														}
														echo ">$dis</option>";
													} ?>
												</select>
											</div>
										</div>
										<div class="clearfix"></div>
										<div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="experiencia">A&ntilde;os de Experiencia</label><div class="help-block with-errors"></div>
	                                            <select id="experiencia" name="experiencia" class="form-control" <?php if($btnSig == 1){ echo 'readonly'; } ?> required>
	                                            	<option value="">Seleccione una opci&oacute;n</option>
	                                            <?php 
			                                    	foreach(ANOSEXP as $key => $exp){ 
														echo "<option value='$key'";
														if ($_SESSION['mfo_datos']['usuario']['anosexp'] == $key)
														{ 
															echo " selected='selected'";
														}
														echo ">$exp</option>";
													} ?>
	                                            </select>
	                                        </div>
	                                    </div>
	                                <?php } ?>
	                                	
	                                    <div class="col-md-6">
		                                    <div class="form-group">
		                                        <label for="telefono">Tel&eacute;fono </label><div class="help-block with-errors"></div>
		                                        <input class="form-control" id="telefono" name="telefono" minlength="10" maxlength="15" pattern='[0-9]+' onclick="numero_validate(this);" value="<?php echo $_SESSION['mfo_datos']['usuario']['telefono']; ?>" <?php if($btnSig == 1){ echo 'readonly'; } ?> required/>
		                                    </div>
	                                    </div>
	                                    <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?>
	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="genero">G&eacute;nero</label><div class="help-block with-errors"></div>
	                                            <select id="genero" name="genero" class="form-control" <?php if($btnSig == 1){ echo 'readonly'; } ?> required>
													<option value="">Seleccione un genero</option>
			                                    	<?php 
			                                    	foreach(GENERO as $key => $ge){ 
														echo "<option value='$key'";
														if ($_SESSION['mfo_datos']['usuario']['genero'] == $key)
														{ 
															echo " selected='selected'";
														}
														echo ">$ge</option>";
													} ?>
	                                            </select>
	                                        </div>
	                                    </div>
	                                    <div class="col-md-3" style="padding-right: 0px;">
	                                        <div class="form-group">
	                                            <label for="escolaridad">Escolaridad</label><div class="help-block with-errors"></div>
	                                            <select id="escolaridad" name="escolaridad" class="form-control" style="padding-left: 0px;" <?php if($btnSig == 1){ echo 'readonly'; } ?> required>
													<?php 
													if (!empty($escolaridad)){
				                                    	foreach($escolaridad as $key => $es){ 
															echo "<option value='".$es['id_escolaridad']."'";
															if ($_SESSION['mfo_datos']['usuario']['id_escolaridad'] == $es['id_escolaridad'])
															{ 
																echo " selected='selected'";
															}
															echo ">".utf8_encode($es['descripcion'])."</option>";
														}
													} ?>
												</select>
	                                        </div>
	                                    </div>	                                    
	                                    <div class="col-md-3">
	                                    	<div class="form-group">
	                                    		<label for="estatus">Estatus</label><div class="help-block with-errors"></div>

	                                    		<?php foreach(STATUS_CARRERA as $key => $status){ 
	                                    			echo "<div class='form-check'>
												  		<input class='form-check-input' type='radio' name='status_carrera' id='radio1' value='$key'";
												  	if($btnSig == 1){ echo ' disabled'; } 
												  	echo " required";
													if ($_SESSION['mfo_datos']['usuario']['status_carrera'] == $key)
													{ 
														echo " checked";
													}
													echo ">$status</div>";
												} ?>
												

											</div>
	                                    </div>
	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="area_select">&Aacute;reas de inter&eacute;s </label><span class="help-text"> (m&aacute;x 3)</span><div class="help-block with-errors"></div>
	                                            <select class="form-control" multiple id="area_select" data-selectr-opts='{"maxSelection": 3 }' name="area_select[]" <?php if($btnSig == 1){ echo 'disabled'; } ?> required>
													<?php 
													if (!empty($arrarea)){
				                                    	foreach($arrarea as $key => $ae){ 
															echo "<option value='".$ae['id_area']."'";
															if (in_array($ae['id_area'], $areaxusuario))
															{ 

																echo " selected='selected'";

															}
															echo ">".utf8_encode($ae['nombre'])."</option>";
														} 
													}?>
												</select>
	                                        </div>
	                                    </div>
	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="nivel_interes">Niveles de inter&eacute;s </label><span class="help-text"> (m&aacute;x 2)</span><div class="help-block with-errors"></div>
	                                            <select class="form-control" multiple id="nivel_interes" data-selectr-opts='{"maxSelection": 2 }' name="nivel_interes[]" <?php if($btnSig == 1){ echo 'disabled'; } ?> required>
													<?php 
													if (!empty($arrinteres)){
				                                    	foreach($arrinteres as $key => $int){ 
															echo "<option value='".$int['id_nivelInteres']."'";
															if (in_array($int['id_nivelInteres'], $nivelxusuario))
															{ 

																echo " selected='selected'";

															}
															echo ">".utf8_encode($int['descripcion'])."</option>";
														} 
													} ?>
												</select>
	                                        </div>
	                                    </div>
	                                <?php } ?>
									<div class="col-md-6">
									  <div class="form-group">
									    <label class="text-center">Contrase&ntilde;a:</label><div class="help-block with-errors"></div>
									    <input id="password" name="password" type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Al menos 1 may&uacute;scula y 1 nro' : ''); if(this.checkValidity()) form.password_two.pattern = this.value;" placeholder="Ejemplo: me198454EjgE" class="form-control" data-toggle="password" <?php if($btnSig == 1){ echo 'disabled'; } ?>>
									  </div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
										  <label class="text-center">Confirmar Contrase&ntilde;a:</label><div class="help-block with-errors"></div>
										  <input id="password_two" name="password_two" type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Por favor, ingrese la misma contraseña' : '');" placeholder="Verificar contraseña" class="form-control" data-toggle="password" <?php if($btnSig == 1){ echo 'disabled'; } ?>>
										</div>
									</div>  
	                                </div>  
	                                  
	                            </div>
	                            
	                            <input type="hidden" name="actualizar" id="actualizar" value="1">
					            <div class="col-sm-8 col-sm-offset-2 col-lg-8 col-lg-offset-2">
							      	<button type="submit" id="boton" class="btn btn-success btn-block"><?php if($btnSig == 0){ echo 'GUARDAR'; }else{ echo 'SIGUIENTE>>'; } ?></button>
							    </div>
				                
				            </div>  
			            </div>   
			        </div>
			    </div>
		    </div> 
        </form>
    </div>
<!--</section>-->

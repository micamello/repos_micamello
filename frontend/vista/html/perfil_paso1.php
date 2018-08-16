
<?php if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == 1) { ?>
<br>
<div class="checkout-wrap">
  <ul class="checkout-bar">
    <li class="visited"><a href="#">Registro</a></li>    
    <li class="active">Completar Perfil</li>
    <li class="">Formulario 1</li>
    <li class="">Formulario 2</li>
    <li class="">Formulario 3</li>
  </ul>
</div>
<br>
<?php } ?>


<section id="product" class="product">
    <div class="container"><br><br>
        <form role="form" name="form1" id="form_editarPerfil" method="post" action="<?php echo PUERTO."://".HOST;?>/cuestionario/" enctype="multipart/form-data">
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="panel panel-default shadow" style="border-radius: 20px;">
                    	<img id="imagen_perfil" width="100%" alt="fotoPerfil" src="<?php echo Modelo_Usuario::obtieneFoto(); ?>" style="border-radius: 20px 20px 0px 0px;">
                        <label for="file-input" class="custom_file"><img class="button-center" src="<?php echo PUERTO."://".HOST."/imagenes/upload-icon.png";?>" width="50px"></label>
						<input id="file-input" type="file" name="file-input" class="upload-photo">
                        <div align="center">
                            <p class="text-center">Actualizar foto de perfil</p>
                            <br>
                        </div>
                    </div>
                </div>
	            <div class="col-md-8">
	                <div class="panel panel-default shadow" style="border-radius: 20px;">
	                    <div class="panel-body">
				            <div class="row">
				            	<div class="main_business">
	                                <div class="col-md-12">
	                                	<div class="col-md-12">
		                                    <div class="form-group">
		                                        <label for="username">Usuario:<h4 class="usuario"><u><?php echo $_SESSION['mfo_datos']['usuario']['username']; ?></u></h4><?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != 1) { ?><h6>RUC: <?php echo $_SESSION['mfo_datos']['usuario']['dni']; ?></h6><?php } ?></label>
		                                        
		                                    </div>
	                                    </div>
	                                    <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == 1) { ?>
	                                    <div class="col-md-6">
		                                    <div class="form-group">
		                                        <label for="dni">C&eacute;dula</label><div class="help-block with-errors"></div>
		                                        <input class="form-control" id="dni" readonly value="<?php echo $_SESSION['mfo_datos']['usuario']['dni']; ?>" />
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
	                                            <label for="nombres"><?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == 1) { ?> Nombres <?php }else{ ?> Nombre de la empresa<?php } ?></label><div class="help-block with-errors"></div>
	                                			<input class="form-control" id="nombres" name="nombres" value="<?php echo $_SESSION['mfo_datos']['usuario']['nombres']; ?>" pattern="[a-z A-ZñÑáéíóúÁÉÍÓÚ]+" required/>
	                                        </div>
	                                    </div>
	                                    <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == 1) { ?>
	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="apellidos">Apellidos</label><div class="help-block with-errors"></div>
	                                			<input class="form-control" id="apellidos" name="apellidos" value="<?php echo $_SESSION['mfo_datos']['usuario']['apellidos']; ?>" pattern='[a-z A-ZñÑáéíóúÁÉÍÓÚ]+' required/>
	                                        </div>
	                                    </div>
	                                    <?php } ?>
	                                    		
	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="provincia">Provincia</label><div class="help-block with-errors"></div>
	                                            <select class="form-control" name="provincia" id="provincia" required>
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
	                                            <select id="ciudad" name="ciudad" class="form-control" required>
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
		                                    <div class="form-group">
		                                        <label for="mayor_edad"><?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == 1) { ?> Fecha de Nacimiento <?php }else{ ?> Fecha de Apertura <?php } ?></label><div class="help-block with-errors"></div>
		                                        <input class="form-control" type="date" name="fecha_nacimiento" id="mayor_edad" value="<?php echo date('Y-m-d',strtotime($_SESSION['mfo_datos']['usuario']['fecha_nacimiento'])); ?>" required/>
		                                    </div>
	                                    </div>
	                                    <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == 1) { ?>
	                                    <div class="col-md-6">
	                                    	<div class="form-group">
		                                    	<label for="discapacidad">Discapacidad</label><div class="help-block with-errors"></div>
			                                    <select id="discapacidad" name="discapacidad" class="form-control" required>
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
										<div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="experiencia">A&ntilde;os de Experiencia</label><div class="help-block with-errors"></div>
	                                            <select id="experiencia" name="experiencia" class="form-control" required>
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
		                                        <input class="form-control" id="telefono" name="telefono" minlength="10" maxlength="15" pattern='[0-9]+' onclick="numero_validate(this);" value="<?php echo $_SESSION['mfo_datos']['usuario']['telefono']; ?>" required/>
		                                    </div>
	                                    </div>
	                                    <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == 1) { ?>
	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="genero">G&eacute;nero</label><div class="help-block with-errors"></div>
	                                            <select id="genero" name="genero" class="form-control" required>
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
	                                            <select id="escolaridad" name="escolaridad" class="form-control" style="padding-left: 0px;"required>
	                                            	<option value="">Seleccione una opci&oacute;n</option>
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
												  		<input class='form-check-input' type='radio' name='status_carrera' id='radio1' value='$key' required";
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
	                                            <select class="form-control" multiple id="area_select" data-selectr-opts='{"maxSelection": 3 }' name="area_select[]" required>
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
	                                            <select class="form-control" multiple id="nivel_interes" data-selectr-opts='{"maxSelection": 2 }' name="nivel_interes[]" required>
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
	                                </div>  
	                                  
	                            </div>
	                            
	                            <input type="hidden" name="actualizar" id="actualizar" value="1">
					            <div class="col-sm-8 col-sm-offset-2 col-lg-8 col-lg-offset-2">
							      <button type="submit" id="boton" class="btn btn-success btn-block">GUARDAR</button>
							    </div>
				                
				            </div>  
			            </div>   
			        </div>
			    </div>
		    </div> 
        </form>
    </div>
</section>

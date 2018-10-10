<?php  
$_SESSION['mostrar_exito'] = "";
$_SESSION['mostrar_error'] = "";

if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?>
<div class="container">
	<div class="checkout-wrap">
	  <ul class="checkout-bar">
        <li class="visited">Registro</li>
        <li class="active">Completar Perfil</li>
        <?php 

        for($i=1;$i<=$nrototaltest;$i++){ ?>
          <?php 
           if ($i <= $nrotestusuario){
             $clase = "visited";
           }
           else{
             $clase = "";
           }
          ?>
          <li class="<?php echo $clase;?>">Formulario <?php echo $i;?></li>                
        <?php } ?>
      </ul>
	</div>
</div>
<br>
<?php } ?>


<!--<section id="product" class="product">-->
    <div class="container"><br><br>
        <form role="form" name="form1" id="form_editarPerfil" method="post" action="<?php echo PUERTO."://".HOST;?>/perfil/" enctype="multipart/form-data">
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="panel panel-default shadow" style="border-radius: 20px;">
                    	<img id="imagen_perfil" width="100%" alt="fotoPerfil" src="<?php echo Modelo_Usuario::obtieneFoto($_SESSION['mfo_datos']['usuario']['id_usuario']); ?>" style="border-radius: 20px 20px 0px 0px;">
                        <label for="file-input" class="custom_file"><img class="button-center" src="<?php echo PUERTO."://".HOST."/imagenes/upload-icon.png";?>" width="50px"></label>
						<input id="file-input" type="file" name="file-input" <?php if($btnSig == 1){ echo 'disabled'; } ?> class="upload-photo">
                        <div align="center">
                            <p class="text-center">Actualizar foto de perfil (.jpg .jpeg )</p>
                            <br>
                        </div>
                    </div>
                    <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){ ?>
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
							<?php 

							if($btnSubir == 1){ ?>
								<div <?php if($btnDescarga == 1){ echo 'class="pull-right" style="position: relative; margin-right: 15px;"'; } ?>>
			                        <label for="subirCV" class="custom_file">
			                        	<img id="imagenBtn" class="button-center" src="<?php echo PUERTO."://".HOST."/imagenes/$imgArch2";?>" width="50px">
			                        </label>
			                   		<input id="subirCV" type="file" name="subirCV" class="upload-photo" accept="application/pdf,application/msword,.doc, .docx">
			                   		<div align="center">
		                            	<p class="text-center arch_cargado" id="texto_status"><?php echo $msj2; ?></p>
		                        	</div>
								</div>
								<br>
	                        <?php }

	                        if($btnDescarga == 1 && $btnSubir == 1 && $btnSig == 0){ echo '<br><br><br>'; } ?>
	                    </div>
                    <?php } ?>
					<div class="panel panel-default shadow" style="border-radius: 20px;">
				    	
				    	<img id="archivo" width="100%" alt="cambio_clave" src="<?php echo PUERTO."://".HOST."/imagenes/cambiar_clave.jpg";?>" style="border-radius: 20px 20px 0px 0px;">

			           	<div>
			                <label for="cambiar" class="custom_file">
			                	<a onclick="abrirModal('','cambiar_clave');">
			                		<img id="cambiar" class="button-center" src="<?php echo PUERTO."://".HOST."/imagenes/btn_cambiar_clave.png";?>" width="50px">
			                	</a>
			                </label>
							<div align="center">
			                    <p class="text-center arch_cargado" id="texto_status1">Presiona aqu&iacute;</p>
			                </div>
			            </div>
			            <br>
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
			                                        <input class="form-control" type="text" id="dni" disabled value="<?php echo $_SESSION['mfo_datos']['usuario']['dni']; ?>" />
			                                    </div>
		                                    </div>
	                                	<?php } ?>

	                                    <div class="col-md-6">
		                                    <div class="form-group">
		                                        <label for="correo">Correo </label><div class="help-block with-errors"></div>
		                                        <input class="form-control" id="correo" type="email" disabled value="<?php echo $_SESSION['mfo_datos']['usuario']['correo']; ?>"/>
		                                    </div>
	                                    </div>

	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="nombres"><?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?> Nombres <span class="requerido" title="Este campo es obligatorio">*</span><?php }else{ ?> Nombre de la empresa<?php } ?></label><div class="help-block with-errors"></div>
	                                			<input class="form-control" type="text" id="nombres" name="nombres" value="<?php echo $_SESSION['mfo_datos']['usuario']['nombres']; ?>" pattern="[a-z A-ZñÑáéíóúÁÉÍÓÚ]+" <?php if($btnSig == 1){ echo 'disabled'; } ?> required/>
	                                        </div>
	                                    </div>

	                                    <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?>
		                                    <div class="col-md-6">
		                                        <div class="form-group">
		                                            <label for="apellidos">Apellidos<span class="requerido" title="Este campo es obligatorio">*</span></label><div class="help-block with-errors"></div>
		                                			<input class="form-control" type="text" id="apellidos" name="apellidos" value="<?php if(isset($_SESSION['mfo_datos']['usuario']['apellidos'])){ echo $_SESSION['mfo_datos']['usuario']['apellidos']; } ?>" pattern='[a-z A-ZñÑáéíóúÁÉÍÓÚ]+' <?php if($btnSig == 1){ echo 'disabled'; } ?> required/>
		                                        </div>
		                                    </div>
	                                    <?php } ?>

	                                    <div class="col-md-<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { echo '6'; }else{ echo '12';} ?>">
		                                    <div class="form-group">
	                                            <label for="nacionalidad">Nacionalidad <span class="requerido" title="Este campo es obligatorio">*</span></label><div class="help-block with-errors"></div>
	                                            <select class="form-control" name="id_nacionalidad" id="id_nacionalidad" <?php if($btnSig == 1){ echo 'disabled'; } ?> required>
	                                            	<option value="">Seleccione su opci&oacute;n</option>
													<?php 
													if (!empty($nacionalidades)){
				                                    	foreach($nacionalidades as $key => $n){ 
															echo "<option value='".$n['id_pais']."'";
															if ($_SESSION['mfo_datos']['usuario']['id_nacionalidad'] == $n['id_pais'])
															{ 
																echo " selected='selected'";
															}
															echo ">".utf8_encode($n['nombre_abr'])."</option>";
														}
													} ?>
												</select>
	                                        </div>
	                                    </div>		

	                                    <div class="col-md-6">
		                                    <div id="mayoria"  class="form-group">
		                                        <label for="mayor_edad"><?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?> Fecha de Nacimiento <?php }else{ ?> Fecha de Apertura <?php } ?><span class="requerido" title="Este campo es obligatorio">*</span></label><div id="error" class="help-block with-errors"></div>
		                                        <input class="form-control" type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="<?php echo date('Y-m-d',strtotime($_SESSION['mfo_datos']['usuario']['fecha_nacimiento'])); ?>" <?php if($btnSig == 1){ echo 'disabled'; } ?> <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?> onchange="calcularEdad()" <?php } ?> placeholder="dd/mm/aaaa" required/>
		                                    </div>
	                                    </div>

										<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) { ?>

											<div class="col-md-6">
											    <div class="form-group">
											        <label for="telefono">Tel&eacute;fono<span class="requerido" title="Este campo es obligatorio">*</span></label><div class="help-block with-errors"></div>
											        <input class="form-control" type="text" id="telefono" name="telefono" minlength="10" maxlength="15" pattern='[0-9]+' onkeypress="return validaNumeros(event)" value="<?php echo $_SESSION['mfo_datos']['usuario']['telefono']; ?>" <?php if($btnSig == 1){ echo 'disabled'; } ?> required/>
											    </div>
											</div>

										<?php } ?>
										
	                                    <fieldset  style="padding: 15px 0px 0px 0px;" class="form-group col-md-12">
    										<legend style="color: #8c8b8b; margin-bottom: 5px;"><h5><b>Direcci&oacute;n Domiciliaria</b></h5></legend>
		                                    <div class="col-md-6">
		                                        <div class="form-group">
		                                            <label for="provincia">Provincia <span class="requerido" title="Este campo es obligatorio">*</span></label><div class="help-block with-errors"></div>
		                                            <select class="form-control" name="provincia" id="provincia" <?php if($btnSig == 1){ echo 'disabled'; } ?> required>
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
		                                            <label for="ciudad">Ciudad <span class="requerido" title="Este campo es obligatorio">*</span></label><div class="help-block with-errors"></div>
		                                            <select id="ciudad" name="ciudad" class="form-control" <?php if($btnSig == 1){ echo 'disabled'; } ?> required>
		                                            <?php 
		                                            if(!empty($arrciudad)){
				                                    	foreach($arrciudad as $key => $ciudad){ 
															echo "<option value='".$ciudad['id_ciudad']."'";
															if ($_SESSION['mfo_datos']['usuario']['id_ciudad'] == $ciudad['id_ciudad'])
															{  
																echo " selected='selected'";
															}
															echo ">".utf8_encode($ciudad['ciudad'])."</option>";
														} 
		                                            }else{ ?>
														<option value="">Selecciona una ciudad</option>
		                                            <?php } ?>
		                                            </select>
		                                        </div>
		                                    </div>					
	                    				</fieldset>
	                    				<hr width="100%" />
	                                    <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?>
		                                    <div class="col-md-6">
		                                    	<div class="form-group">
			                                    	<label for="discapacidad">Discapacidad <span class="requerido" title="Este campo es obligatorio">*</span></label><div class="help-block with-errors"></div>
				                                    <select id="discapacidad" name="discapacidad" class="form-control" <?php if($btnSig == 1){ echo 'disabled'; } ?> required>
				                                    	<option value="">Tiene alguna discapacidad&#63;</option>
				                                    	<?php 
				                                    	foreach(REQUISITO as $key => $dis){ 
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
		                                            <label for="experiencia">A&ntilde;os de Experiencia <span class="requerido" title="Este campo es obligatorio">*</span></label><div class="help-block with-errors"></div>
		                                            <select id="experiencia" name="experiencia" class="form-control" <?php if($btnSig == 1){ echo 'disabled'; } ?> required>
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

											<div class="col-md-6">
											    <div class="form-group">
											        <label for="telefono">Tel&eacute;fono <span class="requerido" title="Este campo es obligatorio">*</span></label><div class="help-block with-errors"></div>
											        <input class="form-control" type="text" id="telefono" name="telefono" minlength="10" maxlength="15" pattern='[0-9]+' onkeydown="return validaNumeros(event)" value="<?php echo $_SESSION['mfo_datos']['usuario']['telefono']; ?>" <?php if($btnSig == 1){ echo 'disabled'; } ?> required/>
											    </div>
											</div>

		                                    <div class="col-md-6">
		                                    	<div class="form-group">
			                                    	<label for="estado_civil">Estado civil <span class="requerido" title="Este campo es obligatorio">*</span></label><div class="help-block with-errors"></div>
				                                    <select id="estado_civil" name="estado_civil" class="form-control" <?php if($btnSig == 1){ echo 'disabled'; } ?> required>
				                                    	<option value="">Seleccione una opci&oacute;n</option>
				                                    	<?php 
				                                    	foreach(ESTADO_CIVIL as $key => $e){ 
															echo "<option value='$key'";
															if ($_SESSION['mfo_datos']['usuario']['estado_civil'] == $key)
															{ 
																echo " selected='selected'";
															}
															echo ">$e</option>";
														} ?>
													</select>
												</div>
											</div>
											<div class="clearfix"></div>
		                                    <div class="col-md-6">
		                                        <div class="form-group">
		                                            <label for="genero">G&eacute;nero <span class="requerido" title="Este campo es obligatorio">*</span></label><div class="help-block with-errors"></div>
		                                            <select id="genero" name="genero" class="form-control" <?php if($btnSig == 1){ echo 'disabled'; } ?> required>
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

											<div class="col-md-6">
		                                    	<div class="form-group">
			                                    	<label for="tiene_trabajo">&#191;Tiene trabajo&#63; <span class="requerido" title="Este campo es obligatorio">*</span></label><div class="help-block with-errors"></div>
				                                    <select id="tiene_trabajo" name="tiene_trabajo" class="form-control" <?php if($btnSig == 1){ echo 'disabled'; } ?> required>
				                                    	<option value="">Seleccione una opci&oacute;n</option>
				                                    	<?php 
				                                    	foreach(REQUISITO as $key => $r){ 
															echo "<option value='$key'";
															if ($_SESSION['mfo_datos']['usuario']['tiene_trabajo'] == $key)
															{ 
																echo " selected='selected'";
															}
															echo ">$r</option>";
														} ?>
													</select>
												</div>
											</div>

											<div class="col-md-6">
		                                    	<div class="form-group">
			                                    	<label for="viajar">&#191;Puede viajar&#63; <span class="requerido" title="Este campo es obligatorio">*</span></label><div class="help-block with-errors"></div>
				                                    <select id="viajar" name="viajar" class="form-control" <?php if($btnSig == 1){ echo 'disabled'; } ?> required>
				                                    	<option value="">Seleccione una opci&oacute;n</option>
				                                    	<?php 
				                                    	foreach(REQUISITO as $key => $r){ 
															echo "<option value='$key'";
															if ($_SESSION['mfo_datos']['usuario']['viajar'] == $key)
															{ 
																echo " selected='selected'";
															}
															echo ">$r</option>";
														} ?>
													</select>
												</div>
											</div>

											<div class="col-md-6">
		                                    	<div class="form-group">
			                                    	<label for="licencia">&#191;Tiene licencia para conducir&#63; <span class="requerido" title="Este campo es obligatorio">*</span></label><div class="help-block with-errors"></div>
				                                    <select id="licencia" name="licencia" class="form-control" <?php if($btnSig == 1){ echo 'disabled'; } ?> required>
				                                    	<option value="">Seleccione una opci&oacute;n</option>
				                                    	<?php 
				                                    	
				                                    	foreach(REQUISITO as $key => $r){ 
															echo "<option value='$key'";
															if ($_SESSION['mfo_datos']['usuario']['licencia'] == $key)
															{ 
																echo " selected='selected'";
															}
															echo ">$r</option>";
														} ?>
													</select>
												</div>
											</div>
	 
		                                    <div class="col-md-6" >
		                                        <div class="form-group">
		                                            <label for="escolaridad">&Uacute;ltimo estudio realizado <span class="requerido" title="Este campo es obligatorio">*</span></label><div class="help-block with-errors"></div>
		                                            <select id="escolaridad" name="escolaridad" class="form-control" onchange="ocultarCampos()"style="padding-left: 0px;" <?php if($btnSig == 1){ echo 'disabled'; } ?> required>
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

		                                    <div class="col-md-6">
		                                    	<div class="form-group">
		                                    		<label for="estatus">Nivel <span class="requerido" title="Este campo es obligatorio">*</span></label><div class="help-block with-errors"></div>
													 <select id="estatus" name="estatus" class="form-control" style="padding-left: 0px;" <?php if($btnSig == 1){ echo 'disabled'; } ?> required>
													 	<option value="">Seleccione su opci&oacute;n</option>
														<?php 
				                                    	foreach(STATUS_CARRERA as $key => $status){ 
															echo "<option value='".$key."'";
															if ($_SESSION['mfo_datos']['usuario']['status_carrera'] == $key)
															{ 
																echo " selected='selected'";
															}
															echo ">".utf8_encode($status)."</option>";
														}
														 ?>
													</select>
												</div>
		                                    </div>
											
											<div class="col-md-6 depende">
		                                        <div class="form-group">
		                                            <label for="lugar_estudio">&#191;Estudi&oacute; en el extranjero&#63; <span class="requerido" title="Este campo es obligatorio">*</span></label><div class="help-block with-errors"></div>
		                                            <select class="form-control" id="lugar_estudio" name="lugar_estudio" onchange='mostrarUni()' <?php if($btnSig == 1){ echo 'disabled'; } ?> >
		                                            	<option value="-1">Seleccione su opci&oacute;n</option>
														<?php #echo strlen($_SESSION['mfo_datos']['usuario']['id_univ']);
														#var_dump($_SESSION['mfo_datos']['usuario']['id_univ']);
				                                    	foreach(REQUISITO as $key => $u){ 

															echo "<option value='".$key."'";
															if ($_SESSION['mfo_datos']['usuario']['id_univ'] != 0 && $key == 0 && strlen($_SESSION['mfo_datos']['usuario']['nombre_univ']) <= 1)
															{
																echo " selected='selected'";
															}else if (strlen($_SESSION['mfo_datos']['usuario']['id_univ']) <= 1 && $key == 1 && strlen($_SESSION['mfo_datos']['usuario']['nombre_univ']) > 1)
															{
																echo " selected='selected'";
															}
															
															echo ">".utf8_encode($u)."</option>";
														} 
														?>
													</select>
		                                        </div>
		                                    </div>

		                                    <div class="col-md-6 depende">
		                                        <div class="form-group">
		                                            <label for="universidad">Universidad <span class="requerido" title="Este campo es obligatorio">*</span></label><div class="help-block with-errors"></div>
		                                            <select class="form-control" id="universidad" name="universidad" <?php if($btnSig == 1){ echo 'disabled'; } ?> >
		                                            	<option value="">Seleccione su opci&oacute;n</option>
														<?php 
														if (!empty($universidades)){
					                                    	foreach($universidades as $key => $u){ 
																echo "<option value='".$u['id_univ']."'";
																if ($_SESSION['mfo_datos']['usuario']['id_univ'] == $u['id_univ'])
																{ 
																	echo " selected='selected'";
																}
																echo ">".utf8_encode($u['nombre'])."</option>";
															} 
														}?>
													</select>
													<input type="text" name="universidad2" id="universidad2" class="form-control" <?php if($btnSig == 1){ echo 'disabled'; } ?>  pattern="[a-z A-ZñÑáéíóúÁÉÍÓÚ.]+" style="display:none" value="<?php if($_SESSION['mfo_datos']['usuario']['nombre_univ'] != ' '){ echo $_SESSION['mfo_datos']['usuario']['nombre_univ']; } ?>">
		                                        </div>
		                                    </div>

		                                    <div class="col-md-6">
		                                        <div class="form-group">
		                                            <label for="area_select">&Aacute;reas de inter&eacute;s <span class="requerido" title="Este campo es obligatorio">*</span></label><span class="help-text"> (m&aacute;x 3)</span><div class="help-block with-errors"></div>
		                                            <?php if (!empty($arrarea)){
		                                            	    $optiones = '';
					                                    	foreach($arrarea as $key => $ae){ 
																if (in_array($ae['id_area'], $areaxusuario))
																{ 
																	$optiones .= '<div class="col-sm-3 col-md-5 badge_item3" id="'.utf8_encode($ae['nombre']).'">'.utf8_encode($ae['nombre']).'</div>';
																}
															} 
														} ?>
													<div class="opcionesSeleccionados">
														<div class="row" id="seleccionados">
															<p style="font-size: 11px; margin-bottom: 0px;">Opciones seleccionadas</p>
															<?php echo $optiones; ?>
														</div>
														<div class="row">
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
		                                        </div>
		                                    </div>

		                                    <div class="col-md-6">
		                                        <div class="form-group">
		                                            <label for="nivel_interes">Niveles de inter&eacute;s  </label><span class="help-text"> (m&aacute;x 2)</span><div class="help-block with-errors"></div>
		                                            <?php if (!empty($arrinteres)){
		                                            	    $optiones = '';
					                                    	foreach($arrinteres as $key => $ae){ 
																if (in_array($ae['id_nivelInteres'], $nivelxusuario))
																{ 
																	$optiones .= '<div class="col-sm-4 col-md-5 badge_item3" id="'.utf8_encode($ae['descripcion']).'">'.utf8_encode($ae['descripcion']).'</div>';
																}
															} 
														} ?>
													<div class="opcionesSeleccionados">
														<div class="row" id="seleccionados1">
															<p style="font-size: 11px; margin-bottom: 0px;">Opciones seleccionadas</p>
															<?php echo $optiones; ?>
														</div>
														
														<div class="row">
				                                            <select class="form-control" multiple id="nivel_interes" data-selectr-opts='{"maxSelection": 2 }' name="nivel_interes[]" <?php if($btnSig == 1){ echo 'disabled'; } ?> required>
																<?php 
																if (!empty($arrinteres)){
							                                    	foreach($arrinteres as $key => $ae){ 
																		echo "<option value='".$ae['id_nivelInteres']."'";
																		if (in_array($ae['id_nivelInteres'], $nivelxusuario))
																		{ 
																			echo " selected='selected'";
																		}
																		echo ">".utf8_encode($ae['descripcion'])."</option>";
																	} 
																}?>
															</select>
														</div>
													</div>
		                                        </div>
		                                    </div>

		                                    <div class="clearfix"></div>
		                                
		                                    <div class="col-md-4 col-md-offset-1">
												<div class="form-group">
													<label>Idioma: </label><div class="help-block with-errors"></div>
													<select id="idioma_of" name="idioma_of" class="form-control" <?php if((count($arridioma) == count($nivelIdiomas)) || $btnSig == 1){ echo 'disabled=disabled'; } ?>>
														<option value="0">Seleccione una opci&oacute;n</option>
														<?php if (!empty($arridioma)){
															
															foreach ($arridioma as $idioma) { ?>
																<option value="<?php echo $idioma['id_idioma'] ?>"
																<?php 
																	$descripcion = utf8_encode($idioma['descripcion']);
																	if(isset($nivelIdiomas[$descripcion])){
																		echo 'disabled=disabled';
																	}
																?>
																><?php echo utf8_encode($idioma['descripcion']) ?></option>
														<?php }
														} ?>
													</select>
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group">
													<label>Nivel idioma: </label><div class="help-block with-errors"></div>
													<select id="nivel_idi_of" name="nivel_idi_of" class="form-control" <?php if((count($arridioma) == count($nivelIdiomas)) || $btnSig == 1){ echo 'disabled=disabled'; } ?>>
														<option disabled selected value="0">Seleccione una opci&oacute;n</option>
														<?php if (!empty($arrnivelidioma)){
															foreach ($arrnivelidioma as $nivelidioma) {?>
																<option value="<?php echo $nivelidioma['id_nivelIdioma'] ?>"><?php echo utf8_encode($nivelidioma['nombre']) ?></option>
														<?php }
														} ?>
													</select>
												</div>
											</div>

											<div class="col-md-2">
												<div class="form-group">
													<a id="btn_transfer" class="button_transfer_list"><i class="fa fa-plus"></i></a>
												</div>
											</div>

											<div class="col-md-12">
												<div class="form-group">
													<label>Idiomas seleccionados: </label><div id="listado_idiomas" class="help-block with-errors"></div>
														<div id="error_msg">
														</div>
														<div class="list_content">
															<div class="form-group" id="list_idioma">
																<?php if(empty($nivelIdiomas)){ ?>
																	<p id="text_nothing">Ningun idioma seleccionado.....</p>
																<?php }else{ ?>
																	<p style="display:none;" id="text_nothing">Ningun idioma seleccionado.....</p>
																<?php 
																	$i = 1;
																	foreach ($nivelIdiomas as $key => $value) {
																		echo '<p id="idioma'.$i.'" disabled="disabled" class="col-md-5 badge_item listado">'.$key.' ('.$value[2].') <i class="fa fa-window-close fa-2x icon" id="'.$i.'" ';
																			if($btnSig != 1){
																				echo 'onclick="delete_item_selected(this);"';
																			}
																			echo '></i></p>';
																			
																		$i++;
																	}
																 }?>
															</div>
														</div>
													<select style="visibility: hidden; height: 1px;" id="select_array_idioma" name="nivel_idioma[]" multiple required>
														<?php foreach ($nivelIdiomas as $key => $value) { ?>
															<option value="<?php echo $value[0].'_'.$value[1]; ?>" id="array_idioma<?php echo $value[0]; ?>" selected='selected'></option>
													    <?php } ?>
													</select>
												</div>
											</div>
										<?php }else{ ?>
					                    	<fieldset  style="padding: 15px 0px 0px 0px;" class="form-group col-md-12">
    											<legend style="color: #8c8b8b; margin-bottom: 5px;"><h5><b>Datos de contacto</b></h5></legend>

								           	 	<!-- Empresas contacto -->
									            <div class="col-md-6" id="group_nombre_contact">
									              <div class="form-group">
									                <label class="text-center">Nombres</label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
									                <input type="text" name="nombre_contact" id="nombre_contact" value="<?php echo $_SESSION['mfo_datos']['usuario']['nombres_contacto']; ?>" pattern='[a-z A-ZñÑáéíóúÁÉÍÓÚ]+' placeholder="Ejemplo: Juan David" class="form-control" <?php if($btnSig == 1){ echo 'disabled'; } ?> <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) { echo 'required'; } ?>>
									              </div>
									            </div>  

									            <div class="col-md-6" id="group_apell_contact">
									              <div class="form-group">
									                <label class="text-center">Apellidos</label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
									                <input type="text" name="apellido_contact" id="apellido_contact" value="<?php echo $_SESSION['mfo_datos']['usuario']['apellidos_contacto']; ?>" pattern='[a-z A-ZñÑáéíóúÁÉÍÓÚ]+' placeholder="Ejemplo: Ortíz Zambrano" class="form-control" <?php if($btnSig == 1){ echo 'disabled'; } ?> <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) { echo 'required'; } ?>>
									              </div>
									            </div> 

									            <div class="col-md-6" id="group_num1_contact">
									              <div class="form-group">
									                <label class="text-center">Teléfono 1</label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
									                <input type="text" name="tel_one_contact" id="tel_one_contact" value="<?php echo $_SESSION['mfo_datos']['usuario']['telefono1']; ?>" class="form-control" onkeydown="return validaNumeros(event);" <?php if($btnSig == 1){ echo 'disabled'; } ?> <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) { echo 'required'; } ?>>
									              </div>
									            </div> 

									            <div class="col-md-6" id="group_num2_contact">
									              <div class="form-group">
									                <label class="text-center">Teléfono 2 (opcional):</label><div class="help-block with-errors"></div>
									                <input type="text" name="tel_two_contact" id="tel_two_contact" value="<?php echo $_SESSION['mfo_datos']['usuario']['telefono2']; ?>" class="form-control" onkeydown="return validaNumeros(event);" <?php if($btnSig == 1){ echo 'disabled'; } ?>>
									              </div>
									            </div> 
									        </fieldset>
								        <?php } ?>
	                            	</div>
		                            <input type="hidden" name="actualizar" id="actualizar" value="1">
					                <div class="row">
					                	<?php if($btnSig == 0){ ?>
											<input type="submit" id="boton" name="" class="btn btn-success" value="GUARDAR">
										<?php }else{ ?>
											<a href="<?php echo PUERTO."://".HOST;?>/cuestionario/" class="btn btn-success">SIGUIENTE</a>
										<?php }?>
									</div>
				            	</div>  
			            	</div>   
			        	</div>
			    	</div>
		    	</div> 
		    </div>
        </form>
    </div>
<!--</section>-->

<div class="modal fade" id="cambiar_clave" tabindex="-1" role="dialog" aria-labelledby="cambiar_clave" aria-hidden="true">
  <div class="modal-dialog" role="document">    
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cambio de Contrase&ntilde;a</h5>                  
      </div>
      	<form action = "<?php echo PUERTO."://".HOST;?>/perfil/" method = "post" id="form_cambiar">
	      <div class="modal-body">
	      	<div class="row">
		      	<div class="col-md-12">
			        <div class="col-md-6">
		                <div class="form-group">
		                  <label class="text-center">Contrase&ntilde;a:</label><div class="help-block with-errors"></div>
		                  <div class="input-group">
		                    <span class="input-group-addon show_hidden" onclick="pass_reveal(this);"><i class="fa fa-eye"></i></span>
		                    <input title="Letras y números, mínimo 8 caracteres" id="password" name="password" type="password" pattern="^(?=(?:.*\d))(?=(?:.*[a-zA-Z]))\S{8,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); if(this.checkValidity()) form.password_two.pattern = this.value;" class="form-control" required>
		                  </div>
		                </div>
		            </div>
		            <div class="col-md-6">
		              <div class="form-group">
		                  <label class="text-center">Confirmar Contrase&ntilde;a:</label><div class="help-block with-errors"></div>
		                  <div class="input-group">
		                    <span class="input-group-addon show_hidden" onclick="pass_reveal(this);"><i class="fa fa-eye"></i></span>
		                    <input id="password_two" name="password_two" type="password" pattern="^(?=(?:.*\d))(?=(?:.*[a-zA-Z]))\S{8,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Ingrese la misma contraseña' : '');" placeholder="Verificar contraseña" class="form-control" required>
		                </div>
		              </div>
		            </div> 
				</div>
			</div>
	      </div>
	      <input type="hidden" name="cambiarClave" id="cambiarClave" value="1">
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <!--<a href="" class="btn btn-success" id="btncambiar">Cambiar</a>-->
	        <input id="button_cambiar" type="submit" name="btnusu" class="btn btn-success" value="Cambiar"> 
	      </div>
  		</form>
    </div>    
  </div>
</div>

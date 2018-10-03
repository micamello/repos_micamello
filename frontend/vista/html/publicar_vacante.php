<div class="">
	<div class="">
		<br>
	<div class="breadcrumb">
		<div class="container">
			<b class="publicar_text">Publicar Ofertas</b>
			<?php 
				if (!empty($publicaciones_restantes)) {
					?>
			 <div align="right">
			 	<div class="col-md-12">
			 		<div class="col-md-4 col-sm-4 col-xs-12">
			 			<div class="caja">
			 			<?php 
			 				if (!empty($_SESSION['mfo_datos']['planes'][0]['fecha_caducidad'])) {
			 					?>
						 			<p>Fecha caducidad plan: </p>
						 			<b><span><?php
						 			$fecha = date_create($_SESSION['mfo_datos']['planes'][0]['fecha_caducidad']);
						 			 echo date_format($fecha, "Y-m-d")?> <i style="color: #49FC49;" class="fa fa-circle"></i></span></b>
			 				<?php
			 				}
			 			 ?>
			 			</div>
			 		</div>	
			 		<div class="col-md-4 col-sm-4 col-xs-12">
			 			<div class="caja">
			 				<p>Publicaciones restantes: </p>
			 				<b><span><?php echo $publicaciones_restantes['p_restantes']; ?></span></b>
			 			</div>
			 		</div>
			 		<div class="col-md-4 col-sm-4 col-xs-12">
			 			<div class="caja">
			 				<p>N° Planes activos: </p>
			 				<b><span><?php echo count($_SESSION['mfo_datos']['planes']); ?></span></b>
			 			</div>
			 		</div>
			 	</div>
			</div>
					<?php
					}
				 ?>	
				  <!-- / Plan(es) activo(s):
				  <select>
				  	<option></option>
				  </select> -->
			 
		</div>
	</div>
	<div class="container">
		<div class="panel panel-default shadow col-md-10 col-md-offset-1">
			<div class="panel-body">
				<form id="form_publicar" role="form" method="post" action="<?php echo PUERTO."://".HOST;?>/publicar/">
					<input type="hidden" name="form_publicar" value="1">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="">Título oferta: </label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
								<input type="text" name="titu_of" class="form-control" placeholder="Título de la oferta" required value="<?php
								    if(isset($_REQUEST['titu_of'])){
								                $name = $_REQUEST['titu_of'];
								                echo $name;
								    }
								?>">
							</div>
						</div>

						<div class="col-md-10 col-md-offset-1">
							<div id="des_of_error" class="form-group">
								<label class="">Descripción oferta: </label>&nbsp;<i class="requerido">*</i><div id="descripcion_error" class="help-block with-errors"></div>
								<textarea id="des_of" rows="7" required name="des_of" class="form-control" style="resize: none;"><?php
								    if(isset($_REQUEST['des_of'])){
								                $name = $_REQUEST['des_of'];
								                echo $name;
								    }
								?></textarea>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">

								<label class="">Salario: </label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
								<input type="text" name="salario" id="salario" class="form-control" placeholder="$0.00" onkeydown=" return validaNumeros(event);" required>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">

								<label>Cantidad de vacantes: </label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
								<input type="number" name="vacantes" min="1" class="form-control" required onkeydown=" return validaNumeros(event);">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Seleccione provincia:</label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
								<select name="provincia_of" class="form-control" id="provincia_of" required>
									<?php 
			                      if (!empty($arrprovinciasucursal)){
			                          foreach($arrprovinciasucursal as $provincia){ ?>
			                              <option value="<?php echo $provincia['id_provincia'] ?>"><?php echo utf8_encode($provincia['nombre']); ?></option>
			                          <?php }

			                      }else{?>
			                      	<option value="">Seleccione una opción</option>
			                      	<?php  }?>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Seleccione ciudad:</label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
								<select name="ciudad_of" class="form-control" id="ciudad_of" required>
									<?php 
	                                	if(!empty($arrciudad)){

	                                		foreach($arrciudad as $ciudad){ 
												echo "<option value='".$ciudad['id_ciudad']."'>".utf8_encode($ciudad['ciudad'])."</option>";
											} 
	                                	}else{ ?>
											<option value="">Selecciona una ciudad</option>
	                                	<?php } ?>
								</select>
							</div>
						</div>

						

					<div class="row">
						<div class="">
							<div class="col-md-6">
								<div class="form-group">
									<div class="opcionesSeleccionados">
										<div class="row" id="seleccionados">
											<p style="font-size: 11px; margin-bottom: 0px;">Opciones seleccionadas</p>
											<!-- <?php echo $optiones; ?> -->
										</div>
										<div class="help-block with-errors"></div>
										<label class="">Categorías: (Máx: 1)</label>&nbsp;<i class="requerido">*</i>
										<select class="form-control" name="area_select[]" id="area_select" data-selectr-opts='{"maxSelection": 1 }' multiple required>
					                    <?php 
					                      if (!empty($arrarea)){
					                          foreach($arrarea as $area){ ?>
					                              <option value="<?php echo $area['id_area'] ?>"><?php echo utf8_encode($area['nombre']); ?></option>
					                          <?php }
					                      } ?>
					                  	</select>
					                </div>
								</div>
							</div>


							<div class="col-md-6">
								<div class="form-group">
									<div class="opcionesSeleccionados">
										<div class="row" id="seleccionados1">
											<p style="font-size: 11px; margin-bottom: 0px;">Opciones seleccionadas</p>
											<!-- <?php echo $optiones; ?> -->
										</div>
										<div class="help-block with-errors"></div>
										<label>Nivel: (Máx: 1)</label>&nbsp;<i class="requerido">*</i>
										<select class="form-control" name="nivel_interes[]" id="nivel_interes" data-selectr-opts='{"maxSelection": 1 }' multiple required>
					                    <!-- <option value="" selected disabled>Seleccione un área</option> -->
					                    <?php 
					                      if (!empty($intereses)){
					                          foreach($intereses as $interes){ ?>
					                              <option value="<?php echo $interes['id_nivelInteres'] ?>"><?php echo utf8_encode($interes['descripcion']); ?></option>
					                          <?php }
					                      } ?>
					                  	</select>
					                </div>
								</div>
							</div>
						</div>
					</div>


						<div class="col-md-6">
							<div class="form-group">
								<label>Jornada: </label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
								<select name="jornada_of" class="form-control" required>
									<?php if (!empty($arrjornada)){
										foreach ($arrjornada as $jornada) {?>
											<option value="<?php echo $jornada['id_jornada'] ?>"><?php echo utf8_encode($jornada['nombre']) ?></option>
									<?php }
									}else{ ?>
											<option value="">Selecciona una opción</option>
	                                	<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Escolaridad: </label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
								<select name="escolaridad" class="form-control" required>
									<?php if (!empty($arrescolaridad)){
										foreach ($arrescolaridad as $escolaridad) {?>
											<option value="<?php echo $escolaridad['id_escolaridad'] ?>"><?php echo utf8_encode($escolaridad['descripcion']) ?></option>
									<?php }
									}else{ ?>
											<option value="">Selecciona una opción</option>
	                                	<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Años de experiencia: </label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
								<select name="experiencia" class="form-control" required>
									<?php 

										foreach(ANOSEXP as $key => $exp){ 
											echo "<option value='$key'>$exp</option>";
										}

									 ?>
								</select>
							</div>
						</div>

						

						<div class="col-md-6">
							<div class="form-group">
								<label>Fecha contratación: </label>&nbsp;<i class="requerido">*</i><div id="fecha_error" class="help-block with-errors"></div>
								<input type="date" id="fecha_contratacion" name="fecha_contratacion" class="form-control" required value="<?php
								    if(isset($_REQUEST['fecha_contratacion'])){
								                $name = $_REQUEST['fecha_contratacion'];
								                echo $name;
								    }
								?>">
							</div>
						</div>

						<div class="col-md-3 col-md-offset-3">
							<div class="form-group">
								<label>Idioma: </label>
								<select id="idioma_of" name="idioma_of" class="form-control">
									<?php if (!empty($arridioma)){
										foreach ($arridioma as $idioma) {?>
											<option value="<?php echo $idioma['id_idioma'] ?>"><?php echo utf8_encode($idioma['descripcion']) ?></option>
									<?php }
									}else{ ?>
											<option value="">Selecciona una opción</option>
	                                	<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label>Nivel idioma: </label>
								<select id="nivel_idi_of" name="nivel_idi_of" class="form-control">
									<?php if (!empty($arrnivelidioma)){
										foreach ($arrnivelidioma as $nivelidioma) {?>
											<option value="<?php echo $nivelidioma['id_nivelIdioma'] ?>"><?php echo utf8_encode($nivelidioma['nombre']) ?></option>
									<?php }
									}else{ ?>
											<option value="">Selecciona una opción</option>
	                                	<?php } ?>
								</select>
							</div>
						</div>

						<div class="">
							<div class="col-md-2">
								<div class="form-group">
									<a id="btn_transfer" class="button_transfer_list"><i class="fa fa-plus"></i></a>
								</div>
							</div>
						</div>



						<div class="col-md-8 col-md-offset-2">

							<div id="id_idi_error" class="form-group">
								<label>Idiomas seleccionados: </label>&nbsp;<i class="requerido">*</i><div id="listado_idiomas" class="help-block with-errors"></div>
								<!-- <div class="col-md-12"> -->
									<div id="error_msg">
									</div>
									<div class="list_content">
										<div class="form-group" id="list_idioma">
											<p id="text_nothing">Ningun idioma seleccionado.....</p>
										</div>
									</div>
								<!-- </div> -->
								<select style="visibility: hidden; height: 1px;" id="select_array_idioma" name="nivel_idioma[]" multiple required>
								</select>
							</div>
						</div>

						<div class="">
							<div class="col-md-12">
								<hr>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Disponibilidad para viajar: </label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
								<select name="viaje" class="form-control" required>

									<?php
										foreach(REQUISITO as $key => $viajar){ 
											echo "<option value='$key'>$viajar</option>";
										}

									 ?>

								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Licencia: </label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
								<select name="licencia" class="form-control" required>

									<?php 

										foreach(REQUISITO as $key => $licencia){ 
											echo "<option value='$key'>$licencia</option>";
										}

									 ?>

								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Cambio de residencia: </label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
								<select name="cambio_residencia" class="form-control" required>

									<?php 

										foreach(REQUISITO as $key => $residencia){ 
											echo "<option value='$key'>$residencia</option>";
										}

									 ?>

								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Discapacidad: </label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
								<select name="discapacidad" class="form-control" required>
									<?php 


										foreach(REQUISITO as $key => $discapacidad){
											echo "<option value='$key'>$discapacidad</option>";

										}
									 ?>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Confidencial: </label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>

								<select name="confidencial" class="form-control" required>
									<?php 

										foreach(REQUISITO as $key => $confidencial){ 
											echo "<option value='$key'>$confidencial</option>";
										}

									 ?>

								</select>
							<span class="label label-default col-md-12">Mostrar datos de la empresa</span>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">

								<label>Edad mínima: </label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
								<input type="number" id="edad_min" name="edad_min" min="18" class="form-control" onkeydown=" return validaNumeros(event);" required>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label>Edad máxima: </label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
								<input type="number" id="edad_max" name="edad_max" min="18" max="100" class="form-control" onkeydown=" return validaNumeros(event);" required>
							</div>
						</div>	
					</div>
					<br>
					<div class="row">
						<!-- <a type="submit" class="btn btn-success">Publicar</a> -->
						<input type="submit" id="boton" name="" class="btn btn-success" value="Publicar oferta">
					</div>
				</form>
			</div>
		</div>
	</div>
	</div>
</div>
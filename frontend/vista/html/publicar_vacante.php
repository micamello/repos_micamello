<div class="">
	<div class="">
		<br>
	<div class="breadcrumb">
		<div class="container">
			<b class="publicar_text">Publicar Ofertas</b>
			<?php 
				if (!empty($publicaciones_restantes)) {
					?>
			 <div align="center">
			 	<div class="col-md-12">
			 		<div class="col-md-4 col-sm-4 col-xs-12">
			 			<div class="caja">
			 			<?php 
			 				$fecha_final = "2015-10-17 11:24:00";
			 				foreach ($_SESSION['mfo_datos']['planes'] as $key => $value) {
			 					if($value['fecha_caducidad'] != NULL || $value['fecha_caducidad'] != ""){
			 						if($fecha_final< $value['fecha_caducidad']){
				 						$fecha_final = $value['fecha_caducidad'];
				 					}
			 					}
			 					else{
			 						if(count($_SESSION['mfo_datos']['planes']) == 1){
			 							$fecha_final = "Ilimitado";
			 						}
			 					}
			 				}		 					
			 			?>
						 			<p>Fecha caducidad plan: 
						 			<b><span><?php
						 						if($fecha_final != "Ilimitado"){
						 							echo date_format(date_create($fecha_final), "Y-m-d");
						 						}
						 						else{
						 							echo $fecha_final;
						 						}
						 					?>
						 			<i style="color: #49FC49;" class="fa fa-circle"></i></span></b></p>
			 			

			 			</div>
			 		</div>	
			 		<div class="col-md-4 col-sm-4 col-xs-12">
			 			<div class="caja">

			 				<p>Ofertas restantes:
			 				<b><span> <?php if(!is_numeric($publicaciones_restantes)){echo $publicaciones_restantes; if (!empty($plan_con_pub >0)){echo " + ";} {
			 					# code...
			 				}}

			 							if($plan_con_pub >0 && is_numeric($plan_con_pub)){echo $plan_con_pub;} ?></span></b></p>

			 			</div>
			 		</div>
			 		<div class="col-md-4 col-sm-4 col-xs-12">
			 			<div class="caja">

			 				<p>N° Planes activos: 
			 				<b><span><?php echo count($_SESSION['mfo_datos']['planes']); ?></span></b></p>

			 			</div>
			 		</div>
			 	</div>
			</div>
					<?php
					}
				 ?>	
			 
		</div>
	</div>

	<div class="container">
		<div class="panel panel-default shadow col-md-10 col-md-offset-1">
			<div class="panel-body">
				<form id="form_publicar" role="form" method="post" action="<?php echo PUERTO."://".HOST;?>/publicar/">
					<input type="hidden" name="form_publicar" value="1">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group" id="titu_of_group">
								<label class="">Título oferta: </label>&nbsp;<i class="requerido">*</i><div id="titu_of_error" class="help-block with-errors"></div>
								<input type="text" name="titu_of" id="titu_of" class="form-control" placeholder="Título de la oferta" value="<?php
								    if(isset($_REQUEST['titu_of'])){
								                $name = $_REQUEST['titu_of'];
								                echo $name;
								    }
								?>">
							</div>
						</div>

						<div class="col-md-10 col-md-offset-1">
							<div id="descripcion_group" class="form-group">
								<label class="">Descripción oferta: </label>&nbsp;<i class="requerido">*</i><div id="descripcion_error" class="help-block with-errors"></div>
								<textarea id="des_of" rows="7" name="des_of" class="form-control" style="resize: none;"><?php
								    if(isset($_REQUEST['des_of'])){
								                $name = $_REQUEST['des_of'];
								                echo $name;
								    }
								?></textarea>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group" id="salario_group">

								<label class="">Salario: </label>&nbsp;<i class="requerido">*</i><div id="salario_error" class="help-block with-errors"></div>
								<input type="text" name="salario" id="salario" class="form-control" placeholder="$0.00">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group" id="vacante_group">

								<label>Cantidad de vacantes: </label>&nbsp;<i class="requerido">*</i><div id="vacante_error" class="help-block with-errors"></div>
								<input type="number" id="vacante" name="vacantes" min="1" class="form-control" value="1">

							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Seleccione provincia:</label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
								<select name="provincia_of" id="provincia_of" class="form-control" id="provincia_of">
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
								<select name="ciudad_of" class="form-control" id="ciudad_of">
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
								<div class="form-group" id="area_group">
									<div class="">
										
										<div class="panel panel-default">
											<div class="panel-head-select">Áreas (Máx: 1)
									        	<label class="num_sel" style="float: right; color: black; padding: 0px 5px 0px 5px;">
									          		<label id="numero1">0</label> de 1
									        	</label>
									      </div>
									      <div class="panel-body">
									        <div class="row" id="seleccionados1">
									        </div>
									      </div>
										<div id="area_error" class="help-block with-errors"></div>
										<select class="form-control" name="area_select[]" id="area_select" multiple>
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
							</div>

							<div class="col-md-6">
								<div class="form-group" id="nivel_group">
									<div class="">
										
											<div class="panel panel-default">
												<div class="panel-head-select">Niveles (Máx: 1)
											        <label class="num_sel" style="float: right; color: black; padding: 0px 5px 0px 5px;">
											          <label id="numero2">0</label> de 1
											        </label>
											      </div>
											      <div class="panel-body">
											        <div class="row" id="seleccionados2">
											        </div>
											      </div>
												<div id="nivel_error" class="help-block with-errors"></div>
												<select class="form-control" name="nivel_interes[]" id="nivel_interes" multiple>
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
					</div>


						<div class="col-md-6">
							<div class="form-group">
								<label>Jornada: </label>&nbsp;<i class="requerido">*</i><div class="help-block with-errors"></div>
								<select name="jornada_of" class="form-control">
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
								<select name="escolaridad" class="form-control">
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
								<select name="experiencia" class="form-control">
									<?php 

										foreach(ANOSEXP as $key => $exp){ 
											echo "<option value='$key'>$exp</option>";
										}

									 ?>
								</select>
							</div>
						</div>

						

						<div class="col-md-6">
							<div class="form-group" id="fecha_group">
								<label>Fecha contratación: </label>&nbsp;<i class="requerido">*</i><div id="fecha_error" class="help-block with-errors"></div>
								<input type="date" id="fecha_contratacion" name="fecha_contratacion" class="form-control" value="<?php
								    if(isset($_REQUEST['fecha_contratacion'])){
								                $name = $_REQUEST['fecha_contratacion'];
								                echo $name;
								    }
								?>">
							</div>
						</div>

						<div class="col-md-3 col-md-offset-2">
							<div class="form-group">
								<label>Idioma: </label>
								<select id="idioma_of" name="idioma_of" class="form-control">
									<option value="" selected="" disabled="">Seleccione una opción</option>
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
									<option value="" selected="" disabled="">Seleccione una opción</option>
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
							<div class="col-md-1">
								<div class="form-group" id="effect_bounce">
									<a id="btn_transfer" class="button_transfer_list">+ Añadir idioma</a>
								</div>
							</div>
						</div>



						<div class="col-md-8 col-md-offset-2">

							<div id="listado_group" class="form-group">
								<label>Idiomas seleccionados: </label>&nbsp;<i class="requerido">*</i><div id="listado_error" class="help-block with-errors"></div>
								<!-- <div class="col-md-12"> -->
									<div id="error_msg">
									</div>
									<div class="list_content">
										<div class="form-group" id="list_idioma">
											<p id="text_nothing">Ningun idioma seleccionado.....</p>
										</div>
									</div>
								<!-- </div> -->
								<select style="visibility: hidden; height: 1px;" id="select_array_idioma" name="nivel_idioma[]" multiple>
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
								<select name="viaje" class="form-control">

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
								<select name="licencia" class="form-control">

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
								<select name="cambio_residencia" class="form-control">

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
								<select name="discapacidad" class="form-control">
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

								<select name="confidencial" class="form-control">
									<?php 

										foreach(REQUISITO as $key => $confidencial){ 
											echo "<option value='$key'>$confidencial</option>";
										}

									 ?>

								</select>
							<!-- <span class="label label-default col-md-12">Mostrar datos de la empresa</span> -->
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group" id="edad_min_group">

								<label>Edad mínima: </label>&nbsp;<i class="requerido">*</i><div id="edad_min_error" class="help-block with-errors"></div>
								<input type="number" id="edad_min" name="edad_min" min="18" class="form-control" value="18">
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group" id="edad_max_group">
								<label>Edad máxima: </label>&nbsp;<i class="requerido">*</i><div id="edad_max_error" class="help-block with-errors"></div>
								<input type="number" id="edad_max" name="edad_max" min="18" class="form-control" value="18">
							</div>
						</div>

						
						<div class="col-md-6">
							<div class="form-group">
								<label>¿Oferta urgente? </label>
								<!-- <div class="urgente_class_input">
									<input class="flipswitch_check" type="checkbox" name="urgente" id="urgente" value="0">
									<label class="label_checkbox">Oferta Urgente (<small id="text_urg" style="color: #A7A7A7;">No</small>)</label>
								</div> -->
								<select class="form-control" name="urgente">
									<?php 
										foreach (REQUISITO as $key => $value) {
											echo "<option value='".$key."'>".$value."</option>";
										}
									 ?>
								</select>
							</div>
						</div>
						
					</div>
					<br>
					<div class="row">
						<!-- <a type="submit" class="btn btn-success">Publicar</a> -->
						<input type="submit" id="boton" name="boton" class="btn btn-success" value="Publicar oferta">
					</div>
				</form>
			</div>
		</div>
	</div>
	</div>
</div>
<div class="container">
	<div class="">
		<div class="breadmic_title">
			Publicar Vacante
		</div>
		<div class="panel">
			<div class="panel-body">
				<form id="form_publicar" role="form" method="post" action="<?php echo PUERTO."://".HOST;?>/publicar/">
					<input type="hidden" name="form_publicar" value="1">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="">Título: </label><div class="help-block with-errors"></div>
								<input type="text" name="titu_of" class="form-control" placeholder="Título de la oferta" required value="<?php
								    if(isset($_REQUEST['titu_of'])){
								                $name = $_REQUEST['titu_of'];
								                echo $name;
								    }
								?>">
							</div>
						</div>

						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label class="">Salario: </label><div class="help-block with-errors"></div>
								<input type="text" name="salario" id="salario" class="form-control" placeholder="$0.00" onkeydown=" return valida_letras(event);" required>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label>Cantidad de vacantes: </label><div class="help-block with-errors"></div>
								<input type="number" name="vacantes" min="1" class="form-control" required onkeydown=" return valida_numeros(event);">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label class="">Descripción: </label><div class="help-block with-errors"></div>
								<textarea id="des_of" name="des_of" class="form-control" style="resize: none;" required></textarea>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label class="">Categorías: (Máx: 1)</label><div class="help-block with-errors"></div>
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

						<div class="col-md-3">
							<div class="form-group">
								<label>Nivel: (Máx: 1)</label><div class="help-block with-errors"></div>
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

						<div class="col-md-3">
							<div class="form-group">
								<label>Seleccione provincia:</label><div class="help-block with-errors"></div>
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

						<div class="col-md-3">
							<div class="form-group">
								<label>Seleccione ciudad:</label><div class="help-block with-errors"></div>
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

						<div class="col-md-3">
							<div class="form-group">
								<label>Jornada: </label><div class="help-block with-errors"></div>
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

						<div class="col-md-3">
							<div class="form-group">
								<label>Tipo contrato: </label><div class="help-block with-errors"></div>
								<select name="tipo_cont_of" class="form-control" required>
									<?php if (!empty($arrtipo)){
										foreach ($arrtipo as $tipo_con) {?>
											<option value="<?php echo $tipo_con['id_tipocontrato'] ?>"><?php echo utf8_encode($tipo_con['descripcion']) ?></option>
									<?php }
									}else{ ?>
											<option value="">Selecciona una opción</option>
	                                	<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label>Escolaridad: </label><div class="help-block with-errors"></div>
								<select name="nivel_idi_of" class="form-control" required>
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

						<div class="col-md-3">
							<div class="form-group">
								<label>Años de experiencia: </label><div class="help-block with-errors"></div>
								<select name="experiencia" class="form-control" required>
									<option value="2">1</option>
									<option value="1">1</option>
								</select>
							</div>
						</div>

						

						<div class="col-md-3">
							<div class="form-group">
								<label>Fecha contratación: </label><div class="help-block with-errors"></div>
								<input type="date" name="fecha_contratacion" class="form-control" required>
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-group">
								<label>Idioma: </label><div class="help-block with-errors"></div>
								<select id="idioma_of" name="idioma_of" class="form-control" required>
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

						<div class="col-md-2">
							<div class="form-group">
								<label>Nivel idioma: </label><div class="help-block with-errors"></div>
								<select id="nivel_idi_of" name="nivel_idi_of" class="form-control" required>
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
									<a id="btn_transfer" class="btn btn-info button_transfer_list"><i class="fas fa-plus"></i></a>
								</div>
							</div>
						</div>



						<div class="col-md-6  col-md-offset-3">
							<div class="form-group">
								<label>Idiomas seleccionados: </label><div class="help-block with-errors"></div>
								<!-- <div class="col-md-12"> -->
									<div id="error_msg">
									</div>
									<br>
								<!-- </div> -->
								<select style="visibility: hidden;" id="select_array_idioma" name="nivel_idioma[]" multiple required>
								</select>
							</div>
						</div>

						<div class="col-md-12">
							<div class="" style="padding: 10px 0 0 0; margin: -100px 0 0 0;">
								<div class="form-group" id="list_idioma">
								</div>
							</div>
						</div>

						<div class="form-inline">
							<div class="col-md-12">
								<hr>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label>Disponibilidad para viajar: </label><div class="help-block with-errors"></div>
								<select name="viaje" class="form-control" required>
									<option value="1">Sí</option>
									<option value="2">No</option>
								</select>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label>Licencia: </label><div class="help-block with-errors"></div>
								<select name="licencia" class="form-control" required>
									<option value="1">Sí</option>
									<option value="2">No</option>
								</select>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label>Cambio de residencia: </label><div class="help-block with-errors"></div>
								<select name="cambio_residencia" class="form-control" required>
									<option value="1">Sí</option>
									<option value="2">No</option>
								</select>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label>Discapacidad: </label><div class="help-block with-errors"></div>
								<select name="discapacidad" class="form-control" required>
									<option value="1">Sí</option>
									<option value="2">No</option>
								</select>
							</div>
						</div>

						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label>Confidencial: </label><div class="help-block with-errors"></div>
								<select name="confidencial" class="form-control" required>
									<option value="" selected disabled>Elija una opción</option>
									<option value="1">Sí</option>
									<option value="2">No</option>
								</select>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label>Edad mínima: </label><div class="help-block with-errors"></div>
								<input type="number" name="edad_min" min="1" class="form-control" required onkeydown=" return valida_numeros(event);">
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label>Edad máxima: </label><div class="help-block with-errors"></div>
								<input type="number" name="edad_max" min="1" max="100" class="form-control" required onkeydown=" return valida_numeros(event);">
							</div>
						</div>	
					</div>
					<div class="row">
						<!-- <a type="submit" class="btn btn-success">Publicar</a> -->
						<input type="submit" name="" class="btn btn-success" value="Publicar">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
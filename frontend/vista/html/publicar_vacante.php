<div class="">
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
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="col-md-12">

					<div class="col-md-12">
						<div class="form-group">
							<label>Título de la oferta</label>
							<input type="text" class="form-control" name="nombreOferta" id="nombreOferta">
						</div>
					</div>	

					<div class="col-md-12">
						<div class="form-group">
							<label>Descripción de la oferta</label>
							<textarea id="descripcionOferta" id="descripcionOferta"></textarea>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Salario: </label>
							<input type="text" class="form-control" name="salario" id="salario">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Salario a convenir: </label>
							<select class="form-control" id="salarioConv" name="salarioConv">
								<?php 
									foreach (REQUISITO as $key => $value) {
										echo "<option value='".$key."'>".$value."</option>";
									}
								 ?>
							</select>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Fecha de contratación: </label>
							<input type="text" data-field="date" max="<?php echo date('Y-m-d'); ?>" value="<?php	echo $fecha_contratacion;?>" class="form-control" name="fechaCont" id="fechaCont">
							<div id="fecha"></div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Cantidad de vacantes: </label>
							<input type="text" class="form-control" name="cantVac" id="cantVac" min="1" value="1">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Seleccione provincia: </label>
							<select class="form-control" name="provinciaOf" id="provinciaOf">
							<?php 
								if (!empty($arrprovinciasucursal)) {
									foreach($arrprovinciasucursal as $provincia){
										echo "<option value='".$provincia['id_provincia']."'>".utf8_encode($provincia['nombre'])."</option>";
									}
								}
								else{
									echo "<option value=''>Seleccione una opción</option>";
								}
							 ?>
							</select>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Seleccione ciudad: </label>
							<select class="form-control" name="ciudadOf" id="ciudadOf">
								<option value="" selected="selected" disabled="disabled">Seleccione una ciudad</option>
							</select>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Seleccione área</label>
							<select class="form-control" name="area_select[]" id="area_select" multiple>
						       	<?php 
				                    $i = 0;
				                    if(!empty($areasSubareas) && is_array($areasSubareas)){
				                      foreach ($areasSubareas as $area) {
				                        if($i != $area['id_area']){
				                          echo "<option value='".$area['id_area']."'>".utf8_encode($area['nombre_area'])."</option>";
				                            $i = $area['id_area'];
				                        }
				                      }
				                    }
			                    ?>
						  	</select>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Seleccione subárea</label>
							<select class="form-control" name="subareasCand[]" id="subareasCand" multiple>
							   	<?php                     
			                        if(!empty($areasSubareas) && is_array($areasSubareas)){
			                          foreach ($areasSubareas as $area) {
			                            if($j != $area['id_subareas']){
			                              echo "<option value='".$area['id_area']."_".$area['id_subareas']."_".$area['id_areas_subareas']."'>".utf8_encode($area['nombre_subarea'])."</option>";
			                            }
			                          }
			                        }
		                        ?>
							</select>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Jornada: </label>
							<select class="form-control" name="jornadaOf" id="jornadaOf">
								<?php 
									if (!empty($arrjornada)) {
										foreach ($arrjornada as $jornada) {
											echo "<option value='".$jornada['id_jornada']."'>".$jornada['nombre']."</option>";
										}
									}
									else{
										echo "<option value=''>Seleccione una opción</option>";
									}
								?>
							</select>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Escolaridad: </label>
							<select class="form-control" name="EscolaridadOf" id="EscolaridadOf">
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
							<label>Edad Mínima: </label>
							<input type="text" class="form-control" name="edadMinOf" id="edadMinOf" value="18">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Edad Máxima: </label>
							<input type="text" class="form-control" name="edadMaxOf" id="edadMaxOf" value="18">
						</div>
					</div>
					<div class="col-md-12">
						<label>Selección de idiomas</label>
						<div class="panel panel-default">
							<div class="panel-body">
								<div class="col-md-4">
									<div class="col-md-12">
										<!-- <div class="col-md-6"> -->
											<div class="form-group">
												<label>Idioma: </label>
												<select class="form-control" id="idiomaOf" name="idiomaOf">
													<?php 
														if (!empty($arridioma)){
															foreach ($arridioma as $idioma) {
																echo "<option value='".$idioma['id_idioma']."'>".$idioma['descripcion']."</option>";
															}
														}
														else{
															echo "<option value=''>Seleccione una opción</option>";
														}
													?>
												</select>
											</div>
										<!-- </div> -->
									</div>
									<div class="col-md-12">
										<!-- <div class="col-md-6"> -->
											<div class="form-group">
												<label>Nivel Idioma: </label>
												<select class="form-control" id="nivelIdiomaOf" name="nivelIdiomaOf">
													<?php 
														if (!empty($arrnivelidioma)){
															foreach ($arrnivelidioma as $nivelidioma) {
																echo "<option value='".$nivelidioma['id_nivelIdioma']."'>".$nivelidioma['nombre']."</option>";
															}
														}
														else{
															echo "<option value=''>Seleccione una opción</option>";
														}
													?>
												</select>
											</div>
										<!-- </div> -->
									</div>
								</div>
								<div class="col-md-2">
									<a class="addButton">Añadir idioma</a>
								</div>
								<div class="col-md-6">
									<div class="panel panel-default">
										<div class="panel-body">
											 <ul class="list_content_mic">
											  <li class="select_list">First item</li>
											  <li class="select_list">Second item</li>
											  <li class="select_list">Third item</li>
											</ul> 
										</div>		
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- <div class="panel panel-default col-md-12">
						<div class="panel-body">
							<div class="col-md-6">
								<div class="form-group">
									<label>Idioma: </label>
									<select class="form-control" id="idiomaOf" name="idiomaOf">
										<?php 
											if (!empty($arridioma)){
												foreach ($arridioma as $idioma) {
													echo "<option value='".$idioma['id_idioma']."'>".$idioma['descripcion']."</option>";
												}
											}
											else{
												echo "<option value=''>Seleccione una opción</option>";
											}
										?>
									</select>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Nivel Idioma: </label>
									<select class="form-control" id="nivelIdiomaOf" name="nivelIdiomaOf">
										<?php 
											if (!empty($arrnivelidioma)){
												foreach ($arrnivelidioma as $nivelidioma) {
													echo "<option value='".$nivelidioma['id_nivelIdioma']."'>".$nivelidioma['nombre']."</option>";
												}
											}
											else{
												echo "<option value=''>Seleccione una opción</option>";
											}
										?>
									</select>
								</div>
							</div>
						</div>
					</div> -->

				</div>
			</div>
		</div>
	</div>
</div>
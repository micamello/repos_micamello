<section id="product" class="">
  <div class="text-center">
    <h2 class="titulo">Publicar Ofertas</h2>
  </div>
</section>

<form id="formPublicar" method="POST" action="<?php echo PUERTO.'://'.HOST.'/publicar/' ?>">
	<section id="product" class="bloque-gris">
	  <div class="container">
	    <div class="col-md-6">
	      <label>Seleccione plan:</label>
	      <select name="planUsuario" id="planesSelect" class="form-control">
			<?php
				foreach ($planes as $plan) {							
					echo "<option value='".Utils::encriptar($plan['id_plan']."_".$plan['id_empresa_plan'])."'>Plan ".utf8_encode($plan['nombre'])."</option>";
				}
			?>
			</select>
	    </div>
	    <div class="col-md-6" style="font-size: 12pt;padding-top: 10px;" id="detallePlan">
	    </div>
	  </div>
	</section>
	 <br>

	<div class="container">
		<div class="panel panel-default">
				<input type="hidden" name="registroOferta" id="registroOferta" value="1">
				<div class="panel-body">
					<div class="col-md-12">
						<div class="col-md-12">
							<div class="form-group">
								<label class="campo">Título de la oferta <span class="no">*</span></label>
								<div class="errorContainer"></div>
								<input type="text" class="form-control" value="<?php if(isset($_POST['nombreOferta'])) echo $_POST['nombreOferta']; ?>" name="nombreOferta" id="nombreOferta">
							</div>
						</div>	

						<div class="col-md-12">
							<div class="form-group">
								<label>Descripción de la oferta <b>*</b></label>
								<div class="errorContainer"></div>
								<textarea id="descripcionOferta" name="descripcionOferta" id="descripcionOferta">
									<?php if(isset($_POST['descripcionOferta'])){echo $_POST['descripcionOferta'];}?>
								</textarea>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Salario: <b>*</b></label>
								<div class="errorContainer"></div>
								<input type="text" class="form-control" name="salarioOf" maxlength="8" minlength="3" id="salarioOf" placeholder="00.00" value="<?php if(isset($_POST['salarioOf'])) echo $_POST['salarioOf']; ?>">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Salario a convenir: <b>*</b></label>
								<div class="errorContainer"></div>
								<select class="form-control" id="salarioConv" name="salarioConv">
									<?php 
										foreach (REQUISITO as $key => $value) {
											$selected = "";
											if($_POST['salarioConv'] == $key){$selected = "selected = 'selected'";}
											echo "<option ".$selected." value='".$key."'>".$value."</option>";
										}
									 ?>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Fecha de contratación: <b>*</b></label>
								<div class="errorContainer"></div>
								<input type="text" data-field="date" max="<?php echo date('Y-m-d'); ?>" value="<?php if(isset($_POST['fechaCont'])){echo $_POST['fechaCont'];}else{echo $fecha_contratacion;} ?>" class="form-control" name="fechaCont" id="fechaCont">
								<div id="fecha"></div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Cantidad de vacantes: <b>*</b></label>
								<div class="errorContainer"></div>
								<input type="text" class="form-control" name="cantVac" id="cantVac" maxlength="3" minlength="1" min="1" value="<?php if(isset($_POST['cantVac'])){echo $_POST['cantVac'];}else{echo 1;} ?>">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Seleccione provincia: <b>*</b></label>
								<div class="errorContainer"></div>
								<select class="form-control" name="provinciaOf" id="provinciaOf">
									<option value="" disabled="disabled" selected="selected">Seleccione una opción</option>
								<?php 
									if (!empty($arrprovinciasucursal)) {
										foreach($arrprovinciasucursal as $provincia){
											$selected = "";
											if($_POST['provinciaOf'] == $provincia['id_provincia']){$selected = "selected = 'selected'";}
											echo "<option ".$selected." value='".$provincia['id_provincia']."'>".utf8_encode($provincia['nombre'])."</option>";
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
								<label>Seleccione ciudad <b>*</b></label>
								<div class="errorContainer"></div>
								<select class="form-control" name="ciudadOf" id="ciudadOf">
									<option value="" selected="selected" disabled="disabled">Selecciona una ciudad</option>
									<?php 
										if(isset($_POST['ciudadOf']) && !empty($_POST['ciudadOf'])){
											foreach($arrciudad as $ciudad){
												$selected = "";
												if($_POST['ciudadOf'] == $ciudad['id_ciudad']){$selected = "selected = 'selected'";}
												echo "<option ".$selected." value='".$ciudad['id_ciudad']."'>".$ciudad['ciudad']."</option>";
											}
										}
									?>
								</select>
							</div>
						</div>


						



						<div class="col-md-6">
							<div class="form-group">
								<label>Seleccione área (máx: numero)<b>*</b></label>
								<div class="errorContainer"></div>
								<select class="form-control" name="area_select[]" id="area_select" multiple>
				       	<?php 
				       	// Utils::log("ederederedereder:". print_r($_POST['area_select'], true));
			                $i = 0;                
			                if(!empty($areasSubareas) && is_array($areasSubareas)){
			                  foreach ($areasSubareas as $area) {
			                  	$selected = "";
			                  	// Utils::log("area: ".print_r($area));
			                    if($i != $area['id_area']){
			                    	if(isset($_POST['area_select'])){
			                    		foreach ($_POST['area_select'] as $key => $value) {
			                    		$selected = "";
				                    		if($value == $area['id_area']){$selected = "selected = 'selected'"; break;}
				                    	}
			                    	}
			                      echo "<option ".$selected." value='".$area['id_area']."'>".utf8_encode($area['nombre_area'])."</option>";
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
								<label>Seleccione subárea (máx: numero)<b>*</b></label>
								<div class="errorContainer"></div>
								<select class="form-control" name="subareasCand[]" id="subareasCand" multiple>
								   	<?php                     
				                        if(!empty($areasSubareas) && is_array($areasSubareas)){
				                          foreach ($areasSubareas as $area) {
				                          	$selected = "";
				                            if($j != $area['id_subareas']){
				                            	if(isset($_POST['subareasCand'])){
				                            		foreach ($_POST['subareasCand'] as $key => $value) {
							                    		$selected = "";
							                    		if($value == $area['id_area']."_".$area['id_subareas']."_".$area['id_areas_subareas']){$selected = "selected = 'selected'"; break;}
							                    	}
				                            	}
				                              echo "<option ".$selected." value='".$area['id_area']."_".$area['id_subareas']."_".$area['id_areas_subareas']."'>".utf8_encode($area['nombre_subarea'])."</option>";
				                            }
				                          }
				                        }
			                        ?>
								</select>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								<label>Jornada: <b>*</b></label>
								<div class="errorContainer"></div>
								<select class="form-control" name="jornadaOf" id="jornadaOf">
									<?php 
										if (!empty($arrjornada)) {
											foreach ($arrjornada as $jornada) {
												$selected = "";
												if($_POST['jornadaOf'] == $key){$selected = "selected = 'selected'";}
												echo "<option ".$selected." value='".$jornada['id_jornada']."'>".$jornada['nombre']."</option>";
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
								<label>Escolaridad: <b>*</b></label>
								<div class="errorContainer"></div>
								<select class="form-control" name="escolaridadOf" id="escolaridadOf">
									<?php
										if (!empty($arrescolaridad)){
											foreach ($arrescolaridad as $escolaridad) {
												$selected = "";
												if($_POST['escolaridadOf'] == $key){$selected = "selected = 'selected'";}
												echo "<option ".$selected." value='".$escolaridad['id_escolaridad']."'>".utf8_encode($escolaridad['descripcion'])."</option>";
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
								<label>Edad Mínima: <b>*</b></label>
								<div class="errorContainer"></div>
								<input type="text" class="form-control" name="edadMinOf" id="edadMinOf" value="<?php if(isset($_POST['edadMinOf'])){echo $_POST['edadMinOf'];}else{echo 18;} ?>">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Edad Máxima: <b>*</b></label>
								<div class="errorContainer"></div>
								<input type="text" class="form-control" name="edadMaxOf" id="edadMaxOf" value="<?php if(isset($_POST['edadMaxOf'])){echo $_POST['edadMaxOf'];}else{echo 18;} ?>">
							</div>
						</div>
						<div class="col-md-12">
							<label>Selección de idiomas <b>*</b></label>
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="col-md-5">
										<div class="col-md-12">
											<!-- <div class="col-md-6"> -->
												<div class="form-group">
													<label>Idioma: </label>
													<select class="form-control" id="idiomaOf" name="idiomaOf">
														<?php 
															if (!empty($arridioma)){
																foreach ($arridioma as $idioma) {
																	echo "<option value='".$idioma['id_idioma']."'>".utf8_encode($idioma['descripcion'])."</option>";
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
												<br>
											<!-- </div> -->
										</div>
										<!-- <div><a class="btn-min-light" id="addButton">Añadir idioma</a><br><br></div> -->
										<div align="center">
					                      <a class="btn-min-light" align="center" id="addButton">Añadir idioma</a><br><br>
					                    </div>
									</div>
									<div class="col-md-6 col-md-offset-1">
										<div class="errorContainer"></div>
										<div class="panel panel-default" style="min-height: 200px;">
											<div class="panel-body listPanel" id="listadoIdiomas">
												<label>Seleccione un idioma</label>
											</div>	
										</div>
									</div>

<!-- <option value="1_1" id="array_idioma1" selected="selected"></option> -->


									<div id="listadoIdiomasSeleccionados" style="display: none;">
										<select id="select_array_idioma" name="nivel_idioma[]" multiple="multiple">
										<?php 
											if(isset($_POST['nivel_idioma']) && !empty($_POST['nivel_idioma'])){
												foreach($_POST['nivel_idioma'] as $key=>$value){
													echo "<option value='".$value."' selected='selected' id='array_idioma".explode('_', $value)[0]."'></option>";
												}
											}
										?>
										</select>
									</div>

									
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Años de experiencia: <b>*</b></label>
								<div class="errorContainer"></div>
								<select class="form-control" name="anosexp" id="anosexp">
									<?php
										foreach(ANOSEXP as $key => $exp){
										$selected = "";
											if($POST['anosexp'] == $key){$selected = "selected = 'selected'";}
											echo "<option ".$selected." value='$key'>$exp</option>";
										}
									?>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Disponibilidad para viajar: <b>*</b></label>
								<div class="errorContainer"></div>
								<select class="form-control" name="DispOf" id="dispOf">
									<?php 
										foreach (REQUISITO as $key => $value) {
											$selected = "";
											if($_POST['DisOf'] == $key){$selected = "selected = 'selected'";}
											echo "<option ".$selected." value='".$key."'>".$value."</option>";
										}
									?>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Tipo de Licencia: <b>*</b></label>
								<div class="errorContainer"></div>
								<select class="form-control" name="licenciaOf" id="licenciaOf">
									<option value="0">Sin Licencia</option>
									<?php 
										foreach ($tipolicencia as $key => $value) {
											$selected = "";
											if($_POST['licenciaOf'] == $key){$selected = "selected = 'selected'";}
											echo "<option ".$selected." value='".$key."'>".$value."</option>";
										}
									?>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Cambio de residencia: <b>*</b></label>
								<div class="errorContainer"></div>
								<select class="form-control" name="residenciaOf" id="residenciaOf">
									<?php 
										foreach (REQUISITO as $key => $value) {
											$selected = "";
											if($_POST['residenciaOf'] == $key){$selected = "selected = 'selected'";}
											echo "<option ".$selected." value='".$key."'>".$value."</option>";
										}
									?>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Discapacidad: <b>*</b></label>
								<div class="errorContainer"></div>
								<select class="form-control" name="discapacidadOf" id="discapacidadOf">
									<?php 
										foreach (REQUISITO as $key => $value) {
											$selected = "";
											if($_POST['discapacidadOf'] == $key){$selected = "selected = 'selected'";}
											echo "<option ".$selected." value='".$key."'>".$value."</option>";
										}
									?>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Primer empleo: <b>*</b></label>
								<div class="errorContainer"></div>
								<select class="form-control" name="primerEmpleoOf" id="primerEmpleoOf">
									<?php 
										foreach (REQUISITO as $key => $value) {
											$selected = "";
											if($_POST['primerEmpleoOf'] == $key){$selected = "selected = 'selected'";}
											echo "<option ".$selected." value='".$key."'>".$value."</option>";
										}
									?>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>¿Oferta urgente?: <b>*</b></label>
								<div class="errorContainer"></div>
								<select class="form-control" name="ofertaUrgenteOf" id="ofertaUrgenteOf">
									<?php 
										foreach (REQUISITO as $key => $value) {
											$selected = "";
											if($_POST['ofertaUrgenteOf'] == $key){$selected = "selected = 'selected'";}
											echo "<option ".$selected." value='".$key."'>".$value."</option>";
										}
									?>
								</select>
							</div>
						</div>

						<div class="col-md-6" id="confidencialObligatory" style="display: none;">
							<div class="form-group">
								<div class="confidencialObligatory">
									<label>Publicación confidencial</label>
									<div><span class="text-help">El plan seleccionado no permite mostrar sus datos</span></div>
								</div>
							</div>
						</div>

						<div class="col-md-6" style="display: none;">
							<div class="form-group">
								<label>Confidencial: <b>*</b></label>
								<div class="errorContainer"></div>
								<select class="form-control" name="confidencialOf" id="confidencialOf">
									<?php 
										foreach (REQUISITO as $key => $value) {
											$selected = "";
											if($_POST['confidencialOf'] == $key){$selected = "selected = 'selected'";}
											echo "<option ".$selected." value='".$key."'>".$value."</option>";
										}
									?>
								</select>
								<span class="help-block">(No/Si presentar informaci&oacute;n de la empresa)</span>
								<!-- <span class="help-block">(No/Si presentar informaci&oacute;n de la empresa)</span> -->
							</div>
						</div>

						<!-- <div class="col-md-12">
							<div class="text-center">
								<input type="submit" name="btnPublicar" id="btnPublicar" class="btn btn-success" value="Publicar oferta">
							</div>
						</div> -->

						<div class="col-md-12">
			              <div class="text-center">
			                <input type="submit" name="btnPublicar" id="btnPublicar" class="btn-blue" value="Publicar oferta">
			              </div>
			            </div>

					</div>
				</div>
			
		</div>
	</div>
</form>
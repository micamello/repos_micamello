<section id="product" class="">
  <div class="text-center">
    <h2 class="titulo">Publicar Ofertas</h2>
  </div>
</section>

<form id="formPublicar" method="POST" action="<?php echo PUERTO.'://'.HOST.'/registroOferta/' ?>">
	<section id="product" class="inicio">
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
								<label>Título de la oferta</label>
								<div class="msgError"></div>
								<input type="text" class="form-control" name="nombreOferta" id="nombreOferta">
							</div>
						</div>	

						<div class="col-md-12">
							<div class="form-group">
								<label>Descripción de la oferta</label>
								<div class="msgError"></div>
								<textarea id="descripcionOferta" name="descripcionOferta" id="descripcionOferta"></textarea>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Salario: </label>
								<div class="msgError"></div>
								<input type="text" class="form-control" name="salarioOf" id="salarioOf" placeholder="00.00">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Salario a convenir: </label>
								<div class="msgError"></div>
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
								<div class="msgError"></div>
								<input type="text" data-field="date" max="<?php echo date('Y-m-d'); ?>" value="<?php	echo $fecha_contratacion;?>" class="form-control" name="fechaCont" id="fechaCont">
								<div id="fecha"></div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Cantidad de vacantes: </label>
								<div class="msgError"></div>
								<input type="text" class="form-control" name="cantVac" id="cantVac" min="1" value="1">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Seleccione provincia: </label>
								<div class="msgError"></div>
								<select class="form-control" name="provinciaOf" id="provinciaOf">
									<option value="" disabled="disabled" selected="selected">Seleccione una opción</option>
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
								<div class="msgError"></div>
								<select class="form-control" name="ciudadOf" id="ciudadOf">
									<option value="" selected="selected" disabled="disabled">Seleccione una ciudad</option>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Seleccione área</label>
								<div class="msgError"></div>
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
								<div class="msgError"></div>
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
								<div class="msgError"></div>
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
								<div class="msgError"></div>
								<select class="form-control" name="escolaridadOf" id="escolaridadOf">
									<?php
										if (!empty($arrescolaridad)){
											foreach ($arrescolaridad as $escolaridad) {
												echo "<option value='".$escolaridad['id_escolaridad']."'>".utf8_encode($escolaridad['descripcion'])."</option>";
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
								<label>Edad Mínima: </label>
								<div class="msgError"></div>
								<input type="text" class="form-control" name="edadMinOf" id="edadMinOf" value="18">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Edad Máxima: </label>
								<div class="msgError"></div>
								<input type="text" class="form-control" name="edadMaxOf" id="edadMaxOf" value="18">
							</div>
						</div>
						<div class="col-md-12">
							<label>Selección de idiomas</label>
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
					                      <a class="btn-blue" align="center" id="addButton">Añadir idioma</a><br><br>
					                    </div>
									</div>
									<div class="col-md-6 col-md-offset-1">
										<div class="msgError"></div>
										<div class="panel panel-default" style="min-height: 200px;">
											<div class="panel-body listPanel" id="listadoIdiomas">
												<label>Seleccione un idioma</label>
											</div>	
										</div>
									</div>

									<div id="listadoIdiomasSeleccionados" style="display: none;">
										<select id="select_array_idioma" name="nivel_idioma[]" multiple="multiple"></select>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Años de experiencia: </label>
								<div class="msgError"></div>
								<select class="form-control" name="anosexp" id="anosexp">
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
								<label>Disponibilidad para viajar: </label>
								<div class="msgError"></div>
								<select class="form-control" name="DispOf" id="dispOf">
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
								<label>Tipo de Licencia: </label>
								<div class="msgError"></div>
								<select class="form-control" name="licenciaOf" id="licenciaOf">
									<option value="0">Sin Licencia</option>
									<?php 
										foreach ($tipolicencia as $key => $value) {
											echo "<option value='".$key."'>".$value."</option>";
										}
									?>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Cambio de residencia: </label>
								<div class="msgError"></div>
								<select class="form-control" name="residenciaOf" id="residenciaOf">
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
								<label>Discapacidad: </label>
								<div class="msgError"></div>
								<select class="form-control" name="discapacidadOf" id="discapacidadOf">
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
								<label>Primer empleo: </label>
								<div class="msgError"></div>
								<select class="form-control" name="primerEmpleoOf" id="primerEmpleoOf">
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
								<label>¿Oferta urgente?: </label>
								<div class="msgError"></div>
								<select class="form-control" name="ofertaUrgenteOf" id="ofertaUrgenteOf">
									<?php 
										foreach (REQUISITO as $key => $value) {
											echo "<option value='".$key."'>".$value."</option>";
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
								<label>Confidencial: </label>
								<div class="msgError"></div>
								<select class="form-control" name="confidencialOf" id="confidencialOf">
									<?php 
										foreach (REQUISITO as $key => $value) {
											echo "<option value='".$key."'>".$value."</option>";
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
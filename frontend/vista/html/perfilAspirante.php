<div class="container">
	<!-- <?php print_r("eder: ".$id_oferta.$vista); ?> -->
		<br><br><br><br><br><br>
	<div class="col-md-10 col-md-offset-1" id="contenido_imprimir">
		<div class="panel panel-default shadow">
			<div class="panel-body">
				<div class="" align="center">
					<div>
						<?php if (!empty($infoUsuario) && is_array($infoUsuario)) {?>
						
						<div class="text-center">
							<div class="col-md-12">
								<img class="perfil_photo_user" src="<?php echo Modelo_Usuario::obtieneFoto($infoUsuario['username']) ?>">
							</div>
						</div>

						<h3 class="text-center">
							<?php echo ucwords(utf8_encode($infoUsuario['nombres']." ".$infoUsuario['apellidos']));
								if($vista != 2){
							?>
								<h5><b>Aspiración salarial:</b> 
							<?php 
								if ((!(empty($asp_sararial['asp_salarial'])))) {
									echo SUCURSAL_MONEDA." ".number_format($asp_sararial['asp_salarial'], 2);
								}
								else{
									echo "-------";
								}
							 }
							 ?>
							</h5>
							<h5><b>Nacionalidad:</b>
								<?php 
									if (!empty($infoUsuario['nacionalidad'])) {
										echo utf8_encode($infoUsuario['nacionalidad']);
									}
									else{
										echo "-------";
									}
								?>
							</h5>
							<!-- <br> -->
						</h3>
						<div class="">
							<hr>
							<h4>Datos candidato</h4>

							<!-- <a onclick="imprimir('contenido_imprimir');" id="boton_imprimir" class="btn btn-warning min_btn btn-xs">Imprimir datos <i class="fa fa-print"></i></a> -->
							
							<a href="<?php echo PUERTO."://".HOST."/fileGEN/datousuario/".$infoUsuario['username']."/".$vista."/".$id_oferta."/" ?>" class="btn btn-info btn-xs" target="_blanked">Imprimir datos <i class="fa fa-file-pdf-o"></i></a>
							<!-- <a id="print" target="_blanked">Descargar datos <i class="fa fa-file-pdf-o"></i></a> -->
							<br><br>
							<div class="col-md-5 col-md-offset-1 form-group">
								<div class="box_text">
									<label>Estado civil <i class="fa fa-user icon fa-2x"></i></label>
										<?php 
										if ($infoUsuario['estado_civil'] != NULL || $infoUsuario['estado_civil'] != "") {
											foreach (ESTADO_CIVIL as $key => $estado) {
												if ($infoUsuario['estado_civil'] == $key) {
													echo "<h6>".$estado."</h6>";
												}
											}
										}
										else{
											echo "<h6>----------</h6>";
										}
										 ?>
								</div>
							</div>

							<div class="col-md-5 form-group">
								<div class="box_text">
									<label>Trabaja <i class="fa fa-briefcase icon fa-2x"></i></label>
										<?php 
										if ($infoUsuario['tiene_trabajo'] != NULL || $infoUsuario['tiene_trabajo'] != "") {
											foreach (REQUISITO as $key => $trabaja) {
												if ($infoUsuario['tiene_trabajo'] == $key) {
													echo "<h6>".$trabaja."</h6>";
												}
											}
										}
										else{
											echo "<h6>----------</h6>";
										}
										?>
								</div>
							</div>

							<div class="col-md-5 col-md-offset-1 form-group">
								<div class="box_text">
									<label>Disponibilidad viajar <i class="fa fa-car icon fa-2x"></i></label>
										<?php 
										if ($infoUsuario['viajar'] != NULL || $infoUsuario['viajar'] != "") {
											foreach (REQUISITO as $key => $viajar) {
												if ($infoUsuario['viajar'] == $key) {
													echo "<h6>".$viajar."</h6>";
												}
											}
										}
										else{
											echo "<h6>----------</h6>";
										}
										 ?>
								</div>
							</div>

							<div class="col-md-5 form-group">
								<div class="box_text">
									<label>Licencia <i class="fa fa-id-card icon fa-2x"></i></label>
										<?php 
										if ($infoUsuario['licencia'] != NULL || $infoUsuario['licencia'] != "") {
											foreach (REQUISITO as $key => $licencia) {
												if ($infoUsuario['licencia'] == $key) {
													echo "<h6>".$licencia."</h6>";
												}
											}
										}
										else{
											echo "<h6>----------</h6>";
										}
										 ?>
								</div>
							</div>

							<div class="col-md-5 col-md-offset-1 form-group">
								<div class="box_text">
									<label>Discapacidad <i class="fa fa-wheelchair icon fa-2x"></i></label>
										<?php 
										if ($infoUsuario['discapacidad'] != NULL || $infoUsuario['discapacidad'] != "") {
											foreach (REQUISITO as $key => $discapacidad) {
												if ($infoUsuario['discapacidad'] == $key) {
													echo "<h6>".$discapacidad."</h6>";
												}
											}
										}
										else{
											echo "<h6>----------</h6>";
										}
										 ?>
								</div>
							</div>

							<div class="col-md-5 form-group">
								<div class="box_text">
									<label>Años experiencia <i class="fa fa-star icon fa-2x"></i></label>
										<?php 
										if ($infoUsuario['anosexp'] != NULL || $infoUsuario['anosexp'] != "") {
											foreach (ANOSEXP as $key => $anosexp) {
												if ($infoUsuario['anosexp'] == $key) {
													echo "<h6>".$anosexp."</h6>";
												}
											}
										}
										else{
											echo "<h6>----------</h6>";
										}
										 ?>
								</div>
							</div>

							<div class="col-md-5 col-md-offset-1 form-group">
								<div class="box_text">
									<label>Estado carrera <i class="fa fa-check icon fa-2x"></i></label>
										<?php 
										if ($infoUsuario['status_carrera'] != NULL || $infoUsuario['status_carrera'] != "") {
											foreach (STATUS_CARRERA as $key => $carrera) {
												if ($infoUsuario['status_carrera'] == $key) {
													echo "<h6>".$carrera."</h6>";
												}
											}
										}
										else{
											echo "<h6>----------</h6>";
										}
										 ?>
								</div>
							</div>

							<div class="col-md-5 form-group">
								<div class="box_text">
									<label>Escolaridad <i class="fa fa-graduation-cap icon fa-2x"></i></label>
										<?php 
										if ($infoUsuario['escolaridad'] != NULL || $infoUsuario['escolaridad'] != "") {
											echo "<h6>".utf8_encode($infoUsuario['escolaridad'])."</h6>";
										}
										else{
											echo "<h6>----------</h6>";
										}
										 ?>
								</div>
							</div>

							<div class="col-md-5 col-md-offset-1 form-group">
								<div class="box_text">
									<label>Género <i class="fa fa-mars icon fa-2x"></i></label>
										<?php 
										if ($infoUsuario['genero'] != NULL || $infoUsuario['genero'] != "") {
											foreach (GENERO as $key => $genero) {
												if ($infoUsuario['genero'] == $key) {
													echo "<h6>".$genero."</h6>";
												}
											}
										}
										else{
											echo "<h6>----------</h6>";
										}
										 ?>
								</div>
							</div>

							<!-- <div class="col-md-5 form-group">
								<div class="box_text">
									<label>Cambio de residencia <i class="fa fa-home icon fa-2x"></i></label>
										<?php 
											if ($infoUsuario['residencia'] != NULL || $infoUsuario['residencia'] != "") {
												foreach (REQUISITO as $key => $residencia) {
													if ($infoUsuario['residencia'] == $key) {
														echo "<h6>".utf8_encode($residencia)."</h6>";
													}
												}
											}
											else{
												echo "<h6>----------</h6>";
											}
										 ?>
								</div>
							</div> -->

							<div class="col-md-5 form-group">
								<div class="box_text">
									<label>Fecha Nac. / Edad <i class="fa fa-calendar icon fa-2x"></i></label>
										<?php 
											if (($infoUsuario['fecha_nacimiento'] != NULL || $infoUsuario['fecha_nacimiento'] != "") || ($infoUsuario['edad'] != NULL || $infoUsuario['edad'] != "")) {
												echo "<h6>".utf8_encode($infoUsuario['fecha_nacimiento'])." (".$infoUsuario['edad']." años)"."</h6>";
											}
											else{
												echo "<h6>----------</h6>";
											}
										 ?>
								</div>
							</div>
							<div class="col-md-12">
								<hr>
								<h4>Estudios</h4>
							</div>
							<?php if(($infoUsuario['id_univ'] == NULL || $infoUsuario['id_univ'] == "") && ($infoUsuario['universidad'] != NULL || $infoUsuario['universidad']) != ""){
								?>
								<div class="col-md-12">
									<p>Estudios en el extrajero</p>
								</div>
							<?php
								}
							 ?>
							<div class="col-md-6 col-md-offset-3 form-group">
								<div class="box_text">
									<label>Universidad <i class="fa fa-university icon fa-2x"></i></label>
										<?php 
											if ($infoUsuario['universidad'] != NULL || $infoUsuario['universidad'] != "") {
												echo "<h6>".utf8_encode($infoUsuario['universidad'])."</h6>";
											}
											else{
												echo "<h6>----------</h6>";
											}
										 ?>
								</div>
							</div>

							<div class="col-md-5 col-md-offset-1 form-group">
								<div class="box_text">
									<label>Escolaridad <i class="fa fa-university icon fa-2x"></i></label>
										<?php 
											if ($infoUsuario['id_escolaridad'] != NULL || $infoUsuario['id_escolaridad'] != "") {
												foreach ($escolaridad as $key => $value) {
													if($key == $infoUsuario['id_escolaridad']){
														echo "<h6>".utf8_encode($value)."</h6>";
													}
												}
											}
											else{
												echo "<h6>----------</h6>";
											}
										 ?>
								</div>
							</div>

							<div class="col-md-5 form-group">
								<div class="box_text">
									<label>Estado carrera <i class="fa fa-university icon fa-2x"></i></label>
										<?php 
											if ($infoUsuario['status_carrera'] != NULL || $infoUsuario['status_carrera'] != "") {
												foreach (STATUS_CARRERA as $key => $value) {
													if($key == $infoUsuario['status_carrera']){
														echo "<h6>".utf8_encode($value)."</h6>";
													}
												}
											}
											else{
												echo "<h6>----------</h6>";
											}
										 ?>
								</div>
							</div>

							<div class="col-md-12">
								<hr>
								<h4>Datos domiciliarios</h4>
								<div class="col-md-4 form-group">
									<div class="box_text">
										<label>País <i class="fa fa-globe icon fa-2x"></i></label>
											<?php 
												if ($infoUsuario['pais'] != NULL || $infoUsuario['pais'] != "") {
													echo "<h6>".utf8_encode($infoUsuario['pais'])."</h6>";	
												}
												else{
													echo "<h6>----------</h6>";
												}
											 ?>
									</div>
								</div>

								<div class="col-md-4 form-group">
									<div class="box_text">
										<label>Provincia <i class="fa fa-map-marker icon fa-2x"></i></label>
											<?php 
												if ($infoUsuario['provincia'] != NULL || $infoUsuario['provincia'] != "") {
													echo "<h6>".utf8_encode($infoUsuario['provincia'])."</h6>";	
												}
												else{
													echo "<h6>----------</h6>";
												}
											 ?>
									</div>
								</div>

								<div class="col-md-4 form-group">
									<div class="box_text">
										<label>Ciudad <i class="fa fa-map-marker icon fa-2x"></i></label>
											<?php 
												if ($infoUsuario['ciudad'] != NULL || $infoUsuario['ciudad'] != "") {
													echo "<h6>".utf8_encode($infoUsuario['ciudad'])."</h6>";
												}
												else{
													echo "<h6>----------</h6>";
												}
											 ?>
									</div>
								</div>
							</div>

							<div class="col-md-12">
								<hr>
								<h4>Dominio de idiomas</h4>
								<div class="col-md-10 col-md-offset-1 form-group">
									<div class="box_text">
										<label>Idiomas <i class="fa fa-language icon fa-2x"></i></label>
										<?php $idiomas = Modelo_NivelxIdioma::relacionIdiomaNivel($infoUsuario['idiomas']); 
										if (!empty($idiomas)) {
											foreach ($idiomas as $key => $value) {
					                               echo "<h6>".utf8_encode($value['descripcion'].' - '.$value['nombre']).'</h6>';
					                            }
										}else{
											echo "<h6>-------------</h6>";
										}
										?>
									</div>
								</div>
							</div>

							<div class="col-md-12">
								<hr>
								<h4>Preferencias de empleos</h4>
								<div class="col-md-5 col-md-offset-1 form-group">
									<div class="box_text">
										<label>Áreas de interés <i class="fa fa-list-alt icon fa-2x"></i></label>
										<?php $areas = Modelo_Area::obtieneAreas($infoUsuario['areas']);
											if(!empty($areas) && is_array($areas)){
												foreach ($areas as $key => $value) {
													echo "<h6>".utf8_encode($value['nombre'])."</h6>";
												}
											}else{
												echo "<h6>-------------</h6>";
											}
										?>
									</div>
								</div>
								<div class="col-md-5 form-group">
									<div class="box_text">
										<label>Nivel de interés <i class="fa fa-list-alt icon fa-2x"></i></label>
										<?php $niveles = Modelo_Interes::obtieneIntereses($infoUsuario['nivel']);
											if(!empty($niveles) && is_array($niveles)){
												foreach ($niveles as $key => $value) {
													echo "<h6>".utf8_encode($value['descripcion'])."</h6>";
												}
											}else{
												echo "<h6>-------------</h6>";
											}
										?>
									</div>
								</div>
							</div>
						</div>

						

						<?php } ?>
					</div>
					<div class="col-md-12">
						<hr>
						<h4>Datos de contacto</h4>
						
					</div>
					<div class="" align="center">
						
							<?php if (!empty($Conf) && is_array($Conf)) {
								?>
								<div class="">
									

									<div class="col-md-4 form-group">
										<div class="box_text">
											<label>Teléfono <i class="fa fa-phone icon fa-2x"></i></label>
											<h6><?php echo $Conf['telefono'] ?></h6>
										</div>
									</div>

									<div class="col-md-4 form-group">
										<div class="box_text">
											<label>Correo <i class="fa fa-at icon fa-2x"></i></label>
											<h6><?php echo $Conf['correo'] ?></h6>
										</div>
									</div>

									<div class="col-md-4 form-group">
										<div class="box_text">
											<label>DNI <i class="fa fa-address-card-o  icon fa-2x"></i></label>
											<h6><?php echo $Conf['dni'] ?></h6>
										</div>
									</div>
								</div>

								<?php
							} ?>
						
					</div>

					<div>
						
					</div>
				</div>

				<br><br><br>
				<div class="col-md-12">
					<hr>
					<h4 class="text-center">Resultados evaluación</h4>
				<?php if(empty($Resultados) && is_array($Resultados)){ ?>
					<div class="alert alert-info">Estimado usuario. <br>El plan que posee actualmente no permite visualizar datos de la evaluación de los postulantes</div>
				<?php echo $enlaceCompraPlan;
					} 
				else{
					foreach ($Resultados as $res) {
						?>
							<input type="hidden" name="nombres_res" value="<?php echo ($res['nombre']) ?>">
							<input type="hidden" name="valor_res" value="<?php echo $res['valor'] ?>">
						<?php
						}
					?>
				
					<div class="hidden-xs hidden-sm" id="result_graph">
						<div class="col-md-10 col-md-offset-1">
						 	<canvas id="myChart"></canvas>
						</div>
					</div>

					<div class="hidden-lg hidden-md">
					<?php $i = 0; foreach ($Resultados as $res) {
						$color = ["#1278A2", "#7D4AF2", "#187D22", "#9A3030", "#637103", "#665706", "#716E69", "#256AF6", "#555555", "#075F5A", "#50AF0B"];
						?>
							<div class="col-md-6 col-sm-6">
							<p class="text-center text_progress_bar"><?php echo utf8_encode($res['nombre']) ?></p>
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo ($res['valor']*100)/25 ?>%; background-color: <?php echo $color[$i]; $i++; ?>;">
								    <?php echo $res['valor'] ?>
								  </div>
								</div>
							</div>
					<?php
						}
					?>
					</div>
				<?php } ?>
				</div>
			</div>
		</div>


		<div class="col-md-2">
			
		</div>
	</div>

</div>
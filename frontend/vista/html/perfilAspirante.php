<div class="container">
		<br><br><br><br><br><br>
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default shadow">
			<div class="panel-body">
				<div class="">
					<div>
						<?php if (!empty($NoConf) && is_array($NoConf)) {?>
						
						<div class="text-center">
							<div class="col-md-12">
								<img class="perfil_photo_user" src="<?php echo Modelo_Usuario::obtieneFoto($NoConf['id_usuario']) ?>">
							</div>
						</div>
						<h3 class="text-center">
							<?php echo ucfirst(utf8_encode($NoConf['nombres']." ".$NoConf['apellidos'])) ?>
							<h5>Aspiración salarial: <?php echo $_SESSION['mfo_datos']['sucursal']['simbolo']." ".number_format($NoConf[0]['asp_salarial'], 2) ?></h5><br>
						</h3>

						<div class="row">
							<div class="col-md-5 col-md-offset-1 form-group">
								<div class="box_text">
									<label>Estado civil <i class="fa fa-user icon fa-2x"></i></label>
										<?php 
										if ($NoConf['estado_civil'] != NULL || $NoConf['estado_civil'] = "") {
											foreach (ESTADO_CIVIL as $key => $estado) {
												if ($NoConf['estado_civil'] == $key) {
													echo "<h6>".$estado."</h6>";
												}
											}
										}
										else{
											echo "<h6>------</h6>";
										}
										 ?>
								</div>
							</div>

							<div class="col-md-5 form-group">
								<div class="box_text">
									<label>Trabaja <i class="fa fa-briefcase icon fa-2x"></i></label>
										<?php 
										if ($NoConf['tiene_trabajo'] != NULL || $NoConf['tiene_trabajo'] = "") {
											foreach (REQUISITO as $key => $trabaja) {
												if ($NoConf['tiene_trabajo'] == $key) {
													echo "<h6>".$trabaja."</h6>";
												}
											}
										}
										else{
											echo "<h6>------</h6>";
										}
										?>
								</div>
							</div>

							<div class="col-md-5 col-md-offset-1 form-group">
								<div class="box_text">
									<label>Disponibilidad viajar <i class="fa fa-car icon fa-2x"></i></label>
										<?php 
										if ($NoConf['viajar'] != NULL || $NoConf['viajar'] = "") {
											foreach (REQUISITO as $key => $viajar) {
												if ($NoConf['viajar'] == $key) {
													echo "<h6>".$viajar."</h6>";
												}
											}
										}
										else{
											echo "<h6>------</h6>";
										}
										 ?>
								</div>
							</div>

							<div class="col-md-5 form-group">
								<div class="box_text">
									<label>Licencia <i class="fa fa-id-card icon fa-2x"></i></label>
										<?php 
										if ($NoConf['licencia'] != NULL || $NoConf['licencia'] = "") {
											foreach (REQUISITO as $key => $licencia) {
												if ($NoConf['licencia'] == $key) {
													echo "<h6>".$licencia."</h6>";
												}
											}
										}
										else{
											echo "<h6>------</h6>";
										}
										 ?>
								</div>
							</div>

							<div class="col-md-5 col-md-offset-1 form-group">
								<div class="box_text">
									<label>Discapacidad <i class="fa fa-wheelchair icon fa-2x"></i></label>
										<?php 
										if ($NoConf['discapacidad'] != NULL || $NoConf['discapacidad'] = "") {
											foreach (REQUISITO as $key => $discapacidad) {
												if ($NoConf['discapacidad'] == $key) {
													echo "<h6>".$discapacidad."</h6>";
												}
											}
										}
										else{
											echo "<h6>------</h6>";
										}
										 ?>
								</div>
							</div>

							<div class="col-md-5 form-group">
								<div class="box_text">
									<label>Años experiencia <i class="fa fa-star icon fa-2x"></i></label>
										<?php 
										if ($NoConf['anosexp'] != NULL || $NoConf['anosexp'] = "") {
											foreach (ANOSEXP as $key => $anosexp) {
												if ($NoConf['anosexp'] == $key) {
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
										if ($NoConf['status_carrera'] != NULL || $NoConf['status_carrera'] = "") {
											foreach (STATUS_CARRERA as $key => $carrera) {
												if ($NoConf['status_carrera'] == $key) {
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
										if ($NoConf['escolaridad'] != NULL || $NoConf['escolaridad'] = "") {
											echo "<h6>".utf8_encode($NoConf['escolaridad'])."</h6>";
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
										if ($NoConf['genero'] != NULL || $NoConf['genero'] = "") {
											foreach (GENERO as $key => $genero) {
												if ($NoConf['genero'] == $key) {
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

							<div class="col-md-5 form-group">
								<div class="box_text">
									<label>Universidad <i class="fa fa-university icon fa-2x"></i></label>
										<?php 
											if ($NoConf['universidad'] != NULL || $NoConf['universidad'] = "") {
												echo "<h6>".utf8_encode($NoConf['universidad'])."</h6>";
											}
											else{
												echo "<h6>----------</h6>";
											}
										 ?>
								</div>
							</div>

							<div class="col-md-5 col-md-offset-1 form-group">
								<div class="box_text">
									<label>Cambio de residencia <i class="fa fa-home icon fa-2x"></i></label>
										<?php 
											if ($NoConf['residencia'] != NULL || $NoConf['residencia'] = "") {
												foreach (REQUISITO as $key => $residencia) {
													if ($NoConf['residencia'] == $key) {
														echo "<h6>".$residencia."</h6>";
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
									<label>Fecha Nac. / Edad <i class="fa fa-calendar icon fa-2x"></i></label>
										<?php 
											if (($NoConf['fecha'] != NULL || $NoConf['fecha'] = "") || ($NoConf['edad'] != NULL || $NoConf['edad'] = "")) {
												echo "<h6>".utf8_encode($NoConf['fecha'])." (".$NoConf['edad']." años)"."</h6>";
											}
											else{
												echo "<h6>----------</h6>";
											}
										 ?>
								</div>
							</div>

							<div class="col-md-5 col-md-offset-1 form-group">
								<div class="box_text">
									<label>País <i class="fa fa-globe icon fa-2x"></i></label>
										<?php 
											if ($NoConf['pais'] != NULL || $NoConf['pais'] = "") {
												echo "<h6>".$NoConf['pais']."</h6>";	
											}
											else{
												echo "<h6>----------</h6>";
											}
										 ?>
								</div>
							</div>

							<div class="col-md-5 form-group">
								<div class="box_text">
									<label>Ciudad <i class="fa fa-map-marker icon fa-2x"></i></label>
										<?php 
											if ($NoConf['ciudad'] != NULL || $NoConf['ciudad'] = "") {
												echo "<h6>".utf8_encode($NoConf['ciudad'])."</h6>";
											}
											else{
												echo "<h6>----------</h6>";
											}
										 ?>
								</div>
							</div>
						</div>

						

						<?php } ?>
					</div>
					<div class="" align="center">
						
							<?php if (!empty($Conf) && is_array($Conf)) {
								?>
								<div class="">
									<h5>Datos de contacto</h5>

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
			<h5 class="text-center">Resultados evaluación</h5>
			<?php if(empty($Resultados) && is_array($Resultados)){ ?>
				<div class="alert alert-info">Estimado usuario. <br>El plan que posee actualmente no permite visualizar datos de la evaluación los postulantes postulantes</div>
			<?php } 
			else{
				foreach ($Resultados as $res) {
					?>
					<input type="hidden" name="nombres_res" value="<?php echo utf8_encode($res['nombre']) ?>">
					<input type="hidden" name="valor_res" value="<?php echo $res['valor'] ?>">
					<?php
				}

				?>
			<br><br><br>
			<div class="col-md-10 col-md-offset-1">
			 	<canvas id="myChart"></canvas>
			</div>
			<?php } ?>
			</div>
		</div>


		<div class="col-md-2">
			
		</div>
	</div>

</div>
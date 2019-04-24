<div class="container">
		<br><br><br><br><br><br>
	<div class="col-md-10 col-md-offset-1" id="contenido_imprimir">
		<div class="panel panel-default shadow">
			<div class="panel-body">
				<div class="fotoPerfil">
					<div class="text-center">
						<div class="col-md-12">
							<img class="perfil_photo_user" src="<?php echo Modelo_Usuario::obtieneFoto($datosUsuario['username']) ?>">
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<!-- <?php echo $vista; ?> -->
					<a target="_blanked" href="<?php echo PUERTO.'://'.HOST.'/hvUsuario/'.Utils::encriptar($datosUsuario['username']).'/'.$id_oferta.'/'.$vista.'/' ?>" class="btn btn-warning">Descargar datos</a>
				</div>
				<div class="col-md-12">
					<div class="nombreUsuario">
						<h5 class=""><?php echo $datosUsuario['nombres']." ".$datosUsuario['apellidos'] ?></h5>
					</div>
					<?php if(isset($datosUsuario['aspSalarial'])){
						echo "<h5><b>Aspiración salarial: </b>". SUCURSAL_MONEDA.$datosUsuario['aspSalarial']."</h5>";
					}
					?>
				</div>
				<div class="col-md-12">
					<hr>
					<h4>Datos de candidato</h4>
				</div>
				<div class="col-md-12">
					<div class="col-md-6">
						<div class="contentData">
							<label>Nombres</label>
							<h5><?php echo $datosUsuario['nombres'] ?></h5>
						</div>
					</div>
					<div class="col-md-6">
						<div class="contentData">
							<label>Apellidos</label>
							<h5><?php echo $datosUsuario['apellidos'] ?></h5>
						</div>
					</div>

					<div class="col-md-6">
						<div class="contentData">
							<label>Nacionalidad</label>
							<h5><?php echo $datosUsuario['nacionalidad'] ?></h5>
						</div>
					</div>

					
					<div class="col-md-6">
						<div class="contentData">
							<label>Edad</label>
							<h5><?php echo $datosUsuario['edad'] ?></h5>
						</div>
					</div>

					<div class="col-md-6">
						<div class="contentData">
							<label>Disp. Viajar</label>
							<h5><?php echo $datosUsuario['viajar'] ?></h5>
						</div>
					</div>

					<div class="col-md-6">
						<div class="contentData">
							<label>Cambio de residencia</label>
							<h5><?php echo $datosUsuario['residencia'] ?></h5>
						</div>
					</div>

					<div class="col-md-6">
						<div class="contentData">
							<label>Discapacidad</label>
							<h5><?php echo $datosUsuario['discapacidad'] ?></h5>
						</div>
					</div>

					

					<div class="col-md-6">
						<div class="contentData">
							<label>Género</label>
							<h5><?php echo $datosUsuario['genero'] ?></h5>
						</div>
					</div>

					<div class="col-md-6">
						<div class="contentData">
							<label>Escolaridad</label>
							<h5><?php echo $datosUsuario['escolaridad'] ?></h5>
						</div>
					</div>

					<div class="col-md-6">
						<div class="contentData">
							<label>Situación laboral</label>
							<h5><?php echo $datosUsuario['situacionLaboral'] ?></h5>
						</div>
					</div>

					<div class="col-md-6">
						<div class="contentData">
							<label>Licencia</label>
							<h5><?php echo $datosUsuario['licencia'] ?></h5>
						</div>
					</div>

					<div class="col-md-6">
						<div class="contentData">
							<label>Universidad</label>
							<h5><?php echo $datosUsuario['universidad'] ?></h5>
						</div>
					</div>
					<div class="col-md-6">
						<div class="contentData">
							<label>Estado civil</label>
							<h5><?php echo $datosUsuario['estadocivil'] ?></h5>
						</div>
					</div>

					<div class="col-md-12">
						<hr>
						<h4>Datos de residencia</h4>
					</div>

					<div class="col-md-4">
						<div class="contentData">
							<label>Ciudad</label>
							<h5><?php echo $datosUsuario['ciudad'] ?></h5>
						</div>
					</div>
					<div class="col-md-4">
						<div class="contentData">
							<label>Pais</label>
							<h5><?php echo $datosUsuario['pais'] ?></h5>
						</div>
					</div>
					<div class="col-md-4">
						<div class="contentData">
							<label>Provincia</label>
							<h5><?php echo $datosUsuario['provincia'] ?></h5>
						</div>
					</div>

					
					<div class="col-md-12">
						<hr>
						<h4>Datos de contacto</h4>
					</div>

					<div class="col-md-6">
						<div class="contentData<?php echo $datosUsuario['classHidden'] ?>">
							<label>Correo</label>
							<h5><?php echo $datosUsuario['correo'] ?></h5>
						</div>
					</div>

					<div class="col-md-6">
						<div class="contentData<?php echo $datosUsuario['classHidden'] ?>">
							<label>Teléfono</label>
							<h5><?php echo $datosUsuario['telefono'] ?></h5>
						</div>
					</div>
					<div class="col-md-6">
						<div class="contentData<?php echo $datosUsuario['classHidden'] ?>">
							<label>DNI</label>
							<h5><?php echo $datosUsuario['dni'] ?></h5>
						</div>
					</div>
					<div class="col-md-6">
						<div class="contentData<?php echo $datosUsuario['classHidden'] ?>">
							<label>Teléfono convencional</label>
							<h5><?php echo $datosUsuario['telefonoConvencional'] ?></h5>
						</div>
					</div>

					<?php 
						if(isset($datosUsuario['mostrarBoton'])){
							echo $datosUsuario['mostrarBoton'];
						}
					?>

					<div class="col-md-12">
						<hr>
						<h4>Idiomas</h4>
						<h5>Idioma - Nivel</h5>
								<?php 
									foreach ($datosUsuario['usuarioxnivelidioma'] as $key=>$value) {
										echo "<div class='col-md-6 col-md-offset-3'>";
											echo "<div class='contentData'>";
												echo "<h5>".$key." - ".$value[2]."</h5>";
											echo "</div>";
										echo "</div>";
									}
								?>
					</div>

					<div class="col-md-12">
						<hr>
						<h4>áreas de interés</h4>
						<?php
						// print_r($vista);
							foreach ($datosUsuario['usuarioxarea'] as $key => $value) {
								echo "<div class='col-md-6 col-md-offset-3'>";
											echo "<div class='contentData'>";
												$actual = $value;
												$name = "";
												foreach ($actual as $key2 => $value2) {
													if($name != $value2['area']){
														$name = $value2['area'];
														echo "<label>Área: ".$value2['area']."</label><br>";
													}
												}
												echo "<label>Subáreas</label>";
												foreach ($actual as $key1 => $value1) {
													echo "<li>".$value1['subarea']."</li>";
												}
									echo "</div>";
								echo "</div>";
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
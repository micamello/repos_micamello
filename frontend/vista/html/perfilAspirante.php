<div class="text-center">
    <h2 class="titulo">Perfil del Candidato</h2>
  </div>
<div class="container-fluid">
	<div class="container">
		<br><br><br><br><br><br>
	<div class="">
		<div class="col-md-10 col-md-offset-1" id="contenido_imprimir">
		<div class="panel panel-default shadow">
			<div class="panel-body">
				<div class="fotoPerfil">
					<div class="text-center">
						<div class="col-md-6">
							<img class="perfil_photo_user" src="<?php echo PUERTO.'://'.HOST.'/imagenes/imgperfil/'.$datosUsuario['username'].'/';?>">
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<!-- <?php echo $vista; ?> -->
					
				</div>


				<div class="col-md-6">
		        	<div class="col-md-12">
			            <div class="nombreUsuario">
			            	<h3 class=""><?php echo utf8_encode($datosUsuario['nombres'])." ".utf8_encode($datosUsuario['apellidos']) ?></h3>
			            </div>
		            	<?php if(isset($datosUsuario['aspSalarial'])){
							echo "<h5><b>Aspiración salarial: </b>". SUCURSAL_MONEDA.$datosUsuario['aspSalarial']."</h5>";
						}
						?>
		        	</div>
			        <div class="col-md-12">
			        	<br>
			        	<a target="_blanked" href="<?php echo PUERTO.'://'.HOST.'/hvUsuario/'.Utils::encriptar($datosUsuario['username']).'/'.$id_oferta.'/'.$vista.'/' ?>" class="btn-blue">Descargar datos</a> 
			        </div>
		      	</div>
				<div class="col-md-12">
					<hr>
					<h4 class="qs-subt">Datos de candidato</h4>
				</div>
				<div class="col-md-12">
					<div align="left">
						<div class="col-md-6">
						<div class="contentData">
							<h5><b>Nombres: </b><?php echo utf8_encode($datosUsuario['nombres']) ?></h5>
						</div>
					</div>
					<div class="col-md-6">
						<div class="contentData">
							<h5><b>Apellidos: </b><?php echo utf8_encode($datosUsuario['apellidos']) ?></h5>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="contentData">
							<h5><b>Edad: </b><?php echo $datosUsuario['edad'] ?></h5>
						</div>
					</div>

					<div class="col-md-6">
						<div class="contentData">
							<h5><b>Disponibilidad para Viajar: </b><?php echo $datosUsuario['viajar'] ?></h5>
						</div>
					</div>

					<div class="col-md-6">
						<div class="contentData">
							<h5><b>Cambio de residencia: </b><?php echo $datosUsuario['residencia'] ?></h5>
						</div>
					</div>

					<div class="col-md-6">
						<div class="contentData">
							<h5><b>Discapacidad: </b><?php echo $datosUsuario['discapacidad'] ?></h5>
						</div>
					</div>

					

					<div class="col-md-6">
						<div class="contentData">
							<h5><b>Género: </b><?php echo $datosUsuario['genero'] ?></h5>
						</div>
					</div>

					<div class="col-md-6">
						<div class="contentData">
							<h5><b>Último estudio realizado: </b><?php echo utf8_encode($datosUsuario['escolaridad']) ?></h5>
						</div>
					</div>

					<div class="col-md-6">
						<div class="contentData">
							<h5><b>Situación laboral: </b><?php echo utf8_encode($datosUsuario['situacionLaboral']) ?></h5>
						</div>
					</div>

					<div class="col-md-6">
						<div class="contentData">
							<h5><b>Tipo de licencia: </b><?php echo $datosUsuario['licencia'] ?></h5>
						</div>
					</div>

					<div class="col-md-6">
						<div class="contentData">
							<h5><b>Estudios en el extranjero: </b><?php echo $datosUsuario['extranjero'] ?></h5>
						</div>
					</div>

					<div class="col-md-6">
						<div class="contentData">
							<h5><b>Universidad: </b><?php echo utf8_encode($datosUsuario['universidad']) ?></h5>
						</div>
					</div>
					<div class="col-md-6">
						<div class="contentData">
							<h5><b>Estado civil: </b><?php echo $datosUsuario['estadocivil'] ?></h5>
						</div>
					</div>
				</div>
					<div class="col-md-12">
						<hr>
						<h4 class="qs-subt">Datos de residencia</h4>
					</div>
					<div align="left">
						<div class="col-md-4">
							<div class="contentData">
								<h5><b>Ciudad de residencia: </b><?php echo utf8_encode($datosUsuario['ciudad']) ?></h5>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="contentData">
								<h5><b>Nacionalidad: </b><?php echo utf8_encode($datosUsuario['nacionalidad']) ?></h5>
							</div>
						</div>
						<div class="col-md-4">
							<div class="contentData">
								<h5><b>Provincia de residencia: </b><?php echo utf8_encode($datosUsuario['provincia']) ?></h5>
							</div>
						</div>
					</div>
					
					<div class="col-md-12">
						<hr>
						<h4 class="qs-subt">Datos de contacto</h4>
					</div>
					<div align="left">
					<div class="col-md-6">
						<div class="contentData<?php echo $datosUsuario['classHidden'] ?>">
							<h5><b>Correo: </b><?php echo $datosUsuario['correo'] ?></h5>
						</div>
					</div>

					<div class="col-md-6">
						<div class="contentData<?php echo $datosUsuario['classHidden'] ?>">
							<h5><b>Celular: </b><?php echo $datosUsuario['telefono'] ?></h5>
						</div>
					</div>
					<div class="col-md-6">
						<div class="contentData<?php echo $datosUsuario['classHidden'] ?>">
							<?php
							$documento = ""; if($datosUsuario['tipo_doc'] == 1) $documento = 'Ruc';
								if($datosUsuario['tipo_doc'] == 2) $documento = 'C&eacute;dula';
								if($datosUsuario['tipo_doc'] == 3) $documento = 'Pasaporte';
										?>
							<h5><b><?php echo $documento; ?>: </b><?php echo $datosUsuario['dni'] ?></h5>
						</div>
					</div>
					<div class="col-md-6">
						<div class="contentData<?php echo $datosUsuario['classHidden'] ?>">
							<h5><b>Teléfono: </b><?php echo $datosUsuario['telefonoConvencional'] ?></h5>
						</div>
					</div>
				</div>

					<?php 
						if(isset($datosUsuario['mostrarBoton'])){
							echo $datosUsuario['mostrarBoton'];
						}
					?>

					<div class="col-md-12">
						<hr>
						<h4 class="qs-subt">Idiomas</h4>

						<div class="col-md-6 col-md-offset-3">
		                  <div class="contentData">
		                    <h5><b>Idioma - Nivel</b></h5>
		                    <?php 
								foreach ($datosUsuario['usuarioxnivelidioma'] as $key=>$value) {
									echo "<h5>".$key." - ".$value[2]."</h5>";
								}
							?>
		                  </div>
		                </div>
								

					<div class="col-md-12">
						<hr>
						<!-- <h4>áreas de interés</h4> -->
						<h4 class="qs-subt">áreas de interés</h4>

						<div align="center" class="col-md-6 col-md-offset-3 table-responsive">
						  <table class="table">
						    <thead>
						      <tr>
						        <th scope="col">Área</th>
						        <th scope="col">Subáreas</th>
						      </tr>
						    </thead>
						    <tbody>

						      	<?php
									foreach ($datosUsuario['usuarioxarea'] as $key => $value) {
										echo "<tr>";
										$actual = $value;
										$name = "";
										foreach ($actual as $key2 => $value2) {
											if($name != $value2['area']){
												$name = $value2['area'];
												echo "<th scope='row'>".utf8_encode($value2['area'])."</th>";
											}
										}
											echo "<td>";
												foreach ($actual as $key1 => $value1) {
													echo "<li>".utf8_encode($value1['subarea'])."</li>";
												}
											echo "</td>";
										echo "</tr>";
									}
								?>
						    </tbody>
						  </table>
						</div>




						<!-- <?php
							foreach ($datosUsuario['usuarioxarea'] as $key => $value) {
								$actual = $value;
								$name = "";
								foreach ($actual as $key2 => $value2) {
									if($name != $value2['area']){
										$name = $value2['area'];
										echo "<label>Área: ".utf8_encode($value2['area'])."</label><br>";
									}
								}
								echo "<label>Subáreas</label>";
								foreach ($actual as $key1 => $value1) {
									echo "<li>".utf8_encode($value1['subarea'])."</li>";
								}
							}
						?> -->
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</div>
</div>
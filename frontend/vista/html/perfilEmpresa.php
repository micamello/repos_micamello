<div class="text-center">
	<h2 class="titulo">Perfil de <?php echo strtoupper(utf8_encode($datosEmpresa['nombres'])); ?></h2>
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
									<img style="height:200px; width: 200px;" class="perfil_photo_user" src="<?php echo PUERTO.'://'.HOST.'/imagenes/imgperfil/'.$datosEmpresa['username'].'/';?>">
								</div>
							</div>
						</div>

						<div class="col-md-6">
				        	<div class="col-md-12">
					            <div class="nombreUsuario">
					            	<h3 class=""><?php echo strtoupper(utf8_encode($datosEmpresa['nombres'])); ?></h3>
					            </div>
				        	</div>
				        	<div class="col-md-12">
					            <div class="nombreUsuario">
					            	<h4 class="no">RUC: <?php echo utf8_encode($datosEmpresa['dni']); ?></h4>
					            </div>
				        	</div>
				      	</div>
						<div class="col-md-12">
							<hr>
							<h4 style="padding-top: 0px;" class="qs-subt">Datos de la empresa</h4>
						</div>
						<div class="col-md-12">
							<div align="left">
								<div class="col-md-6">
									<div class="contentData">
										<h5><b>Nombres: </b><?php echo utf8_encode($datosEmpresa['nombres']) ?></h5>
									</div>
								</div>

								<div class="col-md-6">
									<div class="contentData">
										<h5><b>Sector Industrial: </b><?php echo $datosEmpresa['sectorindustrial']; ?></h5>
									</div>
								</div>

								<div class="col-md-6">
									<div class="contentData">
										<h5><b>Correo: </b><?php echo $datosEmpresa['correo']; ?></h5>
									</div>
								</div>

								<div class="col-md-6">
									<div class="contentData">
										<h5><b>Tel&eacute;fono: </b><?php echo $datosEmpresa['telefono']; ?></h5>
									</div>
								</div>
							</div>
							
							<div class="col-md-12">
								<hr>
								<h4 style="padding-top: 0px;" class="qs-subt">Datos de contacto</h4>
							</div>
							<div align="left">
								<div class="col-md-6">
									<div class="contentData">
										<h5><b>Nombres de contacto: </b><?php echo $datosEmpresa['nombres_contacto']; ?></h5>
									</div>
								</div>

								<div class="col-md-6">
									<div class="contentData">
										<h5><b>Apellidos de contacto: </b><?php echo $datosEmpresa['apellidos_contacto']; ?></h5>
									</div>
								</div>

								<div class="col-md-6">
									<div class="contentData">
										<h5><b>Celular: </b><?php echo $datosEmpresa['telefono1']; ?></h5>
									</div>
								</div>

								<div class="col-md-6">
									<div class="contentData">
										<h5><b>Convencional: </b><?php echo $datosEmpresa['telefono2']; ?></h5>
									</div>
								</div>
							</div>

							<div class="col-md-12">
								<hr>
								<h3 style="padding-top: 0px;font-family: ‘Antipasto’; color: #204478;">Si existe alg&uacute;n dato incorrecto puede escribirnos a <a target="_blank" class="legal_info_content" href="<?php echo PUERTO."://".HOST;?>/recomendacion/">info@micamello.com.ec</a></h3>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
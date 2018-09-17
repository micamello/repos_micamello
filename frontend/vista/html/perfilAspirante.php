<div class="container">
	<?php if (!empty($datos_Usuario)) {?>
		<br><br><br><br><br><br>
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default shadow">
			<div class="panel-body">
				<div class="row">
					<div class="text-center">
						<div class="col-md-12">
							<img class="perfil_photo_user" src="<?php echo Modelo_Usuario::obtieneFoto($datos_Usuario['id_usuario']) ?>">
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="col-md-2">
			
		</div>
	</div>
<?php } ?>
</div>
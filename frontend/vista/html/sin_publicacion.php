<br>
<div class="container">
	<div class="panel panel-default shadow col-md-10 col-md-offset-1">
		<div class="panel-body">
			<h5 class="text-center">Estimado(a) <?php echo $_SESSION['mfo_datos']['usuario']['nombres'] ?></h5>
			<br>
			<div class="alert alert-danger col-md-8 col-md-offset-2" role="alert">
					<?php 
						if (!empty($publicaciones_restantes)) {
							?>
							<br>
							<h5 class="text-center big_number bg_red"><?php echo $publicaciones_restantes['p_restantes'] ?></h5><br>
							Publicaciones restantes
							<?php
						}
					 ?>
					<p class="text_in_alert_danger">
						Actualmente no dispone de publicaciones.<br>
						Si desea seguir publicando vacantes proceda con la contratación o renovación del Plan.
					</p>
					<br>
					<p>
						Haz click en el enlace de abajo y conoce nuestros planes!
					</p>
					<br>
					<a href="<?php echo PUERTO."://".HOST;?>/planes/" class="btn btn-info">Planes MiCamello</a>
					
			</div>
		</div>
	</div>
</div>
<br>
<div class="container">
	<div class="panel panel-default shadow col-md-10 col-md-offset-1">
		<div class="panel-body">
			<h5 class="text-center">
				Estimado <?php echo utf8_encode($_SESSION['mfo_datos']['usuario']['nombres'])."&nbsp;".((isset($_SESSION['mfo_datos']['usuario']['apellidos'])) ? utf8_encode($_SESSION['mfo_datos']['usuario']['apellidos']) : '');?>					
			</h5>
			<br>
			<div class="alert alert-success col-md-8 col-md-offset-2" role="alert">				  					
				<p><i class="fa fa-check-circle fa-5x" aria-hidden="true"></i></p>
				<p class="text_in_alert_danger">
					El cambio de contrase&ntilde;a se ha realizado con &eacute;xito! <br><br> Por motivos de seguridad cerraremos la sesi&oacute;n, por favor vuelva a ingresar utilizando la nueva contrase&ntilde;a.
				</p>        
			</div>
			<a class="btn btn-success" href="<?php echo PUERTO."://".HOST."/login/";?>">Finalizar</a>
		</div>
	</div>
</div>
<br><br>
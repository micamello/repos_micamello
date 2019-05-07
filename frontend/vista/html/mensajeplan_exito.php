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
					Dentro de un momento su plan ser&aacute; activado<br>
					Por favor revise su correo para verificar su subscripci&oacute;n<br><br>
				<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO && isset($msg_cuestionario) && $msg_cuestionario == 1) { ?>
					Cuando su plan este activo, podr&aacute; realizar el tercer <a href="<?php echo PUERTO."://".HOST."/preguntas/"; ?>">formulario</a>
				<?php } ?>	
				</p>        
			</div>
			<div class="col-md-12">
				<?php if(isset($ofertaConvertir)){ ?>
					<a href="<?php echo PUERTO."://".HOST."/verAspirantes/1/".$ofertaConvertir."/1/"; ?>" id="btn_convertir" class="btn btn-md btn-warning">CONVERTIR OFERTA AHORA</a>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<br><br>
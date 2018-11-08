<br>
<div class="container">
	<div class="panel panel-default shadow col-md-10 col-md-offset-1">
		<div class="panel-body">
			<h5 class="text-center">
				Estimado <?php echo $_SESSION['mfo_datos']['usuario']['nombres']."&nbsp;".((isset($_SESSION['mfo_datos']['usuario']['apellidos'])) ? $_SESSION['mfo_datos']['usuario']['apellidos'] : '');?>					
			</h5>
			<br>
			<div class="alert alert-danger col-md-8 col-md-offset-2" role="alert">				  					
				<p><i class="fa fa-times-circle fa-5x" aria-hidden="true"></i></p>
				<p class="text_in_alert_danger">
					Ha ocurrido un error al comprar el plan<br>
					Por favor intente nuevamente la compra o contactese con el administrador
				</p>        
			</div>
		</div>
	</div>
</div>
<br><br>
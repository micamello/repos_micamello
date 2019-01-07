<?php 

$presentarBtn = true;
foreach ($presentarBtnCompra as $key => $value) {

	if($value['fecha_caducidad'] != '' && $value['fecha_caducidad'] >= date('Y-m-d H:i:s') && ($value['num_rest'] == -1 || $value['num_rest'] > 0)){
		$presentarBtn = false;
		break;
	}
}

if($presentarBtn){ ?>
	<div class="parpadea pull-right" >
		<h6 style="color:#6d6d6b"><strong>Desea adquirir un plan con mayores beneficios?</strong><a href="<?php echo PUERTO."://".HOST."/planes/";?>" id="btn_compra" class="btn btn-md btn-warning">Adquierelo YA!</a></h6>
		<br>
		<br>
	</div>
<?php } ?>
<?php 
$presentarBtn = true;
if (!empty($presentarBtnCompra)){

	foreach ($presentarBtnCompra as $key => $value) {

		if($value['fecha_caducidad'] != '' && $value['fecha_caducidad'] >= date('Y-m-d H:i:s') && ($value['num_rest'] == -1 || $value['num_rest'] > 0)){
			$presentarBtn = false;
			break;
		}
	}
}

if ($presentarBtn){
?>
	<div class="col-md-offset-4 col-md-8">
	  <div class="col-md-8">
	    <p style="text-align: right;" class="qs-text">Desea adquirir un plan con mayores beneficios?</p>
	  </div>
	  <div class="col-md-4">
	    <a href="<?php echo PUERTO."://".HOST."/planes/";?>" id="btn_compra" class="btn-blue">Adquierelo YA!</a>
	  </div>
	</div>
	<br><br>
<?php } ?>



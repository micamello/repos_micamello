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

	<div class="ofertas-cambio col-md-offset-3 col-md-8 col-sm-8">
	    <div class="col-md-6 col-md-6 col-xs-6">
	      <p style="text-align: right;" class="qs-text">&iquest;Desea adquirir un plan con mayores beneficios&quest;</p>
	    </div>
	    <div class="col-md-6 col-sm-6 col-xs-6 btn-naranja pulse animated infinite">
	      <a href="<?php echo PUERTO."://".HOST."/planes/";?>" id="btn_compra" class="">Adquierelo YA!</a>
	    </div>
	</div>
	<br><br>
<?php } ?>



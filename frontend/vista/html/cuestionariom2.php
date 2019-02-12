<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/minisitio.css">
  <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
</head>
<body class="window_class">
<?php if(!isset($show_banner) && !isset($breadcrumbs)){ ?>
  <?php } ?>
    <!--mensajes de error y exito-->
    <?php if (isset($sess_err_msg) && !empty($sess_err_msg)){?>
      <div align="center" id="alerta" style="display:" class="alert alert-danger" role="alert">
        <strong><?php echo $sess_err_msg;?></strong>
      </div>  
    <?php }?>

    <?php if (isset($sess_suc_msg) && !empty($sess_suc_msg)){?>
      <div align="center" id="alerta" style="display:" class="alert alert-success" role="alert">
        <strong><?php echo $sess_suc_msg;?></strong>
      </div>  
    <?php } ?>
<br>
<!-- <br><br> -->

	<div class="container">
		<div class="card">
      <form action="<?php echo PUERTO."://".HOST;?>/registroresp/" method="POST" id="respuestas_form">
      <input type="hidden" name="pregunta" value="<?php echo $pregunta; ?>">
      <input type="hidden" name="tiempo" id="tiempo" value="<?php echo $tiempo; ?>">
      <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id_usuario']; ?>">
      <input type="hidden" name="pre" id="pre" value="<?php echo $pre;?>">
      <div class="card-header text-center">
        <h5 class="card-title"><b><?php echo "Pregunta N° ".$pregunta; ?></b></h5>
      </div>
      <div id="error_msg"></div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<h6 class="title_side">Opciones: </h6>
						<table class="table">
							<tbody>
								<?php 
									foreach ($opciones as $opcion) {
										?>
											<tr>
												<td style="padding: 36px;">
													<div>
									                    <div class="caja_origen">
									                      <ul class="list-group1">
									                        <input type="hidden" name="opcion" id="<?php echo 'opcion_'.$opcion['id_opcion'];?>" value="<?php echo $opcion['valor']; ?>">
									                        <li class=""><?php echo ($opcion['descripcion']) ?></li>
									                      </ul>
									                    </div>
													</div>
												</td>
											</tr>
										<?php
									}
								 ?>
							</tbody>
						</table>
					</div>
					<div class="col-md-6">
						<h6 class="title_side">Prioridad: </h6>
						<table class="table">
							<tbody>
								<?php 
								$i = 1;
									foreach ($opciones as $opcion) {
										?>
										<tr>
											<td style="padding: 36px;">
                        						<span class="order_priority"><b><?php echo $i; ?></b></span>
												<div class="caja_destino" id="caja_destino">
                          							<input type="hidden" name="orden" value="<?php echo $i; ?>">
													<p class="texto_destino">Arrastre aqui</p>
												</div>
											</td>
										</tr>
										<?php
										$i++;
									}
								 ?>
							</tbody>
						</table>
					</div>
			          <div class="contenedor_resp" id="contenedor_resp" style="display: none;">
			            
			          </div>
				</div>
			</div>
	      	<div class="card-footer text-center">
	          <div class="center">
	            <input type="submit" name="" class="btn btn-success" value="guardar">
	          </div>
	        </div>
    		</form>
		</div>
	</div>

<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/jquery-3.0.0.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/minisitio.js"></script>
</html>
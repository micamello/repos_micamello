<!DOCTYPE html>
<html>
<head>
	<title>TEST</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/minisitio.css">
</head>
<body>
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

<form action="<?php echo PUERTO."://".HOST;?>/registroresp/" method="POST" id="forma_2">
	<div class="container">
		<div class="col-md-12">
			<br><br>
			<div id="error_msg"></div>
			<br><br>
			<div class="card">
				<div class="card-body">
					<h5><?php echo "Pregunta N° ".$pregunta; ?></h5>			
				</div>
				<input type="hidden" name="pregunta" value="<?php echo $pregunta; ?>">
			      <input type="hidden" name="tiempo" id="tiempo" value="<?php echo $tiempo; ?>">
			      <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id_usuario']; ?>">
			      <input type="hidden" name="pre" id="pre" value="<?php echo $pre;?>">
				<div class="card-footer text-center">
					<?php
					foreach ($opciones as $opc) {
					?>
					<div class="respuesta">
						<div class="row">
							<div class="col-md-11">
								<label><?php echo $opc['descripcion']; ?></label>
								<input type="hidden" name="opcion[]" value="<?php  echo $opc['id_opcion'];?>">
							</div>
							<div class="col-md-1">
								<div class="form-group">
									<input type="text" name="orden[]" class="form-control">
									<div></div>
								</div>
							</div>
						</div>
					</div>
					<hr>
					<?php
					}
					?>
					<!-- <hr> -->
					<div id="contenedor_resp" style="display: none;"></div>
					<input type="submit" name="" class="btn btn-success" value="guardar">
				</div>
			</div>
		</div>
	</div>
</form>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header text-center">
	        <h5 class="modal-title">Indicaciones</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body text-center">
	        <p id="texto_modal" style="font-size: 20px;"></p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary text-center" data-dismiss="modal">Cerrar</button>
	      </div>
	    </div>
	  </div>
	</div>
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/jquery-3.0.0.js"></script>
<!-- <script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/bootstrap.js"></script> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/minisitio.js"></script>
</body>
</html>
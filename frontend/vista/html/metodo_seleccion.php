<!DOCTYPE html>
<html>
<head>
	<title>Selección de método</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/minisitio.css">
</head>
<body>

<form id="form_seleccion" action="<?php echo PUERTO."://".HOST;?>/test_reg_var/" method="post">
	<div class="container">
		<div class="col-md-12">
			<br><br>
			<div id="error_msg"></div>
			<br><br><br>
			<div class="card">
				<div class="card-body">
					<div class="text-center">
						<h5>Seleccione un m&eacute;todo para responder el test</h5>
					</div><br><br>
					<div>
						<div class="row">
						<?php 
						foreach (METODO_SELECCION as $key => $value) {
							?>
								<div class="col-md-6 text-center">
									<div class="form-group">
										<label class="form-check-label">
										  <input type="radio" class="form-check-input" name="seleccion" value="<?php echo $key; ?>">
										  	<?php echo $value; ?>
										</label>
									</div>
									<br>
									<div class="text-center">
										<img class="eder" src="http://nathannagele.com/wp-content/uploads/2018/03/GoogleFormsQuiz_00.gif" style="width: 50%;" id="<?php echo "gif_".$key; ?>">
									</div>
								</div>
							<?php 
						}

						 ?>
						</div>
					</div>
				</div>
				<div class="card-footer text-center">
					<input type="submit" name="" value="Seleccionar" class="btn btn-success">
				</div>
			</div>
		</div>
	</div>
</form>


<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/jquery-3.0.0.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/minisitio.js"></script>
</body>
</html>
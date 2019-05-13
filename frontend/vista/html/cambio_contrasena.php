<div class="container">
  <div class="text-center">
    <h2 class="titulo">Cambio de Contrase&ntilde;a</h2>
  </div>
</div>

<section id="product" class="inicio">
	<div class="container">
	    <div class="row" id="registro-algo-centro">  
	     	<div class="col-md-6 col-md-offset-3">
	        	<div class="" id="inicio-cuadro"> 
	          		<form action = "<?php echo PUERTO."://".HOST;?>/cambioClave/" method = "post" id="form_cambiar" name="form_cambiar">
			            <div class="col-md-12" align="center">
			              	<div id="seccion_usuario" class="form-group">
			                  	<label class="text-center"> <i class="fa fa-user"></i>Usuario</label><div id="err_usuario" class="help-block with-errors"></div>
			                  	<h3 class="usuario">
		                	   		<u><?php echo $_SESSION['mfo_datos']['usuario']['username']; ?></u>
		                	  	</h3>
			                </div>
			           	</div>

			           	<div class="col-md-12">
				            <div id="seccion_clave_ant" class="form-group">
			                  <label class="text-center">Contrase&ntilde;a anterior<i>*</i></label><div id="err_clave_ant" class="help-block with-errors"></div>
			                  <div class="input-group">
			                    <span class="input-group-addon show_hidden" onclick="pass_reveal(this);"><i class="fa fa-eye"></i></span>
			                    <input id="password_ant" name="password_ant" type="password" pattern="^(?=(?:.*\d))(?=(?:.*[a-zA-Z]))\S{8,}$" class="form-control" value="<?php if(isset($data['password_ant'])){ echo $data['password_ant']; } ?>" onkeyup="validarClave()">
			                  </div>
			                </div>
			          	</div>

				        <div class="col-md-12">
				            <div id="seccion_clave" class="form-group">
			                  <label class="text-center">Contrase&ntilde;a <i>*</i></label><div id="err_clave" class="help-block with-errors"></div>
			                  <div class="input-group">
			                    <span class="input-group-addon show_hidden" onclick="pass_reveal(this);"><i class="fa fa-eye"></i></span>
			                    <input title="Letras y números, mínimo 8 caracteres" id="password" name="password" type="password" pattern="^(?=(?:.*\d))(?=(?:.*[a-zA-Z]))\S{8,}$" value="<?php if(isset($data['password'])){ echo $data['password']; } ?>" onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); if(this.checkValidity()) form.password_two.pattern = this.value;" class="form-control" onkeyup="validarClave()" >
			                  </div>
			                </div>
				        </div>

			          	<div class="col-md-12">
				            <div id="seccion_clave1" class="form-group">
				                <label class="text-center">Confirmar Contrase&ntilde;a <i>*</i></label><div id="err_clave1" class="help-block with-errors"></div>
				                <div class="input-group">
				                    <span class="input-group-addon show_hidden" onclick="pass_reveal(this);"><i class="fa fa-eye"></i></span>
				                    <input id="password_two" name="password_two" type="password" pattern="^(?=(?:.*\d))(?=(?:.*[a-zA-Z]))\S{8,}$" value="<?php if(isset($data['password_two'])){ echo $data['password_two']; } ?>" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Ingrese la misma contraseña' : '');" placeholder="Verificar contraseña" class="form-control" onkeyup="validarClave()" >
				                </div>
				            </div>
			          	</div>

			          	<div class="row">          
				            <div class="col-sm-12 col-md-12 col-xs-12">
					            <div class="text-center" style="margin-top: 20px;">
					                <input type="button" id="button_cambiar" name="btnusu" class="btn-blue" style="font-size: 15px;padding: 10px 20px;" value="Guardar Cambios"> 
					            </div>
				            </div>
			          	</div>
			          	<input type="hidden" name="cambiarClave_obligatorio" id="cambiarClave_obligatorio" value="1">
	        		</form>
	      		</div>
	    	</div>
	  	</div>
	</div>
</section>	

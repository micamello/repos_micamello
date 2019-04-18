<div class="container">
	<div class="col-md-offset-2 col-md-8">
		<b>
			<span style="font-size: 18px;"><?php echo $breadcrumbs['cambioClave']; ?></span>
		</b>
		<br/><br/>
    	<div class="panel panel-default shadow-panel1">
			<div class="panel-heading">
			    <span><i class="fa fa-key"></i> Cambiar contrase&ntilde;a</span>
			</div>
			<form action = "<?php echo PUERTO."://".HOST;?>/cambioClave/" method = "post" id="form_cambiar" name="form_cambiar">
				<div class="panel-body">
					<div class="col-md-12">
		                <div id="seccion_usuario" class="form-group">
		                  <label class="text-center"> <i class="fa fa-user"></i>Usuario</label><div id="err_usuario" class="help-block with-errors"></div>
		                  <h3 class="usuario">
	                	   <u><?php echo $_SESSION['mfo_datos']['usuario']['username']; ?></u>
	                	  </h3>
		                </div>
		            </div>
		            <div class="col-md-12">
		                <div id="seccion_clave_ant" class="form-group">
		                  <label class="text-center">Contrase&ntilde;a anterior<i class="requerido">*</i></label><div id="err_clave_ant" class="help-block with-errors"></div>
		                  <div class="input-group">
		                    <span class="input-group-addon show_hidden" onclick="pass_reveal(this);"><i class="fa fa-eye"></i></span>
		                    <input id="password_ant" name="password_ant" type="password" pattern="^(?=(?:.*\d))(?=(?:.*[a-zA-Z]))\S{8,}$" class="form-control" value="<?php if(isset($data['password_ant'])){ echo $data['password_ant']; } ?>" onkeyup="validarClave()">
		                  </div>
		                </div>
		            </div>
		        	<div class="col-md-12">
		                <div id="seccion_clave" class="form-group">
		                  <label class="text-center">Contrase&ntilde;a <i class="requerido">*</i></label><div id="err_clave" class="help-block with-errors"></div>
		                  <div class="input-group">
		                    <span class="input-group-addon show_hidden" onclick="pass_reveal(this);"><i class="fa fa-eye"></i></span>
		                    <input title="Letras y números, mínimo 8 caracteres" id="password" name="password" type="password" pattern="^(?=(?:.*\d))(?=(?:.*[a-zA-Z]))\S{8,}$" value="<?php if(isset($data['password'])){ echo $data['password']; } ?>" onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); if(this.checkValidity()) form.password_two.pattern = this.value;" class="form-control" onkeyup="validarClave()" >
		                  </div>
		                </div>
		            </div>
			        <div class="col-md-12">
			            <div id="seccion_clave1" class="form-group">
			                <label class="text-center">Confirmar Contrase&ntilde;a <i class="requerido">*</i></label><div id="err_clave1" class="help-block with-errors"></div>
			                <div class="input-group">
			                    <span class="input-group-addon show_hidden" onclick="pass_reveal(this);"><i class="fa fa-eye"></i></span>
			                    <input id="password_two" name="password_two" type="password" pattern="^(?=(?:.*\d))(?=(?:.*[a-zA-Z]))\S{8,}$" value="<?php if(isset($data['password_two'])){ echo $data['password_two']; } ?>" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Ingrese la misma contraseña' : '');" placeholder="Verificar contraseña" class="form-control" onkeyup="validarClave()" >
			                </div>
			            </div>
			        </div> 
			        <div class="col-md-12">
			        	<input type="button" id="button_cambiar" name="btnusu" class="btn btn-success" value="Guardar Cambios"> 
			        	<span class="help-block">En este formulario los campos con (<i class="requerido">*</i>) son obligatorios</span>
			        	
			        </div>
				</div>
				<input type="hidden" name="cambiarClave_obligatorio" id="cambiarClave_obligatorio" value="1">
			</form>
		</div>
	</div>
</div>

<div class="container">
	<div class="col-md-offset-2 col-md-8">
		<b>
			<span style="font-size: 18px;"><?php echo $breadcrumbs[$vista]; ?></span>
		</b>
		<br/><br/>
    	<div class="panel panel-default shadow-panel1">
			<div class="panel-heading">
			    <span><i class="fa fa-key"></i> Cambiar contrase&ntilde;a</span>
			</div>
			<div class="panel-body">
				<div class="col-md-12">
	                <div id="seccion_usuario" class="form-group">
	                  <label class="text-center">Usuario</label><div id="err_usuario" class="help-block with-errors"></div>
	                  <div class="input-group">
	                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
	                    <input id="username" name="username" type="text" class="form-control" >
	                  </div>
	                </div>
	            </div>
	        	<div class="col-md-12">
	                <div id="seccion_clave" class="form-group">
	                  <label class="text-center">Contrase&ntilde;a <i class="requerido">*</i></label><div id="err_clave" class="help-block with-errors"></div>
	                  <div class="input-group">
	                    <span class="input-group-addon show_hidden" onclick="pass_reveal(this);"><i class="fa fa-eye"></i></span>
	                    <input title="Letras y números, mínimo 8 caracteres" id="password" name="password" type="password" pattern="^(?=(?:.*\d))(?=(?:.*[a-zA-Z]))\S{8,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); if(this.checkValidity()) form.password_two.pattern = this.value;" class="form-control" onkeyup="validarClave()" >
	                  </div>
	                </div>
	            </div>
		        <div class="col-md-12">
		            <div id="seccion_clave1" class="form-group">
		                <label class="text-center">Confirmar Contrase&ntilde;a <i class="requerido">*</i></label><div id="err_clave1" class="help-block with-errors"></div>
		                <div class="input-group">
		                    <span class="input-group-addon show_hidden" onclick="pass_reveal(this);"><i class="fa fa-eye"></i></span>
		                    <input id="password_two" name="password_two" type="password" pattern="^(?=(?:.*\d))(?=(?:.*[a-zA-Z]))\S{8,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Ingrese la misma contraseña' : '');" placeholder="Verificar contraseña" class="form-control" onkeyup="validarClave()" >
		                </div>
		            </div>
		        </div> 
			</div>
		</div>
	</div>
</div>

	<section id="home" class="home bg-black fix">
	<div class="overlay"></div>
	<div class="container">
	    <div class="row">
	        <div class="main_home text-center">
	            <div class="col-md-12">
	                <div class="hello_slid">
	                    <div class="slid_item">
	                        <div class="home_text ">
	                            <h2 class="text-white">Bienvenid@ <strong><?php echo $_SESSION['mfo_datos']['usuario']['nombres'].' '.$_SESSION['mfo_datos']['usuario']['apellidos']; ?></strong></h2>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div><!--End off row-->
	</div><!--End off container -->
</section> <!--End off Home Sections-->

<?php if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == 1) { ?>
<br>
<div class="checkout-wrap">
  <ul class="checkout-bar">
    <li class="active"><a href="#">Registro</a></li>    
    <li class="active">Completar Perfil</li>
    <li class="">Formulario 1</li>
    <li class="">Formulario 2</li>
    <li class="">Formulario 3</li>
  </ul>
</div>
<br>
<?php } ?>


<section id="product" class="product">
    <div class="container"><br><br>
        <form role="form" name="form1" id="form1" method="post"  enctype="multipart/form-data">
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="panel panel-default shadow" style="border-radius: 20px;">
                    	<img id="imagen_perfil" width="100%" alt="fotoPerfil" src="<?php echo Modelo_Usuario::obtieneFoto(); ?>" style="border-radius: 20px 20px 0px 0px;">
                        <label for="file-input" class="custom_file"><img class="button-center" src="<?php echo PUERTO."://".HOST."/imagenes/upload-icon.png";?>" width="50px"></label>
						<input id="file-input" type="file" name="file-input" class="upload-photo">
                        <div align="center">
                            <p class="text-center">Actualizar foto de perfil</p>
                            <br>
                        </div>
                    </div>
                </div>
	            <div class="col-md-8">
	                <div class="panel panel-default shadow" style="border-radius: 20px;">
	                    <div class="panel-body">
				            <div class="row">
				            	<div class="main_business">
	                                <!-- candidato -->
	                                <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == 1) { ?>
	                                <div class="col-md-12">
	                                	<div class="col-md-12">
		                                    <div class="form-group">
		                                        <label for="username">Usuario:<h4 class="usuario"><u><?php echo $_SESSION['mfo_datos']['usuario']['username']; ?></u></h4></label>
		                                        
		                                    </div>
	                                    </div>
	                                    <div class="col-md-6">
		                                    <div class="form-group">
		                                        <label for="dni">C&eacute;dula </label>
		                                        <input class="form-control" id="dni" readonly value="<?php echo $_SESSION['mfo_datos']['usuario']['dni']; ?>" />
		                                    </div>
	                                    </div>
	                                    <div class="col-md-6">
		                                    <div class="form-group">
		                                        <label for="correo">Correo </label>
		                                        <input class="form-control" id="correo" readonly value="<?php echo $_SESSION['mfo_datos']['usuario']['correo']; ?>" required/>
		                                    </div>
	                                    </div>
	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="nombres">Nombres</label>
	                                			<input class="form-control" id="nombres" value="<?php echo $_SESSION['mfo_datos']['usuario']['nombres']; ?>" required/>
	                                        </div>
	                                    </div>
	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="apellidos">Apellidos</label>
	                                			<input class="form-control" id="apellidos" value="<?php echo $_SESSION['mfo_datos']['usuario']['apellidos']; ?>" />
	                                        </div>
	                                    </div>
	                                    
	                                    		
	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="provincia">Provincia</label>
	                                            <select class="form-control" name="provincia" id="provincia">
	                                            	<option value="">Seleccione una provincia</option>
													<?php 
			                                    	foreach($arrprovincia as $key => $pr){ 
														echo "<option value='".$pr['id_provincia']."'";
														if ($_SESSION['mfo_datos']['usuario']['id_ciudad'] == $pr['id_escolaridad'])
														{ 
															echo " selected='selected'";
														}
														echo ">".utf8_encode($pr['nombre'])."</option>";
													} ?>
												</select>
	                                        </div>
	                                    </div>

	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="ciudad">Ciudad</label>
	                                            <select id="ciudad" class="form-control">
	                                            <?php if(!empty($arrciudad)){
			                                    	foreach($arrciudad as $key => $ciudad){ 
														echo "<option value='".$ciudad['id_ciudad']."'>".utf8_encode($ciudad['ciudad'])."</option>";
													} 
	                                            }else{ ?>
													<option value="">Selecciona una ciudad</option>
	                                            <?php } ?>
	                                            </select>
	                                        </div>
	                                    </div>					
	                                    <div class="col-md-6">
		                                    <div class="form-group">
		                                        <label for="mayor_edad">Fecha Nacimiento </label>
		                                        <input class="form-control" type="date" name="fecha" id="mayor_edad" value="<?php echo date('Y-m-d',strtotime($_SESSION['mfo_datos']['usuario']['fecha_nacimiento'])); ?>" />
		                                    </div>
	                                    </div>
	                                    <div class="col-md-6">
	                                    	<div class="form-group">
		                                    	<label for="discapacidad">Discapacidad</label>
			                                    <select class="form-control">
			                                    	<option value="">Tiene alguna discapacidad&#63;</option>
			                                    	<?php 
			                                    	foreach(DISCAPACIDAD as $key => $dis){ 
														echo "<option value='$key'";
														if ($_SESSION['mfo_datos']['usuario']['discapacidad'] == $key)
														{ 
															echo " selected='selected'";
														}
														echo ">$dis</option>";
													} ?>
												</select>
											</div>
										</div>
										<div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="experiencia">A&ntilde;os de Experiencia</label>
	                                            <select class="form-control">
	                                            	<option value="">Seleccione una opci&oacute;n</option>
	                                            <?php 
			                                    	foreach(ANOSEXP as $key => $exp){ 
														echo "<option value='$key'";
														if ($_SESSION['mfo_datos']['usuario']['anosexp'] == $key)
														{ 
															echo " selected='selected'";
														}
														echo ">$exp</option>";
													} ?>
	                                            </select>
	                                        </div>
	                                    </div>
	                                    <div class="col-md-6">
		                                    <div class="form-group">
		                                        <label for="telefono">Tel&eacute;fono </label>
		                                        <input class="form-control" id="telefono" value="<?php echo $_SESSION['mfo_datos']['usuario']['telefono']; ?>" />
		                                    </div>
	                                    </div>
	                                    
	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="genero">G&eacute;nero</label>
	                                            <select class="form-control">
													<option value="">Seleccione un genero</option>
			                                    	<?php 
			                                    	foreach(GENERO as $key => $ge){ 
														echo "<option value='$key'";
														if ($_SESSION['mfo_datos']['usuario']['genero'] == $key)
														{ 
															echo " selected='selected'";
														}
														echo ">$ge</option>";
													} ?>
	                                            </select>
	                                        </div>
	                                    </div>
	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="escolaridad">Escolaridad</label>
	                                            <select class="form-control">
	                                            	<option value="">Seleccione una opci&oacute;n</option>
													<?php 
			                                    	foreach($escolaridad as $key => $es){ 
														echo "<option value='".$es['id_escolaridad']."'";
														if ($_SESSION['mfo_datos']['usuario']['id_escolaridad'] == $es['id_escolaridad'])
														{ 
															echo " selected='selected'";
														}
														echo ">".utf8_encode($es['descripcion'])."</option>";
													} ?>
												</select>
	                                        </div>
	                                    </div>
	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="area">&Aacute;reas de inter&eacute;s</label>
	                                            <select class="form-control" multiple id="select_area" data-selectr-opts='{"maxSelection": 3 }' name="areas">
													<?php 
			                                    	foreach($arrarea as $key => $ae){ 
														echo "<option value='".$ae['id_area']."'";
														if (in_array($ae['id_area'], $areaxusuario))
														{ 
															echo " selected='selected'";
														}
														echo ">".utf8_encode($ae['nombre'])."</option>";
													} ?>
												</select>

	                                        </div>
	                                    </div>
	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="nivel">Niveles de inter&eacute;s</label>
	                                            <select class="form-control" multiple id="select_nivel" data-selectr-opts='{"maxSelection": 2 }' name="niveles">
													<?php 
			                                    	foreach($arrinteres as $key => $int){ 
														echo "<option value='".$int['id_nivelInteres']."'";
														if (in_array($int['id_nivelInteres'], $nivelxusuario))
														{ 
															echo " selected='selected'";
														}
														echo ">".utf8_encode($int['descripcion'])."</option>";
													} ?>
												</select>
	                                        </div>
	                                    </div>
	                                </div>  
	                                <?php } ?>    
	                            </div>
	                            <input type="text" hidden id="puerto_host" value="<?php echo PUERTO."://".HOST ;?>">
					            <div class="col-sm-8 col-sm-offset-2 col-lg-8 col-lg-offset-2">
							      <button type="submit" class="btn btn-success btn-block">GUARDAR</button>
							    </div>
				                
				            </div>  
			            </div>   
			        </div>
			    </div>
		    </div> 
        </form>
    </div>
</section>

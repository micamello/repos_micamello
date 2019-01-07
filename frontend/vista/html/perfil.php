<?php  
$_SESSION['mostrar_exito'] = "";
$_SESSION['mostrar_error'] = "";
if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?>
<div class="container">
	<div class="checkout-wrap">
	  <ul class="checkout-bar">
        <li class="visited">Registro</li>
        <li class="active">Completar Perfil</li>
        <?php 
        for($i=1;$i<=$nrototaltest;$i++){ ?>
          <?php 
           if ($i <= $nrotestusuario){
             $clase = "visited";
           }
           else{
             $clase = "";
           }
          ?>
          <li class="<?php echo $clase;?>">Formulario <?php echo $i;?></li>                
        <?php } ?>
      </ul>
	</div>
</div>
<br>
<?php } 
?>


<!--<section id="product" class="product">-->
    <div class="container"><br><br>
        <form role="form" name="form_editarPerfil" id="form_editarPerfil" method="post" action="<?php echo PUERTO."://".HOST;?>/perfil/" enctype="multipart/form-data">
            <div class="col-md-12">
                <div class="col-md-4">
                    <div id="seccion_img" class="panel panel-default shadow" style="border-radius: 20px;">
                    	<img id="imagen_perfil" width="100%" alt="fotoPerfil" src="<?php echo Modelo_Usuario::obtieneFoto($_SESSION['mfo_datos']['usuario']['username']); ?>" style="border-radius: 20px 20px 0px 0px;">
                        <label for="file-input" class="custom_file"><img class="button-center" src="<?php echo PUERTO."://".HOST."/imagenes/upload-icon.png";?>" width="50px"></label>
						<input id="file-input" type="file" name="file-input"  class="upload-photo">
                        <div id="err_img" align="center">
                        	<p class="text-center">Actualizar foto de perfil (.jpg .jpeg )</p>
                        </div> 
                        <br>
                    </div>
                    <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){ ?>
	                    <div id="carga" class="panel panel-default shadow" style="border-radius: 20px;">
	                    	
	                    	<img id="archivo" width="100%" alt="hoja_de_vida" src="<?php echo PUERTO."://".HOST."/imagenes/Hv.jpg";?>" style="border-radius: 20px 20px 0px 0px;">
	                       
	                       <?php if($btnDescarga == 1){ ?>
		                       	<div <?php if($btnSig == 0){ echo 'class="pull-left" style="position: relative; margin-left: 15px;"'; } ?>>
			                        <label for="descargarCV" class="custom_file">
			                        	<a href="<?php echo $ruta_arch; ?>" target="_blank">
			                        		<img id="imagenBtn1" style="cursor:pointer;" class="button-center" src="<?php echo PUERTO."://".HOST."/imagenes/$imgArch1";?>" width="50px">
			                        	</a>
			                        </label>

									<input id="descargarCV" type="file" name="descargarCV"  class="upload-photo">
									<div align="center">
			                            <p class="text-center" id="texto_status1"><?php echo $msj1; ?></p>
			                        </div>
			                    </div>
			                    
							<?php } ?>
							
							<?php 
							

							if($btnSubir == 1 || isset($data)){ ?>
								<div <?php if($btnDescarga == 1){ echo 'class="pull-right" style="position: relative; margin-right: 15px;"'; } ?>>
			                        <label for="subirCV" class="custom_file">
			                        	<img id="imagenBtn" class="button-center" src="<?php echo PUERTO."://".HOST."/imagenes/$imgArch2";?>" width="50px">
			                        </label>
			                        <?php if($btnDescarga != 1){ echo '<p id="mensaje_error_hv" class="parpadea" style="font-size:14px;color:red">Cargar la hoja de vida es obligatorio *</p>'; } ?>
			                   		<input id="subirCV" type="file" name="subirCV" class="upload-photo" accept="application/pdf,application/msword,.doc, .docx" >
			                   		<div align="center">
		                            	<p class="text-center" id="texto_status"><?php echo $msj2; ?></p>
		                        	</div>
								</div>
								<br><br>
								<?php if($btnDescarga == 1){ echo '<br><br>'; } ?>

	                        <?php } ?>

	                    </div>
                    <?php } ?>

					<div class="panel panel-default shadow" style="border-radius: 20px;">
				    	
				    	<img id="archivo" width="100%" alt="cambio_clave" src="<?php echo PUERTO."://".HOST."/imagenes/cambiar_clave.jpg";?>" style="border-radius: 20px 20px 0px 0px;">

			           	<div>
			                <label for="cambiar" class="custom_file">
			                	<a onclick="abrirModal('','cambiar_clave','','Ok');">
			                		<img id="cambiar" class="button-center" src="<?php echo PUERTO."://".HOST."/imagenes/btn_cambiar_clave.png";?>" width="50px">
			                	</a>
			                </label>
							<div align="center">
			                    <p class="text-center" id="texto_status1">Presiona aqu&iacute;</p>
			                </div>
			            </div>
			            <br>
				    </div>
                </div>
	            <div class="col-md-8">
	                <div class="panel panel-default shadow" style="border-radius: 20px;">
	                    <div class="panel-body">
				            <div class="row">
				            	<div class="main_business">
	                                <div class="col-md-12">
	                                	<div class="col-md-12">
		                                    <div class="form-group">
		                                        <label for="username">Usuario:
		                                        	<h4 class="usuario">
		                                        	   <u><?php echo $_SESSION['mfo_datos']['usuario']['username']; ?></u>
		                                        	</h4><?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::CANDIDATO) { ?>
		                                        	<h6>RUC: <?php echo $_SESSION['mfo_datos']['usuario']['dni']; ?></h6><?php } ?>
		                                        </label>		                                        
		                                    </div>
	                                    </div>
	                                    <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?>

	                                    	<div class="col-md-6">
									            <div class="form-group" id="seleccione_group">
									              <label for="tipo_dni">Tipo de documento</label><div id="seleccione_error" class="help-block with-errors"></div>
									              <select class="form-control" id="documentacion" name="documentacion" onchange="validarFormulario()" <?php if($_SESSION['mfo_datos']['usuario']['tipo_doc'] == 0){ echo ''; }else{ echo 'disabled';} ?>>
									                <option selected="" value="">Seleccione una opcion</option>
									                <?php 
									                  $option = '';
									                  foreach(DOCUMENTACION as $key => $doc){
									                    $option .= "<option value='".$key."'";
									                	if ($_SESSION['mfo_datos']['usuario']['tipo_doc'] == $key || (isset($data['tipo_doc']) && $data['tipo_doc'] == $key))
														{ 
															$option .= " selected='selected'";
														}
														$option .= ">".$doc."</option>";
													  }
													  echo $option;
									                 ?>
									              </select>
									            </div>
									          </div> 

		                                    <div class="col-md-6">
			                                    <div class="form-group" id="seccion_dni">
			                                        <label for="dni">C&eacute;dula</label><div id="err_dni" class="help-block with-errors"></div>
			                                        <input class="form-control" type="text" id="dni" <?php if($_SESSION['mfo_datos']['usuario']['dni'] == 0){ echo ''; }else{ echo 'disabled';} ?> value="<?php if(isset($data['dni'])){ echo $data['dni']; } else{ if($_SESSION['mfo_datos']['usuario']['dni'] == 0){ echo ''; }else{ echo $_SESSION['mfo_datos']['usuario']['dni']; } } ?>" onkeyup="validarFormulario()" />
			                                    </div>
		                                    </div>
	                                	<?php } ?>

	                                    <div class="col-md-6">
	                                        <div id="seccion_nombre" class="form-group">
	                                            <label for="nombres"><?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?> Nombres <span class="requerido" title="Este campo es obligatorio">*</span><?php }else{ ?> Nombre de la empresa<?php } ?></label><div id="err_nom" class="help-block with-errors"></div>

	                                			<input class="form-control" type="text" id="nombres" name="nombres" maxlength="100" value="<?php if(isset($data['nombres'])){ echo $data['nombres']; } else{ echo $_SESSION['mfo_datos']['usuario']['nombres']; } ?>" pattern="[a-z A-ZñÑáéíóúÁÉÍÓÚ]+"  onkeyup="validarFormulario()" />
	                                        </div>
	                                    </div>

	                                    <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?>
		                                    <div class="col-md-6">
		                                        <div id="seccion_apellido" class="form-group">
		                                            <label for="apellidos">Apellidos<span class="requerido" title="Este campo es obligatorio">*</span></label><div id="err_ape" class="help-block with-errors"></div>

		                                			<input class="form-control" type="text" id="apellidos" name="apellidos" maxlength="100" value="<?php if(isset($data['apellidos'])){ echo $data['apellidos']; } else{ echo $_SESSION['mfo_datos']['usuario']['apellidos']; } ?>" pattern='[a-z A-ZñÑáéíóúÁÉÍÓÚ]+'  onkeyup="validarFormulario()" />
		                                        </div>
		                                    </div>
	                                    <?php } ?>

	                                    <div class="col-md-6">
		                                    <div class="form-group">
		                                        <label for="correo">Correo </label><div class="help-block with-errors"></div>
		                                        <input class="form-control" id="correo" type="email" disabled value="<?php if(isset($data['correo'])){ echo $data['correo']; } else{ echo $_SESSION['mfo_datos']['usuario']['correo']; } ?>"/>
		                                    </div>
	                                    </div>

	                                    <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?>
		                                    <div class="col-md-6">
			                                        <div id="seccion_gen" class="form-group">
			                                            <label for="genero">G&eacute;nero <span class="requerido" title="Este campo es obligatorio">*</span></label><div id="err_gen" class="help-block with-errors"></div>
			                                            <select id="genero" name="genero" class="form-control"  onchange="validarFormulario()" >
															<option value="0">Seleccione un genero</option>
					                                    	<?php 
					                                    	foreach(GENERO as $key => $ge){ 
																echo "<option value='$key'";
																if ($_SESSION['mfo_datos']['usuario']['genero'] == $key || (isset($data['genero']) && $data['genero'] == $key))
																{ 
																	echo " selected='selected'";
																}
																echo ">$ge</option>";
															} ?>
			                                            </select>
			                                        </div>
			                                </div>
		                                <?php } ?>

	                                    <div class="col-md-<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { echo '6'; }else{ echo '12';} ?>">
		                                    <div id="seccion_nac" class="form-group">
	                                            <label for="nacionalidad">Nacionalidad <span class="requerido" title="Este campo es obligatorio">*</span></label><div id="err_nac" class="help-block with-errors"></div>
	                                            <select class="form-control" name="id_nacionalidad" id="id_nacionalidad"  onchange="validarFormulario()" >
	                                            	<option value="0">Seleccione su opci&oacute;n</option>
													<?php 
													if (!empty($nacionalidades)){
				                    					foreach($nacionalidades as $key => $n){ 
															echo "<option value='".$n['id_pais']."'";
															if ($_SESSION['mfo_datos']['usuario']['id_nacionalidad'] == $n['id_pais'] || (isset($data['id_nacionalidad']) && $data['id_nacionalidad'] == $n['id_pais']))
															{ 
																echo " selected='selected'";
															}
															echo ">".utf8_encode($n['nombre_abr'])."</option>";
														}
													} ?>
												</select>
	                                        </div>
	                                    </div>		

	                                    <div class="col-md-6">
		                                    <div id="mayoria"  class="form-group">
		                                        <label for="mayor_edad"><?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?> Fecha de Nacimiento <?php }else{ ?> Fecha de Apertura <?php } ?><span class="requerido" title="Este campo es obligatorio">*</span></label><div id="error" class="help-block with-errors"></div>

		                                        <input class="form-control" type="date" name="fecha_nacimiento" id="fecha_nacimiento" max="<?php echo date('Y-m-d'); ?>"  value="<?php if(isset($data['fecha_nacimiento'])){ echo $data['fecha_nacimiento']; } else{ echo date('Y-m-d',strtotime($_SESSION['mfo_datos']['usuario']['fecha_nacimiento'])); } ?>"  <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?> onchange="calcularEdad(); validarFormulario();" <?php } ?> placeholder="dd/mm/aaaa" onkeyup="calcularEdad(); validarFormulario();" />
		                                    </div>
	                                    </div>

										<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) { ?>

											<div class="col-md-6">
											    <div id="seccion_tlf" class="form-group">
											        <label for="telefono">Tel&eacute;fono <span class="requerido" title="Este campo es obligatorio">*</span></label><div id="err_tlf" class="help-block with-errors"></div>
											        <input class="form-control" type="text" id="telefono" name="telefono" minlength="9" maxlength="15" pattern='[0-9]+' onkeydown="return validaNumeros(event)" value="<?php if(isset($data['telefono'])){ echo $data['telefono']; } else{ echo $_SESSION['mfo_datos']['usuario']['telefono']; } ?>"  onkeyup="validarFormulario()" />
											    </div>
											</div>

										<?php }  ?>
										<hr width="100%" />
	                                    <div class="form-group col-md-12">
    										<h6><b>Direcci&oacute;n Domiciliaria</b></h6>
		                                    <div class="col-md-6">
		                                        <div id="seccion_provincia" class="form-group">
		                                            <label for="provincia">Provincia <span class="requerido" title="Este campo es obligatorio">*</span></label><div id="err_prov" class="help-block with-errors"></div>
		                                            <select class="form-control" name="provincia" id="provincia"  onchange="validarFormulario()" >
		                                            	<option value="0">Seleccione una provincia</option>
														<?php 
														if (!empty($arrprovincia)){									
					                    					foreach($arrprovincia as $key => $pr){ 
																echo "<option value='".$pr['id_provincia']."'";

																if(isset($data['provincia']) && (int)$data['provincia'] == (int)$pr['id_provincia']){
													
																	echo " selected='selected'";
																}else if ((int)$provincia == (int)$pr['id_provincia']){ 
																	echo " selected='selected'";
																}
																echo ">".utf8_encode($pr['nombre'])."</option>";
															}
														} ?>
													</select>
		                                        </div>
		                                    </div>

		                                    <div class="col-md-6">
		                                        <div id="seccion_ciudad" class="form-group">
		                                            <label for="ciudad">Ciudad <span class="requerido" title="Este campo es obligatorio">*</span></label><div id="err_ciu" class="help-block with-errors"></div>
		                                            <select id="ciudad" name="ciudad" class="form-control"  onchange="validarFormulario()" >
		                                            <?php 
		                                            if(!empty($arrciudad)){
				                                    	foreach($arrciudad as $key => $ciudad){ 
															echo "<option value='".$ciudad['id_ciudad']."'";
															if(isset($data['ciudad']) && $data['ciudad'] == $ciudad['id_ciudad']){
																echo " selected='selected'";
															}else if ($_SESSION['mfo_datos']['usuario']['id_ciudad'] == $ciudad['id_ciudad']){  
																echo " selected='selected'";
															}
															echo ">".utf8_encode($ciudad['ciudad'])."</option>";
														} 
		                                            }else{ ?>
														<option value="0">Selecciona una ciudad</option>
		                                            <?php } ?>
		                                            </select>
		                                        </div>
		                                    </div>					
	                    				</div>

	                    				
	                                    <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?>
	                                    	<hr width="100%" />
		                                    <div class="col-md-6">
		                                    	<div id="seccion_dis" class="form-group">
			                                    	<label for="discapacidad">Discapacidad <span class="requerido" title="Este campo es obligatorio">*</span></label><div id="err_dis" class="help-block with-errors"></div>
				                                    <select id="discapacidad" name="discapacidad" class="form-control"  onchange="validarFormulario()" >
				                                    	<option value="-1">Tiene alguna discapacidad&#63;</option>
				                                    	<?php 
				                                    	foreach(REQUISITO as $key => $dis){ 
															echo "<option value='$key'";
															if ($_SESSION['mfo_datos']['usuario']['discapacidad'] == $key || (isset($data['discapacidad']) && $data['discapacidad'] == $key))
															{ 
																echo " selected='selected'";
															}
															echo ">$dis</option>";
														} ?>
													</select>
												</div>
											</div>
											
											<div class="col-md-6">
		                                        <div id="seccion_exp" class="form-group">
		                                            <label for="experiencia">A&ntilde;os de Experiencia <span class="requerido" title="Este campo es obligatorio">*</span></label><div id="err_exp" class="help-block with-errors"></div>
		                                            <select id="experiencia" name="experiencia" class="form-control"  onchange="validarFormulario()" >
		                                            	<option value="0">Seleccione una opci&oacute;n</option>
		                                            <?php 
				                                    	foreach(ANOSEXP as $key => $exp){ 
															echo "<option value='$key'";
															if ($_SESSION['mfo_datos']['usuario']['anosexp'] == $key || (isset($data['experiencia']) && $data['experiencia'] == $key))
															{ 
																echo " selected='selected'";
															}
															echo ">$exp</option>";
														} ?>
		                                            </select>
		                                        </div>
		                                    </div>

											<div class="col-md-6">
											    <div id="seccion_tlf" class="form-group">
											        <label for="telefono">Tel&eacute;fono <span class="requerido" title="Este campo es obligatorio">*</span></label><div id="err_tlf" class="help-block with-errors"></div>
											        <input class="form-control" type="text" id="telefono" name="telefono" minlength="10" maxlength="15" pattern='[0-9]+' onkeydown="return validaNumeros(event)" value="<?php if(isset($data['telefono'])){ echo $data['telefono']; } else{ echo $_SESSION['mfo_datos']['usuario']['telefono']; } ?>"  onkeyup="validarFormulario()" />
											    </div>
											</div>

		                                    <div class="col-md-6">
		                                    	<div id="seccion_civil" class="form-group">
			                                    	<label for="estado_civil">Estado civil <span class="requerido" title="Este campo es obligatorio">*</span></label><div id="err_civil" class="help-block with-errors"></div>
				                                    <select id="estado_civil" name="estado_civil" class="form-control"  onchange="validarFormulario()" >
				                                    	<option value="0">Seleccione una opci&oacute;n</option>
				                                    	<?php 
				                                    	foreach(ESTADO_CIVIL as $key => $e){ 
															echo "<option value='$key'";
															if ($_SESSION['mfo_datos']['usuario']['estado_civil'] == $key || (isset($data['estado_civil']) && $data['estado_civil'] == $key))
															{ 
																echo " selected='selected'";
															}
															echo ">$e</option>";
														} ?>
													</select>
												</div>
											</div>
											<div class="clearfix"></div>
		                                    
		                                    <div class="col-md-6">
		                                    	<div id="seccion_res" class="form-group">
			                                    	<label for="residencia">&#191;Puede cambiar de residencia&#63; <span class="requerido" title="Este campo es obligatorio">*</span></label><div id="err_res" class="help-block with-errors"></div>
				                                    <select id="residencia" name="residencia" class="form-control"  onchange="validarFormulario()" >
				                                    	<option value="0">Seleccione una opci&oacute;n</option>
				                                    	<?php 
				                                    	foreach(REQUISITO as $key => $r){ 
															echo "<option value='$key'";
															if ($_SESSION['mfo_datos']['usuario']['tiene_trabajo'] == $key || (isset($data['tiene_trabajo']) && $data['tiene_trabajo'] == $key))
															{ 
																echo " selected='selected'";
															}
															echo ">$r</option>";
														} ?>
													</select>
												</div>
											</div>

											<div class="col-md-6">
		                                    	<div id="seccion_trab" class="form-group">
			                                    	<label for="tiene_trabajo">&#191;Tiene trabajo&#63; <span class="requerido" title="Este campo es obligatorio">*</span></label><div id="err_trab" class="help-block with-errors"></div>
				                                    <select id="tiene_trabajo" name="tiene_trabajo" class="form-control"  onchange="validarFormulario()" >
				                                    	<option value="0">Seleccione una opci&oacute;n</option>
				                                    	<?php 
				                                    	foreach(REQUISITO as $key => $r){ 
															echo "<option value='$key'";
															if ($_SESSION['mfo_datos']['usuario']['tiene_trabajo'] == $key || (isset($data['tiene_trabajo']) && $data['tiene_trabajo'] == $key))
															{ 
																echo " selected='selected'";
															}
															echo ">$r</option>";
														} ?>
													</select>
												</div>
											</div>

											<div class="col-md-6">
		                                    	<div id="seccion_via" class="form-group">
			                                    	<label for="viajar">&#191;Puede viajar&#63; <span class="requerido" title="Este campo es obligatorio">*</span></label><div id="err_via" class="help-block with-errors"></div>
				                                    <select id="viajar" name="viajar" class="form-control"  onchange="validarFormulario()" >
				                                    	<option value="0">Seleccione una opci&oacute;n</option>
				                                    	<?php 
				                                    	foreach(REQUISITO as $key => $r){ 
															echo "<option value='$key'";
															if ($_SESSION['mfo_datos']['usuario']['viajar'] == $key || (isset($data['viajar']) && $data['viajar'] == $key))
															{ 
																echo " selected='selected'";
															}
															echo ">$r</option>";
														} ?>
													</select>
												</div>
											</div>

											<div class="col-md-6">
		                                    	<div id="seccion_lic" class="form-group">
			                                    	<label for="licencia">&#191;Tiene licencia para conducir&#63; <span class="requerido" title="Este campo es obligatorio">*</span></label><div id="err_lic" class="help-block with-errors"></div>
				                                    <select id="licencia" name="licencia" class="form-control"  onchange="validarFormulario()" >
				                                    	<option value="0">Seleccione una opci&oacute;n</option>
				                                    	<?php 
				                                    	
				                                    	foreach(REQUISITO as $key => $r){ 
															echo "<option value='$key'";
															if ($_SESSION['mfo_datos']['usuario']['licencia'] == $key || (isset($data['licencia']) && $data['licencia'] == $key))
															{ 
																echo " selected='selected'";
															}
															echo ">$r</option>";
														} ?>
													</select>
												</div>
											</div>
	 
		                                    <div class="col-md-6" >
		                                        <div id="seccion_esc" class="form-group">
		                                            <label for="escolaridad">&Uacute;ltimo estudio realizado <span class="requerido" title="Este campo es obligatorio">*</span></label><div id="err_esc" class="help-block with-errors"></div>
		                                            <select id="escolaridad" name="escolaridad" class="form-control" onchange="ocultarCampos(); validarFormulario();"style="padding-left: 0px;"  >
		                                            	<option value="0">Seleccione una opci&oacute;n</option>
														<?php 
														if (!empty($escolaridad)){
					                                    	foreach($escolaridad as $key => $es){ 
																echo "<option value='".$es['id_escolaridad']."'";
																if ($_SESSION['mfo_datos']['usuario']['id_escolaridad'] == $es['id_escolaridad'] || (isset($data['escolaridad']) && $data['escolaridad'] == $es['id_escolaridad']))
																{ 
																	echo " selected='selected'";
																}
																echo ">".utf8_encode($es['descripcion'])."</option>";
															}
														} ?>
													</select>
		                                        </div>
		                                    </div>

		                                    <div class="col-md-6">
		                                    	<div id="seccion_est" class="form-group">
		                                    		<label for="estatus">Nivel <span class="requerido" title="Este campo es obligatorio">*</span></label><div id="err_est" class="help-block with-errors"></div>
													 <select id="estatus" name="estatus" class="form-control" style="padding-left: 0px;"  onchange="validarFormulario()" >
													 	<option value="0">Seleccione su opci&oacute;n</option>
														<?php 
				                                    	foreach(STATUS_CARRERA as $key => $status){ 
															echo "<option value='".$key."'";
															if ($_SESSION['mfo_datos']['usuario']['status_carrera'] == $key || (isset($data['estatus']) && $data['estatus'] == $key))
															{ 
																echo " selected='selected'";
															}
															echo ">".utf8_encode($status)."</option>";
														}
														 ?>
													</select>
												</div>
		                                    </div>

											<div class="col-md-6 depende" hidden>
		                                        <div id="seccion_estudio" class="form-group">
		                                            <label for="lugar_estudio">&#191;Estudi&oacute; en el extranjero&#63; <span class="requerido" title="Este campo es obligatorio">*</span></label><div id="err_estudio" class="help-block with-errors"></div>
		                                            <select class="form-control" id="lugar_estudio" name="lugar_estudio" onchange='mostrarUni(); validarFormulario();'  >
		                                            	<option value="-1" selected="selected">Seleccione su opci&oacute;n</option>

														<?php 
				                                    	foreach(REQUISITO as $key => $u){ 
															echo "<option value='".$key."'";
															if (($_SESSION['mfo_datos']['usuario']['id_univ'] != 0 && $key == 0 && strlen($_SESSION['mfo_datos']['usuario']['nombre_univ']) <= 1) || (isset($data['lugar_estudio']) && $data['lugar_estudio'] == 0 && $key == $data['lugar_estudio']))
															{
																echo " selected='selected'";
															}else if ((strlen($_SESSION['mfo_datos']['usuario']['id_univ']) <= 1 && $key == 1 && strlen($_SESSION['mfo_datos']['usuario']['nombre_univ']) > 1) || (isset($data['lugar_estudio']) && $data['lugar_estudio'] == 1 && $key == $data['lugar_estudio']))
															{
																echo " selected='selected'";
															}
															
															echo ">".utf8_encode($u)."</option>";
														} 
														?>
													</select>
		                                        </div>
		                                    </div>

		                                    <div hidden class="col-md-6 depende">
		                                        <div id="seccion_univ" class="form-group">
		                                            <label for="universidad">Universidad <span class="requerido" title="Este campo es obligatorio">*</span></label><div id="err_univ" class="help-block with-errors"></div>
		                                            <select class="form-control" id="universidad" name="universidad"  onchange="validarFormulario()" >
		                                            	<option value="0">Seleccione su opci&oacute;n</option>
														<?php 
														if (!empty($universidades)){
					                                    	foreach($universidades as $key => $u){ 
																echo "<option value='".$u['id_univ']."'";
																if ($_SESSION['mfo_datos']['usuario']['id_univ'] == $u['id_univ'] || (isset($data['universidad']) && $data['universidad'] == $u['id_univ']))
																{ 
																	echo " selected='selected'";
																}
																echo ">".utf8_encode($u['nombre'])."</option>";
															} 
														}?>
													</select>
													<input type="text" name="universidad2" id="universidad2" maxlength="100" class="form-control"   pattern="[a-z A-ZñÑáéíóúÁÉÍÓÚ.]+" style="display:none" onkeyup="validarFormulario()" value="<?php if(isset($data['universidad2'])){ echo $data['universidad2']; } else{ if($_SESSION['mfo_datos']['usuario']['nombre_univ'] != ' '){ echo $_SESSION['mfo_datos']['usuario']['nombre_univ']; } } ?>">
		                                        </div>
		                                    </div>

		                                    <div class="col-md-6">	
												<div class="form-group" id="seccion_area">
													<div class="panel panel-default">
														<div class="panel-head-select">Áreas (Máx: 3)
												        	<label class="num_sel" style="float: right; color: black; border-radius: 5px;">
												          		<label id="numero1">0</label> de 3
												        	</label>
												        	<div id="err_area" class="help-block with-errors"></div>
												      	</div>
														<div class="panel-body">
															<div class="row" id="seleccionados1">
															</div>
														</div>
													  	<select class="form-control" multiple id="area_select" name="area_select[]"  onchange="validarFormulario()" >
															<?php 
															if (!empty($arrarea)){
											                	foreach($arrarea as $key => $ae){ 
																	echo "<option value='".$ae['id_area']."'";

																	if(isset($data['area_select'])){
																		if (in_array($ae['id_area'], $data['area_select']))
																		{ 
																			echo " selected='selected'";
																		}
																	}else{
																		if (in_array($ae['id_area'], $areaxusuario))
																		{ 
																			echo " selected='selected'";
																		}
																	}
																	echo ">".utf8_encode($ae['nombre'])."</option>";
																} 
															}?>
														</select>
													</div>
												</div>
											</div>

											<div class="col-md-6">	
												<div class="form-group" id="seccion_int">
													<div class="panel panel-default">
														<div class="panel-head-select">Niveles de Interes (Máx: 2)
												        	<label class="num_sel" style="float: right; color: black; border-radius: 5px;">
												          		<label id="numero2">0</label> de 2
												        	</label>
												        	<div id="err_int" class="help-block with-errors"></div>
												      	</div>
														<div class="panel-body">
															<div class="row" id="seleccionados2">
															</div>
														</div>
													  	<select class="form-control" multiple id="nivel_interes" name="nivel_interes[]"  onchange="validarFormulario()" >

															<?php 
															if (!empty($arrinteres)){
											                	foreach($arrinteres as $key => $ae){ 
																	echo "<option value='".$ae['id_nivelInteres']."'";
				
																	if(isset($data['nivel_interes'])){
																		if (in_array($ae['id_nivelInteres'], $data['nivel_interes']))
																		{ 
																			echo " selected='selected'";
																		}
																	}else{
																		if (in_array($ae['id_nivelInteres'], $nivelxusuario))
																		{ 
																			echo " selected='selected'";
																		}
																	}

																	echo ">".utf8_encode($ae['descripcion']);
																	echo "</option>";
																} 
															} ?>
														</select>
													</div>
												</div>
											</div>

		                                    <div class="clearfix"></div>
		                                
		                                    <div class="col-md-4 col-md-offset-1">
												<div class="form-group">
													<label>Idioma: </label><div class="help-block with-errors"></div>
													<select id="idioma_of" name="idioma_of" class="form-control" <?php if((count($arridioma) == count($nivelIdiomas)) || $btnSig == 1){ echo 'disabled=disabled'; } ?> >
														<option value="0">Seleccione una opci&oacute;n</option>
														<?php if (!empty($arridioma)){
															
															foreach ($arridioma as $idioma) { ?>
																<option value="<?php echo $idioma['id_idioma'] ?>"
																<?php 
																	$descripcion = utf8_encode($idioma['descripcion']);
																	if(isset($nivelIdiomas[$descripcion])){
																		echo 'disabled=disabled';
																	}
																?>
																><?php echo utf8_encode($idioma['descripcion']) ?></option>
														<?php }
														} ?>
													</select>
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group">
													<label>Nivel idioma: </label><div class="help-block with-errors"></div>
													<select id="nivel_idi_of" name="nivel_idi_of" class="form-control" <?php if((count($arridioma) == count($nivelIdiomas)) || $btnSig == 1){ echo 'disabled=disabled'; } ?>>
														<option value="0">Seleccione una opci&oacute;n</option>
														<?php if (!empty($arrnivelidioma)){
															foreach ($arrnivelidioma as $nivelidioma) {?>
																<option value="<?php echo $nivelidioma['id_nivelIdioma'] ?>"><?php echo utf8_encode($nivelidioma['nombre']) ?></option>
														<?php }
														} ?>
													</select>
												</div>
											</div>

											<div class="col-md-2">
												<div class="form-group" id="effect_bounce">
													<a id="btn_transfer" class="button_transfer_list"><i class="fa fa-plus"></i> Añadir idioma</a>
												</div>
											</div>

											<div class="col-md-12">
												<div id="seccion_listado" class="form-group">
													<label>Idiomas seleccionados: </label><div id="listado_idiomas" class="help-block with-errors"></div>
														<div id="error_msg">
														</div>
														<div class="list_content">
															<div class="form-group" id="list_idioma">
																<?php if(empty($nivelIdiomas) && (isset($data) && empty($data['nivel_idioma'])) ){ ?>
																	<p id="text_nothing">Ningun idioma seleccionado.....</p>
																<?php }else{ ?>
																	<p style="display:none;" id="text_nothing">Ningun idioma seleccionado.....</p>
																<?php 
																	//$i = 1;
																if(isset($data['nivel_idioma']) && !empty($data['nivel_idioma'])){
																	foreach ($data['nivel_idioma'] as $clave => $comb_idioma) {
																		$sel = explode('_',$comb_idioma);

																		foreach ($arridioma as $key => $value) {

																			if($value['id_idioma'] == $sel[0]){
																				foreach ($arrnivelidioma as $pos => $valor) {
																					if($valor['id_nivelIdioma'] == $sel[1]){
																						echo '<p id="idioma'.$sel[0].'" disabled="disabled" class="col-md-5 badge_item listado">'.utf8_encode($value['descripcion']).' ('.$valor['nombre'].') <i class="fa fa-window-close fa-2x icon" id="'.$sel[0].'" ';
																						if($btnSig != 1){
																							echo 'onclick="delete_item_selected(this); validarFormulario();"';
																						}
																						echo '></i></p>';
																						break;
																					}
																				}
																			}
																		}
																	}
																}else{

																	foreach ($nivelIdiomas as $key => $value) {
																		echo '<p id="idioma'.$value[0].'" disabled="disabled" class="col-md-5 badge_item listado">'.$key.' ('.$value[2].') <i class="fa fa-window-close fa-2x icon" id="'.$value[0].'" ';
																		if($btnSig != 1){
																			echo 'onclick="delete_item_selected(this); validarFormulario();"';
																		}
																		echo '></i></p>';
																	}
																}
															}	 ?>
															</div>
														</div>
													<select style="visibility: hidden; height: 1px;" id="select_array_idioma" name="nivel_idioma[]" multiple >
														<?php 
												        if(isset($data['nivel_idioma']) && !empty($data['nivel_idioma'])){
															foreach ($data['nivel_idioma'] as $clave => $comb_idioma) {
																$sel = explode('_',$comb_idioma);
																echo '<option value="'.$sel[0].'_'.$sel[1].'" id="array_idioma'.$sel[0].'" selected></option>';
															}
														}else{
															foreach ($nivelIdiomas as $key => $value) { ?>
																<option value="<?php echo $value[0].'_'.$value[1]; ?>" id="array_idioma<?php echo $value[0]; ?>" selected></option>
											    	  <?php } 
											    	    }  ?>
													</select>
												</div>
											</div>

										<?php }else{ ?>
					                    	<hr width="100%" />
	                                    	<div class="form-group col-md-12">
    											<h6><b>Datos de contacto</b></h6>

								           	 	<!-- Empresas contacto -->
									            <div class="col-md-6" id="group_nombre_contact">
									              <div id="seccion_nomCon" class="form-group">
									                <label class="text-center">Nombres</label>&nbsp;<i class="requerido">*</i><div id="err_nomCon" class="help-block with-errors"></div>

									                <input type="text" name="nombre_contact" id="nombre_contact" maxlength="100" value="<?php echo (isset($data['nombres_contacto'])) ? $data['nombres_contacto'] : $_SESSION['mfo_datos']['usuario']['nombres_contacto']; ?>" pattern='[a-z A-ZñÑáéíóúÁÉÍÓÚ]+' placeholder="Ejemplo: Juan David" class="form-control" onkeyup="validarFormulario()"  <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) { echo ''; } ?> >
									              </div>
									            </div>  

									            <div class="col-md-6" id="group_apell_contact">
									              <div id="seccion_apeCon" class="form-group">
									                <label class="text-center">Apellidos</label>&nbsp;<i class="requerido">*</i><div id="err_apeCon" class="help-block with-errors"></div>

									                <input type="text" name="apellido_contact" id="apellido_contact" maxlength="100" value="<?php echo (isset($data['apellidos_contacto'])) ? $data['apellidos_contacto'] : $_SESSION['mfo_datos']['usuario']['apellidos_contacto']; ?>" pattern='[a-z A-ZñÑáéíóúÁÉÍÓÚ]+' placeholder="Ejemplo: Ortíz Zambrano" class="form-control" onkeyup="validarFormulario()"  <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) { echo ''; } ?>>
									              </div>
									            </div> 

									            <div class="col-md-6" id="group_num1_contact">
									              <div id="seccion_tlfCon" class="form-group">
									                <label class="text-center">Teléfono 1</label>&nbsp;<i class="requerido">*</i><div id="err_tlfCon" class="help-block with-errors"></div>

									                <input type="text" name="tel_one_contact" id="tel_one_contact" maxlength="25" value="<?php echo (isset($data['tel_one_contact'])) ? $data['tel_one_contact'] : $_SESSION['mfo_datos']['usuario']['telefono1']; ?>" class="form-control" pattern='[0-9]+' onkeyup="validarFormulario()" onkeydown="return validaNumeros(event)"  <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) { echo ''; } ?>>
									              </div>
									            </div> 

									            <div class="col-md-6" id="group_num2_contact">
									              <div class="form-group">
									                <label class="text-center">Teléfono 2 (opcional):</label><div class="help-block with-errors"></div>

									                <input type="text" name="tel_two_contact" id="tel_two_contact" maxlength="25" value="<?php echo (isset($data['tel_two_contact'])) ? $data['tel_two_contact'] : $_SESSION['mfo_datos']['usuario']['telefono2']; ?>" class="form-control" pattern='[0-9]+' onkeydown="return validaNumeros(event)" <?php /*if($btnSig == 1){ echo 'disabled'; }*/ ?>>
									              </div>
									            </div> 
									        </div>
								        <?php } ?>
	                            	</div>
		                            <input type="hidden" name="actualizar" id="actualizar" value="1">
		                            <input type="hidden" name="tipo_usuario" id="tipo_usuario" value="<?php echo $_SESSION['mfo_datos']['usuario']['tipo_usuario']; ?>">
		                            <input type="hidden" name="btnDescarga" id="btnDescarga" value="<?php echo $btnDescarga; ?>">

					                <div class="row">
					                	
										<input type="button" id="boton" name="" class="btn btn-success" value="GUARDAR" disabled onclick="enviarFormulario()">

										<?php if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?>
											<a href="<?php echo PUERTO."://".HOST;?>/cuestionario/" class="btn btn-info" <?php if($btnSig == 0){ echo 'disabled'; } ?>>SIGUIENTE</a>
										<?php }else{ 	?>
											<a href="<?php echo PUERTO."://".HOST;?>/publicar/" class="btn btn-info" <?php if($btnSig == 0){ echo 'disabled'; } ?>>SIGUIENTE</a>
									    <?php } ?>
									</div>
				            	</div>  
			            	</div>   
			        	</div>
			    	</div>
		    	</div> 
		    </div>
        </form>
    </div>
<!--</section>-->

<div class="modal fade" id="cambiar_clave" tabindex="-1" role="dialog" aria-labelledby="cambiar_clave" aria-hidden="true">
  <div class="modal-dialog" role="document">    
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cambio de Contrase&ntilde;a</h5>                  
      </div>
      	<form action = "<?php echo PUERTO."://".HOST;?>/perfil/" method = "post" id="form_cambiar" name="form_cambiar">
	      <div class="modal-body">
	      	<div class="row">
		      	<div class="col-md-12">
			        <div class="col-md-6">
		                <div id="seccion_clave" class="form-group">
		                  <label class="text-center">Contrase&ntilde;a:</label><div id="err_clave" class="help-block with-errors"></div>
		                  <div class="input-group">
		                    <span class="input-group-addon show_hidden" onclick="pass_reveal(this);"><i class="fa fa-eye"></i></span>
		                    <input title="Letras y números, mínimo 8 caracteres" id="password" name="password" type="password" pattern="^(?=(?:.*\d))(?=(?:.*[a-zA-Z]))\S{8,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); if(this.checkValidity()) form.password_two.pattern = this.value;" class="form-control" onkeyup="validarClave()" >
		                  </div>
		                </div>
		            </div>
		            <div class="col-md-6">
		              <div id="seccion_clave1" class="form-group">
		                  <label class="text-center">Confirmar Contrase&ntilde;a:</label><div id="err_clave1" class="help-block with-errors"></div>
		                  <div class="input-group">
		                    <span class="input-group-addon show_hidden" onclick="pass_reveal(this);"><i class="fa fa-eye"></i></span>
		                    <input id="password_two" name="password_two" type="password" pattern="^(?=(?:.*\d))(?=(?:.*[a-zA-Z]))\S{8,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Ingrese la misma contraseña' : '');" placeholder="Verificar contraseña" class="form-control" onkeyup="validarClave()" >
		                </div>
		              </div>
		            </div> 
				</div>
			</div>
	      </div>
	      <input type="hidden" name="cambiarClave" id="cambiarClave" value="1">
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <!--<a href="" class="btn btn-success" id="btncambiar">Cambiar</a>-->
	        <input type="button" id="button_cambiar" name="btnusu" class="btn btn-success" value="Cambiar" onclick="enviarCambioClave()"> 
	      </div>
  		</form>
    </div>    
  </div>
</div>
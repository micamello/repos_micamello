<?php  

//$_SESSION['mostrar_exito'] = "";
//$_SESSION['mostrar_error'] = ""; ?>

<div class="container-fluid">
  <div class="text-center">
    <h2 class="titulo">Mi Perfil</h2>
  </div>
</div>

<?php
 if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?>
<br>
<div class="container">
	<div class="checkout-wrap">
	  <ul class="checkout-bar">
        <li class="visited">Registro</li>
        <?php if (isset($_SESSION['mfo_datos']['usuario']['infohv']) && !empty($_SESSION['mfo_datos']['usuario']['infohv'])){ ?>
          <li class="visited">Completar Perfil</li>
        <?php }else { ?>
        	<li class="active">Completar Perfil</li>
        <?php } ?>
        <?php         
        for($i=1;$i<=3;$i++){ ?>
          <?php
          	if (count($porcentaje_por_usuario) == $nrototalfacetas && $puedeDescargarInforme > 2){ 
          		$clase = "visited";
       		}else if($i <= count($porcentaje_por_usuario) && $i == 1){
       			$clase = "visited";
       		}else if($i <= count($porcentaje_por_usuario) && $i == 2){
       			$clase = "visited";
       		}else{
       			$clase = "";
       		}
          ?>
          <li class="<?php echo $clase;?>">Test <?php echo $i;?></li>                
        <?php } ?>
      </ul>
	</div>
</div>
<div class="visible-md-inline visible-lg-inline visible-sm-inline">
	<br><br><br><br><br><br>
</div>
<?php } ?>

<div class="container">
    <form role="form" name="form_editarPerfil" id="form_editarPerfil" method="post" action="<?php echo PUERTO."://".HOST;?>/perfil/" enctype="multipart/form-data">
        <div class="">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div id="seccion_img" class="recuadro-perfil panel panel-default">
                	<img id="imagen_perfil" width="100%" alt="fotoPerfil" src="<?php echo PUERTO."://".HOST."/imagenes/imgperfil/".$_SESSION['mfo_datos']['usuario']['username']."/"; ?>" style="border-radius: 20px 20px 0px 0px;">
                    <input id="file-input" type="file" name="file-input"  class="upload-photo">
                    <div class="perfil-cuadro" id="err_img" align="center">
                    	<label class="text-center" for="file-input">actualizar foto de perfil <small style="font-size: 75%">(.jpg .jpeg )</small></label>
                    </div> 
                    <!-- <br> -->
                </div>

                <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){ ?>
                	<div id="carga" style="margin: 50px 0px;" class="recuadro-perfil panel panel-default"> 	
                		<?php if($btnDescarga == 1){ ?><br>
                    		<img width="100%" alt="hoja_de_vida" src="<?php echo PUERTO."://".HOST."/imagenes/cv.png";?>" style="border-radius: 20px 20px 0px 0px;">
                    		<div class="perfil-cuadro" align="center">
		                    	<label style="cursor:pointer" class="text-center" id="hoja_de_vida">actualizar o descargar hoja de vida <br><small style="font-size: 75%">(.PDF, .doc, .docx/máx: 2mb)</small></label>
		                    </div> 
		                    <input id="subirCV" type="file" name="subirCV" class="upload-photo" accept="application/pdf,application/msword,.doc, .docx" >
                    	<?php }else{ ?><br>
                    		<img id="hoja_de_vida2" width="100%" alt="hoja_de_vida" src="<?php echo PUERTO."://".HOST."/imagenes/cv.png";?>">
		                    <input id="subirCV" type="file" name="subirCV" class="upload-photo" accept="application/pdf,application/msword,.doc, .docx">
		                    <div class="perfil-cuadro" align="center">
		                    	<label style="cursor:pointer" class="text-center" for="subirCV">Presiona aqu&iacute; para cargar tu hoja de vida (.pdf, .doc, .docx, M&Aacute;X:2M)</label>
		                    </div> 
      					<?php } ?>
                    </div>
                <?php } ?>
      
		        

				    <?php if($puedeDescargarInforme >= 2 && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){ ?>
				    	<div class="recuadro-perfil panel panel-default" style="margin: 50px 0px;"><br>
				    		<a href="<?php echo PUERTO."://".HOST."/fileGEN/informeusuario/".$_SESSION['mfo_datos']['usuario']['username'].'/';?>">
					            <img width="100%" alt="informePersonalidad" src="<?php echo PUERTO."://".HOST."/imagenes/informe.png";?>">
					            <div class="perfil-cuadro" id="err_img" align="center">
					              <label style="cursor:pointer" class="text-center" for="">acceder a informe de competencias laborales <?php if($puedeDescargarInforme >= 2 && $puedeDescargarInforme < 5){ echo 'parcial'; }else{ echo 'completo'; } ?></label>
					            </div>
				        	</a>
				        	<!--<div align="center">
							<input type="hidden" name="createchart" id="createchart" value="1"/>
							  <input type="hidden" name="hidden_div_html" id="hidden_div_html" />
							  <button type="button" name="create_pdf" id="create_pdf" class="btn btn-danger btn-xs">Create PDF</button>
							 
							</div>-->
				        </div>
					<?php } ?>

					<div style="cursor:pointer" class="recuadro-perfil panel panel-default" style="margin: 50px 0px;"><br>
			        	<a onclick="abrirModal('','cambiar_clave','','');">
				            <img width="100%" alt="cambio_clave" src="<?php echo PUERTO.'://'.HOST.'/imagenes/contra.png'; ?>">
				            <div class="perfil-cuadro" id="err_img" align="center">
				              <label style="cursor:pointer" class="text-center" for="">cambiar contraseña</label>
				            </div>
			        	</a>
			        </div>
	       	</div>                
	            <div class="col-md-9 col-sm-9 col-xs-12">
	                <div class="panel panel-default shadow">
	                    <div class="panel-body">
				            <div class="row">
				            	<div class="main_business">
	                                <div class="col-md-12">
	                                	<div class="col-md-12" align="center" style="padding-top:20px">
		                                    <div class="form-group">
		                                        <label for="username">Usuario:
		                                        	<h4 class="usuario">
		                                        	   <u><?php echo $_SESSION['mfo_datos']['usuario']['username']; ?></u>
		                                        	</h4><?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::CANDIDATO) { ?>
		                                        	<h6>RUC: <?php echo $_SESSION['mfo_datos']['usuario']['dni']; ?></h6><?php } ?>
		                                        </label>		                                        
		                                    </div>
	                                    </div>

	                                    <div class="col-md-6">
	                                        <div id="seccion_nombre" class="form-group">
	                                            <label for="nombres"><?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?> Nombres <?php }else{ ?> Nombre de la empresa<?php } ?><span title="Este campo es obligatorio" class="requerido">*</span></label><div id="err_nom" class="help-block with-errors"></div>

	                                			<input class="form-control" type="text" id="nombres" name="nombres" maxlength="100" value="<?php if(isset($data['nombres'])){ echo utf8_encode($data['nombres']); } else{ echo utf8_encode($_SESSION['mfo_datos']['usuario']['nombres']); } ?>" pattern="[a-z A-ZñÑáéíóúÁÉÍÓÚ]+"  onkeyup="validarFormulario(false)" />
	                                        </div>
	                                    </div>

	                                    <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?>
		                                    <div class="col-md-6">
		                                        <div id="seccion_apellido" class="form-group">
		                                            <label for="apellidos">Apellidos<span title="Este campo es obligatorio" class="requerido">*</span></label><div id="err_ape" class="help-block with-errors"></div>

		                                			<input class="form-control <?php echo $noautofill; ?>" type="text" id="apellidos" name="apellidos" maxlength="100" value="<?php if(isset($data['apellidos'])){ echo utf8_encode($data['apellidos']); } else{ echo utf8_encode($_SESSION['mfo_datos']['usuario']['apellidos']); } ?>" pattern='[a-z A-ZñÑáéíóúÁÉÍÓÚ]+'  onkeyup="validarFormulario(false)" <?php echo $readonly; ?>/>
		                                        </div>
		                                    </div>
	                                 
	                                    	<div class="col-md-6">
									            <div class="form-group" id="seleccione_group">
									              <label for="tipo_dni">Tipo de documento</label><div id="seleccione_error" class="help-block with-errors"></div>
									              <select class="form-control" id="documentacion" name="documentacion" <?php if($_SESSION['mfo_datos']['usuario']['tipo_doc'] == 0){ echo ''; }else{ echo 'disabled';} ?> onchange="validarFormulario(true)">
									                <option selected="" value="">Seleccione una opci&oacute;n</option>
									                <?php 
									                  $option = '';
									                  foreach(DOCUMENTACION as $key => $doc){
									                    $option .= "<option value='".$key."'";
									                	if ($_SESSION['mfo_datos']['usuario']['tipo_doc'] == $key || (isset($data['documentacion']) && $data['documentacion'] == $key))
														{ 
															$option .= " selected='selected'";
														}
														$option .= ">".utf8_encode($doc)."</option>";
													  }
													  echo $option;
									                 ?>
									              </select>
								            	</div>
								          	</div>                             
		                                    <div class="col-md-6">
			                                    <div class="form-group" id="seccion_dni">
			                                        <label id="nombre_documento" for="dni">C&eacute;dula</label><div id="err_dni" class="help-block with-errors"></div>
			                                        <input class="form-control" type="text" id="dni" name="dni" <?php if(empty($_SESSION['mfo_datos']['usuario']['dni'])){ echo ''; }else{ echo 'disabled';} ?> value="<?php if(isset($data['dni'])){ echo $data['dni']; } else if(empty($_SESSION['mfo_datos']['usuario']['dni'])){ echo ''; }else{ echo $_SESSION['mfo_datos']['usuario']['dni'];  } ?>" onkeyup="validarFormulario(true)" />
			                                    </div>
		                                    </div>
	                                	<?php }else{  ?>

	                                		<div class="col-md-6">
								                <div class="form-group" id="seccion_sector">
								                  <label>Sector industrial <span class="requerido"> *</span></label>
								                  <div id="err_sector" class="help-block with-errors"></div>
								                  <select id="sectorind" name="sectorind" class="form-control">
								                    <option value="" selected="selected" disabled="disabled">Seleccione una opción</option>
								                    <?php 
								                      if(!empty($arrsectorind)){
								                        foreach($arrsectorind as $key => $sectorind){
								                          	echo "<option value='".$sectorind['id_sectorindustrial']."'";
								                          	if ($_SESSION['mfo_datos']['usuario']['id_sectorindustrial'] == $sectorind['id_sectorindustrial'] || (isset($data['id_sectorindustrial']) && $data['id_sectorindustrial'] == $sectorind['id_sectorindustrial']))
															{ 
																echo " selected='selected'";
															}
															echo ">".utf8_encode($sectorind['descripcion'])."</option>";
								                        }
								                      }
								                    ?>
								                  </select>
								                  <div></div>
								                </div>
								            </div>

								        <?php } ?>

	                                    <div class="col-md-6">
		                                    <div class="form-group">
		                                        <label for="correo">Correo <span title="Este campo es obligatorio" class="requerido"></span></label><div class="help-block with-errors"></div>
		                                        <input class="form-control" id="correo" type="email" disabled value="<?php if(isset($data['correo'])){ echo $data['correo']; } else{ echo $_SESSION['mfo_datos']['usuario']['correo']; } ?>"/>
		                                    </div>
	                                    </div>

	                                    <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?>

		                                    <div class="col-md-6" style="height: 84px;">
		                                        <div id="seccion_gen" class="form-group">
		                                            <label for="genero">G&eacute;nero <span title="Este campo es obligatorio" class="requerido">*</span></label><div id="err_gen" class="help-block with-errors"></div>
		                                            <select id="genero" name="genero" class="form-control"  onchange="validarFormulario(false)" >
														<option disabled value="0">Seleccione un genero</option>
				                                    	<?php 
				                                    	foreach($genero as $key => $ge){ 
															echo "<option value='".$ge['id_genero']."'";
															if ($_SESSION['mfo_datos']['usuario']['id_genero'] == $ge['id_genero'] || (isset($data['id_genero']) && $data['id_genero'] == $ge['id_genero']))
															{ 
																echo " selected='selected'";
															}
															echo ">".$ge['descripcion']."</option>";
														} ?>
		                                            </select>
		                                        </div>
			                                </div>
			                                <div class="clearfix"></div>
			                                <div class="col-md-6">
			                                    <div id="mayoria" class="form-group">
			                                        <label for="mayor_edad">Fecha de Nacimiento<span title="Este campo es obligatorio" class="requerido">*</span></label><div id="error" class="help-block with-errors"></div>
			                                         <input type="text" data-field="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" max="<?php echo date('Y-m-d'); ?>" placeholder="aaaa-mm-dd" value="<?php if(isset($data['fecha_nacimiento'])){ echo $data['fecha_nacimiento']; } else{ echo date('Y-m-d',strtotime($_SESSION['mfo_datos']['usuario']['fecha_nacimiento'])); } ?>" onchange="validarFormulario(false)">
			                                         <div id="fecha"></div>
			                                    </div>
		                                    </div>

		                                <?php }else{ ?>

		                                	<div class="col-md-6">
			                                    <div class="form-group" id="seccion_pag" >
			                                        <label for="pagina_web">P&aacute;gina Web <span id="opcional">(www.micamello.com.ec)</span></label><div id="err_pag" class="help-block with-errors"></div>
			                                        <input class="form-control" id="pagina_web" name="pagina_web" type="text" value="<?php if(isset($data['pagina_web'])){ echo $data['pagina_web']; } else{ echo $_SESSION['mfo_datos']['usuario']['pagina_web']; } ?>" onkeyup="validarFormulario(false)" placeholder="www.micamello.com.ec"/>
			                                    </div>
		                                    </div>

		                                <?php } ?>

	                                    <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?>

	                                    	<div class="col-md-6">
											    <div id="seccion_tlf" class="form-group">
											        <label for="telefono">Celular <span title="Este campo es obligatorio" class="requerido">*</span></label><div id="err_tlf" class="help-block with-errors"></div>
											        <input class="form-control <?php echo $noautofill; ?>" type="text" id="telefono" name="telefono" minlength="10" maxlength="15" pattern='[0-9]+' onkeydown="return validaNumeros(event)" value="<?php if(isset($data['telefono'])){ echo $data['telefono']; } else{ echo $_SESSION['mfo_datos']['usuario']['telefono']; } ?>"  onkeyup="validarFormulario(false)" <?php echo $readonly; ?>/>
											    </div>
											</div>         

										<?php } ?>

	                                    <div class="col-md-6">
		                                    <div id="seccion_nac" class="form-group">
	                                            <label for="nacionalidad"><?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?> Nacionalidad <?php }else{ ?> Pais <?php } ?> <span title="Este campo es obligatorio" class="requerido">*</span></label><div id="err_nac" class="help-block with-errors"></div>
	                                            <select class="form-control" name="id_nacionalidad" id="id_nacionalidad"  onchange="validarFormulario(false)" >
	                                            	<option disabled value="0">Seleccione su opci&oacute;n</option>
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

	                                   
										<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) { ?>

											<div class="col-md-6">
											    <div id="seccion_nro" class="form-group">
											        <label for="nro_trabajadores">N&uacute;mero de Trabajadores <span title="Este campo es obligatorio" class="requerido">*</span></label><div id="err_nro" class="help-block with-errors"></div>
											        <select id="nro_trabajadores" name="nro_trabajadores" class="form-control"  onchange="validarFormulario(false)" >
				                                    	<option disabled selected value="0">Seleccione una opci&oacute;n</option>
				                                    	<?php 
				                                    	foreach(NRO_TRABAJADORES as $key => $r){ 
															echo "<option value='$key'";
															if ($_SESSION['mfo_datos']['usuario']['nro_trabajadores'] == $key || (isset($data['nro_trabajadores']) && $data['nro_trabajadores'] == $key))
															{ 
																echo " selected='selected'";
															}
															echo ">$r</option>";
														} ?>
													</select>
											    </div>
											</div>

											<div class="col-md-4">
											    <div id="seccion_tlf" class="form-group">
											        <label for="telefono">Tel&eacute;fono <span title="Este campo es obligatorio" class="requerido">*</span></label><div id="err_tlf" class="help-block with-errors"></div>
											        <input class="form-control <?php echo $noautofill; ?>" type="text" id="telefono" name="telefono" minlength="9" maxlength="15" pattern='[0-9]+' onkeydown="return validaNumeros(event)" value="<?php if(isset($data['telefono'])){ echo $data['telefono']; } else{ echo $_SESSION['mfo_datos']['usuario']['telefono']; } ?>"  onkeyup="validarFormulario(false)" <?php echo $readonly; ?>/>
											    </div>
											</div>

										<?php }  ?>
	                                    
	                                    <div class="col-md-<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { echo '6'; }else{ echo '4'; } ?>">
	                                        <div id="seccion_provincia" class="form-group">
	                                            <label for="provincia">Provincia<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?> de Residencia <?php } ?><span title="Este campo es obligatorio" class="requerido">*</span></label><div id="err_prov" class="help-block with-errors"></div>
	                                            <select class="form-control" name="provincia" id="provincia"  onchange="validarFormulario(false)" >
	                                            	<option disabled value="0">Seleccione una provincia</option>
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

	                                    <div class="col-md-<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { echo '6'; }else{ echo '4'; } ?>">
	                                        <div id="seccion_ciudad" class="form-group">
	                                            <label for="ciudad">Ciudad<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?> de Residencia <?php } ?><span title="Este campo es obligatorio" class="requerido">*</span></label><div id="err_ciu" class="help-block with-errors"></div>
	                                            <select id="ciudad" name="ciudad" class="form-control"  onchange="validarFormulario(false)" >
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
													<option disabled value="0">Selecciona una ciudad</option>
	                                            <?php } ?>
	                                            </select>
	                                        </div>
	                                    </div>					

	                    				
	                                    <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?>

	                                    	<div class="col-md-6">
											    <div id="seccion_tlfCon" class="form-group">
											        <label for="convencional">Tel&eacute;fono Convencional <span title="Este campo es obligatorio" class="requerido"></span><span id="opcional">(opcional)</span></label><div id="err_tlfCon" class="help-block with-errors"></div>
											        <input class="form-control <?php echo $noautofill; ?>" type="text" id="convencional" name="convencional" minlength="9" maxlength="9" pattern='[0-9]+' onkeydown="return validaNumeros(event)" value="<?php if(isset($data['convencional'])){ echo $data['convencional']; } else{ echo $_SESSION['mfo_datos']['usuario']['tlf_convencional']; } ?>"  onkeyup="validarFormulario(false)" <?php echo $readonly; ?>/>
											    </div>
											</div>

											<div class="col-md-6">
		                                    	<div id="seccion_civil" class="form-group">
			                                    	<label for="estado_civil">Estado civil <span title="Este campo es obligatorio" class="requerido">*</span></label><div id="err_civil" class="help-block with-errors"></div>
				                                    <select id="estado_civil" name="estado_civil" class="form-control"  onchange="validarFormulario()" >
				                                    	<option disabled value="0">Seleccione una opci&oacute;n</option>
				                                    	<?php 
				                                    	foreach($estado_civil as $key => $e){ 
															echo "<option value='".$e['id_estadocivil']."'";
															if ($_SESSION['mfo_datos']['usuario']['id_estadocivil'] == $e['id_estadocivil'] || (isset($data['id_estadocivil']) && $data['id_estadocivil'] == $e['id_estadocivil']))
															{ 
																echo " selected='selected'";
															}
															echo ">".utf8_encode($e['descripcion'])."</option>";
														} ?>
													</select>
												</div>
											</div>

											<div class="col-md-6">
		                                    	<div id="seccion_trab" class="form-group">
			                                    	<label for="tiene_trabajo">Situaci&oacute;n Laboral <span title="Este campo es obligatorio" class="requerido">*</span></label><div id="err_trab" class="help-block with-errors"></div>
				                                    <select id="tiene_trabajo" name="tiene_trabajo" class="form-control"  onchange="validarFormulario(false)" >
				                                    	<option disabled value="0">Seleccione una opci&oacute;n</option>
				                                    	<?php 
				                                    	foreach($situacionLaboral as $key => $r){ 
															echo "<option value='".$key."'";
															if ($_SESSION['mfo_datos']['usuario']['id_situacionlaboral'] == $key || (isset($data['id_situacionlaboral']) && $data['id_situacionlaboral'] == $key))
															{ 
																echo " selected='selected'";
															}
															echo ">".utf8_encode($r)."</option>";
														} ?>
													</select>
												</div>
											</div>
		                                    
		                                    <div class="col-md-6" data-placement="left" data-toggle="tooltip" data-html="true" data-original-title="<i class='fa fa-info-circle fa-2x'></i><br/><p>Esta informaci&oacute;n ser&aacute; tomada en cuenta para sus <a href='<?php echo PUERTO."://".HOST;?>/preguntasFrecuentes/'>autopostulaciones</a>. </p>">
		                                    	<div id="seccion_res" class="form-group">
			                                    	<label for="residencia">&#191;Puede cambiar de residencia&#63; <span title="Este campo es obligatorio" class="requerido">*</span></label><div id="err_res" class="help-block with-errors"></div>
				                                    <select id="residencia" name="residencia" class="form-control"  onchange="validarFormulario(false)" >
				                                    	<option disabled value="0">Seleccione una opci&oacute;n</option>
				                                    	<?php 
				                                    	foreach(REQUISITO as $key => $r){ 
															echo "<option value='$key'";
															if ($_SESSION['mfo_datos']['usuario']['residencia'] == $key || (isset($data['residencia']) && $data['residencia'] == $key))
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
			                                    	<label for="licencia">Tipo de Licencia <span title="Este campo es obligatorio" class="requerido">*</span></label><div id="err_lic" class="help-block with-errors"></div>
				                                    <select id="licencia" name="licencia" class="form-control"  onchange="validarFormulario(false)" >
				                                    	<option selected value="0">No poseo</option>
				                                    	<?php 
				                                    	
				                                    	foreach($licencia as $key => $r){ 
															echo "<option value='".$key."'";
															if ($_SESSION['mfo_datos']['usuario']['id_tipolicencia'] == $key || (isset($data['id_tipolicencia']) && $data['id_tipolicencia'] == $key))
															{ 
																echo " selected='selected'";
															}
															echo ">".$r."</option>";
														} ?>
													</select>
												</div>
											</div>

											<div class="col-md-6" data-placement="left" data-toggle="tooltip" data-html="true" data-original-title="<i class='fa fa-info-circle fa-2x'></i><br/><p>Esta informaci&oacute;n ser&aacute; tomada en cuenta para sus <a href='<?php echo PUERTO."://".HOST;?>/preguntasFrecuentes/'>autopostulaciones</a>. </p>">
		                                    	<div id="seccion_via" class="form-group">
			                                    	<label for="viajar">&#191;Puede viajar&#63; <span title="Este campo es obligatorio" class="requerido">*</span></label><div id="err_via" class="help-block with-errors"></div>
				                                    <select id="viajar" name="viajar" class="form-control"  onchange="validarFormulario(false)" >
				                                    	<option disabled value="0">Seleccione una opci&oacute;n</option>
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
		                                    	<div id="seccion_dis" class="form-group">
			                                    	<label for="discapacidad">Discapacidad <span title="Este campo es obligatorio" class="requerido">*</span></label><div id="err_dis" class="help-block with-errors"></div>
				                                    <select id="discapacidad" name="discapacidad" class="form-control"  onchange="validarFormulario(false)" >
				                                    	<option disabled value="-1">Tiene alguna discapacidad&#63;</option>
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

		                                    <div class="col-md-12" >
		                                        <div id="seccion_esc" class="form-group">
		                                            <label for="escolaridad">&Uacute;ltimo estudio realizado <span title="Este campo es obligatorio" class="requerido">*</span></label><div id="err_esc" class="help-block with-errors"></div>
		                                            <select id="escolaridad" name="escolaridad" class="form-control" onchange="ocultarCampos(); validarFormulario(false);"style="padding-left: 0px;"  >
		                                            	<option disabled value="0">Seleccione una opci&oacute;n</option>
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

											<div class="col-md-6 depende" hidden>
		                                        <div id="seccion_estudio" class="form-group">
		                                            <label for="lugar_estudio">&#191;Estudi&oacute; en el extranjero&#63; <span title="Este campo es obligatorio" class="requerido">*</span></label><div id="err_estudio" class="help-block with-errors"></div>
		                                            <select class="form-control" id="lugar_estudio" name="lugar_estudio" onchange='mostrarUni(); validarFormulario(false);'  >
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
		                                            <label for="universidad">Universidad <span title="Este campo es obligatorio" class="requerido">*</span></label><div id="err_univ" class="help-block with-errors"></div>
		                                            <select class="form-control" id="universidad" name="universidad"  onchange="validarFormulario(false)" >
		                                            	<option disabled selected value="0">Seleccione su opci&oacute;n</option>
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
													<input type="text" name="universidad2" id="universidad2" maxlength="100" class="form-control"   pattern="[a-z A-ZñÑáéíóúÁÉÍÓÚ.]+" style="display:none" onkeyup="validarFormulario(false)" value="<?php if(isset($data['universidad2'])){ echo $data['universidad2']; } else{ if($_SESSION['mfo_datos']['usuario']['nombre_univ'] != ' '){ echo $_SESSION['mfo_datos']['usuario']['nombre_univ']; } } ?>">
		                                        </div>
		                                    </div>

		                                    <div class="col-md-12 col-sm-12 col-lg-6" data-placement="left" data-toggle="tooltip" data-html="true" data-original-title="<i class='fa fa-info-circle fa-2x'></i><br/><p>Esta informaci&oacute;n ser&aacute; tomada en cuenta para sus <a href='<?php echo PUERTO."://".HOST;?>/preguntasFrecuentes/'>autopostulaciones</a>. </p>">
												<div class="form-group" id="seccion_area">
													<label style="font-size: 13px;">&Aacute;reas de Inter&eacute;s. Consiga mejores resultados de empleo, seleccionando <b class="requerido">máximo numero áreas</b> de su inter&eacute;s<span title="Este campo es obligatorio" class="requerido"> *</span></label>											
													<div id="err_area" class="help-block with-errors"></div>

													<select class="form-control" id="area" name="area[]" multiple="multiple">
													  <!-- <option value="">Seleccione una opción</option> -->
													  <?php 
													  $i = 0;
													    if(!empty($areas) && is_array($areas)){
													      foreach ($areas as $area) {
																$selected = '';
													        if($i != $area['id_area']){

													        	if(isset($data['areaxusuario']) && array_key_exists($area['id_area'], $data['areaxusuario'])){
													        		$selected = "selected='selected'";
													        	}else if(!isset($data['areaxusuario']) && isset($_SESSION['mfo_datos']['usuario']['usuarioxarea']) && array_key_exists($area['id_area'], $_SESSION['mfo_datos']['usuario']['usuarioxarea'])){
													        		$selected = "selected='selected'";
													        	}
													          	echo "<option ".$selected." value='".$area['id_area']."'>".utf8_encode($area['nombre_area'])."</option>";
													          	$i = $area['id_area'];
													        }
													      }
													    }
													   ?>
													</select>
												</div>
											</div>

											<div class="col-md-12 col-sm-12 col-lg-6">
												<div class="form-group">
													<label style="font-size: 13px;">Sub-Áreas <span title="Este campo es obligatorio" class="requerido">*</span></label>
													<div class="hidden-xs hidden-sm">
														<div style="padding-top: 17px;"></div>
													</div>
													<div class="help-block with-errors"></div>
													<select class="form-control" id="subareas" name="subareas[]" multiple="multiple" onchange="validarFormulario(false);">
													  <?php 													  
													    if(!empty($areas) && is_array($areas)){
													      foreach ($areas as $area) {
													      	$selected = '';

												        	if(isset($data['areaxusuario']) && array_key_exists($area['id_area'], $data['areaxusuario']) && in_array($area['id_subareas'], $data['areaxusuario'][$area['id_area']])){
												        		$selected = "selected='selected'";
												        	}else if(!isset($data['areaxusuario']) && is_array($_SESSION['mfo_datos']['usuario']['usuarioxarea']) && isset($_SESSION['mfo_datos']['usuario']['usuarioxarea'][$area['id_area']]) && !empty($_SESSION['mfo_datos']['usuario']['usuarioxarea']) && in_array($area['id_subareas'], $_SESSION['mfo_datos']['usuario']['usuarioxarea'][$area['id_area']])){
												        		$selected = "selected='selected'";
												        	}
												          echo "<option ".$selected." value='".$area['id_area']."_".$area['id_subareas']."_".$area['id_areas_subareas']."'>".utf8_encode($area['nombre_subarea'])."</option>";
													      }
													    }
													   ?>
													</select>
												</div>
											</div>

		                                    <div class="clearfix"></div>
		
		                                    <div class="col-md-4 col-md-offset-2">
												<div class="form-group">
													<label>Idioma: </label><div class="help-block with-errors"></div>
													<select id="idioma_of" name="idioma_of" class="form-control" <?php if(count($arridioma) == count($nivelIdiomas)){ echo 'disabled=disabled'; } ?> >
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
													<select id="nivel_idi_of" name="nivel_idi_of" class="form-control" <?php if(count($arridioma) == count($nivelIdiomas)){ echo 'disabled=disabled'; } ?>>
														<option value="0">Seleccione una opci&oacute;n</option>
														<?php if (!empty($arrnivelidioma)){
															foreach ($arrnivelidioma as $nivelidioma) {?>
																<option value="<?php echo $nivelidioma['id_nivelIdioma'] ?>"><?php echo utf8_encode($nivelidioma['nombre']) ?></option>
														<?php }
														} ?>
													</select>
												</div>
											</div>

											<!-- <div class="col-md-2">
												<div class="form-group" id="effect_bounce">
													<a id="btn_transfer" class="button_transfer_list"><i class="fa fa-plus"></i> Añadir idioma</a>
												</div>
											</div> -->
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
																						//if($btnSig != 1){
																							echo 'onclick="delete_item_selected(this); validarFormulario(false);"';
																						//}
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
																		//if($btnSig != 1){
																			echo 'onclick="delete_item_selected(this); validarFormulario(false);"';
																		//}
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

					            <!--<hr width="100%" />-->
					            <div class="col-md-12"><hr></div>
	                    <div class="form-group col-md-12">
												<div class="col-md-12" align="center"><h4><b>Datos de contacto</b></h4></div>

								           	 	<!-- Empresas contacto -->
									            <div class="col-md-6" id="group_nombre_contact">
									              <div id="seccion_nomCon" class="form-group">
									                <label class="text-center">Nombres</label><span title="Este campo es obligatorio" class="requerido">*</span><div id="err_nomCon" class="help-block with-errors"></div>

									                <input type="text" name="nombre_contact" id="nombre_contact" maxlength="100" value="<?php echo (isset($data['nombres_contacto'])) ? utf8_encode($data['nombres_contacto']) : utf8_encode($_SESSION['mfo_datos']['usuario']['nombres_contacto']); ?>" pattern='[a-z A-ZñÑáéíóúÁÉÍÓÚ]+' placeholder="Ejemplo: Juan David" class="form-control" onkeyup="validarFormulario(false)"  <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) { echo ''; } ?> >
									              </div>
									            </div>  

									            <div class="col-md-6" id="group_apell_contact">
									              <div id="seccion_apeCon" class="form-group">
									                <label class="text-center">Apellidos</label><span title="Este campo es obligatorio" class="requerido">*</span><div id="err_apeCon" class="help-block with-errors"></div>

									                <input type="text" name="apellido_contact" id="apellido_contact" maxlength="100" value="<?php echo (isset($data['apellidos_contacto'])) ? utf8_encode($data['apellidos_contacto']) : utf8_encode($_SESSION['mfo_datos']['usuario']['apellidos_contacto']); ?>" pattern='[a-z A-ZñÑáéíóúÁÉÍÓÚ]+' placeholder="Ejemplo: Ortíz Zambrano" class="form-control" onkeyup="validarFormulario(false)"  <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) { echo ''; } ?>>
									              </div>
									            </div> 

									            <div class="col-md-4" id="group_num1_contact">
									              <div id="seccion_tlfCel" class="form-group">
									                <label class="text-center">Celular</label><span title="Este campo es obligatorio" class="requerido">*</span><div id="err_tlfCel" class="help-block with-errors"></div>

									                <input type="text" name="tel_one_contact" id="tel_one_contact" minlength="6" maxlength="15" value="<?php echo (isset($data['tel_one_contact'])) ? $data['tel_one_contact'] : $_SESSION['mfo_datos']['usuario']['telefono1']; ?>" <?php echo $readonly; ?> class="form-control <?php echo $noautofill; ?>" pattern='[0-9]+' onkeyup="validarFormulario(false)" onkeydown="return validaNumeros(event)"  <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) { echo ''; } ?>>
									              </div>
									            </div> 

									            <div class="col-md-4" id="group_num2_contact">
									              <div id="seccion_tlfCon2" class="form-group">
									                <label class="text-center">Convencional <span id="opcional">(opcional)</span></label><div id="err_tlfCon2" class="help-block with-errors"></div>

									                <input type="text" name="tel_two_contact" id="tel_two_contact" minlength="9" maxlength="9" value="<?php echo (isset($data['tel_two_contact'])) ? $data['tel_two_contact'] : $_SESSION['mfo_datos']['usuario']['telefono2']; ?>" onkeyup="validarFormulario(false)" class="form-control <?php echo $noautofill; ?>" <?php echo $readonly; ?> pattern='[0-9]+' onkeydown="return validaNumeros(event)" <?php /*if($btnSig == 1){ echo 'disabled'; }*/ ?>>
									              </div>
									            </div> 

									            <div class="col-md-4">
									              <div id="seccion_cargo" class="form-group">
									                <label class="text-center">Cargo</label><div id="err_cargo" class="help-block with-errors"></div>
									                <select id="cargo" name="cargo" class="form-control" onchange="validarFormulario(false);"style="padding-left: 0px;"  >
		                                            	<option disabled selected value="0">Seleccione una opci&oacute;n</option>
														<?php 
														if (!empty($cargo)){
					                                    	foreach($cargo as $key => $c){ 
																echo "<option value='".$c['id_cargo']."'";
																if ($_SESSION['mfo_datos']['usuario']['id_cargo'] == $c['id_cargo'] || (isset($data['cargo']) && $data['cargo'] == $c['id_cargo']))
																{ 
																	echo " selected='selected'";
																}
																echo ">".utf8_encode($c['descripcion'])."</option>";
															}
														} ?>
													</select>
									              </div>
									            </div> 

									        </div>
								        <?php } ?>
	                            	</div>
		                            <input type="hidden" name="actualizar" id="actualizar" value="1">
		                            <input type="hidden" name="tipo_usuario" id="tipo_usuario" value="<?php echo $_SESSION['mfo_datos']['usuario']['tipo_usuario']; ?>">
		                            <input type="hidden" name="btnDescarga" id="btnDescarga" value="<?php echo $btnDescarga; ?>">

					                <div align="center">
					                	<input type="button" id="boton" name="" class="btn-blue" value="GUARDAR">
										<?php if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { ?>
											<a href="<?php echo PUERTO."://".HOST;?>/cuestionario/" class="btn-light-blue btnPerfil <?php if($btnSig == 0){ echo ''; } ?>" <?php if($btnSig == 0){ echo ''; } ?>>SIGUIENTE</a>
										<?php }else{ 	?>
											<a href="<?php echo PUERTO."://".HOST;?>/publicar/" class="btn-light-blue btnPerfil <?php if($btnSig == 0){ echo ''; } ?>" <?php if($btnSig == 0){ echo ''; } ?>>PUBLICAR OFERTA</a>
									    <?php } ?>
									    <div  style="padding: 10px 0px">
									    	<span class="help-block">En este formulario los campos con (<i>*</i>) son obligatorios</span>
										</div>
									</div>
				            	</div>  
			            	</div>   
			        	</div>
			    	</div>
		    	</div> 
		    </div>
		</div>
	</form>
</div>

<!--grafico para informe-->
<input style="display:none" type="text" id="datosGrafico" value="<?php echo (!empty($val_grafico)) ? $val_grafico : ""; ?>" />
<div class="container" id="Chart_details">
  <!--<div id='chart_div'></div>--><div id='g_chart_1' style="width: auto; height: auto;"></div>
</div>

<section class=" banner-publicidad">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="banner-light col-md-8">¡Planes que se adecuan a tus necesidades!</div>
        <button class="btn-minimalista col-md-2"><a href="<?php echo PUERTO."://".HOST;?>/planes/">Ver Planes</a></button>        
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="cambiar_clave" tabindex="-1" role="dialog" aria-labelledby="cambiar_clave" aria-hidden="true">
  <div class="modal-dialog" role="document">    
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="titulo-modal-hoja modal-title">Cambio de Contrase&ntilde;a</h5>                  
      </div>
      	<form action = "<?php echo PUERTO."://".HOST;?>/perfil/" method = "post" id="form_cambiar" name="form_cambiar">
	      <div class="modal-body">
	      	<div class="row">
		      	<div class="col-md-12">
			        <div class="col-md-6">
		                <div id="seccion_clave" class="form-group">
		                  <label class="text-center">Contrase&ntilde;a <span title="Este campo es obligatorio" class="requerido">*</span></label><div id="err_clave" class="help-block with-errors"></div>
		                  <div class="input-group">
		                    <span class="input-group-addon show_hidden" onclick="pass_reveal(this);"><i class="fa fa-eye"></i></span>
		                    <input title="Letras y números, mínimo 8 caracteres" id="password" name="password" type="password" pattern="^(?=(?:.*\d))(?=(?:.*[a-zA-Z]))\S{8,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); if(this.checkValidity()) form.password_two.pattern = this.value;" class="form-control <?php echo $noautofill; ?>" onkeyup="validarClave()" <?php echo $readonly; ?>>
		                  </div>
		                </div>
		            </div>
		            <div class="col-md-6">
		              <div id="seccion_clave1" class="form-group">
		                  <label class="text-center">Confirmar Contrase&ntilde;a <span title="Este campo es obligatorio" class="requerido">*</span></label><div id="err_clave1" class="help-block with-errors"></div>
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
	      <div class="modal-footer" style="text-align: center !important;">
	        <button type="button" class="btn-red" id="btn-rojo" data-dismiss="modal">Cancelar</button>
			<input type="button" id="button_cambiar" name="button_cambiar" class="btn-light-blue" style="line-height: inherit" value="Cambiar">
	      </div>
  		</form>
    </div>    
  </div>
</div>

<div class="modal fade" id="modal_actualizar" tabindex="-1" role="dialog" aria-labelledby="modal_actualizar" aria-hidden="true">
  <div class="modal-dialog" role="document">    
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="titulo-modal-hoja modal-title" id="exampleModalLongTitle">Hoja de Vida
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        	</button> 
        </h5>                 
      </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-12">
                <p>Puede actualizar o descargar su hoja de vida. Recuerde solo aceptamos formato .pdf, .doc, .docx, y m&aacute;ximo hasta 2MB </p>
                <?php #if($btnDescarga != 1){ //echo '<p id="mensaje_error_hv" class="parpadea" style="font-size:16px;color:red;font-weight:bold;">Cargar la hoja de vida es obligatorio *</p>'; } ?>
              </div>
            </div>
          </div>
        </div>
        <input type="hidden" name="cambiarHv" id="cambiarHv" value="1">
        <div class="modal-footer" style="text-align: center !important;">
        	
        	<label class="btn-blue text-center" for="subirCV" style="cursor:pointer">actualizar</label>
      		<input type="hidden" name="" id="btnDescargarHV" value="<?php echo $_SESSION['mfo_datos']['usuario']['infohv']; ?>">
      		<a href="<?php echo $ruta_arch; ?>" class="btn-blue">descargar</a>
        </div>
    </div>    
  </div>
</div>﻿
<div class="container"> 
	<?php  
	if(isset($filtro) && $vista == 'oferta'){ ?>
		<div class="alert alert-warning col-md-12"> 
			<form role="form" name="filtro" id="filtro" method="post" action="<?php echo PUERTO.'://'.HOST.'/'.$vista.'/'; ?>">
			<?php if($filtro == 1){ ?>
				<h6><b>Las ofertas aqu&iacute; presentadas estan filtradas por las siguientes caracteristicas:</b></h6>

				<?php if(isset($_SESSION['mfo_datos']['usuario']['usuarioxarea'])){
					echo '<br><b>&Aacute;reas y sub&aacute;reas de inter&eacute;s: </b>';
					$areas = '';
					foreach ($areas_subareas as $key => $value) {

						$areas.='<br>- <b>'.utf8_encode($value['area']).'</b> -->'.utf8_encode($value['subareas']);
					}
					echo $areas.'<br>';
				} ?>

				<?php if(isset($_SESSION['mfo_datos']['usuario']['residencia']) && $_SESSION['mfo_datos']['usuario']['residencia'] == 1){
					echo '<br><b>Cambio de Residencia:</b> SI';
		         
		        }else{ 
		        	echo '<br><b>Cambio de Residencia:</b> NO';
		         } ?>

		         
				<br><br>Si desea ver todas las ofertas sin filtro --> <a style="cursor:pointer" class="Button"  onclick="document.forms['filtro'].submit()"><b>Presione aquí</b></a>
				
			<?php }else{ ?>
				Si desea ver las ofertas con los filtros configurados en su cuenta --> <a style="cursor:pointer" class="Button"  onclick="document.forms['filtro'].submit()"> <b>Presione aquí</b></a>
				
			<?php } ?>
				<input type="hidden" name="filtro" id="filtro" value="<?php echo $filtro; ?>">
			</form>
		</div>
	<?php } ?>
	<div class="col-md-12"> 
		<?php if (trim($vista) == 'oferta' && isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'autopostulacion')) { ?> 
			<div class="col-md-12" align="right" > 
				<b>Autopostulaciones restantes: 
				  <span class="parpadea" style="color:red">
				    <?php echo $autopostulaciones_restantes['p_restantes']; ?>					
				  </span>
			  </b> 
			</div><br>
		<?php }else{ echo isset($enlaceCompraPlan) ? $enlaceCompraPlan : ''; ?> <?php } ?> 
	</div> 
</div>

<div class="container">
	<div class="col-md-12">

	  	<div class="col-md-4 visible-md-inline visible-lg-inline">
	  		<b>
				<span style="font-size: 18px;"><i class="fa fa-filter"></i>Filtros</span>
			</b>
			<br/><br/>
			<div class="panel panel-default shadow-panel1">
				<div class="panel-heading">
				    <span><i class="fa fa-key"></i> Palabra Clave</span>
				</div>
				<div class="panel-body">
					<div class="filtros">
						<div class="form-group">
						    <div class="input-group">
							    <input type="text" maxlength="30" class="form-control" id="inputGroup" aria-describedby="inputGroup" onkeypress="return check(event)" placeholder="Ej: Enfermero(a) &oacute; xx-xx-xxxx"> 
							    <?php 
								    $ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/';
								?>
							    <span class="input-group-addon">
							    	<a href="#" onclick="enviarPclave('<?php echo $ruta; ?>','1','1')"><i class="fa fa-search"></i>
							    	</a>
							    </span>
						    </div>
						</div>			    
					</div>
				</div>
		    </div>
		    <?php if($vista == 'cuentas'){ ?>
		    <div class="panel panel-default shadow-panel1">
				<div class="panel-heading">
					<span><i class="fa fa-list-ul"></i> Subempresas</span>
				</div>
				<div class="panel-body">
					<div class="filtros">
				<?php
				if (!empty($array_empresas_hijas)) { 
				    foreach ($array_empresas_hijas as $key => $v) {
				    	$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/S'.$key.'/';
						echo '<li class="lista"><a href="'.$ruta.'1/" class="cuentas" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
					}
				}
				?></div>
				</div>
		    </div>
			<?php } ?>
		    <div class="panel panel-default shadow-panel1">
				<div class="panel-heading">
					<span><i class="fa fa-list-ul"></i> &Aacute;reas de Inter&eacute;s</span>
				</div>
				<div class="panel-body">
					<div class="filtros">
				<?php
				if (!empty($arrarea)) { 
				    foreach ($arrarea as $key => $v) {
				    	$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/A'.$key.'/';
						echo '<li class="lista"><a href="'.$ruta.'1/" class="area" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
					}
				}
				?></div>
				</div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
				<div class="panel-heading">
					<span><i class="fa fa-map"></i> Provincias</span>
				</div>
				<div class="panel-body">
					<div class="filtros">
				<?php
					if (!empty($arrprovincia)) {
					    foreach ($arrprovincia as $key => $v) {
					    	$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/P'.$key.'/';
							echo '<li class="lista"><a href="'.$ruta.'1/" class="provincia" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
						}
					}
				?>
					</div>
				</div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
	            <div class="panel-heading">
	              <span><i class="fa fa-clock-o"></i> Jornada</span>
	            </div>
	            <div class="panel-body">
	          		<div class="filtros">
					<?php
						if (!empty($jornadas)) {
						    foreach ($jornadas as $key => $v) {
						    	$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/J'.$key.'/';
								echo '<li class="lista"><a href="'.$ruta.'1/" class="jornada" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
							}
						}
					?>
	         		</div>
	    		</div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
	            <div class="panel-heading">
	              <span><i class="fa fa-dollar"></i> Salario</span>
	            </div>
	            <div class="panel-body">
	          		<div class="filtros">
					<?php
						if (!empty(SALARIO)) {
						    foreach (SALARIO as $key => $v) {
						    	$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/K'.$key.'/';
								echo '<li class="lista"><a href="'.$ruta.'1/" class="salario" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
							}
						}
					?>
	         		</div>
	    		</div>
		    </div>
		</div>
		
		<div class="col-md-12 hidden-md hidden-lg">
			<form role="form" name="form1" id="filtros" method="post" action="<?php echo PUERTO."://".HOST;?>//">
				<div class="panel panel-default shadow" style="border-radius: 5px;">
					<div class="panel-heading" style="cursor:pointer" data-toggle="collapse" data-target="#contenedor"><i class="fa fa-angle-down"></i>Filtros</div>
	                <div class="panel-body collapse" id="contenedor">
	                	<div class="form-group">
							<input type="text" maxlength="30" class="form-control" id="inputGroup1" placeholder="Ej: Enfermero(a) &oacute; xx-xx-xxxx"> 
						</div>
	                	<div class="form-group">
	                		<?php 
	                			$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/'; 
	                		?>
				            <select id="categorias" class="form-control">
				                <option value="0">Seleccione un &aacute;rea de inter&eacute;s</option>
				                <?php
									foreach ($arrarea as $key => $v) {
										echo '<option value="'.$key.'">'.utf8_encode(ucfirst(strtolower($v))).'</option>';
									}
								?>                    
				            </select>
				        </div>
				        <div class="form-group">
				            <select id="provincia" class="form-control">
				                <option value="0">Seleccione una provincia</option>
				                <?php
									foreach ($arrprovincia as $key => $v) {
										echo '<option value="'.$key.'">'.utf8_encode(ucfirst(strtolower($v))).'</option>';
									}
								?>                    
				            </select>
				        </div>
				        <div class="form-group">
				            <select id="jornada" class="form-control">
				                <option value="0">Seleccione un jornada</option>
				                <?php
									foreach ($jornadas as $key => $v) {
										echo '<option value="'.$key.'">'.utf8_encode(ucfirst(strtolower($v))).'</option>';
									}
								?>                    
				            </select>
				        </div>
				        <div class="form-group">
				            <select id="salario" class="form-control">
				                <option value="0">Seleccione un salario</option>
				                <?php
									foreach (SALARIO as $key => $v) {
										echo '<option value="'.$key.'">'.utf8_encode(ucfirst(strtolower($v))).'</option>';
									}
								?>  
				            </select>
				        </div>
				        <div class="form-group">
							<a class="btn btn-md btn-info" onclick="obtenerFiltro('<?php echo $ruta; ?>','1')">
								Buscar
						    </a>
	                	</div>	
			        </div>
			    </div>
			</form>
		</div>

		
			
		
		<div class="col-md-8">
			<b>
				<span style="font-size: 18px;"><?php echo $breadcrumbs[$vista]; ?></span>
			</b>
			<br/><br/>
			<div id="busquedas" class='container-fluid'>
				<?php if (isset($link)) { 
				 echo $link; 
				} ?>
			</div>
			<div class="table-responsive">
	        	<table class="table table-hover">
	        		<thead>
				      <tr>
						<th colspan="2" class="text-center"></th>
				        <th class="text-center">
							<?php 
								$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/O1'.$_SESSION['mfo_datos']['Filtrar_ofertas']['O'].'/';
							?>
				           <a href="<?php echo $ruta.'1/'; ?>">Salario <i class="fa fa-sort"></i></a>
				        </th>
				        <th class="text-center">
							<?php 
								$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/O2'.$_SESSION['mfo_datos']['Filtrar_ofertas']['O'].'/';
							?>
				           <a href="<?php echo $ruta.'1/'; ?>">Fecha <i class="fa fa-sort"></i></a>
				        </th>
				        <th colspan="2" class="text-center"></th>
				      </tr>
				    </thead>
				</table>
			</div>
	        <div id="result">
	        	<?php 
	        	if(!empty($ofertas) && $ofertas[0]['id_ofertas'] != ''){
		            foreach($ofertas as $key => $o){ 

		            	$datos_plan = Modelo_Oferta::obtenerPlanOferta($o['id_ofertas']);
                   		$id_plan = $datos_plan['id_plan'];
		            	?>
			            <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { 
							echo "<a href='".PUERTO."://".HOST."/detalleOferta/".$vista."/".Utils::encriptar($o["id_ofertas"])."/'>";
						} ?>
						<div class='panel panel-default shadow-panel'>
							<?php if($o['tipo_oferta'] == 1){ echo '<div class="panel-head">Aviso Urgente </div>'; } ?>
						    <div class='panel-body <?php if($o['tipo_oferta'] == 1){ echo 'ofertaUrgente';} ?>' id='caracteristica_oferta'>
						   		<div class="row">
						   			<div class="col-md-12">
										<div class="col-sm-2 col-md-3 col-lg-2" style="padding-left: 0px;" align='center'>
											<?php 										
											$src_imagen = ($o['confidencial'] && $vista!='vacantes' && $vista!='cuentas') ? PUERTO.'://'.HOST.'/imagenes/logo_oferta.png' : Modelo_Usuario::obtieneFoto($o['username']);
											?>
											<img id="imgPerfil" class="img-responsive postulacion'" src="<?php echo $src_imagen; ?>" alt="icono">
							  			</div>
							  			<div class='col-sm-8 col-md-7 col-lg-<?php if($vista == 'oferta'){ echo '10'; }else{ echo '8'; }?>'>
											<span>
										    	<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA) { ?>
											   		
													<?php if (REQUISITO[$o['confidencial']] == 'No') {
														echo '<h5 class="empresa"><i>'.$o['empresa']."</i></h5>";
													}
													else
													{
														echo '<h5 class="empresa"><i>Nombre de la empresa - confidencial</i></h5>';
													} 
												}

												if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA && $vista == 'cuentas'){

													echo '<h5 class="empresa"><i>'.$o['empresa']."</i></h5>";
												}
												?>

												<b style='color: black;'><?php echo utf8_encode($o['titulo']); ?></b>  
												<?php 
												if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) {
													if($vista == 'postulacion'){
												    	if(isset($o['tipo'])){ 						
												    		echo ' | <span class="etiquetaPostulado">Aplic&oacute; de forma '.POSTULACIONES[$o['tipo']].'</span>';
												    	}													    	
													}													
												}
												?>
												</span>
												<br>
											    <span style="color:#333;"><?php echo 'Fecha de creaci&oacute;n de la oferta: '.date("d-m-Y", strtotime($o['fecha_creado'])); ?></span>
												<br>
												<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) { ?>
													<div class="row">
														<p style="color:#737272" class="cortar" align="justify"><?php echo strip_tags(html_entity_decode($o['descripcion'])); ?></p>
													</div>
												<?php } ?>
								  			</div>
								  			<?php if($vista == 'postulacion'){ ?>
								  	
								  				<div class="col-sm-1 col-md-2 col-lg-1 icon_oferta" align="center" style="vertical-align: middle; padding-top: 5%;">
													<?php if(isset($o['tipo']) && $o['tipo'] == 2){ ?>
														<a style="cursor:pointer" title="Eliminar postulaci&oacute;n" href="<?php echo PUERTO."://".HOST."/postulacion/eliminar/".Utils::encriptar($o['id_postulacion'])."/"; ?>">
															<i class="fa fa-trash fa-2x"></i>
														</a>
													<?php }else if(isset($o['puedeEliminar']) && $o['puedeEliminar'] == 1){ ?>
														<a style="cursor:pointer" title="Eliminar postulaci&oacute;n" onclick="abrirModal('Si presiona el botón de Aceptar no recibirá más postulaciones automáticas de esta empresa <?php if (REQUISITO[$o['confidencial']] == 'No') { echo '<b>('.$o['empresa'].')</b>'; } ?>, Desea eliminar la postulación? ','alert_descarga','<?php echo PUERTO."://".HOST."/postulacion/eliminar/".Utils::encriptar($o['id_postulacion'])."/".Utils::encriptar($o['id_empresa'])."/"; ?>','Ok','Confirmación');">
															<i class="fa fa-trash fa-2x"></i>
														</a>
													<?php } ?>
												</div>
											<?php } ?>
											<?php if($vista == 'vacantes' || $vista == 'cuentas'){ ?>
							  					<div class="col-sm-1 col-md-1 col-lg-1 icon_oferta" align="center" style="vertical-align: middle; padding-top: 5%;">
													<a href="<?php echo PUERTO."://".HOST."/detalleOferta/".$vista."/".Utils::encriptar($o["id_ofertas"])."/"; ?>">
														<i class="fa fa-eye" title="Ver detalle de la oferta"></i>
													</a>
												</div>
											<?php } ?>
											<?php if($vista == 'vacantes'){ ?>
												
													<?php 
														$tiempo = Modelo_Parametro::obtieneValor('tiempo_espera');
														$puedeEditar = Modelo_Oferta::puedeEditar($o["id_ofertas"],$tiempo);
														if($puedeEditar["editar"] == 1){
													?>
													<div id="editar" class="col-sm-1 col-md-1 col-lg-1 icon_oferta" align="center" style="vertical-align: middle; padding-top: 5%; cursor:pointer;">
														<a onclick="abrirModalEditar('editar_Of','<?php echo Utils::encriptar($o["id_ofertas"]); ?>');">
															<i class="fa fa-edit" title="Editar la oferta"></i>
														</a>
													</div>
												<?php } ?>
												
											<?php } ?>
								  		</div>
								  	</div>
								  	<div class="row">
							   			<div class="col-md-12">
											<hr style="margin-top: 10px; margin-bottom: 10px;"/>
								  		</div>
								  	</div>
								  	<div class="row">
							   			<div class="col-md-12">

							   				<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) { 
							   					$c1 = 2;
							   					$c2 = 3;
							   					$c3 = 3;
							   					$c4 = 2;
							   					$c5 = 2;
							   				}else{
							   					$c1 = 3;
							   					$c2 = 3;
							   					$c3 = 3;
							   					$c4 = 3;
							   					$c5 = 3;
							   				} ?>

											<div class='col-xs-6 col-md-<?php echo $c1; ?>' align='center'>
							                    <span class="<?php if($o['tipo_oferta'] == 1){ echo 'etiquetaOfertaUrgente';}else{ echo 'etiquetaOferta'; } ?>">Salario: </span><br><?php echo SUCURSAL_MONEDA.number_format($o['salario'],2);?>
							                </div>
							                <div class='col-xs-6 col-md-<?php echo $c2; ?>' align='center'>
							                    <span class="<?php if($o['tipo_oferta'] == 1){ echo 'etiquetaOfertaUrgente';}else{ echo 'etiquetaOferta'; } ?>">Provincia: </span><br><?php echo utf8_encode($o['provincia']);?>
							                </div>
							                <div class='col-xs-6 col-md-<?php echo $c3; ?>' align='center'>
							                    <span class="<?php if($o['tipo_oferta'] == 1){ echo 'etiquetaOfertaUrgente';}else{ echo 'etiquetaOferta'; } ?>">Jornada: </span><br><?php echo $o['jornada']; ?>
							                </div>
							                <div class='col-xs-6 col-md-<?php echo $c4; ?>' align='center'>
							                    <span class="<?php if($o['tipo_oferta'] == 1){ echo 'etiquetaOfertaUrgente';}else{ echo 'etiquetaOferta'; } ?>">Vacantes: </span><br><?php echo $o['vacantes']; ?>
							                </div>
							                <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) { ?>
								                <div class='col-xs-6 col-md-<?php echo $c5; ?>' align='center'>
								                    <span class="inscritos"><b>Inscritos: </b></span>
								                <?php 
								                	if(isset($aspirantesXoferta[$o['id_ofertas']])){
														$cantd = $aspirantesXoferta[$o['id_ofertas']];
													}else{
														$cantd = 0;
													}

													if (isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'buscarCandidatosPostulados',$id_plan) && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA && $cantd != 0) { 
														echo ' <br> <a class="aspirantes" href="'.PUERTO.'://'.HOST.'/verAspirantes/1/'.Utils::encriptar($o['id_ofertas']).'/1/">'.$cantd.'</a>';

													}elseif($cantd == 0){
														echo ' <br> <span class="aspirantes">'.$cantd.'</span>';
													}else{
														echo ' <br> <span style="cursor:pointer" onclick="abrirModal(\'Debe contratar un plan que permita ver inscritos en la oferta\',\'alert_descarga\',\''.PUERTO."://".HOST."/planes/".'\',\'Ok\',\'\')" class="aspirantes">'.$cantd.'</span>';
													}
												?>
								                </div>
								            <?php } ?>
								  		</div>
								  	</div>
								  	<?php if($vista == 'postulacion'){ ?>
								  	<div class="row">
							   			<div class="col-md-12">
											<hr style="margin-top: 10px; margin-bottom: 10px;"/>
								  		</div>
								  	</div>
								  	<div class="row">
								  		<div class="estados_postulados col-md-12">
							                <?php $postulado = Modelo_Postulacion::obtienePostuladoxUsuario($_SESSION['mfo_datos']['usuario']['id_usuario'],$o['id_ofertas']);
							                	$cv_descargado = Modelo_Descarga::obtieneDescargaCV($_SESSION['mfo_datos']['usuario']['infohv']['id_infohv'],$o['id_empresa'],$o['id_ofertas']);
							                 ?>
							                <div class="col-md-3 col-xs-6 <?php if(date("Y-m-d H:i:s", strtotime($o['fecha_contratacion'])) <= date('Y-m-d H:i:s')){ echo 'cancelada'; }else{ echo 'activated'; } ?>">
							                    <div class="wizard-icon"><i class="fa fa-file-text-o"></i></div>
							                    <p>Postulado:
							                    	<?php if(isset($postulado)){ ?>
											    	<b><?php echo date("d-m-Y", strtotime($postulado[0]['fecha_postulado'])); ?></b>
												<?php } ?></p>
							                </div>
							                <div class="col-md-3 col-xs-6 <?php if(date("Y-m-d H:i:s", strtotime($o['fecha_contratacion'])) <= date('Y-m-d H:i:s')){ echo 'cancelada'; }else{ echo 'activated'; } ?>">
							                    <div class="wizard-icon"><i class="fa fa-user"></i></div>
							                    <p>Estatus: <?php if(isset($o['tipo']) && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){ ?>
											    	<b><?php echo ucfirst(strtolower(Modelo_Oferta::ESTATUS_OFERTA[$o['resultado']])); ?></b>
												<?php } ?></p>
							                </div>
							                <div class="col-md-3 col-xs-6 <?php if(date("Y-m-d H:i:s", strtotime($o['fecha_contratacion'])) <= date('Y-m-d H:i:s')){ echo 'cancelada'; }else if(isset($cv_descargado) && $cv_descargado['cantd_descarga'] >= 1){ echo 'activated'; } ?>">
							                    <div class="wizard-icon"><i class="fa fa-key"></i></div>
							                    <p><b>CV visto</b></p>
							                </div>
							                <div class="col-md-3 col-xs-6 <?php if(date("Y-m-d H:i:s", strtotime($o['fecha_contratacion'])) <= date('Y-m-d H:i:s')){ echo 'cancelada'; } ?>">
							                    <div class="wizard-icon"><i class="fa fa-check-circle"></i></div>
							                    <p>Finalizado</p>
							                </div>
							            </div>
								  	</div>
								  <?php } ?>
							    </div>
							</div>
						<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { 
							echo "</a>";
					    } 
					}
				} ?>
	        </div>
	        <div class="col-md-12">
				<?php echo $paginas; ?>
			</div>
		</div>
	</div>
	
</div>

<div class="modal fade" id="editar_Of" tabindex="-1" role="dialog" aria-labelledby="editar_Of" aria-hidden="true">
  <div class="modal-dialog" role="document">    
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Editar Ofertas</h5>                  
      </div>
      	<form action = "<?php echo PUERTO."://".HOST;?>/vacantes/" method = "post" id="form_editar_Of" name="form_editar_Of">
	      <div class="modal-body">
	      	<div class="row">
		      	<div class="col-md-12">
			        <div id="des_of_error" class="form-group">
						<label class="">Descripci&oacute;n oferta: </label>&nbsp;<i class="requerido">*</i><div id="descripcion_error" class="help-block with-errors"></div>
						<textarea id="des_of" rows="7" required name="des_of" class="form-control" style="resize: none;" onkeyup="validarDescripcion()"></textarea>
					</div>
				</div>
			</div>
	      </div>
	      <input type="hidden" name="guardarEdicion" id="guardarEdicion" value="1">
	      <input type="hidden" name="idOferta" id="idOferta" value="<?php echo $o['id_ofertas']; ?>">
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <input type="button" id="boton" name="boton" class="btn btn-success" value="Guardar" onclick="enviarEdicion()"> 
	      </div>
  		</form>
    </div>    
  </div>
</div>
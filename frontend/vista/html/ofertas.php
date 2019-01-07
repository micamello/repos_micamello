<div class="container">
	<div class="col-md-12">
		<br>
			<?php if (trim($vista) == 'oferta' && isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'autopostulacion')) { ?>

			<div class="col-md-12" align="right" >
				<b>Autopostulaciones restantes: <span class="parpadea" style="color:red"><?php echo $autopostulaciones_restantes['p_restantes']; ?></span></b>
			</div>
			<br>
		<?php }else{  
			echo $enlaceCompraPlan; ?>
		<?php } ?>
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
							    <input type="text" maxlength="30" class="form-control" id="inputGroup" aria-describedby="inputGroup" placeholder="Ej: Enfermero(a) &oacute; xx-xx-xxxx"> 
							    <?php 
								    $ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/';
								    $ruta = Controlador_Oferta::calcularRuta($ruta,''); 
								?>
							    <span class="input-group-addon">
							    	<a href="#" onclick="enviarPclave('<?php echo $ruta; ?>','1')"><i class="fa fa-search"></i>
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
						$ruta = Controlador_Oferta::calcularRuta($ruta,'S');
						echo '<li class="lista"><a href="'.$ruta.'1/" class="cuentas" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
					}
				}
				?></div>
				</div>
		    </div>
			<?php } ?>
		    <div class="panel panel-default shadow-panel1">
				<div class="panel-heading">
					<span><i class="fa fa-list-ul"></i> Categor&iacute;as</span>
				</div>
				<div class="panel-body">
					<div class="filtros">
				<?php
				if (!empty($arrarea)) { 
				    foreach ($arrarea as $key => $v) {
				    	$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/A'.$key.'/';
						$ruta = Controlador_Oferta::calcularRuta($ruta,'A');
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
							$ruta = Controlador_Oferta::calcularRuta($ruta,'P');
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
								$ruta = Controlador_Oferta::calcularRuta($ruta,'J');
								echo '<li class="lista"><a href="'.$ruta.'1/" class="jornada" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
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
	                			$ruta = Controlador_Oferta::calcularRuta($ruta,'');
	                		?>
				            <select id="categoria" class="form-control">
				                <option value="0">Seleccione una catego&iacute;a</option>
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
								$ruta = Controlador_Oferta::calcularRuta($ruta,'O');
							?>
				           <a href="<?php echo $ruta.'1/'; ?>">Salario <i class="fa fa-sort"></i></a>
				        </th>
				        <th class="text-center">
							<?php 
								$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/O2'.$_SESSION['mfo_datos']['Filtrar_ofertas']['O'].'/';
								$ruta = Controlador_Oferta::calcularRuta($ruta,'O');
							?>
				           <a href="<?php echo $ruta.'1/'; ?>">Fecha <i class="fa fa-sort"></i></a>
				        </th>
				        <th colspan="2" class="text-center"></th>
				      </tr>
				    </thead>
				</table>
			</div>
	        <div id="result">
	        	<?php if(!empty($ofertas) && $ofertas[0]['id_ofertas'] != ''){
		            foreach($ofertas as $key => $o){ ?>
			            <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { 
							echo "<a href='".PUERTO."://".HOST."/detalleOferta/".$vista."/".$o["id_ofertas"]."/'>";
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

												<b style='color: black;'><?php echo $o['titulo']; ?></b>  
												<?php 
												if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) {
														if($vista == 'postulacion'){
													    	if(isset($o['tipo'])){ 						
													    		echo ' | <span class="etiquetaPostulado">Aplic&oacute; de forma '.POSTULACIONES[$o['tipo']].'</span>';
													    	}													    	
														}													
												}else{

													if(isset($aspirantesXoferta[$o['id_ofertas']])){
														$cantd = $aspirantesXoferta[$o['id_ofertas']];
													}else{
														$cantd = 0;
													}

													if (isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'verCandidatos') && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA && $cantd != 0) { 
														echo ' | <a class="btn-xs btn-primary parpadea" href="'.PUERTO.'://'.HOST.'/verAspirantes/1/'.$o['id_ofertas'].'/1/">Ver Aspirantes ( '.$cantd.' )</a>';

													}elseif($cantd == 0){
														echo ' | <span class="btn-xs btn-danger parpadea">No tiene Aspirantes ( '.$cantd.' )</span>';
													}else{

														echo ' | <span style="cursor:pointer" onclick="abrirModal(\'Debe contratar un plan que permita ver Aspirantes\',\'alert_descarga\',\''.PUERTO."://".HOST."/planes/".'\',\'Ok\')" class="btn-xs btn-primary parpadea">Ver Aspirantes ( '.$cantd.' )</span>';
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

														<a title="Eliminar postulaci&oacute;n" href="<?php echo PUERTO."://".HOST."/postulacion/eliminar/".$o['id_postulacion']."/"; ?>">
															<i class="fa fa-trash fa-2x"></i>
														</a>
													<?php } ?>
												</div>
											<?php } ?>
											<?php if($vista == 'vacantes' || $vista == 'cuentas'){ ?>
							  					<div class="col-sm-1 col-md-1 col-lg-1 icon_oferta" align="center" style="vertical-align: middle; padding-top: 5%;">
													<a href="<?php echo PUERTO."://".HOST."/detalleOferta/".$vista."/".$o["id_ofertas"]."/"; ?>">
														<i class="fa fa-eye" title="Ver detalle de la oferta"></i>
													</a>
												</div>
											<?php } ?>
											<?php if($vista == 'vacantes'){ ?>
												<div id="editar" class="col-sm-1 col-md-1 col-lg-1 icon_oferta" align="center" style="vertical-align: middle; padding-top: 5%; cursor:pointer;">
													<?php $puedeEditar = Modelo_Oferta::puedeEditar($o["id_ofertas"]);
														if($puedeEditar["editar"] == 1){
													?>
													<a onclick="abrirModalEditar('editar_Of','<?php echo $o["id_ofertas"]; ?>');">
														<i class="fa fa-edit" title="Editar la oferta"></i>
													</a>
												<?php } ?>
												</div>
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
											<div class='col-xs-6 col-md-3' align='center'>
							                    <span class="<?php if($o['tipo_oferta'] == 1){ echo 'etiquetaOfertaUrgente';}else{ echo 'etiquetaOferta'; } ?>">Salario: </span><br><?php echo SUCURSAL_MONEDA.number_format($o['salario'],2);?>
							                </div>
							                <div class='col-xs-6 col-md-3' align='center'>
							                    <span class="<?php if($o['tipo_oferta'] == 1){ echo 'etiquetaOfertaUrgente';}else{ echo 'etiquetaOferta'; } ?>">Provincia: </span><br><?php echo utf8_encode($o['provincia']);?>
							                </div>
							                <div class='col-xs-6 col-md-3' align='center'>
							                    <span class="<?php if($o['tipo_oferta'] == 1){ echo 'etiquetaOfertaUrgente';}else{ echo 'etiquetaOferta'; } ?>">Jornada: </span><br><?php echo $o['jornada']; ?>
							                </div>
							                <div class='col-xs-6 col-md-3' align='center'>
							                    <span class="<?php if($o['tipo_oferta'] == 1){ echo 'etiquetaOfertaUrgente';}else{ echo 'etiquetaOferta'; } ?>">Vacantes: </span><br><?php echo $o['vacantes']; ?>
							                </div>
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
							                	$cv_descargado = Modelo_Descarga::obtieneDescargaCV($_SESSION['mfo_datos']['infohv']['id_infohv'],$o['id_empresa'],$o['id_ofertas']);
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
		</div>
	</div>
	<div class="col-md-12">
		<?php echo $paginas; ?>
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
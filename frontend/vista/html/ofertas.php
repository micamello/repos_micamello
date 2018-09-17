<div class="container">
	<div class="col-md-12">
	  	<div class="col-md-4 visible-md-inline visible-lg-inline">
	  		<b>
				<span style="font-size: 17px;"><i class="fa fa-filter"></i>Filtros</span>
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
							    	<a href="#" onclick="enviarPclave('<?php echo $ruta; ?>','<?php echo $page; ?>')"><i class="fa fa-search"></i>
							    	</a>
							    </span>
						    </div>
						</div>			    
					</div>
				</div>
		    </div>
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
						echo '<li class="lista"><a href="'.$ruta.$page.'/" class="area" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
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
							echo '<li class="lista"><a href="'.$ruta.$page.'/" class="provincia" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
						}
					}
				?>
					</div>
				</div>
		    </div>
            
		    <div class="panel panel-default shadow-panel1">
	            <div class="panel-heading">
	              <span><i class="fa fa-user-clock"></i> Jornada</span>
	            </div>
	            <div class="panel-body">
	          		<div class="filtros">
					<?php
						if (!empty($jornadas)) {
						    foreach ($jornadas as $key => $v) {
						    	$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/J'.$key.'/';
								$ruta = Controlador_Oferta::calcularRuta($ruta,'J');
								echo '<li class="lista"><a href="'.$ruta.$page.'/" class="jornada" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
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
							<a class="btn btn-md btn-info" onclick="obtenerFiltro('<?php echo $ruta; ?>','<?php echo $page; ?>')">
								Buscar
						    </a>
	                	</div>	
			        </div>
			    </div>
			</form>
		</div>

		<div class="col-md-8">
			<b>
				<?php if($vista != 'postulacion'){ ?>
					<span style="font-size: 17px;"><?php echo $breadcrumbs['oferta']; ?></span>
				<?php }else{ ?>
					<span style="font-size: 17px;"><?php echo $breadcrumbs['postulacion']; ?></span>
				<?php } ?>
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
				           <a href="<?php echo $ruta.$page.'/'; ?>">Salario <i class="fa fa-sort"></i></a>
				        </th>
				        <th class="text-center">
							<?php 
								$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/O2'.$_SESSION['mfo_datos']['Filtrar_ofertas']['O'].'/';
								$ruta = Controlador_Oferta::calcularRuta($ruta,'O');
							?>
				           <a href="<?php echo $ruta.$page.'/'; ?>">Fecha <i class="fa fa-sort"></i></a>
				        </th>
				        <th colspan="2" class="text-center"></th>
				      </tr>
				    </thead>
				</table>
			</div>
	        <div id="result">
	        	<?php if(!empty($ofertas) && $ofertas[0]['id_ofertas'] != ''){

		            foreach($ofertas as $key => $o){  ?>
		            <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA) { 
						echo "<a href='".PUERTO."://".HOST."/detalleOferta/".$vista."/".$o["id_ofertas"]."/'>";
					} ?>
							<div class='panel panel-default shadow'>
							    <div class='panel-body' id='caracteristica_oferta'>
							   		<div class="row">
							   			<div class="col-md-12">
											<div class="col-sm-2 col-md-3 col-lg-2" style="padding-left: 0px;" align='center'>
												<img id="imgPerfil" class="img-responsive postulacion'" src="<?php if($vista != 'postulacion' && $vista != 'vacantes'){ echo PUERTO.'://'.HOST.'/imagenes/logo.png'; }else{ echo Modelo_Usuario::obtieneFoto($o['id_usuario']); } ?>" alt="icono">
								  			</div>
								  			<div class='col-sm-9 col-md-7 col-lg-<?php if($vista == 'postulacion'){ echo '9'; }else{ echo '10'; }?>'>
												<span>
											    	<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA) { ?>
												   		
															<?php if (REQUISITO[$o['confidencial']] == 'No') {
																echo '<h5 class="empresa"><i>'.$o['empresa']."</i></h5>";
															}
															else
															{
																echo '<h5 class="empresa"><i>Nombre - confidencial</i></h5>';
															} 
													} ?>

													<b style='color: black;'><?php echo $o['titulo']; ?></b>  
													<?php 
													if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA) {

												    	if(isset($o['tipo']) && $o['tipo'] == 2){ 						
												    		echo ' | <span class="etiquetaPostulado">Aplic&oacute; de forma '.POSTULACIONES[$o['tipo']].'</span>';
												    	}else{
															if(isset($postulacionesUserLogueado[$o["id_ofertas"]])){
																$tipo = $postulacionesUserLogueado[$o["id_ofertas"]];
																if($tipo == 2){
														    		echo ' | <span class="etiquetaPostulado">Aplic&oacute; de forma '.POSTULACIONES[$tipo].'</span>';
															    }else{
															    	echo ' | <span class="etiquetaPostulado parpadea">Autopostulado '.POSTULACIONES[$tipo].'</span>';
															    }
															}
														}
													}else{
														if (isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'verCandidatos') && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) { 
															echo ' | <a class="btn-xs btn-primary parpadea" href="'.PUERTO.'://'.HOST.'/verAspirantes/'.$o['id_ofertas'].'/">Ver Aspirantes ( '.$o['aspirantes'].' )</a>';
														}else{
															echo ' | <span style="cursor:pointer" onclick="abrirModal('."'Debe contratar un plan que permita ver Aspirantes'".')" class="btn-xs btn-primary parpadea">Ver Aspirantes ( '.$o['aspirantes'].' )</span>';
														}
													}
													?>
												</span>
												<?php if(isset($o['tipo']) && $o['tipo'] == 2 && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){ ?>
											    	<br>
											    	<span class="<?php echo CLASES_ESTATUS[$o['resultado']]; ?>"><b><?php echo Modelo_Oferta::ESTATUS_OFERTA[$o['resultado']]; ?></b></span>
												<?php } ?>

												<br>
											    <span style="color:#333;"><?php echo 'Fecha de creaci&oacute;n: '.date("d-m-Y", strtotime($o['fecha_creado'])); ?></span>
												<br>
												<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) { ?>
													<div class="row">
														<p style="color:#C3BABA" class="cortar" align="justify"><?php echo $o['descripcion']; ?></p>
													</div>
												<?php } ?>
								  			</div>
								  			<?php if($vista == 'postulacion'){ ?>
								  	
								  				<div class="col-sm-1 col-md-2 col-lg-1" align="center" style="vertical-align: middle; padding-top: 5%;">
													<?php if(isset($o['tipo']) && $o['tipo'] == 2){ ?>
														<a href="<?php echo PUERTO."://".HOST."/postulacion/".$o['id_postulacion']."/"; ?>">
															<i class="fa fa-trash fa-2x"></i>
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
							                    <span class="etiquetaOferta">Salario: </span><br><?php echo $_SESSION["mfo_datos"]["sucursal"]["simbolo"].number_format($o['salario'],2);?>
							                </div>
							                <div class='col-xs-6 col-md-3' align='center'>
							                    <span class="etiquetaOferta">Provincia: </span><br><?php echo $o['provincia']; ?>
							                </div>
							                <div class='col-xs-6 col-md-3' align='center'>
							                    <span class="etiquetaOferta">Jornada: </span><br><?php echo $o['jornada']; ?>
							                </div>
							                <div class='col-xs-6 col-md-3' align='center'>
							                    <span class="etiquetaOferta">Vacantes: </span><br><?php echo $o['vacantes']; ?>
							                </div>
								  		</div>
								  	</div>
							    </div>
							</div>
						<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA) { 
							echo "</a>";
					     } 
					}
				}else{ ?>
					
					<div class='panel panel-default'>
			    		<div class='panel-body' align='center'>
			      			<span>No se encontraron ofertas</span>
			    		</div>
			  		</div>
			  	<?php 
			  		} ?>
	        </div>
		</div>
	</div>
	<div class="col-md-12">
		<?php echo $paginas; ?>
	</div>
</div>


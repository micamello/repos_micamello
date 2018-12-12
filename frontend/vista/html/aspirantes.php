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
							    <input type="text" maxlength="30" class="form-control" id="inputGroup" aria-describedby="inputGroup" placeholder="Ej: Enfermero(a) &oacute; xx-xx-xxxx" /> 
							    <?php 
								    $ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/';
								    $ruta = Controlador_Aspirante::calcularRuta($ruta,'Q');
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
		    <div class="panel panel-default shadow-panel1">
				<div class="panel-heading">
					<span><i class="fa fa-map-marker"></i> Residencia Actual</span>
				</div>
				<div class="panel-body">
					<div class="filtros">
				<?php
					if (!empty($arrprovincia)) {
						foreach ($arrprovincia as $key => $v) {
					    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/U'.$key.'/';
							$ruta = Controlador_Aspirante::calcularRuta($ruta,'U');
							echo '<li class="lista"><a href="'.$ruta.'1/" class="provincia" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
						}
					}else{
						echo 'No hay resultados';
					}
				?></div>
				</div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
				<div class="panel-heading">
					<span><i class="fa fa-map"></i> Nacionalidad</span>
				</div>
				<div class="panel-body">
					<div class="filtros">
				<?php
					if (!empty($nacionalidades)) {
						foreach ($nacionalidades as $key => $v) {
					    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/N'.$key.'/';
							$ruta = Controlador_Aspirante::calcularRuta($ruta,'N');
							echo '<li class="lista"><a href="'.$ruta.'1/" class="nacionalidad" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
						}
					}else{
						echo 'No hay resultados';
					}
				?></div>
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
				    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/A'.$key.'/';
						$ruta = Controlador_Aspirante::calcularRuta($ruta,'A');
						echo '<li class="lista"><a href="'.$ruta.'1/" class="area" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
					}
				}
				?></div>
				</div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
				<div class="panel-heading">
					<span><i class="fa fa-bar-chart"></i> Nivel de estudio</span>
				</div>
				<div class="panel-body">
					<div class="filtros">
				<?php
					if (!empty($escolaridad)) {
						foreach ($escolaridad as $key => $v) {
					    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/E'.$key.'/';
							$ruta = Controlador_Aspirante::calcularRuta($ruta,'E');
							echo '<li class="lista"><a href="'.$ruta.'1/" class="escolaridad" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
						}
					}
				?></div>
				</div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
				<div class="panel-heading">
					<span><i class="fa fa-calendar"></i><?php if ($vista == 2){ echo "Fecha de Registro"; }else{ echo "Fecha de postulaci&oacute;n"; } ?></span>
				</div>
				<div class="panel-body">
					<div class="filtros">
				<?php
					
				    foreach (FECHA_POSTULADO as $key => $v) {

				    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/F'.$key.'/';
						$ruta = Controlador_Aspirante::calcularRuta($ruta,'F');
				    	echo '<li class="lista"><a href="'.$ruta.'1/" class="fecha" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
				    }
				?></div>
				</div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
		          <div class="panel-heading">
		              <span><i class="fa fa-money"></i> Plan Contratado (prioridad)</span>
		            </div>
		          <div class="panel-body">
		          	<div class="filtros">
	          			<div class="btn-group" id="status" data-toggle="buttons">
		          			<?php 
		          			if($_SESSION['mfo_datos']['Filtrar_aspirantes']['P'] == 0){
		          				$cont = 1;
		          			}
		          			foreach (PRIORIDAD as $key => $v) { ?>
				              <?php 
				              	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/P'.$key.'/';
						    	$ruta = Controlador_Aspirante::calcularRuta($ruta,'P');
						    	$ruta .= '1/'; ?>
						    	<label onclick="window.location='<?php echo $ruta; ?>'" class="btn btn-default btn-on-3 btn-md <?php if($_SESSION['mfo_datos']['Filtrar_aspirantes']['P'] == $key || ($_SESSION['mfo_datos']['Filtrar_aspirantes']['P'] == 0 && $cont == 1)){ echo 'active'; $cont = count(PRIORIDAD); } ?>">
									<input type="radio" value="<?php echo $key; ?>" name="multifeatured_module[module_id][status]" checked="checked" /><?php echo $v; ?>
								</label>
							<?php 
							} ?>
			            </div>
					 </div>
		          </div>
		    </div>

		    <?php if ($vista == 1){ ?>
		    <div class="panel panel-default shadow-panel1">
		      <div class="panel-heading">
		            <span><i class="fa fa-money"></i> Salario</span>
		          </div>
		      <div class="panel-body">
		      	<div class="filtros">
				<?php
					foreach (SALARIO as $key => $v) {
				    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/S'.$key.'/';
						$ruta = Controlador_Aspirante::calcularRuta($ruta,'S');
						echo '<li class="lista"><a href="'.$ruta.'1/" class="salario" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
					}
				?></div>
		      </div>
		    </div>
		    <?php } ?>

		    <div class="panel panel-default shadow-panel1">
		      <div class="panel-heading">
		            <span><i class="fa fa-venus-mars"></i> Genero</span>
		          </div>
		      <div class="panel-body">
		      	<div class="filtros">
				<?php
					foreach (GENERO as $key => $v) {
				    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/G'.VALOR_GENERO[$key].'/';
						$ruta = Controlador_Aspirante::calcularRuta($ruta,'G');
						echo '<li class="lista"><a href="'.$ruta.'1/" class="genero" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
					}
				?></div>
		      </div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
				<div class="panel-heading">
					<span><i class="fa fa-plane"></i> Puede viajar?</span>
				</div>
				<div class="panel-body">
					<div class="filtros">
				<?php
			    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/V1/';
					$ruta = Controlador_Aspirante::calcularRuta($ruta,'V');
					echo '<li class="lista"><a href="'.$ruta.'1/" class="viajar" id="1">S&iacute;</a></li>';

					$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/V2/';
					$ruta = Controlador_Aspirante::calcularRuta($ruta,'V');
					echo '<li class="lista"><a href="'.$ruta.'1/" class="viajar" id="2">No</a></li>';
				?></div>
				</div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
		      <div class="panel-heading">
		            <span><i class="fa fa-briefcase"></i> Tiene trabajo?</span>
		          </div>
		      <div class="panel-body">
		      	<div class="filtros">
				<?php
			    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/T1/';
					$ruta = Controlador_Aspirante::calcularRuta($ruta,'T');
					echo '<li class="lista"><a href="'.$ruta.'1/" class="trabajo" id="1">S&iacute;</a></li>';

					$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/T2/';
					$ruta = Controlador_Aspirante::calcularRuta($ruta,'T');
					echo '<li class="lista"><a href="'.$ruta.'1/" class="trabajo" id="2">No</a></li>';
				?></div>
		      </div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
				<div class="panel-heading">
					<span><i class="fa fa-id-card-o"></i> Tiene licencia?</span>
				</div>
				<div class="panel-body">
					<div class="filtros">
				<?php
			    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/L1/';
					$ruta = Controlador_Aspirante::calcularRuta($ruta,'L');
					echo '<li class="lista"><a href="'.$ruta.'1/" class="licencia" id="1">S&iacute;</a></li>';

					$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/L2/';
					$ruta = Controlador_Aspirante::calcularRuta($ruta,'L');
					echo '<li class="lista"><a href="'.$ruta.'1/" class="licencia" id="2">No</a></li>';
				?></div>
				</div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
		      <div class="panel-heading">
		            <span><i class="fa fa-wheelchair"></i> Discapacidad</span>
		          </div>
		      <div class="panel-body">
		      	<div class="filtros">
				<?php
			    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/D1/';
					$ruta = Controlador_Aspirante::calcularRuta($ruta,'D');
					echo '<li class="lista"><a href="'.$ruta.'1/" class="discapacidad" id="1">S&iacute;</a></li>';

					$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/D2/';
					$ruta = Controlador_Aspirante::calcularRuta($ruta,'D');
					echo '<li class="lista"><a href="'.$ruta.'1/" class="discapacidad" id="2">No</a></li>';
				?></div>
		      </div>
		    </div>
		</div>
		<div class="col-md-12 hidden-md hidden-lg">
			<div class="panel panel-default shadow" style="border-radius: 5px;">
				<div class="panel-heading" style="cursor:pointer" data-toggle="collapse" data-target="#contenedor"><i class="fa fa-angle-down"></i>Filtros</div>
                <div class="panel-body collapse" id="contenedor">
                	<div class="form-group">
						<input type="text" maxlength="30" class="form-control" id="inputGroup1" placeholder="Ej: Enfermero(a) &oacute; xx-xx-xxxx" /> 
					</div>
                	<div class="form-group">
                		<?php 
                			$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/'; 
                			$ruta = Controlador_Aspirante::calcularRuta($ruta,'');
                		?>
			            <select id="escolaridad" class="form-control">
			                <option value="0">Seleccione una nivel</option>
			                <?php
								foreach ($escolaridad as $key => $v) {
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
						<a class="btn btn-md btn-info" onclick="obtenerFiltro('<?php echo $ruta; ?>','<?php echo $page; ?>')">
							Buscar
					    </a>
                	</div>	
		        </div>
		    </div>
		</div>

		<div class="col-md-8"> 
			<b>
				<?php if($vista == 1){ ?>
					<span style="font-size: 17px;">Aspirantes Postulados</span>
				<?php }else{ ?>
					<span style="font-size: 17px;">Candidatos Registrados</span>
					<?php }?>				
			</b>
			<br/><br/>
			<div id="busquedas" class='container-fluid'>
				<?php if (isset($link)) { 
				 echo $link; 
				} ?>
			</div>
			
	        <div id="result">
	        	<div class='panel panel-default shadow'>
					<div class='panel-body'>
						<div id="no-more-tables">
				        	<table class="table table-hover">
				        		<thead class="etiquetaBody">
							      <tr>
									<th colspan="2" class="text-center">Nombre y Apellido</th>
							        <th class="text-center" style="width: 100px">
										<?php 
											$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/O1'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['O'].'/';
											$ruta = Controlador_Aspirante::calcularRuta($ruta,'O');
										?>
							           <a href="<?php echo $ruta.'1/'; ?>">Edad <i class="fa fa-sort"></i></a>
							        </th>
							        <th class="text-center">
										<?php 
											$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/O2'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['O'].'/';
											$ruta = Controlador_Aspirante::calcularRuta($ruta,'O');
											if($vista == 1) { $mensaje = 'Postulado el'; }else{ $mensaje = 'Registrado el'; }
										?>
							           <a href="<?php echo $ruta.'1/'; ?>"><?php echo $mensaje; ?><i class="fa fa-sort"></i></a>
							        </th>
							        <th class="text-center" title="Nivel de Estudios">
							        	<?php 
											$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/O3'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['O'].'/';
											$ruta = Controlador_Aspirante::calcularRuta($ruta,'O');
										?>
							           <a href="<?php echo $ruta.'1/'; ?>">Estudios<i class="fa fa-sort"></i></a>
							       </th>

							        <?php if($vista == 1) { ?>
								        <th class="text-center" style="width: 100px" title="Aspiraci&oacute;n Salarial">
								        	<?php 
												$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/O4'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['O'].'/';
												$ruta = Controlador_Aspirante::calcularRuta($ruta,'O');
											?>
								           <a href="<?php echo $ruta.'1/'; ?>">Salario<i class="fa fa-sort"></i></a>
								       </th>
								   <?php } ?>
								   	<?php if(($datosOfertas == false) || (isset($datosOfertas[0]['id_empresa']) && !in_array($datosOfertas[0]['id_empresa'], $array_empresas)) || in_array('-1',$posibilidades)){ ?>
							        	<th colspan="2" class="text-center">Acci&oacute;n</th>
							    	<?php } ?>
							      </tr>
							    </thead>
				        		<tbody>
						        	<?php if(!empty($aspirantes)){
							            foreach($aspirantes as $key => $a){  ?>
							            	<tr>
							            		<td align="right" style="text-align: center;" data-title="Foto: "><img class="img-circle" width="50" height="50" src="<?php echo Modelo_Usuario::obtieneFoto($a['username']); ?>" alt="perfil"></td>

							            		<td data-title="Aspirante: " style="vertical-align: middle; text-align: center;">
							            			<?php echo '<a href="'.PUERTO."://".HOST."/aspirante/".$a['username'].'/'.$id_oferta.'/'.$vista.'/">'.$a['nombres'].' '.$a['apellidos'].'</a>'; ?></td>

							            		<td data-title="Edad: " style="vertical-align: middle; text-align: center;" class="text-center"><?php echo $a['edad']; ?></td>
												<?php if($vista == 1){ ?>
							            			<td data-title="Postulado el: " style="vertical-align: middle; text-align: center;" class="text-center"><?php echo date("d", strtotime($a['fecha_postulado'])).' de '.MESES[date("m", strtotime($a['fecha_postulado']))].', '.date("Y", strtotime($a['fecha_postulado'])); ?></td>
												<?php }else{ ?>
													<td data-title="Registrado el: " style="vertical-align: middle; text-align: center;" class="text-center"><?php echo date("d", strtotime($a['fecha_creacion'])).' de '.MESES[date("m", strtotime($a['fecha_creacion']))].', '.date("Y", strtotime($a['fecha_creacion'])); ?></td>
												<?php } ?>

												<td style="vertical-align: middle; text-align: center;"><?php echo utf8_encode($a['estudios']); ?></td>

												<?php if($vista == 1){ 
													$compl_url = $id_oferta."/"; ?>
													<td style="vertical-align: middle; text-align: center;"><?php echo SUCURSAL_MONEDA.number_format($a['asp_salarial'],2); ?></td>
												<?php }else{
													$compl_url = '';
												} ?>

												<?php if(($datosOfertas == false) || (isset($datosOfertas[0]['id_empresa']) && !in_array($datosOfertas[0]['id_empresa'], $array_empresas)) ||in_array('-1',$posibilidades)){ ?>
													<td title="Descargar Hoja de vida" data-title="Hoja de vida: " style="vertical-align: middle; text-align: center;">
									            		<?php 
										            		if (isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'descargarHv') && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) {

										            			if(in_array('-1',$posibilidades)){
																	echo '<a target="_blank" href="'.PUERTO."://".HOST."/hojasDeVida/".$a['username'].'/'.$compl_url.'"><i class="fa fa-file-text fa-1x"></i></a>';
																}else{
																	$cantidadRestante = array_sum($posibilidades) - $descargas['cantd_descarga'];

																	if($cantidadRestante > 0){
																		echo '<a target="_blank" href="'.PUERTO."://".HOST."/hojasDeVida/".$a['username'].'/'.$compl_url.'"><i class="fa fa-file-text fa-1x"></i></a>';
																	}else{

																		echo '<a href="#" onclick="abrirModal(\'Debe contratar un plan que permita descargar hojas de vida\',\'alert_descarga\')"><i class="fa fa-file-text fa-1x"></i></a>';
																	}
																}

															}else{
																echo '<a href="#" onclick="abrirModal(\'Debe contratar un plan que permita descargar hojas de vida\',\'alert_descarga\')"><i class="fa fa-file-text fa-1x"></i></a>';
															}
														?>
													</td>

													<td title="Descargar Informe de personalidad" data-title="Informe" style="vertical-align: middle; text-align: center;">
									            		<?php 
										            		if (isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'descargarInformePerso') && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) {
																echo '<a target="_blank" href="'.PUERTO."://".HOST."/informePDF/".$a['username'].'/"><i class="fa fa-clipboard fa-1x" aria-hidden="true"></i></a>';
															}else{
																echo '<a href="#" onclick="abrirModal(\'Debe contratar un plan que permita descargar informes de personalidad\',\'alert_descarga\')"><i class="fa fa-clipboard fa-1x"></i></a>';
															}
														?>
													</td>
												<?php } ?>
							            	</tr>
										<?php }
									}else{ ?>
									    <tr>
									      <td colspan="7" class="text-center">No hay resultados</td>
									    </tr>
								  	<?php 
								    } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
	        </div>
		</div>
	</div>
	<div class="col-md-12">
		<?php echo $paginas; ?>
	</div>
</div>


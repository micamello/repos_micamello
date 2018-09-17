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
								    $ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$id_oferta.'/1/';
								    $ruta = Controlador_Aspirante::calcularRuta($ruta,'Q');
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
					<span><i class="fa fa-list-ul"></i> Fecha de postulaci&oacute;n</span>
				</div>
				<div class="panel-body">
					<div class="filtros">
				<?php
					
				    foreach (FECHA_POSTULADO as $key => $v) {

				    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$id_oferta.'/1/F'.$key.'/';
						$ruta = Controlador_Aspirante::calcularRuta($ruta,'F');
				    	echo '<li class="lista"><a href="'.$ruta.$page.'/" class="fecha" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
				    }
				?></div>
				</div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
				<div class="panel-heading">
					<span><i class="fa fa-map"></i> Ubicaci&oacute;n</span>
				</div>
				<div class="panel-body">
					<div class="filtros">
				<?php
					if (!empty($arrprovincia)) {
						foreach ($arrprovincia as $key => $v) {
					    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$id_oferta.'/1/U'.$key.'/';
							$ruta = Controlador_Aspirante::calcularRuta($ruta,'U');
							echo '<li class="lista"><a href="'.$ruta.$page.'/" class="provincia" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
						}
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
					    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$id_oferta.'/1/N'.$key.'/';
							$ruta = Controlador_Aspirante::calcularRuta($ruta,'N');
							echo '<li class="lista"><a href="'.$ruta.$page.'/" class="nacionalidad" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
						}
					}
				?></div>
				</div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
				<div class="panel-heading">
					<span><i class="fa fa-map"></i> Nivel de estudio</span>
				</div>
				<div class="panel-body">
					<div class="filtros">
				<?php
					if (!empty($escolaridad)) {
						foreach ($escolaridad as $key => $v) {
					    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$id_oferta.'/1/E'.$key.'/';
							$ruta = Controlador_Aspirante::calcularRuta($ruta,'E');
							echo '<li class="lista"><a href="'.$ruta.$page.'/" class="escolaridad" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
						}
					}
				?></div>
				</div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
		          <div class="panel-heading">
		              <span><i class="fa fa-user-clock"></i> Prioridad por plan</span>
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
				              	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$id_oferta.'/1/P'.$key.'/';
						    	$ruta = Controlador_Aspirante::calcularRuta($ruta,'P');
						    	$ruta .= $page.'/'; ?>
						    	<label onclick="window.location='<?php echo $ruta; ?>'" class="btn btn-default btn-on-3 btn-md <?php if($_SESSION['mfo_datos']['Filtrar_aspirantes']['P'] == $key || ($_SESSION['mfo_datos']['Filtrar_aspirantes']['P'] == 0 && $cont == 1)){ echo 'active'; $cont = count(PRIORIDAD); } ?>">
									<input type="radio" value="<?php echo $key; ?>" name="multifeatured_module[module_id][status]" checked="checked" ><?php echo $v; ?>
								</label>
							<?php 
							} ?>
			            </div>
					 </div>
		          </div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
		      <div class="panel-heading">
		            <span><i class="fa fa-file"></i> Salario</span>
		          </div>
		      <div class="panel-body">
		      	<div class="filtros">
				<?php
					foreach (SALARIO as $key => $v) {
				    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$id_oferta.'/1/S'.$key.'/';
						$ruta = Controlador_Aspirante::calcularRuta($ruta,'S');
						echo '<li class="lista"><a href="'.$ruta.$page.'/" class="salario" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
					}
				?></div>
		      </div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
		      <div class="panel-heading">
		            <span><i class="fa fa-file"></i> Genero</span>
		          </div>
		      <div class="panel-body">
		      	<div class="filtros">
				<?php
					foreach (GENERO as $key => $v) {
				    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$id_oferta.'/1/G'.VALOR_GENERO[$key].'/';
						$ruta = Controlador_Aspirante::calcularRuta($ruta,'G');
						echo '<li class="lista"><a href="'.$ruta.$page.'/" class="genero" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
					}
				?></div>
		      </div>
		    </div>
		</div>
		<div class="col-md-12 hidden-md hidden-lg">
			<div class="panel panel-default shadow" style="border-radius: 5px;">
				<div class="panel-heading" style="cursor:pointer" data-toggle="collapse" data-target="#contenedor"><i class="fa fa-angle-down"></i>Filtros</div>
                <div class="panel-body collapse" id="contenedor">
                	<div class="form-group">
						<input type="text" maxlength="30" class="form-control" id="inputGroup1" placeholder="Ej: Enfermero(a) &oacute; xx-xx-xxxx"> 
					</div>
                	<div class="form-group">
                		<?php 
                			$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/'; 
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
			            <select id="jornada" class="form-control">
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
				<span style="font-size: 17px;">Aspirantes postulados</span>
			</b>
			<br/><br/>
			<div id="busquedas" class='container-fluid'>
				<?php if (isset($link)) { 
				 echo $link; 
				} ?>
			</div>
			
	        <div id="result">
	        	<div class='panel panel-default shadow'>
					<div class='panel-body' style="padding-top: 35px;">
						<div class="table-responsive">
				        	<table class="table table-hover">
				        		<thead>
							      <tr>
									<th colspan="2" class="text-center"></th>
							        <th class="text-center">
										<?php 
											$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$id_oferta.'/1/O1'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['O'].'/';
											$ruta = Controlador_Aspirante::calcularRuta($ruta,'O');
										?>
							           <a href="<?php echo $ruta.$page.'/'; ?>">Edad <i class="fa fa-sort"></i></a>
							        </th>
							        <th class="text-center">
										<?php 
											$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$id_oferta.'/1/O2'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['O'].'/';
											$ruta = Controlador_Aspirante::calcularRuta($ruta,'O');
										?>
							           <a href="<?php echo $ruta.$page.'/'; ?>">Fecha <i class="fa fa-sort"></i></a>
							        </th>
							        <th colspan="2" class="text-center"></th>
							      </tr>
							    </thead>
				        		<tbody>
					        	<?php if(!empty($aspirantes)){

						            foreach($aspirantes as $key => $a){  ?>
										
						            	<tr>
						            		<td><img class="img-circle" width="50" src="<?php echo Modelo_Usuario::obtieneFoto($a['id_usuario']); ?>" alt="perfil"></td>

						            		<td style="vertical-align: middle; text-align: justify;"><?php echo $a['nombres'].' '.$a['apellidos']; ?></td>

						            		<td style="vertical-align: middle;" class="text-center"><?php echo $a['edad']; ?></td>

						            		<td style="vertical-align: middle;" class="text-center"><?php echo date("d", strtotime($a['fecha_postulado'])).' de '.MESES[date("m", strtotime($a['fecha_postulado']))].', '.date("Y", strtotime($a['fecha_postulado'])); ?></td>
											
											<td style="vertical-align: middle;">
							            		<?php 
								            		if (isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'descargarHv') && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) {

								            			$posibilidades = Modelo_UsuarioxPlan::disponibilidadDescarga($_SESSION['mfo_datos']['usuario']['id_usuario']);
								            			$descargas = Modelo_Descarga::cantidadDescarga($_SESSION['mfo_datos']['usuario']['id_usuario']);
								            			
								            			if(in_array('-1',$posibilidades) ){
															echo '<a href="'.PUERTO."://".HOST."/hojasDeVida/".$a['username'].'.pdf"><i class="fa fa-file-text fa-1x"></i></a>';
														}else{
															$cantidadRestante = array_sum($posibilidades) - $descargas['cantd_descarga'];

															if($cantidadRestante > 0){
																echo '<a href="'.PUERTO."://".HOST."/hojasDeVida/".$a['username'].'.pdf"><i class="fa fa-file-text fa-1x"></i></a>';
															}else{
																echo '<a href="#" onclick="abrirModal('."'Debe contratar un plan que permita descargar hojas de vida'".')"><i class="fa fa-file-text fa-1x"></i></a>';
															}
														}

													}else{
														echo '<a href="#" onclick="abrirModal('."'Debe contratar un plan que permita descargar hojas de vida'".')"><i class="fa fa-file-text fa-1x"></i></a>';
													}
												?>
											</td>

											<td style="vertical-align: middle;">
							            		<?php 
								            		if (isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'descargarInformePerso') && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) {
														echo '<a href="'.PUERTO."://".HOST."/verResultados/".$a['id_usuario'].'/"><i class="fa fa-clipboard fa-1x" aria-hidden="true"></i></a>';
													}else{
														echo '<a href="#" onclick="abrirModal('."'Debe contratar un plan que permita descargar Informes de personalidad'".')"><i class="fa fa-clipboard fa-1x"></i></a>';
													}
												?>
											</td>
						            	</tr>
									<?php }
								}else{ ?>
								    <tr>
								      <td colspan="5" class="text-center">No hay resultados</td>
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


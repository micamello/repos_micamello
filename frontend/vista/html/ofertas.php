<div class="container">
	<div class="col-md-12">

	  	<div class="col-md-4">
	  		<b>
				<span style="font-size: 17px;">Filtros</span>
			</b>
			<br/><br/>
		    <div class="panel panel-default shadow-panel1">
				<div class="panel-heading">
					<span><i class="fas fa-list-ul"></i> Categor&iacute;as</span>
				</div>
				<div class="panel-body">
				<?php
				if (!empty($arrarea)) { 
				    foreach ($arrarea as $key => $ae) {
				        echo '<li class="lista"><a href="'.PUERTO.'://'.HOST.'/'.$mostrar.'/'.$vista.'/1/A'.$key.'/';
				        if($_SESSION['mfo_datos']['Filtrar_ofertas']['P'] != 0){
				        	echo 'P'.$_SESSION['mfo_datos']['Filtrar_ofertas']['P'].'/';
				    	}
				    	if($_SESSION['mfo_datos']['Filtrar_ofertas']['J'] != 0){
				        	echo 'J'.$_SESSION['mfo_datos']['Filtrar_ofertas']['J'].'/';
				    	}
				    	if($_SESSION['mfo_datos']['Filtrar_ofertas']['C'] != 0){
				        	echo 'C'.$_SESSION['mfo_datos']['Filtrar_ofertas']['C'].'/';
				    	}
				    	echo $page.'/" class="interes" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($ae))). '</a></li>';
				    }
				}
				?>
				</div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
				<div class="panel-heading">
					<span><i class="fas fa-map"></i> Provincias</span>
				</div>
				<div class="panel-body">
				<?php
					if (!empty($arrprovincia)) {
						foreach ($arrprovincia as $key => $pr) {
						    echo '<li class="lista"><a href="'.PUERTO.'://'.HOST.'/'.$mostrar.'/'.$vista.'/1/P'.$key.'/';
					        if($_SESSION['mfo_datos']['Filtrar_ofertas']['A'] != 0){
					        	echo 'A'.$_SESSION['mfo_datos']['Filtrar_ofertas']['A'].'/';
					    	}
					    	if($_SESSION['mfo_datos']['Filtrar_ofertas']['J'] != 0){
					        	echo 'J'.$_SESSION['mfo_datos']['Filtrar_ofertas']['J'].'/';
					    	}
					    	if($_SESSION['mfo_datos']['Filtrar_ofertas']['C'] != 0){
					        	echo 'C'.$_SESSION['mfo_datos']['Filtrar_ofertas']['C'].'/';
					    	}
					    	echo $page.'/" class="provincia" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($pr))). '</a></li>';
						}
					}
				?>
				</div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
		          <div class="panel-heading">
		              <span><i class="fas fa-user-clock"></i> Jornada</span>
		            </div>
		          <div class="panel-body">
					<?php
						if (!empty($jornadas)) {
							foreach ($jornadas as $key => $jornada) {
							    echo '<li class="lista"><a href="'.PUERTO.'://'.HOST.'/'.$mostrar.'/'.$vista.'/1/J'.$key.'/';
						        if($_SESSION['mfo_datos']['Filtrar_ofertas']['A'] != 0){
						        	echo 'A'.$_SESSION['mfo_datos']['Filtrar_ofertas']['A'].'/';
						    	}
						    	if($_SESSION['mfo_datos']['Filtrar_ofertas']['P'] != 0){
						        	echo 'P'.$_SESSION['mfo_datos']['Filtrar_ofertas']['P'].'/';
						    	}
						    	if($_SESSION['mfo_datos']['Filtrar_ofertas']['C'] != 0){
						        	echo 'C'.$_SESSION['mfo_datos']['Filtrar_ofertas']['C'].'/';
						    	}
						    	echo $page.'/" class="jornada" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($jornada))). '</a></li>';
							}
						}
					?>
		          </div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
		      <div class="panel-heading">
		            <span><i class="fas fa-file"></i> Contrato</span>
		          </div>
		      <div class="panel-body">
				<?php
					if (!empty($tiposContrato)) {
						foreach ($tiposContrato as $key => $contrato) {
						    echo '<li class="lista"><a href="'.PUERTO.'://'.HOST.'/'.$mostrar.'/'.$vista.'/1/C'.$key.'/';
					        if($_SESSION['mfo_datos']['Filtrar_ofertas']['A'] != 0){
					        	echo 'A'.$_SESSION['mfo_datos']['Filtrar_ofertas']['A'].'/';
					    	}
					    	if($_SESSION['mfo_datos']['Filtrar_ofertas']['P'] != 0){
					        	echo 'P'.$_SESSION['mfo_datos']['Filtrar_ofertas']['P'].'/';
					    	}
					    	if($_SESSION['mfo_datos']['Filtrar_ofertas']['J'] != 0){
					        	echo 'J'.$_SESSION['mfo_datos']['Filtrar_ofertas']['J'].'/';
					    	}
					    	echo $page.'/" class="contrato" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($contrato))). '</a></li>';
						}
					}
				?>
		      </div>
		    </div>
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
			
	        <div id="result">
	        	<?php if(!empty($ofertas)){
		            foreach($ofertas as $key => $o){  ?>
		            		<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA) { ?>
								<a href='<?php echo PUERTO."://".HOST.'/detalleOferta/'.$vista.'/'.$o["id_ofertas"]; ?>/'>
							<?php } ?>
							<div class='panel panel-default shadow'>
							   <div class='panel-body'>
									<div class='col-md-2' align='center'>

										<img style="vertical-align: middle; margin-bottom: 10px;" class="img-circle img-responsive <?php if($vista != 'postulacion'){ echo ' oferta'; }else{ echo ' postulacion'; } ?>" src="<?php if($vista != 'postulacion' && $vista != 'vacantes'){ echo PUERTO.'://'.HOST.'/imagenes/logo.png'; }else{ echo Modelo_Usuario::obtieneFoto($o['id_usuario']); } ?>" alt="icono">

									</div>
								    <div class='col-md-<?php if($vista == 'postulacion'){ echo '9'; }else{ echo '10'; }?>'>
										<span>
								    	<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA) { ?>
									   		
												<?php if ($o['confidencial'] == 0) {
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
											if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) { 
												echo ' | <a class="btn-sm btn-primary parpadea" href="'.PUERTO.'://'.HOST.'/verAspirantes/'.$o['id_ofertas'].'/">Ver Aspirantes</a>';
											}
										}
										?>
										</span>
										
									    
										<?php if(isset($o['tipo']) && $o['tipo'] == 2){ ?>
									    	<br>
									    	<span class="<?php echo CLASES_ESTATUS[$o['resultado']]; ?>"><b><?php echo Modelo_Oferta::ESTATUS_OFERTA[$o['resultado']]; ?></b></span>
										<?php } ?>

										<br>
									    <span style="color:#333;"><?php echo 'Fecha de creaci&oacute;n: '.date("d-m-Y", strtotime($o['fecha_creado'])); ?></span>
										<br><br>
										<div class="row">
											<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) { ?>
												<p style="color:#C3BABA" class="text" align="justify"><?php echo $o['descripcion']; ?></p>
											<?php } ?>
										</div>
										<br>
									  	<div class="row">
									  		<div class='col-sm-3 col-md-2' align='center'>
							                    <span class="etiquetaOferta">Salario: </span><br><?php echo $o['salario']; ?>
							                </div>
							                <div class='col-sm-3 col-md-3' align='center'>
							                    <span class="etiquetaOferta">Provincia: </span><br><?php echo $o['provincia']; ?>
							                </div>
							                <div class='col-sm-3 col-md-3' align='center'>
							                    <span class="etiquetaOferta">Jornada: </span><br><?php echo $o['jornada']; ?>
							                </div>
							                <div class='col-sm-3 col-md-4' align='center'>
							                    <span class="etiquetaOferta">Tipo contrato: </span><br><?php echo $o['contrato']; ?>
							                </div>
									  	</div>
									</div>
									<?php if($vista == 'postulacion'){ 
										if(isset($o['tipo']) && $o['tipo'] == 2){ ?>
											<div class="col-md-1" align='center'>
												<a href="<?php echo PUERTO."://".HOST."/postulacion/".$o['id_postulacion']."/"; ?>"><br><br>
													<img width="25" src="<?php echo PUERTO.'://'.HOST.'/imagenes/delete.png'; ?>" alt="Eliminar">
												</a>
											</div>
										<?php } ?>
									<?php } ?>
							   </div>
							</div>
						</a>
					<?php }
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


<div class="container">
	<div class="col-md-12">
		<div align="center" class="breadcrumb">
			<b>
				<span style="font-size: 17px;">Ofertas de empleo</span>
			</b>
		</div>

	  	<div class="col-md-4">
		    <div class="panel panel-default shadow-panel1">
				<div class="panel-heading">
					<span><i class="fas fa-list-ul"></i> Categor&iacute;as</span>
				</div>
				<div class="panel-body">
				<?php
				if (!empty($arrarea)) { 
				    foreach ($arrarea as $key => $ae) {
				        echo '<li class="lista"><a href="'.PUERTO.'://'.HOST.'/oferta/1/A'.$key.'/';
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
						    echo '<li class="lista"><a href="'.PUERTO.'://'.HOST.'/oferta/1/P'.$key.'/';
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
							    echo '<li class="lista"><a href="'.PUERTO.'://'.HOST.'/oferta/1/J'.$key.'/';
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
						    echo '<li class="lista"><a href="'.PUERTO.'://'.HOST.'/oferta/1/C'.$key.'/';
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
	
			<div id="busquedas" class='container-fluid'>
				<?php echo $link; ?>
			</div>
			
	        <div id="result">
	        	<?php if(!empty($ofertas)){
		            foreach($ofertas as $key => $o){  ?>
						<a href='<?php echo PUERTO."://".HOST.'/detalleOferta/'.$o["id_ofertas"]; ?>/'>
							<div class='panel panel-default shadow-panel'>
							   <div class='panel-body'>
								   <div class='col-md-2' align='center'>
								   		<img class="img-circle img-responsive" style='border: 3px solid #ccf2ff; margin: 0 auto;padding: 19px 0px 19px 0px;' src="<?php echo PUERTO.'://'.HOST.'/imagenes/iconOferta.png'; ?>" alt="icono oferta">
								   </div>
								   <div class='col-md-10'>
								   		<span>
											<?php if ($o['confidencial'] == 0) {
												echo '<h5 class="empresa"><i>'.$o['empresa']."</i></h5>";
											}
											else
											{
												echo '<h5 class="empresa"><i>Nombre - confidencial</i></h5>';
											} ?>
											<b style='color: black;'><?php echo $o['titulo']; ?></b>  
										    <?php 
										    foreach($postulacionesUserLogueado as $key => $p){ 
												
												if($p['id_ofertas'] == $o["id_ofertas"]){
													if($p['tipo'] == 2){
											    		echo ' | <span class="postulacion">Aplic&oacute; de forma '.POSTULACIONES[$p['tipo']].'</span>';
												    }else{
												    	echo ' | <span class="postulacion">Autopostulado '.POSTULACIONES[$p['tipo']].'</span>';
												    }
												}
											} ?>
									    </span>
									</div>
									<br><br><br>
								  	<div class="row">
								  		<div class='col-sm-3 col-md-2' align='center'>
						                    <span class="etiquetaOferta">Salario: </span><br><?php echo $o['salario']; ?>
						                </div>
						                <div class='col-sm-3 col-md-2' align='center'>
						                    <span class="etiquetaOferta">Provincia: </span><br><?php echo $o['provincia']; ?>
						                </div>
						                <div class='col-sm-3 col-md-2' align='center'>
						                    <span class="etiquetaOferta">Jornada: </span><br><?php echo $o['jornada']; ?>
						                </div>
						                <div class='col-sm-3 col-md-3' align='center'>
						                    <span class="etiquetaOferta">Tipo contrato: </span><br><?php echo $o['contrato']; ?>
						                </div>
								  	</div>
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
				<?php } ?>
	        </div>
		</div>
	</div>
	<div class="col-md-12">
		<?php echo $paginas; ?>
	</div>
</div>


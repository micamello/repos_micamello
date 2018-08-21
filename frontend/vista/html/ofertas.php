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
				        echo '<li class="lista"><a onclick="result_filter(this,1);" class="interes" id="' . $ae["id_area"] . '">' . utf8_encode(ucfirst(strtolower($ae["nombre"]))). '</a></li>';
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
						    echo '<li class="lista"><a onclick="result_filter(this,1);" class="provincia" id="'.$pr["id_provincia"].'">'.utf8_encode(ucfirst(strtolower($pr["nombre"]))).'</a></li>';
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
							    echo '<li class="lista"><a onclick="result_filter(this,1);" class="jornada" id="'.$jornada["id_jornada"].'" data-value="'.utf8_encode(ucfirst(strtolower($jornada["nombre"]))).'">'.utf8_encode(ucfirst(strtolower($jornada["nombre"]))).'</a></li>';
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
						    echo '<li class="lista"><a onclick="result_filter(this,1);" class="contrato" id="'.$contrato["id_tipocontrato"].'">'.utf8_encode(ucfirst(strtolower($contrato["descripcion"]))).'</a></li>';
						}
					}
				?>
		      </div>
		    </div>
		</div>
		<div class="col-md-8">
			
			<div id="busquedas" class='container-fluid'>
				<span id="interes_class" class="interes_class"></span>
				<span id="provincia_class" class="provincia_class"></span>
				<span id="jornada_class" class="jornada_class"></span>
				<span id="contrato_class" class="contrato_class"></span>
			</div>
			
	        <div id="result">
	        	<?php if(!empty($ofertas)){
		            foreach($ofertas as $key => $o){  ?>
						<a href='<?php echo PUERTO."://".HOST.'/verOferta/'.$o["id_ofertas"]; ?>'>
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
													if($p['tipo'] == 1){
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
					<br><br>
					<div class='panel panel-default'>
			    		<div class='panel-body' align='center'>
			      			<span>No se encontraron ofertas</span>
			    		</div>
			  		</div>
				<?php } ?>
	        </div>
		</div>
	</div>
</div>


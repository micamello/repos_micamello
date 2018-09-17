<div class="container">
	<div class="col-md-12">

	  	<div class="col-md-4">
	  		<b>
				<span style="font-size: 17px;">Filtros</span>
			</b>
			<br/><br/>
		    <div class="panel panel-default shadow-panel1">
				<div class="panel-heading">
					<span><i class="fa fa-list-ul"></i> Fecha de postulaci&oacute;n</span>
				</div>
				<div class="panel-body">
				<?php
				    foreach (FECHA_POSTULADO as $key => $f) {
				        echo '<li class="lista"><a href="'.PUERTO.'://'.HOST.'/verAspirantes/'.$id_oferta.'/1/F'.$key.'/';
				        if($_SESSION['mfo_datos']['Filtrar_aspirantes']['U'] != 0){
				        	echo 'U'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['U'].'/';
				    	}
				    	if($_SESSION['mfo_datos']['Filtrar_aspirantes']['P'] != 0){
				        	echo 'P'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['P'].'/';
				    	}
				    	if($_SESSION['mfo_datos']['Filtrar_aspirantes']['S'] != 0){
				        	echo 'S'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['S'].'/';
				    	}
				    	if($_SESSION['mfo_datos']['Filtrar_aspirantes']['G'] != 0){
				        	echo 'G'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['G'].'/';
				    	}
				    	echo $page.'/" class="fecha" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($f))). '</a></li>';
				    }
				?>
				</div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
				<div class="panel-heading">
					<span><i class="fa fa-map"></i> Ubicaci&oacute;n</span>
				</div>
				<div class="panel-body">
				<?php
					if (!empty($arrprovincia)) {
						foreach ($arrprovincia as $key => $pr) {
						    echo '<li class="lista"><a href="'.PUERTO.'://'.HOST.'/verAspirantes/'.$id_oferta.'/1/U'.$key.'/';
					        if($_SESSION['mfo_datos']['Filtrar_aspirantes']['P'] != 0){
					        	echo 'P'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['P'].'/';
					    	}
					    	if($_SESSION['mfo_datos']['Filtrar_aspirantes']['F'] != 0){
					        	echo 'F'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['F'].'/';
					    	}
					    	if($_SESSION['mfo_datos']['Filtrar_aspirantes']['S'] != 0){
					        	echo 'S'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['S'].'/';
					    	}
					    	if($_SESSION['mfo_datos']['Filtrar_aspirantes']['G'] != 0){
					        	echo 'G'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['G'].'/';
					    	}
					    	echo $page.'/" class="provincia" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($pr))). '</a></li>';
						}
					}
				?>
				</div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
		          <div class="panel-heading">
		              <span><i class="fa fa-user-clock"></i> Prioridad por plan</span>
		            </div>
		          <div class="panel-body">
					<?php
						foreach (PRIORIDAD as $key => $p) {
						    echo '<li class="lista"><a href="'.PUERTO.'://'.HOST.'/verAspirantes/'.$id_oferta.'/1/P'.$key.'/';
					        if($_SESSION['mfo_datos']['Filtrar_aspirantes']['U'] != 0){
					        	echo 'U'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['U'].'/';
					    	}
					    	if($_SESSION['mfo_datos']['Filtrar_aspirantes']['F'] != 0){
					        	echo 'F'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['F'].'/';
					    	}
					    	if($_SESSION['mfo_datos']['Filtrar_aspirantes']['S'] != 0){
					        	echo 'S'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['S'].'/';
					    	}
					    	if($_SESSION['mfo_datos']['Filtrar_aspirantes']['G'] != 0){
					        	echo 'G'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['G'].'/';
					    	}
					    	echo $page.'/" class="prioridad" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($p))). '</a></li>';
						}
					?>
		          </div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
		      <div class="panel-heading">
		            <span><i class="fa fa-file"></i> Salario</span>
		          </div>
		      <div class="panel-body">
				<?php
					foreach (SALARIO as $key => $s) {
					    echo '<li class="lista"><a href="'.PUERTO.'://'.HOST.'/verAspirantes/'.$id_oferta.'/1/S'.$key.'/';
				        if($_SESSION['mfo_datos']['Filtrar_aspirantes']['U'] != 0){
				        	echo 'U'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['U'].'/';
				    	}
				    	if($_SESSION['mfo_datos']['Filtrar_aspirantes']['P'] != 0){
				        	echo 'P'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['P'].'/';
				    	}
				    	if($_SESSION['mfo_datos']['Filtrar_aspirantes']['F'] != 0){
				        	echo 'F'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['F'].'/';
				    	}
				    	if($_SESSION['mfo_datos']['Filtrar_aspirantes']['G'] != 0){
				        	echo 'G'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['G'].'/';
				    	}
				    	echo $page.'/" class="salario" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($s))). '</a></li>';
					}
				?>
		      </div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
		      <div class="panel-heading">
		            <span><i class="fa fa-file"></i> Genero</span>
		          </div>
		      <div class="panel-body">
				<?php
					foreach (GENERO as $key => $g) {
					    echo '<li class="lista"><a href="'.PUERTO.'://'.HOST.'/verAspirantes/'.$id_oferta.'/1/G'.$key.'/';
				        if($_SESSION['mfo_datos']['Filtrar_aspirantes']['U'] != 0){
				        	echo 'U'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['U'].'/';
				    	}
				    	if($_SESSION['mfo_datos']['Filtrar_aspirantes']['P'] != 0){
				        	echo 'P'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['P'].'/';
				    	}
				    	if($_SESSION['mfo_datos']['Filtrar_aspirantes']['F'] != 0){
				        	echo 'F'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['F'].'/';
				    	}
				    	if($_SESSION['mfo_datos']['Filtrar_aspirantes']['F'] != 0){
				        	echo 'F'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['F'].'/';
				    	}
				    	echo $page.'/" class="genero" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($g))). '</a></li>';
					}
				?>
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
	
	        	<?php if(!empty($aspirantes)){
		            foreach($aspirantes as $key => $a){  ?>
						<div class='panel panel-default shadow'>
						   <div class='panel-body' style="padding-top: 35px;">
								<div class="col-sm-4">
									<div class="example-1 card1">
									<div class="wrapper" width="100%" style="background-image: url('<?php echo Modelo_Usuario::obtieneFoto($a['id_usuario']); ?>');">
									  <div class="data">
									    <div class="content">
									      <p class="text-center" style="font-size: 17px; color: black;"><?php echo $a['nombres'].' '.$a['apellidos']; ?><br>
									      <span style="color:#03A9F4;"><?php echo MESES[date("m", strtotime($a['fecha_postulado']))].', '.date("Y", strtotime($a['fecha_postulado'])); ?></span> </p><br><br>
									      <p class="text">
									        <hr>
									            <ul style="list-style-type: none;">
									        <?php 

									            if (isset($aspirantesConHv[$a['id_usuario']])) {
									                ?>
									                <li><i class="far fa-file"></i> <a class="unstyled" href="<?php echo PUERTO."://".HOST."/hojasDeVida/".$a['username'].'.pdf';?>">Ver Hoja de Vida</a></li>
									                <?php
									            }
									            else
									            {
									                ?>
									                <li><i class="far fa-file"></i> <span style="color: black;">No ha cargado HV</span></li>
									                <?php
									            }?>
									                <li><i class="fa fa-chart-bar"></i> <a href="<?php echo PUERTO."://".HOST."/verResultados/".$a['id_usuario'].'/';?>">Resultados evaluaci&oacute;n</a></li>
									            </ul>
									            
									      </p>
									    </div>
									  </div>
									</div>
									</div>
				                </div> 
						   </div>
						</div>
					<?php }
				}else{ ?>
					
					<div class='panel panel-default'>
			    		<div class='panel-body' align='center'>
			      			<span>No se encontraron resultados</span>
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


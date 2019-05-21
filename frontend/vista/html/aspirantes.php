<style>
	.shadow-panel1{
		cursor:pointer;
	}
</style>
<div class="container">
  <div class="text-center">
    <h2 class="titulo">
    <?php if($vista == 1){ ?>
		Aspirantes Postulados
	<?php }else{ ?>
		Candidatos Registrados
	<?php }?>	
	</h2>
  </div>
</div>

<div class="container-fluid">
	<?php  

	if(!empty($limite_plan) && $_SESSION['mfo_datos']['usuario']['cantd_total'][Utils::desencriptar($id_oferta)] > $limite_plan){ ?>
		<br>
		<div class="alert alert-info col-md-12"> 
			Usted tiene un <b>Plan <?php echo utf8_encode($nombre_plan); ?></b>, en esta oferta existen <b><?php echo $_SESSION['mfo_datos']['usuario']['cantd_total'][Utils::desencriptar($id_oferta)]; ?> postulados</b> pero solo puede visualizar <b><?php echo $limite_plan; ?></b>.
		</div>
	<?php } ?>

	<?php if(!empty($_SESSION['mfo_datos']['Filtrar_aspirantes']['R'])){ ?>
		<br>
		<div class="alert alert-info col-md-12"> 
			Usted activ&oacute; el filtrado por facetas, en el cual se aplica la Teoría Basada en Rango Sumarizados de Likert Modificada a la premiaci&oacute;n por puntajes.
		</div>
	<?php } ?>
	<br>
	<div class="col-md-12">
	  	<div class="col-md-3 visible-md-inline visible-lg-inline">
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
								    //$ruta = Controlador_Aspirante::calcularRuta($ruta,'Q');
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

			<?php
			if (isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'filtroFacetas',$id_plan) && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) { ?>
			    <div class="panel panel-default shadow-panel1">
					<div class="panel-heading" data-toggle="collapse" href="#facetas-desplegable">
				      <div class="row">
				        <div class="col-md-10" id="drop-tit" >
				          <span><i class="fa fa-comments"></i> Competencias</span>
				        </div>
				        <div class="col-md-2" >
				          <span class="caret"></span>
				        </div>
				      </div>
				    </div>
					<div class="panel-body collapse" id="facetas-desplegable" aria-expanded="false">
						<div id="facetas">
						<?php 
						$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/';
						if (!empty($facetas)) {
							$i = 0;
							$f = '';
							$pos = -1;
							echo '<div class="col-md-12" style="padding-right: 5px;">';
							foreach ($facetas as $key => $v) {
								$letra = $v['literal'];//substr($v,0,1);
								if($letra == 'A' && $i > 1){
									$letra = 'P';
								}
								$f .= $letra.'-';
								//$j = $letra;
								
								$pos += 6;
								
								echo '<div id="fac_'.$i.'" style="float:left;width: 90%;"><div class="p-3">
						                <h6 class="font-16 mb-3 mt-0">'.utf8_encode(ucfirst(strtolower($v['faceta']))).'</h6>
						                <input type="text" id="range_0'.$i.'">
						            </div></div><div id="btn_'.$i.'" style="float:right;padding-top: 40px;cursor:pointer"><a onclick="verFacetas(\''.$letra.'\','.$pos.')"><i class="fa fa-search"></i></a></div>';
								$i++;
							}
							echo '<input type="hidden" name="f" id="f" value="'.$f.'">';
							echo '<input type="hidden" name="ruta" id="ruta" value="'.$ruta.'">';
							echo '<input type="hidden" name="page" id="page" value="'.$page.'">';
							echo "<div class='clearfix'></div><br><a style='display:none' id='btn_consultar' name='btn_consultar' class='btn btn-default' href='#'><i class='fa fa-search'></i></a></div>";
						}else{
							echo 'No hay resultados';
						}
					?></div>
					</div>
			    </div>
		    <?php } ?>

		    <div class="panel panel-default shadow-panel1">
		          <div class="panel-heading" data-toggle="collapse" href="#informe-desplegable">
				      <div class="row">
				        <div class="col-md-10" id="drop-tit" >
				          <span>
				            <i class="fa fa-address-book"></i> Informe de personalidad (prioridad)
				          </span>
				        </div>
				        <div class="col-md-2" >
				          <span class="caret"></span>
				        </div>
				      </div>
				    </div>

				    <div class="panel-body collapse" id="informe-desplegable" aria-expanded="false">
			          	<div class="filtros">
		          			<div class="btn-group" id="status" data-toggle="buttons">
			          			<?php 
			          			if($_SESSION['mfo_datos']['Filtrar_aspirantes']['P'] == 0){
			          				$cont = 1;
			          			}
			          			foreach (PRIORIDAD as $key => $v) { ?>
					              <?php 
					              	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/P'.$key.'/';
							    	//$ruta = Controlador_Aspirante::calcularRuta($ruta,'P');
							    	$ruta .= '1/'; ?>
							    	<label style="padding-left:5px; padding-right: 5px;" onclick="window.location='<?php echo $ruta; ?>'" class="btn btn-default btn-on-3 btn-md <?php if($_SESSION['mfo_datos']['Filtrar_aspirantes']['P'] == $key || ($_SESSION['mfo_datos']['Filtrar_aspirantes']['P'] == 0 && $cont == 1)){ echo 'active'; $cont = count(PRIORIDAD); } ?>">
										<input type="radio" value="<?php echo $key; ?>" name="multifeatured_module[module_id][status]" checked="checked" /><?php echo $v; ?>
									</label>
								<?php 
								} ?>
				            </div>
						 </div>
		          	</div>
		    </div>

		    <div class="panel panel-default shadow-panel1">
				<div class="panel-heading" data-toggle="collapse" href="#res-desplegable">
			      <div class="row">
			        <div class="col-md-10" id="drop-tit" >
			          <span>
			            <i class="fa fa-map-marker"></i> Residencia Actual
			          </span>
			        </div>
			        <div class="col-md-2" >
			          <span class="caret"></span>
			        </div>
			      </div>
			    </div>
			    <div class="panel-body collapse" id="res-desplegable" aria-expanded="false">
					<div class="filtros">
				<?php
					if (!empty($arrprovincia)) {
						foreach ($arrprovincia as $key => $v) {
					    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/U'.$key.'/';
							//$ruta = Controlador_Aspirante::calcularRuta($ruta,'U');
							echo '<li class="lista"><a href="'.$ruta.'1/" class="provincia" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
						}
					}else{
						echo 'No hay resultados';
					}
				?></div>
				</div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
				<div class="panel-heading" data-toggle="collapse" href="#nacional-desplegable">
			      <div class="row">
			        <div class="col-md-10" id="drop-tit" >
			          <span>
			            <i class="fa fa-map"></i> Nacionalidad
			          </span>
			        </div>
			        <div class="col-md-2" >
			          <span class="caret"></span>
			        </div>
			      </div>
			    </div>
			    <div class="panel-body collapse" id="nacional-desplegable" aria-expanded="false">
					<div class="filtros">
				<?php
					if (!empty($nacionalidades)) {
						foreach ($nacionalidades as $key => $v) {
					    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/N'.$key.'/';
							//$ruta = Controlador_Aspirante::calcularRuta($ruta,'N');
							echo '<li class="lista"><a href="'.$ruta.'1/" class="nacionalidad" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
						}
					}else{
						echo 'No hay resultados';
					}
				?></div>
				</div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
				<div class="panel-heading" data-toggle="collapse" href="#areas-desplegable">
			      <div class="row">
			        <div class="col-md-10" id="drop-tit" >
			          <span>
						<i class="fa fa-list-ul"></i> &Aacute;reas de Empleos</span>
					</div>
			        <div class="col-md-2" >
			          <span class="caret"></span>
			        </div>
			      </div>
			    </div>
			    <div class="panel-body collapse" id="areas-desplegable" aria-expanded="false">
					<div class="filtros">
				<?php
				if (!empty($arrarea)) { 
				    foreach ($arrarea as $key => $v) {
				    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/A'.$key.'/';
						//$ruta = Controlador_Aspirante::calcularRuta($ruta,'A');
						echo '<li class="lista"><a href="'.$ruta.'1/" class="area" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
					}
				}
				?></div>
				</div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
			    <div class="panel-heading" data-toggle="collapse" href="#estudios-desplegable">
			      <div class="row">
			        <div class="col-md-10" id="drop-tit" >
			          <span>
			            <i class="fa fa-bar-chart"></i> Nivel de estudio
			          </span>
			        </div>
			        <div class="col-md-2" >
			          <span class="caret"></span>
			        </div>
			      </div>
			    </div>
			    <div class="panel-body collapse" id="estudios-desplegable" aria-expanded="false">
					<div class="filtros">
					<?php
						if (!empty($escolaridad)) {
							foreach ($escolaridad as $key => $v) {
						    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/E'.$key.'/';
								//$ruta = Controlador_Aspirante::calcularRuta($ruta,'E');
								echo '<li class="lista"><a href="'.$ruta.'1/" class="escolaridad" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
							}
						}
				?></div>
				</div>
		    </div>
		    <?php #if ($vista == 1){ ?>
			    <!--<div class="panel panel-default shadow-panel1">
					<div class="panel-heading">
						<span><i class="fa fa-calendar"></i>Fecha de postulaci&oacute;n</span>
					</div>
					<div class="panel-body">
						<div class="filtros">
					<?php						
					    /*foreach (FECHA_POSTULADO as $key => $v) {
					    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/F'.$key.'/';
							//$ruta = Controlador_Aspirante::calcularRuta($ruta,'F');
					    	echo '<li class="lista"><a href="'.$ruta.'1/" class="fecha" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
					    }*/
					?></div>
					</div>
			    </div>-->

			<?php #} ?>

		    <?php if ($vista == 1){ ?>
		   
		      <div class="panel panel-default shadow-panel1">
		      	<div class="panel-heading" data-toggle="collapse" href="#salario-desplegable">
			      <div class="row">
			        <div class="col-md-10" id="drop-tit" >
			          <span><i class="fa fa-money"></i> Salario</span>
			        </div>
			        <div class="col-md-2" >
			          <span class="caret"></span>
			        </div>
			      </div>
			    </div>
			    <div class="panel-body collapse" id="salario-desplegable" aria-expanded="false">
		      	<div class="filtros">
				<?php
					foreach (SALARIO as $key => $v) {
				    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/S'.$key.'/';
						//$ruta = Controlador_Aspirante::calcularRuta($ruta,'S');
						echo '<li class="lista"><a href="'.$ruta.'1/" class="salario" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
					}
				?></div>
		      </div>
		    </div>
		    <?php } ?>

		    <div class="panel panel-default shadow-panel1">
		      	<div class="panel-heading" data-toggle="collapse" href="#edades-desplegable">
			      <div class="row">
			        <div class="col-md-10" id="drop-tit" >
			          <span><i class="fa fa-sort-numeric-asc"></i> Edades</span>
			        </div>
			        <div class="col-md-2" >
			          <span class="caret"></span>
			        </div>
			      </div>
			    </div>
			    <div class="panel-body collapse" id="edades-desplegable" aria-expanded="false">
		      	<div class="filtros">
				<?php
					foreach (EDADES as $key => $v) {
				    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/C'.$key.'/';
						echo '<li class="lista"><a href="'.$ruta.'1/" class="edades">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
					}
				?></div>
		      </div>
		    </div>

		    <div class="panel panel-default shadow-panel1">
		      	<div class="panel-heading" data-toggle="collapse" href="#genero-desplegable">
			      <div class="row">
			        <div class="col-md-10" id="drop-tit" >
			          <span>
			            <i class="fa fa-venus-mars"></i> G&eacute;nero
			          </span>
			        </div>
			        <div class="col-md-2" >
			          <span class="caret"></span>
			        </div>
			      </div>
			    </div>
			    <div class="panel-body collapse" id="genero-desplegable" aria-expanded="false">
		      		<div class="filtros">
					<?php
						foreach (GENERO as $key => $v) {
					    	$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/G'.VALOR_GENERO[$key].'/';
							//$ruta = Controlador_Aspirante::calcularRuta($ruta,'G');
							echo '<li class="lista"><a href="'.$ruta.'1/" class="genero">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
						}
					?></div>
		      	</div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
				<div class="panel-heading" data-toggle="collapse" href="#viajar-desplegable">
			      <div class="row">
			        <div class="col-md-10" id="drop-tit" >
			          <span>
			            <i class="fa fa-plane"></i> Puede viajar?
			          </span>
			        </div>
			        <div class="col-md-2" >
			          <span class="caret"></span>
			        </div>
			      </div>
			    </div>
			    <div class="panel-body collapse" id="viajar-desplegable" aria-expanded="false">
					<div class="filtros">
				<?php
			    	foreach (PUEDE_VIAJAR as $key => $v) {
						$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/V'.$key.'/';
						echo '<li class="lista"><a href="'.$ruta.'1/" class="viajar" id="'.$key.'">'.$v.'</a></li>';
					}
				?></div>
				</div>
		    </div>
		    <!--<div class="panel panel-default shadow-panel1">
		      <div class="panel-heading">
		        <span><i class="fa fa-briefcase"></i> Situaci&oacute;n Laboral</span>
		      </div>
		      <div class="panel-body">
		      	<div class="filtros">
				    <?php
				    	/*foreach ($situacionLaboral as $key => $v) {
							$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/T'.$key.'/';
							echo '<li class="lista"><a href="'.$ruta.'1/" class="trabajo" id="'.$key.'">'.utf8_encode($v).'</a></li>';
					  	}*/ ?>					  	
					</div>
		      </div>
		    </div>-->
		    <div class="panel panel-default shadow-panel1">
				<div class="panel-heading" data-toggle="collapse" href="#lic-desplegable">
				      <div class="row">
				        <div class="col-md-10" id="drop-tit" >
				          <span>
				            <i class="fa fa-id-card-o"></i> Tipo de Licencia
				          </span>
				        </div>
				        <div class="col-md-2" >
				          <span class="caret"></span>
				        </div>
				      </div>
				</div>
				<div class="panel-body collapse" id="lic-desplegable" aria-expanded="false">
					<div class="filtros">
					<?php
						$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/L0/';
						echo '<li class="lista"><a href="'.$ruta.'1/" class="licencia" id="0">Sin licencia</a></li>';
				  		foreach ($licencia as $key => $v) {
							$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/L'.$key.'/';
							echo '<li class="lista"><a href="'.$ruta.'1/" class="licencia" id="'.$key.'">'.$v.'</a></li>';
						} ?>							
					</div>
				</div>
		    </div>
		    <div class="panel panel-default shadow-panel1">
		      <div class="panel-heading" data-toggle="collapse" href="#discapacidad-desplegable">
			      <div class="row">
			        <div class="col-md-10" id="drop-tit" >
			          <span>
			            <i class="fa fa-wheelchair"></i> Discapacidad
			          </span>
			        </div>
			        <div class="col-md-2" >
			          <span class="caret"></span>
			        </div>
			      </div>
			    </div>
			    <div class="panel-body collapse" id="discapacidad-desplegable" aria-expanded="false">
		      	<div class="filtros">
				<?php
					foreach (DISCAPACIDAD as $key => $v) {
						$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/D'.$key.'/';
						echo '<li class="lista"><a href="'.$ruta.'1/" class="discapacidad" id="'.$key.'">'.$v.'</a></li>';
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
						<input type="text" maxlength="30" class="form-control" id="inputGroup1" placeholder="Ej: Enfermero(a) &oacute; xx-xx-xxxx" /> 
					</div>
					<div class="form-group" id="facetas_movil">
						<?php
							$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/';
							if (!empty($facetas)) {
								$i = 5;
								$f = '';
								$pos = -1;
								echo '<div class="col-md-12" style="padding-right: 5px;">';
								foreach ($facetas as $key => $v) {
									$letra = $v['literal'];//substr($v,0,1);
									if($letra == 'A' && $i > 6){
										$letra = 'P';
									}
									$f .= $letra.'-';
									$pos += 6;
									
									echo '<div id="fac_'.$i.'" style="float:left;width: 100%;"><div class="p-3">
							                <h6 class="font-16 mb-3 mt-0">'.utf8_encode(ucfirst(strtolower($v['literal']))).'</h6>
							                <input type="text" id="range_0'.$i.'">
							            </div></div>';
									$i++;
								}
								echo '</div>';
							}else{
								echo '<br><br><div class="breadcrumb">No hay resultados</div>';
							}
						?>
					</div>	

					<div class="form-group">
			            <select id="informe" class="form-control">
			                <option value="0">Seleccione un tipo de informe</option>
			                <?php
								foreach (PRIORIDAD as $key => $v) {
									echo '<option value="'.$key.'">'.utf8_encode(ucfirst(strtolower($v))).'</option>';
								}
							?>                    
			            </select>
			        </div>  

			        <div class="form-group">
			            <select id="provincia" class="form-control">
			                <option value="0">Seleccione una provincia de residencia</option>
			                <?php
								foreach ($arrprovincia as $key => $v) {
									echo '<option value="'.$key.'">'.utf8_encode(ucfirst(strtolower($v))).'</option>';
								}
							?>                    
			            </select>
			        </div>

			        <div class="form-group">
			            <select id="nacionalidad" class="form-control">
			                <option value="0">Seleccione una nacionalidad</option>
			                <?php
								foreach ($nacionalidades as $key => $v) {
									echo '<option value="'.$key.'">'.utf8_encode(ucfirst(strtolower($v))).'</option>';
								}
							?>                    
			            </select>
			        </div>

			        <div class="form-group">
			            <select id="areas" class="form-control">
			                <option value="0">Seleccione un &aacute;rea de inter&eacute;s</option>
			                <?php
								foreach ($arrarea as $key => $v) {
									echo '<option value="'.$key.'">'.utf8_encode(ucfirst(strtolower($v))).'</option>';
								}
							?>                    
			            </select>
			        </div>

                	<div class="form-group">
			            <select id="escolaridad" class="form-control">
			                <option value="0">Seleccione un nivel de estudio</option>
			                <?php
								foreach ($escolaridad as $key => $v) {
									echo '<option value="'.$key.'">'.utf8_encode(ucfirst(strtolower($v))).'</option>';
								}
							?>                    
			            </select>
			        </div>
			        
			        <!--<div class="form-group">
			            <select id="postulado" class="form-control">
			                <option value="0">Seleccione una fecha de postulaci&oacute;n</option>
			                <?php
								/*foreach (FECHA_POSTULADO as $key => $v) {
									echo '<option value="'.$key.'">'.utf8_encode(ucfirst(strtolower($v))).'</option>';
								}*/
							?>                    
			            </select>
			        </div>-->

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
			            <select id="viajar" class="form-control">
			                <option value="0">Seleccione una edad</option>
			                <?php
								foreach (EDADES as $key => $v) {
									echo '<option value="'.$key.'">'.utf8_encode(ucfirst(strtolower($v))).'</option>';
								}
							?>                    
			            </select>
			        </div> 

			        <div class="form-group">
			            <select id="genero" class="form-control">
			                <option value="0">Seleccione un g&eacute;nero</option>
			                <?php
								foreach (GENERO as $key => $v) {
									echo '<option value="'.$key.'">'.utf8_encode(ucfirst(strtolower($v))).'</option>';
								}
							?>                    
			            </select>
			        </div> 

			        <div class="form-group">
			            <select id="viajar" class="form-control">
			                <option value="0">Puede viajar?</option>
			                <?php
								foreach (PUEDE_VIAJAR as $key => $v) {
									echo '<option value="'.$key.'">'.utf8_encode(ucfirst(strtolower($v))).'</option>';
								}
							?>                    
			            </select>
			        </div> 
			        <!--
			        <div class="form-group">
			            <select id="trabajo" class="form-control">
			                <option value="0">Situcaci&oacute;n Laboral</option>
							<?php
					    		/*foreach ($situacionLaboral as $key => $v) {
									echo '<option value="'.$key.'">'.utf8_encode($v).'</option>';
						  		}*/ ?>                    
			            </select>
			        </div>-->

			        <div class="form-group">
			        	<select id="licencia" class="form-control">
			                <option value="-1">Tipo de Licencia</option>    
							<?php
							echo '<option value="0">Sin licencia</option>';
					  		foreach ($licencia as $key => $v) {
								echo '<option value="'.$key.'">'.utf8_encode(ucfirst(strtolower($v))).'</option>';
							} ?>               
			            </select>
			        </div>

			        <div class="form-group">
			            <select id="discapacidad" class="form-control">
			                <option value="0">Discapacidad</option>
			                <?php
								foreach (DISCAPACIDAD as $key => $v) {
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

		<?php if($_SESSION['mfo_datos']['accesos'] == 1){ 
			$style_activo = 'style="display:none"';
			$style_desactivo = 'style="display:block"';
		 }else{ 				            			
			$style_activo = 'style="display:block"';
			$style_desactivo = 'style="display:none"';
		 } ?>
		
		<div class="col-md-9"> 
			
			<?php if(($vista == 1 && $num_accesos_rest > 0) || $vista == 2){ ?> 
				<br>
				<div <?php echo $style_activo; ?> id="activarAccesos" class="pull-right">
		          <h6 style="color:#6d6d6b">
		            <button id="activar-accesos" type="button" class="btn-blue" data-placement="bottom" data-toggle="tooltip" data-html="true" title="" data-original-title="<i class='fa fa-info-circle fa-2x'></i><br/><p>Buenas noticias, puedes enviar accesos a los candidatos que elijas para que rindan el test completo. Y mejor aún, ¡puedes completar el proceso de selección!</p>">Activar accesos</button>
		          </h6>
		        </div>

				<div <?php echo $style_desactivo; ?> id="desactivarAccesos" class="pull-right">
					<a id="btn_accesos_cancelar" class="btn-red solo-texto dis-mov">Cancelar</a>
					<a id="btn_accesos_confirmar" class="btn-blue solo-texto dis-mov">Enviar accesos</a>
					<?php if($vista == 1){ ?> 
						<div class="restante" align="right"> 
							<b>N&uacute;mero de accesos restantes: 
							  <span class="parpadea" style="color:red">
							    <?php echo $num_accesos_rest; ?>					
							  </span>
						  </b> 
						</div>
					<?php } ?>
				</div>
				<div class="clearfix"></div>
			<?php } ?>
			
			
			<?php if($vista == 2){ ?>
				<div id="planes" class='panel panel-default shadow'>
					<div class="panel-heading">
						<label class="panel-title pull-left" for="listadoPlanes">Planes con accesos disponibles</label>
				        <button type="button" id="cerrar_accesos" class="close">&times;</button><div id="err_gen" class="help-block with-errors"></div>
				        <div class="clearfix"></div>
				    </div>
					<div class='panel-body'>
						<div class="form-group">
				            <select id="listadoPlanes" class="form-control">
				                <option disabled selected value="0">Seleccione un plan con accesos</option>
				                <?php 
									foreach ($listado_planes as $key => $v) {
										if($v['num_accesos_rest'] > 0){
											echo '<option value="'.Utils::encriptar($v['id_usuario_plan']).'"';
											if(!empty($_SESSION['mfo_datos']['planSeleccionado']) && $_SESSION['mfo_datos']['planSeleccionado'] == Utils::encriptar($v['id_usuario_plan']))
											{
												echo ' selected="selected"';
											}
											echo '>'.utf8_encode(ucfirst(strtolower($v['nombre']))).'('.date("Y-m-d", strtotime($v['fecha_compra'])).') - '.$v['num_accesos_rest'].' accesos</option>';
										}
									}
								?>                    
				            </select>
				        </div>
		    		</div>
		    	</div>
	    	<?php } ?>
		
			<div id="busquedas" class='container-fluid'>
				<?php if (isset($link)) { 
				 echo $link; 
				} ?>
			</div>
			
	        <div id="result">
	        	<div class='panel panel-default shadow'>
					<div class='panel-body'>
						<div id="no-more-tables" class="table-responsive">
			              <table class="table table-hover">
			                <thead class="etiquetaBody">
							      <tr>
							      	<th id="marcar" style="vertical-align: middle; text-align: center; border-bottom:0; <?php if($_SESSION['mfo_datos']['accesos'] == 1){ echo "display:block;"; }else{ echo "display:none;"; } ?>">Accesos</th>
							      	<!--<th id="marcar" style="vertical-align: middle; text-align: center; border-bottom:0; <?php #if($_SESSION['mfo_datos']['accesos'] == 1){ echo "display:block;"; }else{ echo "display:none;"; } ?>"><input type="checkbox" name="marcarTo" id="marcarTo" <?php #if(empty($_SESSION['mfo_datos']['planSeleccionado']) && $vista == 2){ echo 'disabled="disabled" title="Debe seleccionar un plan"'; } ?> <?php #if(!empty($_SESSION['mfo_datos']['usuarioSeleccionado'])){ #echo 'checked'; } ?>></th>-->
							      	<th style="vertical-align: middle; text-align: center;">Foto</th>
									<th colspan="1" style="vertical-align: middle; text-align: center;">Nombre y Apellido</th>
							        <th style="vertical-align: middle; text-align: center;width: 100px">
										<?php 
											$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/O1'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['O'].'/';
										?>
							           <a href="<?php echo $ruta.'1/'; ?>">Edad <i class="fa fa-sort"></i></a>
							        </th>
							        <?php if($vista == 1) { ?>
								        <th style="vertical-align: middle; text-align: center;">
											<?php 
												$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/O2'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['O'].'/';
											
											?>
								           <a href="<?php echo $ruta.'1/'; ?>"><?php echo 'Postulado hace'; ?><i class="fa fa-sort"></i></a>
								        </th>
							    	<?php } ?>
							    	<?php 
							    	$r = 3;
							    	
							    	foreach($facetas as $key => $nombre){ 
							    		echo "<th style='vertical-align: middle; text-align: center;'>".$nombre['literal']."</th>";
								        $r++;
							    	} ?>
							        <th style="vertical-align: middle; text-align: center;" title="Nivel de Estudios">
							        	<?php 
											$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/O3'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['O'].'/';
										?>
							           <a href="<?php echo $ruta.'1/'; ?>">Estudios<i class="fa fa-sort"></i></a>
							       </th>

							        <?php if($vista == 1) { ?>
								        <th style="width: 100px; vertical-align: middle; text-align: center;" title="Aspiraci&oacute;n Salarial">
								        	<?php 
												$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/O4'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['O'].'/';
											?>
								           <a href="<?php echo $ruta.'1/'; ?>">Salario<i class="fa fa-sort"></i></a>
								       </th>
								   <?php } ?>
								   	<?php if(($datosOfertas == false) || (isset($datosOfertas[0]['id_empresa']) && !in_array($datosOfertas[0]['id_empresa'], $array_empresas))/*|| in_array('-1',$posibilidades)*/){ ?>
							        	<th colspan="2" style="vertical-align: middle; text-align: center;">Acci&oacute;n</th>
							    	<?php } ?>
							      </tr>
							    </thead>
				        		<tbody>
						        	<?php 	
				        			//$_SESSION['mfo_datos']['registrosPagina']);
						        	if(!empty($aspirantes)){ 
						        		for ($i=0; $i < count($aspirantes); $i++) { 
						        			$a = $aspirantes[$i]; 
						        			$id_Usuario = Utils::encriptar($a['id_usuario']);
											if($page > 1){
						        				$num_aumentar = ($page-1)*REGISTRO_PAGINA;
						        			}else{
						        				$num_aumentar = 0;
						        			}
						        			if(!empty($limite_plan)){
						        				$ver = false;
						        				if($i < $limite_plan && ($num_aumentar+$i) <= $limite_plan-1){
						        					$ver = true;
						        				}
						        			}else{
						        				$ver = true;
						        			}
						        			
						        			/*echo '<br>i: '.$i;
						        			echo '<br>limite-1: '.($limite_plan-1);
						        			echo '<br>num_aumentar: '.$num_aumentar;*/
						        			?>
							            	<tr>
							            		<?php if($_SESSION['mfo_datos']['accesos'] == 1){ 
							            			$display = 'display:block; vertical-align: middle; text-align: center;';
							            		}else{
							            			$display = 'display:none; vertical-align: middle; text-align: center;';
							            		} ?>
							            		<td style="<?php echo $display; ?>" class="checkboxes">
							            			<?php 
							            			$mostrar = '';
							            			if($a['test_realizados'] == Modelo_Usuario::TEST_PARCIAL){ 
							            				if(!in_array($id_Usuario, $_SESSION['mfo_datos']['usuariosHabilitados'])){
							            					array_push($_SESSION['mfo_datos']['usuariosHabilitados'],$id_Usuario);
							            				}
							            				if(array_key_exists($a['id_usuario'],$usuariosConAccesos) && $usuariosConAccesos[$a['id_usuario']] == ''){
															
							            					$mostrar = 'Acceso Enviado';
							            				}
							            			
								            			if($mostrar == ''){
													?>
							            				<input type="checkbox" class="check_usuarios" <?php if(empty($_SESSION['mfo_datos']['planSeleccionado']) && $vista == 2){ echo 'disabled="disabled" title="Debe seleccionar un plan" '; } if(in_array($id_Usuario,$_SESSION['mfo_datos']['usuarioSeleccionado'])){ echo 'checked'; } ?> id="<?php echo $id_Usuario; ?>" name="usuarios_check" onclick="marcarSeleccionado('<?php echo $id_Usuario; ?>')">
							            			<?php }else{
							            				echo '-'; 
							            			   }
							            		    }else{ echo '-'; } ?>
							            		</td>
							            		<!--<td data-title="N°: " style='vertical-align: middle; text-align: center;'><?php #echo $num_aumentar+($i+1); ?></td>-->

							            		<td align="right" style="text-align: center;" data-title="Foto: ">
							                      <img class="imagen-perfil-2" src="<?php echo Modelo_Usuario::obtieneFoto($a['username']); ?>" alt="perfil" >
							                    </td>
							            		
							            		
							            		<td data-title="Aspirante: " style="vertical-align: middle; text-align: center;">

							            			<?php
								            			if (isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'detallePerfilCandidatos',$id_plan) && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA && $ver == true) {
								            				echo '<a href="'.PUERTO."://".HOST."/aspirante/".$a['username'].'/'.$id_oferta.'/'.$vista.'/">'.utf8_encode($a['nombres']).' '.utf8_encode($a['apellidos']).'</a>'; 
								            			}else{
								            				if(!$ver){ 
								            					echo '-';
								            				}else{
								            					echo '<a href="#" onclick="abrirModal(\'Debe contratar un plan que permita ver los datos del candidato\',\'alert_descarga\',\''.PUERTO."://".HOST."/planes/".'\',\'Ok\',\'\')">'.$a['nombres'].' '.$a['apellidos'].'</a>';
								            				} 
								            			} 
							            			?>
												</td>
												
							            		<td data-title="Edad: " style="vertical-align: middle; text-align: center;" class="text-center"><?php echo $a['edad']; ?></td>
													<?php if($vista == 1){ 
													$date1 = new DateTime(str_replace('00:00:00', '', $a['fecha_postulado']));
													$date2 = new DateTime(date('Y-m-d'));
													$diff = $date1->diff($date2);
													$diff->days . ' d&iacute;as';
 
													?>
							            			<td data-title="Postulado hace: " style="vertical-align: middle; text-align: center;" class="text-center"><?php echo $diff->days . ' d&iacute;as'; /*echo date("d", strtotime($a['fecha_postulado'])).' de '.MESES[date("m", strtotime($a['fecha_postulado']))].', '.date("Y", strtotime($a['fecha_postulado']));*/ ?></td>
												<?php } ?>
												<?php foreach($facetas as $key => $nombre){ 
										    		echo "<td data-title='".$nombre['literal']/*substr($nombre, 0,1)*/.":' style='vertical-align: middle; text-align: center;'>";
										    		if(isset($datos_usuarios[$a['id_usuario']][$key])){ 
										    			echo $datos_usuarios[$a['id_usuario']][$key].'%';
										    		}else{ 
										    			echo '0.00%';
										    		}
										    		echo "</td>";
										    	} ?>
												<td data-title="Estudios: " style="vertical-align: middle; text-align: center;"><?php echo utf8_encode($a['estudios']); ?></td>

												<?php if($vista == 1){ 
													$compl_url = $id_oferta."/"; ?>
													<td data-title="Salario: " style="vertical-align: middle; text-align: center;"><?php echo SUCURSAL_MONEDA.number_format($a['asp_salarial'],2); ?></td>
												<?php }else{
													$compl_url = '';
												} ?>

												<?php 

													echo '<td title="Descargar Informe de personalidad ';
								            			//$color = '';
								            			$title = 'completo';
								            			if($a['numero_test'] == Modelo_Usuario::COMPLETO_TEST){
						            						$imagen = 'icono-aspirante-05.png';
						            					}else{
						            						$imagen = 'icono-aspirante-07.png';
						            					}

								            			if($a['test_realizados'] == Modelo_Usuario::TEST_PARCIAL){

								            				if(array_key_exists($a['id_usuario'],$usuariosConAccesos) && $usuariosConAccesos[$a['id_usuario']] != ''){
								            					//$color = '';
								            					$title = 'completo';

								            					if($a['numero_test'] == Modelo_Usuario::COMPLETO_TEST){
								            						$imagen = 'icono-aspirante-05.png';
								            					}else{
								            						$imagen = 'icono-aspirante-07.png';
								            					}
								            				}else{
									            				//$color = ' parcial';
									            				$title = 'parcial';	

									            				if($a['numero_test'] == Modelo_Usuario::PRIMER_TEST){
									            					$imagen = 'icono-aspirante-06.png';
									            				}else if($a['numero_test'] == Modelo_Usuario::SEGUNDO_TEST){
									            					$imagen = 'icono-aspirante-07.png';
									            				}
									            				
								            				}
								            			}
								            			echo $title.'" data-title="Informe '.$title.'" style="vertical-align: middle; text-align: center;">';
									            		if (isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'descargarInformePerso',$id_plan) && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA && $ver == true) {
									            			if($mostrar == ''){
																echo '<a target="_blank" href="'.PUERTO."://".HOST."/fileGEN/informeusuario/".Utils::encriptar($id_plan).'/'.$id_oferta.'/'.$a['username'].'/"><img src="'.PUERTO."://".HOST.'/imagenes/'.$imagen.'" class="redes-mic" width="100%"></a>';
															}else{
																echo $mostrar;
															}
														}else{
						
															if($mostrar == ''){
																if(!$ver){
																	echo '-';
																}else{
																	echo '<a href="#" onclick="abrirModal(\'Debe contratar un plan que permita descargar informes de personalidad\',\'alert_descarga\',\''.PUERTO."://".HOST."/planes/".'\',\'Ok\',\'\')"><img src="'.PUERTO."://".HOST.'/imagenes/'.$imagen.'" class="redes-mic" width="100%"></a>';
																}
															}else{
																echo $mostrar;
															}
														}
													
													echo '</td>';
												?>

												<?php if(($datosOfertas == false) || (isset($datosOfertas[0]['id_empresa']) && !in_array($datosOfertas[0]['id_empresa'], $array_empresas)) /*|| in_array('-1',$posibilidades)*/){ ?>
													<td title="Descargar Hoja de vida" data-title="Hoja de vida: " style="vertical-align: middle; text-align: center;">
									            		<?php 
										            		if (isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'descargarHv',$id_plan) && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA && $ver == true) {
										            			//if(in_array('-1',$posibilidades)){
																	echo '<a target="_blank" href="'.PUERTO."://".HOST."/hojasDeVida/".$a['username'].'/'.$compl_url.'"><img src="'.PUERTO."://".HOST.'/imagenes/cv-07.png" class="redes-mic" width="100%"></a>';
																/*}else{
																	$cantidadRestante = $posibilidades - count($descargas);
																	if($cantidadRestante > 0){
																		echo '<a target="_blank" href="'.PUERTO."://".HOST."/hojasDeVida/".$a['username'].'/'.$compl_url.'"><i class="fa fa-file-text fa-1x"></i></a>';
																	}else{
																		echo '<a href="#" onclick="abrirModal(\'Debe contratar un plan que permita descargar hojas de vida\',\'alert_descarga\',\''.PUERTO."://".HOST."/planes/".'\',\'Ok\',\'\')"><i class="fa fa-file-text fa-1x"></i></a>';
																	//}
																}*/
															}else{
																if(!$ver){
																	echo '-';
																}else{
																	echo '<a href="#" onclick="abrirModal(\'Debe contratar un plan que permita descargar hojas de vida\',\'alert_descarga\',\''.PUERTO."://".HOST."/planes/".'\',\'Ok\',\'\')"><img src="img/cv-07.png" class="redes-mic" width="100%"></a>';
																}
															}
														?>
													</td>
												<?php } ?>
							            	</tr>
										<?php }
									}else{ ?>
									    <tr>
									      <td colspan="12" class="text-center">No hay resultados</td>
									    </tr>
								  	<?php 
								    } ?>
								</tbody>
							</table>
							<?php 
							if(!empty($_SESSION['mfo_datos']['Filtrar_aspirantes']['R']) && $_SESSION['mfo_datos']['Filtrar_aspirantes']['R'] != ''){
								$facetas_porcentajes = array();
								$literales = array();
								$exp = '/';
								$j = 0;
								foreach ($facetas as $clave => $c) {
									$letra = $c['literal'];//substr($c,0,1);
									if($letra == 'A' && $j > 1){
									  $letra = 'P';
									}
									$pos = strstr($_SESSION['mfo_datos']['Filtrar_aspirantes']['R'], $letra);
									if($pos !== false){
									  $exp .= '('.$letra.'[0-9]{1,3})';
									  $literales[$letra] = $clave;
									}
									$j++;
								}
								$exp .= '/';
								preg_match_all($exp,$_SESSION['mfo_datos']['Filtrar_aspirantes']['R'],$salida, PREG_PATTERN_ORDER);
								unset($salida[0]);
								foreach ($salida as $key => $value) {
									$l = substr($value[0],0,1);
									$i = substr($value[0],1);
									$facetas_porcentajes[$literales[$l]] = $i;
								}
								$b = 0;
								foreach ($facetas as $clave => $c) {
									$l = $c['literal'];//substr($c,0,1);
									if($l == 'A' && $b > 1){
									  $l = 'P';
									}
									if(isset($facetas_porcentajes[$clave])){
										echo '<input type="hidden" name="'.$l.'" id="'.$l.'" value="'.$facetas_porcentajes[$clave].'">';
									}else{
										echo '<input type="hidden" name="'.$l.'" id="'.$l.'" value="0">';
									}
									$b++;
								}
								
  							}?>
						</div>
						
					</div>
				</div>
				<input type="hidden" name="vista" id="vista" value="<?php echo $vista; ?>">
				<input type="hidden" name="accesos" id="accesos" value="<?php echo $_SESSION['mfo_datos']['accesos']; ?>">
				<input type="hidden" name="planOf" id="planOf" value="<?php echo Utils::encriptar($id_empresa_plan); ?>">

				<form role="form" name="form_enviarAccesos" id="form_enviarAccesos" method="post" action="<?php echo $ruta_redirect.'/'.$page.'/'; ?>">
					<input type="hidden" name="enviar_accesos" id="enviar_accesos" value="1">
				</form>
	        </div>
	        <div class="col-md-12">
				<?php echo $paginas; ?>
			</div>
		
		<?php 

			if(!empty($limite_plan) && $_SESSION['mfo_datos']['usuario']['cantd_total'][Utils::desencriptar($id_oferta)] > $limite_plan){ 
				if(isset($_SESSION['mfo_datos']['usuario']['ofertaConvertir']) && !empty($_SESSION['mfo_datos']['usuario']['ofertaConvertir'])){ 
					echo '<input type="hidden" name="ofertaConvertir" id="ofertaConvertir" value="'.$_SESSION['mfo_datos']['usuario']['ofertaConvertir'].'">';
				}else{
					//$_SESSION['mfo_datos']['usuario']['ofertaConvertir'] = $id_oferta;
					echo '<input type="hidden" name="cantd_planes" id="cantd_planes" value="'.count($planes).'">
					<input type="hidden" name="idOferta" id="idOferta" value="'.$id_oferta.'">';
					?>
					<div id="convertirOferta">
					  <div class="col-md-6">
					    <p style="text-align: right;" class="qs-text">Mira todos los perfiles y elige al mejor candidato!</p>
					  </div>
					  <div class="col-md-6">
					    <button id="btn_convertir" type="button" class="btn-blue" data-placement="bottom" data-toggle="tooltip" data-html="true" title=""><?php if(count($planes)!=0){ echo 'COMPLETAR'
							; }else{ echo 'CONTRATAR'; } ?> AHORA</button>
					  </div>
					</div>
				<?php 
				} 
			} ?>
		</div>
	</div>
</div>

<div class="modal fade" id="convertir" tabindex="-1" role="dialog" aria-labelledby="convertir" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog" role="document">    
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="titulo-modal-hoja modal-title">Convertir Oferta</h5>               
      </div>
      	<form action = "<?php echo PUERTO."://".HOST;?>/convertir/" method = "post" id="form_convertir" name="form_convertir">
	        <div class="modal-body">
		        <div class="row">
		            <div class="col-md-12">
						<div class="col-md-12">
							<p id="titulo_oferta"></p>
						</div>
						<div class="hoja-archivo col-md-12">
							<p>Seleccione plan:</p><br>
						</div>
						<div id="select-plan">
							<select name="planUsuario_convertir" id="planUsuario_convertir" class="form-control">
								<?php
								foreach ($planes as $plan) {							
									echo "<option value='".Utils::encriptar($plan['id_empresa_plan'])."'>Plan ".utf8_encode($plan['nombre'])."(".date('Y-m-d',strtotime($plan['fecha_compra'])).") - ".$plan['num_publicaciones_rest']." publicaciones</option>";
								}
								?>
							</select>
						</div>
		        	</div>
		      	</div>
	        </div>
    	</form>
        <input type="hidden" name="convertirOferta" id="convertirOferta" value="1">
        <div class="modal-footer" style="text-align: center !important;">
          <button type="button" id="button_convertir_oferta" name="button_convertir_oferta" class="btn-light-blue" data-dismiss="modal">convertir</button>
          <button type="button" id="cancelar_conversion" name="cancelar_conversion" class="btn-red" data-dismiss="modal">cancelar</button>
        </div>
    </div>    
  </div>
</div>﻿

<div class="modal fade" id="aviso_accesos" tabindex="-1" role="dialog" aria-labelledby="aviso_accesos" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog" role="document">    
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="titulo-modal-hoja modal-title" id="title">ACTIVAR ACCESOS    
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
    	</h5>              
      </div>
		<div class="modal-body">
			<div class="row">
			  	<div class="col-md-12">
		            <div class="col-md-12">
		              <p>Los accesos tienen como funcionalidad, permitir que las empresas completen el proceso de selección</p><hr>
		            </div>
		            <div class="col-md-8">
		              <p class="subt"><b>Beneficios </b></p>
		              <li class="qs-text-lista"><p class="lista-valores">La empresa puede completar el proceso de selección de personal.</p></li>
		              <li class="qs-text-lista"><p class="lista-valores">La empresa puede escoger el (los) candidato (s) para finalizar el test de personalidad CANEA.</p></li>
		              <li class="qs-text-lista"><p class="lista-valores">La empresa puede activar uno o varios accesos, de acuerdo al plan contratado. </p></li>
		            </div>
		            <div class="col-md-4" style="text-align: center !important;"><br><br><br><br>
		              <button style="padding: 15px !important" type="button" class="btn-light-blue" data-dismiss="modal">Aceptar</button>
		            </div>
		            <div class="col-md-12">
		              <hr>
		            </div>
		          </div>
			</div>
		</div>
    </div>    
  </div>
</div>

<section style="background-color: grey;color: white; text-align:center" id="product" class="inicio">
  <div class="container">
    <div class="col-md-12">
      <label>PUBLICIDAD</label>
    </div>
  </div>
</section>
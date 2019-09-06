<style>
	.shadow-panel1{
		cursor:pointer;
	}
</style>

<?php 

$empresa_hija = false;
if(($datosOfertas == false) || (isset($datosOfertas['id_empresa']) && !in_array($datosOfertas['id_empresa'], $array_empresas))){
	$empresa_hija = true;
}else{
	$nombre_empresa = utf8_encode($datosOfertas['nombres']);
} ?>

<div class="container">
  <div class="text-center">
    <h2 class="titulo">
    <?php if($vista == 1){ ?>
		Aspirantes Postulados <?php if(isset($nombre_empresa)){ echo ' - '.$nombre_empresa; }else{
			echo ' - '.utf8_encode($datosOfertas['titulo']);
		} ?>
	<?php }else{ ?>
		Candidatos Registrados 
	<?php }?>	
	</h2>
  </div>
</div>

<br>
<div class=" banner-publicidad" align="center">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="banner-light col-md-9 click ">est&aacute; a un solo click de encontrar el <b>candidato ideal</b></div>
        <button class="btn-blue-2 pulse animated infinite col-md-2"><a href="<?php echo PUERTO."://".HOST;?>/publicar/">Publicar Oferta</a></button>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
	<?php  
	if(!empty($limite_plan) && $_SESSION['mfo_datos']['usuario']['cantd_total'][Utils::desencriptar($id_oferta)] > $limite_plan){ ?>
		<br>
		<div class="alert alert-info col-md-12"> 
			Usted tiene un <b>Plan <?php echo utf8_encode($nombre_plan); ?></b>, en esta oferta existen <b><?php echo $_SESSION['mfo_datos']['usuario']['cantd_total'][Utils::desencriptar($id_oferta)]; ?> postulados</b> pero solo puede visualizar <b><?php echo $limite_plan; ?></b>.
			<?php if($datosOfertas['estado'] == Modelo_Oferta::DENTRODELTIEMPO){ ?>
				<br>Usted está dentro del tiempo límite de la oferta, por tal razón puede vizualizar los candidatos más no descargar su información.
			<?php } ?>
		</div>
	<?php }else if($datosOfertas['estado'] == Modelo_Oferta::DENTRODELTIEMPO){ ?>
		<br>
		<div class="alert alert-info col-md-12"> 
			Usted está dentro del tiempo límite de la oferta, por tal razón puede vizualizar los candidatos más no descargar su información.
		</div>
	<?php } ?>


	<?php if(!empty($_SESSION['mfo_datos']['Filtrar_aspirantes']['R'])){ ?>
		<br>
		<div class="alert alert-info col-md-12" style="font-size: 14pt;"> 
	    	Usted activ&oacute; el <b>filtro por competencias,</b> estos son los mejores candidatos.
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
				<!-- <input type="hidden" name="oferta" id="oferta" value="<?php echo $id_oferta; ?>"> -->
				<div class="panel-heading">
				    <span><i class="fa fa-key"></i> Palabra Clave</span>
				</div>
				<div class="panel-body">
					<div class="filtros">
						<div class="form-group">
						    <div class="input-group">
							    <input type="text" onkeyup="javascript: predictWord($(this), 'aspirantes', <?php echo "'".$id_oferta."'"; ?>);" maxlength="30" class="form-control" id="inputGroup" aria-describedby="inputGroup" placeholder="Ej: Enfermero(a) &oacute; xx-xx-xxxx" /> 
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
						                <h6 class="font-16 mb-3 mt-0">'.$v['literal'].' - '.utf8_encode(ucfirst(strtolower($v['faceta']))).'</h6>
						                <input type="text" id="range_0'.$i.'">
						            </div></div><div id="btn_'.$i.'" data-placement="top" data-toggle="tooltip" data-html="true" data-original-title="<i class=\'fa fa-info-circle fa-2x\'></i><br/><p>Se mostrar&aacute;n candidatos &uacute;nicamente con esta competencia. </p>" style="float:right;padding-top: 40px;cursor:pointer"><a onclick="verFacetas(\''.$letra.'\','.$pos.')"><i class="fa fa-search"></i></a></div>';
								$i++;
							}
							echo '<input type="hidden" name="f" id="f" value="'.$f.'">';
							echo '<input type="hidden" name="ruta" id="ruta" value="'.$ruta.'">';
							echo '<input type="hidden" name="page" id="page" value="'.$page.'">';
							echo "<div class='clearfix'></div><br><a style='display:none' id='btn_consultar' name='btn_consultar' data-placement='top' data-toggle='tooltip' data-html='true' data-original-title='<i class=\"fa fa-info-circle fa-2x\"></i><br/><p>Se mostrar&aacute;n &uacute;nicamente candidatos con las competencias seleccionadas. </p>' class='btn btn-default' href='#'><i class='fa fa-search'></i></a></div>";
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
				            <i class="fa fa-address-book"></i> Informe de competencias laborales (prioridad)
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
		    <div class="panel panel-default shadow-panel1">
				<div class="panel-heading" data-toggle="collapse" href="#situacion-desplegable">
			      <div class="row">
			        <div class="col-md-10" id="drop-tit" >
			          <span>
			            <i class="fa fa-briefcase"></i> Situaci&oacute;n Laboral
			          </span>
			        </div>
			        <div class="col-md-2" >
			          <span class="caret"></span>
			        </div>
			      </div>
			    </div>
			    <div class="panel-body collapse" id="situacion-desplegable" aria-expanded="false">
					<div class="filtros">
					<?php
			    	foreach ($situacionLaboral as $key => $v) {
						$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/T'.$key.'/';
						echo '<li class="lista"><a href="'.$ruta.'1/" class="trabajo" id="'.$key.'">'.utf8_encode($v).'</a></li>';
					} ?>
				  	</div>
				</div>
		    </div>
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

		    <div class="panel panel-default shadow-panel1">
		      <div class="panel-heading" data-toggle="collapse" href="#tiene_auto-desplegable">
			      <div class="row">
			        <div class="col-md-10" id="drop-tit" >
			          <span>
			            <i class="fa fa-car"></i> Auto propio
			          </span>
			        </div>
			        <div class="col-md-2" >
			          <span class="caret"></span>
			        </div>
			      </div>
			    </div>
			    <div class="panel-body collapse" id="tiene_auto-desplegable" aria-expanded="false">
		      	<div class="filtros">
				<?php
					foreach (TIENE_AUTO as $key => $v) {
						$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/W'.$key.'/';
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
						<input type="text" maxlength="30" onkeyup="javascript: predictWord($(this), 'aspirantes', <?php echo "'".$id_oferta."'"; ?>);" class="form-control" id="inputGroup1" placeholder="Ej: Enfermero(a) &oacute; xx-xx-xxxx" /> 
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
			            <select id="edad" class="form-control">
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
									echo '<option value="'.VALOR_GENERO[$key].'">'.utf8_encode(ucfirst(strtolower($v))).'</option>';
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
			        
			        <div class="form-group">
			            <select id="trabajo" class="form-control">
			                <option value="0">Situcaci&oacute;n Laboral</option>
							<?php
					    		foreach ($situacionLaboral as $key => $v) {
									echo '<option value="'.$key.'">'.utf8_encode($v).'</option>';
						  		} ?>                    
			            </select>
			        </div>

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
			            <select id="veh_propio" class="form-control">
			                <option value="0">Vehículo propio</option>
			                <?php
								foreach (TIENE_AUTO as $key => $v) {
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
			
			<?php if(($vista == 1 && $num_accesos_rest > 0 && $empresa_hija == true && $datosOfertas['estado'] == Modelo_Oferta::ACTIVA) || $vista == 2){ ?> 
				<br>
				<div <?php echo $style_activo; ?> id="activarAccesos" class="pull-right">
		          <h6 style="color:#6d6d6b">
		            <button style="float: right;" id="activar-accesos" type="button" class="btn-blue" data-placement="bottom" data-toggle="tooltip" data-html="true" title="" data-original-title="<i class='fa fa-info-circle fa-2x'></i><br/><p>Buenas noticias, puedes enviar accesos a los candidatos que elijas para que rindan el test completo.</p>">Activar accesos</button>
		          </h6>
		          <?php if(count($usuariosConAccesos) > 0){ ?>
		          	<p style="padding-top: 10px;color: #a5a5a5; float: right;" class="bounce infinite form-text text-muted">El color de fondo <span style="background-color: #bbdcf9; width: 50px; border: 1px solid #aaa">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> indica a los usuarios que se les env&iacute;o accesos.</p>
		          <?php } ?>
		        </div>

		        <div <?php echo $style_desactivo; ?> id="desactivarAccesos" class="pull-right">
					<?php if($vista == 1){ ?> 
						<div class="col-md-12" align="right" style="font-size: 14pt;"> 
				          <b style="text-transform: uppercase;">Número de accesos restantes: 
				            <span class="parpadea"><?php echo $num_accesos_rest; ?></span>
				          </b><br>
				          <b>
				            <p style="padding-top: 10px;color: #a5a5a5;" class="bounce infinite animated form-text text-muted">Seleccione los candidatos a los que desee enviar accesos</p>
				          </b> 
				        </div>

					<?php } ?>
				</div>

				<div class="clearfix"></div>
			<?php }else{
				echo '<br><br>';
			} ?>
			
			
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
							    		<?php if($empresa_hija){ ?>
								      		<?php if($_SESSION['mfo_datos']['accesos'] == 1){ echo '<th rowspan="2" id="marcar" style="vertical-align: middle; text-align: center; border-bottom:0px; display: 0;">Accesos</th>'; }else{ echo '<th rowspan="2" id="marcar" style="vertical-align: middle; text-align: center;border-bottom:0px; display:none;">Accesos</th>'; }
								      	 } ?>
								      	<th rowspan="2" style="vertical-align: middle; text-align: center;">Visto</th>
								      	<th rowspan="2" style="vertical-align: middle; text-align: center;">Foto</th>
										<th rowspan="2" colspan="1" style="vertical-align: middle; text-align: center;">Nombre y Apellido</th>
								        <th rowspan="2" style="vertical-align: middle; text-align: center;width: 100px">
											<?php 
												$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/O1'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['O'].'/';
											?>
								           <a href="<?php echo $ruta.'1/'; ?>">Edad <i class="fa fa-sort"></i></a>
								        </th>
								        <?php if($vista == 1) { ?>
									        <th rowspan="2" style="vertical-align: middle; text-align: center;">
												<?php 
													$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/O2'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['O'].'/';
												
												?>
									           <a href="<?php echo $ruta.'1/'; ?>"><?php echo 'Postulado hace'; ?><i class="fa fa-sort"></i></a>
									        </th>
								    	<?php } ?>
								    	<th colspan="5" style="vertical-align: middle; text-align: center;">INFORME <i data-placement="top" data-toggle="tooltip" data-html="true" data-original-title="<i class='fa fa-info-circle fa-2x'></i><br/><p>Es un resumen de las características generales por competencias que describe al candidato. </p>" style="padding-left: 5px;font-size: 18px;cursor:help;" class="fa fa-question-circle-o" aria-hidden="true"></i></th>
								        <th rowspan="2" style="vertical-align: middle; text-align: center;" title="Nivel de Estudios">
								        	<?php 
												$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/O3'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['O'].'/';
											?>
								           <a href="<?php echo $ruta.'1/'; ?>">Estudios<i class="fa fa-sort"></i></a>
								       </th>

								        <?php if($vista == 1) { ?>
									        <th rowspan="2" style="width: 100px; vertical-align: middle; text-align: center;" title="Aspiraci&oacute;n Salarial">
									        	<?php 
													$ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/1/O4'.$_SESSION['mfo_datos']['Filtrar_aspirantes']['O'].'/';
												?>
									           <a href="<?php echo $ruta.'1/'; ?>">Salario<i class="fa fa-sort"></i></a>
									       </th>
									   <?php } ?>
									   	<?php if($empresa_hija){ ?>
								        	<th rowspan="2" colspan="2" style="vertical-align: middle; text-align: center;">Acci&oacute;n</th>
								    	<?php } ?>
							      	</tr>
							      	<tr><?php 
								    	foreach($facetas as $key => $nombre){ 
								    		echo "<th style='vertical-align: middle; text-align: center;'>".$nombre['literal']."</th>";
								    	} ?>
								    </tr>
							    </thead>
				        		<tbody>
						        	<?php 

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
						        			
							            	if(array_key_exists($a['id_usuario'],$usuariosConAccesos)){
					            				$color = ' style="background-color: #bbdcf9;"';
				            				}else{
				            					$color = '';
				            				} ?>
							            	<tr<?php echo $color; ?>>
							            		<?php if($_SESSION['mfo_datos']['accesos'] == 1){ 
							            			$display = 'display: 1; vertical-align: middle; text-align: center;';
							            		}else{
							            			$display = 'display:none; vertical-align: middle; text-align: center;';
							            		} ?>
							            		<td style="<?php echo $display; ?>" class="checkboxes">
							            			<?php 
							            			$mostrar = '';
							            			if($a['test_realizados'] == Modelo_Usuario::TEST_PARCIAL && $datosOfertas['estado'] == Modelo_Oferta::ACTIVA){ 
							            				if(!in_array($id_Usuario, $_SESSION['mfo_datos']['usuariosHabilitados'])){
							            					array_push($_SESSION['mfo_datos']['usuariosHabilitados'],$id_Usuario);
							            				}

							            				if(array_key_exists($a['id_usuario'],$usuariosConAccesos) && $usuariosConAccesos[$a['id_usuario']] == ''){
								            				$mostrar = 'Acceso Enviado';
							            				}/*else if(array_key_exists($a['id_usuario'],$usuariosConAccesos)){
								            				//$mostrar = '-';
							            				}*/
								            									            			
								            			if($mostrar == '' && !array_key_exists($a['id_usuario'],$usuariosConAccesos)){
													?>
							            				<input type="checkbox" class="check_usuarios" <?php if(empty($_SESSION['mfo_datos']['planSeleccionado']) && $vista == 2){ echo 'disabled="disabled" title="Debe seleccionar un plan" '; } if(in_array($id_Usuario,$_SESSION['mfo_datos']['usuarioSeleccionado'])){ echo 'checked'; } ?> id="<?php echo $id_Usuario; ?>" name="usuarios_check" onclick="marcarSeleccionado('<?php echo $id_Usuario; ?>')">
							            			<?php }else{
							            				echo '-'; 
							            			   }
							            		    }else{ echo '-'; } ?>
							            		</td>
							            		<!--<td data-title="N°: " style='vertical-align: middle; text-align: center;'><?php #echo $num_aumentar+($i+1); ?></td>-->

							            		<td style="text-align: center; vertical-align: middle;">
							            			
							            			<?php
							            				$estilo = 'color: #CDCDCD;';
							            				if(!empty($vistos)){
							            					$new_arr = array_column($vistos,'id_usuario');
								            				if(in_array($a['id_usuario'], $new_arr)){
								            					$estilo = 'color: #7ABF89;';
								            					// $imagenvisto = 'check-01.png';
								            				}
								            				
								            				// echo "<img src='".PUERTO.'://'.HOST."/imagenes/".$imagenvisto."' width='40' height='40' alt='img.png'/>";
							            				}
							            				echo "<i class='fa fa-eye' style='".$estilo."font-size: 25px;'></i>";
							            			?>
							            		</td>


							            		<td align="right" style="text-align: center; vertical-align: middle;" data-title="Foto: ">
							                      <img class="imagen-perfil-2" src="<?php echo PUERTO.'://'.HOST.'/imagenes/imgthumb/'.$a['username'].'/'; ?>" alt="perfil" width="50" height="50">
							                    </td>
							            		
							            		
							            		<td data-title="Aspirante: " style="vertical-align: middle; text-align: center;">

							            			<?php
								            			if (isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'detallePerfilCandidatos',$id_plan) && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA && $ver == true) {

								            				if($empresa_hija){

								            					if($datosOfertas['estado'] == Modelo_Oferta::ACTIVA){
								            						echo '<a href="'.PUERTO."://".HOST."/aspirante/".$a['username'].'/'.$id_oferta.'/'.$vista.'/">';
								            					}
								            				}
								            				echo utf8_encode($a['nombres']).' '.utf8_encode($a['apellidos']);
								            				if($empresa_hija){
								            					if($datosOfertas['estado'] == Modelo_Oferta::ACTIVA){
								            						echo '</a>'; 
								            					}
								            				}
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
												<?php } $cont = 1;?>
												
												<?php foreach($facetas as $key => $nombre){
										    		echo "<td data-title='".$nombre['literal']/*substr($nombre, 0,1)*/.":' style='vertical-align: middle; text-align: center;'>";
										    		$varValue = 0;
										    		if(isset($datos_usuarios[$a['id_usuario']][$key])){
										    			if($a['test_realizados'] == Modelo_Usuario::TEST_PARCIAL){
										    				if(array_key_exists($a['id_usuario'],$usuariosConAccesos) && $usuariosConAccesos[$a['id_usuario']] != ''){
										    					if($a['numero_test'] == Modelo_Usuario::COMPLETO_TEST){
										    						$varValue = $datos_usuarios[$a['id_usuario']][$key];
																}else if($a['numero_test'] == Modelo_Usuario::PRIMER_TEST){
																	if($cont > 1){$varValue = 0;}
																}else if($a['numero_test'] == Modelo_Usuario::SEGUNDO_TEST){
																	if($cont > 2){$varValue = 0;}
																}
										    				}
										    				else{
										    					if($cont > 2){$varValue = 0;}else{
										    						$varValue = $datos_usuarios[$a['id_usuario']][$key];
										    					}
										    				}
										    			}
										    			else{
								            				$varValue = $datos_usuarios[$a['id_usuario']][$key];
								            			}
										    			echo number_format($varValue,0).'%';
										    		}else{ 
										    			// echo '0.00%';
										    			echo "0%";
										    		}
										    		echo "</td>";
										    		$cont++;
										    	} ?>
												<td data-title="Estudios: " style="vertical-align: middle; text-align: center;"><?php echo utf8_encode($a['estudios']); ?></td>

												<?php if($vista == 1){ 
													$compl_url = $id_oferta."/"; ?>
													<td data-title="Salario: " style="vertical-align: middle; text-align: center;"><?php echo SUCURSAL_MONEDA.number_format($a['asp_salarial'],2); ?></td>
												<?php }else{
													$compl_url = '';
												} ?>

												<?php if($empresa_hija){ 

													$imagen = '';
													echo '<td title="Descargar Informe de competencias laborales ';
	
								            			if($a['test_realizados'] == Modelo_Usuario::TEST_PARCIAL){
                                      
								            				if(array_key_exists($a['id_usuario'],$usuariosConAccesos) && $usuariosConAccesos[$a['id_usuario']] != ''){
								            					$title = 'parcial';

								            					if($a['numero_test'] == Modelo_Usuario::COMPLETO_TEST){
								            						$title = 'completo';
								            						$imagen = 'icono-aspirante-05.png';
								            					}else if($a['numero_test'] == Modelo_Usuario::PRIMER_TEST){
									            					$imagen = 'icono-aspirante-06.png';
									            				}else if($a['numero_test'] == Modelo_Usuario::SEGUNDO_TEST){
									            					$imagen = 'icono-aspirante-07.png';
									            				}
								            				}else{
									            				
									            				$title = 'parcial';	

									            				if($a['numero_test'] == Modelo_Usuario::PRIMER_TEST){
									            					$imagen = 'icono-aspirante-06.png';
									            				}else{
									            					$imagen = 'icono-aspirante-07.png';
									            				}
									            				
								            				}
								            			}else{
								            				$title = 'completo';
								            				$imagen = 'icono-aspirante-05.png';
								            			}

								            			echo $title.'" data-title="Informe '.$title.'" style="vertical-align: middle; text-align: center;">';
									            		if (isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'descargarInformePerso',$id_plan) && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA && $ver == true) {
									            			if($mostrar == ''){
									            				
									            				if($datosOfertas['estado'] == Modelo_Oferta::ACTIVA){
									            					$variable = '<a class="accionOpcion" onclick="hacerInforme(\''.PUERTO."://".HOST."/fileGEN/informeusuario/".Utils::encriptar($id_plan).'/'.$id_oferta.'/'.$a['username'].'\',\''.Utils::encriptar($a['id_usuario']).'\')"><img src="'.PUERTO."://".HOST.'/imagenes/'.$imagen.'" class="redes-mic" width="100%"></a>';
									            				}else{
																	$variable = '<img src="'.PUERTO."://".HOST.'/imagenes/'.$imagen.'" class="redes-mic" width="100%">';
																}
																
																echo $variable;
															}else{
																echo $mostrar;
															}
														}else{
						
															if($mostrar == ''){
																if(!$ver){
																	echo '-';
																}else{
																	echo '<a href="#" onclick="abrirModal(\'Debe contratar un plan que permita descargar informes de competencias laborales\',\'alert_descarga\',\''.PUERTO."://".HOST."/planes/".'\',\'Ok\',\'\')"><img src="'.PUERTO."://".HOST.'/imagenes/'.$imagen.'" class="redes-mic" width="100%"></a>';
																}
															}else{
																echo $mostrar;
															}
														}
													
													echo '</td>'; ?>

													<td title="Descargar Hoja de vida" data-title="Hoja de vida: " style="vertical-align: middle; text-align: center;">
									            		<?php 
										            		if (isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'descargarHv',$id_plan) && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA && $ver == true) {

										            			if($datosOfertas['estado'] == Modelo_Oferta::ACTIVA){
										            				echo '<a class="accionOpcion" href="'.PUERTO."://".HOST."/hojasDeVida/".$a['username'].'/'.$compl_url.'"><img src="'.PUERTO."://".HOST.'/imagenes/cv-07.png" class="redes-mic" width="100%"></a>';
										            			}else{
																	echo '<img src="'.PUERTO."://".HOST.'/imagenes/cv-07.png" class="redes-mic" width="100%">';
										            			}
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
			<?php if($empresa_hija){ ?>
				<div class="col-md-12">
					<br>
					<div <?php echo $style_desactivo; ?> id="desactivarAccesos_btn" class="pull-right">
						<a id="btn_accesos_cancelar" class="btn-red solo-texto dis-mov">Cancelar</a>
						<a id="btn_accesos_confirmar" class="btn-blue solo-texto dis-mov">Enviar accesos</a>
					</div>
				</div>
			<?php } ?>
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
    	<form action = "<?php echo PUERTO."://".HOST;?>/convertir/" method = "post" id="form_convertir" name="form_convertir">
      <div class="modal-header">
        <h5 class="titulo-modal-hoja modal-title">Convertir Oferta</h5>               
      </div>
      	
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
    	
        <input type="hidden" name="convertirOferta" id="convertirOferta" value="1">
        <div class="modal-footer" style="text-align: center !important;">
          <button type="button" id="button_convertir_oferta" name="button_convertir_oferta" class="btn-light-blue" data-dismiss="modal">convertir</button>
          <button type="button" id="cancelar_conversion" name="cancelar_conversion" class="btn-red" data-dismiss="modal">cancelar</button>
        </div>
      </form>  
    </div>    
  </div>
</div>﻿

<div class="modal fade" id="aviso_accesos" tabindex="-1" role="dialog" aria-labelledby="aviso_accesos" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog" role="document">    
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="subt modal-title" id="title">ACTIVAR ACCESOS    
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
    	</h5>              
      </div>
		<div class="modal-body">
			<div class="row">
			  	<div class="col-md-12">
		            <div class="col-md-12">
		              <p>Los accesos tienen como prop&oacute;sito, permitir a las empresas completar el proceso de selecci&oacute;n. </p><hr>
		            </div>
		            <div class="col-md-8">
		              <p class="subt" style="font-size: 25pt"><b>Beneficios </b></p>
		              <ul>
		                <li class="qs-text-lista"><p style="color: #797979;">Puede escoger el (los) candidato (s) para finalizar el test de competencias laborales CANEA</p></li>
		                <li class="qs-text-lista"><p style="color: #797979;">Puede activar uno o varios accesos, de acuerdo al <b><a href="<?php echo PUERTO."://".HOST;?>/planes/">plan contratado.</a></b> </p></li>
		              </ul>
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
<br>
<div class=" banner-publicidad" align="center">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="banner-light col-md-9 click ">est&aacute; a un solo click de encontrar el <b>candidato ideal</b></div>
        <button class="btn-blue-2 pulse animated infinite col-md-2"><a href="<?php echo PUERTO."://".HOST;?>/publicar/">Publicar Oferta</a></button>
      </div>
    </div>
  </div>
</div>


<section style="background-color: grey;color: white; text-align:center" id="product" class="inicio">
  <div class="container">
    <div class="col-md-12">
      <label>ANUNCIE AQU&Iacute;</label>
    </div>
  </div>
</section>

<!--grafico para informe-->
<input style="display:none" type="text" id="datosGrafico" value="<?php echo (!empty($val_grafico)) ? $val_grafico : ""; ?>" />
<div class="container" id="Chart_details">
  <!--<div id='chart_div'></div>--><div id='g_chart_1' style="width: auto; height: auto;"></div>
</div>
<style>
	.shadow-panel1{
		cursor:pointer;
	}
</style>

<div class="container-fluid">
	<div class="text-center">
		<h2 class="titulo"><?php echo $breadcrumbs[$vista]; ?></h2>
	</div>
</div>

<br><?php  
if(isset($filtro) && $vista == 'oferta'){ ?>
	<div class="container-fluid">
		<form role="form" name="filtro" id="filtro" method="post" action="<?php echo PUERTO.'://'.HOST.'/'.$vista.'/'; ?>"> 
			<?php if($filtro == 1){ ?>
			<div class="alert alert-info col-md-12" style="padding-bottom: 0px;"> 
				<div style="padding-bottom: 0px;">
			        <div class="container-fluid">
			            <div class="col-md-12">
				          <p style="text-align: center;font-weight: bold; font-size: 16pt;">Las ofertas aquí presentadas estan filtradas por las siguientes características:</p>
				        </div>
			            <?php if(isset($_SESSION['mfo_datos']['usuario']['usuarioxarea'])){ ?>
				            <div class="col-md-6 col-sm-12">
				              <h3 class="subt-2" style="font-size:14pt">&Aacute;reas y sub&aacute;reas de empleo</h3>
				              <table class="table">
				                <thead>
				                  <tr>
				                    <th style="text-align: center;font-weight: bold; font-size: 14pt;" scope="col">&Aacute;rea</th>
				                    <th style="text-align: center;font-weight: bold; font-size: 14pt;"scope="col">Sub&aacute;reas</th>
				                  </tr>
				                </thead>
				                <tbody>
				                  	<?php foreach ($areas_subareas as $key => $value) { ?>
										<tr>
											<th scope="row"><?php echo utf8_encode($value['area']); ?></th>
											<td>
												<?php 
													$text_subareas = '';
													$text_subareas2 = '';
													$subareas_array = explode(",",utf8_encode($value['subareas'])); 
													if(count($subareas_array) > 3){
														$text_subareas = $subareas_array[0].', '.$subareas_array[1].', '.$subareas_array[2];
														unset($subareas_array[0],$subareas_array[1],$subareas_array[2]);
														$text_subareas2 = implode(",", $subareas_array);
													}else{
														$text_subareas = utf8_encode($value['subareas']);
													}
												?>
												<span><?php echo $text_subareas; if($text_subareas2 != ''){ ?> <span id="vermasdiv<?php echo $key; ?>" style="display:none"><?php echo ', '.$text_subareas2; ?></span><?php } ?></span><?php if($text_subareas2 != ''){ ?> <b><a href="#" onclick="vermas('vermasdiv<?php echo $key; ?>','ver<?php echo $key; ?>')" id="ver<?php echo $key; ?>"> ..ver m&aacute;s</a></b><?php } ?>
											</td>
										</tr>
				              		<?php } ?>
				                </tbody>
				              </table>
				           	</div>
			            <?php } ?>
			            <div class="col-md-6">
			               	<h3 class="subt-2" style="padding: 15px; text-align: center; font-size:14pt">Cambio de residencia:
			               		<span style="color: #797979;"> 
			               			<?php if(isset($_SESSION['mfo_datos']['usuario']['residencia']) && $_SESSION['mfo_datos']['usuario']['residencia'] == 1){
										echo 'SI';

									}else{ 
										echo 'NO';
									} ?>
			               		</span>
			               	</h3>
			               	<p style="text-align: center;font-weight: bold; font-size: 16pt;">Si desea ver todas las ofertas sin filtro </p><br><a style="cursor:pointer; padding: 15px !important" class="btn-light-blue pulse animated infinite" onclick="document.forms['filtro'].submit()">Click Aqu&iacute;</a>
			            </div> 
			        </div>
			    </div> 
			</div>
			<?php }else{ ?>
	        	<div class="alert alert-info col-md-12" style="padding-bottom: 0px;"> 
				    <div class="row">
				      <div class="col-md-12">
				        <div class="col-md-9" style="font-size: 18px;padding-top: 5px;">Si desea ver las ofertas con los filtros configurados en su cuenta</div>
				        <div class="col-md-3">
		              	<a style="font-size: 18px;cursor:pointer;padding-top: 5px;padding-bottom: 5px;padding-right: 10px;padding-left: 10px;width: 124px;margin-top: 0px;" onclick="document.forms['filtro'].submit()" id="filtro-pop" class="btn-blue-2 pulse animated infinite col-md-2">Click Aqu&iacute;</a>
		            	</div>
				      </div>
				    </div>
				  
				</div><br><br>
	       	<?php } ?>
	       	<input type="hidden" name="filtro" id="filtro" value="<?php echo $filtro; ?>">
		</form>
		<?php echo isset($enlaceCompraPlan) ? $enlaceCompraPlan : '';  ?> 
	</div>
<?php } ?>

<?php if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA){ ?>
<br>
<div class="banner-publicidad " align="center">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="banner-light col-md-9 click ">est&aacute; a un solo click de encontrar el <b>candidato ideal</b></div>
        <button class="btn-blue-2 pulse animated infinite col-md-2"><a href="<?php echo PUERTO."://".HOST;?>/publicar/">Publicar Oferta</a></button>
      </div>
    </div>
  </div>
</div>
<br>
<?php } ?>

<div class="container-fluid">
	<div class="col-md-3 visible-md-inline visible-lg-inline">
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
							<input type="text" maxlength="30" class="form-control" id="inputGroup" aria-describedby="inputGroup" onkeypress="return check(event)" placeholder="Ej: Enfermero(a) &oacute; xx-xx-xxxx"> 
							<?php 
							$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/';
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
		<?php if($vista == 'cuentas'){ ?>
			<div class="panel panel-default shadow-panel1">
				<div class="panel-heading" data-toggle="collapse" href="#subempresas-desplegable">
					<div class="row">
						<div class="col-md-10" id="drop-tit" >
							<span>
								<i class="fa fa-list-ul"></i> Subempresas
							</span>
						</div>
						<div class="col-md-2" >
							<span class="caret"></span>
						</div>
					</div>
				</div>
				<div class="panel-body collapse" id="subempresas-desplegable" aria-expanded="false">
					<div class="filtros">
						<?php
						if (!empty($array_empresas_hijas)) { 
							foreach ($array_empresas_hijas as $key => $v) {
								$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/S'.$key.'/';
								echo '<li class="lista"><a href="'.$ruta.'1/" class="cuentas" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
							}
						}
						?></div>
					</div>
				</div>
		<?php } ?>
			<div class="panel panel-default shadow-panel1">
				<div class="panel-heading" data-toggle="collapse" href="#areas-desplegable">
					<div class="row">
						<div class="col-md-10" id="drop-tit" >
							<span>
								<i class="fa fa-list-ul"></i> &Aacute;reas de Empleos
							</span>
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
								$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/A'.$key.'/';
								echo '<li class="lista"><a href="'.$ruta.'1/" class="area" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
							}
						}
						?></div>
					</div>
			</div>
			<div class="panel panel-default shadow-panel1">
				<div class="panel-heading" data-toggle="collapse" href="#provincias-desplegable">
					<div class="row">
						<div class="col-md-10" id="drop-tit" >
							<span>
								<i class="fa fa-map"></i> Provincias
							</span>
						</div>
						<div class="col-md-2" >
							<span class="caret"></span>
						</div>
					</div>
				</div>
				<div class="panel-body collapse" id="provincias-desplegable" aria-expanded="false">
					<div class="filtros">
						<?php
						if (!empty($arrprovincia)) {
							foreach ($arrprovincia as $key => $v) {
								$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/P'.$key.'/';
								echo '<li class="lista"><a href="'.$ruta.'1/" class="provincia" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
							}
						}
						?>
					</div>
				</div>
			</div>
			<div class="panel panel-default shadow-panel1">
				<div class="panel-heading" data-toggle="collapse" href="#jornada-desplegable">
					<div class="row">
						<div class="col-md-10" id="drop-tit" >
							<span>
								<i class="fa fa-clock-o"></i> Jornada
							</span>
						</div>
						<div class="col-md-2" >
							<span class="caret"></span>
						</div>
					</div>
				</div>
				<div class="panel-body collapse" id="jornada-desplegable" aria-expanded="false">
					<div class="filtros">
						<?php
						if (!empty($jornadas)) {
							foreach ($jornadas as $key => $v) {
								$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/J'.$key.'/';
								echo '<li class="lista"><a href="'.$ruta.'1/" class="jornada" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
							}
						}
						?>
					</div>
				</div>
			</div>
			<div class="panel panel-default shadow-panel1">
				<div class="panel-heading" data-toggle="collapse" href="#salario-desplegable">
					<div class="row">
						<div class="col-md-10" id="drop-tit" >
							<span>
								<i class="fa fa-dollar"></i> Salario
							</span>
						</div>
						<div class="col-md-2" >
							<span class="caret"></span>
						</div>
					</div>
				</div>
				<div class="panel-body collapse" id="salario-desplegable" aria-expanded="false">
					<div class="filtros">
						<?php
						if (!empty(SALARIO)) {
							foreach (SALARIO as $key => $v) {
								$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/K'.$key.'/';
								echo '<li class="lista"><a href="'.$ruta.'1/" class="salario" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
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
				<div class="panel-heading collapsed" style="cursor:pointer" data-toggle="collapse" data-target="#contenedor" aria-expanded="false">
					<i class="fa fa-angle-down"></i>Filtros
				</div>
				<div class="panel-body collapse" id="contenedor" aria-expanded="false" style="height: 30px;">
					<div class="form-group">
						<input type="text" maxlength="30" class="form-control" id="inputGroup1" placeholder="Ej: Enfermero(a) &oacute; xx-xx-xxxx"> 
					</div>
					<div class="form-group">
						<?php 
						$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/'; 
						?>
						<select id="categorias" class="form-control">
							<option value="0">Seleccione un &aacute;rea de empleo</option>
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
						<a class="btn btn-md btn-info" onclick="obtenerFiltro('<?php echo $ruta; ?>','1')">
							Buscar
						</a>
					</div>	  
				</div>
			</div>
		</form>
	</div>
	<div class="col-md-9">
		
		<div class="container-fluid ordenamientos">
			<div class="col-md-12">
				<?php 
					$sinOffSet = false;
					if (trim($vista) == 'oferta' && isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'autopostulacion')) { $sinOffSet = true; ?> 
					<div class="col-md-5"> 
						<div style="cursor:pointer" align="left" data-placement="top" data-toggle="tooltip" data-html="true" data-original-title="<i class='fa fa-info-circle fa-2x'></i><br/><p>Número de oportunidades que le restan para que el sistema lo postule de forma automática.</p>"> 
							<h4><b>Autopostulaciones restantes: 
								<span class="parpadea" style="color:red">
									<?php echo $autopostulaciones_restantes['p_restantes']; ?>					
								</span>
							</b></h4>
						</div><br>
					</div> 
				<?php } ?> 

		        <div class="col-md-3 <?php if(!$sinOffSet){ echo 'col-md-offset-5'; } ?>" style="display: flex;">
			        <span>Ordenar por: </span>
			        <select id="tipo_orden" name="tipo_orden" class="form-control">
			          <option value="1" <?php if($tipo_ordenamiento == 1){ echo 'selected'; } ?>>Salario</option>
			          <option value="2" <?php if($tipo_ordenamiento == 2){ echo 'selected'; } ?>>Fecha</option>
			        </select>
		        </div>
		        <div class="col-md-4" style="padding-left: 0px; padding-right: 0px;">
		          	<label class="radio-inline">
		                <input type="radio" name="orden" value="1" title="Ordena de menor a mayor" <?php if($_SESSION['mfo_datos']['Filtrar_ofertas']['O'] == 2 && !empty($tipo_ordenamiento)){ echo 'checked'; } ?>>
		                Ascendente
		            </label>
		            <label class="radio-inline">
		               <input type="radio" name="orden" value="2" title="Ordena de mayor a menor" <?php if($_SESSION['mfo_datos']['Filtrar_ofertas']['O'] == 1 && !empty($tipo_ordenamiento)){ echo 'checked'; } ?>>
		               Descendente
		            </label>
		        </div>
		        <?php $enlace_ordenamiento = PUERTO.'://'.HOST.'/'.$vista.'/1/O'; ?>
				<input type="hidden" id="enlace_ordenamiento" name="enlace_ordenamiento" value="<?php echo $enlace_ordenamiento; ?>">
	      	</div>
		</div>

		<div id="busquedas" class="container-fluid">
			<?php if (isset($link)) { 
				echo $link; 
			} ?>
		</div>

		<div id="result">
			<?php  
			if(!empty($ofertas) && $ofertas[0]['id_ofertas'] != ''){
				foreach($ofertas as $key => $o){  ?>
					<div class="caja-postulaciones">
						<?php 
						if($vista == 'postulacion' && $o['estado'] != Modelo_Oferta::ACTIVA){
							$o['puedeEliminar'] = 0; 
						}
						if($o['estado'] == Modelo_Oferta::PORAPROBAR){ $t = 'Aviso Pendiente de Aprobaci&oacute;n'; $clase = 'titulo-postulaciones-pendiente'; }else{ $t = ''; } 

						if($o['tipo_oferta'] == 1 && $t == ''){ 
							$clase = 'titulo-postulaciones'; 
							$t = 'Aviso Urgente';
						}else if($o['tipo_oferta'] == 0 && $t == ''){
							$clase = 'titulo-postulaciones-normal';
							$t = 'Aviso Normal';
						}
						echo '<div class="'.$clase.'">'.$t.'</div>'; 
						
						?>
						<div class='panel-body ofertaUrgente' id='caracteristica_oferta'>
							<div class="row">
								<div class="col-md-2 col-sm-4 col-xs-12" style="padding-left: 0px;" align="center">
									<div class="col-md-12 col-sm-12 col-xs-12 imagen-perfil">
										<?php 										
										$src_imagen = ($o['confidencial'] && $vista!='vacantes' && $vista!='cuentas') ? PUERTO.'://'.HOST.'/imagenes/logo_oferta.png' : PUERTO.'://'.HOST.'/imagenes/usuarios/'.$o['username'].'/';
										?>
										<img id="imgPerfil" class="img-res2 img-responsive" src="<?php echo $src_imagen; ?>" alt="icono">
									</div>

									<div class="col-md-12 col-sm-12 col-xs-12">
										<?php if($vista == 'vacantes' || $vista == 'cuentas'){ ?>
											<p id="texto-postulaciones">Publicada:<br> <?php echo date("d-m-Y", strtotime($o['fecha_creado'])); ?></p>
										<?php } ?>
										<?php if($vista == 'vacantes'){ ?>
											<p id="tipo-plan"><?php echo utf8_encode($datos_plan[$o['id_ofertas']]['nombre_plan']); ?></p>
										<?php } ?>
									</div>

									<div class="col-md-12 col-sm-12 col-xs-12">
										<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA) { 	?>
											<?php if (REQUISITO[$o['confidencial']] == 'No') {
												echo '<p id="tipo-empresa">'.utf8_encode($o['empresa']).'</p>';
											}
											else
											{
												echo '<p id="tipo-empresa">Confidencial</p>';
											} 
										}

										if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA && $vista == 'cuentas'){

											echo '<p id="tipo-empresa">'.utf8_encode($o['empresa']).'</p>';
										}
										?>
									</div>
								</div>
								<div class="col-md-10 col-sm-8 col-xs-12">
									<div class="col-md-<?php if($vista == 'oferta'){ echo '9'; }else{ echo '12'; } ?>">
										<h3 class="cargo-postulaciones"><?php echo utf8_encode($o['titulo']); ?></h3>
									</div>
									<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) { ?>
										<div class="col-md-6 col-sm-6">
											<p class="texto-postulaciones cortar" align="justify"><?php echo strip_tags(html_entity_decode($o['descripcion'])); ?></p>
										</div>
									<?php }else{ ?>

										<?php if($vista == 'postulacion'){ ?>
											<div class="col-md-4 col-sm-3 col-xs-6">
												<p class="texto-postulaciones">Modo que aplic&oacute;:&nbsp;<b><?php echo POSTULACIONES[$o['tipo']]; ?></b><br>
													Fecha de la oferta: <?php echo date("d-m-Y", strtotime($o['fecha_creado'])); ?><br>
													Jornada: <?php echo $o['jornada']; ?></p>
											</div>
											<div class="col-md-4 col-sm-3 col-xs-6">
												<p class="texto-postulaciones">Salario: <?php echo SUCURSAL_MONEDA.number_format($o['salario'],2);?><br>
														Provincia: <?php echo utf8_encode($o['provincia']);?><br>
														Vacantes: <?php echo $o['vacantes']; ?></p>
											</div>
										<?php } ?>
									<?php } ?>

									<?php if($vista == 'postulacion' && $o['estado'] == Modelo_Oferta::ACTIVA){ ?>

										<?php if(isset($o['tipo']) && $o['tipo'] == 2){ ?>
											<div class="col-md-2 col-sm-3 col-xs-6">
												<a class="f-s-16px" style="cursor:pointer" title="Eliminar postulaci&oacute;n" href="<?php echo PUERTO."://".HOST."/postulacion/eliminar/".Utils::encriptar($o['id_postulacion'])."/"; ?>">
													<i class="postulacion-icono-basura fa fa-trash"></i><br>Eliminar postulaci&oacute;n
												</a>
											</div>
										<?php }else if(isset($o['puedeEliminar']) && $o['puedeEliminar'] == 1){ ?>
											<div class="col-md-2 col-sm-3 col-xs-6">
												<a class="f-s-16px" style="cursor:pointer" title="Eliminar postulaci&oacute;n" onclick="abrirModal('<span style=\'font-size:14px;\'> Si presiona el botón de Aceptar no recibirá más postulaciones automáticas de esta empresa <?php if (REQUISITO[$o['confidencial']] == 'No') { echo '<b>('.utf8_encode($o['empresa']).')</b>'; } ?>, Desea eliminar la postulación? </span>','alert_descarga','<?php echo PUERTO."://".HOST."/postulacion/eliminar/".Utils::encriptar($o['id_postulacion'])."/".Utils::encriptar($o['id_empresa'])."/"; ?>','Ok','Confirmación');">
													<i class="postulacion-icono-basura fa fa-trash"></i><br>Eliminar postulaci&oacute;n
												</a>
											</div>
										<?php } ?>

									<?php } ?> 

									<?php 
									$tiempo = Modelo_Parametro::obtieneValor('tiempo_espera');
									$puedeEditar = Modelo_Oferta::puedeEditar($o["id_ofertas"],$tiempo);
									
									?>

									<div class="<?php if($vista == 'oferta'){ echo ' col-md-3 col-sm-6 col-xs-12'; }else if($vista == 'vacantes'){ echo 'col-sm-6 col-xs-12'; } ?> ">
										<?php if($vista == 'vacantes'){ 
											if($puedeEditar["editar"] == 1){
												?>
												<div class="col-md-6 col-xs-6">
													<a class="f-s-16px" onclick="abrirModalEditar('editar_Of','<?php echo Utils::encriptar($o["id_ofertas"]); ?>');"><i class="postulacion-icono-editar fa fa-pencil-square-o"></i><br>
													Editar la oferta</a>
												</div>
											<?php }
										} ?>

										<?php if($vista != 'oferta'){ ?>
											<div class="<?php if($vista == 'postulacion' && (isset($o['puedeEliminar']) && $o['puedeEliminar'] == 1 && $o['tipo'] == 1)){ echo 'col-md-2 col-sm-3 col-xs-6'; }else if(isset($o['puedeEliminar']) && $o['puedeEliminar'] == 0 && $vista == 'postulacion' && $o['tipo'] == 1){ echo 'col-md-4 col-sm-6 col-xs-12'; }else if(isset($o['puedeEliminar']) && $o['puedeEliminar'] == 0 && $vista == 'postulacion' && $o['tipo'] == 2){ echo 'col-md-2 col-sm-3 col-xs-6'; }  
											if($puedeEditar["editar"] == 0 && $vista == 'vacantes'){ echo 'col-md-8 col-md-offset-4 col-xs-12 '; }
											if($vista == 'cuentas'){ echo 'col-md-6 col-xs-12'; } ?> ">
											<?php } ?>
											<a class="f-s-16px" href="<?php echo PUERTO."://".HOST."/detalleOferta/".$vista."/".Utils::encriptar($o["id_ofertas"])."/"; ?>">
												<i class="postulacion-icono-ver fa fa-eye"></i><br>
											Ver detalles de la oferta</a>
											<?php if($vista != 'oferta'){ ?>
											</div>
										<?php } ?>
									</div>
									<?php if($vista == 'oferta'){ ?>
										<div class="col-md-9 col-sm-6 col-xs-12">
											<p class="texto-empleo">
												Fecha de la oferta: <?php echo date("d-m-Y", strtotime($o['fecha_creado'])); ?></p>
										</div>
									<?php } ?>

									<?php if($vista != 'oferta'){ ?>
										<div class="col-md-12">
											<hr style="margin: 10px 0px;">
										</div>
									<?php } ?>

									<?php if($vista != 'postulacion'){ ?>
										<div class="col-md-12 col-sm-12 col-xs-12">
											<div class="col-md-3 col-sm-3 col-xs-6">
												<p id="empleo-2">Salario:</p>
												<i class="empleo-icono fa fa-dollar"></i><br>
												<p id="postulacion-2"><?php echo SUCURSAL_MONEDA.number_format($o['salario'],2);?></p>
											</div>
											<div class="col-md-<?php if($vista == 'postulacion' || $vista == 'vacantes' || $vista == 'cuentas'){ echo '2'; }else{ echo '3'; } ?> col-sm-3 col-xs-6">
												<p id="empleo-2">Provincia:</p>
												<i class="empleo-icono fa fa-map-marker"></i><br>
												<p id="postulacion-2"><?php echo utf8_encode($o['provincia']);?></p>
											</div>
											<div class="col-md-<?php if($vista == 'postulacion' || $vista == 'vacantes' || $vista == 'cuentas'){ echo '2'; }else{ echo '3'; } ?> col-sm-3 col-xs-6">
												<p id="empleo-2">Jornada:</p>
												<i class="empleo-icono fa fa-clock-o"></i><br>
												<p id="postulacion-2"><?php echo $o['jornada']; ?></p>
											</div>
											<div class="col-md-<?php if($vista == 'postulacion' || $vista == 'vacantes' || $vista == 'cuentas'){ echo '2'; }else{ echo '3'; } ?> col-sm-3 col-xs-6">
												<p id="empleo-2">Vacantes:</p>
												<i class="empleo-icono fa fa-users"></i><br>
												<p id="postulacion-2"><?php echo $o['vacantes']; ?></p>
											</div>
											<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) { ?>
												<div class="col-md-2 col-xs-12">
													<p id="empleo-2">Postulados:</p>
													<?php 
													$cantd = 0;
													//echo '<br>id:'.$o['id_ofertas'];
													if(isset($aspirantesXoferta[$o['id_ofertas']])){ 
														/*echo '<br>cantd: '.*/$cantd = $aspirantesXoferta[$o['id_ofertas']]; ?>
														<a href="<?php echo PUERTO.'://'.HOST.'/verAspirantes/1/'.Utils::encriptar($o['id_ofertas']).'/1/'; ?>">
													<?php } ?>
													<i class="postulacion-icono-postulado fa fa-user"></i><br>
													<?php 
														/*if(isset($aspirantesXoferta[$o['id_ofertas']])){
															$cantd = $aspirantesXoferta[$o['id_ofertas']];
														}else{
															
														}*/

													if($cantd == 0){
														echo '<p id="postulacion-2">'.$cantd.'</p>';
													}else{

														echo '<p id="postulacion-2">'.$cantd.'</p></a>';
													}
													?>
												</div>
													<?php } ?>
										</div>
									<?php } ?>

									<?php if($vista == 'postulacion'){ ?>
										<?php $postulado = Modelo_Postulacion::obtienePostuladoxUsuario($_SESSION['mfo_datos']['usuario']['id_usuario'],$o['id_ofertas']);
										$cv_descargado = Modelo_Descarga::obtieneDescargaCV($_SESSION['mfo_datos']['usuario']['infohv']['id_infohv'],$o['id_empresa'],$o['id_ofertas']);
										?>
										<div class="col-md-12 col-sm-12 col-xs-12">
											<div class="col-md-3 col-sm-3 col-xs-6">
												<i class="postulacion-icono <?php if(date("Y-m-d H:i:s", strtotime($datos_plan[$o['id_ofertas']]['fecha_caducidad'])) <= date('Y-m-d H:i:s')){ echo 'cancelada'; }else{ echo 'icono-aprobado'; } ?> fa fa-calendar"></i><br>
												<p id="postulacion-2"><?php if(isset($postulado)){ ?>
													<?php echo date("d-m-Y", strtotime($postulado[0]['fecha_postulado'])); ?>
													<?php } ?></p>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-6">
												<i class="postulacion-icono <?php if(date("Y-m-d H:i:s", strtotime($datos_plan[$o['id_ofertas']]['fecha_caducidad'])) <= date('Y-m-d H:i:s')){ echo 'cancelada'; }else{ echo 'icono-aprobado'; } ?> fa fa-spinner"></i><br>
												<p id="postulacion-2"><?php if(isset($o['tipo']) && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){ ?>
												<?php echo ucfirst(strtolower(Modelo_Oferta::ESTATUS_OFERTA[$o['resultado']])); ?>
												<?php } ?></p>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-6">
												<i class="postulacion-icono <?php if(date("Y-m-d H:i:s", strtotime($datos_plan[$o['id_ofertas']]['fecha_caducidad'])) <= date('Y-m-d H:i:s')){ echo 'cancelada'; }else if(isset($cv_descargado) && $cv_descargado['cantd_descarga'] >= 1){ echo 'icono-aprobado'; }else{ echo 'icono-por-aprobar'; } ?> fa fa-file"></i><br>
												<p id="postulacion-2">CV Visto</p>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-6">
												<i class="postulacion-icono <?php if(date("Y-m-d H:i:s", strtotime($datos_plan[$o['id_ofertas']]['fecha_caducidad'])) <= date('Y-m-d H:i:s')){ echo 'cancelada'; }else{ echo 'icono-por-aprobar'; } ?> fa fa-check"></i><br>
												<p id="postulacion-2">Finalizado</p>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
	  		<?php }
			}else{ echo '<br><div class="breadcrumb">No hay resultados</div>'; } ?>
		</div>
		<div class="col-md-12">
			<?php echo $paginas; ?>
		</div>
	</div>
</div>


<?php if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA){ ?>
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
<?php } ?>

<div class="modal fade" id="editar_Of" tabindex="-1" role="dialog" aria-labelledby="editar_Of" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog" role="document">    
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="titulo-modal-hoja modal-title ">Editar Ofertas</h5>                  
			</div>
			<form action = "<?php echo PUERTO."://".HOST;?>/vacantes/" method = "post" id="form_editar_Of" name="form_editar_Of">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div id="des_of_error" class="form-group">
								<label class="">Descripci&oacute;n oferta: </label>&nbsp;<i>*</i><div id="descripcion_error" class="help-block with-errors"></div>
								<textarea id="des_of" rows="7" required name="des_of" class="form-control" style="resize: none;" onkeyup="validarDescripcion()"></textarea>
							</div>
						</div>
					</div>
				</div>
				<input type="hidden" name="guardarEdicion" id="guardarEdicion" value="1">
				<input type="hidden" name="idOferta" id="idOferta" value="<?php echo Utils::encriptar($o['id_ofertas']); ?>">
				<div class="modal-footer" style="text-align: center !important;">
					<button type="button" style="line-height: normal;" class="btn-red" id="btn-rojo" data-dismiss="modal">Cancelar</button>
					<input type="button" id="boton" name="boton" class="btn-light-blue" value="Guardar" onclick="enviarEdicion()"> 
				</div>
			</form>
		</div>    
	</div>
</div>
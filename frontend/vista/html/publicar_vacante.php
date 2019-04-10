<div class="">
	<div class="breadcrumb">
		<div class="container">
			<b class="publicar_text">Publicar Ofertas</b>
			<?php 
				if (!empty($publicaciones_restantes)) {
					?>
			 <div align="center">
			 	<div class="col-md-12">
			 		<div class="col-md-4 col-sm-4 col-xs-12">
			 			<div class="caja">
			 			<?php 
			 				$fecha_final = "2015-10-17 11:24:00";
			 				foreach ($_SESSION['mfo_datos']['planes'] as $key => $value) {
			 					if($value['fecha_caducidad'] != NULL || $value['fecha_caducidad'] != ""){
			 						if($fecha_final< $value['fecha_caducidad']){
				 						$fecha_final = $value['fecha_caducidad'];
				 					}
			 					}
			 					else{
			 						if(count($_SESSION['mfo_datos']['planes']) == 1){
			 							$fecha_final = "Ilimitado";
			 						}
			 					}
			 				}		 					
			 			?>
			 			<p>Fecha caducidad plan: 
			 			<b><span><?php
			 						if($fecha_final != "Ilimitado"){
			 							echo date_format(date_create($fecha_final), "Y-m-d");
			 						}
			 						else{
			 							echo $fecha_final;
			 						}
			 					?>
			 			<i style="color: #49FC49;" class="fa fa-circle"></i></span></b></p>			 			
			 			</div>
			 		</div>	
			 		<div class="col-md-4 col-sm-4 col-xs-12">
			 			<div class="caja">
			 				<p>Ofertas restantes:
			 				<b><span> <?php if(!is_numeric($publicaciones_restantes)){echo $publicaciones_restantes; if (!empty($plan_con_pub >0)){echo " + ";} {
			 					# code...
			 				}}
			 				if($plan_con_pub >0 && is_numeric($plan_con_pub)){echo $plan_con_pub;} ?></span></b></p>
			 			</div>
			 		</div>
			 		<div class="col-md-4 col-sm-4 col-xs-12">
			 			<div class="caja">
			 				<p>N° Planes activos: 
			 				<b><span><?php echo count($_SESSION['mfo_datos']['planes']); ?></span></b></p>
			 			</div>
			 		</div>
			 	</div>
			</div>
					<?php
					}
				 ?>				 
		</div>
	</div>

	<div class="container">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="col-md-12">

					<div class="col-md-12">
						<div class="form-group">
							<label>Título de la oferta</label>
							<input type="text" class="form-control" name="nombreOferta" id="nombreOferta">
						</div>
					</div>	

					<div class="col-md-12">
						<div class="form-group">
							<label>Descripción de la oferta</label>
							<textarea id="descripcionOferta" id="descripcionOferta"></textarea>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label>Salario: </label>
							<input type="" name="">
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label>Salario: </label>
							<select id="salarioConv" name="salarioConv" class="form-control"></select>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
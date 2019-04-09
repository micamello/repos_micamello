<div class="container">

	<div class="col-md-12">
		<div class="text-center">
			<br>
			<div class="con_encabezado">
				<span class="encabezado">Por favor ordene de 1 a 5 las siguientes oraciones en cada pregunta. (1 es la oración con la que mas se identifica y 5 es con la que menos se identifica). Este cuestionario consta de 20 preguntas</span>
			</div>
			<br>
		</div>
		<div class="">
			<div class="">
				<form action="<?php echo PUERTO."://".HOST;?>/cuestionario/guardarResp/" method="post" id="forma_1">
					<div class="respuestas" id="respuestas" style="display: none;"></div>				
					<input type="hidden" name="tiempo" id="tiempo" value="<?php echo $tiempo; ?>">
					 <?php 
						$array_group = array();

						foreach ($data as $key => $value) {
						 $array_group[$value['id_pregunta']][$key] = $value;
						}
            
            switch($faceta){
            	case 1:
            	  $indice = 1;
            	break;
            	case 2:
            	  $indice = 5;
            	break;
            	case 3:
            	  $indice = 9;
            	break;
            	case 4:
            	  $indice = 13;
            	break;
            	case 5:
            	  $indice = 17;
            	break;
            }
            
						shuffle($array_group);
						foreach ($array_group as $key => $value) {
							
							$pregunta = "";
							$pregunta = current($value);
							$actual = $value;

							echo "<div class='panel panel-default'>";
							echo "<div class='error_msg'></div>";
							echo "<div class='panel-heading'><h5>Pregunta ".$indice."</h5></div>";
							echo "<div class='panel-body'>";

							echo "<div class='contenedor_p'>";
							echo "<div class='row'>";
							$columna = "";
							if($navegador == "Safari"){
								$columna = "offset-md-3 ";
							}
							echo "<div class='".$columna."col-md-6'>";
							foreach ($actual as $key => $value) {
								echo "<div class='text_origen' id='nido_".$value['id_opcion']."'>";
								echo "<input type='hidden' name='opcion[]' value='".$value['id_opcion']."'>";
								echo "<label style='cursor:pointer;'>".utf8_encode($value['descripcion'])."</label>";
								echo "</div><br><br>";
							}
							echo "</div>";
							echo "<div class='".$columna."col-md-6'>";
							$l = 1;
							foreach ($actual as $key => $value) {
								echo "<span class='order_priority'>".($l)."</span>";
								echo "<div class='text_destino'><input type='hidden' name='orden[]' value='".($l++)."'></div><br><br>";
							}

							echo "</div>";
							echo "</div>";
							echo "</div>";

							echo "</div>";
							echo "</div>";
							echo "<br><br>";
							$indice++;
						}
					  ?>
					 <div class="row text-center">
					 	 <div class="col-md-12">
					     <input type="submit" name="" value="Guardar" class="btn btn-success">
					   </div>
					 </div>
				</form>
			</div>
		</div>
	</div>
</div>
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
					<input type="hidden" name="acceso" id="acceso" value="<?php echo (isset($acceso) && !empty($acceso)) ? "1" : "0"; ?>">
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

<!-- Modal -->
<div class="modal fade" id="msg_inforcuestionario" tabindex="-1" role="dialog" aria-labelledby="msg_inforcuestionario" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" align="center">Instrucciones</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <h5 class="text-justify">Para una mayor efectividad en tu búsqueda, a continuación, te presentamos tres <b>Formularios de Personalidad</b>, sigue las siguientes instrucciones:</h5>
            <h5 class="text-justify">- Debes responder en el menor tiempo posible<br>
               - Apagar celulares o aparatos que pudieran ser distractores<br>
               - Contesta en forma honesta y precisa. <b>Solo accederás una vez</b><br>
               - Al enviar no podrás realizar ningún tipo de corrección</h5>
            <h5>¿Estás listo? Coloca tu mente en blanco y haz clic</h5>
            <center>
              <button type="button" class="btn btn-success" data-dismiss="modal">Formularios </button>
            </center> 
          </div>
        </div>
      </div>      
    </div>
  </div>
</div>
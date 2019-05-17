<div class="container">

	<div class="col-md-12">
		<div class="text-center">
			<br>
			<div class="con_encabezado">
				<span class="encabezado">Por favor ordene de 1 a 5 las siguientes oraciones en cada pregunta. (1 es la oración con la que mas se identifica y 5 es con la que menos se identifica). Este test consta de 20 preguntas<br><h3 class="metodoTexto"><b>Método seleccionado: </b>Seleccionar y arrastrar<img style="width: 3%;" src="<?php echo PUERTO."://".HOST."/imagenes/metodoSel/2.png";?>"></h3></span>
			</div>
			<br>
		</div>
		<div class="">
			<div class="">
				<form action="<?php echo PUERTO."://".HOST;?>/cuestionario/guardarResp/" method="post" id="forma_2">
					<div class="respuestas" id="respuestas" style="display: none;"></div>					
					<input type="hidden" name="tiempo" id="tiempo" value="<?php echo $tiempo; ?>">
					<input type="hidden" name="acceso" id="acceso" value="<?php echo (isset($acceso) && !empty($acceso)) ? "1" : "0"; ?>">
					<input type="hidden" name="faceta" id="faceta" value="<?php echo $faceta; ?>">
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
							echo "<div class='error_msg' id='error".$indice."'></div>";
							echo "<div class='panel-heading'><h5>Pregunta ".$indice."</h5></div>";
							echo "<div class='panel-body'>";
								echo "<div class='contenedor_p_".$pregunta['id_pregunta']."''>";
								echo "<div class='row'>";
                				echo "<div class='".$columna."col-md-6'>";
								foreach ($actual as $key => $value) {
									echo "<div class='contenedor_drag'>";
									echo "<div class='drag_origen' id='nido_".$value['id_opcion']."'>";
									echo "<input type='hidden' name='opcion[]' value='".$value['id_opcion']."'>";
									echo "<label style='cursor:pointer;'>".utf8_encode($value['descripcion'])."</label>";
									echo "</div>";
									echo "</div><br><br>";
								}
								echo "</div>";
								echo "<div class='col-md-6'>";
								$l = 1;
								foreach ($actual as $key => $value) {
									echo "<span class='order_priority'>".($l)."</span>";
									echo "<div class='drop_destino'><input type='hidden' name='orden[]' value='".($l++)."'></div><br><br>";
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
					     <input type="submit" name="" value="Guardar" class="btn-blue">
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
      <div class="text-center">
      	<h1 class="qs-subt-1">RECOMENDACIONES</h1>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">  
             <span class="contenido-modal-rec">Para obtener mayor efectividad en su b&uacute;squeda de empleo, le invitamos a llenar el siguiente <b>Test de Personalidad</b>. Por favor, tome en cuenta las siguientes recomendaciones:</span>
            <ul>
            	<li class="contenido-modal-rec">No existe l&iacute;mite de tiempo, pero mientras menos se demore tendr&aacute; mejores resultados.</li>
            	<li class="contenido-modal-list">Busque un lugar tranquilo para que pueda completar el test.</li>
            	<li class="contenido-modal-list">Apague celulares o aparatos que puedan distraerlo.</li>
            	<li class="contenido-modal-list">Conteste de forma honesta y precisa. <b>Solo puede acceder una vez.</b></li>
            	<li class="contenido-modal-list">Al enviar no podr&aacute; realizar ning&uacute;n tipo de correcci&oacute;n.</li>
            </ul>   
            <br>
            <br>    
            <center>
              <button type="button" class="btn-blue" data-dismiss="modal">Comenzar</button>
            </center> 
          </div>
        </div>
      </div>      
    </div>
  </div>
</div>
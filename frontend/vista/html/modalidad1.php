<div class="container">

	<div class="col-md-12">
		<div class="text-center">
			<br>
			<div class="con_encabezado">
				<span class="encabezado">CANEA es un informe psicológico de competencias laborales que consta de tres tests con 20 apartados. Ordene de 1 a 5 las oraciones en cada pregunta. En donde 1 es la oración con la que más se identifica y 5 con la que menos se identifica.</span><br>
				<div align="center">
					<h3 class="metodoTexto"><b>Método seleccionado: </b>Doble Click
						<img style="width: 3%;" src="<?php echo PUERTO."://".HOST."/imagenes/metodoSel/1.png";?>">
					</h3>
				</div>
			</div>
			<br>
		</div>
		<div class="">
			<div class="">
				<form action="<?php echo PUERTO."://".HOST;?>/cuestionario/guardarResp/" method="post" id="forma_1">
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
							echo "<div class='error_msg'></div>";
							echo "<div class='panel-heading'><h4>Pregunta ".$indice."</h4></div>";
							echo "<div class='panel-body'>";

							echo "<div class='contenedor_p'>";
							echo "<div class='row'>";
							$columna = "";
							if($navegador == "Safari"){
								$columna = "offset-md-3 ";
							}
							echo "<div class='".$columna."col-md-6 col-sm-6 col-xs-6 col-lg-6'>";
							foreach ($actual as $key => $value) {
								echo "<div class='text_origen' id='nido_".$value['id_opcion']."'>";
								echo "<input type='hidden' name='opcion[]' value='".$value['id_opcion']."'>";
								echo "<label style='cursor:pointer;'>".utf8_encode($value['descripcion'])."</label>";
								echo "</div><br><br>";
							}
							echo "</div>";
							echo "<div class='".$columna."col-md-6 col-sm-6 col-xs-6 col-lg-6'>";
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
      	<?php 
         	if($pagadoEstado == false || $pagadoEstado < 2){?><h1 class="qs-subt-1">RECOMENDACIONES</h1><?php
         	}else{?><h1 class="qs-subt-1">¡Noticias Fant&aacute;sticas!</h1><?php
	 		}
       	?>
      	
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12" style="text-align: justify;">  
          	<?php 
          		if($pagadoEstado == false || $pagadoEstado < 2){
          			?>
          				<span class="contenido-modal-rec">Para obtener mayor efectividad en la búsqueda de empleo, le invitamos a completar el siguiente <b>TEST DE COMPETENCIAS</b>. ¡Recuerde! los test no son una pérdida de tiempo, mucho menos si el reclutador tiene claro cómo utilizar esta herramienta.</span><br><br>
			            <ul>
			            	<li class="contenido-modal-list">Prepárese. Mantenga una actitud tranquila.</li>
			            	<li class="contenido-modal-list">Sea sincero, no pierda credibilidad</li>
			            	<li class="contenido-modal-list">Lea las instrucciones.</li>
			            	<li class="contenido-modal-list">Domine los nervios.</li>
			            	<li class="contenido-modal-list">Sea usted mismo.</li>
			            	<li class="contenido-modal-list">Solo se puede acceder una sola vez.</li>
			            	<li class="contenido-modal-list">Después enviar el test no podrá realizar ningún tipo de corrección.</li>
			            </ul>
          			<?php	
          		}
          		else{
          			?>
          				<span class="contenido-modal-rec">Ahora podrá conocer sus fortalezas laborales a través de nuestro INFORME COMPLETO POR COMPETENCIAS. Recuerde, al rendir el tercer test usted ha conseguido elevar sus oportunidades de obtener un empleo.</span>
          			<?php
          		}
			?>


           	<br>
			<br> 
            <center>
              <button type="button" class="btn-blue" data-dismiss="modal">Iniciar Test</button>
            </center> 



          </div>
        </div>
      </div>      
    </div>
  </div>
</div>
<?php 
  foreach($arreglo as $plan){ ?>
        <ul style="<?php echo ($plan["promocional"]) ? "border: 2px solid #a21414;" : "border: 1px solid #262D5D";?>" class="theplan col-xs-12 col-md-4">
          <li class="title <?php echo ($plan["promocional"]) ? "headingrojo" : "headingazul";?>"><?php echo utf8_encode($plan["nombre"]);?></li>
          <li><img src="<?php echo PUERTO;?>://<?php echo HOST;?>/imagenes/planes/<?php echo $plan["id_plan"];?>.<?php echo $plan["extension"];?>" ></li>
          <li class="titulo"><?php 

            echo (($plan["promocional"]) ? "Promoci&oacute;n " : "");
            if (!empty($plan["duracion"])){ 
              echo $plan["duracion"]." días"; 
            } 
          ?></li>
          <?php 
            $listadoAcciones = explode(",",$plan['acciones']);
            $listadoPermisos = explode(",",$plan['descripciones']);
            foreach($listadoPermisos as $key => $permiso){
              if ($listadoAcciones[$key] == "descargarHv"){
                $permiso = str_replace('NRO',$plan["porc_descarga"],$permiso);
              }
              if ($listadoAcciones[$key] == "publicarOferta" || $listadoAcciones[$key] == "autopostulacion"){
                $permiso = str_replace('NRO',$plan["num_post"],$permiso);
              }              
          ?>
            <li>• <?php echo utf8_encode(trim($permiso));?></li>
          <?php                           
            } 
          ?>

          <li>
            <h1>$<?php echo number_format($plan["costo"],2);?>
              <span class="subscript"></span>
            </h1>
            <a class="pricebutton" onclick="msg_compra(<?php echo $plan["id_plan"];?>);">
              <span class="icon-tag"></span> Suscribirse
            </a>
          </li>
        </ul>
<?php } ?>    

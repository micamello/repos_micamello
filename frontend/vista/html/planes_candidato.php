<div class="container">
  <div class="row">
    <div class="main_business">      
      <?php if (!empty($planes)){ ?>                
        <div class="col-md-12">        
          <h3 align="left">Seleccione un plan:</h3>
          <div class="pricingdiv">   
            <?php foreach($planes as $plan){ ?>
              <ul style="<?php echo ($plan["promocional"]) ? "border: 2px solid #a21414;" : "border: 1px solid #262D5D";?>" class="theplan col-xs-12 col-md-4">
                <li class="title <?php echo ($plan["promocional"]) ? "headingrojo" : "headingazul";?>"><?php echo utf8_encode($plan["nombre"]);?></li>
                <li><img src="<?php echo PUERTO;?>://<?php echo HOST;?>/imagenes/planes/<?php echo $plan["id_plan"];?>.<?php echo $plan["extension"];?>" ></li>
                <li class="titulo">
                  <?php 
                  echo (($plan["promocional"]) ? "Promoci&oacute;n " : "&nbsp;");
                  if (!empty($plan["duracion"])){ 
                    echo $plan["duracion"]." días"; 
                  } 
                  else{
                    echo "ilimitado"; 
                  }
                ?></li>
                <?php 
                  $listadoAcciones = explode(",",$plan['acciones']);
                  $listadoPermisos = explode(",",$plan['permisos']);
                  foreach($listadoPermisos as $key => $permiso){                    
                    if ($listadoAcciones[$key] == "autopostulacion"){
                      $permiso = str_replace('NRO',$plan["num_post"],$permiso);
                    }              
                ?>
                  <li class="text-justify">• <?php echo utf8_encode(trim($permiso));?></li>
                <?php                           
                  } 
                ?>
                <li>
                  <h1><?php echo $_SESSION["mfo_datos"]["sucursal"]["simbolo"].number_format($plan["costo"],2);?>
                    <span class="subscript"></span>
                  </h1>
                  <a class="pricebutton" onclick="msg_compra(<?php echo $plan["id_plan"];?>,'<?php echo utf8_encode($plan["nombre"]);?>');">
                    <span class="icon-tag"></span> Suscribirse
                  </a>
                </li>
              </ul>
            <?php } ?> 
          </div>                                
        </div>  
      <?php } ?>       
    </div>
  </div>
</div>
<br><br>

<!-- Modal -->
<div class="modal fade" id="msg_confirmplan" tabindex="-1" role="dialog" aria-labelledby="msg_confirmplan" aria-hidden="true">
  <div class="modal-dialog" role="document">    
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Confirmaci&oacute;n de Sucripci&oacute;n de plan</h5>                
      </div>
      <div class="modal-body">
        <h5>Usted procedera a suscribirse en el Plan <b><span id="desplan"></span></b>&nbsp;¿Desea continuar?</h5>
        <p class="text-center"><i class="fa fa-shopping-cart fa-5x" aria-hidden="true"></i></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <a class="btn btn-primary" href="" id="btncomprar">Comprar</a>
      </div>
    </div>    
  </div>
</div>
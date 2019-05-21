<div class="container-fluid">
    <div class="col-md-12">
      <div class="text-center"><h2 class="titulo text-center">Planes</h2></div>
      <br>
    </div>

<?php if (!empty($planes)){ ?>   
    <div class="col-md-12">
      <div class="pricingdiv flex-container">
        <?php $count = 0; $class=""; foreach($planes as $plan){$count++;

              if($count == 1){$class = "izq";}if($count == 2){$class = "cen";}if($count == 3){$class = "der";}

              $plan["id_plan"] = Utils::encriptar($plan["id_plan"]);
            ?>
        <ul id="" class="<?php echo $class; ?> theplan plan-tabla col-xs-12 col-md-4 flex-item">
        <!-- <ul style="<?php echo ($plan["promocional"]) ? "border: 2px solid #a21414;" : "border: 1px solid #262D5D";?>" class="theplan col-xs-12 col-md-4"> -->

        <!-- <li class="title <?php echo ($plan["promocional"]) ? "headingrojo" : "headingazul";?>"><?php echo strtoupper(utf8_encode($plan["nombre"]));?></li>  -->

          <div class="titulo-planes title headingazul"><?php echo strtoupper(utf8_encode($plan["nombre"]));?></div>
          <div class="plan-precio"><?php echo SUCURSAL_MONEDA.number_format($plan["costo"],2);?>
          </div>
          <?php if (!empty($plan["costo"])){ ?>  
          <small>(El precio incluye IVA)</small>
          <?php }else{
            ?>
            <small>&nbsp;</small>
            <?php
          } ?>
          <div class="plan-dias"> <?php echo (empty($plan["duracion"])) ? "ILIMITADO" : $plan["duracion"]." D&Iacute;AS";?></div>

          <?php 
            $listadoAcciones = explode(",",$plan['acciones']);
            $listadoPermisos = explode(",",$plan['permisos']);
            foreach($listadoPermisos as $key => $permiso){                    
              if ($listadoAcciones[$key] == "autopostulacion"){
                $permiso = str_replace('NRO',$plan["num_post"],$permiso);
              }              
            ?>
            <li class="lista-plan" class="text-justify"><p class="lista-plan-2"><?php echo utf8_encode(trim($permiso));?></p></li>
            <?php                           
            } 
            ?><br><br><br><br>
                <?php if (empty($plan["costo"])) { ?>
                  <a class="pricebutton btn-blue btn-bottom" href="<?php echo PUERTO;?>://<?php echo HOST;?>/compraplan/<?php echo $plan["id_plan"];?>/">
                    <span class="icon-tag"></span>POSTULARSE
                  </a><p><br></p>
                <?php } else { ?>
                  <a class="pricebutton btn-blue btn-bottom" onclick="msg_compra('<?php echo $plan["id_plan"];?>','<?php echo utf8_encode($plan["nombre"]);?>');">
                    <span class="icon-tag"></span>SUSCRIBIRSE
                  </a><p><br></p>
                <?php } ?> 


          
          <!-- <a class="pricebutton btn-blue" href="https://www.micamello.com.ec/desarrollov3/compraplan/5944e857ecd4b69a071602618a95fcd6/">POSTULARSE</a><p><br></p> -->
        </ul>
      <?php } ?> 
      </div>
    </div>
<?php } ?>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="msg_confirmplan" tabindex="-1" role="dialog" aria-labelledby="msg_confirmplan" aria-hidden="true">
  <div class="modal-dialog" role="document">    
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Confirmaci&oacute;n de Sucripci&oacute;n de Plan</h5>                        
      </div>
      <div class="modal-body">                           
        <h5>Usted procedera a suscribirse en el Plan <b><span id="desplan"></span></b>&nbsp;¿Desea continuar?</h5>
        <!-- <p class="text-center"><i class="fa fa-shopping-cart fa-5x" aria-hidden="true"></i></p> -->
      </div>    
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <a class="btn btn-primary" href="" id="btncomprar">Comprar</a>
      </div>
    </div>    
  </div>
</div>
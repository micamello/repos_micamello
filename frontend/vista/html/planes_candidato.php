<div class="container-fluid">
  <div class="container">
    <div class="col-md-12">
      <div><h2 class="titulo text-center">Planes</h2></div>
      <br>
    </div>
    
    <div class="col-md-12">
      <div class="pricingdiv flex-container">
      <?php 
      if (!empty($planes)){  
        foreach($planes as $key=>$plan){
          $plan["id_plan"] = Utils::encriptar($plan["id_plan"]);
      ?>
        <ul class="plan-tabla <?php echo ($key == 0) ? "izq col-md-offset-2" : "cen"; ?> theplan col-xs-12 col-md-4 flex-item">
          <?php if (empty($plan["costo"])){ ?> 
            <div>&nbsp;</div>
          <?php } ?>
          <div class="titulo-planes title headingazul"><?php echo strtoupper(utf8_encode($plan["nombre"]));?></div>
          <div class="plan-precio"><?php echo SUCURSAL_MONEDA.number_format($plan["costo"],2);?></div>
          <?php if (!empty($plan["costo"])){ ?> 
            <p><small>(El precio incluye IVA)</small></p>
          <?php } else{ ?>
            <p><small>&nbsp;</small></p>
          <?php } ?>
          <div class="plan-dias"><?php echo (empty($plan["duracion"])) ? "&nbsp;" : $plan["duracion"]." D&Iacute;AS";?></div>
          <!--<br>-->
          <?php 
          $listadoAcciones = explode(",",$plan['acciones']);
          $listadoPermisos = explode(",",$plan['permisos']);
          foreach($listadoPermisos as $key => $permiso){                    
            if ($listadoAcciones[$key] == "autopostulacion"){
              $permiso = str_replace('NRO',$plan["num_post"],$permiso);
            }              
            ?>
            <li class="lista-plan" class="text-justify">
              <p class="lista-plan-2">
                <?php echo utf8_encode(trim($permiso));?>                
              </p>
            </li>
          <?php } ?>
          <!--<br>-->
          <br>
          <br>
          <br>
          <?php if (empty($plan["costo"])) { ?>
            <a class="pricebutton btn-blue btn-bottom" href="<?php echo PUERTO;?>://<?php echo HOST;?>/compraplan/<?php echo $plan["id_plan"];?>/"><span class="icon-tag"></span>
              POSTULARSE
            </a>
          <?php } else { ?>            
            <a class="pricebutton btn-blue btn-bottom" onclick="msg_compra('<?php echo $plan["id_plan"];?>','<?php echo utf8_encode($plan["nombre"]);?>');"><span class="icon-tag"></span>
              SUSCRIBIRSE
            </a>
          <?php } ?>  
          <p><br></p>      
        </ul>
      <?php 
        } 
      } ?> 
      </div> 
    </div>

  </div>  
</div>
 
<br> 
<!-- Modal -->
<div class="modal fade" id="msg_confirmplan" tabindex="-1" role="dialog" aria-labelledby="msg_confirmplan" aria-hidden="true">
  <div class="modal-dialog" role="document">    
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Confirmaci&oacute;n de Suscripci&oacute;n de Plan</h5>                        
      </div>
      <div class="modal-body">                           
        <h5>Usted procedera a suscribirse en el Plan <b><span id="desplan"></span></b>&nbsp;¿Desea continuar?</h5>
        <!-- <p class="text-center"><i class="fa fa-shopping-cart fa-5x" aria-hidden="true"></i></p> -->
      </div>    
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <a class="btn btn-primary" href="" id="btncomprar">Continuar</a>
      </div>
    </div>    
  </div>
</div>
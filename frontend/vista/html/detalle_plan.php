<?php foreach($arreglo as $plan){ ?>
  <a onclick="javascript:void(0);">
    <div class="col-xs-12 col-md-4">
      <div class="panel panel-primary <?php echo ($plan["promocional"]) ? "panelrojo" : "panelazul";?>">
        <?php if ($plan["promocional"]){ ?>
          <div class="">
            <div class="ribbon ribbon-top-right"><span>Promoción</span></div>
          </div>                       
        <?php } ?>
        <div class="panel-heading <?php echo ($plan["promocional"]) ? "headingrojo" : "headingazul";?>">
          <h3 class="panel-title"><?php echo utf8_encode($plan["nombre"]);?></h3>
        </div>
        <div class="panel-body <?php echo ($plan["promocional"]) ? "bodyrojo" : "";?>">
          <table align="center">
            <tr align="center">
              <td><img src="<?php echo PUERTO;?>://<?php echo HOST;?>/imagenes/planes/<?php echo $plan["id_plan"];?>.<?php echo $plan["extension"];?>" style="width: 22%;"></td>
            </tr>                            
            <tr align="center" class="titulo">
              <td>
                <?php 
                if (!empty($plan["duracion"])){ 
                  echo $plan["duracion"]." días"; 
                } 
                else{
                  echo "<br>";   
                }
                ?>                            
              </td>
            </tr>                            
            <?php 
            $listado = Modelo_PermisoPlan::listaPermisoxPlan($plan["id_plan"]);             
            foreach($listado as $permiso){
              if ($permiso["accion"] == "descargarHv"){
                $permiso["descripcion"] = str_replace('NRO',$plan["porc_descarga"],$permiso["descripcion"]);
              }
              if ($permiso["accion"] == "publicarOferta" || $permiso["accion"] == "autopostulacion"){
                $permiso["descripcion"] = str_replace('NRO',$plan["num_post"],$permiso["descripcion"]);
              }              
            ?>
              <tr class="aut"><td>• <?php echo utf8_encode($permiso["descripcion"]);?></td></tr>                              
            <?php } ?>
            <tr align="center">
              <td><br><br>
                <h1>$<?php echo number_format($plan["costo"],2);?><span class="subscript"></span></h1>
                <a class="btn btn-success">Suscribirse</a>
              </td>
            </tr>
          </table>
        </div>               
      </div>
    </div>
  </a>        
<?php } ?>    
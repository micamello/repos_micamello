<div class="comparison container-fluid">
  <table style="box-shadow: 10px 10px 5px grey;">
    <thead>
      <tr>
        <th class="logo-tabla" rowspan="2"><img src="<?php echo PUERTO."://".HOST."/imagenes/logo-azul.png"?>" width="100%"></th>
        <?php foreach($planes as $key=>$plan){
        if($plan['id_plan'] == 1){continue;} ?> 
          <th class="plus head-plan">
            <?php echo strtoupper(utf8_encode($plan["nombre"]));?> 
            <img src="<?php echo PUERTO."://".HOST."/imagenes/corona-2-03.png"?>" class="corona">
          </th>
        <?php } ?>
      </tr>     
    </thead>
    <tbody class="tabla-planes-n">    
      <?php       
      $listadoAcciones = explode(",",$plan['acciones']);
      $listadoPermisos = explode(",",$plan['permisos']);     
      foreach($listadoPermisos as $key => $permiso){                
        $par = $key % 2;          
        $clase = ($par == 0) ? "compare-row" : "";                                  
        echo "<tr>";
        echo "<td></td>";
        echo "<td>".utf8_encode(trim($permiso))."</td>";            
        echo "</tr>";
        echo "<tr class='".$clase."'>";
        echo "<td>".utf8_encode(trim($permiso))."</td>"; 
        foreach($planes as $keyp=>$plan){ 
        if($plan['id_plan'] == 1){continue;}                         
          if ($listadoAcciones[$key] == "autopostulacion"){            
            echo "<td><span class='plan-negrita'>".$plan["num_post"]."</span><span class='plan-negrita-2'>Autopostulaciones</span></td>";   
          } 
          else{
            $indicador = "✔";
            if($plan['costo'] == 0 && $listadoAcciones[$key] != "alertaOferta"){
              $indicador = "X";
            }
            echo "<td><span class='simbolos tickgreen'>".$indicador."</span></td>"; 
          }        
        }
        echo "</tr>";                     
      }               
      ?>                            
    </tbody>
    <tfoot>
      <tr>
        <td class="tab-ocultar"></td>
        <?php         
        foreach($planes as $key=>$plan){ 
          if($plan['id_plan'] == 1){continue;}
          echo "<td class='price-info'>";
          echo SUCURSAL_MONEDA.number_format($plan["costo"],2);
          echo "</td>";
        }      
        ?>                
      </tr>
      <tr>
        <td>&nbsp</td>
        <?php         
        foreach($planes as $key=>$plan){ 
          if($plan['id_plan'] == 1){continue;}
          $plan["id_plan"] = Utils::encriptar($plan["id_plan"]);
          $enlace = (empty($plan['costo'])) ? "href='".PUERTO."://".HOST."/compraplan/".$plan["id_plan"]."/'" : 
                                              "onclick=\"msg_compra('".$plan["id_plan"]."','".utf8_encode($plan["nombre"])."');\"";
          echo "<td class='plus head-plan'><a ".$enlace." style='color:white;'>COMPRAR AHORA</a></td>"; 
        }                            
        ?>         
      </tr>
    </tfoot>
  </table>
</div>
 
<br>
<br>  
<!-- Modal -->
<div class="modal fade" id="msg_confirmplan" tabindex="-1" role="dialog" aria-labelledby="msg_confirmplan" aria-hidden="true">
  <div class="modal-dialog" role="document">    
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Confirmaci&oacute;n de Suscripci&oacute;n de Plan</h5>                        
      </div>
      <div class="modal-body">                           
        <h5>Usted procedera a suscribirse en el <b>Plan <span id="desplan"></span></b>&nbsp;¿Desea continuar?</h5>
        <!-- <p class="text-center"><i class="fa fa-shopping-cart fa-5x" aria-hidden="true"></i></p> -->
      </div>    
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <a class="btn btn-primary" href="" id="btncomprar">Continuar</a>
      </div>
    </div>    
  </div>
</div>
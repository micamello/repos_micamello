<div class="container-fluid">
  <div class="container">
    <div class="col-md-12">
      <div><h2 class="titulo text-center">Mis Planes</h2></div>
      <br>
      <br>
    </div>

<?php if (!empty($planes)){ ?> 
    <div class="col-md-12">
      <input type="hidden" id="simbolo" value="<?php echo SUCURSAL_MONEDA;?>">  
      <div class="pricingdiv flex-container">
        <?php 
          if (!empty($gratuitos) && is_array($gratuitos)){ 
            $opc_select = '';
            foreach($gratuitos as $gratuito){ 
              $gratuito["id_plan"] = Utils::encriptar($gratuito["id_plan"]);
          ?>
          <input type="hidden" id="grattitulo_<?php echo $gratuito["id_plan"];?>" value="<?php echo utf8_encode($gratuito["nombre"]);?>">
          <input type="hidden" id="gratprom_<?php echo $gratuito["id_plan"];?>" value="<?php echo $gratuito["promocional"];?>">
          <input type="hidden" id="gratext_<?php echo $gratuito["id_plan"];?>" value="<?php echo $gratuito["extension"];?>">
          <input type="hidden" id="gratid_<?php echo $gratuito["id_plan"];?>" value="<?php echo $gratuito["id_plan"];?>">
          <input type="hidden" id="gratdura_<?php echo $gratuito["id_plan"];?>" value="<?php echo $gratuito["duracion"];?>">
          <input type="hidden" id="gratcosto_<?php echo $gratuito["id_plan"];?>" value="<?php echo number_format($gratuito["costo"],2);?>">
          <?php
            $listadoAcciones = explode(",",$gratuito['acciones']);
            $listadoPermisos = explode(",",$gratuito['permisos']);
            $permisos_grat = '';
            foreach($listadoPermisos as $key => $permiso){
              if ($listadoAcciones[$key] == "publicarOferta" || $listadoAcciones[$key] == "publicarOfertaConfidencial"){
                  $permiso = str_replace('NRO',$gratuito["num_post"],$permiso);                        
                  $permiso = ($gratuito["num_post"] > 1) ? str_replace("publicaci","publicaciones",$permiso) : str_replace("publicaci","publicaci&oacute;n",$permiso);                     
              }
              if ($listadoAcciones[$key] == "adminEmpresas"){
                $permiso = str_replace('NRO',$gratuito["num_cuenta"],$permiso);
              }
              if ($listadoAcciones[$key] == "accessos"){
                $permiso = str_replace('NRO',$gratuito["num_accesos"],$permiso);
              } 
              if ($listadoAcciones[$key] == "buscarCandidatosPostulados"){
                if (!empty($gratuito["limite_perfiles"])){
                  $permiso = str_replace('NRO',$gratuito["limite_perfiles"],$permiso);  
                }
                else{
                 $permiso = str_replace('NRO','',$permiso);   
                }
              } 
              $permisos_grat .= utf8_encode(trim($permiso)).'||';
            }
              $text_publicacion = ($gratuito["num_post"] > 1) ? $gratuito["num_post"]."&nbsp;publicaciones" : $gratuito["num_post"]."&nbsp;publicaci&oacute;n";                 
            $opc_select .= '<option value="'.$gratuito["id_plan"].'">'.$gratuito["nombre"].'&nbsp;-&nbsp;'.$gratuito["num_post"].'&nbsp;'.$text_publicacion.'</option>';
            ?>
            <input type="hidden" id="gratpermiso_<?php echo $gratuito["id_plan"];?>" value="<?php echo $permisos_grat;?>">  
          <?php } ?> 

          <ul id="gratul" style="" class="izq theplan plan-tabla col-xs-12 col-md-4 flex-item">
                  <div>&nbsp;</div>
                  <div class="" id="grattitulo"></div>
                    <div id="gratcosto" class="plan-precio"> 
                      <!-- <span class="subscript"></span> -->
                    </div>
                    <small>&nbsp;</small>
                  <div id="gratdura" class="plan-dias"></div>
                  <?php if (count($gratuitos) > 1){ ?>
                  <div class="select-plan1">
                    <select class="form-control" id="gratcmb">
                      <?php echo $opc_select; ?>
                    </select>
                  </div>                   
                  <?php } else{  ?>
                      <input type="hidden" id="gratcmb" value="<?php echo $gratuito["id_plan"];?>">
                      <input type="hidden" id="gratnombre" value="<?php echo utf8_encode($gratuito["nombre"]);?>">
                  <?php }?>
                  <div id="gratpermisos"></div>  
                  <?php $habilitado = (empty($_SESSION['mfo_datos']['planes'])) ? "mensaje();" : 'buttongrat();';?>
                  <br>
                  <br>
                  <br>
                  <br> 
                    <a class="pricebutton btn-blue btn-bottom" onclick="<?php echo $habilitado;?>"><span class="icon-tag"></span> Subscribirse</a>
                    <p><br></p>
                </ul>
              <?php } ?> 


      <?php 
              if (!empty($planes) && is_array($planes)){                                  
                $opc_select = '';
                foreach($planes as $plan){ 
                  $plan["id_plan"] = Utils::encriptar($plan["id_plan"]);
              ?>
                  <input type="hidden" id="plantitulo_<?php echo $plan["id_plan"];?>" value="<?php echo utf8_encode($plan["nombre"]);?>">
                  <input type="hidden" id="planprom_<?php echo $plan["id_plan"];?>" value="<?php echo $plan["promocional"];?>">
                  <input type="hidden" id="planext_<?php echo $plan["id_plan"];?>" value="<?php echo $plan["extension"];?>">
                  <input type="hidden" id="planid_<?php echo $plan["id_plan"];?>" value="<?php echo $plan["id_plan"];?>">
                  <input type="hidden" id="plandura_<?php echo $plan["id_plan"];?>" value="<?php echo $plan["duracion"];?>">
                  <input type="hidden" id="plancosto_<?php echo $plan["id_plan"];?>" value="<?php echo number_format($plan["costo"],2);?>">
                  <?php
                  $listadoAcciones = explode(",",$plan['acciones']);
                  $listadoPermisos = explode(",",$plan['permisos']);
                  $permisos_plan = '';
                  foreach($listadoPermisos as $key => $permiso){
                    if ($listadoAcciones[$key] == "publicarOferta" || $listadoAcciones[$key] == "publicarOfertaConfidencial"){
                        $permiso = str_replace('NRO',$plan["num_post"],$permiso);
                        $permiso = ($plan["num_post"] > 1) ? str_replace("publicaci","publicaciones",$permiso) : str_replace("publicaci","publicaci&oacute;n",$permiso);
                    }
                    if ($listadoAcciones[$key] == "adminEmpresas"){
                      $permiso = str_replace('NRO',$plan["num_cuenta"],$permiso);
                    }
                    if ($listadoAcciones[$key] == "accessos"){
                      $permiso = str_replace('NRO',$plan["num_accesos"],$permiso);
                    }
                    if ($listadoAcciones[$key] == "buscarCandidatosPostulados"){
                      if (!empty($plan["limite_perfiles"])){    
                        $permiso = str_replace('NRO',$plan["limite_perfiles"],$permiso);
                      }
                      else{
                        $permiso = str_replace('NRO','',$permiso); 
                      }
                    }  
                    $permisos_plan .= utf8_encode(trim($permiso)).'||';
                  }                   
                    $text_publicacion = ($plan["num_post"] > 1) ? $plan["num_post"]."&nbsp;publicaciones" : $plan["num_post"]."publicaci&oacute;n";
                  $opc_select .= '<option value="'.$plan["id_plan"].'">'.$plan["nombre"].'&nbsp;-&nbsp;'.$text_publicacion.'</option>';
                  ?>
                  <input type="hidden" id="planpermiso_<?php echo $plan["id_plan"];?>" value="<?php echo $permisos_plan;?>">
                <?php } ?>

                <ul id="planul" style="" class="cen theplan plan-tabla col-xs-12 col-md-4 flex-item">
                  <div class="" id="plantitulo"></div>
                  <div id="plancosto" class="plan-precio"></div>
                  <small>(El precio incluye IVA)</small>                                 
                  <div id="plandura" class="plan-dias"></div>
                  <?php if (count($planes) > 1){ ?>
                  <div class="select-plan">
                    <select class="form-control" id="plancmb">
                      <?php echo $opc_select; ?>
                    </select>
                  </div>
                  <?php } else{ ?>
                    <input type="hidden" id="plancmb" value="<?php echo Utils::encriptar($plan["id_plan"]);?>">                      
                    <input type="hidden" id="plannombre" value="<?php echo utf8_encode($plan["nombre"]);?>">
                  <?php } ?>  
                  <div id="planpermisos"></div>   
                  <?php $habilitado = (empty($_SESSION['mfo_datos']['planes'])) ? "mensaje();" : 'buttonplan();';?>
                  <br>
                  <br>
                  <br>
                  <br>         
                  <a class="pricebutton btn-blue btn-bottom" onclick="<?php echo $habilitado;?>"><span class="icon-tag"></span> Suscribirse</a>
                  <p><br></p>
                </ul>                                    
              <?php } ?> 


 <?php 
              if (!empty($avisos) && is_array($avisos)){ 
                $opc_select = '';
                foreach($avisos as $aviso){                 
                  $aviso["id_plan"] = Utils::encriptar($aviso["id_plan"]);
              ?>
                  <input type="hidden" id="avisotitulo_<?php echo $aviso["id_plan"];?>" value="<?php echo utf8_encode($aviso["nombre"]);?>">
                  <input type="hidden" id="avisoprom_<?php echo $aviso["id_plan"];?>" value="<?php echo $aviso["promocional"];?>">
                  <input type="hidden" id="avisoext_<?php echo $aviso["id_plan"];?>" value="<?php echo $aviso["extension"];?>">
                  <input type="hidden" id="avisoid_<?php echo $aviso["id_plan"];?>" value="<?php echo $aviso["id_plan"];?>">
                  <?php $duracion = (empty($_SESSION['mfo_datos']['planes'])) ? $aviso["prom_duracion"] : $aviso["duracion"];?>
                  <input type="hidden" id="avisodura_<?php echo $aviso["id_plan"];?>" value="<?php echo $duracion;?>">
                  <?php $costo = (empty($_SESSION['mfo_datos']['planes'])) ? $aviso["prom_costo"] : $aviso["costo"];?>
                  <input type="hidden" id="avisocosto_<?php echo $aviso["id_plan"];?>" value="<?php echo number_format($costo,2);?>">
                  <?php
                  $listadoAcciones = explode(",",$aviso['acciones']);
                  $listadoPermisos = explode(",",$aviso['permisos']);
                  $permisos_aviso = '';
                  foreach($listadoPermisos as $key => $permiso){
                    if ($listadoAcciones[$key] == "publicarOferta" || $listadoAcciones[$key] == "publicarOfertaConfidencial"){
                        $permiso = str_replace('NRO',$aviso["num_post"],$permiso);
                        $permiso = ($aviso["num_post"] > 1) ? str_replace("publicaci","publicaciones",$permiso) : str_replace("publicaci","publicaci&oacute;n",$permiso);                   
                    }  
                    if ($listadoAcciones[$key] == "adminEmpresas"){
                      $permiso = str_replace('NRO',$aviso["num_cuenta"],$permiso);
                    }
                    if ($listadoAcciones[$key] == "accessos"){
                      $permiso = str_replace('NRO',$aviso["num_accesos"],$permiso);
                    }
                    if ($listadoAcciones[$key] == "buscarCandidatosPostulados"){
                      if (!empty($aviso["limite_perfiles"])){
                        $permiso = str_replace('NRO',$aviso["limite_perfiles"],$permiso);
                      }
                      else{
                        $permiso = str_replace('NRO','',$permiso); 
                      }
                    }
                    $permisos_aviso .= utf8_encode(trim($permiso)).'||';
                  }       
                    $text_publicacion = ($aviso["num_post"] > 1) ? $aviso["num_post"]."&nbsp;publicaciones" : $aviso["num_post"]."&nbsp;publicaci&oacute;n";                
                  $opc_select .= '<option value="'.$aviso["id_plan"].'">'.$aviso["nombre"].'&nbsp;-&nbsp;'.$text_publicacion.'</option>';
                  ?>
                  <input type="hidden" id="avisopermiso_<?php echo $aviso["id_plan"];?>" value="<?php echo $permisos_aviso;?>">  
                <?php } ?>
                <ul id="avisoul" class="der theplan plan-tabla col-xs-12 col-md-4 flex-item">
                <div>&nbsp;</div>
                  <div id="avisotitulo" class=""></div>
                    <div id="avisocosto" class="plan-precio"></div>
                    <small>(El precio incluye IVA)</small>                   
                  <div id="avisodura" class="plan-dias"></div>
                  <?php if (count($avisos) > 1){ ?>
                  <div class="select-plan">
                    <select class="form-control" id="avisocmb">
                      <?php echo $opc_select; ?>                           
                    </select>
                  </div>
                  <?php } else { ?>
                      <input type="hidden" id="avisocmb" value="<?php echo $aviso["id_plan"];?>">   
                      <input type="hidden" id="avisonombre" value="<?php echo utf8_encode($aviso["nombre"]);?>">
                  <?php } ?>  
                  <div id="avisopermisos"></div>
                  <?php $habilitado = (empty($_SESSION['mfo_datos']['planes'])) ? "buttonavisograt();" : 'buttonaviso();';?>
                  <br>
                  <br>
                  <br>
                  <br> 
                  <a class="pricebutton btn-blue btn-bottom" onclick="<?php echo $habilitado;?>"><span class="icon-tag"></span> Suscribirse</a>
                  <p><br></p>
                </ul>
              <?php } ?>


      </div>
    </div>
<?php } ?> 
  </div>
</div>
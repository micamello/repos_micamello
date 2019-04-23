<div class="container">
  <div class="row">
    <div class="main_business">      
      <?php if (!empty($planes)){ ?>                
        <div class="col-md-12">        
          <h3>Seleccione un plan:</h3>
          <input type="hidden" id="simbolo" value="<?php echo SUCURSAL_MONEDA;?>">          
            <div class="pricingdiv">   
              <?php 
              if (!empty($gratuitos) && is_array($gratuitos)){ 
                $opc_select = '';
                foreach($gratuitos as $gratuito){ ?>
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
                    if ($listadoAcciones[$key] == "descargarHv"){                      
                      $porc_descarga = ($gratuito["porc_descarga"] == -1) ? "total" : $gratuito["porc_descarga"];
                      $permiso = str_replace('NRO',$porc_descarga,$permiso);
                    }
                    if ($listadoAcciones[$key] == "publicarOferta" || $listadoAcciones[$key] == "publicarOfertaConfidencial"){
                      if ($gratuito["num_post"] == -1){
                        $permiso = "Publicaciones ilimitadas";
                      }
                      else{
                        $permiso = str_replace('NRO',$gratuito["num_post"],$permiso);                        
                        $permiso = ($gratuito["num_post"] > 1) ? str_replace("publicaci","publicaciones",$permiso) : str_replace("publicaci","publicaci&oacute;n",$permiso);
                      }                      
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
                  if ($gratuito["num_post"] == -1){
                    $text_publicacion = "publicaciones ilimitadas";
                  }
                  else{
                    $text_publicacion = ($gratuito["num_post"] > 1) ? $gratuito["num_post"]."&nbsp;publicaciones" : $gratuito["num_post"]."&nbsp;publicaci&oacute;n";                      
                  }                  
                  $opc_select .= '<option value="'.$gratuito["id_plan"].'">'.$gratuito["nombre"].'&nbsp;-&nbsp;'.$gratuito["num_post"].'&nbsp;'.$text_publicacion.'</option>';
                  ?>
                  <input type="hidden" id="gratpermiso_<?php echo $gratuito["id_plan"];?>" value="<?php echo $permisos_grat;?>">  
                <?php } ?>
                <ul id="gratul" style="" class="theplan col-xs-12 col-md-4">
                  <li class="" id="grattitulo"></li>
                  <li><img id="gratimg" src=""></li>
                  <li class="titulo" id="gratdura"></li>
                  <?php if (count($gratuitos) > 1){ ?>                    
                     <select class="form-control" id="gratcmb">
                       <?php echo $opc_select; ?>
                     </select>                    
                  <?php } else{  ?>
                    <li>
                      <input type="hidden" id="gratcmb" value="<?php echo $gratuito["id_plan"];?>">
                      <input type="hidden" id="gratnombre" value="<?php echo utf8_encode($gratuito["nombre"]);?>">
                    </li>
                  <?php }?>
                  <div id="gratpermisos"></div>  
                  <li>
                    <h1 id="gratcosto"><span class="subscript"></span></h1>
                    <a class="pricebutton" onclick="buttongrat();"><span class="icon-tag"></span> Publicar Oferta</a>
                  </li>
                </ul>
              <?php } ?> 

              <?php 
              if (!empty($planes) && is_array($planes)){                                  
                $opc_select = '';
                foreach($planes as $plan){ ?>
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
                    if ($listadoAcciones[$key] == "descargarHv"){
                      $porc_descarga = ($plan["porc_descarga"] == -1) ? "total" : $plan["porc_descarga"];
                      $permiso = str_replace('NRO',$porc_descarga,$permiso);
                    }
                    if ($listadoAcciones[$key] == "publicarOferta" || $listadoAcciones[$key] == "publicarOfertaConfidencial"){
                      if ($plan["num_post"] == -1){
                        $permiso = "Publicaciones ilimitadas";
                      } 
                      else{
                        $permiso = str_replace('NRO',$plan["num_post"],$permiso);
                        $permiso = ($plan["num_post"] > 1) ? str_replace("publicaci","publicaciones",$permiso) : str_replace("publicaci","publicaci&oacute;n",$permiso);
                      }
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
                  if ($plan["num_post"] == -1){
                    $text_publicacion = "publicaciones ilimitadas";
                  } 
                  else{               
                    $text_publicacion = ($plan["num_post"] > 1) ? $plan["num_post"]."&nbsp;publicaciones" : $plan["num_post"]."publicaci&oacute;n";
                  }
                  $opc_select .= '<option value="'.$plan["id_plan"].'">'.$plan["nombre"].'&nbsp;-&nbsp;'.$text_publicacion.'</option>';
                  ?>
                  <input type="hidden" id="planpermiso_<?php echo $plan["id_plan"];?>" value="<?php echo $permisos_plan;?>">
                <?php } ?>
                <ul id="planul" style="" class="theplan col-xs-12 col-md-4">
                  <li class="" id="plantitulo"></li>
                  <li><img src="" id="planimg"></li>
                  <li class="titulo" id="plandura"></li>
                  <?php if (count($planes) > 1){ ?>                                        
                    <li>
                    <select class="form-control" id="plancmb">
                      <?php echo $opc_select; ?>
                    </select>
                    </li>
                  <?php } else{ ?>
                    <input type="hidden" id="plancmb" value="<?php echo Utils::encriptar($plan["id_plan"]);?>">                      
                    <input type="hidden" id="plannombre" value="<?php echo utf8_encode($plan["nombre"]);?>">
                  <?php } ?>  
                  <div id="planpermisos"></div>                    
                  <li>
                    <h1 id="plancosto"></h1>
                    <h6><small>(El precio incluye IVA)</small></h6>
                    <a class="pricebutton" onclick="buttonplan();"><span class="icon-tag"></span> Suscribirse</a>
                  </li>
                </ul>                                    
              <?php } ?> 
              
              <?php 
              if (!empty($avisos) && is_array($avisos)){ 
                $opc_select = '';
                foreach($avisos as $aviso){ ?>
                  <input type="hidden" id="avisotitulo_<?php echo $aviso["id_plan"];?>" value="<?php echo utf8_encode($aviso["nombre"]);?>">
                  <input type="hidden" id="avisoprom_<?php echo $aviso["id_plan"];?>" value="<?php echo $aviso["promocional"];?>">
                  <input type="hidden" id="avisoext_<?php echo $aviso["id_plan"];?>" value="<?php echo $aviso["extension"];?>">
                  <input type="hidden" id="avisoid_<?php echo $aviso["id_plan"];?>" value="<?php echo $aviso["id_plan"];?>">
                  <input type="hidden" id="avisodura_<?php echo $aviso["id_plan"];?>" value="<?php echo $aviso["duracion"];?>">
                  <input type="hidden" id="avisocosto_<?php echo $aviso["id_plan"];?>" value="<?php echo number_format($aviso["costo"],2);?>">
                  <?php
                  $listadoAcciones = explode(",",$aviso['acciones']);
                  $listadoPermisos = explode(",",$aviso['permisos']);
                  $permisos_aviso = '';
                  foreach($listadoPermisos as $key => $permiso){
                    if ($listadoAcciones[$key] == "descargarHv"){
                      $porc_descarga = ($aviso["porc_descarga"] == -1) ? "total" : $aviso["porc_descarga"];
                      $permiso = str_replace('NRO',$porc_descarga,$permiso);
                    }
                    if ($listadoAcciones[$key] == "publicarOferta" || $listadoAcciones[$key] == "publicarOfertaConfidencial"){
                      if ($aviso["num_post"] == -1){
                        $permiso = "Publicaciones ilimitadas";
                      }
                      else{
                        $permiso = str_replace('NRO',$aviso["num_post"],$permiso);
                        $permiso = ($aviso["num_post"] > 1) ? str_replace("publicaci","publicaciones",$permiso) : str_replace("publicaci","publicaci&oacute;n",$permiso);
                      }                      
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
                  if ($aviso["num_post"] == -1){
                    $text_publicacion = "publicaciones ilimitadas"; 
                  }
                  else{
                    $text_publicacion = ($aviso["num_post"] > 1) ? $aviso["num_post"]."&nbsp;publicaciones" : $aviso["num_post"]."&nbsp;publicaci&oacute;n";
                  }                  
                  $opc_select .= '<option value="'.$aviso["id_plan"].'">'.$aviso["nombre"].'&nbsp;-&nbsp;'.$text_publicacion.'</option>';
                  ?>
                  <input type="hidden" id="avisopermiso_<?php echo $aviso["id_plan"];?>" value="<?php echo $permisos_aviso;?>">  
                <?php } ?>
                <ul id="avisoul" class="theplan col-xs-12 col-md-4">
                  <li id="avisotitulo" class=""></li>
                  <li><img src="" id="avisoimg"></li>
                  <li class="titulo" id="avisodura"></li>
                  <?php if (count($avisos) > 1){ ?>
                    <li>
                      <select class="form-control" id="avisocmb">
                        <?php echo $opc_select; ?>                           
                      </select>
                    </li>
                  <?php } else { ?>
                    <input type="hidden" id="avisocmb" value="<?php echo $aviso["id_plan"];?>">   
                    <input type="hidden" id="avisonombre" value="<?php echo utf8_encode($aviso["nombre"]);?>">                   
                  <?php } ?>  
                  <div id="avisopermisos"></div>
                  <li>
                    <h1 id="avisocosto"></h1>
                    <h6><small>(El precio incluye IVA)</small></h6>
                    <a class="pricebutton" onclick="buttonaviso();"><span class="icon-tag"></span> Suscribirse</a>
                  </li>
                </ul>
              <?php } ?>
            </div>                                          
        </div>  
      <?php } ?>       
    </div>
  </div>
</div>
<br>

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
        <a href="" class="btn btn-primary" id="btncomprar">Comprar</a>
      </div>
    </div>    
  </div>
</div>
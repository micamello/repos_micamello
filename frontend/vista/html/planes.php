<div class="container">
  <div class="row">
    <div class="main_business">      
      <?php if (!empty($planes)){ ?>                
        <div class="col-md-12">        
          <div class="container"><h3 align="left">Seleccione un plan:</h3></div>
          <div class="container">            
            <div class="row"> 
              <div class="pricingdiv">   
                <?php echo $planes;?>  
              </div>                                
            </div>
          </div>
        </div>  
      <?php } ?> 
      <?php if (!empty($avisos)){ ?>     
        <div class="col-md-12">        
          <div class="container"><h3 align="left">Seleccione un aviso:</h3></div>
          <div class="container">            
            <div class="row"> 
              <div class="pricingdiv">
                <?php echo $avisos;?>  
              </div>                                 
            </div>
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
      <form method="post" action="<?php echo PUERTO;?>://<?php echo HOST;?>/compraplan/" id="form_plan" name="form_plan">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Sucripci&oacute;n de plan</h5>        
          <input type="hidden" name="idplan" id="idplan" value="">
        </div>
        <div class="modal-body"><p>Procederas a suscribirte en el Plan, ¿Continuar?</p></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Comprar</button>
        </div>
      </form>
    </div>
    
  </div>
</div>
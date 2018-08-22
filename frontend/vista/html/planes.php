<div class="container">
  <div class="row">
    <div class="main_business">      
      <?php if (!empty($planes)){ ?>                
        <div class="col-md-12">        
          <div class="container"><h3 align="left">Seleccione un plan:</h3></div>
          <div class="container">            
            <div class="row">    
              <?php echo $planes;?>                                  
            </div>
          </div>
        </div>  
      <?php } ?> 
      <?php if (!empty($avisos)){ ?>     
        <div class="col-md-12">        
          <div class="container"><h3 align="left">Seleccione un aviso:</h3></div>
          <div class="container">            
            <div class="row">    
              <?php echo $avisos;?>                                  
            </div>
          </div>
        </div>
      <?php } ?> 
    </div>
  </div>
</div>
<br><br>
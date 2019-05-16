
<div class="container-fluid">
  <div class="row">
    <div class="text-center velocimetro col-md-12 col-sm-12">
      <h2 class="vel-titulo col-md-12 col-sm-12">posibilidades:</h2>
      <h2 class="vel-titulo-din"><?php echo $posibilidades; ?></h2>
     
      <img src="<?php echo PUERTO.'://'.HOST.'/imagenes/'.$img; ?>" class="img-responsive" width="50%" style="text-align:center;display: inline;">
      <h3 class="vel-subt">¡Lo deseo! ¡Lo necesito!<br>¡LO QUIERO!</h3>
      <center> 
        <div class="vel-caja col-md-12 col-sm-12 text-center">
          <div class="col-md-12">
            <div class="col-md-8 col-sm-12">
             <h3 class="vel-titulo-1"><?php echo $msj1; ?></h3>
             <h2 class="vel-subt-1"><?php echo $msj2; ?></h2>
            </div>
            <div class="col-md-4 col-sm-12">
              <h5>&nbsp;</h5>
            <button class="btn-minimalista">
              <a href="<?php echo PUERTO.'://'.HOST.'/'.$enlaceboton.'/'; ?>"><?php echo $textoBoton; ?></a>
            </button>      
            </div>  
          </div>
        </div>
      </center>
    </div>
  </div>
</div>

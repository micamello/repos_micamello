<div class="text-center">
    <h2 class="qs-subt"><?php echo utf8_encode($_SESSION['mfo_datos']['usuario']['nombres'])."&nbsp;".((isset($_SESSION['mfo_datos']['usuario']['apellidos'])) ? utf8_encode($_SESSION['mfo_datos']['usuario']['apellidos']) : '');?></h2>
  </div>
<br>
<section id="product" class="inicio">
<div class="container">
    <div class="row" id="registro-algo-centro">  
      <div class="col-md-6 col-md-offset-3">
        <div class="" id="inicio-cuadro"> 
          <div align="center" class="col-md-12">
            <!-- <h3>¡El cambio de contraseña se ha realizado con éxito!</h3><br> -->
            <h4>Ha ocurrido un error al comprar el plan<br>
					Por favor intente nuevamente la compra o escr&iacute;banos a info@micamello.com.ec</h4><br>
            <div align="center">
              <a href="<?php echo PUERTO.'://'.HOST.'/planes/'; ?>" class="btn btn-blue">Aceptar</a>
            </div>
            <!-- <button class="btn-light-blue">Finalizar</button> -->
          </div>
          <div class="row">          
          </div>
        </div>
      </div>
    </div>
  </div>
<br>
<br>
</section>
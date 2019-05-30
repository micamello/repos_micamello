<section id="product" class="product">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12" style="margin: 90px 0px 90px 0px">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <img src="<?php echo PUERTO.'://'.HOST.'/imagenes/'.$img; ?>" class="img-responsive">
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="cuadro-velocimetro">
              <center>
                <h2 class="subt-velocimetro"><?php echo $msj2; ?></h2>
                <?php if($valorporc == 20){ ?>
                  <button class="btn-medio bounceCss">
                    <a href="<?php echo PUERTO.'://'.HOST.'/'.$enlaceboton.'/'; ?>"><?php echo $textoBoton; ?></a>
                  </button>   
                <?php } ?>

                <?php if($valorporc == 40){ ?>
                  <button id="btn-verde" class="btn-medio bounceCss">
                    <a href="<?php echo PUERTO.'://'.HOST.'/fileGEN/informeusuario/'.$_SESSION['mfo_datos']['usuario']['username']; ?>">REVISE SU INFORME PARCIAL</a>
                  </button> 
                  <button class="btn-medio bounceCss">
                    <a href="<?php echo PUERTO.'://'.HOST.'/'.$enlaceboton.'/'; ?>"><?php echo $textoBoton; ?></a>
                  </button> 
                <?php } ?>

                <?php if($valorporc == 100){ ?>
                  <button id="btn-verde" class="btn-medio bounceCss">
                    <a href="<?php echo PUERTO.'://'.HOST.'/'.$enlaceboton.'/'; ?>"><?php echo $textoBoton; ?></a>
                  </button> 
                <?php } ?> 
              </center>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


<!--
<div class="container">
  <div class="row">
    <div class="text-center velocimetro col-md-12 col-sm-12">
      <h2 class="vel-titulo col-md-12 col-sm-12">posibilidades:</h2>
      <h2 class="vel-titulo-din"><?php #echo $posibilidades; ?></h2>
     
      <img src="<?php #echo PUERTO.'://'.HOST.'/imagenes/'.$img; ?>" class="img-responsive" width="40%" style="text-align:center;display: inline;">
      <h3 class="vel-subt">¡Lo deseo! ¡Lo necesito! ¡LO QUIERO!</h3>
      <center> 
        <div class="vel-caja col-md-12 col-sm-12 text-center">
          <div class="col-md-12">
            <div class="col-md-8 col-sm-12">
             <h3 class="vel-titulo-1"><?php #echo $msj1; ?></h3>
             <h4 class="vel-subt-1"><?php #echo $msj2; ?></h4>
            </div>
            <div class="col-md-4 col-sm-12">
              <button style="margin-top:25px;" class="btn-minimalista">
                <a href="<?php #echo PUERTO.'://'.HOST.'/'.$enlaceboton.'/'; ?>"><?php #echo $textoBoton; ?></a> 
              </button>   
            </div>  
          </div>
        </div>
      </center>
    </div>
  </div>
</div>-->
<!--grafico para informe-->
<input style="display:none" type="text" id="datosGrafico" value="<?php echo (!empty($val_grafico)) ? $val_grafico : ""; ?>" />
<div class="container" id="Chart_details">
    <div id='chart_div'></div><div id='g_chart_1' style="width: auto; height: auto;"></div>
</div>
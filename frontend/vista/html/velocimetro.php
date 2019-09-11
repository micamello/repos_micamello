  <div class="container">
  
  <div class="row">

    <div class="col-lg-12 col-md-12 text-center">
      <br>
      <h2 class="titulo"><?php echo $titulo; ?></h2>
      
    </div>
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
              <!-- <button id="btn-verde" class="btn-medio bounceCss">
                <a href="<?php echo PUERTO.'://'.HOST.'/fileGEN/informeusuario/'.$_SESSION['mfo_datos']['usuario']['username'].'/'; ?>">REVISE SU INFORME PARCIAL</a>
              </button>  -->

              <button id="btn-enlace" class="btn-medio bounceCss">
                <a href="<?php echo PUERTO.'://'.HOST.'/'.$enlaceboton.'/'; ?>"><?php echo $textoBoton; ?></a>
              </button> 
            <?php } ?>

            <?php if($valorporc == 100){ ?>
              <!--Aqui debe llevar al perfil para que descargue el test o llevar a ofertas, siempre que no sea por acceso-->
              <button id="btn-verde" class="btn-medio bounceCss">
                <a href="<?php echo PUERTO.'://'.HOST.'/'.$enlaceboton.'/'; ?>"><?php echo $textoBoton; ?></a>
              </button> 
              <button id="btn-enlace" class="btn-medio bounceCss">
                <a href="<?php echo PUERTO.'://'.HOST.'/oferta/'; ?>">POSTULAR A OFERTAS LABORALES</a>
              </button> 
            <?php } ?> 
          </center>
        </div>
      </div>
    </div>
  </div>
</div>

<!--grafico para informe-->
<input style="display:none" type="text" id="datosGrafico" value="<?php echo (!empty($val_grafico)) ? $val_grafico : ""; ?>" />
<div class="container" id="Chart_details">
  <!--<div id='chart_div'></div>--><div id='g_chart_1' style="width: auto; height: auto;"></div>
</div>
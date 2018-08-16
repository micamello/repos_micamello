<section id="product" class="product">
  <div class="container"><br><br>
    <div class="row">
      <div class="main_business">                                                    
        <div class="container"><br><br><br>
          <div class="checkout-wrap">
            <ul class="checkout-bar">
              <li class="visited">Registro</li>
              <li class="visited">Completar Perfil</li>
              <?php for($i=1;$i<=$nrototaltest;$i++){ ?>
                <?php 
                 if ($i < $nrotestusuario){
                   $clase = "visited";
                 }
                 elseif($i == $nrotestusuario){
                   $clase = "active";
                 }
                 else{
                   $clase = "";
                 }
                ?>
                <li class="<?php echo $clase;?>">Formulario <?php echo $i;?></li>                
              <?php } ?>
            </ul>
          </div>
          <br><br><br>
          <div class="row">
            <div class="main_business">
              <div class="col-md-4" align="center">                                
                <img src="<?php echo Modelo_Usuario::obtieneFoto(); ?>" style="border-radius: 5%;">                                
                <br><h3><?php echo $_SESSION['mfo_datos']['usuario']['nombres'].' '.$_SESSION['mfo_datos']['usuario']['apellidos']; ?></h3>
              </div>              
              <div class="col-md-3" align="center">
                <img src="<?php echo PUERTO;?>://<?php echo HOST;?>/imagenes/<?php echo $imagengif;?>">
                <input type="hidden" id="valorporc" name="valorporc" value="<?php echo $valorporc;?>">                                
              </div>
              <div class="col-md-5" align="center">    
                <div class="chart-gauge"></div>
                <div class="progress ">
                  <div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $valorporc;?>%"><?php echo $descrporc;?>
                  </div>
                </div>
              </div>          
            </div>
          </div>
          <div class="col-md-12" align="right" style="margin-top: -44px;">
            <br>
            <h2>
              <div class="row">
                <div class="col-md-10" style="margin-left: 69px;">Posibilidades: 
                  <span style="color:#8C9091;"><?php echo $descrporc;?> </span>
                </div>
                <div class="col-md-1" align="right" style="padding-left:0px;">
                  <?php echo "<span class='count'>".$valorporc."</span>"; ?>
                </div>
                <div class="col-md-1" align="right" style="margin-left: -70px;color: #8c9091;">%</div>
              </div>
            </h2>
          </div>    
          <div class="col-md-12" align="center">
            <img src="<?php echo PUERTO;?>://<?php echo HOST;?>/imagenes/cuestionarios/<?php echo $testactual["imagen"];?>" style="width: 100%">
          </div>            
          <div class="row"> 
            <div class="col-md-4 col-xs-12 pull-right">
              <a href="<?php echo PUERTO;?>://<?php echo HOST;?>/<?php echo $enlaceboton;?>/" class="btn btn-success btn-block">SIGUIENTE CUESTIONARIO<br>SUBIR CV</a>
            </div>
          </div>
        </div>                      
      </div>
    </div>              
  </div>
</section>
<br><br>
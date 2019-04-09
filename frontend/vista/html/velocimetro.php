<div class="container">
  <div class="row">
    <div class="main_business">                                                    
      <div class="container"><br>

        <div class="checkout-wrap">
          <ul class="checkout-bar">
              <li class="visited">Registro</li>
              <li class="active">Completar Perfil</li>
              <?php 
              for($i=1;$i<=($nrototaltest-2);$i++){ ?>
                <?php 
                 if ($i <= $nrotestusuario){
                   $clase = "visited";
                 }
                 else{
                   $clase = "";
                 }
                ?>
                <li class="<?php echo $clase;?>">Cuestionario <?php echo $i;?></li>                
              <?php } ?>
            </ul>
        </div><br><br>
        <div class="row">
          <!--<div class="main_business">-->
            <div class="col-md-3" align="center">                                
              <img src="<?php echo Modelo_Usuario::obtieneFoto($_SESSION['mfo_datos']['usuario']['username']); ?>" style="border-radius: 5%;max-width:100%;max-height: 300px;margin-top: 40px;">
            </div>              
            <div class="col-md-3" align="center">
              <img src="<?php echo PUERTO;?>://<?php echo HOST;?>/imagenes/<?php echo $imagengif;?>">
              <input type="hidden" id="valorporc" name="valorporc" value="<?php echo $valorporc;?>">              
            </div>            
            <div class="col-md-6" align="center">    

              <div class="chart-gauge"></div><br><br>

              <div class="progress ">
                <div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $valorporc;?>%"><?php echo $descrporc;?>
                </div>
              </div>          
            </div>          
          <!--</div>-->
        </div>
        <div class="col-md-12" align="right" style="margin-top:-44px;">
          <br>
          <h2>
            <div class="row">
              <div class="col-md-12">Posibilidades: 
                <?php $fontcolor = ($nrotestusuario == $nrototaltest) ? "CE9F59" : "e63d56";?>
                <span style="color:#<?php echo $fontcolor;?>" class="parpadea"><?php echo $descrporc."&nbsp;".$valorporc;?>%</span>
              </div>              
            </div>
          </h2>
        </div> 
        <div class="col-md-12" align="center">
          <img src="<?php echo PUERTO;?>://<?php echo HOST;?>/imagenes/cuestionarios/<?php echo $imagen;?>" style="width: 100%">
        </div>    
        <div class="row">                    
          <div class="col-md-4 col-xs-12 pull-right">
            <?php 
              echo "<a href='".PUERTO.'://'.HOST.'/'.$enlaceboton."/' class='btn btn-success btn-block'>".$textoBoton."</a>";
             ?>
          </div>        
        </div>
      </div>                      
    </div>
  </div>              
</div>
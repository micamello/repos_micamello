<div class="container">
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
              <img src="<?php echo Modelo_Usuario::obtieneFoto($_SESSION['mfo_datos']['usuario']['id_usuario']); ?>" style="border-radius: 5%;">
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
          <br><br>
          <h2>
            <div class="row">
              <div class="col-md-12">Posibilidades: 
                <span style="color:#8C9091;"><?php echo $descrporc;?> </span>
              </div>
              <div class="col-md-12" align="right">
                <?php echo "<span class='count'>".$valorporc."</span>"; ?>%
              </div>              
            </div>
          </h2>
        </div>    
        <div class="row">                    
          <div class="col-md-4 col-xs-12 pull-right">
            <?php if ($enlaceboton == "cargarHv"){?>
              <?php $desc_enlace = (isset($_SESSION['mfo_datos']['infohv'])) ? "ACTUALIZAR CV" : "SUBIR CV";?>
              <a href="javascript:void(0);" id="btn_subirhv" class="btn btn-success btn-block"><?php echo $desc_enlace;?></a>               
            <?php } else {?>  
              <a href="<?php echo PUERTO;?>://<?php echo HOST;?>/<?php echo $enlaceboton;?>/" class="btn btn-success btn-block">SIGUIENTE CUESTIONARIO</a>
            <?php }?>
          </div>        
        </div>
      </div>                      
    </div>
  </div>              
</div>

<br><br><br>

<!-- Modal -->
<div class="modal fade" id="msg_subirhv" tabindex="-1" role="dialog" aria-labelledby="msg_subirhv" aria-hidden="true">
  <div class="modal-dialog " role="document">
    <form role="form" name="frm_velocimetro" id="frm_velocimetro" method="post" action="<?php echo PUERTO."://".HOST;?>/cargarcv/" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Cargar Hoja de Vida</h5>                  
        </div>
        <div class="modal-body">          
          <div class="panel panel-default shadow" style="border-radius: 20px;">                        
            <img id="archivo" alt="hoja_de_vida" src="<?php echo PUERTO;?>://<?php echo HOST;?>/imagenes/Hv.jpg" style="border-radius: 20px 20px 0px 0px;" width="100%">     
            <br>
            <div class="pull-right" style="position: relative; margin-right: 38%;">
              <label for="subirCV" class="custom_file">
                <img id="imagenBtn" class="button-center" src="<?php echo PUERTO;?>://<?php echo HOST;?>/imagenes/upload-icon.png" width="50px">
              </label>
              <input id="subirCV" name="subirCV" class="upload-photo" type="file" accept="application/pdf,application/msword,.doc, .docx">
              <div align="center">
                <p class="text-center arch_cargado" id="texto_status">Subir CV</p>
              </div>
            </div>                
          </div>          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Subir</button>
        </div>
      </div>
    </form>
  </div>
</div>
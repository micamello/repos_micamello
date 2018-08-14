<section id="product" class="product">
                <div class="container"><br><br>

                    <div class="row">
                        <div class="main_business">
                         
                            <!-- candidato -->
<div class="container"><br><br>
<br>
<div class="checkout-wrap">
  <ul class="checkout-bar">

    <li class="visited">
      <a href="#">Registro</a>
    </li>
    
    <li class="active">Completar Perfil</li>
    
    <li class="">Formulario 1</li>
    
    <li class="">Formulario 2</li>
    
    <li class="">Formulario 3</li>
       
  </ul>
</div><br><br><br>
                    <div class="row">
                        <div class="main_business">
                            <div class="col-md-4" align="center">
                                <?php 
                                //echo $t2;
                                if ($foto=='') {
                                    ?>
                                <img src="assets/images/profile/user.png" style="width: 100%;border-radius: 5%;">
                                    <?php
                                }else{
   
                                ?>
                                <img src="assets/images/profile/<?php echo $foto; ?>" style="border-radius: 5%;">
                                <?php 
                                }
                                ?>
                                <br>
                                <h3><?php echo $nombres.' '.$apellidos; ?></h3>
                            </div>
                            <!-- candidato -->
<div class="col-md-3" align="center">
<img src="img/gif-lo-quiero.gif">                                
</div>


<?php if ($rol==1) { ?>
 <div class="col-md-5" align="center">
    
        <div class="chart-gauge"></div>

<div class="progress ">
  <div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar"
  aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $posi1; ?>%">
  BAJO
  </div>
</div>

</div>          
                            </div>
                        </div>
<div class="col-md-12" align="right" style="margin-top: -44px;">
  <br>

  <h2>
    <div class="row">
    <div class="col-md-10" style="    margin-left: 69px;">
    Posibilidades: 
      <span style="color: #8C9091; " >Bajas </span>
    </div>
    <div class="col-md-1" align="right" style="    padding-left: 0px;">
    <?php echo "<span class='count'>".$posi1.'</span>'; ?>
    </div>
    <div class="col-md-1" align="right" style="margin-left: -70px;color: #8c9091;">
    %
    </div>
    </div>
  </h2>

</div>    

<div class="col-md-12" align="center">
  <img src="img/caracol.gif" style="width: 100%">
</div>  
<div class="col-md-12" align="right">
  <!--
  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
 SUBIR CV-->
</button>
<a href="stest.php" class="btn btn-success">SIGUIENTE CUESTIONARIO / SUBIR CV</a>
</div>                        
                    </div>




      
                            <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
        
                
    </div>
</section>

<!-- Modal de CV -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Seleccione su hoja de vida</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding-bottom: 42px;">
            <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="img-zone text-center" id="img-zone">
                    <div class="img-drop">
                        <h2><small>Arrastra y suelta tu CV aquí</small></h2>
                        <p><em>- o -</em></p>
                        <h2><i class="fas fa-cloud-upload-alt"></i>

</h2>
                        <span class="btn btn-success btn-file">
                        Haga clic para subir archivos<input type="file" multiple="" accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
                    </div>
                </div>
                <div class="progress hidden">
                    <div style="width: 0%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="0" role="progressbar" class="progress-bar progress-bar-success progress-bar-striped active">
                        <span class="sr-only">0% Completo</span>
                    </div>
                </div>
            </div>
        </div>
        <div id="img-preview" class="row">

        </div>
    </div>      </div>
     
    </div>
  </div>
</div>
<!-- fin subir cv -->
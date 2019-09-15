<?php require_once ('includes/Mobile-Detect/Mobile_Detect.php'); 
      $detect = new Mobile_Detect(); ?>

<form action="<?php echo PUERTO."://".HOST."/subirHv/"; ?>" method='POST' id='cargarHVForm' enctype="multipart/form-data">
  <div class="text-center">
  <h2 class="titulo">Cargar Hoja de Vida</h2>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6 col-sm-12 col-md-offset-3">
        
        <?php if ($detect->isMobile()==false) { ?>
        <!--Si es web-->
        <div id="carga" style="margin: 50px 0px;" class="recuadro-perfil panel panel-default"><br>
          <img width="100%" alt="fotoPerfil" src="<?php echo PUERTO.'://'.HOST.'/imagenes/cv.png' ?>" style="border-radius: 20px 20px 0px 0px;">
          <div class="perfil-cuadro" id="err_img" align="center">
            <label style="font-size: 16pt;" class="text-center" id="cargarHV">Seleccione archivo<br></label>
            <br>
            <small style="font-size: 100%">(.PDF, .doc, .docx/máx: 5mb)</small>
          </div>
        </div>
         <input type="file" name="userHV" id="userHV" style="display: none;" class="cargahv" accept=".pdf,.docx,.doc">
         <!-- <a href="#" style="font-size: 20pt;" class="btn-light-blue" disabled="">GUARDAR</a> -->
        <?php }?>

        
        <?php if ($detect->isMobile()==true) { ?>
        <!--Si es movil-->
            <input type="file" name="userHV" id="userHV" class="in-btn" accept=".pdf,.docx,.doc">
            <span class="new">SELECCIONE ARCHIVO</span>
            <br><br><br><br>
        <?php }?>


        <input type="submit" name="hvButton" id="hvButton" value="Guardar" class="btn-light-blue" style="font-size: 20pt;">


      </div>
    </div>
  </div>
</form>

<!DOCTYPE html>
<html>
<head>
  <!-- <title>Procesando</title> -->
  <meta charset="utf-8">
  <meta name="google-site-verification" content="Hy5ewWRp0yOqH1Z_3Q59zSVffxTZDLa_T50VEoGBIBw" />
  <!-- <title>MiCamello - Portal de Empleos en Ecuador</title> -->
  <meta name="keywords" content="ofertas de trabajo, trabajos, empleos, bolsa de empleos, buscar trabajo, busco empleo, portal de empleo, ofertas de empleo, bolsa de empleo, trabajos en ecuador, paginas de empleo, empleos ecuador, camello">
  <title>MiCamello - Portal de Empleos en Ecuador</title>
  <meta name="description" content="Cientos de empresas publican las mejores ofertas en la bolsa de trabajo Mi Camello Ecuador. Busca empleo y apúntate y sé el primero en postular">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta property="og:image" content="https://www.micamello.com.ec/" />
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/bootstrap.css">
  <style type="text/css">
    .externDivLoader{
      position: fixed;
      top: 0px;
      left: 0px;
      width: 100%;
      height: 100%;
      z-index: 10000;
      opacity: 0.8;
    }

    .centrarLoader{
      position: absolute;
      left: 50%;
      top: 50%;
      -webkit-transform: translate(-50%, -50%);
      transform: translate(-50%, -50%);
      background-color: #FFFFFF;
      padding: 20px 50px 20px 50px;
      border-radius: 17px;
    }

  </style>
</head>

<body style="background-color:#204478;">
  <div class="container">
    <div align="center">
      <img src="<?php echo PUERTO."://".HOST; ?>/imagenes/logo.png" class="img-responsive center" width="30%">
    </div>
  </div>
  <!-- <div class="spin"/></div> -->
  <div class="spin">
    <div class="externDivLoader">
      <div class="centrarLoader">
        <div align="center">
          <img src="<?php echo PUERTO."://".HOST;?>/imagenes/loader.gif" class="img-responsive center" style="min-height: 100px; max-height: 100px;">
        </div>
        <h4 style="text-align: justify;">Estamos procesando su compra...</h4>

          <div id="contenido" style="display: none;">
              <div class="row" id="registro-algo-centro">  
                <div class="col-md-6 col-md-offset-3">
                  <div class="" id="inicio-cuadro"> 
                    <div align="center" class="col-md-12">
                  <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO && isset($msg_cuestionario) && $msg_cuestionario == 1) { ?>
                    <input type="hidden" value="preguntas" id="redireccionar" name="redireccionar">

                  <?php }else{
                    echo '<input type="hidden" value="oferta" id="redireccionar" name="redireccionar">';
                  } ?>
                    </div>
                    <div class="col-md-12">
                  <?php if(isset($ofertaConvertir)){ ?>
                    <input type="hidden" value="verAspirantes" id="redireccionar" name="redireccionar">
                  <?php } else{
                    echo "<input type='hidden' value='publicar' id='redireccionar' name='redireccionar'>";
                  }?>
                </div>
                    <div class="row">          
                    </div>
                  </div>
                </div>
              </div>
          </div>



      </div>
    </div>
  </div>




<input type="text" hidden id="puerto_host" value="<?php echo PUERTO."://".HOST ;?>">
<input type="hidden" id="iso" value="<?php echo SUCURSAL_ISO; ?>">

<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/jquery-3.0.0.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/planValidarActivacion.js"></script>




<script type="text/javascript">
  // console.log("eder");
</script>
</body>
</html>
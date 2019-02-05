<?php 

require_once '../constantes.php';
require_once '../init.php';
include '../multisitios.php';

?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/minisitio.css">
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/assets/css/bootstrap.css">
</head>
<body class="window_class">
  <?php if(!isset($show_banner) && !isset($breadcrumbs)){ ?>
  <?php } ?>
    <!--mensajes de error y exito-->
    <?php if (isset($sess_err_msg) && !empty($sess_err_msg)){?>
      <div align="center" id="alerta" style="display:" class="alert alert-danger" role="alert">
        <strong><?php echo $sess_err_msg;?></strong>
      </div>  
    <?php }?>

    <?php if (isset($sess_suc_msg) && !empty($sess_suc_msg)){?>
      <div align="center" id="alerta" style="display:" class="alert alert-success" role="alert">
        <strong><?php echo $sess_suc_msg;?></strong>
      </div>  
    <?php } ?>
  <br>
  <div class="container">
      <div class="col-md-4">
        <div class="card shadow-lg rounded text-center">
          <div class="card-header bg-info text-white">
            Filtros
          </div>
          <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
          <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        </div>
      </div>
      <div class="col-md-8">
        <div id="filtros"><br><br><br><br></div>
        <div class="card shadow-lg rounded text-center">
          <form action="<?php echo PUERTO."://".HOST;?>/registrodatostest/" method="POST" id="form_registrotest">
            <div class="card-header bg-info text-white">
              Encuestas realizadas
            </div>
            <div class="card-body">
            </div>
            <div class="card-footer bg-transparent text-muted">
              <table></table>
            </div>
          </form>
        </div>
      </div>
</div>

<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/jquery-3.0.0.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/minisitio.js"></script>
</body>
</html>
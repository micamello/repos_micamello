<!DOCTYPE html>
<html>
<head>
  <title></title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link href="<?php echo PUERTO."://".HOST;?>/css/assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">

  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/minisitio.css">
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/assets/css/bootstrap.css">
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/mic.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">


</head>
<body class="window_class" style="padding-top:10px;">
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
  
  <div class="col-md-3">
    <div class="card shadow-lg rounded text-center">
      <div class="card-header bg-info text-white">
        Filtros
      </div>
      <br/>
      <div class="panel panel-default shadow-panel1">
        <div class="panel-heading">
          <span><i class="fa fa-map-marker"></i> Residencia Actual</span>
        </div>
        <div class="panel-body">
          <div class="filtros">
            <?php

              if (!empty($residenciaActual)) {
                echo '<input class="form-control" id="residencia" type="text" placeholder="Buscar..">';
                echo '<ul id="menu2">';
                foreach ($residenciaActual as $key => $v) {
                  $ruta = PUERTO.'://'.HOST.'/filtrarEntrevistados/R'.$key.'/';
                  echo '<li><input type="checkbox" name="list" id="prov_'.$key.'">
                        <a href="'.$ruta.'1/">'. utf8_encode(ucfirst(strtolower($v['nombre']))).'</a>';                  
                  echo '</li>';  
                }
                echo '</ul>';
              }else{
                echo 'No hay resultados';
              }
            ?>
          </div>
        </div>
      </div>
      <div class="panel panel-default shadow-panel1">
        <div class="panel-heading">
          <span><i class="fa fa-industry"></i> Empresas</span>
        </div>
        <div class="panel-body">
          <div class="filtros">
            <?php       
              Utils::log(print_r($empresas,true));        
              if (!empty($empresas)) {
                echo '<ul style="padding-left: 0px;">';                
                foreach ($empresas as $key => $v) {
                  $ruta = PUERTO.'://'.HOST.'/filtrarEntrevistados/I'.$key.'/';
                  echo '<li class="list-group-item"><a href="'.$ruta.'1/" class="empresas" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
                }
                echo '</ul>';
              }
            ?>
          </div>
        </div>
      </div>
      <div class="panel panel-default shadow-panel1">
        <div class="panel-heading">
          <span><i class="fa fa-bar-chart"></i> Nivel de estudio</span>
        </div>
        <div class="panel-body">
          <div class="filtros">
        <?php
          if (!empty($escolaridad)) {
            echo '<ul style="padding-left: 0px;">';
            foreach ($escolaridad as $key => $v) {
              $ruta = PUERTO.'://'.HOST.'/filtrarEntrevistados/E'.$key.'/';
              echo '<li class="list-group-item"><a href="'.$ruta.'1/" class="escolaridad" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
            }
            echo '</ul>';
          }
        ?></div>
        </div>
      </div>
      <div class="panel panel-default shadow-panel1">
        <div class="panel-heading">
          <span><i class="fa fa-tasks"></i> Competencias</span>
        </div>
        <div class="panel-body">
          <div class="filtros">
            <?php
             if (!empty($competencias)) {
                echo '<input class="form-control" id="competencias" type="text" placeholder="Buscar..">';
                echo '<ul id="menu3">';
                foreach ($competencias as $key => $v) {
                  echo '<li><input type="checkbox" name="list" id="comp_'.$key.'">
                      <label style="content:none; cursor:pointer; color: #337ab7" for="comp_'.$key.'">'. utf8_encode(ucfirst(strtolower($v['nombre']))).'</label>
                      <ul id="menu31" class="interior">';
                  foreach ($v['grados'] as $p => $val) {

                    $ruta2 = PUERTO.'://'.HOST.'/filtrarEntrevistados/H'.$key.'_'.$p.'/';
                    echo '<li><a href="'.$ruta2.'1/">'.utf8_encode(ucfirst(strtolower($val))).'</a></li>';
                  }
                  echo '</ul></li>';
                }
                echo '</ul>';
            }else{
              echo 'No hay resultados';
            }
          ?>
          </div>
        </div>
      </div>
      <div class="panel panel-default shadow-panel1">
        <div class="panel-heading">
          <span><i class="fa fa-heart"></i> Edad</span>
        </div>
        <div class="panel-body">
          <div class="filtros">
            <?php
              echo '<ul style="padding-left: 0px;">';
              foreach (EDAD as $key => $v) {
                $ruta = PUERTO.'://'.HOST.'/filtrarEntrevistados/F'.$key.'/';
                echo '<li class="list-group-item"><a href="'.$ruta.'1/" class="edad" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
              }
              echo '</ul>';
            ?>
          </div>
        </div>
      </div>
      <div class="panel panel-default shadow-panel1">
        <div class="panel-heading">
          <span><i class="fa fa-map"></i> Nacionalidad</span>
        </div>
        <div class="panel-body">
          <div class="filtros">
        <?php
           if (!empty($nacionalidad)) {
              echo '<input class="form-control" id="nacionalidades" type="text" placeholder="Buscar..">';
            echo '<ul id="menu1">';
           foreach ($nacionalidad as $key => $v) {
                $ruta = PUERTO.'://'.HOST.'/filtrarEntrevistados/N'.$key.'/';
                if($key == SUCURSAL_PAISID){

                  echo '<li><input type="checkbox" name="list" id="pais_'.$key.'">
                      <label style="content:none; cursor:pointer" for="pais_'.$key.'"><a href="'.$ruta.'1/">'. utf8_encode(ucfirst(strtolower($v['nombre']))).'</a></label>
                      <ul id="menu11" class="interior">';
                  foreach ($v['provincias'] as $p => $val) {

                    $ruta2 = PUERTO.'://'.HOST.'/filtrarEntrevistados/N'.$key.'_'.$p.'/';
                    echo '<li><a href="'.$ruta2.'1/">'.utf8_encode(ucfirst(strtolower($val))).'</a></li>';
                  }
                  echo '</ul></li>';
                }else{
                  echo '<li><a class="etiqueta" href="'.$ruta.'1/" class="nacionalidad" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
                }
            }
            echo '</ul>';
          }else{
            echo 'No hay resultados';
          }
        ?></div>
        </div>
      </div>
      <div class="panel panel-default shadow-panel1">
        <div class="panel-heading">
          <span><i class="fa fa-transgender"></i> G&eacute;nero</span>
        </div>
        <div class="panel-body">
          <div class="filtros">
          <?php
            echo '<ul style="padding-left: 0px;">';
            foreach (GENERO as $key => $v) {
              $ruta = PUERTO.'://'.HOST.'/filtrarEntrevistados/G'.VALOR_GENERO[$key].'/';
              echo '<li class="list-group-item"><a href="'.$ruta.'1/" class="genero" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
            }
            echo '</ul>';
          ?>
          </div>
        </div>
      </div>
      <div class="panel panel-default shadow-panel1">
        <div class="panel-heading">
          <span><i class="fa fa-female"></i><i class="fa fa-male"></i> Estado civil</span>
        </div>
        <div class="panel-body">
          <div class="filtros">
            <?php
              echo '<ul style="padding-left: 0px;">';
              foreach (ESTADO_CIVIL as $key => $v) {
                $ruta = PUERTO.'://'.HOST.'/filtrarEntrevistados/C'.$key.'/';
                echo '<li class="list-group-item"><a href="'.$ruta.'1/" class="estado_civil" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
              }
              echo '</ul>';
            ?>
          </div>
        </div>
      </div>      
      <div class="panel panel-default shadow-panel1">
        <div class="panel-heading">
          <span><i class="fa fa-briefcase"></i> Profesi&oacute;n</span>
        </div>
        <div class="panel-body">
          <div class="filtros">
            <input class="form-control" id="profesiones" type="text" placeholder="Buscar..">
            <?php
              if (!empty($profesion)) {
                echo '<ul class="list-group" id="listaProfesiones">';
                foreach ($profesion as $key => $v) {
                  $ruta = PUERTO.'://'.HOST.'/filtrarEntrevistados/P'.$key.'/';
                  echo '<li class="list-group-item"><a href="'.$ruta.'1/" class="profesion" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
                }
                echo '</ul>';
              } ?>
          </div>
        </div>
      </div>
      <div class="panel panel-default shadow-panel1">
        <div class="panel-heading">
          <span><i class="fa fa-address-card-o"></i> Ocupaci&oacute;n</span>
        </div>
        <div class="panel-body">
          <div class="filtros">
            <input class="form-control" id="ocupaciones" type="text" placeholder="Buscar..">
            <?php
              if (!empty($ocupacion)) {
                echo '<ul class="list-group" id="listaOcupaciones">';
                foreach ($ocupacion as $key => $v) {
                  $ruta = PUERTO.'://'.HOST.'/filtrarEntrevistados/O'.$key.'/';
                  echo '<li class="list-group-item"><a href="'.$ruta.'1/" class="ocupacion" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
                }
                echo '</ul>';
            } ?>
          </div>
        </div>
      </div>
      </div>
    </div>
  <div class="col-md-9">
    <div id="links"><?php echo $link; ?></div>
  </div>
  <div class="col-md-9">    
    <a href="<?php echo PUERTO."://".HOST;?>/admin/generarExcel/" class="col-md-1 offset-md-11 btn btn-success"><i class="fa fa-download"></i> Excel</a>
    <br><br>
    <div class="card shadow-lg rounded text-center">
      <div class="card-header bg-info text-white">
        Encuestas realizadas
      </div>
      <div class="card-footer bg-transparent text-muted">
        <?php echo $table;?>
        
      </div>
    </div>
  </div>
  
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/jquery-3.0.0.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/loader.js"></script> 
<script src="<?php echo PUERTO."://".HOST;?>/js/minisitio.js"></script>


</body>
</html>
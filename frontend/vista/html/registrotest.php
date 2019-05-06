<!DOCTYPE html>
<html>
<head>
  <title></title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/minisitio.css">
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
  <div class="col-md-8 offset-md-2">
    <div class="card shadow-lg rounded text-center">
      <form action="<?php echo PUERTO."://".HOST;?>/registrodatostest/" method="POST" id="form_registrotest">
        <div class="card-header bg-info text-white">
          Registro de datos
        </div>
        <div class="card-body">
          <input type="hidden" name="form_register" id="form_register" value="1">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
               <label for="nombres">Nombres</label><i class="asterisk_red">*</i>
               <input type="text" id="nombres" class="form-control" id="nombres" name="nombres">
               <div class="" id="nombre_error"></div>
             </div>
            </div>
            <input type="hidden" name="registro_datos" id="registro_datos" value="1">
            <div class="col-md-6">
             <div class="form-group">
              <label for="apellidos">Apellidos</label><i class="asterisk_red">*</i>
              <input type="text" class="form-control" id="apellidos" name="apellidos">
              <div class="" id="apellido_error"></div>
             </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="fecha">Fecha de nacimiento</label><i class="asterisk_red">*</i>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control">
                <div class="" id="fecha_nacimiento_error"></div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="genero">Género</label><i class="asterisk_red">*</i>
                <select name="genero" class="form-control" id="genero">
                  <option value="1" selected="selected" disabled="disabled">Seleccione una opción</option>
                  <?php 
                    foreach (GENERO as $key => $value) {
                      echo "<option value='".$key."'>".$value."</option>";
                    }
                  ?>
                </select>
                <div class="" id="genero_error"></div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="estado_civil">Estado civil</label><i class="asterisk_red">*</i>
                <select class="form-control" name="estado_civil" id="estado_civil"><i class="asterisk_red">*</i>
                  <option value="" selected="" disabled="">Seleccione una opción</option>
                  <?php 
                    foreach (ESTADO_CIVIL as $key => $value) {
                    echo "<option value='".$key."'>".$value."</option>";
                    }
                   ?>
                </select>
                <div></div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="nivel_instruccion">Nivel de instrucción</label><i class="asterisk_red">*</i>
                  <select class="form-control" name="nivel_instruccion" id="nivel_instruccion">
                    <option value="" selected="" disabled="">Seleccione una opción</option>
                    <?php 
                      foreach ($escolaridad as $esc) {
                        echo "<option value='".$esc['id_escolaridad']."'>".utf8_encode($esc['descripcion'])."</option>";
                      }
                     ?>
                  </select>
                  <div></div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="profesion">Profesión</label><i class="asterisk_red">*</i>
                  <select class="form-control" name="profesion" id="profesion">
                    <option value="" selected="" disabled="">Seleccione una opción</option>
                    <?php 
                    foreach ($profesion as $pro) {
                      echo "<option value='".$pro['id_profesion']."'>".utf8_encode($pro['descripcion'])."</option>";
                    }
                     ?>
                  </select>
                  <div></div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="ocupacion">Ocupación</label><i class="asterisk_red">*</i>
                <select class="form-control" name="ocupacion" id="ocupacion">
                  <option value="" selected="" disabled="">Seleccione una opción</option>
                  <?php 
                    foreach ($ocupacion as $ocu) {
                      echo "<option value='".$ocu['id_ocupacion']."'>".utf8_encode($ocu['descripcion'])."</option>";
                    }
                   ?>
                </select>
                <div></div>
              </div>
            </div>

            <div class="col-md-12">
              <hr>
              <label class="center">Lugar de nacimiento</label>
            </div> 
            <div class="col-md-12" id="pais_content">
              <div class="form-group">
                <label>Nacionalidad</label><i class="asterisk_red">*</i>
                <select class="form-control" name="pais" id="pais">
                  <option value="" selected="" disabled="">Seleccione una opción</option>
                    <?php 
                      foreach ($pais as $pais_listado) {
                        echo "<option value='".$pais_listado['id_pais']."'>".utf8_encode($pais_listado['nombre_abr'])."</option>";
                      }
                     ?>
                </select>
                <div></div>
              </div>
            </div>

            <div class="col-md-6" style="display: none;" id="provincia_content">
              <div class="form-group">
                <label>Provincia</label><i class="asterisk_red">*</i>
                <select class="form-control" name="provincia" id="provincia">
                  <option value="" selected="" disabled="">Seleccione una opción</option>
                </select>
                <div></div>
              </div>
            </div>

            <div class="col-md-6" style="display: none;" id="cantonnac_content">
              <div class="form-group">
                <label>Cantón</label><i class="asterisk_red">*</i>
                <select class="form-control" name="cantonnac" id="cantonnac">
                  <option value="" selected="" disabled="">Seleccione una opción</option>
                </select>
                <div></div>
              </div>
            </div>            

            <div class="col-md-12">
              <hr>
              <label class="center">Lugar de residencia</label>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label>Provincia</label><i class="asterisk_red">*</i>
                <select class="form-control" name="provincia_res" id="provincia_res">
                  <option value="" selected="" disabled="">Seleccione una opción</option>
                  <?php 
                    foreach ($provincia as $provincia_listado) {
                      echo "<option value='".$provincia_listado['id_provincia']."'>".utf8_encode($provincia_listado['nombre'])."</option>";
                    }
                   ?>
                </select>
                <div></div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Cantón</label><i class="asterisk_red">*</i>
                <select class="form-control" name="canton_res" id="canton_res" disabled="disabled">
                  <option value="" selected="" disabled="">Seleccione una opción</option>
                </select>
                <div></div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Parroquia</label><i class="asterisk_red">*</i>
                <select class="form-control" name="parroquia_res" id="parroquia_res" disabled="disabled">
                  <option value="" selected="" disabled="">Seleccione una opción</option>
                </select>
                <div></div>
              </div>
            </div>

            <div class="col-md-12">
              <hr>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="correo">Correo</label><i class="asterisk_red">*</i>
                <input type="text" class="form-control" name="correo" id="correo">
                <div></div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="aspiracion_salarial">Aspiración salarial (2 decimales)</label><i class="asterisk_red">*</i>
                <input type="text" class="form-control" name="aspiracion_salarial" id="aspiracion_salarial" placeholder="0.00">
                <div></div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" name="terminos_condiciones" id="terminos_condiciones">
                <label class="form-check-label" for="terminos_condiciones">Aceptar políticas para presentar y publicar el TEST</label><i class="asterisk_red">*</i>
                <div></div>
              </div>
            </div>
          </div>
          <input type="text" hidden id="puerto_host" value="<?php echo PUERTO."://".HOST ;?>">
          <div class="alert alert-danger" style="display: none" id="errors_form" role="alert">
            
          </div>

        </div>
        <div class="card-footer bg-transparent text-muted">
          <input type="submit" name="" id="registro" class="btn btn-success" value="Guardar">
        </div>
      </form>
    </div>
  </div>
</div>

<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/jquery-3.0.0.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/minisitio.js"></script>
</body>
</html>
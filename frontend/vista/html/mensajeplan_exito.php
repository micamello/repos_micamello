<div class="text-center">
    <h2 class="qs-subt"><?php echo utf8_encode($_SESSION['mfo_datos']['usuario']['nombres'])."&nbsp;".((isset($_SESSION['mfo_datos']['usuario']['apellidos'])) ? utf8_encode($_SESSION['mfo_datos']['usuario']['apellidos']) : '');?></h2>
  </div>
<br>
<section id="product" class="inicio">
<div class="container">
    <div class="row" id="registro-algo-centro">  
      <div class="col-md-6 col-md-offset-3">
        <div class="" id="inicio-cuadro"> 
          <div align="center" class="col-md-12">
            <!-- <h3>¡El cambio de contraseña se ha realizado con éxito!</h3><br> -->
            <h4>Dentro de un momento su plan ser&aacute; activado<br>
					Por favor revise su correo para verificar su subscripci&oacute;n</h4><br>
				<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO && isset($msg_cuestionario) && $msg_cuestionario == 1) { ?>
					<h4>Cuando su plan este activo, podr&aacute; realizar el tercer <br><a href="<?php echo PUERTO."://".HOST."/preguntas/"; ?>" class="btn-blue">formulario</a></h4>
				<?php } ?>
            <!-- <button class="btn-light-blue">Finalizar</button> -->
          </div>
          <div class="col-md-12">
				<?php if(isset($ofertaConvertir)){ ?>
					<!--<a href="<?php #echo PUERTO."://".HOST."/verAspirantes/1/".$ofertaConvertir."/1/"; ?>" id="btn_convertir" class="btn-blue">CONVERTIR OFERTA AHORA</a>-->
				<?php } ?>
			</div>
          <div class="row">          
          </div>
        </div>
      </div>
    </div>
  </div>
<br>
<br>
<br>
</section>
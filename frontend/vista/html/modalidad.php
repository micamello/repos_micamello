<div class="text-center">
  <h2 class="titulo">Desarrollo de Tests</h2>
</div>
<div class="container">
  <!-- <div class="error"></div> -->
  <form id="metodoSeleccion" action="<?php echo PUERTO."://".HOST;?>/modalidad/" method="POST">
      <div class="row">
        <div class="col-md-12">
          <p class="qs-text">A continuación se le presentaran dos opciones de respuestas, escoja con la que se sienta más cómodo. Tome en cuenta que la opción 1 es aquella con la que se siente
completamente identificado y la opción 5 es la que menos se siente identificado</p>
        </div>
        <div class="col-md-12">
          <?php 
            foreach (METODO_SELECCION as $key => $value) {
          ?>
          <div class="col-md-6" align="center">
            <div class="tit-test "><p><?php echo utf8_encode($value[0]); ?></p></div>
            <img id="img-test" src="<?php echo PUERTO."://".HOST."/imagenes/metodoSel/".$key.".png";?>">
            <div class="col-md-12 text-center">
              <div class="form-group check_box">
                <label class="btn-blue margin-40">
                  <input type="radio" name="seleccion" value="<?php echo $key; ?>">&nbsp; Escoger esta opción
                </label>
              </div> 
            </div>
          </div>
        <?php
          }
        ?>
        <div class="col-md-12" align="center">
          <input type="submit" class="btn-blue"  value="Ir a los tests"/>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="modal fade" id="msg_canea" tabindex="-1" role="dialog" aria-labelledby="msg_canea" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="row">
        <div class="text-center">
          <br>
         <h2 class="titulo">¿Qué es CANEA?</h2>
        </div>
        <div class="col-md-12">
        <p class="qs-text">CANEA está basado en la teoría de los “5 GRANDES RASGOS DE PERSONALIDAD”, teoría que ha tenido validez y ha sido muy utilizada en diversas investigaciones en el área organizacional a nivel mundial. Para efectos prácticos CANEA se ha definido de la siguiente manera: </p>
      </div>

      <section>
        <div class="">
            <div class="col-md-12 col-sm-12 text-center">
              <!-- <div class="canea-text-modal col-md-1 col-sm-1 ocultar">&nbsp;</div> -->
              <div class="col-md-2 col-sm-2 col-xs-2 col-sm-offset-1 col-xs-offset-1">
                <div class="canea-text-modal visible-lg visible-md visible-xs visible-sm ">C</div>
                <div class="texto-canea "><h4 class="hidden-sm hidden-xs">Hacer</h4></div>
              </div>
              <div class="col-md-2 col-sm-2 col-xs-2  text-center">
                <div class="canea-text-modal visible-lg visible-md visible-xs visible-sm ">A</div>
                <div class="texto-canea " align="center"><h4 class="hidden-sm hidden-xs">Relaciones Interpersonales</h4></div>
              </div>
              <div class="col-md-2 col-sm-2 col-xs-2 ">
                <div class="canea-text-modal visible-lg visible-md visible-xs visible-sm">N</div>
                <div class="texto-canea "><h4 class="hidden-sm hidden-xs">Estabilidad Emocional</h4></div>
              </div>
              <div class="col-md-2 col-sm-2 col-xs-2 ">
                <div class="canea-text-modal visible-lg visible-md visible-xs visible-sm ">E</div>
                <div class="texto-canea "><h4 class="hidden-sm hidden-xs">Asertividad</h4></div>
              </div>
              <div id="prueba-e" class="col-md-2 col-sm-2 col-xs-2 ">
                <div class="canea-text-modal visible-lg visible-md visible-xs visible-sm">A</div>
                <div id="prueba-e" class="texto-canea "><h4 class="hidden-sm hidden-xs">Pensar</h4></div>
              </div>
              <div class="canea-text-modal col-md-1 ocultar">&nbsp;</div>
            </div>
          </div>
          <!-- <div class="hidden-lg hidden-md">
            <div class="" style="margin-left: 35px;">
              <div class="">
                <div class="col-md-12">
                  <div class="col-md-12 col-sm-12">
                    <label class="canea-text-modal">C</label>
                    <label class="texto-canea" style="vertical-align: middle; margin-left: 0px;">Hacer</label>
                  </div>
                  <div class="col-md-12 col-sm-12">
                    <label class="canea-text-modal">A</label>
                    <label class="texto-canea" style="vertical-align: middle; margin-left: 0px;">Relaciones interpersonales</label>
                  </div>
                  <div class="col-md-12 col-sm-12">
                    <label class="canea-text-modal">N</label>
                    <label class="texto-canea" style="vertical-align: middle; margin-left: 0px;">Estabilidad Emocional</label>
                  </div>
                  <div class="col-md-12 col-sm-12">
                    <label class="canea-text-modal">E</label>
                    <label class="texto-canea" style="vertical-align: middle; margin-left: 0px;">Asertividad</label>
                  </div>
                  <div class="col-md-12 col-sm-12">
                    <label class="canea-text-modal">A</label>
                    <label class="texto-canea" style="vertical-align: middle; margin-left: 0px;">PENSAR</label>
                  </div>
                </div>
              </div>
            </div>
          </div> -->

        <div class="text-center">
          <button type="button" class="btn-blue" data-dismiss="modal">Seleccionar método</button>
        </div>
      </section> 
      </div>     
    </div>
  </div>
</div>





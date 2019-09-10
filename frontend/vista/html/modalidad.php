<script>

  function seleccionar($dato){
    document.getElementById("seleccion"+$dato).checked = true;
}
</script>

<div class="text-center">
  <h2 class="titulo">Desarrollo de Tests</h2>
</div>
<div class="container">
  <!-- <div class="error"></div> -->
  <form id="metodoSeleccion" action="<?php echo PUERTO."://".HOST;?>/modalidad/" method="POST">
      <div class="row">
        <div class="col-md-12">
          <p class="qs-text">A continuación le presentamos dos métodos de respuesta, elija la opción con la que se sienta más cómodo.</p>
        </div>
        <div class="col-md-12">

          <?php 
            foreach (METODO_SELECCION as $key => $value) {
          ?>
          <div class="col-md-6" align="center">
            <div class="tit-test "><p><?php echo utf8_encode($value[0]); ?></p></div>
            <img id="img-test" src="<?php echo PUERTO."://".HOST."/imagenes/metodoSel/".$key.".png";?>">
            <div class="col-md-12 text-center">
              <input type="radio" style="visibility: hidden;" name="seleccion" id="seleccion<?php echo $key;?>" value="<?php echo $key; ?>">
              <input type="submit" class="btn-blue margin-40"  
                     onclick="seleccionar(<?php echo $key; ?>)" value="Escoger esta opción"/>
              
            </div>
          </div>
        <?php
          }
        ?>
        <!-- <div class="col-md-12" align="center">
          <input type="submit" class="btn-blue"  value="Ir a los tests"/>
        </div> -->
      </div>
    </div>
  </form>
</div>


<div class="modal fade" id="msg_canea" tabindex="-1" role="dialog" aria-labelledby="msg_canea" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="row">
        <div class="text-center">
          <br>
        </div>
        <div class="col-md-12">
          <img style="display:block; margin:auto;" src="../imagenes/iconOferta.png"/><br>
          <p class="qs-text" style="font-size: 22px">Antes de cargar tu hoja de vida, completa el <span class="texto-canea">TEST CANEA</span> que te ayudar&aacute; a postularte como uno de los primeros candidatos!</p>
        </div>

       <section>
        <div class="text-center">
          <button type="button" class="btn-blue" data-dismiss="modal">Continuar</button>
        </div>
      </section> 
      </div>     
    </div>
  </div>
</div>





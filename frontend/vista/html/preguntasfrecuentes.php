<section id="product">
  <div class="text-center">
    <h2 class="titulo">Preguntas y Respuestas Frecuentes</h2>
  </div>
</section>

<section id="product" class="inicio">
  <div class="container">
    <div class="row">
      <div class="col-md- 12 col-xs-12">
        <div class="tabCommon tabLeft">
          <div class="col-md-2">
            <ul style="border: none;" class="nav nav-tabs">
              <?php if(count($candidatos) > 0) { ?>
                <li class="faq-lista active"><a class="faq-tab" data-toggle="tab" href="#candidatos" aria-expanded="true">Candidatos</a></li>
              <?php } ?>

              <?php if(count($empresas) > 0) { ?>
                <li class="faq-lista"><a class="faq-tab" data-toggle="tab" href="#empresas">Empresas</a></li>
              <?php } ?>
            </ul>
          </div>
          <div class="tab-content col-md-7 post-news-body" id="square">
            <!---CANDIDATO--->
            <?php if(count($candidatos) > 0) { ?>
              <div id="candidatos" class="tab-pane fade active in">
                <div class="accordionCommon" id="accordionOne">
                  <div class="panel-group" id="accordionFirst">

                    <?php 
                      $cont = 1;
                      //echo count($candidatos); 
                      foreach ($candidatos as $key => $value) { ?>
                      <div class="faq-bloque-principal panel-default">
                        <a class="faq-bloque-titulo accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordionFirst" href="#collapse-b<?php echo $cont; ?>" aria-expanded="false">
                          <span class=""><?php echo utf8_encode($value['pregunta']); ?></span>
                          <span class="iconBlock iconTransparent"><i class="fa fa-chevron-up"></i></span>
                        </a>                    
                        <div id="collapse-b<?php echo $cont; ?>" class="faq-bloque-texto-1 collapse" aria-expanded="false" style="height: 0px;">
                          <div class="faq-bloque-texto-2">
                            <p><?php echo utf8_encode($value['respuesta']); ?></p>
                          </div>
                        </div>
                      </div>
                    <?php 
                      $cont++;
                    } ?>
                  </div>
                </div>
              </div>
            <?php } ?>

            <!---EMPRESAS--->
            <?php if(count($empresas) > 0) { ?>
              <div id="empresas" class="tab-pane fade active in">
                <div class="accordionCommon" id="accordionOne">
                  <div class="panel-group" id="accordionFirst">

                    <?php 
                      $cont = 1;
                      //echo count($candidatos); 
                      foreach ($empresas as $key => $value) { ?>
                      <div class="faq-bloque-principal panel-default">
                        <a class="faq-bloque-titulo accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordionFirst" href="#collapse-c<?php echo $cont; ?>" aria-expanded="false">
                          <span class=""><?php echo utf8_encode($value['pregunta']); ?></span>
                          <span class="iconBlock iconTransparent"><i class="fa fa-chevron-up"></i></span>
                        </a>                    
                        <div id="collapse-c<?php echo $cont; ?>" class="faq-bloque-texto-1 collapse" aria-expanded="false" style="height: 0px;">
                          <div class="faq-bloque-texto-2">
                            <p><?php echo utf8_encode($value['respuesta']); ?></p>
                          </div>
                        </div>
                      </div>
                    <?php 
                      $cont++;
                    } ?>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>

        <div class="col-md-3 col-md-12 col-xs-12">
          <aside>
            <div class="panel panel-default eventSidebar">
              <div>
                <h3 class="faq-bloque-titulo">¿Tienes alguna pregunta?</h3>
              </div>
              <div class="faq-bloque-texto-1 faq-preguntas">
                <p class="faq-formulario">Escríbenos a <a href="mailto:info@micamello.com.ec">info@micamello.com.ec</a> o envíanos tu duda dando click <a target="_blank" href="<?php echo PUERTO."://".HOST;?>/recomendacion/"">aqu&iacute;</a></p>

              </div>
            </div>
          </aside>
        </div>
      </div>
    </div>
  </div>
</section>
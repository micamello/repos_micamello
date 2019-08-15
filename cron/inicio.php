<?php  echo ( extension_loaded ( ' openssl ' )? ' SSL cargado ' : ' SSL no cargado ' ) . " \ n " ; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="cuadro-banner">
                  <div class="col-md-12">
                    <p>¡Conoce las mejores empresas, encuentra tu pr&oacute;xima oportunidad laboral y evalua tus competencias!</p>
                  </div>
                  <?php if(!Modelo_Usuario::estaLogueado()){ ?>
                    <div class="col-md-12">
                      <button class="btn-blue" id="cuadro-celeste">
                        <a href="<?php echo PUERTO."://".HOST."/registro/"?>" class="texto-white">Suscr&iacute;bete</a>
                      </button>
                    </div>
                  <?php } ?>
                </div>
            </div>

            <div class="col-md-6" id="foto-banner">
                <img style="width: 100%; background-size: cover;" src="<?php echo PUERTO.'://'.HOST;?>/imagenes/banner/principal-2.jpg">
            </div>
        </div>
    </div>

<br><br>

<div class="text-center" align="center">
    <h2 class="titulo">&Aacute;reas de Empleos</h2>
  </div><br><br>

<section id="brand" class="business bloque">
    <div class="container-fluid">
      <div class="carousel slide fade-carousel carousel-fade" data-ride="carousel" data-interval="3000" id="myCarousel1">
         
        
      <div class="texto-white carousel-inner" role="listbox">
        <?php 
            $cont = 1;
            $areas_bloque = array_chunk($arrarea, DIVISIBLE_BLOQUE);
            foreach ($areas_bloque as $key => $valores) {
                echo '<div class="item ';
                if($cont == 1){ 
                    echo 'active'; 
                }
                echo '"> ';
                $arrarea = array_chunk($valores,DIVISIBLE_FILA);
                foreach ($arrarea as $k => $a) {
                    echo '<div class="col-md-12 col-sm-12" id="bloque-car">';
                    foreach ($a as $c => $datos) {
                        echo '<div class="brand_item col-md-2 col-sm-6" align="center">
                            <i class="iconos '.$datos['ico'].'"></i><br><br>
                            <h5>'.utf8_encode($datos['nombre']).'</h5>
                        </div>';
                    }
                    echo '</div>';
                }
                echo '</div>'; 
                $cont++;
        } ?>
      </div>
    <?php 
    if (!empty($areas_bloque)){ ?>
        <ol class="indicadores col-md-12 carousel-indicators">
        <?php 
            for ($i=0; $i < count($areas_bloque); $i++) { 
              ?>
                <li data-target="#myCarousel1" data-slide-to="<?php echo $i; ?>" <?php if($i == 0){ echo 'class="active"'; } ?>></li>
      <?php     
            } ?>
        </ol>
    <?php } ?> 
      
    </div>   

  </div>
</section>

<br><br>
<div class="text-center" align="center">
  <h2 class="titulo">¿Qué es CANEA?</h2>
  <center>
    <div class="col-md-12 col-sm-12 text-center">
      <div class="col-md-2 col-sm-2 col-xs-2 col-sm-offset-1 col-xs-offset-1">
        <div class="canea-text-modal visible-lg visible-md visible-xs visible-sm ">C</div>
      </div>
      <div class="col-md-2 col-sm-2 col-xs-2  text-center">
        <div class="canea-text-modal visible-lg visible-md visible-xs visible-sm ">A</div>
      </div>
      <div class="col-md-2 col-sm-2 col-xs-2 ">
        <div class="canea-text-modal visible-lg visible-md visible-xs visible-sm">N</div>
        
      </div>
      <div class="col-md-2 col-sm-2 col-xs-2 ">
        <div class="canea-text-modal visible-lg visible-md visible-xs visible-sm ">E</div>
        
      </div>
      <div id="prueba-e" class="col-md-2 col-sm-2 col-xs-2 ">
        <div class="canea-text-modal visible-lg visible-md visible-xs visible-sm">A</div>
        
      </div>
      <div class="canea-text-modal col-md-1 ocultar">&nbsp;</div>
    </div>
    <div class="parrafo col-md-12 col-sm-12 col-xs-12">
      <p>Es un Test que tiene por objetivo evaluar las competencias laborales de los candidatos y facilitar el proceso de reclutamiento de las empresas.</p>
    </div>
    <button class="btn-blue">
      <a href="<?php echo PUERTO."://".HOST."/canea/"?>" class="texto-white">Conoce m&aacute;s</a>
    </button>
  </center>
</div>
<!-- <br> -->

<!-- PUBLICIDAD -->
<section class="tti_section text-center">
  <div class="container">
    <div class="row"> 
      <div class="col-md-12">
        <img id="imagen-centro" class="img-responsive" align="center" src="<?php echo PUERTO.'://'.HOST;?>/imagenes/logo_tti_blanco.png">
      </div>
      <div class="col-md-12">
        <div class="tti_concept">
          <span>
            Somos consultores asociados de TTI 
            SUCCESS INSIGHTS™ , l&iacute;der mundial en medici&oacute;n de habilidades blandas 
            para la gesti&oacute;n de talento y alto desempe&ntilde;o, con el nivel de 
            confiabilidad m&aacute;s alto a nivel mundial.
          </span>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="item_tti">
          <p>
            <span class="tti_st">
              <i class="fa fa-flag"></i>
            </span>
          </p>
          
          <span class="count">92</span>
          <span>PA&Iacute;SES</span>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="item_tti">
          <p>
            <span class="tti_st">
              <i class="fa fa-check-circle"></i>
            </span>
          </p>
          
          <p class="text_definition_tti">
            <span class="count">10</span><span> MILLONES</span>
          </p>
          DE EVALUADOS
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="item_tti">
          <p>
            <span class="tti_st">
              <i class="fa fa-clock-o"></i>
            </span>
          </p>
          
          <p>
            <span class="count">8</span><span> SEGUNDOS</span>
          </p>
          EN ALG&Uacute;N LUGAR DEL MUNDO SE HACE UN TTI
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="item_tti">
          <p>
            <span class="tti_st">
              <i class="fa fa-search"></i>
            </span>
          </p>
          
          <p>
            <span class="count">30</span><span> AÑOS</span>
          </p>
          DE INVESTIGACI&Oacute;N
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Listado de auspiciantes -->
<section id="brand" class="brand fix">
  <div class="container-fluid">
    <br>
    <!--<div class="carousel slide col-md-12" data-ride="carousel" data-type="multi" data-interval="3000" id="myCarousel3">
      <div class="carousel-inner">
        <?php 
       /* $cont = 1;
        if (count($arrauspiciante) > 1){
          foreach($arrauspiciante as $auspiciante) {     */    
        ?>
            <div class="item <?php #if($cont == 1){ echo 'active'; } ?>">
              <div class="brand_item col-md-2 col-sm-6 "><a target="_blank" href="<?php #echo $auspiciante['url']; ?>"><img style="max-width:100%; width:100%" src="<?php #echo PUERTO."://".HOST;?>/imagenes/auspiciantes/<?php #echo $auspiciante['id_auspiciante'].'.'.$auspiciante['extension'];?>" class="img-responsive"></a>
              </div>
            </div>
        <?php 
          #$cont++; 
          #}
        #} 
        ?>
      </div>
    </div>    -->            
  </div>
</section><!-- End off Brand section -->

<?php if(!Modelo_Usuario::estaLogueado()){ ?>
  <section class=" banner-publicidad">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="banner-light col-md-6">¡Únete hoy y encuentra tu trabajo ideal!</div>
          <button class="btn-minimalista col-md-2"><a href="<?php echo PUERTO."://".HOST."/registro/";?>">Registrarse</a></button>
          <button class="btn-minimalista col-md-2"><a href="<?php echo PUERTO."://".HOST."/login/";?>">Ingresar</a></button>
        </div>
      </div>
    </div>
  </section>
<?php } ?>
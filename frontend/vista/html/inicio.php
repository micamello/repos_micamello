<div class="">
    <div class="row">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <?php 
            if (!empty($banners)){ ?>
                <ol class="carousel-indicators">
                <?php 
                    $cont = 0;
                    foreach($banners as $banner){  ?>
                        <li data-target="#myCarousel" data-slide-to="<?php echo $cont; ?>" <?php if($cont == 0){ echo 'class="active"'; } ?>></li>
              <?php     $cont++; 
                    } ?>
                </ol>
            <?php } ?>

            <div class="carousel-inner">
              <?php 
            if (!empty($banners)){
                $cont = 0;
                foreach($banners as $banner){ ?>
                    <div class="item <?php if($cont == 0){ echo 'active'; } ?>">
                        <a href="<?php echo $banner['url']; ?>" target="_blan"><img style="width: 100%; background-size: cover;" src="<?php echo PUERTO.'://'.HOST;?>/imagenes/banner/<?php echo $banner['id_banner'];?>.<?php echo $banner['extension'];?>"></a>
                    </div>
                <?php $cont++; }
            } ?>
            </div>
        </div>
    
    </div>
    <?php 
        if (isset($_SESSION['mfo_datos']['usuario']) && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) {
            ?>
            <section style="background-color: #369fe4; padding: 10px 0px 10px 0px;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="container">
                            <span style="font-size: 40px; color: white; font-weight: 500;">Llámanos a nuestras líneas Call Center:</span>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="container">
                        <div class="col-md-6">
                            <span style="font-size: 30px; color: white; text-align: center;"><b>Quito: </b>026055990 <i class="fa fa-phone"></i></span>
                        </div>
                        <div class="col-md-6">
                            <span style="font-size: 30px; color: white; text-align: center;"><b>Guayaquil: </b>04 6060111 <i class="fa fa-phone"></i></span>
                        </div>
                    </div>
                </div>
            </section>
    <?php } ?>
    
            <!--Featured Section-->
            <section>
                <div class="container">
                    <div class="row">
                        
                        <div class="job_count">
                            <div  align="center" class="col-md-4 col-sm-4 col-xs-12" >
                                <h3 class="info_text_jobs">Empleos Agregados</h3>                                
                                <h2 align="" class="count"><?php echo $nro_oferta; ?></h2>                                   
                            </div>
                            <div align="center" class="col-md-4 col-sm-4 col-xs-12">
                                <h3 class="info_text_jobs">Candidatos Activos</h3>  
                                <h2 class="count"><?php echo $nro_candidato; ?></h2>                                   
                            </div>
                           <div align="center" class="col-md-4 col-sm-4 col-xs-12">
                                <h3 class="info_text_jobs">Empresas Disponibles</h3>
                                <h2 class="count"><?php echo $nro_empresa; ?></h2>
                            </div>
                        </div>
                    </div><!-- End off row -->
                </div><!-- End off container -->
            </section><!-- End off Featured Section-->

            <section id="brand" class="business bg-grey roomy-70">
              <div class="container-fluid">
                <div class="" align="center">
                                    <h2 class="title_section">Categorías de Empleos</h2>
                                        Una mejor carrera está por ahí. Te ayudaremos a encontrarlo Somos 
                                        su primer paso para convertirnos en todo lo que queremos ser.
                                </div><br><br>
                <div class="carousel slide col-md-10 col-md-offset-1" data-ride="carousel" data-type="multi" data-interval="3000" id="myCarousel">
                  <div class="carousel-inner">
                    <?php 
                        $cont = 1;
                        foreach($arrarea as $area) {
                        $nro_areas = Modelo_Oferta::obtieneNroArea($area["id_area"]);  
                    ?>
                        <div class="item <?php if($cont == 1){ echo 'active'; } ?>">
                          <div class="brand_item col-md-2 col-sm-6" align="center"><i class="<?php echo $area['ico'] ?> font_awesome"></i><br><br>
                            <h5><?php echo utf8_encode($area['nombre']) ?></h5>
                            <div class="nvac">(<?php echo $nro_areas; ?> vacantes)</div><br><br>
                          </div>
                        </div>
                    <?php $cont++; } ?>
                  </div>
                </div>                
              </div>
            </section>

            <!--product section-->
            <section class="casos_exito_mic">
                <div class="container">
                    <div class="row">                        
                        <div class="main_test fix">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="text-center fix">
                                    <h2 class="title_section">Casos de Éxito</h2>
                                    <h5>Una mejor carrera está por ahí. Te ayudaremos a encontrarlo</h5>
                                </div>
                            </div>

                <?php foreach($arrtestimonio as $testimonio) { ?>
                        <div class="col-md-4">
                            <div class="test_item fix">
                                <div class="col-sm-2 col-md-4" id="testimonio">
                                    <img class="img-circle" src="<?php echo PUERTO.'://'.HOST;?>/imagenes/testimonios/<?php echo $testimonio['id_testimonio'];?>.<?php echo $testimonio['extension'];?>"><i id="icono" class="fa fa-quote-left"></i></img>
                                </div>
                                <div style="" class="col-sm-10 col-md-8">
                                    <h5><?php echo utf8_encode($testimonio['nombre']);?></h5>
                                    <h6><?php echo utf8_encode($testimonio['profesion']);?></h6>
                                    <p><?php echo utf8_encode($testimonio['descripcion']);?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                        </div>
                    </div>
                </div>
            </section><!-- End off Product section -->

<!-- PUBLICIDAD -->

            <section class="tti_section">
                <div class="container">
                    <div class="row"> 
                        <div class="col-md-12">
                            <img src="<?php echo PUERTO.'://'.HOST;?>/imagenes/logo_tti_blanco.png">
                        </div>
                        <div class="col-md-12">
                            <div class="tti_concept">
                                <span>
                                    Somos consultores asociados de TTI SUCCESS INSIGHTS™ , líder mundial en medición de habilidades blandas para la gestión de talento y alto desempeño, con el nivel de confiabilidad más alto a nivel mundial.
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
                                <span>PAÍSES</span>
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
                                EN ALGÚN LUGAR DEL MUNDO SE HACE UN TTI
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
                                DE INVESTIGACIÓN
                            </div>
                        </div>
                    </div>
                </div>
            </section>

<!-- Modal registro exitoso -->
<!-- <div class="modal" tabindex="-1" role="dialog" id="modal_registro">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
    </div>
  </div>
</div> -->
<!-- Modal registro exitoso -->

<!-- FIN PUBLICIDAD -->
<!-- <a href="<?php echo PUERTO."://".HOST;?>/informePDF/" class="btn btn-success">Eder</a> -->

<!-- Listado de auspiciantes -->
<section id="brand" class="brand fix">
  <div class="container-fluid">
    <div class="carousel slide col-md-12" data-ride="carousel" data-type="multi" data-interval="3000" id="myCarousel">
      <div class="carousel-inner">
        <?php 
            $cont = 1;
            foreach($arrauspiciante as $auspiciante) { 
        ?>
            <div class="item <?php if($cont == 1){ echo 'active'; } ?>">
              <div class="brand_item col-md-2 col-sm-6 "><a target="_blank" href="<?php echo $auspiciante['url']; ?>"><img style="width:100%" src="<?php echo PUERTO."://".HOST;?>/imagenes/auspiciantes/<?php echo $auspiciante['id_auspiciante'].'.'.$auspiciante['extension'];?>" class="img-responsive"></a></div>
            </div>
        <?php $cont++; } ?>
      </div>
    </div>                
  </div>
</section><!-- End off Brand section -->





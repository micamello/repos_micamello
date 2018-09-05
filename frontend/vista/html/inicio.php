<div class="">
    <div class="row">
    <?php 
    if (!empty($banners)){
        foreach($banners as $banner){ ?>
            <img style="width: 100%; background-size: cover;" src="<?php echo PUERTO.'://'.HOST;?>/imagenes/banner/<?php echo $banner['id_banner'];?>.<?php echo $banner['extension'];?>">
        <?php }
    } ?>
    </div>
            <?php 
                //if ($rol==2) {
                    ?>
                    <!--<section style="background-color: #369fe4; padding: 10px 0px 10px 0px;">
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
                    </section>-->
                    <?php
                    # code...
                //}
             ?>
    
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


            <!--Business Section-->
            <section id="business" class="business bg-grey roomy-70">
                <div class="container">
                    <div class="row">
                        <div class="main_business">
                            <div class="col-md-12">
                                <div class="" align="center">
                                    <h2 class="title_section">Categorías de Empleos</h2>
                                        Una mejor carrera está por ahí. Te ayudaremos a encontrarlo Somos 
                                        su primer paso para convertirnos en todo lo que queremos ser.
                                </div><br><br>
                                <?php 
                                    foreach($arrarea as $area){
                                      $nro_areas = Modelo_Oferta::obtieneNroArea($area["id_area"]);  
                                ?>

                                    <div class="col-md-3 col-sm-6 col-xs-12" align="center">
                                        <i class="<?php echo $area['ico']; ?> font_awesome" aria-hidden="true"></i>

                                        <h5><a href="javascript:void(0);"><?php echo utf8_encode($area['nombre']);?></a></h5>

                                        <div class="nvac">(<?php echo $nro_areas; ?> vacantes)</div><br><br>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!-- End off Business section -->

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

                            <div class="col-md-6">
                                <div class="test_item fix">
                                    <div class="item_img">
                                        <img class="img-circle" src="<?php echo PUERTO.'://'.HOST;?>/imagenes/testimonios/<?php echo $testimonio['id_testimonio'];?>.<?php echo $testimonio['extension'];?>"  />
                                        <i class="fa fa-quote-left"></i>
                                    </div>

                                    <div class="item_text">
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
<section id="brand" class="brand fix roomy-70">
  <div class="container">
    <div class="row">
      <?php foreach($arrauspiciante as $auspiciante) { ?>
        <div class="main_brand text-center">
          <div class="col-md-2 col-sm-4 col-xs-12">
            <div class="brand_item auspiciantes_list">
              <img src="<?php echo PUERTO."://".HOST;?>/imagenes/auspiciantes/<?php echo $auspiciante['id_auspiciante'];?>.<?php echo $auspiciante['extension'];?>" />
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</section><!-- End off Brand section -->
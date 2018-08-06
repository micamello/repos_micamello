<!--Home Sections-->

<div class=""><br>
    <?php 
    if (!empty($banners)){
        foreach($banners as $banner){ ?>
            <img style="width: 100%; background-size: cover;" src="<?php echo PUERTO.'://'.HOST;?>/imagenes/banner/<?php echo $banner['imagen'];?>">
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
            <section id="features" class="features">
                <div class="container"><br>
                    <div class="row">
                            <div  align="center" class="col-md-4 bordi" >
								<h3>Empleos Agregados</h3>                                
								<h2 align="" class="count"><?php echo $nro_oferta; ?></h2>                                   
                            </div>
                            <div align="center" class="col-md-4 bordi">
								<h3>Candidatos Activos</h3>  
								<h2 class="count"><?php echo $nro_candidato; ?></h2>                                   
                            </div>
                           <div align="center" class="col-md-4">
								<h3>Empresas Disponibles</h3>
								<h2 class="count"><?php echo $nro_empresa; ?></h2>
                            </div>
                    </div><!-- End off row -->
                </div><!-- End off container --><br>
            </section><!-- End off Featured Section-->


            <!--Business Section-->
            <section id="business" class="business bg-grey roomy-70">
                <div class="container">
                    <div class="row">
                        <div class="main_business">
                            <div class="col-md-12">
                                <div class="business_item sm-m-top-50" align="center">
                                    <h2 class="text-uppercase">Categorías de Empleos</h2>
										Una mejor carrera está por ahí. Te ayudaremos a encontrarlo Somos 
										su primer paso para convertirnos en todo lo que queremos ser.
                                </div><br><br>
                                <?php 
                                    foreach($intereses as $interes){
                                      $nro_interes = Modelo_Oferta::obtieneNroInteres($interes["id_intereses"]);  
                                ?>
                                    <div class="col-md-3" align="center">
                                        <i class="<?php echo $interes['ico']; ?>" aria-hidden="true"></i>
                                        <h5><a href="javascript:void(0);"><?php echo $interes['nombre']; ?></a></h5>
                                        <div class="nvac">(<?php echo $nro_interes; ?> vacantes)</div><br><br>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!-- End off Business section -->

            <!--product section--><br>
            <section id="product" class="product">
                <div class="container">
                    <div class="row">                        
                        <div class="main_test fix">

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="head_title text-center fix">
                                    <h2 class="text-uppercase">Casos de Éxito</h2>
                                    <h5>Una mejor carrera está por ahí. Te ayudaremos a encontrarlo</h5>
                                </div>
                            </div>

                <?php foreach($arrtestimonio as $testimonio) { ?>

                            <div class="col-md-6">
                                <div class="test_item fix">
                                    <div class="item_img">
                                        <img class="img-circle" src="<?php echo PUERTO.'://'.HOST;?>/imagenes/testimonios/<?php echo $testimonio['imagen'] ?>"  />
                                        <i class="fa fa-quote-left"></i>
                                    </div>

                                    <div class="item_text">
                                        <h5><?php echo $testimonio['nombre'] ?></h5>
                                        <h6><?php echo $testimonio['profesion'] ?></h6>
                                        <p><?php echo $testimonio['descripcion'] ?></p>
                                    </div>
                                </div>
                            </div>
                    <?php } ?>
                        </div>
                    </div>
                </div>
            </section><!-- End off Product section -->

<!-- PUBLICIDAD -->

            <section id="product" class="product" style="background-color: #4B92A7">
                <div class="container">
                    <div class="row"> 
                        <div class="col-md-12"><br><br>
                            <img src="<?php echo PUERTO.'://'.HOST;?>/imagenes/logo_tti_blanco.png">
                        </div>
                        <div class="col-md-12" style="color: #fff; font-size: 16px"><br>
                            Somos consultores asociados de TTI SUCCESS INSIGHTS™ , líder mundial en medición de habilidades blandas para la gestión de talento y alto desempeño, con el nivel de confiabilidad más alto a nivel mundial.
                        </div>
                        <div class="col-md-3"><br><br><br>
                            <span style="border-collapse: separate;">
                                <span>
                                    <p>
                                        <i class="far fa-flag" style="color: #fff; font-size: 60px"></i>
                                    </p>
                                </span><br>
                                <span class="count" style="color: #000">92</span>
                            </span> 
                            <span style="color: #fff">PAÍSES</span>
                        </div>
                        <div class="col-md-3"><br><br><br>
                            <span style="border-collapse: separate;">
                                <span>
                                    <p>
                                        <i class="fas fa-user-check" style="color: #fff; font-size: 60px"></i>
                                    </p>
                                </span><br>
                                <span class="count" style="color: #000">10</span>
                            </span>
                            <span style="color: #fff">MILLONES</span><br>
                            <span style="color: #fff; font-size: 20px">DE EVALUADOS</span>
                        </div>
                        <div class="col-md-3"><br><br><br>
                            <span style="border-collapse: separate;">
                                <span>
                                    <p>
                                        <i class="fa fa-clock" style="color: #fff; font-size: 60px"></i>
                                    </p>
                                </span><br>
                                <span class="count" style="color: #000">8</span>
                            </span>
                            <span style="color: #fff">SEGUNDOS</span><br>
                            <span style="color: #fff; font-size: 20px">EN ALGÚN LUGAR DEL MUNDO SE HACE UN TTI</span>
                        </div>
                        <div class="col-md-3"><br><br><br>
                            <span style="border-collapse: separate;">
                                <span>
                                    <p>
                                        <i class="fa fa-search" style="color: #fff; font-size: 60px"></i>
                                    </p>
                                </span><br>
                                <span class="count" style="color: #000">30</span>
                            </span>
                            <span style="color: #fff">AÑOS</span><br>
                            <span style="color: #fff; font-size: 20px">DE INVESTIGACIÓN</span>
                        </div>
                    </div><br><br>
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

            <section id="brand" class="brand fix roomy-80">
                <div class="container">
                    <div class="row">
                    <?php foreach($arrauspiciante as $auspiciante) {  ?>

                        <div class="main_brand text-center">
                            <div class="col-md-2 col-sm-4 col-xs-6">
                                <div class="brand_item sm-m-top-20">
                                    <img src="<?php echo PUERTO."://".HOST;?>/imagenes/auspiciantes/<?php echo $auspiciante['imagen'] ?>" />
                                </div>
                            </div>
                        </div>

                    <?php } ?>

                    </div>
                </div>
            </section><!-- End off Brand section -->

        </div>


        <!-- JS includes -->   
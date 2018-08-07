<style type="text/css">
  .home {
    background: linear-gradient( rgba(35, 30, 30, 0.35), rgba(0, 0, 0, 0.35) ),url(<?php echo PUERTO.'://'.HOST;?>/imagenes/banner/cabecera-empresa-3.jpg) no-repeat scroll center center;    background-size: cover;
    position: relative;
    padding-top: 185px;
    padding-bottom: 79px;
    width: 100%;
}
body {
    background-color: #eceff1;
}
</style>
<section id="home" class="home bg-black fix">
	<div class="overlay"></div>
	<div class="container">
	    <div class="row">
	        <div class="main_home text-center">
	            <div class="col-md-12">
	                <div class="hello_slid">
	                    <div class="slid_item">
	                        <div class="home_text ">
	                            <h2 class="text-white">Bienvenid@ <strong><?php echo $_SESSION['mfo_datos']['usuario']['nombres'].' '.$_SESSION['mfo_datos']['usuario']['apellidos']; ?></strong></h2>
	                        </div>
	                    </div>
	                </div>
	            </div>

	        </div>


	    </div><!--End off row-->
	</div><!--End off container -->
</section> <!--End off Home Sections-->

<br>
<div class="checkout-wrap">
  <ul class="checkout-bar">
    <li class="active"><a href="#">Registro</a></li>    
    <li class="active">Completar Perfil</li>
    <li class="">Formulario 1</li>
    <li class="">Formulario 2</li>
    <li class="">Formulario 3</li>
  </ul>
</div>
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

<section id="product" class="product">
    <div class="container"><br><br>
        <div class="row">
            <div class="main_business">                  
                </div>
            </div>
        </div>
    </div>
</section>


<div class="container">
    <div class="breadcrumb">
      <p class="text-center" style="font-size: 20px;">Datos del perfil</p>
    </div>
</div>

<div class="container">
    <div class="col-md-12">
        <section class="profilebox">
            <div class="">
                <div class="col-md-4">
                    <div class="background_img">
                      <aside>                    
                        <img class="profpic" src="<?php echo Modelo_Usuario::obtieneFoto(); ?>" style="border-radius: 50%;">
                                    
                        <ul class="prof-sm"></ul>
                      </aside>
                    
                    <header>
                        <h1 class="prof-name"><?php echo $_SESSION['mfo_datos']['usuario']['nombres']; ?></h1>
                        <h4 class="prof-user"><?php echo $_SESSION['mfo_datos']['usuario']['correo']; ?></h4>
                    </header>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="divide_desc">
                        <main class="user-desc">
                                 
                            <div class="form-group col-md-6">
                                <label for="nombres">Nombres</label>
                                <input class="form-control text-center" readonly id="nombres" value="<?php echo $_SESSION['mfo_datos']['usuario']['nombres']; ?>" />
                            </div>

                            <div class="form-group col-md-6">
                                <label for="apellidos">Apellidos</label>
                                <input class="form-control text-center" readonly id="apellidos" value="<?php echo $_SESSION['mfo_datos']['usuario']['apellidos']; ?>" />
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="correo">Correo</label>
                                <input class="form-control text-center" readonly id="correo" value="<?php echo $_SESSION['mfo_datos']['usuario']['correo']; ?>" />
                            </div>
                                                
                            <div class="form-group col-md-6">
                                <label for="telefono">Tel&eacute;fono</label>
                                <input class="form-control text-center" readonly id="telefono" value="<?php echo $_SESSION['mfo_datos']['usuario']['telefono']; ?>" />
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="dni">C&eacute;dula</label>
                                <input class="form-control text-center" readonly id="dni" value="<?php echo $_SESSION['mfo_datos']['usuario']['dni']; ?>" />
                            </div>
                                                
                            <div class="form-group col-md-6">
                                <label for="username">Usuario</label>
                                <input class="form-control text-center" readonly id="username" value="<?php echo $_SESSION['mfo_datos']['usuario']['username']; ?>" />
                            </div>
                            
                        </main>
                    </div>
                    <footer>
                        <div align="right">
                            <a class="btn btn-success" href="<?php echo PUERTO."://".HOST."/editarperfil/";?>">SIGUIENTE <i class="fa fa-angle-double-right"></i></a>
                        </div>
                    </footer>
                </div>
        </section>
    </div>
</div>
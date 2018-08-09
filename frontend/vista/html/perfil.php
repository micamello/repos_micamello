<style type="text/css">
  .home {
    background: linear-gradient( rgba(35, 30, 30, 0.35), rgba(0, 0, 0, 0.35) ),url(<?php echo PUERTO.'://'.HOST;?>/imagenes/banner/cabecera-candidato.jpg) no-repeat scroll center center;    background-size: cover;
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

            <section id="product" class="product">
                <div class="container"><br><br>
                    <div class="row">
                        <div class="main_business">                            
                            </div>
                        </div>
                    </div>
                </div>
        </form>

    </div>
    
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
                    <img class="profpic" src="<?php echo PUERTO.'://'.HOST;?>/imagenes/usuarios/profile/<?php echo $_SESSION['mfo_datos']['usuario']['id_usuario']; ?>.jpg" style="border-radius: 50%;">
                                
                    <ul class="prof-sm">
                        
                    </ul>
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
                    <div class="col-md-6">
                        <b><span class="text-muted">Nombres: </span></b><br><div class="breadcrumb" style="text-align: center; color: black; font-size: 17px;"><?php echo $_SESSION['mfo_datos']['usuario']['nombres']; ?></div>
                    </div>
                    
                    <div class="col-md-6">
                        <b><span class="text-muted">Apellidos: </span></b><br><div class="breadcrumb" style="text-align: center; color: black; font-size: 17px;"><?php echo $_SESSION['mfo_datos']['usuario']['apellidos']; ?></div>
                    </div>
                    
                    <div class="col-md-6">
                        <b><span class="text-muted">Correo: </span></b><br><div class="breadcrumb" style="text-align: center; color: black; font-size: 17px;"><?php echo $_SESSION['mfo_datos']['usuario']['correo']; ?></div>
                    </div>
                                        
                    <div class="col-md-6">
                        <b><span class="text-muted">Teléfono: </span></b><br><div class="breadcrumb" style="text-align: center; color: black; font-size: 17px;"><?php echo $_SESSION['mfo_datos']['usuario']['telefono']; ?></div>
                    </div>
                    
                    <div class="col-md-6">
                        <b><span class="text-muted">Cédula: </span></b><br><div class="breadcrumb" style="text-align: center; color: black; font-size: 17px;"><?php echo $_SESSION['mfo_datos']['usuario']['dni']; ?></div>
                    </div>
                                        
                    <div class="col-md-6">
                        <b><span class="text-muted">Usuario: </span></b><br><div class="breadcrumb" style="text-align: center; color: black; font-size: 17px;"><?php echo $_SESSION['mfo_datos']['usuario']['username']; ?></div>
                    </div>
                    
                </main>
                </div>
                <footer>
                    <?php //if ($nombre_hv != "" && $rol == 1): ?>
                        <!--<div class="col-md-6" align="center">
                            <a target="blanked" class="btn btn-warning" href="docs/curiculum/<?php echo $nombre_hv ?>" style="text-decoration: underline;"><img src="http://doctoresqueretaro.com/wp-content/uploads/2015/02/icono.png" width="30px">Ver/Descargar HV</a>
                        </div>-->
                    <?php //else: ?>

                    <?php //endif ?>
                    <div align="right">
                        <a class="btn btn-success" href="<?php echo PUERTO."://".HOST."/editarperfil/";?>">SIGUIENTE <i class="fa fa-angle-double-right"></i></a>
                    </div>
                </footer>
            </div>
        </div>
        
    </section>
    </div>
    </div>
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
                        <img class="profpic" src="<?php echo Modelo_Usuario::obtieneFoto($_SESSION['mfo_datos']['usuario']['id_usuario']); ?>" style="border-radius: 50%;">
                                    
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
                                <?php if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == 1) { ?>
                                    <label for="nombres">Nombres</label>
                                <?php }else{ ?>
                                    <label for="nombres">Nombre de la empresa</label>
                                <?php } ?>
                                <input class="form-control text-center" readonly id="nombres" value="<?php echo $_SESSION['mfo_datos']['usuario']['nombres']; ?>" />
                            </div>

                            <?php if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == 1) { ?>
                                <div class="form-group col-md-6">
                                    <label for="apellidos">Apellidos</label>
                                    <input class="form-control text-center" readonly id="apellidos" value="<?php echo $_SESSION['mfo_datos']['usuario']['apellidos']; ?>" />
                                </div>
                            <?php } ?>

                            <div class="form-group col-md-6">
                                <?php if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == 1) { ?>
                                    <label for="nombres">C&eacute;dula</label>
                                <?php }else{ ?>
                                    <label for="nombres">Ruc</label>
                                <?php } ?>
                                <input class="form-control text-center" readonly id="dni" value="<?php echo $_SESSION['mfo_datos']['usuario']['dni']; ?>" />
                            </div>

                            <div class="form-group col-md-6">
                                <label for="telefono">Tel&eacute;fono</label>
                                <input class="form-control text-center" readonly id="telefono" value="<?php echo $_SESSION['mfo_datos']['usuario']['telefono']; ?>" />
                            </div>

                            <?php if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == 1) { ?>
                                <div class="form-group col-md-6">
                                    <label for="correo">Correo</label>
                                    <input class="form-control text-center" readonly id="correo" value="<?php echo $_SESSION['mfo_datos']['usuario']['correo']; ?>" />
                                </div>
                                                                              
                                <div class="form-group col-md-6">
                                    <label for="username">Usuario</label>
                                    <input class="form-control text-center" readonly id="username" value="<?php echo $_SESSION['mfo_datos']['usuario']['username']; ?>" />
                                </div>
                            <?php }else{ ?>
                                <div class="form-group col-md-6">
                                    <label for="mayor_edad"><?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == 1) { ?> Fecha de Nacimiento <?php }else{ ?> Fecha de Apertura <?php } ?></label>
                                    <input class="form-control text-center" type="text" name="fecha" id="mayor_edad" value="<?php echo date('d-m-Y',strtotime($_SESSION['mfo_datos']['usuario']['fecha_nacimiento'])); ?>" readonly/>
                                </div>
                            <?php } ?>
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
<br><br><br><br><br> 
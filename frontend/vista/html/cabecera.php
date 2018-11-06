<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta name="google-site-verification" content="Hy5ewWRp0yOqH1Z_3Q59zSVffxTZDLa_T50VEoGBIBw" />
  <title>MiCamello - Portal de Empleos en Ecuador</title>
  <meta name="keywords" content="ofertas de trabajo, trabajos, empleos, bolsa de empleos, buscar trabajo, busco empleo, portal de empleo, ofertas de empleo, bolsa de empleo, trabajos en ecuador, paginas de empleo, empleos ecuador, camello">
  <title>MiCamello - Portal de Empleos en Ecuador</title>
  <meta name="description" content="Cientos de empresas publican las mejores ofertas en la bolsa de trabajo Mi Camello Ecuador. Busca empleo y apúntate y sé el primero en postular">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta property="og:image" content="https://www.micamello.com.ec/" />
  <link rel="icon" type="image/x-icon" href="<?php echo PUERTO."://".HOST;?>/imagenes/favicon.ico">

  <!--Google Font link-->
  <!--<link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">-->
  <!-- <link rel="stylesheet" type="text/css" href="<?php #echo PUERTO."://".HOST;?>/css/demo.css" /> -->

  <!-- <link rel="stylesheet" type="text/css" href="<?php echo PUERTO."://".HOST;?>/css/style.css" /> -->
  <!--<link href='http://fonts.googleapis.com/css?family=Alfa+Slab+One' rel='stylesheet' type='text/css'>-->
  <!--<link href='http://fonts.googleapis.com/css?family=Boogaloo' rel='stylesheet' type='text/css'>-->
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/assets/css/bootstrap.css">
  <!-- Archivo css micamello mic.css -->
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/mic.css">
  <!--Theme custom css -->
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/assets/css/style.css">
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/media-queries.css">
  
  <link href="<?php echo PUERTO."://".HOST;?>/css/assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo PUERTO."://".HOST;?>/css/cookies.css" rel="stylesheet" type="text/css">

  <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous"> -->
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/assets/css/font-awesome.min.css">


  <?php
    if (isset($template_css) && is_array($template_css)){
      foreach($template_css as $file_css){
        echo '<link rel="stylesheet" href="'.PUERTO.'://'.HOST.'/css/'.$file_css.'.css">';
      }  
    }
  ?>

  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-123345917-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-123345917-1');
  </script>

  <?php if(isset($_SESSION['mostrar_banner'])){ ?>
  <style>
    /* Para vista perfil */
    .home {
        background-image: url(<?php echo $_SESSION['mostrar_banner']; ?>);   
        background-size: cover;
        position: relative;
        padding-top: 185px;
        padding-bottom: 79px;
        width: 100%;
    }
  </style>
  <?php } ?>
</head>

<body>

<!--                       LEY DE COOKIES                     -->
<div class="modal fade" id="msg_cookies" tabindex="-1" role="dialog" aria-labelledby="msg_cookies" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel" align="center">Uso de Cookies</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12" style="font-size: 16px; color: #333">
            <b class="text_large">Este sitio web utiliza cookies para que usted tenga la mejor experiencia de usuario. Si contin&uacute;a navegando est&aacute; dando su consentimiento para la aceptaci&oacute;n de las mencionadas cookies y la aceptaci&oacute;n de nuestra pol&iacute;tica de cookies.</b>
            <b class="text_small">Este sitio web utiliza cookies desea activarlas para mayor experiencia.</b>
            <br>
            <center>
              <a href="#" class="ok" onclick="CrearCookie();"><b>OK</b></a> | 
              <a href="<?php echo PUERTO."://".HOST;?>/docs/politicas_de_cookies.pdf" target="_blank" class="info">M&aacute;s informaci&oacute;n</a>
            </center> 
          </div>
        </div>
      </div>      
    </div>
  </div>
</div>

<!--                       NOTIFICACIONES                     -->
<?php

if(isset($_SESSION['mfo_datos']['usuario'])){

 $notificaciones = Modelo_Notificacion::notificacionxUsuario($_SESSION['mfo_datos']['usuario']['id_usuario'],Modelo_Notificacion::WEB);

 if(!empty($notificaciones)){  ?>

  <input type="hidden" name="msg_notificacion" id="msg_notificacion" value="1">

  <div class="modal fade" id="notificaciones" tabindex="-1" role="dialog" aria-labelledby="notificaciones" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel" align="center">Notificaci&oacute;n</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12" style="font-size: 16px; color: #333">

              <b class="text_large">
                <?php echo $notificaciones['descripcion']; ?>
              </b>
              <b class="text_small"><?php echo $notificaciones['descripcion']; ?></b>
              <br>
              <center>
                <a href="#" onclick="desactivarNotificacion(<?php echo $notificaciones['id_notificacion']; ?>,'<?php echo $notificaciones['url']; ?>')" class="ok"><b>Aceptar</b></a>
              </center> 
            </div>
          </div>
        </div>      
      </div>
    </div>
  </div>
<?php } 
} ?>


  <nav class="navbar navbar-default navbar-fixed-top">
 <!--   <button id="buttonP">Dar Permisos</button>  
<button id="buttonN">Lanzar notificación</button>-->
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo PUERTO."://".HOST;?>">
            <img src="<?php echo PUERTO.'://'.HOST.'/imagenes/sucursal/logos/'.SUCURSAL_ID.'.'.SUCURSAL_LOGO;?>" alt="micamellologo">
          </a>
        </div>
        <!-- End Header Navigation -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav"> 
            </ul>
        <ul class="nav navbar-nav navbar-right">                          
              <?php 
              if (isset($menu["menu"])){   
                foreach($menu["menu"] as $key=>$optmnu){ ?>                                                    
                  <li>
                    <a onclick="<?php echo (isset($optmnu["onclick"])) ? $optmnu["onclick"] : "";?>" href="<?php echo $optmnu["href"];?>" <?php echo (isset($optmnu["modal"])) ? ' ' : '';?>><?php if($optmnu["nombre"] == 'Inicio'){ echo '
                    <i class="fa fa-home fa-2x"></i>';  }else{ echo $optmnu["nombre"]; } ?></a>
                  </li>                            
                <?php } ?>
                <?php if (isset($menu["submenu_cuentas"])){ ?>                            
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cuentas
                      <ul class="dropdown-menu">
                        <?php foreach($menu["submenu_cuentas"] as $submenu_cuentas){ ?>  
                           <li><a href="<?php echo $submenu_cuentas['href'];?>"><?php echo $submenu_cuentas['nombre'];?></a></li>
                        <?php } ?>
                      </ul>
                    </a>
                  </li>                              
                <?php } ?>
                <?php if (isset($menu["submenu"])){ ?>                            
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['mfo_datos']['usuario']['nombres']; ?><img src="<?php echo Modelo_Usuario::obtieneFoto($_SESSION['mfo_datos']['usuario']['id_usuario']); ?>" class="user_icon">
                      <ul class="dropdown-menu">
                        <?php foreach($menu["submenu"] as $submenu){ ?>  
                            <li><a href="<?php echo $submenu['href'];?>"><?php echo $submenu['nombre'];?></a></li>
                        <?php } ?>
                      </ul>
                    </a>
                  </li>                              
                <?php } ?>
              <?php } ?>
            </ul>
        </div> 
    </div> 
</nav>


<?php
if(isset($show_banner)){ ?>
<section id="home" class="home bg-black fix">
  <div class="overlay" ></div>
  <div class="container">
    <!--<div class="row">-->
      <div class="main_home text-center">
        <div class="col-md-12">
          <div class="hello_slid">
            <div class="slid_item">
              <div class="home_text ">
                <h2 class="text-white">Bienvenid@ <strong><?php echo $_SESSION['mfo_datos']['usuario']['nombres'].' '; if(isset($_SESSION['mfo_datos']['usuario']['apellidos'])) { echo $_SESSION['mfo_datos']['usuario']['apellidos']; } ?></strong></h2>
              </div>
            </div>
          </div>
        </div>
      </div>
    <!--</div>End off row-->
  </div><!--End off container -->
</section> <!--End off Home Sections-->
<?php } ?>

<?php

  if (isset($breadcrumbs) && is_array($breadcrumbs)){ ?>
    <br>
    <?php if(!isset($show_banner)){ ?> 
      <br><br><br><br>
    <?php } ?>
    <div class="container">
      <ol class="breadcrumb" align="left">
        <?php 
        $cont = 1;
        echo '<li><a href="'.PUERTO."://".HOST.'/">Inicio</a></li>';
        foreach($breadcrumbs as $key => $accion){ 
          if((count($breadcrumbs)-1) >= $cont){
              $enlace = '<a href="'.PUERTO."://".HOST.'/'.$key.'/">'.$accion.'</a>';
          }else{
            $enlace = $accion;
          }
          echo '<li>'.$enlace.'</li>';
          $cont++;
        } ?>
      </ol> 
    </div>
  <?php } ?>



<section id="product" class="product">
  <br>
  <?php if(!isset($show_banner) && !isset($breadcrumbs)){ ?>
    <br><br><br>
  <?php } ?>
    <!--mensajes de error y exito-->
    <?php if (isset($sess_err_msg) && !empty($sess_err_msg)){?>
      <div align="center" id="alerta" style="display:" class="alert alert-danger alert-dismissible">
        <?php echo $sess_err_msg;?>
      </div>  
    <?php }?>

    <?php if (isset($sess_suc_msg) && !empty($sess_suc_msg)){?>
      <div align="center" id="alerta" style="display:" class="alert alert-success alert-dismissible">
        <?php echo $sess_suc_msg;?>
      </div>  
    <?php } ?>
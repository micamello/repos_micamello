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
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/bootstrap.css">
  <!-- Archivo css micamello mic.css -->
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/mic.css">
  <!--Theme custom css -->
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/assets/css/style.css">
  <!--<link rel="stylesheet" href="<?php #echo PUERTO."://".HOST;?>/css/media-queries.css">-->
  <link href="<?php echo PUERTO."://".HOST;?>/css/assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo PUERTO."://".HOST;?>/css/cookies.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/bootstrap-multiselect.css">
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/micamello.css">
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/estilo.css">

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

  <script type="text/javascript" src="https://integracion.alignetsac.com/VPOS2/js/modalcomercio.js"></script>
</head>

<body>

  <!--                       LEY DE COOKIES                     -->
<!--<div class="modal fade" id="msg_cookies" tabindex="-1" role="dialog" aria-labelledby="msg_cookies" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
              <a href="<?php #echo PUERTO."://".HOST;?>/docs/politicas_de_cookies.pdf" target="_blank" class="info">M&aacute;s informaci&oacute;n</a>
            </center> 
          </div>
        </div>
      </div>      
    </div>
  </div>
</div>-->

<!--NOTIFICACIONES-->
<?php
if(isset($_SESSION['mfo_datos']['usuario'])){
  $notificaciones = Modelo_Notificacion::notificacionxUsuario($_SESSION['mfo_datos']['usuario']['id_usuario'],$_SESSION['mfo_datos']['usuario']['tipo_usuario']);

  if(!empty($notificaciones)){ ?>
    <input type="hidden" name="msg_notificacion" id="msg_notificacion" value="1">
    <div class="modal fade" id="notificaciones" tabindex="-1" role="dialog" aria-labelledby="notificaciones" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel" align="center">Notificaci&oacute;n</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12" style="font-size:16px; color:#333">
                <b class="text_large">
                  <?php echo $notificaciones['descripcion'];?>
                </b>
                <b class="text_small"><?php echo utf8_encode($notificaciones['descripcion']); ?></b>
                <br>
                <center>
                  <?php if ($notificaciones["tipo"] == Modelo_Notificacion::DESBLOQUEO_ACCESO && 
                  $notificaciones["tipo_usuario"] == Modelo_Usuario::CANDIDATO) { ?>
                    <a href="javascript:void(0);" onclick="cancelarAcceso(<?php echo $notificaciones['id_notificacion'];?>);" class="btn btn-cancel"><b>Cancelar</b></a>
                    <a href="javascript:void(0);" onclick="aceptarAcceso(<?php echo $notificaciones['id_notificacion'];?>);" class="btn btn-success"><b>Aceptar</b></a>
                  <?php } else { ?>
                    <a href="javascript:void(0);" onclick="desactivarNotificacion(<?php echo $notificaciones['id_notificacion'];?>);" class="btn btn-success"><b>Aceptar</b></a>
                  <?php } ?>                  
                </center> 
              </div>
            </div>
          </div>      
        </div>
      </div>
    </div>
  <?php } 
} ?>

<?php 
$navegador = Utils::detectarNavegador();
$_SESSION['mfo_datos']['navegador'] = $navegador;
if($navegador == 'MSIE'){ ?>
  <div align="center" id="mensaje" style="height: 150px;background: #c36262; color:black;"><br>
    <h3>Usted esta usando internet explorer 8 o inferior</h3>
    <p>Esta es una versi&oacute;n antigua del navegador, y puede afectar negativamente a su seguridad y su experiencia de navegaci&oacute;n.</p>
    <p>Por favor, actualice a la version actual de IE o cambie de navegador ahora.</p>
    <p><b><a href="https://www.microsoft.com/es-es/download/internet-explorer.aspx">Actualizar IE</a></b></p>
  </div>
<?php } ?>

<nav class="menu navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" id="img-logo"  href="<?php echo PUERTO."://".HOST;?>">
        <img class="logo" src="<?php echo PUERTO.'://'.HOST.'/imagenes/sucursal/logos/'.SUCURSAL_ID.'.'.SUCURSAL_LOGO;?>" alt="micamellologo">
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
            <li <?php if($optmnu["nombre"] == 'Registrate' || $optmnu["nombre"] == 'Ingresar'){ echo 'class="btn-minimalist"'; } ?> >
              <a class="texto-white" <?php if(isset($optmnu['id'])){ echo 'id="'.$optmnu["id"].'"';}  if(isset($optmnu['href'])){ echo 'href="'.$optmnu['href'].'"'; }else{ echo 'onclick="'.$optmnu['onclick'].'"'; } ?> <?php echo (isset($optmnu["modal"])) ? ' ' : '';?>><?php if($optmnu["nombre"] == 'Inicio'){ echo '
              Inicio';  }else{ echo $optmnu["nombre"]; } ?></a>
            </li>                            
          <?php } ?>
          <?php if (isset($menu["submenu_cuentas"])){ ?>                            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cuentas&nbsp;<i class="fa fa-caret-down"></i>
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
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <?php echo utf8_encode($_SESSION['mfo_datos']['usuario']['nombres']).(isset($_SESSION['mfo_datos']['usuario']['apellidos']) ? ' '.utf8_encode($_SESSION['mfo_datos']['usuario']['apellidos']) : ''); ?>&nbsp;&nbsp;&nbsp;<!-- &nbsp;&nbsp;&nbsp;&nbsp; -->
              <img src="<?php echo Modelo_Usuario::obtieneFoto($_SESSION['mfo_datos']['usuario']['username']); ?>" class="user_icon <?php if(Utils::detectarNavegador()=='Safari'){
                echo "usericon_safari";
              } ?>"><i class="fa fa-caret-down"></i>
              <ul class="dropdown-menu">
                <?php foreach($menu["submenu"] as $submenu){ ?>  
                  <li><a <?php if(isset($submenu['href'])){ echo 'href="'.$submenu['href'].'"'; }else{ echo 'onclick="'.$submenu['onclick'].'"'; } ?>><?php echo $submenu['nombre'];?></a></li>
                <?php } ?>
              </ul>
            </a>
          </li>                              
        <?php } ?>
      <?php } ?>
      <li>
        <a id="regEmpMic" href="<?php echo FACEBOOK; ?>"><i class="social fa fa-facebook"></i></a>
      </li>
      <li>
        <a id="regEmpMic" href="<?php echo TWITTER; ?>"><i class="social fa fa-twitter"></i></a>
      </li>
      <li>
        <a id="regEmpMic" href="<?php echo INSTAGRAM; ?>"><i class="social fa fa-instagram"></i></a>
      </li>
      </ul>
    </div> 
  </div>
</nav>

<?php
//if(isset($show_banner)){ ?>
<!--<section id="home" class="home bg-black fix">
  <div class="overlay" ></div>
  <div class="container">
      <div class="main_home text-center">
        <div class="col-md-12">
          <div class="hello_slid">
            <div class="slid_item">
              <div class="home_text ">
                <h2 class="text-white">Bienvenid@ <strong><?php //echo utf8_encode($_SESSION['mfo_datos']['usuario']['nombres']).' '; if(isset($_SESSION['mfo_datos']['usuario']['apellidos'])) { echo utf8_encode($_SESSION['mfo_datos']['usuario']['apellidos']); } ?></strong></h2>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</section>-->
<?php //} ?>

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
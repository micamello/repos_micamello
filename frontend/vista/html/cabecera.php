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
    <link rel="alternate" hreflang="ec-EC" href="https://www.micamello.com.ec/" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:image" content="https://www.micamello.com.ec/" />
    <link rel="icon" type="image/x-icon" href="<?php echo PUERTO."://".HOST;?>/imagenes/favicon.ico">

    <!--Google Font link-->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo PUERTO."://".HOST;?>/css/demo.css" />

    <!-- <link rel="stylesheet" type="text/css" href="<?php echo PUERTO."://".HOST;?>/css/style.css" /> -->
    <link href='http://fonts.googleapis.com/css?family=Alfa+Slab+One' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Boogaloo' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/assets/css/bootstrap.css">
    <!-- Archivo css micamello mic.css -->
    <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/mic.css">
    <!--Theme custom css -->
    <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/media-queries.css">
    <!-- Estilos del multiselect -->
    <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/multiple-select.css">

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
          background: linear-gradient( rgba(35, 30, 30, 0.35), rgba(0, 0, 0, 0.35) ),url(<?php echo $_SESSION['mostrar_banner']; ?>) no-repeat scroll center center;    background-size: cover;
          position: relative;
          padding-top: 185px;
          padding-bottom: 79px;
          width: 100%;
      }
    </style>
    <?php } ?>

    </head>

<body>



<?php
error_reporting(0);

  include("config/potencia.php");

//CANDIDATO
if( $_POST["btnusu"] ) {
    $username=$_POST['username'];
    $correo=$_POST['correo'];
    $nombres=$_POST['nombres'];
    $apellidos=$_POST['apellidos'];
    $password=$_POST['password'];
    $telefono=$_POST['telefono'];
    $dni=$_POST['cedula'];
    $ciudad = $_POST['ciudad'];
    $provincia = $_POST['provincia'];
    $term_cond = $_POST['term_cond'];

    $valuesniv = $_POST['niveles'];
            $rioniv='';
            for ($i=0;$i<count($valuesniv);$i++) 
                    { 
                    $rioniv.=$valuesniv[$i].';'; 
                    } 
    $nivel_intereses=trim($rioniv);

            $values = $_POST['intereses'];
            $rio='';
            for ($i=0;$i<count($values);$i++) 
                    { 
                    $rio.=$values[$i].';'; 
                    } 
    $intereses=trim($rio);


//Guardo datos
    $sql2 = "insert into mfo_usuario (username,password,correo,telefono,dni,intereses,nivel_oferta,nombres,apellidos,fecha_creacion,rol, estado, token, ciudad, provincia, term_cond)
            values('$username','$password', '$correo', '$telefono', '$dni', '$intereses', '$nivel_intereses', '$nombres', '$apellidos', NOW(),1,2,'$token', '$ciudad', '$provincia', '$term_cond')";
   // echo $sql2;
    $result2 = mysqli_query($db,$sql2);
    if ($result2) {
//echo $correo;
include('assets/email.php');    
    
    echo "
 <script>success_register();</script>
 ";
} else{
    echo "
    <script>error_register();</script>
    ";
    //echo "Error: " . mysqli_error($db);
}
   

}

//EMPRESA
if( $_POST["btnemp"] ) {
    $username=$_POST['emp_username'];
    $correo=$_POST['emp_correo'];
    $nombres=$_POST['emp_nempresa'];
    $password=$_POST['emp_password'];
    $telefono=$_POST['emp_telefono'];
    $dni=$_POST['emp_cedula'];
    $ciudad_emp = $_POST['ciudad_emp'];
    $provincia_emp = $_POST['provincia_emp'];
    $term_emp= $_POST['term_emp'];


//Guardo datos
    $sql2 = "insert into mfo_usuario (username,password,correo,telefono,dni,nombres ,fecha_creacion,rol, estado, token, ciudad, provincia, term_cond)
            values('$username','$password', '$correo', '$telefono', '$dni', '$nombres', NOW(),2,2,'$token', '$ciudad_emp', '$provincia_emp', '$term_emp')";
   // echo $sql2;
    $result2 = mysqli_query($db,$sql2);
    if ($result2) {
        include('email.php');   
    echo "
 <script>success_register();</script>
 ";
} else{
    echo "
    <script>error_register_emp();</script>";
    //echo "Error: " . mysqli_error($db);
}
}


?>
    <!--fin de los modals-->


    <body data-spy="scroll" data-target=".navbar-collapse">

        <!--<input type="hidden" name="" id="sessionvar" value="<?php //echo $login_session ?>">-->
        <!-- Preloader -->



        <div class="culmn">
            <!--Home page style-->

   <style type="text/css">
    section#action {
    height: 64px;
    padding-top: 8px;
}
</style>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
                    <div class="navbar-header">
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                      <a class="navbar-brand">
                        <img src="<?php echo PUERTO.'://'.HOST.'/imagenes/sucursal/logos/'.$_SESSION['mfo_datos']['sucursal']['id_sucursal'].'.'.$_SESSION['mfo_datos']['sucursal']['extensionlogo'];?>" alt="micamellologo">
                      </a>
                    </div>
                    <!-- End Header Navigation -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav"> 
                        </ul>
                    <ul class="nav navbar-nav navbar-right">                          
                          <?php 
                          
                          foreach($menu["menu"] as $key=>$optmnu){ ?>                                                    
                            <li>
                              <a onclick="<?php echo $optmnu["onclick"];?>" href="<?php echo $optmnu["href"];?>" <?php echo (isset($optmnu["modal"])) ? ' ' : '';?>><?php echo $optmnu["nombre"];?></a>
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
                              </li>                              
                          <?php } ?>
                        </ul>
                    </div>
                    
                </div> 

            </nav>

<?php
if(isset($show_banner)){ ?>
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
<?php } ?>

<section id="product" class="product">
  <br><br><br><br>
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
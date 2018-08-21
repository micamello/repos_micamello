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
<?php if( !Modelo_Usuario::estaLogueado() ){ ?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" style="z-index:9999">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 97px;">
      <!--<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">REGISTRE SU CUENTA 
        <i class="fa fa-user" style="color: #00a885;padding: 8px;font-size: 25px;"></i></h4>
      </div>-->
      
      <div class="modal-body">

        <!--Formulario de registro usuario - candidato-->
        <div class="col-md-12" align="center">
          <span class="text-center">Accede con: </span>
          <br><br>
          
          <!--<a id="facebook_login" href="<?php //echo $loginUrl ?>">
            <i class="fab fa-facebook" style="font-size: 40px"></i>
          </a>

           <a id="google_login" onclick="window.location = '<?php //echo $gloginURL ?>';">
            <i class="fab fa-google-plus-square" style="font-size: 40px; color:#a94442"></i>
          </a>

          <a id="instagram_login" onclick="javascript: window.location = '<?php //echo $Instagram->getLoginURL() ?>';">
            <i class="fab fa-instagram" style="font-size: 40px; color:#31708f"></i>
          </a>-->
        </div>

        <hr>
        
        <div class="col-md-12" align="center">
          <p class="center-text-line" style="font-size: 17px;">ó</p>
          <span class="text-center" style="color: grey; font-size: 15px;">o registrate con tus datos: </span><br><br>
        </div>


        <br><br>
        <form action = "<?php echo PUERTO."://".HOST;?>/registro/" method = "post" id="form_candidato">

         <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="text-center">Usuario:</label><div class="help-block with-errors"></div>
              <input id="username" type="text" name="username" placeholder="Ejemplo: camello205487" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$" class="form-control" aria-describedby="usernameHelp" required>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label class="text-center">Correo:</label><div class="help-block with-errors"></div>
              <input id="correo" type="email" name="correo" placeholder="Ejemplo: camello@gmail.com" class="form-control" aria-describedby="correoHelp" required>
            </div>
          </div>   
          <input type="hidden" name="register_form" id="register_form" value="1">
          <div class="col-md-6">
              <div class="form-group">
                <label class="text-center">Nombres:</label><div class="help-block with-errors"></div>
                <input type="text" name="nombres" id="name_user" pattern="[a-z A-ZñÑáéíóúÁÉÍÓÚ]+" placeholder="Ejemplo: Carlos Pedro" class="form-control" required>
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                <label class="text-center">Apellidos:</label><div class="help-block with-errors"></div>
                <input type="text" name="apellidos" id="apell_user" pattern='[a-z A-ZñÑáéíóúÁÉÍÓÚ]+' placeholder="Ejemplo: Ortiz Zambrano" class="form-control" required>
              </div>
          </div>       

          <div class="col-md-6">
              <div class="form-group">
                <label class="text-center">Contraseña:</label><div class="help-block with-errors"></div>
                <input id="password" name="password" type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Debe contener letra, una mayúscula mínimo y numeros' : ''); if(this.checkValidity()) form.password_two.pattern = this.value;" placeholder="Ejemplo: me198454EjgE" class="form-control" required data-toggle="password">
              </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="text-center">Confirmar Contraseña:</label><div class="help-block with-errors"></div>
              <input id="password_two" name="password_two" type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Por favor, ingrese la misma contraseña' : '');" placeholder="Verificar contraseña" class="form-control" required data-toggle="password">
            </div>
          </div>    

           <div class="col-md-6">
             <div class="form-group">
               <label for="numero_cand">Celular: </label><div class="help-block with-errors"></div>
               <input type="text" class="form-control" name="numero_cand" id="numero_cand" onclick="numero_validate(this);" required>
             </div>
           </div> 

           <div class="col-md-6">
                  <div class="group">
                    <div class="form-group">
                      <label class="text-center">Cédula / Pasaporte:</label><div class="help-block with-errors"></div>
                      <input id="dni" type="text" name="cedula" minlength="10" maxlength="15" onkeypress="" class="form-control" aria-describedby="dniHelp" required>
                    </div>
                  </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Seleccione área: </label><div class="help-block with-errors"></div>
                  <select class="form-control" name="area_select" id="area_select" multiple required>
                    <option value="" selected disabled>Seleccione un área</option>
                    <?php 
                      if (isset($arrarea) && !empty($arrarea)){
                          foreach($arrarea as $area){ ?>
                              <option value="<?php echo $area['id_area'] ?>"><?php echo $area['nombre'] ?></option>
                          <?php }
                      } ?>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Seleccione nivel de interés: </label><div class="help-block with-errors"></div>
                  <select class="form-control" name="nivel_interes" id="nivel_interes" multiple required>
                    <option value="" selected disabled>Seleccione un área</option>
                    <?php 
                      if (isset($intereses) && !empty($intereses)){
                          foreach($intereses as $interes){ ?>
                              <option value="<?php echo $interes['id_nivelInteres'] ?>"><?php echo $interes['descripcion'] ?></option>
                          <?php }
                      } ?>
                  </select>
                </div>
              </div>  


              <div class="" align="left">
                <label><input type="checkbox" name="term_cond" id="term_cond" value="1" required><a href="<?php echo PUERTO."://".HOST;?>/docs/terminos_y_condiciones.pdf" target="blank">Aceptar términos y condiciones </a></label>
              </div>
              <div class="" align="left">
                <label><input type="checkbox" name="term_data" id="term_data" value="1" required><a href="<?php echo PUERTO."://".HOST;?>/docs/terminos_y_condiciones.pdf" target="blank">Aceptar términos de confidencialidad de datos </a></label>
              </div>

              <div class="row">
                <div class="text-center">
                  <input id="button-save" type="submit" name="btnusu" class="btn btn-primary" value="Crear Cuenta">  
                </div> 
              </div>
            </div>

        </form>
        <!--Formulario de registro usuario - candidato-->


        <div class="row">
          <div class="col-md-12"><br>
            <p class="text-center"><strong>¿Ya tienes cuenta? </strong><a href="<?php echo PUERTO."://".HOST;?>/login/">Iniciar sesión</a></p> 
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- modal empresa -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" style="z-index:9999">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 97px;">
              <form role="form" id="form_empresa" name="formulario2" method="post">

      <!--<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">REGISTRE SU EMPRESA 
        <i class="fa fa-user" style="color: #00a885;padding: 8px;font-size: 25px;"></i></h4>
      </div>-->
      <div class="modal-body">
        <div class="col-md-6">
            <div class="form-group">
              <label>Usuario:</label><div class="help-block with-errors"></div>
              <input type="text" id="emp_username" name="emp_username" placeholder="Ejemplo: camello205487" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$" class="form-control" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
              <label>Correo:</label><div class="help-block with-errors"></div>
              <input type="email" id="emp_correo" name="emp_correo" placeholder="carlosp@gmail.com" class="form-control" required>
            </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
              <label class="text-center">seleccione provincia:</label><div class="help-block with-errors"></div>
              <select id="provincia_emp" class="form-control" name="provincia_emp" required>
                <option value="" selected disabled>Seleccione provincia</option>
                <?php if (isset($arrprovincia) && !empty($arrprovincia)){ ?> 
                  <?php foreach($arrprovincia as $provincia) { ?>
                      <option value="<?php echo $provincia['nombre'] ?>" id="<?php echo $provincia['id_pro'] ?>"><?php echo $provincia['nombre']; ?></option>
                  <?php } ?>
                <?php } ?>
            </select>
           </div>
         </div>

         <div class="col-md-6">
          <div class="form-group">
              <label class="text-center">seleccione ciudad:</label><div class="help-block with-errors"></div>
              <select id="ciudad_emp" class="form-control" name="ciudad_emp" required>
                <option value="">Selecciona ciudad primero</option>              
            </select>
           </div>
         </div>  


        <div class="col-md-6">
            <div class="form-group">
              <label>Contraseña:</label><div class="help-block with-errors"></div>
              <input id="password" name="emp_password" type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Debe contener letra, una mayúscula mínimo y numeros' : ''); if(this.checkValidity()) form.password_two.pattern = this.value;" placeholder="Formato: me198454EjgE" class="form-control" required data-toggle="password">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
              <label>Confirmar Contraseña:</label><div class="help-block with-errors"></div>
              <input id="password_two" name="password_two" type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Por favor, ingrese la misma contraseña' : '');" placeholder="Verificar contraseña" class="form-control" required data-toggle="password">
            </div>
        </div>   
       <div class="col-md-6">
            <div class="form-group">
              <label>RUC:</label><div class="help-block with-errors"></div>
              <input id="dni" type="text" name="emp_cedula" minlength="10" maxlength="15" onkeypress="" class="form-control" aria-describedby="dniHelp" required>
            </div>
        </div>
       <div class="col-md-6">
            <div class="form-group">
              <label>Nombre de Empresa:</label><div class="help-block with-errors"></div>
              <input type="text" id="emp_nempresa" name="emp_nempresa"  class="form-control" required>
            </div>
        </div>        

       <div class="col-md-6">
            <div class="form-group">
              <label>Teléfono:</label><div class="help-block with-errors"></div>
              <input type="text" name="emp_telefono" id="emp_telefono" minlength="10" maxlength="15" onclick="numero_validate(this);"  class="form-control" required>
            </div>
        </div>        
        
        <div class="ecol-md-6" align="center">
        ¿Ya tienes una cuenta? <a href="<?php echo PUERTO."://".HOST;?>/login/">Iniciar sesión</a>
        </div>
        <br><br><br>
        <div align="left">
          <label><input type="checkbox" name="term_emp" id="terminos_emp" value="1"><a href="<?php echo PUERTO."://".HOST;?>/docs/terminos_y_condiciones.pdf" target="blank">Aceptar términos y condiciones</a></label>
        </div>
        <br>
        <div align="center">
          <input type="submit" id="button-save-emp" disabled name="btnemp" class="btn btn-primary" value="Crear Cuenta Empresarial"> 
        </div>    
      </div>
     

</form>
    </div>
  </div>
</div>
<?php } ?>



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
        <!--<div id="loading">
            <div id="loading-center">
                <div id="loading-center-absolute">
                    <div class="object" id="object_one"></div>
                    <div class="object" id="object_two"></div>
                    <div class="object" id="object_three"></div>
                    <div class="object" id="object_four"></div>
                </div>
            </div>
        </div>--><!--End off Preloader -->


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
                        <img src="<?php echo PUERTO.'://'.HOST.'/imagenes/sucursal/'.$_SESSION['mfo_datos']['sucursal']['logo']; ?>" alt="micamellologo">
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
                              <a onclick="<?php echo $optmnu["onclick"];?>" href="<?php echo $optmnu["href"];?>" <?php echo (isset($optmnu["modal"])) ? 'data-toggle="modal" data-target="#'.$optmnu["modal"].'"' : '';?>><?php echo $optmnu["nombre"];?></a>
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
<br>
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
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta name="google-site-verification" content="Hy5ewWRp0yOqH1Z_3Q59zSVffxTZDLa_T50VEoGBIBw" />
        <title>MiCamello - Portal de Empleos en Ecuador</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="og:image" content="https://www.micamello.com.ec/" />
        <link rel="icon" type="image/x-icon" href="<?php echo PUERTO."://".HOST;?>/imagenes/favicon.ico">

        <!--Google Font link-->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo PUERTO."://".HOST;?>/css/demo.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo PUERTO."://".HOST;?>/css/style.css" />
        <link href='http://fonts.googleapis.com/css?family=Alfa+Slab+One' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Boogaloo' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/assets/css/slick/slick.css"> 
        <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/assets/css/slick/slick-theme.css">
        <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/assets/css/animate.css">
        <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/assets/css/iconfont.css">
        <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/assets/css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/assets/css/magnific-popup.css">
        <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/assets/css/bootsnav.css">
        <link rel="stylesheet" type="text/css" href="<?php echo PUERTO."://".HOST;?>/css/add-style.css">

        <!--Theme custom css -->
        <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/assets/css/style.css">
        <!--<link rel="stylesheet" href="assets/css/colors/maron.css">-->

        <!--Theme Responsive css-->
        <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/assets/css/responsive.css" />
        <style type="text/css">
            .text-divider{margin: 1em 0; line-height: 0; text-align: center;}
            .text-divider span{background-color: white; padding: 1em;}
            .text-divider:before{ content: " "; display: block; border-top: 1px solid #e3e3e3; border-bottom: 1px solid #f7f7f7;}

            /*--------------dropdown--------------*/
        </style>
        <script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.23.0/sweetalert2.all.js"></script>
        <script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/jquery-1.11.2.min.js"></script>
        <script type="text/javascript">
            function success_register()
            {
                swal(
                  'Registro exitoso!',
                  'POR FAVOR, REVISE SU CORREO Y ACTIVE SU CUENTA PARA COMPLETAR SU PERFIL!',
                  'success'
                )
            }

            function error_register()
            {
                swal({
                  type: 'error',
                  title: 'Error al registrar',
                  text: 'REGISTRO DUPLICADO, POR FAVOR, REVISE Y VUELVA A INTENTARLO!'
                })
                $('#myModal').modal('show');
            }

            function error_register_emp()
            {
                swal({
                  type: 'error',
                  title: 'Error al registrar',
                  text: 'REGISTRO DUPLICADO, POR FAVOR, REVISE Y VUELVA A INTENTARLO!'
                })
                $('#myModal2').modal('show');
            }
        </script>
		

		
    </head>
	<!-- Modal -->
    <?php //include('assets/init.modal.php'); ?>

    <!--inicio de los modals-->
    <?php
//function generarCodigo($longitud) {
// $key = '';
// $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
// $max = strlen($pattern)-1;
// for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
// return $key;
//}
 
//Ejemplo de uso
 
//$token=generarCodigo(50); // genera un código de 6 caracteres de longitud.

?>

<?php 
//    require 'app/fb_init.php';
//    $helper = $fb->getRedirectLoginHelper();
//    $permissions = ['email']; // Optional permissions
//    $loginUrl = $helper->getLoginUrl('http://localhost/micamello/fb-callback.php', $permissions);
 ?>

 <?php
//    require_once "app/g_init.php";
//    $gloginURL = $gClient->createAuthUrl();
  ?>

  <!--Login instagram-->
  <?php
//    require "src/instagram/InstagramAPI.php";
    ?>

<?php if( !Modelo_Usuario::estaLogueado() ){ ?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" style="z-index:9999">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 97px;">
      <!--<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">REGISTRE SU CUENTA 
        <i class="fa fa-user" style="color: #00a885;padding: 8px;font-size: 25px;"></i></h4>
      </div>-->
      <form role="form" name="formulario" id="form_candidato" method="post">
      <div class="modal-body">
        
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
        <div class="col-md-12" id="alert_term">
          
        </div>

        <hr>
      <div class="row">
        
        <div class="col-md-12" align="center">
          <p class="center-text-line" style="font-size: 17px;">ó</p>
          <span class="text-center" style="color: grey; font-size: 15px;">o registrate con tus datos: </span><br><br>
        </div>
        <br><br>
        <div class="col-md-6">
            <div class="form-group">
              <label class="text-center">Usuario:</label>
              <small id="usernameHelp" class="form-text text-muted" style="color: red;"></small>
              <input id="username" type="text" name="username" placeholder="Carlos" class="form-control" aria-describedby="usernameHelp" required>
            </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="text-center">Correo:</label>
            <small id="correoHelp" class="form-text text-muted" style="color: red;"></small>
            <input id="correo" type="email" name="correo" placeholder="carlos@gmail.com" class="form-control" aria-describedby="correoHelp" required>
          </div>
        </div>   

        <div class="col-md-6">
            <div class="form-group">
              <label class="text-center">Nombres:</label>
              <input type="text" name="nombres" placeholder="Carlos Pedro" class="form-control" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
              <label class="text-center">Apellidos:</label>
              <input type="text" name="apellidos" placeholder="Ortiz Z" class="form-control" required>
            </div>
        </div> 

      <div class="col-md-6">
        <div class="form-group">
            <label class="text-center">seleccione provincia:</label>
            <select id="provincia" class="form-control" name="provincia" required>
              <option value="" selected disabled>Seleccione provincia</option>
        <!--SQL EXTRACT ALL PROVINCES-->
        <?php  foreach($arrprovincia as $provincia){ ?>
            <option value="<?php echo $provincia['nombre'] ?>" id="<?php echo $provincia['id_pro'] ?>"><?php echo $provincia['nombre']; ?></option>
        <?php } ?>
        <!--SQL EXTRACT ALL PROVINCES-->
          </select>
         </div>
         </div>    

         <div class="col-md-6">
          <div class="form-group">
              <label class="text-center">seleccione ciudad:</label>
              <select id="ciudad" class="form-control" name="ciudad" required>
                <option value="">Selecciona ciudad primero</option>
          <!--SQL EXTRACT ALL PROVINCES-->
          <!--SQL EXTRACT ALL PROVINCES-->
            </select>
           </div>
         </div>      

        <div class="col-md-6">
            <div class="form-group">
              <label class="text-center">Contraseña:</label>
              <input id="password" name="password" type="password" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Debe tener al menos 6 caracteres' : ''); if(this.checkValidity()) form.password_two.pattern = this.value;" placeholder="Contraseña" class="form-control" required data-toggle="password">
            </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="text-center">Confirmar Contraseña:</label>
            <input id="password_two" name="password_two" type="password" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Por favor, ingrese la misma contraseña que se indica arriba' : '');" placeholder="Verificar contraseña" class="form-control" required data-toggle="password">
          </div>
        </div>   

     <div class="col-md-6">
            <div class="group">
              <div class="form-group">
                <label class="text-center">Cédula / Pasaporte:</label><br>
                <small id="dniHelp" class="form-text text-muted" style="color: red;"></small>
                <input id="dni" type="text" name="cedula"  class="form-control" aria-describedby="dniHelp" required>
              </div>
            </div>
        </div>

       <div class="col-md-6">
            <div class="form-group">
              <label class="text-center">Teléfono:</label>
              <input type="text" name="telefono"  class="form-control" required>
            </div>
        </div>
         <div class="col-md-6">
            <div class="form-group">
              <label class="text-center">Áreas de Interes:</label><br>
              <select id="intereses" name="intereses[]" multiple class="form-control" required>
                  <?php
                  foreach($intereses as $interes){
                      $id_ma=$interes['id_intereses'];
                      echo "<label><option type='checkbox' id='option$id_ma' value='$id_ma' class='single-checkbox1'>".$interes['nombre']."</option></label>";
                  }
                 ?>

              </select> 
            </div> 
          
        <br>
        </div>
       <div class="col-md-6">
            <div class="form-group">
              <label class="text-center">Nivel de Interés: <span style="color: gray; font-size: 10px;">(Escoga dos opciones)</span></label><br>

              <div class="form-group">
                  <select class="form-control" id="nivel" multiple name="niveles[]" required>
                    <label><option type="checkbox" name="" id="option1" class="single-checkbox" value='1'>Cargos gerenciales</option></label><br>
                    <label><option type="checkbox" name="" id="option2" class="single-checkbox" value='2'>Cargos medios</option></label><br>
                    <label><option type="checkbox" name="" id="option3" class="single-checkbox" value='3'>Cargos básicos</option></label>
                  </select>
              
            </div> 
             
            </div>
        </div>
        
        
        <!--<div id="form_student" class="animate_panel" style="display: none;">
          <div class="col-md-6">
            <div class="form-group">
              <label>Seleccione Universidad</label>
              <select class="form-control" name="university_user" id="university_user">
                <option value="" selected disabled>Seleccione Universidad</option>
                <?php 
                  //$select_university = mysqli_query($db, "SELECT * FROM mfo_universidades");
                  //while ($row = mysqli_fetch_assoc($select_university)) {
                    ?>
                      <option value="<?php //echo $row['id_universidad'] ?>"><?php //echo $row['nombre']; ?></option>
                    <?php
                  //}
                 ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Ingrese código</label>
              <input type="text" name="code_asign" id="code_asign" class="form-control" placeholder="ejemplo: 0000-000">
            </div>
          </div> 
        </div>-->       
           
      </div>


<div class="" align="left">
  <label><input type="checkbox" name="term_cond" id="terminos" value="1"><a href="<?php echo PUERTO."://".HOST;?>/docs/terminos_y_condiciones.pdf" target="blank">Aceptar términos y condiciones </a><i id="verify_check" style="display: none;"><img src="http://bestanimations.com/Signs&Shapes/Arrows/Left/left-arrow-16.gif" width="40px"></i></label>
</div>
<div class="row">
  <div class="text-center">
    <input id="button-save" disabled type="submit" name="btnusu" class="btn btn-primary" value="Crear Cuenta">  
  </div> 
  
</div>
<div class="row">
  <div class="col-md-12"><br>
    <p class="text-center"><strong>¿Ya tienes cuenta? </strong><a href="<?php echo PUERTO."://".HOST;?>/login/">Iniciar sesión</a></p> 
  </div>
</div>

      </div>
    </form>
     


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
              <label>Usuario:</label>
              <small id="username_empHelp" class="form-text text-muted" style="color: red;"></small>
              <input type="text" id="emp_username" name="emp_username" placeholder="carlosp" class="form-control" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
              <label>Correo:</label>
              <small id="correo_empHelp" class="form-text text-muted" style="color: red;"></small>
              <input type="email" id="emp_correo" name="emp_correo" placeholder="carlosp@gmail.com" class="form-control" required>
            </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
              <label class="text-center">seleccione provincia:</label>
              <select id="provincia_emp" class="form-control" name="provincia_emp" required>
                <option value="" selected disabled>Seleccione provincia</option>
          <!--SQL EXTRACT ALL PROVINCES-->
          <?php foreach($arrprovincia as $provincia) { ?>
              <option value="<?php echo $provincia['nombre'] ?>" id="<?php echo $provincia['id_pro'] ?>"><?php echo $provincia['nombre']; ?></option>
          <?php } ?>
          <!--SQL EXTRACT ALL PROVINCES-->
            </select>
           </div>
         </div>

         <div class="col-md-6">
          <div class="form-group">
              <label class="text-center">seleccione ciudad:</label>
              <select id="ciudad_emp" class="form-control" name="ciudad_emp" required>
                <option value="">Selecciona ciudad primero</option>
          <!--SQL EXTRACT ALL PROVINCES-->
          <!--SQL EXTRACT ALL PROVINCES-->
            </select>
           </div>
         </div>  


        <div class="col-md-6">
            <div class="form-group">
              <label>Contraseña:</label>
              <input type="password" name="emp_password" id="password"  class="form-control" required data-toggle="password">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
              <label>Confirmar Contraseña:</label>
              <input type="password" name="emp_password2" id="confirm_password" class="form-control" required data-toggle="password">
            </div>
        </div>   
       <div class="col-md-6">
            <div class="form-group">
              <label>RUC:</label>
              <small id="ruc_empHelp" class="form-text text-muted" style="color: red;"></small>
              <input type="number" id="emp_cedula" name="emp_cedula"  class="form-control" required>
            </div>
        </div>
       <div class="col-md-6">
            <div class="form-group">
              <label>Nombre de Empresa:</label>
              <small id="name_empHelp" class="form-text text-muted" style="color: red;"></small>
              <input type="text" id="emp_nempresa" name="emp_nempresa"  class="form-control" required>
            </div>
        </div>        

       <div class="col-md-6">
            <div class="form-group">
              <label>Teléfono:</label>
              <input type="text" name="emp_telefono"  class="form-control" required>
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

        <input type="hidden" name="" id="sessionvar" value="<?php //echo $login_session ?>">
        <!-- Preloader -->
        <div id="loading">
            <div id="loading-center">
                <div id="loading-center-absolute">
                    <div class="object" id="object_one"></div>
                    <div class="object" id="object_two"></div>
                    <div class="object" id="object_three"></div>
                    <div class="object" id="object_four"></div>
                </div>
            </div>
        </div><!--End off Preloader -->


        <div class="culmn">
            <!--Home page style-->

   <style type="text/css">
    section#action {
    height: 64px;
    padding-top: 8px;
}
</style>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<nav class="navbar navbar-default bootsnav navbar-fixed">
<?php 
    /*$sesr = mysqli_query($db,"SELECT id_res FROM mfo_respuestas WHERE test='3' and estado='FINAL3' and id_usuario=$id_usuario");
    $rec = mysqli_fetch_array($sesr,MYSQLI_ASSOC);
    $ff1=$rec['id_res'];

    $sesr1 = mysqli_query($db,"SELECT * FROM mfo_respuestas WHERE test='3' and estado='INICIADA' and id_usuario=$id_usuario");
    $rec1 = $sesr1->num_rows;
    

    $sesr2 = mysqli_query($db,"SELECT * FROM mfo_respuestas WHERE test='2' and estado='FINAL2' and id_usuario=$id_usuario");
    $rec2 = $sesr2->num_rows;*/
 ?>
               
                <!-- Start Top Search -->
                <div class="top-search">
                    <div class="container">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="text" class="form-control" placeholder="Search">
                            <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
                        </div>
                    </div>
                </div>
                <!-- End Top Search -->

                <div class="container">                    
                    <!-- Start Header Navigation -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                            <i class="fa fa-bars"></i>
                        </button>
                        <a class="navbar-brand" href="index.php">
                            <img src="<?php echo PUERTO."://".HOST;?>/images/blanco.png" class="logo" 
              style="width:35%; margin-top:-35px" alt="">
                            <!--<img src="assets/images/footer-logo.png" class="logo logo-scrolled" alt="">-->
                        </a>

                    </div>
                    <!-- End Header Navigation -->
                    <div class="collapse navbar-collapse" id="navbar-menu">
                        <ul class="nav navbar-nav navbar-right">
                          <?php foreach($menu as $optmnu){ ?>
                            <li>
                              <a href="<?php echo $optmnu["href"];?>" <?php echo (isset($optmnu["modal"])) ? 'data-toggle="modal" data-target="#'.$optmnu["modal"].'"' : '';?>><?php echo $optmnu["nombre"];?></a>
                            </li>                                                
                          <?php }?>
                          <?php if (isset($menu["submenu"])){ ?>                            
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['mfo_datos']['usuario']['nombres']; ?> 
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
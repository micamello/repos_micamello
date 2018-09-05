<?php
define('HOST', 'localhost/repos_micamello');
define('PUERTO', 'http');
define('FRONTEND_RUTA', 'C:/wamp64/www/repos_micamello/');
define('DBSERVIDOR', 'localhost');
define('DBUSUARIO', 'root'); 
define('DBNOMBRE', 'micamello_base');
define('DBCLAVE', '');     
define('RUTA_INCLUDES', FRONTEND_RUTA.'includes/');
define('RUTA_FRONTEND', FRONTEND_RUTA.'frontend/'); 
define('RUTA_VISTA', FRONTEND_RUTA.'frontend/Vista/');
define('TOKEN', 'token.micamello.ecuador');
define('HORAS_VALIDO_PASSWORD', '24');
define('MAIL_CORREO','support@micamello.com.ec');
define('MAIL_NOMBRE','Mi Camello');
define('MAIL_USERNAME','micamelloecuador@gmail.com');
define('MAIL_PASSWORD','ecuador2018');
define('MAIL_PORT','587');
define('MAIL_HOST','smtp.gmail.com');
define('KEY_ENCRIPTAR','micamelloecuador');
define('PESO_IMAGEN','1000000');
define('PESO_ARCHIVO','2000000');
define('PATH_PROFILE',FRONTEND_RUTA.'imagenes/usuarios/profile/');
define('PATH_ARCHIVO',FRONTEND_RUTA.'imagenes/usuarios/hv/');
define('CLASES_ESTATUS',array('1'=>'alert-success','2'=>'alert-danger','3'=>'alert-warning'));
define('ESTADOS',array('1'=>'Activo','0'=>'Inactivo'));
define('MAIL_SUGERENCIAS','micamelloecuador@gmail.com');

define('DISCAPACIDAD', array('0'=>'No', '1'=>'S&iacute;'));
define('STATUS_CARRERA', array('1'=>'Estudiante', '2'=>'Graduado'));
define('POSTULACIONES', array('2'=>'Manual', '1'=>'Autom&aacute;tico'));
define('GENERO', array('M'=>'Masculino', 'F'=>'Femenino', 'P'=>'Prefiero no decirlo'));
define('PRIORIDAD', array('1'=>'Gratuito', '2'=>'Pagado'));
define('SALARIO', array('1'=>'Menos de 341', '2'=>'M&aacute;s de 341', '3'=>'M&aacute;s de 700'));
define('FECHA_POSTULADO', array('1'=>'Hoy', '2'=>'&Uacute;ltimos 3 d&iacute;as', '3'=>'&Uacute;ltima semana', '4'=>'&Uacute;ltimo mes'));
define('CALCULAR_FECHA', array('1'=>'', '2'=>'-3DIAS', '3'=>'-1SEMANA', '4'=>'-1MES'));
define('MESES', array('01'=>'Enero', '02'=>'Febrero', '03'=>'Marzo', '04'=>'Abril','05'=>'Mayo', '06'=>'Junio', '07'=>'Julio', '08'=>'Agosto','09'=>'Septiembre', '10'=>'Octubre', '11'=>'Noviembre', '12'=>'Diciembre'));
define('ANOSEXP', array('1'=>'Sin Experiencia', '2'=>'1 - 3 a&ntilde;os', '3'=>'4 - 6 a&ntilde;os', '4'=>'7 - 10 a&ntilde;os', '5'=>'M&aacute;s de 10 a&ntilde;os'));
define('REGISTRO_PAGINA',10);

?>
<?php
//define('HOST', 'localhost/repos_micamello');
define('PUERTO', 'http');
define('FRONTEND_RUTA', 'C:/wamp64/www/repos_micamello/');
define('DBSERVIDOR', 'localhost');
define('DBUSUARIO', 'root'); 
define('DBNOMBRE', 'micamello_desarrollo2');
define('DBCLAVE', '');     
define('RUTA_INCLUDES', FRONTEND_RUTA.'includes/');
define('RUTA_FRONTEND', FRONTEND_RUTA.'frontend/'); 
define('RUTA_VISTA', FRONTEND_RUTA.'frontend/Vista/');
define('TOKEN', 'token.micamello.ecuador');
define('HORAS_VALIDO_PASSWORD', '24');
define('MAIL_CORREO','info@micamello.com.ec');
define('MAIL_NOMBRE','Mi Camello');
define('MAIL_USERNAME','info@micamello.com.ec');
define('MAIL_PASSWORD','bXKX695=ukC@');
define('MAIL_PORT','587');
define('MAIL_HOST','mail.micamello.com.ec');
define('KEY_ENCRIPTAR','micamelloecuador');
define('PESO_IMAGEN','1000000');
define('PESO_ARCHIVO','2000000');
define('PATH_PROFILE',FRONTEND_RUTA.'imagenes/usuarios/profile/');
define('PATH_ARCHIVO',FRONTEND_RUTA.'imagenes/usuarios/hv/');
define('CLASES_ESTATUS',array('1'=>'alert-success','2'=>'alert-danger','3'=>'alert-warning'));
define('ESTADOS',array('1'=>'Activo','0'=>'Inactivo'));
define('MAIL_SUGERENCIAS','info@micamello.com.ec');
define('PATH_COMPROBANTE',FRONTEND_RUTA.'imagenes/usuarios/comprobante/');
define('STATUS_CARRERA', array('1'=>'Estudiante', '2'=>'Graduado'));
define('POSTULACIONES', array('2'=>'Manual', '1'=>'Autom&aacute;tico'));
define('GENERO', array('M'=>'Masculino', 'F'=>'Femenino', 'P'=>'Prefiero no decirlo'));
define('VALOR_GENERO', array('M'=>'1', 'F'=>'2', 'P'=>'3'));
define('PRIORIDAD', array('1'=>'Plan Gratuito', '2'=>'Plan Pagado'));
define('ESTATUS_OFERTA', array('1'=>'Contratado', '2'=>'No contratado', '3'=>'En proceso'));
define('SALARIO', array('1'=>'Menos de 386', '2'=>'Entre 386 y 700', '3'=>'Entre 700 y 1200', '4'=>'M&aacute;s de 1200'));
define('FECHA_POSTULADO', array('1'=>'Hoy', '2'=>'&Uacute;ltimos 3 d&iacute;as', '3'=>'&Uacute;ltima semana', '4'=>'&Uacute;ltimo mes'));
define('CALCULAR_FECHA', array('1'=>'', '2'=>'-3DIAS', '3'=>'-1SEMANA', '4'=>'-1MES'));
define('MESES', array('01'=>'Enero', '02'=>'Febrero', '03'=>'Marzo', '04'=>'Abril','05'=>'Mayo', '06'=>'Junio', '07'=>'Julio', '08'=>'Agosto','09'=>'Septiembre', '10'=>'Octubre', '11'=>'Noviembre', '12'=>'Diciembre'));
define('ANOSEXP', array('1'=>'Sin Experiencia', '2'=>'1 - 3 a&ntilde;os', '3'=>'4 - 6 a&ntilde;os', '4'=>'7 - 10 a&ntilde;os', '5'=>'M&aacute;s de 10 a&ntilde;os'));
define('REGISTRO_PAGINA',10);
define('RUTA_PAYPAL','https://www.sandbox.paypal.com/cgi-bin/webscr');
define('REQUISITO', array('0'=>'No', '1'=>'S&iacute;'));
define('ESTADO_CIVIL',array('1'=>'Soltero(a)', '2'=>'Casado(a)', '3'=>'En union', '4'=>'Divorciado(a)','5'=>'Viudo(a)'));
define('CRON_RUTA',FRONTEND_RUTA.'cron/');
define('DIAS_AUTOPOSTULACION','3');
define('AUTOPOSTULACION_MIN','5');
define('TIPO_DOCUMENTO', array('1'=>'RUC','2'=>'CÉDULA','3'=>'PASAPORTE'));
define('DOCUMENTACION', array('2'=>'CÉDULA', '3'=>'PASAPORTE'));
define('APP_ID', '706585049706744');
define('APP_SECRET', '247391a884159a515d149502b0f56aba');
?>
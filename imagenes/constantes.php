<?php
define('HOST', 'www.micamello.com.ec/cuestionario');
define('SUCURSAL_ID','1');
define('SUCURSAL_ICONO','png');
define('SUCURSAL_LOGO','png');
define('SUCURSAL_PAISID','39');
define('SUCURSAL_MONEDA','1');
define('SUCURSAL_ISO','EC');
define('PUERTO', 'https');
define('FRONTEND_RUTA', '/home/micamellocomec/public_html/cuestionario/');
define('DBSERVIDOR', 'localhost');
define('DBUSUARIO', 'micamell_root'); 
define('DBNOMBRE', 'micamell_desarrollo2');
define('DBCLAVE', '[K3}Jim;[h)m');     
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
define('ESTADO_CIVIL',array('1'=>'Soltero(a)', '2'=>'Unión libre', '3'=>'Casado(a)', '4'=>'Separado(a)','5'=>'Divorciado(a)','6'=>'Viudo(a)','7'=>'Otro'));
define('CRON_RUTA',FRONTEND_RUTA.'cron/');
define('DIAS_AUTOPOSTULACION','3');
define('AUTOPOSTULACION_MIN','5');
define('TIPO_DOCUMENTO', array('1'=>'RUC','2'=>'CÉDULA','3'=>'PASAPORTE'));
define('DOCUMENTACION', array('2'=>'CÉDULA', '3'=>'PASAPORTE'));
define('EDAD', array('1'=>'Entre 18 y 20 a&ntilde;os', '2'=>'Entre 20 y 30 a&ntilde;os','3'=>'Entre 30 y 40 a&ntilde;os','4'=>'Entre 40 y 50 a&ntilde;os','5'=>'M&aacute;s de 50 a&ntilde;os'));
define('OPCIONES',array('a','b','c','d','e'));

// método de selección
define('METODO_SELECCION', array('1'=>array(
										'Esta opción le permitirá dar doble clip para seleccionar la respuesta, tome en cuenta que el 1  es la opción  con la que más se siente identificado y 5 la opción con la que menos se siente identificado.'
									), '2'=>array(
										'Esta opción le permitirá seleccionar y arrastrar la respuesta; tome en cuenta que la opción 1 es la opción con la que más se siente identificado y la opción 5 la opción con la que menos se siente identificado.', ''
									)));

// facebook
define('FB_ID_CLIENTE', '2148107835439054');
define('FB_CLIENTE_SECRET', 'cac4885b9285bde2975216f6a26f69a9');

// twitter
define('CONSUMER_KEY', 's7ac5g54J6UDY5CLw3GAmIUbq');
define('CONSUMER_SECRET', '0tBkfO1NhUSq2CrefAKkI1wZqmUFJbdM7ugBCX48NOY4UwFOwU');
define('ACCESS_TOKEN', '1055523335109533696-nCq3bDsm4J4EJzo6PMnbRknuDGqKha');
define('ACCESS_TOKEN_SECRET', 'u37zWlOowuE3bo6GxKORUaQpWy5b39H6cNTalRxuydsTO');
define('OAUTH_CALLBACK', 'https://www.micamello.com.ec/desarrollov2/twitter.php?tipo_usuario=1');

// google
define('G_ID_CLIENTE', '286913321702-08b89odiboi5us5kvuj2tckskmhk7bg4.apps.googleusercontent.com');
define('G_SECRET', '6e9oTU5JXCL9KbiR8qhX-1sf');

// linkedin
define('LK_ID_CLIENTE', '78mhxodb8c3yih');
define('LK_SECRET', 'pWZA5w3DS9NGHG3c');
define("LK_REDIRECT_URI", "https://www.micamello.com.ec/desarrollov2/linkedin.php");
define("LK_SCOPE", 'r_basicprofile r_emailaddress');
?>
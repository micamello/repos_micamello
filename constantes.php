<?php
//define('HOST', 'localhost/repos_micamello');
define('PUERTO', 'http');
define('FRONTEND_RUTA', 'C:/wamp64/www/repos_micamello/');
define('DBSERVIDOR', 'localhost');
define('DBUSUARIO', 'root'); 
define('DBNOMBRE', 'micamell_desarrollo3');
define('DBCLAVE', '');     
define('RUTA_INCLUDES', FRONTEND_RUTA.'includes/');
define('RUTA_FRONTEND', FRONTEND_RUTA.'frontend/'); 
define('RUTA_VISTA', FRONTEND_RUTA.'frontend/Vista/');
define('RUTA_ADMIN', FRONTEND_RUTA.'admin');
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
// define('MAIL_SUGERENCIAS','info@micamello.com.ec');
define('MAIL_SUGERENCIAS','evpozo@gmail.com');
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
define('METODO_CUESTIONARIO',array('0'=>'Preguntas ordenadas','1'=>'Preguntas aleatorias'));

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
define('G_SECRET', 'dkpJFubkmGyTHXx3gjptqcCf');

// linkedin
define('LK_ID_CLIENTE', '78mhxodb8c3yih');
define('LK_SECRET', 'pWZA5w3DS9NGHG3c');
define("LK_REDIRECT_URI", "https://www.micamello.com.ec/desarrollov2/linkedin.php");
define("LK_SCOPE", 'r_basicprofile r_emailaddress');




// CORREOS_TEMPLATES
// REGISTRO MANUAL
const TAGS_REPLACE_T1 = array("%NOMBRE%", "%NOMBRE_USUARIO%", "%URL_BOTON%", "%TEXTO_BOTON%");
//REGISTRO RED SOCIAL
const TAGS_REPLACE_T2 = array("%NOMBRE%", "%NOMBRE_USUARIO%", "%URL_BOTON%", "%TEXTO_BOTON%", "%CORREO%", "%PASSWORD%");
// AVISO CREACION
const TAGS_REPLACE_T3 = array("%NOMBRE%", "%NOMBRE_USUARIO%", "%CORREO%", "%PASSWORD%");
// RECUPERAR CONTRASEÑA
const TAGS_REPLACE_T4 = array("%NOMBRE%", "%URL_BOTON%", "%TEXTO_BOTON%");
// PRE_REGISTRO ACTIVACION CUENTA USUARIO
const TAGS_REPLACE_T5 = array("%NOMBRE%", "%NOMBRE_USUARIO%", "%URL_BOTON%", "%TEXTO_BOTON%", "%CORREO%", "%PASSWORD%");
// ERROR CRON PRE_REGISTRO
const TAGS_REPLACE_T6 = array("%MENSAJE_ERROR%");
// RECOMENDACIONES
const TAGS_REPLACE_T7 = array("%NOMBRE_DEST%", "%NOMBRE_USUARIO_SUGERENCIA%", "%MENSAJE_SUGERENCIA%", "%CORREO%", "%TELEFONO%");
//ERROR_GENERAL
const TAGS_REPLACE_T8 = array("%MENSAJE_ERROR%", "%CABECERA%", "%LOGO_TIPO_MENSAJE%");
// AUTOPOSTULACIONES------------ALERTAS_OFERTAS
const TAGS_REPLACE_T9 = array("%NOMBRE%", "%MENSAJE%", "%CABECERA%", "%LOGO_TIPO_MENSAJE%", "%CONTENIDO%");
// CANCELAR_PLANES
const TAGS_REPLACE_T10 = array("%CABECERA%", "%LOGO_TIPO_MENSAJE%", "%NOMBRE%", "%NOMBRE_PLAN%", "%FECHA_PLAN%");
// MENSAJE_GENERAL
const TAGS_REPLACE_T11 = array("%CABECERA%", "%LOGO_TIPO_MENSAJE%", "%MENSAJE%");
// print_r(TAGS_REPLACE_T1);
// CEBECERAS
define('TIPO', 	array(
						'eliminar_oferta'=>array(
												'asunto'=>'Error con Cron de eliminación oferta', 
												'logo'=>'https://cdn4.iconfinder.com/data/icons/gradient-ui-1/512/error-512.png', 
												'cabecera'=>'Error Cron Eliminar Ofertas'
												),
						'promocion_planes'=>array(
												'asunto'=>'Error con Cron de Promocion Planes', 
												'logo'=>'https://cdn4.iconfinder.com/data/icons/gradient-ui-1/512/error-512.png', 
												'cabecera'=>'Error Cron Promocion Planes'
												),
						'autopostulacion'=>array(
												'asunto'=>'Notificación autopostulaciones a ofertas', 
												'logo'=>'https://cdn3.iconfinder.com/data/icons/finance-152/64/41-512.png', 
												'cabecera'=>'Notificación autopostulaciones',
												'contenido'=>'Le confirmamos su autopostulaci&oacute;n a las siguientes ofertas:'
												),
						'alerta_oferta'=>array(
												'asunto'=>'Ofertas laborales recomendadas', 
												'logo'=>'https://cdn4.iconfinder.com/data/icons/ios-web-user-interface-multi-circle-flat-vol-2/512/Alert_bell_notification_education_Christmas_bell_church_bell_ring-512.png', 
												'cabecera'=>'Ofertas Laborales',
												'contenido'=>'Le informamos las siguientes ofertas que se ajustan a su perfil:'
												),
						'cancelacion_plan'=>array(
												'cabecera'=>"Caducidad de plan contratado",
												'asunto'=>'Cancelación de plan', 
												'logo'=>'https://cdn0.iconfinder.com/data/icons/twitter-ui-flat/48/Twitter_UI-11-512.png'
												),
						'registro_error'=>array(
												'asunto'=>'Error Cron Cancelar Planes', 
												'logo'=>'https://cdn4.iconfinder.com/data/icons/gradient-ui-1/512/error-512.png', 
												'cabecera'=>'Error en registro candidato'
												),
						'cron_paypal_data'=>array(
												'asunto'=>'Cron Paypal', 
												'logo'=>'https://cdn0.iconfinder.com/data/icons/streamline-emoji-1/48/092-robot-face-1-512.png', 
												'cabecera'=>'Mensaje CRON PAYPAL'
												),
						'error_cron_paypal'=>array(
												'asunto'=>'',
												'logo'=>'https://cdn0.iconfinder.com/data/icons/streamline-emoji-1/48/093-robot-face-2-512.png', 
												'cabecera'=>'Mensaje Error CRON PAYPAL'
												),
						'cron_paypal_planes'=>array(
												'asunto'=>'Cron planes_paypal.php',
												'logo'=>'https://cdn4.iconfinder.com/data/icons/file-documents-vol-3/128/file_documents-20-512.png', 
												'cabecera'=>'Notificación CRON PAYPAL'
												),
						'notificaciones'=>array(
												'asunto'=>'',
												'logo'=>'https://cdn4.iconfinder.com/data/icons/gradient-ui-1/512/error-512.png', 
												'cabecera'=>'Mensaje Cancelación de Subscripción'
												)
					)
		);
?>
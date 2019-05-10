<?php
//define('HOST', 'localhost/repos_micamello');
define('PUERTO', 'http');
define('FRONTEND_RUTA', 'C:/wamp64/www/repos_micamello/');
define('DBSERVIDOR', 'localhost');
define('DBUSUARIO', 'root'); 
define('DBNOMBRE', 'base_fer');
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
define('MAIL_SUGERENCIAS','desarrollo@micamello.com.ec');
define('PATH_COMPROBANTE',FRONTEND_RUTA.'imagenes/usuarios/comprobante/');
define('STATUS_CARRERA', array('1'=>'Estudiante', '2'=>'Graduado'));
define('POSTULACIONES', array('2'=>'Manual', '1'=>'Autom&aacute;tico'));
define('GENERO', array('M'=>'Masculino', 'F'=>'Femenino', 'P'=>'Prefiero no decirlo'));
define('VALOR_GENERO', array('M'=>'1', 'F'=>'2', 'P'=>'3'));
define('PRIORIDAD', array('1'=>'Informe Parcial', '2'=>'Informe Completo'));
define('ESTATUS_OFERTA', array('1'=>'Contratado', '2'=>'No contratado', '3'=>'En proceso'));
define('SALARIO', array('1'=>'Menos de 386', '2'=>'Entre 386 y 700', '3'=>'Entre 700 y 1200', '4'=>'M&aacute;s de 1200'));
define('EDADES', array('1'=>'18 a 25 A&ntilde;os', '2'=>'25 a 35 A&ntilde;os', '3'=>'35 a 45 A&ntilde;os', '4'=>'M&aacute;s de 45 a&ntilde;os'));
define('FACEBOOK', 'https://es-la.facebook.com/MiCamello.com.ec/');
define('TWITTER', 'https://twitter.com/MiCamelloec');
define('INSTAGRAM', 'https://www.instagram.com/micamelloec/');

define('NRO_TRABAJADORES', array('1'=>'De 1 a 10 trabajadores', '2'=>'De 11 a 50 trabajadores', '3'=>'De 51 a 200 trabajadores', '4'=>'De 201 a 500 trabajadores','5'=>'De 501 a 1000 trabajadores','6'=>'M&aacute;s de 1000 trabajadores'));

define('FECHA_POSTULADO', array('1'=>'Hoy', '2'=>'&Uacute;ltimos 3 d&iacute;as', '3'=>'&Uacute;ltima semana', '4'=>'&Uacute;ltimo mes'));
define('CALCULAR_FECHA', array('1'=>'', '2'=>'-3DIAS', '3'=>'-1SEMANA', '4'=>'-1MES'));
define('MESES', array('01'=>'Enero', '02'=>'Febrero', '03'=>'Marzo', '04'=>'Abril','05'=>'Mayo', '06'=>'Junio', '07'=>'Julio', '08'=>'Agosto','09'=>'Septiembre', '10'=>'Octubre', '11'=>'Noviembre', '12'=>'Diciembre'));
define('PUEDE_VIAJAR',array('1'=>'S&iacute;','2'=>'No'));
define('TIENE_TRABAJO',array('1'=>'S&iacute;','2'=>'No'));
define('TIENE_LICENCIA',array('1'=>'S&iacute;','2'=>'No'));
define('DISCAPACIDAD',array('1'=>'S&iacute;','2'=>'No'));

//este filtro sirve para colocar por defecto el filtro de las areas y subareas del candidato o sin filtro
//Para el 0 no se aplican los filtros y para 1 si se aplican 
//define('FILTRO_PREFERENCIAS_DEFAULT',0);

define('ANOSEXP', array('1'=>'Sin Experiencia', '2'=>'1 - 3 a&ntilde;os', '3'=>'4 - 6 a&ntilde;os', '4'=>'7 - 10 a&ntilde;os', '5'=>'M&aacute;s de 10 a&ntilde;os'));

define('REGISTRO_PAGINA',20);
define('RUTA_PAYPAL','https://www.sandbox.paypal.com/cgi-bin/webscr');
define('REQUISITO', array('0'=>'No', '1'=>'S&iacute;'));
define('ESTADO_CIVIL',array('1'=>'Soltero(a)', '2'=>'Unión libre', '3'=>'Casado(a)', '4'=>'Separado(a)','5'=>'Divorciado(a)','6'=>'Viudo(a)','7'=>'Otro'));
define('CRON_RUTA',FRONTEND_RUTA.'cron/');
define('DIAS_AUTOPOSTULACION','3');
define('AUTOPOSTULACION_MIN','5');
define('TIPO_DOCUMENTO', array('1'=>'RUC','2'=>'CÉDULA','3'=>'PASAPORTE'));
define('DOCUMENTACION', array('2'=>'Cédula', '3'=>'Pasaporte'));
define('EDAD', array('1'=>'Entre 18 y 20 a&ntilde;os', '2'=>'Entre 20 y 30 a&ntilde;os','3'=>'Entre 30 y 40 a&ntilde;os','4'=>'Entre 40 y 50 a&ntilde;os','5'=>'M&aacute;s de 50 a&ntilde;os'));
define('OPCIONES',array('a','b','c','d','e'));
define('METODO_CUESTIONARIO',array('0'=>'Preguntas ordenadas','1'=>'Preguntas aleatorias'));
define('DIVISIBLE_BLOQUE','12');
define('DIVISIBLE_FILA','6');
// método de selección
define('METODO_SELECCION', array('1'=>array(
										'Esta opción le permitirá dar doble clip para seleccionar la respuesta, tome en cuenta que el 1  es la opción  con la que más se siente identificado y 5 la opción con la que menos se siente identificado.'
									), '2'=>array(
										'Esta opción le permitirá seleccionar y arrastrar la respuesta; tome en cuenta que la opción 1 es la opción con la que más se siente identificado y la opción 5 la opción con la que menos se siente identificado.', ''
									)));

define('AREASPERMITIDAS', '3');
define('VALORES_ORDENAMIENTO', array('100','1000'));

//FACTURACION ELECTRONICA
define('WS_SRI_RECEPCION','https://celcer.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl');
define('WS_SRI_AUTORIZACION','https://celcer.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl');

//PAYME
define('PAYME_ACQUIRERID','237');
define('PAYME_IDCOMMERCE','10030');
define('PAYME_SECRET_KEY','MGvMqSVsEyLDxRJHkL.39434899322');
define('PAYME_CURRENCY_CODE','840');
define('PAYME_WS','https://integracion.alignetsac.com/WALLETWS/services/WalletCommerce?wsdl');

// facebook
define('FB_ID_CLIENTE', '2148107835439054');
define('FB_CLIENTE_SECRET', 'cac4885b9285bde2975216f6a26f69a9');

// twitter
define('CONSUMER_KEY', 'gJH5LuLrlmEIWGWtXm9S7A0o7');
define('CONSUMER_SECRET', 'JdEcME5eRfbnNcjMMkkB1OdvXKmdGOyDVpSx01SvhUTiwAuscQ');
define('ACCESS_TOKEN', '1055523335109533696-f1gHlquih3kjXPWzsIxnCJWgqaYuLF');
define('ACCESS_TOKEN_SECRET', 'zyYUWeicNZDVbwQvDD4N7HYXEr2xep2m5VgrbY9RPbRr0');
// define('OAUTH_CALLBACK', 'https://www.micamello.com.ec/desarrollov3/twitter.php');

// google
define('G_ID_CLIENTE', '267500430223-s19h2gid1va7d1t7vm7e29cddnd03aav.apps.googleusercontent.com');
define('G_SECRET', '1dwFr9eQ_OOiGGCaoUvBLFYh');

// linkedin
define('LK_ID_CLIENTE', '78mhxodb8c3yih');
define('LK_SECRET', 'pWZA5w3DS9NGHG3c');
// define("LK_REDIRECT_URI", "https://www.micamello.com.ec/desarrollov2/linkedin.php");
define("LK_SCOPE", 'r_basicprofile r_emailaddress');

// CORREOS_TEMPLATES
// REGISTRO MANUAL
/*const TAGS_REPLACE_T1 = array("%NOMBRE%", "%NOMBRE_USUARIO%", "%URL_BOTON%", "%TEXTO_BOTON%");
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
		);*/
?>
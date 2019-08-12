<?php
//define('HOST', 'localhost/repos_micamello');
define('PUERTO', 'http');
define('FRONTEND_RUTA', 'C:/wamp64/www/repos_micamello/');
define('DBSERVIDOR', 'localhost');
define('DBUSUARIO', 'root');
define('DBNOMBRE', 'produccion_cambios');
define('DBCLAVE', '');     
define('RUTA_INCLUDES', FRONTEND_RUTA.'includes/');
define('RUTA_FRONTEND', FRONTEND_RUTA.'frontend/'); 
define('RUTA_VISTA', FRONTEND_RUTA.'frontend/Vista/');
define('RUTA_ADMIN', FRONTEND_RUTA.'admin');
define('TOKEN', 'token.micamello.ecuador');
define('HORAS_VALIDO_PASSWORD', '24');
define('MAIL_CORREO','noresponder@micamello.com.ec');
define('MAIL_NOMBRE','Mi Camello');
define('MAIL_USERNAME','noresponder@micamello.com.ec');
define('MAIL_PASSWORD','tmh!efKO=72@');
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
define('SALARIO', array('1'=>'Menos de 394', '2'=>'Entre 394 y 700', '3'=>'Entre 700 y 1200', '4'=>'M&aacute;s de 1200'));
define('EDADES', array('1'=>'18 a 25 A&ntilde;os', '2'=>'25 a 35 A&ntilde;os', '3'=>'35 a 45 A&ntilde;os', '4'=>'M&aacute;s de 45 a&ntilde;os'));
define('FACEBOOK', 'https://www.facebook.com/MiCamello.com.ec/');
define('TWITTER', 'https://twitter.com/MiCamelloec');
define('INSTAGRAM', 'https://www.instagram.com/micamelloec/');
define('LINKEDIN','https://www.linkedin.com/company/mi-camello-s-a/');
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
define('TIPO_DOCUMENTO', array('1'=>'Ruc','2'=>'Cédula','3'=>'Pasaporte'));
define('DOCUMENTACION', array('2'=>'Cédula', '3'=>'Pasaporte'));
define('EDAD', array('1'=>'Entre 18 y 20 a&ntilde;os', '2'=>'Entre 20 y 30 a&ntilde;os','3'=>'Entre 30 y 40 a&ntilde;os','4'=>'Entre 40 y 50 a&ntilde;os','5'=>'M&aacute;s de 50 a&ntilde;os'));
define('OPCIONES',array('a','b','c','d','e'));
define('METODO_CUESTIONARIO',array('0'=>'Preguntas ordenadas','1'=>'Preguntas aleatorias'));
define('DIVISIBLE_BLOQUE','12');
define('DIVISIBLE_FILA','6');
// método de selección
define('METODO_SELECCION', array('1'=>array(
										'Doble click para ordenar las respuestas<br><div class="visible-lg hidden-sm"><br></div>'
									), '2'=>array(
										'Seleccionar y arrastrar para ordenar las respuestas', ''
									)));
define('AREASPERMITIDAS', '3');
define('VALORES_ORDENAMIENTO', array('100','1000'));
//FACTURACION ELECTRONICA
//PRUEBAS
define('WS_SRI_RECEPCION','https://celcer.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl');
define('WS_SRI_AUTORIZACION','https://celcer.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl');
//PRODUCCION
//define('WS_SRI_RECEPCION','https://cel.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl');
//define('WS_SRI_AUTORIZACION','https://cel.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl');
//PAYME
//PRUEBAS
define('PAYME_ACQUIRERID','237');
define('PAYME_IDCOMMERCE','10030');
define('PAYME_SECRET_KEY','mjNkPqNvrjUxZAH.97676492');
define('PAYME_RUTA','https://integracion.alignetsac.com/');
//PRODUCCION
//define('PAYME_ACQUIRERID','39');
//define('PAYME_IDCOMMERCE','11562');
//define('PAYME_SECRET_KEY','ggkGwgUsgLUhQTTTZC?89837522396');
//define('PAYME_RUTA','https://vpayment.verifika.com/');
define('PAYME_CURRENCY_CODE','840');
define('GRAVAIVA','1.12');
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
define("LK_SCOPE", 'r_liteprofile r_emailaddress');
// correos
define("DIRECTORIOCORREOS", array('0'=>'desarrollo@micamello.com.ec', '1'=>'desarrollo2@micamello.com.ec', '2'=>'administrador.gye@micamello.com.ec'));
define('AREASPERMITIDAS_PUB', '1');
define('SUBAREA_PERM_PUB', '1');
define('SERVER_SMTP','smtp-relay.sendinblue.com');
define('PUERTO_SMTP',587);
define('ID_SMTP','ffueltala@gmail.com');
define('CLAVE_SMTP','cz0Ls8tI34AZ2aUJ');
define('OFERTA_ACTIVA_DESCARGA','45');
define('OFERTA_ACTIVA_VER','15');
define('MAX_PFACETA', '2');
?>
-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.7.21


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema micamello_base
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ micamello_base;
USE micamello_base;

--
-- Table structure for table `micamello_base`.`mfo_accionsist`
--

DROP TABLE IF EXISTS `mfo_accionsist`;
CREATE TABLE `mfo_accionsist` (
  `id_accionSist` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la tabla',
  `accion` varchar(50) NOT NULL COMMENT 'Accion existente en el sistema',
  `descripcion` varchar(200) NOT NULL COMMENT 'Detalle del módulo al que se accedera con dicha acción',
  `estado` tinyint(4) NOT NULL COMMENT 'Si el módulo del sistema esta activo o no',
  `tipo_permiso` int(3) NOT NULL COMMENT '1.- sistema interno (backend) o 2.- visualizaciones (frontend)',
  PRIMARY KEY (`id_accionSist`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_accionsist`
--

/*!40000 ALTER TABLE `mfo_accionsist` DISABLE KEYS */;
INSERT INTO `mfo_accionsist` (`id_accionSist`,`accion`,`descripcion`,`estado`,`tipo_permiso`) VALUES 
 (1,'verOfertaTrabajo','Permite ver las ofertas de trabajos',0,2),
 (2,'autopostulacion','Se puede observar las autopostulaciones',0,2),
 (3,'cargarHv','Permite cargar a los candidatos hojas de vida',0,1),
 (4,'notificacionesCorreo','Dara acceso al envio de correo con notificaciones',0,1),
 (5,'descargarInformePerso','Descargar informes de personalidad',0,2),
 (6,'descargarHv','Permite descargar las hojas de vida',0,2),
 (7,'buscarCandidatos','Filtrar por candidatos',0,2),
 (8,'detallePerfilCandidatos','Permite ver el perfil del candidato',0,2),
 (9,'verCandidatos','Ver listado de candidatos',0,2),
 (10,'paquetesVendidos','Permite ver los paquetes mas vendidos',0,2),
 (11,'reporteVenta','Reporte de los paquetes mas vendidos',0,2),
 (12,'crearCandidato','Crear un nuevo candidato',0,2),
 (13,'editarCandidato','Editar un nuevo candidato',0,2),
 (14,'eliminarCandidato','Eliminar un nuevo candidato',0,2),
 (15,'adminCandidato','Administrar a los candidatos',0,2);
/*!40000 ALTER TABLE `mfo_accionsist` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_admin`
--

DROP TABLE IF EXISTS `mfo_admin`;
CREATE TABLE `mfo_admin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del administrador',
  `username` varchar(50) NOT NULL COMMENT 'Usuario administrador',
  `password` varchar(50) NOT NULL COMMENT 'Clave para acceder al sistema con un usuario administrador',
  `correo` varchar(100) NOT NULL COMMENT 'Correo del administrador',
  `estado` tinyint(4) NOT NULL COMMENT 'Campo para saber si el usuario esta activo o no',
  `ultima_sesion` datetime NOT NULL COMMENT 'Registra la ultima fecha y hora de conexión del administrador',
  `id_rol` int(11) NOT NULL COMMENT 'Identificador del rol que le pertenece',
  PRIMARY KEY (`id_admin`),
  KEY `fk_mfo_admin_mfo_rol1` (`id_rol`),
  CONSTRAINT `fk_mfo_admin_mfo_rol1` FOREIGN KEY (`id_rol`) REFERENCES `mfo_rol` (`id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_admin`
--

/*!40000 ALTER TABLE `mfo_admin` DISABLE KEYS */;
INSERT INTO `mfo_admin` (`id_admin`,`username`,`password`,`correo`,`estado`,`ultima_sesion`,`id_rol`) VALUES 
 (1,'admin','e10adc3949ba59abbe56e057f20f883e','administrador@micamello.com.ec',1,'2018-08-06 04:30:43',1);
/*!40000 ALTER TABLE `mfo_admin` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_area`
--

DROP TABLE IF EXISTS `mfo_area`;
CREATE TABLE `mfo_area` (
  `id_area` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la tabla',
  `nombre` varchar(200) NOT NULL COMMENT 'Nombre de los intereses(areas) del sistema',
  `ico` varchar(100) NOT NULL COMMENT 'Icono que se coloca en el sistema segun el interes',
  PRIMARY KEY (`id_area`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_area`
--

/*!40000 ALTER TABLE `mfo_area` DISABLE KEYS */;
INSERT INTO `mfo_area` (`id_area`,`nombre`,`ico`) VALUES 
 (1,'Informatica','fab fa-android giga'),
 (2,'Salud','fa fa-heartbeat giga'),
 (3,'Educación','fa fa-university giga'),
 (4,'Marketing','fas fa-bullhorn giga');
/*!40000 ALTER TABLE `mfo_area` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_auspiciante`
--

DROP TABLE IF EXISTS `mfo_auspiciante`;
CREATE TABLE `mfo_auspiciante` (
  `id_auspiciante` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL COMMENT 'Nombre de la marca o empresa ',
  `orden` int(3) NOT NULL COMMENT 'Orden en el que se presentara el anuncio',
  `estado` tinyint(4) NOT NULL COMMENT 'Indica si el auspiciante esta activo o no',
  PRIMARY KEY (`id_auspiciante`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_auspiciante`
--

/*!40000 ALTER TABLE `mfo_auspiciante` DISABLE KEYS */;
INSERT INTO `mfo_auspiciante` (`id_auspiciante`,`nombre`,`orden`,`estado`) VALUES 
 (1,'Mozilla',1,1),
 (2,'Google',2,1),
 (3,'Microsoft',3,1),
 (4,'Amazon',4,1),
 (5,'Envato',5,1),
 (6,'themeforest',6,1);
/*!40000 ALTER TABLE `mfo_auspiciante` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_banner`
--

DROP TABLE IF EXISTS `mfo_banner`;
CREATE TABLE `mfo_banner` (
  `id_banner` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la imagen de tipo banner',
  `nombre` varchar(50) NOT NULL COMMENT 'Nombre que llevara el banner o publicidad',
  `orden` int(3) NOT NULL COMMENT 'Orden de prioridad en el que se mostraran los banner',
  `tipo` int(1) NOT NULL COMMENT 'Tipo de banner (Banner principal, interno o publicidad)',
  `url` text NOT NULL COMMENT 'Enlace que tendra la imagen en caso de querer redireccionar',
  `estado` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Este campo indica si el banner o publicidad esta o no activa',
  PRIMARY KEY (`id_banner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_banner`
--

/*!40000 ALTER TABLE `mfo_banner` DISABLE KEYS */;
/*!40000 ALTER TABLE `mfo_banner` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_caracteristica`
--

DROP TABLE IF EXISTS `mfo_caracteristica`;
CREATE TABLE `mfo_caracteristica` (
  `id_caracteristica` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador de las caracteristicas que componen al rasgo',
  `num_car` int(3) NOT NULL COMMENT 'Posición en el rango de carcateristicas',
  `nombre` varchar(100) NOT NULL COMMENT 'Nombre de la caracteristica',
  `descripcion` text NOT NULL COMMENT 'Descripcion de la caracteristica',
  `id_rasgo` int(11) NOT NULL COMMENT 'Campo para saber a que rasgo pertenece la caracteristica',
  PRIMARY KEY (`id_caracteristica`),
  KEY `fk_mfo_caracteristica_mfo_rasgo1` (`id_rasgo`),
  CONSTRAINT `fk_mfo_caracteristica_mfo_rasgo1` FOREIGN KEY (`id_rasgo`) REFERENCES `mfo_rasgo` (`id_rasgo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=232 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_caracteristica`
--

/*!40000 ALTER TABLE `mfo_caracteristica` DISABLE KEYS */;
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (1,25,' Líder innato','Es generador de una cultura de excelencia, donde el carácter es un valor fundamental del cual no puede prescindir.Para crear un ambiente donde todos y cada uno puedan dar lo mejor de sí mismos. La sabiduría y el conocimiento del líder queda evidenciado en el aprovechamiento que hace de sus recursos. El talento es un recurso que no debe ser marginado. Es capaz de crear un ambiente donde todo el equipo pueda destacarse y salir del anonimato y nada es más motivador que el reconocimiento.',1),
 (2,24,' Gestor','Posee conocimientos específicos, los cuales usa para ejercer su labor con maestría, tiende a ser líder o cabeza de grupo dirige y gestiona los recursos materiales y humanos de una compañía con facilidad. Posee un pensamiento estratégico y logra que tanto sus empleados, clientes y asociados lo respeten.',1),
 (3,23,' Capacidad para socializar','Se caracteriza por su capacidad de conocer y aprender de su contacto con otros individuos, evalúa e interpreta los modelos sociales y es capaz de extraer lo mejor de ellos, es bueno para las relaciones sociales, el comercio y la publicidad.',1),
 (4,22,' Facilidad de palabra','Su desenvolvimiento social y su carisma e inteligencia emocional, lo hacen una persona hábil para exponer en grupos grandes, expresar sus ideas, conocimientos, emociones y sentimientos de forma correcta y entendible para quien lo escucha.',1);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (5,21,' Conciencia de lo externo','Es consciente de los procesos que ocurren fuera de sí, es capaz de reconocer, evaluar y regular los agentes externos, como motivadores extrínsecos, agentes estresores, estímulos negativos o positivos, riesgos, entre otros.',1),
 (6,20,'Optimista','Se caracteriza por ser de naturaleza optimista, tener mente positiva y no dejarse arrebatar por los desatinos cometidos, encuentra la luz al final del túnel, y casi nunca ve una derrota en sus fracasos, más bien los ve como la oportunidad de aprender de ellos y mejorar cada día.',1),
 (7,19,' Extremista','Es consciente de los procesos que ocurren fuera de sí, es capaz de reconocer, evaluar y regular los agentes externos, como motivadores extrínsecos, agentes estresores, estímulos negativos o positivos, riesgos, entre otros.',1),
 (8,18,' Positivo','Es una persona jovial y carismática, siempre esta alegre a pesar de los procesos adversos en su interior, esta energía positiva es trasmitida a los demás.',1),
 (9,17,' Busca ser reconocido','Sus principales objetivos, logros y metas son superficiales y externos, su crecimiento personal se mide en metas alcanzadas y no en el conocimiento adquirido en el camino a la meta.',1);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (10,16,' Demostrativo','Puede expresarse de forma correcta y acertada, logra evidenciar sus procesos internos como las emociones, sin importar las críticas o sentirse desprotegido o expuesto.',1),
 (11,15,' Busca el equilibrio','Se caracteriza por encontrar un equilibrio en su mundo, entre trabajo y familia, entre diversión y tiempo de ocio, también aplica este principio para las negociaciones, el amor y las relaciones sociales.',1),
 (12,14,' Sentido de responsabilidad','Es muy responsable en cuanto se compromete, pero también exige compromiso de los demás, no le gusta cuando le fallan o incumplen un trato. Él se encargará de cumplir con sus acuerdos, así como hacer cumplir a los demás de la mejor manera.',1),
 (13,13,' Autocritico','Tiene una imagen clara de sí mismo, de sus capacidades, fortalezas y debilidades, sabe lo que puede cumplir y lo que no, también es capaz de la autocrítica y la autoevaluación.',1),
 (14,12,' Ordenado','Normalmente es organizado en su puesto de trabajo, su hogar y su forma de trabajar estructurada, también posee pensamientos organizados, su forma de expresarse es pausada y sigue un orden de ideas.',1);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (15,11,' Eficiente','A la hora de trabajar es ermitaño, retraído y callado, por lo cual es eficiente ya que carece de agentes distractores.',1),
 (16,10,' Desinteresado','Trabaja en pro del crecimiento personal, emocional e intelectual, los reconocimientos y estímulos externos son secundarios para él, prefiere sentirse bien consigo mismo.',1),
 (17,9,' Miedo escénico','Es poco expresivo y no desea ser expuesto, hablar en público no es su fuerte, aunque tenga muchos conocimientos prefiere expresarlos de otra forma, no suele ser buen orador.',1),
 (18,8,' Auto evaluación','Puede autoevaluarse de forma profunda, conocerse a sí mismo hasta el último rincón, se autocorrige y castiga si es necesario, posee la capacidad de buscar en su interior.',1),
 (19,7,' Consciencia de su interior','Es consciente de lo que ocurre dentro de sí, reconoce estudia y controla todos los procesos internos, pensamientos, memoria, etc. Esto lo hace especial ya que puede utilizar sus herramientas cognitivas con facilidad',1),
 (20,6,' Intelectual','En primer lugar, esta su salud mental y paz espiritual, sus pensamientos son prioridad y procura entenderlos, busca el crecimiento intelectual.',1);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (21,5,' Auto consciencia','Posee una capacidad inmejorable de ver en su interior y reconocer los procesos que le afecten y lograr solucionarlos.',1),
 (22,25,' Equilibrado.','Busca el equilibrio en todo lo que hace, en su trabajo, en la distribución del tiempo, en el amor. Puede llegar a estresarse si algo lo hace perder el equilibrio, podría sentir una pérdida de control sobre todo lo que hace. ',2),
 (23,24,' Proactivo.','Actúa con rapidez y decisión, maneja sus herramientas de forma adecuada para la superación de obstáculos.',2),
 (24,23,' Emocional.','Reconoce sus emociones y las acepta tal y como son, y las expresa de forma coherente.',2),
 (25,22,' Resolutor de conflictos.','Es capaz de solucionar de manera eficiente y equilibrada los problemas que se le presenten, es bueno en la mediación y la lucha de intereses.',2),
 (26,21,' Cortés.','Es cortes, educado y se adapta a la situación.',2),
 (27,20,' Empático.','Tiene la capacidad de sentir lo mismo que otra persona a pesar de no estar pasando por la misma situación, la empatía le permite sentirse cercano al dolor o al sufrimiento de otra persona.',2);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (28,19,' Motivado.','Al emprender un proyecto, trabajo o aventura se apasiona completamente con esta y se entrega, su tiempo y su dedicación es total, si su trabajo le gusta lo hará lo mejor posible.',2),
 (29,18,' Adecuada autoestima.','Su nivel de autoestima es bueno y equilibrado, no es egocéntrico, más bien es fuerte emocionalmente y caracterizado por el amor propio y el sentido de pertenencia.',2),
 (30,17,' Reciproco.','Maneja la reciprocidad, si se esfuerza más en su estrato laboral, desea más reconocimientos o recompensas, este principio lo lleva a lo social y a lo personal; debe haber una proporción entre esfuerzo y recompensa.',2),
 (31,16,' Complementario.','En el amor suele complementar correctamente a sus parejas, en el trabajo es buen socio o compañero, supliendo o sirviendo de complemento ante las fallas de los demás, sabrá como compensarlas y salir adelante como un equipo sólido.',2),
 (32,15,' Fuerte.','Gracias a su equilibrada autoestima y el conocimiento de sí mismo y sus capacidades, cuando existen contratiempos, dificultades o fracasos, no se abate con facilidad, identifica las fallas y trabaja para no volver a cometerlas.',2);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (33,14,' Impuntual.','La puntualidad es una simple ilusión, ya que no posee un sentido de esta, normalmente llega tarde al trabajo y encuentra excusas para ello fácilmente. ',2),
 (34,13,' Descortés.','No usa correctamente las normas de cortesía, es cómodo y no busca la adaptación al medio ambiente. No sigue estándares ni normas, por lo cual no es común verlos en grupos o círculos sociales con normas rígidas.',2),
 (35,12,' Incumplido.','Las metas colocadas por otros y por sí mismo son incumplidas a menudo, no es capaz de ahorrar, hacer dietas, cumplir horarios, entregar deberes, entre otros.',2),
 (36,11,' Desestructurado.','Se caracteriza por ser olvidadizo y mantener un estado de desorden permanente, así como sus espacios laborales sus ideas trabajan de forma aleatoria, por ende, debe realizar planificaciones, llevar diarios y crear esquemas para lograr los objetivos que se proponga. Debe también cuidar sus finanzas ya que no recuerda en que gasta el dinero.',2),
 (37,10,' Trabajo en equipo.','Carece de herramientas y es consciente de ello, busca apoyarse en su equipo de trabajo, para lograr sus objetivos, conforma y lidera equipos multidisciplinarios que contrarresten sus debilidades.',2);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (38,9,' Apático.','Aunque reconozca las emociones de otros no intenta ocupar los zapatos de esa persona, no vive las emociones vividas por otro ser humano y carece de sensibilidad ante las mismas, no es bueno prestando contención emocional a familiares y amigos en situaciones de pérdidas significativas.',2),
 (39,8,' Puntualiza temas.','No puede mantener la ilación de la charla, tiende a cambiar de tema conforme esta va transcurriendo. Es importante para poder trabajar con el/ella puntualizar los temas a discutir y encarrilarlos ya que puede perder fácilmente el tema.',2),
 (40,7,' Toma de decisiones.','Le cuesta diferenciar entre emergencias y urgencias, también le cuesta establecer jerarquías entre sus responsabilidades, suele entregar trabajos tarde, y hace cosas sin mayor importancia antes de las que realmente importan. ',2),
 (41,6,' Pasivo.','Su carácter desorganizado le impide en lo general tomar decisiones claras, prefiere dejar que agentes externos decidan por él.',2),
 (42,5,' Inestable.','Es consciente de su desorden interno y busca experimentar orden en el mundo exterior.',2);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (43,25,'Expresivo.','Reconoce sus emociones y pensamientos como algo natural y logra expresarlos con facilidad, debe tener cuidado ya que suele no tener filtros y sus palabras no siempre son agradables.',3),
 (44,24,' Asertivo.','Sin gran esfuerzo logra encontrar las palabras adecuadas en el momento adecuado, maneja bien las herramientas comunicativas y las usa de forma ágil lo que le da una gran ventaja en las relaciones laborales y cargos gerenciales.',3),
 (45,23,' Comunicador.','Se expresa correctamente sin importar el medio de comunicación, ya sea escrito, verbal, o simplemente usando su lenguaje corporal logra que todos entiendan con facilidad.',3),
 (46,22,' Mentor.','Le gusta compartir sus conocimientos, los da a quien desee escucharlo detenidamente, su habilidad para ser entendido lo hace especialmente bueno para las carreras afines a la educación, consejería, psicología, asesor, entre otras.',3),
 (47,21,' Histriónico.','Domina el público y el miedo escénico, carece de ridículo y posee el control de su conocimiento el cual lo hace un excelente orador, es bueno con grupos grandes, se proyecta adecuadamente y su energía se trasmite de forma correcta.',3);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (48,20,' Transmisor.','Es capaz de cumplir órdenes y comunicarse dentro y fuera de su trabajo. Esto le permite gozar de mejores relaciones y escalar más rápido en su empresa.',3),
 (49,19,' Receptor.','Está atento a la recepción de información proveniente del medio ambiente, coloca su energía psíquica (concentración) en captar lo que le están transfiriendo, lo hace especialmente bueno en la adquisición de conocimientos en los estudios, trabajos, talleres, cursos, etc., adicional a esto se caracteriza por tener una excelente memoria.',3),
 (50,18,' Culto.','Posee un vocabulario enriquecido y culturalmente elevado, es bueno para adaptarse al medio en donde se desenvuelve, ha leído suficiente como para poseer un léxico flexible puede ser tan burdo o tan sofisticado según sea requerido.',3),
 (51,17,' Buena memoria.','Logra retener información de forma consciente e inconsciente de forma más eficiente que el promedio, su memoria es prodigiosa y puede recuperar información fácilmente. Es bueno para los trabajos donde requiera esta habilidad, es bueno en las matemáticas y/o la historia.  ',3),
 (52,16,' Expresión corporal.','Lo que está ocurriendo en su mente es expresado de forma correcta por su cuerpo entero, las expresiones faciales son acompañadas del pensamiento que le corresponde, dolor, angustia, miedo, horror, asombro, sin importar lo que sienta será coherente ayudándole esto a ser entendido emocionalmente por los demás y estableciendo lazos empáticos con otros.',3);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (53,15,' Seguro.','La confianza es importante para todo lo que hace en su vida personal y laboral, gracias a ella logra expresar opiniones o críticas, levanta la voz de una manera respetuosa al estar en desacuerdo, da a conocer sus ideas y conocimientos sin miedo a ser juzgado, puede decir que ¨no¨ cuando es necesario y puede defender a sus compañeros y seres queridos.',3),
 (54,14,' Inexpresivo.','Debe aprender a comunicarse de forma efectiva para evitar inconvenientes en el trabajo y su vida personal; mejorar las vías de comunicación, ya que no diferencia importancia alguna entre ellas y suele no ser entendido con facilidad, sus mensajes pueden ser interpretados de una forma distinta a la que él quisiera se interpretara.',3),
 (55,13,' Indiferente.','Por lo general le cuesta trabajo servir de interlocutor, entre partes en un conflicto, no logra un equilibrio donde las partes ganen por igual, por ende, notaremos que posee desequilibrios en su vida personal, su capacidad de resolución de conflictos puede verse afectada también. Con herramientas y estudio puede lograr un equilibrio en la mediación.',3),
 (56,12,' Inadecuada autoestima.','Suele tener una percepción errada de sí mismo, lo cual lo lleva a no aceptarse tal y como es, desea constantemente ser diferente y entiende que los demás creen lo mismo, no se siente aceptado y se retrae, le cuesta la socialización y la visualización del mundo tal y como es. Debe emprender un arduo trabajo personal para la superación de este obstáculo el cual lo hace especialmente retraído. ',3);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (57,11,' Tímido.','Por su carácter tímido y retraído prefiere guardar todo aquello que ocurre dentro de sí mismo, sus pensamientos normalmente no son expuestos. No expone ideas novedosas, aunque las tenga. Por otro lado, sus emociones son tesoros que no comparte con nadie, debe establecer una relación de profunda confianza para expresarlo, es bueno para labores solitarias donde la comunicación con compañeros no es necesaria.',3),
 (58,10,' Común.','Su léxico es coloquial o informal, su lenguaje carecerá de forma y fondo es decir carece de contenido y contexto; puede ser muy especializado en una materia y usara un lenguaje en extremo técnico, el cual será difícil de entender si no se maneja el mismo idioma, carece de un lenguaje extenso que le impide comunicarse con otros que no posean los mismos conocimientos.',3),
 (59,9,' Inseguro.','Su timidez y baja exposición en el mundo exterior, le dan poca seguridad en sí mismo le dificulta expresarse ante un público grande.',3),
 (60,8,' Tosco.','Es tosco con sus movimientos y su lenguaje corporal realmente no expresa lo que siente o quiere, suele tener rostro muy expresivo lo cual no dice nada ya que no están en vínculo directo con su realidad interna o psíquica.',3);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (61,7,' Comunicación limitada.','Hacerse entender no es su fuerte, puede poseer un conocimiento profundo de un tema, pero sus dificultades comunicacionales le impiden hacer llegar el mensaje correctamente. Suele conseguir una vía de comunicación sea escrita u oral con la cual se identifique más para comunicarse y hacerse entender por sus semejantes. ',3),
 (62,6,' Distraído.','Si el portador del mensaje no habla su mismo lenguaje, es decir, si no posee sus mismos conocimientos técnicos, le costara mucho entender cualquier mensaje que este intente trasmitirle, prefiere estar en zonas de confort, así garantiza que con quien habla pueda entenderle, así como también entender lo que le dicen.',3),
 (63,5,'Retraído.','Prefiere mantenerse en el anonimato, no desea reconocimientos públicos, los tumultos le causan molestia, no desea la interacción prolongada o sostenida como otras personas, preferiría laborar de forma solitaria para ser más eficiente en lo que hace.',3),
 (64,25,' Positivo.','Posee una energía positiva la cual le permite ver con claridad la solución de todos los problemas, puede llegar a ser demasiado optimista y no ver con claridad los obstáculos en el camino y tomar decisiones apresuradas o dar fecha de entrega poco realistas.',4);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (65,24,' Exitoso.','Le gusta solucionar problemas y salir airoso de los conflictos, luego suele ser el tipo de individuo al que todos consultan su punto de vista ya que logra ver soluciones que otros no encuentran. ',4),
 (66,23,' Persuasor.','Altamente persuasivo, tiene una capacidad innegable para influenciar sobre las decisiones de los demás sin que estos se den cuenta de ello. Usa su energía para dirigir a otros y persuadirlos esto hace que logre sus objetivos a través de otras personas.',4),
 (67,22,' Habilidad numérica.','En general es bueno para las matemáticas, puede desarrollar habilidades numéricas increíbles, rapidez de cálculo, lógica, etc.; es bueno para las ciencias puras y carreras como la ingeniería, la arquitectura, el diseño. También es bueno en oficios donde la precisión numérica deba ser usada.',4),
 (68,21,' Correcto.','Es de fácil adaptación, se visualiza en el cumplimiento de normas legales, sociales y laborales usa el uniforme adecuadamente, llega a la hora estipulada, respeta plazos, es educado, respeta normas de cortesía y le gusta que los demás sean igual, intenta crear una sensación de uniformidad y respeto dentro del ambiente laboral.',4),
 (69,20,' Adaptado.','Es capaz de adaptarse en cualquier lugar y circunstancia usa su medio ambiente para el beneficio de los objetivos a cumplir, posee una inteligencia aplicada y una personalidad muy flexible, suele encajar en donde lo pongan.',4);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (70,19,' Optimista.','Puede ver la luz al final del túnel sin llegar a ser en extremo positivo, ve la solución, pero se detiene para analizar los pro y contras, es analítico y calmado, siempre logra tener buen ánimo y esperanzas ante cualquier obstáculo.',4),
 (71,18,' Lógico.','Se le hace fácil las matemáticas básicas y la lógica matemática, maneja adecuadamente las unidades de medidas, tamaños y espacios, es decir su capacidad visual-espacial se encuentra desarrollada, puede calcular presupuestos con facilidad y planificar gastos. También logra una adecuada administración de los ingresos.',4),
 (72,17,' Estratégico.','Planifica y ejecuta métodos de acción de forma correcta rápida y eficaz. Utiliza las herramientas de trabajo adecuadamente, y es estructurado.',4),
 (73,16,' Perseverante.','No se cansa, busca la superación constante y desea superar obstáculos a como dé lugar, si se presenta alguno no desiste hasta lograr solucionar o superarlo, no tiende a evadir los problemas, prefiere enfrentarlos y darles una solución equilibrada.',4),
 (74,15,' Adaptable','Su plasticidad es admirable, se adapta y utiliza los recursos mentales de formas infinitas, puede aplicar cualquier conocimiento en cualquier área sin importar lo desligado que estén, es decir puede aplicar conocimientos matemáticos en las artes o viceversa.',4);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (75,14,' Indeciso.','Le cuesta decidir, necesita tiempo o un pequeño empujón para que dé el siguiente paso, piensa y analiza de forma constante antes de tomar cualquier decisión.',4),
 (76,13,' Incumplido.','Se le dificulta el cumplimiento de metas, plazos y promesas, no suele cumplir con su palabra, aunque sea sincero el compromiso que adquirió.',4),
 (77,12,' Pesimista.','En ocasiones pierde el ánimo, no ve solución o simplemente no encuentra la salida, debe trabajar su confianza y autoestima, es analista profundo, le gusta trabajar en bases sólidas no se arriesga ya que lo incierto no le da comodidad y cree que hay muchas posibilidades de fallar.',4),
 (78,11,' jefe.','No es bueno en cargos gerenciales, con la experiencia y el tiempo puede ocupar cargos de jefaturas.',4),
 (79,10,' Arriesgado.','Incumple cánones, reglas, normas, leyes, etc. No le gusta seguir modas, usar uniformes, pertenecer a grupos, no le gusta que le diga lo que debe hacer.',4),
 (80,9,' Solitario.','No le gusta verse vinculado con la resolución de conflictos y menos si no le benefician personalmente. Prefiere carreras más artísticas, con menos uso de razonamientos matemáticos y que presente menos conflictos personales, no le agradan las dualidades ni la toma de decisiones.',4);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (81,8,' Inseguro.','Cuando logra tomar una decisión por correcta que sea, siempre mantiene la sensación en sí de que le gustaría haber escogido otra cosa, piensa recurrentemente que pudo escoger algo más. ',4),
 (82,7,' Conformista.','Se conforma con lo que tiene y obtiene sin mucho esfuerzo, no lucha por alcanzar estándares más altos, no se preocupa por tener ascensos en su trabajo, no es competitivo ni ambicioso.',4),
 (83,6,' Negligente.','Las estrategias y planes de acción son cosa olvidada para él, al verse frente a complicaciones busca soluciones preestablecidas y las sigue, no se esforzará por crear o buscar soluciones creativas.',4),
 (84,5,' Despistado.','No presta la adecuada atención, esto conlleva a la perdida de información, es olvidadizo, no recuerda direcciones, pierde las llaves, no retiene nombres, ni números telefónicos.',4),
 (85,25,' Prodigio.','Soluciona, crea, gestiona, fabrica, construye. Es hábil mentalmente, suele estar en las nubes le gusta soñar e ingeniar cosas nuevas, es especialmente para las carreras creativas, busca soluciones a los problemas fácilmente, la adaptación de herramientas es una característica fundamental. Suele ser sobresaliente en el área donde se desenvuelva por sus capacidades intelectuales. ',5),
 (86,24,' Intuitivo.','Percibe, capta, recibe señales del ambiente, es capaz de desarrollar niveles muy altos de empatía para con sus allegados, puede intuir cuando algo no va bien, puede parecer que posee un sexto sentido más desarrollado el cual lo hace especial.',5);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (87,23,' Ingenioso.','Desarrolla herramientas para la solución de cualquier conflicto o superación de obstáculo. ',5),
 (88,22,' Innovador.','De lo creado es capaz de renovar; no todo está creado, la última palabra no se ha dicho y desea ser quien encuentre esa innovación. El hoy ya es pasado para él, vive en el futuro, se adelanta a los pasos de los compañeros y se percata de pequeños detalles.',5),
 (89,21,' Abstracto.','Puede imaginar fácilmente las cosas sin tenerlas frente a él. Puede definir infinidad de estrategias basadas en las matemáticas para la resolución de problemas reales en cualquier ámbito y sin importar su complejidad. ',5),
 (90,20,' Jovial.','Es alegre, con ganas de vivir, tiene mucha energía la cual trasmite a las personas cercanas, intenta permanecer de buen humor, emana vitalidad juventud. Esta alegría expresada es coherente con sus sentimientos y pensamientos.',5),
 (91,19,' Creativo.','Empezar desde cero no es un problema, crear es lo suyo la innovación y buscar formas nuevas de realizar tareas, busca soluciones, ofrece opciones y forja imperios desde la nada. Es bueno para darle base a los proyectos, consolida empresas, idea nuevas formas de salir adelante.',5);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (92,18,' Pensativo.','Es un soñador por excelencia, su mente pocas veces logra tocar tierra está volando constantemente, esto le da capacidades creativas sin igual, pero también lo hace distraído y descuidado. Le es fácil soltar y perdonar olvidar el pasado que ya no le interesa, también tiene una percepción del futuro única, si canaliza esta característica puede lograr cosas increíbles. ',5),
 (93,17,'Dificultad matemática.  ','Puede tener complicaciones con tareas concretas y con la consecución de objetivos estrictos, así como también se le dificultan las ciencias puras como la matemática, la física y la química, no quiere decir esto que no puede estudiarlas y desarrollarlas de forma adecuada, solo que tendrá complicaciones y no irá al ritmo de los demás.',5),
 (94,16,' Capaz.','Puede desarrollar nuevas formas de superar los obstáculos cotidianos, no importa si la respuesta a una situación en concreto no la tiene con un momento de análisis y de imaginación lograra dar una respuesta adecuada, innovadora y creativa a cualquier situación.',5),
 (95,15,' Artístico.','Es increíblemente bueno para las artes plásticas, actuación, música, se le facilita la escritura de libros, ama la fantasía y la ciencia ficción, entiende el mundo de forma distinta a los demás. ',5);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (96,14,' Explorador.','En todo lo que ejecuta desea que lleve su firma personal, es decir aplica su imaginación y creatividad para que todo lo que haga tenga un toque especial.',5),
 (97,13,' Concreto.','Posee un pensamiento más concreto y estructurado, desea orden y vive con los pies sobre la tierra, es especialmente bueno para carreras como la ingeniería, las matemáticas, la computación, entre otras carreras donde la estructuración sea necesaria y tenga un basamento teórico comprobable.',5),
 (98,12,' No posee un don artístico.','En especial no posee dones artísticos como la actuación, la pintura, el canto, entre otros, puede tocar instrumentos si se esfuerza y estudia, pero no lo hará con facilidad. Cuando emprende proyectos artísticos debe estar preparado para la frustración ya que no siempre le saldrán bien algunas cosas.',5),
 (99,11,' Hábil.','Soluciona conflictos y supera obstáculos atreves del uso de la planificación y la estructuración mental que lo caracteriza, siente que si no pone orden no lograra alcanzar ninguna meta. ',5),
 (100,10,' Estructurado.','Se le dificulta el desarrollo del pensamiento abstracto que le permita comprender complejos conceptos matemáticos y admirar toda la belleza escondida tras infinidad de patrones presentes en la naturaleza.',5);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (101,9,' Pensamiento rígido.','Su estructura mental está muy bien definida, necesita orden, cree que los objetivos serán logrados si mantiene una estructura inquebrantable, es bueno para cargos de oficiales de policía, tránsito y custodio en correccionales, directores, puede ser un jefe rígido, es poco creativo y retrógrado. Suele estar de mal humor o cambiar rápidamente de alegría a enojo, es un padre estricto y no demuestra el afecto con contacto físico. ',5),
 (102,8,' Lógico.','Utiliza la lógica ya sea inductiva o deductiva para el análisis de contenido y la solución de conflictos, puede realizar análisis desde los aspectos macro a lo micro es decir puede ver desde las grandes generalidades y llegar a ser lo más específico posible. Estas características son evidenciadas en profesiones con rasgos investigativos.',5),
 (103,7,' Concreto.','En su trabajo ejerce sus labores de forma específica, no le gusta hacer más de una cosa a la vez porque siente que pierde fuerza lo que hace, prefiere hacer una cosa a la vez, pero hacerla bien.',5),
 (104,6,' Poco creativo.','Crear desde cero no es su fuerte, prefiere tomar bases sólidas y partir desde ahí, le gustan las actividades que mantengan sus pies y cabeza en el suelo, carece de una capacidad imaginativa desarrollada. ',5);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (105,5,' Desmotivado.','Puede llegar a tener un carácter rígido y pesimista, no parece estar motivado y no desea que alguien los motive, prefiere las actividades menos enérgicas.',5),
 (106,25,' Exigente.','No acepta mediocridades, sus niveles de exigencia son los más altos, lo que le garantiza realizar trabajos con excelente calidad, lucha por ser el mejor, es competitivo y quiere siempre ganar.',6),
 (107,24,' Focalizado.','Tiene sus objetivos claros y es capaz de modificarlos para que estos compaginen con los de su empresa, así cada logro personal implica un crecimiento para su empresa y cada vez que crece la empresa el también crece con ella.',6),
 (108,23,' Auto desafiante.','Se reta constantemente, es organizado y posee un orden jerárquico en sus metas, identifica y califica las metas a corto, mediano y largo plazo según sea correspondiente y se dispone a cumplirlas.',6),
 (109,22,' Arriesgado.','Es arriesgado, toma decisiones, adquiere responsabilidades. No espera la voluntad de nadie, se ocupa antes que preocuparse. Asume nuevos retos en su vida y en el trabajo, puede asumir más de un proyecto, debe tener cuidado con esto porque puede traer problemas de tiempo.',6);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (110,21,' autodirección.','No necesita guías, toma las riendas de su vida y la direcciona en función a sus principios y metas, proyecta una dirección y no se rinde hasta llegar a la meta.',6),
 (111,20,' Autocrítico.','Se autoevalúa y critica duramente, puede ver dentro de sí y revisar las fallas, es consciente de sus fortalezas y debilidades, si falla puede tomar lo bueno fácilmente y mejorar, es un ser en constante cambio ya que modifica lo que no desea y mantiene y refuerza sus puntos positivos.',6),
 (112,19,' Promotor.','Es tan activo el cómo la gente que lo rodea, si el mundo no gira el hará que gire, llena de energía el ambiente y proyecta motivación a sus compañeros y amigos.',6),
 (113,18,' Dinámico.','Está en constante movimiento, jamás se detiene, si lo hace siente una sensación de claustro, se siente encerrado y pierde su libertad, él debe ser libre, le gusta la velocidad, los deportes y procura movilizarse tanto física como mentalmente.',6),
 (114,17,' Sentido de pertenencia.','Ama lo que hace y donde lo hace, ama a su empresa y se siente perteneciente a ella por sobre todas las cosas tiene la sensación de que lo que hace es muy importante para la organización a la que pertenece. ',6);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (115,16,' Positivo.','Mantiene un estado de ánimo óptimo, y de motivación constante, cree que puede lograr todo lo que se propone.',6),
 (116,15,' Resiliente.','El fracaso no es parte de su vocabulario, y si cae simplemente se levanta y se vuelve más fuerte con cada caída.',6),
 (117,14,' Egoísta.','Es egoísta sus intereses están por encima de cualquier otra persona, la principal persona por la que lucha es por sí mismo, no pertenece a grupos donde el objetivo de este no le sirva para crecer o impulsarse',6),
 (118,13,' Desorganizado.','En puesto de trabajo es desordenado, puede perder objetos y documentos, olvida donde deja sus cosas. Normalmente no es higiénico.',6),
 (119,12,' Bajo sentido de pertenencia.','Trabaja en lo que le propongan y le genere dinero sin importar si le gusta o no, si le beneficia económicamente lo hará sin importar nada. Esto lo lleva a no sentirse perteneciente a la organización, empresa o grupo.',6),
 (120,11,' Cómodo.','Si la paga será la misma preferirá las tareas más sencillas de hacer y fáciles de ejecutar buscará la manera de adaptarlas para realizarlas de la forma más cómoda posible.',6);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (121,10,' Melancólico.','Se aferra al pasado y a los problemas de este. Le cuesta la superación de duelos, las separaciones y el perdón.',6),
 (122,9,' Desapegado.','Las metas de la empresa no son importantes para el simplemente desea trabajar y que le paguen este o no este la empresa percibiendo ingresos, si la empresa crece él no se verá afectado ya que sus objetivos personales son muy apartes de ella.',6),
 (123,8,' Pocas aspiraciones.','No es constante con sus actos por ende no posee metas a largo plazo, y si las llega a tener jamás las logra alcanzar, el cumplimiento de metas cortas es lo realmente gratificante para él ya que su nivel de compromiso es tan bajo que asumir retos para sí mismo son una carga muy grande.',6),
 (124,7,' Inconstante.','Es inconstante no logra sus objetivos y mucho menos los de su empresa, le cuesta el cumplimiento de metas, y la consecución de logros profesionales. Si su superior le encomienda una tarea, tardara más que el promedio, y al culminar el día existen grandes probabilidades de que no culmine dicha tarea.',6),
 (125,6,' Autorregulado.','Aunque es descuidado, se conoce a sí mismo, es doloroso reconocer quien es realmente, pero esto lo lleva a asumir solo las responsabilidades que podrá cumplir y estipulara un tiempo correcto de entrega.  ',6);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (126,5,' Desanimado.','Debe ser estimulado diariamente, recompensarlo por sus pequeños logros por muy insignificantes que sean, para él son grandes, necesita elogios y de vez en cuando un empujoncito para que arranque sus actividades no le caerá mal.',6),
 (127,25,' Genera confianza.','Hace que todos confíen en él, contagia a sus amigos, compañeros y familiares con una sensación de confianza profunda, todos recurren a él como un confidente, es excelente amigo y suele ocupar cargo de entera confianza para el dueño de la empresa.',7),
 (128,24,' Responsable.','Fácilmente puede asumir responsabilidades con la plena seguridad de que cumplirá, así mismo puede asumir más de una tarea a la vez, es buen vecino, padre y amigo. ',7),
 (129,23,' Cumplidor.','Siempre garantiza el cumplimiento de su trabajo, si promete, cumplirá. Para él un apretón de manos y su palabra son más fuertes que cualquier contrato escrito, cumple metas, objetivos y retos personales.',7),
 (130,22,' Comprometido.','Es capaz de comprometerse emocionalmente con alguien, si decide casarse será fiel y llevará su matrimonio a la trascendencia. Este compromiso emocional puede ser con amigos y familiares, también es sensible y de buen corazón.',7);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (131,21,' Firme.','Si se pacta o se llega un acuerdo se mantendrá firme hasta cumplirse a cabalidad, exigirá lo mismo de la contra parte que contrajo el compromiso será exigente y buscara que las partes en cuestión dispongan de la misma cantidad de energía aplicada al pacto, es decir pedirá que el pacto o compromiso sea ejecutado por las partes con una distribución equitativa de la responsabilidad.',7),
 (132,20,' Constante.','Su nivel de responsabilidad y compromiso lo lleva a ser una persona exitosa, con constancia y seguridad, establece relaciones estratégicas basadas en la confianza y el respeto que le ayudan a progresar y lograr sus objetivos.',7),
 (133,19,' Ejemplar.','Suele ser el empleado de confianza, al que le damos las llaves para que abra el local, haga cobros y retiros de dinero, puede trabajar hasta tarde y no se molestara porque le den tareas extras.',7),
 (134,18,' Cumple metas.','Las metas u objetivos colocados por la empresa serán cumplidos con gran facilidad, no tendrá problemas en asumirlas como propias y crecer junto a quienes lo contratan.',7);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (135,17,' Puntual.','Su compromiso es tal que será uno de los primeros empleados en llegar a su puesto de trabajo, también exigirá lo mismo de sus compañeros y clientes. Suele molestarse cuando un cliente no llega a tiempo y no cumple con las reuniones pautadas.',7),
 (136,16,' Moral y ético.','Sus conceptos sociales como el de moral están bien infundados por su educación y es capaz de moldearse según la situación en la que se encuentre, lo que no será moldeable es que una vez establecida la ética personal será literalmente inquebrantable.',7),
 (137,15,' Sincero.','No suele dar excusas y decir mentiras, por sus valores no se permite a si mismo fallar y dar excusas, más bien reconoce los errores y pone en práctica la mejora de los mismo; no le gustan las personas mentirosas y prefiere descartarlas como amistades o empleados.',7),
 (138,14,' Respetuoso.','Suele respetar las leyes y normas de un lugar determinado o general, normalmente irrespetara dichas leyes y normas si una causa de fuerza mayor se lo impide. De transgredir una ley o norma suele arrepentirse y aceptar que cometió el error, asumiendo las responsabilidades que esto conlleva. ',7),
 (139,13,' Indisciplinado. ','Las peticiones y reclamos de sus superiores no son prioridad para él, deja pasar el tiempo y luego vuelve a cometer los mismos errores. Con él los reclamos y memorándums son habituales ya que no desea mejorar.',7);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (140,12,' Inconsistente.','Adquiere responsabilidades que constantemente está posponiendo, actividades laborales o en su vida personal puede posponer desde un día de parque con sus hijos hasta una entrega de proyecto en el trabajo, si es estudiante prefiere no ir a clases para no entregar los deberes que le han solicitado, no consigue tiempo y se excusa para no cumplir con lo que le corresponde.',7),
 (141,11,' Desligado.','No es fiel a su puesto de trabajo y a su empresa, no se siente perteneciente a ella, esto ocurrirá sin importar la empresa o el cargo que ocupe, se encuentra en una búsqueda constante de nuevos empleos y no ofrece una estabilidad al contratante.',7),
 (142,10,' Consecuente.','Las responsabilidades asignadas son cumplidas sin embargo los lapsos de entregas suelen ser alargados o postergados, debe trabajar el sentido de pertenencia y la jerarquización de tareas.',7),
 (143,9,' Impuntual.','En ocasiones llega tarde a su puesto de trabajo, se escudará en cualquier motivo para no tomar a tiempo sus responsabilidades, deja esperando a los clientes, lo cual representa pérdidas para la empresa ya que los clientes pueden molestarse y buscar otras ofertas en el mercado.',7);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (144,8,' Cómodo.','Se mantiene cómodo en su puesto realizando las tareas inherentes a su cargo sin abarcar más allá de lo que eso compromete, si se le proponen actividades extras con rapidez las rechazara.',7),
 (145,7,' Mentiroso.','Las excusas falsas, el motivo de sus retrasos, por qué no tiene tiempo, son ejemplos de las mentiras que puede llegar a utilizar, no tiene realmente un entendimiento de lo que puede ocasionar con sus mentiras y por eso las dice. No está consciente de estar haciendo algo malo.',7),
 (146,6,' Variable.','Cambia constantemente de trabajos ya que no encaja en ninguno, cuando el nivel de exigencia aumenta prefiere huir, si es que no lo despiden antes. Puede llegar a tener problemas con su compañeros y jefes.',7),
 (147,5,' Desapegado.','No desea establecer vínculo emocional con nadie ya que su objetivo no es permanecer mucho tiempo con una persona, cuando ve que la relación está avanzando a otro nivel de compromiso prefiere cometer un error grave para salir de la situación. No posee mejores amigos ni personas de alta confianza.',7),
 (148,25,' Impulsor.','La motivación, es innegable, contagia a todos los que lo rodean y logra que su equipo de trabajo salga adelante, es el motor de arranque en su trabajo y familia.',8);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (149,24,' Alentador.','no permite el sedentarismo en su lugar de trabajo ni en su hogar, establece rutinas de actividad y no puede estar estático.',8),
 (150,23,' Animado.','Es alegre, animado, suele ser el alma de la fiesta.',8),
 (151,22,' Influenciador. ','es un influenciador nato, los compañeros lo siguen y comparten sus ideas, es un líder positivo querido por la mayoría.',8),
 (152,21,' Auto conocimiento','Conoce sus capacidades motivadoras y decide usarlas de forma positiva, se dedica a esto y genera ingresos de ello.',8),
 (153,20,' Lidera.','El equipo más exitoso que lidera es su familia, luego lleva su éxito como líder a su trabajo donde se convierte en la voz de sus compañeros y logra alcanzar puestos altos, así como también ganar la estima de sus amigos y allegados. Este candidato es de vital importancia para la empresa.',8),
 (154,19,' Conduce. ','Guía, maneja y lleva de la mano a quien se lo pida le muestra los caminos al éxito y comparte con ellos sus conocimientos, también puede llevar toda una empresa consigo, posee cargos gerenciales y jefaturas, lo podemos conseguir en cargos bajos y medios, pero dura poco en ellos ya que logra la consecución de sus metas.',8),
 (155,18,' Progresista.','Su energía psíquica la direcciona en un objetivo, esto le permite lograrlos sin mayor contratiempo, esto solo puede llevarlo a un punto y es al progreso y al crecimiento personal y profesional.',8);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (156,17,' Futurista.','Piensa en el mañana, no se estanca en el pasado ni se preocupa por volver a ser lo que fue, prefiere enfocarse en ser lo mejor que ha sido jamás.',8),
 (157,16,' Superador.','Los errores no son revividos en el presente ni recordados en el futuro, son experiencias ocurridas en el momento y de las cuales se aprende y se extraen cosas positivas.',8),
 (158,15,' Luchador.','La lucha constante es una característica ya que sus metas solo se logran atreves de la lucha constante y el emprendimiento de nuevos retos.',8),
 (159,14,' Individualista.','El trabajo en equipo no es su fuerte, prefiere laborar de forma individual, esto le impide progresar rápidamente, no es bueno en trabajos de equipo ni deportes donde la cooperación sea fundamental para el éxito.',8),
 (160,13,' Solitario.','No le interesa pertenecer a grupos o sociedades, no es específicamente antisocial, simplemente pertenecer a grupos donde compartan intereses no es de su agrado, prefiere disfrutar de la soledad.',8),
 (161,12,' Estático.','Suele ser sedentario, no se moviliza y prefiere durar muchos años en un solo trabajo, no se renueva y parece vivir en otra época, puede mantener la misma vestimenta de décadas pasadas y sentirse a gusto.',8);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (162,11,' Vive el presente.','Vive el día a día, aunque influenciado por el pasado, no se preocupa por el mañana.',8),
 (163,10,' Aprovechado.','Es aquel que deja que otros trabajen y se beneficia de la labor de otros, solo suele progresar si es en grupo ya que individualmente le costaría mucho trabajo conseguir sus objetivos.',8),
 (164,9,' Repetitivo.','Es común que repita los errores del pasado, consigue parejas iguales, trabajos parecidos, jefes tiranos, en otras palabras, no aprende y tropieza con la misma pierda una y otra y otra vez. También posee un estado de melancolía perenne el cual le identifica o caracteriza.',8),
 (165,8,' Persuasor negativo.','Puede generar rumores con facilidad y sumar personas para realizar complot en contra de otras, se maneja en un círculo de auto sabotaje el cual es cíclico, no le cae bien nadie y no le gusta compartir alegrías en público.',8),
 (166,7,' Toxico.','Encabeza pequeños focos de inconformidad en contra de los superiores y de sus iguales, puede ser líder de grupos de 2 o más personas, los cuales se caracterizan por ser especialmente pequeños y nunca encuentra nada que sea positivo. Estos grupos son de vital importancia diluirlos dentro de una empresa ya que no contribuyen al progreso de esta.',8);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (167,6,' Despreocupado.','Ante los conflictos prueba las estrategias que ya sabe y si no funcionan es mucho más fácil dejar el problema sin solución y evadir responsabilidades.',8),
 (168,5,' Desmotivado. ','Necesita ser motivado constantemente por sus características sedentarias y cíclicas, si no es impulsado tiende a no avanzar y estanca a las personas de su alrededor ya sean compañeros de trabajo o familiares.',8),
 (169,25,' Estable.','Se encuentra en la búsqueda constante de la identificación con la empresa y sus seres queridos, prefiere las relaciones largas y duraderas, le gusta la estabilidad y la calma, es fiel y no se irá de la empresa sin antes negociar términos.',9),
 (170,24,' Equitativo.','Así como es capaz de comprometerse y dar su palabra y cumplirla a cabalidad, desea que la contraparte tenga el mismo nivel de compromiso.',9),
 (171,23,' Adherido.','La visión y misión de su compañía serán las suyas sin refutar, trabajara para el éxito de las mismas, así como el éxito general de la empresa.',9),
 (172,22,' Cumple su palabra.','La palabra suele ser más fuerte que un contrato, es querido y reconocido por el cumplimiento de sus promesas, posee un alto valor ético, es el héroe de su hogar y un ejemplo en su trabajo.',9);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (173,21,' Planifica y reacciona.','Luego de una ardua planificación de estrategias, no pierde tiempo en la aplicación de las mismas.',9),
 (174,20,' Ético.','Al realizar un compromiso de partes mide los valores éticos y morales de su contraparte.',9),
 (175,19,' Responsable.','Cumple con su trabajo sin problemas, es eficiente en lo que hace, cumple con compromisos sociales si dice que asistirá a un evento puedes contar con su presencia.',9),
 (176,18,' Estandarte. ','Empezando desde casa enseñándole a sus hijos y pareja el valor de comprometerse y cumplir con los acuerdos, pasa a influenciar a sus compañeros estableciendo una red de personas que comparten el mismo valor que él.',9),
 (177,17,' Meticuloso.','Se empapa bien de los términos y condiciones y ve las letras pequeñas antes de firmar un compromiso.',9),
 (178,16,' Identifica.','Identifica califica y ejecuta sus roles con responsabilidad. Sin importar el rol que ejecute, lo ejecutara con excelencia y siempre jerarquizando su debida importancia.',9),
 (179,15,' Especifico.','Diferencia, clasifica y establece acuerdos verbales y escritos, es claro y preciso al elaborar dichos contratos, es minucioso y no permite dejar cabos sueltos. Sus acuerdos están llenos de detalles y son equilibrados para ambas partes.',9);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (180,14,' Impuntual.','El horario y entrada de trabajo se le dificulta cumplirlo, también su salud es variable ya que el horario de comidas es cuestionable, no posee rutinas estables que le permitan llevar una vida sana.',9),
 (181,13,' Desapasionado.','No se apasiona por nada, no lleva la insignia de un equipo o sigue los pasos de líderes, prefiere ver desde afuera a la gente apasionada trabajar.',9),
 (182,12,' Incumplido.','Cuando tiene lapsos de entrega de proyecto o simplemente debe terminar un trabajo a tiempo, siempre se pasa los tiempos propuestos, si inicia proyectos o dietas no son culminadas.',9),
 (183,11,' Principios cuestionables. ','Aunque conoce los principios no tiene problemas en transgredirlos.',9),
 (184,10,' Reactivo.','Toma decisiones apresuradas sin pensar, y ejecuta antes de tener el pan de acción listo, toma muchos riesgos.',9),
 (185,9,' Desentendido.','Para esta persona es fácil romper o burlar contratos firmados, convenios o pactos un papel firmado no es limitación para sus objetivos.',9),
 (186,8,' Desequilibrado.','Suele tener un desequilibrio en sus roles, es decir, trabaja mucho y deja a un lado su rol de padre y esposo, no se dedica a su familia nuclear y desatiende sus roles como hijo hermano, nieto, entre otros.',9);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (187,7,' Indiferente.','Las personas alrededor pueden estar haciendo cosas incorrectas y no se inmuta ante esto, no hace nada para evitar lo que sucede a su alrededor. Así como tampoco le afectan los comentarios y acciones de sus compañeros.',9),
 (188,6,' Desarraigado.','La visión y misión de la empresa no son cosa suya, se limita a realizar sus labores de forma automática y no muestra interés en el crecimiento y desarrollo de la compañía.',9),
 (189,5,' Desvinculado.','No le parece importante los lazos emocionales que pueda llegar a tener con otras personas, aprecia más lo físico y material, el placer y las riquezas, lo superficial es lo de ellos.',9),
 (190,25,' Intolerante.','No se le puede otorgar muchas responsabilidades, trabajara a su ritmo, no se le debería de presionar.',10),
 (191,24,' Lento.','Su ritmo es lento y necesita tiempo para adaptarse, las metas a muy corto plazo lo ponen incómodo.',10),
 (192,23,'Torpeza emocional.','No identifica bien sus emociones por ende no es capaz de controlarlas, el estrés puede salirse de control y causar daños profundos.',10);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (193,22,' Nervioso.','En las emergencias médicas no actúa coherentemente y pierde el control, en las crisis suele huir o alejarse para no verse comprometido en una situación desagradable.',10),
 (194,21,' Temeroso.','No piensa mucho en que hay del otro lado, ya que esto le causa ansiedad, el futuro incierto es causante de temor prefiere planificar bien y cuando el plan se descarrila pierde la ilación fácilmente.',10),
 (195,20,' Evade.','No es amante de las emociones exacerbadas, no le verán en parque de atracciones, ni conduciendo a altas velocidades, no le agradan las sorpresas ni las bromas pesadas. ',10),
 (196,19,' Susceptible.','La percepción que tienen los demás sobre ellos y las críticas que puedan darle son muy fuertes de asimilar por eso prefiere aislarse antes de ser expuesto.',10),
 (197,18,' Reservado.','Es cerrado y poco comunicativo no dice mucho en general, pero lo que más esconde son sus emociones y pensamientos, teme ser descubierto o expuesto.',10),
 (198,17,' Apático.','Al no poseer una inteligencia emocional desarrollada no puede colocarse en los zapatos de otra persona, carece de la capacidad de interpretar y sentir las emociones y sentimientos de otros sin estar transitando por la misma situación.',10);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (199,16,' Prefiere olvidar.','Utiliza sus mecanismos inconscientes de defensa para olvidar eventos traumáticos y solo recordar los que son positivos o placenteros para él.',10),
 (200,15,' Retraído.','Le gusta la soledad y el anonimato, se siente más seguro y menos expuesto en el mundo suele ser compatible con carreras que se ejecuten en solitario.',10),
 (201,14,'Flexibilidad y empatía.','El candidato puede moldear su forma de actuar según lo desee, y utiliza correctamente el concepto de empatía.',10),
 (202,13,' Impulsor.','Logra utilizar sus propias vivencias para ayudar a otros a superar las mismas situaciones.',10),
 (203,12,' Autoestima.','La autoestima es un concepto manejado para él, confía en que puede lograr lo que se proponga sin llegar el extremo del optimismo.',10),
 (204,11,' Calmado.','Puede analizar cada recurso que posee para la confrontación del estrés y escoger el que más se adecue al momento.',10),
 (205,10,' Arriesgado.','Se le pueden plantear retos y metas nuevas sin miedo a que las rechace, puede afrontar situaciones estresantes con normalidad.',10);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (206,9,' Autocontrol. ','En cada situación actúa coherentemente y utiliza de forma moderada los impulsos y reflejos.',10),
 (207,8,' Seguro.','Posee una autoestima elevada la cual le permite formar una coraza de seguridad en sí mismo, esta lo protege y permite que salga airoso de las críticas.',10),
 (208,7,' Inteligencia emocional. ','Ha desarrollado su inteligencia emocional tanto como para entender su mundo interior, comprende sus emociones la identifica y las expone a través de la conducta de forma adecuada al contexto.',10),
 (209,6,' Competitivo.','Es bueno y competente en el puesto de trabajo, realiza bien sus labores, se puede tener la confianza de que hará lo mejor posible en su trabajo.',10),
 (210,5,' Resiliente.','Se le puede colocar presión y ser exigentes con las tareas a realizar, trabaja bien en periodos cortos y puede tener mejoras constantes.',10),
 (211,25,'Desea aprobación.','Es superficial, se deja alienar por las palabras de elogio o critica que la sociedad arroje sobre él.',11),
 (212,24,' Reconocimiento.','Desea reconocimiento laboral, esto es más importante para él que la recompensa monetaria.',11);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (213,23,'Desea halagados.','Cuando sus compañeros lo halagan se siente bien, si lo hace su esposa e hijos confirma su autoridad y su lugar dentro del hogar, el crecimiento laborar lo mide según las palabras de elogios de su jefe.',11),
 (214,22,'Requiere estímulo.','Necesita estimulo constante para reafirmar que su trabajo está bien hecho.',11),
 (215,21,'Necesita reafirmación.','Necesita ser aprobado y reafirmado por sus iguales y superiores en el trabajo, de lo contrario no sabrá cuando está realizando un buen trabajo, así como también solicita autorización para hacer lo que sea dentro y fuera del trabajo, aunque sepa que debe hacerlo.',11),
 (216,20,' Socializador.','La necesidad de aprobación social lo hace rodearse de muchos amigos, los cuales reafirman su ego.',11),
 (217,19,' Vanidoso.','Verse bien es fundamental para él, siempre se verá pulcro y bien combinado cabello limpio, al igual que las manos y ropa. Es un seguidor de modas y estilos novedosos.',11),
 (218,18,' Simpático.','Es reciproco con los elogios y le gusta reafirmar a sus amigos y compañeros de trabajos.',11);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (219,17,' Precavido.','Le gusta siempre estar bien con todos, no le agrada que la gente se enoje con él por eso evita molestarlos.',11),
 (220,16,' Condescendiente.','Prefiere seguir el hilo a alguien que está discutiendo o que no tiene la razón, no son buenos llevando la contraria y mucho menos discutiendo sobre puntos de vista, así que evita las confrontaciones.',11),
 (221,15,' Voluntarioso.','Puede dejar a un lado sus intereses y trabajar en pro de los demás y sus intereses sin ningún problema.',11),
 (222,14,' Despistado.','Carece de atención detenida o específica, esto le impide al candidato ver detalles pequeños y sutiles, ve el mundo como un todo o como generalidades.',11),
 (223,13,' Altruista.','sus acciones no requieren de reconocimiento para sentirse bien, si hace algo bueno y nadie lo nota no se sentirá triste o decepcionado. ',11),
 (224,12,' Apático.','En el trabajo preferiría una bonificación salarial que un elogio frente a sus compañeros deja a un lado el reconocimiento y el respeto por las remuneraciones, en el amor prefiere que le demuestren amor antes de estar proclamándolo.',11),
 (225,11,' Solitario.','Prefiere la soledad es un ermitaño, puede ser también de carácter gruñón y distante en el trato, no suele dejarse ver en fiestas ni eventos sociales.',11);
INSERT INTO `mfo_caracteristica` (`id_caracteristica`,`num_car`,`nombre`,`descripcion`,`id_rasgo`) VALUES 
 (226,10,' Interesado.','Le gustaría más tener un buen socio de negocios a un buen amigo, no tiene personas allegadas con las que compartir momentos, prefiere rodearse de personas iguales a él llenas de intereses económicos.',11),
 (227,9,' Egoísta. ','La persona más importante para él es el mismo, solo le interesa el éxito personal y no el colectivo, si le dieran a escoger deportes no tendría problemas en escoger cualquiera que no sea en equipo, prefiere luchar por sus objetivos solo que contar con la ayuda de alguien y compartir el crédito.',11),
 (228,8,' Determinado.','Cuando está decidido a tomar acciones no pide autorización a nadie, simplemente actúa impulsivamente y luego asume los resultados.',11),
 (229,7,'Motivación interna.','La motivación proviene del interior y de la satisfacción personal que puede sentir al tomar o dejar alguna acción. ',11),
 (230,6,' Autosuficiente.','Las palabras de ánimo y aliento no serán necesarias ya que es autosuficiente y muestra indiferencia ante el apoyo social, prefiere recorrer el camino solo.',11),
 (231,5,' Cerrado.','Es retraído, meditabundo y no hace contacto visual con facilidad, el mundo exterior no le interesa desea pasar desapercibido se incomoda cuando lo invitan a interactuar en público.  ',11);
/*!40000 ALTER TABLE `mfo_caracteristica` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_ciudad`
--

DROP TABLE IF EXISTS `mfo_ciudad`;
CREATE TABLE `mfo_ciudad` (
  `id_ciudad` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador de las ciudades',
  `nombre` varchar(50) NOT NULL COMMENT 'Nombre de cada ciudad',
  `id_provincia` int(11) NOT NULL COMMENT 'Identificador de la provincia',
  PRIMARY KEY (`id_ciudad`),
  KEY `fk_mfo_ciudades_mfo_provincias1` (`id_provincia`),
  CONSTRAINT `fk_mfo_ciudades_mfo_provincias1` FOREIGN KEY (`id_provincia`) REFERENCES `mfo_provincia` (`id_provincia`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=221 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_ciudad`
--

/*!40000 ALTER TABLE `mfo_ciudad` DISABLE KEYS */;
INSERT INTO `mfo_ciudad` (`id_ciudad`,`nombre`,`id_provincia`) VALUES 
 (1,'CUENCA',1),
 (2,'GIRÓN',1),
 (3,'GUALACEO',1),
 (4,'NABÓN',1),
 (5,'PAUTE',1),
 (6,'PUCARA',1),
 (7,'SAN FERNANDO',1),
 (8,'SANTA ISABEL',1),
 (9,'SIGSIG',1),
 (10,'OÑA',1),
 (11,'CHORDELEG',1),
 (12,'EL PAN',1),
 (13,'SEVILLA DE ORO',1),
 (14,'GUACHAPALA',1),
 (15,'CAMILO PONCE ENRÍQUEZ',1),
 (16,'GUAYAQUIL',2),
 (17,'ALFREDO BAQUERIZO MORENO (JUJÁN)',2),
 (18,'BALAO',2),
 (19,'BALZAR',2),
 (20,'COLIMES',2),
 (21,'DAULE',2),
 (22,'DURÁN',2),
 (23,'EL EMPALME',2),
 (24,'EL TRIUNFO',2),
 (25,'MILAGRO',2),
 (26,'NARANJAL',2),
 (27,'NARANJITO',2),
 (28,'PALESTINA',2),
 (29,'PEDRO CARBO',2),
 (30,'SAMBORONDÓN',2),
 (31,'SANTA LUCÍA',2),
 (32,'SALITRE (URBINA JADO)',2),
 (33,'SAN JACINTO DE YAGUACHI',2),
 (34,'PLAYAS',2),
 (35,'SIMÓN BOLÍVAR',2),
 (36,'CORONEL MARCELINO MARIDUEÑA',2),
 (37,'LOMAS DE SARGENTILLO',2),
 (38,'NOBOL',2),
 (39,'GENERAL ANTONIO ELIZALDE',2),
 (40,'ISIDRO AYORA',2),
 (41,'GUARANDA',3),
 (42,'CHILLANES',3);
INSERT INTO `mfo_ciudad` (`id_ciudad`,`nombre`,`id_provincia`) VALUES 
 (43,'CHIMBO',3),
 (44,'ECHEANDÍA',3),
 (45,'SAN MIGUEL',3),
 (46,'CALUMA',3),
 (47,'LAS NAVES',3),
 (48,'AZOGUES',4),
 (49,'BIBLIÁN',4),
 (50,'CAÑAR',4),
 (51,'LA TRONCAL',4),
 (52,'EL TAMBO',4),
 (53,'DÉLEG',4),
 (54,'TULCÁN',5),
 (55,'BOLÍVAR',5),
 (56,'ESPEJO',5),
 (57,'MIRA',5),
 (58,'MONTÚFAR',5),
 (59,'SAN PEDRO DE HUACA',5),
 (60,'RIOBAMBA',6),
 (61,'ALAUSI',6),
 (62,'COLTA',6),
 (63,'CHAMBO',6),
 (64,'CHUNCHI',6),
 (65,'GUAMOTE',6),
 (66,'GUANO',6),
 (67,'PALLATANGA',6),
 (68,'PENIPE',6),
 (69,'CUMANDÁ',6),
 (70,'LATACUNGA',7),
 (71,'LA MANÁ',7),
 (72,'PANGUA',7),
 (73,'PUJILI',7),
 (74,'SALCEDO',7),
 (75,'SAQUISILÍ',7),
 (76,'SIGCHOS',7),
 (77,'MACHALA',8),
 (78,'ARENILLAS',8),
 (79,'ATAHUALPA',8),
 (80,'BALSAS',8),
 (81,'CHILLA',8),
 (82,'EL GUABO',8),
 (83,'HUAQUILLAS',8),
 (84,'MARCABELÍ',8),
 (85,'PASAJE',8),
 (86,'PIÑAS',8),
 (87,'PORTOVELO',8),
 (88,'SANTA ROSA',8),
 (89,'ZARUMA',8),
 (90,'LAS LAJAS',8),
 (91,'ESMERALDAS',9);
INSERT INTO `mfo_ciudad` (`id_ciudad`,`nombre`,`id_provincia`) VALUES 
 (92,'ELOY ALFARO',9),
 (93,'MUISNE',9),
 (94,'QUININDÉ',9),
 (95,'SAN LORENZO',9),
 (96,'ATACAMES',9),
 (97,'RIOVERDE',9),
 (98,'LA CONCORDIA',9),
 (99,'SAN CRISTÓBAL',10),
 (100,'ISABELA',10),
 (101,'SANTA CRUZ',10),
 (102,'IBARRA',11),
 (103,'ANTONIO ANTE',11),
 (104,'COTACACHI',11),
 (105,'OTAVALO',11),
 (106,'PIMAMPIRO',11),
 (107,'SAN MIGUEL DE URCUQUÍ',11),
 (108,'LOJA',12),
 (109,'CALVAS',12),
 (110,'CATAMAYO',12),
 (111,'CELICA',12),
 (112,'CHAGUARPAMBA',12),
 (113,'ESPÍNDOLA',12),
 (114,'GONZANAMÁ',12),
 (115,'MACARÁ',12),
 (116,'PALTAS',12),
 (117,'PUYANGO',12),
 (118,'SARAGURO',12),
 (119,'SOZORANGA',12),
 (120,'ZAPOTILLO',12),
 (121,'PINDAL',12),
 (122,'QUILANGA',12),
 (123,'OLMEDO',12),
 (124,'BABAHOYO',13),
 (125,'BABA',13),
 (126,'MONTALVO',13),
 (127,'PUEBLOVIEJO',13),
 (128,'QUEVEDO',13),
 (129,'URDANETA',13),
 (130,'VENTANAS',13),
 (131,'VÍNCES',13),
 (132,'PALENQUE',13),
 (133,'BUENA FÉ',13),
 (134,'VALENCIA',13);
INSERT INTO `mfo_ciudad` (`id_ciudad`,`nombre`,`id_provincia`) VALUES 
 (135,'MOCACHE',13),
 (136,'QUINSALOMA',13),
 (137,'PORTOVIEJO',14),
 (138,'BOLÍVAR',14),
 (139,'CHONE',14),
 (140,'EL CARMEN',14),
 (141,'FLAVIO ALFARO',14),
 (142,'JIPIJAPA',14),
 (143,'JUNÍN',14),
 (144,'MANTA',14),
 (145,'MONTECRISTI',14),
 (146,'PAJÁN',14),
 (147,'PICHINCHA',14),
 (148,'ROCAFUERTE',14),
 (149,'SANTA ANA',14),
 (150,'SUCRE',14),
 (151,'TOSAGUA',14),
 (152,'24 DE MAYO',14),
 (153,'PEDERNALES',14),
 (154,'OLMEDO',14),
 (155,'PUERTO LÓPEZ',14),
 (156,'JAMA',14),
 (157,'JARAMIJÓ',14),
 (158,'SAN VICENTE',14),
 (159,'MORONA',15),
 (160,'GUALAQUIZA',15),
 (161,'LIMÓN INDANZA',15),
 (162,'PALORA',15),
 (163,'SANTIAGO',15),
 (164,'SUCÚA',15),
 (165,'HUAMBOYA',15),
 (166,'SAN JUAN BOSCO',15),
 (167,'TAISHA',15),
 (168,'LOGROÑO',15),
 (169,'PABLO SEXTO',15),
 (170,'TIWINTZA',15),
 (171,'TENA',16),
 (172,'ARCHIDONA',16),
 (173,'EL CHACO',16),
 (174,'QUIJOS',16),
 (175,'CARLOS JULIO AROSEMENA TOLA',16),
 (176,'ORELLANA',17);
INSERT INTO `mfo_ciudad` (`id_ciudad`,`nombre`,`id_provincia`) VALUES 
 (177,'AGUARICO',17),
 (178,'LA JOYA DE LOS SACHAS',17),
 (179,'LORETO',17),
 (180,'PASTAZA',18),
 (181,'MERA',18),
 (182,'SANTA CLARA',18),
 (183,'ARAJUNO',18),
 (184,'QUITO',19),
 (185,'CAYAMBE',19),
 (186,'MEJIA',19),
 (187,'PEDRO MONCAYO',19),
 (188,'RUMIÑAHUI',19),
 (189,'SAN MIGUEL DE LOS BANCOS',19),
 (190,'PEDRO VICENTE MALDONADO',19),
 (191,'PUERTO QUITO',19),
 (192,'SANTA ELENA',20),
 (193,'LA LIBERTAD',20),
 (194,'SALINAS',20),
 (195,'SANTO DOMINGO',21),
 (196,'LAGO AGRIO',22),
 (197,'GONZALO PIZARRO',22),
 (198,'PUTUMAYO',22),
 (199,'SHUSHUFINDI',22),
 (200,'SUCUMBÍOS',22),
 (201,'CASCALES',22),
 (202,'CUYABENO',22),
 (203,'AMBATO',23),
 (204,'BAÑOS DE AGUA SANTA',23),
 (205,'CEVALLOS',23),
 (206,'MOCHA',23),
 (207,'PATATE',23),
 (208,'QUERO',23),
 (209,'SAN PEDRO DE PELILEO',23),
 (210,'SANTIAGO DE PÍLLARO',23),
 (211,'TISALEO',23),
 (212,'ZAMORA',24),
 (213,'CHINCHIPE',24),
 (214,'NANGARITZA',24),
 (215,'YACUAMBI',24);
INSERT INTO `mfo_ciudad` (`id_ciudad`,`nombre`,`id_provincia`) VALUES 
 (216,'YANTZAZA (YANZATZA)',24),
 (217,'EL PANGUI',24),
 (218,'CENTINELA DEL CÓNDOR',24),
 (219,'PALANDA',24),
 (220,'PAQUISHA',24);
/*!40000 ALTER TABLE `mfo_ciudad` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_convenio_univ`
--

DROP TABLE IF EXISTS `mfo_convenio_univ`;
CREATE TABLE `mfo_convenio_univ` (
  `id_convenio_univ` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL COMMENT 'Nombre de la universidad con las que se tiene convenios',
  `iso` varchar(15) DEFAULT NULL COMMENT 'Abreviatura de la universidad',
  `id_pais` int(11) NOT NULL COMMENT 'Campo para saber a que pais pertenece la universidad',
  `convenio` tinyint(4) NOT NULL COMMENT 'Campo para saber si la universidad tiene o no convenio',
  PRIMARY KEY (`id_convenio_univ`),
  KEY `fk_mfo_convenio_univ_mfo_pais1` (`id_pais`),
  CONSTRAINT `fk_mfo_convenio_univ_mfo_pais1` FOREIGN KEY (`id_pais`) REFERENCES `mfo_pais` (`id_pais`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_convenio_univ`
--

/*!40000 ALTER TABLE `mfo_convenio_univ` DISABLE KEYS */;
INSERT INTO `mfo_convenio_univ` (`id_convenio_univ`,`Nombre`,`iso`,`id_pais`,`convenio`) VALUES 
 (1,'Universidad de Cuenca','UCUENCA',1,0),
 (2,'Escuela Sup. Politécnica del Litoral','ESPOL',1,0),
 (3,'Universidad Agraria del Ecuador','Guayaquil',1,0),
 (4,'Universidad de Guayaquil','UG',1,0),
 (5,'Universidad Estatal de Milagro','UNEMI',1,0),
 (6,'Univ. Estatal Península de Santa Elena','UPSE',1,0),
 (7,'Universidad Casa Grande','Guayaquil',1,0),
 (8,'Universidad Cat. de Sgo. de Guayaquil','UCSG',1,0),
 (9,'Universidad San Francisco de Quito','USFQ',1,0),
 (10,'Universidad Santa María','USM',1,0),
 (11,'Universidad del Pacifico Escuela de Negocios','Guayaquil',1,0),
 (12,'Univ. Laica Vicente Rocafuerte de Guayaquil','Guayaquil',1,0),
 (13,'Universidad Metropolitana','UMETRO',1,0),
 (14,'Univ. Naval Rafael Moran Valverde','UNINAV',1,0),
 (15,'Univ. de Especialidades Espíritu Santo','UEES',1,0),
 (16,'Universidad Tecnológica Ecotec','Guayaquil',1,0),
 (17,'Univ. Tecnológ. Empresarial de Guayaquil','UTEG',1,0),
 (18,'IDE Business School','Guayaquil',1,0);
INSERT INTO `mfo_convenio_univ` (`id_convenio_univ`,`Nombre`,`iso`,`id_pais`,`convenio`) VALUES 
 (19,'Universidad Nacional de Loja','UNL',1,0),
 (20,'Escuela Sup. Pol. Ecológica S. M. Ludeña','ESPEC',1,0),
 (21,'Universidad Técnica Particular de Loja','UTPL',1,0),
 (22,'Universidad Técnica de Babahoyo','UTB',1,0),
 (23,'Universidad Técnica Estatal de Quevedo','UTEQ',1,0),
 (24,'Esc. Sup. Politéc. Ecológica Amazónica','ESPEA',1,0),
 (25,'Esc. Sup. Pol. Agropecuaria de Manabi','ESPAM',1,0),
 (26,'Universidad Estatal del Sur de Manabi','Jipijapa',1,0),
 (27,'Universidad Laica E. Alfaro de Manabi','ULEAM',1,0),
 (28,'Universidad Técnica de Manabi','UTM',1,0),
 (29,'Universidad San Gregorio de Portoviejo','Portoviejo',1,0),
 (30,'Escuela Sup. Politécnica del Litoral','ESPOL',1,0),
 (31,'Escuela Politécnica del Ejercito','ESPE',1,0),
 (32,'Escuela Politécnica Nacional','EPN',1,0),
 (33,'Facultad Latinoamericana de Cs. Soc.','FLACSO',1,0),
 (34,'Instituto de Altos Estudios Nacionales','IAEN',1,0),
 (35,'Universidad Andina Simón Bolívar','UASB',1,0);
INSERT INTO `mfo_convenio_univ` (`id_convenio_univ`,`Nombre`,`iso`,`id_pais`,`convenio`) VALUES 
 (36,'Universidad Central del Ecuador','UCE',1,0),
 (37,'Esc. Politécnica Javeriana del Ecuador','ESPOJ',1,0),
 (38,'Pontificia Univ. Católica del Ecuador','PUCE',1,0),
 (39,'Universidad Alfredo Pérez Guerrero','UNAP',1,0),
 (40,'Universidad Cristiana Latinoamericana','UCL',1,0),
 (41,'Universidad de Especialidades Turísticas','UCT',1,0),
 (42,'Universidad Tecnológica Indoamerica','UTI',1,0),
 (43,'Universidad Indoamérica','Quito',1,0),
 (44,'Esc. Sup. Politéc. Ecológica Amazónica','ESPEA',1,0),
 (45,'Universidad de Las Americas','Quito',1,0),
 (46,'Universidad de Los Hemisferios','Quito',1,0),
 (47,'Univ. Iberoamericana del Ecuador','UNIBE',1,0),
 (48,'IDE Business School','Quito',1,0),
 (49,'Universidad Internacional del Ecuador','UIDE',1,0),
 (50,'Universidad Og Mandino','UOM',1,0),
 (51,'Universidad Particular Internacional Sek','UISEK',1,0),
 (52,'Universidad San Francisco de Quito','USFQ',1,0),
 (53,'Universidad Tecnológica América','UNITA',1,0);
INSERT INTO `mfo_convenio_univ` (`id_convenio_univ`,`Nombre`,`iso`,`id_pais`,`convenio`) VALUES 
 (54,'Universidad Tecnológica Equinoccial','UTE',1,0),
 (55,'Universidad Tecnológica Israel','UTI',1,0),
 (56,'Univ. Interc. de las Nac. y Pueblos Indig. A. Wasi','Quito',1,0),
 (57,'Universidad de las Américas','UDLA',1,0),
 (58,'Universidad Metropolitana','UMETRO',1,0),
 (59,'Universidad del Pacifico Escuela de Negocios','Quito',1,0),
 (60,'Universidad Estatal Amazónica','UEA',1,0),
 (61,'Universidad Técnica de Ambato','UTA',1,0),
 (62,'Universidad Regional Autónoma de Los Andes','Ambato',1,0),
 (63,'Universidad Tecnológica Indoamerica','UTI',1,0),
 (64,'Universidad Católica de Cuenca','UCACUE',1,0),
 (65,'Universidad del Azuay','UAZUAY',1,0),
 (66,'Universidad Panamericana de Cuenca','UPC',1,0),
 (67,'Universidad Politécnica Salesiana','UPS',1,0),
 (68,'Universidad Estatal de Bolívar','UEB',1,0),
 (69,'Universidad Politécnica Estatal del Carchi','UPEC',1,0),
 (70,'Escuela Sup. Politécnica de Chimborazo','ESPOCH',1,0),
 (71,'Universidad Nacional de Chimborazo','UNACH ',1,0);
INSERT INTO `mfo_convenio_univ` (`id_convenio_univ`,`Nombre`,`iso`,`id_pais`,`convenio`) VALUES 
 (72,'Univ. Interamericana del Ecuador','UNIDEC',1,0),
 (73,'Universidad Técnica de Cotopaxi','UTC',1,0),
 (74,'Universidad Técnica de Machala','Machala',1,0),
 (75,'Universidad Tecnológica S. A. de Machala','UTSAM',1,0),
 (76,'Universidad Metropolitana','UMETRO',1,0),
 (77,'Univ. Técnica L. V. T. de Esmeraldas','UTELVT',1,0),
 (78,'Universidad Técnica del Norte','UTN',1,0),
 (79,'Universidad de Otavalo','Otavalo',1,0);
/*!40000 ALTER TABLE `mfo_convenio_univ` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_cuestionario`
--

DROP TABLE IF EXISTS `mfo_cuestionario`;
CREATE TABLE `mfo_cuestionario` (
  `id_cuestionario` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del cuestionario',
  `nombre` varchar(45) DEFAULT NULL COMMENT 'Nombre del cuestionario',
  PRIMARY KEY (`id_cuestionario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_cuestionario`
--

/*!40000 ALTER TABLE `mfo_cuestionario` DISABLE KEYS */;
INSERT INTO `mfo_cuestionario` (`id_cuestionario`,`nombre`) VALUES 
 (1,'Interés personal social'),
 (2,'Interés personal cognitivo'),
 (3,'Interés personal emocional');
/*!40000 ALTER TABLE `mfo_cuestionario` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_descarga`
--

DROP TABLE IF EXISTS `mfo_descarga`;
CREATE TABLE `mfo_descarga` (
  `id_descarga` int(11) NOT NULL AUTO_INCREMENT,
  `id_infohv` int(11) NOT NULL COMMENT 'Identificador de la hoja de vida del candidato',
  `id_empresa` int(11) NOT NULL COMMENT 'Empresa que realiza las descargas de Hv de los candidatos',
  PRIMARY KEY (`id_descarga`),
  KEY `fk_mfo_descarga_mfo_infohv1` (`id_infohv`),
  KEY `fk_mfo_descarga_mfo_usuario1` (`id_empresa`),
  CONSTRAINT `fk_mfo_descarga_mfo_infohv1` FOREIGN KEY (`id_infohv`) REFERENCES `mfo_infohv` (`id_infohv`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_descarga_mfo_usuario1` FOREIGN KEY (`id_empresa`) REFERENCES `mfo_usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_descarga`
--

/*!40000 ALTER TABLE `mfo_descarga` DISABLE KEYS */;
/*!40000 ALTER TABLE `mfo_descarga` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_escolaridad`
--

DROP TABLE IF EXISTS `mfo_escolaridad`;
CREATE TABLE `mfo_escolaridad` (
  `id_escolaridad` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la tabla escolaridad',
  `descripcion` varchar(45) NOT NULL COMMENT 'Categoria de la escolaridad',
  `dependencia` tinyint(4) NOT NULL COMMENT 'Campo para saber si la escolaridad depende de una lista de convenios',
  PRIMARY KEY (`id_escolaridad`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_escolaridad`
--

/*!40000 ALTER TABLE `mfo_escolaridad` DISABLE KEYS */;
INSERT INTO `mfo_escolaridad` (`id_escolaridad`,`descripcion`,`dependencia`) VALUES 
 (1,'Primaria',0),
 (2,'Bachiller',0),
 (3,'Técnico',0),
 (4,'Universitario',0),
 (5,'Masrter',0),
 (6,'PHD',0);
/*!40000 ALTER TABLE `mfo_escolaridad` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_for_mej`
--

DROP TABLE IF EXISTS `mfo_for_mej`;
CREATE TABLE `mfo_for_mej` (
  `id_fm` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la tabla',
  `nombre` varchar(200) NOT NULL COMMENT 'Descripcion del resultado de la pregunta',
  `max_rango` int(2) NOT NULL COMMENT 'Número maximo del rango a evaluar',
  `min_rango` int(2) NOT NULL COMMENT 'Número minimo del rango a evaluar',
  `id_tipo_for_mej` int(11) NOT NULL COMMENT '1.- Fortalezas y 2.- Mejoras',
  `id_rasgo` int(11) NOT NULL COMMENT 'Identificador del rasgo',
  PRIMARY KEY (`id_fm`),
  KEY `fk_mfo_for_mej_mfo_rasgo1` (`id_rasgo`),
  CONSTRAINT `fk_mfo_for_mej_mfo_rasgo1` FOREIGN KEY (`id_rasgo`) REFERENCES `mfo_rasgo` (`id_rasgo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=248 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_for_mej`
--

/*!40000 ALTER TABLE `mfo_for_mej` DISABLE KEYS */;
INSERT INTO `mfo_for_mej` (`id_fm`,`nombre`,`max_rango`,`min_rango`,`id_tipo_for_mej`,`id_rasgo`) VALUES 
 (1,'Capaz',25,19,1,1),
 (2,'Sociable',25,19,1,1),
 (3,'Facilidad de expresión',25,19,1,1),
 (4,'Optimismo',25,19,1,1),
 (5,'Enérgico',25,19,1,1),
 (6,'Jovial',25,19,1,1),
 (7,'Positivo',18,12,1,1),
 (8,'Motivación interna',18,12,1,1),
 (9,'Inteligencia emocional',18,12,1,1),
 (10,'Equilibrado',18,12,1,1),
 (11,'Responsable',18,12,1,1),
 (12,'Auto critica',18,12,1,1),
 (13,'Callado',11,5,1,1),
 (14,'Introspección',11,5,1,1),
 (15,'Auto evaluación',11,5,1,1),
 (16,'Concentración',11,5,1,1),
 (17,'Orden',11,5,1,1),
 (18,'Individualismo',25,19,2,1),
 (19,'Puede ser muy confiado',25,19,2,1),
 (20,'Debe tomarse pausas al hablar',25,19,2,1),
 (21,'Debe tomarse las cosas con calma',25,19,2,1),
 (22,'No piensa antes de actuar.',25,19,2,1),
 (23,'Muy arriesgado',18,12,2,1),
 (24,'No aprovecha los estímulos externos',18,12,2,1),
 (25,'Puede no ser flexible',18,12,2,1),
 (26,'Se desorienta si su estructura se moviliza',18,12,2,1),
 (27,'Es duro consigo mismo',18,12,2,1);
INSERT INTO `mfo_for_mej` (`id_fm`,`nombre`,`max_rango`,`min_rango`,`id_tipo_for_mej`,`id_rasgo`) VALUES 
 (28,'Necesita socializar mas',11,5,2,1),
 (29,'Vive en un mundo interno',11,5,2,1),
 (30,'Se juzga y califica',11,5,2,1),
 (31,'Visión de túnel',11,5,2,1),
 (32,'No tolera la desorganización',11,5,2,1),
 (33,'Organizado',25,19,1,2),
 (34,'Acciona',25,19,1,2),
 (35,'Manejo de emociones',25,19,1,2),
 (36,'Resolución de conflictos',25,19,1,2),
 (37,'Empatía',25,19,1,2),
 (38,'Cortez',25,19,1,2),
 (39,'Búsqueda de nuevas emociones',25,19,1,2),
 (40,'Buena autoestima',18,12,1,2),
 (41,'Proporcionado',18,12,1,2),
 (42,'Acompañante',18,12,1,2),
 (43,'Contraparte',18,12,1,2),
 (44,'Resiliencia',18,12,1,2),
 (45,'Flexibilidad',11,5,1,2),
 (46,'Cumplimiento de objetivos a corto plazo',11,5,1,2),
 (47,'Mundo exterior armónico',11,5,1,2),
 (48,'Frio y calculador',11,5,1,2),
 (49,'Flexibilidad',25,19,2,2),
 (50,'Se involucra emocionalmente',25,19,2,2),
 (51,'Rigidez en las normas',25,19,2,2),
 (52,'Ser más individual',18,12,2,2);
INSERT INTO `mfo_for_mej` (`id_fm`,`nombre`,`max_rango`,`min_rango`,`id_tipo_for_mej`,`id_rasgo`) VALUES 
 (53,'Impuntualidad',18,12,2,2),
 (54,'Cortesía',18,12,2,2),
 (55,'Cumplimiento de metas',18,12,2,2),
 (56,'Planificación',18,12,2,2),
 (57,'Toma de decisiones',11,5,2,2),
 (58,'Solución de problemas',11,5,2,2),
 (59,'Empatía',11,5,2,2),
 (60,'Jerarquizar',11,5,2,2),
 (61,'Autoestima',11,5,2,2),
 (62,'Expresivo',25,19,1,3),
 (63,'Asertivo',25,19,1,3),
 (64,'Comunicador',25,19,1,3),
 (65,'Comprensible',25,19,1,3),
 (66,'Receptor',25,19,1,3),
 (67,'Vocabulario amplio',18,12,1,3),
 (68,'Memoria',18,12,1,3),
 (69,'Expresión corporal',18,12,1,3),
 (70,'Seguridad',18,12,1,3),
 (71,'Consciencia de su interior',11,5,1,3),
 (72,'Concentración',11,5,1,3),
 (73,'Manejo de métodos de comunicación no verbales',11,5,1,3),
 (74,'Bueno para trabajos individuales',11,5,1,3),
 (75,'Egocentrismo',25,19,2,3),
 (76,'Concentración',25,19,2,3),
 (77,'Selección de tareas',25,19,2,3),
 (78,'Proyección',25,19,2,3),
 (79,'Vías de comunicación',18,12,2,3);
INSERT INTO `mfo_for_mej` (`id_fm`,`nombre`,`max_rango`,`min_rango`,`id_tipo_for_mej`,`id_rasgo`) VALUES 
 (80,'Mediación',18,12,2,3),
 (81,'Aceptación del yo',18,12,2,3),
 (82,'Expresión corporal',18,12,2,3),
 (83,'Comunicación',11,5,2,3),
 (84,'Seguridad',11,5,2,3),
 (85,'Recepción de información',11,5,2,3),
 (86,'Solución de conflictos',25,19,1,4),
 (87,'Superación de obstáculos',25,19,1,4),
 (88,'Correcto',25,19,1,4),
 (89,'Optimismo',25,19,1,4),
 (90,'Habilidad matemática',25,19,1,4),
 (91,'Adaptación',25,19,1,4),
 (92,'Usa estrategias',18,12,1,4),
 (93,'Proactivo',18,12,1,4),
 (94,'Inteligencias múltiples',18,12,1,4),
 (95,'Seguimiento de ordenes',11,5,1,4),
 (96,'Flexibilidad ética',11,5,1,4),
 (97,'Estabilidad laboral',11,5,1,4),
 (98,'Debe analizar más probabilidades',25,19,2,4),
 (99,'Aceptación de ayuda',25,19,2,4),
 (100,'Abstracción',25,19,2,4),
 (101,'Lenguaje e interpretación verbal',25,19,2,4),
 (102,'Optimismo en extremo',25,19,2,4),
 (103,'Toma de decisiones',18,12,2,4),
 (104,'Cumplimiento de metas',18,12,2,4);
INSERT INTO `mfo_for_mej` (`id_fm`,`nombre`,`max_rango`,`min_rango`,`id_tipo_for_mej`,`id_rasgo`) VALUES 
 (105,'Pesimismo',18,12,2,4),
 (106,'Compromiso',11,5,2,4),
 (107,'Seguridad en las decisiones',11,5,2,4),
 (108,'Resolución de conflictos',11,5,2,4),
 (109,'Genialidad',25,19,1,5),
 (110,'Proyección ',25,19,1,5),
 (111,'Futurista',25,19,1,5),
 (112,'Alegre',25,19,1,5),
 (113,'Creador ',25,19,1,5),
 (114,'Pensador',18,12,1,5),
 (115,'Arte, música, teatro',18,12,1,5),
 (116,'Expresión ',18,12,1,5),
 (117,'Movimiento interno',18,12,1,5),
 (118,'Soluciona conflictos',18,12,1,5),
 (119,'Pensamiento lógico',11,5,1,5),
 (120,'Retrospectivo',11,5,1,5),
 (121,'Perfecto para los números',11,5,1,5),
 (122,'Es muy realista',11,5,1,5),
 (123,'Matemática y materias afines',25,19,2,5),
 (124,'Pisar tierra',25,19,2,5),
 (125,'Les cuesta ver la realidad',25,19,2,5),
 (126,'Controlar su jovialidad según la situación',25,19,2,5),
 (127,'Estimular la creatividad',18,12,2,5),
 (128,'El arte lo obtiene por aprendizaje',18,12,2,5),
 (129,'Motivación',11,5,2,5);
INSERT INTO `mfo_for_mej` (`id_fm`,`nombre`,`max_rango`,`min_rango`,`id_tipo_for_mej`,`id_rasgo`) VALUES 
 (130,'Imaginación',11,5,2,5),
 (131,'Creación o invención',11,5,2,5),
 (132,'Visión del futuro',11,5,2,5),
 (133,'Altos estándares',25,19,1,6),
 (134,'Objetivos personales unidos a los organizacionales',25,19,1,6),
 (135,'Auto desafío',25,19,1,6),
 (136,'Arriesgado',25,19,1,6),
 (137,'Auto direccionamiento',25,19,1,6),
 (138,'Movimiento constante',25,19,1,6),
 (139,'Sentido de pertenencia',18,12,1,6),
 (140,'Positivismo',18,12,1,6),
 (141,'Resistencia a la frustración',18,12,1,6),
 (142,'Luchador',18,12,1,6),
 (143,'Metas cortas',11,5,1,6),
 (144,'Compromiso real',11,5,1,6),
 (145,'Plasticidad en sus estándares ',11,5,1,6),
 (146,'Humildad',25,19,2,6),
 (147,'Velar por objetivos personales',25,19,2,6),
 (148,'Flexibilidad de sus estándares',25,19,2,6),
 (149,'Luchar por objetivos grupales',18,12,2,6),
 (150,'Debe gustarle lo que hace ',18,12,2,6),
 (151,'Tomar acción ante las situaciones estresantes',18,12,2,6),
 (152,'Tomar compromisos más grandes',11,5,2,6);
INSERT INTO `mfo_for_mej` (`id_fm`,`nombre`,`max_rango`,`min_rango`,`id_tipo_for_mej`,`id_rasgo`) VALUES 
 (153,'Tener metas a mediano y largo plazo',11,5,2,6),
 (154,'Culminar las tareas',11,5,2,6),
 (155,'Confianza',25,19,1,7),
 (156,'Multitasking (puede realizar múltiples actividades)',25,19,1,7),
 (157,'Eficaz',25,19,1,7),
 (158,'Comprometido',25,19,1,7),
 (159,'Responsabilidad',25,19,1,7),
 (160,'Puntualidad',18,12,1,7),
 (161,'Moral',18,12,1,7),
 (162,'Ética',18,12,1,7),
 (163,'Honesto',18,12,1,7),
 (164,'No se arriesga más de lo necesario',11,5,1,7),
 (165,'No asume más de lo que puede lograr',11,5,1,7),
 (166,'Respetuoso',11,5,1,7),
 (167,'Solidario',11,5,1,7),
 (168,'Tomar actividades especificas',25,19,2,7),
 (169,'Eficiencia',25,19,2,7),
 (170,'Equilibrio entre trabajo y familia',25,19,2,7),
 (171,'Plasticidad legal (adaptabilidad)',18,12,2,7),
 (172,'Prestar más atención a sus superiores',18,12,2,7),
 (173,'Sentido de pertenencia',18,12,2,7),
 (174,'Honestidad',11,5,2,7),
 (175,'Estabilidad laboral',11,5,2,7);
INSERT INTO `mfo_for_mej` (`id_fm`,`nombre`,`max_rango`,`min_rango`,`id_tipo_for_mej`,`id_rasgo`) VALUES 
 (176,'Vínculo emocional',11,5,2,7),
 (177,'Motivación',25,19,1,8),
 (178,'Promotor de actividad',25,19,1,8),
 (179,'Guía',25,19,1,8),
 (180,'Éxito grupal',25,19,1,8),
 (181,'Alegría',25,19,1,8),
 (182,'Direccionado al progreso',18,12,1,8),
 (183,'Visualiza claramente el futuro',18,12,1,8),
 (184,'Esfuerzo',18,12,1,8),
 (185,'Logro de metas',18,12,1,8),
 (186,'Liderazgo',11,5,1,8),
 (187,'Persuasión',11,5,1,8),
 (188,'Constante',11,5,1,8),
 (189,'Dependencia de un equipo solido',25,19,2,8),
 (190,'Puede ser mal interpretado',25,19,2,8),
 (191,'Trabajar menos individualmente',18,12,2,8),
 (192,'Pertenecer a grupos',18,12,2,8),
 (193,'Movilidad',18,12,2,8),
 (194,'No cometer los mismos errores',11,5,2,8),
 (195,'Innovar',11,5,2,8),
 (196,'Compromiso emocional',25,19,1,9),
 (197,'Estabilidad emocional',25,19,1,9),
 (198,'Cumplidor',25,19,1,9),
 (199,'Desea compromiso',25,19,1,9),
 (200,'Selectivo',18,12,1,9);
INSERT INTO `mfo_for_mej` (`id_fm`,`nombre`,`max_rango`,`min_rango`,`id_tipo_for_mej`,`id_rasgo`) VALUES 
 (201,'Flexibilidad moral',18,12,1,9),
 (202,'Trabajo en casa',18,12,1,9),
 (203,'Trabajar lejos de casa',11,5,1,9),
 (204,'Trabajo que necesite viajar ',11,5,1,9),
 (205,'Compromiso con objetivos propios',11,5,1,9),
 (206,'Superación del duelo',25,19,2,9),
 (207,'Superación de la frustración',25,19,2,9),
 (208,'Cumplimiento de horarios',18,12,2,9),
 (209,'Pasión',18,12,2,9),
 (210,'Ética',18,12,2,9),
 (211,'Familiaridad',11,5,2,9),
 (212,'Uso de contratos',11,5,2,9),
 (213,'Búsqueda de ambientes libres de estrés',25,19,1,10),
 (214,'Se toma su tiempo',25,19,1,10),
 (215,'Trasmite energía positiva',25,19,1,10),
 (216,'Confianza en sí mismo',18,12,1,10),
 (217,'Ayuda a otros a superar el estrés',18,12,1,10),
 (218,'Olvida recuerdos negativos',18,12,1,10),
 (219,'Trabajo bajo presión',11,5,1,10),
 (220,'Competitivo',11,5,1,10),
 (221,'Control de impulsos',11,5,1,10),
 (222,'Control emocional ',11,5,1,10),
 (223,'Gestión de emociones',25,19,2,10);
INSERT INTO `mfo_for_mej` (`id_fm`,`nombre`,`max_rango`,`min_rango`,`id_tipo_for_mej`,`id_rasgo`) VALUES 
 (224,'Cumplimiento de metas a corto plazo',25,19,2,10),
 (225,'Apatía',18,12,2,10),
 (226,'Flexibilidad',18,12,2,10),
 (227,'Superar huellas del pasado',18,12,2,10),
 (228,'Escogencia de tareas',11,5,2,10),
 (229,'Ver todo como competencia',11,5,2,10),
 (230,'Acepta opiniones',25,19,1,11),
 (231,'Reconocimiento',25,19,1,11),
 (232,'Búsqueda de estímulo constante',25,19,1,11),
 (233,'Busca aprobación en superiores ',25,19,1,11),
 (234,'No es conflictivo',18,12,1,11),
 (235,'Es amiguero',18,12,1,11),
 (236,'Sabe reforzar',18,12,1,11),
 (237,'Trabajo por el bien común',18,12,1,11),
 (238,'Auto motivado',11,5,1,11),
 (239,'Rápida superación del duelo',11,5,1,11),
 (240,'Autogestión ',11,5,1,11),
 (241,'Dependencia',25,19,2,11),
 (242,'Se afecta por los comentarios',25,19,2,11),
 (243,'Buscar estímulos internos',25,19,2,11),
 (244,'Puede ser egoísta',18,12,2,11),
 (245,'Atención ',18,12,2,11),
 (246,'Aceptación de consejos y guía',11,5,2,11);
INSERT INTO `mfo_for_mej` (`id_fm`,`nombre`,`max_rango`,`min_rango`,`id_tipo_for_mej`,`id_rasgo`) VALUES 
 (247,'Establecer lazos más duraderos',11,5,2,11);
/*!40000 ALTER TABLE `mfo_for_mej` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_idioma`
--

DROP TABLE IF EXISTS `mfo_idioma`;
CREATE TABLE `mfo_idioma` (
  `id_idioma` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del idioma',
  `descripcion` varchar(45) DEFAULT NULL COMMENT 'Nombre del idioma',
  PRIMARY KEY (`id_idioma`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_idioma`
--

/*!40000 ALTER TABLE `mfo_idioma` DISABLE KEYS */;
INSERT INTO `mfo_idioma` (`id_idioma`,`descripcion`) VALUES 
 (1,'Español'),
 (2,'Inglés');
/*!40000 ALTER TABLE `mfo_idioma` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_infohv`
--

DROP TABLE IF EXISTS `mfo_infohv`;
CREATE TABLE `mfo_infohv` (
  `id_infohv` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_creacion` datetime NOT NULL COMMENT 'Fecha en el que se cargo la hv o fue visto',
  `formato` varchar(10) NOT NULL COMMENT 'Formato en el que se puede guardar la hoja de vida',
  `id_usuario` int(11) NOT NULL COMMENT 'Usuario al que le pertenece la hoja de vida',
  PRIMARY KEY (`id_infohv`),
  KEY `fk_mfo_infohv_mfo_usuario1` (`id_usuario`),
  CONSTRAINT `fk_mfo_infohv_mfo_usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `mfo_usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_infohv`
--

/*!40000 ALTER TABLE `mfo_infohv` DISABLE KEYS */;
/*!40000 ALTER TABLE `mfo_infohv` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_informe`
--

DROP TABLE IF EXISTS `mfo_informe`;
CREATE TABLE `mfo_informe` (
  `id_informe` int(11) NOT NULL COMMENT 'Identificador de la tabla',
  `infome` text NOT NULL COMMENT 'Todo el contenido del informe por cuestionario',
  `fecha` datetime NOT NULL COMMENT 'Fecha en la que se registro la generacion del informe',
  `id_cuestionario` int(11) NOT NULL COMMENT 'Cuestionario al que pertenece dicho informe',
  `id_usuario` int(11) NOT NULL COMMENT 'Candidato que genero un informe',
  PRIMARY KEY (`id_informe`),
  KEY `fk_mfo_informe_test1` (`id_cuestionario`),
  KEY `fk_mfo_informe_mfo_usuario1` (`id_usuario`),
  CONSTRAINT `fk_mfo_informe_mfo_usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `mfo_usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_informe_test1` FOREIGN KEY (`id_cuestionario`) REFERENCES `mfo_cuestionario` (`id_cuestionario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_informe`
--

/*!40000 ALTER TABLE `mfo_informe` DISABLE KEYS */;
/*!40000 ALTER TABLE `mfo_informe` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_jornada`
--

DROP TABLE IF EXISTS `mfo_jornada`;
CREATE TABLE `mfo_jornada` (
  `id_jornada` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la jornada',
  `nombre` varchar(45) NOT NULL COMMENT 'Nombre que llevara la jornada',
  PRIMARY KEY (`id_jornada`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_jornada`
--

/*!40000 ALTER TABLE `mfo_jornada` DISABLE KEYS */;
INSERT INTO `mfo_jornada` (`id_jornada`,`nombre`) VALUES 
 (1,'Por horas'),
 (2,'Medio Tiempo'),
 (3,'Tiempo completo');
/*!40000 ALTER TABLE `mfo_jornada` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_moneda`
--

DROP TABLE IF EXISTS `mfo_moneda`;
CREATE TABLE `mfo_moneda` (
  `id_moneda` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la moneda',
  `nombre` varchar(25) NOT NULL COMMENT 'Nombre que le corresponde a la moneda',
  `simbolo` varchar(4) NOT NULL COMMENT 'Simbolo representativo de la moneda',
  PRIMARY KEY (`id_moneda`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_moneda`
--

/*!40000 ALTER TABLE `mfo_moneda` DISABLE KEYS */;
INSERT INTO `mfo_moneda` (`id_moneda`,`nombre`,`simbolo`) VALUES 
 (1,'Dolar','$'),
 (2,'Pesos colombianos','$'),
 (3,'Sol','S/');
/*!40000 ALTER TABLE `mfo_moneda` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_nivelidioma`
--

DROP TABLE IF EXISTS `mfo_nivelidioma`;
CREATE TABLE `mfo_nivelidioma` (
  `id_nivelIdioma` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la tabla',
  `nombre` varchar(45) DEFAULT NULL COMMENT 'Nombre del nivel de idioma',
  PRIMARY KEY (`id_nivelIdioma`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_nivelidioma`
--

/*!40000 ALTER TABLE `mfo_nivelidioma` DISABLE KEYS */;
INSERT INTO `mfo_nivelidioma` (`id_nivelIdioma`,`nombre`) VALUES 
 (1,'Bajo'),
 (2,'Medio'),
 (3,'Alto');
/*!40000 ALTER TABLE `mfo_nivelidioma` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_nivelidioma_idioma`
--

DROP TABLE IF EXISTS `mfo_nivelidioma_idioma`;
CREATE TABLE `mfo_nivelidioma_idioma` (
  `id_nivelIdioma_idioma` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la relacion entre el idioma el el nivel',
  `id_idioma` int(11) NOT NULL COMMENT 'Se especifica el idioma',
  `id_nivelIdioma` int(11) NOT NULL COMMENT 'Nivel al que pertenece el idioma',
  PRIMARY KEY (`id_nivelIdioma_idioma`),
  KEY `fk_mfo_nivelIdioma_has_mfo_idioma_mfo_nivelIdioma1` (`id_nivelIdioma`),
  KEY `fk_mfo_nivelIdioma_has_mfo_idioma_mfo_idioma1` (`id_idioma`),
  CONSTRAINT `fk_mfo_nivelIdioma_has_mfo_idioma_mfo_idioma1` FOREIGN KEY (`id_idioma`) REFERENCES `mfo_idioma` (`id_idioma`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_nivelIdioma_has_mfo_idioma_mfo_nivelIdioma1` FOREIGN KEY (`id_nivelIdioma`) REFERENCES `mfo_nivelidioma` (`id_nivelIdioma`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_nivelidioma_idioma`
--

/*!40000 ALTER TABLE `mfo_nivelidioma_idioma` DISABLE KEYS */;
INSERT INTO `mfo_nivelidioma_idioma` (`id_nivelIdioma_idioma`,`id_idioma`,`id_nivelIdioma`) VALUES 
 (1,1,1),
 (2,1,2),
 (3,1,3),
 (4,2,1),
 (5,2,2),
 (6,2,3);
/*!40000 ALTER TABLE `mfo_nivelidioma_idioma` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_nivelinteres`
--

DROP TABLE IF EXISTS `mfo_nivelinteres`;
CREATE TABLE `mfo_nivelinteres` (
  `id_nivelInteres` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la tabla',
  `descripcion` varchar(45) NOT NULL COMMENT 'Nombre que llevara cada nivel',
  PRIMARY KEY (`id_nivelInteres`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_nivelinteres`
--

/*!40000 ALTER TABLE `mfo_nivelinteres` DISABLE KEYS */;
INSERT INTO `mfo_nivelinteres` (`id_nivelInteres`,`descripcion`) VALUES 
 (1,'Cargos gerenciales'),
 (2,'Cargos medios'),
 (3,'Cargos básicos');
/*!40000 ALTER TABLE `mfo_nivelinteres` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_oferta`
--

DROP TABLE IF EXISTS `mfo_oferta`;
CREATE TABLE `mfo_oferta` (
  `id_ofertas` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de las ofertas ingresadas',
  `titulo` varchar(100) NOT NULL COMMENT 'Título que llevara e}la publicacion de la oferta',
  `descripcion` varchar(500) NOT NULL COMMENT 'Breve descripción de la vacante publicada',
  `salario` varchar(100) NOT NULL COMMENT 'Valor a pagar por la oferta',
  `fecha_contratacion` datetime DEFAULT NULL COMMENT 'Fecha en la que estiman contratar a un candidato',
  `vacantes` int(100) NOT NULL COMMENT 'Cantidad de vacantes disponibles parea la oferta',
  `anosexp` int(2) DEFAULT NULL COMMENT 'Cantidad de años de experiencia',
  `estado` tinyint(4) NOT NULL COMMENT 'Campo para saber si la oferta esta activa o no (1.- activa y 0.- inactiva)',
  `fecha_creado` datetime DEFAULT NULL COMMENT 'Fecha en la que se crero la publicación',
  `id_area` int(11) NOT NULL COMMENT 'Area en que se ubicara la oferta',
  `id_nivelInteres` int(11) NOT NULL COMMENT 'Nivel de la oferta',
  `id_jornada` int(11) NOT NULL COMMENT 'Identificador de la jornada de trabajo',
  `id_ciudad` int(11) unsigned NOT NULL COMMENT 'Ciudad para la cual fue hecha la oferta',
  `id_tipocontrato` int(11) NOT NULL COMMENT 'Campo para saber si el contrato es indefinido, por una cantidad especifica de meses o temporal',
  `id_requisitoOfreta` int(11) NOT NULL COMMENT 'Campos identificador de los requisitos que puede tener una oferta',
  `id_escolaridad` int(11) NOT NULL COMMENT 'Campo que muestra para que tipo de escolaridad es la oferta',
  `id_usuario` int(11) NOT NULL COMMENT 'Usuario que creo la oferta',
  `id_plan` int(11) NOT NULL COMMENT 'Plan al que pertenece la oferta',
  PRIMARY KEY (`id_ofertas`),
  KEY `fk_mfo_ofertas_mfo_area1` (`id_area`),
  KEY `fk_mfo_ofertas_mfo_nivelInteres1` (`id_nivelInteres`),
  KEY `fk_mfo_ofertas_mfo_jornada1` (`id_jornada`),
  KEY `fk_mfo_ofertas_mfo_ciudad1` (`id_ciudad`),
  KEY `fk_mfo_ofertas_mfo_tipocontrato1` (`id_tipocontrato`),
  KEY `fk_mfo_ofertas_mfo_requisitoOfreta1` (`id_requisitoOfreta`),
  KEY `fk_mfo_ofertas_mfo_escolaridad1` (`id_escolaridad`),
  KEY `fk_mfo_ofertas_mfo_usuario1` (`id_usuario`),
  KEY `fk_mfo_ofertas_mfo_plan1` (`id_plan`),
  CONSTRAINT `fk_mfo_ofertas_mfo_area1` FOREIGN KEY (`id_area`) REFERENCES `mfo_area` (`id_area`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_ofertas_mfo_ciudad1` FOREIGN KEY (`id_ciudad`) REFERENCES `mfo_ciudad` (`id_ciudad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_ofertas_mfo_escolaridad1` FOREIGN KEY (`id_escolaridad`) REFERENCES `mfo_escolaridad` (`id_escolaridad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_ofertas_mfo_jornada1` FOREIGN KEY (`id_jornada`) REFERENCES `mfo_jornada` (`id_jornada`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_ofertas_mfo_nivelInteres1` FOREIGN KEY (`id_nivelInteres`) REFERENCES `mfo_nivelinteres` (`id_nivelInteres`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_ofertas_mfo_plan1` FOREIGN KEY (`id_plan`) REFERENCES `mfo_plan` (`id_plan`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_ofertas_mfo_requisitoOfreta1` FOREIGN KEY (`id_requisitoOfreta`) REFERENCES `mfo_requisitoofreta` (`id_requisitoOfreta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_ofertas_mfo_tipocontrato1` FOREIGN KEY (`id_tipocontrato`) REFERENCES `mfo_tipocontrato` (`id_tipocontrato`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_ofertas_mfo_usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `mfo_usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_oferta`
--

/*!40000 ALTER TABLE `mfo_oferta` DISABLE KEYS */;
/*!40000 ALTER TABLE `mfo_oferta` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_opcion`
--

DROP TABLE IF EXISTS `mfo_opcion`;
CREATE TABLE `mfo_opcion` (
  `id_opcion` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de las opciones de respuestas configuradas en el sistema',
  `descripcion` varchar(50) NOT NULL COMMENT 'Nombre de la opcion (respuesta) que constituira la pregunta',
  PRIMARY KEY (`id_opcion`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_opcion`
--

/*!40000 ALTER TABLE `mfo_opcion` DISABLE KEYS */;
INSERT INTO `mfo_opcion` (`id_opcion`,`descripcion`) VALUES 
 (1,'Completamente falso'),
 (2,'Ni verdadero ni falso'),
 (3,'Bastante falso'),
 (4,'Bastante verdadero'),
 (5,'Completamente');
/*!40000 ALTER TABLE `mfo_opcion` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_opcion_respuesta`
--

DROP TABLE IF EXISTS `mfo_opcion_respuesta`;
CREATE TABLE `mfo_opcion_respuesta` (
  `id_opcion_respuesta` int(1) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la opcion',
  `id_opcion` int(11) NOT NULL COMMENT 'Identificador de la opcion',
  `id_pre` int(11) NOT NULL COMMENT 'Identificador de la pregunta al que se le configurara las opciones de respuesta',
  `orden` int(1) NOT NULL COMMENT 'Orden en que se presentan las opciones',
  PRIMARY KEY (`id_opcion_respuesta`),
  KEY `fk_mfo_opcion_respuesta_mfo_opcion1` (`id_opcion`),
  KEY `fk_mfo_opcion_respuesta_mfo_pregunta1` (`id_pre`),
  CONSTRAINT `fk_mfo_opcion_respuesta_mfo_opcion1` FOREIGN KEY (`id_opcion`) REFERENCES `mfo_opcion` (`id_opcion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_opcion_respuesta_mfo_pregunta1` FOREIGN KEY (`id_pre`) REFERENCES `mfo_pregunta` (`id_pre`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_opcion_respuesta`
--

/*!40000 ALTER TABLE `mfo_opcion_respuesta` DISABLE KEYS */;
/*!40000 ALTER TABLE `mfo_opcion_respuesta` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_pais`
--

DROP TABLE IF EXISTS `mfo_pais`;
CREATE TABLE `mfo_pais` (
  `id_pais` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del país registrado',
  `nombre` varchar(45) NOT NULL COMMENT 'Nombre del pais en el que este el usuario',
  `dominio` varchar(45) NOT NULL COMMENT 'Url del sistema comprado en cada pais',
  `icono` varchar(45) DEFAULT NULL COMMENT 'Imagen que representa al pais ',
  `logo` varchar(45) NOT NULL COMMENT 'Logo del sistema dependiendo del pais',
  `iso` varchar(45) DEFAULT NULL COMMENT 'Abreviatura del nombre del pais',
  `id_moneda` int(11) NOT NULL COMMENT 'Identificador de la moneda que representa el pais',
  PRIMARY KEY (`id_pais`),
  KEY `fk_mfo_pais_mfo_moneda1` (`id_moneda`),
  CONSTRAINT `fk_mfo_pais_mfo_moneda1` FOREIGN KEY (`id_moneda`) REFERENCES `mfo_moneda` (`id_moneda`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_pais`
--

/*!40000 ALTER TABLE `mfo_pais` DISABLE KEYS */;
INSERT INTO `mfo_pais` (`id_pais`,`nombre`,`dominio`,`icono`,`logo`,`iso`,`id_moneda`) VALUES 
 (1,'Ecuador','micamello.com.ec','ecu.png','logo.png','EC',1),
 (2,'Colombia','micamello.com.ec','col.png','logo.png','CO',2),
 (3,'Perú','micamello.com.ec','peru.png','logo.png','PE',3);
/*!40000 ALTER TABLE `mfo_pais` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_parametro`
--

DROP TABLE IF EXISTS `mfo_parametro`;
CREATE TABLE `mfo_parametro` (
  `id_parametros` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del parametro a configurar',
  `nombre` varchar(100) NOT NULL COMMENT 'Nombre del parametro a configurar',
  `descripcion` text NOT NULL COMMENT 'Texto o valor del parametro',
  PRIMARY KEY (`id_parametros`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_parametro`
--

/*!40000 ALTER TABLE `mfo_parametro` DISABLE KEYS */;
INSERT INTO `mfo_parametro` (`id_parametros`,`nombre`,`descripcion`) VALUES 
 (1,'introduccionInforme','El informe arrojado después de aplicar nuestras escalas de valoración esta creado para ampliar el conocimiento sobre el aspirante a un cargo especifico, si bien existen personalidades más o menos adecuadas para algunos cargos, es importante entender que esté por encima o por debajo del punto de inflexión el candidato no es bueno o malo, el punto de inflexión al que hacemos referencia, es el punto medio en nuestra escala de valoración, donde se ubica el promedio de la población, según los estudios realizados._saltoLinea_Los perfiles de personalidad presentados son una mirada al interior de un candidato, es la aproximación a la realidad que no es visible._saltoLinea_Entendiendo esto no debemos juzgar ni calificar a los aspirantes después de leer el informe, es bueno comprender que cada candidato es diferente y posee rasgos cognitivos y conductuales distintos los cuales los predisponen a ser mejores que otros en algunos cargos, otro factor a considerar es que cualquier individuo sin importar el resultado de este informe es capaz de desarrollar actividades y adaptarse a las exigencias del trabajo, algunos con más rapidez que otros, pero en definitiva todos pueden lograrlo._saltoLinea_Debemos ser objetivos y analizar las características conductuales que deseamos en nuestro personal a contratar, estudiar cual será más productivo para nuestra empresa y escoger sin prejuicios._saltoLinea_El conocimiento es un instrumento poderoso, que colocamos en sus manos, es de vital importancia que la información no sea divulgada ni usada para el desprestigio del aspirante._saltoLinea_Los informes arrojados contienen afirmaciones positivas sobre la personalidad del candidato, hacer caso omiso a cualquier afirmación con la cual no se sienta identificado.'),
 (2,'introCaracteristica','Basado en las respuestas de _nombreAspirante_ se presenta el siguiente cuadro con características que lo definen, estas son interpretadas individualmente y correlacionadas entre si para una mejor comprensión.');
/*!40000 ALTER TABLE `mfo_parametro` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_permisoplan`
--

DROP TABLE IF EXISTS `mfo_permisoplan`;
CREATE TABLE `mfo_permisoplan` (
  `id_permisoPlan` int(11) NOT NULL COMMENT 'Identificador de la tabla',
  `id_plan` int(11) NOT NULL COMMENT 'Paln al que le corresponden la acciones',
  `id_accionSist` int(11) NOT NULL COMMENT 'Acciones que estan relacionadas con el plan',
  PRIMARY KEY (`id_permisoPlan`),
  KEY `fk_mfo_permisoPlan_mfo_accionSist1` (`id_accionSist`),
  KEY `fk_mfo_permisoPlan_mfo_plan1` (`id_plan`),
  CONSTRAINT `fk_mfo_permisoPlan_mfo_accionSist1` FOREIGN KEY (`id_accionSist`) REFERENCES `mfo_accionsist` (`id_accionSist`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_permisoPlan_mfo_plan1` FOREIGN KEY (`id_plan`) REFERENCES `mfo_plan` (`id_plan`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_permisoplan`
--

/*!40000 ALTER TABLE `mfo_permisoplan` DISABLE KEYS */;
/*!40000 ALTER TABLE `mfo_permisoplan` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_permisoxrol`
--

DROP TABLE IF EXISTS `mfo_permisoxrol`;
CREATE TABLE `mfo_permisoxrol` (
  `id_accionxrol` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador para acceder a la relacion rol y accion del sistema',
  `id_rol` int(11) NOT NULL COMMENT 'Rol de los usuarios administradores',
  `id_accionSist` int(11) NOT NULL COMMENT 'Acciones del sistema',
  PRIMARY KEY (`id_accionxrol`),
  KEY `fk_mfo_accionxrol_mfo_rol1` (`id_rol`),
  KEY `fk_mfo_accionxrol_mfo_accionSist1` (`id_accionSist`),
  CONSTRAINT `fk_mfo_accionxrol_mfo_accionSist1` FOREIGN KEY (`id_accionSist`) REFERENCES `mfo_accionsist` (`id_accionSist`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_accionxrol_mfo_rol1` FOREIGN KEY (`id_rol`) REFERENCES `mfo_rol` (`id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_permisoxrol`
--

/*!40000 ALTER TABLE `mfo_permisoxrol` DISABLE KEYS */;
/*!40000 ALTER TABLE `mfo_permisoxrol` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_plan`
--

DROP TABLE IF EXISTS `mfo_plan`;
CREATE TABLE `mfo_plan` (
  `id_plan` int(11) NOT NULL COMMENT 'Identificador del plan',
  `nombre` varchar(100) NOT NULL COMMENT 'Nombre que llevara cada plan',
  `estado` tinyint(4) NOT NULL COMMENT '1.- activo y 0.- inactivo',
  `num_post` int(3) NOT NULL COMMENT 'Número de postulaciones configuradas por plan',
  `promocional` tinyint(4) NOT NULL COMMENT 'Campo que marcaría el plan como en promocion',
  `costo` float NOT NULL COMMENT 'Valor monetario del plan',
  `duracion` int(3) NOT NULL COMMENT 'cantidad de días que componen el plan',
  `tipo_usuario` int(1) NOT NULL COMMENT 'Especifica 1.- si es un plan para el candidato y 2.- para la empresa ',
  `tipo_plan` int(1) NOT NULL COMMENT '1.- tipo aviso y 2.- tipo plan o paquete',
  PRIMARY KEY (`id_plan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_plan`
--

/*!40000 ALTER TABLE `mfo_plan` DISABLE KEYS */;
/*!40000 ALTER TABLE `mfo_plan` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_porcentajextest`
--

DROP TABLE IF EXISTS `mfo_porcentajextest`;
CREATE TABLE `mfo_porcentajextest` (
  `id_porc` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del porcentaje por cuestionario',
  `valor` float NOT NULL COMMENT 'Valor que obtuvo en el cuestionario',
  `id_usuario` int(11) NOT NULL COMMENT 'Usuario asociado a cada resultado segun el cuestionario',
  `id_cuestionario` int(11) NOT NULL COMMENT 'Número de cuestionario al que corresponde el resultado',
  PRIMARY KEY (`id_porc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_porcentajextest`
--

/*!40000 ALTER TABLE `mfo_porcentajextest` DISABLE KEYS */;
/*!40000 ALTER TABLE `mfo_porcentajextest` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_postulacion`
--

DROP TABLE IF EXISTS `mfo_postulacion`;
CREATE TABLE `mfo_postulacion` (
  `id_auto` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` tinyint(4) NOT NULL COMMENT '1.- automatico y 2.- manual',
  `fecha_postulado` datetime NOT NULL COMMENT 'Fecha en el que se hizo el autopostulado',
  `resultado` int(3) NOT NULL COMMENT '1.- Contratado, 2.- No contradado, 3.- En proceso',
  `id_usuario` int(11) NOT NULL COMMENT 'Usuario postulado',
  `id_ofertas` int(11) NOT NULL COMMENT 'Oferta a la que fue postulado el usuario',
  PRIMARY KEY (`id_auto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_postulacion`
--

/*!40000 ALTER TABLE `mfo_postulacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `mfo_postulacion` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_pregunta`
--

DROP TABLE IF EXISTS `mfo_pregunta`;
CREATE TABLE `mfo_pregunta` (
  `id_pre` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la pregunta',
  `pregunta` varchar(250) NOT NULL COMMENT 'Redacción de la pregunta',
  `modo` varchar(50) NOT NULL COMMENT 'Permite conocer si la pregunta es 1.- directa o 2.- inversa',
  `id_cuestionario` int(11) NOT NULL COMMENT 'Número de cuestionario al que pertenece la pregunta',
  `id_rasgo` int(11) NOT NULL COMMENT 'Rasgo al que va relacionada la pregunta',
  PRIMARY KEY (`id_pre`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_pregunta`
--

/*!40000 ALTER TABLE `mfo_pregunta` DISABLE KEYS */;
INSERT INTO `mfo_pregunta` (`id_pre`,`pregunta`,`modo`,`id_cuestionario`,`id_rasgo`) VALUES 
 (1,'Me considero una persona alegre y animada.','1',1,1),
 (2,'Prefiero no decir lo que siento “para no herir” a las otras Personas.','2',1,2),
 (3,'Al hablar prefiero usar pocas palabras, ser directo y sin mucho detalle.','1',1,3),
 (4,'Me complazco mucho conversando con las personas.','1',1,1),
 (5,'En el trabajo prefiero alejarme de aquellos que se quejan por todo.','1',1,2),
 (6,'En una discusión hablo con franqueza y eso suele dolerle a quienes me rodean.','2',1,3),
 (7,'Disfruto de asistir a lugares dónde hay muchas personas.','1',1,1),
 (8,'Si fuera líder de equipo las personas han de hacer lo que deseo en el momento preciso.','2',1,2),
 (9,'En una entrevista de trabajo me interesa dejarle claro al entrevistador que no miento, por eso explico todo muy bien.','2',1,3),
 (10,'Me gusta tener mucha gente a mi lado','1',1,1),
 (11,'Una manera de probar a las personas es pidiéndole que hagan esfuerzos por mí.','2',1,2),
 (12,'La mejor forma de terminar una relación de pareja es decir “te quiero, pero lo más sano es que esta relación se acabe para no hacernos daño”.','2',1,3);
INSERT INTO `mfo_pregunta` (`id_pre`,`pregunta`,`modo`,`id_cuestionario`,`id_rasgo`) VALUES 
 (13,'Me   gustaría   tener mucha    energía   para ¨comerme    el mundo¨.','1',1,1),
 (14,'Soy de los que piensa que más vale una verdad que lástima que una mentira piadosa.','2',1,2),
 (15,'Cuando un compañero de trabajo huye de sus tareas, me enfado y con indirectas y sarcasmo le insinuó que tiene Que cambiar.','2',1,3),
 (16,'Me considero bueno en mi trabajo, porque identifico los obstáculos con mucha facilidad.','1',2,4),
 (17,'Soy capaz de aportar ideas nuevas, ante una situación difícil.','2',2,5),
 (18,'Comienzo muchas cosas que luego no termino.','2',2,6),
 (19,'Me planteo objetivos y trato de cumplirlos a como dé lugar.','1',2,7),
 (20,'En realidad, me gusta dejar las cosas tal como están.','2',2,4),
 (21,'A menudo confío en mis instintos e intuiciones.','1',2,5),
 (22,'Me desanimo con rapidez cuando las cosas no salen como yo espero.','2',2,6),
 (23,'Hago las cosas en el momento y de la forma que me lo piden.','1',2,7),
 (24,'Soy de los que cree que existen múltiples caminos para alcanzar los objetivos propuestos','1',2,4);
INSERT INTO `mfo_pregunta` (`id_pre`,`pregunta`,`modo`,`id_cuestionario`,`id_rasgo`) VALUES 
 (25,'Generalmente, sé salir de apuros por mis propios medios.','1',2,5),
 (26,'Puedo dedicar horas a un proyecto o trabajo asignado, para entregar según los criterios acordados.','1',2,6),
 (27,'Soy una persona auto disciplinada.','1',2,7),
 (28,'Sí algo no me gusta es tener que tomar decisiones que impliquen consecuencias para los demás.','1',2,4),
 (29,'Con frecuencia, me doy la oportunidad de pensar en nuevas alternativas, para resolver situaciones y problemas.','1',2,5),
 (30,'Puedo realizar tareas propias de mi cargo, sin necesidad de recibir reconocimientos o supervisión continua.','1',2,6),
 (31,'Soy consciente de mis capacidades y limitaciones ','1',2,7),
 (32,'Trato de hacer mis asignaciones con cuidado, para no tener que corregir posteriormente.','1',2,4),
 (33,'Frecuentemente busco “similitudes” y coincidencias en las Cosas cotidianas que me suceden.','1',2,5),
 (34,'Puedo decir de mí que realizo las cosas por el gusto de hacerlas lo mejor posible.','1',2,6),
 (35,'Trato de hacer mis asignaciones con cuidado, para no tener que corregir posteriormente.','2',2,7);
INSERT INTO `mfo_pregunta` (`id_pre`,`pregunta`,`modo`,`id_cuestionario`,`id_rasgo`) VALUES 
 (36,'A pesar de las múltiples actividades, siempre consigo tener entusiasmo para encarar mis labores.','1',3,8),
 (37,'Al   pensar   en   mi   último   puesto   de   trabajo, me   siento orgulloso de haber pertenecido a esa empresa pues tiene excelentes cualidades.','1',3,9),
 (38,'En mi trabajo, soy una de las pocas personas que sé hacer bien mis tareas.','2',3,10),
 (39,'Me esfuerzo para que la gente me acepte y me aprecie.','1',3,11),
 (40,'En realidad, nunca tengo como aburrirme en el trabajo, afortunadamente siempre tengo algo que hacer.','2',3,8),
 (41,'En el trabajo siempre estoy sonriente y alegre.','1',3,9),
 (42,'Por lo general, me irrita mucho no conseguir las cosas con la rapidez que deseo.','2',3,10),
 (43,'Me resulta fácil entrar en contacto con otras personas.','1',3,11),
 (44,'Siempre consigo poner en práctica nuevas maneras de hacer el trabajo que realizo.','1',3,8),
 (45,'Puedo decir de mí, que trabajo más por los resultados que por cumplir un horario.','1',3,9),
 (46,'He descubierto que me enfado con facilidad con las personas que me rodean.','2',3,10);
INSERT INTO `mfo_pregunta` (`id_pre`,`pregunta`,`modo`,`id_cuestionario`,`id_rasgo`) VALUES 
 (47,'La posibilidad de ser rechazado es desagradable para mí.','1',3,11),
 (48,'En mi vida en general hasta las cosas sencillas me inspiran a seguir adelante.','1',3,8),
 (49,'En el trabajo me cuido de tener relaciones de cordialidad y respeto con mis compañeros.','1',3,9),
 (50,'Jamás abandonaría una amistad porque sus ideas no coincidan con las mías en un cien por ciento.','1',3,10),
 (51,'Sí mi opinión difiere del resto del grupo, opto por no darla.','2',3,11),
 (52,'Me gusta presentar nuevos proyectos a mis compañeros, estoy seguro de tener la capacidad para convencerlos.','1',3,8),
 (53,'En realidad, la política de “primero el cliente” no siempre puede cumplirse, hay otras prioridades por hacer.','2',3,9),
 (54,'La vida me ha enseñado que ninguna persona es mejor o peor que otra.','1',3,10),
 (55,' Si algo me cuesta en la vida es decir “no”','2',3,11);
/*!40000 ALTER TABLE `mfo_pregunta` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_provincia`
--

DROP TABLE IF EXISTS `mfo_provincia`;
CREATE TABLE `mfo_provincia` (
  `id_provincia` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la provincia en el sistema',
  `nombre` varchar(50) NOT NULL COMMENT 'Nombre de la provincia',
  `iso_code` varchar(25) NOT NULL COMMENT 'Código que representa a la provincia',
  `id_pais` int(11) NOT NULL COMMENT 'Identificador del pais',
  PRIMARY KEY (`id_provincia`),
  KEY `fk_mfo_provincias_mfo_pais1` (`id_pais`),
  CONSTRAINT `fk_mfo_provincias_mfo_pais1` FOREIGN KEY (`id_pais`) REFERENCES `mfo_pais` (`id_pais`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_provincia`
--

/*!40000 ALTER TABLE `mfo_provincia` DISABLE KEYS */;
INSERT INTO `mfo_provincia` (`id_provincia`,`nombre`,`iso_code`,`id_pais`) VALUES 
 (1,'AZUAY','AZ',1),
 (2,'GUAYAS','GYE',1),
 (3,'BOLIVAR','BO',1),
 (4,'CAÑAR','CA',1),
 (5,'CARCHI','CAR',1),
 (6,'CHIMBORAZO','CHI',1),
 (7,'COTOPAXI','CO',1),
 (8,'EL ORO','OR',1),
 (9,'ESMERALDAS','ES',1),
 (10,'GALAPAGOS','GA',1),
 (11,'IMBABURA','IM',1),
 (12,'LOJA','LO',1),
 (13,'LOS RIOS','CHI',1),
 (14,'MANABI','MA',1),
 (15,'MORONA SANTIAGO','MS',1),
 (16,'NAPO','NA',1),
 (17,'ORELLANA','OR',1),
 (18,'PASTAZA','PAS',1),
 (19,'PICHINCHA','PI',1),
 (20,'SANTA ELENA','SEL',1),
 (21,'SANTO DOMINGO DE LOS TSACHILAS','SDT',1),
 (22,'SUCUMBIOS','SUC',1),
 (23,'TUNGURAHUA','TU',1),
 (24,'ZAMORA CHINCHIPE','ZCH',1);
/*!40000 ALTER TABLE `mfo_provincia` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_rasgo`
--

DROP TABLE IF EXISTS `mfo_rasgo`;
CREATE TABLE `mfo_rasgo` (
  `id_rasgo` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del rasgo',
  `nombre` varchar(50) NOT NULL COMMENT 'Nombre del rasgo',
  `caract_max` int(3) NOT NULL COMMENT 'Número máximo de carcateristicas por rasgo',
  `id_cuestionario` int(11) NOT NULL COMMENT 'Identificador que permite conocer a que cuestionario pertenece el rasgo',
  PRIMARY KEY (`id_rasgo`),
  KEY `fk_mfo_rasgo_test1` (`id_cuestionario`),
  CONSTRAINT `fk_mfo_rasgo_test1` FOREIGN KEY (`id_cuestionario`) REFERENCES `mfo_cuestionario` (`id_cuestionario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_rasgo`
--

/*!40000 ALTER TABLE `mfo_rasgo` DISABLE KEYS */;
INSERT INTO `mfo_rasgo` (`id_rasgo`,`nombre`,`caract_max`,`id_cuestionario`) VALUES 
 (1,'Extroversión',25,1),
 (2,'Armónico',25,1),
 (3,'Comunicador',25,1),
 (4,'Resolutivo',25,2),
 (5,'Creativo',25,2),
 (6,'Orientado al logro',25,2),
 (7,'Responsable',25,2),
 (8,'Impulsor',25,3),
 (9,'Comprometido',25,3),
 (10,'Tolerancia al estrés',25,3),
 (11,'Buscador de aprobación',25,3);
/*!40000 ALTER TABLE `mfo_rasgo` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_rasgo_general`
--

DROP TABLE IF EXISTS `mfo_rasgo_general`;
CREATE TABLE `mfo_rasgo_general` (
  `id_rasgo_general` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del rasgo',
  `nombre` varchar(45) NOT NULL COMMENT 'Nombre del limite que ocupara el rasgo',
  `min_rango` int(2) NOT NULL COMMENT 'Mínimo del rango para dicho rasgo',
  `max_rango` int(2) NOT NULL COMMENT 'Máximo del rango para dicho rasgo',
  `descripcion` text NOT NULL COMMENT 'Contenido que representa al rasgo general por cuestionario',
  `id_cuestionario` int(11) NOT NULL COMMENT 'Identificador para saber a que cuestionario esta relacionado dicho rasgo',
  PRIMARY KEY (`id_rasgo_general`),
  KEY `fk_mfo_rasgo_general_test1` (`id_cuestionario`),
  CONSTRAINT `fk_mfo_rasgo_general_test1` FOREIGN KEY (`id_cuestionario`) REFERENCES `mfo_cuestionario` (`id_cuestionario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_rasgo_general`
--

/*!40000 ALTER TABLE `mfo_rasgo_general` DISABLE KEYS */;
INSERT INTO `mfo_rasgo_general` (`id_rasgo_general`,`nombre`,`min_rango`,`max_rango`,`descripcion`,`id_cuestionario`) VALUES 
 (1,'extremo superior',19,25,'_nombreAspirante_ es una persona extrovertida y amiguera, perfecto como orador y bueno para establecer relaciones interpersonales y alianzas estratégicas que favorezcan a la empresa, aunque debe relajarse y tomar las cosas con calma y pensar antes de actuar._saltoLinea__nombreAspirante_ es muy eficiente en el trabajo, rara vez llegara tarde o faltara a un compromiso, se obsesiona con el tiempo he intenta realizar varias tareas simultáneas._saltoLinea_Se levanta muy temprano en la mañana con una sensación imperante de que el tiempo apremia y debe salir rápido, aunque no sea así, siempre parece estar apurado o llevar prisa, es una persona en la que podemos contar para involucrarlo en mas de un proyecto en la organización u empresa donde labore. _saltoLinea_Así como también se preocupará por establecer un ambiente de trabajo armónico e intentará que los conflictos sean solucionados de forma equilibrada y por la vía de la comunicación. _saltoLinea_Debe cuidar más de su salud ya que el estrés que le causan los compromisos que por voluntad adquiere lo hacen alimentarse mal y a destiempo, tiende a manejar a gran velocidad, es una persona con alto riesgo de sufrir ataques cardiacos, entre otras enfermedades relacionadas con el estrés. _saltoLinea_Es muy competitivo y se involucra en situaciones que lo pongan a prueba y pueda sobresalir de entre sus compañeros. Es altamente deseable para ocupar cargos de alta gerencia y si opta por cargos medios y/o básicos, será un trabajador con gran eficiencia y rapidez, trabajará bajo presión y tendrá una solución a los problemas que se le presenten.',1),
 (2,'extremo medio',12,18,'_nombreAspirante_ es motivado por estímulos externos, como el poder, el dinero, entre otros, los cuales son su motor de arranque e impulso._saltoLinea_Es inusual que ejerza algún trabajo sin esperar una recompensa por ello. _nombreAspirante_ es capaz de desarrollar bien sus ideas y emociones de forma coherente, se encuentra en constante búsqueda del equilibrio en su vida y en su trabajo, desea un orden entre trabajo y tiempo libre._saltoLinea_Este equilibrio lo pone en práctica dando una ponderación equitativa entre lo que da y lo que recibe, _nombreAspirante_ puede llegar a ser impuntual, pero logra cumplir con los plazos asignados, el conocimiento técnico que posee lo puede llevar a verse arrogante y descortés, pero lo hace de forma inconsciente, debe tener cuidado con su disciplina porque, al descuidarla puede quedar mal con los objetivos que se propone. _saltoLinea_Se conoce a sí mismo, reconoce su interior tanto como su exterior, sabe cómo se ve y se siente. _saltoLinea_Le gusta prestar atención a las cosas, retiene mayor cantidad de conocimiento, mientras más se enfoca mejor retiene la información, al conocer sus emociones e interior logra expresarlas con su lenguaje corporal de forma coherente, sus expresiones faciales y cuerpo hablan por sí solo.',1);
INSERT INTO `mfo_rasgo_general` (`id_rasgo_general`,`nombre`,`min_rango`,`max_rango`,`descripcion`,`id_cuestionario`) VALUES 
 (3,'extremo inferior',5,11,'_nombreAspirante_ es muy responsable, no tiene apuro ni la sensación de que el tiempo se le acaba, es buen compañero de trabajo, amable y educado, normalmente tiene más amigos que otras personas y si se presenta algún problema en la oficina no se ofusca fácilmente, lo solucionara con calma y serenidad._saltoLinea_En general tiene un temperamento estable, tiende a ser bastante informal, es seguro de sí mismo, relajado y agradable, no es buen comunicador de sus ideas ni sentimientos, esto hace que se desenvuelva en ambientes conflictivos con facilidad._saltoLinea__nombreAspirante_ Posee amistades duraderas y honestas, no es una persona buena para ser orador, se le dificulta cargos de liderazgo, ventas y relaciones públicas, es buen trabajador, responsable y rutinario, bueno para cargos que se ejerzan en la seguridad de una oficina._saltoLinea_El uso de la empatía no es lo suyo, le cuesta interpretar las emociones de los demás y estar en sus zapatos._saltoLinea_Por otro lado, debe aprender a dar una jerarquía a los problemas, se le dificulta diferenciar entre urgencia y emergencia, esto influye en su toma de decisiones.  ',1),
 (4,'extremo superior',19,25,'_nombreAspirante_ es una persona creativa con grandes rasgos de comprensión abstracta, capaz de imaginar y proyectar en el futuro para posteriormente lograr sus objetivos, es capaz de dar una opinión sobre casi cualquier tema y propone proyectos innovadores que pueden ayudar al crecimiento de la empresa._saltoLinea_Es capaz de hacer consciente sus emociones, sabe lo que piensa y siente, en ocasiones sin importar lo malo que sean sus sentimientos, puede ser positivo porque _nombreAspirante_ no retiene malestares ni se guarda sentimientos dañinos._saltoLinea_Mientras más alto el puntaje mayor es la capacidad de lograr cada objetivo propuesto ya sea en plano personal o laboral, es una persona con objetivos claros y con la capacidad de conseguir lo que se proponga, no necesita la constante supervisión de su trabajo ya que sin duda cumplirá._saltoLinea_Ya que es altamente responsable, es bueno para cargos de alta confianza, con objetivos claros, puede crear proyectos desde cero, así como también tomar uno iniciado y llevarlo a su máxima expresión, es capaz de solucionar o superar los obstáculos que se le presenten._saltoLinea__nombreAspirante_ tiene un poder de emprendimiento fuera del promedio, esto tiene que ver con el empoderamiento que coloca en los proyectos en los que se involucra, _nombreAspirante_ se siente perteneciente a su empresa, se arraiga y defiende los patrimonios.',2);
INSERT INTO `mfo_rasgo_general` (`id_rasgo_general`,`nombre`,`min_rango`,`max_rango`,`descripcion`,`id_cuestionario`) VALUES 
 (5,'extremo medio',12,18,'_nombreAspirante_ es una persona capaz de utilizar correctamente estrategias y planificaciones, cumple y sigue los objetivos, su creatividad es mejor aplicada en las tareas concretas como la matemática._saltoLinea_Se siente perteneciente a la organización y a los proyectos que decida iniciar, _nombreAspirante_ logra llegar a tiempo a sus reuniones y a su puesto de trabajo y exige lo mismo de los demás. Mantiene una actitud activa ante los inconvenientes que se le presenten en el camino hasta lograr superarlos._saltoLinea_Sus capacidades intelectuales son utilizadas de forma correcta esto le facilita vincularse y aprender muchas labores las cuales ejecuta con facilidad luego de aprenderlas. Su carácter es siempre positivo y animado, es jovial, _nombreAspirante_ logra interactuar con su medio ambiente y todo lo que lo compone._saltoLinea_Es capaz de soportar fracasos y superarlos con facilidad, suele ser honesto y cumple con normas básicas y leyes, habla con franqueza y es sincero con sus emociones. Puede llegar a ser indiferente ante los reclamos de su jefe dando la sensación de que no presta atención.',2),
 (6,'extremo inferior',5,11,'_nombreAspirante_ trabaja bajo valores de integridad como la honestidad, el respeto, la solidaridad, la puntualidad, posee excelentes relaciones interpersonales.',2);
INSERT INTO `mfo_rasgo_general` (`id_rasgo_general`,`nombre`,`min_rango`,`max_rango`,`descripcion`,`id_cuestionario`) VALUES 
 (7,'extremo superior',19,25,'_nombreAspirante_ es capaz de impulsar proyectos a su máxima expresión, así como también es capaz de crear formas innovadoras para cumplir con sus objetivos o los de la organización._saltoLinea_Sin duda _nombreAspirante_ es deseable dentro de la empresa ya que será capaz de solucionar y desarrollar según se le presenten los obstáculos, es capaz de comprometerse con la empresa y con sus superiores colocando los intereses laborales y sus metas por encima de cualquier cosa._saltoLinea_Esta característica también la aplica en el plano personal, mantiene compromisos firmes como el matrimonio, mantiene una estabilidad constante en su hogar, por ende, su efectividad en el trabajo crece. _saltoLinea_Según logra objetivos necesita ser recompensado más que monetariamente, desea ser reconocido por su esfuerzo dentro de la empresa, le gustan los elogios y las palabras de aliento y motivación. _saltoLinea_Posee una alta tolerancia a al estrés, siendo el caso de personas que ejercen puestos de alta exigencia.',3),
 (8,'extremo medio',12,18,'_nombreAspirante_ proyectada en el futuro y en lo que vendrá, el pasado es una escuela para él y desea aprender. Siempre se mantiene en constante movimiento y se esfuerza por el cumplimiento de sus metas y objetivos. _saltoLinea_Normalmente prefiere trabajar individualmente antes de unirse a un grupo o equipos de trabajo. Desea conocer cada detalle antes de involucrarse en un proyecto y adquirir compromisos. _saltoLinea_Es capaz de establecer tratos con seriedad y firma contratos con frecuencia, prefiere que todas las cláusulas queden bien claras y explicitas antes de cometer errores, no suele cumplir horarios muy estrictos ni rutinas diarias. En ocasiones carece de empatía y no comparte las emociones de los demás. _saltoLinea_Puede ser un gran apoyo para otras personas cuando están pasando por un mal momento, es de gran ayuda en momentos difíciles y es un buen amigo. Por momentos parece seguir la corriente para no llevar la contraria ni caer en discusiones, no le gustan los conflictos. _saltoLinea_Desea ser reconocido con acciones o bienes materiales, no desea elogios ni palabras de aliento',3);
INSERT INTO `mfo_rasgo_general` (`id_rasgo_general`,`nombre`,`min_rango`,`max_rango`,`descripcion`,`id_cuestionario`) VALUES 
 (9,'extremo inferior',5,11,'_nombreAspirante_ no se compromete fácilmente con los objetivos de la organización a la que pertenece, simplemente ve la oportunidad como un empleo cualquiera y debe cumplir con el mismo, no hará mayor cosa por superar a sus Compañeros ni de generar ideas que conlleven al crecimiento de la empresa. _saltoLinea_Tiene metas claras, pero no ambiciosas, no se compromete más allá de lo que pueda cumplir, así como tampoco le interesan las palabras de elogio ni el reconocimiento de sus labores, simplemente se dedica a realizar su trabajo de la mejor manera posible, el origen de sus motivaciones es intrínseca, esto indica que _nombreAspirante_ vela por el bienestar propio._saltoLinea_En el ámbito personal los niveles de compromiso con su familia nuclear si posee, son bajos es posible que tenga problemas de estabilidad familiar que pueden llegar a influir en su desempeño laboral. _saltoLinea__nombreAspirante_ no debe ser expuesto en cargos o labores con altas exigencias, _nombreAspirante_ no trabajara bien bajo presión.',3);
/*!40000 ALTER TABLE `mfo_rasgo_general` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_rcomprobantescam`
--

DROP TABLE IF EXISTS `mfo_rcomprobantescam`;
CREATE TABLE `mfo_rcomprobantescam` (
  `id_comprobante` int(11) NOT NULL AUTO_INCREMENT,
  `num_comprobante` varchar(70) NOT NULL COMMENT 'Número que corresponde a la referencia del pago',
  `nombre` varchar(100) NOT NULL COMMENT 'Nombre de la persona que hizo el pago',
  `correo` varchar(100) NOT NULL COMMENT 'Campo para guardar la direccion email del que realizo el pago',
  `telefono` varchar(25) NOT NULL COMMENT 'Teléfono de contacto con la persona que hizo el deposito',
  `dni` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL COMMENT 'Cedula o ruc de la persona que hace el pago de plan',
  `fecha_creacion` datetime NOT NULL COMMENT 'Fecha en que se registro el pago en la plataforma',
  `valor` float NOT NULL COMMENT 'Valor po el cual esta hecho el pago',
  `estado` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Estado del pago. (1.- pago verificado, 0.- Pago incorrecto o invalido)',
  `id_ciudad` int(11) unsigned NOT NULL COMMENT 'Identificador de la ciudad en que se hizo el pago',
  `id_admin` int(11) NOT NULL COMMENT 'quien hace la aprobacion del pago',
  `id_usuario_plan` int(11) NOT NULL COMMENT 'Usuario al que corresponde el pago',
  `tipo_pago` int(11) NOT NULL COMMENT '1.- deposito, 2.- paypal y 3.- Paymentez',
  PRIMARY KEY (`id_comprobante`),
  KEY `fk_mfo_rcomprobantescam_mfo_ciudad1` (`id_ciudad`),
  KEY `fk_mfo_rcomprobantescam_mfo_usuario_plan1` (`id_usuario_plan`),
  KEY `fk_admin_idx` (`id_admin`),
  CONSTRAINT `fk_admin` FOREIGN KEY (`id_admin`) REFERENCES `mfo_admin` (`id_admin`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_rcomprobantescam_mfo_ciudad1` FOREIGN KEY (`id_ciudad`) REFERENCES `mfo_ciudad` (`id_ciudad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_rcomprobantescam_mfo_usuario_plan1` FOREIGN KEY (`id_usuario_plan`) REFERENCES `mfo_usuario_plan` (`id_usuario_plan`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_rcomprobantescam`
--

/*!40000 ALTER TABLE `mfo_rcomprobantescam` DISABLE KEYS */;
/*!40000 ALTER TABLE `mfo_rcomprobantescam` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_requisitoofreta`
--

DROP TABLE IF EXISTS `mfo_requisitoofreta`;
CREATE TABLE `mfo_requisitoofreta` (
  `id_requisitoOfreta` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de requisitos',
  `licencia` tinyint(4) DEFAULT '0' COMMENT 'Valor 0.- no posee licencia y 1.- posee licencia',
  `viajar` tinyint(4) DEFAULT '0' COMMENT 'Valor 0.- no puede viajar y 1.- puede viajar',
  `residencia` tinyint(4) DEFAULT '0' COMMENT 'Valor 0.- no posee residencia y 1.- posee residencia',
  `discapacidad` tinyint(4) DEFAULT '0' COMMENT 'Valor 0.- no tiene discapacidad y 1.- si tiene discapacidad',
  `confidencial` tinyint(4) DEFAULT '0' COMMENT 'Valor 0.- no es confidencial la informacion de la empresa y 1.- es confidencial la informacion',
  `edad_minima` int(2) DEFAULT NULL COMMENT 'Edad mínima para el cargo de la oferta',
  `edad_maxima` int(2) DEFAULT NULL COMMENT 'Edad máxima para el cargo de la oferta',
  `id_nivelIdioma_idioma` int(11) NOT NULL COMMENT 'Identificador de la tabla nivelIdioma_idioma',
  PRIMARY KEY (`id_requisitoOfreta`),
  KEY `fk_mfo_requisitoOfreta_mfo_nivelIdioma_idioma1` (`id_nivelIdioma_idioma`),
  CONSTRAINT `fk_mfo_requisitoOfreta_mfo_nivelIdioma_idioma1` FOREIGN KEY (`id_nivelIdioma_idioma`) REFERENCES `mfo_nivelidioma_idioma` (`id_nivelIdioma_idioma`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_requisitoofreta`
--

/*!40000 ALTER TABLE `mfo_requisitoofreta` DISABLE KEYS */;
/*!40000 ALTER TABLE `mfo_requisitoofreta` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_respuesta`
--

DROP TABLE IF EXISTS `mfo_respuesta`;
CREATE TABLE `mfo_respuesta` (
  `id_respuesta` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la respuesta',
  `valor` int(3) NOT NULL COMMENT 'Puntaje que obtiene cada respuesta',
  `seleccion` int(3) NOT NULL COMMENT 'Número de la espuesta seleccionada',
  `tiempo` time NOT NULL COMMENT 'Tiempo que tardo el candidato en seleccionar la opcion correcta',
  `estado` int(3) NOT NULL COMMENT 'Estado en el que se encuentra cada respuesta (1.- Iniciada, 2.- En proceso, 3.- No iniciada y 4.- Finalizada )',
  `id_usuario` int(11) NOT NULL COMMENT 'Campo para saber a que usuario le corresponde dicha respuesta',
  `id_cuestionario` int(11) NOT NULL COMMENT 'Número de cuestionario',
  `id_pre` int(11) NOT NULL COMMENT 'Identificador de la pregunta que le corresponde',
  PRIMARY KEY (`id_respuesta`),
  KEY `fk_mfo_respuestas_mfo_usuario1` (`id_usuario`),
  KEY `fk_mfo_respuestas_test1` (`id_cuestionario`),
  KEY `fk_mfo_respuestas_mfo_preguntas1` (`id_pre`),
  CONSTRAINT `fk_mfo_respuestas_mfo_preguntas1` FOREIGN KEY (`id_pre`) REFERENCES `mfo_pregunta` (`id_pre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_respuestas_mfo_usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `mfo_usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_respuestas_test1` FOREIGN KEY (`id_cuestionario`) REFERENCES `mfo_cuestionario` (`id_cuestionario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_respuesta`
--

/*!40000 ALTER TABLE `mfo_respuesta` DISABLE KEYS */;
/*!40000 ALTER TABLE `mfo_respuesta` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_resultxrasgo`
--

DROP TABLE IF EXISTS `mfo_resultxrasgo`;
CREATE TABLE `mfo_resultxrasgo` (
  `id_result` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador del informe',
  `valor` int(3) unsigned DEFAULT '0' COMMENT 'Calculo del rasgo ',
  `id_usuario` int(11) NOT NULL COMMENT 'Identificador del usuario al que corresponde los resultados',
  `id_rasgo` int(11) NOT NULL COMMENT 'Campo para saber el rasgo al que pertenece dicho valor',
  PRIMARY KEY (`id_result`),
  KEY `fk_mfo_inf_result_mfo_usuario1` (`id_usuario`),
  KEY `fk_mfo_resultxrasgo_mfo_rasgo1` (`id_rasgo`),
  CONSTRAINT `fk_mfo_inf_result_mfo_usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `mfo_usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_resultxrasgo_mfo_rasgo1` FOREIGN KEY (`id_rasgo`) REFERENCES `mfo_rasgo` (`id_rasgo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_resultxrasgo`
--

/*!40000 ALTER TABLE `mfo_resultxrasgo` DISABLE KEYS */;
/*!40000 ALTER TABLE `mfo_resultxrasgo` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_rol`
--

DROP TABLE IF EXISTS `mfo_rol`;
CREATE TABLE `mfo_rol` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del rol',
  `descripcion` varchar(25) NOT NULL COMMENT 'Nombre de cada tipo de usuario en el sistema (candidato, empresa o administrador)',
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_rol`
--

/*!40000 ALTER TABLE `mfo_rol` DISABLE KEYS */;
INSERT INTO `mfo_rol` (`id_rol`,`descripcion`) VALUES 
 (1,'Administrador'),
 (2,'Psicologo'),
 (3,'Venta#1'),
 (4,'Venta#2');
/*!40000 ALTER TABLE `mfo_rol` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_sugerencia`
--

DROP TABLE IF EXISTS `mfo_sugerencia`;
CREATE TABLE `mfo_sugerencia` (
  `id_sugerencias` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la sugerencia',
  `nombres` varchar(30) NOT NULL COMMENT 'Nombre de la persona que realiza la sugerencia',
  `correo` varchar(30) NOT NULL COMMENT 'Correo al que se le puede comunicar al usuario',
  `telefono` varchar(25) NOT NULL COMMENT 'Número de telefono del usuario que envia la sugerencia',
  `descripcion` varchar(250) NOT NULL COMMENT 'Texto con los comentarios a realizar',
  `fecha_creacion` datetime NOT NULL,
  PRIMARY KEY (`id_sugerencias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_sugerencia`
--

/*!40000 ALTER TABLE `mfo_sugerencia` DISABLE KEYS */;
/*!40000 ALTER TABLE `mfo_sugerencia` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_templateemail`
--

DROP TABLE IF EXISTS `mfo_templateemail`;
CREATE TABLE `mfo_templateemail` (
  `id_templateEmail` int(11) NOT NULL COMMENT 'Identificador del template',
  `categoria` int(1) NOT NULL COMMENT 'Especifica el tipo de contenido que llevara el correo',
  `nombre` varchar(45) NOT NULL COMMENT 'Nombre del template',
  `contenido` text NOT NULL COMMENT 'Contenido HTML que construira el correo electronico según el tipo',
  PRIMARY KEY (`id_templateEmail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_templateemail`
--

/*!40000 ALTER TABLE `mfo_templateemail` DISABLE KEYS */;
/*!40000 ALTER TABLE `mfo_templateemail` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_testimonio`
--

DROP TABLE IF EXISTS `mfo_testimonio`;
CREATE TABLE `mfo_testimonio` (
  `id_testimonio` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del testimonio registrado en el sistema',
  `nombre` varchar(100) NOT NULL COMMENT 'Nombre de la persona que dio el testimonio',
  `profesion` varchar(100) NOT NULL COMMENT 'Profesion de la persona que dio elo testimonio',
  `descripcion` varchar(200) NOT NULL COMMENT 'Comentarios sobre el sistema',
  `orden` int(3) NOT NULL COMMENT 'Orden en el cual apareceran los testimonios en la web',
  `estado` tinyint(4) NOT NULL COMMENT 'Indica si el testimonio esta activo o no',
  `id_pais` int(11) NOT NULL COMMENT 'Pais de la persona que hace el testimonio',
  PRIMARY KEY (`id_testimonio`),
  KEY `fk_mfo_testimonio_mfo_pais1` (`id_pais`),
  CONSTRAINT `fk_mfo_testimonio_mfo_pais1` FOREIGN KEY (`id_pais`) REFERENCES `mfo_pais` (`id_pais`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_testimonio`
--

/*!40000 ALTER TABLE `mfo_testimonio` DISABLE KEYS */;
/*!40000 ALTER TABLE `mfo_testimonio` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_tipocontrato`
--

DROP TABLE IF EXISTS `mfo_tipocontrato`;
CREATE TABLE `mfo_tipocontrato` (
  `id_tipocontrato` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del tipo de contrato',
  `descripcion` varchar(45) NOT NULL COMMENT 'Nombre del tipo de contrato',
  PRIMARY KEY (`id_tipocontrato`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_tipocontrato`
--

/*!40000 ALTER TABLE `mfo_tipocontrato` DISABLE KEYS */;
/*!40000 ALTER TABLE `mfo_tipocontrato` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_usuario`
--

DROP TABLE IF EXISTS `mfo_usuario`;
CREATE TABLE `mfo_usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la tabla',
  `username` varchar(50) NOT NULL COMMENT 'Usuario para loguearse en el sistema',
  `password` varchar(100) NOT NULL COMMENT 'password para loguearse en el sistema',
  `correo` varchar(100) NOT NULL COMMENT 'Correo asociado al usuario',
  `telefono` varchar(25) NOT NULL COMMENT 'Número de telefono del usuario',
  `dni` varchar(25) NOT NULL COMMENT 'Documento de identificacion (cedula o pasaporte)',
  `nombres` varchar(100) NOT NULL COMMENT 'Nombres asociados al usuario',
  `apellidos` varchar(100) NOT NULL COMMENT 'Apellidos asociados al usuario',
  `fecha_nacimiento` datetime NOT NULL COMMENT 'Fecha en la que el usuario asociado nacio',
  `genero` varchar(1) DEFAULT NULL COMMENT 'Identidad sexual del usuario',
  `discapacidad` varchar(2) DEFAULT 'No' COMMENT 'Si el usuario posee una limitación física o mental',
  `anosexp` int(3) DEFAULT NULL COMMENT 'Cantidad de años de experiencia laboral',
  `fecha_creacion` datetime NOT NULL COMMENT 'Fecha en la que el usuario fue creado',
  `foto` tinyint(4) DEFAULT NULL COMMENT 'Se carga si tiene o no foto vinculada al usuario',
  `token` varchar(100) NOT NULL COMMENT 'Validacón de pago o de cuenta del usuario (POR DEFINIR)',
  `estado` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Estado activo o inactivo del usuario',
  `term_cond` tinyint(4) DEFAULT '0' COMMENT 'Campo que permite manejar si el usuario acepto los terminos de la empresa',
  `conf_datos` tinyint(4) NOT NULL COMMENT 'Campo que permite guardar si el usuario dio permiso de uso de sus datos y que fuesen confidenciales',
  `status_carrera` int(3) NOT NULL COMMENT '1.- Estudiante, 2.- Egresado',
  `tipo_usuario` int(3) NOT NULL COMMENT '1.- usuario y 2.- empresa',
  `id_escolaridad` int(11) NOT NULL COMMENT 'Identificador del tipo de escolaridad del usuario',
  `id_ciudad` int(11) unsigned NOT NULL COMMENT 'Identificador de la ciudad',
  `id_convenio_univ` int(11) DEFAULT NULL COMMENT 'Identificador de la universidad con la que posiblemente tiene convenio la emprersa',
  `ultima_sesion` datetime NOT NULL COMMENT 'Registra la ultima fecha y hora de conexión del candidato o empresa',
  PRIMARY KEY (`id_usuario`),
  KEY `fk_mfo_usuario_mfo_escolaridad1` (`id_escolaridad`),
  KEY `fk_mfo_usuario_mfo_ciudad1` (`id_ciudad`),
  KEY `fk_convenio_univ_idx` (`id_convenio_univ`),
  CONSTRAINT `fk_convenio_univ` FOREIGN KEY (`id_convenio_univ`) REFERENCES `mfo_convenio_univ` (`id_convenio_univ`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_usuario_mfo_ciudad1` FOREIGN KEY (`id_ciudad`) REFERENCES `mfo_ciudad` (`id_ciudad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_usuario_mfo_escolaridad1` FOREIGN KEY (`id_escolaridad`) REFERENCES `mfo_escolaridad` (`id_escolaridad`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_usuario`
--

/*!40000 ALTER TABLE `mfo_usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `mfo_usuario` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_usuario_plan`
--

DROP TABLE IF EXISTS `mfo_usuario_plan`;
CREATE TABLE `mfo_usuario_plan` (
  `id_usuario_plan` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la relacion entre usuario y plan',
  `id_usuario` int(11) NOT NULL COMMENT 'Candidato o empresa que compro el plan',
  `id_plan` int(11) NOT NULL COMMENT 'Plan comprado por el candidato o empresa',
  `estado` tinyint(4) NOT NULL COMMENT 'Permite conocer si ese candidato o empresa tiene un plan activo',
  `fecha_compra` datetime NOT NULL COMMENT 'Fecha en la que fue comprado el plan',
  `num_post_rest` int(3) NOT NULL COMMENT 'Numero de postulaciones restantes',
  `fecha_caducidad` datetime NOT NULL COMMENT 'Fecha en que caduca el plan ',
  PRIMARY KEY (`id_usuario_plan`),
  KEY `fk_mfo_usuario_has_mfo_plan_mfo_usuario1` (`id_usuario`),
  KEY `fk_mfo_usuario_has_mfo_plan_mfo_plan1` (`id_plan`),
  CONSTRAINT `fk_mfo_usuario_has_mfo_plan_mfo_plan1` FOREIGN KEY (`id_plan`) REFERENCES `mfo_plan` (`id_plan`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_usuario_has_mfo_plan_mfo_usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `mfo_usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_usuario_plan`
--

/*!40000 ALTER TABLE `mfo_usuario_plan` DISABLE KEYS */;
/*!40000 ALTER TABLE `mfo_usuario_plan` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_usuarioxarea`
--

DROP TABLE IF EXISTS `mfo_usuarioxarea`;
CREATE TABLE `mfo_usuarioxarea` (
  `id_usuarioxarea` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador para relacionar el usuario por area de interes',
  `id_usuario` int(11) NOT NULL COMMENT 'Identificador del usuario',
  `id_area` int(11) NOT NULL COMMENT 'Identificador del area ',
  PRIMARY KEY (`id_usuarioxarea`),
  KEY `fk_mfo_usuario_has_mfo_intereses_mfo_usuario` (`id_usuario`),
  KEY `fk_mfo_usuario_has_mfo_intereses_mfo_intereses1` (`id_area`),
  CONSTRAINT `fk_mfo_usuario_has_mfo_intereses_mfo_intereses1` FOREIGN KEY (`id_area`) REFERENCES `mfo_area` (`id_area`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_usuario_has_mfo_intereses_mfo_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `mfo_usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_usuarioxarea`
--

/*!40000 ALTER TABLE `mfo_usuarioxarea` DISABLE KEYS */;
/*!40000 ALTER TABLE `mfo_usuarioxarea` ENABLE KEYS */;


--
-- Table structure for table `micamello_base`.`mfo_usuarioxnivel`
--

DROP TABLE IF EXISTS `mfo_usuarioxnivel`;
CREATE TABLE `mfo_usuarioxnivel` (
  `id_usuarioxnivel` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la interseccion de la tabla usuario y la tabla nivelInteres',
  `id_usuario` int(11) NOT NULL COMMENT 'Identificador del usuario',
  `id_nivelInteres` int(11) NOT NULL COMMENT 'Identificador del nivel de interes',
  PRIMARY KEY (`id_usuarioxnivel`),
  KEY `fk_mfo_usuario_has_mfo_nivelInteres_mfo_usuario1` (`id_usuario`),
  KEY `fk_mfo_usuario_has_mfo_nivelInteres_mfo_nivelInteres1` (`id_nivelInteres`),
  CONSTRAINT `fk_mfo_usuario_has_mfo_nivelInteres_mfo_nivelInteres1` FOREIGN KEY (`id_nivelInteres`) REFERENCES `mfo_nivelinteres` (`id_nivelInteres`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_usuario_has_mfo_nivelInteres_mfo_usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `mfo_usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `micamello_base`.`mfo_usuarioxnivel`
--

/*!40000 ALTER TABLE `mfo_usuarioxnivel` DISABLE KEYS */;
/*!40000 ALTER TABLE `mfo_usuarioxnivel` ENABLE KEYS */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

ALTER TABLE mfo_testimonio
  DROP FOREIGN KEY fk_mfo_testimonio_mfo_pais1;

ALTER TABLE mfo_provincia
  DROP FOREIGN KEY fk_mfo_provincias_mfo_pais1;

ALTER TABLE mfo_usuario
  DROP FOREIGN KEY fk_convenio_univ;

ALTER TABLE mfo_convenio_univ
  DROP FOREIGN KEY fk_mfo_convenio_univ_mfo_pais1;
  

DROP TABLE `micamello_base`.`mfo_pais`;
-- -----------------------------------------------------
-- Table `micamello_base`.`mfo_pais`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `micamello_base`.`mfo_pais` (
  `id_pais` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del país registrado',
  `nombre` VARCHAR(100) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL COMMENT 'Nombre del pais en el que este el usuario',
  PRIMARY KEY (`id_pais`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;

INSERT INTO `micamello_base`.`mfo_pais`(`nombre`)VALUES
('Antigua y Barbuda (Antigua y Barbuda)'),
('Argentina (República Argentina)'),
('Bahamas (Mancomunidad de las Bahamas)'),
('Barbados (Barbados)'),
('Belice (Belice)'),
('Bolivia (Estado Plurinacional de Bolivia)'),
('Brasil (República Federativa de Brasil)'),
('Canadá (Canadá)'),
('Chile (República de Chile)'),
('Colombia (República de Colombia)'),
('Costa Rica (República de Costa Rica)'),
('Cuba (República de Cuba)'),
('Dominica (Mancomunidad de Dominica)'),
('Ecuador (República del Ecuador)'),
('El Salvador (República de El Salvador)'),
('Estados Unidos (Estados Unidos de América)'),
('Granada (Granada)'),
('Guatemala (República de Guatemala)'),
('Guyana (República Cooperativa de Guyana)'),
('Haití (República de Haití)'),
('Honduras (República de Honduras)'),
('Jamaica (Jamaica)'),
('México (Estados Unidos Mexicanos)'),
('Nicaragua (República de Nicaragua)'),
('Panamá (República de Panamá)'),
('Paraguay (República del Paraguay)'),
('Perú (República del Perú)'),
('República Dominicana (República Dominicana)'),
('San Cristóbal y Nieves (Federación de San Cristóbal y Nieves)'),
('San Vicente y las Granadinas (San Vicente y las Granadinas)'),
('Santa Lucía (Santa Lucía)'),
('Surinam (República de Surinam)'),
('Trinidad y Tobago (República de Trinidad y Tobago)'),
('Uruguay (República Oriental del Uruguay)'),
('Venezuela (República Bolivariana de Venezuela)');

UPDATE mfo_provincia SET id_pais = 14 WHERE id_pais = 1;

ALTER TABLE `micamello_base`.`mfo_testimonio` 
ADD CONSTRAINT `fk_testimonio_pais`
  FOREIGN KEY (`id_pais`)
  REFERENCES `micamello_base`.`mfo_pais` (`id_pais`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `micamello_base`.`mfo_provincia` 
ADD CONSTRAINT `fk_provincia_pais`
  FOREIGN KEY (`id_pais`)
  REFERENCES `micamello_base`.`mfo_pais` (`id_pais`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

ALTER TABLE `micamello_base`.`mfo_usuario` 
ADD CONSTRAINT `fk_convenio_univ`
  FOREIGN KEY (`id_convenio_univ`)
  REFERENCES `micamello_base`.`mfo_convenio_univ` (`id_convenio_univ`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


INSERT INTO `mfo_convenio_univ` (`Nombre`,`iso`,`id_pais`,`convenio`) VALUES 
 ('Universidad de Cuenca','UCUENCA',14,0),
 ('Escuela Sup. Politécnica del Litoral','ESPOL',14,0),
 ('Universidad Agraria del Ecuador','Guayaquil',14,0),
 ('Universidad de Guayaquil','UG',14,0),
 ('Universidad Estatal de Milagro','UNEMI',14,0),
 ('Univ. Estatal Península de Santa Elena','UPSE',14,0),
 ('Universidad Casa Grande','Guayaquil',14,0),
 ('Universidad Cat. de Sgo. de Guayaquil','UCSG',14,0),
 ('Universidad San Francisco de Quito','USFQ',14,0),
 ('Universidad Santa María','USM',14,0),
 ('Universidad del Pacifico Escuela de Negocios','Guayaquil',14,0),
 ('Univ. Laica Vicente Rocafuerte de Guayaquil','Guayaquil',14,0),
 ('Universidad Metropolitana','UMETRO',14,0),
 ('Univ. Naval Rafael Moran Valverde','UNINAV',14,0),
 ('Univ. de Especialidades Espíritu Santo','UEES',14,0),
 ('Universidad Tecnológica Ecotec','Guayaquil',14,0),
 ('Univ. Tecnológ. Empresarial de Guayaquil','UTEG',14,0),
 ('IDE Business School','Guayaquil',14,0),
 ('Universidad Nacional de Loja','UNL',14,0),
 ('Escuela Sup. Pol. Ecológica S. M. Ludeña','ESPEC',14,0),
 ('Universidad Técnica Particular de Loja','UTPL',14,0),
 ('Universidad Técnica de Babahoyo','UTB',14,0),
 ('Universidad Técnica Estatal de Quevedo','UTEQ',14,0),
 ('Esc. Sup. Politéc. Ecológica Amazónica','ESPEA',14,0),
 ('Esc. Sup. Pol. Agropecuaria de Manabi','ESPAM',14,0),
 ('Universidad Estatal del Sur de Manabi','Jipijapa',14,0),
 ('Universidad Laica E. Alfaro de Manabi','ULEAM',14,0),
 ('Universidad Técnica de Manabi','UTM',14,0),
 ('Universidad San Gregorio de Portoviejo','Portoviejo',14,0),
 ('Escuela Sup. Politécnica del Litoral','ESPOL',14,0),
 ('Escuela Politécnica del Ejercito','ESPE',14,0),
 ('Escuela Politécnica Nacional','EPN',14,0),
 ('Facultad Latinoamericana de Cs. Soc.','FLACSO',14,0),
 ('Instituto de Altos Estudios Nacionales','IAEN',14,0),
 ('Universidad Andina Simón Bolívar','UASB',14,0),
 ('Universidad Central del Ecuador','UCE',14,0),
 ('Esc. Politécnica Javeriana del Ecuador','ESPOJ',14,0),
 ('Pontificia Univ. Católica del Ecuador','PUCE',14,0),
 ('Universidad Alfredo Pérez Guerrero','UNAP',14,0),
 ('Universidad Cristiana Latinoamericana','UCL',14,0),
 ('Universidad de Especialidades Turísticas','UCT',14,0),
 ('Universidad Tecnológica Indoamerica','UTI',14,0),
 ('Universidad Indoamérica','Quito',14,0),
 ('Esc. Sup. Politéc. Ecológica Amazónica','ESPEA',14,0),
 ('Universidad de Las Americas','Quito',14,0),
 ('Universidad de Los Hemisferios','Quito',14,0),
 ('Univ. Iberoamericana del Ecuador','UNIBE',14,0),
 ('IDE Business School','Quito',14,0),
 ('Universidad Internacional del Ecuador','UIDE',14,0),
 ('Universidad Og Mandino','UOM',14,0),
 ('Universidad Particular Internacional Sek','UISEK',14,0),
 ('Universidad San Francisco de Quito','USFQ',14,0),
 ('Universidad Tecnológica América','UNITA',14,0),
 ('Universidad Tecnológica Equinoccial','UTE',14,0),
 ('Universidad Tecnológica Israel','UTI',14,0),
 ('Univ. Interc. de las Nac. y Pueblos Indig. A. Wasi','Quito',14,0),
 ('Universidad de las Américas','UDLA',14,0),
 ('Universidad Metropolitana','UMETRO',14,0),
 ('Universidad del Pacifico Escuela de Negocios','Quito',14,0),
 ('Universidad Estatal Amazónica','UEA',14,0),
 ('Universidad Técnica de Ambato','UTA',14,0),
 ('Universidad Regional Autónoma de Los Andes','Ambato',14,0),
 ('Universidad Tecnológica Indoamerica','UTI',14,0),
 ('Universidad Católica de Cuenca','UCACUE',14,0),
 ('Universidad del Azuay','UAZUAY',14,0),
 ('Universidad Panamericana de Cuenca','UPC',14,0),
 ('Universidad Politécnica Salesiana','UPS',14,0),
 ('Universidad Estatal de Bolívar','UEB',14,0),
 ('Universidad Politécnica Estatal del Carchi','UPEC',14,0),
 ('Escuela Sup. Politécnica de Chimborazo','ESPOCH',14,0),
 ('Universidad Nacional de Chimborazo','UNACH ',14,0),
 ('Univ. Interamericana del Ecuador','UNIDEC',14,0),
 ('Universidad Técnica de Cotopaxi','UTC',14,0),
 ('Universidad Técnica de Machala','Machala',14,0),
 ('Universidad Tecnológica S. A. de Machala','UTSAM',14,0),
 ('Universidad Metropolitana','UMETRO',14,0),
 ('Univ. Técnica L. V. T. de Esmeraldas','UTELVT',14,0),
 ('Universidad Técnica del Norte','UTN',14,0),
 ('Universidad de Otavalo','Otavalo',14,0);

-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `micamello_base`.`mfo_sucursal` (
  `id_sucursal` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del país registrado',
  `dominio` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL COMMENT 'Url del sistema comprado en cada pais',
  `icono` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL DEFAULT NULL COMMENT 'Imagen que representa al pais ',
  `logo` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL COMMENT 'Logo del sistema dependiendo del pais',
  `iso` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL DEFAULT NULL COMMENT 'Abreviatura del nombre del pais',
  `id_pais` INT(11) NOT NULL COMMENT 'Pais donde se creo la sucursal',
  `id_moneda` INT(11) NOT NULL COMMENT 'Moneda que se usa en dicha sucursal',
  PRIMARY KEY (`id_sucursal`),
  CONSTRAINT `fk_mfo_sucursal_mfo_pais1`
    FOREIGN KEY (`id_pais`)
    REFERENCES `micamello_base`.`mfo_pais` (`id_pais`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_mfo_sucursal_mfo_moneda1`
    FOREIGN KEY (`id_moneda`)
    REFERENCES `micamello_base`.`mfo_moneda` (`id_moneda`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;

INSERT INTO `mfo_sucursal` (`dominio`,`icono`,`logo`,`iso`,`id_pais`,`id_moneda`) VALUES 
 ('Ecuador','micamello_base.com.ec','ecu.png','logo.png','EC',14,1),
 ('Colombia','micamello_base.com.ec','col.png','logo.png','CO',10,2),
 ('Perú','micamello_base.com.ec','peru.png','logo.png','PE',27,3);


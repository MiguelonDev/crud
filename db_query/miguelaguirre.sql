-- Estructura de base de datos miguelaguirre
DROP DATABASE IF EXISTS `miguelaguirre`;
CREATE DATABASE `miguelaguirre`;
USE `miguelaguirre`;

-- Estructura de tabla miguelaguirre.tablaprincipal
DROP TABLE IF EXISTS `tablaprincipal`;
CREATE TABLE `tablaprincipal` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL DEFAULT '0',
  `Apellidos` varchar(50) NOT NULL DEFAULT '0',
  `Telefono` varchar(50) NOT NULL DEFAULT '0',
  KEY `Índice 1` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- Datos iniciales para la tabla miguelaguirre.tablaprincipal
INSERT INTO `tablaprincipal` (`ID`, `Nombre`, `Apellidos`, `Telefono`) VALUES
	(1, 'Miguel', 'Aguirre', '646704613');


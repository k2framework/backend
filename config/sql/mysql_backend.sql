-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 28-10-2012 a las 16:06:03
-- Versión del servidor: 5.5.8
-- Versión de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `backend_k2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditorias`
--

CREATE TABLE IF NOT EXISTS `auditorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuarios_id` int(11) NOT NULL,
  `fecha_at` date NOT NULL,
  `accion_realizada` text NOT NULL,
  `tabla_afectada` varchar(150) DEFAULT NULL,
  `ip` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuarios_id` (`usuarios_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `auditorias`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menus_id` int(11) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT '100',
  `clases` varchar(50) DEFAULT NULL,
  `visible_en` int(11) NOT NULL DEFAULT '1',
  `activo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `menus_id` (`menus_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `menus`
--

INSERT INTO `menus` (`id`, `menus_id`, `nombre`, `url`, `posicion`, `clases`, `visible_en`, `activo`) VALUES
(1, NULL, 'Administración', 'admin/usuarios', 100, NULL, 1, 1),
(2, 1, 'Usuarios', 'admin/usuarios', 100, NULL, 1, 1),
(3, 1, 'Roles', 'admin/roles', 100, NULL, 1, 1),
(4, NULL, 'Mi Perfil', 'admin/usuarios/perfil', 90, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recursos`
--

CREATE TABLE IF NOT EXISTS `recursos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recurso` varchar(200) NOT NULL,
  `descripcion` text,
  `activo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `recursos`
--

INSERT INTO `recursos` (`id`, `recurso`, `descripcion`, `activo`) VALUES
(1, 'admin/*', 'modulo para la administracion del sistema', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(50) NOT NULL,
  `plantilla` varchar(50) DEFAULT NULL,
  `activo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `rol` (`rol`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `rol`, `plantilla`, `activo`) VALUES
(1, 'usuario comun', NULL, 1),
(2, 'usuario administrador', NULL, 1),
(4, 'administrador del sistema', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_recursos`
--

CREATE TABLE IF NOT EXISTS `roles_recursos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roles_id` int(11) NOT NULL,
  `recursos_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `roles_id` (`roles_id`),
  KEY `recursos_id` (`recursos_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `roles_recursos`
--

INSERT INTO `roles_recursos` (`id`, `roles_id`, `recursos_id`) VALUES
(1, 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_usuarios`
--

CREATE TABLE IF NOT EXISTS `roles_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roles_id` int(11) NOT NULL,
  `usuarios_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `roles_id` (`roles_id`),
  KEY `usuarios_id` (`usuarios_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

--
-- Volcar la base de datos para la tabla `roles_usuarios`
--

INSERT INTO `roles_usuarios` (`id`, `roles_id`, `usuarios_id`) VALUES
(1, 1, 2),
(2, 2, 3),
(3, 4, 3),
(8, 1, 12),
(38, 2, 42),
(40, 1, 44),
(41, 2, 44),
(42, 4, 44),
(44, 2, 45),
(45, 4, 45),
(48, 2, 46),
(52, 4, 47);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `clave` varchar(40) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- Volcar la base de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `login`, `clave`, `nombres`, `email`, `activo`) VALUES
(2, 'usuario', 'baxuN8I44GotM', 'usuario del sistema', 'programador.manuel@gmail.com', 1),
(3, 'admin', 'baxuN8I44GotM', 'usuario administrador del sistema', 'manuel_j555@hotmail.com', 1),
(6, 'fghdfg', '123', 'asdasd', 'asdasds@sdasdasd', 1),
(12, 'admin11', 'sdfdfsd', 'dfgdfg', 'manuel_j555@hotmail.com', 1),
(42, 'admin222', '111', '111', 'manuel_j555@hotmail.com', 1),
(44, 'admin55', '345', '345', 'manuel_j555@hotmail.com', 1),
(45, 'manu', 'K2932zu3yPbLQ', 'Manuel José Papá', 'manuel_j555@hotmail.com', 1),
(46, 'otromas', 'K2YHTXv7/p8Mk', '123123', 'manuel_j555@hotmail.com', 1),
(47, 'dfgdfgdfgfdgfdgdfg', 'K2nF2wV1VJp2c', 'fdgdfgfg', 'manuel_j555@hotmail.com', 1);

--
-- Filtros para las tablas descargadas (dump)
--

--
-- Filtros para la tabla `auditorias`
--
ALTER TABLE `auditorias`
  ADD CONSTRAINT `auditorias_ibfk_1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`menus_id`) REFERENCES `menus` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `roles_recursos`
--
ALTER TABLE `roles_recursos`
  ADD CONSTRAINT `roles_recursos_ibfk_1` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `roles_recursos_ibfk_2` FOREIGN KEY (`recursos_id`) REFERENCES `recursos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `roles_usuarios`
--
ALTER TABLE `roles_usuarios`
  ADD CONSTRAINT `roles_usuarios_ibfk_1` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `roles_usuarios_ibfk_2` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : k2

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2013-05-23 17:42:34
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `auditorias`
-- ----------------------------
DROP TABLE IF EXISTS `auditorias`;
CREATE TABLE `auditorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuarios_id` int(11) NOT NULL,
  `fecha_at` date NOT NULL,
  `accion_realizada` text NOT NULL,
  `tabla_afectada` varchar(150) DEFAULT NULL,
  `ip` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuarios_id` (`usuarios_id`),
  CONSTRAINT `auditorias_ibfk_1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auditorias
-- ----------------------------

-- ----------------------------
-- Table structure for `menus`
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menus_id` int(11) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT '100',
  `clases` varchar(50) DEFAULT NULL,
  `visible_en` int(11) NOT NULL DEFAULT '1',
  `activo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `menus_id` (`menus_id`),
  CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`menus_id`) REFERENCES `menus` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO `menus` VALUES ('1', null, 'Administración', 'admin/usuarios', '100', null, '1', '1');
INSERT INTO `menus` VALUES ('2', '1', 'Usuarios', 'admin/usuarios', '100', null, '1', '1');
INSERT INTO `menus` VALUES ('3', '1', 'Roles', 'admin/roles', '100', null, '1', '1');
INSERT INTO `menus` VALUES ('4', null, 'Mi Perfil', 'admin/usuarios/perfil', '90', null, '1', '1');
INSERT INTO `menus` VALUES ('5', '1', 'Menús', 'admin/menu', '100', null, '2', '1');
INSERT INTO `menus` VALUES ('6', '1', 'Privilegios', 'admin/privilegios', '101', null, '1', '1');
INSERT INTO `menus` VALUES ('7', '1', 'Recursos', 'admin/recursos', '100', null, '1', '1');

-- ----------------------------
-- Table structure for `recursos`
-- ----------------------------
DROP TABLE IF EXISTS `recursos`;
CREATE TABLE `recursos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recurso` varchar(200) NOT NULL,
  `descripcion` text,
  `activo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of recursos
-- ----------------------------
INSERT INTO `recursos` VALUES ('1', 'admin/*', 'modulo para la administracion de usuarios', '1');
INSERT INTO `recursos` VALUES ('2', 'admin/usuarios/*', 'modulo para la administracion de usuarios', '1');
INSERT INTO `recursos` VALUES ('3', 'admin/roles/*', 'modulo para la administracion de roles', '1');
INSERT INTO `recursos` VALUES ('4', 'admin/recursos/*', 'modulo para la administracion de recursos', '1');
INSERT INTO `recursos` VALUES ('5', 'admin/privilegios/*', 'modulo para la administracion de privilegios', '1');
INSERT INTO `recursos` VALUES ('6', 'admin/menu/*', 'modulo para la administracion de menus', '1');
INSERT INTO `recursos` VALUES ('7', 'admin/usuarios/perfil', 'edición del perfil del usuario', '1');

-- ----------------------------
-- Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(50) NOT NULL,
  `plantilla` varchar(50) DEFAULT NULL,
  `activo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `rol` (`rol`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'usuario comun', null, '1');
INSERT INTO `roles` VALUES ('2', 'usuario administrador', null, '1');
INSERT INTO `roles` VALUES ('4', 'administrador del sistema', null, '1');

-- ----------------------------
-- Table structure for `roles_recursos`
-- ----------------------------
DROP TABLE IF EXISTS `roles_recursos`;
CREATE TABLE `roles_recursos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roles_id` int(11) NOT NULL,
  `recursos_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `roles_id` (`roles_id`),
  KEY `recursos_id` (`recursos_id`),
  CONSTRAINT `roles_recursos_ibfk_1` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `roles_recursos_ibfk_2` FOREIGN KEY (`recursos_id`) REFERENCES `recursos` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roles_recursos
-- ----------------------------
INSERT INTO `roles_recursos` VALUES ('1', '4', '1');
INSERT INTO `roles_recursos` VALUES ('2', '4', '2');
INSERT INTO `roles_recursos` VALUES ('3', '4', '3');
INSERT INTO `roles_recursos` VALUES ('4', '4', '4');
INSERT INTO `roles_recursos` VALUES ('5', '4', '5');
INSERT INTO `roles_recursos` VALUES ('6', '4', '6');
INSERT INTO `roles_recursos` VALUES ('7', '2', '2');
INSERT INTO `roles_recursos` VALUES ('8', '2', '3');
INSERT INTO `roles_recursos` VALUES ('9', '2', '6');
INSERT INTO `roles_recursos` VALUES ('10', '1', '7');

-- ----------------------------
-- Table structure for `roles_usuarios`
-- ----------------------------
DROP TABLE IF EXISTS `roles_usuarios`;
CREATE TABLE `roles_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roles_id` int(11) NOT NULL,
  `usuarios_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `roles_id` (`roles_id`),
  KEY `usuarios_id` (`usuarios_id`),
  CONSTRAINT `roles_usuarios_ibfk_1` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `roles_usuarios_ibfk_2` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roles_usuarios
-- ----------------------------
INSERT INTO `roles_usuarios` VALUES ('2', '2', '3');
INSERT INTO `roles_usuarios` VALUES ('3', '4', '3');
INSERT INTO `roles_usuarios` VALUES ('56', '1', '2');

-- ----------------------------
-- Table structure for `usuarios`
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `clave` varchar(40) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES ('2', 'usuario', 'K2932zu3yPbLQ', 'usuario del sistema', 'programador.manuel@gmail.com', '1');
INSERT INTO `usuarios` VALUES ('3', 'admin', 'K2932zu3yPbLQ', 'usuario administrador del sistema', 'manuel_j555@hotmail.com', '1');

/*
Navicat PGSQL Data Transfer

Source Server         : local postgress
Source Server Version : 90204
Source Host           : localhost:5432
Source Database       : backend
Source Schema         : public

Target Server Type    : PGSQL
Target Server Version : 90204
File Encoding         : 65001

Date: 2013-05-26 01:29:22
*/


-- ----------------------------
-- Sequence structure for "public"."logs_id_seq"
-- ----------------------------
DROP SEQUENCE "public"."logs_id_seq";
CREATE SEQUENCE "public"."logs_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;

-- ----------------------------
-- Sequence structure for "public"."menus_id_seq"
-- ----------------------------
DROP SEQUENCE "public"."menus_id_seq";
CREATE SEQUENCE "public"."menus_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;

-- ----------------------------
-- Sequence structure for "public"."recursos_id_seq"
-- ----------------------------
DROP SEQUENCE "public"."recursos_id_seq";
CREATE SEQUENCE "public"."recursos_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;

-- ----------------------------
-- Sequence structure for "public"."roles_id_seq"
-- ----------------------------
DROP SEQUENCE "public"."roles_id_seq";
CREATE SEQUENCE "public"."roles_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;

-- ----------------------------
-- Sequence structure for "public"."roles_recursos_id_seq"
-- ----------------------------
DROP SEQUENCE "public"."roles_recursos_id_seq";
CREATE SEQUENCE "public"."roles_recursos_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 31
 CACHE 1;

-- ----------------------------
-- Sequence structure for "public"."roles_usuarios_id_seq"
-- ----------------------------
DROP SEQUENCE "public"."roles_usuarios_id_seq";
CREATE SEQUENCE "public"."roles_usuarios_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;

-- ----------------------------
-- Sequence structure for "public"."usuarios_id_seq"
-- ----------------------------
DROP SEQUENCE "public"."usuarios_id_seq";
CREATE SEQUENCE "public"."usuarios_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;

-- ----------------------------
-- Table structure for "public"."logs"
-- ----------------------------
DROP TABLE "public"."logs";
CREATE TABLE "public"."logs" (
"id" int4 DEFAULT nextval('logs_id_seq'::regclass) NOT NULL,
"usuarios_id" int4,
"query_type" varchar(20) NOT NULL,
"sql_query" text NOT NULL,
"tabla" varchar(20)
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of logs
-- ----------------------------

-- ----------------------------
-- Table structure for "public"."menus"
-- ----------------------------
DROP TABLE "public"."menus";
CREATE TABLE "public"."menus" (
"id" int4 DEFAULT nextval('menus_id_seq'::regclass) NOT NULL,
"menus_id" int4,
"nombre" varchar(100) NOT NULL,
"url" varchar(100) NOT NULL,
"posicion" int4 NOT NULL,
"clases" varchar(50),
"visible_en" int4 NOT NULL,
"activo" int4 NOT NULL
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO "public"."menus" VALUES ('1', null, 'Administración', 'admin/usuarios', '100', null, '1', '1');
INSERT INTO "public"."menus" VALUES ('2', '1', 'Usuarios', 'admin/usuarios', '100', null, '1', '1');
INSERT INTO "public"."menus" VALUES ('3', '1', 'Roles', 'admin/roles', '100', null, '1', '1');
INSERT INTO "public"."menus" VALUES ('4', null, 'Mi Perfil', 'admin/usuarios/perfil', '90', null, '1', '1');
INSERT INTO "public"."menus" VALUES ('5', '1', 'Menús', 'admin/menu', '100', null, '2', '1');
INSERT INTO "public"."menus" VALUES ('6', '1', 'Privilegios', 'admin/privilegios', '101', null, '1', '1');
INSERT INTO "public"."menus" VALUES ('7', '1', 'Recursos', 'admin/recursos', '100', null, '1', '1');
INSERT INTO "public"."menus" VALUES ('8', '1', 'Auditorias', 'admin/logs', '110', null, '1', '1');

-- ----------------------------
-- Table structure for "public"."recursos"
-- ----------------------------
DROP TABLE "public"."recursos";
CREATE TABLE "public"."recursos" (
"id" int4 NOT NULL,
"recurso" varchar(200) NOT NULL,
"descripcion" text,
"activo" int4 NOT NULL
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of recursos
-- ----------------------------
INSERT INTO "public"."recursos" VALUES ('1', 'admin/*', 'modulo para la administracion de usuarios', '1');
INSERT INTO "public"."recursos" VALUES ('2', 'admin/usuarios/*', 'modulo para la administracion de usuarios', '1');
INSERT INTO "public"."recursos" VALUES ('3', 'admin/roles/*', 'modulo para la administracion de roles', '1');
INSERT INTO "public"."recursos" VALUES ('4', 'admin/recursos/*', 'modulo para la administracion de recursos', '1');
INSERT INTO "public"."recursos" VALUES ('5', 'admin/privilegios/*', 'modulo para la administracion de privilegios', '1');
INSERT INTO "public"."recursos" VALUES ('6', 'admin/menu/*', 'modulo para la administracion de menus', '1');
INSERT INTO "public"."recursos" VALUES ('7', 'admin/usuarios/perfil', 'edición del perfil del usuario', '1');

-- ----------------------------
-- Table structure for "public"."roles"
-- ----------------------------
DROP TABLE "public"."roles";
CREATE TABLE "public"."roles" (
"id" int4 DEFAULT nextval('roles_id_seq'::regclass) NOT NULL,
"rol" varchar(50) NOT NULL,
"plantilla" varchar(50),
"activo" int4 NOT NULL
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO "public"."roles" VALUES ('1', 'usuario comun', null, '1');
INSERT INTO "public"."roles" VALUES ('2', 'usuario administrador', null, '1');
INSERT INTO "public"."roles" VALUES ('4', 'administrador del sistema', null, '1');

-- ----------------------------
-- Table structure for "public"."roles_recursos"
-- ----------------------------
DROP TABLE "public"."roles_recursos";
CREATE TABLE "public"."roles_recursos" (
"id" int4 DEFAULT nextval('roles_recursos_id_seq'::regclass) NOT NULL,
"roles_id" int4 NOT NULL,
"recursos_id" int4 NOT NULL
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of roles_recursos
-- ----------------------------
INSERT INTO "public"."roles_recursos" VALUES ('1', '4', '1');
INSERT INTO "public"."roles_recursos" VALUES ('2', '4', '2');
INSERT INTO "public"."roles_recursos" VALUES ('3', '4', '3');
INSERT INTO "public"."roles_recursos" VALUES ('4', '4', '4');
INSERT INTO "public"."roles_recursos" VALUES ('5', '4', '5');
INSERT INTO "public"."roles_recursos" VALUES ('6', '4', '6');
INSERT INTO "public"."roles_recursos" VALUES ('7', '2', '2');
INSERT INTO "public"."roles_recursos" VALUES ('8', '2', '3');
INSERT INTO "public"."roles_recursos" VALUES ('9', '2', '6');
INSERT INTO "public"."roles_recursos" VALUES ('10', '1', '7');

-- ----------------------------
-- Table structure for "public"."roles_usuarios"
-- ----------------------------
DROP TABLE "public"."roles_usuarios";
CREATE TABLE "public"."roles_usuarios" (
"id" int4 DEFAULT nextval('roles_usuarios_id_seq'::regclass) NOT NULL,
"roles_id" int4 NOT NULL,
"usuarios_id" int4 NOT NULL
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of roles_usuarios
-- ----------------------------
INSERT INTO "public"."roles_usuarios" VALUES ('2', '2', '3');
INSERT INTO "public"."roles_usuarios" VALUES ('3', '4', '3');
INSERT INTO "public"."roles_usuarios" VALUES ('56', '1', '2');

-- ----------------------------
-- Table structure for "public"."usuarios"
-- ----------------------------
DROP TABLE "public"."usuarios";
CREATE TABLE "public"."usuarios" (
"id" int4 DEFAULT nextval('usuarios_id_seq'::regclass) NOT NULL,
"login" varchar(50) NOT NULL,
"clave" varchar(40) NOT NULL,
"nombres" varchar(100) NOT NULL,
"email" varchar(100) NOT NULL,
"activo" int4 NOT NULL
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO "public"."usuarios" VALUES ('2', 'usuario', 'K2932zu3yPbLQ', 'usuario del sistema', 'programador.manuel@gmail.com', '1');
INSERT INTO "public"."usuarios" VALUES ('3', 'admin', 'K2932zu3yPbLQ', 'usuario administrador del sistema', 'manuel_j555@hotmail.com', '1');

-- ----------------------------
-- Alter Sequences Owned By 
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table "public"."logs"
-- ----------------------------
ALTER TABLE "public"."logs" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table "public"."menus"
-- ----------------------------
ALTER TABLE "public"."menus" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table "public"."recursos"
-- ----------------------------
ALTER TABLE "public"."recursos" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table "public"."roles"
-- ----------------------------
ALTER TABLE "public"."roles" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table "public"."roles_recursos"
-- ----------------------------
ALTER TABLE "public"."roles_recursos" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table "public"."roles_usuarios"
-- ----------------------------
ALTER TABLE "public"."roles_usuarios" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table "public"."usuarios"
-- ----------------------------
ALTER TABLE "public"."usuarios" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Key structure for table "public"."logs"
-- ----------------------------
ALTER TABLE "public"."logs" ADD FOREIGN KEY ("usuarios_id") REFERENCES "public"."usuarios" ("id") ON DELETE RESTRICT ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Key structure for table "public"."menus"
-- ----------------------------
ALTER TABLE "public"."menus" ADD FOREIGN KEY ("menus_id") REFERENCES "public"."menus" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Key structure for table "public"."roles_recursos"
-- ----------------------------
ALTER TABLE "public"."roles_recursos" ADD FOREIGN KEY ("roles_id") REFERENCES "public"."roles" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."roles_recursos" ADD FOREIGN KEY ("recursos_id") REFERENCES "public"."recursos" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Key structure for table "public"."roles_usuarios"
-- ----------------------------
ALTER TABLE "public"."roles_usuarios" ADD FOREIGN KEY ("usuarios_id") REFERENCES "public"."usuarios" ("id") ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE "public"."roles_usuarios" ADD FOREIGN KEY ("roles_id") REFERENCES "public"."roles" ("id") ON DELETE RESTRICT ON UPDATE CASCADE;



CREATE TABLE `tbl_bitacora` (
  `id_bitacora` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `accion` varchar(50) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `fecha_accion` datetime NOT NULL,
  `usuario_id` int(10) unsigned NOT NULL,
  `objeto_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_bitacora`),
  KEY `fk_bitacora_usuarios` (`usuario_id`),
  KEY `fk_bitacora_objeto` (`objeto_id`),
  CONSTRAINT `fk_bitacora_objeto` FOREIGN KEY (`objeto_id`) REFERENCES `tbl_objeto` (`id_objeto`),
  CONSTRAINT `fk_bitacora_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `tbl_usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=445 DEFAULT CHARSET=utf8;

INSERT INTO tbl_bitacora VALUES("27","Inicio de sesion","Se inicio sesion correctamente","2021-01-31 21:37:39","2","1");
INSERT INTO tbl_bitacora VALUES("28","Inicio de sesion","Inicio de sesion correctamente","2021-01-31 21:42:41","2","1");
INSERT INTO tbl_bitacora VALUES("29","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-01-31 21:49:36","2","1");
INSERT INTO tbl_bitacora VALUES("30","Inicio de sesion","Inicio de sesion correctamente","2021-01-31 21:55:33","2","1");
INSERT INTO tbl_bitacora VALUES("31","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-01-31 21:55:48","2","1");
INSERT INTO tbl_bitacora VALUES("32","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-01-31 21:55:56","2","1");
INSERT INTO tbl_bitacora VALUES("33","usuario bloqueado","Usuario bloqueado, realizó los 3 intentos permitidos para acceder al sistema","2021-01-31 21:56:03","2","1");
INSERT INTO tbl_bitacora VALUES("34","usuario bloqueado","ERROR: intento de inicio de sesión con usuario bloqueado","2021-01-31 21:56:12","2","1");
INSERT INTO tbl_bitacora VALUES("35","usuario bloqueado","ERROR: intento de inicio de sesión con usuario bloqueado","2021-01-31 22:32:05","2","1");
INSERT INTO tbl_bitacora VALUES("36","Inicio de sesion","Inicio de sesion correctamente","2021-01-31 22:32:33","2","1");
INSERT INTO tbl_bitacora VALUES("37","Inicio de sesion","Inicio de sesion correctamente","2021-01-31 22:42:42","2","1");
INSERT INTO tbl_bitacora VALUES("38","Inicio de sesion","Inicio de sesion correctamente","2021-01-31 23:57:42","2","1");
INSERT INTO tbl_bitacora VALUES("39","Inicio de sesion","Inicio de sesion correctamente","2021-02-01 18:24:14","2","1");
INSERT INTO tbl_bitacora VALUES("40","Inicio de sesion","Inicio de sesion correctamente","2021-02-01 18:24:53","2","1");
INSERT INTO tbl_bitacora VALUES("41","Inicio de sesion","Inicio de sesion correctamente","2021-02-02 15:45:34","2","1");
INSERT INTO tbl_bitacora VALUES("42","usuario bloqueado","ERROR: intento de inicio de sesión con usuario bloqueado","2021-02-02 15:46:04","7","1");
INSERT INTO tbl_bitacora VALUES("43","Inicio de sesion","Inicio de sesion correctamente","2021-02-02 15:46:58","7","1");
INSERT INTO tbl_bitacora VALUES("44","Inicio de sesion","Inicio de sesion correctamente","2021-02-02 18:51:24","2","1");
INSERT INTO tbl_bitacora VALUES("45","Inicio de sesion","Inicio de sesion correctamente","2021-02-02 19:06:41","7","1");
INSERT INTO tbl_bitacora VALUES("46","Inicio de sesion","Inicio de sesion correctamente","2021-02-02 19:29:52","7","1");
INSERT INTO tbl_bitacora VALUES("47","Inicio de sesion","Inicio de sesion correctamente","2021-02-02 19:34:07","7","1");
INSERT INTO tbl_bitacora VALUES("48","Inicio de sesion","Inicio de sesion correctamente","2021-02-02 19:36:48","7","1");
INSERT INTO tbl_bitacora VALUES("49","Inicio de sesion","Inicio de sesion correctamente","2021-02-02 19:50:33","7","1");
INSERT INTO tbl_bitacora VALUES("50","Inicio de sesion","Inicio de sesion correctamente","2021-02-05 17:45:22","15","1");
INSERT INTO tbl_bitacora VALUES("51","Inicio de sesion","Inicio de sesion correctamente","2021-02-05 18:43:40","15","1");
INSERT INTO tbl_bitacora VALUES("52","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-05 19:43:52","15","1");
INSERT INTO tbl_bitacora VALUES("53","Inicio de sesion","Inicio de sesion correctamente","2021-02-05 19:43:59","15","1");
INSERT INTO tbl_bitacora VALUES("54","Inicio de sesion","Inicio de sesion correctamente","2021-02-05 20:03:16","2","1");
INSERT INTO tbl_bitacora VALUES("55","Inicio de sesion","Inicio de sesion correctamente","2021-02-05 20:25:43","7","1");
INSERT INTO tbl_bitacora VALUES("56","Inicio de sesion","Inicio de sesion correctamente","2021-02-09 17:34:27","7","1");
INSERT INTO tbl_bitacora VALUES("57","Inicio de sesion","Inicio de sesion correctamente","2021-02-09 18:13:53","7","1");
INSERT INTO tbl_bitacora VALUES("58","Inicio de sesion","Inicio de sesion correctamente","2021-02-09 18:14:43","2","1");
INSERT INTO tbl_bitacora VALUES("59","Inicio de sesion","Inicio de sesion correctamente","2021-02-09 18:27:06","7","1");
INSERT INTO tbl_bitacora VALUES("60","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-09 19:35:06","2","1");
INSERT INTO tbl_bitacora VALUES("61","Inicio de sesion","Inicio de sesion correctamente","2021-02-09 19:35:21","2","1");
INSERT INTO tbl_bitacora VALUES("62","Inicio de sesion","Inicio de sesion correctamente","2021-02-09 20:36:13","7","1");
INSERT INTO tbl_bitacora VALUES("63","Inicio de sesion","Inicio de sesion correctamente","2021-02-09 21:54:21","2","1");
INSERT INTO tbl_bitacora VALUES("64","Inicio de sesion","Inicio de sesion correctamente","2021-02-09 21:59:30","7","1");
INSERT INTO tbl_bitacora VALUES("65","Inicio de sesion","Inicio de sesion correctamente","2021-02-09 22:38:35","2","1");
INSERT INTO tbl_bitacora VALUES("66","Inicio de sesion","Inicio de sesion correctamente","2021-02-09 23:16:56","7","1");
INSERT INTO tbl_bitacora VALUES("67","Inicio de sesion","Inicio de sesion correctamente","2021-02-09 23:24:38","2","1");
INSERT INTO tbl_bitacora VALUES("68","Inicio de sesion","Inicio de sesion correctamente","2021-02-09 23:58:42","7","1");
INSERT INTO tbl_bitacora VALUES("69","Inicio de sesion","Inicio de sesion correctamente","2021-02-10 00:12:36","2","1");
INSERT INTO tbl_bitacora VALUES("70","Inicio de sesion","Inicio de sesion correctamente","2021-02-10 00:17:50","7","1");
INSERT INTO tbl_bitacora VALUES("71","Inicio de sesion","Inicio de sesion correctamente","2021-02-10 00:18:29","2","1");
INSERT INTO tbl_bitacora VALUES("72","Inicio de sesion","Inicio de sesion correctamente","2021-02-10 00:43:23","7","1");
INSERT INTO tbl_bitacora VALUES("73","Inicio de sesion","Inicio de sesion correctamente","2021-02-10 00:48:31","2","1");
INSERT INTO tbl_bitacora VALUES("74","Inicio de sesion","Inicio de sesion correctamente","2021-02-10 00:50:28","7","1");
INSERT INTO tbl_bitacora VALUES("75","Inicio de sesion","Inicio de sesion correctamente","2021-02-10 09:16:12","2","1");
INSERT INTO tbl_bitacora VALUES("76","Inicio de sesion","Inicio de sesion correctamente","2021-02-10 09:23:36","7","1");
INSERT INTO tbl_bitacora VALUES("77","Inicio de sesion","Inicio de sesion correctamente","2021-02-10 12:09:47","7","1");
INSERT INTO tbl_bitacora VALUES("78","Inicio de sesion","Inicio de sesion correctamente","2021-02-10 12:15:14","2","1");
INSERT INTO tbl_bitacora VALUES("79","Inicio de sesion","Inicio de sesion correctamente","2021-02-10 13:19:50","7","1");
INSERT INTO tbl_bitacora VALUES("80","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-10 20:24:51","2","1");
INSERT INTO tbl_bitacora VALUES("81","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-10 20:25:13","2","1");
INSERT INTO tbl_bitacora VALUES("82","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-10 20:27:41","2","1");
INSERT INTO tbl_bitacora VALUES("83","Inicio de sesion","Inicio de sesion correctamente","2021-02-10 20:27:53","2","1");
INSERT INTO tbl_bitacora VALUES("84","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-10 20:31:15","15","1");
INSERT INTO tbl_bitacora VALUES("85","Inicio de sesion","Inicio de sesion correctamente","2021-02-10 20:31:24","15","1");
INSERT INTO tbl_bitacora VALUES("86","Inicio de sesion","Inicio de sesion correctamente","2021-02-10 20:56:15","2","1");
INSERT INTO tbl_bitacora VALUES("87","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-10 21:42:49","2","1");
INSERT INTO tbl_bitacora VALUES("88","usuario bloqueado","Usuario bloqueado, realizó los 3 intentos permitidos para acceder al sistema","2021-02-10 21:43:14","2","1");
INSERT INTO tbl_bitacora VALUES("89","Inicio de sesion","Inicio de sesion correctamente","2021-02-10 21:44:00","2","1");
INSERT INTO tbl_bitacora VALUES("90","Inicio de sesion","Inicio de sesion correctamente","2021-02-10 22:28:25","7","1");
INSERT INTO tbl_bitacora VALUES("91","Inicio de sesion","Inicio de sesion correctamente","2021-02-10 22:34:14","2","1");
INSERT INTO tbl_bitacora VALUES("92","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-10 22:45:44","2","1");
INSERT INTO tbl_bitacora VALUES("93","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-10 22:46:16","2","1");
INSERT INTO tbl_bitacora VALUES("94","Inicio de sesion","Inicio de sesion correctamente","2021-02-10 22:46:27","2","1");
INSERT INTO tbl_bitacora VALUES("95","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-10 22:58:26","2","1");
INSERT INTO tbl_bitacora VALUES("96","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-10 23:22:38","2","1");
INSERT INTO tbl_bitacora VALUES("97","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-10 23:27:28","2","1");
INSERT INTO tbl_bitacora VALUES("98","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-10 23:30:23","2","1");
INSERT INTO tbl_bitacora VALUES("99","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-10 23:33:19","2","1");
INSERT INTO tbl_bitacora VALUES("100","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-10 23:35:46","2","1");
INSERT INTO tbl_bitacora VALUES("101","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-10 23:42:50","2","1");
INSERT INTO tbl_bitacora VALUES("102","Inicio de sesion","Inicio de sesion correctamente","2021-02-10 23:45:15","2","1");
INSERT INTO tbl_bitacora VALUES("103","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-10 23:47:57","2","1");
INSERT INTO tbl_bitacora VALUES("104","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-10 23:51:40","2","1");
INSERT INTO tbl_bitacora VALUES("105","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-11 00:03:15","2","1");
INSERT INTO tbl_bitacora VALUES("106","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-11 00:07:33","2","1");
INSERT INTO tbl_bitacora VALUES("107","Inicio de sesion","Inicio de sesion correctamente","2021-02-11 00:08:37","2","1");
INSERT INTO tbl_bitacora VALUES("108","Inicio de sesion","Inicio de sesion correctamente","2021-02-11 00:20:33","2","1");
INSERT INTO tbl_bitacora VALUES("109","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-11 00:31:08","2","1");
INSERT INTO tbl_bitacora VALUES("110","Inicio de sesion","Inicio de sesion correctamente","2021-02-11 00:31:16","2","1");
INSERT INTO tbl_bitacora VALUES("111","Inicio de sesion","Inicio de sesion correctamente","2021-02-11 00:44:01","2","1");
INSERT INTO tbl_bitacora VALUES("112","Inicio de sesion","Inicio de sesion correctamente","2021-02-11 01:28:22","7","1");
INSERT INTO tbl_bitacora VALUES("113","Inicio de sesion","Inicio de sesion correctamente","2021-02-11 10:13:20","7","1");
INSERT INTO tbl_bitacora VALUES("114","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-11 11:02:01","7","1");
INSERT INTO tbl_bitacora VALUES("115","Inicio de sesion","Inicio de sesion correctamente","2021-02-11 11:02:09","7","1");
INSERT INTO tbl_bitacora VALUES("116","Inicio de sesion","Inicio de sesion correctamente","2021-02-11 11:12:10","7","1");
INSERT INTO tbl_bitacora VALUES("117","Inicio de sesion","Inicio de sesion correctamente","2021-02-11 17:11:53","7","1");
INSERT INTO tbl_bitacora VALUES("118","Inicio de sesion","Inicio de sesion correctamente","2021-02-11 18:07:53","7","1");
INSERT INTO tbl_bitacora VALUES("119","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-11 18:10:51","7","1");
INSERT INTO tbl_bitacora VALUES("120","Inicio de sesion","Inicio de sesion correctamente","2021-02-11 18:14:57","18","1");
INSERT INTO tbl_bitacora VALUES("121","Inicio de sesion","Inicio de sesion correctamente","2021-02-12 22:50:02","7","1");
INSERT INTO tbl_bitacora VALUES("122","Inicio de sesion","Inicio de sesion correctamente","2021-02-14 19:58:32","7","1");
INSERT INTO tbl_bitacora VALUES("123","Inicio de sesion","Inicio de sesion correctamente","2021-02-15 10:44:08","7","1");
INSERT INTO tbl_bitacora VALUES("124","Inicio de sesion","Inicio de sesion correctamente","2021-02-15 10:45:39","7","1");
INSERT INTO tbl_bitacora VALUES("125","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-15 11:14:32","7","1");
INSERT INTO tbl_bitacora VALUES("126","Inicio de sesion","Inicio de sesion correctamente","2021-02-15 11:34:04","7","1");
INSERT INTO tbl_bitacora VALUES("127","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-15 11:50:07","7","1");
INSERT INTO tbl_bitacora VALUES("128","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-15 11:50:29","7","1");
INSERT INTO tbl_bitacora VALUES("129","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-15 11:52:39","7","1");
INSERT INTO tbl_bitacora VALUES("130","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-15 11:52:47","7","1");
INSERT INTO tbl_bitacora VALUES("131","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-15 11:52:54","7","1");
INSERT INTO tbl_bitacora VALUES("132","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-15 11:57:52","7","1");
INSERT INTO tbl_bitacora VALUES("133","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-15 11:57:57","7","1");
INSERT INTO tbl_bitacora VALUES("134","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-15 11:58:00","7","1");
INSERT INTO tbl_bitacora VALUES("135","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-15 21:50:06","2","1");
INSERT INTO tbl_bitacora VALUES("136","Inicio de sesion","Inicio de sesion correctamente","2021-02-15 21:50:18","7","1");
INSERT INTO tbl_bitacora VALUES("137","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 21:41:51","2","1");
INSERT INTO tbl_bitacora VALUES("138","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 21:41:56","2","1");
INSERT INTO tbl_bitacora VALUES("139","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 21:43:50","2","1");
INSERT INTO tbl_bitacora VALUES("140","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 21:43:54","2","1");
INSERT INTO tbl_bitacora VALUES("141","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 21:43:57","2","1");
INSERT INTO tbl_bitacora VALUES("142","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 21:44:48","2","1");
INSERT INTO tbl_bitacora VALUES("143","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 21:44:50","2","1");
INSERT INTO tbl_bitacora VALUES("144","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 21:44:53","2","1");
INSERT INTO tbl_bitacora VALUES("145","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 21:45:13","2","1");
INSERT INTO tbl_bitacora VALUES("146","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 21:45:16","2","1");
INSERT INTO tbl_bitacora VALUES("147","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 21:45:19","2","1");
INSERT INTO tbl_bitacora VALUES("148","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 21:46:39","2","1");
INSERT INTO tbl_bitacora VALUES("149","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 21:46:42","2","1");
INSERT INTO tbl_bitacora VALUES("150","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 21:46:44","2","1");
INSERT INTO tbl_bitacora VALUES("151","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 21:49:05","2","1");
INSERT INTO tbl_bitacora VALUES("152","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 21:49:08","2","1");
INSERT INTO tbl_bitacora VALUES("153","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 21:49:12","2","1");
INSERT INTO tbl_bitacora VALUES("154","Inicio de sesion","Inicio de sesion correctamente","2021-02-17 21:50:55","7","1");
INSERT INTO tbl_bitacora VALUES("155","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 17:35:17","2","1");
INSERT INTO tbl_bitacora VALUES("156","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 17:35:20","2","1");
INSERT INTO tbl_bitacora VALUES("157","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 17:35:22","2","1");
INSERT INTO tbl_bitacora VALUES("158","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 17:41:59","2","1");
INSERT INTO tbl_bitacora VALUES("159","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 17:42:02","2","1");
INSERT INTO tbl_bitacora VALUES("160","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 17:42:05","2","1");
INSERT INTO tbl_bitacora VALUES("161","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 17:43:52","2","1");
INSERT INTO tbl_bitacora VALUES("162","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 17:43:55","2","1");
INSERT INTO tbl_bitacora VALUES("163","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 17:43:57","2","1");
INSERT INTO tbl_bitacora VALUES("164","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 17:49:52","2","1");
INSERT INTO tbl_bitacora VALUES("165","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 17:49:57","2","1");
INSERT INTO tbl_bitacora VALUES("166","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 17:50:00","2","1");
INSERT INTO tbl_bitacora VALUES("167","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 17:57:26","2","1");
INSERT INTO tbl_bitacora VALUES("168","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 17:57:44","2","1");
INSERT INTO tbl_bitacora VALUES("169","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 17:57:46","2","1");
INSERT INTO tbl_bitacora VALUES("170","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 17:57:48","2","1");
INSERT INTO tbl_bitacora VALUES("171","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 17:57:50","2","1");
INSERT INTO tbl_bitacora VALUES("172","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 17:57:53","2","1");
INSERT INTO tbl_bitacora VALUES("173","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 17:58:13","2","1");
INSERT INTO tbl_bitacora VALUES("174","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 17:58:15","2","1");
INSERT INTO tbl_bitacora VALUES("175","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 17:58:17","2","1");
INSERT INTO tbl_bitacora VALUES("176","usuario bloqueado","ERROR: intento de inicio de sesión con usuario bloqueado","2021-02-17 18:17:13","2","1");
INSERT INTO tbl_bitacora VALUES("177","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 18:17:29","2","1");
INSERT INTO tbl_bitacora VALUES("178","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 18:17:31","2","1");
INSERT INTO tbl_bitacora VALUES("179","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 18:17:34","2","1");
INSERT INTO tbl_bitacora VALUES("180","Inicio de sesion","Inicio de sesion correctamente","2021-02-17 18:19:37","7","1");
INSERT INTO tbl_bitacora VALUES("181","Inicio de sesion","Inicio de sesion correctamente","2021-02-17 18:33:25","7","1");
INSERT INTO tbl_bitacora VALUES("182","Inicio de sesion","Inicio de sesion correctamente","2021-02-17 18:34:18","7","1");
INSERT INTO tbl_bitacora VALUES("183","Inicio de sesion","Inicio de sesion correctamente","2021-02-17 18:35:59","7","1");
INSERT INTO tbl_bitacora VALUES("184","Inicio de sesion","Inicio de sesion correctamente","2021-02-17 18:39:48","7","1");
INSERT INTO tbl_bitacora VALUES("185","Inicio de sesion","Inicio de sesion correctamente","2021-02-17 18:45:17","7","1");
INSERT INTO tbl_bitacora VALUES("186","Inicio de sesion","Inicio de sesion correctamente","2021-02-17 18:47:09","7","1");
INSERT INTO tbl_bitacora VALUES("187","Inicio de sesion","Inicio de sesion correctamente","2021-02-17 18:48:22","7","1");
INSERT INTO tbl_bitacora VALUES("188","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 18:48:47","7","1");
INSERT INTO tbl_bitacora VALUES("189","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 18:49:07","7","1");
INSERT INTO tbl_bitacora VALUES("190","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 18:49:57","7","1");
INSERT INTO tbl_bitacora VALUES("191","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 18:50:21","7","1");
INSERT INTO tbl_bitacora VALUES("192","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 18:50:23","7","1");
INSERT INTO tbl_bitacora VALUES("193","Inicio de sesion","Inicio de sesion correctamente","2021-02-17 18:51:11","12","1");
INSERT INTO tbl_bitacora VALUES("194","Inicio de sesion","Inicio de sesion correctamente","2021-02-17 18:52:54","12","1");
INSERT INTO tbl_bitacora VALUES("195","Inicio de sesion","Inicio de sesion correctamente","2021-02-17 18:54:02","12","1");
INSERT INTO tbl_bitacora VALUES("196","Inicio de sesion","Inicio de sesion correctamente","2021-02-17 18:56:06","12","1");
INSERT INTO tbl_bitacora VALUES("197","Inicio de sesion","Inicio de sesion correctamente","2021-02-17 20:08:22","12","1");
INSERT INTO tbl_bitacora VALUES("198","Inicio de sesion","Inicio de sesion correctamente","2021-02-17 21:02:45","12","1");
INSERT INTO tbl_bitacora VALUES("199","Inicio de sesion","Inicio de sesion correctamente","2021-02-17 21:22:39","12","1");
INSERT INTO tbl_bitacora VALUES("200","Inicio de sesion","Inicio de sesion correctamente","2021-02-17 22:21:55","12","1");
INSERT INTO tbl_bitacora VALUES("201","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 22:51:01","12","1");
INSERT INTO tbl_bitacora VALUES("202","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 22:51:05","12","1");
INSERT INTO tbl_bitacora VALUES("203","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 22:51:07","12","1");
INSERT INTO tbl_bitacora VALUES("204","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 22:58:48","12","1");
INSERT INTO tbl_bitacora VALUES("205","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:00:24","12","1");
INSERT INTO tbl_bitacora VALUES("206","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:00:28","12","1");
INSERT INTO tbl_bitacora VALUES("207","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:00:37","12","1");
INSERT INTO tbl_bitacora VALUES("208","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:01:37","12","1");
INSERT INTO tbl_bitacora VALUES("209","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:01:40","12","1");
INSERT INTO tbl_bitacora VALUES("210","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:01:48","12","1");
INSERT INTO tbl_bitacora VALUES("211","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:01:51","12","1");
INSERT INTO tbl_bitacora VALUES("212","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:01:53","12","1");
INSERT INTO tbl_bitacora VALUES("213","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:02:58","12","1");
INSERT INTO tbl_bitacora VALUES("214","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:03:01","12","1");
INSERT INTO tbl_bitacora VALUES("215","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:03:03","12","1");
INSERT INTO tbl_bitacora VALUES("216","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:03:34","12","1");
INSERT INTO tbl_bitacora VALUES("217","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:04:05","12","1");
INSERT INTO tbl_bitacora VALUES("218","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:04:19","12","1");
INSERT INTO tbl_bitacora VALUES("219","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:20:31","12","1");
INSERT INTO tbl_bitacora VALUES("220","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:20:37","12","1");
INSERT INTO tbl_bitacora VALUES("221","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:20:40","12","1");
INSERT INTO tbl_bitacora VALUES("222","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:20:44","12","1");
INSERT INTO tbl_bitacora VALUES("223","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:22:31","12","1");
INSERT INTO tbl_bitacora VALUES("224","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:22:35","12","1");
INSERT INTO tbl_bitacora VALUES("225","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:22:37","12","1");
INSERT INTO tbl_bitacora VALUES("226","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:40:37","12","1");
INSERT INTO tbl_bitacora VALUES("227","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:41:24","12","1");
INSERT INTO tbl_bitacora VALUES("228","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:41:28","12","1");
INSERT INTO tbl_bitacora VALUES("229","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:41:32","12","1");
INSERT INTO tbl_bitacora VALUES("230","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:47:18","12","1");
INSERT INTO tbl_bitacora VALUES("231","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:47:20","12","1");
INSERT INTO tbl_bitacora VALUES("232","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:47:23","12","1");
INSERT INTO tbl_bitacora VALUES("233","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:48:29","12","1");
INSERT INTO tbl_bitacora VALUES("234","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:48:32","12","1");
INSERT INTO tbl_bitacora VALUES("235","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-17 23:48:34","12","1");
INSERT INTO tbl_bitacora VALUES("236","Inicio de sesion","Inicio de sesion correctamente","2021-02-17 23:55:04","12","1");
INSERT INTO tbl_bitacora VALUES("237","Inicio de sesion","Inicio de sesion correctamente","2021-02-18 09:14:56","12","1");
INSERT INTO tbl_bitacora VALUES("238","Inicio de sesion","Inicio de sesion correctamente","2021-02-18 10:46:19","12","1");
INSERT INTO tbl_bitacora VALUES("239","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-18 11:16:02","2","1");
INSERT INTO tbl_bitacora VALUES("240","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-18 11:16:05","2","1");
INSERT INTO tbl_bitacora VALUES("241","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-18 11:16:08","2","1");
INSERT INTO tbl_bitacora VALUES("242","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-18 11:22:05","2","1");
INSERT INTO tbl_bitacora VALUES("243","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-18 11:29:37","2","1");
INSERT INTO tbl_bitacora VALUES("244","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-18 11:31:15","2","1");
INSERT INTO tbl_bitacora VALUES("245","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-18 11:31:18","2","1");
INSERT INTO tbl_bitacora VALUES("246","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-18 11:31:21","2","1");
INSERT INTO tbl_bitacora VALUES("247","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-18 11:31:25","2","1");
INSERT INTO tbl_bitacora VALUES("248","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-18 11:31:54","2","1");
INSERT INTO tbl_bitacora VALUES("249","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-18 11:31:56","2","1");
INSERT INTO tbl_bitacora VALUES("250","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-18 11:32:08","2","1");
INSERT INTO tbl_bitacora VALUES("251","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-18 11:35:43","2","1");
INSERT INTO tbl_bitacora VALUES("252","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-18 11:35:46","2","1");
INSERT INTO tbl_bitacora VALUES("253","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-18 11:35:49","2","1");
INSERT INTO tbl_bitacora VALUES("254","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-18 11:38:26","2","1");
INSERT INTO tbl_bitacora VALUES("255","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-18 11:38:29","2","1");
INSERT INTO tbl_bitacora VALUES("256","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-18 11:38:32","2","1");
INSERT INTO tbl_bitacora VALUES("257","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-18 11:54:17","2","1");
INSERT INTO tbl_bitacora VALUES("258","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-18 11:54:20","2","1");
INSERT INTO tbl_bitacora VALUES("259","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-18 11:54:23","2","1");
INSERT INTO tbl_bitacora VALUES("260","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-18 11:57:21","12","1");
INSERT INTO tbl_bitacora VALUES("261","Inicio de sesion","Inicio de sesion correctamente","2021-02-18 11:57:28","12","1");
INSERT INTO tbl_bitacora VALUES("262","Inicio de sesion","Inicio de sesion correctamente","2021-02-19 04:05:44","12","1");
INSERT INTO tbl_bitacora VALUES("263","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-19 04:07:47","12","1");
INSERT INTO tbl_bitacora VALUES("264","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-19 04:07:51","12","1");
INSERT INTO tbl_bitacora VALUES("265","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-19 04:14:48","2","1");
INSERT INTO tbl_bitacora VALUES("266","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-19 04:14:52","2","1");
INSERT INTO tbl_bitacora VALUES("267","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-19 04:14:56","2","1");
INSERT INTO tbl_bitacora VALUES("268","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-19 04:38:55","12","1");
INSERT INTO tbl_bitacora VALUES("269","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-19 04:38:59","12","1");
INSERT INTO tbl_bitacora VALUES("270","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-19 04:39:03","12","1");
INSERT INTO tbl_bitacora VALUES("271","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-19 04:45:35","12","1");
INSERT INTO tbl_bitacora VALUES("272","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-19 04:45:38","12","1");
INSERT INTO tbl_bitacora VALUES("273","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-19 04:45:40","12","1");
INSERT INTO tbl_bitacora VALUES("274","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-19 04:51:57","12","1");
INSERT INTO tbl_bitacora VALUES("275","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-19 04:52:06","12","1");
INSERT INTO tbl_bitacora VALUES("276","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-19 04:52:10","12","1");
INSERT INTO tbl_bitacora VALUES("277","Inicio de sesion","Inicio de sesion correctamente","2021-02-18 23:45:29","12","1");
INSERT INTO tbl_bitacora VALUES("278","Inicio de sesion","Inicio de sesion correctamente","2021-02-19 00:22:01","12","1");
INSERT INTO tbl_bitacora VALUES("279","Inicio de sesion","Inicio de sesion correctamente","2021-02-19 00:26:48","12","1");
INSERT INTO tbl_bitacora VALUES("280","Inicio de sesion","Inicio de sesion correctamente","2021-02-19 16:45:13","12","1");
INSERT INTO tbl_bitacora VALUES("281","Inicio de sesion","Inicio de sesion correctamente","2021-02-19 17:24:49","12","1");
INSERT INTO tbl_bitacora VALUES("282","Inicio de sesion","Inicio de sesion correctamente","2021-02-19 17:44:29","12","1");
INSERT INTO tbl_bitacora VALUES("283","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-19 17:46:19","2","1");
INSERT INTO tbl_bitacora VALUES("284","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-19 17:46:27","2","1");
INSERT INTO tbl_bitacora VALUES("285","Inicio de sesion","Inicio de sesion correctamente","2021-02-19 17:46:44","2","1");
INSERT INTO tbl_bitacora VALUES("286","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-19 19:23:33","7","1");
INSERT INTO tbl_bitacora VALUES("287","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-19 19:26:46","7","1");
INSERT INTO tbl_bitacora VALUES("288","Inicio de sesion","Inicio de sesion correctamente","2021-02-19 19:27:01","7","1");
INSERT INTO tbl_bitacora VALUES("289","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-19 19:51:43","17","1");
INSERT INTO tbl_bitacora VALUES("290","Inicio de sesion","Inicio de sesion correctamente","2021-02-19 19:51:50","17","1");
INSERT INTO tbl_bitacora VALUES("291","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-19 20:07:02","7","1");
INSERT INTO tbl_bitacora VALUES("292","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-19 20:11:07","7","1");
INSERT INTO tbl_bitacora VALUES("293","Inicio de sesion","Inicio de sesion correctamente","2021-02-19 21:11:38","22","1");
INSERT INTO tbl_bitacora VALUES("294","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-19 21:24:55","7","1");
INSERT INTO tbl_bitacora VALUES("295","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-19 21:26:48","7","1");
INSERT INTO tbl_bitacora VALUES("296","Inicio de sesion","Inicio de sesion correctamente","2021-02-19 22:15:03","12","1");
INSERT INTO tbl_bitacora VALUES("297","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-19 22:51:09","20","1");
INSERT INTO tbl_bitacora VALUES("298","Inicio de sesion","Inicio de sesion correctamente","2021-02-19 23:27:20","12","1");
INSERT INTO tbl_bitacora VALUES("299","Inicio de sesion","Inicio de sesion correctamente","2021-02-20 17:21:40","12","1");
INSERT INTO tbl_bitacora VALUES("300","Inicio de sesion","Inicio de sesion correctamente","2021-02-20 21:27:03","12","1");
INSERT INTO tbl_bitacora VALUES("301","Inicio de sesion","Inicio de sesion correctamente","2021-02-20 23:45:03","12","1");
INSERT INTO tbl_bitacora VALUES("302","Inicio de sesion","Inicio de sesion correctamente","2021-02-20 23:45:37","12","1");
INSERT INTO tbl_bitacora VALUES("303","Inicio de sesion","Inicio de sesion correctamente","2021-02-20 23:46:09","12","1");
INSERT INTO tbl_bitacora VALUES("304","Inicio de sesion","Inicio de sesion correctamente","2021-02-20 23:47:40","12","1");
INSERT INTO tbl_bitacora VALUES("305","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-20 23:49:22","7","1");
INSERT INTO tbl_bitacora VALUES("306","Inicio de sesion","Inicio de sesion correctamente","2021-02-20 23:49:31","7","1");
INSERT INTO tbl_bitacora VALUES("307","Inicio de sesion","Inicio de sesion correctamente","2021-02-20 23:52:44","7","1");
INSERT INTO tbl_bitacora VALUES("308","Inicio de sesion","Inicio de sesion correctamente","2021-02-20 23:55:25","12","1");
INSERT INTO tbl_bitacora VALUES("309","Inicio de sesion","Inicio de sesion correctamente","2021-02-21 00:10:25","12","1");
INSERT INTO tbl_bitacora VALUES("310","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 00:12:34","2","1");
INSERT INTO tbl_bitacora VALUES("311","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 00:16:17","2","1");
INSERT INTO tbl_bitacora VALUES("312","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 00:26:21","2","1");
INSERT INTO tbl_bitacora VALUES("313","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 00:29:06","2","1");
INSERT INTO tbl_bitacora VALUES("314","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-21 00:47:52","12","1");
INSERT INTO tbl_bitacora VALUES("315","Inicio de sesion","Inicio de sesion correctamente","2021-02-21 00:47:58","12","1");
INSERT INTO tbl_bitacora VALUES("316","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-21 16:44:04","12","1");
INSERT INTO tbl_bitacora VALUES("317","Inicio de sesion","Inicio de sesion correctamente","2021-02-21 16:44:28","12","1");
INSERT INTO tbl_bitacora VALUES("318","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 16:50:48","2","1");
INSERT INTO tbl_bitacora VALUES("319","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 16:53:11","2","1");
INSERT INTO tbl_bitacora VALUES("320","Inicio de sesion","Inicio de sesion correctamente","2021-02-21 16:57:29","12","1");
INSERT INTO tbl_bitacora VALUES("321","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 17:08:28","2","1");
INSERT INTO tbl_bitacora VALUES("322","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 17:19:31","2","1");
INSERT INTO tbl_bitacora VALUES("323","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 17:22:25","2","1");
INSERT INTO tbl_bitacora VALUES("324","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 17:24:52","2","1");
INSERT INTO tbl_bitacora VALUES("325","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 17:39:33","2","1");
INSERT INTO tbl_bitacora VALUES("326","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 17:55:38","2","1");
INSERT INTO tbl_bitacora VALUES("327","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 17:58:52","2","1");
INSERT INTO tbl_bitacora VALUES("328","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:08:34","2","1");
INSERT INTO tbl_bitacora VALUES("329","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:10:17","2","1");
INSERT INTO tbl_bitacora VALUES("330","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:18:18","2","1");
INSERT INTO tbl_bitacora VALUES("331","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:19:29","2","1");
INSERT INTO tbl_bitacora VALUES("332","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:24:42","2","1");
INSERT INTO tbl_bitacora VALUES("333","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:24:42","2","1");
INSERT INTO tbl_bitacora VALUES("334","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:24:43","2","1");
INSERT INTO tbl_bitacora VALUES("335","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:24:43","2","1");
INSERT INTO tbl_bitacora VALUES("336","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:24:43","2","1");
INSERT INTO tbl_bitacora VALUES("337","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:24:44","2","1");
INSERT INTO tbl_bitacora VALUES("338","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:24:44","2","1");
INSERT INTO tbl_bitacora VALUES("339","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:24:45","2","1");
INSERT INTO tbl_bitacora VALUES("340","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:24:46","2","1");
INSERT INTO tbl_bitacora VALUES("341","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:24:46","2","1");
INSERT INTO tbl_bitacora VALUES("342","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:24:47","2","1");
INSERT INTO tbl_bitacora VALUES("343","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:26:57","2","1");
INSERT INTO tbl_bitacora VALUES("344","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:26:57","2","1");
INSERT INTO tbl_bitacora VALUES("345","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:26:58","2","1");
INSERT INTO tbl_bitacora VALUES("346","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:26:58","2","1");
INSERT INTO tbl_bitacora VALUES("347","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:26:59","2","1");
INSERT INTO tbl_bitacora VALUES("348","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:26:59","2","1");
INSERT INTO tbl_bitacora VALUES("349","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:27:00","2","1");
INSERT INTO tbl_bitacora VALUES("350","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:27:00","2","1");
INSERT INTO tbl_bitacora VALUES("351","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:27:00","2","1");
INSERT INTO tbl_bitacora VALUES("352","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:27:01","2","1");
INSERT INTO tbl_bitacora VALUES("353","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:27:02","2","1");
INSERT INTO tbl_bitacora VALUES("354","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:30:26","2","1");
INSERT INTO tbl_bitacora VALUES("355","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:31:42","2","1");
INSERT INTO tbl_bitacora VALUES("356","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:34:20","2","1");
INSERT INTO tbl_bitacora VALUES("357","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:34:20","2","1");
INSERT INTO tbl_bitacora VALUES("358","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:34:20","2","1");
INSERT INTO tbl_bitacora VALUES("359","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:34:21","2","1");
INSERT INTO tbl_bitacora VALUES("360","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:34:21","2","1");
INSERT INTO tbl_bitacora VALUES("361","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:34:22","2","1");
INSERT INTO tbl_bitacora VALUES("362","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:34:22","2","1");
INSERT INTO tbl_bitacora VALUES("363","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:34:23","2","1");
INSERT INTO tbl_bitacora VALUES("364","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:34:23","2","1");
INSERT INTO tbl_bitacora VALUES("365","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:34:24","2","1");
INSERT INTO tbl_bitacora VALUES("366","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:34:25","2","1");
INSERT INTO tbl_bitacora VALUES("367","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:34:27","2","1");
INSERT INTO tbl_bitacora VALUES("368","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:36:49","2","1");
INSERT INTO tbl_bitacora VALUES("369","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:36:49","2","1");
INSERT INTO tbl_bitacora VALUES("370","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:36:50","2","1");
INSERT INTO tbl_bitacora VALUES("371","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:36:50","2","1");
INSERT INTO tbl_bitacora VALUES("372","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:36:51","2","1");
INSERT INTO tbl_bitacora VALUES("373","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:36:51","2","1");
INSERT INTO tbl_bitacora VALUES("374","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:36:52","2","1");
INSERT INTO tbl_bitacora VALUES("375","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:36:52","2","1");
INSERT INTO tbl_bitacora VALUES("376","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:36:52","2","1");
INSERT INTO tbl_bitacora VALUES("377","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:36:53","2","1");
INSERT INTO tbl_bitacora VALUES("378","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:36:54","2","1");
INSERT INTO tbl_bitacora VALUES("379","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:36:57","2","1");
INSERT INTO tbl_bitacora VALUES("380","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:40:01","2","1");
INSERT INTO tbl_bitacora VALUES("381","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:42:29","2","1");
INSERT INTO tbl_bitacora VALUES("382","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 18:45:49","2","1");
INSERT INTO tbl_bitacora VALUES("383","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 20:03:26","2","1");
INSERT INTO tbl_bitacora VALUES("384","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 20:06:43","2","1");
INSERT INTO tbl_bitacora VALUES("385","Inicio de sesion","Inicio de sesion correctamente","2021-02-21 20:57:03","12","1");
INSERT INTO tbl_bitacora VALUES("386","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-21 21:21:41","12","1");
INSERT INTO tbl_bitacora VALUES("387","Inicio de sesion","Inicio de sesion correctamente","2021-02-22 12:00:58","12","1");
INSERT INTO tbl_bitacora VALUES("388","Inicio de sesion","Inicio de sesion correctamente","2021-02-22 16:37:03","12","1");
INSERT INTO tbl_bitacora VALUES("389","Inicio de sesion","Inicio de sesion correctamente","2021-02-22 20:29:51","12","1");
INSERT INTO tbl_bitacora VALUES("390","Inicio de sesion","Inicio de sesion correctamente","2021-02-22 20:34:28","12","1");
INSERT INTO tbl_bitacora VALUES("391","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-22 21:02:10","2","1");
INSERT INTO tbl_bitacora VALUES("392","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-22 21:02:46","2","1");
INSERT INTO tbl_bitacora VALUES("393","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-22 21:02:57","2","1");
INSERT INTO tbl_bitacora VALUES("394","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-22 21:03:18","7","1");
INSERT INTO tbl_bitacora VALUES("395","Inicio de sesion","Inicio de sesion correctamente","2021-02-22 21:03:25","7","1");
INSERT INTO tbl_bitacora VALUES("396","Inicio de sesion","Inicio de sesion correctamente","2021-02-22 21:39:15","7","1");
INSERT INTO tbl_bitacora VALUES("397","Inicio de sesion","Inicio de sesion correctamente","2021-02-22 21:41:41","7","1");
INSERT INTO tbl_bitacora VALUES("398","Inicio de sesion","Inicio de sesion correctamente","2021-02-22 22:15:02","7","1");
INSERT INTO tbl_bitacora VALUES("399","Inicio de sesion","Inicio de sesion correctamente","2021-02-22 22:19:53","12","1");
INSERT INTO tbl_bitacora VALUES("400","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-22 23:03:14","12","1");
INSERT INTO tbl_bitacora VALUES("401","usuario bloqueado","Usuario bloqueado, realizó los 3 intentos permitidos para acceder al sistema","2021-02-22 23:03:23","12","1");
INSERT INTO tbl_bitacora VALUES("402","Inicio de sesion","Inicio de sesion correctamente","2021-02-22 23:03:59","12","1");
INSERT INTO tbl_bitacora VALUES("403","usuario bloqueado","Usuario bloqueado, realizó los 3 intentos permitidos para acceder al sistema","2021-02-22 23:12:24","7","1");
INSERT INTO tbl_bitacora VALUES("404","Inicio de sesion","Inicio de sesion correctamente","2021-02-22 23:12:59","7","1");
INSERT INTO tbl_bitacora VALUES("405","Inicio de sesion","Inicio de sesion correctamente","2021-02-22 23:14:41","12","1");
INSERT INTO tbl_bitacora VALUES("406","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-22 23:23:18","12","1");
INSERT INTO tbl_bitacora VALUES("407","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-22 23:24:57","12","1");
INSERT INTO tbl_bitacora VALUES("408","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-22 23:37:44","12","1");
INSERT INTO tbl_bitacora VALUES("409","Cambio de contraseña","Cambio de contraseña, por motivos de olvido o bloqueo","2021-02-22 23:48:53","12","1");
INSERT INTO tbl_bitacora VALUES("410","Inicio de sesion","Inicio de sesion correctamente","2021-02-22 23:54:52","7","1");
INSERT INTO tbl_bitacora VALUES("411","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-23 01:11:47","7","1");
INSERT INTO tbl_bitacora VALUES("412","Inicio de sesion","Inicio de sesion correctamente","2021-02-23 01:11:58","7","1");
INSERT INTO tbl_bitacora VALUES("413","Inicio de sesion","Inicio de sesion correctamente","2021-02-23 01:34:51","7","1");
INSERT INTO tbl_bitacora VALUES("414","Inicio de sesion","Inicio de sesion correctamente","2021-02-23 10:42:58","12","1");
INSERT INTO tbl_bitacora VALUES("415","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-23 11:20:56","7","1");
INSERT INTO tbl_bitacora VALUES("416","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-23 11:21:04","7","1");
INSERT INTO tbl_bitacora VALUES("417","Inicio de sesion","Inicio de sesion correctamente","2021-02-23 11:21:13","7","1");
INSERT INTO tbl_bitacora VALUES("418","Inicio de sesion","Inicio de sesion correctamente","2021-02-23 15:20:06","20","1");
INSERT INTO tbl_bitacora VALUES("419","usuario bloqueado","Usuario bloqueado, realizó los 3 intentos permitidos para acceder al sistema","2021-02-23 15:24:41","7","1");
INSERT INTO tbl_bitacora VALUES("420","usuario bloqueado","ERROR: intento de inicio de sesión con usuario bloqueado","2021-02-23 15:25:46","7","1");
INSERT INTO tbl_bitacora VALUES("421","Inicio de sesion","Inicio de sesion correctamente","2021-02-23 15:26:40","7","1");
INSERT INTO tbl_bitacora VALUES("422","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-23 15:27:30","2","1");
INSERT INTO tbl_bitacora VALUES("423","usuario bloqueado","Usuario bloqueado, realizó los 3 intentos permitidos para acceder al sistema","2021-02-23 15:27:36","2","1");
INSERT INTO tbl_bitacora VALUES("424","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-23 15:28:07","2","1");
INSERT INTO tbl_bitacora VALUES("425","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-23 15:28:17","2","1");
INSERT INTO tbl_bitacora VALUES("426","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-23 15:28:28","2","1");
INSERT INTO tbl_bitacora VALUES("427","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-23 15:29:33","12","1");
INSERT INTO tbl_bitacora VALUES("428","Inicio de sesion","Inicio de sesion correctamente","2021-02-23 15:29:41","12","1");
INSERT INTO tbl_bitacora VALUES("429","usuario bloqueado","ERROR: intento de inicio de sesión con usuario bloqueado","2021-02-23 15:34:30","7","1");
INSERT INTO tbl_bitacora VALUES("430","usuario bloqueado","ERROR: intento de inicio de sesión con usuario bloqueado","2021-02-23 15:34:36","7","1");
INSERT INTO tbl_bitacora VALUES("431","usuario bloqueado","ERROR: intento de inicio de sesión con usuario bloqueado","2021-02-23 15:34:46","7","1");
INSERT INTO tbl_bitacora VALUES("432","usuario bloqueado","ERROR: intento de inicio de sesión con usuario bloqueado","2021-02-23 15:34:54","7","1");
INSERT INTO tbl_bitacora VALUES("433","usuario bloqueado","ERROR: intento de inicio de sesión con usuario bloqueado","2021-02-23 15:35:27","7","1");
INSERT INTO tbl_bitacora VALUES("434","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-23 15:35:51","7","1");
INSERT INTO tbl_bitacora VALUES("435","Inicio de sesion","Inicio de sesion correctamente","2021-02-23 15:35:57","7","1");
INSERT INTO tbl_bitacora VALUES("436","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-23 15:39:09","7","1");
INSERT INTO tbl_bitacora VALUES("437","Inicio de sesion","Inicio de sesion correctamente","2021-02-23 15:39:17","7","1");
INSERT INTO tbl_bitacora VALUES("438","Inicio de sesion","Inicio de sesion correctamente","2021-02-23 15:43:47","7","1");
INSERT INTO tbl_bitacora VALUES("439","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-23 15:50:58","12","1");
INSERT INTO tbl_bitacora VALUES("440","Inicio de sesion","Inicio de sesion correctamente","2021-02-23 15:51:04","12","1");
INSERT INTO tbl_bitacora VALUES("441","Inicio de sesion","Inicio de sesion correctamente","2021-02-23 16:05:51","7","1");
INSERT INTO tbl_bitacora VALUES("442","Error de sesion","ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos","2021-02-23 18:34:29","12","1");
INSERT INTO tbl_bitacora VALUES("443","Inicio de sesion","Inicio de sesion correctamente","2021-02-23 18:34:38","12","1");
INSERT INTO tbl_bitacora VALUES("444","Inicio de sesion","Inicio de sesion correctamente","2021-03-03 22:42:37","12","1");



CREATE TABLE `tbl_boletos` (
  `id_boletos_vendidos` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cantidad_total_boletos` int(3) NOT NULL,
  `total_cobrado` int(4) NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_boletos_vendidos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `tbl_boletos_detalle` (
  `id_boletos_detalle` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cantidad_boletos` int(3) NOT NULL,
  `sub_total` int(4) NOT NULL,
  `tipo_nacionalidad_id` int(10) unsigned NOT NULL,
  `usuario_id` int(10) unsigned NOT NULL,
  `tipo_boleto_id` int(10) unsigned NOT NULL,
  `boletos_vendidos_id` int(10) unsigned NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_boletos_detalle`),
  KEY `fk_bDetalle_nacionalidad` (`tipo_nacionalidad_id`),
  KEY `fk_bDetalle_usuarios` (`usuario_id`),
  KEY `fk_bDetalle_tipoBoleto` (`tipo_boleto_id`),
  KEY `fk_bDetalle_boletos` (`boletos_vendidos_id`),
  CONSTRAINT `fk_bDetalle_boletos` FOREIGN KEY (`boletos_vendidos_id`) REFERENCES `tbl_boletos` (`id_boletos_vendidos`),
  CONSTRAINT `fk_bDetalle_nacionalidad` FOREIGN KEY (`tipo_nacionalidad_id`) REFERENCES `tbl_tipo_nacionalidad` (`id_tipo_nacionalidad`),
  CONSTRAINT `fk_bDetalle_tipoBoleto` FOREIGN KEY (`tipo_boleto_id`) REFERENCES `tbl_tipo_boletos` (`id_tipo_boleto`),
  CONSTRAINT `fk_bDetalle_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `tbl_usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `tbl_clientes` (
  `id_cliente` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(50) NOT NULL,
  `identidad` varchar(13) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `tipo_nacionalidad` int(10) unsigned NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_cliente`),
  KEY `fk_cliente_nacionalidad` (`tipo_nacionalidad`),
  CONSTRAINT `fk_cliente_nacionalidad` FOREIGN KEY (`tipo_nacionalidad`) REFERENCES `tbl_tipo_nacionalidad` (`id_tipo_nacionalidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `tbl_detalle_orden` (
  `id_detalle_orden` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cantidad` int(3) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `producto_id` int(10) unsigned NOT NULL,
  `ordenes_id` int(10) unsigned NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_detalle_orden`),
  KEY `fk_dOrden_producto` (`producto_id`),
  KEY `fk_dOrden_ordenes` (`ordenes_id`),
  CONSTRAINT `fk_dOrden_ordenes` FOREIGN KEY (`ordenes_id`) REFERENCES `tbl_ordenes` (`id_orden`),
  CONSTRAINT `fk_dOrden_producto` FOREIGN KEY (`producto_id`) REFERENCES `tbl_producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `tbl_detalle_reservacion` (
  `id_detalle_reservacion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reservacion_id` int(10) unsigned NOT NULL,
  `habitacion_id` int(10) unsigned NOT NULL,
  `cantidad_persona` int(1) unsigned NOT NULL,
  `cantidad_ninos` int(3) NOT NULL,
  `inventario_id` int(10) unsigned DEFAULT NULL,
  `cantidad_articulo` int(2) unsigned DEFAULT NULL,
  `precio_articulo` int(3) unsigned DEFAULT NULL,
  `total_pago` int(4) unsigned NOT NULL,
  `estado_eliminar` int(1) NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_detalle_reservacion`),
  KEY `fk_dReservacion_reservacion` (`reservacion_id`),
  KEY `fk_dReservacion_habitacion` (`habitacion_id`),
  KEY `fk_dReservacion_inventario` (`inventario_id`),
  CONSTRAINT `fk_dReservacion_habitacion` FOREIGN KEY (`habitacion_id`) REFERENCES `tbl_habitacion_servicio` (`id_habitacion_servicio`),
  CONSTRAINT `fk_dReservacion_inventario` FOREIGN KEY (`inventario_id`) REFERENCES `tbl_inventario` (`id_inventario`),
  CONSTRAINT `fk_dReservacion_reservacion` FOREIGN KEY (`reservacion_id`) REFERENCES `tbl_reservaciones` (`id_reservacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `tbl_estado` (
  `id_estado` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_estado` varchar(15) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `estado_eliminado` int(1) NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO tbl_estado VALUES("2","ACTIVO","Disponible de la cuenta","1","root@localhost","2021-01-20 20:50:34","root@localhost","2021-01-20 20:50:34");
INSERT INTO tbl_estado VALUES("3","BLOQUEADO","La cuenta no se encuentra disponible","1","root@localhost","2021-01-20 20:51:50","root@localhost","2021-01-20 20:51:50");
INSERT INTO tbl_estado VALUES("4","NUEVO","La cuenta se ha creado recientemente","1","root@localhost","2021-01-27 20:44:58","root@localhost","2021-01-27 20:44:58");



CREATE TABLE `tbl_estatus_solicitud` (
  `id_estatus_solicitud` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `estatus` varchar(15) NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_estatus_solicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `tbl_habitacion_servicio` (
  `id_habitacion_servicio` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) DEFAULT NULL,
  `habitacion_area` varchar(15) NOT NULL,
  `estado_id` int(10) unsigned NOT NULL,
  `precio_habitacion_servicio` int(3) NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_habitacion_servicio`),
  KEY `fk_hServicio_estado` (`estado_id`),
  CONSTRAINT `fk_hServicio_estado` FOREIGN KEY (`estado_id`) REFERENCES `tbl_estado` (`id_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `tbl_hist_contrasena` (
  `id_hist_contrasena` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` int(10) unsigned NOT NULL,
  `contrasena` varchar(60) NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_hist_contrasena`),
  KEY `fk_hContrasena_usuario` (`usuario_id`),
  CONSTRAINT `fk_hContrasena_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `tbl_usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8;

INSERT INTO tbl_hist_contrasena VALUES("86","12","$2y$10$8YOtVonJE9mVnBYDXmUXC.DZcVj481PtiW6ffJ20BoFjRMW92Wy4y","RODRIGUEZ","2021-02-21 20:53:48","RODRIGUEZ","2021-02-21 20:53:48");
INSERT INTO tbl_hist_contrasena VALUES("87","12","$2y$10$ZZKSPJZdDbCPRyVM6kg7g.IFg3gZHxfPsaW6em0nYS8TP0FfE7AC6","RODRIGUEZ","2021-02-21 21:21:41","RODRIGUEZ","2021-02-21 21:21:41");
INSERT INTO tbl_hist_contrasena VALUES("88","12","$2y$10$vfOLWORq0yB1.OeDIvZ3bOmqQztfKsSQ8OGgRRTMIqFJeGPqVhTE.","RODRIGUEZ","2021-02-22 23:23:18","RODRIGUEZ","2021-02-22 23:23:18");
INSERT INTO tbl_hist_contrasena VALUES("89","12","$2y$10$XHVZ9GNqgkmpZLcwxhOuzOD8RFIwHS7uLI6c3qAzurKu0O53sJs2y","RODRIGUEZ","2021-02-22 23:24:57","RODRIGUEZ","2021-02-22 23:24:57");
INSERT INTO tbl_hist_contrasena VALUES("90","12","$2y$10$C0qpo7GpP495/zSDBp408.vPAx2gh/fz2UwNHrq9DXTxaxmAZHphy","RODRIGUEZ","2021-02-22 23:37:44","RODRIGUEZ","2021-02-22 23:37:44");
INSERT INTO tbl_hist_contrasena VALUES("91","12","$2y$10$J5mV.BDilCOAD9uPO.XyzOa9W6M8rvKgI2I35/6bcRAei1ITVHhsS","RODRIGUEZ","2021-02-22 23:48:53","RODRIGUEZ","2021-02-22 23:48:53");



CREATE TABLE `tbl_inventario` (
  `id_inventario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_articulo` varchar(30) NOT NULL,
  `existencias` int(4) NOT NULL,
  `costo` double(5,2) NOT NULL,
  `fecha_entrada` datetime NOT NULL,
  `fecha_salida` datetime DEFAULT NULL,
  `estado_eliminar` int(1) DEFAULT NULL,
  `producto_id` int(10) unsigned NOT NULL,
  `orden_id` int(10) unsigned NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_inventario`),
  KEY `fk_inventario_producto` (`producto_id`),
  KEY `fk_inventario_ordenes` (`orden_id`),
  CONSTRAINT `fk_inventario_ordenes` FOREIGN KEY (`orden_id`) REFERENCES `tbl_ordenes` (`id_orden`),
  CONSTRAINT `fk_inventario_producto` FOREIGN KEY (`producto_id`) REFERENCES `tbl_producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `tbl_localidad` (
  `id_localidad` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_localidad` varchar(30) NOT NULL,
  `estado_eliminado` int(1) NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_localidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `tbl_objeto` (
  `id_objeto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `objeto` varchar(50) NOT NULL,
  `tipo_objeto` varchar(50) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `estado_eliminado` int(1) NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_objeto`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

INSERT INTO tbl_objeto VALUES("1","LOGIN","Seguridad","Permite el acceso al sistema mediante las credenciales","1","root@localhost","2021-01-21 01:08:53","root@localhost","2021-01-21 01:08:53");
INSERT INTO tbl_objeto VALUES("2","REPORTE BITACORA","mantenimiento","Permite visualizar registros historicos","1","root@localhost","2021-01-27 22:58:23","root@localhost","2021-01-27 22:58:23");
INSERT INTO tbl_objeto VALUES("3","REPORTE PRODUCTO","mantenimiento","Permite visualizar registros historicos","1","root@localhost","2021-01-27 22:59:00","root@localhost","2021-01-27 22:59:00");
INSERT INTO tbl_objeto VALUES("4","PERFIL","mantenimiento","Permite visualizar información del usuario","1","root@localhost","2021-01-27 22:59:35","root@localhost","2021-01-27 22:59:35");
INSERT INTO tbl_objeto VALUES("5","MENU","información","Permite visualizar información","1","root@localhost","2021-01-27 23:01:19","root@localhost","2021-01-27 23:01:19");
INSERT INTO tbl_objeto VALUES("6","INICIO","ninguno","sin especificar","1","root@localhost","2021-01-30 23:52:08","root@localhost","2021-01-30 23:52:08");



CREATE TABLE `tbl_ordenes` (
  `id_orden` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `localidad_id` int(10) unsigned NOT NULL,
  `estado_id` int(10) unsigned NOT NULL,
  `usuario_id` int(10) unsigned NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_orden`),
  KEY `fk_ordenes_localidad` (`localidad_id`),
  KEY `fk_ordenes_estado` (`estado_id`),
  KEY `fk_ordenes_usuario` (`usuario_id`),
  CONSTRAINT `fk_ordenes_estado` FOREIGN KEY (`estado_id`) REFERENCES `tbl_estado` (`id_estado`),
  CONSTRAINT `fk_ordenes_localidad` FOREIGN KEY (`localidad_id`) REFERENCES `tbl_localidad` (`id_localidad`),
  CONSTRAINT `fk_ordenes_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `tbl_usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `tbl_parametros` (
  `id_parametro` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parametro` varchar(50) NOT NULL,
  `valor` varchar(100) NOT NULL,
  `estado_eliminado` int(1) NOT NULL,
  `usuario_id` int(10) unsigned NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_parametro`),
  KEY `fk_parametros_usuarios` (`usuario_id`),
  CONSTRAINT `fk_parametros_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `tbl_usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

INSERT INTO tbl_parametros VALUES("1","INTENTOS_SESION","3","1","2","root@localhost","2021-02-14 19:43:21","root@localhost","2021-02-14 19:43:21");
INSERT INTO tbl_parametros VALUES("2","NOMBRE_DATABASE","bd_fundacion_amitigra","1","2","root@localhost","2021-02-14 19:47:01","root@localhost","2021-02-14 19:47:01");
INSERT INTO tbl_parametros VALUES("3","PUERTO_DATABASE","3306","1","2","root@localhost","2021-02-14 19:47:28","root@localhost","2021-02-14 19:47:28");
INSERT INTO tbl_parametros VALUES("4","NOMBRE_SISTEMA","SAAT-Sistema Administrativo AmiTigra","1","2","root@localhost","2021-02-14 19:59:33","root@localhost","2021-02-14 19:59:33");
INSERT INTO tbl_parametros VALUES("5","PUERTO_CORREO","587","1","2","root@localhost","2021-02-14 22:08:31","root@localhost","2021-02-14 22:08:31");
INSERT INTO tbl_parametros VALUES("6","CORREO_SISTEMA","soporte.fundacionamitigra@gmail.com","1","2","root@localhost","2021-02-14 22:24:41","root@localhost","2021-02-14 22:24:41");
INSERT INTO tbl_parametros VALUES("7","NOMBRE_ORGANIZACION","FUNDACION AMITIGRA","1","2","root@localhost","2021-02-14 22:53:25","root@localhost","2021-02-14 22:53:25");
INSERT INTO tbl_parametros VALUES("8","FOTO_ORGANIZACION","","1","2","root@localhost","2021-02-22 20:01:04","root@localhost","2021-02-22 20:01:04");
INSERT INTO tbl_parametros VALUES("9","USUARIO_ADMIN","","1","2","root@localhost","2021-02-22 20:02:01","root@localhost","2021-02-22 20:02:01");
INSERT INTO tbl_parametros VALUES("10","MENSAJE_CORREO","","1","2","root@localhost","2021-02-22 20:02:40","root@localhost","2021-02-22 20:02:40");
INSERT INTO tbl_parametros VALUES("11","USUARIO_CONTRASENA","","1","2","root@localhost","2021-02-22 20:03:18","root@localhost","2021-02-22 20:03:18");
INSERT INTO tbl_parametros VALUES("13","HOST_HOSPEDADOR","localhost","1","2","root@localhost","2021-02-22 20:08:53","root@localhost","2021-02-22 20:08:53");



CREATE TABLE `tbl_permisos` (
  `id_permiso` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permiso_insercion` int(1) NOT NULL,
  `permiso_eliminacion` int(1) NOT NULL,
  `permiso_actualizacion` int(1) NOT NULL,
  `permiso_consulta` int(1) NOT NULL,
  `estado_eliminado` int(1) NOT NULL,
  `rol_id` int(10) unsigned NOT NULL,
  `objeto_id` int(10) unsigned NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_permiso`),
  KEY `fk_permisos_rol` (`rol_id`),
  KEY `fk_permisos_objeto` (`objeto_id`),
  CONSTRAINT `fk_permisos_objeto` FOREIGN KEY (`objeto_id`) REFERENCES `tbl_objeto` (`id_objeto`),
  CONSTRAINT `fk_permisos_rol` FOREIGN KEY (`rol_id`) REFERENCES `tbl_roles` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

INSERT INTO tbl_permisos VALUES("1","1","1","1","1","1","2","4","root@localhost","2021-01-21 22:56:04","root@localhost","2021-01-21 22:56:04");
INSERT INTO tbl_permisos VALUES("2","1","1","1","1","1","2","6","root@localhost","2021-01-31 00:18:51","root@localhost","2021-01-31 00:18:51");
INSERT INTO tbl_permisos VALUES("3","0","0","0","1","1","3","5","root@localhost","2021-01-31 00:20:09","root@localhost","2021-01-31 00:20:09");
INSERT INTO tbl_permisos VALUES("4","1","1","1","1","1","2","5","root@localhost","2021-02-09 18:22:49","root@localhost","2021-02-09 18:22:49");
INSERT INTO tbl_permisos VALUES("5","0","0","1","1","1","3","4","root@localhost","2021-02-10 00:11:35","root@localhost","2021-02-10 00:11:35");
INSERT INTO tbl_permisos VALUES("6","1","1","1","1","1","3","6","root@localhost","2021-02-10 09:20:04","root@localhost","2021-02-10 09:20:04");
INSERT INTO tbl_permisos VALUES("7","1","1","1","1","1","4","4","root@localhost","2021-02-22 20:41:29","root@localhost","2021-02-22 20:41:29");
INSERT INTO tbl_permisos VALUES("8","1","1","1","1","1","4","6","root@localhost","2021-02-22 20:42:10","root@localhost","2021-02-22 20:42:10");
INSERT INTO tbl_permisos VALUES("9","1","1","1","1","1","4","5","root@localhost","2021-02-22 20:42:29","root@localhost","2021-02-22 20:42:29");



CREATE TABLE `tbl_preguntas` (
  `id_pregunta` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pregunta` varchar(100) NOT NULL,
  `estado_eliminado` int(1) DEFAULT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_pregunta`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

INSERT INTO tbl_preguntas VALUES("1","¿Cuál es el primer nombre de tu mamá?","1","root@localhost","2021-01-20 20:54:22","root@localhost","2021-01-20 20:54:22");
INSERT INTO tbl_preguntas VALUES("2","¿Cuál es el primer nombre de tu papá?","1","root@localhost","2021-01-20 20:54:54","root@localhost","2021-01-20 20:54:54");
INSERT INTO tbl_preguntas VALUES("3","¿Cuál es el nombre de tu mascota?","1","root@localhost","2021-01-20 20:55:07","root@localhost","2021-01-20 20:55:07");
INSERT INTO tbl_preguntas VALUES("4","¿Cuál es el nombre de tu equipo favorito?","1","root@localhost","2021-01-20 20:55:24","root@localhost","2021-01-20 20:55:24");
INSERT INTO tbl_preguntas VALUES("5","¿Cuál es el nombre de tu mejor amigo?","1","root@localhost","2021-02-19 21:46:37","root@localhost","2021-02-19 21:46:37");
INSERT INTO tbl_preguntas VALUES("6","¿Cual es tu apodo/sobrenombre?","1","root@localhost","2021-02-19 21:47:29","root@localhost","2021-02-19 21:47:29");
INSERT INTO tbl_preguntas VALUES("7","¿Cuál es tu color favorito?","1","root@localhost","2021-02-19 21:47:47","root@localhost","2021-02-19 21:47:47");
INSERT INTO tbl_preguntas VALUES("8","¿Cómo se llama la escuela a la que fuiste?","1","root@localhost","2021-02-19 21:48:07","root@localhost","2021-02-19 21:48:07");
INSERT INTO tbl_preguntas VALUES("9","¿Cuántos hermanos tienes?","1","root@localhost","2021-02-19 21:48:29","root@localhost","2021-02-19 21:48:29");
INSERT INTO tbl_preguntas VALUES("10","¿Cuál es el nombre de tu cantante favorito?","1","root@localhost","2021-02-19 21:48:46","root@localhost","2021-02-19 21:48:46");



CREATE TABLE `tbl_preguntas_usuario` (
  `pregunta_id` int(10) unsigned NOT NULL,
  `usuario_id` int(10) unsigned NOT NULL,
  `respuesta` varchar(30) NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  KEY `fk_pUsuario_preguntas` (`pregunta_id`),
  KEY `fk_pUsuario_usuario` (`usuario_id`),
  CONSTRAINT `fk_pUsuario_preguntas` FOREIGN KEY (`pregunta_id`) REFERENCES `tbl_preguntas` (`id_pregunta`),
  CONSTRAINT `fk_pUsuario_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `tbl_usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO tbl_preguntas_usuario VALUES("1","13","INGRID","FERNANDOA","2021-01-29 21:38:36","FERNANDOA","2021-01-29 21:38:36");
INSERT INTO tbl_preguntas_usuario VALUES("1","14","INGRID","PRUEBA","2021-01-31 15:01:32","PRUEBA","2021-01-31 15:01:32");
INSERT INTO tbl_preguntas_usuario VALUES("1","15","INGRID","USERPRUEBA","2021-01-31 21:27:25","USERPRUEBA","2021-01-31 21:27:25");
INSERT INTO tbl_preguntas_usuario VALUES("3","15","RAMBO","USERPRUEBA","2021-01-31 21:27:25","USERPRUEBA","2021-01-31 21:27:25");
INSERT INTO tbl_preguntas_usuario VALUES("4","15","REALMADRID","USERPRUEBA","2021-01-31 21:27:25","USERPRUEBA","2021-01-31 21:27:25");
INSERT INTO tbl_preguntas_usuario VALUES("1","16","MARIA","PEDRO","2021-01-31 21:39:27","PEDRO","2021-01-31 21:39:27");
INSERT INTO tbl_preguntas_usuario VALUES("2","16","JUAN","PEDRO","2021-01-31 21:39:27","PEDRO","2021-01-31 21:39:27");
INSERT INTO tbl_preguntas_usuario VALUES("4","16","REALMADRID","PEDRO","2021-01-31 21:39:27","PEDRO","2021-01-31 21:39:27");
INSERT INTO tbl_preguntas_usuario VALUES("1","17","INGRID","ANGEL","2021-02-11 11:57:46","ANGEL","2021-02-11 11:57:46");
INSERT INTO tbl_preguntas_usuario VALUES("3","17","LOKY","ANGEL","2021-02-11 11:57:46","ANGEL","2021-02-11 11:57:46");
INSERT INTO tbl_preguntas_usuario VALUES("4","17","REALMADRID","ANGEL","2021-02-11 11:57:46","ANGEL","2021-02-11 11:57:46");
INSERT INTO tbl_preguntas_usuario VALUES("1","18","MARIA","MARTINEZ","2021-02-11 18:26:14","MARTINEZ","2021-02-11 18:26:14");
INSERT INTO tbl_preguntas_usuario VALUES("2","18","CARLOS","MARTINEZ","2021-02-11 18:26:14","MARTINEZ","2021-02-11 18:26:14");
INSERT INTO tbl_preguntas_usuario VALUES("3","18","LOKY","MARTINEZ","2021-02-11 18:26:14","MARTINEZ","2021-02-11 18:26:14");
INSERT INTO tbl_preguntas_usuario VALUES("1","19","PRUEBA","SUJELY","2021-02-19 19:41:34","SUJELY","2021-02-19 19:41:34");
INSERT INTO tbl_preguntas_usuario VALUES("2","19","PRUEBA","SUJELY","2021-02-19 19:41:34","SUJELY","2021-02-19 19:41:34");
INSERT INTO tbl_preguntas_usuario VALUES("3","19","PRUEBA","SUJELY","2021-02-19 19:41:34","SUJELY","2021-02-19 19:41:34");
INSERT INTO tbl_preguntas_usuario VALUES("1","20","PRUEBA","ADMIN","2021-02-19 21:25:03","ADMIN","2021-02-19 21:25:03");
INSERT INTO tbl_preguntas_usuario VALUES("2","20","PRUEBA","ADMIN","2021-02-19 21:25:03","ADMIN","2021-02-19 21:25:03");
INSERT INTO tbl_preguntas_usuario VALUES("3","20","PRUEBA","ADMIN","2021-02-19 21:25:03","ADMIN","2021-02-19 21:25:03");
INSERT INTO tbl_preguntas_usuario VALUES("1","21","PRUEBA","ADMINS","2021-02-19 21:16:08","ADMINS","2021-02-19 21:16:08");
INSERT INTO tbl_preguntas_usuario VALUES("2","21","PRUEBA","ADMINS","2021-02-19 21:16:08","ADMINS","2021-02-19 21:16:08");
INSERT INTO tbl_preguntas_usuario VALUES("3","21","PRUEBA","ADMINS","2021-02-19 21:16:08","ADMINS","2021-02-19 21:16:08");
INSERT INTO tbl_preguntas_usuario VALUES("1","22","PRUEBA","ADMINR","2021-02-19 21:06:10","ADMINR","2021-02-19 21:06:10");
INSERT INTO tbl_preguntas_usuario VALUES("2","22","PRUEBA","ADMINR","2021-02-19 21:06:10","ADMINR","2021-02-19 21:06:10");
INSERT INTO tbl_preguntas_usuario VALUES("3","22","PRUEBA","ADMINR","2021-02-19 21:06:10","ADMINR","2021-02-19 21:06:10");
INSERT INTO tbl_preguntas_usuario VALUES("1","23","PRUEBA","ADMINSP","2021-02-19 21:48:33","ADMINSP","2021-02-19 21:48:33");
INSERT INTO tbl_preguntas_usuario VALUES("2","23","PRUEBA","ADMINSP","2021-02-19 21:48:33","ADMINSP","2021-02-19 21:48:33");
INSERT INTO tbl_preguntas_usuario VALUES("3","23","PRUEBA","ADMINSP","2021-02-19 21:48:33","ADMINSP","2021-02-19 21:48:33");
INSERT INTO tbl_preguntas_usuario VALUES("7","25","AZUL","ROSALES","2021-02-23 18:39:31","ROSALES","2021-02-23 18:39:31");
INSERT INTO tbl_preguntas_usuario VALUES("1","25","MARIA","ROSALES","2021-02-23 18:39:31","ROSALES","2021-02-23 18:39:31");
INSERT INTO tbl_preguntas_usuario VALUES("3","25","LOKY","ROSALES","2021-02-23 18:39:31","ROSALES","2021-02-23 18:39:31");



CREATE TABLE `tbl_producto` (
  `id_producto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_producto` varchar(30) NOT NULL,
  `cantidad_producto` int(4) unsigned NOT NULL,
  `tipo_producto_id` int(10) unsigned NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `fk_producto_tProducto` (`tipo_producto_id`),
  CONSTRAINT `fk_producto_tProducto` FOREIGN KEY (`tipo_producto_id`) REFERENCES `tbl_tipo_producto` (`id_tipo_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `tbl_reservaciones` (
  `id_reservacion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fecha_reservacion` datetime NOT NULL,
  `fecha_entrada` datetime NOT NULL,
  `fecha_salida` datetime NOT NULL,
  `cliente_id` int(10) unsigned NOT NULL,
  `usuario_id` int(10) unsigned NOT NULL,
  `localidad_id` int(10) unsigned NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_reservacion`),
  KEY `fk_reservaciones_clientes` (`cliente_id`),
  KEY `fk_reservaciones_usuario` (`usuario_id`),
  KEY `fk_reservaciones_localidad` (`localidad_id`),
  CONSTRAINT `fk_reservaciones_clientes` FOREIGN KEY (`cliente_id`) REFERENCES `tbl_clientes` (`id_cliente`),
  CONSTRAINT `fk_reservaciones_localidad` FOREIGN KEY (`localidad_id`) REFERENCES `tbl_localidad` (`id_localidad`),
  CONSTRAINT `fk_reservaciones_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `tbl_usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `tbl_roles` (
  `id_rol` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rol` varchar(20) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `estado_eliminado` int(1) NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO tbl_roles VALUES("2","administrador","Tiene el control/acceso total del sistema","1","root@localhost","2021-01-20 20:57:43","root@localhost","2021-01-20 20:57:43");
INSERT INTO tbl_roles VALUES("3","asistente","Tiene acceso/permiso a ciertos modulos del sistema","1","root@localhost","2021-01-20 20:58:26","root@localhost","2021-01-20 20:58:26");
INSERT INTO tbl_roles VALUES("4","usuario","Tiene acceso limitado al sistema","1","root@localhost","2021-01-31 10:32:13","root@localhost","2021-01-31 10:32:13");
INSERT INTO tbl_roles VALUES("5","visitante","Rol default para visitantes","1","admin","2021-02-24 01:54:29","admin","2021-02-24 01:54:29");



CREATE TABLE `tbl_solicitudes` (
  `id_solicitud` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fecha_solicitud` datetime NOT NULL,
  `coordenadas` varchar(30) NOT NULL,
  `croquis` blob NOT NULL,
  `recibo` int(30) NOT NULL,
  `cliente_id` int(10) unsigned NOT NULL,
  `usuario_id` int(10) unsigned NOT NULL,
  `estatus_solicitud` int(10) unsigned NOT NULL,
  `tipo_solicitud` int(10) unsigned NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_solicitud`),
  KEY `fk_solicitudes_clientes` (`cliente_id`),
  KEY `fk_solicitudes_usuario` (`usuario_id`),
  KEY `fk_solicitudes_sSolicitud` (`estatus_solicitud`),
  KEY `fk_solicitudes_tSolicitud` (`tipo_solicitud`),
  CONSTRAINT `fk_solicitudes_clientes` FOREIGN KEY (`cliente_id`) REFERENCES `tbl_clientes` (`id_cliente`),
  CONSTRAINT `fk_solicitudes_sSolicitud` FOREIGN KEY (`estatus_solicitud`) REFERENCES `tbl_estatus_solicitud` (`id_estatus_solicitud`),
  CONSTRAINT `fk_solicitudes_tSolicitud` FOREIGN KEY (`tipo_solicitud`) REFERENCES `tbl_tipo_solicitud` (`id_tipo_solicitud`),
  CONSTRAINT `fk_solicitudes_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `tbl_usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `tbl_tipo_boletos` (
  `id_tipo_boleto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_tipo_boleto` varchar(30) NOT NULL,
  `precio_venta` int(3) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_tipo_boleto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `tbl_tipo_nacionalidad` (
  `id_tipo_nacionalidad` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nacionalidad` varchar(15) NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_tipo_nacionalidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `tbl_tipo_producto` (
  `id_tipo_producto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_tipo_producto` varchar(30) NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_tipo_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `tbl_tipo_solicitud` (
  `id_tipo_solicitud` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(30) NOT NULL,
  `precio_solicitud` int(4) NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_tipo_solicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `tbl_usuarios` (
  `id_usuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(40) NOT NULL,
  `nombre_usuario` varchar(30) NOT NULL,
  `foto` char(50) DEFAULT NULL,
  `genero` varchar(10) NOT NULL,
  `telefono` varchar(8) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `contrasena` varchar(60) NOT NULL,
  `token` varchar(60) DEFAULT NULL,
  `intentos` int(1) DEFAULT NULL,
  `rol_id` int(10) unsigned NOT NULL,
  `estado_id` int(10) unsigned NOT NULL,
  `fecha_ult_conexion` datetime NOT NULL,
  `preguntas_contestadas` int(1) NOT NULL,
  `primer_ingreso` datetime NOT NULL,
  `fecha_vencimiento` datetime NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `fk_usuarios_roles` (`rol_id`),
  KEY `fk_usuarios_estado` (`estado_id`),
  CONSTRAINT `fk_usuarios_estado` FOREIGN KEY (`estado_id`) REFERENCES `tbl_estado` (`id_estado`),
  CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`rol_id`) REFERENCES `tbl_roles` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

INSERT INTO tbl_usuarios VALUES("2","Daniel Aguilar Rodriguez","AGUILAR","19e0b25741ffabef367eb60e33498f00.png","masculino","96885556","fernandounah.rodriguez@gmail.com","$2y$10$hp9X4l0WBte0.2NAhdHV7eNMFImyffvUcIACBvkVVZJHCvPbMj5e2","NmVkNjllMjMyYjRhOTJjMWFiNDk0OGY0","3","3","2","2021-01-20 21:05:31","3","2021-02-21 20:06:43","2021-03-21 20:06:43","root@localhost","2021-01-20 21:05:31","root@localhost","2021-01-20 21:05:31");
INSERT INTO tbl_usuarios VALUES("7","Daniel Fernando Aguilar Rodirguez","FERNANDO","d79d2cd5ab22d85d0855ffe3556d5300.png","masculino","96885556","dfa.rodriguez@gmail.com","$2y$10$rrLwvZQ5r80UPeY8v81NBuE4uF/8e39pcaq99ZlqRAyS0EUPMAR9G"," ","2","3","2","2021-02-23 16:05:51","0","2021-02-19 21:26:48","2021-03-19 21:26:48","FERNANDO","2021-01-29 20:29:19","FERNANDO","2021-01-29 20:29:19");
INSERT INTO tbl_usuarios VALUES("8","SAIRY GONZALES","SAIRY","foto.png","femenino","97655434","sairy7gonzales@gmail.com","$2y$12$JgEL.aiWbuyS2LQaaxNN4O8rjrEezP6ojGQ5HB1POln/LyS8nT/LW","","1","4","2","2021-01-29 20:32:19","0","2021-01-29 20:32:19","2021-03-01 20:32:19","SAIRY","2021-01-29 20:32:19","SAIRY","2021-01-29 20:32:19");
INSERT INTO tbl_usuarios VALUES("9","DINA MADRID","MADRID","foto.png","femenino","98654333","dinamadrid24@gmail.com","$2y$12$lGYkWzHhTFb6UXO9vYSZMOmuKwZRctLcUmDbMPWrXS/jy02cwRp6u","","0","4","4","2021-01-29 20:40:43","0","2021-01-29 20:40:43","2021-03-01 20:40:43","MADRID","2021-01-29 20:40:43","MADRID","2021-01-29 20:40:43");
INSERT INTO tbl_usuarios VALUES("10","RONAL AGUILAR","RONAL","foto.png","masculino","98564323","ronar@gmail.com","$2y$12$48iBOtqzqjHDlGQHKM2eg.aiitGsi2Nbrrdur8RZ5gVJIDUfyJTxW","","0","4","4","2021-01-29 21:21:59","0","2021-01-29 21:21:59","2021-03-01 21:21:59","RONAL","2021-01-29 21:21:59","RONAL","2021-01-29 21:21:59");
INSERT INTO tbl_usuarios VALUES("11","MICHAEL CERRATO","MICHAEL","foto.png","masculino","87654543","michael@gmail.com","$2y$12$ng2KxgaQnN55a1/7AsxNkeG6hkAAA7iM82lfDp8dkLTB.hi7r9FuG","","0","4","2","2021-01-29 21:30:04","0","2021-01-29 21:30:04","2021-03-01 21:30:04","MICHAEL","2021-01-29 21:30:04","MICHAEL","2021-01-29 21:30:04");
INSERT INTO tbl_usuarios VALUES("12","Fernando Rodriguez","ADMIN","e0dfdce48a4bee2510139c1881b9bb91.png","masculino","89654349","fernyrodriguez97@gmail.com","$2y$10$TY/JU6bPwLlGn9PsS5qWvu7.U6WmRAaoaBVePaWlzIfS6AuWCoTsG"," ","2","2","2","2021-03-16 17:13:41","0","2021-02-22 23:48:53","2021-03-22 23:48:53","RODRIGUEZ","2021-01-29 21:33:02","RODRIGUEZ","2021-01-29 21:33:02");
INSERT INTO tbl_usuarios VALUES("13","FERNANDO AGUILAR RODRIGUEZ","FERNANDOA","foto.png","masculino","98654345","dfaguilarrd@gmail.com","$2y$10$b0UeojG936YEl4wXkGY8yOeFwQC.QL.v2Ncu6MVgx5aXf/.jEOCQ.","","0","4","4","2021-01-29 21:36:35","0","2021-01-29 21:36:35","2021-03-01 21:36:35","FERNANDOA","2021-01-29 21:36:35","FERNANDOA","2021-01-29 21:36:35");
INSERT INTO tbl_usuarios VALUES("14","USUARIO PRUEBA","PRUEBA","foto.png","masculino","98675434","usuarioprueba@gmail.com","$2y$12$9gZBCW8dBXb5jr8AaL1c5O4pxa2oKhgNrl1WSKtYruiAhUtRbmzJG","","0","4","4","2021-01-31 15:31:58","0","2021-01-31 15:31:58","2021-03-03 15:31:58","PRUEBA","2021-01-31 15:31:58","PRUEBA","2021-01-31 15:31:58");
INSERT INTO tbl_usuarios VALUES("15","USUARIO DE PRUEBA","USERPRUEBA","foto","masculino","98798769","usuariopruebas@gmail.com","$2y$10$Zf.bg2itwdUjW3hQV3SGo.UjTiAY9Gsm.Ev2vNFM8mKO3oRrqXShO","","2","4","4","2021-01-31 21:25:24","0","2021-01-31 21:25:24","2021-03-03 21:25:24","USERPRUEBA","2021-01-31 21:25:24","USERPRUEBA","2021-01-31 21:25:24");
INSERT INTO tbl_usuarios VALUES("16","PEDRO LÓPEZ","PEDRO","foto","masculino","79879898","pedrolopez@gmail.com","$2y$10$/C3IbBoCVQ7KoGUzWkPPbeFTVCppWXQm35kNYftFvudwr8i6G9vdq","","0","4","4","2021-01-31 21:27:36","0","2021-01-31 21:27:36","2021-03-03 21:27:36","PEDRO","2021-01-31 21:27:36","PEDRO","2021-01-31 21:27:36");
INSERT INTO tbl_usuarios VALUES("17","Angel Aguilar","ANGEL","98e259a7ca750525ff58304969b8c0a7.png","masculino","34645656","angel@gmail.com","$2y$10$3g3VRhg3ZuFw741qa0uyjeq6X0PmaPAOeHF4rOiIIGGgjJmkdvhua","","1","4","4","2021-02-11 11:46:53","0","2021-02-11 11:46:53","2021-03-11 11:46:53","ANGEL","2021-02-11 11:46:53","ANGEL","2021-02-11 11:46:53");
INSERT INTO tbl_usuarios VALUES("18","JUAN MARTINEZ","MARTINEZ","foto","masculino","96775434","martinez@gmail.com","$2y$10$oG.hmqibzroG0yDWvc3VjOCWoi0aJdLvjT9/r0Dd3US70.lxSsY.G","","0","3","4","2021-02-11 18:14:23","0","2021-02-11 18:14:23","2021-03-11 18:14:23","MARTINEZ","2021-02-11 18:14:23","MARTINEZ","2021-02-11 18:14:23");
INSERT INTO tbl_usuarios VALUES("19","SAIRY SUJELY GONSALEZ","SUJELY","foto","femenino","87987987","sujely@gmail.com","$2y$10$UxNfUDwd0qLtBK40cJbXm.NCYzsXFTDMzS7JqeTuKQMV8pApGAge2","","0","4","4","2021-02-19 19:34:38","0","2021-02-19 19:34:38","2021-03-19 19:34:38","SUJELY","2021-02-19 19:34:38","SUJELY","2021-02-19 19:34:38");
INSERT INTO tbl_usuarios VALUES("20","ADMIN PRUEBA","ADMINu","8291e41553ef11531d5e3edcad96aed5.png","masculino","87432222","admin1@gmail.com","$2y$10$M3f9ucAy/lzoFvJPrlY2ReNDQniQrKW8CBwnK9.WTElWYieDEY9FS","","1","4","4","2021-02-23 15:20:06","0","2021-02-19 21:03:22","2021-03-19 21:03:22","ADMIN","2021-02-19 21:03:22","ADMIN","2021-02-19 21:03:22");
INSERT INTO tbl_usuarios VALUES("21","ADMIN PRUEBAS","ADMINS","46e3bcfc7d27bd05f7d6d4c615fd20c6.png","masculino","0","admins@gmail.com","$2y$10$bb2q4LCKxzzDPHopkIUAYOPjEK2Fix.xBb1UWGsg.C.iU65yeqJpG","","0","4","4","2021-02-19 21:08:13","0","2021-02-19 21:08:13","2021-03-19 21:08:13","ADMINS","2021-02-19 21:08:13","ADMINS","2021-02-19 21:08:13");
INSERT INTO tbl_usuarios VALUES("22","Admin Rodriguez","ADMINR","d94d799ff5c0b4691a175baf4ba72979.png","masculino","99569876","adminr@gmail.com","$2y$10$ezo9muXyfrXRRIjAGZlcS.qkPZC1eaxd8qlRn4Q3OP43VJOO.gplm","","","2","4","2021-02-19 21:10:03","0","2021-02-19 21:10:03","2021-03-19 21:10:03","ADMINR","2021-02-19 21:10:03","ADMINR","2021-02-19 21:10:03");
INSERT INTO tbl_usuarios VALUES("23","ADMINS PRUEBAS","ADMINSP","foto","masculino","76876876","adminsp@gmail.com","$2y$10$9HFN9iER8NJVH3GYd2AKFOl29tBbbJNpOVIBlnIVBQL7JrFMvr5S2","","0","2","4","2021-02-19 21:33:45","0","2021-02-19 21:33:45","2021-03-19 21:33:45","ADMINSP","2021-02-19 21:33:45","ADMINSP","2021-02-19 21:33:45");
INSERT INTO tbl_usuarios VALUES("24","DWDFFF","FDGDGDG","","masculino","79879879","Adminre@gmail.com","$2y$10$LXpcVdlm905hm4iJJtrqYeDFIq1rT7EsAqpbCCdQTuH0teQ6yqZpy","","","4","4","2021-02-23 12:11:28","0","2021-02-23 12:11:28","2021-03-23 12:11:28","fernando","2021-02-23 12:11:28","fernando","2021-02-23 12:11:28");
INSERT INTO tbl_usuarios VALUES("25","MARIO ROSALES","ROSALES","foto","masculino","76543465","dfaguilarr@gmail.com","$2y$10$7PH4GhxyE8DcF6yKH5yN0.vQ/89IJfXyLaZpT7gzmXMXZO02pQ9mK","","0","2","2","2021-02-23 18:31:35","0","2021-02-23 18:31:35","2021-03-23 18:31:35","ROSALES","2021-02-23 18:31:35","ROSALES","2021-02-23 18:31:35");
INSERT INTO tbl_usuarios VALUES("26","INFORMATICA UNAH","INFORMATICA","","masculino","98765433","informatica@gmail.com","$2y$10$TzFEhs2DtTLbb3WjFHElC.snA7dFlCCFCz342apRXPpnzKHEpYGNq","","","3","4","2021-02-23 18:43:08","0","2021-02-23 18:43:08","2021-03-23 18:43:08","admin","2021-02-23 18:43:08","admin","2021-02-23 18:43:08");


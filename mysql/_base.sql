/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP TABLE IF EXISTS `characters`;
CREATE TABLE IF NOT EXISTS `characters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

REPLACE INTO `characters` (`id`, `name`) VALUES
	(1, 'Abraão pai de Isaque'),
	(2, 'Agar concumbina de Abraão'),
	(3, 'Eva'),
	(4, 'Samuel, Profeta'),
	(5, 'Ana esposa de Elcana'),
	(6, 'Elcana marido de Ana'),
	(7, 'Davi, Rei'),
	(8, 'Absalão filho de Davi'),
	(9, 'Daniel / Beltessazar'),
	(10, 'Misael / Mesaque'),
	(11, 'Miguel, Arcanjo'),
	(12, 'Gabriel, Anjo'),
	(13, 'Paulo, Apóstolo'),
	(14, 'Adão'),
	(15, 'Golias'),
	(16, 'Sara esposa de Abraão'),
	(17, 'Moisés, Líder de Israel'),
	(18, 'Mefibosete, filho de Jonatã'),
	(19, 'Jonas, Profeta'),
	(20, 'Sansão, Juíz'),
	(21, 'Jael esposa de Héber'),
	(22, 'Débora, Profetisa'),
	(23, 'Noé, Profeta'),
	(24, 'Sem filho de Noé'),
	(25, 'Cã filho de Noé'),
	(26, 'Jafé filho de Noé'),
	(27, 'Metusalém filho de Enoque'),
	(28, 'José do Egito'),
	(29, 'José pai de Jesus'),
	(30, 'Maria mãe de Jesus'),
	(31, 'Maria Madalena'),
	(32, 'Lázaro amigo de Jesus'),
	(33, 'Marta irmã de Lázaro'),
	(34, 'Maria irmã de Lázaro'),
	(35, 'Esaú / Edom'),
	(36, 'Jacó / Israel'),
	(37, 'Gideão, Juíz'),
	(38, 'Herodes Ântipas, Governador'),
	(39, 'Corá, Levita'),
	(40, 'Salomão, Rei'),
	(41, 'Roboão, rei'),
	(42, 'Jeroboão, Rei'),
	(43, 'Acabe, Rei'),
	(44, 'Jezabel, Rainha'),
	(45, 'Dorcas / Tabita'),
	(46, 'Pedro, Apóstolo'),
	(47, 'João, Apóstolo'),
	(48, 'Judas Iscariotes'),
	(49, 'Dalila de Sansão'),
	(50, 'Saul, Rei'),
	(51, 'Zacarias pai de João Batista'),
	(52, 'João Batista'),
	(53, 'Barnabé amigo de Paulo'),
	(54, 'Lucas, discípulo'),
	(55, 'Sulamita, Camponesa'),
	(56, 'Jeoás / Joás, Rei'),
	(57, 'Josias, Rei'),
	(58, 'Manassés filho de José'),
	(59, 'Jefté, Juiz'),
	(60, 'Rubem filho de Jacó'),
	(61, 'Simeão filho de Jacó'),
	(62, 'Levi filho de Jacó'),
	(63, 'Judá filho de Jacó'),
	(64, 'Dã filho de Jacó'),
	(65, 'Naftali filho de Jacó'),
	(66, 'Gade filho de Jacó'),
	(67, 'Aser filho de Jacó'),
	(68, 'Issacar filho de Jacó'),
	(69, 'Zebulão filho de Jacó'),
	(70, 'Benjamim filho de Jacó'),
	(71, 'Sangar, Juíz'),
	(72, 'Tola, Juíz'),
	(73, 'Ezequiel, Profeta'),
	(74, 'Judas Tadeu'),
	(75, 'Mateus, Apóstolo'),
	(76, 'Tomé, Apóstolo'),
	(77, 'Natanael, Apóstolo'),
	(78, 'André, Apóstolo'),
	(79, 'Matias, Apóstolo'),
	(80, 'Raquel esposa de jacó'),
	(81, 'Léia esposa de Jacó'),
	(82, 'Raabe de Jericó'),
	(83, 'Calebe amigo de Josué'),
	(84, 'Arão irmão de Moisés'),
	(85, 'Miriã irmã de Moisés'),
	(86, 'Hulda, Profetisa'),
	(87, 'Balaão'),
	(88, 'Isaías, Profeta'),
	(89, 'Caim filho de Adão'),
	(90, 'Abel filho de Adão'),
	(91, 'Hananias / Sadraque'),
	(92, 'Azarias / Abednego'),
	(93, 'Efraim filho de José'),
	(94, 'Enoque, Profeta'),
	(95, 'Elias, Profeta'),
	(96, 'Eliseu, Profeta'),
	(97, 'Ló Sobrinho de Abraão'),
	(98, 'Jó'),
	(99, 'Josué, Líder de Israel');

DROP TABLE IF EXISTS `character_question`;
CREATE TABLE IF NOT EXISTS `character_question` (
  `question_id` int(10) unsigned NOT NULL,
  `character_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`character_id`,`question_id`),
  KEY `FK_Q_CHAR` (`question_id`),
  KEY `FK_CHAR_Q` (`character_id`),
  CONSTRAINT `FK_CHAR_Q` FOREIGN KEY (`character_id`) REFERENCES `characters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Q_CHAR` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `field` char(50) NOT NULL,
  `value` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`field`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

REPLACE INTO `config` (`field`, `value`) VALUES
	('api', 'YW5jaWVudDo0bkMxM250ITIwMjQ');

DROP TABLE IF EXISTS `gamers`;
CREATE TABLE IF NOT EXISTS `gamers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  `points` int(10) unsigned DEFAULT 0,
  `room_code` char(6) DEFAULT NULL,
  `finished` tinyint(1) unsigned DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK_ROOM` (`room_code`),
  CONSTRAINT `FK_ROOM` FOREIGN KEY (`room_code`) REFERENCES `rooms` (`code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

REPLACE INTO `questions` (`id`, `question`) VALUES
	(1, 'Mudou de cidade ou de país?'),
	(2, 'Foi um Patriarca?'),
	(3, 'Cometeu um pecado grave mas se arrependeu e mudou?'),
	(4, 'Casou?'),
	(5, 'Presenciou algum milagre?'),
	(6, 'Tinha algum filho ou filha?'),
	(7, 'Foi profeta ou profetisa?'),
	(8, 'Falou com um anjo?'),
	(9, 'Correu risco de morte e sobreviveu?'),
	(10, 'Lutou contra os inimigos de Jeová?'),
	(11, 'Foi um traidor?'),
	(12, 'Foi um rei ou rainha?'),
	(13, 'Foi um dos 12 Juízes?'),
	(14, 'Foi um dos 12 Apóstolos?'),
	(15, 'Foi missionário?'),
	(16, 'Foi Sacerdote ou Sumo Sacerdote?'),
	(17, 'Foi Nazireu?'),
	(18, 'Conheceu Jesus pessoalmente?'),
	(19, 'Presenciou uma das 9 ressurreições?'),
	(20, 'Tinha algum problema físico ou doença crônica?'),
	(21, 'Seu nome se tornou uma das tribos de Israel?'),
	(22, 'Largou tudo para salvar a vida ou para sair de uma situação difícil?'),
	(23, 'Até onde se sabe morreu como inimigo ou inimiga de Jeová?'),
	(24, 'A Bíblia fala pouco sobre essa pessoa?'),
	(25, 'Escreveu algum livro da Bíblia?'),
	(26, 'Tem algum livro da Bíblia com seu nome?'),
	(27, 'Contou alguma mentira que não foi considerada errada?'),
	(28, 'Fez algo impressionante mesmo sendo de idade avançada?'),
	(29, 'Dialogou com um animal?'),
	(30, 'Viveu no período dos Juízes de Israel?'),
	(31, 'Viveu no período dos Reis de Israel?'),
	(32, 'Viveu no período antes do dilúvio?'),
	(33, 'Viveu após o dilúvio mas antes de haver Juízes em Israel?'),
	(34, 'Viveu após o período em que havia reis designados por Jeová?'),
	(35, 'A Bíblia deixa claro que essa pessoa não será ressussitada?');

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE IF NOT EXISTS `rooms` (
  `code` char(6) NOT NULL,
  `fase` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `secret_character_id` int(10) unsigned DEFAULT NULL,
  `out_gamer_id` int(10) unsigned DEFAULT NULL,
  `qt_rounds` int(10) unsigned DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`code`),
  KEY `FK_SECRET` (`secret_character_id`),
  KEY `FK_OUT_OF_LOOP` (`out_gamer_id`),
  CONSTRAINT `FK_OUT_OF_LOOP` FOREIGN KEY (`out_gamer_id`) REFERENCES `gamers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `FK_SECRET` FOREIGN KEY (`secret_character_id`) REFERENCES `characters` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `views`;
CREATE TABLE IF NOT EXISTS `views` (
  `room_code` char(6) NOT NULL,
  `gamer_id` int(10) unsigned NOT NULL,
  `qt` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`room_code`,`gamer_id`),
  KEY `FK_GAMER_VIEWS` (`gamer_id`),
  KEY `FK_ROOM_VIEWS` (`room_code`),
  CONSTRAINT `FK_GAMER_VIEWS` FOREIGN KEY (`gamer_id`) REFERENCES `gamers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_ROOM_VIEWS` FOREIGN KEY (`room_code`) REFERENCES `rooms` (`code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

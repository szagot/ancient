/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE IF NOT EXISTS `ancient` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `ancient`;

DROP TABLE IF EXISTS `characters`;
CREATE TABLE IF NOT EXISTS `characters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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


DROP TABLE IF EXISTS `gamer`;
CREATE TABLE IF NOT EXISTS `gamer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  `points` int(10) unsigned DEFAULT 0,
  `room_code` char(50) DEFAULT NULL,
  `finished` tinyint(1) unsigned DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK_ROOM` (`room_code`),
  CONSTRAINT `FK_ROOM` FOREIGN KEY (`room_code`) REFERENCES `room` (`code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `room`;
CREATE TABLE IF NOT EXISTS `room` (
  `code` char(50) NOT NULL,
  `fase` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `secret_character_id` int(10) unsigned DEFAULT NULL,
  `out_gamer_id` int(10) unsigned DEFAULT NULL,
  `qt_rounds` int(10) unsigned DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`code`),
  KEY `FK_SECRET` (`secret_character_id`),
  KEY `FK_OUT_OF_LOOP` (`out_gamer_id`),
  CONSTRAINT `FK_OUT_OF_LOOP` FOREIGN KEY (`out_gamer_id`) REFERENCES `gamer` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `FK_SECRET` FOREIGN KEY (`secret_character_id`) REFERENCES `characters` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

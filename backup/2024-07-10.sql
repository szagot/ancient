-- MariaDB dump 10.19  Distrib 10.5.23-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: ancient
-- ------------------------------------------------------
-- Server version	10.5.23-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `character_question`
--

DROP TABLE IF EXISTS `character_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `character_question` (
  `question_id` int(10) unsigned NOT NULL,
  `character_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`character_id`,`question_id`),
  KEY `FK_Q_CHAR` (`question_id`),
  KEY `FK_CHAR_Q` (`character_id`),
  CONSTRAINT `FK_CHAR_Q` FOREIGN KEY (`character_id`) REFERENCES `characters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Q_CHAR` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `character_question`
--

LOCK TABLES `character_question` WRITE;
/*!40000 ALTER TABLE `character_question` DISABLE KEYS */;
INSERT INTO `character_question` VALUES (1,1),(2,1),(4,1),(6,1),(8,1),(10,1),(28,1),(33,1),(1,2),(6,2),(8,2),(9,2),(22,2),(33,2),(1,3),(4,3),(6,3),(8,3),(11,3),(23,3),(29,3),(35,3),(1,4),(4,4),(6,4),(7,4),(1,5),(4,5),(6,5),(30,5),(1,6),(4,6),(6,6),(24,6),(30,6),(1,7),(3,7),(4,7),(6,7),(9,7),(10,7),(12,7),(25,7),(27,7),(31,7),(4,8),(6,8),(11,8),(12,8),(23,8),(31,8),(1,9),(7,9),(8,9),(9,9),(25,9),(26,9),(28,9),(31,9),(34,9),(1,10),(8,10),(9,10),(31,10),(34,10),(1,11),(8,11),(1,12),(8,12),(10,12),(24,12),(1,13),(3,13),(8,13),(1,14),(4,14),(6,14),(8,14),(11,14),(23,14),(32,14),(35,14),(23,15),(24,15),(31,15),(1,16),(4,16),(6,16),(8,16),(1,17),(3,17),(4,17),(6,17),(7,17),(8,17),(9,17),(10,17),(1,19),(3,19),(7,19),(8,19),(9,19),(1,20),(3,20),(4,20),(8,20),(9,20),(10,20),(4,21),(6,21),(1,22),(7,22),(10,22),(30,22),(1,23),(2,23),(4,23),(6,23),(7,23),(8,23),(9,23),(1,24),(2,24),(4,24),(6,24),(1,25),(2,25),(4,25),(6,25),(9,25),(22,25),(24,25),(32,25),(33,25),(1,26),(2,26),(4,26),(6,26),(6,27),(1,28),(4,28),(6,28),(9,28),(1,29),(4,29),(6,29),(8,29),(9,29),(1,30),(4,30),(1,31),(8,31),(1,32),(1,33),(1,34),(2,35),(4,35),(6,35),(11,35),(33,35),(1,36),(2,36),(4,36),(6,36),(8,36),(9,36),(1,37),(4,37),(8,37),(10,37),(13,37),(30,37),(1,38),(6,38),(1,39),(4,39),(6,39),(10,39),(11,39),(23,39),(33,39),(35,39),(1,40),(4,40),(6,40),(8,40),(4,41),(6,41),(4,42),(6,42),(9,42),(1,43),(4,43),(6,43),(10,43),(11,43),(12,43),(23,43),(31,43),(4,44),(6,44),(1,45),(4,45),(6,45),(19,45),(24,45),(34,45),(1,46),(3,46),(4,46),(8,46),(1,47),(8,47),(14,47),(1,48),(8,48),(1,49),(11,49),(23,49),(30,49),(4,50),(6,50),(10,50),(1,51),(4,51),(6,51),(8,51),(1,52),(6,52),(8,52),(1,53),(15,53),(24,53),(34,53),(1,54),(8,54),(4,55),(4,56),(6,56),(4,57),(6,57),(10,57),(1,58),(2,58),(4,58),(6,58),(1,59),(4,59),(6,59),(8,59),(10,59),(2,60),(3,60),(4,60),(6,60),(2,61),(3,61),(4,61),(6,61),(2,62),(3,62),(4,62),(6,62),(2,63),(3,63),(4,63),(6,63),(2,64),(3,64),(4,64),(6,64),(21,64),(24,64),(33,64),(2,65),(3,65),(4,65),(6,65),(2,66),(3,66),(4,66),(6,66),(21,66),(24,66),(33,66),(2,67),(3,67),(4,67),(6,67),(11,67),(21,67),(24,67),(33,67),(2,68),(3,68),(4,68),(6,68),(2,69),(3,69),(4,69),(6,69),(2,70),(4,70),(6,70),(21,70),(24,70),(33,70),(1,71),(10,71),(10,72),(1,73),(4,73),(7,73),(8,73),(25,73),(26,73),(31,73),(34,73),(1,74),(8,74),(1,75),(8,75),(14,75),(8,76),(1,77),(8,77),(1,78),(8,78),(14,78),(18,78),(19,78),(24,78),(34,78),(1,79),(8,79),(14,79),(4,80),(6,80),(4,81),(6,81),(1,82),(4,82),(9,82),(1,83),(4,83),(6,83),(9,83),(10,83),(22,83),(28,83),(33,83),(1,84),(3,84),(4,84),(6,84),(9,84),(10,84),(16,84),(22,84),(33,84),(1,85),(3,85),(4,85),(6,85),(9,85),(1,86),(7,86),(1,87),(7,87),(8,87),(11,87),(23,87),(29,87),(1,88),(7,88),(8,88),(1,89),(4,89),(6,89),(8,89),(11,89),(23,89),(32,89),(35,89),(1,90),(8,90),(32,90),(1,91),(8,91),(9,91),(24,91),(31,91),(34,91),(1,92),(8,92),(9,92),(31,92),(34,92),(1,93),(2,93),(4,93),(6,93),(21,93),(24,93),(33,93),(1,94),(7,94),(24,94),(32,94),(1,95),(7,95),(8,95),(9,95),(10,95),(19,95),(28,95),(31,95),(1,96),(7,96),(8,96),(9,96),(10,96),(19,96),(22,96),(28,96),(31,96),(1,97),(4,97),(6,97),(8,97),(1,98),(4,98),(6,98),(9,98),(1,99),(4,99),(6,99),(9,99),(10,99),(30,99),(4,103),(6,103),(4,104),(6,104);
/*!40000 ALTER TABLE `character_question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `characters`
--

DROP TABLE IF EXISTS `characters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `characters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `characters`
--

LOCK TABLES `characters` WRITE;
/*!40000 ALTER TABLE `characters` DISABLE KEYS */;
INSERT INTO `characters` VALUES (1,'Abraão, pai de Isaque'),(2,'Agar, concumbina de Abraão'),(3,'Eva, primeira mulher'),(4,'Samuel, Profeta'),(5,'Ana, esposa de Elcana'),(6,'Elcana, marido de Ana'),(7,'Davi, Rei'),(8,'Absalão, filho de Davi'),(9,'Daniel / Beltessazar'),(10,'Misael / Mesaque'),(11,'Miguel, Arcanjo'),(12,'Gabriel, Anjo'),(13,'Paulo, Apóstolo'),(14,'Adão, primeiro homem'),(15,'Golias, o Filisteu'),(16,'Sara, esposa de Abraão'),(17,'Moisés, Líder de Israel'),(18,'Mefibosete, filho de Jonatã'),(19,'Jonas, Profeta'),(20,'Sansão, Juíz'),(21,'Jael, esposa de Héber'),(22,'Débora, Profetisa'),(23,'Noé, Profeta'),(24,'Sem, filho de Noé'),(25,'Cã, filho de Noé'),(26,'Jafé, filho de Noé'),(27,'Metusalém, filho de Enoque'),(28,'José, filho de Jacó'),(29,'José, pai de Jesus'),(30,'Maria, mãe de Jesus'),(31,'Maria Madalena'),(32,'Lázaro, amigo de Jesus'),(33,'Marta, irmã de Lázaro'),(34,'Maria, irmã de Lázaro'),(35,'Esaú / Edom'),(36,'Jacó / Israel'),(37,'Gideão, Juíz'),(38,'Herodes Ântipas, Governador'),(39,'Corá, Levita'),(40,'Salomão, Rei'),(41,'Roboão, rei'),(42,'Jeroboão, Rei'),(43,'Acabe, Rei'),(44,'Jezabel, Rainha'),(45,'Dorcas / Tabita'),(46,'Pedro, Apóstolo'),(47,'João, Apóstolo'),(48,'Judas Iscariotes, Apóstolo'),(49,'Dalila de Sansão'),(50,'Saul, Rei'),(51,'Zacarias, pai de João Batista'),(52,'João Batista'),(53,'Barnabé, amigo de Paulo'),(54,'Lucas, discípulo'),(55,'Sulamita, Camponesa'),(56,'Jeoás / Joás, Rei'),(57,'Josias, Rei'),(58,'Manassés, filho de José'),(59,'Jefté, Juiz'),(60,'Rubem, filho de Jacó'),(61,'Simeão, filho de Jacó'),(62,'Levi, filho de Jacó'),(63,'Judá, filho de Jacó'),(64,'Dã, filho de Jacó'),(65,'Naftali, filho de Jacó'),(66,'Gade, filho de Jacó'),(67,'Aser, filho de Jacó'),(68,'Issacar, filho de Jacó'),(69,'Zebulão, filho de Jacó'),(70,'Benjamim, filho de Jacó'),(71,'Sangar, Juíz'),(72,'Tola, Juíz'),(73,'Ezequiel, Profeta'),(74,'Judas Tadeu, Apóstolo'),(75,'Mateus, Apóstolo'),(76,'Tomé, Apóstolo'),(77,'Natanael, Apóstolo'),(78,'André, Apóstolo'),(79,'Matias, Apóstolo'),(80,'Raquel, esposa de jacó'),(81,'Léia, esposa de Jacó'),(82,'Raabe, de Jericó'),(83,'Calebe, amigo de Josué'),(84,'Arão, irmão de Moisés'),(85,'Miriã irmã de Moisés'),(86,'Hulda, Profetisa'),(87,'Balaão, falso Profeta'),(88,'Isaías, Profeta'),(89,'Caim, filho de Adão'),(90,'Abel, filho de Adão'),(91,'Hananias / Sadraque'),(92,'Azarias / Abednego'),(93,'Efraim, filho de José'),(94,'Enoque, Profeta'),(95,'Elias, Profeta'),(96,'Eliseu, Profeta'),(97,'Ló, Sobrinho de Abraão'),(98,'Jó, da terra de Uz'),(99,'Josué, Líder de Israel'),(103,'Rute, amiga de Noemi'),(104,'Noemi, amiga de Rute'),(106,'Nabucodonosor, Rei de Babilônia');
/*!40000 ALTER TABLE `characters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `field` char(50) NOT NULL,
  `value` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`field`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config`
--

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES ('api','YW5jaWVudDo0bkMxM250ITIwMjQ');
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gamers`
--

DROP TABLE IF EXISTS `gamers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gamers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  `points` int(10) unsigned DEFAULT 0,
  `room_code` char(6) DEFAULT NULL,
  `finished` tinyint(1) unsigned DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK_ROOM` (`room_code`),
  CONSTRAINT `FK_ROOM` FOREIGN KEY (`room_code`) REFERENCES `rooms` (`code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gamers`
--

LOCK TABLES `gamers` WRITE;
/*!40000 ALTER TABLE `gamers` DISABLE KEYS */;
INSERT INTO `gamers` VALUES (1,'szagot',0,'D6B180',0),(2,'alini',0,'D6B180',0),(3,'daniel',0,'D6B180',0),(4,'filipe',0,'D6B180',0),(9,'alejandro',0,'D6B180',0),(10,'sara',0,'D6B180',0);
/*!40000 ALTER TABLE `gamers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (1,'Viu algum milagre?'),(2,'Foi um Patriarca?'),(3,'Cometeu um pecado grave mas se arrependeu e mudou?'),(4,'Casou?'),(6,'Tinha algum filho ou filha?'),(7,'Foi profeta ou profetisa?'),(8,'Falou com um anjo?'),(9,'Correu risco de morte e sobreviveu?'),(10,'Lutou contra os inimigos de Jeová?'),(11,'Foi um traidor?'),(12,'Foi um rei ou rainha?'),(13,'Foi um dos 12 Juízes?'),(14,'Foi um dos 12 Apóstolos?'),(15,'Foi missionário?'),(16,'Foi Sacerdote ou Sumo Sacerdote?'),(17,'Foi Nazireu?'),(18,'Conheceu Jesus pessoalmente?'),(19,'Presenciou uma das 9 ressurreições?'),(20,'Tinha algum problema físico ou doença crônica?'),(21,'Seu nome se tornou uma das tribos de Israel?'),(22,'Largou tudo para salvar a vida ou para sair de uma situação difícil?'),(23,'Até onde se sabe morreu como inimigo ou inimiga de Jeová?'),(24,'A Bíblia fala pouco sobre essa pessoa?'),(25,'Escreveu algum livro da Bíblia?'),(26,'Tem algum livro da Bíblia com seu nome?'),(27,'Contou alguma mentira que não foi considerada errada?'),(28,'Fez algo impressionante mesmo sendo de idade avançada?'),(29,'Dialogou com um animal?'),(30,'Viveu no período dos Juízes de Israel? (após a entrada na Terra Prometida, entre 1.473 AC e 1.117 AC)'),(31,'Viveu no período dos Reis de Israel? (entre 1.117 AC e 607 AC)'),(32,'Viveu no período antes do dilúvio (antes de 2.370 AC)?'),(33,'Viveu após o dilúvio mas antes de haver Juízes em Israel (entre 2.370 AC e 1.473 AC)?'),(34,'Viveu após a queda de Jerusalém por Nabucodonosor, Rei de Babilônia? (após 607 AC)'),(35,'A Bíblia deixa claro que essa pessoa não será ressussitada?');
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rooms` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES ('D6B180',2,88,10,0,'2024-07-05 15:18:54');
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `views`
--

DROP TABLE IF EXISTS `views`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `views` (
  `room_code` char(6) NOT NULL,
  `gamer_id` int(10) unsigned NOT NULL,
  `qt` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`room_code`,`gamer_id`),
  KEY `FK_GAMER_VIEWS` (`gamer_id`),
  KEY `FK_ROOM_VIEWS` (`room_code`),
  CONSTRAINT `FK_GAMER_VIEWS` FOREIGN KEY (`gamer_id`) REFERENCES `gamers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_ROOM_VIEWS` FOREIGN KEY (`room_code`) REFERENCES `rooms` (`code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `views`
--

LOCK TABLES `views` WRITE;
/*!40000 ALTER TABLE `views` DISABLE KEYS */;
/*!40000 ALTER TABLE `views` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-07-10 18:11:16

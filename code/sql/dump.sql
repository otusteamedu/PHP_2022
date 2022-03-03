-- MySQL dump 10.13  Distrib 8.0.23, for Linux (x86_64)
--
-- Host: localhost    Database: laravel
-- ------------------------------------------------------
-- Server version	8.0.23

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cinema`
--

DROP TABLE IF EXISTS `cinema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cinema` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cinema_pk` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cinema`
--

LOCK TABLES `cinema` WRITE;
/*!40000 ALTER TABLE `cinema` DISABLE KEYS */;
INSERT INTO `cinema` VALUES (1,'Украина');
/*!40000 ALTER TABLE `cinema` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `film`
--

DROP TABLE IF EXISTS `film`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `film` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `cost` double NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `film`
--

LOCK TABLES `film` WRITE;
/*!40000 ALTER TABLE `film` DISABLE KEYS */;
INSERT INTO `film` VALUES (1,'Титаник',500,'2022-03-03 14:16:38','2022-03-03 14:17:01'),(2,'Терминатор2',500,'2022-03-03 14:16:38','2022-03-03 14:17:01'),(3,'Властелин колец',600,'2022-03-03 14:16:38','2022-03-03 14:17:01'),(4,'Форсаж9',700,'2022-03-03 14:16:38','2022-03-03 14:17:01');
/*!40000 ALTER TABLE `film` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hall`
--

DROP TABLE IF EXISTS `hall`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hall` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(10) DEFAULT NULL,
  `cinema_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hall_id_uindex` (`id`),
  KEY `fk_cinema_id` (`cinema_id`),
  CONSTRAINT `fk_cinema_id` FOREIGN KEY (`cinema_id`) REFERENCES `cinema` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hall`
--

LOCK TABLES `hall` WRITE;
/*!40000 ALTER TABLE `hall` DISABLE KEYS */;
INSERT INTO `hall` VALUES (1,'Первый зал',1),(2,'Второй зал',1);
/*!40000 ALTER TABLE `hall` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hall_film`
--

DROP TABLE IF EXISTS `hall_film`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hall_film` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hall_id` int DEFAULT NULL,
  `film_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hall_film_id_uindex` (`id`),
  KEY `fk_film_id` (`film_id`),
  KEY `fk_hall_id` (`hall_id`),
  CONSTRAINT `fk_film_id` FOREIGN KEY (`film_id`) REFERENCES `film` (`id`),
  CONSTRAINT `fk_hall_id` FOREIGN KEY (`hall_id`) REFERENCES `hall` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hall_film`
--

LOCK TABLES `hall_film` WRITE;
/*!40000 ALTER TABLE `hall_film` DISABLE KEYS */;
INSERT INTO `hall_film` VALUES (1,1,1),(2,1,2),(3,1,3),(6,2,1),(7,2,2);
/*!40000 ALTER TABLE `hall_film` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hall_places`
--

DROP TABLE IF EXISTS `hall_places`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hall_places` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hall_id` int DEFAULT NULL,
  `place_id` int DEFAULT NULL,
  `row` smallint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_hall_places_hall_id` (`hall_id`),
  KEY `fk_hall_places_place_id` (`place_id`),
  CONSTRAINT `fk_hall_places_hall_id` FOREIGN KEY (`hall_id`) REFERENCES `hall` (`id`),
  CONSTRAINT `fk_hall_places_place_id` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hall_places`
--

LOCK TABLES `hall_places` WRITE;
/*!40000 ALTER TABLE `hall_places` DISABLE KEYS */;
INSERT INTO `hall_places` VALUES (1,1,6,1),(2,1,4,1),(3,1,2,1),(4,1,1,1),(5,1,7,1),(6,1,5,1),(7,1,3,1);
/*!40000 ALTER TABLE `hall_places` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `hall_id` int DEFAULT NULL,
  `place_id` int DEFAULT NULL,
  `film_id` int DEFAULT NULL,
  `status_id` int NOT NULL DEFAULT '0',
  `cost` double DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id_uindex` (`id`),
  KEY `fk_order_id` (`film_id`),
  KEY `fk_status_id` (`status_id`),
  KEY `fk_user_id` (`user_id`),
  KEY `fk_order_hall_id` (`hall_id`),
  KEY `fk_order_place_id` (`place_id`),
  CONSTRAINT `fk_order_hall_id` FOREIGN KEY (`hall_id`) REFERENCES `hall` (`id`),
  CONSTRAINT `fk_order_id` FOREIGN KEY (`film_id`) REFERENCES `film` (`id`),
  CONSTRAINT `fk_order_place_id` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`),
  CONSTRAINT `fk_status_id` FOREIGN KEY (`status_id`) REFERENCES `order_status` (`id`),
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (1,1,1,1,1,3,500,'2022-03-02 16:03:50','2022-04-03 16:03:57'),(2,1,1,2,2,1,500,'2022-03-02 16:03:53','2022-03-04 16:03:58'),(3,2,2,1,3,2,600,'2022-03-03 16:03:55','2022-03-03 16:03:59'),(4,2,2,2,4,3,600,'2022-03-03 16:03:56','2022-03-03 16:04:00');
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_status`
--

DROP TABLE IF EXISTS `order_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_status_id_uindex` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_status`
--

LOCK TABLES `order_status` WRITE;
/*!40000 ALTER TABLE `order_status` DISABLE KEYS */;
INSERT INTO `order_status` VALUES (1,'Новый'),(2,'В обработке'),(3,'Выполнен');
/*!40000 ALTER TABLE `order_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `places`
--

DROP TABLE IF EXISTS `places`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `places` (
  `id` int NOT NULL AUTO_INCREMENT,
  `place` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `places_id_uindex` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `places`
--

LOCK TABLES `places` WRITE;
/*!40000 ALTER TABLE `places` DISABLE KEYS */;
INSERT INTO `places` VALUES (1,18),(2,17),(3,16),(4,15),(5,1),(6,2),(7,3),(8,4),(9,5),(10,6),(11,7),(12,8),(13,9),(14,10),(15,11),(16,12),(17,13),(18,14);
/*!40000 ALTER TABLE `places` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_uindex` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Василий Иванович'),(2,'Петр Петрович');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-03-03 15:11:27

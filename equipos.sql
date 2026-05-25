-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: berumen_db
-- ------------------------------------------------------
-- Server version	8.4.3

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
-- Table structure for table `equipos`
--

DROP TABLE IF EXISTS `equipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `numero` int NOT NULL,
  `tipo` enum('computadora','videojuego') COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estatus` enum('disponible','en_uso','pausado','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'disponible',
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `equipos_numero_unique` (`numero`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipos`
--

LOCK TABLES `equipos` WRITE;
/*!40000 ALTER TABLE `equipos` DISABLE KEYS */;
INSERT INTO `equipos` VALUES (1,1,'computadora','Computadora 1','disponible',1,'2026-05-12 01:41:03','2026-05-18 16:12:43'),(2,2,'computadora','Computadora 2','disponible',1,'2026-05-12 01:41:03','2026-05-18 17:06:14'),(3,3,'computadora','Computadora 3','disponible',1,'2026-05-12 01:41:03','2026-05-19 14:57:50'),(4,4,'computadora','Computadora 4','disponible',1,'2026-05-12 01:41:03','2026-05-18 17:06:16'),(5,5,'computadora','Computadora 5','disponible',1,'2026-05-12 01:41:03','2026-05-18 16:15:24'),(6,11,'videojuego','Videojuego 11','disponible',1,'2026-05-12 01:41:03','2026-05-15 19:00:23'),(7,12,'videojuego','Videojuego 12','disponible',1,'2026-05-12 01:41:03','2026-05-15 15:09:17'),(8,13,'videojuego','Videojuego 13','disponible',1,'2026-05-12 01:41:03','2026-05-14 20:45:12'),(9,14,'videojuego','Videojuego 14','disponible',1,'2026-05-12 01:41:03','2026-05-18 17:06:20'),(10,15,'videojuego','Videojuego 15','disponible',1,'2026-05-12 01:41:03','2026-05-19 14:52:41'),(11,16,'videojuego','Videojuego 16','disponible',1,'2026-05-12 01:41:03','2026-05-18 17:06:25'),(12,17,'videojuego','Videojuego 17','disponible',1,'2026-05-12 01:41:03','2026-05-14 22:01:59');
/*!40000 ALTER TABLE `equipos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-23  9:57:00

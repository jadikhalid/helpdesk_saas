-- MySQL dump 10.13  Distrib 8.0.45, for Linux (x86_64)
--
-- Host: localhost    Database: helpdesk_saas
-- ------------------------------------------------------
-- Server version	8.0.45-0ubuntu0.24.04.1

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
-- Table structure for table `slas`
--

DROP TABLE IF EXISTS `slas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `slas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `label` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resolution_time_hours` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `label` (`label`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slas`
--

LOCK TABLES `slas` WRITE;
/*!40000 ALTER TABLE `slas` DISABLE KEYS */;
INSERT INTO `slas` VALUES (1,'Critique',2,'2026-03-04 22:59:45'),(2,'Urgent',8,'2026-03-04 22:59:45'),(3,'Standard',24,'2026-03-04 22:59:45');
/*!40000 ALTER TABLE `slas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('open','pending','resolved','closed') COLLATE utf8mb4_unicode_ci DEFAULT 'open',
  `priority_id` int DEFAULT NULL,
  `client_id` int DEFAULT NULL,
  `assigned_to` int DEFAULT NULL,
  `deadline_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `priority_id` (`priority_id`),
  CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`priority_id`) REFERENCES `slas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (9,'premier ticket','premier ticket','open',3,NULL,NULL,'2026-03-12 22:49:00','2026-03-11 22:49:00'),(11,'deuxieme ticket','Description du deuxieme ticket','closed',2,NULL,NULL,'2026-03-12 07:21:47','2026-03-11 23:21:47'),(12,'3eme ticket','Description du 3eme ticket','resolved',1,NULL,NULL,'2026-03-12 01:22:50','2026-03-11 23:22:50'),(13,'neme ticket','description neme ticket','closed',2,NULL,NULL,'2026-03-13 06:50:43','2026-03-12 22:50:43');
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('super_admin','admin','user') COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `email_2` (`email`),
  UNIQUE KEY `email_3` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Super Admin Demo','superadmin@jadi-digital.com','$2y$10$0Wx8m1YekLmvb6C4mYCmK.qNjomTNH285DwiGJ3oCuVBZkBEvZ6K6','super_admin','2026-03-18 00:25:39'),(2,'Admin Demo','admin@jadi-digital.com','$2y$10$0Wx8m1YekLmvb6C4mYCmK.qNjomTNH285DwiGJ3oCuVBZkBEvZ6K6','admin','2026-03-18 00:25:39'),(3,'User Demo','user@jadi-digital.com','$2y$10$0Wx8m1YekLmvb6C4mYCmK.qNjomTNH285DwiGJ3oCuVBZkBEvZ6K6','user','2026-03-18 00:25:39');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-18  0:34:49

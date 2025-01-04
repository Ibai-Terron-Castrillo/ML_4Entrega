-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: markatze
-- ------------------------------------------------------
-- Server version	8.0.39

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `produktuak`
--

DROP TABLE IF EXISTS `produktuak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produktuak` (
  `id` int NOT NULL AUTO_INCREMENT,
  `izena` varchar(100) DEFAULT NULL,
  `mota` varchar(50) DEFAULT NULL,
  `prezioa` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produktuak`
--

LOCK TABLES `produktuak` WRITE;
/*!40000 ALTER TABLE `produktuak` DISABLE KEYS */;
INSERT INTO `produktuak` VALUES (1,'Ordenagailu eramangarria','Elektronika',799.99),(2,'Mahaigaineko ordenagailua','Elektronika',1200.00),(3,'Sagua','Osagarriak',25.50),(4,'Teklatua','Osagarriak',45.99),(5,'Kable HDMI','Osagarriak',12.99),(6,'USB memoria 32GB','Biltegiratzea',15.00),(7,'USB memoria 64GB','Biltegiratzea',22.50),(8,'Kanpoko disko gogorra 1TB','Biltegiratzea',59.99),(9,'Kanpoko disko gogorra 2TB','Biltegiratzea',89.99),(10,'Erabilitako ordenagailua','Elektronika',499.99),(11,'Pantaila 24 hazbeteko','Elektronika',150.00),(12,'Pantaila 27 hazbeteko','Elektronika',220.00),(13,'Erabilitako pantaila','Elektronika',85.00),(14,'Ordenagailu eramangarria berritua','Elektronika',650.00),(15,'Mahaigain berritua','Elektronika',950.00),(16,'Bateriadun sagua','Osagarriak',30.00),(17,'Erabilitako teklatua','Osagarriak',20.00),(18,'WiFi egokigailua','Osagarriak',15.00),(19,'Audio bozgorailuak','Osagarriak',50.00),(20,'Mikrofonoa','Osagarriak',35.00),(21,'Zorro eramangarria','Osagarriak',25.00),(22,'Ordenagailu eramangarri zaharra','Elektronika',299.99),(23,'Egonkortzaile elektrikoa','Osagarriak',40.00),(24,'Ordenagailu monitorea','Elektronika',180.00),(25,'Erabilitako kablea','Osagarriak',5.00),(26,'Bateria eramangarria','Elektronika',55.00),(27,'Kargagailu unibertsala','Elektronika',20.00),(28,'Gamepad-a','Osagarriak',40.50),(29,'Kanpoko SSD 512GB','Biltegiratzea',70.00),(30,'Kanpoko SSD 1TB','Biltegiratzea',120.00),(31,'eeeeeeeeeeeeeeeeeeeeeeeee','Elektronika',3.00),(35,'grfvdgrccc','Osagarriak',545.00),(36,'grfvdgrccc','Osagarriak',545.00);
/*!40000 ALTER TABLE `produktuak` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-29 15:45:57

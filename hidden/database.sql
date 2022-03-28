-- MariaDB dump 10.19  Distrib 10.5.13-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: shop
-- ------------------------------------------------------
-- Server version	10.5.13-MariaDB

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
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kunden_id` int(10) NOT NULL,
  `ordered` tinyint(1) NOT NULL DEFAULT 0,
  `ordered_date` datetime DEFAULT NULL,
  `sent` tinyint(1) NOT NULL DEFAULT 0,
  `sent_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kunden_id` (`kunden_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`kunden_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,1,0,NULL,0,NULL),(4,2,0,NULL,0,NULL),(6,3,0,NULL,0,NULL),(7,5,0,NULL,0,NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_group`
--

DROP TABLE IF EXISTS `permission_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_group` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `showUser` tinyint(1) NOT NULL DEFAULT 0,
  `modifyUser` tinyint(1) NOT NULL DEFAULT 0,
  `deleteUser` tinyint(1) NOT NULL DEFAULT 0,
  `showUserPerms` tinyint(1) NOT NULL DEFAULT 0,
  `modifyUserPerms` tinyint(1) NOT NULL DEFAULT 0,
  `showProduct` tinyint(1) NOT NULL DEFAULT 0,
  `createProduct` tinyint(1) NOT NULL DEFAULT 0,
  `modifyProduct` tinyint(1) NOT NULL DEFAULT 0,
  `showCategories` tinyint(1) NOT NULL DEFAULT 0,
  `modifyCategories` tinyint(1) NOT NULL DEFAULT 0,
  `deleteCategories` tinyint(1) NOT NULL DEFAULT 0,
  `createCategories` tinyint(1) NOT NULL DEFAULT 0,
  `showOrders` tinyint(1) NOT NULL DEFAULT 0,
  `markOrders` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_group`
--

LOCK TABLES `permission_group` WRITE;
/*!40000 ALTER TABLE `permission_group` DISABLE KEYS */;
INSERT INTO `permission_group` VALUES (1,'default',0,0,0,0,0,0,0,0,0,0,0,0,0,0),(2,'admin',1,1,1,1,1,1,1,1,1,1,1,1,1,1),(3,'employee',1,0,0,0,0,1,1,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `permission_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_images` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `img` varchar(255) NOT NULL,
  `product_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_images`
--

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` VALUES (1,'RTX3080_TI.jpg',2),(2,'RTX3070_TI.jpg',2),(3,'test.jpg',1),(4,'RTX3070_TI.jpg',3),(5,'RTX3080_TI.jpg',6),(6,'RTX3070.jpg',4),(7,'RTX3070.jpg',4),(8,'test.jpg',7),(9,'High-end-monitor.jpg',8),(10,'CapOwhpQaQn8MquiO5nNNe.webp',8),(11,'test.jpg',9),(12,'RTX3070_TI.jpg',10),(13,'CapOwhpQaQn8MquiO5nNNe.webp',11);
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_list`
--

DROP TABLE IF EXISTS `product_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_list` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `list_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `list_id` (`list_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_list_ibfk_1` FOREIGN KEY (`list_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `product_list_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_list`
--

LOCK TABLES `product_list` WRITE;
/*!40000 ALTER TABLE `product_list` DISABLE KEYS */;
INSERT INTO `product_list` VALUES (1,1,1,10),(2,1,2,200),(40,1,3,100),(46,1,5,6),(47,4,2,3),(50,6,2,199),(55,6,3,2),(56,6,4,2),(57,1,8,5),(58,6,11,1);
/*!40000 ALTER TABLE `product_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `desc` mediumtext NOT NULL,
  `product_type_id` int(10) NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `rrp` decimal(7,2) NOT NULL DEFAULT 0.00,
  `quantity` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `visible` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `product_type_id` (`product_type_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`product_type_id`) REFERENCES `products_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Test','Test Description',100000,10.00,0.00,20,'2022-02-07 15:24:08','2022-03-23 21:13:16',0),(2,'RTX 3080 TI','Ist der Hammer und nicht überteuert',54,1500.00,900.00,200,'2022-02-10 05:38:03','2022-03-12 19:42:41',1),(3,'RTX 3070 TI','Ist der Hammer',54,1500.00,900.00,200,'2022-02-10 05:38:19','2022-03-12 19:43:13',1),(4,'RTX 3070','Ist der Hammer',54,1500.00,900.00,19,'2022-02-10 05:38:39','2022-03-12 19:43:13',1),(5,'Uhr','Ist der Hammer',100000,120.00,140.00,6,'2022-02-10 05:39:19','2022-03-23 21:13:16',1),(6,'RTX 3060','Ist der Hammer und nicht überteuert',54,1500.00,900.00,5,'2022-03-06 05:38:03','2022-03-12 19:43:13',1),(7,'Test','Test Description',100000,10.00,0.00,0,'2022-02-07 15:24:08','2022-03-23 21:13:16',1),(8,'Classic Vintage Monitor','Best Device ever.',106,1099.99,1099.99,5,'2022-03-13 19:03:15','2022-03-13 19:03:15',1),(9,'Test2','Test2 Description',100000,10.00,0.00,0,'2022-02-07 15:24:08','2022-03-23 21:13:16',1),(10,'RTX 307023 TI','Ist der Hammer',54,1500.00,900.00,200,'2022-03-31 04:38:19','2022-04-01 18:43:13',1),(11,'Rick Astley\'s Mikrofon','This Mikrofon never gonna gives you up',252,69420.00,69421.00,24,'2022-03-23 07:57:08','2022-03-23 07:57:08',1);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_types`
--

DROP TABLE IF EXISTS `products_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_types` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100001 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products_types`
--

LOCK TABLES `products_types` WRITE;
/*!40000 ALTER TABLE `products_types` DISABLE KEYS */;
INSERT INTO `products_types` VALUES (1,0,'Hardware','2022-02-07 15:22:54','2022-03-12 19:32:20'),(2,0,'Monitore','2022-03-12 19:39:16','2022-03-12 19:40:58'),(3,0,'Peripherie','2022-03-12 19:49:04','2022-03-12 19:49:04'),(4,0,'Netzwerktechnik','2022-03-12 19:53:02','2022-03-12 19:53:02'),(5,0,'Audio','2022-03-12 19:56:55','2022-03-12 19:56:55'),(50,1,'Arbeitsspeicher','2022-03-11 11:34:41','2022-03-12 19:39:38'),(51,1,'CPUs','2022-03-11 11:34:57','2022-03-12 19:39:43'),(52,1,'CPU Kühler','2022-03-11 11:43:53','2022-03-12 19:39:48'),(53,1,'Festplatten & SSDs','2022-03-11 11:43:53','2022-03-12 19:39:54'),(54,1,'Grafikkarten','2022-02-10 05:36:35','2022-03-12 19:39:59'),(55,1,'Laufwerke','2022-03-11 11:43:53','2022-03-12 19:41:10'),(56,1,'Mainboards','2022-03-11 11:43:53','2022-03-12 19:41:17'),(57,1,'Netzteile','2022-03-11 11:43:53','2022-03-12 19:41:24'),(58,1,'Gehäuse','2022-03-11 11:43:53','2022-03-12 19:41:45'),(59,1,'Kühlung','2022-03-11 11:43:53','2022-03-12 19:41:54'),(60,1,'Serverschrank','2022-03-11 11:43:53','2022-03-12 19:42:10'),(100,2,'24 Zoll','2022-03-11 11:43:53','2022-03-12 19:44:03'),(101,2,'27 Zoll','2022-03-11 11:43:53','2022-03-12 19:49:50'),(102,2,'32 Zoll','2022-03-11 11:43:53','2022-03-12 19:49:57'),(103,2,'34 Zoll','2022-03-11 11:43:53','2022-03-12 19:49:57'),(104,2,'49 Zoll','2022-03-11 11:43:53','2022-03-12 19:49:57'),(105,2,'Monitorzubehör','2022-03-11 11:43:53','2022-03-13 18:59:58'),(106,2,'High-End','2022-03-13 19:00:09','2022-03-13 19:00:09'),(150,3,'Office-Mäuse','2022-03-11 11:43:53','2022-03-12 19:52:34'),(151,3,'Gaming-Mäuse','2022-03-11 11:43:53','2022-03-12 19:52:26'),(152,3,'Mauspads','2022-03-11 11:43:53','2022-03-12 19:51:34'),(153,3,'Office-Tastaturen','2022-03-11 11:43:53','2022-03-12 19:51:46'),(154,3,'Gaming-Tastaturen','2022-03-11 11:43:53','2022-03-12 19:51:53'),(155,3,'Joystick','2022-03-11 11:43:53','2022-03-12 19:52:03'),(156,3,'Lenkräder','2022-03-11 11:43:53','2022-03-12 19:52:12'),(157,3,'Controller','2022-03-11 11:43:53','2022-03-12 19:52:47'),(158,3,'USB-Hubs','2022-03-11 11:43:53','2022-03-12 19:55:37'),(200,4,'Access-Points','2022-03-11 11:43:53','2022-03-12 19:53:20'),(201,4,'Bluetooth Adapter','2022-03-11 11:43:53','2022-03-12 19:53:29'),(202,4,'Netzwerkswitches','2022-03-11 11:43:53','2022-03-12 19:53:47'),(203,4,'Router','2022-03-11 11:43:53','2022-03-12 19:54:01'),(204,4,'WLAN Repeater','2022-03-11 11:43:53','2022-03-12 19:54:12'),(250,5,'Headsets','2022-03-11 11:43:53','2022-03-12 19:55:49'),(251,5,'Kopfhörer','2022-03-11 11:43:53','2022-03-12 19:55:59'),(252,5,'Mikrofone','2022-03-11 11:43:53','2022-03-12 19:56:06'),(253,5,'Lautsprecher','2022-03-11 11:43:53','2022-03-12 19:56:15'),(254,5,'Soundbar','2022-03-11 11:43:53','2022-03-12 19:56:24'),(255,5,'Soundkarten','2022-03-11 11:43:53','2022-03-12 19:56:29'),(99998,0,'To be Removed','2022-03-12 20:49:43','2022-03-12 20:50:11'),(100000,99998,'test','2022-03-23 20:03:10','2022-03-23 21:13:39');
/*!40000 ALTER TABLE `products_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `securitytokens`
--

DROP TABLE IF EXISTS `securitytokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `securitytokens` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `securitytoken` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `securitytokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `securitytokens`
--

LOCK TABLES `securitytokens` WRITE;
/*!40000 ALTER TABLE `securitytokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `securitytokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `passwort` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vorname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `nachname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `passwortcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `passwortcode_time` timestamp NULL DEFAULT NULL,
  `permission_group` int(10) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `permission_group` (`permission_group`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'test@test.com','$2y$10$SfhYIDtn.iOuCW7zfoFLuuZHX6lja4lF4XA4JqNmpiH/.P3zB8JCa','Vorname','Nachname','2022-02-04 07:57:26','2022-03-12 22:23:31',NULL,NULL,1),(2,'ich@paul-vassen.de','$2y$10$AjGihIboyCYY/gnDq7J08.spp4N6Du.wog2anlhRsFALSZj9DPrPq','Paul','Vaßen','2022-02-04 15:34:37','2022-03-21 11:08:26',NULL,NULL,2),(3,'jan@schniebs.com','$2y$10$xlYaMlJc0JLTBAhHLrgC5.Y1ECi5y8IbxBY74W4nzCmuNLio.NwFO','Jan','Schniebs','2022-02-23 07:14:00','2022-03-21 11:06:26',NULL,NULL,2),(5,'g.einkaufstute@edeka.de','$2y$10$unifQHy15eQr./VQXD1lj.Zouy/HURsgZYUtbUNy0VDA/mtrqrf8i','Gerhard','Einkaufstüte','2022-02-23 09:36:25','2022-02-23 09:36:25',NULL,NULL,1);
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

-- Dump completed on 2022-03-28 17:11:23

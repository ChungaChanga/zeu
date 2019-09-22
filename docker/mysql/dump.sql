-- MySQL dump 10.13  Distrib 5.7.27, for Linux (x86_64)
--
-- Host: localhost    Database: zeu
-- ------------------------------------------------------
-- Server version	5.7.27

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` VALUES ('admin','1',1569175411),('proxyEditor','2',1569179601);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('admin',1,NULL,NULL,NULL,1568828734,1568828734),('handleProxy',2,'Handle a proxy',NULL,NULL,1568828733,1568828733),('handleUser',2,'Handle a users',NULL,NULL,1568828733,1568828733),('proxyEditor',1,NULL,NULL,NULL,1568828733,1568828733);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` VALUES ('proxyEditor','handleProxy'),('admin','handleUser'),('admin','proxyEditor');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1568828703),('m140506_102106_rbac_init',1568828707),('m170907_052038_rbac_add_index_on_auth_assignment_user_id',1568828708),('m180523_151638_rbac_updates_indexes_without_prefix',1568828709);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proxy`
--

DROP TABLE IF EXISTS `proxy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proxy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_hash` int(11) unsigned DEFAULT NULL,
  `port` smallint(6) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-proxy-ip_hash-port` (`ip_hash`,`port`),
  KEY `idx-proxy-port` (`port`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proxy`
--

LOCK TABLES `proxy` WRITE;
/*!40000 ALTER TABLE `proxy` DISABLE KEYS */;
INSERT INTO `proxy` VALUES (1,0,0),(19,154907662,59838),(101,169042677,37986),(104,202836995,45),(94,216562854,21416),(3,311695738,3833),(86,321978526,48200),(31,338543433,40179),(54,356960827,37579),(51,397412472,52103),(46,431911762,57228),(95,451973604,26993),(48,499102996,36253),(34,499507239,29577),(5,512051218,39071),(22,532638706,63924),(79,584524993,58847),(38,630762659,42392),(82,673259985,22975),(47,734387411,21490),(50,828046988,39399),(53,830016774,33765),(69,846819046,31403),(17,886936116,49297),(36,1052041019,10651),(12,1052348992,26827),(75,1129280980,4886),(85,1149228892,45651),(71,1149879007,42519),(43,1154621633,44174),(33,1187489148,41519),(70,1255987508,11530),(15,1279979718,33433),(30,1285727035,47056),(90,1327893165,50461),(32,1382951257,5320),(66,1430827846,12873),(27,1463250369,44526),(62,1551706519,56084),(18,1611660742,21492),(63,1637176401,57759),(72,1641548750,43065),(14,1676494071,4862),(55,1701452812,55867),(20,1712754453,40005),(40,1754715551,37999),(16,1851195036,23770),(98,1865999484,58441),(4,1873785556,33311),(64,1942237237,16453),(76,2126612238,2835),(37,2181735563,60498),(6,2236045483,6536),(84,2254395093,45506),(58,2259615506,53792),(11,2332879111,18684),(65,2349707268,30709),(28,2439918068,26021),(44,2457695896,34300),(89,2482334258,61204),(24,2592511099,62952),(88,2646040566,41583),(7,2664333535,40438),(56,2755560134,54837),(23,2790483010,48520),(93,2830853128,36222),(25,2832317958,1989),(81,2904477660,42725),(42,2907787731,28952),(26,2997266379,43853),(87,3127102693,34050),(74,3129950703,45294),(68,3153861057,59590),(97,3155584097,50341),(83,3184450016,5351),(103,3229158401,313),(102,3231282252,27402),(77,3232269578,62979),(61,3267228986,3144),(10,3271341997,11887),(8,3293692946,16420),(45,3340974319,5781),(96,3418645410,37048),(35,3455442167,18856),(100,3511217378,18218),(39,3600751918,8709),(29,3654496651,20947),(13,3665557807,61822),(41,3713003267,37492),(80,3801550408,22624),(59,3815034844,49688),(9,3824410344,17714),(99,3970428899,13248),(49,3975742401,33342),(67,4017332958,17479),(78,4066152901,5785),(91,4072848516,5062),(57,4095355780,40074),(52,4097039586,26355),(60,4110873621,58675),(73,4116724107,34840),(92,4124889949,9291),(21,4144224322,21148),(2,4294967295,65535);
/*!40000 ALTER TABLE `proxy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `auth_key` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Admin','admin@mail.zz','$2y$13$Kfj368MZam02O9CjA0LynuYk.NYmt4IM5y.H89UQl3OZGpzR4X0BW','MCOpsQTHZNUIl9dgXR17NiuqsfVKv6mV'),(2,'FirstEditor','fedit@mail.zz','$2y$13$Kfj368MZam02O9CjA0LynuYk.NYmt4IM5y.H89UQl3OZGpzR4X0BW','u-ofH6Tx6rRgRg-vh6DYmsxuyYaBB6tc');
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

-- Dump completed on 2019-09-22 19:20:31

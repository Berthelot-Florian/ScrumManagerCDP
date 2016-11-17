-- MySQL dump 10.13  Distrib 5.7.16, for Linux (x86_64)
--
-- Host: localhost    Database: scma
-- ------------------------------------------------------
-- Server version	5.7.16-0ubuntu0.16.04.1

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
-- Table structure for table `Annex`
--

DROP TABLE IF EXISTS `Annexe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Annexe` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `project` smallint(6) NOT NULL,
  `name` varchar(32) NOT NULL,
  `type` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project` (`project`),
  CONSTRAINT `Annexe_ibfk_1` FOREIGN KEY (`project`) REFERENCES `Project` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Annex`
--

LOCK TABLES `Annex` WRITE;
/*!40000 ALTER TABLE `Annex` DISABLE KEYS */;
/*!40000 ALTER TABLE `Annex` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ContributorProject`
--

DROP TABLE IF EXISTS `ContributorProject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ContributorProject` (
  `contributor` smallint(6) NOT NULL,
  `project` smallint(6) NOT NULL,
  PRIMARY KEY (`contributor`,`project`),
  KEY `project` (`project`),
  CONSTRAINT `ContributorProject_ibfk_1` FOREIGN KEY (`contributor`) REFERENCES `Users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ContributorProject_ibfk_2` FOREIGN KEY (`project`) REFERENCES `Project` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ContributorProject`
--

LOCK TABLES `ContributorProject` WRITE;
/*!40000 ALTER TABLE `ContributorProject` DISABLE KEYS */;
/*!40000 ALTER TABLE `ContributorProject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ContributorTask`
--

DROP TABLE IF EXISTS `ContributorTask`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ContributorTask` (
  `contributor` smallint(6) NOT NULL,
  `task` smallint(6) NOT NULL,
  PRIMARY KEY (`contributor`,`task`),
  KEY `task` (`task`),
  CONSTRAINT `ContributorTask_ibfk_1` FOREIGN KEY (`contributor`) REFERENCES `Users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ContributorTask_ibfk_2` FOREIGN KEY (`task`) REFERENCES `Task` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ContributorTask`
--

LOCK TABLES `ContributorTask` WRITE;
/*!40000 ALTER TABLE `ContributorTask` DISABLE KEYS */;
/*!40000 ALTER TABLE `ContributorTask` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Project`
--

DROP TABLE IF EXISTS `Project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Project` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `scrummaster` smallint(6) NOT NULL,
  `productowner` smallint(6) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `scrummaster` (`scrummaster`),
  KEY `productowner` (`productowner`),
  CONSTRAINT `Project_ibfk_1` FOREIGN KEY (`scrummaster`) REFERENCES `Users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `Project_ibfk_2` FOREIGN KEY (`productowner`) REFERENCES `Users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Project`
--

LOCK TABLES `Project` WRITE;
/*!40000 ALTER TABLE `Project` DISABLE KEYS */;
/*!40000 ALTER TABLE `Project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Sprint`
--

DROP TABLE IF EXISTS `Sprint`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Sprint` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `number` smallint(6) NOT NULL,
  `project` smallint(6) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project` (`project`),
  CONSTRAINT `Sprint_ibfk_1` FOREIGN KEY (`project`) REFERENCES `Project` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Sprint`
--

LOCK TABLES `Sprint` WRITE;
/*!40000 ALTER TABLE `Sprint` DISABLE KEYS */;
/*!40000 ALTER TABLE `Sprint` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Task`
--

DROP TABLE IF EXISTS `Task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Task` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `project` smallint(6) NOT NULL,
  `description` text,
  `effort` smallint(6) DEFAULT NULL,
  `sprint` smallint(6) DEFAULT NULL,
  `state` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project` (`project`),
  KEY `sprint` (`sprint`),
  CONSTRAINT `Task_ibfk_1` FOREIGN KEY (`project`) REFERENCES `Project` (`id`) ON DELETE CASCADE,
  CONSTRAINT `Task_ibfk_2` FOREIGN KEY (`sprint`) REFERENCES `Sprint` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Task`
--

LOCK TABLES `Task` WRITE;
/*!40000 ALTER TABLE `Task` DISABLE KEYS */;
/*!40000 ALTER TABLE `Task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UserStory`
--

DROP TABLE IF EXISTS `UserStory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserStory` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `project` smallint(6) NOT NULL,
  `rank` varchar(32) NOT NULL,
  `action` varchar(32) NOT NULL,
  `goal` varchar(32) NOT NULL,
  `priority` smallint(6) ,
  `difficulty` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project` (`project`),
  CONSTRAINT `UserStory_ibfk_1` FOREIGN KEY (`project`) REFERENCES `Project` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserStory`
--

LOCK TABLES `UserStory` WRITE;
/*!40000 ALTER TABLE `UserStory` DISABLE KEYS */;
/*!40000 ALTER TABLE `UserStory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `login` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `pseudo` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (1,'Toto','f71dbe52628a3f83a77ab494817525c6','toto','toto');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-09 22:18:37

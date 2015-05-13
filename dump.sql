CREATE DATABASE  IF NOT EXISTS `projects` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `projects`;
-- MySQL dump 10.13  Distrib 5.6.23, for Win64 (x86_64)
--
-- Host: localhost    Database: projects
-- ------------------------------------------------------
-- Server version	5.6.15-log

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
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `max_projects` int(11) DEFAULT '25',
  `private_allowed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'tester','test@test.com','ee26b0dd4af7e749aa1a8ee3c10ae9923f618980772e473f8819a5d4940e0db27ac185f8a0e1d5f84f88bc887fd67b143732c304cc5fa9ad8e6f57f50028a8ff','0dbr5ns38lluu0udp5hsco88l4',25,0),(4,'testers','test@test.co','178048c4eb33ae72df54da8dfccc496edba73d9ac82745f65a9493e1d9931b23ee12467b09cbe3aadf6f0f36ebaa0b7c33ea68692e1abefcf0fc9e755cc7d3fe','js9650g91r5jecrqittfmiss23',25,0);
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `code`
--

DROP TABLE IF EXISTS `code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_name` varchar(45) NOT NULL,
  `manager` int(11) DEFAULT NULL,
  `code` longtext,
  `private` tinyint(1) DEFAULT '0',
  `edit_level` tinyint(1) DEFAULT '0',
  `language` varchar(255) DEFAULT 'javascript',
  `hasBackups` tinyint(1) DEFAULT '0',
  `numberOfBackups` int(11) DEFAULT '20',
  `backupAfterSyncs` int(11) DEFAULT '10',
  `syncAfter` int(11) DEFAULT '25',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `code`
--

LOCK TABLES `code` WRITE;
/*!40000 ALTER TABLE `code` DISABLE KEYS */;
INSERT INTO `code` VALUES (1,'asdf',NULL,'this does shit lol pls save yes. alkdjfl\nalsdkjf\nalksdjfalksdjfadfasdfkljaldkfjlkj',0,0,'javascript',NULL,NULL,10,25),(2,'conn',NULL,'function code() {\n    doign some random stuff lol pls work i dont work lol im just going to type random stuff to try and test if this will keep saving and it looks like it does fk yes ima firing my lazer\n    asdfkja\n    dfasdlkfjad\n    fads\n    fasflk4j1435\n    151\n    5jklafjsdfa\n    sdfaksdjfasd\n    falsdjkfasd\n}',0,0,'javascript',NULL,NULL,10,25),(3,'new',NULL,'function stuff() {\n    for(var i = 0; i < 5; i++) {\n        console.log(i);\n    }\n}\n\nstuasdfkajlsdkfjlakjsasdfkljasldkfjalksjdflkajj',0,1,'javascript',1,5,10,25),(4,'new1',NULL,'',0,0,'javascript',NULL,NULL,10,25);
/*!40000 ALTER TABLE `code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `code_backups`
--

DROP TABLE IF EXISTS `code_backups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `code_backups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) DEFAULT NULL,
  `code` longtext,
  `date` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=158 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `code_backups`
--

LOCK TABLES `code_backups` WRITE;
/*!40000 ALTER TABLE `code_backups` DISABLE KEYS */;
INSERT INTO `code_backups` VALUES (156,3,'function stuff() {\n    for(var i = 0; i < 5; i++) {\n        console.log(i);\n    }\n}\n\nstuasdfkajlsdkfjlakjsasdlfkjalsdkjflkasdjflkajsdlkfjlaksdjflkajsdlfkjaslkdfjlaksdjflaksdjflkajsdlkfjalksdjflaksjdflk','1431118890827'),(157,3,'function stuff() {\n    for(var i = 0; i < 5; i++) {\n        console.log(i);\n    }\n}\n\nstuasdfkajlsdkfjlakjsasdlfkjalsdkjflkasdjflkajsdlkfjlaksdjflkajsdlfkjaslkdfjlaksdjflaksdjflkajsdlkfjalksdjflaksjdflkajsldkfjlaksdjflkajsdlkfjalskdjfl','1431118892197'),(154,3,'function stuff() {\n    for(var i = 0; i < 5; i++) {\n        console.log(i);\n    }\n}\n\nstuasdfkajlsdkfjlakjsasdlfkjalsdkjflkasdjflkajsdlkf','1431118888105'),(155,3,'function stuff() {\n    for(var i = 0; i < 5; i++) {\n        console.log(i);\n    }\n}\n\nstuasdfkajlsdkfjlakjsasdlfkjalsdkjflkasdjflkajsdlkfjlaksdjflkajsdlfkjaslkdfjlaksdjfl','1431118889526'),(153,3,'function stuff() {\n    for(var i = 0; i < 5; i++) {\n        console.log(i);\n    }\n}\n\nstuasdfkajlsdkfjlakjsdlkajldskjfalksdjflkajsdlkfjalksdjflaksjdflkajsdlkfjalksdjflkajsdflkjalksdfjlkajsdflkjasdlkfjalksdjflkajsdlfkjalksdjflkasjdfasldkfjalskdjflkajsdlfkjjjjjjjlkjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjalsdkfjal','1431118860715');
/*!40000 ALTER TABLE `code_backups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file_auths`
--

DROP TABLE IF EXISTS `file_auths`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `file_auths` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file_auths`
--

LOCK TABLES `file_auths` WRITE;
/*!40000 ALTER TABLE `file_auths` DISABLE KEYS */;
INSERT INTO `file_auths` VALUES (1,1,4,1),(2,2,4,0);
/*!40000 ALTER TABLE `file_auths` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file_backups`
--

DROP TABLE IF EXISTS `file_backups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `file_backups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) DEFAULT NULL,
  `code` longtext,
  `date` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file_backups`
--

LOCK TABLES `file_backups` WRITE;
/*!40000 ALTER TABLE `file_backups` DISABLE KEYS */;
/*!40000 ALTER TABLE `file_backups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file_contribution`
--

DROP TABLE IF EXISTS `file_contribution`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `file_contribution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `actions` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file_contribution`
--

LOCK TABLES `file_contribution` WRITE;
/*!40000 ALTER TABLE `file_contribution` DISABLE KEYS */;
/*!40000 ALTER TABLE `file_contribution` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `folder_id` int(11) DEFAULT NULL,
  `edit_level` tinyint(1) DEFAULT '0',
  `language` varchar(45) DEFAULT NULL,
  `extension` varchar(45) DEFAULT '.file',
  `private` tinyint(1) DEFAULT '0',
  `numberOfBackups` int(11) DEFAULT '5',
  `backupAfterSyncs` int(11) DEFAULT '10',
  `syncAfter` int(11) DEFAULT '25',
  `code` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` VALUES (1,'test',1,1,'javascript','js',0,5,10,25,'randomly testing shit pls '),(2,'code',5,1,'javascript','js',0,5,10,25,'fucking work pls'),(6,'test',3,0,'javascript','js',0,5,10,25,NULL);
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `folders`
--

DROP TABLE IF EXISTS `folders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `folders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `folder_name` varchar(45) DEFAULT NULL,
  `folder_parent_id` int(11) DEFAULT NULL,
  `has_child` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `folders`
--

LOCK TABLES `folders` WRITE;
/*!40000 ALTER TABLE `folders` DISABLE KEYS */;
INSERT INTO `folders` VALUES (1,1,'test',NULL,0),(2,1,'test2',1,0),(3,1,'outer',NULL,1),(4,1,'inner',3,1);
/*!40000 ALTER TABLE `folders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `old_deltas`
--

DROP TABLE IF EXISTS `old_deltas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `old_deltas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) DEFAULT NULL,
  `deltas` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `old_deltas`
--

LOCK TABLES `old_deltas` WRITE;
/*!40000 ALTER TABLE `old_deltas` DISABLE KEYS */;
/*!40000 ALTER TABLE `old_deltas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_auths`
--

DROP TABLE IF EXISTS `project_auths`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_auths` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `level` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_auths`
--

LOCK TABLES `project_auths` WRITE;
/*!40000 ALTER TABLE `project_auths` DISABLE KEYS */;
INSERT INTO `project_auths` VALUES (1,4,1,1);
/*!40000 ALTER TABLE `project_auths` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_contribution`
--

DROP TABLE IF EXISTS `project_contribution`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_contribution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `actions` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_contribution`
--

LOCK TABLES `project_contribution` WRITE;
/*!40000 ALTER TABLE `project_contribution` DISABLE KEYS */;
INSERT INTO `project_contribution` VALUES (1,1,4,154);
/*!40000 ALTER TABLE `project_contribution` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `edit_level` tinyint(1) DEFAULT '0',
  `private` tinyint(1) DEFAULT '0',
  `manager_id` int(11) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'test',1,0,4,'This is some random description that is kinda long.'),(2,'Code Collaboration',1,0,4,'Code Collaboration Project.');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-05-13 11:04:12

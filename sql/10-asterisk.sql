-- MySQL dump 10.16  Distrib 10.1.36-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: asterisk
-- ------------------------------------------------------
-- Server version	10.1.36-MariaDB

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
-- Table structure for table `audio_store_details`
--
USE asterisk;

DROP TABLE IF EXISTS `audio_store_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audio_store_details` (
  `audio_filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `audio_format` varchar(10) COLLATE utf8_unicode_ci DEFAULT 'unknown',
  `audio_filesize` bigint(20) unsigned DEFAULT '0',
  `audio_epoch` bigint(20) unsigned DEFAULT '0',
  `audio_length` int(10) unsigned DEFAULT '0',
  UNIQUE KEY `audio_filename` (`audio_filename`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audio_store_details`
--

LOCK TABLES `audio_store_details` WRITE;
/*!40000 ALTER TABLE `audio_store_details` DISABLE KEYS */;
INSERT INTO `audio_store_details` VALUES ('go_press_1.wav','wav',296444,1459457431,19);
/*!40000 ALTER TABLE `audio_store_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `call_log`
--

DROP TABLE IF EXISTS `call_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `call_log` (
  `uniqueid` varchar(20) NOT NULL,
  `channel` varchar(100) DEFAULT NULL,
  `channel_group` varchar(30) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `server_ip` varchar(15) DEFAULT NULL,
  `extension` varchar(100) DEFAULT NULL,
  `number_dialed` varchar(15) DEFAULT NULL,
  `caller_code` varchar(20) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `start_epoch` int(10) DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `end_epoch` int(10) DEFAULT NULL,
  `length_in_sec` int(10) DEFAULT NULL,
  `length_in_min` double(8,2) DEFAULT NULL,
  PRIMARY KEY (`uniqueid`),
  KEY `caller_code` (`caller_code`),
  KEY `server_ip` (`server_ip`),
  KEY `channel` (`channel`),
  KEY `start_time` (`start_time`),
  KEY `end_time` (`end_time`),
  KEY `time` (`start_time`,`end_time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `call_log`
--

LOCK TABLES `call_log` WRITE;
/*!40000 ALTER TABLE `call_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `call_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `call_log_archive`
--

DROP TABLE IF EXISTS `call_log_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `call_log_archive` (
  `uniqueid` varchar(20) NOT NULL,
  `channel` varchar(100) DEFAULT NULL,
  `channel_group` varchar(30) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `server_ip` varchar(15) DEFAULT NULL,
  `extension` varchar(100) DEFAULT NULL,
  `number_dialed` varchar(15) DEFAULT NULL,
  `caller_code` varchar(20) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `start_epoch` int(10) DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `end_epoch` int(10) DEFAULT NULL,
  `length_in_sec` int(10) DEFAULT NULL,
  `length_in_min` double(8,2) DEFAULT NULL,
  PRIMARY KEY (`uniqueid`),
  KEY `caller_code` (`caller_code`),
  KEY `server_ip` (`server_ip`),
  KEY `channel` (`channel`),
  KEY `start_time` (`start_time`),
  KEY `end_time` (`end_time`),
  KEY `time` (`start_time`,`end_time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `call_log_archive`
--

LOCK TABLES `call_log_archive` WRITE;
/*!40000 ALTER TABLE `call_log_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `call_log_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `callcard_accounts`
--

DROP TABLE IF EXISTS `callcard_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `callcard_accounts` (
  `card_id` varchar(20) NOT NULL,
  `pin` varchar(10) NOT NULL,
  `status` enum('GENERATE','PRINT','SHIP','HOLD','ACTIVE','USED','EMPTY','CANCEL','VOID') DEFAULT 'GENERATE',
  `balance_minutes` smallint(5) DEFAULT '3',
  `inbound_group_id` varchar(20) DEFAULT '',
  PRIMARY KEY (`card_id`),
  KEY `pin` (`pin`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `callcard_accounts`
--

LOCK TABLES `callcard_accounts` WRITE;
/*!40000 ALTER TABLE `callcard_accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `callcard_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `callcard_accounts_details`
--

DROP TABLE IF EXISTS `callcard_accounts_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `callcard_accounts_details` (
  `card_id` varchar(20) NOT NULL,
  `run` varchar(4) DEFAULT '',
  `batch` varchar(5) DEFAULT '',
  `pack` varchar(5) DEFAULT '',
  `sequence` varchar(5) DEFAULT '',
  `status` enum('GENERATE','PRINT','SHIP','HOLD','ACTIVE','USED','EMPTY','CANCEL','VOID') DEFAULT 'GENERATE',
  `balance_minutes` smallint(5) DEFAULT '3',
  `initial_value` varchar(6) DEFAULT '0.00',
  `initial_minutes` smallint(5) DEFAULT '3',
  `note_purchase_order` varchar(20) DEFAULT '',
  `note_printer` varchar(20) DEFAULT '',
  `note_did` varchar(18) DEFAULT '',
  `inbound_group_id` varchar(20) DEFAULT '',
  `note_language` varchar(10) DEFAULT 'English',
  `note_name` varchar(20) DEFAULT '',
  `note_comments` varchar(255) DEFAULT '',
  `create_user` varchar(20) DEFAULT '',
  `activate_user` varchar(20) DEFAULT '',
  `used_user` varchar(20) DEFAULT '',
  `void_user` varchar(20) DEFAULT '',
  `create_time` datetime DEFAULT NULL,
  `activate_time` datetime DEFAULT NULL,
  `used_time` datetime DEFAULT NULL,
  `void_time` datetime DEFAULT NULL,
  PRIMARY KEY (`card_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `callcard_accounts_details`
--

LOCK TABLES `callcard_accounts_details` WRITE;
/*!40000 ALTER TABLE `callcard_accounts_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `callcard_accounts_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `callcard_log`
--

DROP TABLE IF EXISTS `callcard_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `callcard_log` (
  `uniqueid` varchar(20) NOT NULL,
  `card_id` varchar(20) DEFAULT NULL,
  `balance_minutes_start` smallint(5) DEFAULT '3',
  `call_time` datetime DEFAULT NULL,
  `agent_time` datetime DEFAULT NULL,
  `dispo_time` datetime DEFAULT NULL,
  `agent` varchar(20) DEFAULT '',
  `agent_dispo` varchar(6) DEFAULT '',
  `agent_talk_sec` mediumint(8) DEFAULT '0',
  `agent_talk_min` mediumint(8) DEFAULT '0',
  `phone_number` varchar(18) DEFAULT NULL,
  `inbound_did` varchar(18) DEFAULT NULL,
  PRIMARY KEY (`uniqueid`),
  KEY `card_id` (`card_id`),
  KEY `call_time` (`call_time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `callcard_log`
--

LOCK TABLES `callcard_log` WRITE;
/*!40000 ALTER TABLE `callcard_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `callcard_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cid_channels_recent`
--

DROP TABLE IF EXISTS `cid_channels_recent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cid_channels_recent` (
  `caller_id_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `connected_line_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `server_ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `call_date` datetime DEFAULT NULL,
  `channel` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `dest_channel` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `linkedid` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `dest_uniqueid` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `uniqueid` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  KEY `call_date` (`call_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cid_channels_recent`
--

LOCK TABLES `cid_channels_recent` WRITE;
/*!40000 ALTER TABLE `cid_channels_recent` DISABLE KEYS */;
/*!40000 ALTER TABLE `cid_channels_recent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conferences`
--

DROP TABLE IF EXISTS `conferences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conferences` (
  `conf_exten` int(7) unsigned NOT NULL,
  `server_ip` varchar(15) NOT NULL,
  `extension` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conferences`
--

LOCK TABLES `conferences` WRITE;
/*!40000 ALTER TABLE `conferences` DISABLE KEYS */;
INSERT INTO `conferences` VALUES (8600001,'127.0.0.1',''),(8600002,'127.0.0.1',''),(8600003,'127.0.0.1',''),(8600004,'127.0.0.1',''),(8600005,'127.0.0.1',''),(8600006,'127.0.0.1',''),(8600007,'127.0.0.1',''),(8600008,'127.0.0.1',''),(8600009,'127.0.0.1',''),(8600010,'127.0.0.1',''),(8600011,'127.0.0.1',''),(8600012,'127.0.0.1',''),(8600013,'127.0.0.1',''),(8600014,'127.0.0.1',''),(8600015,'127.0.0.1',''),(8600016,'127.0.0.1',''),(8600017,'127.0.0.1',''),(8600018,'127.0.0.1',''),(8600019,'127.0.0.1',''),(8600020,'127.0.0.1',''),(8600021,'127.0.0.1',''),(8600022,'127.0.0.1',''),(8600023,'127.0.0.1',''),(8600024,'127.0.0.1',''),(8600025,'127.0.0.1',''),(8600026,'127.0.0.1',''),(8600027,'127.0.0.1',''),(8600028,'127.0.0.1',''),(8600029,'127.0.0.1',''),(8600030,'127.0.0.1',''),(8600031,'127.0.0.1',''),(8600032,'127.0.0.1',''),(8600033,'127.0.0.1',''),(8600034,'127.0.0.1',''),(8600035,'127.0.0.1',''),(8600036,'127.0.0.1',''),(8600037,'127.0.0.1',''),(8600038,'127.0.0.1',''),(8600039,'127.0.0.1',''),(8600040,'127.0.0.1',''),(8600041,'127.0.0.1',''),(8600042,'127.0.0.1',''),(8600043,'127.0.0.1',''),(8600044,'127.0.0.1',''),(8600045,'127.0.0.1',''),(8600046,'127.0.0.1',''),(8600047,'127.0.0.1',''),(8600048,'127.0.0.1',''),(8600049,'127.0.0.1',''),(8600001,'127.0.0.1',''),(8600002,'127.0.0.1',''),(8600003,'127.0.0.1',''),(8600004,'127.0.0.1',''),(8600005,'127.0.0.1',''),(8600006,'127.0.0.1',''),(8600007,'127.0.0.1',''),(8600008,'127.0.0.1',''),(8600009,'127.0.0.1',''),(8600010,'127.0.0.1',''),(8600011,'127.0.0.1',''),(8600012,'127.0.0.1',''),(8600013,'127.0.0.1',''),(8600014,'127.0.0.1',''),(8600015,'127.0.0.1',''),(8600016,'127.0.0.1',''),(8600017,'127.0.0.1',''),(8600018,'127.0.0.1',''),(8600019,'127.0.0.1',''),(8600020,'127.0.0.1',''),(8600021,'127.0.0.1',''),(8600022,'127.0.0.1',''),(8600023,'127.0.0.1',''),(8600024,'127.0.0.1',''),(8600025,'127.0.0.1',''),(8600026,'127.0.0.1',''),(8600027,'127.0.0.1',''),(8600028,'127.0.0.1',''),(8600029,'127.0.0.1',''),(8600030,'127.0.0.1',''),(8600031,'127.0.0.1',''),(8600032,'127.0.0.1',''),(8600033,'127.0.0.1',''),(8600034,'127.0.0.1',''),(8600035,'127.0.0.1',''),(8600036,'127.0.0.1',''),(8600037,'127.0.0.1',''),(8600038,'127.0.0.1',''),(8600039,'127.0.0.1',''),(8600040,'127.0.0.1',''),(8600041,'127.0.0.1',''),(8600042,'127.0.0.1',''),(8600043,'127.0.0.1',''),(8600044,'127.0.0.1',''),(8600045,'127.0.0.1',''),(8600046,'127.0.0.1',''),(8600047,'127.0.0.1',''),(8600048,'127.0.0.1',''),(8600049,'127.0.0.1',''),(8600001,'127.0.0.1',''),(8600002,'127.0.0.1',''),(8600003,'127.0.0.1',''),(8600004,'127.0.0.1',''),(8600005,'127.0.0.1',''),(8600006,'127.0.0.1',''),(8600007,'127.0.0.1',''),(8600008,'127.0.0.1',''),(8600009,'127.0.0.1',''),(8600010,'127.0.0.1',''),(8600011,'127.0.0.1',''),(8600012,'127.0.0.1',''),(8600013,'127.0.0.1',''),(8600014,'127.0.0.1',''),(8600015,'127.0.0.1',''),(8600016,'127.0.0.1',''),(8600017,'127.0.0.1',''),(8600018,'127.0.0.1',''),(8600019,'127.0.0.1',''),(8600020,'127.0.0.1',''),(8600021,'127.0.0.1',''),(8600022,'127.0.0.1',''),(8600023,'127.0.0.1',''),(8600024,'127.0.0.1',''),(8600025,'127.0.0.1',''),(8600026,'127.0.0.1',''),(8600027,'127.0.0.1',''),(8600028,'127.0.0.1',''),(8600029,'127.0.0.1',''),(8600030,'127.0.0.1',''),(8600031,'127.0.0.1',''),(8600032,'127.0.0.1',''),(8600033,'127.0.0.1',''),(8600034,'127.0.0.1',''),(8600035,'127.0.0.1',''),(8600036,'127.0.0.1',''),(8600037,'127.0.0.1',''),(8600038,'127.0.0.1',''),(8600039,'127.0.0.1',''),(8600040,'127.0.0.1',''),(8600041,'127.0.0.1',''),(8600042,'127.0.0.1',''),(8600043,'127.0.0.1',''),(8600044,'127.0.0.1',''),(8600045,'127.0.0.1',''),(8600046,'127.0.0.1',''),(8600047,'127.0.0.1',''),(8600048,'127.0.0.1',''),(8600049,'127.0.0.1',''),(8600001,'127.0.0.1',''),(8600002,'127.0.0.1',''),(8600003,'127.0.0.1',''),(8600004,'127.0.0.1',''),(8600005,'127.0.0.1',''),(8600006,'127.0.0.1',''),(8600007,'127.0.0.1',''),(8600008,'127.0.0.1',''),(8600009,'127.0.0.1',''),(8600010,'127.0.0.1',''),(8600011,'127.0.0.1',''),(8600012,'127.0.0.1',''),(8600013,'127.0.0.1',''),(8600014,'127.0.0.1',''),(8600015,'127.0.0.1',''),(8600016,'127.0.0.1',''),(8600017,'127.0.0.1',''),(8600018,'127.0.0.1',''),(8600019,'127.0.0.1',''),(8600020,'127.0.0.1',''),(8600021,'127.0.0.1',''),(8600022,'127.0.0.1',''),(8600023,'127.0.0.1',''),(8600024,'127.0.0.1',''),(8600025,'127.0.0.1',''),(8600026,'127.0.0.1',''),(8600027,'127.0.0.1',''),(8600028,'127.0.0.1',''),(8600029,'127.0.0.1',''),(8600030,'127.0.0.1',''),(8600031,'127.0.0.1',''),(8600032,'127.0.0.1',''),(8600033,'127.0.0.1',''),(8600034,'127.0.0.1',''),(8600035,'127.0.0.1',''),(8600036,'127.0.0.1',''),(8600037,'127.0.0.1',''),(8600038,'127.0.0.1',''),(8600039,'127.0.0.1',''),(8600040,'127.0.0.1',''),(8600041,'127.0.0.1',''),(8600042,'127.0.0.1',''),(8600043,'127.0.0.1',''),(8600044,'127.0.0.1',''),(8600045,'127.0.0.1',''),(8600046,'127.0.0.1',''),(8600047,'127.0.0.1',''),(8600048,'127.0.0.1',''),(8600049,'127.0.0.1',''),(8600001,'127.0.0.1',''),(8600002,'127.0.0.1',''),(8600003,'127.0.0.1',''),(8600004,'127.0.0.1',''),(8600005,'127.0.0.1',''),(8600006,'127.0.0.1',''),(8600007,'127.0.0.1',''),(8600008,'127.0.0.1',''),(8600009,'127.0.0.1',''),(8600010,'127.0.0.1',''),(8600011,'127.0.0.1',''),(8600012,'127.0.0.1',''),(8600013,'127.0.0.1',''),(8600014,'127.0.0.1',''),(8600015,'127.0.0.1',''),(8600016,'127.0.0.1',''),(8600017,'127.0.0.1',''),(8600018,'127.0.0.1',''),(8600019,'127.0.0.1',''),(8600020,'127.0.0.1',''),(8600021,'127.0.0.1',''),(8600022,'127.0.0.1',''),(8600023,'127.0.0.1',''),(8600024,'127.0.0.1',''),(8600025,'127.0.0.1',''),(8600026,'127.0.0.1',''),(8600027,'127.0.0.1',''),(8600028,'127.0.0.1',''),(8600029,'127.0.0.1',''),(8600030,'127.0.0.1',''),(8600031,'127.0.0.1',''),(8600032,'127.0.0.1',''),(8600033,'127.0.0.1',''),(8600034,'127.0.0.1',''),(8600035,'127.0.0.1',''),(8600036,'127.0.0.1',''),(8600037,'127.0.0.1',''),(8600038,'127.0.0.1',''),(8600039,'127.0.0.1',''),(8600040,'127.0.0.1',''),(8600041,'127.0.0.1',''),(8600042,'127.0.0.1',''),(8600043,'127.0.0.1',''),(8600044,'127.0.0.1',''),(8600045,'127.0.0.1',''),(8600046,'127.0.0.1',''),(8600047,'127.0.0.1',''),(8600048,'127.0.0.1',''),(8600049,'127.0.0.1','');
/*!40000 ALTER TABLE `conferences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_information`
--

DROP TABLE IF EXISTS `contact_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_information` (
  `contact_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `last_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `office_num` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `cell_num` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `other_num1` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `other_num2` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `bu_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `department` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `group_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `job_title` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `location` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  PRIMARY KEY (`contact_id`),
  KEY `ci_first_name` (`first_name`),
  KEY `ci_last_name` (`last_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_information`
--

LOCK TABLES `contact_information` WRITE;
/*!40000 ALTER TABLE `contact_information` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dialable_inventory_snapshots`
--

DROP TABLE IF EXISTS `dialable_inventory_snapshots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dialable_inventory_snapshots` (
  `snapshot_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `snapshot_time` datetime DEFAULT NULL,
  `list_id` bigint(14) unsigned DEFAULT NULL,
  `list_name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `list_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `campaign_id` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `list_lastcalldate` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `list_start_inv` mediumint(8) unsigned DEFAULT NULL,
  `dialable_count` mediumint(8) unsigned DEFAULT NULL,
  `dialable_count_nofilter` mediumint(8) unsigned DEFAULT NULL,
  `dialable_count_oneoff` mediumint(8) unsigned DEFAULT NULL,
  `dialable_count_inactive` mediumint(8) unsigned DEFAULT NULL,
  `average_call_count` decimal(3,1) DEFAULT NULL,
  `penetration` decimal(5,2) DEFAULT NULL,
  `shift_data` text COLLATE utf8_unicode_ci,
  `time_setting` enum('LOCAL','SERVER') COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`snapshot_id`),
  UNIQUE KEY `snapshot_date_list_key` (`snapshot_time`,`list_id`,`time_setting`),
  KEY `snapshot_date_key` (`snapshot_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dialable_inventory_snapshots`
--

LOCK TABLES `dialable_inventory_snapshots` WRITE;
/*!40000 ALTER TABLE `dialable_inventory_snapshots` DISABLE KEYS */;
/*!40000 ALTER TABLE `dialable_inventory_snapshots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `go_agent_sessions`
--

DROP TABLE IF EXISTS `go_agent_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `go_agent_sessions` (
  `agent_session_id` int(11) NOT NULL AUTO_INCREMENT,
  `sess_agent_user` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sess_agent_phone` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sess_agent_status` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`agent_session_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3563 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `go_agent_sessions`
--

LOCK TABLES `go_agent_sessions` WRITE;
/*!40000 ALTER TABLE `go_agent_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `go_agent_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `go_scripts`
--

DROP TABLE IF EXISTS `go_scripts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `go_scripts` (
  `account_num` varchar(50) NOT NULL,
  `script_id` varchar(15) NOT NULL,
  `campaign_id` varchar(8) DEFAULT NULL,
  `surveyid` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `go_scripts`
--

LOCK TABLES `go_scripts` WRITE;
/*!40000 ALTER TABLE `go_scripts` DISABLE KEYS */;
INSERT INTO `go_scripts` VALUES ('2222835441','2222835441','',''),('2222835441','2222835441','',''),('2222835441','2222835441','',''),('2222835441','2222835441','',''),('2222835441','2222835441','',''),('2222835441','2222835441','',''),('2222835441','2222835441','',''),('2222835441','2222835441','',''),('2222835441','2222835441','',''),('2222835441','2222835441','',''),('2222835441','2222835441','',''),('2222835441','2222835441','',''),('2222835441','2222835441','',''),('2222835441','2222835441','',''),('2222835441','','',''),('2222835441','2222835441','',''),('2222835441','2222835441','',''),('2222835441','2222835441','','');
/*!40000 ALTER TABLE `go_scripts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `go_useraccess`
--

DROP TABLE IF EXISTS `go_useraccess`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `go_useraccess` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `useraccess_name` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `useraccess_desc` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `vicidial_users_column_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `access_type` enum('1','0') CHARACTER SET utf8 NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `go_useraccess`
--

LOCK TABLES `go_useraccess` WRITE;
/*!40000 ALTER TABLE `go_useraccess` DISABLE KEYS */;
INSERT INTO `go_useraccess` VALUES (1,'View Reports','Allow to view reports ui','view_reports','1'),(2,'Alter agent interface options',NULL,'alter_agent_interface_options','1'),(3,'Modify Users','Allow to modify a user','modify_users','1'),(4,'Change Agent Campaign',NULL,'change_agent_campaign','1'),(5,'Delete Users',NULL,'delete_users','1'),(6,'Modify User Groups',NULL,'modify_usergroups','1'),(7,'Delete User Groups',NULL,'delete_user_groups','1'),(8,'Modify Lists',NULL,'modify_lists','1'),(9,'Delete Lists',NULL,'delete_lists','1'),(10,'Load Leads',NULL,'load_leads','1'),(11,'Modify Leads',NULL,'modify_leads','1'),(12,'Download Lists',NULL,'download_lists','1'),(13,'Export Reports',NULL,'export_reports','1'),(14,'Delete From DNC',NULL,'delete_from_dnc','1'),(15,'Custom Fields Modify',NULL,'custom_fields_modify','1'),(16,'Modify Campaigns',NULL,'modify_campaigns','1'),(17,'Campaign Detail',NULL,'campaign_detail','1'),(18,'Delete Campaigns',NULL,'delete_campaigns','1'),(19,'Modify InGroups',NULL,'modify_ingroups','1'),(20,'Delete InGroups',NULL,'delete_ingroups','1'),(21,'Modify Inbound DIDs',NULL,'modify_inbound_dids','1'),(22,'Delete Inbound DIDs',NULL,'delete_inbound_dids','1'),(23,'Modify Remote Agents',NULL,'modify_remoteagents','1'),(24,'Delete Remote Agents',NULL,'delete_remote_agents','1'),(25,'Modify Scripts',NULL,'modify_scripts','1'),(26,'Delete Scripts',NULL,'delete_scripts','1'),(27,'Modify Filters',NULL,'modify_filters','1'),(28,'Delete Filters',NULL,'delete_filters','1'),(29,'AGC Admin Access',NULL,'ast_admin_access','1'),(30,'AGC Delete Phones',NULL,'ast_delete_phones','1'),(31,'Modify Call Times',NULL,'modify_call_times','1'),(32,'Delete Call Times',NULL,'delete_call_times','1'),(33,'Modify Servers',NULL,'modify_servers','1'),(34,'CallCard Admin',NULL,'callcard_admin','1'),(35,'Agent API Access',NULL,'vdc_agent_api_access','1'),(36,'Add Timeclock Log Record',NULL,'add_timeclock_log','1'),(37,'Modify Timeclock Log Record',NULL,'modify_timeclock_log','1'),(38,'Delete Timeclock Log Record',NULL,'delete_timeclock_log','1'),(39,'Manager Shift Enforcement Override',NULL,'manager_shift_enforcement_override','1'),(40,'Realtime Block User Info',NULL,'realtime_block_user_info','1'),(41,'Agent Choose Ingroups',NULL,'agent_choose_ingroups','0'),(42,'Agent Choose Blended',NULL,'agent_choose_blended','0'),(43,'Hot Keys Active',NULL,'hotkeys_active','0'),(44,'Scheduled Callbacks',NULL,'scheduled_callbacks','0'),(45,'Agent-Only Callbacks',NULL,'agentonly_callbacks','0'),(46,'Agent Call Manual',NULL,'agentcall_manual','0'),(47,'Vicidial Recording',NULL,'vicidial_recording','0'),(48,'Vicidial Transfers',NULL,'vicidial_transfers','0'),(49,'Closer Default Blended',NULL,'closer_default_blended','0'),(50,'VICIDIAL Recording Override',NULL,'vicidial_recording_override','0'),(51,'Agent Alter Customer Data Override',NULL,'alter_custdata_override','0'),(52,'Agent Alter Customer Phone Override',NULL,'alter_custphone_override','0'),(53,'Agent Shift Enforcement Override',NULL,'agent_shift_enforcement_override','0'),(54,'Agent Call Log View Override',NULL,'agent_call_log_view_override','0'),(55,'Agent Lead Search Override',NULL,'agent_lead_search','0'),(56,'Alert Enabled',NULL,'alert_enabled','0'),(57,'Allow Alerts',NULL,'allow_alerts','0');
/*!40000 ALTER TABLE `go_useraccess` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `go_viewLists`
--

DROP TABLE IF EXISTS `go_viewLists`;
/*!50001 DROP VIEW IF EXISTS `go_viewLists`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `go_viewLists` (
  `list_id` tinyint NOT NULL,
  `list_name` tinyint NOT NULL,
  `list_description` tinyint NOT NULL,
  `tally` tinyint NOT NULL,
  `active` tinyint NOT NULL,
  `list_lastcalldate` tinyint NOT NULL,
  `campaign_id` tinyint NOT NULL,
  `reset_time` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `goautodial_recordings_view`
--

DROP TABLE IF EXISTS `goautodial_recordings_view`;
/*!50001 DROP VIEW IF EXISTS `goautodial_recordings_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `goautodial_recordings_view` (
  `recording_id` tinyint NOT NULL,
  `lead_id` tinyint NOT NULL,
  `phone` tinyint NOT NULL,
  `call_date` tinyint NOT NULL,
  `duration` tinyint NOT NULL,
  `agent` tinyint NOT NULL,
  `disposition` tinyint NOT NULL,
  `fullname` tinyint NOT NULL,
  `location` tinyint NOT NULL,
  `filename` tinyint NOT NULL,
  `campaign_id` tinyint NOT NULL,
  `list_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `goautodial_recordings_view_all`
--

DROP TABLE IF EXISTS `goautodial_recordings_view_all`;
/*!50001 DROP VIEW IF EXISTS `goautodial_recordings_view_all`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `goautodial_recordings_view_all` (
  `recording_id` tinyint NOT NULL,
  `lead_id` tinyint NOT NULL,
  `phone` tinyint NOT NULL,
  `call_date` tinyint NOT NULL,
  `duration` tinyint NOT NULL,
  `agent` tinyint NOT NULL,
  `disposition` tinyint NOT NULL,
  `campaign_dispo` tinyint NOT NULL,
  `fullname` tinyint NOT NULL,
  `location` tinyint NOT NULL,
  `filename` tinyint NOT NULL,
  `campaign_id` tinyint NOT NULL,
  `list_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `goautodial_recordings_views`
--

DROP TABLE IF EXISTS `goautodial_recordings_views`;
/*!50001 DROP VIEW IF EXISTS `goautodial_recordings_views`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `goautodial_recordings_views` (
  `recording_id` tinyint NOT NULL,
  `lead_id` tinyint NOT NULL,
  `phone` tinyint NOT NULL,
  `call_date` tinyint NOT NULL,
  `duration` tinyint NOT NULL,
  `agent` tinyint NOT NULL,
  `disposition` tinyint NOT NULL,
  `campaign_dispo` tinyint NOT NULL,
  `fullname` tinyint NOT NULL,
  `location` tinyint NOT NULL,
  `filename` tinyint NOT NULL,
  `campaign_id` tinyint NOT NULL,
  `list_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `groups_alias`
--

DROP TABLE IF EXISTS `groups_alias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups_alias` (
  `group_alias_id` varchar(30) NOT NULL,
  `group_alias_name` varchar(50) DEFAULT NULL,
  `caller_id_number` varchar(20) DEFAULT NULL,
  `caller_id_name` varchar(20) DEFAULT NULL,
  `active` enum('Y','N') DEFAULT 'N',
  `user_group` varchar(20) DEFAULT '---ALL---',
  PRIMARY KEY (`group_alias_id`),
  UNIQUE KEY `group_alias_id` (`group_alias_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups_alias`
--

LOCK TABLES `groups_alias` WRITE;
/*!40000 ALTER TABLE `groups_alias` DISABLE KEYS */;
/*!40000 ALTER TABLE `groups_alias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inbound_email_attachments`
--

DROP TABLE IF EXISTS `inbound_email_attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inbound_email_attachments` (
  `attachment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email_row_id` int(10) unsigned DEFAULT NULL,
  `filename` varchar(250) NOT NULL DEFAULT '',
  `file_type` varchar(100) DEFAULT NULL,
  `file_encoding` varchar(20) DEFAULT NULL,
  `file_size` varchar(45) DEFAULT NULL,
  `file_extension` varchar(5) NOT NULL DEFAULT '',
  `file_contents` longblob NOT NULL,
  PRIMARY KEY (`attachment_id`),
  KEY `attachments_email_id_key` (`email_row_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inbound_email_attachments`
--

LOCK TABLES `inbound_email_attachments` WRITE;
/*!40000 ALTER TABLE `inbound_email_attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `inbound_email_attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inbound_numbers`
--

DROP TABLE IF EXISTS `inbound_numbers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inbound_numbers` (
  `extension` varchar(30) NOT NULL,
  `full_number` varchar(30) NOT NULL,
  `server_ip` varchar(15) NOT NULL,
  `inbound_name` varchar(30) DEFAULT NULL,
  `department` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inbound_numbers`
--

LOCK TABLES `inbound_numbers` WRITE;
/*!40000 ALTER TABLE `inbound_numbers` DISABLE KEYS */;
/*!40000 ALTER TABLE `inbound_numbers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `justgovoip_sippy_info`
--

DROP TABLE IF EXISTS `justgovoip_sippy_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `justgovoip_sippy_info` (
  `carrier_id` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `web_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `authname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `voip_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `vm_password` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `i_account` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `justgovoip_sippy_info`
--

LOCK TABLES `justgovoip_sippy_info` WRITE;
/*!40000 ALTER TABLE `justgovoip_sippy_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `justgovoip_sippy_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `live_channels`
--

DROP TABLE IF EXISTS `live_channels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `live_channels` (
  `channel` varchar(100) NOT NULL,
  `server_ip` varchar(15) NOT NULL,
  `channel_group` varchar(30) DEFAULT NULL,
  `extension` varchar(100) DEFAULT NULL,
  `channel_data` varchar(100) DEFAULT NULL
) ENGINE=MEMORY DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `live_channels`
--

LOCK TABLES `live_channels` WRITE;
/*!40000 ALTER TABLE `live_channels` DISABLE KEYS */;
/*!40000 ALTER TABLE `live_channels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `live_inbound`
--

DROP TABLE IF EXISTS `live_inbound`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `live_inbound` (
  `uniqueid` varchar(20) NOT NULL,
  `channel` varchar(100) NOT NULL,
  `server_ip` varchar(15) NOT NULL,
  `caller_id` varchar(30) DEFAULT NULL,
  `extension` varchar(100) DEFAULT NULL,
  `phone_ext` varchar(40) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `acknowledged` enum('Y','N') DEFAULT 'N',
  `inbound_number` varchar(20) DEFAULT NULL,
  `comment_a` varchar(50) DEFAULT NULL,
  `comment_b` varchar(50) DEFAULT NULL,
  `comment_c` varchar(50) DEFAULT NULL,
  `comment_d` varchar(50) DEFAULT NULL,
  `comment_e` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `live_inbound`
--

LOCK TABLES `live_inbound` WRITE;
/*!40000 ALTER TABLE `live_inbound` DISABLE KEYS */;
/*!40000 ALTER TABLE `live_inbound` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `live_inbound_log`
--

DROP TABLE IF EXISTS `live_inbound_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `live_inbound_log` (
  `uniqueid` varchar(20) NOT NULL,
  `channel` varchar(100) NOT NULL,
  `server_ip` varchar(15) NOT NULL,
  `caller_id` varchar(30) DEFAULT NULL,
  `extension` varchar(100) DEFAULT NULL,
  `phone_ext` varchar(40) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `acknowledged` enum('Y','N') DEFAULT 'N',
  `inbound_number` varchar(20) DEFAULT NULL,
  `comment_a` varchar(50) DEFAULT NULL,
  `comment_b` varchar(50) DEFAULT NULL,
  `comment_c` varchar(50) DEFAULT NULL,
  `comment_d` varchar(50) DEFAULT NULL,
  `comment_e` varchar(50) DEFAULT NULL,
  KEY `uniqueid` (`uniqueid`),
  KEY `phone_ext` (`phone_ext`),
  KEY `start_time` (`start_time`),
  KEY `comment_a` (`comment_a`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `live_inbound_log`
--

LOCK TABLES `live_inbound_log` WRITE;
/*!40000 ALTER TABLE `live_inbound_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `live_inbound_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `live_sip_channels`
--

DROP TABLE IF EXISTS `live_sip_channels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `live_sip_channels` (
  `channel` varchar(100) NOT NULL,
  `server_ip` varchar(15) NOT NULL,
  `channel_group` varchar(30) DEFAULT NULL,
  `extension` varchar(100) DEFAULT NULL,
  `channel_data` varchar(100) DEFAULT NULL
) ENGINE=MEMORY DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `live_sip_channels`
--

LOCK TABLES `live_sip_channels` WRITE;
/*!40000 ALTER TABLE `live_sip_channels` DISABLE KEYS */;
/*!40000 ALTER TABLE `live_sip_channels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanpa_prefix_exchanges_fast`
--

DROP TABLE IF EXISTS `nanpa_prefix_exchanges_fast`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanpa_prefix_exchanges_fast` (
  `ac_prefix` char(7) DEFAULT '',
  `type` char(1) DEFAULT '',
  KEY `nanpaacprefix` (`ac_prefix`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanpa_prefix_exchanges_fast`
--

LOCK TABLES `nanpa_prefix_exchanges_fast` WRITE;
/*!40000 ALTER TABLE `nanpa_prefix_exchanges_fast` DISABLE KEYS */;
/*!40000 ALTER TABLE `nanpa_prefix_exchanges_fast` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanpa_prefix_exchanges_master`
--

DROP TABLE IF EXISTS `nanpa_prefix_exchanges_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanpa_prefix_exchanges_master` (
  `areacode` char(3) DEFAULT '',
  `prefix` char(4) DEFAULT '',
  `source` char(1) DEFAULT '',
  `type` char(1) DEFAULT '',
  `tier` varchar(20) DEFAULT '',
  `postal_code` varchar(20) DEFAULT '',
  `new_areacode` char(3) DEFAULT '',
  `tzcode` varchar(4) DEFAULT '',
  `region` char(2) DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanpa_prefix_exchanges_master`
--

LOCK TABLES `nanpa_prefix_exchanges_master` WRITE;
/*!40000 ALTER TABLE `nanpa_prefix_exchanges_master` DISABLE KEYS */;
/*!40000 ALTER TABLE `nanpa_prefix_exchanges_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanpa_wired_to_wireless`
--

DROP TABLE IF EXISTS `nanpa_wired_to_wireless`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanpa_wired_to_wireless` (
  `phone` char(10) NOT NULL,
  PRIMARY KEY (`phone`),
  UNIQUE KEY `phone` (`phone`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanpa_wired_to_wireless`
--

LOCK TABLES `nanpa_wired_to_wireless` WRITE;
/*!40000 ALTER TABLE `nanpa_wired_to_wireless` DISABLE KEYS */;
/*!40000 ALTER TABLE `nanpa_wired_to_wireless` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanpa_wireless_to_wired`
--

DROP TABLE IF EXISTS `nanpa_wireless_to_wired`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanpa_wireless_to_wired` (
  `phone` char(10) NOT NULL,
  PRIMARY KEY (`phone`),
  UNIQUE KEY `phone` (`phone`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanpa_wireless_to_wired`
--

LOCK TABLES `nanpa_wireless_to_wired` WRITE;
/*!40000 ALTER TABLE `nanpa_wireless_to_wired` DISABLE KEYS */;
/*!40000 ALTER TABLE `nanpa_wireless_to_wired` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `online`
--

DROP TABLE IF EXISTS `online`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `conference` varchar(255) DEFAULT NULL,
  `channel` varchar(80) DEFAULT NULL,
  `talking` int(11) DEFAULT '0',
  `muted` int(11) DEFAULT '0',
  `number` varchar(20) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `admin` int(11) DEFAULT '0',
  `scoreid` int(11) DEFAULT NULL,
  `lastmenuoption` varchar(25) DEFAULT NULL,
  `uniqueid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `online`
--

LOCK TABLES `online` WRITE;
/*!40000 ALTER TABLE `online` DISABLE KEYS */;
/*!40000 ALTER TABLE `online` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `park_log`
--

DROP TABLE IF EXISTS `park_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `park_log` (
  `uniqueid` varchar(20) DEFAULT '',
  `status` varchar(10) DEFAULT NULL,
  `channel` varchar(100) DEFAULT NULL,
  `channel_group` varchar(30) DEFAULT NULL,
  `server_ip` varchar(15) DEFAULT NULL,
  `parked_time` datetime DEFAULT NULL,
  `grab_time` datetime DEFAULT NULL,
  `hangup_time` datetime DEFAULT NULL,
  `parked_sec` int(10) DEFAULT NULL,
  `talked_sec` int(10) DEFAULT NULL,
  `extension` varchar(100) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `lead_id` int(9) unsigned DEFAULT '0',
  KEY `parked_time` (`parked_time`),
  KEY `lead_id_park` (`lead_id`),
  KEY `uniqueid_park` (`uniqueid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `park_log`
--

LOCK TABLES `park_log` WRITE;
/*!40000 ALTER TABLE `park_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `park_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parked_channels`
--

DROP TABLE IF EXISTS `parked_channels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parked_channels` (
  `channel` varchar(100) NOT NULL,
  `server_ip` varchar(15) NOT NULL,
  `channel_group` varchar(30) DEFAULT NULL,
  `extension` varchar(100) DEFAULT NULL,
  `parked_by` varchar(100) DEFAULT NULL,
  `parked_time` datetime DEFAULT NULL
) ENGINE=MEMORY DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parked_channels`
--

LOCK TABLES `parked_channels` WRITE;
/*!40000 ALTER TABLE `parked_channels` DISABLE KEYS */;
/*!40000 ALTER TABLE `parked_channels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parked_channels_recent`
--

DROP TABLE IF EXISTS `parked_channels_recent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parked_channels_recent` (
  `channel` varchar(100) NOT NULL,
  `server_ip` varchar(15) NOT NULL,
  `channel_group` varchar(30) DEFAULT NULL,
  `park_end_time` datetime DEFAULT NULL,
  KEY `channel_group` (`channel_group`),
  KEY `park_end_time` (`park_end_time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parked_channels_recent`
--

LOCK TABLES `parked_channels_recent` WRITE;
/*!40000 ALTER TABLE `parked_channels_recent` DISABLE KEYS */;
/*!40000 ALTER TABLE `parked_channels_recent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phone_favorites`
--

DROP TABLE IF EXISTS `phone_favorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phone_favorites` (
  `extension` varchar(100) DEFAULT NULL,
  `server_ip` varchar(15) DEFAULT NULL,
  `extensions_list` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phone_favorites`
--

LOCK TABLES `phone_favorites` WRITE;
/*!40000 ALTER TABLE `phone_favorites` DISABLE KEYS */;
/*!40000 ALTER TABLE `phone_favorites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phones`
--

DROP TABLE IF EXISTS `phones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phones` (
  `extension` varchar(100) DEFAULT NULL,
  `dialplan_number` varchar(20) DEFAULT NULL,
  `voicemail_id` varchar(10) DEFAULT NULL,
  `phone_ip` varchar(15) DEFAULT NULL,
  `computer_ip` varchar(15) DEFAULT NULL,
  `server_ip` varchar(15) DEFAULT NULL,
  `login` varchar(15) DEFAULT NULL,
  `pass` varchar(100) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `active` enum('Y','N') DEFAULT NULL,
  `phone_type` varchar(50) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `company` varchar(10) DEFAULT NULL,
  `picture` varchar(19) DEFAULT NULL,
  `messages` int(4) DEFAULT NULL,
  `old_messages` int(4) DEFAULT NULL,
  `protocol` enum('SIP','Zap','IAX2','EXTERNAL') DEFAULT 'SIP',
  `local_gmt` varchar(6) DEFAULT '-5',
  `ASTmgrUSERNAME` varchar(20) DEFAULT 'cron',
  `ASTmgrSECRET` varchar(20) DEFAULT '1234',
  `login_user` varchar(20) DEFAULT NULL,
  `login_pass` varchar(100) DEFAULT NULL,
  `login_campaign` varchar(10) DEFAULT NULL,
  `park_on_extension` varchar(10) DEFAULT '8301',
  `conf_on_extension` varchar(10) DEFAULT '8302',
  `VICIDIAL_park_on_extension` varchar(10) DEFAULT '8301',
  `VICIDIAL_park_on_filename` varchar(10) DEFAULT 'park',
  `monitor_prefix` varchar(10) DEFAULT '8612',
  `recording_exten` varchar(10) DEFAULT '8309',
  `voicemail_exten` varchar(10) DEFAULT '8501',
  `voicemail_dump_exten` varchar(20) DEFAULT '85026666666666',
  `ext_context` varchar(20) DEFAULT 'default',
  `dtmf_send_extension` varchar(100) DEFAULT 'local/8500998@default',
  `call_out_number_group` varchar(100) DEFAULT 'Zap/g2/',
  `client_browser` varchar(100) DEFAULT '/usr/bin/mozilla',
  `install_directory` varchar(100) DEFAULT '/usr/local/perl_TK',
  `local_web_callerID_URL` varchar(255) DEFAULT 'http://astguiclient.sf.net/test_callerid_output.php',
  `VICIDIAL_web_URL` varchar(255) DEFAULT 'http://astguiclient.sf.net/test_VICIDIAL_output.php',
  `AGI_call_logging_enabled` enum('0','1') DEFAULT '1',
  `user_switching_enabled` enum('0','1') DEFAULT '1',
  `conferencing_enabled` enum('0','1') DEFAULT '1',
  `admin_hangup_enabled` enum('0','1') DEFAULT '0',
  `admin_hijack_enabled` enum('0','1') DEFAULT '0',
  `admin_monitor_enabled` enum('0','1') DEFAULT '1',
  `call_parking_enabled` enum('0','1') DEFAULT '1',
  `updater_check_enabled` enum('0','1') DEFAULT '1',
  `AFLogging_enabled` enum('0','1') DEFAULT '1',
  `QUEUE_ACTION_enabled` enum('0','1') DEFAULT '1',
  `CallerID_popup_enabled` enum('0','1') DEFAULT '1',
  `voicemail_button_enabled` enum('0','1') DEFAULT '1',
  `enable_fast_refresh` enum('0','1') DEFAULT '0',
  `fast_refresh_rate` int(5) DEFAULT '1000',
  `enable_persistant_mysql` enum('0','1') DEFAULT '0',
  `auto_dial_next_number` enum('0','1') DEFAULT '1',
  `VDstop_rec_after_each_call` enum('0','1') DEFAULT '1',
  `DBX_server` varchar(15) DEFAULT NULL,
  `DBX_database` varchar(15) DEFAULT 'asterisk',
  `DBX_user` varchar(15) DEFAULT 'cron',
  `DBX_pass` varchar(15) DEFAULT '1234',
  `DBX_port` int(6) DEFAULT '3306',
  `DBY_server` varchar(15) DEFAULT NULL,
  `DBY_database` varchar(15) DEFAULT 'asterisk',
  `DBY_user` varchar(15) DEFAULT 'cron',
  `DBY_pass` varchar(15) DEFAULT '1234',
  `DBY_port` int(6) DEFAULT '3306',
  `outbound_cid` varchar(20) DEFAULT NULL,
  `enable_sipsak_messages` enum('0','1') DEFAULT '0',
  `email` varchar(100) DEFAULT NULL,
  `template_id` varchar(15) NOT NULL,
  `conf_override` text,
  `phone_context` varchar(20) DEFAULT 'default',
  `phone_ring_timeout` smallint(3) DEFAULT '60',
  `conf_secret` varchar(20) DEFAULT 'test',
  `delete_vm_after_email` enum('N','Y') DEFAULT 'N',
  `is_webphone` enum('Y','N','Y_API_LAUNCH') DEFAULT 'N',
  `use_external_server_ip` enum('Y','N') DEFAULT 'N',
  `codecs_list` varchar(100) DEFAULT '',
  `codecs_with_template` enum('0','1') DEFAULT '0',
  `webphone_dialpad` enum('Y','N','TOGGLE','TOGGLE_OFF') DEFAULT 'Y',
  `on_hook_agent` enum('Y','N') DEFAULT 'N',
  `webphone_auto_answer` enum('Y','N') DEFAULT 'Y',
  `voicemail_timezone` varchar(30) DEFAULT 'eastern',
  `voicemail_options` varchar(255) DEFAULT '',
  `user_group` varchar(20) DEFAULT '---ALL---',
  `voicemail_greeting` varchar(100) DEFAULT '',
  `voicemail_dump_exten_no_inst` varchar(20) DEFAULT '85026666666667',
  `voicemail_instructions` enum('Y','N') DEFAULT 'Y',
  `on_login_report` enum('Y','N') NOT NULL DEFAULT 'N',
  `unavail_dialplan_fwd_exten` varchar(40) DEFAULT '',
  `unavail_dialplan_fwd_context` varchar(100) DEFAULT '',
  `nva_call_url` text,
  `nva_search_method` varchar(40) DEFAULT 'NONE',
  `nva_error_filename` varchar(255) DEFAULT '',
  `nva_new_list_id` bigint(14) unsigned DEFAULT '995',
  `nva_new_phone_code` varchar(10) DEFAULT '1',
  `nva_new_status` varchar(6) DEFAULT 'NVAINS',
  `webphone_dialbox` enum('Y','N') DEFAULT 'Y',
  `webphone_mute` enum('Y','N') DEFAULT 'Y',
  `webphone_volume` enum('Y','N') DEFAULT 'Y',
  `webphone_debug` enum('Y','N') DEFAULT 'N',
  `outbound_alt_cid` varchar(20) DEFAULT '',
  `conf_qualify` enum('Y','N') DEFAULT 'Y',
  `webphone_layout` varchar(255) DEFAULT '',
  UNIQUE KEY `extenserver` (`extension`,`server_ip`),
  KEY `server_ip` (`server_ip`),
  KEY `pvmid` (`voicemail_id`),
  KEY `pdpn` (`dialplan_number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phones`
--

LOCK TABLES `phones` WRITE;
/*!40000 ALTER TABLE `phones` DISABLE KEYS */;
INSERT INTO `phones` VALUES ('7798306534','99997798306534','7798306534','','','127.0.0.1','7798306534','','ACTIVE','Y','','Admin User','ADMIN','',0,0,'EXTERNAL','-5','cron','1234',NULL,NULL,NULL,'8301','8302','8301','park','8612','8309','8501','85026666666666','default','local/8500998@default','Zap/g2/','/usr/bin/mozilla','/usr/local/perl_TK','http://astguiclient.sf.net/test_callerid_output.php','http://astguiclient.sf.net/test_VICIDIAL_output.php','1','1','1','0','0','1','1','1','1','1','1','1','0',1000,'0','1','1',NULL,'asterisk','cron','1234',3306,NULL,'asterisk','cron','1234',3306,'0000000000','0',NULL,'--NONE--',NULL,'default',60,'','N','N','N','','0','Y','N','Y','eastern','','ADMIN','','85026666666667','Y','N','','',NULL,'NONE','',995,'1','NVAINS','Y','Y','Y','N','','Y',''),('5474470533','99995474470533','5474470533','','','127.0.0.1','5474470533','','ACTIVE','Y','','Agent 001','AGENTS','',0,0,'EXTERNAL','-5','cron','1234',NULL,NULL,NULL,'8301','8302','8301','park','8612','8309','8501','85026666666666','default','local/8500998@default','Zap/g2/','/usr/bin/mozilla','/usr/local/perl_TK','http://astguiclient.sf.net/test_callerid_output.php','http://astguiclient.sf.net/test_VICIDIAL_output.php','1','1','1','0','0','1','1','1','1','1','1','1','0',1000,'0','1','1',NULL,'asterisk','cron','1234',3306,NULL,'asterisk','cron','1234',3306,'0000000000','0',NULL,'--NONE--',NULL,'default',60,'','N','N','N','','0','Y','N','Y','eastern','','AGENTS','','85026666666667','Y','N','','',NULL,'NONE','',995,'1','NVAINS','Y','Y','Y','N','','Y','');
/*!40000 ALTER TABLE `phones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phones_alias`
--

DROP TABLE IF EXISTS `phones_alias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phones_alias` (
  `alias_id` varchar(20) NOT NULL,
  `alias_name` varchar(50) DEFAULT NULL,
  `logins_list` varchar(255) DEFAULT NULL,
  `user_group` varchar(20) DEFAULT '---ALL---',
  PRIMARY KEY (`alias_id`),
  UNIQUE KEY `alias_id` (`alias_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phones_alias`
--

LOCK TABLES `phones_alias` WRITE;
/*!40000 ALTER TABLE `phones_alias` DISABLE KEYS */;
/*!40000 ALTER TABLE `phones_alias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recording_log`
--

DROP TABLE IF EXISTS `recording_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recording_log` (
  `recording_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `channel` varchar(100) DEFAULT NULL,
  `server_ip` varchar(15) DEFAULT NULL,
  `extension` varchar(100) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `start_epoch` int(10) unsigned DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `end_epoch` int(10) unsigned DEFAULT NULL,
  `length_in_sec` mediumint(8) unsigned DEFAULT NULL,
  `length_in_min` double(8,2) DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `vicidial_id` varchar(20) DEFAULT NULL,
  `b64encoded` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`recording_id`),
  KEY `filename` (`filename`),
  KEY `lead_id` (`lead_id`),
  KEY `user` (`user`),
  KEY `vicidial_id` (`vicidial_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recording_log`
--

LOCK TABLES `recording_log` WRITE;
/*!40000 ALTER TABLE `recording_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `recording_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recording_log_archive`
--

DROP TABLE IF EXISTS `recording_log_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recording_log_archive` (
  `recording_id` int(10) unsigned NOT NULL,
  `channel` varchar(100) DEFAULT NULL,
  `server_ip` varchar(15) DEFAULT NULL,
  `extension` varchar(100) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `start_epoch` int(10) unsigned DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `end_epoch` int(10) unsigned DEFAULT NULL,
  `length_in_sec` mediumint(8) unsigned DEFAULT NULL,
  `length_in_min` double(8,2) DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `vicidial_id` varchar(20) DEFAULT NULL,
  `b64encoded` tinyint(1) DEFAULT NULL,
  UNIQUE KEY `recording_id` (`recording_id`),
  UNIQUE KEY `recording_id_2` (`recording_id`),
  KEY `filename` (`filename`),
  KEY `lead_id` (`lead_id`),
  KEY `user` (`user`),
  KEY `vicidial_id` (`vicidial_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recording_log_archive`
--

LOCK TABLES `recording_log_archive` WRITE;
/*!40000 ALTER TABLE `recording_log_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `recording_log_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recording_log_deletion_queue`
--

DROP TABLE IF EXISTS `recording_log_deletion_queue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recording_log_deletion_queue` (
  `recording_id` int(9) unsigned NOT NULL,
  `lead_id` int(10) unsigned DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `date_queued` datetime DEFAULT NULL,
  `date_deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`recording_id`),
  KEY `date_deleted` (`date_deleted`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recording_log_deletion_queue`
--

LOCK TABLES `recording_log_deletion_queue` WRITE;
/*!40000 ALTER TABLE `recording_log_deletion_queue` DISABLE KEYS */;
/*!40000 ALTER TABLE `recording_log_deletion_queue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `routing_initiated_recordings`
--

DROP TABLE IF EXISTS `routing_initiated_recordings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `routing_initiated_recordings` (
  `recording_id` int(10) unsigned NOT NULL,
  `filename` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `launch_time` datetime DEFAULT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `vicidial_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `processed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`recording_id`),
  KEY `lead_id` (`lead_id`),
  KEY `user` (`user`),
  KEY `processed` (`processed`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `routing_initiated_recordings`
--

LOCK TABLES `routing_initiated_recordings` WRITE;
/*!40000 ALTER TABLE `routing_initiated_recordings` DISABLE KEYS */;
/*!40000 ALTER TABLE `routing_initiated_recordings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `server_performance`
--

DROP TABLE IF EXISTS `server_performance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `server_performance` (
  `start_time` datetime NOT NULL,
  `server_ip` varchar(15) NOT NULL,
  `sysload` int(6) NOT NULL,
  `freeram` smallint(5) unsigned NOT NULL,
  `usedram` smallint(5) unsigned NOT NULL,
  `processes` smallint(4) unsigned NOT NULL,
  `channels_total` smallint(4) unsigned NOT NULL,
  `trunks_total` smallint(4) unsigned NOT NULL,
  `clients_total` smallint(4) unsigned NOT NULL,
  `clients_zap` smallint(4) unsigned NOT NULL,
  `clients_iax` smallint(4) unsigned NOT NULL,
  `clients_local` smallint(4) unsigned NOT NULL,
  `clients_sip` smallint(4) unsigned NOT NULL,
  `live_recordings` smallint(4) unsigned NOT NULL,
  `cpu_user_percent` smallint(3) unsigned NOT NULL DEFAULT '0',
  `cpu_system_percent` smallint(3) unsigned NOT NULL DEFAULT '0',
  `cpu_idle_percent` smallint(3) unsigned NOT NULL DEFAULT '0',
  `disk_reads` mediumint(7) DEFAULT NULL,
  `disk_writes` mediumint(7) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `server_performance`
--

LOCK TABLES `server_performance` WRITE;
/*!40000 ALTER TABLE `server_performance` DISABLE KEYS */;
/*!40000 ALTER TABLE `server_performance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `server_updater`
--

DROP TABLE IF EXISTS `server_updater`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `server_updater` (
  `server_ip` varchar(15) NOT NULL,
  `last_update` datetime DEFAULT NULL,
  `db_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MEMORY DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `server_updater`
--

LOCK TABLES `server_updater` WRITE;
/*!40000 ALTER TABLE `server_updater` DISABLE KEYS */;
INSERT INTO `server_updater` VALUES ('127.0.0.1','2018-09-24 14:54:43','2018-09-24 06:54:43');
/*!40000 ALTER TABLE `server_updater` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servers`
--

DROP TABLE IF EXISTS `servers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servers` (
  `server_id` varchar(10) NOT NULL,
  `server_description` varchar(255) DEFAULT NULL,
  `server_ip` varchar(15) NOT NULL,
  `active` enum('Y','N') DEFAULT NULL,
  `asterisk_version` varchar(20) DEFAULT '1.2.9',
  `max_vicidial_trunks` smallint(4) DEFAULT '23',
  `telnet_host` varchar(20) NOT NULL DEFAULT 'localhost',
  `telnet_port` int(5) NOT NULL DEFAULT '5038',
  `ASTmgrUSERNAME` varchar(20) NOT NULL DEFAULT 'cron',
  `ASTmgrSECRET` varchar(20) NOT NULL DEFAULT '1234',
  `ASTmgrUSERNAMEupdate` varchar(20) NOT NULL DEFAULT 'updatecron',
  `ASTmgrUSERNAMElisten` varchar(20) NOT NULL DEFAULT 'listencron',
  `ASTmgrUSERNAMEsend` varchar(20) NOT NULL DEFAULT 'sendcron',
  `local_gmt` varchar(6) DEFAULT '-5',
  `voicemail_dump_exten` varchar(20) NOT NULL DEFAULT '85026666666666',
  `answer_transfer_agent` varchar(20) NOT NULL DEFAULT '8365',
  `ext_context` varchar(20) NOT NULL DEFAULT 'default',
  `sys_perf_log` enum('Y','N') DEFAULT 'N',
  `vd_server_logs` enum('Y','N') DEFAULT 'Y',
  `agi_output` enum('NONE','STDERR','FILE','BOTH') DEFAULT 'FILE',
  `vicidial_balance_active` enum('Y','N') DEFAULT 'N',
  `balance_trunks_offlimits` smallint(5) unsigned DEFAULT '0',
  `recording_web_link` enum('SERVER_IP','ALT_IP','EXTERNAL_IP') DEFAULT 'SERVER_IP',
  `alt_server_ip` varchar(100) DEFAULT '',
  `active_asterisk_server` enum('Y','N') DEFAULT 'Y',
  `generate_vicidial_conf` enum('Y','N') DEFAULT 'Y',
  `rebuild_conf_files` enum('Y','N') DEFAULT 'Y',
  `outbound_calls_per_second` smallint(3) unsigned DEFAULT '20',
  `sysload` int(6) NOT NULL DEFAULT '0',
  `channels_total` smallint(4) unsigned NOT NULL DEFAULT '0',
  `cpu_idle_percent` smallint(3) unsigned NOT NULL DEFAULT '0',
  `disk_usage` varchar(255) DEFAULT '1',
  `sounds_update` enum('Y','N') DEFAULT 'N',
  `vicidial_recording_limit` mediumint(8) DEFAULT '60',
  `carrier_logging_active` enum('Y','N') DEFAULT 'Y',
  `vicidial_balance_rank` tinyint(3) unsigned DEFAULT '0',
  `rebuild_music_on_hold` enum('Y','N') DEFAULT 'Y',
  `active_agent_login_server` enum('Y','N') DEFAULT 'Y',
  `conf_secret` varchar(20) DEFAULT 'test',
  `external_server_ip` varchar(100) DEFAULT '',
  `custom_dialplan_entry` text,
  `active_twin_server_ip` varchar(15) DEFAULT '',
  `user_group` varchar(20) DEFAULT '---ALL---',
  `audio_store_purge` text,
  `svn_revision` int(9) DEFAULT '0',
  `svn_info` text,
  `system_uptime` varchar(255) DEFAULT '',
  `auto_restart_asterisk` enum('Y','N') DEFAULT 'N',
  `asterisk_temp_no_restart` enum('Y','N') DEFAULT 'N',
  `voicemail_dump_exten_no_inst` varchar(20) DEFAULT '85026666666667',
  `gather_asterisk_output` enum('Y','N') DEFAULT 'N',
  `web_socket_url` varchar(255) DEFAULT '',
  `conf_qualify` enum('Y','N') DEFAULT 'Y',
  `routing_prefix` varchar(10) DEFAULT '13',
  UNIQUE KEY `server_id` (`server_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servers`
--

LOCK TABLES `servers` WRITE;
/*!40000 ALTER TABLE `servers` DISABLE KEYS */;
INSERT INTO `servers` VALUES ('GOautodial','My GOautodial Server','127.0.0.1','Y','13.X',96,'localhost',5038,'cron','1234','updatecron','listencron','sendcron','-5.00','85026666666666','8365','default','N','N','NONE','N',0,'EXTERNAL_IP','vaglxc01.goautodial.com','Y','Y','N',10,132,0,95,'1 50|2 0|3 1|4 96|5 0|6 5|7 0|','N',60,'N',0,'N','Y','test','vaglxc01.goautodial.com','','','---ALL---',NULL,2552,'/usr/src/astguiclient_svn/trunk\nPath: .\nWorking Copy Root Path: /usr/src/astguiclient_svn/trunk\nURL: svn://svn.eflo.net/agc_2-X/trunk\nRepository Root: svn://svn.eflo.net\nRepository UUID: 3d104415-ff17-0410-8863-d5cf3c621b8a\nRevision: 2552\nNode Kind: directory\nSchedule: normal\nLast Changed Author: mattf\nLast Changed Rev: 2552\nLast Changed Date: 2016-06-13 14:20:13 -0400 (Mon, 13 Jun 2016)\n\n\n','10 days 4:53','N','N','85026666666667','N','','Y','13');
/*!40000 ALTER TABLE `servers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_settings`
--

DROP TABLE IF EXISTS `system_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_settings` (
  `version` varchar(50) DEFAULT NULL,
  `install_date` varchar(50) DEFAULT NULL,
  `use_non_latin` enum('0','1') DEFAULT '0',
  `webroot_writable` enum('0','1') DEFAULT '1',
  `enable_queuemetrics_logging` enum('0','1') DEFAULT '0',
  `queuemetrics_server_ip` varchar(15) DEFAULT NULL,
  `queuemetrics_dbname` varchar(50) DEFAULT NULL,
  `queuemetrics_login` varchar(50) DEFAULT NULL,
  `queuemetrics_pass` varchar(50) DEFAULT NULL,
  `queuemetrics_url` varchar(255) DEFAULT NULL,
  `queuemetrics_log_id` varchar(10) DEFAULT 'VIC',
  `queuemetrics_eq_prepend` varchar(255) DEFAULT 'NONE',
  `vicidial_agent_disable` enum('NOT_ACTIVE','LIVE_AGENT','EXTERNAL','ALL') DEFAULT 'ALL',
  `allow_sipsak_messages` enum('0','1') DEFAULT '0',
  `admin_home_url` varchar(255) DEFAULT '../vicidial/welcome.php',
  `enable_agc_xfer_log` enum('0','1') DEFAULT '0',
  `db_schema_version` int(8) unsigned DEFAULT '0',
  `auto_user_add_value` int(9) unsigned DEFAULT '101',
  `timeclock_end_of_day` varchar(4) DEFAULT '0000',
  `timeclock_last_reset_date` date DEFAULT NULL,
  `vdc_header_date_format` varchar(50) DEFAULT 'MS_DASH_24HR  2008-06-24 23:59:59',
  `vdc_customer_date_format` varchar(50) DEFAULT 'AL_TEXT_AMPM  OCT 24, 2008 11:59:59 PM',
  `vdc_header_phone_format` varchar(50) DEFAULT 'US_PARN (000)000-0000',
  `vdc_agent_api_active` enum('0','1') DEFAULT '0',
  `qc_last_pull_time` datetime DEFAULT NULL,
  `enable_vtiger_integration` enum('0','1') DEFAULT '0',
  `vtiger_server_ip` varchar(15) DEFAULT NULL,
  `vtiger_dbname` varchar(50) DEFAULT NULL,
  `vtiger_login` varchar(50) DEFAULT NULL,
  `vtiger_pass` varchar(50) DEFAULT NULL,
  `vtiger_url` varchar(255) DEFAULT NULL,
  `qc_features_active` enum('1','0') DEFAULT '0',
  `outbound_autodial_active` enum('1','0') DEFAULT '1',
  `outbound_calls_per_second` smallint(3) unsigned DEFAULT '40',
  `enable_tts_integration` enum('0','1') DEFAULT '0',
  `agentonly_callback_campaign_lock` enum('0','1') DEFAULT '1',
  `sounds_central_control_active` enum('0','1') DEFAULT '0',
  `sounds_web_server` varchar(50) DEFAULT '127.0.0.1',
  `sounds_web_directory` varchar(255) DEFAULT '',
  `active_voicemail_server` varchar(15) DEFAULT '',
  `auto_dial_limit` varchar(5) DEFAULT '4',
  `user_territories_active` enum('0','1') DEFAULT '0',
  `allow_custom_dialplan` enum('0','1') DEFAULT '0',
  `db_schema_update_date` datetime DEFAULT NULL,
  `enable_second_webform` enum('0','1') DEFAULT '0',
  `default_webphone` enum('1','0') DEFAULT '0',
  `default_external_server_ip` enum('1','0') DEFAULT '0',
  `webphone_url` varchar(255) DEFAULT '',
  `static_agent_url` varchar(255) DEFAULT '',
  `default_phone_code` varchar(8) DEFAULT '1',
  `enable_agc_dispo_log` enum('0','1') DEFAULT '0',
  `custom_dialplan_entry` text,
  `queuemetrics_loginout` enum('STANDARD','CALLBACK','NONE') DEFAULT 'STANDARD',
  `callcard_enabled` enum('1','0') DEFAULT '0',
  `queuemetrics_callstatus` enum('0','1') DEFAULT '1',
  `default_codecs` varchar(100) DEFAULT '',
  `custom_fields_enabled` enum('0','1') DEFAULT '0',
  `admin_web_directory` varchar(255) DEFAULT 'vicidial',
  `label_title` varchar(60) DEFAULT '',
  `label_first_name` varchar(60) DEFAULT '',
  `label_middle_initial` varchar(60) DEFAULT '',
  `label_last_name` varchar(60) DEFAULT '',
  `label_address1` varchar(60) DEFAULT '',
  `label_address2` varchar(60) DEFAULT '',
  `label_address3` varchar(60) DEFAULT '',
  `label_city` varchar(60) DEFAULT '',
  `label_state` varchar(60) DEFAULT '',
  `label_province` varchar(60) DEFAULT '',
  `label_postal_code` varchar(60) DEFAULT '',
  `label_vendor_lead_code` varchar(60) DEFAULT '',
  `label_gender` varchar(60) DEFAULT '',
  `label_phone_number` varchar(60) DEFAULT '',
  `label_phone_code` varchar(60) DEFAULT '',
  `label_alt_phone` varchar(60) DEFAULT '',
  `label_security_phrase` varchar(60) DEFAULT '',
  `label_email` varchar(60) DEFAULT '',
  `label_comments` varchar(60) DEFAULT '',
  `slave_db_server` varchar(50) DEFAULT '',
  `reports_use_slave_db` varchar(2000) DEFAULT '',
  `webphone_systemkey` varchar(100) DEFAULT '',
  `first_login_trigger` enum('Y','N') DEFAULT 'N',
  `hosted_settings` varchar(100) DEFAULT '',
  `default_phone_registration_password` varchar(100) DEFAULT 'test',
  `default_phone_login_password` varchar(100) DEFAULT 'test',
  `default_server_password` varchar(100) DEFAULT 'test',
  `admin_modify_refresh` smallint(5) unsigned DEFAULT '0',
  `nocache_admin` enum('0','1') DEFAULT '1',
  `generate_cross_server_exten` enum('0','1') DEFAULT '0',
  `queuemetrics_addmember_enabled` enum('0','1') DEFAULT '0',
  `queuemetrics_dispo_pause` varchar(6) DEFAULT '',
  `label_hide_field_logs` varchar(6) DEFAULT 'Y',
  `queuemetrics_pe_phone_append` enum('0','1') DEFAULT '0',
  `test_campaign_calls` enum('0','1') DEFAULT '0',
  `agents_calls_reset` enum('0','1') DEFAULT '1',
  `voicemail_timezones` text,
  `default_voicemail_timezone` varchar(30) DEFAULT 'eastern',
  `default_local_gmt` varchar(6) DEFAULT '-5.00',
  `noanswer_log` enum('Y','N') DEFAULT 'N',
  `alt_log_server_ip` varchar(50) DEFAULT '',
  `alt_log_dbname` varchar(50) DEFAULT '',
  `alt_log_login` varchar(50) DEFAULT '',
  `alt_log_pass` varchar(50) DEFAULT '',
  `tables_use_alt_log_db` varchar(2000) DEFAULT '',
  `did_agent_log` enum('Y','N') DEFAULT 'N',
  `campaign_cid_areacodes_enabled` enum('0','1') DEFAULT '1',
  `pllb_grouping_limit` smallint(5) DEFAULT '100',
  `did_ra_extensions_enabled` enum('0','1') DEFAULT '0',
  `expanded_list_stats` enum('0','1') DEFAULT '1',
  `contacts_enabled` enum('0','1') DEFAULT '0',
  `svn_version` varchar(100) DEFAULT '',
  `call_menu_qualify_enabled` enum('0','1') DEFAULT '0',
  `admin_list_counts` enum('0','1') DEFAULT '1',
  `allow_voicemail_greeting` enum('0','1') DEFAULT '0',
  `audio_store_purge` text,
  `svn_revision` int(9) DEFAULT '0',
  `queuemetrics_socket` varchar(20) DEFAULT 'NONE',
  `queuemetrics_socket_url` text,
  `enhanced_disconnect_logging` enum('0','1') DEFAULT '0',
  `allow_emails` enum('0','1') DEFAULT '0',
  `level_8_disable_add` enum('0','1') DEFAULT '0',
  `pass_hash_enabled` enum('0','1') DEFAULT '0',
  `pass_key` varchar(100) DEFAULT '',
  `pass_cost` tinyint(2) unsigned DEFAULT '2',
  `disable_auto_dial` enum('0','1') DEFAULT '0',
  `queuemetrics_record_hold` enum('0','1') DEFAULT '0',
  `country_code_list_stats` enum('0','1') DEFAULT '0',
  `reload_timestamp` datetime DEFAULT NULL,
  `queuemetrics_pause_type` enum('0','1') DEFAULT '0',
  `frozen_server_call_clear` enum('0','1') DEFAULT '0',
  `default_language` varchar(10) DEFAULT 'en_us',
  `callback_time_24hour` enum('0','1') DEFAULT '0',
  `active_modules` text,
  `allow_chats` enum('0','1') DEFAULT '0',
  `enable_languages` enum('0','1') DEFAULT '0',
  `language_method` varchar(20) DEFAULT 'DISABLED',
  `meetme_enter_login_filename` varchar(255) DEFAULT '',
  `meetme_enter_leave3way_filename` varchar(255) DEFAULT '',
  `enable_did_entry_list_id` enum('0','1') DEFAULT '0',
  `enable_third_webform` enum('0','1') DEFAULT '0',
  `chat_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `chat_timeout` int(3) unsigned DEFAULT NULL,
  `agent_debug_logging` varchar(20) DEFAULT '0',
  `agent_whisper_enabled` enum('0','1') DEFAULT '0',
  `user_hide_realtime_enabled` enum('0','1') DEFAULT '0',
  `custom_reports_use_slave_db` varchar(2000) DEFAULT '',
  `usacan_phone_dialcode_fix` enum('0','1') DEFAULT '0',
  `cache_carrier_stats_realtime` enum('0','1') DEFAULT '0',
  `oldest_logs_date` datetime DEFAULT NULL,
  `log_recording_access` enum('0','1') DEFAULT '0',
  `report_default_format` enum('TEXT','HTML') DEFAULT 'TEXT',
  `alt_ivr_logging` enum('0','1') DEFAULT '0',
  `admin_row_click` enum('0','1') DEFAULT '1',
  `admin_screen_colors` varchar(20) DEFAULT 'default',
  `ofcom_uk_drop_calc` enum('1','0') DEFAULT '0',
  `agent_chat_screen_colors` varchar(20) DEFAULT 'default',
  `enable_auto_reports` enum('1','0') DEFAULT '0',
  `enable_pause_code_limits` enum('1','0') DEFAULT '0',
  `enable_drop_lists` enum('0','1','2') DEFAULT '0',
  `allow_ip_lists` enum('0','1','2') DEFAULT '0',
  `system_ip_blacklist` varchar(30) DEFAULT '',
  `agent_push_events` enum('0','1') DEFAULT '0',
  `agent_push_url` text,
  `hide_inactive_lists` enum('0','1') DEFAULT '0',
  `allow_manage_active_lists` enum('0','1') DEFAULT '0',
  `expired_lists_inactive` enum('0','1') DEFAULT '0',
  `did_system_filter` enum('0','1') DEFAULT '0',
  `anyone_callback_inactive_lists` enum('default','NO_ADD_TO_HOPPER','KEEP_IN_HOPPER') DEFAULT 'default',
  `enable_gdpr_download_deletion` enum('0','1','2') DEFAULT '0',
  `source_id_display` enum('0','1') DEFAULT '0',
  `agent_screen_colors` varchar(20) DEFAULT 'default',
  `script_remove_js` enum('1','0') DEFAULT '1',
  `manual_auto_next` enum('1','0') DEFAULT '0',
  `user_new_lead_limit` enum('1','0') DEFAULT '0',
  `agent_xfer_park_3way` enum('1','0') DEFAULT '0',
  `rec_prompt_count` int(9) unsigned DEFAULT '0',
  `agent_soundboards` enum('1','0') DEFAULT '0',
  `web_loader_phone_length` varchar(10) DEFAULT 'DISABLED',
  `agent_script` varchar(50) DEFAULT 'vicidial.php',
  `vdad_debug_logging` enum('1','0') DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_settings`
--

LOCK TABLES `system_settings` WRITE;
/*!40000 ALTER TABLE `system_settings` DISABLE KEYS */;
INSERT INTO `system_settings` VALUES ('2.14b0.5','2009-04-19','0','0','0','','','','','','VIC','NONE','ALL','0','../login/','0',1541,101,'0000','2014-01-29','MS_DASH_24HR  2008-06-24 23:59:59','MS_DASH_24HR  2008-06-24 23:59:59','US_PARN (000)000-0000','0','2009-04-19 22:42:08','0','','','','','','0','1',40,'0','1','1','gadcs.justgocloud.com','c9dxwnxfmyp14sydn43f4h8tdxn1xh','66.165.230.44','20','0','1','2018-08-19 20:10:49','1','0','0','','','1','0','','STANDARD','0','1','','1','vicidial','','','','','Address','---HIDE---','---HIDE---','','','---HIDE---','','','---HIDE---','','','','','','','','','','N','','G02x16','G02x16','G02x16',0,'1','0','0','','Y','0','0','1','newzealand=Pacific/Auckland\naustraliaeast=Australia/Sydney\naustraliacentral=Australia/Adelaide\naustraliawest=Australia/Perth\njapan=Asia/Tokyo\nphilippines=Asia/Manila\nchina=Asia/Shanghai\nmalaysia=Asia/Kuala_Lumpur\nthailand=Asia/Bangkok\nindia=Asia/Calcutta\npakistan=Asia/Karachi\nrussiaeast=Europe/Moscow\nkenya=Africa/Nairobi\neuropeaneast=Europe/Kiev\nsouthafrica=Africa/Johannesburg\neuropean=Europe/Copenhagen\nnigeria=Africa/Lagos\nuk=Europe/London\nbrazil=America/Sao_Paulo\nnewfoundland=Canada/Newfoundland\ncarribeaneast=America/Santo_Domingo\natlantic=Canada/Atlantic\nchile=America/Santiago\neastern=America/New_York\nperu=America/Lima\ncentral=America/Chicago\nmexicocity=America/Mexico_City\nmountain=America/Denver\narizona=America/Phoenix\nsaskatchewan=America/Saskatchewan\npacific=America/Los_Angeles\nalaska=America/Anchorage\nhawaii=Pacific/Honolulu\neastern24=America/New_York\ncentral24=America/Chicago\nmountain24=America/Denver\npacific24=America/Los_Angeles\nmilitary=Zulu\n','eastern','1.00','N','','','','','','N','1',100,'0','1','0','','0','1','0',NULL,2552,'NONE','','0','0','0','1','DIapgKfF5fQWEYMY',12,'0','0','0','2014-09-15 07:30:28','0','0','en_us','0',NULL,'0','0','DISABLED','','','0','0','',0,'0','0','0','','0','0',NULL,'0','TEXT','0','1','default','0','default','0','0','0','0','','0',NULL,'0','0','0','0','default','0','0','default','1','0','0','0',0,'0','DISABLED','vicidial.php','0');
/*!40000 ALTER TABLE `system_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `temp_recording_view`
--

DROP TABLE IF EXISTS `temp_recording_view`;
/*!50001 DROP VIEW IF EXISTS `temp_recording_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `temp_recording_view` (
  `recording_id` tinyint NOT NULL,
  `lead_id` tinyint NOT NULL,
  `phone` tinyint NOT NULL,
  `call_date` tinyint NOT NULL,
  `duration` tinyint NOT NULL,
  `agent` tinyint NOT NULL,
  `disposition` tinyint NOT NULL,
  `campaign_dispo` tinyint NOT NULL,
  `fullname` tinyint NOT NULL,
  `location` tinyint NOT NULL,
  `filename` tinyint NOT NULL,
  `list_id` tinyint NOT NULL,
  `user_group` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `twoday_call_log`
--

DROP TABLE IF EXISTS `twoday_call_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twoday_call_log` (
  `uniqueid` varchar(20) NOT NULL,
  `channel` varchar(100) DEFAULT NULL,
  `channel_group` varchar(30) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `server_ip` varchar(15) DEFAULT NULL,
  `extension` varchar(100) DEFAULT NULL,
  `number_dialed` varchar(15) DEFAULT NULL,
  `caller_code` varchar(20) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `start_epoch` int(10) DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `end_epoch` int(10) DEFAULT NULL,
  `length_in_sec` int(10) DEFAULT NULL,
  `length_in_min` double(8,2) DEFAULT NULL,
  PRIMARY KEY (`uniqueid`),
  KEY `caller_code` (`caller_code`),
  KEY `server_ip` (`server_ip`),
  KEY `channel` (`channel`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twoday_call_log`
--

LOCK TABLES `twoday_call_log` WRITE;
/*!40000 ALTER TABLE `twoday_call_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `twoday_call_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twoday_recording_log`
--

DROP TABLE IF EXISTS `twoday_recording_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twoday_recording_log` (
  `recording_id` int(10) unsigned NOT NULL,
  `channel` varchar(100) DEFAULT NULL,
  `server_ip` varchar(15) DEFAULT NULL,
  `extension` varchar(100) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `start_epoch` int(10) unsigned DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `end_epoch` int(10) unsigned DEFAULT NULL,
  `length_in_sec` mediumint(8) unsigned DEFAULT NULL,
  `length_in_min` double(8,2) DEFAULT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `vicidial_id` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`recording_id`),
  KEY `filename` (`filename`),
  KEY `lead_id` (`lead_id`),
  KEY `user` (`user`),
  KEY `vicidial_id` (`vicidial_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twoday_recording_log`
--

LOCK TABLES `twoday_recording_log` WRITE;
/*!40000 ALTER TABLE `twoday_recording_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `twoday_recording_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twoday_vicidial_agent_log`
--

DROP TABLE IF EXISTS `twoday_vicidial_agent_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twoday_vicidial_agent_log` (
  `agent_log_id` int(9) unsigned NOT NULL,
  `user` varchar(20) DEFAULT NULL,
  `server_ip` varchar(15) NOT NULL,
  `event_time` datetime DEFAULT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `campaign_id` varchar(8) DEFAULT NULL,
  `pause_epoch` int(10) unsigned DEFAULT NULL,
  `pause_sec` smallint(5) unsigned DEFAULT '0',
  `wait_epoch` int(10) unsigned DEFAULT NULL,
  `wait_sec` smallint(5) unsigned DEFAULT '0',
  `talk_epoch` int(10) unsigned DEFAULT NULL,
  `talk_sec` smallint(5) unsigned DEFAULT '0',
  `dispo_epoch` int(10) unsigned DEFAULT NULL,
  `dispo_sec` smallint(5) unsigned DEFAULT '0',
  `status` varchar(6) DEFAULT NULL,
  `user_group` varchar(20) DEFAULT NULL,
  `comments` varchar(20) DEFAULT NULL,
  `sub_status` varchar(6) DEFAULT NULL,
  `dead_epoch` int(10) unsigned DEFAULT NULL,
  `dead_sec` smallint(5) unsigned DEFAULT '0',
  PRIMARY KEY (`agent_log_id`),
  KEY `lead_id` (`lead_id`),
  KEY `user` (`user`),
  KEY `event_time` (`event_time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twoday_vicidial_agent_log`
--

LOCK TABLES `twoday_vicidial_agent_log` WRITE;
/*!40000 ALTER TABLE `twoday_vicidial_agent_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `twoday_vicidial_agent_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twoday_vicidial_closer_log`
--

DROP TABLE IF EXISTS `twoday_vicidial_closer_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twoday_vicidial_closer_log` (
  `closecallid` int(9) unsigned NOT NULL,
  `lead_id` int(9) unsigned NOT NULL,
  `list_id` bigint(14) unsigned DEFAULT NULL,
  `campaign_id` varchar(20) DEFAULT NULL,
  `call_date` datetime DEFAULT NULL,
  `start_epoch` int(10) unsigned DEFAULT NULL,
  `end_epoch` int(10) unsigned DEFAULT NULL,
  `length_in_sec` int(10) DEFAULT NULL,
  `status` varchar(6) DEFAULT NULL,
  `phone_code` varchar(10) DEFAULT NULL,
  `phone_number` varchar(18) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `processed` enum('Y','N') DEFAULT NULL,
  `queue_seconds` decimal(7,2) DEFAULT '0.00',
  `user_group` varchar(20) DEFAULT NULL,
  `xfercallid` int(9) unsigned DEFAULT NULL,
  `term_reason` enum('CALLER','AGENT','QUEUETIMEOUT','ABANDON','AFTERHOURS','HOLDRECALLXFER','HOLDTIME','NOAGENT','NONE') DEFAULT 'NONE',
  `uniqueid` varchar(20) NOT NULL DEFAULT '',
  `agent_only` varchar(20) DEFAULT '',
  PRIMARY KEY (`closecallid`),
  KEY `lead_id` (`lead_id`),
  KEY `call_date` (`call_date`),
  KEY `campaign_id` (`campaign_id`),
  KEY `uniqueid` (`uniqueid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twoday_vicidial_closer_log`
--

LOCK TABLES `twoday_vicidial_closer_log` WRITE;
/*!40000 ALTER TABLE `twoday_vicidial_closer_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `twoday_vicidial_closer_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twoday_vicidial_log`
--

DROP TABLE IF EXISTS `twoday_vicidial_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twoday_vicidial_log` (
  `uniqueid` varchar(20) NOT NULL,
  `lead_id` int(9) unsigned NOT NULL,
  `list_id` bigint(14) unsigned DEFAULT NULL,
  `campaign_id` varchar(8) DEFAULT NULL,
  `call_date` datetime DEFAULT NULL,
  `start_epoch` int(10) unsigned DEFAULT NULL,
  `end_epoch` int(10) unsigned DEFAULT NULL,
  `length_in_sec` int(10) DEFAULT NULL,
  `status` varchar(6) DEFAULT NULL,
  `phone_code` varchar(10) DEFAULT NULL,
  `phone_number` varchar(18) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `processed` enum('Y','N') DEFAULT NULL,
  `user_group` varchar(20) DEFAULT NULL,
  `term_reason` enum('CALLER','AGENT','QUEUETIMEOUT','ABANDON','AFTERHOURS','NONE') DEFAULT 'NONE',
  `alt_dial` varchar(6) DEFAULT 'NONE',
  PRIMARY KEY (`uniqueid`),
  KEY `lead_id` (`lead_id`),
  KEY `call_date` (`call_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twoday_vicidial_log`
--

LOCK TABLES `twoday_vicidial_log` WRITE;
/*!40000 ALTER TABLE `twoday_vicidial_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `twoday_vicidial_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twoday_vicidial_xfer_log`
--

DROP TABLE IF EXISTS `twoday_vicidial_xfer_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twoday_vicidial_xfer_log` (
  `xfercallid` int(9) unsigned NOT NULL,
  `lead_id` int(9) unsigned NOT NULL,
  `list_id` bigint(14) unsigned DEFAULT NULL,
  `campaign_id` varchar(20) DEFAULT NULL,
  `call_date` datetime DEFAULT NULL,
  `phone_code` varchar(10) DEFAULT NULL,
  `phone_number` varchar(18) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `closer` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`xfercallid`),
  KEY `lead_id` (`lead_id`),
  KEY `call_date` (`call_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twoday_vicidial_xfer_log`
--

LOCK TABLES `twoday_vicidial_xfer_log` WRITE;
/*!40000 ALTER TABLE `twoday_vicidial_xfer_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `twoday_vicidial_xfer_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_call_log`
--

DROP TABLE IF EXISTS `user_call_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_call_log` (
  `user_call_log_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(20) DEFAULT NULL,
  `call_date` datetime DEFAULT NULL,
  `call_type` varchar(20) DEFAULT NULL,
  `server_ip` varchar(15) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `number_dialed` varchar(30) DEFAULT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `callerid` varchar(20) DEFAULT NULL,
  `group_alias_id` varchar(30) DEFAULT NULL,
  `preset_name` varchar(40) DEFAULT '',
  `campaign_id` varchar(20) DEFAULT '',
  `customer_hungup` enum('BEFORE_CALL','DURING_CALL','') DEFAULT '',
  `customer_hungup_seconds` smallint(5) unsigned DEFAULT '0',
  `xfer_hungup` varchar(20) DEFAULT '',
  `xfer_hungup_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`user_call_log_id`),
  KEY `user` (`user`),
  KEY `call_date` (`call_date`),
  KEY `group_alias_id` (`group_alias_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2064 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_call_log`
--

LOCK TABLES `user_call_log` WRITE;
/*!40000 ALTER TABLE `user_call_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_call_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_call_log_archive`
--

DROP TABLE IF EXISTS `user_call_log_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_call_log_archive` (
  `user_call_log_id` int(9) unsigned NOT NULL,
  `user` varchar(20) DEFAULT NULL,
  `call_date` datetime DEFAULT NULL,
  `call_type` varchar(20) DEFAULT NULL,
  `server_ip` varchar(15) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `number_dialed` varchar(30) DEFAULT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `callerid` varchar(20) DEFAULT NULL,
  `group_alias_id` varchar(30) DEFAULT NULL,
  `preset_name` varchar(40) DEFAULT '',
  `campaign_id` varchar(20) DEFAULT '',
  `customer_hungup` enum('BEFORE_CALL','DURING_CALL','') DEFAULT '',
  `customer_hungup_seconds` smallint(5) unsigned DEFAULT '0',
  `xfer_hungup` varchar(20) DEFAULT '',
  `xfer_hungup_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`user_call_log_id`),
  KEY `user` (`user`),
  KEY `call_date` (`call_date`),
  KEY `group_alias_id` (`group_alias_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_call_log_archive`
--

LOCK TABLES `user_call_log_archive` WRITE;
/*!40000 ALTER TABLE `user_call_log_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_call_log_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_admin_log`
--

DROP TABLE IF EXISTS `vicidial_admin_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_admin_log` (
  `admin_log_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `event_date` datetime NOT NULL,
  `user` varchar(20) NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `event_section` varchar(30) NOT NULL,
  `event_type` enum('ADD','COPY','LOAD','RESET','MODIFY','DELETE','SEARCH','LOGIN','LOGOUT','CLEAR','OVERRIDE','EXPORT','OTHER') DEFAULT 'OTHER',
  `record_id` varchar(50) NOT NULL,
  `event_code` varchar(255) NOT NULL,
  `event_sql` mediumtext,
  `event_notes` mediumtext,
  `user_group` varchar(20) DEFAULT '---ALL---',
  PRIMARY KEY (`admin_log_id`),
  KEY `user` (`user`),
  KEY `event_section` (`event_section`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_admin_log`
--

LOCK TABLES `vicidial_admin_log` WRITE;
/*!40000 ALTER TABLE `vicidial_admin_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_admin_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_agent_function_log`
--

DROP TABLE IF EXISTS `vicidial_agent_function_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_agent_function_log` (
  `agent_function_log_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `agent_log_id` int(9) unsigned DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `function` varchar(20) DEFAULT NULL,
  `event_time` datetime DEFAULT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `campaign_id` varchar(8) DEFAULT NULL,
  `user_group` varchar(20) DEFAULT NULL,
  `caller_code` varchar(30) DEFAULT '',
  `comments` varchar(40) DEFAULT '',
  `stage` varchar(40) DEFAULT '',
  `uniqueid` varchar(20) DEFAULT '',
  PRIMARY KEY (`agent_function_log_id`),
  KEY `event_time` (`event_time`),
  KEY `caller_code` (`caller_code`),
  KEY `user` (`user`),
  KEY `lead_id` (`lead_id`),
  KEY `stage` (`stage`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_agent_function_log`
--

LOCK TABLES `vicidial_agent_function_log` WRITE;
/*!40000 ALTER TABLE `vicidial_agent_function_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_agent_function_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_agent_function_log_archive`
--

DROP TABLE IF EXISTS `vicidial_agent_function_log_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_agent_function_log_archive` (
  `agent_function_log_id` int(9) unsigned NOT NULL,
  `agent_log_id` int(9) unsigned DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `function` varchar(20) DEFAULT NULL,
  `event_time` datetime DEFAULT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `campaign_id` varchar(8) DEFAULT NULL,
  `user_group` varchar(20) DEFAULT NULL,
  `caller_code` varchar(30) DEFAULT '',
  `comments` varchar(40) DEFAULT '',
  `stage` varchar(40) DEFAULT '',
  `uniqueid` varchar(20) DEFAULT '',
  PRIMARY KEY (`agent_function_log_id`),
  KEY `event_time` (`event_time`),
  KEY `caller_code` (`caller_code`),
  KEY `user` (`user`),
  KEY `lead_id` (`lead_id`),
  KEY `stage` (`stage`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_agent_function_log_archive`
--

LOCK TABLES `vicidial_agent_function_log_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_agent_function_log_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_agent_function_log_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_agent_log`
--

DROP TABLE IF EXISTS `vicidial_agent_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_agent_log` (
  `agent_log_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(20) DEFAULT NULL,
  `server_ip` varchar(15) NOT NULL,
  `event_time` datetime DEFAULT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `campaign_id` varchar(8) DEFAULT NULL,
  `pause_epoch` int(10) unsigned DEFAULT NULL,
  `pause_sec` smallint(5) unsigned DEFAULT '0',
  `wait_epoch` int(10) unsigned DEFAULT NULL,
  `wait_sec` smallint(5) unsigned DEFAULT '0',
  `talk_epoch` int(10) unsigned DEFAULT NULL,
  `talk_sec` smallint(5) unsigned DEFAULT '0',
  `dispo_epoch` int(10) unsigned DEFAULT NULL,
  `dispo_sec` smallint(5) unsigned DEFAULT '0',
  `status` varchar(6) DEFAULT NULL,
  `user_group` varchar(20) DEFAULT NULL,
  `comments` varchar(20) DEFAULT NULL,
  `sub_status` varchar(6) DEFAULT NULL,
  `dead_epoch` int(10) unsigned DEFAULT NULL,
  `dead_sec` smallint(5) unsigned DEFAULT '0',
  `processed` enum('Y','N') DEFAULT 'N',
  `uniqueid` varchar(20) DEFAULT '',
  `pause_type` enum('UNDEFINED','SYSTEM','AGENT','API','ADMIN') DEFAULT 'UNDEFINED',
  PRIMARY KEY (`agent_log_id`),
  KEY `lead_id` (`lead_id`),
  KEY `user` (`user`),
  KEY `event_time` (`event_time`),
  KEY `time_user` (`event_time`,`user`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_agent_log`
--

LOCK TABLES `vicidial_agent_log` WRITE;
/*!40000 ALTER TABLE `vicidial_agent_log` DISABLE KEYS */;
INSERT INTO `vicidial_agent_log` VALUES (1,'625931985','127.0.0.1','2018-09-24 05:16:54',NULL,'28222950',1537737414,0,1537737414,0,NULL,0,NULL,0,NULL,'AGENTS',NULL,NULL,NULL,0,'N','','SYSTEM'),(2,'648983183','127.0.0.1','2018-09-24 05:16:54',NULL,'58307174',1537737414,0,1537737414,0,NULL,0,NULL,0,NULL,'AGENTS',NULL,NULL,NULL,0,'N','','SYSTEM');
/*!40000 ALTER TABLE `vicidial_agent_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_agent_log_archive`
--

DROP TABLE IF EXISTS `vicidial_agent_log_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_agent_log_archive` (
  `agent_log_id` int(9) unsigned NOT NULL,
  `user` varchar(20) DEFAULT NULL,
  `server_ip` varchar(15) NOT NULL,
  `event_time` datetime DEFAULT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `campaign_id` varchar(8) DEFAULT NULL,
  `pause_epoch` int(10) unsigned DEFAULT NULL,
  `pause_sec` smallint(5) unsigned DEFAULT '0',
  `wait_epoch` int(10) unsigned DEFAULT NULL,
  `wait_sec` smallint(5) unsigned DEFAULT '0',
  `talk_epoch` int(10) unsigned DEFAULT NULL,
  `talk_sec` smallint(5) unsigned DEFAULT '0',
  `dispo_epoch` int(10) unsigned DEFAULT NULL,
  `dispo_sec` smallint(5) unsigned DEFAULT '0',
  `status` varchar(6) DEFAULT NULL,
  `user_group` varchar(20) DEFAULT NULL,
  `comments` varchar(20) DEFAULT NULL,
  `sub_status` varchar(6) DEFAULT NULL,
  `dead_epoch` int(10) unsigned DEFAULT NULL,
  `dead_sec` smallint(5) unsigned DEFAULT '0',
  `processed` enum('Y','N') DEFAULT 'N',
  `uniqueid` varchar(20) DEFAULT '',
  `pause_type` enum('UNDEFINED','SYSTEM','AGENT','API','ADMIN') DEFAULT 'UNDEFINED',
  PRIMARY KEY (`agent_log_id`),
  KEY `lead_id` (`lead_id`),
  KEY `user` (`user`),
  KEY `event_time` (`event_time`),
  KEY `time_user` (`event_time`,`user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_agent_log_archive`
--

LOCK TABLES `vicidial_agent_log_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_agent_log_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_agent_log_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_agent_skip_log`
--

DROP TABLE IF EXISTS `vicidial_agent_skip_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_agent_skip_log` (
  `user_skip_log_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_date` datetime DEFAULT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `campaign_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `previous_status` varchar(6) COLLATE utf8_unicode_ci DEFAULT '',
  `previous_called_count` smallint(5) unsigned DEFAULT '0',
  PRIMARY KEY (`user_skip_log_id`),
  KEY `user` (`user`),
  KEY `event_date` (`event_date`),
  KEY `campaign_id` (`campaign_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_agent_skip_log`
--

LOCK TABLES `vicidial_agent_skip_log` WRITE;
/*!40000 ALTER TABLE `vicidial_agent_skip_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_agent_skip_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_agent_sph`
--

DROP TABLE IF EXISTS `vicidial_agent_sph`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_agent_sph` (
  `campaign_group_id` varchar(20) NOT NULL,
  `stat_date` date NOT NULL,
  `shift` varchar(20) NOT NULL,
  `role` enum('FRONTER','CLOSER') DEFAULT 'FRONTER',
  `user` varchar(20) NOT NULL,
  `calls` mediumint(8) unsigned DEFAULT '0',
  `sales` mediumint(8) unsigned DEFAULT '0',
  `login_sec` mediumint(8) unsigned DEFAULT '0',
  `login_hours` decimal(5,2) DEFAULT '0.00',
  `sph` decimal(6,2) DEFAULT '0.00',
  KEY `campaign_group_id` (`campaign_group_id`),
  KEY `stat_date` (`stat_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_agent_sph`
--

LOCK TABLES `vicidial_agent_sph` WRITE;
/*!40000 ALTER TABLE `vicidial_agent_sph` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_agent_sph` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_ajax_log`
--

DROP TABLE IF EXISTS `vicidial_ajax_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_ajax_log` (
  `user` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `start_time` datetime NOT NULL,
  `db_time` datetime NOT NULL,
  `run_time` varchar(20) COLLATE utf8_unicode_ci DEFAULT '0',
  `php_script` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `lead_id` int(10) unsigned DEFAULT '0',
  `stage` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `session_name` varchar(40) COLLATE utf8_unicode_ci DEFAULT '',
  `last_sql` text COLLATE utf8_unicode_ci,
  KEY `ajax_dbtime_key` (`db_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_ajax_log`
--

LOCK TABLES `vicidial_ajax_log` WRITE;
/*!40000 ALTER TABLE `vicidial_ajax_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_ajax_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_amm_multi`
--

DROP TABLE IF EXISTS `vicidial_amm_multi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_amm_multi` (
  `amm_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `campaign_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `entry_type` enum('campaign','ingroup','list','') COLLATE utf8_unicode_ci DEFAULT '',
  `active` enum('Y','N') COLLATE utf8_unicode_ci DEFAULT 'N',
  `amm_field` varchar(30) COLLATE utf8_unicode_ci DEFAULT 'vendor_lead_code',
  `amm_rank` smallint(5) DEFAULT '1',
  `amm_wildcard` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `amm_filename` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `amm_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  PRIMARY KEY (`amm_id`),
  KEY `vicidial_AMM_multi_campaign_id_key` (`campaign_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_amm_multi`
--

LOCK TABLES `vicidial_amm_multi` WRITE;
/*!40000 ALTER TABLE `vicidial_amm_multi` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_amm_multi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_api_log`
--

DROP TABLE IF EXISTS `vicidial_api_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_api_log` (
  `api_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(20) NOT NULL,
  `api_date` datetime DEFAULT NULL,
  `api_script` varchar(10) DEFAULT NULL,
  `function` varchar(20) NOT NULL,
  `agent_user` varchar(20) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `result` varchar(10) DEFAULT NULL,
  `result_reason` varchar(255) DEFAULT NULL,
  `source` varchar(20) DEFAULT NULL,
  `data` text,
  `run_time` varchar(20) DEFAULT '0',
  `webserver` smallint(5) unsigned DEFAULT '0',
  `api_url` int(9) unsigned DEFAULT '0',
  PRIMARY KEY (`api_id`),
  KEY `api_date` (`api_date`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_api_log`
--

LOCK TABLES `vicidial_api_log` WRITE;
/*!40000 ALTER TABLE `vicidial_api_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_api_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_api_log_archive`
--

DROP TABLE IF EXISTS `vicidial_api_log_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_api_log_archive` (
  `api_id` int(9) unsigned NOT NULL,
  `user` varchar(20) NOT NULL,
  `api_date` datetime DEFAULT NULL,
  `api_script` varchar(10) DEFAULT NULL,
  `function` varchar(20) NOT NULL,
  `agent_user` varchar(20) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `result` varchar(10) DEFAULT NULL,
  `result_reason` varchar(255) DEFAULT NULL,
  `source` varchar(20) DEFAULT NULL,
  `data` text,
  `run_time` varchar(20) DEFAULT '0',
  `webserver` smallint(5) unsigned DEFAULT '0',
  `api_url` int(9) unsigned DEFAULT '0',
  PRIMARY KEY (`api_id`),
  KEY `api_date` (`api_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_api_log_archive`
--

LOCK TABLES `vicidial_api_log_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_api_log_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_api_log_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_api_urls`
--

DROP TABLE IF EXISTS `vicidial_api_urls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_api_urls` (
  `api_id` int(9) unsigned NOT NULL,
  `api_date` datetime DEFAULT NULL,
  `remote_ip` varchar(50) DEFAULT NULL,
  `url` mediumtext,
  PRIMARY KEY (`api_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_api_urls`
--

LOCK TABLES `vicidial_api_urls` WRITE;
/*!40000 ALTER TABLE `vicidial_api_urls` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_api_urls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_api_urls_archive`
--

DROP TABLE IF EXISTS `vicidial_api_urls_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_api_urls_archive` (
  `api_id` int(9) unsigned NOT NULL,
  `api_date` datetime DEFAULT NULL,
  `remote_ip` varchar(50) DEFAULT NULL,
  `url` mediumtext,
  PRIMARY KEY (`api_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_api_urls_archive`
--

LOCK TABLES `vicidial_api_urls_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_api_urls_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_api_urls_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_areacode_filters`
--

DROP TABLE IF EXISTS `vicidial_areacode_filters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_areacode_filters` (
  `group_id` varchar(20) NOT NULL,
  `areacode` varchar(6) NOT NULL,
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_areacode_filters`
--

LOCK TABLES `vicidial_areacode_filters` WRITE;
/*!40000 ALTER TABLE `vicidial_areacode_filters` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_areacode_filters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_asterisk_output`
--

DROP TABLE IF EXISTS `vicidial_asterisk_output`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_asterisk_output` (
  `server_ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `sip_peers` mediumtext COLLATE utf8_unicode_ci,
  `iax_peers` mediumtext COLLATE utf8_unicode_ci,
  `asterisk` mediumtext COLLATE utf8_unicode_ci,
  `update_date` datetime DEFAULT NULL,
  UNIQUE KEY `server_ip` (`server_ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_asterisk_output`
--

LOCK TABLES `vicidial_asterisk_output` WRITE;
/*!40000 ALTER TABLE `vicidial_asterisk_output` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_asterisk_output` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_auto_calls`
--

DROP TABLE IF EXISTS `vicidial_auto_calls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_auto_calls` (
  `auto_call_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `server_ip` varchar(15) NOT NULL,
  `campaign_id` varchar(20) DEFAULT NULL,
  `status` enum('SENT','RINGING','LIVE','XFER','PAUSED','CLOSER','BUSY','DISCONNECT','IVR') DEFAULT 'PAUSED',
  `lead_id` int(9) unsigned NOT NULL,
  `uniqueid` varchar(20) DEFAULT NULL,
  `callerid` varchar(20) DEFAULT NULL,
  `channel` varchar(100) DEFAULT NULL,
  `phone_code` varchar(10) DEFAULT NULL,
  `phone_number` varchar(18) DEFAULT NULL,
  `call_time` datetime DEFAULT NULL,
  `call_type` enum('IN','OUT','OUTBALANCE') DEFAULT 'OUT',
  `stage` varchar(20) DEFAULT 'START',
  `last_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `alt_dial` varchar(6) DEFAULT 'NONE',
  `queue_priority` tinyint(2) DEFAULT '0',
  `agent_only` varchar(20) DEFAULT '',
  `agent_grab` varchar(20) DEFAULT '',
  `queue_position` smallint(4) unsigned DEFAULT '1',
  `extension` varchar(100) DEFAULT '',
  `agent_grab_extension` varchar(100) DEFAULT '',
  PRIMARY KEY (`auto_call_id`),
  KEY `uniqueid` (`uniqueid`),
  KEY `callerid` (`callerid`),
  KEY `call_time` (`call_time`),
  KEY `last_update_time` (`last_update_time`)
) ENGINE=MEMORY DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_auto_calls`
--

LOCK TABLES `vicidial_auto_calls` WRITE;
/*!40000 ALTER TABLE `vicidial_auto_calls` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_auto_calls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_automated_reports`
--

DROP TABLE IF EXISTS `vicidial_automated_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_automated_reports` (
  `report_id` varchar(30) NOT NULL,
  `report_name` varchar(100) DEFAULT NULL,
  `report_last_run` datetime DEFAULT NULL,
  `report_last_length` smallint(5) DEFAULT '0',
  `report_server` varchar(30) DEFAULT 'active_voicemail_server',
  `report_times` varchar(255) DEFAULT '',
  `report_weekdays` varchar(7) DEFAULT '',
  `report_monthdays` varchar(100) DEFAULT '',
  `report_destination` enum('EMAIL','FTP') DEFAULT 'EMAIL',
  `email_from` varchar(255) DEFAULT '',
  `email_to` varchar(255) DEFAULT '',
  `email_subject` varchar(255) DEFAULT '',
  `ftp_server` varchar(255) DEFAULT '',
  `ftp_user` varchar(255) DEFAULT '',
  `ftp_pass` varchar(255) DEFAULT '',
  `ftp_directory` varchar(255) DEFAULT '',
  `report_url` text,
  `run_now_trigger` enum('N','Y') DEFAULT 'N',
  `active` enum('N','Y') DEFAULT 'N',
  `user_group` varchar(20) DEFAULT '---ALL---',
  `filename_override` varchar(255) DEFAULT '',
  UNIQUE KEY `report_id` (`report_id`),
  KEY `report_times` (`report_times`),
  KEY `run_now_trigger` (`run_now_trigger`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_automated_reports`
--

LOCK TABLES `vicidial_automated_reports` WRITE;
/*!40000 ALTER TABLE `vicidial_automated_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_automated_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_avatar_audio`
--

DROP TABLE IF EXISTS `vicidial_avatar_audio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_avatar_audio` (
  `avatar_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `audio_filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `audio_name` text COLLATE utf8_unicode_ci,
  `rank` smallint(5) DEFAULT '0',
  `h_ord` smallint(5) DEFAULT '1',
  `level` smallint(5) DEFAULT '1',
  `parent_audio_filename` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `parent_rank` varchar(2) COLLATE utf8_unicode_ci DEFAULT '',
  `button_type` varchar(40) COLLATE utf8_unicode_ci DEFAULT 'button',
  `font_size` varchar(3) COLLATE utf8_unicode_ci DEFAULT '2',
  KEY `avatar_id` (`avatar_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_avatar_audio`
--

LOCK TABLES `vicidial_avatar_audio` WRITE;
/*!40000 ALTER TABLE `vicidial_avatar_audio` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_avatar_audio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_avatars`
--

DROP TABLE IF EXISTS `vicidial_avatars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_avatars` (
  `avatar_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `avatar_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar_notes` text COLLATE utf8_unicode_ci,
  `avatar_api_user` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `avatar_api_pass` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `active` enum('Y','N') COLLATE utf8_unicode_ci DEFAULT 'Y',
  `audio_functions` varchar(100) COLLATE utf8_unicode_ci DEFAULT 'PLAY-STOP-RESTART',
  `audio_display` varchar(100) COLLATE utf8_unicode_ci DEFAULT 'FILE-NAME',
  `user_group` varchar(20) COLLATE utf8_unicode_ci DEFAULT '---ALL---',
  `soundboard_layout` varchar(40) COLLATE utf8_unicode_ci DEFAULT 'default',
  `columns_limit` smallint(5) DEFAULT '5',
  PRIMARY KEY (`avatar_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_avatars`
--

LOCK TABLES `vicidial_avatars` WRITE;
/*!40000 ALTER TABLE `vicidial_avatars` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_avatars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_call_menu`
--

DROP TABLE IF EXISTS `vicidial_call_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_call_menu` (
  `menu_id` varchar(50) NOT NULL,
  `menu_name` varchar(100) DEFAULT NULL,
  `menu_prompt` varchar(255) DEFAULT NULL,
  `menu_timeout` smallint(2) unsigned DEFAULT '10',
  `menu_timeout_prompt` varchar(255) DEFAULT 'NONE',
  `menu_invalid_prompt` varchar(255) DEFAULT 'NONE',
  `menu_repeat` tinyint(1) unsigned DEFAULT '0',
  `menu_time_check` enum('0','1') DEFAULT '0',
  `call_time_id` varchar(20) DEFAULT '',
  `track_in_vdac` enum('0','1') DEFAULT '1',
  `custom_dialplan_entry` text,
  `tracking_group` varchar(20) DEFAULT 'CALLMENU',
  `dtmf_log` enum('0','1') DEFAULT '0',
  `dtmf_field` varchar(50) DEFAULT 'NONE',
  `user_group` varchar(20) DEFAULT '---ALL---',
  `qualify_sql` text,
  `alt_dtmf_log` enum('0','1') DEFAULT '0',
  `question` int(11) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_call_menu`
--

LOCK TABLES `vicidial_call_menu` WRITE;
/*!40000 ALTER TABLE `vicidial_call_menu` DISABLE KEYS */;
INSERT INTO `vicidial_call_menu` VALUES ('defaultlog','Default Call Menu','hello-world',20,'NONE','NONE',0,'0','24hours','0','exten => _X.,1,AGI(agi-NVA_recording.agi,BOTH------Y---Y---Y)\nexten => _X.,n,Goto(default,${EXTEN},1)','CALLMENU','0','NONE','---ALL---','','0',0),('defaultcallmenu','Default Call Menu','goWelcomeIVR',10,'','',2,'','24hours','1','','CALLMENU','0','NONE','ADMIN',NULL,'0',NULL);
/*!40000 ALTER TABLE `vicidial_call_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_call_menu_options`
--

DROP TABLE IF EXISTS `vicidial_call_menu_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_call_menu_options` (
  `menu_id` varchar(50) NOT NULL,
  `option_value` varchar(20) NOT NULL DEFAULT '',
  `option_description` varchar(255) DEFAULT '',
  `option_route` varchar(20) DEFAULT NULL,
  `option_route_value` varchar(255) DEFAULT NULL,
  `option_route_value_context` varchar(1000) DEFAULT NULL,
  UNIQUE KEY `menuoption` (`menu_id`,`option_value`),
  KEY `menu_id` (`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_call_menu_options`
--

LOCK TABLES `vicidial_call_menu_options` WRITE;
/*!40000 ALTER TABLE `vicidial_call_menu_options` DISABLE KEYS */;
INSERT INTO `vicidial_call_menu_options` VALUES ('defaultlog','TIMEOUT','hangup','HANGUP','vm-goodbye',''),('giemenu','TIMEOUT','Hangup','HANGUP','vm-goodbye',NULL),('giemenu','1','ingroup','INGROUP','INGGIE','CIDLOOKUP,LB,998,97370454,1,sip-silence,sip-silence,sip-silence,1'),('For IVR Test','TIMEOUT','Hangup','HANGUP','vm-goodbye',NULL),('defaultcallmenu','TIMEOUT','Hangup','HANGUP','vm-goodbye',NULL),('defaultcallmenu','1','Route to Ingroup','INGROUP','AGENTDIRECT','CIDLOOKUP,LB,998,TESTCAMP,1,sip-silence,sip-silence,sip-silence,1');
/*!40000 ALTER TABLE `vicidial_call_menu_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_call_notes`
--

DROP TABLE IF EXISTS `vicidial_call_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_call_notes` (
  `notesid` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `lead_id` int(9) unsigned NOT NULL,
  `vicidial_id` varchar(20) DEFAULT NULL,
  `call_date` datetime DEFAULT NULL,
  `order_id` varchar(20) DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `appointment_time` time DEFAULT NULL,
  `call_notes` text,
  PRIMARY KEY (`notesid`),
  KEY `lead_id` (`lead_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_call_notes`
--

LOCK TABLES `vicidial_call_notes` WRITE;
/*!40000 ALTER TABLE `vicidial_call_notes` DISABLE KEYS */;
INSERT INTO `vicidial_call_notes` VALUES (1,23820,NULL,'2018-04-03 17:32:12',NULL,NULL,NULL,'no audio'),(2,23981,NULL,'2018-05-01 13:22:07',NULL,NULL,NULL,'john medicareabc'),(3,23981,NULL,'2018-05-01 16:15:24',NULL,NULL,NULL,'john medicareabc'),(4,23981,NULL,'2018-05-01 17:18:49',NULL,NULL,NULL,'john medicareabc');
/*!40000 ALTER TABLE `vicidial_call_notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_call_notes_archive`
--

DROP TABLE IF EXISTS `vicidial_call_notes_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_call_notes_archive` (
  `notesid` int(9) unsigned NOT NULL,
  `lead_id` int(9) unsigned NOT NULL,
  `vicidial_id` varchar(20) DEFAULT NULL,
  `call_date` datetime DEFAULT NULL,
  `order_id` varchar(20) DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `appointment_time` time DEFAULT NULL,
  `call_notes` text,
  PRIMARY KEY (`notesid`),
  KEY `lead_id` (`lead_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_call_notes_archive`
--

LOCK TABLES `vicidial_call_notes_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_call_notes_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_call_notes_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_call_time_holidays`
--

DROP TABLE IF EXISTS `vicidial_call_time_holidays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_call_time_holidays` (
  `holiday_id` varchar(30) NOT NULL,
  `holiday_name` varchar(100) NOT NULL,
  `holiday_comments` varchar(255) DEFAULT '',
  `holiday_date` date DEFAULT NULL,
  `holiday_status` enum('ACTIVE','INACTIVE','EXPIRED') DEFAULT 'INACTIVE',
  `ct_default_start` smallint(4) unsigned NOT NULL DEFAULT '900',
  `ct_default_stop` smallint(4) unsigned NOT NULL DEFAULT '2100',
  `default_afterhours_filename_override` varchar(255) DEFAULT '',
  `user_group` varchar(20) DEFAULT '---ALL---',
  PRIMARY KEY (`holiday_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_call_time_holidays`
--

LOCK TABLES `vicidial_call_time_holidays` WRITE;
/*!40000 ALTER TABLE `vicidial_call_time_holidays` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_call_time_holidays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_call_times`
--

DROP TABLE IF EXISTS `vicidial_call_times`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_call_times` (
  `call_time_id` varchar(10) NOT NULL,
  `call_time_name` varchar(30) NOT NULL,
  `call_time_comments` varchar(255) DEFAULT '',
  `ct_default_start` smallint(4) unsigned NOT NULL DEFAULT '900',
  `ct_default_stop` smallint(4) unsigned NOT NULL DEFAULT '2100',
  `ct_sunday_start` smallint(4) unsigned DEFAULT '0',
  `ct_sunday_stop` smallint(4) unsigned DEFAULT '0',
  `ct_monday_start` smallint(4) unsigned DEFAULT '0',
  `ct_monday_stop` smallint(4) unsigned DEFAULT '0',
  `ct_tuesday_start` smallint(4) unsigned DEFAULT '0',
  `ct_tuesday_stop` smallint(4) unsigned DEFAULT '0',
  `ct_wednesday_start` smallint(4) unsigned DEFAULT '0',
  `ct_wednesday_stop` smallint(4) unsigned DEFAULT '0',
  `ct_thursday_start` smallint(4) unsigned DEFAULT '0',
  `ct_thursday_stop` smallint(4) unsigned DEFAULT '0',
  `ct_friday_start` smallint(4) unsigned DEFAULT '0',
  `ct_friday_stop` smallint(4) unsigned DEFAULT '0',
  `ct_saturday_start` smallint(4) unsigned DEFAULT '0',
  `ct_saturday_stop` smallint(4) unsigned DEFAULT '0',
  `ct_state_call_times` text,
  `default_afterhours_filename_override` varchar(255) DEFAULT '',
  `sunday_afterhours_filename_override` varchar(255) DEFAULT '',
  `monday_afterhours_filename_override` varchar(255) DEFAULT '',
  `tuesday_afterhours_filename_override` varchar(255) DEFAULT '',
  `wednesday_afterhours_filename_override` varchar(255) DEFAULT '',
  `thursday_afterhours_filename_override` varchar(255) DEFAULT '',
  `friday_afterhours_filename_override` varchar(255) DEFAULT '',
  `saturday_afterhours_filename_override` varchar(255) DEFAULT '',
  `user_group` varchar(20) DEFAULT '---ALL---',
  `ct_holidays` text,
  PRIMARY KEY (`call_time_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_call_times`
--

LOCK TABLES `vicidial_call_times` WRITE;
/*!40000 ALTER TABLE `vicidial_call_times` DISABLE KEYS */;
INSERT INTO `vicidial_call_times` VALUES ('24hours','default 24 hours calling','',0,2400,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,'','','','','','','','','---ALL---',''),('9am-9pm','default 9am to 9pm calling','',900,2100,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,'','','','','','','','','---ALL---',''),('9am-5pm','default 9am to 5pm calling','',900,1700,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,'','','','','','','','','---ALL---',''),('12pm-5pm','default 12pm to 5pm calling','',1200,500,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,'','','','','','','','','07131983',''),('12pm-9pm','default 12pm to 9pm calling','',1200,1200,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,'','','','','','','','','---ALL---',''),('5pm-9pm','default 5pm to 9pm calling','',1700,2100,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,'','','','','','','','','---ALL---','');
/*!40000 ALTER TABLE `vicidial_call_times` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_callbacks`
--

DROP TABLE IF EXISTS `vicidial_callbacks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_callbacks` (
  `callback_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `list_id` bigint(14) unsigned DEFAULT NULL,
  `campaign_id` varchar(8) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `entry_time` datetime DEFAULT NULL,
  `callback_time` datetime DEFAULT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user` varchar(20) DEFAULT NULL,
  `recipient` enum('USERONLY','ANYONE') DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `user_group` varchar(20) DEFAULT NULL,
  `lead_status` varchar(6) DEFAULT 'CALLBK',
  `email_alert` datetime DEFAULT NULL,
  `email_result` enum('SENT','FAILED','NOT AVAILABLE') DEFAULT NULL,
  PRIMARY KEY (`callback_id`),
  KEY `lead_id` (`lead_id`),
  KEY `status` (`status`),
  KEY `callback_time` (`callback_time`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_callbacks`
--

LOCK TABLES `vicidial_callbacks` WRITE;
/*!40000 ALTER TABLE `vicidial_callbacks` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_callbacks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_callbacks_archive`
--

DROP TABLE IF EXISTS `vicidial_callbacks_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_callbacks_archive` (
  `callback_id` int(9) unsigned NOT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `list_id` bigint(14) unsigned DEFAULT NULL,
  `campaign_id` varchar(8) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `entry_time` datetime DEFAULT NULL,
  `callback_time` datetime DEFAULT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user` varchar(20) DEFAULT NULL,
  `recipient` enum('USERONLY','ANYONE') DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `user_group` varchar(20) DEFAULT NULL,
  `lead_status` varchar(6) DEFAULT 'CALLBK',
  `email_alert` datetime DEFAULT NULL,
  `email_result` enum('SENT','FAILED','NOT AVAILABLE') DEFAULT NULL,
  PRIMARY KEY (`callback_id`),
  KEY `lead_id` (`lead_id`),
  KEY `status` (`status`),
  KEY `callback_time` (`callback_time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_callbacks_archive`
--

LOCK TABLES `vicidial_callbacks_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_callbacks_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_callbacks_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_campaign_agents`
--

DROP TABLE IF EXISTS `vicidial_campaign_agents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_campaign_agents` (
  `user` varchar(20) DEFAULT NULL,
  `campaign_id` varchar(20) DEFAULT NULL,
  `campaign_rank` tinyint(1) DEFAULT '0',
  `campaign_weight` tinyint(1) DEFAULT '0',
  `calls_today` smallint(5) unsigned DEFAULT '0',
  `group_web_vars` varchar(255) DEFAULT '',
  `campaign_grade` tinyint(2) unsigned DEFAULT '1',
  UNIQUE KEY `vlca_user_campaign_id` (`user`,`campaign_id`),
  KEY `campaign_id` (`campaign_id`),
  KEY `user` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_campaign_agents`
--

LOCK TABLES `vicidial_campaign_agents` WRITE;
/*!40000 ALTER TABLE `vicidial_campaign_agents` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_campaign_agents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_campaign_cid_areacodes`
--

DROP TABLE IF EXISTS `vicidial_campaign_cid_areacodes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_campaign_cid_areacodes` (
  `campaign_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `areacode` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `outbound_cid` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` enum('Y','N','') COLLATE utf8_unicode_ci DEFAULT '',
  `cid_description` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `call_count_today` mediumint(7) DEFAULT '0',
  UNIQUE KEY `campareacode` (`campaign_id`,`areacode`,`outbound_cid`),
  KEY `campaign_id` (`campaign_id`),
  KEY `areacode` (`areacode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_campaign_cid_areacodes`
--

LOCK TABLES `vicidial_campaign_cid_areacodes` WRITE;
/*!40000 ALTER TABLE `vicidial_campaign_cid_areacodes` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_campaign_cid_areacodes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_campaign_dnc`
--

DROP TABLE IF EXISTS `vicidial_campaign_dnc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_campaign_dnc` (
  `phone_number` varchar(18) NOT NULL,
  `campaign_id` varchar(8) NOT NULL,
  UNIQUE KEY `phonecamp` (`phone_number`,`campaign_id`),
  KEY `phone_number` (`phone_number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_campaign_dnc`
--

LOCK TABLES `vicidial_campaign_dnc` WRITE;
/*!40000 ALTER TABLE `vicidial_campaign_dnc` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_campaign_dnc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_campaign_hotkeys`
--

DROP TABLE IF EXISTS `vicidial_campaign_hotkeys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_campaign_hotkeys` (
  `status` varchar(6) NOT NULL,
  `hotkey` varchar(1) NOT NULL,
  `status_name` varchar(30) DEFAULT NULL,
  `selectable` enum('Y','N') DEFAULT NULL,
  `campaign_id` varchar(8) DEFAULT NULL,
  KEY `campaign_id` (`campaign_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_campaign_hotkeys`
--

LOCK TABLES `vicidial_campaign_hotkeys` WRITE;
/*!40000 ALTER TABLE `vicidial_campaign_hotkeys` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_campaign_hotkeys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_campaign_hour_counts`
--

DROP TABLE IF EXISTS `vicidial_campaign_hour_counts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_campaign_hour_counts` (
  `campaign_id` varchar(8) DEFAULT NULL,
  `date_hour` datetime DEFAULT NULL,
  `next_hour` datetime DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  `type` varchar(8) DEFAULT 'CALLS',
  `calls` mediumint(6) unsigned DEFAULT '0',
  `hr` tinyint(2) DEFAULT '0',
  UNIQUE KEY `vchc_camp_hour` (`campaign_id`,`date_hour`,`type`),
  KEY `campaign_id` (`campaign_id`),
  KEY `date_hour` (`date_hour`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_campaign_hour_counts`
--

LOCK TABLES `vicidial_campaign_hour_counts` WRITE;
/*!40000 ALTER TABLE `vicidial_campaign_hour_counts` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_campaign_hour_counts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_campaign_hour_counts_archive`
--

DROP TABLE IF EXISTS `vicidial_campaign_hour_counts_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_campaign_hour_counts_archive` (
  `campaign_id` varchar(8) DEFAULT NULL,
  `date_hour` datetime DEFAULT NULL,
  `next_hour` datetime DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  `type` varchar(8) DEFAULT 'CALLS',
  `calls` mediumint(6) unsigned DEFAULT '0',
  `hr` tinyint(2) DEFAULT '0',
  UNIQUE KEY `vchc_camp_hour` (`campaign_id`,`date_hour`,`type`),
  KEY `campaign_id` (`campaign_id`),
  KEY `date_hour` (`date_hour`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_campaign_hour_counts_archive`
--

LOCK TABLES `vicidial_campaign_hour_counts_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_campaign_hour_counts_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_campaign_hour_counts_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_campaign_server_stats`
--

DROP TABLE IF EXISTS `vicidial_campaign_server_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_campaign_server_stats` (
  `campaign_id` varchar(20) NOT NULL,
  `server_ip` varchar(15) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `local_trunk_shortage` smallint(5) unsigned DEFAULT '0',
  KEY `campaign_id` (`campaign_id`),
  KEY `server_ip` (`server_ip`)
) ENGINE=MEMORY DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_campaign_server_stats`
--

LOCK TABLES `vicidial_campaign_server_stats` WRITE;
/*!40000 ALTER TABLE `vicidial_campaign_server_stats` DISABLE KEYS */;
INSERT INTO `vicidial_campaign_server_stats` VALUES ('58307174','127.0.0.1','2018-09-23 21:16:31',0),('28222950','127.0.0.1','2018-09-23 21:16:31',0),('','127.0.0.1','2018-09-24 06:54:43',0);
/*!40000 ALTER TABLE `vicidial_campaign_server_stats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_campaign_stats`
--

DROP TABLE IF EXISTS `vicidial_campaign_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_campaign_stats` (
  `campaign_id` varchar(20) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `dialable_leads` int(9) unsigned DEFAULT '0',
  `calls_today` int(9) unsigned DEFAULT '0',
  `answers_today` int(9) unsigned DEFAULT '0',
  `drops_today` decimal(12,3) DEFAULT '0.000',
  `drops_today_pct` varchar(6) DEFAULT '0',
  `drops_answers_today_pct` varchar(6) DEFAULT '0',
  `calls_hour` int(9) unsigned DEFAULT '0',
  `answers_hour` int(9) unsigned DEFAULT '0',
  `drops_hour` int(9) unsigned DEFAULT '0',
  `drops_hour_pct` varchar(6) DEFAULT '0',
  `calls_halfhour` int(9) unsigned DEFAULT '0',
  `answers_halfhour` int(9) unsigned DEFAULT '0',
  `drops_halfhour` int(9) unsigned DEFAULT '0',
  `drops_halfhour_pct` varchar(6) DEFAULT '0',
  `calls_fivemin` int(9) unsigned DEFAULT '0',
  `answers_fivemin` int(9) unsigned DEFAULT '0',
  `drops_fivemin` int(9) unsigned DEFAULT '0',
  `drops_fivemin_pct` varchar(6) DEFAULT '0',
  `calls_onemin` int(9) unsigned DEFAULT '0',
  `answers_onemin` int(9) unsigned DEFAULT '0',
  `drops_onemin` int(9) unsigned DEFAULT '0',
  `drops_onemin_pct` varchar(6) DEFAULT '0',
  `differential_onemin` varchar(20) DEFAULT '0',
  `agents_average_onemin` varchar(20) DEFAULT '0',
  `balance_trunk_fill` smallint(5) unsigned DEFAULT '0',
  `status_category_1` varchar(20) DEFAULT NULL,
  `status_category_count_1` int(9) unsigned DEFAULT '0',
  `status_category_2` varchar(20) DEFAULT NULL,
  `status_category_count_2` int(9) unsigned DEFAULT '0',
  `status_category_3` varchar(20) DEFAULT NULL,
  `status_category_count_3` int(9) unsigned DEFAULT '0',
  `status_category_4` varchar(20) DEFAULT NULL,
  `status_category_count_4` int(9) unsigned DEFAULT '0',
  `hold_sec_stat_one` mediumint(8) unsigned DEFAULT '0',
  `hold_sec_stat_two` mediumint(8) unsigned DEFAULT '0',
  `agent_non_pause_sec` mediumint(8) unsigned DEFAULT '0',
  `hold_sec_answer_calls` mediumint(8) unsigned DEFAULT '0',
  `hold_sec_drop_calls` mediumint(8) unsigned DEFAULT '0',
  `hold_sec_queue_calls` mediumint(8) unsigned DEFAULT '0',
  `agent_calls_today` int(9) unsigned DEFAULT '0',
  `agent_wait_today` bigint(14) unsigned DEFAULT '0',
  `agent_custtalk_today` bigint(14) unsigned DEFAULT '0',
  `agent_acw_today` bigint(14) unsigned DEFAULT '0',
  `agent_pause_today` bigint(14) unsigned DEFAULT '0',
  `answering_machines_today` int(9) unsigned DEFAULT '0',
  `agenthandled_today` int(9) unsigned DEFAULT '0',
  PRIMARY KEY (`campaign_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_campaign_stats`
--

LOCK TABLES `vicidial_campaign_stats` WRITE;
/*!40000 ALTER TABLE `vicidial_campaign_stats` DISABLE KEYS */;
INSERT INTO `vicidial_campaign_stats` VALUES ('AGENTDIRECT','2018-09-23 21:14:12',0,0,0,0.000,'0','0',0,0,0,'0',0,0,0,'0',0,0,0,'0',0,0,0,'0','0','0',0,'',0,'',0,'',0,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0),('AGENTDIRECT_CHAT','2018-09-23 21:14:12',0,0,0,0.000,'0','0',0,0,0,'0',0,0,0,'0',0,0,0,'0',0,0,0,'0','0','0',0,'',0,'',0,'',0,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0),('SalesAndBilling','2018-09-23 21:14:12',0,0,0,0.000,'0','0',0,0,0,'0',0,0,0,'0',0,0,0,'0',0,0,0,'0','0','0',0,'',0,'',0,'',0,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0),('TechSupport','2018-09-23 21:14:12',0,0,0,0.000,'0','0',0,0,0,'0',0,0,0,'0',0,0,0,'0',0,0,0,'0','0','0',0,'',0,'',0,'',0,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0),('Closer','2018-09-23 21:14:12',0,0,0,0.000,'0','0',0,0,0,'0',0,0,0,'0',0,0,0,'0',0,0,0,'0','0','0',0,'',0,'',0,'',0,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0),('ING12345678901','2018-09-23 21:14:12',0,0,0,0.000,'0','0',0,0,0,'0',0,0,0,'0',0,0,0,'0',0,0,0,'0','0','0',0,'',0,'',0,'',0,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0),('INGTest','2018-09-23 21:14:12',0,0,0,0.000,'0','0',0,0,0,'0',0,0,0,'0',0,0,0,'0',0,0,0,'0','0','0',0,'',0,'',0,'',0,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0),('ING8552861592','2018-09-23 21:14:12',0,0,0,0.000,'0','0',0,0,0,'0',0,0,0,'0',0,0,0,'0',0,0,0,'0','0','0',0,'',0,'',0,'',0,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0),('ING123456789','2018-09-23 21:14:12',0,0,0,0.000,'0','0',0,0,0,'0',0,0,0,'0',0,0,0,'0',0,0,0,'0','0','0',0,'',0,'',0,'',0,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0),('ING123','2018-09-23 21:14:12',0,0,0,0.000,'0','0',0,0,0,'0',0,0,0,'0',0,0,0,'0',0,0,0,'0','0','0',0,'',0,'',0,'',0,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0),('ING987654321','2018-09-23 21:14:12',0,0,0,0.000,'0','0',0,0,0,'0',0,0,0,'0',0,0,0,'0',0,0,0,'0','0','0',0,'',0,'',0,'',0,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0),('ING1920192019','2018-09-23 21:14:12',0,0,0,0.000,'0','0',0,0,0,'0',0,0,0,'0',0,0,0,'0',0,0,0,'0','0','0',0,'',0,'',0,'',0,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0),('TESTBUG6818','2018-09-23 21:14:12',0,0,0,0.000,'0','0',0,0,0,'0',0,0,0,'0',0,0,0,'0',0,0,0,'0','0','0',0,'',0,'',0,'',0,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0),('ING3233808432','2018-09-23 21:14:12',0,0,0,0.000,'0','0',0,0,0,'0',0,0,0,'0',0,0,0,'0',0,0,0,'0','0','0',0,'',0,'',0,'',0,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0),('ING4844147','2018-09-23 21:14:13',0,0,0,0.000,'0','0',0,0,0,'0',0,0,0,'0',0,0,0,'0',0,0,0,'0','0','0',0,'',0,'',0,'',0,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `vicidial_campaign_stats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_campaign_stats_debug`
--

DROP TABLE IF EXISTS `vicidial_campaign_stats_debug`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_campaign_stats_debug` (
  `campaign_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `server_ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `entry_time` datetime DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `debug_output` text COLLATE utf8_unicode_ci,
  `adapt_output` text COLLATE utf8_unicode_ci,
  UNIQUE KEY `campserver` (`campaign_id`,`server_ip`),
  KEY `campaign_id` (`campaign_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_campaign_stats_debug`
--

LOCK TABLES `vicidial_campaign_stats_debug` WRITE;
/*!40000 ALTER TABLE `vicidial_campaign_stats_debug` DISABLE KEYS */;
INSERT INTO `vicidial_campaign_stats_debug` VALUES ('58307174','127.0.0.1','2018-09-24 05:16:31','2018-09-23 21:16:31','58307174 127.0.0.1: agents: 1 (READY: 1)    dial_level: 0     (1|0|0)   \n58307174 127.0.0.1: Calls to place: 0 (0 - 0 [0 + 0|0|0|0]) 0 \nCAMPAIGN DIFFERENTIAL: 0.95   0.95   (0.95 - 0)\nLOCAL TRUNK SHORTAGE: 0|0  (0 - 96)\n',NULL),('28222950','127.0.0.1','2018-09-24 05:16:31','2018-09-23 21:16:31','28222950 127.0.0.1: agents: 1 (READY: 1)    dial_level: 0     (1|0|0)   \n28222950 127.0.0.1: Calls to place: 0 (0 - 0 [0 + 0|0|0|0]) 0 \nCAMPAIGN DIFFERENTIAL: 1   1   (1 - 0)\nLOCAL TRUNK SHORTAGE: 0|0  (0 - 96)\n',NULL),('AGENTDIRECT','INBOUND','2018-09-24 14:54:00','2018-09-24 06:54:00','     ANSWERED STATUSES: AGENTDIRECT|DROP,XDROP,CALLBK,CBHOLD,DEC,DNC,SALE,NI,NP,XFER,TIMEOT,AFTHRS,NANQUE,QCFAIL,DNCKO,dc2,dc3,dc1,WNo,GSALE,GDNC,GCBACK,cd2,cd1,Dispo1,Dispo2,Dispo3,SALEKO|\n     DAILY STATS|0|0|0|0         IN-GROUP: AGENTDIRECT   CALLS: 0   ANSWER: 0   DROPS: 0\n               Stat1: 0   Stat2: 0   Hold: 0|0|0\n',NULL),('AGENTDIRECT_CHAT','INBOUND','2018-09-24 14:54:00','2018-09-24 06:54:00','     ANSWERED STATUSES: AGENTDIRECT_CHAT|DROP,XDROP,CALLBK,CBHOLD,DEC,DNC,SALE,NI,NP,XFER,TIMEOT,AFTHRS,NANQUE,QCFAIL,DNCKO,dc2,dc3,dc1,WNo,GSALE,GDNC,GCBACK,cd2,cd1,Dispo1,Dispo2,Dispo3,SALEKO|\n     DAILY STATS|0|0|0|13         IN-GROUP: AGENTDIRECT_CHAT   CALLS: 0   ANSWER: 0   DROPS: 0\n               Stat1: 0   Stat2: 0   Hold: 0|0|0\n',NULL),('SalesAndBilling','INBOUND','2018-09-24 14:54:00','2018-09-24 06:54:00','     ANSWERED STATUSES: SalesAndBilling|DROP,XDROP,CALLBK,CBHOLD,DEC,DNC,SALE,NI,NP,XFER,TIMEOT,AFTHRS,NANQUE,QCFAIL,DNCKO,dc2,dc3,dc1,WNo,GSALE,GDNC,GCBACK,cd2,cd1,Dispo1,Dispo2,Dispo3,SALEKO|\n     DAILY STATS|0|0|0|2         IN-GROUP: SalesAndBilling   CALLS: 0   ANSWER: 0   DROPS: 0\n               Stat1: 0   Stat2: 0   Hold: 0|0|0\n',NULL),('TechSupport','INBOUND','2018-09-24 14:54:00','2018-09-24 06:54:00','     ANSWERED STATUSES: TechSupport|DROP,XDROP,CALLBK,CBHOLD,DEC,DNC,SALE,NI,NP,XFER,TIMEOT,AFTHRS,NANQUE,QCFAIL,DNCKO,dc2,dc3,dc1,WNo,GSALE,GDNC,GCBACK,cd2,cd1,Dispo1,Dispo2,Dispo3,SALEKO|\n     DAILY STATS|0|0|0|3         IN-GROUP: TechSupport   CALLS: 0   ANSWER: 0   DROPS: 0\n               Stat1: 0   Stat2: 0   Hold: 0|0|0\n',NULL),('Closer','INBOUND','2018-09-24 14:54:00','2018-09-24 06:54:00','     ANSWERED STATUSES: Closer|DROP,XDROP,CALLBK,CBHOLD,DEC,DNC,SALE,NI,NP,XFER,TIMEOT,AFTHRS,NANQUE,QCFAIL,DNCKO,dc2,dc3,dc1,WNo,GSALE,GDNC,GCBACK,cd2,cd1,Dispo1,Dispo2,Dispo3,SALEKO|\n     DAILY STATS|0|0|0|4         IN-GROUP: Closer   CALLS: 0   ANSWER: 0   DROPS: 0\n               Stat1: 0   Stat2: 0   Hold: 0|0|0\n',NULL),('ING12345678901','INBOUND','2018-09-24 14:54:00','2018-09-24 06:54:00','     ANSWERED STATUSES: ING12345678901|DROP,XDROP,CALLBK,CBHOLD,DEC,DNC,SALE,NI,NP,XFER,TIMEOT,AFTHRS,NANQUE,QCFAIL,DNCKO,dc2,dc3,dc1,WNo,GSALE,GDNC,GCBACK,cd2,cd1,Dispo1,Dispo2,Dispo3,SALEKO|\n     DAILY STATS|0|0|0|5         IN-GROUP: ING12345678901   CALLS: 0   ANSWER: 0   DROPS: 0\n               Stat1: 0   Stat2: 0   Hold: 0|0|0\n',NULL),('INGTest','INBOUND','2018-09-24 14:54:00','2018-09-24 06:54:00','     ANSWERED STATUSES: INGTest|DROP,XDROP,CALLBK,CBHOLD,DEC,DNC,SALE,NI,NP,XFER,TIMEOT,AFTHRS,NANQUE,QCFAIL,DNCKO,dc2,dc3,dc1,WNo,GSALE,GDNC,GCBACK,cd2,cd1,Dispo1,Dispo2,Dispo3,SALEKO|\n     DAILY STATS|0|0|0|6         IN-GROUP: INGTest   CALLS: 0   ANSWER: 0   DROPS: 0\n               Stat1: 0   Stat2: 0   Hold: 0|0|0\n',NULL),('ING8552861592','INBOUND','2018-09-24 14:54:00','2018-09-24 06:54:00','     ANSWERED STATUSES: ING8552861592|DROP,XDROP,CALLBK,CBHOLD,DEC,DNC,SALE,NI,NP,XFER,TIMEOT,AFTHRS,NANQUE,QCFAIL,DNCKO,dc2,dc3,dc1,WNo,GSALE,GDNC,GCBACK,cd2,cd1,Dispo1,Dispo2,Dispo3,SALEKO|\n     DAILY STATS|0|0|0|7         IN-GROUP: ING8552861592   CALLS: 0   ANSWER: 0   DROPS: 0\n               Stat1: 0   Stat2: 0   Hold: 0|0|0\n',NULL),('ING123456789','INBOUND','2018-09-24 14:54:00','2018-09-24 06:54:00','     ANSWERED STATUSES: ING123456789|DROP,XDROP,CALLBK,CBHOLD,DEC,DNC,SALE,NI,NP,XFER,TIMEOT,AFTHRS,NANQUE,QCFAIL,DNCKO,dc2,dc3,dc1,WNo,GSALE,GDNC,GCBACK,cd2,cd1,Dispo1,Dispo2,Dispo3,SALEKO|\n     DAILY STATS|0|0|0|8         IN-GROUP: ING123456789   CALLS: 0   ANSWER: 0   DROPS: 0\n               Stat1: 0   Stat2: 0   Hold: 0|0|0\n',NULL),('ING123','INBOUND','2018-09-24 14:54:00','2018-09-24 06:54:00','     ANSWERED STATUSES: ING123|DROP,XDROP,CALLBK,CBHOLD,DEC,DNC,SALE,NI,NP,XFER,TIMEOT,AFTHRS,NANQUE,QCFAIL,DNCKO,dc2,dc3,dc1,WNo,GSALE,GDNC,GCBACK,cd2,cd1,Dispo1,Dispo2,Dispo3,SALEKO|\n     DAILY STATS|0|0|0|9         IN-GROUP: ING123   CALLS: 0   ANSWER: 0   DROPS: 0\n               Stat1: 0   Stat2: 0   Hold: 0|0|0\n',NULL),('ING987654321','INBOUND','2018-09-24 14:54:00','2018-09-24 06:54:00','     ANSWERED STATUSES: ING987654321|DROP,XDROP,CALLBK,CBHOLD,DEC,DNC,SALE,NI,NP,XFER,TIMEOT,AFTHRS,NANQUE,QCFAIL,DNCKO,dc2,dc3,dc1,WNo,GSALE,GDNC,GCBACK,cd2,cd1,Dispo1,Dispo2,Dispo3,SALEKO|\n     DAILY STATS|0|0|0|10         IN-GROUP: ING987654321   CALLS: 0   ANSWER: 0   DROPS: 0\n               Stat1: 0   Stat2: 0   Hold: 0|0|0\n',NULL),('ING1920192019','INBOUND','2018-09-24 14:54:00','2018-09-24 06:54:00','     ANSWERED STATUSES: ING1920192019|DROP,XDROP,CALLBK,CBHOLD,DEC,DNC,SALE,NI,NP,XFER,TIMEOT,AFTHRS,NANQUE,QCFAIL,DNCKO,dc2,dc3,dc1,WNo,GSALE,GDNC,GCBACK,cd2,cd1,Dispo1,Dispo2,Dispo3,SALEKO|\n     DAILY STATS|0|0|0|11         IN-GROUP: ING1920192019   CALLS: 0   ANSWER: 0   DROPS: 0\n               Stat1: 0   Stat2: 0   Hold: 0|0|0\n',NULL),('TESTBUG6818','INBOUND','2018-09-24 14:54:00','2018-09-24 06:54:00','     ANSWERED STATUSES: TESTBUG6818|DROP,XDROP,CALLBK,CBHOLD,DEC,DNC,SALE,NI,NP,XFER,TIMEOT,AFTHRS,NANQUE,QCFAIL,DNCKO,dc2,dc3,dc1,WNo,GSALE,GDNC,GCBACK,cd2,cd1,Dispo1,Dispo2,Dispo3,SALEKO|\n     DAILY STATS|0|0|0|12         IN-GROUP: TESTBUG6818   CALLS: 0   ANSWER: 0   DROPS: 0\n               Stat1: 0   Stat2: 0   Hold: 0|0|0\n',NULL),('ING3233808432','INBOUND','2018-09-24 14:54:00','2018-09-24 06:54:00','     ANSWERED STATUSES: ING3233808432|DROP,XDROP,CALLBK,CBHOLD,DEC,DNC,SALE,NI,NP,XFER,TIMEOT,AFTHRS,NANQUE,QCFAIL,DNCKO,dc2,dc3,dc1,WNo,GSALE,GDNC,GCBACK,cd2,cd1,Dispo1,Dispo2,Dispo3,SALEKO|\n     DAILY STATS|0|0|0|14         IN-GROUP: ING3233808432   CALLS: 0   ANSWER: 0   DROPS: 0\n               Stat1: 0   Stat2: 0   Hold: 0|0|0\n',NULL),('ING4844147','INBOUND','2018-09-24 14:54:00','2018-09-24 06:54:00','     ANSWERED STATUSES: ING4844147|DROP,XDROP,CALLBK,CBHOLD,DEC,DNC,SALE,NI,NP,XFER,TIMEOT,AFTHRS,NANQUE,QCFAIL,DNCKO,dc2,dc3,dc1,WNo,GSALE,GDNC,GCBACK,cd2,cd1,Dispo1,Dispo2,Dispo3,SALEKO|\n     DAILY STATS|0|0|0|15         IN-GROUP: ING4844147   CALLS: 0   ANSWER: 0   DROPS: 0\n               Stat1: 0   Stat2: 0   Hold: 0|0|0\n',NULL),('','127.0.0.1','2018-09-24 14:54:43','2018-09-24 06:54:43',' : agents: 0 (READY: 0)    dial_level: 0     (||)   \n : Calls to place: 0 (0 - 0 [0 + 0|0|0|0]) 0 \nCAMPAIGN DIFFERENTIAL: 0   0   (0 - 0)\nLOCAL TRUNK SHORTAGE: 0|0  (0 - 96)\n',NULL);
/*!40000 ALTER TABLE `vicidial_campaign_stats_debug` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_campaign_statuses`
--

DROP TABLE IF EXISTS `vicidial_campaign_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_campaign_statuses` (
  `status` varchar(6) NOT NULL,
  `status_name` varchar(30) DEFAULT NULL,
  `selectable` enum('Y','N') DEFAULT NULL,
  `campaign_id` varchar(20) DEFAULT NULL,
  `human_answered` enum('Y','N') DEFAULT 'N',
  `category` varchar(20) DEFAULT 'UNDEFINED',
  `sale` enum('Y','N') DEFAULT 'N',
  `dnc` enum('Y','N') DEFAULT 'N',
  `customer_contact` enum('Y','N') DEFAULT 'N',
  `not_interested` enum('Y','N') DEFAULT 'N',
  `unworkable` enum('Y','N') DEFAULT 'N',
  `scheduled_callback` enum('Y','N') DEFAULT 'N',
  `completed` enum('Y','N') DEFAULT 'N',
  `min_sec` int(5) unsigned DEFAULT '0',
  `max_sec` int(5) unsigned DEFAULT '0',
  `answering_machine` enum('Y','N') DEFAULT 'N',
  UNIQUE KEY `vicidial_campaign_statuses_key` (`status`,`campaign_id`),
  KEY `campaign_id` (`campaign_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_campaign_statuses`
--

LOCK TABLES `vicidial_campaign_statuses` WRITE;
/*!40000 ALTER TABLE `vicidial_campaign_statuses` DISABLE KEYS */;
INSERT INTO `vicidial_campaign_statuses` VALUES ('DNCKO','DNC KO','Y','43594247','Y','UNDEFINED','N','Y','Y','N','N','N','N',0,0,'N'),('dc2','dc2 new edit2','Y','73351287','Y','UNDEFINED','Y','N','N','N','N','N','N',0,0,'N'),('dc3','dc3 new','Y','73351287','Y','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('dc1','dc1 new sale','Y','73351287','Y','UNDEFINED','Y','N','N','N','N','N','N',0,0,'N'),('NOEL','NOEL','Y','43594247','N','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('WNo','Wrong Number','Y','41235696','Y','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('GSALE','Gie Sale','Y','36661028','Y','UNDEFINED','Y','N','Y','N','N','N','N',0,0,'N'),('GDNC','Gie Do Not Calls','Y','36661028','Y','UNDEFINED','N','Y','Y','N','N','N','N',0,0,'N'),('GCBACK','Gie Call Back','Y','36661028','Y','UNDEFINED','N','N','Y','N','N','Y','N',0,0,'N'),('cd2','cd2','Y','45640625','Y','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('cd1','cd1','Y','13373511','Y','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('Dispo1','Dispo1','Y','46570691','Y','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('Dispo2','Dispo2','Y','46570691','Y','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('Dispo3','Dispo3','Y','46570691','Y','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('LUNCH','Lunch Break','Y','12904133','N','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('SALEKO','SALE KO','Y','70249839','Y','UNDEFINED','Y','N','N','N','N','N','N',0,0,'N');
/*!40000 ALTER TABLE `vicidial_campaign_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_campaigns`
--

DROP TABLE IF EXISTS `vicidial_campaigns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_campaigns` (
  `campaign_id` varchar(8) NOT NULL,
  `campaign_name` varchar(40) DEFAULT NULL,
  `active` enum('Y','N') DEFAULT NULL,
  `dial_status_a` varchar(6) DEFAULT NULL,
  `dial_status_b` varchar(6) DEFAULT NULL,
  `dial_status_c` varchar(6) DEFAULT NULL,
  `dial_status_d` varchar(6) DEFAULT NULL,
  `dial_status_e` varchar(6) DEFAULT NULL,
  `lead_order` varchar(30) DEFAULT NULL,
  `park_ext` varchar(10) DEFAULT NULL,
  `park_file_name` varchar(100) DEFAULT 'default',
  `web_form_address` text,
  `allow_closers` enum('Y','N') DEFAULT NULL,
  `hopper_level` int(8) unsigned DEFAULT '1',
  `auto_dial_level` varchar(6) DEFAULT '0',
  `next_agent_call` enum('random','oldest_call_start','oldest_call_finish','campaign_rank','overall_user_level','fewest_calls','longest_wait_time','campaign_grade_random') DEFAULT 'longest_wait_time',
  `local_call_time` varchar(10) DEFAULT '9am-9pm',
  `voicemail_ext` varchar(10) DEFAULT NULL,
  `dial_timeout` tinyint(3) unsigned DEFAULT '60',
  `dial_prefix` varchar(20) DEFAULT '9',
  `campaign_cid` varchar(20) DEFAULT '0000000000',
  `campaign_vdad_exten` varchar(20) DEFAULT '8368',
  `campaign_rec_exten` varchar(20) DEFAULT '8309',
  `campaign_recording` enum('NEVER','ONDEMAND','ALLCALLS','ALLFORCE') DEFAULT 'ONDEMAND',
  `campaign_rec_filename` varchar(50) DEFAULT 'FULLDATE_CUSTPHONE',
  `campaign_script` varchar(20) DEFAULT NULL,
  `get_call_launch` enum('NONE','SCRIPT','WEBFORM','WEBFORMTWO','WEBFORMTHREE','FORM','PREVIEW_WEBFORM','PREVIEW_WEBFORMTWO','PREVIEW_WEBFORMTHREE') DEFAULT 'NONE',
  `am_message_exten` varchar(100) DEFAULT 'vm-goodbye',
  `amd_send_to_vmx` enum('Y','N') DEFAULT 'N',
  `xferconf_a_dtmf` varchar(50) DEFAULT NULL,
  `xferconf_a_number` varchar(50) DEFAULT NULL,
  `xferconf_b_dtmf` varchar(50) DEFAULT NULL,
  `xferconf_b_number` varchar(50) DEFAULT NULL,
  `alt_number_dialing` enum('N','Y','SELECTED','SELECTED_TIMER_ALT','SELECTED_TIMER_ADDR3') DEFAULT 'N',
  `scheduled_callbacks` enum('Y','N') DEFAULT 'N',
  `lead_filter_id` varchar(20) DEFAULT 'NONE',
  `drop_call_seconds` tinyint(3) DEFAULT '5',
  `drop_action` enum('HANGUP','MESSAGE','VOICEMAIL','IN_GROUP','AUDIO','CALLMENU','VMAIL_NO_INST') DEFAULT 'AUDIO',
  `safe_harbor_exten` varchar(20) DEFAULT '8307',
  `display_dialable_count` enum('Y','N') DEFAULT 'Y',
  `wrapup_seconds` smallint(3) unsigned DEFAULT '0',
  `wrapup_message` varchar(255) DEFAULT 'Wrapup Call',
  `closer_campaigns` text,
  `use_internal_dnc` enum('Y','N','AREACODE') DEFAULT 'N',
  `allcalls_delay` smallint(3) unsigned DEFAULT '0',
  `omit_phone_code` enum('Y','N') DEFAULT 'N',
  `dial_method` enum('MANUAL','RATIO','ADAPT_HARD_LIMIT','ADAPT_TAPERED','ADAPT_AVERAGE','INBOUND_MAN') DEFAULT 'MANUAL',
  `available_only_ratio_tally` enum('Y','N') DEFAULT 'N',
  `adaptive_dropped_percentage` varchar(4) DEFAULT '3',
  `adaptive_maximum_level` varchar(6) DEFAULT '3.0',
  `adaptive_latest_server_time` varchar(4) DEFAULT '2100',
  `adaptive_intensity` varchar(6) DEFAULT '0',
  `adaptive_dl_diff_target` smallint(3) DEFAULT '0',
  `concurrent_transfers` enum('AUTO','1','2','3','4','5','6','7','8','9','10','15','20','25','30','40','50','60','80','100') DEFAULT 'AUTO',
  `auto_alt_dial` enum('NONE','ALT_ONLY','ADDR3_ONLY','ALT_AND_ADDR3','ALT_AND_EXTENDED','ALT_AND_ADDR3_AND_EXTENDED','EXTENDED_ONLY','MULTI_LEAD') DEFAULT 'NONE',
  `auto_alt_dial_statuses` varchar(255) DEFAULT ' B N NA DC -',
  `agent_pause_codes_active` enum('Y','N','FORCE') DEFAULT 'N',
  `campaign_description` varchar(255) DEFAULT NULL,
  `campaign_changedate` datetime DEFAULT NULL,
  `campaign_stats_refresh` enum('Y','N') DEFAULT 'N',
  `campaign_logindate` datetime DEFAULT NULL,
  `dial_statuses` varchar(255) DEFAULT ' NEW -',
  `disable_alter_custdata` enum('Y','N') DEFAULT 'N',
  `no_hopper_leads_logins` enum('Y','N') DEFAULT 'N',
  `list_order_mix` varchar(20) DEFAULT 'DISABLED',
  `campaign_allow_inbound` enum('Y','N') DEFAULT 'N',
  `manual_dial_list_id` bigint(14) unsigned DEFAULT '998',
  `default_xfer_group` varchar(20) DEFAULT '---NONE---',
  `xfer_groups` text,
  `queue_priority` tinyint(2) DEFAULT '50',
  `drop_inbound_group` varchar(20) DEFAULT '---NONE---',
  `qc_enabled` enum('Y','N') DEFAULT 'N',
  `qc_statuses` text,
  `qc_lists` text,
  `qc_shift_id` varchar(20) DEFAULT '24HRMIDNIGHT',
  `qc_get_record_launch` enum('NONE','SCRIPT','WEBFORM','QCSCRIPT','QCWEBFORM') DEFAULT 'NONE',
  `qc_show_recording` enum('Y','N') DEFAULT 'Y',
  `qc_web_form_address` varchar(255) DEFAULT NULL,
  `qc_script` varchar(20) DEFAULT NULL,
  `survey_first_audio_file` varchar(50) DEFAULT 'US_pol_survey_hello',
  `survey_dtmf_digits` varchar(16) DEFAULT '1238',
  `survey_ni_digit` varchar(1) DEFAULT '8',
  `survey_opt_in_audio_file` varchar(50) DEFAULT 'US_pol_survey_transfer',
  `survey_ni_audio_file` varchar(50) DEFAULT 'US_thanks_no_contact',
  `survey_method` enum('AGENT_XFER','VOICEMAIL','EXTENSION','HANGUP','CAMPREC_60_WAV','CALLMENU','VMAIL_NO_INST') DEFAULT 'AGENT_XFER',
  `survey_no_response_action` enum('OPTIN','OPTOUT','DROP') DEFAULT 'OPTIN',
  `survey_ni_status` varchar(6) DEFAULT 'NI',
  `survey_response_digit_map` varchar(255) DEFAULT '1-DEMOCRAT|2-REPUBLICAN|3-INDEPENDANT|8-OPTOUT|X-NO RESPONSE|',
  `survey_xfer_exten` varchar(40) DEFAULT '8300',
  `survey_camp_record_dir` varchar(255) DEFAULT '/home/survey',
  `disable_alter_custphone` enum('Y','N','HIDE') DEFAULT 'Y',
  `display_queue_count` enum('Y','N') DEFAULT 'Y',
  `manual_dial_filter` varchar(50) DEFAULT 'NONE',
  `agent_clipboard_copy` varchar(50) DEFAULT 'NONE',
  `agent_extended_alt_dial` enum('Y','N') DEFAULT 'N',
  `use_campaign_dnc` enum('Y','N','AREACODE') DEFAULT 'N',
  `three_way_call_cid` enum('CAMPAIGN','CUSTOMER','AGENT_PHONE','AGENT_CHOOSE','CUSTOM_CID') DEFAULT 'CAMPAIGN',
  `three_way_dial_prefix` varchar(20) DEFAULT '',
  `web_form_target` varchar(100) NOT NULL DEFAULT 'vdcwebform',
  `vtiger_search_category` varchar(100) DEFAULT 'LEAD',
  `vtiger_create_call_record` enum('Y','N','DISPO') DEFAULT 'Y',
  `vtiger_create_lead_record` enum('Y','N') DEFAULT 'Y',
  `vtiger_screen_login` enum('Y','N','NEW_WINDOW') DEFAULT 'Y',
  `cpd_amd_action` enum('DISABLED','DISPO','MESSAGE','CALLMENU','INGROUP') DEFAULT 'DISABLED',
  `agent_allow_group_alias` enum('Y','N') DEFAULT 'N',
  `default_group_alias` varchar(30) DEFAULT '',
  `vtiger_search_dead` enum('DISABLED','ASK','RESURRECT') DEFAULT 'ASK',
  `vtiger_status_call` enum('Y','N') DEFAULT 'N',
  `survey_third_digit` varchar(1) DEFAULT '',
  `survey_third_audio_file` varchar(50) DEFAULT 'US_thanks_no_contact',
  `survey_third_status` varchar(6) DEFAULT 'NI',
  `survey_third_exten` varchar(40) DEFAULT '8300',
  `survey_fourth_digit` varchar(1) DEFAULT '',
  `survey_fourth_audio_file` varchar(50) DEFAULT 'US_thanks_no_contact',
  `survey_fourth_status` varchar(6) DEFAULT 'NI',
  `survey_fourth_exten` varchar(40) DEFAULT '8300',
  `drop_lockout_time` varchar(6) DEFAULT '0',
  `quick_transfer_button` varchar(20) DEFAULT 'N',
  `prepopulate_transfer_preset` enum('N','PRESET_1','PRESET_2','PRESET_3','PRESET_4','PRESET_5') DEFAULT 'N',
  `drop_rate_group` varchar(20) DEFAULT 'DISABLED',
  `view_calls_in_queue` enum('NONE','ALL','1','2','3','4','5') DEFAULT 'NONE',
  `view_calls_in_queue_launch` enum('AUTO','MANUAL') DEFAULT 'MANUAL',
  `grab_calls_in_queue` enum('Y','N') DEFAULT 'N',
  `call_requeue_button` enum('Y','N') DEFAULT 'N',
  `pause_after_each_call` enum('Y','N') DEFAULT 'N',
  `no_hopper_dialing` enum('Y','N') DEFAULT 'N',
  `agent_dial_owner_only` enum('NONE','USER','TERRITORY','USER_GROUP','USER_BLANK','TERRITORY_BLANK','USER_GROUP_BLANK') DEFAULT 'NONE',
  `agent_display_dialable_leads` enum('Y','N') DEFAULT 'N',
  `web_form_address_two` text,
  `waitforsilence_options` varchar(25) DEFAULT '',
  `agent_select_territories` enum('Y','N') DEFAULT 'N',
  `campaign_calldate` datetime DEFAULT NULL,
  `crm_popup_login` enum('Y','N') DEFAULT 'N',
  `crm_login_address` text,
  `timer_action` varchar(20) DEFAULT 'NONE',
  `timer_action_message` varchar(255) DEFAULT '',
  `timer_action_seconds` mediumint(7) DEFAULT '-1',
  `start_call_url` text,
  `dispo_call_url` text,
  `xferconf_c_number` varchar(50) DEFAULT '',
  `xferconf_d_number` varchar(50) DEFAULT '',
  `xferconf_e_number` varchar(50) DEFAULT '',
  `use_custom_cid` enum('Y','N','AREACODE','USER_CUSTOM_1','USER_CUSTOM_2','USER_CUSTOM_3','USER_CUSTOM_4','USER_CUSTOM_5') DEFAULT 'N',
  `scheduled_callbacks_alert` enum('NONE','BLINK','RED','BLINK_RED','BLINK_DEFER','RED_DEFER','BLINK_RED_DEFER') DEFAULT 'NONE',
  `queuemetrics_callstatus_override` enum('DISABLED','NO','YES') DEFAULT 'DISABLED',
  `extension_appended_cidname` enum('Y','N','Y_USER','Y_WITH_CAMPAIGN','Y_USER_WITH_CAMPAIGN') DEFAULT 'N',
  `scheduled_callbacks_count` enum('LIVE','ALL_ACTIVE') DEFAULT 'ALL_ACTIVE',
  `manual_dial_override` enum('NONE','ALLOW_ALL','DISABLE_ALL') DEFAULT 'NONE',
  `blind_monitor_warning` enum('DISABLED','ALERT','NOTICE','AUDIO','ALERT_NOTICE','ALERT_AUDIO','NOTICE_AUDIO','ALL') DEFAULT 'DISABLED',
  `blind_monitor_message` varchar(255) DEFAULT 'Someone is blind monitoring your session',
  `blind_monitor_filename` varchar(100) DEFAULT '',
  `inbound_queue_no_dial` enum('DISABLED','ENABLED','ALL_SERVERS','ENABLED_WITH_CHAT','ALL_SERVERS_WITH_CHAT') DEFAULT 'DISABLED',
  `timer_action_destination` varchar(30) DEFAULT '',
  `enable_xfer_presets` enum('DISABLED','ENABLED','CONTACTS') DEFAULT 'DISABLED',
  `hide_xfer_number_to_dial` enum('DISABLED','ENABLED') DEFAULT 'DISABLED',
  `manual_dial_prefix` varchar(20) DEFAULT '',
  `customer_3way_hangup_logging` enum('DISABLED','ENABLED') DEFAULT 'ENABLED',
  `customer_3way_hangup_seconds` smallint(5) unsigned DEFAULT '5',
  `customer_3way_hangup_action` enum('NONE','DISPO') DEFAULT 'NONE',
  `ivr_park_call` enum('DISABLED','ENABLED','ENABLED_PARK_ONLY','ENABLED_BUTTON_HIDDEN') DEFAULT 'DISABLED',
  `ivr_park_call_agi` text,
  `manual_preview_dial` enum('DISABLED','PREVIEW_AND_SKIP','PREVIEW_ONLY') DEFAULT 'PREVIEW_AND_SKIP',
  `realtime_agent_time_stats` enum('DISABLED','WAIT_CUST_ACW','WAIT_CUST_ACW_PAUSE','CALLS_WAIT_CUST_ACW_PAUSE') DEFAULT 'CALLS_WAIT_CUST_ACW_PAUSE',
  `use_auto_hopper` enum('Y','N') DEFAULT 'N',
  `auto_hopper_multi` varchar(6) DEFAULT '1',
  `auto_hopper_level` mediumint(8) unsigned DEFAULT '0',
  `auto_trim_hopper` enum('Y','N') DEFAULT 'N',
  `api_manual_dial` enum('STANDARD','QUEUE','QUEUE_AND_AUTOCALL') DEFAULT 'STANDARD',
  `manual_dial_call_time_check` enum('DISABLED','ENABLED') DEFAULT 'DISABLED',
  `display_leads_count` enum('Y','N') DEFAULT 'N',
  `lead_order_randomize` enum('Y','N') DEFAULT 'N',
  `lead_order_secondary` enum('LEAD_ASCEND','LEAD_DESCEND','CALLTIME_ASCEND','CALLTIME_DESCEND','VENDOR_ASCEND','VENDOR_DESCEND') DEFAULT 'LEAD_ASCEND',
  `per_call_notes` enum('ENABLED','DISABLED') DEFAULT 'DISABLED',
  `my_callback_option` enum('CHECKED','UNCHECKED') DEFAULT 'UNCHECKED',
  `agent_lead_search` enum('ENABLED','LIVE_CALL_INBOUND','LIVE_CALL_INBOUND_AND_MANUAL','DISABLED') DEFAULT 'DISABLED',
  `agent_lead_search_method` varchar(30) DEFAULT 'CAMPLISTS_ALL',
  `queuemetrics_phone_environment` varchar(20) DEFAULT '',
  `auto_pause_precall` enum('Y','N') DEFAULT 'N',
  `auto_pause_precall_code` varchar(6) DEFAULT 'PRECAL',
  `auto_resume_precall` enum('Y','N') DEFAULT 'N',
  `manual_dial_cid` enum('CAMPAIGN','AGENT_PHONE') DEFAULT 'CAMPAIGN',
  `post_phone_time_diff_alert` varchar(30) DEFAULT 'DISABLED',
  `custom_3way_button_transfer` varchar(30) DEFAULT 'DISABLED',
  `available_only_tally_threshold` enum('DISABLED','LOGGED-IN_AGENTS','NON-PAUSED_AGENTS','WAITING_AGENTS') DEFAULT 'DISABLED',
  `available_only_tally_threshold_agents` smallint(5) unsigned DEFAULT '0',
  `dial_level_threshold` enum('DISABLED','LOGGED-IN_AGENTS','NON-PAUSED_AGENTS','WAITING_AGENTS') DEFAULT 'DISABLED',
  `dial_level_threshold_agents` smallint(5) unsigned DEFAULT '0',
  `safe_harbor_audio` varchar(100) DEFAULT 'buzz',
  `safe_harbor_menu_id` varchar(50) DEFAULT '',
  `survey_menu_id` varchar(50) DEFAULT '',
  `callback_days_limit` smallint(3) DEFAULT '0',
  `dl_diff_target_method` enum('ADAPT_CALC_ONLY','CALLS_PLACED') DEFAULT 'ADAPT_CALC_ONLY',
  `disable_dispo_screen` enum('DISPO_ENABLED','DISPO_DISABLED','DISPO_SELECT_DISABLED') DEFAULT 'DISPO_ENABLED',
  `disable_dispo_status` varchar(6) DEFAULT '',
  `screen_labels` varchar(20) DEFAULT '--SYSTEM-SETTINGS--',
  `status_display_fields` varchar(30) DEFAULT 'CALLID',
  `na_call_url` text,
  `survey_recording` enum('Y','N','Y_WITH_AMD') DEFAULT 'N',
  `pllb_grouping` enum('DISABLED','ONE_SERVER_ONLY','CASCADING') DEFAULT 'DISABLED',
  `pllb_grouping_limit` smallint(5) DEFAULT '50',
  `call_count_limit` smallint(5) unsigned DEFAULT '0',
  `call_count_target` smallint(5) unsigned DEFAULT '3',
  `callback_hours_block` tinyint(2) DEFAULT '0',
  `callback_list_calltime` enum('ENABLED','DISABLED') DEFAULT 'DISABLED',
  `user_group` varchar(20) DEFAULT '---ALL---',
  `hopper_vlc_dup_check` enum('Y','N') DEFAULT 'N',
  `in_group_dial` enum('DISABLED','MANUAL_DIAL','NO_DIAL','BOTH') DEFAULT 'DISABLED',
  `in_group_dial_select` enum('AGENT_SELECTED','CAMPAIGN_SELECTED','ALL_USER_GROUP') DEFAULT 'CAMPAIGN_SELECTED',
  `safe_harbor_audio_field` varchar(30) DEFAULT 'DISABLED',
  `pause_after_next_call` enum('ENABLED','DISABLED') DEFAULT 'DISABLED',
  `owner_populate` enum('ENABLED','DISABLED') DEFAULT 'DISABLED',
  `use_other_campaign_dnc` varchar(8) DEFAULT '',
  `allow_emails` enum('Y','N') DEFAULT 'N',
  `amd_inbound_group` varchar(20) DEFAULT '',
  `amd_callmenu` varchar(50) DEFAULT '',
  `survey_wait_sec` tinyint(3) DEFAULT '10',
  `manual_dial_lead_id` enum('Y','N') DEFAULT 'N',
  `dead_max` smallint(5) unsigned DEFAULT '0',
  `dead_max_dispo` varchar(6) DEFAULT 'DCMX',
  `dispo_max` smallint(5) unsigned DEFAULT '0',
  `dispo_max_dispo` varchar(6) DEFAULT 'DISMX',
  `pause_max` smallint(5) unsigned DEFAULT '0',
  `max_inbound_calls` smallint(5) unsigned DEFAULT '0',
  `manual_dial_search_checkbox` enum('SELECTED','SELECTED_RESET','UNSELECTED','UNSELECTED_RESET','SELECTED_LOCK','UNSELECTED_LOCK') DEFAULT 'SELECTED',
  `hide_call_log_info` enum('Y','N') DEFAULT 'N',
  `timer_alt_seconds` smallint(5) DEFAULT '0',
  `wrapup_bypass` enum('DISABLED','ENABLED') DEFAULT 'ENABLED',
  `wrapup_after_hotkey` enum('DISABLED','ENABLED') DEFAULT 'DISABLED',
  `callback_active_limit` smallint(5) unsigned DEFAULT '0',
  `callback_active_limit_override` enum('N','Y') DEFAULT 'N',
  `allow_chats` enum('Y','N') DEFAULT 'N',
  `comments_all_tabs` enum('DISABLED','ENABLED') DEFAULT 'DISABLED',
  `comments_dispo_screen` enum('DISABLED','ENABLED','REPLACE_CALL_NOTES') DEFAULT 'DISABLED',
  `comments_callback_screen` enum('DISABLED','ENABLED','REPLACE_CB_NOTES') DEFAULT 'DISABLED',
  `qc_comment_history` enum('CLICK','AUTO_OPEN','CLICK_ALLOW_MINIMIZE','AUTO_OPEN_ALLOW_MINIMIZE') DEFAULT 'CLICK',
  `show_previous_callback` enum('DISABLED','ENABLED') DEFAULT 'ENABLED',
  `clear_script` enum('DISABLED','ENABLED') DEFAULT 'DISABLED',
  `cpd_unknown_action` enum('DISABLED','DISPO','MESSAGE','CALLMENU','INGROUP') DEFAULT 'DISABLED',
  `manual_dial_search_filter` varchar(50) DEFAULT 'NONE',
  `web_form_address_three` text,
  `manual_dial_override_field` enum('ENABLED','DISABLED') DEFAULT 'ENABLED',
  `status_display_ingroup` enum('ENABLED','DISABLED') DEFAULT 'ENABLED',
  `customer_gone_seconds` smallint(5) unsigned DEFAULT '30',
  `agent_display_fields` varchar(100) DEFAULT '',
  `am_message_wildcards` enum('Y','N') DEFAULT 'N',
  `manual_dial_timeout` varchar(3) DEFAULT '',
  `routing_initiated_recordings` enum('Y','N') DEFAULT 'N',
  `manual_dial_hopper_check` enum('Y','N') DEFAULT 'N',
  `callback_useronly_move_minutes` mediumint(5) unsigned DEFAULT '0',
  `ofcom_uk_drop_calc` enum('Y','N') DEFAULT 'N',
  `dead_to_dispo` enum('ENABLED','DISABLED') DEFAULT 'DISABLED',
  `agent_xfer_validation` enum('N','Y') DEFAULT 'N',
  `ready_max_logout` mediumint(7) DEFAULT '0',
  `callback_display_days` smallint(3) DEFAULT '0',
  `three_way_record_stop` enum('Y','N') DEFAULT 'N',
  `hangup_xfer_record_start` enum('Y','N') DEFAULT 'N',
  `scheduled_callbacks_email_alert` enum('Y','N') DEFAULT 'N',
  `max_inbound_calls_outcome` enum('DEFAULT','ALLOW_AGENTDIRECT','ALLOW_MI_PAUSE','ALLOW_AGENTDIRECT_AND_MI_PAUSE') DEFAULT 'DEFAULT',
  `manual_auto_next_options` enum('DEFAULT','PAUSE_NO_COUNT') DEFAULT 'DEFAULT',
  `agent_screen_time_display` enum('DISABLED','ENABLED_BASIC','ENABLED_FULL','ENABLED_BILL_BREAK_LUNCH_COACH') DEFAULT 'DISABLED',
  `next_dial_my_callbacks` enum('DISABLED','ENABLED') DEFAULT 'DISABLED',
  `inbound_no_agents_no_dial_container` varchar(40) DEFAULT '---DISABLED---',
  `inbound_no_agents_no_dial_threshold` smallint(5) DEFAULT '0',
  `cid_group_id` varchar(20) DEFAULT '---DISABLED---',
  `pause_max_dispo` varchar(6) DEFAULT 'PAUSMX',
  `script_top_dispo` enum('Y','N') DEFAULT 'N',
  `manual_auto_next` smallint(5) unsigned DEFAULT '0',
  `manual_auto_show` enum('Y','N') DEFAULT 'N',
  `allow_required_fields` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`campaign_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_campaigns`
--

LOCK TABLES `vicidial_campaigns` WRITE;
/*!40000 ALTER TABLE `vicidial_campaigns` DISABLE KEYS */;
INSERT INTO `vicidial_campaigns` VALUES ('12904133','TESTCAMP','Y','NEW',NULL,NULL,NULL,NULL,'DOWN',NULL,'default',NULL,'Y',100,'0','oldest_call_finish','9am-9pm',NULL,30,'9','5164536886','8368','8309','ALLFORCE','FULLDATE_CUSTPHONE_CAMPAIGN_AGENT','','NONE','vm-goodbye','N',NULL,NULL,NULL,NULL,'N','Y','NONE',7,'AUDIO','8307','Y',0,'Wrapup Call',NULL,'Y',0,'N','RATIO','Y','3','3.0','2100','0',0,'AUTO','NONE',' B N NA DC -','N',NULL,'2018-09-23 20:31:29','N',NULL,' N NA A AA DROP B NEW -','N','Y','DISABLED','N',0,'---NONE---',NULL,50,'---NONE---','N',NULL,NULL,'24HRMIDNIGHT','NONE','Y',NULL,NULL,'US_pol_survey_hello','1238','8','US_pol_survey_transfer','US_thanks_no_contact','AGENT_XFER','OPTIN','NI','1-DEMOCRAT|2-REPUBLICAN|3-INDEPENDANT|8-OPTOUT|X-NO RESPONSE|','8300','/home/survey','Y','Y','DNC_ONLY','NONE','N','Y','CAMPAIGN','','vdcwebform','LEAD','Y','Y','Y','DISABLED','N','','ASK','N','','US_thanks_no_contact','NI','8300','','US_thanks_no_contact','NI','8300','0','N','N','DISABLED','NONE','MANUAL','N','N','N','N','NONE','N',NULL,'','N',NULL,'N',NULL,'NONE','',-1,NULL,NULL,'','','','N','BLINK_RED','DISABLED','N','ALL_ACTIVE','NONE','DISABLED','Someone is blind monitoring your session','','DISABLED','','DISABLED','DISABLED','','ENABLED',5,'NONE','DISABLED',NULL,'PREVIEW_AND_SKIP','CALLS_WAIT_CUST_ACW_PAUSE','N','1',0,'N','STANDARD','DISABLED','N','N','LEAD_ASCEND','DISABLED','UNCHECKED','DISABLED','CAMPLISTS_ALL','','N','PRECAL','N','CAMPAIGN','DISABLED','DISABLED','DISABLED',0,'DISABLED',0,'buzz','','',0,'ADAPT_CALC_ONLY','DISPO_ENABLED','','--SYSTEM-SETTINGS--','CALLID',NULL,'N','DISABLED',50,0,3,0,'DISABLED','---ALL---','N','DISABLED','CAMPAIGN_SELECTED','DISABLED','DISABLED','DISABLED','','N','','',10,'N',0,'DCMX',0,'DISMX',0,0,'SELECTED','N',0,'ENABLED','DISABLED',0,'N','N','DISABLED','DISABLED','DISABLED','CLICK','ENABLED','DISABLED','DISABLED','NONE',NULL,'ENABLED','ENABLED',30,'','N','','N','N',0,'N','DISABLED','N',0,0,'N','N','N','DEFAULT','DEFAULT','DISABLED','DISABLED','---DISABLED---',0,'---DISABLED---','PAUSMX','N',0,'N','N');
/*!40000 ALTER TABLE `vicidial_campaigns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_campaigns_list_mix`
--

DROP TABLE IF EXISTS `vicidial_campaigns_list_mix`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_campaigns_list_mix` (
  `vcl_id` varchar(20) NOT NULL,
  `vcl_name` varchar(50) DEFAULT NULL,
  `campaign_id` varchar(8) DEFAULT NULL,
  `list_mix_container` text,
  `mix_method` enum('EVEN_MIX','IN_ORDER','RANDOM') DEFAULT 'IN_ORDER',
  `status` enum('ACTIVE','INACTIVE') DEFAULT 'INACTIVE',
  PRIMARY KEY (`vcl_id`),
  KEY `campaign_id` (`campaign_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_campaigns_list_mix`
--

LOCK TABLES `vicidial_campaigns_list_mix` WRITE;
/*!40000 ALTER TABLE `vicidial_campaigns_list_mix` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_campaigns_list_mix` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_carrier_hour_counts`
--

DROP TABLE IF EXISTS `vicidial_carrier_hour_counts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_carrier_hour_counts` (
  `date_hour` datetime DEFAULT NULL,
  `next_hour` datetime DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  `type` varchar(20) DEFAULT 'ANSWERED',
  `calls` mediumint(6) unsigned DEFAULT '0',
  `hr` tinyint(2) DEFAULT '0',
  UNIQUE KEY `vclhc_hour` (`date_hour`,`type`),
  KEY `date_hour` (`date_hour`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_carrier_hour_counts`
--

LOCK TABLES `vicidial_carrier_hour_counts` WRITE;
/*!40000 ALTER TABLE `vicidial_carrier_hour_counts` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_carrier_hour_counts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_carrier_hour_counts_archive`
--

DROP TABLE IF EXISTS `vicidial_carrier_hour_counts_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_carrier_hour_counts_archive` (
  `date_hour` datetime DEFAULT NULL,
  `next_hour` datetime DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  `type` varchar(20) DEFAULT 'ANSWERED',
  `calls` mediumint(6) unsigned DEFAULT '0',
  `hr` tinyint(2) DEFAULT '0',
  UNIQUE KEY `vclhc_hour` (`date_hour`,`type`),
  KEY `date_hour` (`date_hour`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_carrier_hour_counts_archive`
--

LOCK TABLES `vicidial_carrier_hour_counts_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_carrier_hour_counts_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_carrier_hour_counts_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_carrier_log`
--

DROP TABLE IF EXISTS `vicidial_carrier_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_carrier_log` (
  `uniqueid` varchar(20) NOT NULL,
  `call_date` datetime DEFAULT NULL,
  `server_ip` varchar(15) NOT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `hangup_cause` tinyint(1) unsigned DEFAULT '0',
  `dialstatus` varchar(16) DEFAULT NULL,
  `channel` varchar(100) DEFAULT NULL,
  `dial_time` smallint(3) unsigned DEFAULT '0',
  `answered_time` smallint(4) unsigned DEFAULT '0',
  `sip_hangup_cause` smallint(4) unsigned DEFAULT '0',
  `sip_hangup_reason` varchar(50) DEFAULT '',
  `caller_code` varchar(30) DEFAULT '',
  PRIMARY KEY (`uniqueid`),
  KEY `call_date` (`call_date`),
  KEY `vdcllid` (`lead_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_carrier_log`
--

LOCK TABLES `vicidial_carrier_log` WRITE;
/*!40000 ALTER TABLE `vicidial_carrier_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_carrier_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_carrier_log_archive`
--

DROP TABLE IF EXISTS `vicidial_carrier_log_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_carrier_log_archive` (
  `uniqueid` varchar(20) NOT NULL,
  `call_date` datetime DEFAULT NULL,
  `server_ip` varchar(15) NOT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `hangup_cause` tinyint(1) unsigned DEFAULT '0',
  `dialstatus` varchar(16) DEFAULT NULL,
  `channel` varchar(100) DEFAULT NULL,
  `dial_time` smallint(3) unsigned DEFAULT '0',
  `answered_time` smallint(4) unsigned DEFAULT '0',
  `sip_hangup_cause` smallint(4) unsigned DEFAULT '0',
  `sip_hangup_reason` varchar(50) DEFAULT '',
  `caller_code` varchar(30) DEFAULT '',
  PRIMARY KEY (`uniqueid`),
  KEY `call_date` (`call_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_carrier_log_archive`
--

LOCK TABLES `vicidial_carrier_log_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_carrier_log_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_carrier_log_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_chat_archive`
--

DROP TABLE IF EXISTS `vicidial_chat_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_chat_archive` (
  `chat_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `chat_start_time` datetime DEFAULT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chat_creator` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `transferring_agent` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_direct` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_direct_group_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`chat_id`),
  KEY `vicidial_chat_archive_lead_id_key` (`lead_id`),
  KEY `vicidial_chat_archive_start_time_key` (`chat_start_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_chat_archive`
--

LOCK TABLES `vicidial_chat_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_chat_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_chat_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_chat_log`
--

DROP TABLE IF EXISTS `vicidial_chat_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_chat_log` (
  `message_row_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chat_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` mediumtext COLLATE utf8_unicode_ci,
  `message_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `poster` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chat_member_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chat_level` enum('0','1') COLLATE utf8_unicode_ci DEFAULT '0',
  PRIMARY KEY (`message_row_id`),
  KEY `vicidial_chat_log_user_key` (`poster`),
  KEY `live_chat_id` (`chat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_chat_log`
--

LOCK TABLES `vicidial_chat_log` WRITE;
/*!40000 ALTER TABLE `vicidial_chat_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_chat_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_chat_log_archive`
--

DROP TABLE IF EXISTS `vicidial_chat_log_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_chat_log_archive` (
  `message_row_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chat_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` mediumtext COLLATE utf8_unicode_ci,
  `message_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `poster` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chat_member_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chat_level` enum('0','1') COLLATE utf8_unicode_ci DEFAULT '0',
  PRIMARY KEY (`message_row_id`),
  KEY `vicidial_chat_log_archive_user_key` (`poster`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_chat_log_archive`
--

LOCK TABLES `vicidial_chat_log_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_chat_log_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_chat_log_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_chat_participants`
--

DROP TABLE IF EXISTS `vicidial_chat_participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_chat_participants` (
  `chat_participant_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `chat_id` int(9) unsigned DEFAULT NULL,
  `chat_member` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chat_member_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ping_date` datetime DEFAULT NULL,
  `vd_agent` enum('Y','N') COLLATE utf8_unicode_ci DEFAULT 'N',
  PRIMARY KEY (`chat_participant_id`),
  UNIQUE KEY `vicidial_chat_participants_key` (`chat_id`,`chat_member`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_chat_participants`
--

LOCK TABLES `vicidial_chat_participants` WRITE;
/*!40000 ALTER TABLE `vicidial_chat_participants` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_chat_participants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_cid_groups`
--

DROP TABLE IF EXISTS `vicidial_cid_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_cid_groups` (
  `cid_group_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `cid_group_notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `cid_group_type` enum('AREACODE','STATE') COLLATE utf8_unicode_ci DEFAULT 'AREACODE',
  `user_group` varchar(20) COLLATE utf8_unicode_ci DEFAULT '---ALL---',
  PRIMARY KEY (`cid_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_cid_groups`
--

LOCK TABLES `vicidial_cid_groups` WRITE;
/*!40000 ALTER TABLE `vicidial_cid_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_cid_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_closer_log`
--

DROP TABLE IF EXISTS `vicidial_closer_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_closer_log` (
  `closecallid` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `lead_id` int(9) unsigned NOT NULL,
  `list_id` bigint(14) unsigned DEFAULT NULL,
  `campaign_id` varchar(20) DEFAULT NULL,
  `call_date` datetime DEFAULT NULL,
  `start_epoch` int(10) unsigned DEFAULT NULL,
  `end_epoch` int(10) unsigned DEFAULT NULL,
  `length_in_sec` int(10) DEFAULT NULL,
  `status` varchar(6) DEFAULT NULL,
  `phone_code` varchar(10) DEFAULT NULL,
  `phone_number` varchar(18) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `processed` enum('Y','N') DEFAULT NULL,
  `queue_seconds` decimal(7,2) DEFAULT '0.00',
  `user_group` varchar(20) DEFAULT NULL,
  `xfercallid` int(9) unsigned DEFAULT NULL,
  `term_reason` enum('CALLER','AGENT','QUEUETIMEOUT','ABANDON','AFTERHOURS','HOLDRECALLXFER','HOLDTIME','NOAGENT','NONE','MAXCALLS','ACFILTER','CLOSETIME') DEFAULT 'NONE',
  `uniqueid` varchar(20) NOT NULL DEFAULT '',
  `agent_only` varchar(20) DEFAULT '',
  `queue_position` smallint(4) unsigned DEFAULT '1',
  `called_count` smallint(5) unsigned DEFAULT '0',
  PRIMARY KEY (`closecallid`),
  KEY `lead_id` (`lead_id`),
  KEY `call_date` (`call_date`),
  KEY `campaign_id` (`campaign_id`),
  KEY `uniqueid` (`uniqueid`),
  KEY `phone_number` (`phone_number`),
  KEY `date_user` (`call_date`,`user`)
) ENGINE=MyISAM AUTO_INCREMENT=2737 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_closer_log`
--

LOCK TABLES `vicidial_closer_log` WRITE;
/*!40000 ALTER TABLE `vicidial_closer_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_closer_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_closer_log_archive`
--

DROP TABLE IF EXISTS `vicidial_closer_log_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_closer_log_archive` (
  `closecallid` int(9) unsigned NOT NULL,
  `lead_id` int(9) unsigned NOT NULL,
  `list_id` bigint(14) unsigned DEFAULT NULL,
  `campaign_id` varchar(20) DEFAULT NULL,
  `call_date` datetime DEFAULT NULL,
  `start_epoch` int(10) unsigned DEFAULT NULL,
  `end_epoch` int(10) unsigned DEFAULT NULL,
  `length_in_sec` int(10) DEFAULT NULL,
  `status` varchar(6) DEFAULT NULL,
  `phone_code` varchar(10) DEFAULT NULL,
  `phone_number` varchar(18) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `processed` enum('Y','N') DEFAULT NULL,
  `queue_seconds` decimal(7,2) DEFAULT '0.00',
  `user_group` varchar(20) DEFAULT NULL,
  `xfercallid` int(9) unsigned DEFAULT NULL,
  `term_reason` enum('CALLER','AGENT','QUEUETIMEOUT','ABANDON','AFTERHOURS','HOLDRECALLXFER','HOLDTIME','NOAGENT','NONE','MAXCALLS','ACFILTER','CLOSETIME') DEFAULT 'NONE',
  `uniqueid` varchar(20) NOT NULL DEFAULT '',
  `agent_only` varchar(20) DEFAULT '',
  `queue_position` smallint(4) unsigned DEFAULT '1',
  `called_count` smallint(5) unsigned DEFAULT '0',
  PRIMARY KEY (`closecallid`),
  KEY `lead_id` (`lead_id`),
  KEY `call_date` (`call_date`),
  KEY `campaign_id` (`campaign_id`),
  KEY `uniqueid` (`uniqueid`),
  KEY `phone_number` (`phone_number`),
  KEY `date_user` (`call_date`,`user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_closer_log_archive`
--

LOCK TABLES `vicidial_closer_log_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_closer_log_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_closer_log_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_comments`
--

DROP TABLE IF EXISTS `vicidial_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_comments` (
  `comment_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `lead_id` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `list_id` bigint(14) unsigned NOT NULL,
  `campaign_id` varchar(8) NOT NULL,
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `hidden` tinyint(1) DEFAULT NULL,
  `hidden_user_id` int(11) DEFAULT NULL,
  `hidden_timestamp` datetime DEFAULT NULL,
  `unhidden_user_id` int(11) DEFAULT NULL,
  `unhidden_timestamp` datetime DEFAULT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `lead_id` (`lead_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_comments`
--

LOCK TABLES `vicidial_comments` WRITE;
/*!40000 ALTER TABLE `vicidial_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_conf_templates`
--

DROP TABLE IF EXISTS `vicidial_conf_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_conf_templates` (
  `template_id` varchar(15) NOT NULL,
  `template_name` varchar(50) NOT NULL,
  `template_contents` text,
  `user_group` varchar(20) DEFAULT '---ALL---',
  UNIQUE KEY `template_id` (`template_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_conf_templates`
--

LOCK TABLES `vicidial_conf_templates` WRITE;
/*!40000 ALTER TABLE `vicidial_conf_templates` DISABLE KEYS */;
INSERT INTO `vicidial_conf_templates` VALUES ('SIP_generic','SIP phone generic','type=friend\nhost=dynamic\ncanreinvite=no\ncontext=default','---ALL---'),('IAX_generic','IAX phone generic','type=friend\nhost=dynamic\nmaxauthreq=10\nauth=md5,plaintext,rsa\ncontext=default','---ALL---');
/*!40000 ALTER TABLE `vicidial_conf_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_conferences`
--

DROP TABLE IF EXISTS `vicidial_conferences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_conferences` (
  `conf_exten` int(7) unsigned NOT NULL,
  `server_ip` varchar(15) NOT NULL,
  `extension` varchar(100) DEFAULT NULL,
  `leave_3way` enum('0','1') DEFAULT '0',
  `leave_3way_datetime` datetime DEFAULT NULL,
  UNIQUE KEY `serverconf` (`server_ip`,`conf_exten`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_conferences`
--

LOCK TABLES `vicidial_conferences` WRITE;
/*!40000 ALTER TABLE `vicidial_conferences` DISABLE KEYS */;
INSERT INTO `vicidial_conferences` VALUES (8600051,'127.0.0.1','','0','2017-10-27 07:16:10'),(8600052,'127.0.0.1','','0','2017-10-27 09:58:07'),(8600053,'127.0.0.1','','0','2017-11-16 13:42:47'),(8600054,'127.0.0.1','','0','2017-10-27 09:59:12'),(8600055,'127.0.0.1','','0','2017-10-27 10:01:52'),(8600056,'127.0.0.1','','0',NULL),(8600057,'127.0.0.1','','0',NULL),(8600058,'127.0.0.1','','0',NULL),(8600059,'127.0.0.1','','0',NULL),(8600060,'127.0.0.1','','0',NULL),(8600061,'127.0.0.1','','0',NULL),(8600062,'127.0.0.1','','0',NULL),(8600063,'127.0.0.1','','0',NULL),(8600064,'127.0.0.1','','0',NULL),(8600065,'127.0.0.1','','0',NULL),(8600066,'127.0.0.1','','0',NULL),(8600067,'127.0.0.1','','0',NULL),(8600068,'127.0.0.1','','0',NULL),(8600069,'127.0.0.1','','0',NULL),(8600070,'127.0.0.1','','0',NULL),(8600071,'127.0.0.1','','0',NULL),(8600072,'127.0.0.1','','0',NULL),(8600073,'127.0.0.1','','0',NULL),(8600074,'127.0.0.1','','0',NULL),(8600075,'127.0.0.1','','0',NULL),(8600076,'127.0.0.1','','0',NULL),(8600077,'127.0.0.1','','0',NULL),(8600078,'127.0.0.1','','0',NULL),(8600079,'127.0.0.1','','0',NULL),(8600080,'127.0.0.1','','0',NULL),(8600081,'127.0.0.1','','0',NULL),(8600082,'127.0.0.1','','0',NULL),(8600083,'127.0.0.1','','0',NULL),(8600084,'127.0.0.1','','0',NULL),(8600085,'127.0.0.1','','0',NULL),(8600086,'127.0.0.1','','0',NULL),(8600087,'127.0.0.1','','0',NULL),(8600088,'127.0.0.1','','0',NULL),(8600089,'127.0.0.1','','0',NULL),(8600090,'127.0.0.1','','0',NULL),(8600091,'127.0.0.1','','0',NULL),(8600092,'127.0.0.1','','0',NULL),(8600093,'127.0.0.1','','0',NULL),(8600094,'127.0.0.1','','0',NULL),(8600095,'127.0.0.1','','0',NULL),(8600096,'127.0.0.1','','0',NULL),(8600097,'127.0.0.1','','0',NULL),(8600098,'127.0.0.1','','0',NULL),(8600099,'127.0.0.1','','0',NULL),(8600100,'127.0.0.1','','0',NULL),(8600101,'127.0.0.1','','0',NULL),(8600102,'127.0.0.1','','0',NULL),(8600103,'127.0.0.1','','0',NULL),(8600104,'127.0.0.1','','0',NULL),(8600105,'127.0.0.1','','0',NULL),(8600106,'127.0.0.1','','0',NULL),(8600107,'127.0.0.1','','0',NULL),(8600108,'127.0.0.1','','0',NULL),(8600109,'127.0.0.1','','0',NULL),(8600110,'127.0.0.1','','0',NULL),(8600111,'127.0.0.1','','0',NULL),(8600112,'127.0.0.1','','0',NULL),(8600113,'127.0.0.1','','0',NULL),(8600114,'127.0.0.1','','0',NULL),(8600115,'127.0.0.1','','0',NULL),(8600116,'127.0.0.1','','0',NULL),(8600117,'127.0.0.1','','0',NULL),(8600118,'127.0.0.1','','0',NULL),(8600119,'127.0.0.1','','0',NULL),(8600120,'127.0.0.1','','0',NULL),(8600121,'127.0.0.1','','0',NULL),(8600122,'127.0.0.1','','0',NULL),(8600123,'127.0.0.1','','0',NULL),(8600124,'127.0.0.1','','0',NULL),(8600125,'127.0.0.1','','0',NULL),(8600126,'127.0.0.1','','0',NULL),(8600127,'127.0.0.1','','0',NULL),(8600128,'127.0.0.1','','0',NULL),(8600129,'127.0.0.1','','0',NULL),(8600130,'127.0.0.1','','0',NULL),(8600131,'127.0.0.1','','0',NULL),(8600132,'127.0.0.1','','0',NULL),(8600133,'127.0.0.1','','0',NULL),(8600134,'127.0.0.1','','0',NULL),(8600135,'127.0.0.1','','0',NULL),(8600136,'127.0.0.1','','0',NULL),(8600137,'127.0.0.1','','0',NULL),(8600138,'127.0.0.1','','0',NULL),(8600139,'127.0.0.1','','0',NULL),(8600140,'127.0.0.1','','0',NULL),(8600141,'127.0.0.1','','0',NULL),(8600142,'127.0.0.1','','0',NULL),(8600143,'127.0.0.1','','0',NULL),(8600144,'127.0.0.1','','0',NULL),(8600145,'127.0.0.1','','0',NULL),(8600146,'127.0.0.1','','0',NULL),(8600147,'127.0.0.1','','0',NULL),(8600148,'127.0.0.1','','0',NULL),(8600149,'127.0.0.1','','0',NULL),(8600150,'127.0.0.1','','0',NULL),(8600151,'127.0.0.1','','0',NULL),(8600152,'127.0.0.1','','0',NULL),(8600153,'127.0.0.1','','0',NULL),(8600154,'127.0.0.1','','0',NULL),(8600155,'127.0.0.1','','0',NULL),(8600156,'127.0.0.1','','0',NULL),(8600157,'127.0.0.1','','0',NULL),(8600158,'127.0.0.1','','0',NULL),(8600159,'127.0.0.1','','0',NULL),(8600160,'127.0.0.1','','0',NULL),(8600161,'127.0.0.1','','0',NULL),(8600162,'127.0.0.1','','0',NULL),(8600163,'127.0.0.1','','0',NULL),(8600164,'127.0.0.1','','0',NULL),(8600165,'127.0.0.1','','0',NULL),(8600166,'127.0.0.1','','0',NULL),(8600167,'127.0.0.1','','0',NULL),(8600168,'127.0.0.1','','0',NULL),(8600169,'127.0.0.1','','0',NULL),(8600170,'127.0.0.1','','0',NULL),(8600171,'127.0.0.1','','0',NULL),(8600172,'127.0.0.1','','0',NULL),(8600173,'127.0.0.1','','0',NULL),(8600174,'127.0.0.1','','0',NULL),(8600175,'127.0.0.1','','0',NULL),(8600176,'127.0.0.1','','0',NULL),(8600177,'127.0.0.1','','0',NULL),(8600178,'127.0.0.1','','0',NULL),(8600179,'127.0.0.1','','0',NULL),(8600180,'127.0.0.1','','0',NULL),(8600181,'127.0.0.1','','0',NULL),(8600182,'127.0.0.1','','0',NULL),(8600183,'127.0.0.1','','0',NULL),(8600184,'127.0.0.1','','0',NULL),(8600185,'127.0.0.1','','0',NULL),(8600186,'127.0.0.1','','0',NULL),(8600187,'127.0.0.1','','0',NULL),(8600188,'127.0.0.1','','0',NULL),(8600189,'127.0.0.1','','0',NULL),(8600190,'127.0.0.1','','0',NULL),(8600191,'127.0.0.1','','0',NULL),(8600192,'127.0.0.1','','0',NULL),(8600193,'127.0.0.1','','0',NULL),(8600194,'127.0.0.1','','0',NULL),(8600195,'127.0.0.1','','0',NULL),(8600196,'127.0.0.1','','0',NULL),(8600197,'127.0.0.1','','0',NULL),(8600198,'127.0.0.1','','0',NULL),(8600199,'127.0.0.1','','0',NULL),(8600200,'127.0.0.1','','0',NULL),(8600201,'127.0.0.1','','0',NULL),(8600202,'127.0.0.1','','0',NULL),(8600203,'127.0.0.1','','0',NULL),(8600204,'127.0.0.1','','0',NULL),(8600205,'127.0.0.1','','0',NULL),(8600206,'127.0.0.1','','0',NULL),(8600207,'127.0.0.1','','0',NULL),(8600208,'127.0.0.1','','0',NULL),(8600209,'127.0.0.1','','0',NULL),(8600210,'127.0.0.1','','0',NULL),(8600211,'127.0.0.1','','0',NULL),(8600212,'127.0.0.1','','0',NULL),(8600213,'127.0.0.1','','0',NULL),(8600214,'127.0.0.1','','0',NULL),(8600215,'127.0.0.1','','0',NULL),(8600216,'127.0.0.1','','0',NULL),(8600217,'127.0.0.1','','0',NULL),(8600218,'127.0.0.1','','0',NULL),(8600219,'127.0.0.1','','0',NULL),(8600220,'127.0.0.1','','0',NULL),(8600221,'127.0.0.1','','0',NULL),(8600222,'127.0.0.1','','0',NULL),(8600223,'127.0.0.1','','0',NULL),(8600224,'127.0.0.1','','0',NULL),(8600225,'127.0.0.1','','0',NULL),(8600226,'127.0.0.1','','0',NULL),(8600227,'127.0.0.1','','0',NULL),(8600228,'127.0.0.1','','0',NULL),(8600229,'127.0.0.1','','0',NULL),(8600230,'127.0.0.1','','0',NULL),(8600231,'127.0.0.1','','0',NULL),(8600232,'127.0.0.1','','0',NULL),(8600233,'127.0.0.1','','0',NULL),(8600234,'127.0.0.1','','0',NULL),(8600235,'127.0.0.1','','0',NULL),(8600236,'127.0.0.1','','0',NULL),(8600237,'127.0.0.1','','0',NULL),(8600238,'127.0.0.1','','0',NULL),(8600239,'127.0.0.1','','0',NULL),(8600240,'127.0.0.1','','0',NULL),(8600241,'127.0.0.1','','0',NULL),(8600242,'127.0.0.1','','0',NULL),(8600243,'127.0.0.1','','0',NULL),(8600244,'127.0.0.1','','0',NULL),(8600245,'127.0.0.1','','0',NULL),(8600246,'127.0.0.1','','0',NULL),(8600247,'127.0.0.1','','0',NULL),(8600248,'127.0.0.1','','0',NULL),(8600249,'127.0.0.1','','0',NULL),(8600250,'127.0.0.1','','0',NULL),(8600251,'127.0.0.1','','0',NULL),(8600252,'127.0.0.1','','0',NULL),(8600253,'127.0.0.1','','0',NULL),(8600254,'127.0.0.1','','0',NULL),(8600255,'127.0.0.1','','0',NULL),(8600256,'127.0.0.1','','0',NULL),(8600257,'127.0.0.1','','0',NULL),(8600258,'127.0.0.1','','0',NULL),(8600259,'127.0.0.1','','0',NULL),(8600260,'127.0.0.1','','0',NULL),(8600261,'127.0.0.1','','0',NULL),(8600262,'127.0.0.1','','0',NULL),(8600263,'127.0.0.1','','0',NULL),(8600264,'127.0.0.1','','0',NULL),(8600265,'127.0.0.1','','0',NULL),(8600266,'127.0.0.1','','0',NULL),(8600267,'127.0.0.1','','0',NULL),(8600268,'127.0.0.1','','0',NULL),(8600269,'127.0.0.1','','0',NULL),(8600270,'127.0.0.1','','0',NULL),(8600271,'127.0.0.1','','0',NULL),(8600272,'127.0.0.1','','0',NULL),(8600273,'127.0.0.1','','0',NULL),(8600274,'127.0.0.1','','0',NULL),(8600275,'127.0.0.1','','0',NULL),(8600276,'127.0.0.1','','0',NULL),(8600277,'127.0.0.1','','0',NULL),(8600278,'127.0.0.1','','0',NULL),(8600279,'127.0.0.1','','0',NULL),(8600280,'127.0.0.1','','0',NULL),(8600281,'127.0.0.1','','0',NULL),(8600282,'127.0.0.1','','0',NULL),(8600283,'127.0.0.1','','0',NULL),(8600284,'127.0.0.1','','0',NULL),(8600285,'127.0.0.1','','0',NULL),(8600286,'127.0.0.1','','0',NULL),(8600287,'127.0.0.1','','0',NULL),(8600288,'127.0.0.1','','0',NULL),(8600289,'127.0.0.1','','0',NULL),(8600290,'127.0.0.1','','0',NULL),(8600291,'127.0.0.1','','0',NULL),(8600292,'127.0.0.1','','0',NULL),(8600293,'127.0.0.1','','0',NULL),(8600294,'127.0.0.1','','0',NULL),(8600295,'127.0.0.1','','0',NULL),(8600296,'127.0.0.1','','0',NULL),(8600297,'127.0.0.1','','0',NULL),(8600298,'127.0.0.1','','0',NULL),(8600299,'127.0.0.1','','0',NULL);
/*!40000 ALTER TABLE `vicidial_conferences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_configuration`
--

DROP TABLE IF EXISTS `vicidial_configuration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(36) NOT NULL,
  `value` varchar(36) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_configuration`
--

LOCK TABLES `vicidial_configuration` WRITE;
/*!40000 ALTER TABLE `vicidial_configuration` DISABLE KEYS */;
INSERT INTO `vicidial_configuration` VALUES (1,'qc_database_version','1766');
/*!40000 ALTER TABLE `vicidial_configuration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_country_iso_tld`
--

DROP TABLE IF EXISTS `vicidial_country_iso_tld`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_country_iso_tld` (
  `country_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT '',
  `iso2` varchar(2) COLLATE utf8_unicode_ci DEFAULT '',
  `iso3` varchar(3) COLLATE utf8_unicode_ci DEFAULT '',
  `num3` varchar(4) COLLATE utf8_unicode_ci DEFAULT '',
  `tld` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  KEY `iso3` (`iso3`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_country_iso_tld`
--

LOCK TABLES `vicidial_country_iso_tld` WRITE;
/*!40000 ALTER TABLE `vicidial_country_iso_tld` DISABLE KEYS */;
INSERT INTO `vicidial_country_iso_tld` VALUES ('Afghanistan','AF','AFG','004','af'),('Aland Islands','AX','ALA','248','ax'),('Albania','AL','ALB','008','al'),('Algeria','DZ','DZA','012','dz'),('American Samoa','AS','ASM','016','as'),('Andorra','AD','AND','020','ad'),('Angola','AO','AGO','024','ao'),('Anguilla','AI','AIA','660','ai'),('Antarctica','AQ','ATA','010','aq'),('Antigua and Barbuda','AG','ATG','028','ag'),('Argentina','AR','ARG','032','ar'),('Armenia','AM','ARM','051','am'),('Aruba','AW','ABW','533','aw'),('Australia','AU','AUS','036','au'),('Austria','AT','AUT','040','at'),('Azerbaijan','AZ','AZE','031','az'),('Bahamas','BS','BHS','044','bs'),('Bahrain','BH','BHR','048','bh'),('Bangladesh','BD','BGD','050','bd'),('Barbados','BB','BRB','052','bb'),('Belarus','BY','BLR','112','by'),('Belgium','BE','BEL','056','be'),('Belize','BZ','BLZ','084','bz'),('Benin','BJ','BEN','204','bj'),('Bermuda','BM','BMU','060','bm'),('Bhutan','BT','BTN','064','bt'),('Bolivia (Plurinational State of)','BO','BOL','068','bo'),('Bonaire, Sint Eustatius and Saba','BQ','BES','535','bq'),('Bosnia and Herzegovina','BA','BIH','070','ba'),('Botswana','BW','BWA','072','bw'),('Bouvet Island','BV','BVT','074','bv'),('Brazil','BR','BRA','076','br'),('British Indian Ocean Territory','IO','IOT','086','io'),('Brunei Darussalam','BN','BRN','096','bn'),('Bulgaria','BG','BGR','100','bg'),('Burkina Faso','BF','BFA','854','bf'),('Burundi','BI','BDI','108','bi'),('Cambodia','KH','KHM','116','kh'),('Cameroon','CM','CMR','120','cm'),('Canada','CA','CAN','124','ca'),('Cabo Verde','CV','CPV','132','cv'),('Cayman Islands','KY','CYM','136','ky'),('Central African Republic','CF','CAF','140','cf'),('Chad','TD','TCD','148','td'),('Chile','CL','CHL','152','cl'),('China','CN','CHN','156','cn'),('Christmas Island','CX','CXR','162','cx'),('Cocos (Keeling) Islands','CC','CCK','166','cc'),('Colombia','CO','COL','170','co'),('Comoros','KM','COM','174','km'),('Congo','CG','COG','178','cg'),('Congo (Democratic Republic of the)','CD','COD','180','cd'),('Cook Islands','CK','COK','184','ck'),('Costa Rica','CR','CRI','188','cr'),('CÃ´te d\'Ivoire','CI','CIV','384','ci'),('Croatia','HR','HRV','191','hr'),('Cuba','CU','CUB','192','cu'),('CuraÃ§ao','CW','CUW','531','cw'),('Cyprus','CY','CYP','196','cy'),('Czech Republic','CZ','CZE','203','cz'),('Denmark','DK','DNK','208','dk'),('Djibouti','DJ','DJI','262','dj'),('Dominica','DM','DMA','212','dm'),('Dominican Republic','DO','DOM','214','do'),('Ecuador','EC','ECU','218','ec'),('Egypt','EG','EGY','818','eg'),('El Salvador','SV','SLV','222','sv'),('Equatorial Guinea','GQ','GNQ','226','gq'),('Eritrea','ER','ERI','232','er'),('Estonia','EE','EST','233','ee'),('Ethiopia','ET','ETH','231','et'),('Falkland Islands (Malvinas)','FK','FLK','238','fk'),('Faroe Islands','FO','FRO','234','fo'),('Fiji','FJ','FJI','242','fj'),('Finland','FI','FIN','246','fi'),('France','FR','FRA','250','fr'),('French Guiana','GF','GUF','254','gf'),('French Polynesia','PF','PYF','258','pf'),('French Southern Territories','TF','ATF','260','tf'),('Gabon','GA','GAB','266','ga'),('Gambia','GM','GMB','270','gm'),('Georgia','GE','GEO','268','ge'),('Germany','DE','DEU','276','de'),('Ghana','GH','GHA','288','gh'),('Gibraltar','GI','GIB','292','gi'),('Greece','GR','GRC','300','gr'),('Greenland','GL','GRL','304','gl'),('Grenada','GD','GRD','308','gd'),('Guadeloupe','GP','GLP','312','gp'),('Guam','GU','GUM','316','gu'),('Guatemala','GT','GTM','320','gt'),('Guernsey','GG','GGY','831','gg'),('Guinea','GN','GIN','324','gn'),('Guinea-Bissau','GW','GNB','624','gw'),('Guyana','GY','GUY','328','gy'),('Haiti','HT','HTI','332','ht'),('Heard Island and McDonald Islands','HM','HMD','334','hm'),('Vatican City','VA','VAT','336','va'),('Honduras','HN','HND','340','hn'),('Hong Kong','HK','HKG','344','hk'),('Hungary','HU','HUN','348','hu'),('Iceland','IS','ISL','352','is'),('India','IN','IND','356','in'),('Indonesia','ID','IDN','360','id'),('Iran (Islamic Republic of)','IR','IRN','364','ir'),('Iraq','IQ','IRQ','368','iq'),('Ireland','IE','IRL','372','ie'),('Isle of Man','IM','IMN','833','im'),('Israel','IL','ISR','376','il'),('Italy','IT','ITA','380','it'),('Jamaica','JM','JAM','388','jm'),('Japan','JP','JPN','392','jp'),('Jersey','JE','JEY','832','je'),('Jordan','JO','JOR','400','jo'),('Kazakhstan','KZ','KAZ','398','kz'),('Kenya','KE','KEN','404','ke'),('Kiribati','KI','KIR','296','ki'),('Korea (Democratic People\'s Republic of)','KP','PRK','408','kp'),('Korea (Republic of)','KR','KOR','410','kr'),('Kosovo','XK','XKX','?','?'),('Kuwait','KW','KWT','414','kw'),('Kyrgyzstan','KG','KGZ','417','kg'),('Lao People\'s Democratic Republic','LA','LAO','418','la'),('Latvia','LV','LVA','428','lv'),('Lebanon','LB','LBN','422','lb'),('Lesotho','LS','LSO','426','ls'),('Liberia','LR','LBR','430','lr'),('Libya','LY','LBY','434','ly'),('Liechtenstein','LI','LIE','438','li'),('Lithuania','LT','LTU','440','lt'),('Luxembourg','LU','LUX','442','lu'),('Macao','MO','MAC','446','mo'),('Macedonia (the former Yugoslav Republic of)','MK','MKD','807','mk'),('Madagascar','MG','MDG','450','mg'),('Malawi','MW','MWI','454','mw'),('Malaysia','MY','MYS','458','my'),('Maldives','MV','MDV','462','mv'),('Mali','ML','MLI','466','ml'),('Malta','MT','MLT','470','mt'),('Marshall Islands','MH','MHL','584','mh'),('Martinique','MQ','MTQ','474','mq'),('Mauritania','MR','MRT','478','mr'),('Mauritius','MU','MUS','480','mu'),('Mayotte','YT','MYT','175','yt'),('Mexico','MX','MEX','484','mx'),('Micronesia (Federated States of)','FM','FSM','583','fm'),('Moldova (Republic of)','MD','MDA','498','md'),('Monaco','MC','MCO','492','mc'),('Mongolia','MN','MNG','496','mn'),('Montenegro','ME','MNE','499','me'),('Montserrat','MS','MSR','500','ms'),('Morocco','MA','MAR','504','ma'),('Mozambique','MZ','MOZ','508','mz'),('Myanmar','MM','MMR','104','mm'),('Namibia','NA','NAM','516','na'),('Nauru','NR','NRU','520','nr'),('Nepal','NP','NPL','524','np'),('Netherlands','NL','NLD','528','nl'),('New Caledonia','NC','NCL','540','nc'),('New Zealand','NZ','NZL','554','nz'),('Nicaragua','NI','NIC','558','ni'),('Niger','NE','NER','562','ne'),('Nigeria','NG','NGA','566','ng'),('Niue','NU','NIU','570','nu'),('Norfolk Island','NF','NFK','574','nf'),('Northern Mariana Islands','MP','MNP','580','mp'),('Norway','NO','NOR','578','no'),('Oman','OM','OMN','512','om'),('Pakistan','PK','PAK','586','pk'),('Palau','PW','PLW','585','pw'),('Palestine','PS','PSE','275','ps'),('Panama','PA','PAN','591','pa'),('Papua New Guinea','PG','PNG','598','pg'),('Paraguay','PY','PRY','600','py'),('Peru','PE','PER','604','pe'),('Philippines','PH','PHL','608','ph'),('Pitcairn','PN','PCN','612','pn'),('Poland','PL','POL','616','pl'),('Portugal','PT','PRT','620','pt'),('Puerto Rico','PR','PRI','630','pr'),('Qatar','QA','QAT','634','qa'),('RÃ©union','RE','REU','638','re'),('Romania','RO','ROU','642','ro'),('Russian Federation','RU','RUS','643','ru'),('Rwanda','RW','RWA','646','rw'),('Saint BarthÃ©lemy','BL','BLM','652','gp'),('Saint Helena, Ascension and Tristan da Cunha','SH','SHN','654','sh'),('Saint Kitts and Nevis','KN','KNA','659','kn'),('Saint Lucia','LC','LCA','662','lc'),('Saint Martin (French part)','MF','MAF','663','gp'),('Saint Pierre and Miquelon','PM','SPM','666','pm'),('Saint Vincent and the Grenadines','VC','VCT','670','vc'),('Samoa','WS','WSM','882','ws'),('San Marino','SM','SMR','674','sm'),('Sao Tome and Principe','ST','STP','678','st'),('Saudi Arabia','SA','SAU','682','sa'),('Senegal','SN','SEN','686','sn'),('Serbia','RS','SRB','688','rs'),('Seychelles','SC','SYC','690','sc'),('Sierra Leone','SL','SLE','694','sl'),('Singapore','SG','SGP','702','sg'),('Sint Maarten (Dutch part)','SX','SXM','534','sx'),('Slovakia','SK','SVK','703','sk'),('Slovenia','SI','SVN','705','si'),('Solomon Islands','SB','SLB','090','sb'),('Somalia','SO','SOM','706','so'),('South Africa','ZA','ZAF','710','za'),('South Georgia and the South Sandwich Islands','GS','SGS','239','gs'),('South Sudan','SS','SSD','728','ss'),('Spain','ES','ESP','724','es'),('Sri Lanka','LK','LKA','144','lk'),('Sudan','SD','SDN','729','sd'),('Suriname','SR','SUR','740','sr'),('Svalbard and Jan Mayen','SJ','SJM','744','sj'),('Swaziland','SZ','SWZ','748','sz'),('Sweden','SE','SWE','752','se'),('Switzerland','CH','CHE','756','ch'),('Syrian Arab Republic','SY','SYR','760','sy'),('Taiwan, Province of China','TW','TWN','158','tw'),('Tajikistan','TJ','TJK','762','tj'),('Tanzania, United Republic of','TZ','TZA','834','tz'),('Thailand','TH','THA','764','th'),('Timor-Leste','TL','TLS','626','tl'),('Togo','TG','TGO','768','tg'),('Tokelau','TK','TKL','772','tk'),('Tonga','TO','TON','776','to'),('Trinidad and Tobago','TT','TTO','780','tt'),('Tunisia','TN','TUN','788','tn'),('Turkey','TR','TUR','792','tr'),('Turkmenistan','TM','TKM','795','tm'),('Turks and Caicos Islands','TC','TCA','796','tc'),('Tuvalu','TV','TUV','798','tv'),('Uganda','UG','UGA','800','ug'),('Ukraine','UA','UKR','804','ua'),('United Arab Emirates','AE','ARE','784','ae'),('United Kingdom of Great Britain and Northern Ireland','GB','GBR','826','uk'),('United States of America','US','USA','840','us'),('United States Minor Outlying Islands','UM','UMI','581','us'),('Uruguay','UY','URY','858','uy'),('Uzbekistan','UZ','UZB','860','uz'),('Vanuatu','VU','VUT','548','vu'),('Venezuela (Bolivarian Republic of)','VE','VEN','862','ve'),('Viet Nam','VN','VNM','704','vn'),('Virgin Islands (British)','VG','VGB','092','vg'),('Virgin Islands (U.S.)','VI','VIR','850','vi'),('Wallis and Futuna','WF','WLF','876','wf'),('Western Sahara','EH','ESH','732','eh'),('Yemen','YE','YEM','887','ye'),('Zambia','ZM','ZMB','894','zm'),('Zimbabwe','ZW','ZWE','716','zw');
/*!40000 ALTER TABLE `vicidial_country_iso_tld` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_cpd_log`
--

DROP TABLE IF EXISTS `vicidial_cpd_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_cpd_log` (
  `cpd_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `channel` varchar(100) NOT NULL,
  `uniqueid` varchar(20) DEFAULT NULL,
  `callerid` varchar(20) DEFAULT NULL,
  `server_ip` varchar(15) NOT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `event_date` datetime DEFAULT NULL,
  `result` varchar(20) DEFAULT NULL,
  `status` enum('NEW','PROCESSED') DEFAULT 'NEW',
  `cpd_seconds` decimal(7,2) DEFAULT '0.00',
  PRIMARY KEY (`cpd_id`),
  KEY `uniqueid` (`uniqueid`),
  KEY `callerid` (`callerid`),
  KEY `lead_id` (`lead_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_cpd_log`
--

LOCK TABLES `vicidial_cpd_log` WRITE;
/*!40000 ALTER TABLE `vicidial_cpd_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_cpd_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_custom_cid`
--

DROP TABLE IF EXISTS `vicidial_custom_cid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_custom_cid` (
  `cid` varchar(18) NOT NULL,
  `state` varchar(20) DEFAULT NULL,
  `areacode` varchar(6) DEFAULT NULL,
  `country_code` smallint(5) unsigned DEFAULT NULL,
  `campaign_id` varchar(8) DEFAULT '--ALL--',
  KEY `state` (`state`),
  KEY `areacode` (`areacode`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_custom_cid`
--

LOCK TABLES `vicidial_custom_cid` WRITE;
/*!40000 ALTER TABLE `vicidial_custom_cid` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_custom_cid` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_custom_leadloader_templates`
--

DROP TABLE IF EXISTS `vicidial_custom_leadloader_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_custom_leadloader_templates` (
  `template_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `template_name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `template_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `list_id` int(10) unsigned DEFAULT NULL,
  `standard_variables` text COLLATE utf8_unicode_ci,
  `custom_table` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custom_variables` text COLLATE utf8_unicode_ci,
  `template_statuses` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`template_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_custom_leadloader_templates`
--

LOCK TABLES `vicidial_custom_leadloader_templates` WRITE;
/*!40000 ALTER TABLE `vicidial_custom_leadloader_templates` DISABLE KEYS */;
INSERT INTO `vicidial_custom_leadloader_templates` VALUES ('SAMPLE_TEMPLATE','Sample template','',999,'phone_number,9|first_name,0|last_name,1|address1,3|address2,4|address3,5|city,6|state,7|postal_code,8|','custom_999','appointment_date,2|appointment_notes,9|nearest_city,2|',NULL);
/*!40000 ALTER TABLE `vicidial_custom_leadloader_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_custom_reports`
--

DROP TABLE IF EXISTS `vicidial_custom_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_custom_reports` (
  `custom_report_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `report_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `user` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domain` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path_name` text COLLATE utf8_unicode_ci,
  `custom_variables` text COLLATE utf8_unicode_ci,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_modify` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`custom_report_id`),
  UNIQUE KEY `custom_report_name_key` (`report_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_custom_reports`
--

LOCK TABLES `vicidial_custom_reports` WRITE;
/*!40000 ALTER TABLE `vicidial_custom_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_custom_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_daily_max_stats`
--

DROP TABLE IF EXISTS `vicidial_daily_max_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_daily_max_stats` (
  `stats_date` date NOT NULL,
  `stats_flag` enum('OPEN','CLOSED','CLOSING') COLLATE utf8_unicode_ci DEFAULT 'CLOSED',
  `stats_type` enum('TOTAL','INGROUP','CAMPAIGN','') COLLATE utf8_unicode_ci DEFAULT '',
  `campaign_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `closed_time` datetime DEFAULT NULL,
  `max_channels` mediumint(8) unsigned DEFAULT '0',
  `max_calls` mediumint(8) unsigned DEFAULT '0',
  `max_inbound` mediumint(8) unsigned DEFAULT '0',
  `max_outbound` mediumint(8) unsigned DEFAULT '0',
  `max_agents` mediumint(8) unsigned DEFAULT '0',
  `max_remote_agents` mediumint(8) unsigned DEFAULT '0',
  `total_calls` int(9) unsigned DEFAULT '0',
  KEY `stats_date` (`stats_date`),
  KEY `stats_flag` (`stats_flag`),
  KEY `campaign_id` (`campaign_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_daily_max_stats`
--

LOCK TABLES `vicidial_daily_max_stats` WRITE;
/*!40000 ALTER TABLE `vicidial_daily_max_stats` DISABLE KEYS */;
INSERT INTO `vicidial_daily_max_stats` VALUES ('2018-09-24','OPEN','TOTAL','','2018-09-23 21:14:33',NULL,0,0,0,0,2,2,0),('2018-09-24','OPEN','INGROUP','AGENTDIRECT','2018-09-23 21:15:03',NULL,0,0,0,0,0,0,0),('2018-09-24','OPEN','INGROUP','AGENTDIRECT_CHAT','2018-09-23 21:15:03',NULL,0,0,0,0,0,0,0),('2018-09-24','OPEN','INGROUP','SalesAndBilling','2018-09-23 21:15:03',NULL,0,0,0,0,0,0,0),('2018-09-24','OPEN','INGROUP','TechSupport','2018-09-23 21:15:03',NULL,0,0,0,0,0,0,0),('2018-09-24','OPEN','INGROUP','Closer','2018-09-23 21:15:03',NULL,0,0,0,0,0,0,0),('2018-09-24','OPEN','INGROUP','ING12345678901','2018-09-23 21:15:03',NULL,0,0,0,0,0,0,0),('2018-09-24','OPEN','INGROUP','INGTest','2018-09-23 21:15:03',NULL,0,0,0,0,0,0,0),('2018-09-24','OPEN','INGROUP','ING8552861592','2018-09-23 21:15:03',NULL,0,0,0,0,0,0,0),('2018-09-24','OPEN','INGROUP','ING123456789','2018-09-23 21:15:03',NULL,0,0,0,0,0,0,0),('2018-09-24','OPEN','INGROUP','ING123','2018-09-23 21:15:03',NULL,0,0,0,0,0,0,0),('2018-09-24','OPEN','INGROUP','ING987654321','2018-09-23 21:15:03',NULL,0,0,0,0,0,0,0),('2018-09-24','OPEN','INGROUP','ING1920192019','2018-09-23 21:15:03',NULL,0,0,0,0,0,0,0),('2018-09-24','OPEN','INGROUP','TESTBUG6818','2018-09-23 21:15:03',NULL,0,0,0,0,0,0,0),('2018-09-24','OPEN','INGROUP','ING3233808432','2018-09-23 21:15:03',NULL,0,0,0,0,0,0,0),('2018-09-24','OPEN','INGROUP','ING4844147','2018-09-23 21:15:03',NULL,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `vicidial_daily_max_stats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_daily_ra_stats`
--

DROP TABLE IF EXISTS `vicidial_daily_ra_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_daily_ra_stats` (
  `stats_date` date NOT NULL,
  `stats_flag` enum('OPEN','CLOSED','CLOSING') COLLATE utf8_unicode_ci DEFAULT 'CLOSED',
  `user` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `closed_time` datetime DEFAULT NULL,
  `max_calls` mediumint(8) unsigned DEFAULT '0',
  `total_calls` int(9) unsigned DEFAULT '0',
  KEY `stats_date` (`stats_date`),
  KEY `stats_flag` (`stats_flag`),
  KEY `user` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_daily_ra_stats`
--

LOCK TABLES `vicidial_daily_ra_stats` WRITE;
/*!40000 ALTER TABLE `vicidial_daily_ra_stats` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_daily_ra_stats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_dial_log`
--

DROP TABLE IF EXISTS `vicidial_dial_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_dial_log` (
  `caller_code` varchar(30) NOT NULL,
  `lead_id` int(9) unsigned DEFAULT '0',
  `server_ip` varchar(15) DEFAULT NULL,
  `call_date` datetime DEFAULT NULL,
  `extension` varchar(100) DEFAULT '',
  `channel` varchar(100) DEFAULT '',
  `context` varchar(100) DEFAULT '',
  `timeout` mediumint(7) unsigned DEFAULT '0',
  `outbound_cid` varchar(100) DEFAULT '',
  `sip_hangup_cause` smallint(4) unsigned DEFAULT '0',
  `sip_hangup_reason` varchar(50) DEFAULT '',
  `uniqueid` varchar(20) DEFAULT '',
  KEY `caller_code` (`caller_code`),
  KEY `call_date` (`call_date`),
  KEY `vddllid` (`lead_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_dial_log`
--

LOCK TABLES `vicidial_dial_log` WRITE;
/*!40000 ALTER TABLE `vicidial_dial_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_dial_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_dial_log_archive`
--

DROP TABLE IF EXISTS `vicidial_dial_log_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_dial_log_archive` (
  `caller_code` varchar(30) NOT NULL,
  `lead_id` int(9) unsigned DEFAULT '0',
  `server_ip` varchar(15) DEFAULT NULL,
  `call_date` datetime DEFAULT NULL,
  `extension` varchar(100) DEFAULT '',
  `channel` varchar(100) DEFAULT '',
  `context` varchar(100) DEFAULT '',
  `timeout` mediumint(7) unsigned DEFAULT '0',
  `outbound_cid` varchar(100) DEFAULT '',
  `sip_hangup_cause` smallint(4) unsigned DEFAULT '0',
  `sip_hangup_reason` varchar(50) DEFAULT '',
  `uniqueid` varchar(20) DEFAULT '',
  UNIQUE KEY `vddla` (`caller_code`,`call_date`),
  KEY `caller_code` (`caller_code`),
  KEY `call_date` (`call_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_dial_log_archive`
--

LOCK TABLES `vicidial_dial_log_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_dial_log_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_dial_log_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_did_agent_log`
--

DROP TABLE IF EXISTS `vicidial_did_agent_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_did_agent_log` (
  `uniqueid` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `server_ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `caller_id_number` varchar(18) COLLATE utf8_unicode_ci DEFAULT NULL,
  `caller_id_name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extension` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `call_date` datetime DEFAULT NULL,
  `did_id` varchar(9) COLLATE utf8_unicode_ci DEFAULT '',
  `did_description` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `did_route` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `group_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `user` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'VDCL',
  KEY `uniqueid` (`uniqueid`),
  KEY `caller_id_number` (`caller_id_number`),
  KEY `extension` (`extension`),
  KEY `call_date` (`call_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_did_agent_log`
--

LOCK TABLES `vicidial_did_agent_log` WRITE;
/*!40000 ALTER TABLE `vicidial_did_agent_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_did_agent_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_did_agent_log_archive`
--

DROP TABLE IF EXISTS `vicidial_did_agent_log_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_did_agent_log_archive` (
  `uniqueid` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `server_ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `caller_id_number` varchar(18) COLLATE utf8_unicode_ci DEFAULT NULL,
  `caller_id_name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extension` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `call_date` datetime DEFAULT NULL,
  `did_id` varchar(9) COLLATE utf8_unicode_ci DEFAULT '',
  `did_description` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `did_route` varchar(9) COLLATE utf8_unicode_ci DEFAULT '',
  `group_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `user` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'VDCL',
  UNIQUE KEY `vdala` (`uniqueid`,`call_date`,`did_route`),
  KEY `uniqueid` (`uniqueid`),
  KEY `caller_id_number` (`caller_id_number`),
  KEY `extension` (`extension`),
  KEY `call_date` (`call_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_did_agent_log_archive`
--

LOCK TABLES `vicidial_did_agent_log_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_did_agent_log_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_did_agent_log_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_did_log`
--

DROP TABLE IF EXISTS `vicidial_did_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_did_log` (
  `uniqueid` varchar(20) NOT NULL,
  `channel` varchar(100) NOT NULL,
  `server_ip` varchar(15) NOT NULL,
  `caller_id_number` varchar(18) DEFAULT NULL,
  `caller_id_name` varchar(20) DEFAULT NULL,
  `extension` varchar(100) DEFAULT NULL,
  `call_date` datetime DEFAULT NULL,
  `did_id` varchar(9) DEFAULT '',
  `did_route` varchar(20) DEFAULT '',
  KEY `uniqueid` (`uniqueid`),
  KEY `caller_id_number` (`caller_id_number`),
  KEY `extension` (`extension`),
  KEY `call_date` (`call_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_did_log`
--

LOCK TABLES `vicidial_did_log` WRITE;
/*!40000 ALTER TABLE `vicidial_did_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_did_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_did_ra_extensions`
--

DROP TABLE IF EXISTS `vicidial_did_ra_extensions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_did_ra_extensions` (
  `did_id` int(9) unsigned NOT NULL,
  `user_start` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extension` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `description` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` enum('Y','N','') COLLATE utf8_unicode_ci DEFAULT '',
  `call_count_today` mediumint(7) DEFAULT '0',
  UNIQUE KEY `didraexten` (`did_id`,`user_start`,`extension`),
  KEY `did_id` (`did_id`),
  KEY `user_start` (`user_start`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_did_ra_extensions`
--

LOCK TABLES `vicidial_did_ra_extensions` WRITE;
/*!40000 ALTER TABLE `vicidial_did_ra_extensions` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_did_ra_extensions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_dnc`
--

DROP TABLE IF EXISTS `vicidial_dnc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_dnc` (
  `phone_number` varchar(18) NOT NULL,
  PRIMARY KEY (`phone_number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_dnc`
--

LOCK TABLES `vicidial_dnc` WRITE;
/*!40000 ALTER TABLE `vicidial_dnc` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_dnc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_dnc_log`
--

DROP TABLE IF EXISTS `vicidial_dnc_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_dnc_log` (
  `phone_number` varchar(18) COLLATE utf8_unicode_ci NOT NULL,
  `campaign_id` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `action` enum('add','delete') COLLATE utf8_unicode_ci DEFAULT 'add',
  `action_date` datetime NOT NULL,
  `user` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  KEY `phone_number` (`phone_number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_dnc_log`
--

LOCK TABLES `vicidial_dnc_log` WRITE;
/*!40000 ALTER TABLE `vicidial_dnc_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_dnc_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_dnccom_filter_log`
--

DROP TABLE IF EXISTS `vicidial_dnccom_filter_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_dnccom_filter_log` (
  `filter_log_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `lead_id` int(9) unsigned NOT NULL,
  `list_id` bigint(14) unsigned DEFAULT NULL,
  `filter_date` datetime DEFAULT NULL,
  `new_status` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `old_status` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(18) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dnccom_data` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`filter_log_id`),
  KEY `lead_id` (`lead_id`),
  KEY `filter_date` (`filter_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_dnccom_filter_log`
--

LOCK TABLES `vicidial_dnccom_filter_log` WRITE;
/*!40000 ALTER TABLE `vicidial_dnccom_filter_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_dnccom_filter_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_dnccom_scrub_log`
--

DROP TABLE IF EXISTS `vicidial_dnccom_scrub_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_dnccom_scrub_log` (
  `phone_number` varchar(18) DEFAULT NULL,
  `scrub_date` datetime NOT NULL,
  `flag_invalid` enum('','0','1') DEFAULT '',
  `flag_dnc` enum('','0','1') DEFAULT '',
  `flag_projdnc` enum('','0','1') DEFAULT '',
  `flag_litigator` enum('','0','1') DEFAULT '',
  `full_response` varchar(255) DEFAULT '',
  KEY `phone_number` (`phone_number`),
  KEY `scrub_date` (`scrub_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_dnccom_scrub_log`
--

LOCK TABLES `vicidial_dnccom_scrub_log` WRITE;
/*!40000 ALTER TABLE `vicidial_dnccom_scrub_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_dnccom_scrub_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_drop_lists`
--

DROP TABLE IF EXISTS `vicidial_drop_lists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_drop_lists` (
  `dl_id` varchar(30) NOT NULL,
  `dl_name` varchar(100) DEFAULT NULL,
  `last_run` datetime DEFAULT NULL,
  `dl_server` varchar(30) DEFAULT 'active_voicemail_server',
  `dl_times` varchar(120) DEFAULT '',
  `dl_weekdays` varchar(7) DEFAULT '',
  `dl_monthdays` varchar(100) DEFAULT '',
  `drop_statuses` varchar(255) DEFAULT ' DROP -',
  `list_id` bigint(14) unsigned DEFAULT NULL,
  `duplicate_check` varchar(50) DEFAULT 'NONE',
  `run_now_trigger` enum('N','Y') DEFAULT 'N',
  `active` enum('N','Y') DEFAULT 'N',
  `user_group` varchar(20) DEFAULT '---ALL---',
  `closer_campaigns` text,
  `dl_minutes` mediumint(6) unsigned DEFAULT '0',
  UNIQUE KEY `dl_id` (`dl_id`),
  KEY `dl_times` (`dl_times`),
  KEY `run_now_trigger` (`run_now_trigger`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_drop_lists`
--

LOCK TABLES `vicidial_drop_lists` WRITE;
/*!40000 ALTER TABLE `vicidial_drop_lists` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_drop_lists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_drop_log`
--

DROP TABLE IF EXISTS `vicidial_drop_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_drop_log` (
  `uniqueid` varchar(50) NOT NULL,
  `server_ip` varchar(15) NOT NULL,
  `drop_date` datetime NOT NULL,
  `lead_id` int(9) unsigned NOT NULL,
  `phone_code` varchar(10) DEFAULT NULL,
  `phone_number` varchar(18) DEFAULT NULL,
  `campaign_id` varchar(20) NOT NULL,
  `status` varchar(6) NOT NULL,
  `drop_processed` enum('N','Y','U') DEFAULT 'N',
  KEY `drop_date` (`drop_date`),
  KEY `drop_processed` (`drop_processed`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_drop_log`
--

LOCK TABLES `vicidial_drop_log` WRITE;
/*!40000 ALTER TABLE `vicidial_drop_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_drop_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_drop_log_archive`
--

DROP TABLE IF EXISTS `vicidial_drop_log_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_drop_log_archive` (
  `uniqueid` varchar(50) NOT NULL,
  `server_ip` varchar(15) NOT NULL,
  `drop_date` datetime NOT NULL,
  `lead_id` int(9) unsigned NOT NULL,
  `phone_code` varchar(10) DEFAULT NULL,
  `phone_number` varchar(18) DEFAULT NULL,
  `campaign_id` varchar(20) NOT NULL,
  `status` varchar(6) NOT NULL,
  `drop_processed` enum('N','Y','U') DEFAULT 'N',
  UNIQUE KEY `vicidial_drop_log_archive_key` (`drop_date`,`uniqueid`),
  KEY `drop_processed` (`drop_processed`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_drop_log_archive`
--

LOCK TABLES `vicidial_drop_log_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_drop_log_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_drop_log_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_drop_rate_groups`
--

DROP TABLE IF EXISTS `vicidial_drop_rate_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_drop_rate_groups` (
  `group_id` varchar(20) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `calls_today` int(9) unsigned DEFAULT '0',
  `answers_today` int(9) unsigned DEFAULT '0',
  `drops_today` double(12,3) DEFAULT '0.000',
  `drops_today_pct` varchar(6) DEFAULT '0',
  `drops_answers_today_pct` varchar(6) DEFAULT '0',
  `answering_machines_today` int(9) unsigned DEFAULT '0',
  `agenthandled_today` int(9) unsigned DEFAULT '0',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_drop_rate_groups`
--

LOCK TABLES `vicidial_drop_rate_groups` WRITE;
/*!40000 ALTER TABLE `vicidial_drop_rate_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_drop_rate_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_dtmf_log`
--

DROP TABLE IF EXISTS `vicidial_dtmf_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_dtmf_log` (
  `dtmf_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dtmf_time` datetime DEFAULT NULL,
  `channel` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `server_ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `uniqueid` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `digit` varchar(1) COLLATE utf8_unicode_ci DEFAULT '',
  `direction` enum('Received','Sent') COLLATE utf8_unicode_ci DEFAULT 'Received',
  `state` enum('BEGIN','END') COLLATE utf8_unicode_ci DEFAULT 'BEGIN',
  PRIMARY KEY (`dtmf_id`),
  KEY `vicidial_dtmf_uniqueid_key` (`uniqueid`)
) ENGINE=MyISAM AUTO_INCREMENT=12267 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_dtmf_log`
--

LOCK TABLES `vicidial_dtmf_log` WRITE;
/*!40000 ALTER TABLE `vicidial_dtmf_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_dtmf_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_email_accounts`
--

DROP TABLE IF EXISTS `vicidial_email_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_email_accounts` (
  `email_account_id` varchar(20) NOT NULL,
  `email_account_name` varchar(100) DEFAULT NULL,
  `email_account_description` varchar(255) DEFAULT NULL,
  `user_group` varchar(20) DEFAULT '---ALL---',
  `protocol` enum('POP3','IMAP','SMTP') DEFAULT 'IMAP',
  `email_replyto_address` varchar(255) DEFAULT NULL,
  `email_account_server` varchar(255) DEFAULT NULL,
  `email_account_user` varchar(255) DEFAULT NULL,
  `email_account_pass` varchar(100) DEFAULT NULL,
  `pop3_auth_mode` enum('BEST','PASS','APOP','CRAM-MD5') DEFAULT 'BEST',
  `active` enum('Y','N') DEFAULT 'N',
  `email_frequency_check_mins` tinyint(3) unsigned DEFAULT '5',
  `group_id` varchar(20) DEFAULT NULL,
  `default_list_id` bigint(14) unsigned DEFAULT NULL,
  `call_handle_method` varchar(20) DEFAULT 'CID',
  `agent_search_method` enum('LO','LB','SO') DEFAULT 'LB',
  `campaign_id` varchar(8) DEFAULT NULL,
  `list_id` bigint(14) unsigned DEFAULT NULL,
  `email_account_type` enum('INBOUND','OUTBOUND') DEFAULT 'INBOUND',
  PRIMARY KEY (`email_account_id`),
  KEY `email_accounts_group_key` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_email_accounts`
--

LOCK TABLES `vicidial_email_accounts` WRITE;
/*!40000 ALTER TABLE `vicidial_email_accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_email_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_email_list`
--

DROP TABLE IF EXISTS `vicidial_email_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_email_list` (
  `email_row_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `email_date` datetime DEFAULT NULL,
  `protocol` enum('POP3','IMAP','NONE') DEFAULT 'IMAP',
  `email_to` varchar(255) DEFAULT NULL,
  `email_from` varchar(255) DEFAULT NULL,
  `email_from_name` varchar(255) DEFAULT NULL,
  `subject` text,
  `mime_type` text,
  `content_type` text,
  `content_transfer_encoding` text,
  `x_mailer` text,
  `sender_ip` varchar(25) DEFAULT NULL,
  `message` text CHARACTER SET utf8,
  `email_account_id` varchar(20) DEFAULT NULL,
  `group_id` varchar(20) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `direction` enum('INBOUND','OUTBOUND') DEFAULT 'INBOUND',
  `uniqueid` varchar(20) DEFAULT NULL,
  `xfercallid` int(9) unsigned DEFAULT NULL,
  PRIMARY KEY (`email_row_id`),
  KEY `email_list_account_key` (`email_account_id`),
  KEY `email_list_user_key` (`user`),
  KEY `vicidial_email_lead_id_key` (`lead_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_email_list`
--

LOCK TABLES `vicidial_email_list` WRITE;
/*!40000 ALTER TABLE `vicidial_email_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_email_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_email_log`
--

DROP TABLE IF EXISTS `vicidial_email_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_email_log` (
  `email_log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email_row_id` int(10) unsigned DEFAULT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `email_date` datetime DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `email_to` varchar(255) DEFAULT NULL,
  `message` text CHARACTER SET utf8,
  `campaign_id` varchar(10) DEFAULT NULL,
  `attachments` text,
  PRIMARY KEY (`email_log_id`),
  KEY `vicidial_email_log_lead_id_key` (`lead_id`),
  KEY `vicidial_email_log_email_row_id_key` (`email_row_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_email_log`
--

LOCK TABLES `vicidial_email_log` WRITE;
/*!40000 ALTER TABLE `vicidial_email_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_email_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_extension_groups`
--

DROP TABLE IF EXISTS `vicidial_extension_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_extension_groups` (
  `extension_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `extension_group_id` varchar(20) NOT NULL,
  `extension` varchar(100) DEFAULT '8300',
  `rank` mediumint(7) DEFAULT '0',
  `campaign_groups` text,
  `call_count_today` mediumint(7) DEFAULT '0',
  `last_call_time` datetime DEFAULT NULL,
  `last_callerid` varchar(20) DEFAULT '',
  PRIMARY KEY (`extension_id`),
  KEY `extension_group_id` (`extension_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_extension_groups`
--

LOCK TABLES `vicidial_extension_groups` WRITE;
/*!40000 ALTER TABLE `vicidial_extension_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_extension_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_filter_phone_groups`
--

DROP TABLE IF EXISTS `vicidial_filter_phone_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_filter_phone_groups` (
  `filter_phone_group_id` varchar(20) NOT NULL,
  `filter_phone_group_name` varchar(40) NOT NULL,
  `filter_phone_group_description` varchar(100) DEFAULT NULL,
  `user_group` varchar(20) DEFAULT '---ALL---',
  KEY `filter_phone_group_id` (`filter_phone_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_filter_phone_groups`
--

LOCK TABLES `vicidial_filter_phone_groups` WRITE;
/*!40000 ALTER TABLE `vicidial_filter_phone_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_filter_phone_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_filter_phone_numbers`
--

DROP TABLE IF EXISTS `vicidial_filter_phone_numbers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_filter_phone_numbers` (
  `phone_number` varchar(18) NOT NULL,
  `filter_phone_group_id` varchar(20) NOT NULL,
  UNIQUE KEY `phonefilter` (`phone_number`,`filter_phone_group_id`),
  KEY `phone_number` (`phone_number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_filter_phone_numbers`
--

LOCK TABLES `vicidial_filter_phone_numbers` WRITE;
/*!40000 ALTER TABLE `vicidial_filter_phone_numbers` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_filter_phone_numbers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_grab_call_log`
--

DROP TABLE IF EXISTS `vicidial_grab_call_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_grab_call_log` (
  `auto_call_id` int(9) unsigned NOT NULL,
  `user` varchar(20) DEFAULT NULL,
  `event_date` datetime DEFAULT NULL,
  `call_time` datetime DEFAULT NULL,
  `campaign_id` varchar(20) DEFAULT NULL,
  `uniqueid` varchar(20) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `queue_priority` tinyint(2) DEFAULT '0',
  `call_type` enum('IN','OUT','OUTBALANCE') DEFAULT 'OUT',
  KEY `auto_call_id` (`auto_call_id`),
  KEY `event_date` (`event_date`),
  KEY `user` (`user`),
  KEY `campaign_id` (`campaign_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_grab_call_log`
--

LOCK TABLES `vicidial_grab_call_log` WRITE;
/*!40000 ALTER TABLE `vicidial_grab_call_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_grab_call_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_hopper`
--

DROP TABLE IF EXISTS `vicidial_hopper`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_hopper` (
  `hopper_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `lead_id` int(9) unsigned NOT NULL,
  `campaign_id` varchar(8) DEFAULT NULL,
  `status` enum('READY','QUEUE','INCALL','DONE','HOLD','DNC') DEFAULT 'READY',
  `user` varchar(20) DEFAULT NULL,
  `list_id` bigint(14) unsigned NOT NULL,
  `gmt_offset_now` decimal(4,2) DEFAULT '0.00',
  `state` varchar(2) DEFAULT '',
  `alt_dial` varchar(6) DEFAULT 'NONE',
  `priority` tinyint(2) DEFAULT '0',
  `source` varchar(1) DEFAULT '',
  `vendor_lead_code` varchar(20) DEFAULT '',
  PRIMARY KEY (`hopper_id`),
  KEY `lead_id` (`lead_id`)
) ENGINE=MEMORY AUTO_INCREMENT=202 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_hopper`
--

LOCK TABLES `vicidial_hopper` WRITE;
/*!40000 ALTER TABLE `vicidial_hopper` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_hopper` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_html_cache_stats`
--

DROP TABLE IF EXISTS `vicidial_html_cache_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_html_cache_stats` (
  `stats_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `stats_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `stats_date` datetime NOT NULL,
  `stats_count` int(9) unsigned DEFAULT '0',
  `stats_html` mediumtext COLLATE utf8_unicode_ci,
  UNIQUE KEY `vicidial_html_cache_stats_key` (`stats_type`,`stats_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_html_cache_stats`
--

LOCK TABLES `vicidial_html_cache_stats` WRITE;
/*!40000 ALTER TABLE `vicidial_html_cache_stats` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_html_cache_stats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_inbound_callback_queue`
--

DROP TABLE IF EXISTS `vicidial_inbound_callback_queue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_inbound_callback_queue` (
  `icbq_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `icbq_date` datetime DEFAULT NULL,
  `icbq_status` varchar(10) DEFAULT NULL,
  `icbq_phone_number` varchar(20) DEFAULT NULL,
  `icbq_phone_code` varchar(10) DEFAULT NULL,
  `icbq_nextday_choice` enum('Y','N','U') DEFAULT 'U',
  `lead_id` int(9) unsigned NOT NULL,
  `group_id` varchar(20) NOT NULL,
  `queue_priority` tinyint(2) DEFAULT '0',
  `call_date` datetime DEFAULT NULL,
  `gmt_offset_now` decimal(4,2) DEFAULT '0.00',
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`icbq_id`),
  KEY `icbq_status` (`icbq_status`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_inbound_callback_queue`
--

LOCK TABLES `vicidial_inbound_callback_queue` WRITE;
/*!40000 ALTER TABLE `vicidial_inbound_callback_queue` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_inbound_callback_queue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_inbound_callback_queue_archive`
--

DROP TABLE IF EXISTS `vicidial_inbound_callback_queue_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_inbound_callback_queue_archive` (
  `icbq_id` int(9) unsigned NOT NULL,
  `icbq_date` datetime DEFAULT NULL,
  `icbq_status` varchar(10) DEFAULT NULL,
  `icbq_phone_number` varchar(20) DEFAULT NULL,
  `icbq_phone_code` varchar(10) DEFAULT NULL,
  `icbq_nextday_choice` enum('Y','N','U') DEFAULT 'U',
  `lead_id` int(9) unsigned NOT NULL,
  `group_id` varchar(20) NOT NULL,
  `queue_priority` tinyint(2) DEFAULT '0',
  `call_date` datetime DEFAULT NULL,
  `gmt_offset_now` decimal(4,2) DEFAULT '0.00',
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`icbq_id`),
  KEY `icbq_status` (`icbq_status`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_inbound_callback_queue_archive`
--

LOCK TABLES `vicidial_inbound_callback_queue_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_inbound_callback_queue_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_inbound_callback_queue_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_inbound_dids`
--

DROP TABLE IF EXISTS `vicidial_inbound_dids`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_inbound_dids` (
  `did_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `did_pattern` varchar(50) NOT NULL,
  `did_description` varchar(50) DEFAULT NULL,
  `did_active` enum('Y','N') DEFAULT 'Y',
  `did_route` enum('EXTEN','VOICEMAIL','AGENT','PHONE','IN_GROUP','CALLMENU','VMAIL_NO_INST') DEFAULT 'EXTEN',
  `extension` varchar(50) DEFAULT '9998811112',
  `exten_context` varchar(50) DEFAULT 'default',
  `voicemail_ext` varchar(10) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `server_ip` varchar(15) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `user_unavailable_action` enum('IN_GROUP','EXTEN','VOICEMAIL','PHONE','VMAIL_NO_INST') DEFAULT 'VOICEMAIL',
  `user_route_settings_ingroup` varchar(20) DEFAULT 'AGENTDIRECT',
  `group_id` varchar(20) DEFAULT NULL,
  `call_handle_method` varchar(20) DEFAULT 'CID',
  `agent_search_method` enum('LO','LB','SO') DEFAULT 'LB',
  `list_id` bigint(14) unsigned DEFAULT '999',
  `campaign_id` varchar(8) DEFAULT NULL,
  `phone_code` varchar(10) DEFAULT '1',
  `menu_id` varchar(50) DEFAULT '',
  `record_call` enum('Y','N','Y_QUEUESTOP') DEFAULT 'N',
  `filter_inbound_number` enum('DISABLED','GROUP','URL','DNC_INTERNAL','DNC_CAMPAIGN','GROUP_AREACODE') DEFAULT 'DISABLED',
  `filter_phone_group_id` varchar(20) DEFAULT '',
  `filter_url` varchar(1000) DEFAULT '',
  `filter_action` enum('EXTEN','VOICEMAIL','AGENT','PHONE','IN_GROUP','CALLMENU','VMAIL_NO_INST') DEFAULT 'EXTEN',
  `filter_extension` varchar(50) DEFAULT '9998811112',
  `filter_exten_context` varchar(50) DEFAULT 'default',
  `filter_voicemail_ext` varchar(10) DEFAULT NULL,
  `filter_phone` varchar(100) DEFAULT NULL,
  `filter_server_ip` varchar(15) DEFAULT NULL,
  `filter_user` varchar(20) DEFAULT NULL,
  `filter_user_unavailable_action` enum('IN_GROUP','EXTEN','VOICEMAIL','PHONE','VMAIL_NO_INST') DEFAULT 'VOICEMAIL',
  `filter_user_route_settings_ingroup` varchar(20) DEFAULT 'AGENTDIRECT',
  `filter_group_id` varchar(20) DEFAULT NULL,
  `filter_call_handle_method` varchar(20) DEFAULT 'CID',
  `filter_agent_search_method` enum('LO','LB','SO') DEFAULT 'LB',
  `filter_list_id` bigint(14) unsigned DEFAULT '999',
  `filter_campaign_id` varchar(8) DEFAULT NULL,
  `filter_phone_code` varchar(10) DEFAULT '1',
  `filter_menu_id` varchar(50) DEFAULT '',
  `filter_clean_cid_number` varchar(20) DEFAULT '',
  `custom_one` varchar(100) DEFAULT '',
  `custom_two` varchar(100) DEFAULT '',
  `custom_three` varchar(100) DEFAULT '',
  `custom_four` varchar(100) DEFAULT '',
  `custom_five` varchar(100) DEFAULT '',
  `user_group` varchar(20) DEFAULT '---ALL---',
  `filter_dnc_campaign` varchar(8) DEFAULT '',
  `filter_url_did_redirect` enum('Y','N') DEFAULT 'N',
  `no_agent_ingroup_redirect` enum('DISABLED','Y','NO_PAUSED','READY_ONLY') DEFAULT 'DISABLED',
  `no_agent_ingroup_id` varchar(20) DEFAULT '',
  `no_agent_ingroup_extension` varchar(50) DEFAULT '9998811112',
  `pre_filter_phone_group_id` varchar(20) DEFAULT '',
  `pre_filter_extension` varchar(50) DEFAULT '',
  `entry_list_id` bigint(14) unsigned DEFAULT '0',
  `filter_entry_list_id` bigint(14) unsigned DEFAULT '0',
  `max_queue_ingroup_calls` smallint(5) DEFAULT '0',
  `max_queue_ingroup_id` varchar(20) DEFAULT '',
  `max_queue_ingroup_extension` varchar(50) DEFAULT '9998811112',
  `did_carrier_description` varchar(255) DEFAULT '',
  PRIMARY KEY (`did_id`),
  UNIQUE KEY `did_pattern` (`did_pattern`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_inbound_dids`
--

LOCK TABLES `vicidial_inbound_dids` WRITE;
/*!40000 ALTER TABLE `vicidial_inbound_dids` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_inbound_dids` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_inbound_group_agents`
--

DROP TABLE IF EXISTS `vicidial_inbound_group_agents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_inbound_group_agents` (
  `user` varchar(20) DEFAULT NULL,
  `group_id` varchar(20) DEFAULT NULL,
  `group_rank` tinyint(1) DEFAULT '0',
  `group_weight` tinyint(1) DEFAULT '0',
  `calls_today` smallint(5) unsigned DEFAULT '0',
  `group_web_vars` varchar(255) DEFAULT '',
  `group_grade` tinyint(2) unsigned DEFAULT '1',
  `group_type` varchar(1) DEFAULT 'C',
  UNIQUE KEY `viga_user_group_id` (`user`,`group_id`),
  KEY `group_id` (`group_id`),
  KEY `user` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_inbound_group_agents`
--

LOCK TABLES `vicidial_inbound_group_agents` WRITE;
/*!40000 ALTER TABLE `vicidial_inbound_group_agents` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_inbound_group_agents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_inbound_groups`
--

DROP TABLE IF EXISTS `vicidial_inbound_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_inbound_groups` (
  `group_id` varchar(20) NOT NULL,
  `group_name` varchar(30) DEFAULT NULL,
  `group_color` varchar(7) DEFAULT NULL,
  `active` enum('Y','N') DEFAULT NULL,
  `web_form_address` text,
  `voicemail_ext` varchar(10) DEFAULT NULL,
  `next_agent_call` varchar(30) DEFAULT 'longest_wait_time',
  `fronter_display` enum('Y','N') DEFAULT 'Y',
  `ingroup_script` varchar(20) DEFAULT NULL,
  `get_call_launch` enum('NONE','SCRIPT','WEBFORM','WEBFORMTWO','WEBFORMTHREE','FORM') DEFAULT 'NONE',
  `xferconf_a_dtmf` varchar(50) DEFAULT NULL,
  `xferconf_a_number` varchar(50) DEFAULT NULL,
  `xferconf_b_dtmf` varchar(50) DEFAULT NULL,
  `xferconf_b_number` varchar(50) DEFAULT NULL,
  `drop_call_seconds` smallint(4) unsigned DEFAULT '360',
  `drop_action` enum('HANGUP','MESSAGE','VOICEMAIL','IN_GROUP','CALLMENU','VMAIL_NO_INST') DEFAULT 'MESSAGE',
  `drop_exten` varchar(20) DEFAULT '8307',
  `call_time_id` varchar(20) DEFAULT '24hours',
  `after_hours_action` enum('HANGUP','MESSAGE','EXTENSION','VOICEMAIL','IN_GROUP','CALLMENU','VMAIL_NO_INST') DEFAULT 'MESSAGE',
  `after_hours_message_filename` varchar(255) DEFAULT 'vm-goodbye',
  `after_hours_exten` varchar(20) DEFAULT '8300',
  `after_hours_voicemail` varchar(20) DEFAULT NULL,
  `welcome_message_filename` varchar(255) DEFAULT '---NONE---',
  `moh_context` varchar(50) DEFAULT 'default',
  `onhold_prompt_filename` varchar(255) DEFAULT 'generic_hold',
  `prompt_interval` smallint(5) unsigned DEFAULT '60',
  `agent_alert_exten` varchar(100) DEFAULT 'ding',
  `agent_alert_delay` int(6) DEFAULT '1000',
  `default_xfer_group` varchar(20) DEFAULT '---NONE---',
  `queue_priority` tinyint(2) DEFAULT '0',
  `drop_inbound_group` varchar(20) DEFAULT '---NONE---',
  `ingroup_recording_override` enum('DISABLED','NEVER','ONDEMAND','ALLCALLS','ALLFORCE') DEFAULT 'DISABLED',
  `ingroup_rec_filename` varchar(50) DEFAULT 'NONE',
  `afterhours_xfer_group` varchar(20) DEFAULT '---NONE---',
  `qc_enabled` enum('Y','N') DEFAULT 'N',
  `qc_statuses` text,
  `qc_shift_id` varchar(20) DEFAULT '24HRMIDNIGHT',
  `qc_get_record_launch` enum('NONE','SCRIPT','WEBFORM','QCSCRIPT','QCWEBFORM') DEFAULT 'NONE',
  `qc_show_recording` enum('Y','N') DEFAULT 'Y',
  `qc_web_form_address` varchar(255) DEFAULT NULL,
  `qc_script` varchar(20) DEFAULT NULL,
  `play_place_in_line` enum('Y','N') DEFAULT 'N',
  `play_estimate_hold_time` enum('Y','N') DEFAULT 'N',
  `hold_time_option` varchar(30) DEFAULT 'NONE',
  `hold_time_option_seconds` smallint(5) DEFAULT '360',
  `hold_time_option_exten` varchar(20) DEFAULT '8300',
  `hold_time_option_voicemail` varchar(20) DEFAULT '',
  `hold_time_option_xfer_group` varchar(20) DEFAULT '---NONE---',
  `hold_time_option_callback_filename` varchar(255) DEFAULT 'vm-hangup',
  `hold_time_option_callback_list_id` bigint(14) unsigned DEFAULT '999',
  `hold_recall_xfer_group` varchar(20) DEFAULT '---NONE---',
  `no_delay_call_route` enum('Y','N') DEFAULT 'N',
  `play_welcome_message` enum('ALWAYS','NEVER','IF_WAIT_ONLY','YES_UNLESS_NODELAY') DEFAULT 'ALWAYS',
  `answer_sec_pct_rt_stat_one` smallint(5) unsigned DEFAULT '20',
  `answer_sec_pct_rt_stat_two` smallint(5) unsigned DEFAULT '30',
  `default_group_alias` varchar(30) DEFAULT '',
  `no_agent_no_queue` enum('N','Y','NO_PAUSED','NO_READY') DEFAULT 'N',
  `no_agent_action` enum('CALLMENU','INGROUP','DID','MESSAGE','EXTENSION','VOICEMAIL','VMAIL_NO_INST') DEFAULT 'MESSAGE',
  `no_agent_action_value` varchar(255) DEFAULT 'nbdy-avail-to-take-call|vm-goodbye',
  `web_form_address_two` text,
  `timer_action` varchar(20) DEFAULT 'NONE',
  `timer_action_message` varchar(255) DEFAULT '',
  `timer_action_seconds` mediumint(7) DEFAULT '-1',
  `start_call_url` text,
  `dispo_call_url` text,
  `xferconf_c_number` varchar(50) DEFAULT '',
  `xferconf_d_number` varchar(50) DEFAULT '',
  `xferconf_e_number` varchar(50) DEFAULT '',
  `ignore_list_script_override` enum('Y','N') DEFAULT 'N',
  `extension_appended_cidname` enum('Y','N','Y_USER','Y_WITH_CAMPAIGN','Y_USER_WITH_CAMPAIGN') DEFAULT 'N',
  `uniqueid_status_display` enum('DISABLED','ENABLED','ENABLED_PREFIX','ENABLED_PRESERVE') DEFAULT 'DISABLED',
  `uniqueid_status_prefix` varchar(50) DEFAULT '',
  `hold_time_option_minimum` smallint(5) DEFAULT '0',
  `hold_time_option_press_filename` varchar(255) DEFAULT 'to-be-called-back|digits/1',
  `hold_time_option_callmenu` varchar(50) DEFAULT '',
  `hold_time_option_no_block` enum('N','Y') DEFAULT 'N',
  `hold_time_option_prompt_seconds` smallint(5) DEFAULT '10',
  `onhold_prompt_no_block` enum('N','Y') DEFAULT 'N',
  `onhold_prompt_seconds` smallint(5) DEFAULT '10',
  `hold_time_second_option` varchar(30) DEFAULT 'NONE',
  `hold_time_third_option` varchar(30) DEFAULT 'NONE',
  `wait_hold_option_priority` enum('WAIT','HOLD','BOTH') DEFAULT 'WAIT',
  `wait_time_option` varchar(30) DEFAULT 'NONE',
  `wait_time_second_option` varchar(30) DEFAULT 'NONE',
  `wait_time_third_option` varchar(30) DEFAULT 'NONE',
  `wait_time_option_seconds` smallint(5) DEFAULT '120',
  `wait_time_option_exten` varchar(20) DEFAULT '8300',
  `wait_time_option_voicemail` varchar(20) DEFAULT '',
  `wait_time_option_xfer_group` varchar(20) DEFAULT '---NONE---',
  `wait_time_option_callmenu` varchar(50) DEFAULT '',
  `wait_time_option_callback_filename` varchar(255) DEFAULT 'vm-hangup',
  `wait_time_option_callback_list_id` bigint(14) unsigned DEFAULT '999',
  `wait_time_option_press_filename` varchar(255) DEFAULT 'to-be-called-back|digits/1',
  `wait_time_option_no_block` enum('N','Y') DEFAULT 'N',
  `wait_time_option_prompt_seconds` smallint(5) DEFAULT '10',
  `timer_action_destination` varchar(30) DEFAULT '',
  `calculate_estimated_hold_seconds` smallint(5) unsigned DEFAULT '0',
  `add_lead_url` text,
  `eht_minimum_prompt_filename` varchar(255) DEFAULT '',
  `eht_minimum_prompt_no_block` enum('N','Y') DEFAULT 'N',
  `eht_minimum_prompt_seconds` smallint(5) DEFAULT '10',
  `on_hook_ring_time` smallint(5) DEFAULT '15',
  `na_call_url` text,
  `on_hook_cid` varchar(30) DEFAULT 'GENERIC',
  `group_calldate` datetime DEFAULT NULL,
  `action_xfer_cid` varchar(18) DEFAULT 'CUSTOMER',
  `drop_callmenu` varchar(50) DEFAULT '',
  `after_hours_callmenu` varchar(50) DEFAULT '',
  `user_group` varchar(20) DEFAULT '---ALL---',
  `max_calls_method` enum('TOTAL','IN_QUEUE','DISABLED') DEFAULT 'DISABLED',
  `max_calls_count` smallint(5) DEFAULT '0',
  `max_calls_action` enum('DROP','AFTERHOURS','NO_AGENT_NO_QUEUE','AREACODE_FILTER') DEFAULT 'NO_AGENT_NO_QUEUE',
  `dial_ingroup_cid` varchar(20) DEFAULT '',
  `group_handling` enum('PHONE','EMAIL','CHAT') DEFAULT 'PHONE',
  `web_form_address_three` text,
  `populate_lead_ingroup` enum('ENABLED','DISABLED') DEFAULT 'ENABLED',
  `drop_lead_reset` enum('Y','N') DEFAULT 'N',
  `after_hours_lead_reset` enum('Y','N') DEFAULT 'N',
  `nanq_lead_reset` enum('Y','N') DEFAULT 'N',
  `wait_time_lead_reset` enum('Y','N') DEFAULT 'N',
  `hold_time_lead_reset` enum('Y','N') DEFAULT 'N',
  `status_group_id` varchar(20) DEFAULT '',
  `routing_initiated_recordings` enum('Y','N') DEFAULT 'N',
  `on_hook_cid_number` varchar(18) DEFAULT '',
  `populate_lead_province` varchar(20) DEFAULT 'DISABLED',
  `areacode_filter` enum('DISABLED','ALLOW_ONLY','DROP_ONLY') DEFAULT 'DISABLED',
  `areacode_filter_seconds` smallint(5) DEFAULT '10',
  `areacode_filter_action` enum('CALLMENU','INGROUP','DID','MESSAGE','EXTENSION','VOICEMAIL','VMAIL_NO_INST') DEFAULT 'MESSAGE',
  `areacode_filter_action_value` varchar(255) DEFAULT 'nbdy-avail-to-take-call|vm-goodbye',
  `populate_state_areacode` enum('DISABLED','NEW_LEAD_ONLY','OVERWRITE_ALWAYS') DEFAULT 'DISABLED',
  `inbound_survey` enum('DISABLED','ENABLED') DEFAULT 'DISABLED',
  `inbound_survey_filename` text,
  `inbound_survey_accept_digit` varchar(1) DEFAULT '',
  `inbound_survey_question_filename` text,
  `inbound_survey_callmenu` text,
  `icbq_expiration_hours` smallint(5) DEFAULT '96',
  `closing_time_action` varchar(30) DEFAULT 'DISABLED',
  `closing_time_now_trigger` enum('Y','N') DEFAULT 'N',
  `closing_time_filename` text,
  `closing_time_end_filename` text,
  `closing_time_lead_reset` enum('Y','N') DEFAULT 'N',
  `closing_time_option_exten` varchar(20) DEFAULT '8300',
  `closing_time_option_callmenu` varchar(50) DEFAULT '',
  `closing_time_option_voicemail` varchar(20) DEFAULT '',
  `closing_time_option_xfer_group` varchar(20) DEFAULT '---NONE---',
  `closing_time_option_callback_list_id` bigint(14) unsigned DEFAULT '999',
  `add_lead_timezone` enum('SERVER','PHONE_CODE_AREACODE') DEFAULT 'SERVER',
  `icbq_call_time_id` varchar(20) DEFAULT '24hours',
  `icbq_dial_filter` varchar(50) DEFAULT 'NONE',
  `customer_chat_screen_colors` varchar(20) DEFAULT 'default',
  `customer_chat_survey_link` text,
  `customer_chat_survey_text` text,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_inbound_groups`
--

LOCK TABLES `vicidial_inbound_groups` WRITE;
/*!40000 ALTER TABLE `vicidial_inbound_groups` DISABLE KEYS */;
INSERT INTO `vicidial_inbound_groups` VALUES ('AGENTDIRECT','Single Agent Direct Queue','white','Y',NULL,NULL,'oldest_call_finish','Y',NULL,'NONE',NULL,NULL,NULL,NULL,360,'MESSAGE','8307','24hours','MESSAGE','vm-goodbye','8300',NULL,'---NONE---','default','generic_hold',60,'8304',1000,'---NONE---',99,'---NONE---','DISABLED','NONE','---NONE---','N',NULL,'24HRMIDNIGHT','NONE','Y',NULL,NULL,'N','N','NONE',360,'8300','','---NONE---','vm-hangup',999,'---NONE---','N','ALWAYS',20,30,'','N','MESSAGE','nbdy-avail-to-take-call|vm-goodbye',NULL,'NONE','',-1,NULL,NULL,'','','','N','N','DISABLED','',0,'to-be-called-back|digits/1','','N',10,'N',10,'NONE','NONE','WAIT','NONE','NONE','NONE',120,'8300','','---NONE---','','vm-hangup',999,'to-be-called-back|digits/1','N',10,'',0,NULL,'','N',10,15,NULL,'GENERIC','2016-05-24 22:07:07','CUSTOMER','','','---ALL---','DISABLED',0,'NO_AGENT_NO_QUEUE','','PHONE',NULL,'ENABLED','N','N','N','N','N','','N','','DISABLED','DISABLED',10,'MESSAGE','nbdy-avail-to-take-call|vm-goodbye','DISABLED','DISABLED',NULL,'',NULL,NULL,96,'DISABLED','N',NULL,NULL,'N','8300','','','---NONE---',999,'SERVER','24hours','NONE','default',NULL,NULL),('AGENTDIRECT_CHAT','Agent Direct Queue for Chats','#FFFFFF','Y','','','longest_wait_time','Y','','',NULL,NULL,NULL,NULL,360,'MESSAGE','8307','24hours','MESSAGE','vm-goodbye','8300',NULL,'---NONE---','default','generic_hold',60,'ding',1000,'---NONE---',99,'---NONE---','DISABLED','NONE','---NONE---','N',NULL,'24HRMIDNIGHT','NONE','Y',NULL,NULL,'N','N','NONE',360,'8300','','---NONE---','vm-hangup',0,'---NONE---','N','ALWAYS',20,30,'','N','MESSAGE','nbdy-avail-to-take-call|vm-goodbye','','NONE','',-1,'','','','','','N','N','DISABLED','',0,'to-be-called-back|digits/1','','N',10,'N',10,'NONE','NONE','WAIT','NONE','NONE','NONE',120,'8300','','---NONE---','','vm-hangup',999,'to-be-called-back|digits/1','N',10,'',0,'','','N',10,15,'','GENERIC',NULL,'CUSTOMER','','','---ALL---','DISABLED',0,'DROP','','CHAT','','ENABLED','N','N','N','N','N','','N','','DISABLED','DISABLED',10,'MESSAGE','nbdy-avail-to-take-call|vm-goodbye','DISABLED','DISABLED',NULL,'',NULL,NULL,96,'DISABLED','N',NULL,NULL,'N','8300','','','---NONE---',999,'SERVER','24hours','NONE','default',NULL,NULL);
/*!40000 ALTER TABLE `vicidial_inbound_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_inbound_survey_log`
--

DROP TABLE IF EXISTS `vicidial_inbound_survey_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_inbound_survey_log` (
  `uniqueid` varchar(50) NOT NULL,
  `lead_id` int(9) unsigned NOT NULL,
  `campaign_id` varchar(20) NOT NULL,
  `call_date` datetime DEFAULT NULL,
  `participate` enum('N','Y') DEFAULT 'N',
  `played` enum('N','R','Y') DEFAULT 'N',
  `dtmf_response` varchar(1) DEFAULT '',
  `next_call_menu` text,
  KEY `call_date` (`call_date`),
  KEY `lead_id` (`lead_id`),
  KEY `uniqueid` (`uniqueid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_inbound_survey_log`
--

LOCK TABLES `vicidial_inbound_survey_log` WRITE;
/*!40000 ALTER TABLE `vicidial_inbound_survey_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_inbound_survey_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_inbound_survey_log_archive`
--

DROP TABLE IF EXISTS `vicidial_inbound_survey_log_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_inbound_survey_log_archive` (
  `uniqueid` varchar(50) NOT NULL,
  `lead_id` int(9) unsigned NOT NULL,
  `campaign_id` varchar(20) NOT NULL,
  `call_date` datetime DEFAULT NULL,
  `participate` enum('N','Y') DEFAULT 'N',
  `played` enum('N','R','Y') DEFAULT 'N',
  `dtmf_response` varchar(1) DEFAULT '',
  `next_call_menu` text,
  UNIQUE KEY `visla_key` (`uniqueid`,`call_date`,`campaign_id`,`lead_id`),
  KEY `call_date` (`call_date`),
  KEY `lead_id` (`lead_id`),
  KEY `uniqueid` (`uniqueid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_inbound_survey_log_archive`
--

LOCK TABLES `vicidial_inbound_survey_log_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_inbound_survey_log_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_inbound_survey_log_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_ingroup_hour_counts`
--

DROP TABLE IF EXISTS `vicidial_ingroup_hour_counts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_ingroup_hour_counts` (
  `group_id` varchar(20) DEFAULT NULL,
  `date_hour` datetime DEFAULT NULL,
  `next_hour` datetime DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  `type` varchar(22) DEFAULT 'CALLS',
  `calls` int(9) unsigned DEFAULT '0',
  `hr` tinyint(2) DEFAULT '0',
  UNIQUE KEY `vihc_ingr_hour` (`group_id`,`date_hour`,`type`),
  KEY `group_id` (`group_id`),
  KEY `date_hour` (`date_hour`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_ingroup_hour_counts`
--

LOCK TABLES `vicidial_ingroup_hour_counts` WRITE;
/*!40000 ALTER TABLE `vicidial_ingroup_hour_counts` DISABLE KEYS */;
INSERT INTO `vicidial_ingroup_hour_counts` VALUES ('AGENTDIRECT','2018-09-24 05:00:00','2018-09-24 06:00:00','2018-09-24 06:00:10','CALLS',0,5),('AGENTDIRECT','2018-09-24 00:00:00','2018-09-24 01:00:00','2018-09-24 05:15:53','CALLS',0,0),('AGENTDIRECT','2018-09-24 01:00:00','2018-09-24 02:00:00','2018-09-24 05:15:53','CALLS',0,1),('AGENTDIRECT','2018-09-24 02:00:00','2018-09-24 03:00:00','2018-09-24 05:15:53','CALLS',0,2),('AGENTDIRECT','2018-09-24 03:00:00','2018-09-24 04:00:00','2018-09-24 05:15:53','CALLS',0,3),('AGENTDIRECT','2018-09-24 04:00:00','2018-09-24 05:00:00','2018-09-24 05:15:53','CALLS',0,4),('AGENTDIRECT_CHAT','2018-09-24 05:00:00','2018-09-24 06:00:00','2018-09-24 06:00:10','CALLS',0,5),('AGENTDIRECT_CHAT','2018-09-24 00:00:00','2018-09-24 01:00:00','2018-09-24 05:15:53','CALLS',0,0),('AGENTDIRECT_CHAT','2018-09-24 01:00:00','2018-09-24 02:00:00','2018-09-24 05:15:53','CALLS',0,1),('AGENTDIRECT_CHAT','2018-09-24 02:00:00','2018-09-24 03:00:00','2018-09-24 05:15:53','CALLS',0,2),('AGENTDIRECT_CHAT','2018-09-24 03:00:00','2018-09-24 04:00:00','2018-09-24 05:15:53','CALLS',0,3),('AGENTDIRECT_CHAT','2018-09-24 04:00:00','2018-09-24 05:00:00','2018-09-24 05:15:53','CALLS',0,4),('SalesAndBilling','2018-09-24 05:00:00','2018-09-24 06:00:00','2018-09-24 06:00:10','CALLS',0,5),('SalesAndBilling','2018-09-24 00:00:00','2018-09-24 01:00:00','2018-09-24 05:15:53','CALLS',0,0),('SalesAndBilling','2018-09-24 01:00:00','2018-09-24 02:00:00','2018-09-24 05:15:53','CALLS',0,1),('SalesAndBilling','2018-09-24 02:00:00','2018-09-24 03:00:00','2018-09-24 05:15:53','CALLS',0,2),('SalesAndBilling','2018-09-24 03:00:00','2018-09-24 04:00:00','2018-09-24 05:15:53','CALLS',0,3),('SalesAndBilling','2018-09-24 04:00:00','2018-09-24 05:00:00','2018-09-24 05:15:53','CALLS',0,4),('TechSupport','2018-09-24 05:00:00','2018-09-24 06:00:00','2018-09-24 06:00:10','CALLS',0,5),('TechSupport','2018-09-24 00:00:00','2018-09-24 01:00:00','2018-09-24 05:15:53','CALLS',0,0),('TechSupport','2018-09-24 01:00:00','2018-09-24 02:00:00','2018-09-24 05:15:53','CALLS',0,1),('TechSupport','2018-09-24 02:00:00','2018-09-24 03:00:00','2018-09-24 05:15:53','CALLS',0,2),('TechSupport','2018-09-24 03:00:00','2018-09-24 04:00:00','2018-09-24 05:15:53','CALLS',0,3),('TechSupport','2018-09-24 04:00:00','2018-09-24 05:00:00','2018-09-24 05:15:53','CALLS',0,4),('Closer','2018-09-24 05:00:00','2018-09-24 06:00:00','2018-09-24 06:00:10','CALLS',0,5),('Closer','2018-09-24 00:00:00','2018-09-24 01:00:00','2018-09-24 05:15:53','CALLS',0,0),('Closer','2018-09-24 01:00:00','2018-09-24 02:00:00','2018-09-24 05:15:53','CALLS',0,1),('Closer','2018-09-24 02:00:00','2018-09-24 03:00:00','2018-09-24 05:15:53','CALLS',0,2),('Closer','2018-09-24 03:00:00','2018-09-24 04:00:00','2018-09-24 05:15:53','CALLS',0,3),('Closer','2018-09-24 04:00:00','2018-09-24 05:00:00','2018-09-24 05:15:53','CALLS',0,4),('ING12345678901','2018-09-24 05:00:00','2018-09-24 06:00:00','2018-09-24 06:00:10','CALLS',0,5),('ING12345678901','2018-09-24 00:00:00','2018-09-24 01:00:00','2018-09-24 05:15:53','CALLS',0,0),('ING12345678901','2018-09-24 01:00:00','2018-09-24 02:00:00','2018-09-24 05:15:53','CALLS',0,1),('ING12345678901','2018-09-24 02:00:00','2018-09-24 03:00:00','2018-09-24 05:15:53','CALLS',0,2),('ING12345678901','2018-09-24 03:00:00','2018-09-24 04:00:00','2018-09-24 05:15:53','CALLS',0,3),('ING12345678901','2018-09-24 04:00:00','2018-09-24 05:00:00','2018-09-24 05:15:53','CALLS',0,4),('INGTest','2018-09-24 05:00:00','2018-09-24 06:00:00','2018-09-24 06:00:10','CALLS',0,5),('INGTest','2018-09-24 00:00:00','2018-09-24 01:00:00','2018-09-24 05:15:53','CALLS',0,0),('INGTest','2018-09-24 01:00:00','2018-09-24 02:00:00','2018-09-24 05:15:53','CALLS',0,1),('INGTest','2018-09-24 02:00:00','2018-09-24 03:00:00','2018-09-24 05:15:53','CALLS',0,2),('INGTest','2018-09-24 03:00:00','2018-09-24 04:00:00','2018-09-24 05:15:53','CALLS',0,3),('INGTest','2018-09-24 04:00:00','2018-09-24 05:00:00','2018-09-24 05:15:53','CALLS',0,4),('ING8552861592','2018-09-24 05:00:00','2018-09-24 06:00:00','2018-09-24 06:00:10','CALLS',0,5),('ING8552861592','2018-09-24 00:00:00','2018-09-24 01:00:00','2018-09-24 05:15:53','CALLS',0,0),('ING8552861592','2018-09-24 01:00:00','2018-09-24 02:00:00','2018-09-24 05:15:53','CALLS',0,1),('ING8552861592','2018-09-24 02:00:00','2018-09-24 03:00:00','2018-09-24 05:15:53','CALLS',0,2),('ING8552861592','2018-09-24 03:00:00','2018-09-24 04:00:00','2018-09-24 05:15:53','CALLS',0,3),('ING8552861592','2018-09-24 04:00:00','2018-09-24 05:00:00','2018-09-24 05:15:53','CALLS',0,4),('ING123456789','2018-09-24 05:00:00','2018-09-24 06:00:00','2018-09-24 06:00:10','CALLS',0,5),('ING123456789','2018-09-24 00:00:00','2018-09-24 01:00:00','2018-09-24 05:15:53','CALLS',0,0),('ING123456789','2018-09-24 01:00:00','2018-09-24 02:00:00','2018-09-24 05:15:53','CALLS',0,1),('ING123456789','2018-09-24 02:00:00','2018-09-24 03:00:00','2018-09-24 05:15:53','CALLS',0,2),('ING123456789','2018-09-24 03:00:00','2018-09-24 04:00:00','2018-09-24 05:15:53','CALLS',0,3),('ING123456789','2018-09-24 04:00:00','2018-09-24 05:00:00','2018-09-24 05:15:53','CALLS',0,4),('ING123','2018-09-24 05:00:00','2018-09-24 06:00:00','2018-09-24 06:00:10','CALLS',0,5),('ING123','2018-09-24 00:00:00','2018-09-24 01:00:00','2018-09-24 05:15:53','CALLS',0,0),('ING123','2018-09-24 01:00:00','2018-09-24 02:00:00','2018-09-24 05:15:53','CALLS',0,1),('ING123','2018-09-24 02:00:00','2018-09-24 03:00:00','2018-09-24 05:15:53','CALLS',0,2),('ING123','2018-09-24 03:00:00','2018-09-24 04:00:00','2018-09-24 05:15:53','CALLS',0,3),('ING123','2018-09-24 04:00:00','2018-09-24 05:00:00','2018-09-24 05:15:53','CALLS',0,4),('ING987654321','2018-09-24 05:00:00','2018-09-24 06:00:00','2018-09-24 06:00:10','CALLS',0,5),('ING987654321','2018-09-24 00:00:00','2018-09-24 01:00:00','2018-09-24 05:15:53','CALLS',0,0),('ING987654321','2018-09-24 01:00:00','2018-09-24 02:00:00','2018-09-24 05:15:53','CALLS',0,1),('ING987654321','2018-09-24 02:00:00','2018-09-24 03:00:00','2018-09-24 05:15:53','CALLS',0,2),('ING987654321','2018-09-24 03:00:00','2018-09-24 04:00:00','2018-09-24 05:15:53','CALLS',0,3),('ING987654321','2018-09-24 04:00:00','2018-09-24 05:00:00','2018-09-24 05:15:53','CALLS',0,4),('ING1920192019','2018-09-24 05:00:00','2018-09-24 06:00:00','2018-09-24 06:00:10','CALLS',0,5),('ING1920192019','2018-09-24 00:00:00','2018-09-24 01:00:00','2018-09-24 05:15:53','CALLS',0,0),('ING1920192019','2018-09-24 01:00:00','2018-09-24 02:00:00','2018-09-24 05:15:53','CALLS',0,1),('ING1920192019','2018-09-24 02:00:00','2018-09-24 03:00:00','2018-09-24 05:15:53','CALLS',0,2),('ING1920192019','2018-09-24 03:00:00','2018-09-24 04:00:00','2018-09-24 05:15:53','CALLS',0,3),('ING1920192019','2018-09-24 04:00:00','2018-09-24 05:00:00','2018-09-24 05:15:53','CALLS',0,4),('TESTBUG6818','2018-09-24 05:00:00','2018-09-24 06:00:00','2018-09-24 06:00:10','CALLS',0,5),('TESTBUG6818','2018-09-24 00:00:00','2018-09-24 01:00:00','2018-09-24 05:15:53','CALLS',0,0),('TESTBUG6818','2018-09-24 01:00:00','2018-09-24 02:00:00','2018-09-24 05:15:53','CALLS',0,1),('TESTBUG6818','2018-09-24 02:00:00','2018-09-24 03:00:00','2018-09-24 05:15:53','CALLS',0,2),('TESTBUG6818','2018-09-24 03:00:00','2018-09-24 04:00:00','2018-09-24 05:15:53','CALLS',0,3),('TESTBUG6818','2018-09-24 04:00:00','2018-09-24 05:00:00','2018-09-24 05:15:53','CALLS',0,4),('ING3233808432','2018-09-24 05:00:00','2018-09-24 06:00:00','2018-09-24 06:00:10','CALLS',0,5),('ING3233808432','2018-09-24 00:00:00','2018-09-24 01:00:00','2018-09-24 05:15:53','CALLS',0,0),('ING3233808432','2018-09-24 01:00:00','2018-09-24 02:00:00','2018-09-24 05:15:53','CALLS',0,1),('ING3233808432','2018-09-24 02:00:00','2018-09-24 03:00:00','2018-09-24 05:15:53','CALLS',0,2),('ING3233808432','2018-09-24 03:00:00','2018-09-24 04:00:00','2018-09-24 05:15:53','CALLS',0,3),('ING3233808432','2018-09-24 04:00:00','2018-09-24 05:00:00','2018-09-24 05:15:53','CALLS',0,4),('ING4844147','2018-09-24 05:00:00','2018-09-24 06:00:00','2018-09-24 06:00:10','CALLS',0,5),('ING4844147','2018-09-24 00:00:00','2018-09-24 01:00:00','2018-09-24 05:15:53','CALLS',0,0),('ING4844147','2018-09-24 01:00:00','2018-09-24 02:00:00','2018-09-24 05:15:53','CALLS',0,1),('ING4844147','2018-09-24 02:00:00','2018-09-24 03:00:00','2018-09-24 05:15:53','CALLS',0,2),('ING4844147','2018-09-24 03:00:00','2018-09-24 04:00:00','2018-09-24 05:15:53','CALLS',0,3),('ING4844147','2018-09-24 04:00:00','2018-09-24 05:00:00','2018-09-24 05:15:53','CALLS',0,4),('AGENTDIRECT','2018-09-24 06:00:00','2018-09-24 07:00:00','2018-09-24 07:00:19','CALLS',0,6),('AGENTDIRECT_CHAT','2018-09-24 06:00:00','2018-09-24 07:00:00','2018-09-24 07:00:19','CALLS',0,6),('SalesAndBilling','2018-09-24 06:00:00','2018-09-24 07:00:00','2018-09-24 07:00:19','CALLS',0,6),('TechSupport','2018-09-24 06:00:00','2018-09-24 07:00:00','2018-09-24 07:00:19','CALLS',0,6),('Closer','2018-09-24 06:00:00','2018-09-24 07:00:00','2018-09-24 07:00:19','CALLS',0,6),('ING12345678901','2018-09-24 06:00:00','2018-09-24 07:00:00','2018-09-24 07:00:19','CALLS',0,6),('INGTest','2018-09-24 06:00:00','2018-09-24 07:00:00','2018-09-24 07:00:19','CALLS',0,6),('ING8552861592','2018-09-24 06:00:00','2018-09-24 07:00:00','2018-09-24 07:00:19','CALLS',0,6),('ING123456789','2018-09-24 06:00:00','2018-09-24 07:00:00','2018-09-24 07:00:19','CALLS',0,6),('ING123','2018-09-24 06:00:00','2018-09-24 07:00:00','2018-09-24 07:00:19','CALLS',0,6),('ING987654321','2018-09-24 06:00:00','2018-09-24 07:00:00','2018-09-24 07:00:19','CALLS',0,6),('ING1920192019','2018-09-24 06:00:00','2018-09-24 07:00:00','2018-09-24 07:00:19','CALLS',0,6),('TESTBUG6818','2018-09-24 06:00:00','2018-09-24 07:00:00','2018-09-24 07:00:19','CALLS',0,6),('ING3233808432','2018-09-24 06:00:00','2018-09-24 07:00:00','2018-09-24 07:00:19','CALLS',0,6),('ING4844147','2018-09-24 06:00:00','2018-09-24 07:00:00','2018-09-24 07:00:19','CALLS',0,6),('AGENTDIRECT','2018-09-24 07:00:00','2018-09-24 08:00:00','2018-09-24 08:00:28','CALLS',0,7),('AGENTDIRECT_CHAT','2018-09-24 07:00:00','2018-09-24 08:00:00','2018-09-24 08:00:28','CALLS',0,7),('SalesAndBilling','2018-09-24 07:00:00','2018-09-24 08:00:00','2018-09-24 08:00:28','CALLS',0,7),('TechSupport','2018-09-24 07:00:00','2018-09-24 08:00:00','2018-09-24 08:00:28','CALLS',0,7),('Closer','2018-09-24 07:00:00','2018-09-24 08:00:00','2018-09-24 08:00:28','CALLS',0,7),('ING12345678901','2018-09-24 07:00:00','2018-09-24 08:00:00','2018-09-24 08:00:28','CALLS',0,7),('INGTest','2018-09-24 07:00:00','2018-09-24 08:00:00','2018-09-24 08:00:28','CALLS',0,7),('ING8552861592','2018-09-24 07:00:00','2018-09-24 08:00:00','2018-09-24 08:00:28','CALLS',0,7),('ING123456789','2018-09-24 07:00:00','2018-09-24 08:00:00','2018-09-24 08:00:28','CALLS',0,7),('ING123','2018-09-24 07:00:00','2018-09-24 08:00:00','2018-09-24 08:00:28','CALLS',0,7),('ING987654321','2018-09-24 07:00:00','2018-09-24 08:00:00','2018-09-24 08:00:28','CALLS',0,7),('ING1920192019','2018-09-24 07:00:00','2018-09-24 08:00:00','2018-09-24 08:00:28','CALLS',0,7),('TESTBUG6818','2018-09-24 07:00:00','2018-09-24 08:00:00','2018-09-24 08:00:28','CALLS',0,7),('ING3233808432','2018-09-24 07:00:00','2018-09-24 08:00:00','2018-09-24 08:00:28','CALLS',0,7),('ING4844147','2018-09-24 07:00:00','2018-09-24 08:00:00','2018-09-24 08:00:28','CALLS',0,7),('AGENTDIRECT','2018-09-24 08:00:00','2018-09-24 09:00:00','2018-09-24 09:00:37','CALLS',0,8),('AGENTDIRECT_CHAT','2018-09-24 08:00:00','2018-09-24 09:00:00','2018-09-24 09:00:37','CALLS',0,8),('SalesAndBilling','2018-09-24 08:00:00','2018-09-24 09:00:00','2018-09-24 09:00:37','CALLS',0,8),('TechSupport','2018-09-24 08:00:00','2018-09-24 09:00:00','2018-09-24 09:00:37','CALLS',0,8),('Closer','2018-09-24 08:00:00','2018-09-24 09:00:00','2018-09-24 09:00:37','CALLS',0,8),('ING12345678901','2018-09-24 08:00:00','2018-09-24 09:00:00','2018-09-24 09:00:37','CALLS',0,8),('INGTest','2018-09-24 08:00:00','2018-09-24 09:00:00','2018-09-24 09:00:37','CALLS',0,8),('ING8552861592','2018-09-24 08:00:00','2018-09-24 09:00:00','2018-09-24 09:00:37','CALLS',0,8),('ING123456789','2018-09-24 08:00:00','2018-09-24 09:00:00','2018-09-24 09:00:37','CALLS',0,8),('ING123','2018-09-24 08:00:00','2018-09-24 09:00:00','2018-09-24 09:00:37','CALLS',0,8),('ING987654321','2018-09-24 08:00:00','2018-09-24 09:00:00','2018-09-24 09:00:37','CALLS',0,8),('ING1920192019','2018-09-24 08:00:00','2018-09-24 09:00:00','2018-09-24 09:00:37','CALLS',0,8),('TESTBUG6818','2018-09-24 08:00:00','2018-09-24 09:00:00','2018-09-24 09:00:37','CALLS',0,8),('ING3233808432','2018-09-24 08:00:00','2018-09-24 09:00:00','2018-09-24 09:00:37','CALLS',0,8),('ING4844147','2018-09-24 08:00:00','2018-09-24 09:00:00','2018-09-24 09:00:37','CALLS',0,8),('AGENTDIRECT','2018-09-24 09:00:00','2018-09-24 10:00:00','2018-09-24 10:00:46','CALLS',0,9),('AGENTDIRECT_CHAT','2018-09-24 09:00:00','2018-09-24 10:00:00','2018-09-24 10:00:46','CALLS',0,9),('SalesAndBilling','2018-09-24 09:00:00','2018-09-24 10:00:00','2018-09-24 10:00:46','CALLS',0,9),('TechSupport','2018-09-24 09:00:00','2018-09-24 10:00:00','2018-09-24 10:00:46','CALLS',0,9),('Closer','2018-09-24 09:00:00','2018-09-24 10:00:00','2018-09-24 10:00:46','CALLS',0,9),('ING12345678901','2018-09-24 09:00:00','2018-09-24 10:00:00','2018-09-24 10:00:46','CALLS',0,9),('INGTest','2018-09-24 09:00:00','2018-09-24 10:00:00','2018-09-24 10:00:46','CALLS',0,9),('ING8552861592','2018-09-24 09:00:00','2018-09-24 10:00:00','2018-09-24 10:00:46','CALLS',0,9),('ING123456789','2018-09-24 09:00:00','2018-09-24 10:00:00','2018-09-24 10:00:46','CALLS',0,9),('ING123','2018-09-24 09:00:00','2018-09-24 10:00:00','2018-09-24 10:00:46','CALLS',0,9),('ING987654321','2018-09-24 09:00:00','2018-09-24 10:00:00','2018-09-24 10:00:46','CALLS',0,9),('ING1920192019','2018-09-24 09:00:00','2018-09-24 10:00:00','2018-09-24 10:00:46','CALLS',0,9),('TESTBUG6818','2018-09-24 09:00:00','2018-09-24 10:00:00','2018-09-24 10:00:46','CALLS',0,9),('ING3233808432','2018-09-24 09:00:00','2018-09-24 10:00:00','2018-09-24 10:00:46','CALLS',0,9),('ING4844147','2018-09-24 09:00:00','2018-09-24 10:00:00','2018-09-24 10:00:46','CALLS',0,9),('AGENTDIRECT','2018-09-24 10:00:00','2018-09-24 11:00:00','2018-09-24 11:00:05','CALLS',0,10),('AGENTDIRECT_CHAT','2018-09-24 10:00:00','2018-09-24 11:00:00','2018-09-24 11:00:05','CALLS',0,10),('SalesAndBilling','2018-09-24 10:00:00','2018-09-24 11:00:00','2018-09-24 11:00:05','CALLS',0,10),('TechSupport','2018-09-24 10:00:00','2018-09-24 11:00:00','2018-09-24 11:00:05','CALLS',0,10),('Closer','2018-09-24 10:00:00','2018-09-24 11:00:00','2018-09-24 11:00:05','CALLS',0,10),('ING12345678901','2018-09-24 10:00:00','2018-09-24 11:00:00','2018-09-24 11:00:05','CALLS',0,10),('INGTest','2018-09-24 10:00:00','2018-09-24 11:00:00','2018-09-24 11:00:05','CALLS',0,10),('ING8552861592','2018-09-24 10:00:00','2018-09-24 11:00:00','2018-09-24 11:00:05','CALLS',0,10),('ING123456789','2018-09-24 10:00:00','2018-09-24 11:00:00','2018-09-24 11:00:05','CALLS',0,10),('ING123','2018-09-24 10:00:00','2018-09-24 11:00:00','2018-09-24 11:00:05','CALLS',0,10),('ING987654321','2018-09-24 10:00:00','2018-09-24 11:00:00','2018-09-24 11:00:05','CALLS',0,10),('ING1920192019','2018-09-24 10:00:00','2018-09-24 11:00:00','2018-09-24 11:00:05','CALLS',0,10),('TESTBUG6818','2018-09-24 10:00:00','2018-09-24 11:00:00','2018-09-24 11:00:05','CALLS',0,10),('ING3233808432','2018-09-24 10:00:00','2018-09-24 11:00:00','2018-09-24 11:00:05','CALLS',0,10),('ING4844147','2018-09-24 10:00:00','2018-09-24 11:00:00','2018-09-24 11:00:05','CALLS',0,10),('AGENTDIRECT','2018-09-24 11:00:00','2018-09-24 12:00:00','2018-09-24 12:00:14','CALLS',0,11),('AGENTDIRECT_CHAT','2018-09-24 11:00:00','2018-09-24 12:00:00','2018-09-24 12:00:14','CALLS',0,11),('SalesAndBilling','2018-09-24 11:00:00','2018-09-24 12:00:00','2018-09-24 12:00:14','CALLS',0,11),('TechSupport','2018-09-24 11:00:00','2018-09-24 12:00:00','2018-09-24 12:00:14','CALLS',0,11),('Closer','2018-09-24 11:00:00','2018-09-24 12:00:00','2018-09-24 12:00:14','CALLS',0,11),('ING12345678901','2018-09-24 11:00:00','2018-09-24 12:00:00','2018-09-24 12:00:14','CALLS',0,11),('INGTest','2018-09-24 11:00:00','2018-09-24 12:00:00','2018-09-24 12:00:14','CALLS',0,11),('ING8552861592','2018-09-24 11:00:00','2018-09-24 12:00:00','2018-09-24 12:00:14','CALLS',0,11),('ING123456789','2018-09-24 11:00:00','2018-09-24 12:00:00','2018-09-24 12:00:14','CALLS',0,11),('ING123','2018-09-24 11:00:00','2018-09-24 12:00:00','2018-09-24 12:00:14','CALLS',0,11),('ING987654321','2018-09-24 11:00:00','2018-09-24 12:00:00','2018-09-24 12:00:14','CALLS',0,11),('ING1920192019','2018-09-24 11:00:00','2018-09-24 12:00:00','2018-09-24 12:00:14','CALLS',0,11),('TESTBUG6818','2018-09-24 11:00:00','2018-09-24 12:00:00','2018-09-24 12:00:14','CALLS',0,11),('ING3233808432','2018-09-24 11:00:00','2018-09-24 12:00:00','2018-09-24 12:00:14','CALLS',0,11),('ING4844147','2018-09-24 11:00:00','2018-09-24 12:00:00','2018-09-24 12:00:14','CALLS',0,11),('AGENTDIRECT','2018-09-24 12:00:00','2018-09-24 13:00:00','2018-09-24 13:00:23','CALLS',0,12),('AGENTDIRECT_CHAT','2018-09-24 12:00:00','2018-09-24 13:00:00','2018-09-24 13:00:23','CALLS',0,12),('SalesAndBilling','2018-09-24 12:00:00','2018-09-24 13:00:00','2018-09-24 13:00:23','CALLS',0,12),('TechSupport','2018-09-24 12:00:00','2018-09-24 13:00:00','2018-09-24 13:00:23','CALLS',0,12),('Closer','2018-09-24 12:00:00','2018-09-24 13:00:00','2018-09-24 13:00:23','CALLS',0,12),('ING12345678901','2018-09-24 12:00:00','2018-09-24 13:00:00','2018-09-24 13:00:23','CALLS',0,12),('INGTest','2018-09-24 12:00:00','2018-09-24 13:00:00','2018-09-24 13:00:23','CALLS',0,12),('ING8552861592','2018-09-24 12:00:00','2018-09-24 13:00:00','2018-09-24 13:00:23','CALLS',0,12),('ING123456789','2018-09-24 12:00:00','2018-09-24 13:00:00','2018-09-24 13:00:23','CALLS',0,12),('ING123','2018-09-24 12:00:00','2018-09-24 13:00:00','2018-09-24 13:00:23','CALLS',0,12),('ING987654321','2018-09-24 12:00:00','2018-09-24 13:00:00','2018-09-24 13:00:23','CALLS',0,12),('ING1920192019','2018-09-24 12:00:00','2018-09-24 13:00:00','2018-09-24 13:00:23','CALLS',0,12),('TESTBUG6818','2018-09-24 12:00:00','2018-09-24 13:00:00','2018-09-24 13:00:23','CALLS',0,12),('ING3233808432','2018-09-24 12:00:00','2018-09-24 13:00:00','2018-09-24 13:00:23','CALLS',0,12),('ING4844147','2018-09-24 12:00:00','2018-09-24 13:00:00','2018-09-24 13:00:23','CALLS',0,12),('AGENTDIRECT','2018-09-24 13:00:00','2018-09-24 14:00:00','2018-09-24 14:00:32','CALLS',0,13),('AGENTDIRECT_CHAT','2018-09-24 13:00:00','2018-09-24 14:00:00','2018-09-24 14:00:32','CALLS',0,13),('SalesAndBilling','2018-09-24 13:00:00','2018-09-24 14:00:00','2018-09-24 14:00:32','CALLS',0,13),('TechSupport','2018-09-24 13:00:00','2018-09-24 14:00:00','2018-09-24 14:00:32','CALLS',0,13),('Closer','2018-09-24 13:00:00','2018-09-24 14:00:00','2018-09-24 14:00:32','CALLS',0,13),('ING12345678901','2018-09-24 13:00:00','2018-09-24 14:00:00','2018-09-24 14:00:32','CALLS',0,13),('INGTest','2018-09-24 13:00:00','2018-09-24 14:00:00','2018-09-24 14:00:32','CALLS',0,13),('ING8552861592','2018-09-24 13:00:00','2018-09-24 14:00:00','2018-09-24 14:00:32','CALLS',0,13),('ING123456789','2018-09-24 13:00:00','2018-09-24 14:00:00','2018-09-24 14:00:32','CALLS',0,13),('ING123','2018-09-24 13:00:00','2018-09-24 14:00:00','2018-09-24 14:00:32','CALLS',0,13),('ING987654321','2018-09-24 13:00:00','2018-09-24 14:00:00','2018-09-24 14:00:32','CALLS',0,13),('ING1920192019','2018-09-24 13:00:00','2018-09-24 14:00:00','2018-09-24 14:00:32','CALLS',0,13),('TESTBUG6818','2018-09-24 13:00:00','2018-09-24 14:00:00','2018-09-24 14:00:32','CALLS',0,13),('ING3233808432','2018-09-24 13:00:00','2018-09-24 14:00:00','2018-09-24 14:00:32','CALLS',0,13),('ING4844147','2018-09-24 13:00:00','2018-09-24 14:00:00','2018-09-24 14:00:32','CALLS',0,13),('AGENTDIRECT','2018-09-24 14:00:00','2018-09-24 15:00:00','2018-09-24 14:54:00','CALLS',0,14),('AGENTDIRECT_CHAT','2018-09-24 14:00:00','2018-09-24 15:00:00','2018-09-24 14:54:00','CALLS',0,14),('SalesAndBilling','2018-09-24 14:00:00','2018-09-24 15:00:00','2018-09-24 14:54:00','CALLS',0,14),('TechSupport','2018-09-24 14:00:00','2018-09-24 15:00:00','2018-09-24 14:54:00','CALLS',0,14),('Closer','2018-09-24 14:00:00','2018-09-24 15:00:00','2018-09-24 14:54:00','CALLS',0,14),('ING12345678901','2018-09-24 14:00:00','2018-09-24 15:00:00','2018-09-24 14:54:00','CALLS',0,14),('INGTest','2018-09-24 14:00:00','2018-09-24 15:00:00','2018-09-24 14:54:00','CALLS',0,14),('ING8552861592','2018-09-24 14:00:00','2018-09-24 15:00:00','2018-09-24 14:54:00','CALLS',0,14),('ING123456789','2018-09-24 14:00:00','2018-09-24 15:00:00','2018-09-24 14:54:00','CALLS',0,14),('ING123','2018-09-24 14:00:00','2018-09-24 15:00:00','2018-09-24 14:54:00','CALLS',0,14),('ING987654321','2018-09-24 14:00:00','2018-09-24 15:00:00','2018-09-24 14:54:00','CALLS',0,14),('ING1920192019','2018-09-24 14:00:00','2018-09-24 15:00:00','2018-09-24 14:54:00','CALLS',0,14),('TESTBUG6818','2018-09-24 14:00:00','2018-09-24 15:00:00','2018-09-24 14:54:00','CALLS',0,14),('ING3233808432','2018-09-24 14:00:00','2018-09-24 15:00:00','2018-09-24 14:54:00','CALLS',0,14),('ING4844147','2018-09-24 14:00:00','2018-09-24 15:00:00','2018-09-24 14:54:00','CALLS',0,14);
/*!40000 ALTER TABLE `vicidial_ingroup_hour_counts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_ingroup_hour_counts_archive`
--

DROP TABLE IF EXISTS `vicidial_ingroup_hour_counts_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_ingroup_hour_counts_archive` (
  `group_id` varchar(20) DEFAULT NULL,
  `date_hour` datetime DEFAULT NULL,
  `next_hour` datetime DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  `type` varchar(22) DEFAULT 'CALLS',
  `calls` int(9) unsigned DEFAULT '0',
  `hr` tinyint(2) DEFAULT '0',
  UNIQUE KEY `vihc_ingr_hour` (`group_id`,`date_hour`,`type`),
  KEY `group_id` (`group_id`),
  KEY `date_hour` (`date_hour`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_ingroup_hour_counts_archive`
--

LOCK TABLES `vicidial_ingroup_hour_counts_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_ingroup_hour_counts_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_ingroup_hour_counts_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_ip_list_entries`
--

DROP TABLE IF EXISTS `vicidial_ip_list_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_ip_list_entries` (
  `ip_list_id` varchar(30) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  KEY `ip_list_id` (`ip_list_id`),
  KEY `ip_address` (`ip_address`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_ip_list_entries`
--

LOCK TABLES `vicidial_ip_list_entries` WRITE;
/*!40000 ALTER TABLE `vicidial_ip_list_entries` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_ip_list_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_ip_lists`
--

DROP TABLE IF EXISTS `vicidial_ip_lists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_ip_lists` (
  `ip_list_id` varchar(30) NOT NULL,
  `ip_list_name` varchar(100) DEFAULT NULL,
  `active` enum('N','Y') DEFAULT 'N',
  `user_group` varchar(20) DEFAULT '---ALL---',
  UNIQUE KEY `ip_list_id` (`ip_list_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_ip_lists`
--

LOCK TABLES `vicidial_ip_lists` WRITE;
/*!40000 ALTER TABLE `vicidial_ip_lists` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_ip_lists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_ivr`
--

DROP TABLE IF EXISTS `vicidial_ivr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_ivr` (
  `ivr_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `entry_time` datetime DEFAULT NULL,
  `length_in_sec` smallint(5) unsigned DEFAULT '0',
  `inbound_number` varchar(12) DEFAULT NULL,
  `recording_id` int(9) unsigned DEFAULT NULL,
  `recording_filename` varchar(50) DEFAULT NULL,
  `company_id` varchar(12) DEFAULT NULL,
  `phone_number` varchar(18) DEFAULT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `campaign_id` varchar(20) DEFAULT NULL,
  `product_code` varchar(20) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `prompt_audio_1` varchar(20) DEFAULT NULL,
  `prompt_response_1` tinyint(1) unsigned DEFAULT '0',
  `prompt_audio_2` varchar(20) DEFAULT NULL,
  `prompt_response_2` tinyint(1) unsigned DEFAULT '0',
  `prompt_audio_3` varchar(20) DEFAULT NULL,
  `prompt_response_3` tinyint(1) unsigned DEFAULT '0',
  `prompt_audio_4` varchar(20) DEFAULT NULL,
  `prompt_response_4` tinyint(1) unsigned DEFAULT '0',
  `prompt_audio_5` varchar(20) DEFAULT NULL,
  `prompt_response_5` tinyint(1) unsigned DEFAULT '0',
  `prompt_audio_6` varchar(20) DEFAULT NULL,
  `prompt_response_6` tinyint(1) unsigned DEFAULT '0',
  `prompt_audio_7` varchar(20) DEFAULT NULL,
  `prompt_response_7` tinyint(1) unsigned DEFAULT '0',
  `prompt_audio_8` varchar(20) DEFAULT NULL,
  `prompt_response_8` tinyint(1) unsigned DEFAULT '0',
  `prompt_audio_9` varchar(20) DEFAULT NULL,
  `prompt_response_9` tinyint(1) unsigned DEFAULT '0',
  `prompt_audio_10` varchar(20) DEFAULT NULL,
  `prompt_response_10` tinyint(1) unsigned DEFAULT '0',
  `prompt_audio_11` varchar(20) DEFAULT NULL,
  `prompt_response_11` tinyint(1) unsigned DEFAULT '0',
  `prompt_audio_12` varchar(20) DEFAULT NULL,
  `prompt_response_12` tinyint(1) unsigned DEFAULT '0',
  `prompt_audio_13` varchar(20) DEFAULT NULL,
  `prompt_response_13` tinyint(1) unsigned DEFAULT '0',
  `prompt_audio_14` varchar(20) DEFAULT NULL,
  `prompt_response_14` tinyint(1) unsigned DEFAULT '0',
  `prompt_audio_15` varchar(20) DEFAULT NULL,
  `prompt_response_15` tinyint(1) unsigned DEFAULT '0',
  `prompt_audio_16` varchar(20) DEFAULT NULL,
  `prompt_response_16` tinyint(1) unsigned DEFAULT '0',
  `prompt_audio_17` varchar(20) DEFAULT NULL,
  `prompt_response_17` tinyint(1) unsigned DEFAULT '0',
  `prompt_audio_18` varchar(20) DEFAULT NULL,
  `prompt_response_18` tinyint(1) unsigned DEFAULT '0',
  `prompt_audio_19` varchar(20) DEFAULT NULL,
  `prompt_response_19` tinyint(1) unsigned DEFAULT '0',
  `prompt_audio_20` varchar(20) DEFAULT NULL,
  `prompt_response_20` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`ivr_id`),
  KEY `phone_number` (`phone_number`),
  KEY `entry_time` (`entry_time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_ivr`
--

LOCK TABLES `vicidial_ivr` WRITE;
/*!40000 ALTER TABLE `vicidial_ivr` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_ivr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_ivr_response`
--

DROP TABLE IF EXISTS `vicidial_ivr_response`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_ivr_response` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `btn` varchar(10) DEFAULT NULL,
  `lead_id` int(10) unsigned DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `question` int(11) DEFAULT NULL,
  `response` varchar(10) DEFAULT NULL,
  `uniqueid` varchar(50) DEFAULT NULL,
  `campaign` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `question_created` (`question`,`uniqueid`,`campaign`,`created`),
  KEY `lead_id` (`lead_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1599 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_ivr_response`
--

LOCK TABLES `vicidial_ivr_response` WRITE;
/*!40000 ALTER TABLE `vicidial_ivr_response` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_ivr_response` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_language_phrases`
--

DROP TABLE IF EXISTS `vicidial_language_phrases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_language_phrases` (
  `phrase_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `language_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `english_text` varchar(10000) COLLATE utf8_unicode_ci DEFAULT '',
  `translated_text` text COLLATE utf8_unicode_ci,
  `source` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`phrase_id`),
  KEY `language_id` (`language_id`),
  KEY `english_text` (`english_text`(333))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_language_phrases`
--

LOCK TABLES `vicidial_language_phrases` WRITE;
/*!40000 ALTER TABLE `vicidial_language_phrases` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_language_phrases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_languages`
--

DROP TABLE IF EXISTS `vicidial_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_languages` (
  `language_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `language_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `language_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `user_group` varchar(20) COLLATE utf8_unicode_ci DEFAULT '---ALL---',
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` enum('Y','N') COLLATE utf8_unicode_ci DEFAULT 'N',
  UNIQUE KEY `language_id` (`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_languages`
--

LOCK TABLES `vicidial_languages` WRITE;
/*!40000 ALTER TABLE `vicidial_languages` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_lead_filters`
--

DROP TABLE IF EXISTS `vicidial_lead_filters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_lead_filters` (
  `lead_filter_id` varchar(20) NOT NULL,
  `lead_filter_name` varchar(30) NOT NULL,
  `lead_filter_comments` varchar(255) DEFAULT NULL,
  `lead_filter_sql` text,
  `user_group` varchar(20) DEFAULT '---ALL---',
  PRIMARY KEY (`lead_filter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_lead_filters`
--

LOCK TABLES `vicidial_lead_filters` WRITE;
/*!40000 ALTER TABLE `vicidial_lead_filters` DISABLE KEYS */;
INSERT INTO `vicidial_lead_filters` VALUES ('FILTEMP','FILTRER TEMPLATE','FILTRER TEMPLATE','state in(\"AL\",\"AR\",\"CA\",\"CO\",\"CT\",\"FL\",\"GA\",\"IL\",\"KY\",\"LA\",\"MD\",\"MA\",\"MN\",\"MS\",\"NJ\",\"NM\",\"NY\",\"OR\",\"PA\",\"SC\",\"WA\")\r\n\r\n\r\n\r\nLEFT(phone_number,3) in (\"201\",\"215\",\"609\",\"718\",\"732\",\"856\",\"908\",\"973\",\"215\",\"267\",\"484\",\"609\",\"610\",\"717\",\"856\",\"626\",\"213\",\"310\",\"323\",\"562\",\"619\")','---ALL---');
/*!40000 ALTER TABLE `vicidial_lead_filters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_lead_recycle`
--

DROP TABLE IF EXISTS `vicidial_lead_recycle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_lead_recycle` (
  `recycle_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `campaign_id` varchar(8) DEFAULT NULL,
  `status` varchar(6) NOT NULL,
  `attempt_delay` smallint(5) unsigned DEFAULT '1800',
  `attempt_maximum` tinyint(3) unsigned DEFAULT '2',
  `active` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`recycle_id`),
  KEY `campaign_id` (`campaign_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_lead_recycle`
--

LOCK TABLES `vicidial_lead_recycle` WRITE;
/*!40000 ALTER TABLE `vicidial_lead_recycle` DISABLE KEYS */;
INSERT INTO `vicidial_lead_recycle` VALUES (26,'15281117','ERI',1800,2,'Y'),(27,'15281117','PU',1800,2,'Y'),(28,'12904133','AA',1800,5,'Y');
/*!40000 ALTER TABLE `vicidial_lead_recycle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_lead_search_log`
--

DROP TABLE IF EXISTS `vicidial_lead_search_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_lead_search_log` (
  `search_log_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(20) NOT NULL,
  `event_date` datetime NOT NULL,
  `source` varchar(10) DEFAULT '',
  `search_query` text,
  `results` int(9) unsigned DEFAULT '0',
  `seconds` mediumint(7) unsigned DEFAULT '0',
  PRIMARY KEY (`search_log_id`),
  KEY `user` (`user`),
  KEY `event_date` (`event_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_lead_search_log`
--

LOCK TABLES `vicidial_lead_search_log` WRITE;
/*!40000 ALTER TABLE `vicidial_lead_search_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_lead_search_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_lead_search_log_archive`
--

DROP TABLE IF EXISTS `vicidial_lead_search_log_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_lead_search_log_archive` (
  `search_log_id` int(9) unsigned NOT NULL,
  `user` varchar(20) NOT NULL,
  `event_date` datetime NOT NULL,
  `source` varchar(10) DEFAULT '',
  `search_query` text,
  `results` int(9) unsigned DEFAULT '0',
  `seconds` mediumint(7) unsigned DEFAULT '0',
  PRIMARY KEY (`search_log_id`),
  KEY `user` (`user`),
  KEY `event_date` (`event_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_lead_search_log_archive`
--

LOCK TABLES `vicidial_lead_search_log_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_lead_search_log_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_lead_search_log_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_list`
--

DROP TABLE IF EXISTS `vicidial_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_list` (
  `lead_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `entry_date` datetime DEFAULT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(6) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `vendor_lead_code` varchar(20) DEFAULT NULL,
  `source_id` varchar(50) DEFAULT NULL,
  `list_id` bigint(14) unsigned NOT NULL DEFAULT '0',
  `gmt_offset_now` decimal(4,2) DEFAULT '0.00',
  `called_since_last_reset` enum('Y','N','Y1','Y2','Y3','Y4','Y5','Y6','Y7','Y8','Y9','Y10') DEFAULT 'N',
  `phone_code` varchar(10) DEFAULT NULL,
  `phone_number` varchar(18) NOT NULL,
  `title` varchar(4) DEFAULT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `middle_initial` varchar(1) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `address1` varchar(100) DEFAULT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `address3` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `country_code` varchar(3) DEFAULT NULL,
  `gender` enum('M','F','U') DEFAULT 'U',
  `date_of_birth` date DEFAULT NULL,
  `alt_phone` varchar(12) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `security_phrase` varchar(100) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `called_count` smallint(5) unsigned DEFAULT '0',
  `last_local_call_time` datetime DEFAULT NULL,
  `rank` smallint(5) NOT NULL DEFAULT '0',
  `owner` varchar(20) DEFAULT '',
  `entry_list_id` bigint(14) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`lead_id`),
  KEY `phone_number` (`phone_number`),
  KEY `list_id` (`list_id`),
  KEY `called_since_last_reset` (`called_since_last_reset`),
  KEY `status` (`status`),
  KEY `gmt_offset_now` (`gmt_offset_now`),
  KEY `postal_code` (`postal_code`),
  KEY `last_local_call_time` (`last_local_call_time`),
  KEY `phone_list` (`phone_number`,`list_id`),
  KEY `list_phone` (`list_id`,`phone_number`),
  KEY `list_status` (`list_id`,`status`),
  KEY `rank` (`rank`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB AUTO_INCREMENT=29264 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_list`
--

LOCK TABLES `vicidial_list` WRITE;
/*!40000 ALTER TABLE `vicidial_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_list_alt_phones`
--

DROP TABLE IF EXISTS `vicidial_list_alt_phones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_list_alt_phones` (
  `alt_phone_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `lead_id` int(9) unsigned NOT NULL,
  `phone_code` varchar(10) DEFAULT NULL,
  `phone_number` varchar(18) DEFAULT NULL,
  `alt_phone_note` varchar(30) DEFAULT NULL,
  `alt_phone_count` smallint(5) unsigned DEFAULT NULL,
  `active` enum('Y','N') DEFAULT 'Y',
  PRIMARY KEY (`alt_phone_id`),
  KEY `lead_id` (`lead_id`),
  KEY `phone_number` (`phone_number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_list_alt_phones`
--

LOCK TABLES `vicidial_list_alt_phones` WRITE;
/*!40000 ALTER TABLE `vicidial_list_alt_phones` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_list_alt_phones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_list_archive`
--

DROP TABLE IF EXISTS `vicidial_list_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_list_archive` (
  `lead_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `entry_date` datetime DEFAULT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(6) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `vendor_lead_code` varchar(20) DEFAULT NULL,
  `source_id` varchar(50) DEFAULT NULL,
  `list_id` bigint(14) unsigned NOT NULL DEFAULT '0',
  `gmt_offset_now` decimal(4,2) DEFAULT '0.00',
  `called_since_last_reset` enum('Y','N','Y1','Y2','Y3','Y4','Y5','Y6','Y7','Y8','Y9','Y10') DEFAULT 'N',
  `phone_code` varchar(10) DEFAULT NULL,
  `phone_number` varchar(18) NOT NULL,
  `title` varchar(4) DEFAULT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `middle_initial` varchar(1) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `address1` varchar(100) DEFAULT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `address3` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `country_code` varchar(3) DEFAULT NULL,
  `gender` enum('M','F','U') DEFAULT 'U',
  `date_of_birth` date DEFAULT NULL,
  `alt_phone` varchar(12) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `security_phrase` varchar(100) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `called_count` smallint(5) unsigned DEFAULT '0',
  `last_local_call_time` datetime DEFAULT NULL,
  `rank` smallint(5) NOT NULL DEFAULT '0',
  `owner` varchar(20) DEFAULT '',
  `entry_list_id` bigint(14) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`lead_id`),
  KEY `phone_number` (`phone_number`),
  KEY `list_id` (`list_id`),
  KEY `called_since_last_reset` (`called_since_last_reset`),
  KEY `status` (`status`),
  KEY `gmt_offset_now` (`gmt_offset_now`),
  KEY `postal_code` (`postal_code`),
  KEY `last_local_call_time` (`last_local_call_time`),
  KEY `phone_list` (`phone_number`,`list_id`),
  KEY `list_phone` (`list_id`,`phone_number`),
  KEY `list_status` (`list_id`,`status`),
  KEY `rank` (`rank`),
  KEY `owner` (`owner`)
) ENGINE=MyISAM AUTO_INCREMENT=1028 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_list_archive`
--

LOCK TABLES `vicidial_list_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_list_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_list_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_list_pins`
--

DROP TABLE IF EXISTS `vicidial_list_pins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_list_pins` (
  `pins_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `entry_time` datetime DEFAULT NULL,
  `phone_number` varchar(18) DEFAULT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `campaign_id` varchar(20) DEFAULT NULL,
  `product_code` varchar(20) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `digits` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`pins_id`),
  KEY `lead_id` (`lead_id`),
  KEY `phone_number` (`phone_number`),
  KEY `entry_time` (`entry_time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_list_pins`
--

LOCK TABLES `vicidial_list_pins` WRITE;
/*!40000 ALTER TABLE `vicidial_list_pins` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_list_pins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_list_update_log`
--

DROP TABLE IF EXISTS `vicidial_list_update_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_list_update_log` (
  `event_date` datetime DEFAULT NULL,
  `lead_id` varchar(255) DEFAULT NULL,
  `vendor_id` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `status` varchar(6) DEFAULT NULL,
  `old_status` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT '',
  `result` varchar(20) DEFAULT NULL,
  `result_rows` smallint(3) unsigned DEFAULT '0',
  `list_id` varchar(255) DEFAULT NULL,
  KEY `event_date` (`event_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_list_update_log`
--

LOCK TABLES `vicidial_list_update_log` WRITE;
/*!40000 ALTER TABLE `vicidial_list_update_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_list_update_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `vicidial_list_view`
--

DROP TABLE IF EXISTS `vicidial_list_view`;
/*!50001 DROP VIEW IF EXISTS `vicidial_list_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vicidial_list_view` (
  `lead_id` tinyint NOT NULL,
  `fullname` tinyint NOT NULL,
  `status` tinyint NOT NULL,
  `phone_number` tinyint NOT NULL,
  `address1` tinyint NOT NULL,
  `address2` tinyint NOT NULL,
  `address3` tinyint NOT NULL,
  `city` tinyint NOT NULL,
  `state` tinyint NOT NULL,
  `province` tinyint NOT NULL,
  `date_of_birth` tinyint NOT NULL,
  `alt_phone` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `vicidial_lists`
--

DROP TABLE IF EXISTS `vicidial_lists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_lists` (
  `list_id` bigint(14) unsigned NOT NULL,
  `list_name` varchar(30) DEFAULT NULL,
  `campaign_id` varchar(8) DEFAULT NULL,
  `active` enum('Y','N') DEFAULT NULL,
  `list_description` varchar(255) DEFAULT NULL,
  `list_changedate` datetime DEFAULT NULL,
  `list_lastcalldate` datetime DEFAULT NULL,
  `reset_time` varchar(100) DEFAULT '',
  `agent_script_override` varchar(20) DEFAULT '',
  `campaign_cid_override` varchar(20) DEFAULT '',
  `am_message_exten_override` varchar(100) DEFAULT '',
  `drop_inbound_group_override` varchar(20) DEFAULT '',
  `xferconf_a_number` varchar(50) DEFAULT '',
  `xferconf_b_number` varchar(50) DEFAULT '',
  `xferconf_c_number` varchar(50) DEFAULT '',
  `xferconf_d_number` varchar(50) DEFAULT '',
  `xferconf_e_number` varchar(50) DEFAULT '',
  `web_form_address` text,
  `web_form_address_two` text,
  `time_zone_setting` enum('COUNTRY_AND_AREA_CODE','POSTAL_CODE','NANPA_PREFIX','OWNER_TIME_ZONE_CODE') DEFAULT 'COUNTRY_AND_AREA_CODE',
  `inventory_report` enum('Y','N') DEFAULT 'Y',
  `expiration_date` date DEFAULT '2099-12-31',
  `na_call_url` text,
  `local_call_time` varchar(10) NOT NULL DEFAULT 'campaign',
  `web_form_address_three` text,
  `status_group_id` varchar(20) DEFAULT '',
  `inbound_list_script_override` varchar(20) DEFAULT NULL,
  `default_xfer_group` varchar(20) DEFAULT '---NONE---',
  `user_new_lead_limit` smallint(5) DEFAULT '-1',
  PRIMARY KEY (`list_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_lists`
--

LOCK TABLES `vicidial_lists` WRITE;
/*!40000 ALTER TABLE `vicidial_lists` DISABLE KEYS */;
INSERT INTO `vicidial_lists` VALUES (999,'Default inbound list','TESTCAMP','N',NULL,NULL,NULL,'','','','','','','','','','',NULL,NULL,'COUNTRY_AND_AREA_CODE','Y','2099-12-31',NULL,'campaign',NULL,'',NULL,'---NONE---',-1),(998,'Default Manual list','TESTCAMP','N','',NULL,'0000-00-00 00:00:00','','','','','NONE','','','','','','',NULL,'COUNTRY_AND_AREA_CODE','Y','2099-12-31',NULL,'campaign',NULL,'',NULL,'---NONE---',-1),(1001,'List 1001','15281117','Y','List 1001 Description','2018-09-23 13:22:13',NULL,NULL,'script001',NULL,'','NONE',NULL,NULL,NULL,NULL,NULL,'https://goautodial.org',NULL,'COUNTRY_AND_AREA_CODE','Y','2099-12-31',NULL,'campaign',NULL,'',NULL,'---NONE---',-1);
/*!40000 ALTER TABLE `vicidial_lists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_lists_custom`
--

DROP TABLE IF EXISTS `vicidial_lists_custom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_lists_custom` (
  `list_id` bigint(14) unsigned NOT NULL,
  `audit_comments` tinyint(1) DEFAULT NULL COMMENT 'visible',
  `audit_comments_enabled` tinyint(1) DEFAULT NULL COMMENT 'invisible',
  PRIMARY KEY (`list_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_lists_custom`
--

LOCK TABLES `vicidial_lists_custom` WRITE;
/*!40000 ALTER TABLE `vicidial_lists_custom` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_lists_custom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_lists_fields`
--

DROP TABLE IF EXISTS `vicidial_lists_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_lists_fields` (
  `field_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `list_id` bigint(14) unsigned NOT NULL DEFAULT '0',
  `field_label` varchar(50) DEFAULT NULL,
  `field_name` varchar(5000) DEFAULT NULL,
  `field_description` varchar(100) DEFAULT NULL,
  `field_rank` smallint(5) DEFAULT NULL,
  `field_help` varchar(1000) DEFAULT NULL,
  `field_type` enum('TEXT','AREA','SELECT','MULTI','RADIO','CHECKBOX','DATE','TIME','DISPLAY','SCRIPT','HIDDEN','READONLY','HIDEBLOB') DEFAULT 'TEXT',
  `field_options` varchar(5000) DEFAULT NULL,
  `field_size` smallint(5) DEFAULT NULL,
  `field_max` smallint(5) DEFAULT NULL,
  `field_default` varchar(255) DEFAULT NULL,
  `field_cost` smallint(5) DEFAULT NULL,
  `field_required` enum('Y','N','INBOUND_ONLY') DEFAULT 'N',
  `name_position` enum('LEFT','TOP') DEFAULT 'LEFT',
  `multi_position` enum('HORIZONTAL','VERTICAL') DEFAULT 'HORIZONTAL',
  `field_order` smallint(5) DEFAULT '1',
  `field_encrypt` enum('Y','N') DEFAULT 'N',
  `field_show_hide` enum('DISABLED','X_OUT_ALL','LAST_1','LAST_2','LAST_3','LAST_4','FIRST_1_LAST_4') DEFAULT 'DISABLED',
  `field_duplicate` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`field_id`),
  UNIQUE KEY `listfield` (`list_id`,`field_label`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_lists_fields`
--

LOCK TABLES `vicidial_lists_fields` WRITE;
/*!40000 ALTER TABLE `vicidial_lists_fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_lists_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_live_agents`
--

DROP TABLE IF EXISTS `vicidial_live_agents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_live_agents` (
  `live_agent_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(20) DEFAULT NULL,
  `server_ip` varchar(15) NOT NULL,
  `conf_exten` varchar(20) DEFAULT NULL,
  `extension` varchar(100) DEFAULT NULL,
  `status` enum('READY','QUEUE','INCALL','PAUSED','CLOSER','MQUEUE') DEFAULT 'PAUSED',
  `lead_id` int(9) unsigned NOT NULL,
  `campaign_id` varchar(8) DEFAULT NULL,
  `uniqueid` varchar(20) DEFAULT NULL,
  `callerid` varchar(20) DEFAULT NULL,
  `channel` varchar(100) DEFAULT NULL,
  `random_id` int(8) unsigned DEFAULT NULL,
  `last_call_time` datetime DEFAULT NULL,
  `last_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_call_finish` datetime DEFAULT NULL,
  `closer_campaigns` text,
  `call_server_ip` varchar(15) DEFAULT NULL,
  `user_level` tinyint(3) unsigned DEFAULT '0',
  `comments` varchar(20) DEFAULT NULL,
  `campaign_weight` tinyint(1) DEFAULT '0',
  `calls_today` smallint(5) unsigned DEFAULT '0',
  `external_hangup` varchar(1) DEFAULT '',
  `external_status` varchar(255) DEFAULT '',
  `external_pause` varchar(20) DEFAULT '',
  `external_dial` varchar(100) DEFAULT '',
  `external_ingroups` text,
  `external_blended` enum('0','1') DEFAULT '0',
  `external_igb_set_user` varchar(20) DEFAULT '',
  `external_update_fields` enum('0','1') DEFAULT '0',
  `external_update_fields_data` varchar(255) DEFAULT '',
  `external_timer_action` varchar(20) DEFAULT '',
  `external_timer_action_message` varchar(255) DEFAULT '',
  `external_timer_action_seconds` mediumint(7) DEFAULT '-1',
  `agent_log_id` int(9) unsigned DEFAULT '0',
  `last_state_change` datetime DEFAULT NULL,
  `agent_territories` text,
  `outbound_autodial` enum('Y','N') DEFAULT 'N',
  `manager_ingroup_set` enum('Y','N','SET') DEFAULT 'N',
  `ra_user` varchar(20) DEFAULT '',
  `ra_extension` varchar(100) DEFAULT '',
  `external_dtmf` varchar(100) DEFAULT '',
  `external_transferconf` varchar(120) DEFAULT '',
  `external_park` varchar(40) DEFAULT '',
  `external_timer_action_destination` varchar(100) DEFAULT '',
  `on_hook_agent` enum('Y','N') DEFAULT 'N',
  `on_hook_ring_time` smallint(5) DEFAULT '15',
  `ring_callerid` varchar(20) DEFAULT '',
  `last_inbound_call_time` datetime DEFAULT NULL,
  `last_inbound_call_finish` datetime DEFAULT NULL,
  `campaign_grade` tinyint(2) unsigned DEFAULT '1',
  `external_recording` varchar(20) DEFAULT '',
  `external_pause_code` varchar(6) DEFAULT '',
  `pause_code` varchar(6) DEFAULT '',
  `preview_lead_id` int(9) unsigned DEFAULT '0',
  `external_lead_id` int(9) unsigned DEFAULT '0',
  PRIMARY KEY (`live_agent_id`),
  KEY `random_id` (`random_id`),
  KEY `last_call_time` (`last_call_time`),
  KEY `last_update_time` (`last_update_time`),
  KEY `last_call_finish` (`last_call_finish`),
  KEY `vlali` (`lead_id`),
  KEY `vlaus` (`user`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_live_agents`
--

LOCK TABLES `vicidial_live_agents` WRITE;
/*!40000 ALTER TABLE `vicidial_live_agents` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_live_agents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_live_chats`
--

DROP TABLE IF EXISTS `vicidial_live_chats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_live_chats` (
  `chat_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `chat_start_time` datetime DEFAULT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chat_creator` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `transferring_agent` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_direct` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_direct_group_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`chat_id`),
  KEY `vicidial_live_chats_lead_id_key` (`lead_id`),
  KEY `vicidial_live_chats_start_time_key` (`chat_start_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_live_chats`
--

LOCK TABLES `vicidial_live_chats` WRITE;
/*!40000 ALTER TABLE `vicidial_live_chats` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_live_chats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_live_inbound_agents`
--

DROP TABLE IF EXISTS `vicidial_live_inbound_agents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_live_inbound_agents` (
  `user` varchar(20) DEFAULT NULL,
  `group_id` varchar(20) DEFAULT NULL,
  `group_weight` tinyint(1) DEFAULT '0',
  `calls_today` smallint(5) unsigned DEFAULT '0',
  `last_call_time` datetime DEFAULT NULL,
  `last_call_finish` datetime DEFAULT NULL,
  `group_grade` tinyint(2) unsigned DEFAULT '1',
  UNIQUE KEY `vlia_user_group_id` (`user`,`group_id`),
  KEY `group_id` (`group_id`),
  KEY `group_weight` (`group_weight`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_live_inbound_agents`
--

LOCK TABLES `vicidial_live_inbound_agents` WRITE;
/*!40000 ALTER TABLE `vicidial_live_inbound_agents` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_live_inbound_agents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_log`
--

DROP TABLE IF EXISTS `vicidial_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_log` (
  `uniqueid` varchar(20) NOT NULL,
  `lead_id` int(9) unsigned NOT NULL,
  `list_id` bigint(14) unsigned DEFAULT NULL,
  `campaign_id` varchar(8) DEFAULT NULL,
  `call_date` datetime DEFAULT NULL,
  `start_epoch` int(10) unsigned DEFAULT NULL,
  `end_epoch` int(10) unsigned DEFAULT NULL,
  `length_in_sec` int(10) DEFAULT NULL,
  `status` varchar(6) DEFAULT NULL,
  `phone_code` varchar(10) DEFAULT NULL,
  `phone_number` varchar(18) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `processed` enum('Y','N') DEFAULT NULL,
  `user_group` varchar(20) DEFAULT NULL,
  `term_reason` enum('CALLER','AGENT','QUEUETIMEOUT','ABANDON','AFTERHOURS','NONE') DEFAULT 'NONE',
  `alt_dial` varchar(6) DEFAULT 'NONE',
  `called_count` smallint(5) unsigned DEFAULT '0',
  PRIMARY KEY (`uniqueid`),
  KEY `lead_id` (`lead_id`),
  KEY `call_date` (`call_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_log`
--

LOCK TABLES `vicidial_log` WRITE;
/*!40000 ALTER TABLE `vicidial_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_log_archive`
--

DROP TABLE IF EXISTS `vicidial_log_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_log_archive` (
  `uniqueid` varchar(20) NOT NULL,
  `lead_id` int(9) unsigned NOT NULL,
  `list_id` bigint(14) unsigned DEFAULT NULL,
  `campaign_id` varchar(8) DEFAULT NULL,
  `call_date` datetime DEFAULT NULL,
  `start_epoch` int(10) unsigned DEFAULT NULL,
  `end_epoch` int(10) unsigned DEFAULT NULL,
  `length_in_sec` int(10) DEFAULT NULL,
  `status` varchar(6) DEFAULT NULL,
  `phone_code` varchar(10) DEFAULT NULL,
  `phone_number` varchar(18) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `processed` enum('Y','N') DEFAULT NULL,
  `user_group` varchar(20) DEFAULT NULL,
  `term_reason` enum('CALLER','AGENT','QUEUETIMEOUT','ABANDON','AFTERHOURS','NONE') DEFAULT 'NONE',
  `alt_dial` varchar(6) DEFAULT 'NONE',
  `called_count` smallint(5) unsigned DEFAULT '0',
  PRIMARY KEY (`uniqueid`),
  KEY `lead_id` (`lead_id`),
  KEY `call_date` (`call_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_log_archive`
--

LOCK TABLES `vicidial_log_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_log_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_log_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_log_extended`
--

DROP TABLE IF EXISTS `vicidial_log_extended`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_log_extended` (
  `uniqueid` varchar(50) NOT NULL,
  `server_ip` varchar(15) DEFAULT NULL,
  `call_date` datetime DEFAULT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `caller_code` varchar(30) NOT NULL,
  `custom_call_id` varchar(100) DEFAULT NULL,
  `start_url_processed` enum('N','Y','U') DEFAULT 'N',
  `dispo_url_processed` enum('N','Y','U','XY','XU') DEFAULT 'N',
  `multi_alt_processed` enum('N','Y','U') DEFAULT 'N',
  `noanswer_processed` enum('N','Y','U') DEFAULT 'N',
  PRIMARY KEY (`uniqueid`),
  KEY `call_date` (`call_date`),
  KEY `vlecc` (`caller_code`),
  KEY `vle_lead_id` (`lead_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_log_extended`
--

LOCK TABLES `vicidial_log_extended` WRITE;
/*!40000 ALTER TABLE `vicidial_log_extended` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_log_extended` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_log_extended_archive`
--

DROP TABLE IF EXISTS `vicidial_log_extended_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_log_extended_archive` (
  `uniqueid` varchar(50) NOT NULL,
  `server_ip` varchar(15) DEFAULT NULL,
  `call_date` datetime DEFAULT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `caller_code` varchar(30) NOT NULL,
  `custom_call_id` varchar(100) DEFAULT NULL,
  `start_url_processed` enum('N','Y','U') DEFAULT 'N',
  `dispo_url_processed` enum('N','Y','U','XY','XU') DEFAULT 'N',
  `multi_alt_processed` enum('N','Y','U') DEFAULT 'N',
  `noanswer_processed` enum('N','Y','U') DEFAULT 'N',
  PRIMARY KEY (`uniqueid`),
  UNIQUE KEY `vlea` (`uniqueid`,`call_date`,`lead_id`),
  KEY `call_date` (`call_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_log_extended_archive`
--

LOCK TABLES `vicidial_log_extended_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_log_extended_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_log_extended_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_log_noanswer`
--

DROP TABLE IF EXISTS `vicidial_log_noanswer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_log_noanswer` (
  `uniqueid` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `lead_id` int(9) unsigned NOT NULL,
  `list_id` bigint(14) unsigned DEFAULT NULL,
  `campaign_id` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `call_date` datetime DEFAULT NULL,
  `start_epoch` int(10) unsigned DEFAULT NULL,
  `end_epoch` int(10) unsigned DEFAULT NULL,
  `length_in_sec` int(10) DEFAULT NULL,
  `status` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(18) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `processed` enum('Y','N') COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_group` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `term_reason` enum('CALLER','AGENT','QUEUETIMEOUT','ABANDON','AFTERHOURS','NONE') COLLATE utf8_unicode_ci DEFAULT 'NONE',
  `alt_dial` varchar(6) COLLATE utf8_unicode_ci DEFAULT 'NONE',
  `caller_code` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`uniqueid`),
  KEY `lead_id` (`lead_id`),
  KEY `call_date` (`call_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_log_noanswer`
--

LOCK TABLES `vicidial_log_noanswer` WRITE;
/*!40000 ALTER TABLE `vicidial_log_noanswer` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_log_noanswer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_log_noanswer_archive`
--

DROP TABLE IF EXISTS `vicidial_log_noanswer_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_log_noanswer_archive` (
  `uniqueid` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `lead_id` int(9) unsigned NOT NULL,
  `list_id` bigint(14) unsigned DEFAULT NULL,
  `campaign_id` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `call_date` datetime DEFAULT NULL,
  `start_epoch` int(10) unsigned DEFAULT NULL,
  `end_epoch` int(10) unsigned DEFAULT NULL,
  `length_in_sec` int(10) DEFAULT NULL,
  `status` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(18) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `processed` enum('Y','N') COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_group` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `term_reason` enum('CALLER','AGENT','QUEUETIMEOUT','ABANDON','AFTERHOURS','NONE') COLLATE utf8_unicode_ci DEFAULT 'NONE',
  `alt_dial` varchar(6) COLLATE utf8_unicode_ci DEFAULT 'NONE',
  `caller_code` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`uniqueid`),
  KEY `lead_id` (`lead_id`),
  KEY `call_date` (`call_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_log_noanswer_archive`
--

LOCK TABLES `vicidial_log_noanswer_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_log_noanswer_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_log_noanswer_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_manager`
--

DROP TABLE IF EXISTS `vicidial_manager`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_manager` (
  `man_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `uniqueid` varchar(20) DEFAULT NULL,
  `entry_date` datetime DEFAULT NULL,
  `status` enum('NEW','QUEUE','SENT','UPDATED','DEAD') DEFAULT NULL,
  `response` enum('Y','N') DEFAULT NULL,
  `server_ip` varchar(15) NOT NULL,
  `channel` varchar(100) DEFAULT NULL,
  `action` varchar(20) DEFAULT NULL,
  `callerid` varchar(20) DEFAULT NULL,
  `cmd_line_b` varchar(100) DEFAULT NULL,
  `cmd_line_c` varchar(100) DEFAULT NULL,
  `cmd_line_d` varchar(100) DEFAULT NULL,
  `cmd_line_e` varchar(100) DEFAULT NULL,
  `cmd_line_f` varchar(100) DEFAULT NULL,
  `cmd_line_g` varchar(100) DEFAULT NULL,
  `cmd_line_h` varchar(100) DEFAULT NULL,
  `cmd_line_i` varchar(100) DEFAULT NULL,
  `cmd_line_j` varchar(100) DEFAULT NULL,
  `cmd_line_k` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`man_id`),
  KEY `callerid` (`callerid`),
  KEY `uniqueid` (`uniqueid`),
  KEY `serverstat` (`server_ip`,`status`)
) ENGINE=MyISAM AUTO_INCREMENT=29155 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_manager`
--

LOCK TABLES `vicidial_manager` WRITE;
/*!40000 ALTER TABLE `vicidial_manager` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_manager` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_manager_chat_log`
--

DROP TABLE IF EXISTS `vicidial_manager_chat_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_manager_chat_log` (
  `manager_chat_message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `manager_chat_id` int(10) unsigned DEFAULT NULL,
  `manager_chat_subid` tinyint(3) unsigned DEFAULT NULL,
  `manager` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` mediumtext COLLATE utf8_unicode_ci,
  `message_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message_date` datetime DEFAULT NULL,
  `message_viewed_date` datetime DEFAULT NULL,
  `message_posted_by` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `audio_alerted` enum('Y','N') COLLATE utf8_unicode_ci DEFAULT 'N',
  PRIMARY KEY (`manager_chat_message_id`),
  KEY `manager_chat_id_key` (`manager_chat_id`),
  KEY `manager_chat_subid_key` (`manager_chat_subid`),
  KEY `manager_chat_manager_key` (`manager`),
  KEY `manager_chat_user_key` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_manager_chat_log`
--

LOCK TABLES `vicidial_manager_chat_log` WRITE;
/*!40000 ALTER TABLE `vicidial_manager_chat_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_manager_chat_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_manager_chat_log_archive`
--

DROP TABLE IF EXISTS `vicidial_manager_chat_log_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_manager_chat_log_archive` (
  `manager_chat_message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `manager_chat_id` int(10) unsigned DEFAULT NULL,
  `manager_chat_subid` tinyint(3) unsigned DEFAULT NULL,
  `manager` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` mediumtext COLLATE utf8_unicode_ci,
  `message_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message_date` datetime DEFAULT NULL,
  `message_viewed_date` datetime DEFAULT NULL,
  `message_posted_by` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `audio_alerted` enum('Y','N') COLLATE utf8_unicode_ci DEFAULT 'N',
  PRIMARY KEY (`manager_chat_message_id`),
  KEY `manager_chat_id_archive_key` (`manager_chat_id`),
  KEY `manager_chat_subid_archive_key` (`manager_chat_subid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_manager_chat_log_archive`
--

LOCK TABLES `vicidial_manager_chat_log_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_manager_chat_log_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_manager_chat_log_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_manager_chats`
--

DROP TABLE IF EXISTS `vicidial_manager_chats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_manager_chats` (
  `manager_chat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `internal_chat_type` enum('AGENT','MANAGER') COLLATE utf8_unicode_ci DEFAULT 'MANAGER',
  `chat_start_date` datetime DEFAULT NULL,
  `manager` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `selected_agents` mediumtext COLLATE utf8_unicode_ci,
  `selected_user_groups` mediumtext COLLATE utf8_unicode_ci,
  `selected_campaigns` mediumtext COLLATE utf8_unicode_ci,
  `allow_replies` enum('Y','N') COLLATE utf8_unicode_ci DEFAULT 'N',
  PRIMARY KEY (`manager_chat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_manager_chats`
--

LOCK TABLES `vicidial_manager_chats` WRITE;
/*!40000 ALTER TABLE `vicidial_manager_chats` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_manager_chats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_manager_chats_archive`
--

DROP TABLE IF EXISTS `vicidial_manager_chats_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_manager_chats_archive` (
  `manager_chat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `internal_chat_type` enum('AGENT','MANAGER') COLLATE utf8_unicode_ci DEFAULT 'MANAGER',
  `chat_start_date` datetime DEFAULT NULL,
  `manager` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `selected_agents` mediumtext COLLATE utf8_unicode_ci,
  `selected_user_groups` mediumtext COLLATE utf8_unicode_ci,
  `selected_campaigns` mediumtext COLLATE utf8_unicode_ci,
  `allow_replies` enum('Y','N') COLLATE utf8_unicode_ci DEFAULT 'N',
  PRIMARY KEY (`manager_chat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_manager_chats_archive`
--

LOCK TABLES `vicidial_manager_chats_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_manager_chats_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_manager_chats_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_manual_dial_queue`
--

DROP TABLE IF EXISTS `vicidial_manual_dial_queue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_manual_dial_queue` (
  `mdq_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(20) DEFAULT NULL,
  `phone_number` varchar(100) DEFAULT '',
  `entry_time` datetime DEFAULT NULL,
  `status` enum('READY','QUEUE') DEFAULT 'READY',
  `external_dial` varchar(100) DEFAULT '',
  PRIMARY KEY (`mdq_id`),
  KEY `user` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_manual_dial_queue`
--

LOCK TABLES `vicidial_manual_dial_queue` WRITE;
/*!40000 ALTER TABLE `vicidial_manual_dial_queue` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_manual_dial_queue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_monitor_calls`
--

DROP TABLE IF EXISTS `vicidial_monitor_calls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_monitor_calls` (
  `monitor_call_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `server_ip` varchar(15) NOT NULL,
  `callerid` varchar(20) DEFAULT NULL,
  `channel` varchar(100) DEFAULT NULL,
  `context` varchar(100) DEFAULT NULL,
  `uniqueid` varchar(20) DEFAULT NULL,
  `monitor_time` datetime DEFAULT NULL,
  `user_phone` varchar(10) DEFAULT 'USER',
  `api_log` enum('Y','N') DEFAULT 'N',
  `barge_listen` enum('LISTEN','BARGE') DEFAULT 'LISTEN',
  `prepop_id` varchar(100) DEFAULT '',
  `campaigns_limit` varchar(1000) DEFAULT '',
  `users_list` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`monitor_call_id`),
  KEY `callerid` (`callerid`),
  KEY `monitor_time` (`monitor_time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_monitor_calls`
--

LOCK TABLES `vicidial_monitor_calls` WRITE;
/*!40000 ALTER TABLE `vicidial_monitor_calls` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_monitor_calls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_monitor_log`
--

DROP TABLE IF EXISTS `vicidial_monitor_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_monitor_log` (
  `server_ip` varchar(15) NOT NULL,
  `callerid` varchar(20) DEFAULT NULL,
  `channel` varchar(100) DEFAULT NULL,
  `context` varchar(100) DEFAULT NULL,
  `uniqueid` varchar(20) DEFAULT NULL,
  `monitor_time` datetime DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `campaign_id` varchar(8) DEFAULT NULL,
  KEY `user` (`user`),
  KEY `campaign_id` (`campaign_id`),
  KEY `monitor_time` (`monitor_time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_monitor_log`
--

LOCK TABLES `vicidial_monitor_log` WRITE;
/*!40000 ALTER TABLE `vicidial_monitor_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_monitor_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_music_on_hold`
--

DROP TABLE IF EXISTS `vicidial_music_on_hold`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_music_on_hold` (
  `moh_id` varchar(100) NOT NULL,
  `moh_name` varchar(255) DEFAULT NULL,
  `active` enum('Y','N') DEFAULT 'N',
  `random` enum('Y','N') DEFAULT 'N',
  `remove` enum('Y','N') DEFAULT 'N',
  `user_group` varchar(20) DEFAULT '---ALL---',
  PRIMARY KEY (`moh_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_music_on_hold`
--

LOCK TABLES `vicidial_music_on_hold` WRITE;
/*!40000 ALTER TABLE `vicidial_music_on_hold` DISABLE KEYS */;
INSERT INTO `vicidial_music_on_hold` VALUES ('default','Default Music On Hold','Y','N','N','---ALL---');
/*!40000 ALTER TABLE `vicidial_music_on_hold` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_music_on_hold_files`
--

DROP TABLE IF EXISTS `vicidial_music_on_hold_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_music_on_hold_files` (
  `filename` varchar(100) NOT NULL,
  `moh_id` varchar(100) NOT NULL,
  `rank` smallint(5) DEFAULT NULL,
  UNIQUE KEY `mohfile` (`filename`,`moh_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_music_on_hold_files`
--

LOCK TABLES `vicidial_music_on_hold_files` WRITE;
/*!40000 ALTER TABLE `vicidial_music_on_hold_files` DISABLE KEYS */;
INSERT INTO `vicidial_music_on_hold_files` VALUES ('conf','default',1);
/*!40000 ALTER TABLE `vicidial_music_on_hold_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_nanpa_filter_log`
--

DROP TABLE IF EXISTS `vicidial_nanpa_filter_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_nanpa_filter_log` (
  `output_code` varchar(30) NOT NULL,
  `status` varchar(20) DEFAULT 'BEGIN',
  `server_ip` varchar(15) DEFAULT '',
  `list_id` text,
  `start_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `user` varchar(20) DEFAULT '',
  `leads_count` bigint(14) DEFAULT '0',
  `filter_count` bigint(14) DEFAULT '0',
  `status_line` varchar(255) DEFAULT '',
  `script_output` text,
  PRIMARY KEY (`output_code`),
  KEY `start_time` (`start_time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_nanpa_filter_log`
--

LOCK TABLES `vicidial_nanpa_filter_log` WRITE;
/*!40000 ALTER TABLE `vicidial_nanpa_filter_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_nanpa_filter_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_nanpa_prefix_codes`
--

DROP TABLE IF EXISTS `vicidial_nanpa_prefix_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_nanpa_prefix_codes` (
  `areacode` char(3) DEFAULT NULL,
  `prefix` char(3) DEFAULT NULL,
  `GMT_offset` varchar(6) DEFAULT NULL,
  `DST` enum('Y','N') DEFAULT NULL,
  `latitude` varchar(17) DEFAULT NULL,
  `longitude` varchar(17) DEFAULT NULL,
  `city` varchar(50) DEFAULT '',
  `state` varchar(2) DEFAULT '',
  `postal_code` varchar(10) DEFAULT '',
  `country` varchar(2) DEFAULT '',
  `lata_type` varchar(1) DEFAULT '',
  KEY `areaprefix` (`areacode`,`prefix`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_nanpa_prefix_codes`
--

LOCK TABLES `vicidial_nanpa_prefix_codes` WRITE;
/*!40000 ALTER TABLE `vicidial_nanpa_prefix_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_nanpa_prefix_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_outbound_ivr_log`
--

DROP TABLE IF EXISTS `vicidial_outbound_ivr_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_outbound_ivr_log` (
  `uniqueid` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `caller_code` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `event_date` datetime DEFAULT NULL,
  `campaign_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `lead_id` int(9) unsigned DEFAULT NULL,
  `menu_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `menu_action` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  UNIQUE KEY `campserver` (`event_date`,`lead_id`,`menu_id`),
  KEY `event_date` (`event_date`),
  KEY `lead_id` (`lead_id`),
  KEY `campaign_id` (`campaign_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_outbound_ivr_log`
--

LOCK TABLES `vicidial_outbound_ivr_log` WRITE;
/*!40000 ALTER TABLE `vicidial_outbound_ivr_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_outbound_ivr_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_outbound_ivr_log_archive`
--

DROP TABLE IF EXISTS `vicidial_outbound_ivr_log_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_outbound_ivr_log_archive` (
  `uniqueid` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `caller_code` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `event_date` datetime DEFAULT NULL,
  `campaign_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `lead_id` int(9) unsigned DEFAULT NULL,
  `menu_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `menu_action` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  UNIQUE KEY `campserver` (`event_date`,`lead_id`,`menu_id`),
  KEY `event_date` (`event_date`),
  KEY `lead_id` (`lead_id`),
  KEY `campaign_id` (`campaign_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_outbound_ivr_log_archive`
--

LOCK TABLES `vicidial_outbound_ivr_log_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_outbound_ivr_log_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_outbound_ivr_log_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_override_ids`
--

DROP TABLE IF EXISTS `vicidial_override_ids`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_override_ids` (
  `id_table` varchar(50) NOT NULL,
  `active` enum('0','1') DEFAULT '0',
  `value` int(9) DEFAULT '0',
  PRIMARY KEY (`id_table`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_override_ids`
--

LOCK TABLES `vicidial_override_ids` WRITE;
/*!40000 ALTER TABLE `vicidial_override_ids` DISABLE KEYS */;
INSERT INTO `vicidial_override_ids` VALUES ('vicidial_users','0',1000),('vicidial_campaigns','0',20000),('vicidial_inbound_groups','0',30000),('vicidial_lists','0',40000),('vicidial_call_menu','0',50000),('vicidial_user_groups','0',60000),('vicidial_lead_filters','0',70000),('vicidial_scripts','0',80000),('phones','0',100);
/*!40000 ALTER TABLE `vicidial_override_ids` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_pause_codes`
--

DROP TABLE IF EXISTS `vicidial_pause_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_pause_codes` (
  `pause_code` varchar(6) NOT NULL,
  `pause_code_name` varchar(30) DEFAULT NULL,
  `billable` enum('NO','YES','HALF') DEFAULT 'NO',
  `campaign_id` varchar(8) DEFAULT NULL,
  `time_limit` smallint(5) unsigned DEFAULT '65000',
  `require_mgr_approval` enum('NO','YES') DEFAULT 'NO',
  KEY `campaign_id` (`campaign_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_pause_codes`
--

LOCK TABLES `vicidial_pause_codes` WRITE;
/*!40000 ALTER TABLE `vicidial_pause_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_pause_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_phone_codes`
--

DROP TABLE IF EXISTS `vicidial_phone_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_phone_codes` (
  `country_code` smallint(5) unsigned DEFAULT NULL,
  `country` char(3) DEFAULT NULL,
  `areacode` char(3) DEFAULT NULL,
  `state` varchar(4) DEFAULT NULL,
  `GMT_offset` varchar(6) DEFAULT '',
  `DST` enum('Y','N') DEFAULT NULL,
  `DST_range` varchar(8) DEFAULT NULL,
  `geographic_description` varchar(100) DEFAULT NULL,
  `tz_code` varchar(4) DEFAULT '',
  KEY `country_area_code` (`country_code`,`areacode`),
  KEY `country_state` (`country_code`,`state`),
  KEY `country_code` (`country_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_phone_codes`
--

LOCK TABLES `vicidial_phone_codes` WRITE;
/*!40000 ALTER TABLE `vicidial_phone_codes` DISABLE KEYS */;
INSERT INTO `vicidial_phone_codes` VALUES (1,'USA','201','NJ','-5','Y','SSM-FSN','New Jersey','EST'),(1,'USA','202','DC','-5','Y','SSM-FSN','District of Columbia','EST'),(1,'USA','203','CT','-5','Y','SSM-FSN','Connecticut','EST'),(1,'CAN','204','MB','-6','Y','SSM-FSN','Manitoba','CST'),(1,'USA','205','AL','-6','Y','SSM-FSN','Alabama','CST'),(1,'USA','206','WA','-8','Y','SSM-FSN','Washington','PST'),(1,'USA','207','ME','-5','Y','SSM-FSN','Maine','EST'),(1,'USA','208','ID','-7','Y','SSM-FSN','Idaho','MST'),(1,'USA','209','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','210','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'USA','212','NY','-5','Y','SSM-FSN','New York','EST'),(1,'USA','213','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','214','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'USA','215','PA','-5','Y','SSM-FSN','Pennsylvania','EST'),(1,'USA','216','OH','-5','Y','SSM-FSN','Ohio','EST'),(1,'USA','217','IL','-6','Y','SSM-FSN','Illinois','CST'),(1,'USA','218','MN','-6','Y','SSM-FSN','Minnesota','CST'),(1,'USA','219','IN','-6','Y','SSM-FSN','Indiana','CST'),(1,'USA','220','OH','-5','Y','SSM-FSN','Ohio','EST'),(1,'USA','223','PA','-5','Y','SSM-FSN','Pennsylvania','EST'),(1,'USA','224','IL','-6','Y','SSM-FSN','Illinois','CST'),(1,'USA','225','LA','-6','Y','SSM-FSN','Louisiana','CST'),(1,'CAN','226','ON','-5','Y','SSM-FSN','Ontario','EST'),(1,'USA','227','MD','-5','Y','SSM-FSN','Maryland','EST'),(1,'USA','228','MS','-6','Y','SSM-FSN','Mississippi','CST'),(1,'USA','229','GA','-5','Y','SSM-FSN','Georgia','EST'),(1,'USA','231','MI','-5','Y','SSM-FSN','Michigan','EST'),(1,'USA','234','OH','-5','Y','SSM-FSN','Ohio','EST'),(1,'CAN','236','BC','-8','Y','SSM-FSN','British Columbia','PST'),(1,'USA','239','FL','-5','Y','SSM-FSN','Florida','EST'),(1,'USA','240','MD','-5','Y','SSM-FSN','Maryland','EST'),(1,'BHS','242','','-5','Y','FSA-LSO','Bahamas','EST'),(1,'BRB','246','','-4','N','','Barbados','AST'),(1,'USA','248','MI','-5','Y','SSM-FSN','Michigan','EST'),(1,'CAN','249','ON','-5','Y','SSM-FSN','Ontario','EST'),(1,'CAN','250','BC','-8','Y','SSM-FSN','British Columbia','PST'),(1,'USA','251','AL','-6','Y','SSM-FSN','Alabama','CST'),(1,'USA','252','NC','-5','Y','SSM-FSN','North Carolina','EST'),(1,'USA','253','WA','-8','Y','SSM-FSN','Washington','PST'),(1,'USA','254','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'USA','256','AL','-6','Y','SSM-FSN','Alabama','CST'),(1,'USA','260','IN','-5','Y','SSM-FSN','Indiana','EST'),(1,'USA','262','WI','-6','Y','SSM-FSN','Wisconsin','CST'),(1,'AIA','264','','-4','N','','Anguilla','AST'),(1,'USA','267','PA','-5','Y','SSM-FSN','Pennsylvania','EST'),(1,'ATG','268','','-4','N','','Antigua and Barbuda','AST'),(1,'USA','269','MI','-5','Y','SSM-FSN','Michigan','EST'),(1,'USA','270','KY','-6','Y','SSM-FSN','Kentucky','CST'),(1,'USA','272','PA','-5','Y','SSM-FSN','Pennsylvania','EST'),(1,'USA','274','WI','-6','Y','SSM-FSN','Wisconsin','CST'),(1,'USA','276','VA','-5','Y','SSM-FSN','Virginia','EST'),(1,'USA','278','MI','-5','Y','SSM-FSN','Michigan','EST'),(1,'USA','279','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','280','MD','-5','Y','SSM-FSN','Maryland','EST'),(1,'USA','281','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'USA','282','IL','-6','Y','SSM-FSN','Illinois','CST'),(1,'USA','283','OH','-5','Y','SSM-FSN','Ohio','EST'),(1,'VGB','284','','-4','N','','British Virgin Islands','AST'),(1,'CAN','289','ON','-5','Y','SSM-FSN','Ontario','EST'),(1,'ABW','297','','-4','N','','Aruba','AST'),(1,'USA','301','MD','-5','Y','SSM-FSN','Maryland','EST'),(1,'USA','302','DE','-5','Y','SSM-FSN','Delaware','EST'),(1,'USA','303','CO','-7','Y','SSM-FSN','Colorado','MST'),(1,'USA','304','WV','-5','Y','SSM-FSN','West Virginia','EST'),(1,'USA','305','FL','-5','Y','SSM-FSN','Florida','EST'),(1,'CAN','306','SK','-6','N','','Saskatchewan','CST'),(1,'USA','307','WY','-7','Y','SSM-FSN','Wyoming','MST'),(1,'USA','308','NE','-6','Y','SSM-FSN','Nebraska','CST'),(1,'USA','309','IL','-6','Y','SSM-FSN','Illinois','CST'),(1,'USA','310','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','312','IL','-6','Y','SSM-FSN','Illinois','CST'),(1,'USA','313','MI','-5','Y','SSM-FSN','Michigan','EST'),(1,'USA','314','MO','-6','Y','SSM-FSN','Missouri','CST'),(1,'USA','315','NY','-5','Y','SSM-FSN','New York','EST'),(1,'USA','316','KS','-6','Y','SSM-FSN','Kansas','CST'),(1,'USA','317','IN','-5','Y','SSM-FSN','Indiana','EST'),(1,'USA','318','LA','-6','Y','SSM-FSN','Louisiana','CST'),(1,'USA','319','IA','-6','Y','SSM-FSN','Iowa','CST'),(1,'USA','320','MN','-6','Y','SSM-FSN','Minnesota','CST'),(1,'USA','321','FL','-5','Y','SSM-FSN','Florida','EST'),(1,'USA','323','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','325','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'USA','326','OH','-5','Y','SSM-FSN','Ohio','EST'),(1,'USA','327','AR','-6','Y','SSM-FSN','Arkansas','CST'),(1,'USA','330','OH','-5','Y','SSM-FSN','Ohio','EST'),(1,'USA','331','IL','-6','Y','SSM-FSN','Illinois','CST'),(1,'USA','332','NY','-5','Y','SSM-FSN','New York','EST'),(1,'USA','334','AL','-6','Y','SSM-FSN','Alabama','CST'),(1,'USA','336','NC','-5','Y','SSM-FSN','North Carolina','EST'),(1,'USA','337','LA','-6','Y','SSM-FSN','Louisiana','CST'),(1,'USA','339','MA','-5','Y','SSM-FSN','Massachusetts','EST'),(1,'VIR','340','','-4','N','','Virgin Islands','AST'),(1,'USA','341','CA','-8','Y','SSM-FSN','California','PST'),(1,'CAN','343','ON','-5','Y','SSM-FSN','Ontario','EST'),(1,'CYM','345','','-5','Y','FSA-LSO','Cayman Islands','EST'),(1,'USA','346','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'USA','347','NY','-5','Y','SSM-FSN','New York','EST'),(1,'USA','351','MA','-5','Y','SSM-FSN','Massachusetts','EST'),(1,'USA','352','FL','-5','Y','SSM-FSN','Florida','EST'),(1,'USA','358','PA','-5','Y','SSM-FSN','Pennsylvania','EST'),(1,'USA','360','WA','-8','Y','SSM-FSN','Washington','PST'),(1,'USA','361','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'USA','364','KY','-6','Y','SSM-FSN','Kentucky','CST'),(1,'CAN','365','ON','-5','Y','SSM-FSN','Ontario','EST'),(1,'CAN','367','QC','-5','Y','SSM-FSN','Quebec','EST'),(1,'USA','369','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','380','OH','-5','Y','SSM-FSN','Ohio','EST'),(1,'USA','385','UT','-7','Y','SSM-FSN','Utah','MST'),(1,'USA','386','FL','-5','Y','SSM-FSN','Florida','EST'),(1,'USA','401','RI','-5','Y','SSM-FSN','Rhode Island','EST'),(1,'USA','402','NE','-6','Y','SSM-FSN','Nebraska','CST'),(1,'CAN','403','AB','-7','Y','SSM-FSN','Alberta','MST'),(1,'USA','404','GA','-5','Y','SSM-FSN','Georgia','EST'),(1,'USA','405','OK','-6','Y','SSM-FSN','Oklahoma','CST'),(1,'USA','406','MT','-7','Y','SSM-FSN','Montana','MST'),(1,'USA','407','FL','-5','Y','SSM-FSN','Florida','EST'),(1,'USA','408','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','409','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'USA','410','MD','-5','Y','SSM-FSN','Maryland','EST'),(1,'USA','412','PA','-5','Y','SSM-FSN','Pennsylvania','EST'),(1,'USA','413','MA','-5','Y','SSM-FSN','Massachusetts','EST'),(1,'USA','414','WI','-6','Y','SSM-FSN','Wisconsin','CST'),(1,'USA','415','CA','-8','Y','SSM-FSN','California','PST'),(1,'CAN','416','ON','-5','Y','SSM-FSN','Ontario','EST'),(1,'USA','417','MO','-6','Y','SSM-FSN','Missouri','CST'),(1,'CAN','418','QC','-5','Y','SSM-FSN','Quebec','EST'),(1,'USA','419','OH','-5','Y','SSM-FSN','Ohio','EST'),(1,'USA','423','TN','-5','Y','SSM-FSN','Tennessee','EST'),(1,'USA','424','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','425','WA','-8','Y','SSM-FSN','Washington','PST'),(1,'USA','430','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'CAN','431','MB','-6','Y','SSM-FSN','Manitoba','CST'),(1,'USA','432','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'USA','434','VA','-5','Y','SSM-FSN','Virginia','EST'),(1,'USA','435','UT','-7','Y','SSM-FSN','Utah','MST'),(1,'CAN','437','ON','-5','Y','SSM-FSN','Ontario','EST'),(1,'CAN','438','QC','-5','Y','SSM-FSN','Quebec','EST'),(1,'USA','440','OH','-5','Y','SSM-FSN','Ohio','EST'),(1,'BMU','441','','-4','Y','FSA-LSO','Bermuda','AST'),(1,'USA','442','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','443','MD','-5','Y','SSM-FSN','Maryland','EST'),(1,'USA','445','PA','-5','Y','SSM-FSN','Pennsylvania','EST'),(1,'USA','447','IL','-6','Y','SSM-FSN','Illinois','CST'),(1,'CAN','450','QC','-5','Y','SSM-FSN','Quebec','EST'),(1,'USA','458','OR','-8','Y','SSM-FSN','Oregon','PST'),(1,'USA','463','IN','-5','Y','SSM-FSN','Indiana','EST'),(1,'USA','464','IL','-6','Y','SSM-FSN','Illinois','CST'),(1,'USA','469','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'USA','470','GA','-5','Y','SSM-FSN','Georgia','EST'),(1,'GRD','473','','-4','N','','Grenada','AST'),(1,'USA','475','CT','-5','Y','SSM-FSN','Connecticut','EST'),(1,'USA','478','GA','-5','Y','SSM-FSN','Georgia','EST'),(1,'USA','479','AR','-6','Y','SSM-FSN','Arkansas','CST'),(1,'USA','480','AZ','-7','N','','Arizona','MST'),(1,'USA','484','PA','-5','Y','SSM-FSN','Pennsylvania','EST'),(1,'USA','501','AR','-6','Y','SSM-FSN','Arkansas','CST'),(1,'USA','502','KY','-5','Y','SSM-FSN','Kentucky','EST'),(1,'USA','503','OR','-8','Y','SSM-FSN','Oregon','PST'),(1,'USA','504','LA','-6','Y','SSM-FSN','Louisiana','CST'),(1,'USA','505','NM','-7','Y','SSM-FSN','New Mexico','MST'),(1,'CAN','506','NB','-4','Y','SSM-FSN','New Brunswick','AST'),(1,'USA','507','MN','-6','Y','SSM-FSN','Minnesota','CST'),(1,'USA','508','MA','-5','Y','SSM-FSN','Massachusetts','EST'),(1,'USA','509','WA','-8','Y','SSM-FSN','Washington','PST'),(1,'USA','510','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','512','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'USA','513','OH','-5','Y','SSM-FSN','Ohio','EST'),(1,'CAN','514','QC','-5','Y','SSM-FSN','Quebec','EST'),(1,'USA','515','IA','-6','Y','SSM-FSN','Iowa','CST'),(1,'USA','516','NY','-5','Y','SSM-FSN','New York','EST'),(1,'USA','517','MI','-5','Y','SSM-FSN','Michigan','EST'),(1,'USA','518','NY','-5','Y','SSM-FSN','New York','EST'),(1,'CAN','519','ON','-5','Y','SSM-FSN','Ontario','EST'),(1,'USA','520','AZ','-7','N','','Arizona','MST'),(1,'USA','530','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','531','NE','-6','Y','SSM-FSN','Nebraska','CST'),(1,'USA','534','WI','-6','Y','SSM-FSN','Wisconsin','CST'),(1,'USA','539','OK','-6','Y','SSM-FSN','Oklahoma','CST'),(1,'USA','540','VA','-5','Y','SSM-FSN','Virginia','EST'),(1,'USA','541','OR','-8','Y','SSM-FSN','Oregon','PST'),(1,'USA','546','MI','-5','Y','SSM-FSN','Michigan','EST'),(1,'CAN','548','ON','-5','Y','SSM-FSN','Ontario','EST'),(1,'USA','551','NJ','-5','Y','SSM-FSN','New Jersey','EST'),(1,'USA','557','MO','-6','Y','SSM-FSN','Missouri','CST'),(1,'USA','559','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','561','FL','-5','Y','SSM-FSN','Florida','EST'),(1,'USA','562','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','563','IA','-6','Y','SSM-FSN','Iowa','CST'),(1,'USA','564','WA','-8','Y','SSM-FSN','Washington','PST'),(1,'USA','567','OH','-5','Y','SSM-FSN','Ohio','EST'),(1,'USA','570','PA','-5','Y','SSM-FSN','Pennsylvania','EST'),(1,'USA','571','VA','-5','Y','SSM-FSN','Virginia','EST'),(1,'USA','573','MO','-6','Y','SSM-FSN','Missouri','CST'),(1,'USA','574','IN','-5','Y','SSM-FSN','Indiana','EST'),(1,'USA','575','NM','-7','Y','SSM-FSN','New Mexico','MST'),(1,'CAN','579','QU','-5','Y','SSM-FSN','Quebec','EST'),(1,'USA','580','OK','-6','Y','SSM-FSN','Oklahoma','CST'),(1,'CAN','581','QC','-5','Y','SSM-FSN','Quebec','EST'),(1,'USA','582','PA','-5','Y','SSM-FSN','Pennsylvania','EST'),(1,'USA','585','NY','-5','Y','SSM-FSN','New York','EST'),(1,'USA','586','MI','-5','Y','SSM-FSN','Michigan','EST'),(1,'CAN','587','AB','-7','Y','SSM-FSN','Alberta','MST'),(1,'GLP','590','','-4','N','','Guadeloupe','AST'),(1,'MTQ','596','','-4','N','','Martinique','AST'),(1,'CUW','599','','-4','N','','Antilles','AST'),(1,'USA','601','MS','-6','Y','SSM-FSN','Mississippi','CST'),(1,'USA','602','AZ','-7','N','','Arizona','MST'),(1,'USA','603','NH','-5','Y','SSM-FSN','New Hampshire','EST'),(1,'CAN','604','BC','-8','Y','SSM-FSN','British Columbia','PST'),(1,'USA','605','SD','-6','Y','SSM-FSN','South Dakota','CST'),(1,'USA','606','KY','-5','Y','SSM-FSN','Kentucky','EST'),(1,'USA','607','NY','-5','Y','SSM-FSN','New York','EST'),(1,'USA','608','WI','-6','Y','SSM-FSN','Wisconsin','CST'),(1,'USA','609','NJ','-5','Y','SSM-FSN','New Jersey','EST'),(1,'USA','610','PA','-5','Y','SSM-FSN','Pennsylvania','EST'),(1,'USA','612','MN','-6','Y','SSM-FSN','Minnesota','CST'),(1,'CAN','613','ON','-5','Y','SSM-FSN','Ontario','EST'),(1,'USA','614','OH','-5','Y','SSM-FSN','Ohio','EST'),(1,'USA','615','TN','-6','Y','SSM-FSN','Tennessee','CST'),(1,'USA','616','MI','-5','Y','SSM-FSN','Michigan','EST'),(1,'USA','617','MA','-5','Y','SSM-FSN','Massachusetts','EST'),(1,'USA','618','IL','-6','Y','SSM-FSN','Illinois','CST'),(1,'USA','619','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','620','KS','-6','Y','SSM-FSN','Kansas','CST'),(1,'USA','623','AZ','-7','N','','Arizona','MST'),(1,'USA','626','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','627','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','628','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','629','TN','-6','Y','SSM-FSN','Tennessee','CST'),(1,'USA','630','IL','-6','Y','SSM-FSN','Illinois','CST'),(1,'USA','631','NY','-5','Y','SSM-FSN','New York','EST'),(1,'USA','636','MO','-6','Y','SSM-FSN','Missouri','CST'),(1,'CAN','639','SK','-6','N','','Saskatchewan','CST'),(1,'USA','640','NJ','-5','Y','SSM-FSN','New Jersey','EST'),(1,'USA','641','IA','-6','Y','SSM-FSN','Iowa','CST'),(1,'USA','646','NY','-5','Y','SSM-FSN','New York','EST'),(1,'CAN','647','ON','-5','Y','SSM-FSN','Ontario','EST'),(1,'TCA','649','','-5','Y','FSA-LSO','Turks Islands','EST'),(1,'USA','650','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','651','MN','-6','Y','SSM-FSN','Minnesota','CST'),(1,'USA','657','CA','-8','Y','SSM-FSN','California','PST'),(1,'JAM','658','','-5','N','','Jamaica','EST'),(1,'USA','659','AL','-6','Y','SSM-FSN','Alabama','CST'),(1,'USA','660','MO','-6','Y','SSM-FSN','Missouri','CST'),(1,'USA','661','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','662','MS','-6','Y','SSM-FSN','Mississippi','CST'),(1,'MSR','664','','-4','N','','Montserrat','AST'),(1,'USA','667','MD','-5','Y','SSM-FSN','Maryland','EST'),(1,'USA','669','CA','-8','Y','SSM-FSN','California','PST'),(1,'MNP','670','MP','+10','N','','Mariana Islands','ChST'),(1,'GUM','671','GU','+10','N','','Guam','GST'),(1,'CAN','672','BC','-8','Y','SSM-FSN','British Columbia','PST'),(1,'USA','678','GA','-5','Y','SSM-FSN','Georgia','EST'),(1,'USA','679','MI','-5','Y','SSM-FSN','Michigan','EST'),(1,'USA','680','NY','-5','Y','SSM-FSN','New York','EST'),(1,'USA','681','WV','-5','Y','SSM-FSN','West Virginia','EST'),(1,'USA','682','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'ASM','684','','-11','N','','American Samoa','SST'),(1,'USA','689','FL','-5','Y','SSM-FSN','Florida','EST'),(1,'USA','701','ND','-6','Y','SSM-FSN','North Dakota','CST'),(1,'USA','702','NV','-8','Y','SSM-FSN','Nevada','PST'),(1,'USA','703','VA','-5','Y','SSM-FSN','Virginia','EST'),(1,'USA','704','NC','-5','Y','SSM-FSN','North Carolina','EST'),(1,'CAN','705','ON','-5','Y','SSM-FSN','Ontario','EST'),(1,'USA','706','GA','-5','Y','SSM-FSN','Georgia','EST'),(1,'USA','707','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','708','IL','-6','Y','SSM-FSN','Illinois','CST'),(1,'CAN','709','NF','-3.5','Y','SSM-FSN','Newfoundland','NST'),(1,'USA','712','IA','-6','Y','SSM-FSN','Iowa','CST'),(1,'USA','713','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'USA','714','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','715','WI','-6','Y','SSM-FSN','Wisconsin','CST'),(1,'USA','716','NY','-5','Y','SSM-FSN','New York','EST'),(1,'USA','717','PA','-5','Y','SSM-FSN','Pennsylvania','EST'),(1,'USA','718','NY','-5','Y','SSM-FSN','New York','EST'),(1,'USA','719','CO','-7','Y','SSM-FSN','Colorado','MST'),(1,'USA','720','CO','-7','Y','SSM-FSN','Colorado','MST'),(1,'NLD','721','','-4','N','','St. Maarten','AST'),(1,'USA','724','PA','-5','Y','SSM-FSN','Pennsylvania','EST'),(1,'USA','725','NV','-8','Y','SSM-FSN','Nevada','PST'),(1,'USA','726','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'USA','727','FL','-5','Y','SSM-FSN','Florida','EST'),(1,'USA','730','IL','-6','Y','SSM-FSN','Illinois','CST'),(1,'USA','731','TN','-6','Y','SSM-FSN','Tennessee','CST'),(1,'USA','732','NJ','-5','Y','SSM-FSN','New Jersey','EST'),(1,'USA','734','MI','-5','Y','SSM-FSN','Michigan','EST'),(1,'USA','737','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'USA','740','OH','-5','Y','SSM-FSN','Ohio','EST'),(1,'CAN','742','ON','-5','Y','SSM-FSN','Ontario','EST'),(1,'USA','743','NC','-5','Y','SSM-FSN','North Carolina','EST'),(1,'USA','747','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','752','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','754','FL','-5','Y','SSM-FSN','Florida','EST'),(1,'USA','757','VA','-5','Y','SSM-FSN','Virginia','EST'),(1,'LCA','758','','-4','N','','St. Lucia','AST'),(1,'USA','760','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','762','GA','-5','Y','SSM-FSN','Georgia','EST'),(1,'USA','763','MN','-6','Y','SSM-FSN','Minnesota','CST'),(1,'USA','764','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','765','IN','-5','Y','SSM-FSN','Indiana','EST'),(1,'DMA','767','','-4','N','','Dominica','AST'),(1,'USA','769','MS','-6','Y','SSM-FSN','Mississippi','CST'),(1,'USA','770','GA','-5','Y','SSM-FSN','Georgia','EST'),(1,'USA','772','FL','-5','Y','SSM-FSN','Florida','EST'),(1,'USA','773','IL','-6','Y','SSM-FSN','Illinois','CST'),(1,'USA','774','MA','-5','Y','SSM-FSN','Massachusetts','EST'),(1,'USA','775','NV','-8','Y','SSM-FSN','Nevada','PST'),(1,'CAN','778','BC','-8','Y','SSM-FSN','British Columbia','PST'),(1,'USA','779','IL','-6','Y','SSM-FSN','Illinois','CST'),(1,'CAN','780','AB','-7','Y','SSM-FSN','Alberta','MST'),(1,'USA','781','MA','-5','Y','SSM-FSN','Massachusetts','EST'),(1,'CAN','782','NS','-4','Y','SSM-FSN','Nova Scotia','AST'),(1,'VCT','784','','-4','N','','St. Vincent','AST'),(1,'USA','785','KS','-6','Y','SSM-FSN','Kansas','CST'),(1,'USA','786','FL','-5','Y','SSM-FSN','Florida','EST'),(1,'PRI','787','PR','-4','N','','Puerto Rico','AST'),(1,'USA','801','UT','-7','Y','SSM-FSN','Utah','MST'),(1,'USA','802','VT','-5','Y','SSM-FSN','Vermont','EST'),(1,'USA','803','SC','-5','Y','SSM-FSN','South Carolina','EST'),(1,'USA','804','VA','-5','Y','SSM-FSN','Virginia','EST'),(1,'USA','805','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','806','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'CAN','807','ON','-5','Y','SSM-FSN','Ontario','EST'),(1,'USA','808','HI','-10','N','','Hawaii','HST'),(1,'DOM','809','','-4','N','','Dominican Republic','AST'),(1,'USA','810','MI','-5','Y','SSM-FSN','Michigan','EST'),(1,'USA','812','IN','-5','Y','SSM-FSN','Indiana','EST'),(1,'USA','813','FL','-5','Y','SSM-FSN','Florida','EST'),(1,'USA','814','PA','-5','Y','SSM-FSN','Pennsylvania','EST'),(1,'USA','815','IL','-6','Y','SSM-FSN','Illinois','CST'),(1,'USA','816','MO','-6','Y','SSM-FSN','Missouri','CST'),(1,'USA','817','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'USA','818','CA','-8','Y','SSM-FSN','California','PST'),(1,'CAN','819','QC','-5','Y','SSM-FSN','Quebec','EST'),(1,'USA','820','CA','-8','Y','SSM-FSN','California','PST'),(1,'CAN','825','AB','-7','Y','SSM-FSN','Alberta','MST'),(1,'USA','828','NC','-5','Y','SSM-FSN','North Carolina','EST'),(1,'DOM','829','','-4','N','','Dominican Republic','AST'),(1,'USA','830','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'USA','831','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','832','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'USA','835','PA','-5','Y','SSM-FSN','Pennsylvania','EST'),(1,'USA','838','NY','-5','Y','SSM-FSN','New York','EST'),(1,'USA','843','SC','-5','Y','SSM-FSN','South Carolina','EST'),(1,'USA','845','NY','-5','Y','SSM-FSN','New York','EST'),(1,'USA','847','IL','-6','Y','SSM-FSN','Illinois','CST'),(1,'USA','848','NJ','-5','Y','SSM-FSN','New Jersey','EST'),(1,'DOM','849','','-4','N','','Dominican Republic','AST'),(1,'USA','850','FL','-6','Y','SSM-FSN','Florida','CST'),(1,'USA','854','SC','-5','Y','SSM-FSN','South Carolina','EST'),(1,'USA','856','NJ','-5','Y','SSM-FSN','New Jersey','EST'),(1,'USA','857','MA','-5','Y','SSM-FSN','Massachusetts','EST'),(1,'USA','858','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','859','KY','-5','Y','SSM-FSN','Kentucky','EST'),(1,'USA','860','CT','-5','Y','SSM-FSN','Connecticut','EST'),(1,'USA','862','NJ','-5','Y','SSM-FSN','New Jersey','EST'),(1,'USA','863','FL','-5','Y','SSM-FSN','Florida','EST'),(1,'USA','864','SC','-5','Y','SSM-FSN','South Carolina','EST'),(1,'USA','865','TN','-5','Y','SSM-FSN','Tennessee','EST'),(1,'CAN','867','YT','-8','Y','SSM-FSN','Yukon','PST'),(1,'TTO','868','','-4','N','','Trinidad and Tobago','AST'),(1,'KNA','869','','-4','N','','St. Kitts and Nevis','AST'),(1,'USA','870','AR','-6','Y','SSM-FSN','Arkansas','CST'),(1,'USA','872','IL','-6','Y','SSM-FSN','Illinois','CST'),(1,'CAN','873','QC','-5','Y','SSM-FSN','Quebec','EST'),(1,'JAM','876','','-5','N','','Jamaica','EST'),(1,'USA','878','PA','-5','Y','SSM-FSN','Pennsylvania','EST'),(1,'CAN','879','NF','-3.5','Y','SSM-FSN','Newfoundland','NST'),(1,'USA','901','TN','-6','Y','SSM-FSN','Tennessee','CST'),(1,'CAN','902','NS','-4','Y','SSM-FSN','Nova Scotia','AST'),(1,'USA','903','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'USA','904','FL','-5','Y','SSM-FSN','Florida','EST'),(1,'CAN','905','ON','-5','Y','SSM-FSN','Ontario','EST'),(1,'USA','906','MI','-6','Y','SSM-FSN','Michigan','CST'),(1,'USA','907','AK','-9','Y','SSM-FSN','Alaska','AKST'),(1,'USA','908','NJ','-5','Y','SSM-FSN','New Jersey','EST'),(1,'USA','909','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','910','NC','-5','Y','SSM-FSN','North Carolina','EST'),(1,'USA','912','GA','-5','Y','SSM-FSN','Georgia','EST'),(1,'USA','913','KS','-6','Y','SSM-FSN','Kansas','CST'),(1,'USA','914','NY','-5','Y','SSM-FSN','New York','EST'),(1,'USA','915','TX','-7','Y','SSM-FSN','Texas','MST'),(1,'USA','916','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','917','NY','-5','Y','SSM-FSN','New York','EST'),(1,'USA','918','OK','-6','Y','SSM-FSN','Oklahoma','CST'),(1,'USA','919','NC','-5','Y','SSM-FSN','North Carolina','EST'),(1,'USA','920','WI','-6','Y','SSM-FSN','Wisconsin','CST'),(1,'USA','925','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','927','FL','-5','Y','SSM-FSN','Florida','EST'),(1,'USA','928','AZ','-7','N','','Arizona','MST'),(1,'USA','929','NY','-5','Y','SSM-FSN','New York','EST'),(1,'USA','930','IN','-5','Y','SSM-FSN','Indiana','EST'),(1,'USA','931','TN','-6','Y','SSM-FSN','Tennessee','CST'),(1,'USA','934','NY','-5','Y','SSM-FSN','New York','EST'),(1,'USA','935','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','936','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'USA','937','OH','-5','Y','SSM-FSN','Ohio','EST'),(1,'USA','938','AL','-6','Y','SSM-FSN','Alabama','CST'),(1,'USA','939','PR','-4','N','','Puerto Rico','AST'),(1,'USA','940','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'USA','941','FL','-5','Y','SSM-FSN','Florida','EST'),(1,'USA','947','MI','-5','Y','SSM-FSN','Michigan','EST'),(1,'USA','949','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','951','CA','-8','Y','SSM-FSN','California','PST'),(1,'USA','952','MN','-6','Y','SSM-FSN','Minnesota','CST'),(1,'USA','954','FL','-5','Y','SSM-FSN','Florida','EST'),(1,'USA','956','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'USA','957','NM','-7','Y','SSM-FSN','New Mexico','MST'),(1,'USA','959','CT','-5','Y','SSM-FSN','Connecticut','EST'),(1,'USA','970','CO','-7','Y','SSM-FSN','Colorado','MST'),(1,'USA','971','OR','-8','Y','SSM-FSN','Oregon','PST'),(1,'USA','972','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'USA','973','NJ','-5','Y','SSM-FSN','New Jersey','EST'),(1,'USA','975','MO','-6','Y','SSM-FSN','Missouri','CST'),(1,'USA','978','MA','-5','Y','SSM-FSN','Massachusetts','EST'),(1,'USA','979','TX','-6','Y','SSM-FSN','Texas','CST'),(1,'USA','980','NC','-5','Y','SSM-FSN','North Carolina','EST'),(1,'USA','984','NC','-5','Y','SSM-FSN','North Carolina','EST'),(1,'USA','985','LA','-6','Y','SSM-FSN','Louisiana','CST'),(1,'USA','986','ID','-7','Y','SSM-FSN','Idaho','MST'),(1,'USA','989','MI','-5','Y','SSM-FSN','Michigan','EST'),(7,'RUS','*','','+3','Y','LSM-LSO','Russia','MSK'),(7,'KAZ','*','','+6','N','','Kazakhstan','ALMT'),(7,'TJK','*','','+5','N','','Tajikistan','TJT'),(7,'TKM','*','','+5','N','','Turkmenistan','TMT'),(7,'KGZ','*','','+6','N','','Kyrgyzstan','KGT'),(20,'EGY','*','','+2','Y','LTA-LTS','Egypt','EET'),(27,'ZAF','*','','+2','N','','South Africa','SAST'),(30,'GRC','*','','+2','Y','LSM-LSO','Greece','EET'),(31,'NLD','*','','+1','Y','LSM-LSO','Netherlands Holland','CET'),(32,'BEL','*','','+1','Y','LSM-LSO','Belgium','CET'),(33,'FRA','*','','+1','Y','LSM-LSO','France','CET'),(34,'ESP','*','','+1','Y','LSM-LSO','Spain','CET'),(36,'HUN','*','','+1','Y','LSM-LSO','Hungary','CET'),(39,'ITA','*','','+1','Y','LSM-LSO','Italy','CET'),(39,'VAT','*','','+1','Y','LSM-LSO','Vatican City','CET'),(40,'ROU','*','','+2','Y','LSM-LSO','Romania','EET'),(41,'CHE','*','','+1','Y','LSM-LSO','Switzerland','CET'),(42,'CZE','*','','+1','Y','LSM-LSO','Czech Republic','CET'),(43,'AUT','*','','+1','Y','LSM-LSO','Austria','CET'),(44,'GBR','*','','0','Y','LSM-LSO','Great Britain United Kingdom','GMT'),(45,'DNK','*','','+1','Y','LSM-LSO','Denmark','CET'),(46,'SWE','*','','+1','Y','LSM-LSO','Sweden','CET'),(47,'NOR','*','','+1','Y','LSM-LSO','Norway','CET'),(48,'POL','*','','+1','Y','LSM-LSO','Poland','CET'),(49,'DEU','*','','+1','Y','LSM-LSO','Germany','CET'),(51,'PER','*','','-5','N','','Peru','PET'),(52,'MEX','222','','-6','Y','FSA-LSO','Puebla, Pue.','CST'),(52,'MEX','223','','-6','Y','FSA-LSO','Magdalena Tetela Morelos, La','CST'),(52,'MEX','224','','-6','Y','FSA-LSO','Almolonga Todos Santos jp','CST'),(52,'MEX','225','','-6','Y','FSA-LSO','Palmilla, Laakr','CST'),(52,'MEX','226','','-6','Y','FSA-LSO','Altotongar','CST'),(52,'MEX','227','','-6','Y','FSA-LSO','Huejotzingoq','CST'),(52,'MEX','228','','-6','Y','FSA-LSO','Jalapa, Ver.bze','CST'),(52,'MEX','229','','-6','Y','FSA-LSO','Veracruz, Ver.','CST'),(52,'MEX','231','','-6','Y','FSA-LSO','Aire Libre La Mina re','CST'),(52,'MEX','232','','-6','Y','FSA-LSO','Arroyo Del Potrero','CST'),(52,'MEX','233','','-6','Y','FSA-LSO','Ayotoxco De Guerrerok','CST'),(52,'MEX','235','','-6','Y','FSA-LSO','Arroyo Hondomxz','CST'),(52,'MEX','236','','-6','Y','FSA-LSO','Ajalpanuxh','CST'),(52,'MEX','237','','-6','Y','FSA-LSO','San Antonio Texcalapr','CST'),(52,'MEX','238','','-6','Y','FSA-LSO','Tehuacan','CST'),(52,'MEX','241','','-6','Y','FSA-LSO','Apizaco, Tlax.vae','CST'),(52,'MEX','243','','-6','Y','FSA-LSO','Ahuatlanrv','CST'),(52,'MEX','244','','-6','Y','FSA-LSO','Atlixco, Pue.u','CST'),(52,'MEX','245','','-6','Y','FSA-LSO','Atzitzintlam','CST'),(52,'MEX','246','','-6','Y','FSA-LSO','Tlaxcala, Tlax.','CST'),(52,'MEX','247','','-6','Y','FSA-LSO','Huamantlaia','CST'),(52,'MEX','248','','-6','Y','FSA-LSO','San Martin Texmelucan','CST'),(52,'MEX','249','','-6','Y','FSA-LSO','Acatzingo De Hidalgo','CST'),(52,'MEX','271','','-6','Y','FSA-LSO','Cordoba','CST'),(52,'MEX','272','','-6','Y','FSA-LSO','Orizaba, Ver.rb','CST'),(52,'MEX','273','','-6','Y','FSA-LSO','Boca Del Monte','CST'),(52,'MEX','274','','-6','Y','FSA-LSO','Acatlan De Perez Figueroaz','CST'),(52,'MEX','275','','-6','Y','FSA-LSO','Acaxtlahuacan De Albino Zertucheci','CST'),(52,'MEX','276','','-6','Y','FSA-LSO','Atlzayancanxj','CST'),(52,'MEX','278','','-6','Y','FSA-LSO','Capilla, Las','CST'),(52,'MEX','279','','-6','Y','FSA-LSO','Acatlanir','CST'),(52,'MEX','281','','-6','Y','FSA-LSO','Loma Bonitanyn','CST'),(52,'MEX','282','','-6','Y','FSA-LSO','Altos, Losrq','CST'),(52,'MEX','283','','-6','Y','FSA-LSO','Abasolo Del Valle','CST'),(52,'MEX','284','','-6','Y','FSA-LSO','Angel R. Cabadagyt','CST'),(52,'MEX','285','','-6','Y','FSA-LSO','Cocuite, Elnjr','CST'),(52,'MEX','287','','-6','Y','FSA-LSO','Benemerito Juarez Palo Gacho yhy','CST'),(52,'MEX','288','','-6','Y','FSA-LSO','Aculag','CST'),(52,'MEX','294','','-6','Y','FSA-LSO','Catemacosbw','CST'),(52,'MEX','296','','-6','Y','FSA-LSO','Antigua, La','CST'),(52,'MEX','297','','-6','Y','FSA-LSO','Alvarado','CST'),(52,'MEX','311','NAY','-7','Y','FSA-LSO','Tepic, Nay.big','MST'),(52,'MEX','312','','-6','Y','FSA-LSO','Colima, Col.n','CST'),(52,'MEX','313','','-6','Y','FSA-LSO','Augusto Gomez Villanueva Coalatilla','CST'),(52,'MEX','314','','-6','Y','FSA-LSO','Manzanillo, Col.jbq','CST'),(52,'MEX','315','','-6','Y','FSA-LSO','Barra De Navidadbe','CST'),(52,'MEX','316','','-6','Y','FSA-LSO','Ayutlagj','CST'),(52,'MEX','317','','-6','Y','FSA-LSO','Ahuacapanmrk','CST'),(52,'MEX','319','NAY','-7','Y','FSA-LSO','Boquita, Lamya','MST'),(52,'MEX','321','','-6','Y','FSA-LSO','Ayuquilaej','CST'),(52,'MEX','322','NAY','-7','Y','FSA-LSO','Puerto Vallarta, Jal.b','MST'),(52,'MEX','323','NAY','-7','Y','FSA-LSO','Amapartd','MST'),(52,'MEX','324','NAY','-7','Y','FSA-LSO','Ahuacatlanbm','MST'),(52,'MEX','325','NAY','-7','Y','FSA-LSO','Acaponetaeyw','MST'),(52,'MEX','326','','-6','Y','FSA-LSO','Atemajac De Brizuela','CST'),(52,'MEX','327','NAY','-7','Y','FSA-LSO','Amado Nervo El Conde','MST'),(52,'MEX','328','','-6','Y','FSA-LSO','Capulin, El','CST'),(52,'MEX','329','NAY','-7','Y','FSA-LSO','Buceriasq','MST'),(52,'MEX','330','','-6','Y','FSA-LSO','Guadalajara, Jal. y Zonas Conurbadastbh','CST'),(52,'MEX','331','','-6','Y','FSA-LSO','Guadalajara, Jal. y Zonas Conurbadastbh','CST'),(52,'MEX','332','','-6','Y','FSA-LSO','Guadalajara, Jal. y Zonas Conurbadastbh','CST'),(52,'MEX','333','','-6','Y','FSA-LSO','Guadalajara, Jal. y Zonas Conurbadastbh','CST'),(52,'MEX','334','','-6','Y','FSA-LSO','Guadalajara, Jal. y Zonas Conurbadastbh','CST'),(52,'MEX','335','','-6','Y','FSA-LSO','Guadalajara, Jal. y Zonas Conurbadastbh','CST'),(52,'MEX','336','','-6','Y','FSA-LSO','Guadalajara, Jal. y Zonas Conurbadastbh','CST'),(52,'MEX','337','','-6','Y','FSA-LSO','Guadalajara, Jal. y Zonas Conurbadastbh','CST'),(52,'MEX','338','','-6','Y','FSA-LSO','Guadalajara, Jal. y Zonas Conurbadastbh','CST'),(52,'MEX','339','','-6','Y','FSA-LSO','Guadalajara, Jal. y Zonas Conurbadastbh','CST'),(52,'MEX','341','','-6','Y','FSA-LSO','Ciudad Guzman','CST'),(52,'MEX','342','','-6','Y','FSA-LSO','Sayulaq','CST'),(52,'MEX','343','','-6','Y','FSA-LSO','Ejutla','CST'),(52,'MEX','344','','-6','Y','FSA-LSO','Huisquilcoq','CST'),(52,'MEX','345','','-6','Y','FSA-LSO','Ayotlankbe','CST'),(52,'MEX','346','','-6','Y','FSA-LSO','Apulco','CST'),(52,'MEX','347','','-6','Y','FSA-LSO','Mirandillasw','CST'),(52,'MEX','348','','-6','Y','FSA-LSO','Allende','CST'),(52,'MEX','349','','-6','Y','FSA-LSO','Atengo','CST'),(52,'MEX','351','','-6','Y','FSA-LSO','Zamora, Mich.','CST'),(52,'MEX','352','','-6','Y','FSA-LSO','La Piedad, Mich.bt','CST'),(52,'MEX','353','','-6','Y','FSA-LSO','Sahuayo, Mich.','CST'),(52,'MEX','354','','-6','Y','FSA-LSO','Atapanw','CST'),(52,'MEX','355','','-6','Y','FSA-LSO','Carapanipw','CST'),(52,'MEX','356','','-6','Y','FSA-LSO','Charcos, Losa','CST'),(52,'MEX','357','','-6','Y','FSA-LSO','Arado, Locx','CST'),(52,'MEX','358','','-6','Y','FSA-LSO','Garita, Lapb','CST'),(52,'MEX','359','','-6','Y','FSA-LSO','Guandarok','CST'),(52,'MEX','371','','-6','Y','FSA-LSO','Atenquiquex','CST'),(52,'MEX','372','','-6','Y','FSA-LSO','Amacueca','CST'),(52,'MEX','373','','-6','Y','FSA-LSO','Caqada De Las Floresf','CST'),(52,'MEX','374','','-6','Y','FSA-LSO','Amatitanmte','CST'),(52,'MEX','375','','-6','Y','FSA-LSO','Amecak','CST'),(52,'MEX','376','','-6','Y','FSA-LSO','Ajijiccc','CST'),(52,'MEX','377','','-6','Y','FSA-LSO','Coculav','CST'),(52,'MEX','378','','-6','Y','FSA-LSO','Tepatitlan, Jal.a','CST'),(52,'MEX','381','','-6','Y','FSA-LSO','Cojumatlan De Reguleshuj','CST'),(52,'MEX','382','','-6','Y','FSA-LSO','Mazamitla','CST'),(52,'MEX','383','','-6','Y','FSA-LSO','Chavindaiq','CST'),(52,'MEX','384','','-6','Y','FSA-LSO','Ahuisculco','CST'),(52,'MEX','385','','-6','Y','FSA-LSO','Buenavista','CST'),(52,'MEX','386','','-6','Y','FSA-LSO','Ahualulco De Mercadoryd','CST'),(52,'MEX','387','','-6','Y','FSA-LSO','Acatlan De Juarezgr','CST'),(52,'MEX','388','','-6','Y','FSA-LSO','Atenguillo','CST'),(52,'MEX','389','NAY','-7','Y','FSA-LSO','Milpas Viejasze','MST'),(52,'MEX','391','','-6','Y','FSA-LSO','Atotonilco El Altoak','CST'),(52,'MEX','392','','-6','Y','FSA-LSO','Ocotlan','CST'),(52,'MEX','393','','-6','Y','FSA-LSO','Barca, Lamu','CST'),(52,'MEX','394','','-6','Y','FSA-LSO','Barrio, Elmz','CST'),(52,'MEX','395','','-6','Y','FSA-LSO','San Diego De Alejandriae','CST'),(52,'MEX','411','','-6','Y','FSA-LSO','Calera, La El Canario','CST'),(52,'MEX','412','','-6','Y','FSA-LSO','Comonfortk','CST'),(52,'MEX','413','','-6','Y','FSA-LSO','Apaseo El Alto','CST'),(52,'MEX','414','','-6','Y','FSA-LSO','Fuente, Laepi','CST'),(52,'MEX','415','','-6','Y','FSA-LSO','San Miguel de Allende, Gto.y','CST'),(52,'MEX','417','','-6','Y','FSA-LSO','Acambarowyq','CST'),(52,'MEX','418','','-6','Y','FSA-LSO','Adjuntas Del Rio  Las Adjuntas aqe','CST'),(52,'MEX','419','','-6','Y','FSA-LSO','Ajuchitlandec','CST'),(52,'MEX','421','','-6','Y','FSA-LSO','Coroneor','CST'),(52,'MEX','422','','-6','Y','FSA-LSO','Ario De Rosales','CST'),(52,'MEX','423','','-6','Y','FSA-LSO','Ahuirany','CST'),(52,'MEX','424','','-6','Y','FSA-LSO','Bonifacio Moreno  El Aguaje','CST'),(52,'MEX','425','','-6','Y','FSA-LSO','Antunez  Morelos','CST'),(52,'MEX','426','','-6','Y','FSA-LSO','Aguilillaisx','CST'),(52,'MEX','427','','-6','Y','FSA-LSO','Polotitlan','CST'),(52,'MEX','428','','-6','Y','FSA-LSO','Carreton, Elnxf','CST'),(52,'MEX','429','','-6','Y','FSA-LSO','Abasoloazi','CST'),(52,'MEX','431','','-6','Y','FSA-LSO','Caqadas De Obregonc','CST'),(52,'MEX','432','','-6','Y','FSA-LSO','Calzada De La Merced, Lawxm','CST'),(52,'MEX','433','','-6','Y','FSA-LSO','Benito Juarezrun','CST'),(52,'MEX','434','','-6','Y','FSA-LSO','Acuitzio Del Canje','CST'),(52,'MEX','435','','-6','Y','FSA-LSO','Angao  Angao De Los Herrera','CST'),(52,'MEX','436','','-6','Y','FSA-LSO','Cantabriaz','CST'),(52,'MEX','437','','-6','Y','FSA-LSO','Atolinga','CST'),(52,'MEX','438','','-6','Y','FSA-LSO','Barranca, Layq','CST'),(52,'MEX','441','','-6','Y','FSA-LSO','Agua Zarcac','CST'),(52,'MEX','442','','-6','Y','FSA-LSO','Queretaro','CST'),(52,'MEX','443','','-6','Y','FSA-LSO','Morelia, Mich.q','CST'),(52,'MEX','444','','-6','Y','FSA-LSO','San Luis Potosi','CST'),(52,'MEX','445','','-6','Y','FSA-LSO','Moroleon','CST'),(52,'MEX','447','','-6','Y','FSA-LSO','Apeopwp','CST'),(52,'MEX','448','','-6','Y','FSA-LSO','Amealcoz','CST'),(52,'MEX','449','','-6','Y','FSA-LSO','Aguascalientes, Ags.n','CST'),(52,'MEX','451','','-6','Y','FSA-LSO','Araron','CST'),(52,'MEX','452','','-6','Y','FSA-LSO','Uruapan, Mich.d','CST'),(52,'MEX','453','','-6','Y','FSA-LSO','Apatzingan De La Constitucione','CST'),(52,'MEX','454','','-6','Y','FSA-LSO','Agua Caliente  Ojo De Agua','CST'),(52,'MEX','455','','-6','Y','FSA-LSO','Alvaro Obregonjrb','CST'),(52,'MEX','456','','-6','Y','FSA-LSO','Cerro Colorado','CST'),(52,'MEX','457','','-6','Y','FSA-LSO','Chalchihuites','CST'),(52,'MEX','458','','-6','Y','FSA-LSO','Barril, El','CST'),(52,'MEX','459','','-6','Y','FSA-LSO','Caracuaro De Morelos','CST'),(52,'MEX','461','','-6','Y','FSA-LSO','Celaya, Gto.xad','CST'),(52,'MEX','462','','-6','Y','FSA-LSO','Irapuato, Gto.hhm','CST'),(52,'MEX','463','','-6','Y','FSA-LSO','Huanuscoub','CST'),(52,'MEX','464','','-6','Y','FSA-LSO','Salamanca, Gto.ur','CST'),(52,'MEX','465','','-6','Y','FSA-LSO','Carbonerasz','CST'),(52,'MEX','466','','-6','Y','FSA-LSO','Cupareoyu','CST'),(52,'MEX','467','','-6','Y','FSA-LSO','Apozold','CST'),(52,'MEX','468','','-6','Y','FSA-LSO','Covadongathp','CST'),(52,'MEX','469','','-6','Y','FSA-LSO','Atarjea, Lawmc','CST'),(52,'MEX','471','','-6','Y','FSA-LSO','Acuitzeramow','CST'),(52,'MEX','472','','-6','Y','FSA-LSO','Aguas Buenast','CST'),(52,'MEX','473','','-6','Y','FSA-LSO','Guanajuato, Gto.u','CST'),(52,'MEX','474','','-6','Y','FSA-LSO','Lagos de Moreno, Jal.n','CST'),(52,'MEX','475','','-6','Y','FSA-LSO','Bajio De San Josegs','CST'),(52,'MEX','476','','-6','Y','FSA-LSO','Caqada De Negrosmzx','CST'),(52,'MEX','477','','-6','Y','FSA-LSO','Leon','CST'),(52,'MEX','478','','-6','Y','FSA-LSO','General Enrique Estrada','CST'),(52,'MEX','481','','-6','Y','FSA-LSO','Ciudad Valles, S.L.P.jn','CST'),(52,'MEX','482','','-6','Y','FSA-LSO','Agua Buenar','CST'),(52,'MEX','483','','-6','Y','FSA-LSO','Chalchocoyoqi','CST'),(52,'MEX','485','','-6','Y','FSA-LSO','Bledosejg','CST'),(52,'MEX','486','','-6','Y','FSA-LSO','Armadillo De Los Infanteh','CST'),(52,'MEX','487','','-6','Y','FSA-LSO','Arroyo Secomw','CST'),(52,'MEX','488','','-6','Y','FSA-LSO','Cedral','CST'),(52,'MEX','489','','-6','Y','FSA-LSO','Ahuacatlanchi','CST'),(52,'MEX','492','','-6','Y','FSA-LSO','Zacatecas, Zac.yk','CST'),(52,'MEX','493','','-6','Y','FSA-LSO','Fresnillo, Zac.','CST'),(52,'MEX','494','','-6','Y','FSA-LSO','Cargadero, Elcr','CST'),(52,'MEX','495','','-6','Y','FSA-LSO','Calvillo','CST'),(52,'MEX','496','','-6','Y','FSA-LSO','Amarillas De Esparza  Amarillas p','CST'),(52,'MEX','498','','-6','Y','FSA-LSO','Boquilla De Arriba','CST'),(52,'MEX','499','','-6','Y','FSA-LSO','Atitanacdp','CST'),(52,'MEX','550','','-6','Y','FSA-LSO','Ciudad de Mexico, D.F.','CST'),(52,'MEX','551','','-6','Y','FSA-LSO','Ciudad de Mexico, D.F.','CST'),(52,'MEX','552','','-6','Y','FSA-LSO','Ciudad de Mexico, D.F.','CST'),(52,'MEX','553','','-6','Y','FSA-LSO','Ciudad de Mexico, D.F.','CST'),(52,'MEX','554','','-6','Y','FSA-LSO','Ciudad de Mexico, D.F.','CST'),(52,'MEX','555','','-6','Y','FSA-LSO','Ciudad de Mexico, D.F.','CST'),(52,'MEX','556','','-6','Y','FSA-LSO','Ciudad de Mexico, D.F.','CST'),(52,'MEX','557','','-6','Y','FSA-LSO','Ciudad de Mexico, D.F.','CST'),(52,'MEX','558','','-6','Y','FSA-LSO','Ciudad de Mexico, D.F.','CST'),(52,'MEX','559','','-6','Y','FSA-LSO','Ciudad de Mexico, D.F.','CST'),(52,'MEX','588','','-6','Y','FSA-LSO','Arana, Los','CST'),(52,'MEX','591','','-6','Y','FSA-LSO','Praderas Del Potrero','CST'),(52,'MEX','592','','-6','Y','FSA-LSO','Jaltepec','CST'),(52,'MEX','593','','-6','Y','FSA-LSO','Coyotepec','CST'),(52,'MEX','594','','-6','Y','FSA-LSO','San Marcos Nepantla, Mex.khq','CST'),(52,'MEX','595','','-6','Y','FSA-LSO','Texcoco, Mex.edd','CST'),(52,'MEX','596','','-6','Y','FSA-LSO','Reyes Acozac, Losr','CST'),(52,'MEX','597','','-6','Y','FSA-LSO','Amecameca De Juarezkp','CST'),(52,'MEX','599','','-6','Y','FSA-LSO','Apaxco De Ocampoun','CST'),(52,'MEX','612','BCS','-7','Y','FSA-LSO','La Paz, B.C.S.fj','MST'),(52,'MEX','613','BCS','-7','Y','FSA-LSO','Ciudad Constituciona','MST'),(52,'MEX','614','CHIH','-7','Y','FSA-LSO','Chihuahua, Chih.ns','MST'),(52,'MEX','615','BCS','-7','Y','FSA-LSO','Bahia Asuncionnu','MST'),(52,'MEX','616','BC','-8','Y','FSA-LSO','Camalun','PST'),(52,'MEX','618','','-6','Y','FSA-LSO','Durango, Dgo.tkn','CST'),(52,'MEX','621','CHIH','-7','Y','FSA-LSO','Julimese','MST'),(52,'MEX','622','SON','-7','N','','Guaymas, Son.yw','MST'),(52,'MEX','623','SON','-7','N','','Aconchi','MST'),(52,'MEX','624','BCS','-7','Y','FSA-LSO','San Jose del Cabo','MST'),(52,'MEX','625','CHIH','-7','Y','FSA-LSO','Ciudad Cuauhtemoc','MST'),(52,'MEX','626','CHIH','-7','Y','FSA-LSO','Manuel Benavidesu','MST'),(52,'MEX','627','CHIH','-7','Y','FSA-LSO','Parral, Chih.','MST'),(52,'MEX','628','CHIH','-7','Y','FSA-LSO','Mariano Matamorosgjt','MST'),(52,'MEX','629','CHIH','-7','Y','FSA-LSO','Ceballoskp','MST'),(52,'MEX','631','SON','-7','N','','Nogales, Son.','MST'),(52,'MEX','632','SON','-7','N','','Imurisb','MST'),(52,'MEX','633','SON','-7','N','','Agua Prietag','MST'),(52,'MEX','634','SON','-7','N','','Abanico, Elt','MST'),(52,'MEX','635','CHIH','-7','Y','FSA-LSO','Areponapuchim','MST'),(52,'MEX','636','CHIH','-7','Y','FSA-LSO','Ascensionb','MST'),(52,'MEX','637','SON','-7','N','','Altar','MST'),(52,'MEX','638','SON','-7','N','','Choya, Latp','MST'),(52,'MEX','639','CHIH','-7','Y','FSA-LSO','Ciudad Delicias, Chih.mfj','MST'),(52,'MEX','641','SON','-7','N','','Benjamin Hillnde','MST'),(52,'MEX','642','SON','-7','N','','Navojoa, Son.ir','MST'),(52,'MEX','643','SON','-7','N','','Agua Blancawmi','MST'),(52,'MEX','644','SON','-7','N','','Ciudad Obregon','MST'),(52,'MEX','645','SON','-7','N','','Bacoachimcj','MST'),(52,'MEX','646','BC','-8','Y','FSA-LSO','Ensenada, B.C.tt','PST'),(52,'MEX','647','SON','-7','N','','Alamosk','MST'),(52,'MEX','648','CHIH','-7','Y','FSA-LSO','Boquilla De Babisas  La Boquilla De Conchos','MST'),(52,'MEX','649','CHIH','-7','Y','FSA-LSO','Baborigame','MST'),(52,'MEX','651','SON','-7','N','','Sonoitakhk','MST'),(52,'MEX','652','CHIH','-7','Y','FSA-LSO','Largo, El','MST'),(52,'MEX','653','SON','-7','N','','San Luis Rio Colorado','MST'),(52,'MEX','656','CHIH','-7','Y','FSA-LSO','Ciudad Juarez','MST'),(52,'MEX','658','BC','-8','Y','FSA-LSO','Ciudad Morelos  Cuervos t','PST'),(52,'MEX','659','CHIH','-7','Y','FSA-LSO','Abraham Gonzalez','MST'),(52,'MEX','661','BC','-8','Y','FSA-LSO','Playas De Rosarito','PST'),(52,'MEX','662','SON','-7','N','','Hermosillo, Son.vkv','MST'),(52,'MEX','664','BC','-8','Y','FSA-LSO','Tijuana, B.C.j','PST'),(52,'MEX','665','BC','-8','Y','FSA-LSO','Tecatese','PST'),(52,'MEX','667','SIN','-7','Y','FSA-LSO','Culiacan','MST'),(52,'MEX','668','SIN','-7','Y','FSA-LSO','Los Mochis, Sin.qx','MST'),(52,'MEX','669','SIN','-7','Y','FSA-LSO','Mazatlan','MST'),(52,'MEX','671','','-6','Y','FSA-LSO','Cuencame De Ceniceros  Cuencame ah','CST'),(52,'MEX','672','SIN','-7','Y','FSA-LSO','Altatajm','MST'),(52,'MEX','673','SIN','-7','Y','FSA-LSO','Benito Juareznv','MST'),(52,'MEX','674','','-6','Y','FSA-LSO','Canelas','CST'),(52,'MEX','675','','-6','Y','FSA-LSO','Cieneguilla','CST'),(52,'MEX','676','','-6','Y','FSA-LSO','Antonio Amaro  Saucillo hmj','CST'),(52,'MEX','677','','-6','Y','FSA-LSO','Abasolomvd','CST'),(52,'MEX','686','BC','-8','Y','FSA-LSO','Mexicali, B.C.','PST'),(52,'MEX','687','SIN','-7','Y','FSA-LSO','Adolfo Ruiz Cortinesqj','MST'),(52,'MEX','694','SIN','-7','Y','FSA-LSO','Agua Caliente De Garate  Agua Caliente k','MST'),(52,'MEX','695','SIN','-7','Y','FSA-LSO','Concha, La  La Concepcion w','MST'),(52,'MEX','696','SIN','-7','Y','FSA-LSO','Bolillo, Elg','MST'),(52,'MEX','697','SIN','-7','Y','FSA-LSO','Angosturay','MST'),(52,'MEX','698','SIN','-7','Y','FSA-LSO','Adolfo Lopez Mateos  Jahuara Segundo wfp','MST'),(52,'MEX','711','','-6','Y','FSA-LSO','Oro De Hidalgo, Elh','CST'),(52,'MEX','712','','-6','Y','FSA-LSO','Atlacomulco De Fabelahwk','CST'),(52,'MEX','713','','-6','Y','FSA-LSO','San Nicolas Tlazalah','CST'),(52,'MEX','714','','-6','Y','FSA-LSO','Chalma','CST'),(52,'MEX','715','','-6','Y','FSA-LSO','Heroica Zitacuaro','CST'),(52,'MEX','716','','-6','Y','FSA-LSO','Almoloya De Alquisiraswn','CST'),(52,'MEX','717','','-6','Y','FSA-LSO','Atlatlahucaffe','CST'),(52,'MEX','718','','-6','Y','FSA-LSO','Acambay','CST'),(52,'MEX','719','','-6','Y','FSA-LSO','Emiliano Zapata  Colonia Emiliano Zapata zv','CST'),(52,'MEX','721','','-6','Y','FSA-LSO','Ixtapan De La Salar','CST'),(52,'MEX','722','','-6','Y','FSA-LSO','Toluca, Mex.vg','CST'),(52,'MEX','723','','-6','Y','FSA-LSO','Chiltepec  Chiltepec De Hidalgo q','CST'),(52,'MEX','724','','-6','Y','FSA-LSO','Almoloya De Las Granadasy','CST'),(52,'MEX','725','','-6','Y','FSA-LSO','Cieneguillas De Guadalupeur','CST'),(52,'MEX','726','','-6','Y','FSA-LSO','Amanalco De Becerra','CST'),(52,'MEX','727','','-6','Y','FSA-LSO','Atenango Del Riobwn','CST'),(52,'MEX','728','','-6','Y','FSA-LSO','Lerma, Mex.puy','CST'),(52,'MEX','731','','-6','Y','FSA-LSO','Amayucaj','CST'),(52,'MEX','732','','-6','Y','FSA-LSO','Ajuchitlan Del Progresowq','CST'),(52,'MEX','733','','-6','Y','FSA-LSO','Mayanalan','CST'),(52,'MEX','734','','-6','Y','FSA-LSO','Zacatepec, Mor.j','CST'),(52,'MEX','735','','-6','Y','FSA-LSO','Cuautla, Mor.aum','CST'),(52,'MEX','736','','-6','Y','FSA-LSO','Acapetlahuayazu','CST'),(52,'MEX','737','','-6','Y','FSA-LSO','Coatetelcodbf','CST'),(52,'MEX','738','','-6','Y','FSA-LSO','Alfajayucan','CST'),(52,'MEX','739','','-6','Y','FSA-LSO','Amatlan De Quetzalcoatl','CST'),(52,'MEX','741','','-6','Y','FSA-LSO','Acatepecvc','CST'),(52,'MEX','742','','-6','Y','FSA-LSO','Atoyac De Alvarezr','CST'),(52,'MEX','743','','-6','Y','FSA-LSO','Acayucasj','CST'),(52,'MEX','744','','-6','Y','FSA-LSO','Acapulco, Gro.g','CST'),(52,'MEX','745','','-6','Y','FSA-LSO','Ayutla De Los Libresj','CST'),(52,'MEX','746','','-6','Y','FSA-LSO','Benito Juarezgha','CST'),(52,'MEX','747','','-6','Y','FSA-LSO','Chilpancingo, Gro.tp','CST'),(52,'MEX','748','','-6','Y','FSA-LSO','Almoloyag','CST'),(52,'MEX','749','','-6','Y','FSA-LSO','Calpulalpanp','CST'),(52,'MEX','751','','-6','Y','FSA-LSO','Ahuehuetzingoae','CST'),(52,'MEX','753','','-6','Y','FSA-LSO','Ciudad Lazaro Cardenas','CST'),(52,'MEX','754','','-6','Y','FSA-LSO','Apangoyy','CST'),(52,'MEX','755','','-6','Y','FSA-LSO','Zihuatanejo, Gro.','CST'),(52,'MEX','756','','-6','Y','FSA-LSO','Ahuacuotzingou','CST'),(52,'MEX','757','','-6','Y','FSA-LSO','Alcozauca De Guerreroswf','CST'),(52,'MEX','758','','-6','Y','FSA-LSO','Mesas, Lasuu','CST'),(52,'MEX','759','','-6','Y','FSA-LSO','Alberto, Elgi','CST'),(52,'MEX','761','','-6','Y','FSA-LSO','Bellavista Del Riokke','CST'),(52,'MEX','762','','-6','Y','FSA-LSO','Acamixtla','CST'),(52,'MEX','763','','-6','Y','FSA-LSO','Chapantongoqbn','CST'),(52,'MEX','764','','-6','Y','FSA-LSO','Nuevo Necaxaaze','CST'),(52,'MEX','765','','-6','Y','FSA-LSO','Alamosc','CST'),(52,'MEX','766','','-6','Y','FSA-LSO','Gutierrez Zamora','CST'),(52,'MEX','767','','-6','Y','FSA-LSO','Amuco De La Reformangv','CST'),(52,'MEX','768','','-6','Y','FSA-LSO','Amatlanctj','CST'),(52,'MEX','769','','-6','Y','FSA-LSO','Axochiapan','CST'),(52,'MEX','771','','-6','Y','FSA-LSO','Pachuca, Hgo.p','CST'),(52,'MEX','772','','-6','Y','FSA-LSO','Actopan','CST'),(52,'MEX','773','','-6','Y','FSA-LSO','Tepeji del Rio, Hgo.','CST'),(52,'MEX','774','','-6','Y','FSA-LSO','Agua Blanca Iturbide','CST'),(52,'MEX','775','','-6','Y','FSA-LSO','Singuilucan, Hgo.m','CST'),(52,'MEX','776','','-6','Y','FSA-LSO','Acaxochitlanr','CST'),(52,'MEX','777','','-6','Y','FSA-LSO','Cuernavaca, Mor.uq','CST'),(52,'MEX','778','','-6','Y','FSA-LSO','Ajacuba','CST'),(52,'MEX','779','','-6','Y','FSA-LSO','Plazas, Laswu','CST'),(52,'MEX','781','','-6','Y','FSA-LSO','Bajos Del Ejidovzi','CST'),(52,'MEX','782','','-6','Y','FSA-LSO','Poza Rica, Ver.','CST'),(52,'MEX','783','','-6','Y','FSA-LSO','Tuxpan, Ver.','CST'),(52,'MEX','784','','-6','Y','FSA-LSO','Adolfo Ruiz Cortinesvha','CST'),(52,'MEX','785','','-6','Y','FSA-LSO','Cerro Azulsc','CST'),(52,'MEX','786','','-6','Y','FSA-LSO','Agostitlanzrp','CST'),(52,'MEX','789','','-6','Y','FSA-LSO','Atlapexcouk','CST'),(52,'MEX','791','','-6','Y','FSA-LSO','Cides, Losfyu','CST'),(52,'MEX','797','','-6','Y','FSA-LSO','Ahuacatlan','CST'),(52,'MEX','810','','-6','Y','FSA-LSO','Monterrey, N.L. y Zonas Conurbadas','CST'),(52,'MEX','811','','-6','Y','FSA-LSO','Monterrey, N.L. y Zonas Conurbadas','CST'),(52,'MEX','812','','-6','Y','FSA-LSO','Monterrey, N.L. y Zonas Conurbadas','CST'),(52,'MEX','813','','-6','Y','FSA-LSO','Monterrey, N.L. y Zonas Conurbadas','CST'),(52,'MEX','814','','-6','Y','FSA-LSO','Monterrey, N.L. y Zonas Conurbadas','CST'),(52,'MEX','815','','-6','Y','FSA-LSO','Monterrey, N.L. y Zonas Conurbadas','CST'),(52,'MEX','816','','-6','Y','FSA-LSO','Monterrey, N.L. y Zonas Conurbadas','CST'),(52,'MEX','817','','-6','Y','FSA-LSO','Monterrey, N.L. y Zonas Conurbadas','CST'),(52,'MEX','818','','-6','Y','FSA-LSO','Monterrey, N.L. y Zonas Conurbadas','CST'),(52,'MEX','819','','-6','Y','FSA-LSO','Monterrey, N.L. y Zonas Conurbadas','CST'),(52,'MEX','821','','-6','Y','FSA-LSO','Guadalupe  Hacienda De Guadalupe, La ywx','CST'),(52,'MEX','823','','-6','Y','FSA-LSO','Chinaen','CST'),(52,'MEX','824','','-6','Y','FSA-LSO','Ciudad Sabinas Hidalgohp','CST'),(52,'MEX','825','','-6','Y','FSA-LSO','Cienega De Florespqs','CST'),(52,'MEX','826','','-6','Y','FSA-LSO','Aramberri','CST'),(52,'MEX','828','','-6','Y','FSA-LSO','Barranquito, Elq','CST'),(52,'MEX','829','','-6','Y','FSA-LSO','Bustamantes','CST'),(52,'MEX','831','','-6','Y','FSA-LSO','Ciudad Mante, Tamps.q','CST'),(52,'MEX','832','','-6','Y','FSA-LSO','Adolfo Lopez Mateos  Chamal Nuevo','CST'),(52,'MEX','833','','-6','Y','FSA-LSO','Tampico, Tamps.n','CST'),(52,'MEX','834','','-6','Y','FSA-LSO','Ciudad Victoria, Tamps.','CST'),(52,'MEX','835','','-6','Y','FSA-LSO','Abasology','CST'),(52,'MEX','836','','-6','Y','FSA-LSO','Aldamah','CST'),(52,'MEX','841','','-6','Y','FSA-LSO','Burgosaue','CST'),(52,'MEX','842','','-6','Y','FSA-LSO','Concepcion Del Oror','CST'),(52,'MEX','844','','-6','Y','FSA-LSO','Saltillo, Coah.p','CST'),(52,'MEX','845','','-6','Y','FSA-LSO','Ebanopf','CST'),(52,'MEX','846','','-6','Y','FSA-LSO','Chijol 17ry','CST'),(52,'MEX','861','','-6','Y','FSA-LSO','Sabinas, Coah.j','CST'),(52,'MEX','862','','-6','Y','FSA-LSO','Allendeby','CST'),(52,'MEX','864','','-6','Y','FSA-LSO','Ciudad Melchor Muzquiztzc','CST'),(52,'MEX','866','','-6','Y','FSA-LSO','Monclova, Coah.','CST'),(52,'MEX','867','','-6','Y','FSA-LSO','Nuevo Laredo, Tamps.ef','CST'),(52,'MEX','868','','-6','Y','FSA-LSO','Matamoros, Tamps.yjv','CST'),(52,'MEX','869','','-6','Y','FSA-LSO','Cuatrocienegas De Carranzaabw','CST'),(52,'MEX','871','','-6','Y','FSA-LSO','Torreon','CST'),(52,'MEX','872','','-6','Y','FSA-LSO','Bermejillo','CST'),(52,'MEX','873','','-6','Y','FSA-LSO','Anahuacrvg','CST'),(52,'MEX','877','','-6','Y','FSA-LSO','Ciudad Acuqaepb','CST'),(52,'MEX','878','','-6','Y','FSA-LSO','Jimenez','CST'),(52,'MEX','891','','-6','Y','FSA-LSO','Ciudad Camargo','CST'),(52,'MEX','892','','-6','Y','FSA-LSO','Agualeguasmg','CST'),(52,'MEX','894','','-6','Y','FSA-LSO','Anahuacsr','CST'),(52,'MEX','897','','-6','Y','FSA-LSO','Arcabuzsmf','CST'),(52,'MEX','899','','-6','Y','FSA-LSO','Reynosa, Tamps.','CST'),(52,'MEX','913','','-6','Y','FSA-LSO','Cuauhtemocg','CST'),(52,'MEX','914','','-6','Y','FSA-LSO','Ayapaqi','CST'),(52,'MEX','916','','-6','Y','FSA-LSO','Catazajatkr','CST'),(52,'MEX','917','','-6','Y','FSA-LSO','Chontalpa  Estacion Chontalpa s','CST'),(52,'MEX','918','','-6','Y','FSA-LSO','Acacoyagua','CST'),(52,'MEX','919','','-6','Y','FSA-LSO','Altamirano','CST'),(52,'MEX','921','','-6','Y','FSA-LSO','Coatzacoalcos, Ver.wer','CST'),(52,'MEX','922','','-6','Y','FSA-LSO','Chinameca, Ver.ewa','CST'),(52,'MEX','923','','-6','Y','FSA-LSO','Agua Dulcen','CST'),(52,'MEX','924','','-6','Y','FSA-LSO','24 De Febrerow','CST'),(52,'MEX','932','','-6','Y','FSA-LSO','Ixtacomitanrid','CST'),(52,'MEX','933','','-6','Y','FSA-LSO','Carlos Greene 1 Ra. Secciongep','CST'),(52,'MEX','934','','-6','Y','FSA-LSO','Arena De Hidalgoe','CST'),(52,'MEX','936','','-6','Y','FSA-LSO','Benito Juarez  San Carlos cfp','CST'),(52,'MEX','937','','-6','Y','FSA-LSO','Cardenas','CST'),(52,'MEX','938','','-6','Y','FSA-LSO','Ciudad del Carmen, Camp.','CST'),(52,'MEX','951','','-6','Y','FSA-LSO','Oaxaca, Oax.p','CST'),(52,'MEX','953','','-6','Y','FSA-LSO','Acatlan De Osoriotsb','CST'),(52,'MEX','954','','-6','Y','FSA-LSO','Bajos De Chilad','CST'),(52,'MEX','958','','-6','Y','FSA-LSO','Candelaria Loxichab','CST'),(52,'MEX','961','','-6','Y','FSA-LSO','Tuxtla Gutierrez','CST'),(52,'MEX','962','','-6','Y','FSA-LSO','Tapachula, Chis.uid','CST'),(52,'MEX','963','','-6','Y','FSA-LSO','Chicomuselopj','CST'),(52,'MEX','964','','-6','Y','FSA-LSO','Buenos Airesuwv','CST'),(52,'MEX','965','','-6','Y','FSA-LSO','Cristobal Obregonhd','CST'),(52,'MEX','966','','-6','Y','FSA-LSO','Arriagaeiy','CST'),(52,'MEX','967','','-6','Y','FSA-LSO','Candelaria, Laq','CST'),(52,'MEX','968','','-6','Y','FSA-LSO','Cintalapa De Figueroack','CST'),(52,'MEX','969','','-6','Y','FSA-LSO','Campestre Flamboyanesref','CST'),(52,'MEX','971','','-6','Y','FSA-LSO','Ixtepec, Oax.f','CST'),(52,'MEX','972','','-6','Y','FSA-LSO','Barrio De La Soledad, El','CST'),(52,'MEX','981','','-6','Y','FSA-LSO','Campeche, Camp.g','CST'),(52,'MEX','982','','-6','Y','FSA-LSO','Candelaria','CST'),(52,'MEX','983','','-6','Y','FSA-LSO','Chetumal, Q.Rooqzh','CST'),(52,'MEX','984','','-6','Y','FSA-LSO','Akumalb','CST'),(52,'MEX','985','','-6','Y','FSA-LSO','Chemaxj','CST'),(52,'MEX','986','','-6','Y','FSA-LSO','Colonia Yucatane','CST'),(52,'MEX','987','','-6','Y','FSA-LSO','Cozumelxmg','CST'),(52,'MEX','988','','-6','Y','FSA-LSO','Acanceh','CST'),(52,'MEX','991','','-6','Y','FSA-LSO','Bacaic','CST'),(52,'MEX','992','','-6','Y','FSA-LSO','Benito Juarezwvz','CST'),(52,'MEX','993','','-6','Y','FSA-LSO','Villahermosa, Tab.d','CST'),(52,'MEX','994','','-6','Y','FSA-LSO','Cabeza De Torog','CST'),(52,'MEX','995','','-6','Y','FSA-LSO','Camaron, El','CST'),(52,'MEX','996','','-6','Y','FSA-LSO','Becalcu','CST'),(52,'MEX','997','','-6','Y','FSA-LSO','Akilm','CST'),(52,'MEX','998','','-6','Y','FSA-LSO','Cancun','CST'),(52,'MEX','999','','-6','Y','FSA-LSO','Merida','CST'),(53,'CUB','*','','-5','N','','Cuba','EST'),(54,'ARG','*','','-3','N','','Argentina','ART'),(55,'BRA','*','','-3','Y','TSO-LSF','Brazil','BRT'),(56,'CHL','*','','-4','Y','SSO-SSM','Chile','CLT'),(57,'COL','*','','-5','N','','Columbia','COT'),(58,'VEN','*','','-4','N','','Venezuela','VET'),(60,'MYS','*','','+8','N','','Malaysia','MYT'),(61,'AUS','2','NS','+10','Y','FSO-FSA','New South Wales & Capitol','AEST'),(61,'AUS','3','VI','+10','Y','FSO-FSA','Victoria','AEST'),(61,'AUS','5','','+10','Y','FSO-FSA','Prefix 5 nonexistant','AEST'),(61,'AUS','7','QL','+10','N','','Queensland','AEST'),(61,'AUS','36','TA','+10','Y','FSO-FSA','Tasmania','AEST'),(61,'AUS','80','SA','+9.5','Y','FSO-FSA','Southern Australia','ACST'),(61,'AUS','81','SA','+9.5','Y','FSO-FSA','Southern Australia','ACST'),(61,'AUS','82','WA','+8','N','','Western Australia','AWST'),(61,'AUS','83','SA','+9.5','Y','FSO-FSA','Southern Australia','ACST'),(61,'AUS','84','WA','+8','N','','Western Australia','AWST'),(61,'AUS','85','SA','+9.5','Y','FSO-FSA','Southern Australia','ACST'),(61,'AUS','86','WA','+8','N','','Western Australia','AWST'),(61,'AUS','88','SA','+9.5','Y','FSO-FSA','Southern Australia','ACST'),(61,'AUS','89','WA','+8','N','','Western Australia','AWST'),(61,'AUS','889','NT','+9.5','N','','Northern Territory','ACST'),(61,'AUS','4S','WA','+8','N','','Mobile numbers Western Australia','AWST'),(61,'AUS','4S','NT','+9.5','N','','Mobile numbers Northern Territory','ACST'),(61,'AUS','4S','SA','+9.5','Y','FSO-FSA','Mobile numbers South Australia','ACST'),(61,'AUS','4S','TA','+10','Y','FSO-FSA','Mobile numbers Tasmania','AEST'),(61,'AUS','4S','AC','+10','Y','FSO-FSA','Mobile numbers Capitol','AEST'),(61,'AUS','4S','NS','+10','Y','FSO-FSA','Mobile numbers New South Wales','AEST'),(61,'AUS','4S','','+10','Y','FSO-FSA','Mobile numbers No State Given','AEST'),(61,'AUS','4S','QL','+10','N','','Mobile numbers Queensland','AEST'),(61,'AUS','4S','VI','+10','Y','FSO-FSA','Mobile numbers Victoria','AEST'),(62,'IDN','*','','+7','N','','Indonesia','WIB'),(63,'PHL','*','','+8','N','','Philippines','PHT'),(64,'NZL','*','','+12','Y','FSO-TSM','New Zealand','NZST'),(65,'SGP','*','','+8','N','','Singapore','SGT'),(66,'THA','*','','+7','N','','Thailand','ICT'),(81,'JPN','*','','+9','N','','Japan','JST'),(82,'KOR','*','','+9','N','','Korea  South','KST'),(84,'VNM','*','','+7','N','','Vietnam','ICT'),(86,'CHN','*','','+8','N','','China','CST'),(90,'TUR','*','','+2','Y','LSM-LSO','Turkey','EET'),(91,'IND','*','','+5.5','N','','India','IST'),(92,'PAK','*','','+5','N','','Pakistan','PKT'),(93,'AFG','*','','+4.5','N','','Afghanistan','AFT'),(94,'LKA','*','','+5.5','N','','Sri Lanka','IST'),(95,'MMR','*','','+6.5','N','','Myanmar Burma','MMT'),(98,'IRN','*','','+3.5','N','','Iran','IRST'),(211,'SSD','*','','+3','N','','South Sudan','EAT'),(212,'MAR','*','','0','N','','Morocco','WET'),(213,'DZA','*','','+1','N','','Algeria','CET'),(216,'TUN','*','','+1','N','','Tunisia','CET'),(218,'LBY','*','','+1','N','','Libya','CET'),(220,'GMB','*','','0','N','','Gambia','GMT'),(221,'SEN','*','','0','N','','Senegal','GMT'),(222,'MRT','*','','0','N','','Mauritania','GMT'),(223,'MLI','*','','0','N','','Mali','GMT'),(224,'GIN','*','','0','N','','Guinea','GMT'),(225,'CIV','*','','0','N','','Cote d Ivorie Ivory Coast','GMT'),(226,'BFA','*','','0','N','','Bukina Faso','GMT'),(227,'NER','*','','+1','N','','Niger Republic','WAT'),(228,'TGO','*','','0','N','','Togo','GMT'),(229,'BEN','*','','+1','N','','Benin','WAT'),(230,'MUS','*','','+4','N','','Mauritius','MUT'),(231,'LBR','*','','0','N','','Liberia','GMT'),(232,'SLE','*','','0','N','','Sierra Leone','GMT'),(233,'GHA','*','','0','N','','Ghana','GMT'),(234,'NGA','*','','+1','N','','Nigeria','WAT'),(235,'TCD','*','','+1','N','','Chad','WAT'),(236,'CAF','*','','+1','N','','Central African Republic','WAT'),(237,'CMR','*','','+1','N','','Cameroon','WAT'),(238,'CPV','*','','-1','N','','Cape Verde Islands','CVT'),(239,'STP','*','','0','N','','Sao Tome and Principe','GMT'),(240,'GNQ','*','','+1','N','','Equatorial Guinea','WAT'),(241,'GAB','*','','+1','N','','Gabon','WAT'),(242,'COG','*','','+1','N','','Congo','WAT'),(243,'COD','*','','+1','N','','Zaire Congo','WAT'),(244,'AGO','*','','+1','N','','Angola','WAT'),(245,'GNB','*','','0','N','','Guinea - Bissau','GMT'),(246,'IOT','*','','+6','N','','British Indian Ocean Territory','BST'),(247,'ASC','*','','0','N','','Ascension Island','GMT'),(248,'SYC','*','','+4','N','','Seychelles','SCT'),(249,'SDN','*','','+3','N','','Sudan','EAT'),(250,'RWA','*','','+2','N','','Rwanda','CAT'),(251,'ETH','*','','+3','N','','Ethiopia','EAT'),(252,'SOM','*','','+3','N','','Somalia','EAT'),(253,'DJI','*','','+3','N','','Djibouti','EAT'),(254,'KEN','*','','+3','N','','Kenya','EAT'),(255,'TZA','*','','+3','N','','Tanzania','EAT'),(256,'UGA','*','','+3','N','','Uganda','EAT'),(257,'BDI','*','','+2','N','','Burundi','CAT'),(258,'MOZ','*','','+2','N','','Mozambique','CAT'),(260,'ZMB','*','','+2','N','','Zambia','CAT'),(261,'MDG','*','','+3','N','','Madagascar','EAT'),(262,'MYT','*','','+3','N','','Reunion and Mayotte','EAT'),(263,'ZWE','*','','+2','N','','Zimbabwe','CAT'),(264,'NAM','*','','+2','Y','FSS-FSA','Namibia','CAT'),(265,'MWI','*','','+2','N','','Malawi','CAT'),(266,'LSO','*','','+2','N','','Lesotho','CAT'),(267,'BWA','*','','+2','N','','Botswana','CAT'),(268,'SWZ','*','','+2','N','','Swaziland','CAT'),(269,'COM','*','','+3','N','','Comoros','EAT'),(290,'SHN','*','','0','N','','St Helena','GMT'),(291,'ERI','*','','+3','N','','Eritrea','EAT'),(297,'ABW','*','','-4','N','','Aruba','AST'),(298,'FRO','*','','0','N','','Faroe Islands','GMT'),(299,'GRL','*','','-1','Y','LSM-LSO','Greenland','EGT'),(349,'ESP','*','','+1','Y','LSM-LSO','Spain','CET'),(350,'GIB','*','','+1','Y','LSM-LSO','Gibraltar','CET'),(351,'PRT','*','','0','Y','LSM-LSO','Portugal','WET'),(352,'LUX','*','','+1','Y','LSM-LSO','Luxembourg','CET'),(353,'IRL','*','','0','Y','LSM-LSO','Ireland','IST'),(354,'ISL','*','','0','N','','Iceland','GMT'),(355,'ALB','*','','+1','Y','LSM-LSO','Albania','CET'),(356,'MLT','*','','+1','Y','LSM-LSO','Malta','CET'),(357,'CYP','*','','+2','Y','LSM-LSO','Cyprus','EET'),(358,'FIN','*','','+2','Y','LSM-LSO','Finland','EET'),(359,'BGR','*','','+2','Y','LSM-LSO','Bulgaria','EET'),(370,'LTU','*','','+2','Y','LSM-LSO','Lithuania','EET'),(371,'LVA','*','','+2','Y','LSM-LSO','Latvia','EET'),(372,'EST','*','','+2','Y','LSM-LSO','Estonia','EET'),(373,'MDA','*','','+2','Y','LSM-LSO','Moldovia','EET'),(374,'ARM','*','','+4','Y','LSM-LSO','Armenia','AMT'),(375,'BLR','*','','+2','Y','LSM-LSO','Belarus','EET'),(376,'AND','*','','+1','Y','LSM-LSO','Andorra','CET'),(377,'MCO','*','','+1','Y','LSM-LSO','Monaco','CET'),(378,'SMR','*','','+1','Y','LSM-LSO','San Marino','CET'),(379,'VAT','*','','+1','Y','LSM-LSO','Vatican City State','CET'),(380,'UKR','*','','+2','Y','LSM-LSO','Ukraine','EET'),(381,'SRB','*','','+1','Y','LSM-LSO','Serbia','CET'),(382,'MNE','*','','+1','Y','LSM-LSO','Montenegro','CET'),(383,'XKX','*','','+1','Y','LSM-LSO','Kosovo','CET'),(385,'HRV','*','','+1','Y','LSM-LSO','Croatia','CET'),(386,'SVN','*','','+1','Y','LSM-LSO','Slovenia','CET'),(387,'BIH','*','','+1','Y','LSM-LSO','Bosnia Hercegovina','CET'),(389,'MKD','*','','+1','Y','LSM-LSO','Macedonia','CET'),(420,'CZE','*','','+1','Y','LSM-LSO','Czech Republic','CET'),(421,'SVK','*','','+1','Y','LSM-LSO','Slovakia','CET'),(423,'LIE','*','','+1','Y','LSM-LSO','Lichtenstein','CET'),(500,'FLK','*','','-4','Y','FSS-TSA','Falkland Islands','FKT'),(501,'BLZ','*','','-6','N','','Belize','CST'),(502,'GTM','*','','-6','N','','Guatemala','CST'),(503,'SLV','*','','-6','N','','El Salvador','CST'),(504,'HND','*','','-6','N','','Honduras','CST'),(505,'NIC','*','','-6','N','','Nicaragua','CST'),(506,'CRI','*','','-6','N','','Costa Rica','CST'),(507,'PAN','*','','-5','N','','Panama','EST'),(508,'SPM','*','','-3','Y','SSM-FSN','Saint Pierre and Miquelon','PMST'),(509,'HTI','*','','-5','N','','Haiti','EST'),(590,'GLP','*','','-4','N','','Guadeloupe','AST'),(591,'BOL','*','','-4','N','','Bolivia','BOT'),(592,'GUY','*','','-4','N','','Guyana','AST'),(593,'ECU','*','','-5','N','','Ecuador','ECT'),(594,'GUF','*','','-3','N','','French Guiana','GFT'),(595,'PRY','*','','-4','Y','SSO-SSM','Paraguay','PYT'),(596,'MTQ','*','','-4','N','','Martinique','AST'),(597,'SUR','*','','-3','N','','Suriname','SRT'),(598,'URY','*','','-3','Y','FSO-SSM','Uruguay','UYT'),(599,'CUW','*','','-4','N','','Netherlands Antilles','AST'),(649,'PCN','*','','-8','N','','Pitcain Island','PST'),(670,'TLS','*','','+9','N','','Timor-Leste','TLT'),(671,'GUM','*','','+10','N','','Guam','GST'),(672,'ATA','*','','+8','N','','Antarctic Aus Territory','CAST'),(672,'CCK','*','','+6.5','N','','Cocos Island','CCT'),(672,'CXR','*','','+7','N','','Christmas Island','CXT'),(673,'BRN','*','','+8','N','','Brunei Darussalam','BNT'),(674,'NRU','*','','-12','N','','Nauru','NRT'),(675,'PNG','*','','+10','N','','Papua New Guinea','PGT'),(676,'TON','*','','+13','N','','Tonga','TST'),(677,'SLB','*','','-11','N','','Solomon Islands','SBT'),(678,'VUT','*','','-11','N','','Vanuatu','VUT'),(679,'FJI','*','','+12','N','','Fiji','FJT'),(680,'PLW','*','','+9','N','','Palau','PWT'),(681,'WLF','*','','+12','N','','Wallis and Futuna','WFT'),(682,'COK','*','','+10.5','N','','Cook Islands','CKT'),(683,'NIU','*','','-11','N','','Niue Island','NUT'),(684,'ASM','*','','-11','N','','Samoa USA','SST'),(685,'WSM','*','','-11','N','','Samoa Western','WST'),(686,'KIR','*','','+12','N','','Kiribati','GILT'),(687,'NCL','*','','+11','N','','New Caledonia','NCT'),(688,'TUV','*','','-12','N','','Tuvalu','TVT'),(689,'PYF','*','','+9','N','','French Polynesia','GAMT'),(690,'TKL','*','','-10','N','','Tokelau','TKT'),(691,'FSM','*','','+11','N','','Micronesia','PONT'),(692,'MHL','*','','+12','N','','Marshall Islands','MHT'),(850,'PRK','*','','+9','N','','Korea North','KST'),(852,'HKG','*','','+8','N','','Hong Kong','HKT'),(853,'MAC','*','','+8','N','','Macao','CST'),(855,'KHM','*','','+7','N','','Cambodia','ICT'),(856,'LAO','*','','+7','N','','Laos','ICT'),(870,'PCN','*','','-8','N','','Pitcain Island','PST'),(880,'BGD','*','','+6','N','','Bangladesh','BST'),(886,'TWN','*','','+8','N','','Taiwan','CST'),(960,'MDV','*','','+5','N','','Maldives','MVT'),(961,'LBN','*','','+2','Y','LSM-LSO','Lebanon','EET'),(962,'JOR','*','','+2','Y','LSM-LSO','Jordan','EET'),(963,'SYR','*','','+2','Y','LSM-LSO','Syria','EET'),(964,'IRQ','*','','+3','Y','FDA-FDO','Iraq','AST'),(965,'KWT','*','','+3','N','','Kuwait','AST'),(966,'SAU','*','','+3','N','','Saudi Arabia','AST'),(967,'YEM','*','','+3','N','','Yemen','AST'),(968,'OMN','*','','+4','N','','Oman','GST'),(970,'PSE','*','','+2','Y','LFM-TSS','Palestine','IST'),(971,'ARE','*','','+4','N','','United Arab Emirates','GST'),(972,'ISR','*','','+2','Y','LFM-TSS','Israel','IST'),(973,'BHR','*','','+3','N','','Bahrain','AST'),(974,'QAT','*','','+3','N','','Qatar','AST'),(975,'BTN','*','','+6','N','','Bhutan','BTT'),(976,'MNG','*','','+8','N','','Mongolia','ULAT'),(977,'NPL','*','','+5.75','N','','Nepal','NPT'),(992,'TJK','*','','+5','N','','Tajikistan','TJT'),(993,'TKM','*','','+5','N','','Turkmenistan','TMT'),(994,'AZE','*','','+1','Y','LSM-LSO','Azerbaijan','AZT'),(995,'GEO','*','','+4','N','','Georgia','GET'),(996,'KGZ','*','','+5','N','','Kyrgyz Republic','UZT'),(998,'UZB','*','','+5','N','','Uzbekistan','UZT');
/*!40000 ALTER TABLE `vicidial_phone_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_postal_codes`
--

DROP TABLE IF EXISTS `vicidial_postal_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_postal_codes` (
  `postal_code` varchar(10) NOT NULL,
  `state` varchar(4) DEFAULT NULL,
  `GMT_offset` varchar(6) DEFAULT '',
  `DST` enum('Y','N') DEFAULT NULL,
  `DST_range` varchar(8) DEFAULT NULL,
  `country` char(3) DEFAULT NULL,
  `country_code` smallint(5) unsigned DEFAULT NULL,
  KEY `country_postal_code` (`country_code`,`postal_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_postal_codes`
--

LOCK TABLES `vicidial_postal_codes` WRITE;
/*!40000 ALTER TABLE `vicidial_postal_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_postal_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_process_log`
--

DROP TABLE IF EXISTS `vicidial_process_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_process_log` (
  `serial_id` varchar(20) NOT NULL,
  `run_time` datetime DEFAULT NULL,
  `run_sec` int(11) DEFAULT NULL,
  `server_ip` varchar(15) NOT NULL,
  `script` varchar(100) DEFAULT NULL,
  `process` varchar(100) DEFAULT NULL,
  `output_lines` mediumtext,
  KEY `serial_id` (`serial_id`),
  KEY `run_time` (`run_time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_process_log`
--

LOCK TABLES `vicidial_process_log` WRITE;
/*!40000 ALTER TABLE `vicidial_process_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_process_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_process_trigger_log`
--

DROP TABLE IF EXISTS `vicidial_process_trigger_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_process_trigger_log` (
  `trigger_id` varchar(20) NOT NULL,
  `server_ip` varchar(15) NOT NULL,
  `trigger_time` datetime DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `trigger_lines` text,
  `trigger_results` mediumtext,
  KEY `trigger_id` (`trigger_id`),
  KEY `trigger_time` (`trigger_time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_process_trigger_log`
--

LOCK TABLES `vicidial_process_trigger_log` WRITE;
/*!40000 ALTER TABLE `vicidial_process_trigger_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_process_trigger_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_process_triggers`
--

DROP TABLE IF EXISTS `vicidial_process_triggers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_process_triggers` (
  `trigger_id` varchar(20) NOT NULL,
  `trigger_name` varchar(100) DEFAULT NULL,
  `server_ip` varchar(15) NOT NULL,
  `trigger_time` datetime DEFAULT NULL,
  `trigger_run` enum('0','1') DEFAULT '0',
  `user` varchar(20) DEFAULT NULL,
  `trigger_lines` text,
  PRIMARY KEY (`trigger_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_process_triggers`
--

LOCK TABLES `vicidial_process_triggers` WRITE;
/*!40000 ALTER TABLE `vicidial_process_triggers` DISABLE KEYS */;
INSERT INTO `vicidial_process_triggers` VALUES ('LOAD_LEADS','Load Leads','127.0.0.1','2009-01-01 00:00:00','0',NULL,'/usr/share/astguiclient/VICIDIAL_IN_new_leads_file.pl');
/*!40000 ALTER TABLE `vicidial_process_triggers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_qc_agent_log`
--

DROP TABLE IF EXISTS `vicidial_qc_agent_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_qc_agent_log` (
  `qc_agent_log_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `qc_user` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `qc_user_group` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `qc_user_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lead_user` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `web_server_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `view_datetime` datetime NOT NULL,
  `save_datetime` datetime DEFAULT NULL,
  `view_epoch` int(10) unsigned NOT NULL,
  `save_epoch` int(10) unsigned DEFAULT NULL,
  `elapsed_seconds` smallint(5) unsigned DEFAULT NULL,
  `lead_id` int(9) unsigned NOT NULL,
  `list_id` bigint(14) unsigned NOT NULL,
  `campaign_id` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `old_status` varchar(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `new_status` varchar(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `details` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `processed` enum('Y','N') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`qc_agent_log_id`),
  KEY `view_epoch` (`view_epoch`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_qc_agent_log`
--

LOCK TABLES `vicidial_qc_agent_log` WRITE;
/*!40000 ALTER TABLE `vicidial_qc_agent_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_qc_agent_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_qc_codes`
--

DROP TABLE IF EXISTS `vicidial_qc_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_qc_codes` (
  `code` varchar(8) NOT NULL,
  `code_name` varchar(30) DEFAULT NULL,
  `qc_result_type` enum('PASS','FAIL','CANCEL','COMMIT') NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_qc_codes`
--

LOCK TABLES `vicidial_qc_codes` WRITE;
/*!40000 ALTER TABLE `vicidial_qc_codes` DISABLE KEYS */;
INSERT INTO `vicidial_qc_codes` VALUES ('QCPASS','PASS','PASS'),('QCFAIL','FAIL','FAIL'),('QCCANCEL','CANCEL','CANCEL');
/*!40000 ALTER TABLE `vicidial_qc_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_recording_access_log`
--

DROP TABLE IF EXISTS `vicidial_recording_access_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_recording_access_log` (
  `recording_access_log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `recording_id` int(10) unsigned DEFAULT NULL,
  `lead_id` int(10) unsigned DEFAULT NULL,
  `user` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_datetime` datetime DEFAULT NULL,
  `access_result` enum('ACCESSED','INVALID USER','INVALID PERMISSIONS','NO RECORDING','RECORDING UNAVAILABLE') COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT '',
  PRIMARY KEY (`recording_access_log_id`),
  KEY `recording_id` (`recording_id`),
  KEY `lead_id` (`lead_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1599 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_recording_access_log`
--

LOCK TABLES `vicidial_recording_access_log` WRITE;
/*!40000 ALTER TABLE `vicidial_recording_access_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_recording_access_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_remote_agent_log`
--

DROP TABLE IF EXISTS `vicidial_remote_agent_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_remote_agent_log` (
  `uniqueid` varchar(20) DEFAULT '',
  `callerid` varchar(20) DEFAULT '',
  `ra_user` varchar(20) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `call_time` datetime DEFAULT NULL,
  `extension` varchar(100) DEFAULT '',
  `lead_id` int(9) unsigned DEFAULT '0',
  `phone_number` varchar(18) DEFAULT '',
  `campaign_id` varchar(20) DEFAULT '',
  `processed` enum('Y','N') DEFAULT 'N',
  `comment` varchar(255) DEFAULT '',
  KEY `call_time` (`call_time`),
  KEY `ra_user` (`ra_user`),
  KEY `extension` (`extension`),
  KEY `phone_number` (`phone_number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_remote_agent_log`
--

LOCK TABLES `vicidial_remote_agent_log` WRITE;
/*!40000 ALTER TABLE `vicidial_remote_agent_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_remote_agent_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_remote_agents`
--

DROP TABLE IF EXISTS `vicidial_remote_agents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_remote_agents` (
  `remote_agent_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `user_start` varchar(20) DEFAULT NULL,
  `number_of_lines` tinyint(3) unsigned DEFAULT '1',
  `server_ip` varchar(15) NOT NULL,
  `conf_exten` varchar(20) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') DEFAULT 'INACTIVE',
  `campaign_id` varchar(8) DEFAULT NULL,
  `closer_campaigns` text,
  `extension_group` varchar(20) DEFAULT 'NONE',
  `extension_group_order` varchar(20) DEFAULT 'NONE',
  `on_hook_agent` enum('Y','N') DEFAULT 'N',
  `on_hook_ring_time` smallint(5) DEFAULT '15',
  PRIMARY KEY (`remote_agent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_remote_agents`
--

LOCK TABLES `vicidial_remote_agents` WRITE;
/*!40000 ALTER TABLE `vicidial_remote_agents` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_remote_agents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_report_log`
--

DROP TABLE IF EXISTS `vicidial_report_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_report_log` (
  `report_log_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `event_date` datetime NOT NULL,
  `user` varchar(20) NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `report_name` varchar(50) NOT NULL,
  `browser` text,
  `referer` text,
  `notes` text,
  `url` text,
  `run_time` varchar(20) DEFAULT '0',
  `webserver` smallint(5) unsigned DEFAULT '0',
  PRIMARY KEY (`report_log_id`),
  KEY `user` (`user`),
  KEY `report_name` (`report_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_report_log`
--

LOCK TABLES `vicidial_report_log` WRITE;
/*!40000 ALTER TABLE `vicidial_report_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_report_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_rt_monitor_log`
--

DROP TABLE IF EXISTS `vicidial_rt_monitor_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_rt_monitor_log` (
  `manager_user` varchar(20) NOT NULL,
  `manager_server_ip` varchar(15) NOT NULL,
  `manager_phone` varchar(20) NOT NULL,
  `manager_ip` varchar(15) DEFAULT NULL,
  `agent_user` varchar(20) DEFAULT NULL,
  `agent_server_ip` varchar(15) DEFAULT NULL,
  `agent_status` varchar(10) DEFAULT NULL,
  `agent_session` varchar(10) DEFAULT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `campaign_id` varchar(8) DEFAULT NULL,
  `caller_code` varchar(20) DEFAULT NULL,
  `monitor_start_time` datetime DEFAULT NULL,
  `monitor_end_time` datetime DEFAULT NULL,
  `monitor_sec` int(9) unsigned DEFAULT '0',
  `monitor_type` enum('LISTEN','BARGE','HIJACK','WHISPER') DEFAULT 'LISTEN',
  UNIQUE KEY `caller_code` (`caller_code`),
  KEY `manager_user` (`manager_user`),
  KEY `agent_user` (`agent_user`),
  KEY `monitor_start_time` (`monitor_start_time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_rt_monitor_log`
--

LOCK TABLES `vicidial_rt_monitor_log` WRITE;
/*!40000 ALTER TABLE `vicidial_rt_monitor_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_rt_monitor_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_rt_monitor_log_archive`
--

DROP TABLE IF EXISTS `vicidial_rt_monitor_log_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_rt_monitor_log_archive` (
  `manager_user` varchar(20) NOT NULL,
  `manager_server_ip` varchar(15) NOT NULL,
  `manager_phone` varchar(20) NOT NULL,
  `manager_ip` varchar(15) DEFAULT NULL,
  `agent_user` varchar(20) DEFAULT NULL,
  `agent_server_ip` varchar(15) DEFAULT NULL,
  `agent_status` varchar(10) DEFAULT NULL,
  `agent_session` varchar(10) DEFAULT NULL,
  `lead_id` int(9) unsigned DEFAULT NULL,
  `campaign_id` varchar(8) DEFAULT NULL,
  `caller_code` varchar(20) DEFAULT NULL,
  `monitor_start_time` datetime DEFAULT NULL,
  `monitor_end_time` datetime DEFAULT NULL,
  `monitor_sec` int(9) unsigned DEFAULT '0',
  `monitor_type` enum('LISTEN','BARGE','HIJACK','WHISPER') DEFAULT 'LISTEN',
  UNIQUE KEY `caller_code` (`caller_code`),
  KEY `manager_user` (`manager_user`),
  KEY `agent_user` (`agent_user`),
  KEY `monitor_start_time` (`monitor_start_time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_rt_monitor_log_archive`
--

LOCK TABLES `vicidial_rt_monitor_log_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_rt_monitor_log_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_rt_monitor_log_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_screen_colors`
--

DROP TABLE IF EXISTS `vicidial_screen_colors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_screen_colors` (
  `colors_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `colors_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` enum('Y','N') COLLATE utf8_unicode_ci DEFAULT 'N',
  `menu_background` varchar(6) COLLATE utf8_unicode_ci DEFAULT '015B91',
  `frame_background` varchar(6) COLLATE utf8_unicode_ci DEFAULT 'D9E6FE',
  `std_row1_background` varchar(6) COLLATE utf8_unicode_ci DEFAULT '9BB9FB',
  `std_row2_background` varchar(6) COLLATE utf8_unicode_ci DEFAULT 'B9CBFD',
  `std_row3_background` varchar(6) COLLATE utf8_unicode_ci DEFAULT '8EBCFD',
  `std_row4_background` varchar(6) COLLATE utf8_unicode_ci DEFAULT 'B6D3FC',
  `std_row5_background` varchar(6) COLLATE utf8_unicode_ci DEFAULT 'A3C3D6',
  `alt_row1_background` varchar(6) COLLATE utf8_unicode_ci DEFAULT 'BDFFBD',
  `alt_row2_background` varchar(6) COLLATE utf8_unicode_ci DEFAULT '99FF99',
  `alt_row3_background` varchar(6) COLLATE utf8_unicode_ci DEFAULT 'CCFFCC',
  `user_group` varchar(20) COLLATE utf8_unicode_ci DEFAULT '---ALL---',
  `web_logo` varchar(100) COLLATE utf8_unicode_ci DEFAULT 'default_new',
  PRIMARY KEY (`colors_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_screen_colors`
--

LOCK TABLES `vicidial_screen_colors` WRITE;
/*!40000 ALTER TABLE `vicidial_screen_colors` DISABLE KEYS */;
INSERT INTO `vicidial_screen_colors` VALUES ('red_rust','dark red rust','Y','804435','E7D0C2','C68C71','D9B39F','D9B49F','C68C72','C68C73','BDFFBD','99FF99','CCFFCC','---ALL---','default_new'),('pale_green','pale green','Y','738035','E0E7C2','B6C572','C4CF8B','B6C572','C4CF8B','C4CF8B','BDFFBD','99FF99','CCFFCC','---ALL---','default_new'),('alt_green','alternate green','Y','333333','D6E3B2','AEC866','BCD180','BCD180','AEC866','AEC866','BDFFBD','99FF99','CCFFCC','---ALL---','default_new'),('default_blue_test','default blue test','Y','015B91','D9E6FE','9BB9FB','B9CBFD','8EBCFD','B6D3FC','A3C3D6','BDFFBD','99FF99','CCFFCC','---ALL---','default_new'),('basic_orange','basic orange','Y','804d00','ffebcc','ffcc80','ffd699','ffcc80','ffd699','ffcc80','BDFFBD','99FF99','CCFFCC','---ALL---','default_new'),('basic_purple','basic purple','Y','660066','ffccff','ff99ff','ffb3ff','ff99ff','ffb3ff','ff99ff','BDFFBD','99FF99','CCFFCC','---ALL---','SAMPLE.png'),('basic_yellow','basic yellow','Y','666600','ffffcc','ffff66','ffff99','ffff66','ffff99','ffff66','BDFFBD','99FF99','CCFFCC','---ALL---','default_new'),('basic_red','basic red','Y','800000','ffe6e6','ff9999','ffb3b3','ff9999','ffb3b3','ff9999','BDFFBD','99FF99','CCFFCC','---ALL---','default_new'),('default_grey_agent','default grey agent','Y','FFFFFF','cccccc','E6E6E6','E6E6E6','E6E6E6','E6E6E6','E6E6E6','E6E6E6','E6E6E6','E6E6E6','---ALL---','DEFAULTAGENT.png');
/*!40000 ALTER TABLE `vicidial_screen_colors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_screen_labels`
--

DROP TABLE IF EXISTS `vicidial_screen_labels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_screen_labels` (
  `label_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `label_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` enum('Y','N') COLLATE utf8_unicode_ci DEFAULT 'N',
  `label_hide_field_logs` varchar(6) COLLATE utf8_unicode_ci DEFAULT 'Y',
  `label_title` varchar(60) COLLATE utf8_unicode_ci DEFAULT '',
  `label_first_name` varchar(60) COLLATE utf8_unicode_ci DEFAULT '',
  `label_middle_initial` varchar(60) COLLATE utf8_unicode_ci DEFAULT '',
  `label_last_name` varchar(60) COLLATE utf8_unicode_ci DEFAULT '',
  `label_address1` varchar(60) COLLATE utf8_unicode_ci DEFAULT '',
  `label_address2` varchar(60) COLLATE utf8_unicode_ci DEFAULT '',
  `label_address3` varchar(60) COLLATE utf8_unicode_ci DEFAULT '',
  `label_city` varchar(60) COLLATE utf8_unicode_ci DEFAULT '',
  `label_state` varchar(60) COLLATE utf8_unicode_ci DEFAULT '',
  `label_province` varchar(60) COLLATE utf8_unicode_ci DEFAULT '',
  `label_postal_code` varchar(60) COLLATE utf8_unicode_ci DEFAULT '',
  `label_vendor_lead_code` varchar(60) COLLATE utf8_unicode_ci DEFAULT '',
  `label_gender` varchar(60) COLLATE utf8_unicode_ci DEFAULT '',
  `label_phone_number` varchar(60) COLLATE utf8_unicode_ci DEFAULT '',
  `label_phone_code` varchar(60) COLLATE utf8_unicode_ci DEFAULT '',
  `label_alt_phone` varchar(60) COLLATE utf8_unicode_ci DEFAULT '',
  `label_security_phrase` varchar(60) COLLATE utf8_unicode_ci DEFAULT '',
  `label_email` varchar(60) COLLATE utf8_unicode_ci DEFAULT '',
  `label_comments` varchar(60) COLLATE utf8_unicode_ci DEFAULT '',
  `user_group` varchar(20) COLLATE utf8_unicode_ci DEFAULT '---ALL---',
  PRIMARY KEY (`label_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_screen_labels`
--

LOCK TABLES `vicidial_screen_labels` WRITE;
/*!40000 ALTER TABLE `vicidial_screen_labels` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_screen_labels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_scripts`
--

DROP TABLE IF EXISTS `vicidial_scripts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_scripts` (
  `script_id` varchar(20) NOT NULL,
  `script_name` varchar(50) DEFAULT NULL,
  `script_comments` varchar(255) DEFAULT NULL,
  `script_text` text,
  `active` enum('Y','N') DEFAULT NULL,
  `user_group` varchar(20) DEFAULT '---ALL---',
  `script_color` varchar(7) DEFAULT 'white',
  PRIMARY KEY (`script_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_scripts`
--

LOCK TABLES `vicidial_scripts` WRITE;
/*!40000 ALTER TABLE `vicidial_scripts` DISABLE KEYS */;
INSERT INTO `vicidial_scripts` VALUES ('script001','DefaultScript','DefaultScript','Hi my name is --A--fullname--B-- , \r\nhow are you Mr/Mrs --A--first_name--B-- --A--last_name--B-- ,\r\ncan you confirm if this is your address --A--address1--B-- ','Y','ADMIN','white');
/*!40000 ALTER TABLE `vicidial_scripts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_server_carriers`
--

DROP TABLE IF EXISTS `vicidial_server_carriers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_server_carriers` (
  `carrier_id` varchar(15) NOT NULL,
  `carrier_name` varchar(50) NOT NULL,
  `registration_string` varchar(255) DEFAULT NULL,
  `template_id` varchar(15) NOT NULL,
  `account_entry` text,
  `protocol` enum('SIP','Zap','IAX2','EXTERNAL') DEFAULT 'SIP',
  `globals_string` varchar(255) DEFAULT NULL,
  `dialplan_entry` text,
  `server_ip` varchar(15) NOT NULL,
  `active` enum('Y','N') DEFAULT 'Y',
  `carrier_description` varchar(255) DEFAULT NULL,
  `user_group` varchar(20) DEFAULT '---ALL---',
  UNIQUE KEY `carrier_id` (`carrier_id`),
  KEY `server_ip` (`server_ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_server_carriers`
--

LOCK TABLES `vicidial_server_carriers` WRITE;
/*!40000 ALTER TABLE `vicidial_server_carriers` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_server_carriers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_server_trunks`
--

DROP TABLE IF EXISTS `vicidial_server_trunks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_server_trunks` (
  `server_ip` varchar(15) NOT NULL,
  `campaign_id` varchar(20) NOT NULL,
  `dedicated_trunks` smallint(5) unsigned DEFAULT '0',
  `trunk_restriction` enum('MAXIMUM_LIMIT','OVERFLOW_ALLOWED') DEFAULT 'OVERFLOW_ALLOWED',
  KEY `campaign_id` (`campaign_id`),
  KEY `server_ip` (`server_ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_server_trunks`
--

LOCK TABLES `vicidial_server_trunks` WRITE;
/*!40000 ALTER TABLE `vicidial_server_trunks` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_server_trunks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_session_data`
--

DROP TABLE IF EXISTS `vicidial_session_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_session_data` (
  `session_name` varchar(40) NOT NULL,
  `user` varchar(20) DEFAULT NULL,
  `campaign_id` varchar(8) DEFAULT NULL,
  `server_ip` varchar(15) NOT NULL,
  `conf_exten` varchar(20) DEFAULT NULL,
  `extension` varchar(100) NOT NULL,
  `login_time` datetime NOT NULL,
  `webphone_url` text,
  `agent_login_call` text,
  UNIQUE KEY `session_name` (`session_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_session_data`
--

LOCK TABLES `vicidial_session_data` WRITE;
/*!40000 ALTER TABLE `vicidial_session_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_session_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_settings_containers`
--

DROP TABLE IF EXISTS `vicidial_settings_containers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_settings_containers` (
  `container_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `container_notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `container_type` varchar(40) COLLATE utf8_unicode_ci DEFAULT 'OTHER',
  `user_group` varchar(20) COLLATE utf8_unicode_ci DEFAULT '---ALL---',
  `container_entry` mediumtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`container_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_settings_containers`
--

LOCK TABLES `vicidial_settings_containers` WRITE;
/*!40000 ALTER TABLE `vicidial_settings_containers` DISABLE KEYS */;
INSERT INTO `vicidial_settings_containers` VALUES ('AGENT_CALLBACK_EMAIL ','Scheduled callback email alert settings','OTHER','---ALL---','; sending email address\r\nemail_from => vicidial@local.server\r\n\r\n; subject of the email\r\nemail_subject => Scheduled callback alert for --A--agent_name--B--\r\n\r\nemail_body_begin => \r\nThis is a reminder that you have a scheduled callback right now for the following lead:\r\n\r\nName: --A--first_name--B-- --A--last_name--B--\r\nPhone: --A--phone_number--B--\r\nAlt. phone: --A--alt_phone--B--\r\nEmail: --A--email--B--\r\nCB Comments: --A--callback_comments--B--\r\nLead Comments: --A--comments--B--\r\n\r\nPlease don\'t respond to this, fool.\r\n\r\nemail_body_end');
/*!40000 ALTER TABLE `vicidial_settings_containers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_shifts`
--

DROP TABLE IF EXISTS `vicidial_shifts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_shifts` (
  `shift_id` varchar(20) NOT NULL,
  `shift_name` varchar(50) DEFAULT NULL,
  `shift_start_time` varchar(4) DEFAULT '0900',
  `shift_length` varchar(5) DEFAULT '16:00',
  `shift_weekdays` varchar(7) DEFAULT '0123456',
  `report_option` enum('Y','N') DEFAULT 'N',
  `user_group` varchar(20) DEFAULT '---ALL---',
  `report_rank` smallint(5) DEFAULT '1',
  KEY `shift_id` (`shift_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_shifts`
--

LOCK TABLES `vicidial_shifts` WRITE;
/*!40000 ALTER TABLE `vicidial_shifts` DISABLE KEYS */;
INSERT INTO `vicidial_shifts` VALUES ('24HRMIDNIGHT','24 hours 7 days a week','0000','24:00','0123456','N','---ALL---',1);
/*!40000 ALTER TABLE `vicidial_shifts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_state_call_times`
--

DROP TABLE IF EXISTS `vicidial_state_call_times`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_state_call_times` (
  `state_call_time_id` varchar(10) NOT NULL,
  `state_call_time_state` varchar(2) NOT NULL,
  `state_call_time_name` varchar(30) NOT NULL,
  `state_call_time_comments` varchar(255) DEFAULT '',
  `sct_default_start` smallint(4) unsigned NOT NULL DEFAULT '900',
  `sct_default_stop` smallint(4) unsigned NOT NULL DEFAULT '2100',
  `sct_sunday_start` smallint(4) unsigned DEFAULT '0',
  `sct_sunday_stop` smallint(4) unsigned DEFAULT '0',
  `sct_monday_start` smallint(4) unsigned DEFAULT '0',
  `sct_monday_stop` smallint(4) unsigned DEFAULT '0',
  `sct_tuesday_start` smallint(4) unsigned DEFAULT '0',
  `sct_tuesday_stop` smallint(4) unsigned DEFAULT '0',
  `sct_wednesday_start` smallint(4) unsigned DEFAULT '0',
  `sct_wednesday_stop` smallint(4) unsigned DEFAULT '0',
  `sct_thursday_start` smallint(4) unsigned DEFAULT '0',
  `sct_thursday_stop` smallint(4) unsigned DEFAULT '0',
  `sct_friday_start` smallint(4) unsigned DEFAULT '0',
  `sct_friday_stop` smallint(4) unsigned DEFAULT '0',
  `sct_saturday_start` smallint(4) unsigned DEFAULT '0',
  `sct_saturday_stop` smallint(4) unsigned DEFAULT '0',
  `user_group` varchar(20) DEFAULT '---ALL---',
  `ct_holidays` text,
  PRIMARY KEY (`state_call_time_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_state_call_times`
--

LOCK TABLES `vicidial_state_call_times` WRITE;
/*!40000 ALTER TABLE `vicidial_state_call_times` DISABLE KEYS */;
INSERT INTO `vicidial_state_call_times` VALUES ('alabama','AL','Alabama 8am-8pm and Sunday','',800,2000,2400,2400,0,0,0,0,0,0,0,0,0,0,0,0,'---ALL---',NULL),('illinois','IL','Illinois 8am','',800,2100,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'---ALL---',NULL),('indiana','IN','Indiana 8pm restriction','',900,2000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'---ALL---',NULL),('kentucky','KY','Kentucky 10am restriction','',1000,2100,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'---ALL---',NULL),('louisiana','LA','Louisiana 8am-8pm and Sunday','',800,2000,2400,2400,0,0,0,0,0,0,0,0,0,0,0,0,'---ALL---',NULL),('massachuse','MA','Massachusetts 8am-8pm','',800,2000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'---ALL---',NULL),('mississipp','MS','Mississippi 8am-8pm and Sunday','',800,2000,2400,2400,0,0,0,0,0,0,0,0,0,0,0,0,'---ALL---',NULL),('nebraska','NE','Nebraska 8am','',800,2100,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'---ALL---',NULL),('nevada','NV','Nevada 8pm restriction','',900,2000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'---ALL---',NULL),('pennsylvan','PA','Pennsylvania sunday restrictio','',900,2100,1330,2100,0,0,0,0,0,0,0,0,0,0,0,0,'---ALL---',NULL),('rhodeislan','RI','Rhode Island restrictions','',900,1800,2400,2400,0,0,0,0,0,0,0,0,0,0,1000,1700,'---ALL---',NULL),('sdakota','SD','South Dakota sunday restrict','',900,2100,2400,2400,0,0,0,0,0,0,0,0,0,0,0,0,'---ALL---',NULL),('tennessee','TN','Tennessee 8am','',800,2100,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'---ALL---',NULL),('texas','TX','Texas sunday restriction','',900,2100,1200,2100,0,0,0,0,0,0,0,0,0,0,0,0,'---ALL---',NULL),('utah','UT','Utah 8pm restriction','',900,2000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'---ALL---',NULL),('washington','WA','Washington 8am','',800,2100,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'---ALL---',NULL),('wyoming','WY','Wyoming 8am-8pm','',800,2000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'---ALL---',NULL),('test','PH','test','test',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'---ALL---',NULL);
/*!40000 ALTER TABLE `vicidial_state_call_times` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_stations`
--

DROP TABLE IF EXISTS `vicidial_stations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_stations` (
  `agent_station` varchar(10) NOT NULL,
  `phone_channel` varchar(100) DEFAULT NULL,
  `computer_ip` varchar(15) NOT NULL,
  `server_ip` varchar(15) NOT NULL,
  `DB_server_ip` varchar(15) NOT NULL,
  `DB_user` varchar(15) DEFAULT NULL,
  `DB_pass` varchar(15) DEFAULT NULL,
  `DB_port` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`agent_station`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_stations`
--

LOCK TABLES `vicidial_stations` WRITE;
/*!40000 ALTER TABLE `vicidial_stations` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_stations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_status_categories`
--

DROP TABLE IF EXISTS `vicidial_status_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_status_categories` (
  `vsc_id` varchar(20) NOT NULL,
  `vsc_name` varchar(50) DEFAULT NULL,
  `vsc_description` varchar(255) DEFAULT NULL,
  `tovdad_display` enum('Y','N') DEFAULT 'N',
  `sale_category` enum('Y','N') DEFAULT 'N',
  `dead_lead_category` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`vsc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_status_categories`
--

LOCK TABLES `vicidial_status_categories` WRITE;
/*!40000 ALTER TABLE `vicidial_status_categories` DISABLE KEYS */;
INSERT INTO `vicidial_status_categories` VALUES ('UNDEFINED','Default Category',NULL,'N','N','N');
/*!40000 ALTER TABLE `vicidial_status_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_status_groups`
--

DROP TABLE IF EXISTS `vicidial_status_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_status_groups` (
  `status_group_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `status_group_notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `user_group` varchar(20) COLLATE utf8_unicode_ci DEFAULT '---ALL---',
  PRIMARY KEY (`status_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_status_groups`
--

LOCK TABLES `vicidial_status_groups` WRITE;
/*!40000 ALTER TABLE `vicidial_status_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_status_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_statuses`
--

DROP TABLE IF EXISTS `vicidial_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_statuses` (
  `status` varchar(6) NOT NULL,
  `status_name` varchar(30) DEFAULT NULL,
  `selectable` enum('Y','N') DEFAULT NULL,
  `human_answered` enum('Y','N') DEFAULT 'N',
  `category` varchar(20) DEFAULT 'UNDEFINED',
  `sale` enum('Y','N') DEFAULT 'N',
  `dnc` enum('Y','N') DEFAULT 'N',
  `customer_contact` enum('Y','N') DEFAULT 'N',
  `not_interested` enum('Y','N') DEFAULT 'N',
  `unworkable` enum('Y','N') DEFAULT 'N',
  `scheduled_callback` enum('Y','N') DEFAULT 'N',
  `completed` enum('Y','N') DEFAULT 'N',
  `min_sec` int(5) unsigned DEFAULT '0',
  `max_sec` int(5) unsigned DEFAULT '0',
  `answering_machine` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_statuses`
--

LOCK TABLES `vicidial_statuses` WRITE;
/*!40000 ALTER TABLE `vicidial_statuses` DISABLE KEYS */;
INSERT INTO `vicidial_statuses` VALUES ('NEW','New Lead','N','N','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('QUEUE','Lead To Be Called','N','N','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('INCALL','Lead Being Called','N','N','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('DROP','Agent Not Available','N','Y','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('XDROP','Agent Not Available IN','N','Y','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('NA','No Answer AutoDial','N','N','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('CALLBK','Call Back','Y','Y','UNDEFINED','N','N','N','N','N','Y','N',0,0,'N'),('CBHOLD','Call Back Hold','N','Y','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('A','Answering Machine','Y','N','UNDEFINED','N','N','N','N','N','N','N',0,0,'Y'),('AA','Answering Machine Auto','N','N','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('AM','Answering Machine Sent to Mesg','N','N','UNDEFINED','N','N','N','N','N','N','N',0,0,'Y'),('AL','Answering Machine Msg Played','N','N','UNDEFINED','N','N','N','N','N','N','N',0,0,'Y'),('AFAX','Fax Machine Auto','N','N','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('B','Busy','Y','N','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('DC','Disconnected Number','Y','N','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('DEC','Declined Sale','Y','Y','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('DNC','DO NOT CALL','Y','Y','UNDEFINED','N','Y','N','N','N','N','N',0,0,'N'),('DNCL','DO NOT CALL Hopper Match','N','N','UNDEFINED','N','Y','N','N','N','N','N',0,0,'N'),('SALE','Sale Made','Y','Y','UNDEFINED','Y','N','N','N','N','N','N',0,0,'N'),('N','No Answer','Y','N','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('NI','Not Interested','Y','Y','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('NP','No Pitch No Price','Y','Y','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('PU','Call Picked Up','N','N','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('PM','Played Message','N','N','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('XFER','Call Transferred','Y','Y','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('ERI','Agent Error','N','N','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('SVYEXT','Survey sent to Extension','N','N','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('SVYVM','Survey sent to Voicemail','N','N','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('SVYHU','Survey Hungup','N','N','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('SVYREC','Survey sent to Record','N','N','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('QVMAIL','Queue Abandon Voicemail Left','N','N','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('AB','Busy Auto','N','N','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('ADC','Disconnected Number Auto','N','N','UNDEFINED','N','N','N','N','Y','N','N',0,0,'N'),('TIMEOT','Inbound Queue Timeout Drop','N','Y','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('AFTHRS','Inbound After Hours Drop','N','Y','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('NANQUE','Inbound No Agent No Queue Drop','N','Y','UNDEFINED','N','N','N','N','N','N','N',0,0,'N'),('QCFAIL','QC_FAIL_CALLBK','N','Y','QC','N','N','Y','N','N','Y','N',0,0,'N');
/*!40000 ALTER TABLE `vicidial_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_territories`
--

DROP TABLE IF EXISTS `vicidial_territories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_territories` (
  `territory_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `territory` varchar(100) DEFAULT '',
  `territory_description` varchar(255) DEFAULT '',
  PRIMARY KEY (`territory_id`),
  UNIQUE KEY `uniqueterritory` (`territory`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_territories`
--

LOCK TABLES `vicidial_territories` WRITE;
/*!40000 ALTER TABLE `vicidial_territories` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_territories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_timeclock_audit_log`
--

DROP TABLE IF EXISTS `vicidial_timeclock_audit_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_timeclock_audit_log` (
  `timeclock_id` int(9) unsigned NOT NULL,
  `event_epoch` int(10) unsigned NOT NULL,
  `event_date` datetime NOT NULL,
  `login_sec` int(10) unsigned DEFAULT NULL,
  `event` varchar(50) NOT NULL,
  `user` varchar(20) NOT NULL,
  `user_group` varchar(20) NOT NULL,
  `ip_address` varchar(15) DEFAULT NULL,
  `shift_id` varchar(20) DEFAULT NULL,
  `event_datestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tcid_link` int(9) unsigned DEFAULT NULL,
  KEY `timeclock_id` (`timeclock_id`),
  KEY `user` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_timeclock_audit_log`
--

LOCK TABLES `vicidial_timeclock_audit_log` WRITE;
/*!40000 ALTER TABLE `vicidial_timeclock_audit_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_timeclock_audit_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_timeclock_log`
--

DROP TABLE IF EXISTS `vicidial_timeclock_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_timeclock_log` (
  `timeclock_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `event_epoch` int(10) unsigned NOT NULL,
  `event_date` datetime NOT NULL,
  `login_sec` int(10) unsigned DEFAULT NULL,
  `event` varchar(50) NOT NULL,
  `user` varchar(20) NOT NULL,
  `user_group` varchar(20) NOT NULL,
  `ip_address` varchar(15) DEFAULT NULL,
  `shift_id` varchar(20) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `manager_user` varchar(20) DEFAULT NULL,
  `manager_ip` varchar(15) DEFAULT NULL,
  `event_datestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tcid_link` int(9) unsigned DEFAULT NULL,
  PRIMARY KEY (`timeclock_id`),
  KEY `user` (`user`),
  KEY `vtl_event_epoch` (`event_epoch`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_timeclock_log`
--

LOCK TABLES `vicidial_timeclock_log` WRITE;
/*!40000 ALTER TABLE `vicidial_timeclock_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_timeclock_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_timeclock_status`
--

DROP TABLE IF EXISTS `vicidial_timeclock_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_timeclock_status` (
  `user` varchar(20) NOT NULL,
  `user_group` varchar(20) NOT NULL,
  `event_epoch` int(10) unsigned DEFAULT NULL,
  `event_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(50) DEFAULT NULL,
  `ip_address` varchar(15) DEFAULT NULL,
  `shift_id` varchar(20) DEFAULT NULL,
  UNIQUE KEY `user` (`user`),
  KEY `user_2` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_timeclock_status`
--

LOCK TABLES `vicidial_timeclock_status` WRITE;
/*!40000 ALTER TABLE `vicidial_timeclock_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_timeclock_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_tts_prompts`
--

DROP TABLE IF EXISTS `vicidial_tts_prompts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_tts_prompts` (
  `tts_id` varchar(50) NOT NULL,
  `tts_name` varchar(100) DEFAULT NULL,
  `active` enum('Y','N') DEFAULT NULL,
  `tts_text` text,
  `tts_voice` varchar(100) DEFAULT 'Allison-8kHz',
  `user_group` varchar(20) DEFAULT '---ALL---',
  PRIMARY KEY (`tts_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_tts_prompts`
--

LOCK TABLES `vicidial_tts_prompts` WRITE;
/*!40000 ALTER TABLE `vicidial_tts_prompts` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_tts_prompts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_url_log`
--

DROP TABLE IF EXISTS `vicidial_url_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_url_log` (
  `url_log_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `uniqueid` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `url_date` datetime DEFAULT NULL,
  `url_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
  `response_sec` smallint(5) unsigned DEFAULT '0',
  `url` text COLLATE utf8_unicode_ci,
  `url_response` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`url_log_id`),
  KEY `uniqueid` (`uniqueid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_url_log`
--

LOCK TABLES `vicidial_url_log` WRITE;
/*!40000 ALTER TABLE `vicidial_url_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_url_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_url_multi`
--

DROP TABLE IF EXISTS `vicidial_url_multi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_url_multi` (
  `url_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `campaign_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `entry_type` enum('campaign','ingroup','list','') COLLATE utf8_unicode_ci DEFAULT '',
  `active` enum('Y','N') COLLATE utf8_unicode_ci DEFAULT 'N',
  `url_type` enum('dispo','start','addlead','noagent','') COLLATE utf8_unicode_ci DEFAULT '',
  `url_rank` smallint(5) DEFAULT '1',
  `url_statuses` varchar(1000) COLLATE utf8_unicode_ci DEFAULT '',
  `url_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `url_address` text COLLATE utf8_unicode_ci,
  `url_lists` varchar(1000) COLLATE utf8_unicode_ci DEFAULT '',
  PRIMARY KEY (`url_id`),
  KEY `vicidial_url_multi_campaign_id_key` (`campaign_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_url_multi`
--

LOCK TABLES `vicidial_url_multi` WRITE;
/*!40000 ALTER TABLE `vicidial_url_multi` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_url_multi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_urls`
--

DROP TABLE IF EXISTS `vicidial_urls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_urls` (
  `url_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT '',
  PRIMARY KEY (`url_id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_urls`
--

LOCK TABLES `vicidial_urls` WRITE;
/*!40000 ALTER TABLE `vicidial_urls` DISABLE KEYS */;
INSERT INTO `vicidial_urls` VALUES (1,'http://ee-v3-c7.goautodial.com/agc/vicidial.php'),(2,'https://ee-v3-c7.goautodial.com/agc/vicidial.php'),(3,'https://demo-fr.goautodial.com/vicidial.go/non_agent_api.php');
/*!40000 ALTER TABLE `vicidial_urls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_user_closer_log`
--

DROP TABLE IF EXISTS `vicidial_user_closer_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_user_closer_log` (
  `user` varchar(20) DEFAULT NULL,
  `campaign_id` varchar(20) DEFAULT NULL,
  `event_date` datetime DEFAULT NULL,
  `blended` enum('1','0') DEFAULT '0',
  `closer_campaigns` text,
  `manager_change` varchar(20) DEFAULT '',
  KEY `user` (`user`),
  KEY `event_date` (`event_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_user_closer_log`
--

LOCK TABLES `vicidial_user_closer_log` WRITE;
/*!40000 ALTER TABLE `vicidial_user_closer_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_user_closer_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_user_groups`
--

DROP TABLE IF EXISTS `vicidial_user_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_user_groups` (
  `user_group` varchar(20) NOT NULL,
  `group_name` varchar(40) NOT NULL,
  `allowed_campaigns` text,
  `qc_allowed_campaigns` text,
  `qc_allowed_inbound_groups` text,
  `group_shifts` text,
  `forced_timeclock_login` enum('Y','N','ADMIN_EXEMPT') DEFAULT 'N',
  `shift_enforcement` enum('OFF','START','ALL','ADMIN_EXEMPT') DEFAULT 'OFF',
  `agent_status_viewable_groups` text,
  `agent_status_view_time` enum('Y','N') DEFAULT 'N',
  `agent_call_log_view` enum('Y','N') DEFAULT 'N',
  `agent_xfer_consultative` enum('Y','N') DEFAULT 'Y',
  `agent_xfer_dial_override` enum('Y','N') DEFAULT 'Y',
  `agent_xfer_vm_transfer` enum('Y','N') DEFAULT 'Y',
  `agent_xfer_blind_transfer` enum('Y','N') DEFAULT 'Y',
  `agent_xfer_dial_with_customer` enum('Y','N') DEFAULT 'Y',
  `agent_xfer_park_customer_dial` enum('Y','N') DEFAULT 'Y',
  `agent_fullscreen` enum('Y','N') DEFAULT 'N',
  `allowed_reports` varchar(2000) DEFAULT 'ALL REPORTS',
  `webphone_url_override` varchar(255) DEFAULT '',
  `webphone_systemkey_override` varchar(100) DEFAULT '',
  `webphone_dialpad_override` enum('DISABLED','Y','N','TOGGLE','TOGGLE_OFF') DEFAULT 'DISABLED',
  `admin_viewable_groups` text,
  `admin_viewable_call_times` text,
  `allowed_custom_reports` varchar(2000) DEFAULT '',
  `agent_allowed_chat_groups` text,
  `admin_ip_list` varchar(30) DEFAULT '',
  `agent_ip_list` varchar(30) DEFAULT '',
  `api_ip_list` varchar(30) DEFAULT '',
  `webphone_layout` varchar(255) DEFAULT '',
  `agent_xfer_park_3way` enum('Y','N') DEFAULT 'Y'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_user_groups`
--

LOCK TABLES `vicidial_user_groups` WRITE;
/*!40000 ALTER TABLE `vicidial_user_groups` DISABLE KEYS */;
INSERT INTO `vicidial_user_groups` VALUES ('ADMIN','GOAUTODIAL ADMINISTRATORS',' -ALL-CAMPAIGNS- -','','','  ','N','OFF','   ','N','N','Y','Y','Y','Y','Y','Y','N','ALL REPORTS','','','DISABLED','  ','  ','','   ','','','','','Y'),('AGENTS','GOAUTODIAL AGENTS',' -ALL-CAMPAIGNS- -',NULL,NULL,NULL,'N','OFF',' ','N','N','Y','Y','Y','Y','Y','Y','N','ALL REPORTS','','','DISABLED',' ',' ','',' ','','','','','Y'),('SUPERVISOR','SUPERVISOR',' -',NULL,NULL,NULL,'N','OFF',' AGENTS SUPERVISOR ','N','N','Y','Y','Y','Y','Y','Y','N','null','','','DISABLED',' AGENTS SUPERVISOR ',' ','',NULL,'','','','','Y');
/*!40000 ALTER TABLE `vicidial_user_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_user_list_new_lead`
--

DROP TABLE IF EXISTS `vicidial_user_list_new_lead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_user_list_new_lead` (
  `user` varchar(20) NOT NULL,
  `list_id` bigint(14) unsigned DEFAULT '999',
  `user_override` smallint(5) DEFAULT '-1',
  `new_count` mediumint(8) unsigned DEFAULT '0',
  UNIQUE KEY `userlistnew` (`user`,`list_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_user_list_new_lead`
--

LOCK TABLES `vicidial_user_list_new_lead` WRITE;
/*!40000 ALTER TABLE `vicidial_user_list_new_lead` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_user_list_new_lead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_user_log`
--

DROP TABLE IF EXISTS `vicidial_user_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_user_log` (
  `user_log_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(20) DEFAULT NULL,
  `event` varchar(50) DEFAULT NULL,
  `campaign_id` varchar(8) DEFAULT NULL,
  `event_date` datetime DEFAULT NULL,
  `event_epoch` int(10) unsigned DEFAULT NULL,
  `user_group` varchar(20) DEFAULT NULL,
  `session_id` varchar(20) DEFAULT NULL,
  `server_ip` varchar(15) DEFAULT NULL,
  `extension` varchar(50) DEFAULT NULL,
  `computer_ip` varchar(15) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `data` varchar(255) DEFAULT NULL,
  `phone_login` varchar(15) DEFAULT '',
  `server_phone` varchar(15) DEFAULT '',
  `phone_ip` varchar(15) DEFAULT '',
  `webserver` smallint(5) unsigned DEFAULT '0',
  `login_url` int(9) unsigned DEFAULT '0',
  `browser_width` smallint(5) unsigned DEFAULT '0',
  `browser_height` smallint(5) unsigned DEFAULT '0',
  PRIMARY KEY (`user_log_id`),
  KEY `user` (`user`),
  KEY `phone_ip` (`phone_ip`),
  KEY `vuled` (`event_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_user_log`
--

LOCK TABLES `vicidial_user_log` WRITE;
/*!40000 ALTER TABLE `vicidial_user_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_user_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_user_territories`
--

DROP TABLE IF EXISTS `vicidial_user_territories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_user_territories` (
  `user` varchar(20) NOT NULL,
  `territory` varchar(100) DEFAULT '',
  `level` enum('TOP_AGENT','STANDARD_AGENT','BOTTOM_AGENT') DEFAULT 'STANDARD_AGENT',
  UNIQUE KEY `userterritory` (`user`,`territory`),
  KEY `user` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_user_territories`
--

LOCK TABLES `vicidial_user_territories` WRITE;
/*!40000 ALTER TABLE `vicidial_user_territories` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_user_territories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_user_territory_log`
--

DROP TABLE IF EXISTS `vicidial_user_territory_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_user_territory_log` (
  `user` varchar(20) DEFAULT NULL,
  `campaign_id` varchar(20) DEFAULT NULL,
  `event_date` datetime DEFAULT NULL,
  `agent_territories` text,
  KEY `user` (`user`),
  KEY `event_date` (`event_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_user_territory_log`
--

LOCK TABLES `vicidial_user_territory_log` WRITE;
/*!40000 ALTER TABLE `vicidial_user_territory_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_user_territory_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_users`
--

DROP TABLE IF EXISTS `vicidial_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_users` (
  `user_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(20) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `user_level` tinyint(3) unsigned DEFAULT '1',
  `user_group` varchar(20) DEFAULT NULL,
  `phone_login` varchar(20) DEFAULT NULL,
  `phone_pass` varchar(100) DEFAULT NULL,
  `delete_users` enum('0','1') DEFAULT '0',
  `delete_user_groups` enum('0','1') DEFAULT '0',
  `delete_lists` enum('0','1') DEFAULT '0',
  `delete_campaigns` enum('0','1') DEFAULT '0',
  `delete_ingroups` enum('0','1') DEFAULT '0',
  `delete_remote_agents` enum('0','1') DEFAULT '0',
  `load_leads` enum('0','1') DEFAULT '0',
  `campaign_detail` enum('0','1') DEFAULT '0',
  `ast_admin_access` enum('0','1') DEFAULT '0',
  `ast_delete_phones` enum('0','1') DEFAULT '0',
  `delete_scripts` enum('0','1') DEFAULT '0',
  `modify_leads` enum('0','1') DEFAULT '0',
  `hotkeys_active` enum('0','1') DEFAULT '0',
  `change_agent_campaign` enum('0','1') DEFAULT '0',
  `agent_choose_ingroups` enum('0','1') DEFAULT '1',
  `closer_campaigns` text,
  `scheduled_callbacks` enum('0','1') DEFAULT '1',
  `agentonly_callbacks` enum('0','1') DEFAULT '0',
  `agentcall_manual` enum('0','1') DEFAULT '0',
  `vicidial_recording` enum('0','1') DEFAULT '1',
  `vicidial_transfers` enum('0','1') DEFAULT '1',
  `delete_filters` enum('0','1') DEFAULT '0',
  `alter_agent_interface_options` enum('0','1') DEFAULT '0',
  `closer_default_blended` enum('0','1') DEFAULT '0',
  `delete_call_times` enum('0','1') DEFAULT '0',
  `modify_call_times` enum('0','1') DEFAULT '0',
  `modify_users` enum('0','1') DEFAULT '0',
  `modify_campaigns` enum('0','1') DEFAULT '0',
  `modify_lists` enum('0','1') DEFAULT '0',
  `modify_scripts` enum('0','1') DEFAULT '0',
  `modify_filters` enum('0','1') DEFAULT '0',
  `modify_ingroups` enum('0','1') DEFAULT '0',
  `modify_usergroups` enum('0','1') DEFAULT '0',
  `modify_remoteagents` enum('0','1') DEFAULT '0',
  `modify_servers` enum('0','1') DEFAULT '0',
  `view_reports` enum('0','1') DEFAULT '0',
  `vicidial_recording_override` enum('DISABLED','NEVER','ONDEMAND','ALLCALLS','ALLFORCE') DEFAULT 'DISABLED',
  `alter_custdata_override` enum('NOT_ACTIVE','ALLOW_ALTER') DEFAULT 'NOT_ACTIVE',
  `qc_enabled` enum('1','0') DEFAULT '0',
  `qc_user_level` int(2) DEFAULT '1',
  `qc_pass` enum('1','0') DEFAULT '0',
  `qc_finish` enum('1','0') DEFAULT '0',
  `qc_commit` enum('1','0') DEFAULT '0',
  `add_timeclock_log` enum('1','0') DEFAULT '0',
  `modify_timeclock_log` enum('1','0') DEFAULT '0',
  `delete_timeclock_log` enum('1','0') DEFAULT '0',
  `alter_custphone_override` enum('NOT_ACTIVE','ALLOW_ALTER') DEFAULT 'NOT_ACTIVE',
  `vdc_agent_api_access` enum('0','1') DEFAULT '0',
  `modify_inbound_dids` enum('1','0') DEFAULT '0',
  `delete_inbound_dids` enum('1','0') DEFAULT '0',
  `active` enum('Y','N') DEFAULT 'Y',
  `alert_enabled` enum('1','0') DEFAULT '0',
  `download_lists` enum('1','0') DEFAULT '0',
  `agent_shift_enforcement_override` enum('DISABLED','OFF','START','ALL') DEFAULT 'DISABLED',
  `manager_shift_enforcement_override` enum('0','1') DEFAULT '0',
  `shift_override_flag` enum('0','1') DEFAULT '0',
  `export_reports` enum('1','0') DEFAULT '0',
  `delete_from_dnc` enum('0','1') DEFAULT '0',
  `email` varchar(100) DEFAULT '',
  `user_code` varchar(100) DEFAULT '',
  `territory` varchar(100) DEFAULT '',
  `allow_alerts` enum('0','1') DEFAULT '0',
  `agent_choose_territories` enum('0','1') DEFAULT '1',
  `custom_one` varchar(100) DEFAULT '',
  `custom_two` varchar(100) DEFAULT '',
  `custom_three` varchar(100) DEFAULT '',
  `custom_four` varchar(100) DEFAULT '',
  `custom_five` varchar(100) DEFAULT '',
  `voicemail_id` varchar(10) DEFAULT '',
  `agent_call_log_view_override` enum('DISABLED','Y','N') DEFAULT 'DISABLED',
  `callcard_admin` enum('1','0') DEFAULT '0',
  `agent_choose_blended` enum('0','1') DEFAULT '1',
  `realtime_block_user_info` enum('0','1') DEFAULT '0',
  `custom_fields_modify` enum('0','1') DEFAULT '0',
  `force_change_password` enum('Y','N') DEFAULT 'N',
  `agent_lead_search_override` enum('NOT_ACTIVE','ENABLED','LIVE_CALL_INBOUND','LIVE_CALL_INBOUND_AND_MANUAL','DISABLED') DEFAULT 'NOT_ACTIVE',
  `modify_shifts` enum('1','0') DEFAULT '0',
  `modify_phones` enum('1','0') DEFAULT '0',
  `modify_carriers` enum('1','0') DEFAULT '0',
  `modify_labels` enum('1','0') DEFAULT '0',
  `modify_statuses` enum('1','0') DEFAULT '0',
  `modify_voicemail` enum('1','0') DEFAULT '0',
  `modify_audiostore` enum('1','0') DEFAULT '0',
  `modify_moh` enum('1','0') DEFAULT '0',
  `modify_tts` enum('1','0') DEFAULT '0',
  `preset_contact_search` enum('NOT_ACTIVE','ENABLED','DISABLED') DEFAULT 'NOT_ACTIVE',
  `modify_contacts` enum('1','0') DEFAULT '0',
  `modify_same_user_level` enum('0','1') DEFAULT '1',
  `admin_hide_lead_data` enum('0','1') DEFAULT '0',
  `admin_hide_phone_data` enum('0','1','2_DIGITS','3_DIGITS','4_DIGITS') DEFAULT '0',
  `agentcall_email` enum('0','1') DEFAULT '0',
  `modify_email_accounts` enum('0','1') DEFAULT '0',
  `failed_login_count` tinyint(3) unsigned DEFAULT '0',
  `last_login_date` datetime DEFAULT '2001-01-01 00:00:01',
  `last_ip` varchar(15) DEFAULT '',
  `pass_hash` varchar(500) DEFAULT '',
  `alter_admin_interface_options` enum('0','1') DEFAULT '1',
  `max_inbound_calls` smallint(5) unsigned DEFAULT '0',
  `modify_custom_dialplans` enum('1','0') DEFAULT '0',
  `wrapup_seconds_override` smallint(4) DEFAULT '-1',
  `modify_languages` enum('1','0') DEFAULT '0',
  `selected_language` varchar(100) DEFAULT 'default English',
  `user_choose_language` enum('1','0') DEFAULT '0',
  `ignore_group_on_search` enum('1','0') DEFAULT '0',
  `api_list_restrict` enum('1','0') DEFAULT '0',
  `api_allowed_functions` varchar(1000) DEFAULT ' ALL_FUNCTIONS ',
  `lead_filter_id` varchar(20) DEFAULT 'NONE',
  `admin_cf_show_hidden` enum('1','0') DEFAULT '0',
  `agentcall_chat` enum('1','0') DEFAULT '0',
  `user_hide_realtime` enum('1','0') DEFAULT '0',
  `access_recordings` enum('0','1') DEFAULT '0',
  `modify_colors` enum('1','0') DEFAULT '0',
  `avatar` longtext,
  `api_only_user` enum('0','1') DEFAULT '0',
  `modify_auto_reports` enum('1','0') DEFAULT '0',
  `modify_ip_lists` enum('1','0') DEFAULT '0',
  `ignore_ip_list` enum('1','0') DEFAULT '0',
  `ready_max_logout` mediumint(7) DEFAULT '-1',
  `export_gdpr_leads` enum('0','1','2') DEFAULT '0',
  `pause_code_approval` enum('1','0') DEFAULT '0',
  `user_nickname` varchar(50) DEFAULT '',
  `user_new_lead_limit` smallint(5) DEFAULT '-1',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user` (`user`)
) ENGINE=MyISAM AUTO_INCREMENT=1479 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_users`
--

LOCK TABLES `vicidial_users` WRITE;
/*!40000 ALTER TABLE `vicidial_users` DISABLE KEYS */;
INSERT INTO `vicidial_users` VALUES (2,'VDAD','','Outbound Auto Dial',1,'ADMIN',NULL,NULL,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','1',NULL,'1','0','0','1','1','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','DISABLED','NOT_ACTIVE','0',1,'0','0','0','0','0','0','NOT_ACTIVE','0','0','0','N','0','0','DISABLED','0','0','0','0','','','','0','1','','','','','','','DISABLED','0','1','0','0','N','NOT_ACTIVE','0','0','0','0','0','0','0','0','0','NOT_ACTIVE','0','1','0','0','0','0',0,'2001-01-01 00:00:01','','','1',0,'0',-1,'0','default English','0','0','0',' ALL_FUNCTIONS ','NONE','0','0','0','0','0',NULL,'0','0','0','0',-1,'0','0','',-1),(26,'VDCL','','Inbound No Agent',1,'ADMIN',NULL,NULL,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','1',NULL,'1','0','0','1','1','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','DISABLED','NOT_ACTIVE','0',1,'0','0','0','0','0','0','NOT_ACTIVE','0','0','0','N','0','0','DISABLED','0','0','0','0','','','','0','1','','','','','','','DISABLED','0','1','0','0','N','NOT_ACTIVE','0','0','0','0','0','0','0','0','0','NOT_ACTIVE','0','1','0','0','0','0',0,'2001-01-01 00:00:01','','','1',0,'0',-1,'0','default English','0','0','0',' ALL_FUNCTIONS ','NONE','0','0','0','0','0',NULL,'0','0','0','0',-1,'0','0','',-1),(1352,'goAPI','','GOautodial API User',99,'ADMIN','','','1','1','1','1','1','1','1','1','1','1','1','1','0','1','1','INGROUP18772999379 -','1','0','0','1','1','1','1','0','1','1','1','1','1','1','1','1','1','1','1','1','DISABLED','NOT_ACTIVE','0',1,'0','0','0','1','1','1','NOT_ACTIVE','1','1','1','Y','0','1','DISABLED','1','0','1','1','','','','0','','','','','','','','DISABLED','1','1','0','1','N','NOT_ACTIVE','1','1','1','1','1','1','1','1','1','NOT_ACTIVE','1','1','0','0','0','0',0,'0000-00-00 00:00:00','10.1.3.10','KToB93bzjGd1RS4mDqePJ6Uk.jgNRrK','1',0,'1',-1,'0','default English','0','0','1',' ALL_FUNCTIONS ','NONE','0','0','0','0','1',NULL,'0','0','0','0',-1,'0','0','',-1),(1478,'agent001','','Agent 001',1,'AGENTS','5474470533','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','1',NULL,'1','1','1','1','1','0','0','1','0','0','0','0','0','0','0','0','0','0','0','0','DISABLED','NOT_ACTIVE','0',1,'0','0','0','0','0','0','NOT_ACTIVE','1','0','0','Y','0','0','DISABLED','0','0','0','0','','','','0','1','','','','','','','DISABLED','0','1','0','0','N','NOT_ACTIVE','0','0','0','0','0','0','0','0','0','NOT_ACTIVE','0','1','0','0','0','0',0,'2001-01-01 00:00:01','','6T/67WuVhg/r2ZozdbB1zIlxw5tzeSq','1',0,'0',-1,'0','default English','0','0','0',' ALL_FUNCTIONS ','NONE','0','0','0','0','0',NULL,'0','0','0','0',-1,'0','0','',-1),(1463,'goadmin','','goadmin',9,'ADMIN','7254747950','','0','0','0','0','0','0','0','0','0','0','0','0','1','0','1',NULL,'1','1','1','1','1','0','0','1','0','0','0','0','0','0','0','0','0','0','0','0','ALLFORCE','NOT_ACTIVE','0',1,'0','0','0','0','0','0','NOT_ACTIVE','1','0','0','Y','0','0','DISABLED','0','0','0','0','info@goautodial.com','','','0','1','','','','','','2920','DISABLED','0','1','0','0','N','ENABLED','0','0','0','0','0','0','0','0','0','NOT_ACTIVE','0','','0','0','0','0',0,'2001-01-01 00:00:01','','h0CAwQ/of1y0YFKgut1hVcqNl1SMSNu','1',0,'0',-1,'0','default English','0','0','0',' ALL_FUNCTIONS ','NONE','0','0','0','0','0',NULL,'0','0','0','0',-1,'0','0','',-1);
/*!40000 ALTER TABLE `vicidial_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `vicidial_users_view`
--

DROP TABLE IF EXISTS `vicidial_users_view`;
/*!50001 DROP VIEW IF EXISTS `vicidial_users_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vicidial_users_view` (
  `user_id` tinyint NOT NULL,
  `user` tinyint NOT NULL,
  `full_name` tinyint NOT NULL,
  `user_group` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `vicidial_vdad_log`
--

DROP TABLE IF EXISTS `vicidial_vdad_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_vdad_log` (
  `caller_code` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `server_ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `call_date` datetime DEFAULT NULL,
  `epoch_micro` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `db_time` datetime NOT NULL,
  `run_time` varchar(20) COLLATE utf8_unicode_ci DEFAULT '0',
  `vdad_script` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `lead_id` int(10) unsigned DEFAULT '0',
  `stage` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `step` smallint(5) unsigned DEFAULT '0',
  KEY `caller_code` (`caller_code`),
  KEY `vdad_dbtime_key` (`db_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_vdad_log`
--

LOCK TABLES `vicidial_vdad_log` WRITE;
/*!40000 ALTER TABLE `vicidial_vdad_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_vdad_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_voicemail`
--

DROP TABLE IF EXISTS `vicidial_voicemail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_voicemail` (
  `voicemail_id` varchar(10) NOT NULL,
  `active` enum('Y','N') DEFAULT 'Y',
  `pass` varchar(10) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `messages` int(4) DEFAULT '0',
  `old_messages` int(4) DEFAULT '0',
  `email` varchar(100) DEFAULT NULL,
  `delete_vm_after_email` enum('N','Y') DEFAULT 'N',
  `voicemail_timezone` varchar(30) DEFAULT 'eastern',
  `voicemail_options` varchar(255) DEFAULT '',
  `user_group` varchar(20) DEFAULT '---ALL---',
  `voicemail_greeting` varchar(100) DEFAULT '',
  `on_login_report` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`voicemail_id`),
  UNIQUE KEY `voicemail_id` (`voicemail_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_voicemail`
--

LOCK TABLES `vicidial_voicemail` WRITE;
/*!40000 ALTER TABLE `vicidial_voicemail` DISABLE KEYS */;
INSERT INTO `vicidial_voicemail` VALUES ('3142018','Y','3142018','Wits robocall message',57,0,'noc@goautodial.com','N','eastern','','ADMIN','','N'),('3142019','Y','3142019','Test DID route to voicemail for Surveys',23,0,'noc@goautodial.com','N','eastern','','6022Test2','','N'),('2921','Y','2921','Sales Team',27,0,'sales@goautodial.com','N','eastern','','ADMIN','','N'),('2920','Y','2920','Customer Service Team',9,0,'cs@goautodial.com','N','eastern','','ADMIN','','N');
/*!40000 ALTER TABLE `vicidial_voicemail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_webservers`
--

DROP TABLE IF EXISTS `vicidial_webservers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_webservers` (
  `webserver_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `webserver` varchar(125) DEFAULT '',
  `hostname` varchar(125) DEFAULT '',
  PRIMARY KEY (`webserver_id`),
  UNIQUE KEY `vdweb` (`webserver`,`hostname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_webservers`
--

LOCK TABLES `vicidial_webservers` WRITE;
/*!40000 ALTER TABLE `vicidial_webservers` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_webservers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_xfer_log`
--

DROP TABLE IF EXISTS `vicidial_xfer_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_xfer_log` (
  `xfercallid` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `lead_id` int(9) unsigned NOT NULL,
  `list_id` bigint(14) unsigned DEFAULT NULL,
  `campaign_id` varchar(20) DEFAULT NULL,
  `call_date` datetime DEFAULT NULL,
  `phone_code` varchar(10) DEFAULT NULL,
  `phone_number` varchar(18) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `closer` varchar(20) DEFAULT NULL,
  `front_uniqueid` varchar(50) DEFAULT '',
  `close_uniqueid` varchar(50) DEFAULT '',
  PRIMARY KEY (`xfercallid`),
  KEY `lead_id` (`lead_id`),
  KEY `call_date` (`call_date`),
  KEY `date_user` (`call_date`,`user`),
  KEY `date_closer` (`call_date`,`closer`),
  KEY `phone_number` (`phone_number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_xfer_log`
--

LOCK TABLES `vicidial_xfer_log` WRITE;
/*!40000 ALTER TABLE `vicidial_xfer_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_xfer_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_xfer_log_archive`
--

DROP TABLE IF EXISTS `vicidial_xfer_log_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_xfer_log_archive` (
  `xfercallid` int(9) unsigned NOT NULL,
  `lead_id` int(9) unsigned NOT NULL,
  `list_id` bigint(14) unsigned DEFAULT NULL,
  `campaign_id` varchar(20) DEFAULT NULL,
  `call_date` datetime DEFAULT NULL,
  `phone_code` varchar(10) DEFAULT NULL,
  `phone_number` varchar(18) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `closer` varchar(20) DEFAULT NULL,
  `front_uniqueid` varchar(50) DEFAULT '',
  `close_uniqueid` varchar(50) DEFAULT '',
  PRIMARY KEY (`xfercallid`),
  KEY `lead_id` (`lead_id`),
  KEY `call_date` (`call_date`),
  KEY `date_user` (`call_date`,`user`),
  KEY `date_closer` (`call_date`,`closer`),
  KEY `phone_number` (`phone_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_xfer_log_archive`
--

LOCK TABLES `vicidial_xfer_log_archive` WRITE;
/*!40000 ALTER TABLE `vicidial_xfer_log_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_xfer_log_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_xfer_presets`
--

DROP TABLE IF EXISTS `vicidial_xfer_presets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_xfer_presets` (
  `campaign_id` varchar(20) NOT NULL,
  `preset_name` varchar(40) NOT NULL,
  `preset_number` varchar(50) NOT NULL,
  `preset_dtmf` varchar(50) DEFAULT '',
  `preset_hide_number` enum('Y','N') DEFAULT 'N',
  KEY `preset_name` (`preset_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_xfer_presets`
--

LOCK TABLES `vicidial_xfer_presets` WRITE;
/*!40000 ALTER TABLE `vicidial_xfer_presets` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_xfer_presets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vicidial_xfer_stats`
--

DROP TABLE IF EXISTS `vicidial_xfer_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vicidial_xfer_stats` (
  `campaign_id` varchar(20) NOT NULL,
  `preset_name` varchar(40) NOT NULL,
  `xfer_count` smallint(5) unsigned DEFAULT '0',
  KEY `campaign_id` (`campaign_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vicidial_xfer_stats`
--

LOCK TABLES `vicidial_xfer_stats` WRITE;
/*!40000 ALTER TABLE `vicidial_xfer_stats` DISABLE KEYS */;
/*!40000 ALTER TABLE `vicidial_xfer_stats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vtiger_rank_data`
--

DROP TABLE IF EXISTS `vtiger_rank_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vtiger_rank_data` (
  `account` varchar(20) NOT NULL,
  `seqacct` varchar(20) NOT NULL,
  `last_attempt_days` smallint(5) unsigned NOT NULL,
  `orders` smallint(5) NOT NULL,
  `net_sales` smallint(5) NOT NULL,
  `net_sales_ly` smallint(5) NOT NULL,
  `percent_variance` varchar(10) NOT NULL,
  `imu` varchar(10) NOT NULL,
  `aov` smallint(5) NOT NULL,
  `returns` smallint(5) NOT NULL,
  `rank` smallint(5) NOT NULL,
  PRIMARY KEY (`account`),
  UNIQUE KEY `seqacct` (`seqacct`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vtiger_rank_data`
--

LOCK TABLES `vtiger_rank_data` WRITE;
/*!40000 ALTER TABLE `vtiger_rank_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `vtiger_rank_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vtiger_rank_parameters`
--

DROP TABLE IF EXISTS `vtiger_rank_parameters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vtiger_rank_parameters` (
  `parameter_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `parameter` varchar(20) NOT NULL,
  `lower_range` varchar(20) NOT NULL,
  `upper_range` varchar(20) NOT NULL,
  `points` smallint(5) NOT NULL,
  PRIMARY KEY (`parameter_id`),
  KEY `parameter` (`parameter`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vtiger_rank_parameters`
--

LOCK TABLES `vtiger_rank_parameters` WRITE;
/*!40000 ALTER TABLE `vtiger_rank_parameters` DISABLE KEYS */;
/*!40000 ALTER TABLE `vtiger_rank_parameters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vtiger_vicidial_roles`
--

DROP TABLE IF EXISTS `vtiger_vicidial_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vtiger_vicidial_roles` (
  `user_level` tinyint(2) DEFAULT NULL,
  `vtiger_role` varchar(5) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vtiger_vicidial_roles`
--

LOCK TABLES `vtiger_vicidial_roles` WRITE;
/*!40000 ALTER TABLE `vtiger_vicidial_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `vtiger_vicidial_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `web_client_sessions`
--

DROP TABLE IF EXISTS `web_client_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `web_client_sessions` (
  `extension` varchar(100) NOT NULL,
  `server_ip` varchar(15) NOT NULL,
  `program` enum('agc','vicidial','monitor','other') DEFAULT 'agc',
  `start_time` datetime NOT NULL,
  `session_name` varchar(40) NOT NULL,
  UNIQUE KEY `session_name` (`session_name`)
) ENGINE=MEMORY DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `web_client_sessions`
--

LOCK TABLES `web_client_sessions` WRITE;
/*!40000 ALTER TABLE `web_client_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `web_client_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `www_phrases`
--

DROP TABLE IF EXISTS `www_phrases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `www_phrases` (
  `phrase_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phrase_text` varchar(10000) COLLATE utf8_unicode_ci DEFAULT '',
  `php_filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `php_directory` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `source` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `insert_date` datetime DEFAULT NULL,
  PRIMARY KEY (`phrase_id`),
  KEY `phrase_text` (`phrase_text`(333))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `www_phrases`
--

LOCK TABLES `www_phrases` WRITE;
/*!40000 ALTER TABLE `www_phrases` DISABLE KEYS */;
/*!40000 ALTER TABLE `www_phrases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `go_viewLists`
--

/*!50001 DROP TABLE IF EXISTS `go_viewLists`*/;
/*!50001 DROP VIEW IF EXISTS `go_viewLists`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `go_viewLists` AS select `vls`.`list_id` AS `list_id`,`vls`.`list_name` AS `list_name`,`vls`.`list_description` AS `list_description`,count(0) AS `tally`,`vls`.`active` AS `active`,`vls`.`list_lastcalldate` AS `list_lastcalldate`,`vls`.`campaign_id` AS `campaign_id`,`vls`.`reset_time` AS `reset_time` from (`vicidial_lists` `vls` join `vicidial_list` `vl`) where (`vls`.`list_id` = `vl`.`list_id`) group by `vls`.`list_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `goautodial_recordings_view`
--

/*!50001 DROP TABLE IF EXISTS `goautodial_recordings_view`*/;
/*!50001 DROP VIEW IF EXISTS `goautodial_recordings_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `goautodial_recordings_view` AS select `rec`.`recording_id` AS `recording_id`,`rec`.`lead_id` AS `lead_id`,`vl`.`phone_number` AS `phone`,`rec`.`start_time` AS `call_date`,sec_to_time(`rec`.`length_in_sec`) AS `duration`,`us`.`full_name` AS `agent`,`st`.`status_name` AS `disposition`,concat_ws(_latin1' ',`vl`.`first_name`,`vl`.`last_name`) AS `fullname`,`rec`.`location` AS `location`,`rec`.`filename` AS `filename`,`vls`.`campaign_id` AS `campaign_id`,`vl`.`list_id` AS `list_id` from ((((`recording_log` `rec` join `vicidial_list` `vl` on((`vl`.`lead_id` = `rec`.`lead_id`))) join `vicidial_lists` `vls` on((`vl`.`list_id` = `vls`.`list_id`))) join `vicidial_users` `us` on((`us`.`user` = `rec`.`user`))) join `vicidial_statuses` `st` on((`st`.`status` = `vl`.`status`))) where ((`rec`.`length_in_sec` > 1) and (`rec`.`lead_id` > 1)) order by `rec`.`lead_id`,`vl`.`list_id`,`vl`.`phone_number`,`rec`.`start_time` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `goautodial_recordings_view_all`
--

/*!50001 DROP TABLE IF EXISTS `goautodial_recordings_view_all`*/;
/*!50001 DROP VIEW IF EXISTS `goautodial_recordings_view_all`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `goautodial_recordings_view_all` AS select `rec`.`recording_id` AS `recording_id`,`rec`.`lead_id` AS `lead_id`,`vl`.`phone_number` AS `phone`,`rec`.`start_time` AS `call_date`,sec_to_time(`rec`.`length_in_sec`) AS `duration`,`us`.`full_name` AS `agent`,`st`.`status_name` AS `disposition`,`vcs`.`status_name` AS `campaign_dispo`,concat_ws(_latin1'',`vl`.`first_name`,`vl`.`last_name`) AS `fullname`,`rec`.`location` AS `location`,`rec`.`filename` AS `filename`,`vls`.`campaign_id` AS `campaign_id`,`vl`.`list_id` AS `list_id` from (((((`recording_log` `rec` left join `vicidial_list` `vl` on((`rec`.`lead_id` = `vl`.`lead_id`))) left join `vicidial_lists` `vls` on((`vl`.`list_id` = `vls`.`list_id`))) join `vicidial_users` `us` on((`rec`.`user` = `us`.`user`))) left join `vicidial_statuses` `st` on((`vl`.`status` = `st`.`status`))) left join `vicidial_campaign_statuses` `vcs` on((`vl`.`status` = `vcs`.`status`))) where (`rec`.`lead_id` > 1) order by `rec`.`lead_id`,`vl`.`list_id`,`vl`.`phone_number`,`rec`.`start_time` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `goautodial_recordings_views`
--

/*!50001 DROP TABLE IF EXISTS `goautodial_recordings_views`*/;
/*!50001 DROP VIEW IF EXISTS `goautodial_recordings_views`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `goautodial_recordings_views` AS select `rec`.`recording_id` AS `recording_id`,`rec`.`lead_id` AS `lead_id`,`vl`.`phone_number` AS `phone`,`rec`.`start_time` AS `call_date`,sec_to_time(`rec`.`length_in_sec`) AS `duration`,`us`.`full_name` AS `agent`,`st`.`status_name` AS `disposition`,`vcs`.`status_name` AS `campaign_dispo`,concat_ws(_latin1' ',`vl`.`first_name`,`vl`.`last_name`) AS `fullname`,`rec`.`location` AS `location`,`rec`.`filename` AS `filename`,`vls`.`campaign_id` AS `campaign_id`,`vl`.`list_id` AS `list_id` from (((((`recording_log` `rec` left join `vicidial_list` `vl` on((`rec`.`lead_id` = `vl`.`lead_id`))) left join `vicidial_lists` `vls` on((`vl`.`list_id` = `vls`.`list_id`))) join `vicidial_users` `us` on((`rec`.`user` = `us`.`user`))) left join `vicidial_statuses` `st` on((`vl`.`status` = `st`.`status`))) left join `vicidial_campaign_statuses` `vcs` on((`vl`.`status` = `vcs`.`status`))) where ((`rec`.`length_in_sec` > 1) and (`rec`.`lead_id` > 1)) order by `rec`.`lead_id`,`vl`.`list_id`,`vl`.`phone_number`,`rec`.`start_time` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `temp_recording_view`
--

/*!50001 DROP TABLE IF EXISTS `temp_recording_view`*/;
/*!50001 DROP VIEW IF EXISTS `temp_recording_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `temp_recording_view` AS select `recrd`.`recording_id` AS `recording_id`,`recrd`.`lead_id` AS `lead_id`,`vl`.`phone_number` AS `phone`,`recrd`.`start_time` AS `call_date`,`recrd`.`length_in_sec` AS `duration`,`vu`.`full_name` AS `agent`,`vs`.`status_name` AS `disposition`,`vcs`.`status_name` AS `campaign_dispo`,concat_ws(_latin1' ',`vl`.`first_name`,`vl`.`last_name`) AS `fullname`,`recrd`.`location` AS `location`,`recrd`.`filename` AS `filename`,`vl`.`list_id` AS `list_id`,`vu`.`user_group` AS `user_group` from (((((`recording_log` `recrd` left join `vicidial_users` `vu` on((`recrd`.`user` = `vu`.`user`))) left join `vicidial_user_groups` `vug` on((`vu`.`user_group` = `vug`.`user_group`))) left join `vicidial_list` `vl` on((`recrd`.`lead_id` = `vl`.`lead_id`))) left join `vicidial_statuses` `vs` on((`vl`.`status` = `vs`.`status`))) left join `vicidial_campaign_statuses` `vcs` on((`vl`.`status` = `vcs`.`status`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vicidial_list_view`
--

/*!50001 DROP TABLE IF EXISTS `vicidial_list_view`*/;
/*!50001 DROP VIEW IF EXISTS `vicidial_list_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vicidial_list_view` AS select `vicidial_list`.`lead_id` AS `lead_id`,concat_ws(_latin1' ',`vicidial_list`.`first_name`,`vicidial_list`.`last_name`) AS `fullname`,`vicidial_list`.`status` AS `status`,`vicidial_list`.`phone_number` AS `phone_number`,`vicidial_list`.`address1` AS `address1`,`vicidial_list`.`address2` AS `address2`,`vicidial_list`.`address3` AS `address3`,`vicidial_list`.`city` AS `city`,`vicidial_list`.`state` AS `state`,`vicidial_list`.`province` AS `province`,`vicidial_list`.`date_of_birth` AS `date_of_birth`,`vicidial_list`.`alt_phone` AS `alt_phone` from `vicidial_list` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vicidial_users_view`
--

/*!50001 DROP TABLE IF EXISTS `vicidial_users_view`*/;
/*!50001 DROP VIEW IF EXISTS `vicidial_users_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vicidial_users_view` AS select `vicidial_users`.`user_id` AS `user_id`,`vicidial_users`.`user` AS `user`,`vicidial_users`.`full_name` AS `full_name`,`vicidial_users`.`user_group` AS `user_group` from `vicidial_users` order by `vicidial_users`.`user_id`,`vicidial_users`.`user`,`vicidial_users`.`full_name` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-09-24 14:54:43
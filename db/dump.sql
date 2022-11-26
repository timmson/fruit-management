-- MySQL dump 10.13  Distrib 5.7.40, for Linux (x86_64)
--
-- Host: localhost    Database: fruit
-- ------------------------------------------------------
-- Server version       5.7.40

USE `fruit`;

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
-- Table structure for table `fm_cat_log`
--

DROP TABLE IF EXISTS `fm_cat_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fm_cat_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fm_name` varchar(100) NOT NULL,
  `fm_descr` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fm_cat_log`
--

LOCK TABLES `fm_cat_log` WRITE;
/*!40000 ALTER TABLE `fm_cat_log` DISABLE KEYS */;
INSERT INTO `fm_cat_log` VALUES (1,'log','Logging'),(2,'cmnt','Comments'),(3,'url','Link'),(4,'est','Estimation');
/*!40000 ALTER TABLE `fm_cat_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fm_priority`
--

DROP TABLE IF EXISTS `fm_priority`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fm_priority` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fm_name` varchar(100) NOT NULL,
  `fm_descr` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fm_priority`
--

LOCK TABLES `fm_priority` WRITE;
/*!40000 ALTER TABLE `fm_priority` DISABLE KEYS */;
INSERT INTO `fm_priority` VALUES (1,'high','High'),(2,'medium','Medium'),(3,'low','Low');
/*!40000 ALTER TABLE `fm_priority` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fm_project`
--

DROP TABLE IF EXISTS `fm_project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fm_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fm_name` varchar(100) NOT NULL,
  `fm_descr` varchar(255) NOT NULL,
  `fm_manager` varchar(255) NOT NULL,
  `fm_parent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fm_project`
--

LOCK TABLES `fm_project` WRITE;
/*!40000 ALTER TABLE `fm_project` DISABLE KEYS */;
INSERT INTO `fm_project` VALUES (1,'REL','Release project','manager',NULL),(2,'SAMPLE','Some new project','manager',NULL);
/*!40000 ALTER TABLE `fm_project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fm_relation`
--

DROP TABLE IF EXISTS `fm_relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fm_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fm_parent` int(11) NOT NULL,
  `fm_child` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fm_relation`
--

LOCK TABLES `fm_relation` WRITE;
/*!40000 ALTER TABLE `fm_relation` DISABLE KEYS */;
INSERT INTO `fm_relation` VALUES (1,0,0),(2,1,2),(3,2,3);
/*!40000 ALTER TABLE `fm_relation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fm_state`
--

DROP TABLE IF EXISTS `fm_state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fm_state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fm_name` varchar(100) NOT NULL,
  `fm_descr` varchar(255) NOT NULL,
  `fm_next_state` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fm_state`
--

LOCK TABLES `fm_state` WRITE;
/*!40000 ALTER TABLE `fm_state` DISABLE KEYS */;
INSERT INTO `fm_state` VALUES (1,'new','New',2),(2,'planned','Planned',3),(3,'in_progress','In progress',5),(4,'decline','Decline',NULL),(5,'test','Testing',6),(6,'done','Done',NULL);
/*!40000 ALTER TABLE `fm_state` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fm_subscribe`
--

DROP TABLE IF EXISTS `fm_subscribe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fm_subscribe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fm_task` int(11) NOT NULL,
  `fm_user` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fm_subscribe`
--

LOCK TABLES `fm_subscribe` WRITE;
/*!40000 ALTER TABLE `fm_subscribe` DISABLE KEYS */;
INSERT INTO `fm_subscribe` VALUES (1,3,'fruit');
/*!40000 ALTER TABLE `fm_subscribe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fm_task`
--

DROP TABLE IF EXISTS `fm_task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fm_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fm_name` varchar(100) NOT NULL,
  `fm_descr` varchar(255) DEFAULT NULL,
  `fm_project` int(11) NOT NULL,
  `fm_state` int(11) NOT NULL,
  `fm_priority` int(11) NOT NULL DEFAULT '2',
  `fm_plan` int(11) NOT NULL DEFAULT '0',
  `fm_user` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fm_task`
--

LOCK TABLES `fm_task` WRITE;
/*!40000 ALTER TABLE `fm_task` DISABLE KEYS */;
INSERT INTO `fm_task` VALUES (1,'RFC','Release 1',1,3,2,100,'fruit'),(2,'Some','work',2,3,2,100,'fruit'),(3,'Some','work',2,3,2,100,'vegetable');
/*!40000 ALTER TABLE `fm_task` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `i_add_work_log` AFTER INSERT ON `fm_task` FOR EACH ROW BEGIN
        INSERT INTO fm_work_log
    SELECT  null, new.id, 1, curdate(), now(), 0, concat(s.fm_descr), new.fm_user
    FROM fm_state s WHERE new.fm_state = s.id;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `u_add_work_log` AFTER UPDATE ON `fm_task` FOR EACH ROW BEGIN
    IF new.fm_state <> old.fm_state THEN
        INSERT INTO fm_work_log
        SELECT  null, new.id, 1, curdate(), now(), 0, concat(s.fm_descr), new.fm_user
        FROM fm_state s WHERE new.fm_state = s.id;
     END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `d_remove_work_log` AFTER DELETE ON `fm_task` FOR EACH ROW BEGIN
   DELETE FROM fm_work_log where fm_task = old.id;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `fm_timesheet`
--

DROP TABLE IF EXISTS `fm_timesheet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fm_timesheet` (
  `task_id` int(11) DEFAULT NULL,
  `task_name` varchar(25) DEFAULT NULL,
  `task_descr` varchar(255) DEFAULT NULL,
  `task_state` varchar(25) DEFAULT NULL,
  `project_name` varchar(25) DEFAULT NULL,
  `task_spent_mon` int(11) DEFAULT NULL,
  `task_spent_tue` int(11) DEFAULT NULL,
  `task_spent_wen` int(11) DEFAULT NULL,
  `task_spent_th` int(11) DEFAULT NULL,
  `task_spent_fr` int(11) DEFAULT NULL,
  `work_week` int(11) DEFAULT NULL,
  `work_year` int(11) DEFAULT NULL,
  `work_user` varchar(25) DEFAULT NULL,
  KEY `fm_timesheet_work_user` (`work_user`,`work_week`,`work_year`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fm_timesheet`
--

LOCK TABLES `fm_timesheet` WRITE;
/*!40000 ALTER TABLE `fm_timesheet` DISABLE KEYS */;
INSERT INTO `fm_timesheet` VALUES (2,'Some','work','In progress','SAMPLE',0,0,0,0,0,47,2022,'fruit'),(2,'Some','work','In progress','SAMPLE',0,0,0,0,0,47,2022,'vegetable');
/*!40000 ALTER TABLE `fm_timesheet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fm_user`
--

DROP TABLE IF EXISTS `fm_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fm_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fm_name` varchar(100) NOT NULL,
  `fm_descr` varchar(255) DEFAULT NULL,
  `fm_password_enc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fm_user`
--

LOCK TABLES `fm_user` WRITE;
/*!40000 ALTER TABLE `fm_user` DISABLE KEYS */;
INSERT INTO `fm_user` VALUES (1,'root','root','63a9f0ea7bb98050796b649e85481845'),(2,'fruit','User of Fruits','e0deff349b2c61f5f796ccaa344a4930'),(3,'vegetable','User of Vegetables','4bd349cde0fbfbb97b9e3cfb557cb2af');
/*!40000 ALTER TABLE `fm_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fm_work_log`
--

DROP TABLE IF EXISTS `fm_work_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fm_work_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fm_task` int(11) NOT NULL,
  `fm_cat` int(11) DEFAULT NULL,
  `fm_date` datetime NOT NULL,
  `fm_date_actual` datetime DEFAULT NULL,
  `fm_spent_hour` double NOT NULL,
  `fm_comment` varchar(255) DEFAULT NULL,
  `fm_user` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fm_work_log_fm_user` (`fm_user`),
  KEY `fm_work_log_fm_task` (`fm_task`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fm_work_log`
--

LOCK TABLES `fm_work_log` WRITE;
/*!40000 ALTER TABLE `fm_work_log` DISABLE KEYS */;
INSERT INTO `fm_work_log` VALUES (1,1,1,'2022-11-26 00:00:00','2022-11-26 00:12:43',0,'In progress','fruit'),(2,2,1,'2022-11-26 00:00:00','2022-11-26 00:12:43',0,'In progress','fruit'),(3,3,1,'2022-11-26 00:00:00','2022-11-26 00:12:43',0,'In progress','vegetable'),(4,2,4,'2022-11-26 00:00:00','2022-11-26 00:12:43',8,'Work','fruit'),(5,2,1,'2022-11-26 00:00:00','2022-11-26 00:12:43',8,'Work','vegetable');
/*!40000 ALTER TABLE `fm_work_log` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `i_update_timesheet` AFTER INSERT ON `fm_work_log` FOR EACH ROW BEGIN
    if new.fm_spent_hour > 0 then
        call prc_timesheet(week(new.fm_date), year(new.fm_date), new.fm_user);
    END If;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `d_update_timesheet` AFTER DELETE ON `fm_work_log` FOR EACH ROW BEGIN
        if old.fm_spent_hour > 0 then
                call prc_timesheet(week(old.fm_date), year(old.fm_date), old.fm_user);
        END if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Temporary table structure for view `v_task_all`
--

DROP TABLE IF EXISTS `v_task_all`;
/*!50001 DROP VIEW IF EXISTS `v_task_all`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_task_all` AS SELECT
 1 AS `id`,
 1 AS `fm_project_id`,
 1 AS `fm_project`,
 1 AS `fm_project_descr`,
 1 AS `fm_manager`,
 1 AS `fm_name`,
 1 AS `fm_code`,
 1 AS `fm_descr`,
 1 AS `fm_state`,
 1 AS `fm_state_name`,
 1 AS `fm_next_state_id`,
 1 AS `fm_priority`,
 1 AS `fm_priority_name`,
 1 AS `fm_priority_descr`,
 1 AS `fm_week_hour`,
 1 AS `fm_all_hour`,
 1 AS `fm_plan_hour`,
 1 AS `fm_last_comment`,
 1 AS `fm_user`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_task_in_progress`
--

DROP TABLE IF EXISTS `v_task_in_progress`;
/*!50001 DROP VIEW IF EXISTS `v_task_in_progress`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_task_in_progress` AS SELECT
 1 AS `id`,
 1 AS `fm_project_id`,
 1 AS `fm_project`,
 1 AS `fm_project_descr`,
 1 AS `fm_manager`,
 1 AS `fm_name`,
 1 AS `fm_code`,
 1 AS `fm_descr`,
 1 AS `fm_state`,
 1 AS `fm_state_name`,
 1 AS `fm_priority`,
 1 AS `fm_priority_name`,
 1 AS `fm_priority_descr`,
 1 AS `fm_week_hour`,
 1 AS `fm_all_hour`,
 1 AS `fm_plan_hour`,
 1 AS `fm_last_comment`,
 1 AS `fm_user`*/;
SET character_set_client = @saved_cs_client;

--
-- Dumping routines for database 'fruit'
--
/*!50003 DROP FUNCTION IF EXISTS `func_full_project_descr` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `func_full_project_descr`(project INT) RETURNS varchar(100) CHARSET utf8 DETERMINISTIC READS SQL DATA
RETURN (select fm_name from fm_project where id = project) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `func_hour_day` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `func_hour_day`(task INT, daynum INT, weeknum INT, weekyear INT, username VARCHAR(25)) RETURNS int(11)
    DETERMINISTIC READS SQL DATA
RETURN coalesce((select sum(fm_spent_hour) from fm_work_log where fm_task = task and dayofweek(fm_date) = daynum and week(fm_date) = weeknum and year(fm_date) = weekyear and fm_user = username), 0) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `prc_timesheet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `prc_timesheet`(IN weeknum INT, IN weekyear INT, IN username VARCHAR(25))
BEGIN
        delete from fm_timesheet where work_week = weeknum and work_year = weekyear and work_user = username;
        insert into fm_timesheet
        select
            t.id,
            t.fm_name,
            t.fm_descr,
            s.fm_descr,
            p.fm_name,
            func_hour_day(t.id, 2, weeknum, weekyear, username),
            func_hour_day(t.id, 3, weeknum, weekyear, username),
            func_hour_day(t.id, 4, weeknum, weekyear, username),
            func_hour_day(t.id, 5, weeknum, weekyear, username),
            func_hour_day(t.id, 6, weeknum, weekyear, username),
            weeknum,
            weekyear,
            username
            from
                fm_task t,
                fm_project p,
                fm_state s
            where
                t.id  in
                        (select distinct fm_task
                                from fm_work_log
                                where fm_spent_hour > 0
                                    and fm_user = username
                                    and week(fm_date) = weeknum
                                    and year(fm_date) = weekyear) and
                t.fm_project  = p.id and
                t.fm_state  = s.id;
   END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `v_task_all`
--

/*!50001 DROP VIEW IF EXISTS `v_task_all`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_task_all` AS select `t`.`id` AS `id`,`p`.`id` AS `fm_project_id`,`p`.`fm_name` AS `fm_project`,`p`.`fm_descr` AS `fm_project_descr`,`p`.`fm_manager` AS `fm_manager`,concat(convert(`p`.`fm_name` using utf8),_utf8'-',cast(`t`.`id` as char charset utf8)) AS `fm_name`,`t`.`fm_name` AS `fm_code`,`t`.`fm_descr` AS `fm_descr`,`s`.`fm_descr` AS `fm_state`,`s`.`fm_name` AS `fm_state_name`,`s`.`fm_next_state` AS `fm_next_state_id`,`t`.`fm_priority` AS `fm_priority`,`pr`.`fm_name` AS `fm_priority_name`,`pr`.`fm_descr` AS `fm_priority_descr`,coalesce((select sum(`l`.`fm_spent_hour`) AS `sum(fm_spent_hour)` from `fm_work_log` `l` where ((`l`.`fm_task` = `t`.`id`) and (week(`l`.`fm_date`,0) = week(curdate(),0)))),0) AS `fm_week_hour`,coalesce((select sum(`l`.`fm_spent_hour`) AS `sum(fm_spent_hour)` from `fm_work_log` `l` where (`l`.`fm_task` = `t`.`id`)),0) AS `fm_all_hour`,`t`.`fm_plan` AS `fm_plan_hour`,(select `fm_work_log`.`fm_comment` AS `fm_comment` from `fm_work_log` where (`fm_work_log`.`id` = (select max(`l`.`id`) AS `max(l.id)` from `fm_work_log` `l` where (`l`.`fm_task` = `t`.`id`)))) AS `fm_last_comment`,`t`.`fm_user` AS `fm_user` from (((`fm_task` `t` join `fm_project` `p` on((`t`.`fm_project` = `p`.`id`))) join `fm_state` `s` on((`t`.`fm_state` = `s`.`id`))) join `fm_priority` `pr` on((`t`.`fm_priority` = `pr`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_task_in_progress`
--

/*!50001 DROP VIEW IF EXISTS `v_task_in_progress`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_task_in_progress` AS select `t`.`id` AS `id`,`t`.`fm_project_id` AS `fm_project_id`,`t`.`fm_project` AS `fm_project`,`t`.`fm_project_descr` AS `fm_project_descr`,`t`.`fm_manager` AS `fm_manager`,`t`.`fm_name` AS `fm_name`,`t`.`fm_code` AS `fm_code`,`t`.`fm_descr` AS `fm_descr`,`t`.`fm_state` AS `fm_state`,`t`.`fm_state_name` AS `fm_state_name`,`t`.`fm_priority` AS `fm_priority`,`t`.`fm_priority_name` AS `fm_priority_name`,`t`.`fm_priority_descr` AS `fm_priority_descr`,`t`.`fm_week_hour` AS `fm_week_hour`,`t`.`fm_all_hour` AS `fm_all_hour`,`t`.`fm_plan_hour` AS `fm_plan_hour`,`t`.`fm_last_comment` AS `fm_last_comment`,`t`.`fm_user` AS `fm_user` from `v_task_all` `t` where (`t`.`fm_state_name` not in (_utf8'done',_utf8'decline')) */;
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

-- Dump completed on 2022-11-26  6:07:54
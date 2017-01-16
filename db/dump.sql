-- MySQL dump 10.11
--
-- Host: localhost    Database: tm
-- ------------------------------------------------------
-- Server version	5.0.51b-community-nt-log

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
-- Current Database: `tm`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `tm` /*!40100 DEFAULT CHARACTER SET cp1251 COLLATE cp1251_general_cs */;

USE `tm`;

--
-- Table structure for table `tm_cat_log`
--

DROP TABLE IF EXISTS `tm_cat_log`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `tm_cat_log` (
  `id` int(11) NOT NULL auto_increment,
  `tm_name` varchar(100) collate cp1251_general_cs NOT NULL,
  `tm_descr` varchar(255) collate cp1251_general_cs NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=cp1251 COLLATE=cp1251_general_cs;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `tm_priority`
--

DROP TABLE IF EXISTS `tm_priority`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `tm_priority` (
  `id` int(11) NOT NULL auto_increment,
  `tm_name` varchar(100) collate cp1251_general_cs NOT NULL,
  `tm_descr` varchar(255) collate cp1251_general_cs NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=cp1251 COLLATE=cp1251_general_cs;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `tm_project`
--

DROP TABLE IF EXISTS `tm_project`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `tm_project` (
  `id` int(11) NOT NULL auto_increment,
  `tm_name` varchar(100) collate cp1251_general_cs NOT NULL,
  `tm_descr` varchar(255) collate cp1251_general_cs NOT NULL,
  `tm_manager` varchar(255) collate cp1251_general_cs NOT NULL,
  `tm_parent` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=cp1251 COLLATE=cp1251_general_cs;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `tm_relation`
--

DROP TABLE IF EXISTS `tm_relation`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `tm_relation` (
  `id` int(11) NOT NULL auto_increment,
  `tm_parent` int(11) NOT NULL,
  `tm_child` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=548 DEFAULT CHARSET=cp1251 COLLATE=cp1251_general_cs;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `tm_state`
--

DROP TABLE IF EXISTS `tm_state`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `tm_state` (
  `id` int(11) NOT NULL auto_increment,
  `tm_name` varchar(100) collate cp1251_general_cs NOT NULL,
  `tm_descr` varchar(255) collate cp1251_general_cs NOT NULL,
  `tm_next_state` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=cp1251 COLLATE=cp1251_general_cs;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `tm_subscribe`
--

DROP TABLE IF EXISTS `tm_subscribe`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `tm_subscribe` (
  `id` int(11) NOT NULL auto_increment,
  `tm_task` int(11) NOT NULL,
  `tm_user` varchar(25) collate cp1251_general_cs NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=cp1251 COLLATE=cp1251_general_cs;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `tm_task`
--

DROP TABLE IF EXISTS `tm_task`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `tm_task` (
  `id` int(11) NOT NULL auto_increment,
  `tm_name` varchar(100) collate cp1251_general_cs NOT NULL,
  `tm_descr` varchar(255) collate cp1251_general_cs default NULL,
  `tm_project` int(11) NOT NULL,
  `tm_state` int(11) NOT NULL,
  `tm_priority` int(11) NOT NULL default '2',
  `tm_plan` int(11) NOT NULL default '0',
  `tm_user` varchar(25) collate cp1251_general_cs NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=643 DEFAULT CHARSET=cp1251 COLLATE=cp1251_general_cs;
SET character_set_client = @saved_cs_client;

/*!50003 SET @SAVE_SQL_MODE=@@SQL_MODE*/;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `i_add_work_log` AFTER INSERT ON `tm_task` FOR EACH ROW BEGIN
	INSERT INTO tm_work_log
    SELECT  null, new.id, 1, curdate(), now(), 0, concat(s.tm_descr), new.tm_user   
    FROM tm_state s WHERE new.tm_state = s.id;
END */;;

/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `u_add_work_log` AFTER UPDATE ON `tm_task` FOR EACH ROW BEGIN
    IF new.tm_state <> old.tm_state THEN
        INSERT INTO tm_work_log 
        SELECT  null, new.id, 1, curdate(), now(), 0, concat(s.tm_descr), new.tm_user
        FROM tm_state s WHERE new.tm_state = s.id;
     END IF;
END */;;

/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `d_remove_work_log` AFTER DELETE ON `tm_task` FOR EACH ROW BEGIN
   DELETE FROM tm_work_log where tm_task = old.id;
END */;;

DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@SAVE_SQL_MODE*/;

--
-- Table structure for table `tm_timesheet`
--

DROP TABLE IF EXISTS `tm_timesheet`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `tm_timesheet` (
  `task_id` int(11) default NULL,
  `task_name` varchar(25) collate cp1251_general_cs default NULL,
  `task_descr` varchar(255) collate cp1251_general_cs default NULL,
  `task_state` varchar(25) collate cp1251_general_cs default NULL,
  `project_name` varchar(25) collate cp1251_general_cs default NULL,
  `task_spent_mon` int(11) default NULL,
  `task_spent_tue` int(11) default NULL,
  `task_spent_wen` int(11) default NULL,
  `task_spent_th` int(11) default NULL,
  `task_spent_fr` int(11) default NULL,
  `work_week` int(11) default NULL,
  `work_year` int(11) default NULL,
  `work_user` varchar(25) collate cp1251_general_cs default NULL,
  KEY `tm_timesheet_work_user` USING BTREE (`work_user`,`work_week`,`work_year`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 COLLATE=cp1251_general_cs;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `tm_work_log`
--

DROP TABLE IF EXISTS `tm_work_log`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `tm_work_log` (
  `id` int(11) NOT NULL auto_increment,
  `tm_task` int(11) NOT NULL,
  `tm_cat` int(11) default NULL,
  `tm_date` datetime NOT NULL,
  `tm_date_actual` datetime default NULL,
  `tm_spent_hour` double NOT NULL,
  `tm_comment` varchar(255) collate cp1251_general_cs default NULL,
  `tm_user` varchar(25) collate cp1251_general_cs default NULL,
  PRIMARY KEY  (`id`),
  KEY `tm_work_log_tm_user` (`tm_user`),
  KEY `tm_work_log_tm_task` (`tm_task`)
) ENGINE=MyISAM AUTO_INCREMENT=3780 DEFAULT CHARSET=cp1251 COLLATE=cp1251_general_cs;
SET character_set_client = @saved_cs_client;

/*!50003 SET @SAVE_SQL_MODE=@@SQL_MODE*/;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `i_update_timesheet` AFTER INSERT ON `tm_work_log` FOR EACH ROW BEGIN
    if new.tm_spent_hour > 0 then
        call prc_timesheet(week(new.tm_date), year(new.tm_date), new.tm_user);
    END If;
END */;;

/*!50003 SET SESSION SQL_MODE="NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `d_update_timesheet` AFTER DELETE ON `tm_work_log` FOR EACH ROW BEGIN
	if old.tm_spent_hour > 0 then
		call prc_timesheet(week(old.tm_date), year(old.tm_date), old.tm_user);
	END if;
END */;;

DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@SAVE_SQL_MODE*/;

--
-- Temporary table structure for view `v_task_all`
--

DROP TABLE IF EXISTS `v_task_all`;
/*!50001 DROP VIEW IF EXISTS `v_task_all`*/;
/*!50001 CREATE TABLE `v_task_all` (
  `id` int(11),
  `tm_project_id` int(11),
  `tm_project` varchar(100),
  `tm_project_descr` varchar(255),
  `tm_manager` varchar(255),
  `tm_name` varchar(104),
  `tm_code` varchar(100),
  `tm_descr` varchar(255),
  `tm_state` varchar(255),
  `tm_state_name` varchar(100),
  `tm_next_state_id` int(11),
  `tm_priority` int(11),
  `tm_priority_name` varchar(100),
  `tm_priority_descr` varchar(255),
  `tm_week_hour` double,
  `tm_all_hour` double,
  `tm_plan_hour` int(11),
  `tm_last_comment` varchar(255),
  `tm_user` varchar(25)
) */;

--
-- Temporary table structure for view `v_task_in_progress`
--

DROP TABLE IF EXISTS `v_task_in_progress`;
/*!50001 DROP VIEW IF EXISTS `v_task_in_progress`*/;
/*!50001 CREATE TABLE `v_task_in_progress` (
  `id` int(11),
  `tm_project_id` int(11),
  `tm_project` varchar(100),
  `tm_project_descr` varchar(255),
  `tm_manager` varchar(255),
  `tm_name` varchar(104),
  `tm_code` varchar(100),
  `tm_descr` varchar(255),
  `tm_state` varchar(255),
  `tm_state_name` varchar(100),
  `tm_priority` int(11),
  `tm_priority_name` varchar(100),
  `tm_priority_descr` varchar(255),
  `tm_week_hour` double,
  `tm_all_hour` double,
  `tm_plan_hour` int(11),
  `tm_last_comment` varchar(255),
  `tm_user` varchar(25)
) */;

--
-- Dumping routines for database 'tm'
--
DELIMITER ;;
/*!50003 DROP FUNCTION IF EXISTS `func_full_project_descr` */;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 FUNCTION `func_full_project_descr`(project INT) RETURNS varchar(100) CHARSET cp1251
RETURN (select tm_name from tm_project where id = project) */;;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE*/;;
/*!50003 DROP FUNCTION IF EXISTS `func_hour_day` */;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_CREATE_USER"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 FUNCTION `func_hour_day`(task INT, daynum INT, weeknum INT, weekyear INT, username VARCHAR(25)) RETURNS int(11)
RETURN coalesce((select sum(tm_spent_hour) from tm_work_log where tm_task = task and dayofweek(tm_date) = daynum and week(tm_date) = weeknum and year(tm_date) = weekyear and tm_user = username), 0) */;;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE*/;;
/*!50003 DROP PROCEDURE IF EXISTS `prc_timesheet` */;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_CREATE_USER"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `prc_timesheet`(IN weeknum INT, IN weekyear INT, IN username VARCHAR(25))
BEGIN
        delete from tm_timesheet where work_week = weeknum and work_year = weekyear and work_user = username;
        insert into tm_timesheet
        select
            t.id,
            t.tm_name,
            t.tm_descr,
            s.tm_descr,
            p.tm_name,
            func_hour_day(t.id, 2, weeknum, weekyear, username),
            func_hour_day(t.id, 3, weeknum, weekyear, username),
            func_hour_day(t.id, 4, weeknum, weekyear, username),
            func_hour_day(t.id, 5, weeknum, weekyear, username),
            func_hour_day(t.id, 6, weeknum, weekyear, username),
            weeknum,
            weekyear,
            username
            from 
                tm_task t, 
                tm_project p,
                tm_state s
            where 
                t.id  in 
                        (select distinct tm_task 
                                from tm_work_log 
                                where tm_spent_hour > 0 
                                    and tm_user = username 
                                    and week(tm_date) = weeknum
                                    and year(tm_date) = weekyear) and
                t.tm_project  = p.id and
                t.tm_state  = s.id;
   END */;;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE*/;;
DELIMITER ;

--
-- Current Database: `tm`
--

USE `tm`;

--
-- Final view structure for view `v_task_all`
--

/*!50001 DROP TABLE `v_task_all`*/;
/*!50001 DROP VIEW IF EXISTS `v_task_all`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_task_all` AS select `t`.`id` AS `id`,`p`.`id` AS `tm_project_id`,`p`.`tm_name` AS `tm_project`,`p`.`tm_descr` AS `tm_project_descr`,`p`.`tm_manager` AS `tm_manager`,concat(convert(`p`.`tm_name` using utf8),_utf8'-',cast(`t`.`id` as char charset utf8)) AS `tm_name`,`t`.`tm_name` AS `tm_code`,`t`.`tm_descr` AS `tm_descr`,`s`.`tm_descr` AS `tm_state`,`s`.`tm_name` AS `tm_state_name`,`s`.`tm_next_state` AS `tm_next_state_id`,`t`.`tm_priority` AS `tm_priority`,`pr`.`tm_name` AS `tm_priority_name`,`pr`.`tm_descr` AS `tm_priority_descr`,coalesce((select sum(`l`.`tm_spent_hour`) AS `sum(tm_spent_hour)` from `tm_work_log` `l` where ((`l`.`tm_task` = `t`.`id`) and (week(`l`.`tm_date`,0) = week(curdate(),0)))),0) AS `tm_week_hour`,coalesce((select sum(`l`.`tm_spent_hour`) AS `sum(tm_spent_hour)` from `tm_work_log` `l` where (`l`.`tm_task` = `t`.`id`)),0) AS `tm_all_hour`,`t`.`tm_plan` AS `tm_plan_hour`,(select `tm_work_log`.`tm_comment` AS `tm_comment` from `tm_work_log` where (`tm_work_log`.`id` = (select max(`l`.`id`) AS `max(l.id)` from `tm_work_log` `l` where (`l`.`tm_task` = `t`.`id`)))) AS `tm_last_comment`,`t`.`tm_user` AS `tm_user` from (((`tm_task` `t` join `tm_project` `p` on((`t`.`tm_project` = `p`.`id`))) join `tm_state` `s` on((`t`.`tm_state` = `s`.`id`))) join `tm_priority` `pr` on((`t`.`tm_priority` = `pr`.`id`))) */;

--
-- Final view structure for view `v_task_in_progress`
--

/*!50001 DROP TABLE `v_task_in_progress`*/;
/*!50001 DROP VIEW IF EXISTS `v_task_in_progress`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_task_in_progress` AS select `t`.`id` AS `id`,`t`.`tm_project_id` AS `tm_project_id`,`t`.`tm_project` AS `tm_project`,`t`.`tm_project_descr` AS `tm_project_descr`,`t`.`tm_manager` AS `tm_manager`,`t`.`tm_name` AS `tm_name`,`t`.`tm_code` AS `tm_code`,`t`.`tm_descr` AS `tm_descr`,`t`.`tm_state` AS `tm_state`,`t`.`tm_state_name` AS `tm_state_name`,`t`.`tm_priority` AS `tm_priority`,`t`.`tm_priority_name` AS `tm_priority_name`,`t`.`tm_priority_descr` AS `tm_priority_descr`,`t`.`tm_week_hour` AS `tm_week_hour`,`t`.`tm_all_hour` AS `tm_all_hour`,`t`.`tm_plan_hour` AS `tm_plan_hour`,`t`.`tm_last_comment` AS `tm_last_comment`,`t`.`tm_user` AS `tm_user` from `v_task_all` `t` where (`t`.`tm_state_name` not in (_cp1251'done',_cp1251'decline')) */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-16  9:53:32
